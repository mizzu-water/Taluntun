<?php
/**
 * Admin dashboard: headline counts + recent activity.
 */
require_once __DIR__ . '/includes/admin_auth.php';

/** Run a COUNT(*) style query that returns a single number. */
function count_of(string $sql): int {
    $res = db()->query($sql);
    return $res ? (int)$res->fetch_row()[0] : 0;
}

$stats = [
    ['Total users',          count_of("SELECT COUNT(*) FROM users WHERE role = 'user'"),  'users.php',            count_of("SELECT COUNT(*) FROM users WHERE role = 'admin'") . ' admin account(s)'],
    ['Schools',              count_of('SELECT COUNT(*) FROM colleges WHERE is_archived = 0 OR is_archived IS NULL'), 'schools.php', count_of('SELECT COUNT(*) FROM colleges WHERE is_archived = 1') . ' archived / ' . count_of('SELECT COUNT(*) FROM college_degrees') . ' links'],
    ['RIASEC questions',     count_of('SELECT COUNT(*) FROM questions'),                  'riasec_questions.php', count_of("SELECT COUNT(*) FROM questions WHERE test_set = 'standard'") . ' standard / ' . count_of("SELECT COUNT(*) FROM questions WHERE test_set = 'extended'") . ' extended'],
    ['Degree quiz questions',count_of('SELECT COUNT(*) FROM course_questions'),           'course_questions.php', count_of('SELECT COUNT(DISTINCT degree_id) FROM course_questions') . ' degrees covered'],
    ['Assessments taken',    count_of('SELECT COUNT(*) FROM assessment_results'),         null,                   count_of('SELECT COUNT(DISTINCT user_id) FROM assessment_results') . ' unique users'],
];

$recentAssessments = db()->query(
    "SELECT ar.holland_code, ar.taken_at, u.full_name, u.email
     FROM assessment_results ar JOIN users u ON u.id = ar.user_id
     ORDER BY ar.taken_at DESC, ar.id DESC LIMIT 8"
)->fetch_all(MYSQLI_ASSOC);

$recentUsers = db()->query(
    "SELECT id, full_name, email, role, is_verified, created_at FROM users ORDER BY created_at DESC, id DESC LIMIT 8"
)->fetch_all(MYSQLI_ASSOC);

$pageTitle = 'Dashboard';
$activeNav = 'dashboard';
require __DIR__ . '/includes/header.php';
?>

<div class="stats">
    <?php foreach ($stats as [$label, $value, $href, $hint]): ?>
        <?php if ($href): ?><a class="stat" href="<?= e($href) ?>"><?php else: ?><div class="stat"><?php endif; ?>
            <div class="label"><?= e($label) ?></div>
            <div class="value"><?= number_format($value) ?></div>
            <div class="hint"><?= e($hint) ?></div>
        <?php if ($href): ?></a><?php else: ?></div><?php endif; ?>
    <?php endforeach; ?>
</div>

<div class="form-grid">
    <div class="card">
        <h2>Recent assessments</h2>
        <?php if (!$recentAssessments): ?>
            <p class="muted">No assessments yet.</p>
        <?php else: ?>
            <table>
                <thead><tr><th>User</th><th>Code</th><th>Taken</th></tr></thead>
                <tbody>
                <?php foreach ($recentAssessments as $r): ?>
                    <tr>
                        <td><?= e($r['full_name']) ?><div class="muted"><?= e($r['email']) ?></div></td>
                        <td><span class="badge badge-dark"><?= e($r['holland_code']) ?></span></td>
                        <td class="muted"><?= e(date('M j, Y g:i A', strtotime($r['taken_at']))) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="card">
        <h2>Newest accounts</h2>
        <table>
            <thead><tr><th>Name</th><th>Status</th><th>Joined</th></tr></thead>
            <tbody>
            <?php foreach ($recentUsers as $u): ?>
                <tr>
                    <td><a href="user_edit.php?id=<?= (int)$u['id'] ?>"><?= e($u['full_name']) ?></a><div class="muted"><?= e($u['email']) ?></div></td>
                    <td>
                        <?php if ($u['role'] === 'admin'): ?><span class="badge badge-dark">Admin</span><?php endif; ?>
                        <?= $u['is_verified'] ? '<span class="badge badge-green">Verified</span>' : '<span class="badge badge-amber">Unverified</span>' ?>
                    </td>
                    <td class="muted"><?= e(date('M j, Y', strtotime($u['created_at']))) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
