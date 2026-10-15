<?php
/**
 * Add / edit a school, upload its logo, and link it to degree programs.
 * Everything here is read by the public Colleges, School Profile and Programs pages.
 */
require_once __DIR__ . '/includes/admin_auth.php';

$id     = (int)($_GET['id'] ?? 0);
$isNew  = $id === 0;
$errors = [];

$school = [
    'name' => '', 'short_name' => '', 'type' => 'Private', 'address' => '', 'about' => '',
    'website' => '', 'profile_url' => '', 'image_url' => '', 'latitude' => '', 'longitude' => '',
    'map_query' => '', 'requirements' => '', 'is_archived' => 0,
];
$linked   = [];   // degree_id => is_featured
$hasWebsite = (bool)db()->query("SHOW COLUMNS FROM colleges LIKE 'website'")->num_rows;

if (!$isNew) {
    $stmt = db()->prepare('SELECT * FROM colleges WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $found = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$found) {
        flash('error', 'School not found.');
        redirect('schools.php');
    }
    $school = array_merge($school, array_map(fn($v) => $v ?? '', $found));

    $stmt = db()->prepare('SELECT degree_id, is_featured FROM college_degrees WHERE college_id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    foreach ($stmt->get_result()->fetch_all(MYSQLI_ASSOC) as $row) {
        $linked[(int)$row['degree_id']] = (int)$row['is_featured'];
    }
    $stmt->close();
}

/** JSON requirements <-> "Title | Description | Status" lines (one per line). */
function requirements_to_text(string $json): string {
    $items = json_decode($json, true);
    if (!is_array($items)) return '';
    return implode("\n", array_map(
        fn($r) => trim(($r['title'] ?? '') . ' | ' . ($r['desc'] ?? '') . ' | ' . ($r['status'] ?? ''), ' |'),
        $items
    ));
}
function text_to_requirements(string $text): ?string {
    $items = [];
    foreach (preg_split('/\R/', $text) as $line) {
        if (trim($line) === '') continue;
        $parts = array_map('trim', explode('|', $line));
        $items[] = ['title' => $parts[0] ?? '', 'desc' => $parts[1] ?? '', 'status' => $parts[2] ?? 'Required'];
    }
    return $items ? json_encode($items, JSON_UNESCAPED_UNICODE) : null;
}

$requirementsText = requirements_to_text((string)$school['requirements']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $school['name']        = post_str('name', 255);
    $school['short_name']  = post_str('short_name', 50);
    $school['type']        = post_str('type', 50);
    $school['address']     = post_str('address', 255);
    $school['about']       = post_str('about', 5000);
    $school['website']     = post_str('website', 255);
    $school['profile_url'] = post_str('profile_url', 255);
    $school['map_query']   = post_str('map_query', 255);
    $school['latitude']    = post_str('latitude', 20);
    $school['longitude']   = post_str('longitude', 20);
    $school['is_archived']  = !empty($_POST['is_archived']) ? 1 : 0;
    $requirementsText      = post_str('requirements', 10000);

    if ($school['name'] === '') $errors[] = 'School name is required.';
    if (!preg_match('/^[A-Za-z0-9_-]{2,50}$/', $school['short_name'])) {
        $errors[] = 'Short name is required (2-50 letters, numbers, dashes or underscores). It is used in profile URLs.';
    }
    if ($school['website'] !== '' && !filter_var($school['website'], FILTER_VALIDATE_URL)) {
        $errors[] = 'Website must be a full URL, e.g. https://www.school.edu.ph';
    }
    if ($school['latitude'] !== '' && (!is_numeric($school['latitude']) || abs((float)$school['latitude']) > 90)) {
        $errors[] = 'Latitude must be a number between -90 and 90.';
    }
    if ($school['longitude'] !== '' && (!is_numeric($school['longitude']) || abs((float)$school['longitude']) > 180)) {
        $errors[] = 'Longitude must be a number between -180 and 180.';
    }

    // Short name doubles as the public profile id, so it must be unique.
    if (!$errors) {
        $stmt = db()->prepare('SELECT id FROM colleges WHERE short_name = ? AND id <> ?');
        $stmt->bind_param('si', $school['short_name'], $id);
        $stmt->execute();
        if ($stmt->get_result()->fetch_row()) $errors[] = 'Another school already uses that short name.';
        $stmt->close();
    }

    /* ---------- Logo upload (optional) ---------- */
    if (!$errors && !empty($_FILES['logo']['name'])) {
        $file = $_FILES['logo'];
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = $file['error'] === UPLOAD_ERR_OK ? (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']) : '';
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Logo upload failed (error code ' . (int)$file['error'] . ').';
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Logo must be 2 MB or smaller.';
        } elseif (!isset($allowed[$mime]) || !getimagesize($file['tmp_name'])) {
            $errors[] = 'Logo must be a JPG, PNG or WEBP image.';
        } else {
            $dir = __DIR__ . '/../assets/colleges/uploads';
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $filename = strtolower($school['short_name']) . '-' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
            if (move_uploaded_file($file['tmp_name'], $dir . '/' . $filename)) {
                // Same absolute-path style as the existing seeded rows.
                $school['image_url'] = app_base() . '/assets/colleges/uploads/' . $filename;
            } else {
                $errors[] = 'Could not save the uploaded logo.';
            }
        }
    } elseif (empty($_FILES['logo']['name'])) {
        $school['image_url'] = post_str('image_url', 255);
    }

    if (!$errors) {
        if ($school['profile_url'] === '') {
            // Generic profile template works for any school with a short name.
            $school['profile_url'] = 'school-profile?id=' . rawurlencode($school['short_name']);
        }
        $lat  = $school['latitude']  !== '' ? (float)$school['latitude']  : null;
        $lng  = $school['longitude'] !== '' ? (float)$school['longitude'] : null;
        $reqs = text_to_requirements($requirementsText);
        $nullable = fn($v) => $v === '' ? null : $v;

        db()->begin_transaction();
        try {
            $cols = ['name', 'short_name', 'type', 'address', 'about', 'profile_url', 'image_url', 'map_query'];
            $vals = array_map(fn($c) => $nullable($school[$c]), $cols);
            $vals[0] = $school['name'];
            $types = str_repeat('s', count($cols));
            if ($hasWebsite) { $cols[] = 'website'; $vals[] = $nullable($school['website']); $types .= 's'; }
            $cols[] = 'latitude';     $vals[] = $lat;  $types .= 'd';
            $cols[] = 'longitude';    $vals[] = $lng;  $types .= 'd';
            $cols[] = 'requirements'; $vals[] = $reqs; $types .= 's';
            $cols[] = 'is_archived';   $vals[] = (int)$school['is_archived']; $types .= 'i';

            if ($isNew) {
                $sql = 'INSERT INTO colleges (' . implode(', ', $cols) . ') VALUES (' . rtrim(str_repeat('?, ', count($cols)), ', ') . ')';
                $stmt = db()->prepare($sql);
                $stmt->bind_param($types, ...$vals);
                $stmt->execute();
                $id = db()->insert_id;
            } else {
                $sql = 'UPDATE colleges SET ' . implode(' = ?, ', $cols) . ' = ? WHERE id = ?';
                $stmt = db()->prepare($sql);
                $stmt->bind_param($types . 'i', ...array_merge($vals, [$id]));
                $stmt->execute();
            }

            /* ---------- Degree program links ---------- */
            $selected = array_map('intval', (array)($_POST['degrees'] ?? []));
            $featured = array_map('intval', (array)($_POST['featured'] ?? []));
            $del = db()->prepare('DELETE FROM college_degrees WHERE college_id = ?');
            $del->bind_param('i', $id);
            $del->execute();
            if ($selected) {
                $ins = db()->prepare('INSERT INTO college_degrees (college_id, degree_id, is_featured)
                                      SELECT ?, id, ? FROM degrees WHERE id = ?');
                foreach (array_unique($selected) as $degreeId) {
                    $isFeat = in_array($degreeId, $featured, true) ? 1 : 0;
                    $ins->bind_param('iii', $id, $isFeat, $degreeId);
                    $ins->execute();
                }
            }
            db()->commit();
        } catch (Throwable $ex) {
            db()->rollback();
            throw $ex;
        }

        flash('success', $isNew ? 'School added. It now appears on the public Colleges page.' : 'School updated.');
        redirect('school_edit.php?id=' . $id);
    }

    // Re-check boxes from the submitted form after a validation error.
    $linked = [];
    foreach ((array)($_POST['degrees'] ?? []) as $d) {
        $linked[(int)$d] = in_array((int)$d, array_map('intval', (array)($_POST['featured'] ?? [])), true) ? 1 : 0;
    }
}

$degrees = db()->query('SELECT id, title, category FROM degrees ORDER BY category, title')->fetch_all(MYSQLI_ASSOC);

$pageTitle = $isNew ? 'Add school' : 'Edit school';
$activeNav = 'schools';
require __DIR__ . '/includes/header.php';
?>

<p><a href="schools.php">&larr; Back to schools</a>
<?php if (!$isNew): ?> &middot; <a href="<?= e(app_base()) ?>/school-profile?id=<?= e(rawurlencode($school['short_name'])) ?>" target="_blank" rel="noopener">View public profile &nearr;</a><?php endif; ?></p>

<?php foreach ($errors as $err): ?><div class="alert alert-error"><?= e($err) ?></div><?php endforeach; ?>

<form method="post" action="school_edit.php<?= $isNew ? '' : '?id=' . $id ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="card">
        <h2>School information</h2>
        <div class="form-grid">
            <div>
                <label for="name">School name</label>
                <input id="name" name="name" type="text" value="<?= e($school['name']) ?>" required maxlength="255">
            </div>
            <div>
                <label for="short_name">Short name / code</label>
                <input id="short_name" name="short_name" type="text" value="<?= e($school['short_name']) ?>" required maxlength="50" pattern="[A-Za-z0-9_\-]{2,50}">
                <div class="help">Used in links, e.g. school-profile?id=<strong><?= e($school['short_name'] ?: 'NU') ?></strong></div>
            </div>
            <div>
                <label for="type">Type</label>
                <input id="type" name="type" type="text" list="type-list" value="<?= e($school['type']) ?>" maxlength="50">
                <datalist id="type-list">
                    <option value="Public"><option value="Public State U"><option value="Private"><option value="Private Sectarian">
                </datalist>
                <div class="help">Types containing "Public" are shown with the Free Tuition badge.</div>
            </div>
            <div>
                <label for="website">Website</label>
                <input id="website" name="website" type="url" value="<?= e($school['website']) ?>" placeholder="https://" <?= $hasWebsite ? '' : 'disabled' ?>>
                <?php if (!$hasWebsite): ?><div class="help">Run the admin migration to enable this field.</div><?php endif; ?>
            </div>
            <div class="full">
                <label for="address">Location / address</label>
                <input id="address" name="address" type="text" value="<?= e($school['address']) ?>" maxlength="255">
            </div>
            <div class="full">
                <label for="about">Description</label>
                <textarea id="about" name="about" rows="5"><?= e($school['about']) ?></textarea>
            </div>
            <div class="full" style="margin-top: 4px;">
                <label class="checkbox">
                    <input type="checkbox" name="is_archived" value="1" <?= !empty($school['is_archived']) ? 'checked' : '' ?>>
                    Archive this school (hides it from the public Colleges page and degree search)
                </label>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Logo &amp; map</h2>
        <div class="form-grid">
            <div>
                <label for="logo">Upload logo / cover image</label>
                <input id="logo" name="logo" type="file" accept="image/jpeg,image/png,image/webp">
                <div class="help">JPG, PNG or WEBP, max 2 MB. Leave empty to keep the current image.</div>
                <?php if ($school['image_url']): ?>
                    <p><img class="logo-preview" src="<?= e($school['image_url']) ?>" alt="Current logo"></p>
                <?php endif; ?>
            </div>
            <div>
                <label for="image_url">...or image path / URL</label>
                <input id="image_url" name="image_url" type="text" value="<?= e($school['image_url']) ?>" maxlength="255">
                <label for="profile_url" style="margin-top:14px">Profile page link</label>
                <input id="profile_url" name="profile_url" type="text" value="<?= e($school['profile_url']) ?>" maxlength="255" placeholder="Auto: school-profile?id=SHORTNAME">
            </div>
            <div>
                <label for="latitude">Latitude</label>
                <input id="latitude" name="latitude" type="text" inputmode="decimal" value="<?= e($school['latitude']) ?>" placeholder="14.3294">
            </div>
            <div>
                <label for="longitude">Longitude</label>
                <input id="longitude" name="longitude" type="text" inputmode="decimal" value="<?= e($school['longitude']) ?>" placeholder="120.9367">
            </div>
            <div class="full">
                <label for="map_query">Google Maps search text</label>
                <input id="map_query" name="map_query" type="text" value="<?= e($school['map_query']) ?>" maxlength="255">
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Admission requirements</h2>
        <textarea name="requirements" rows="6" placeholder="Entrance Exam | School admission test | Required"><?= e($requirementsText) ?></textarea>
        <div class="help">One per line: <code>Title | Description | Status</code> (Status e.g. Required, Verify, Optional).</div>
    </div>

    <div class="card">
        <h2>Degree programs offered</h2>
        <p class="muted">Checked programs show on this school's Programs page and on each degree's profile. Tick "featured" to highlight one.</p>
        <input type="search" id="degreeFilter" placeholder="Filter programs..." style="margin-bottom:10px">
        <div class="degree-list" id="degreeList">
            <?php foreach ($degrees as $d): $did = (int)$d['id']; ?>
                <div class="degree-row" data-title="<?= e(strtolower($d['title'] . ' ' . $d['category'])) ?>">
                    <input type="checkbox" id="deg<?= $did ?>" name="degrees[]" value="<?= $did ?>" <?= isset($linked[$did]) ? 'checked' : '' ?>>
                    <label for="deg<?= $did ?>" style="margin:0;font-weight:500"><?= e($d['title']) ?></label>
                    <span class="feat"><input type="checkbox" name="featured[]" value="<?= $did ?>" <?= !empty($linked[$did]) ? 'checked' : '' ?>> featured</span>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="help">Scholarships are currently static content on the Scholarships page (no database table), so they can't be linked here yet.</p>
    </div>

    <div class="form-actions">
        <button class="btn btn-primary" type="submit"><?= $isNew ? 'Add school' : 'Save changes' ?></button>
        <a class="btn btn-light" href="schools.php">Cancel</a>
    </div>
</form>

<script>
document.getElementById('degreeFilter').addEventListener('input', function () {
    var q = this.value.toLowerCase();
    document.querySelectorAll('#degreeList .degree-row').forEach(function (row) {
        row.style.display = row.dataset.title.indexOf(q) !== -1 ? '' : 'none';
    });
});
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
