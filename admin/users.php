<?php
/**
 * Manage accounts: list with search + pagination, and delete.
 * Add / edit / reset password / change role live in user_edit.php.
 */
require_once __DIR__ . '/includes/admin_auth.php';

/* ---------- Delete (POST) ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);

    if ($id === (int)$ADMIN['id']) {
        flash('error', 'You cannot delete your own account.');
    } elseif ($id > 0) {
        // Never leave the system without an admin.
        $stmt = db()->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $target = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $adminCount = (int)db()->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetch_row()[0];
        if (!$target) {
            flash('error', 'Account not found.');
        } elseif ($target['role'] === 'admin' && $adminCount <= 1) {
            flash('error', 'You cannot delete the last admin account.');
        } else {
            // Saved items, quiz attempts and results cascade via foreign keys;
            // user_assessments (in-progress tests) has no FK, so clear it explicitly.
            db()->begin_transaction();
            $stmt = db()->prepare('DELETE FROM user_assessments WHERE user_id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt = db()->prepare('DELETE FROM users WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            db()->commit();
            flash('success', 'Account deleted.');
        }
    }
    redirect('users.php' . query_with([]));
}

/* ---------- Filters ---------- */
$search  = trim((string)($_GET['q'] ?? ''));
$role    = in_array($_GET['role'] ?? '', ['user', 'admin'], true) ? $_GET['role'] : '';
$perPage = 15;
$page    = max(1, (int)($_GET['page'] ?? 1));

$where  = [];
$types  = '';
$params = [];
if ($search !== '') {
    $where[] = '(full_name LIKE ? OR email LIKE ? OR username LIKE ?)';
    $like = '%' . $search . '%';
    array_push($params, $like, $like, $like);
    $types .= 'sss';
}
if ($role !== '') {
    $where[] = 'role = ?';
    $params[] = $role;
    $types .= 's';
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$stmt = db()->prepare("SELECT COUNT(*) FROM users $whereSql");
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = (int)$stmt->get_result()->fetch_row()[0];
$stmt->close();

$totalPages = max(1, (int)ceil($total / $perPage));
$page   = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$stmt = db()->prepare("SELECT u.id, u.full_name, u.username, u.email, u.user_type, u.role, u.is_verified, u.created_at,
                              (SELECT COUNT(*) FROM assessment_results ar WHERE ar.user_id = u.id) AS assessments
                       FROM users u $whereSql
                       ORDER BY u.created_at DESC, u.id DESC LIMIT ? OFFSET ?");
$stmt->bind_param($types . 'ii', ...array_merge($params, [$perPage, $offset]));
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$pageTitle = 'Accounts';
$activeNav = 'users';
require __DIR__ . '/includes/header.php';
?>

<div class="toolbar">
    <form method="get" action="users.php">
        <input type="search" name="q" value="<?= e($search) ?>" placeholder="Search name, email or username">
        <select name="role">
            <option value="">All roles</option>
            <option value="user"  <?= $role === 'user'  ? 'selected' : '' ?>>Users</option>
            <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admins</option>
        </select>
        <button class="btn btn-light" type="submit">Filter</button>
        <?php if ($search !== '' || $role !== ''): ?><a class="btn btn-light" href="users.php">Clear</a><?php endif; ?>
    </form>
    <a class="btn btn-primary" href="user_edit.php">+ Add account</a>
</div>

<p class="muted"><?= number_format($total) ?> account(s) found</p>

<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Name</th><th>Email / Username</th><th>Type</th><th>Role</th><th>Status</th><th>Tests</th><th>Joined</th><th></th></tr>
        </thead>
        <tbody>
        <?php if (!$users): ?>
            <tr><td colspan="8" class="empty">No accounts match your search.</td></tr>
        <?php endif; ?>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><strong><?= e($u['full_name']) ?></strong><?php if ((int)$u['id'] === (int)$ADMIN['id']): ?> <span class="muted">(you)</span><?php endif; ?></td>
                <td><?= e($u['email']) ?><?php if ($u['username']): ?><div class="muted">@<?= e($u['username']) ?></div><?php endif; ?></td>
                <td><?= e(strtoupper($u['user_type'] ?? '')) ?></td>
                <td><span class="badge <?= $u['role'] === 'admin' ? 'badge-dark' : '' ?>"><?= e(ucfirst($u['role'])) ?></span></td>
                <td><?= $u['is_verified'] ? '<span class="badge badge-green">Verified</span>' : '<span class="badge badge-amber">Unverified</span>' ?></td>
                <td><?= (int)$u['assessments'] ?></td>
                <td class="muted"><?= e(date('M j, Y', strtotime($u['created_at']))) ?></td>
                <td class="actions">
                    <a class="btn btn-light btn-sm" href="user_edit.php?id=<?= (int)$u['id'] ?>">Edit</a>
                    <?php if ((int)$u['id'] !== (int)$ADMIN['id']): ?>
                        <form method="post" action="users.php<?= e(query_with([])) ?>" data-confirm="Delete <?= e($u['full_name']) ?>'s account and all of their results? This cannot be undone.">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= render_pagination($page, $totalPages) ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
