<?php
/**
 * Manage schools (the `colleges` table that powers the public Colleges page).
 * Supports search, filtering by status (active vs archived), and archiving/restoring via modal.
 */
require_once __DIR__ . '/includes/admin_auth.php';

/* ---------- Archive / Restore (POST) ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);

    if ($action === 'archive' && $id > 0) {
        $stmt = db()->prepare('UPDATE colleges SET is_archived = 1 WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $ok = $stmt->affected_rows > 0;
        $stmt->close();
        flash($ok ? 'success' : 'error', $ok ? 'School archived. It has been hidden from the public Colleges page.' : 'School not found.');
        redirect('schools.php' . query_with([]));
    }

    if ($action === 'restore' && $id > 0) {
        $stmt = db()->prepare('UPDATE colleges SET is_archived = 0 WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $ok = $stmt->affected_rows > 0;
        $stmt->close();
        flash($ok ? 'success' : 'error', $ok ? 'School restored. It is now visible on the public Colleges page.' : 'School not found.');
        redirect('schools.php' . query_with([]));
    }
}

$status = strtolower((string)($_GET['status'] ?? 'active'));
if (!in_array($status, ['active', 'archived', 'all'], true)) {
    $status = 'active';
}

$countsRes = db()->query("SELECT 
    COUNT(*) AS total_all,
    SUM(CASE WHEN is_archived = 0 OR is_archived IS NULL THEN 1 ELSE 0 END) AS total_active,
    SUM(CASE WHEN is_archived = 1 THEN 1 ELSE 0 END) AS total_archived
FROM colleges");
$counts = $countsRes ? $countsRes->fetch_assoc() : [];
$activeCount   = (int)($counts['total_active'] ?? 0);
$archivedCount = (int)($counts['total_archived'] ?? 0);
$allCount      = (int)($counts['total_all'] ?? 0);

$search = trim((string)($_GET['q'] ?? ''));

$where = [];
$params = [];
$types = '';

if ($status === 'active') {
    $where[] = '(c.is_archived = 0 OR c.is_archived IS NULL)';
} elseif ($status === 'archived') {
    $where[] = 'c.is_archived = 1';
}

if ($search !== '') {
    $where[] = '(c.name LIKE ? OR c.short_name LIKE ? OR c.address LIKE ?)';
    $like = '%' . $search . '%';
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types .= 'sss';
}

$sql = "SELECT c.id, c.name, c.short_name, c.type, c.address, c.image_url, c.is_archived,
               (SELECT COUNT(*) FROM college_degrees cd WHERE cd.college_id = c.id) AS programs
        FROM colleges c";
if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY c.name ASC';

$stmt = db()->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$schools = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$pageTitle = 'Schools';
$activeNav = 'schools';
require __DIR__ . '/includes/header.php';
?>

<div class="filter-tabs">
    <a class="filter-tab <?= $status === 'active' ? 'active' : '' ?>" href="schools.php<?= e(query_with(['status' => 'active'])) ?>">
        Active <span class="count"><?= $activeCount ?></span>
    </a>
    <a class="filter-tab <?= $status === 'archived' ? 'active' : '' ?>" href="schools.php<?= e(query_with(['status' => 'archived'])) ?>">
        Archived <span class="count"><?= $archivedCount ?></span>
    </a>
    <a class="filter-tab <?= $status === 'all' ? 'active' : '' ?>" href="schools.php<?= e(query_with(['status' => 'all'])) ?>">
        All <span class="count"><?= $allCount ?></span>
    </a>
</div>

<div class="toolbar">
    <form method="get" action="schools.php">
        <?php if ($status !== 'active'): ?>
            <input type="hidden" name="status" value="<?= e($status) ?>">
        <?php endif; ?>
        <input type="search" name="q" value="<?= e($search) ?>" placeholder="Search name, short name or address">
        <button class="btn btn-light" type="submit">Search</button>
        <?php if ($search !== ''): ?><a class="btn btn-light" href="schools.php<?= e(query_with(['q' => null])) ?>">Clear</a><?php endif; ?>
    </form>
    <a class="btn btn-primary" href="school_edit.php">+ Add school</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Logo</th>
                <th>School</th>
                <th>Type</th>
                <th>Location</th>
                <th>Programs</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$schools): ?>
            <tr><td colspan="7" class="empty">No schools found in this view.</td></tr>
        <?php endif; ?>
        <?php foreach ($schools as $s): ?>
            <tr>
                <td><?php if ($s['image_url']): ?><img class="logo-preview" style="width:64px;height:44px" src="<?= e($s['image_url']) ?>" alt=""><?php endif; ?></td>
                <td><strong><?= e($s['name']) ?></strong><div class="muted"><?= e($s['short_name']) ?></div></td>
                <td><?= e($s['type']) ?></td>
                <td class="muted"><?= e($s['address']) ?></td>
                <td><span class="badge badge-green"><?= (int)$s['programs'] ?></span></td>
                <td>
                    <?php if (!empty($s['is_archived'])): ?>
                        <span class="badge badge-amber">Archived</span>
                    <?php else: ?>
                        <span class="badge badge-green">Active</span>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a class="btn btn-light btn-sm" href="school_edit.php?id=<?= (int)$s['id'] ?>">Edit</a>
                    <?php if (!empty($s['is_archived'])): ?>
                        <form method="post" action="schools.php<?= e(query_with([])) ?>" class="js-confirm-form"
                              data-modal-title="Restore School"
                              data-modal-message="Restore &lt;strong&gt;<?= e($s['name']) ?>&lt;/strong&gt;? It will appear back on the public Colleges page and degree listings."
                              data-modal-btn="Restore School"
                              data-modal-btn-class="btn-primary"
                              data-modal-icon="restore">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="restore">
                            <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
                            <button class="btn btn-outline-green btn-sm" type="submit">Restore</button>
                        </form>
                    <?php else: ?>
                        <form method="post" action="schools.php<?= e(query_with([])) ?>" class="js-confirm-form"
                              data-modal-title="Archive School"
                              data-modal-message="Are you sure you want to archive &lt;strong&gt;<?= e($s['name']) ?>&lt;/strong&gt;? It will disappear from the public Colleges page, but you can restore it anytime from the Archived tab."
                              data-modal-btn="Archive School"
                              data-modal-btn-class="btn-amber"
                              data-modal-icon="archive">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="archive">
                            <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
                            <button class="btn btn-outline-amber btn-sm" type="submit">Archive</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
