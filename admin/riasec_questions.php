<?php
/**
 * Manage RIASEC assessment questions (`questions` table).
 * Read live by /api/get_questions for the public Assessment page.
 */
require_once __DIR__ . '/includes/admin_auth.php';

/* ---------- Delete (POST) ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    $stmt = db()->prepare('DELETE FROM questions WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    flash($stmt->affected_rows ? 'success' : 'error', $stmt->affected_rows ? 'Question deleted.' : 'Question not found.');
    redirect('riasec_questions.php' . query_with([]));
}

/* ---------- Filters ---------- */
$trait   = array_key_exists($_GET['trait'] ?? '', RIASEC_TRAITS) ? $_GET['trait'] : '';
$set     = in_array($_GET['set'] ?? '', ['standard', 'extended'], true) ? $_GET['set'] : '';
$search  = trim((string)($_GET['q'] ?? ''));

$where = []; $types = ''; $params = [];
if ($trait !== '')  { $where[] = 'trait = ?';           $params[] = $trait;            $types .= 's'; }
if ($set !== '')    { $where[] = 'test_set = ?';        $params[] = $set;              $types .= 's'; }
if ($search !== '') { $where[] = 'question_text LIKE ?'; $params[] = '%' . $search . '%'; $types .= 's'; }
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$stmt = db()->prepare("SELECT id, trait, question_text, test_set, is_reverse_coded FROM questions $whereSql
                       ORDER BY FIELD(test_set, 'standard', 'extended'), id");
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Balance check: scores are summed per trait, so uneven counts skew results.
$balance = ['standard' => array_fill_keys(array_keys(RIASEC_TRAITS), 0), 'extended' => array_fill_keys(array_keys(RIASEC_TRAITS), 0)];
foreach (db()->query('SELECT test_set, trait, COUNT(*) n FROM questions GROUP BY test_set, trait') as $row) {
    if (isset($balance[$row['test_set']][$row['trait']])) $balance[$row['test_set']][$row['trait']] = (int)$row['n'];
}
$unbalanced = [];
foreach ($balance as $setName => $counts) {
    if (count(array_unique($counts)) > 1) $unbalanced[] = $setName;
}

$pageTitle = 'RIASEC Assessment Questions';
$activeNav = 'riasec';
require __DIR__ . '/includes/header.php';
?>

<div class="card">
    <h2>Question balance</h2>
    <table>
        <thead><tr><th>Set</th><?php foreach (RIASEC_TRAITS as $code => $name): ?><th><?= e($code) ?> &middot; <?= e($name) ?></th><?php endforeach; ?><th>Total</th></tr></thead>
        <tbody>
        <?php foreach ($balance as $setName => $counts): ?>
            <tr>
                <td><strong><?= e(ucfirst($setName)) ?></strong></td>
                <?php foreach ($counts as $n): ?><td><?= $n ?></td><?php endforeach; ?>
                <td><strong><?= array_sum($counts) ?></strong></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p class="help">The 60-question test uses the <em>standard</em> set; the 120-question test uses <em>standard + extended</em>.
        Answers use a fixed 1&ndash;5 scale (Strongly disagree &rarr; Strongly agree). Reverse-coded questions score as 6 &minus; answer.</p>
    <?php if ($unbalanced): ?>
        <div class="alert alert-info" style="margin:12px 0 0">Heads up: the <?= e(implode(' and ', $unbalanced)) ?> set has an uneven number of questions per trait. Because trait scores are summed, traits with more questions will be favoured.</div>
    <?php endif; ?>
</div>

<div class="toolbar">
    <form method="get" action="riasec_questions.php">
        <select name="trait">
            <option value="">All traits</option>
            <?php foreach (RIASEC_TRAITS as $code => $name): ?>
                <option value="<?= e($code) ?>" <?= $trait === $code ? 'selected' : '' ?>><?= e("$code - $name") ?></option>
            <?php endforeach; ?>
        </select>
        <select name="set">
            <option value="">Both sets</option>
            <option value="standard" <?= $set === 'standard' ? 'selected' : '' ?>>Standard</option>
            <option value="extended" <?= $set === 'extended' ? 'selected' : '' ?>>Extended</option>
        </select>
        <input type="search" name="q" value="<?= e($search) ?>" placeholder="Search text">
        <button class="btn btn-light" type="submit">Filter</button>
        <?php if ($trait || $set || $search !== ''): ?><a class="btn btn-light" href="riasec_questions.php">Clear</a><?php endif; ?>
    </form>
    <a class="btn btn-primary" href="riasec_question_edit.php<?= $trait ? '?trait=' . e($trait) : '' ?>">+ Add question</a>
</div>

<p class="muted"><?= count($questions) ?> question(s)</p>

<div class="table-wrap">
    <table>
        <thead><tr><th>#</th><th>Trait</th><th>Question</th><th>Set</th><th>Scoring</th><th></th></tr></thead>
        <tbody>
        <?php if (!$questions): ?><tr><td colspan="6" class="empty">No questions match.</td></tr><?php endif; ?>
        <?php foreach ($questions as $q): ?>
            <tr>
                <td class="muted"><?= (int)$q['id'] ?></td>
                <td><span class="badge badge-dark" title="<?= e(RIASEC_TRAITS[$q['trait']] ?? '') ?>"><?= e($q['trait']) ?></span></td>
                <td class="clamp"><?= e($q['question_text']) ?></td>
                <td><?= e(ucfirst($q['test_set'])) ?></td>
                <td><?= $q['is_reverse_coded'] ? '<span class="badge badge-amber">Reverse</span>' : '<span class="badge badge-green">Normal</span>' ?></td>
                <td class="actions">
                    <a class="btn btn-light btn-sm" href="riasec_question_edit.php?id=<?= (int)$q['id'] ?>">Edit</a>
                    <form method="post" action="riasec_questions.php<?= e(query_with([])) ?>" data-confirm="Delete this question from the assessment?">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= (int)$q['id'] ?>">
                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
