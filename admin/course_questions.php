<?php
/**
 * Manage Degree Quiz questions (`course_questions` table).
 * Filtered by degree strand/program, stage, or search query.
 */
require_once __DIR__ . '/includes/admin_auth.php';

/* ---------- Delete (POST) ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    $stmt = db()->prepare('DELETE FROM course_questions WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    flash($stmt->affected_rows ? 'success' : 'error', $stmt->affected_rows ? 'Question deleted.' : 'Question not found.');
    redirect('course_questions.php' . query_with([]));
}

/* ---------- Filters ---------- */
$degreeId = (int)($_GET['degree_id'] ?? 0);
$stage    = (int)($_GET['stage'] ?? 0);
$search   = trim((string)($_GET['q'] ?? ''));
$perPage  = 20;
$page     = max(1, (int)($_GET['page'] ?? 1));

// Load all degrees for the filter dropdown
$degrees = db()->query('SELECT id, title, category FROM degrees ORDER BY category, title')->fetch_all(MYSQLI_ASSOC);

$where = []; $types = ''; $params = [];
if ($degreeId > 0) {
    $where[] = 'cq.degree_id = ?';
    $params[] = $degreeId;
    $types .= 'i';
}
if ($stage > 0) {
    $where[] = 'cq.stage = ?';
    $params[] = $stage;
    $types .= 'i';
}
if ($search !== '') {
    $where[] = '(cq.question_text LIKE ? OR cq.option_a LIKE ? OR cq.option_b LIKE ? OR cq.option_c LIKE ? OR cq.option_d LIKE ?)';
    $like = '%' . $search . '%';
    array_push($params, $like, $like, $like, $like, $like);
    $types .= 'sssss';
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$stmt = db()->prepare("SELECT COUNT(*) FROM course_questions cq $whereSql");
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = (int)$stmt->get_result()->fetch_row()[0];
$stmt->close();

$totalPages = max(1, (int)ceil($total / $perPage));
$page   = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$stmt = db()->prepare("SELECT cq.id, cq.degree_id, cq.stage, cq.question_number, cq.question_text,
                              cq.option_a, cq.option_b, cq.option_c, cq.option_d, cq.correct_answer,
                              d.title as degree_title, d.category as degree_category
                       FROM course_questions cq
                       JOIN degrees d ON d.id = cq.degree_id
                       $whereSql
                       ORDER BY d.title ASC, cq.stage ASC, cq.question_number ASC, cq.id ASC
                       LIMIT ? OFFSET ?");
$stmt->bind_param($types . 'ii', ...array_merge($params, [$perPage, $offset]));
$stmt->execute();
$questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$pageTitle = 'Degree Quiz Questions';
$activeNav = 'quiz';
require __DIR__ . '/includes/header.php';
?>

<div class="toolbar">
    <form method="get" action="course_questions.php">
        <select name="degree_id">
            <option value="">All Degree Programs</option>
            <?php foreach ($degrees as $d): ?>
                <option value="<?= (int)$d['id'] ?>" <?= $degreeId === (int)$d['id'] ? 'selected' : '' ?>>
                    <?= e($d['title']) ?> (<?= e($d['category']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <select name="stage">
            <option value="">All Stages</option>
            <?php foreach (QUIZ_STAGES as $sNum => $sName): ?>
                <option value="<?= $sNum ?>" <?= $stage === $sNum ? 'selected' : '' ?>><?= e($sName) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="search" name="q" value="<?= e($search) ?>" placeholder="Search question or options">
        <button class="btn btn-light" type="submit">Filter</button>
        <?php if ($degreeId > 0 || $stage > 0 || $search !== ''): ?>
            <a class="btn btn-light" href="course_questions.php">Clear</a>
        <?php endif; ?>
    </form>
    <a class="btn btn-primary" href="course_question_edit.php<?= $degreeId ? '?degree_id=' . $degreeId : '' ?>">+ Add Quiz Question</a>
</div>

<p class="muted"><?= number_format($total) ?> question(s) found</p>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Degree Program</th>
                <th>Stage</th>
                <th>#</th>
                <th>Question & Options</th>
                <th>Key</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$questions): ?>
            <tr><td colspan="6" class="empty">No quiz questions match your search or filter.</td></tr>
        <?php endif; ?>
        <?php foreach ($questions as $q): ?>
            <tr>
                <td>
                    <strong><?= e($q['degree_title']) ?></strong>
                    <div class="muted"><?= e($q['degree_category']) ?></div>
                </td>
                <td>
                    <span class="badge badge-amber">Stage <?= (int)$q['stage'] ?></span>
                </td>
                <td class="muted"><?= (int)$q['question_number'] ?></td>
                <td class="clamp">
                    <p style="margin:0 0 6px; font-weight:600;"><?= e($q['question_text']) ?></p>
                    <div class="muted text-xs" style="line-height:1.5;">
                        <span style="<?= $q['correct_answer'] === 'A' ? 'color:#065f46; font-weight:bold;' : '' ?>">A: <?= e($q['option_a']) ?></span><br>
                        <span style="<?= $q['correct_answer'] === 'B' ? 'color:#065f46; font-weight:bold;' : '' ?>">B: <?= e($q['option_b']) ?></span><br>
                        <span style="<?= $q['correct_answer'] === 'C' ? 'color:#065f46; font-weight:bold;' : '' ?>">C: <?= e($q['option_c']) ?></span><br>
                        <span style="<?= $q['correct_answer'] === 'D' ? 'color:#065f46; font-weight:bold;' : '' ?>">D: <?= e($q['option_d']) ?></span>
                    </div>
                </td>
                <td>
                    <span class="badge badge-green" style="font-size:12px; font-weight:800;"><?= e($q['correct_answer']) ?></span>
                </td>
                <td class="actions">
                    <a class="btn btn-light btn-sm" href="course_question_edit.php?id=<?= (int)$q['id'] ?>">Edit</a>
                    <form method="post" action="course_questions.php<?= e(query_with([])) ?>" data-confirm="Delete this course quiz question?">
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

<?= render_pagination($page, $totalPages) ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
