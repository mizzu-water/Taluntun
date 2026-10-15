<?php
/**
 * Add / edit a Degree Quiz question (`course_questions` table).
 * Links question directly to a degree program, stage, options A-D, and correct answer key.
 */
require_once __DIR__ . '/includes/admin_auth.php';

$id     = (int)($_GET['id'] ?? 0);
$isNew  = $id === 0;
$errors = [];

$q = [
    'degree_id'       => (int)($_GET['degree_id'] ?? 0),
    'stage'           => 1,
    'question_number' => 1,
    'question_text'   => '',
    'option_a'        => '',
    'option_b'        => '',
    'option_c'        => '',
    'option_d'        => '',
    'correct_answer'  => 'A',
];

$degrees = db()->query('SELECT id, title, category FROM degrees ORDER BY category, title')->fetch_all(MYSQLI_ASSOC);

if (!$isNew) {
    $stmt = db()->prepare('SELECT id, degree_id, stage, question_number, question_text, option_a, option_b, option_c, option_d, correct_answer FROM course_questions WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $found = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$found) {
        flash('error', 'Quiz question not found.');
        redirect('course_questions.php');
    }
    $q = $found;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $q['degree_id']       = (int)($_POST['degree_id'] ?? 0);
    $q['stage']           = (int)($_POST['stage'] ?? 1);
    $q['question_number'] = (int)($_POST['question_number'] ?? 1);
    $q['question_text']   = post_str('question_text', 2000);
    $q['option_a']        = post_str('option_a', 1000);
    $q['option_b']        = post_str('option_b', 1000);
    $q['option_c']        = post_str('option_c', 1000);
    $q['option_d']        = post_str('option_d', 1000);
    $q['correct_answer']  = strtoupper(post_str('correct_answer', 1));

    if ($q['degree_id'] <= 0) {
        $errors[] = 'Please select a degree program.';
    }
    if (!in_array($q['stage'], [1, 2, 3], true)) {
        $errors[] = 'Stage must be 1, 2, or 3.';
    }
    if ($q['question_number'] <= 0) {
        $errors[] = 'Question number must be greater than 0.';
    }
    if (mb_strlen($q['question_text']) < 5) {
        $errors[] = 'Question text is required.';
    }
    if ($q['option_a'] === '' || $q['option_b'] === '' || $q['option_c'] === '' || $q['option_d'] === '') {
        $errors[] = 'All four answer options (A, B, C, D) are required.';
    }
    if (!in_array($q['correct_answer'], ['A', 'B', 'C', 'D'], true)) {
        $errors[] = 'Correct answer must be A, B, C, or D.';
    }

    // Check unique key on (degree_id, stage, question_number)
    if (!$errors) {
        $stmt = db()->prepare('SELECT id FROM course_questions WHERE degree_id = ? AND stage = ? AND question_number = ? AND id <> ?');
        $stmt->bind_param('iiii', $q['degree_id'], $q['stage'], $q['question_number'], $id);
        $stmt->execute();
        if ($stmt->get_result()->fetch_row()) {
            $errors[] = "A question for this degree program under Stage {$q['stage']} with Question #{$q['question_number']} already exists.";
        }
        $stmt->close();
    }

    if (!$errors) {
        if ($isNew) {
            $stmt = db()->prepare('INSERT INTO course_questions (degree_id, stage, question_number, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('iiissssss', $q['degree_id'], $q['stage'], $q['question_number'], $q['question_text'], $q['option_a'], $q['option_b'], $q['option_c'], $q['option_d'], $q['correct_answer']);
        } else {
            $stmt = db()->prepare('UPDATE course_questions SET degree_id = ?, stage = ?, question_number = ?, question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_answer = ? WHERE id = ?');
            $stmt->bind_param('iiissssssi', $q['degree_id'], $q['stage'], $q['question_number'], $q['question_text'], $q['option_a'], $q['option_b'], $q['option_c'], $q['option_d'], $q['correct_answer'], $id);
        }
        $stmt->execute();
        $savedId = $isNew ? db()->insert_id : $id;
        flash('success', $isNew ? 'Degree quiz question added.' : 'Degree quiz question updated.');

        if ($isNew && isset($_POST['add_another'])) {
            redirect('course_question_edit.php?degree_id=' . $q['degree_id'] . '&stage=' . $q['stage']);
        }
        redirect('course_questions.php?degree_id=' . $q['degree_id']);
    }
}

$pageTitle = $isNew ? 'Add Degree Quiz Question' : 'Edit Degree Quiz Question';
$activeNav = 'quiz';
require __DIR__ . '/includes/header.php';
?>

<p><a href="course_questions.php<?= $q['degree_id'] ? '?degree_id=' . $q['degree_id'] : '' ?>">&larr; Back to quiz questions</a></p>
<?php foreach ($errors as $err): ?><div class="alert alert-error"><?= e($err) ?></div><?php endforeach; ?>

<form class="card" method="post" action="course_question_edit.php<?= $isNew ? '' : '?id=' . $id ?>">
    <?= csrf_field() ?>
    <h2>Question Information</h2>
    <div class="form-grid">
        <div class="full">
            <label for="degree_id">Degree Program</label>
            <select id="degree_id" name="degree_id" required>
                <option value="">-- Select Degree Program --</option>
                <?php foreach ($degrees as $d): ?>
                    <option value="<?= (int)$d['id'] ?>" <?= (int)$q['degree_id'] === (int)$d['id'] ? 'selected' : '' ?>>
                        <?= e($d['title']) ?> (<?= e($d['category']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="stage">Curriculum Stage</label>
            <select id="stage" name="stage">
                <?php foreach (QUIZ_STAGES as $sNum => $sName): ?>
                    <option value="<?= $sNum ?>" <?= (int)$q['stage'] === $sNum ? 'selected' : '' ?>><?= e($sName) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="question_number">Question Number (Within Stage)</label>
            <input id="question_number" name="question_number" type="number" min="1" max="100" value="<?= (int)$q['question_number'] ?>" required>
            <div class="help">Unique index per degree and stage.</div>
        </div>
        <div class="full">
            <label for="question_text">Question Prompt</label>
            <textarea id="question_text" name="question_text" rows="3" required maxlength="2000" placeholder="e.g. In Computer Science, what is dynamic programming?"><?= e($q['question_text']) ?></textarea>
        </div>
    </div>

    <h2 style="margin-top:24px;">Options & Answer Key</h2>
    <p class="help">Fill in all 4 choices and select which one is the correct answer.</p>
    <div style="margin-top:16px;">
        <div class="option-row">
            <label class="radio">
                <input type="radio" name="correct_answer" value="A" <?= $q['correct_answer'] === 'A' ? 'checked' : '' ?>> A:
            </label>
            <input type="text" name="option_a" value="<?= e($q['option_a']) ?>" required placeholder="Choice A text">
        </div>
        <div class="option-row">
            <label class="radio">
                <input type="radio" name="correct_answer" value="B" <?= $q['correct_answer'] === 'B' ? 'checked' : '' ?>> B:
            </label>
            <input type="text" name="option_b" value="<?= e($q['option_b']) ?>" required placeholder="Choice B text">
        </div>
        <div class="option-row">
            <label class="radio">
                <input type="radio" name="correct_answer" value="C" <?= $q['correct_answer'] === 'C' ? 'checked' : '' ?>> C:
            </label>
            <input type="text" name="option_c" value="<?= e($q['option_c']) ?>" required placeholder="Choice C text">
        </div>
        <div class="option-row">
            <label class="radio">
                <input type="radio" name="correct_answer" value="D" <?= $q['correct_answer'] === 'D' ? 'checked' : '' ?>> D:
            </label>
            <input type="text" name="option_d" value="<?= e($q['option_d']) ?>" required placeholder="Choice D text">
        </div>
    </div>

    <div class="form-actions">
        <button class="btn btn-primary" type="submit"><?= $isNew ? 'Add Question' : 'Save Changes' ?></button>
        <?php if ($isNew): ?>
            <button class="btn btn-light" type="submit" name="add_another" value="1">Add &amp; Add Another</button>
        <?php endif; ?>
        <a class="btn btn-light" href="course_questions.php<?= $q['degree_id'] ? '?degree_id=' . $q['degree_id'] : '' ?>">Cancel</a>
    </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
