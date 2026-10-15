<?php
/**
 * Add / edit an account, reset its password and change its role.
 *   user_edit.php        -> new account
 *   user_edit.php?id=5   -> edit account 5
 */
require_once __DIR__ . '/includes/admin_auth.php';

$id     = (int)($_GET['id'] ?? 0);
$isNew  = $id === 0;
$isSelf = !$isNew && $id === (int)$ADMIN['id'];
$errors = [];

$user = [
    'full_name' => '', 'username' => '', 'email' => '', 'user_type' => 'shs',
    'role' => 'user', 'is_verified' => 1,
];

if (!$isNew) {
    $stmt = db()->prepare('SELECT id, full_name, username, email, user_type, role, is_verified, created_at FROM users WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $found = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$found) {
        flash('error', 'Account not found.');
        redirect('users.php');
    }
    $user = $found;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? 'save';

    /* ---------- Reset password ---------- */
    if ($action === 'reset_password' && !$isNew) {
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        if (!is_string($new) || strlen($new) < 8) {
            $errors['new_password'] = 'Password must be at least 8 characters.';
        } elseif ($new !== $confirm) {
            $errors['confirm_password'] = 'Passwords do not match.';
        } else {
            $hash = password_hash($new, PASSWORD_BCRYPT);
            $stmt = db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
            $stmt->bind_param('si', $hash, $id);
            $stmt->execute();
            flash('success', 'Password updated for ' . $user['full_name'] . '.');
            redirect('user_edit.php?id=' . $id);
        }
    }

    /* ---------- Save details ---------- */
    if ($action === 'save') {
        $user['full_name']   = post_str('full_name', 150);
        $user['username']    = post_str('username', 50);
        $user['email']       = post_str('email', 191);
        $user['user_type']   = in_array($_POST['user_type'] ?? '', ['shs', 'college', 'professional'], true) ? $_POST['user_type'] : 'shs';
        $user['role']        = ($_POST['role'] ?? '') === 'admin' ? 'admin' : 'user';
        $user['is_verified'] = isset($_POST['is_verified']) ? 1 : 0;
        $password            = $_POST['password'] ?? '';

        // An admin may not demote or unverify themselves (prevents lock-out).
        if ($isSelf) {
            $user['role'] = 'admin';
            $user['is_verified'] = 1;
        }

        if ($user['full_name'] === '') $errors['full_name'] = 'Full name is required.';
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Enter a valid email address.';
        if ($user['username'] !== '' && !preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $user['username'])) {
            $errors['username'] = 'Use 3-50 letters, numbers, dots, dashes or underscores.';
        }
        if ($isNew && (!is_string($password) || strlen($password) < 8)) {
            $errors['password'] = 'Password must be at least 8 characters.';
        }

        // Uniqueness checks for email + username.
        if (!$errors) {
            $stmt = db()->prepare('SELECT email, username FROM users WHERE (email = ? OR (username IS NOT NULL AND username = ?)) AND id <> ?');
            $stmt->bind_param('ssi', $user['email'], $user['username'], $id);
            $stmt->execute();
            foreach ($stmt->get_result()->fetch_all(MYSQLI_ASSOC) as $dup) {
                if (strcasecmp($dup['email'], $user['email']) === 0) $errors['email'] = 'That email is already in use.';
                if ($user['username'] !== '' && strcasecmp((string)$dup['username'], $user['username']) === 0) $errors['username'] = 'That username is taken.';
            }
            $stmt->close();
        }

        // Don't allow removing the last admin via demotion.
        if (!$errors && !$isNew && $found['role'] === 'admin' && $user['role'] !== 'admin') {
            $adminCount = (int)db()->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetch_row()[0];
            if ($adminCount <= 1) $errors['role'] = 'This is the last admin account; it must stay an admin.';
        }

        if (!$errors) {
            $username = $user['username'] !== '' ? $user['username'] : null;
            if ($isNew) {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = db()->prepare('INSERT INTO users (full_name, username, email, password_hash, user_type, role, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('ssssssi', $user['full_name'], $username, $user['email'], $hash, $user['user_type'], $user['role'], $user['is_verified']);
                $stmt->execute();
                $id = db()->insert_id;
                flash('success', 'Account created.');
            } else {
                $stmt = db()->prepare('UPDATE users SET full_name = ?, username = ?, email = ?, user_type = ?, role = ?, is_verified = ? WHERE id = ?');
                $stmt->bind_param('sssssii', $user['full_name'], $username, $user['email'], $user['user_type'], $user['role'], $user['is_verified'], $id);
                $stmt->execute();
                if ($isSelf) $_SESSION['full_name'] = $user['full_name'];
                flash('success', 'Account updated.');
            }
            redirect('user_edit.php?id=' . $id);
        }
    }
}

/** Render an inline field error. */
function field_error(array $errors, string $key): string {
    return isset($errors[$key]) ? '<div class="help" style="color:#dc2626">' . e($errors[$key]) . '</div>' : '';
}

$pageTitle = $isNew ? 'Add account' : 'Edit account';
$activeNav = 'users';
require __DIR__ . '/includes/header.php';
?>

<p><a href="users.php">&larr; Back to accounts</a></p>

<?php if ($errors): ?><div class="alert alert-error">Please fix the highlighted fields.</div><?php endif; ?>

<form class="card" method="post" action="user_edit.php<?= $isNew ? '' : '?id=' . $id ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <h2>Account details</h2>
    <div class="form-grid">
        <div>
            <label for="full_name">Full name</label>
            <input id="full_name" name="full_name" type="text" value="<?= e($user['full_name']) ?>" required maxlength="150">
            <?= field_error($errors, 'full_name') ?>
        </div>
        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?= e($user['email']) ?>" required maxlength="191">
            <?= field_error($errors, 'email') ?>
        </div>
        <div>
            <label for="username">Username <span class="muted">(optional, used for admin login)</span></label>
            <input id="username" name="username" type="text" value="<?= e($user['username']) ?>" maxlength="50">
            <?= field_error($errors, 'username') ?>
        </div>
        <div>
            <label for="user_type">User type</label>
            <select id="user_type" name="user_type">
                <?php foreach (['shs' => 'Senior High School', 'college' => 'College', 'professional' => 'Professional'] as $val => $label): ?>
                    <option value="<?= e($val) ?>" <?= $user['user_type'] === $val ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="role">Role</label>
            <select id="role" name="role" <?= $isSelf ? 'disabled' : '' ?>>
                <option value="user"  <?= $user['role'] === 'user'  ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <?php if ($isSelf): ?><div class="help">You can't change your own role.</div><?php endif; ?>
            <?= field_error($errors, 'role') ?>
        </div>
        <div>
            <label>&nbsp;</label>
            <label class="checkbox"><input type="checkbox" name="is_verified" value="1" <?= $user['is_verified'] ? 'checked' : '' ?> <?= $isSelf ? 'disabled' : '' ?>> Email verified (can log in)</label>
        </div>
        <?php if ($isNew): ?>
            <div class="full">
                <label for="password">Initial password</label>
                <input id="password" name="password" type="password" minlength="8" required autocomplete="new-password">
                <div class="help">At least 8 characters. Stored as a bcrypt hash.</div>
                <?= field_error($errors, 'password') ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="form-actions">
        <button class="btn btn-primary" type="submit"><?= $isNew ? 'Create account' : 'Save changes' ?></button>
        <a class="btn btn-light" href="users.php">Cancel</a>
    </div>
</form>

<?php if (!$isNew): ?>
<form class="card" method="post" action="user_edit.php?id=<?= $id ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="reset_password">
    <h2>Reset password</h2>
    <div class="form-grid">
        <div>
            <label for="new_password">New password</label>
            <input id="new_password" name="new_password" type="password" minlength="8" required autocomplete="new-password">
            <?= field_error($errors, 'new_password') ?>
        </div>
        <div>
            <label for="confirm_password">Confirm new password</label>
            <input id="confirm_password" name="confirm_password" type="password" minlength="8" required autocomplete="new-password">
            <?= field_error($errors, 'confirm_password') ?>
        </div>
    </div>
    <div class="form-actions">
        <button class="btn btn-primary" type="submit">Update password</button>
    </div>
</form>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
