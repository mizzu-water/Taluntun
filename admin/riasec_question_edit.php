<?php
/**
 * Add / edit a RIASEC assessment question.
 * Each question belongs to one Holland trait and one test set, and can be reverse-coded.
 */
require_once __DIR__ . '/includes/admin_auth.php';

$id     = (int)($_GET['id'] ?? 0);
$isNew  = $id === 0;
$errors = [];
$q = [
    'trait' => array_key_exists($_GET['trait'] ?? '', RIASEC_TRAITS) ? $_GET['trait'] : 'R',
    'question_text' => '', 'test_set' => 'standard', 'is_reverse_coded' => 0,
];

if (!$isNew) {
    $stmt = db()->prepare('SELECT id, trait, question_text, test_set, is_reverse_coded FROM questions WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $found = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$found) {
        flash('error', 'Question not found.');
        redirect('riasec_questions.php');
    }
    $q = $found;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $q['trait']            = $_POST['trait'] ?? '';
    $q['question_text']    = post_str('question_text', 1000);
    $q['test_set']         = $_POST['test_set'] ?? '';
    $q['is_reverse_coded'] = isset($_POST['is_reverse_coded']) ? 1 : 0;

    if (!array_key_exists($q['trait'], RIASEC_TRAITS)) $errors[] = 'Choose a Holland code (R, I, A, S, E or C).';
    if (!in_array($q['test_set'], ['standard', 'extended'], true)) $errors[] = 'Choose a test set.';
    if (mb_strlen($q['question_text']) < 5) $errors[] = 'Question text is required.';

    if (!$errors) {
        if ($isNew) {
            $stmt = db()->prepare('INSERT INTO questions (trait, question_text, test_set, is_reverse_coded) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('sssi', $q['trait'], $q['question_text'], $q['test_set'], $q['is_reverse_coded']);
        } else {
            $stmt = db()->prepare('UPDATE questions SET trait = ?, question_text = ?, test_set = ?, is_reverse_coded = ? WHERE id = ?');
            $stmt->bind_param('sssii', $q['trait'], $q['question_text'], $q['test_set'], $q['is_reverse_coded'], $id);
        }
        $stmt->execute();
        flash('success', $isNew ? 'Question added to the assessment.' : 'Question updated.');
        if ($isNew && isset($_POST['add_another'])) redirect('riasec_question_edit.php?trait=' . urlencode($q['trait']));
        redirect('riasec_questions.php?trait=' . urlencode($q['trait']));
    }
}

$pageTitle = $isNew ? 'Add RIASEC question' : 'Edit RIASEC question';
$activeNav = 'riasec';
require __DIR__ . '/includes/header.php';
?>

<p><a href="riasec_questions.php">&larr; Back to questions</a></p>
<?php foreach ($errors as $err): ?><div class="alert alert-error"><?= e($err) ?></div><?php endforeach; ?>

<form class="card" method="post" action="riasec_question_edit.php<?= $isNew ? '' : '?id=' . $id ?>">
    <?= csrf_field() ?>
    <div class="form-grid">
        <div>
            <label for="trait">Holland code</label>
            <select id="trait" name="trait">
                <?php foreach (RIASEC_TRAITS as $code => $name): ?>
                    <option value="<?= e($code) ?>" <?= $q['trait'] === $code ? 'selected' : '' ?>><?= e("$code - $name") ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="test_set">Test set</label>
            <select id="test_set" name="test_set">
                <option value="standard" <?= $q['test_set'] === 'standard' ? 'selected' : '' ?>>Standard (60-question test)</option>
                <option value="extended" <?= $q['test_set'] === 'extended' ? 'selected' : '' ?>>Extended (added for 120-question test)</option>
            </select>
        </div>
        <div class="full">
            <label for="question_text">Statement</label>
            <textarea id="question_text" name="question_text" rows="3" required maxlength="1000" placeholder="I enjoy..."><?= e($q['question_text']) ?></textarea>
            <div class="help">Write it as a first-person statement; users rate it from 1 (Strongly disagree) to 5 (Strongly agree).</div>
        </div>
        <div class="full">
            <label class="checkbox"><input type="checkbox" name="is_reverse_coded" value="1" <?= $q['is_reverse_coded'] ? 'checked' : '' ?>> Reverse-coded</label>
            <div class="help">Tick this when agreeing means <em>less</em> of the trait (e.g. "I dislike working with tools" for R). The answer is scored as 6 &minus; rating.</div>
        </div>
    </div>
    <div class="form-actions">
        <button class="btn btn-primary" type="submit"><?= $isNew ? 'Add question' : 'Save changes' ?></button>
        <?php if ($isNew): ?><button class="btn btn-light" type="submit" name="add_another" value="1">Add &amp; add another</button><?php endif; ?>
        <a class="btn btn-light" href="riasec_questions.php">Cancel</a>
    </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
