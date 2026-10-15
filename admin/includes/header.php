<?php
/**
 * Admin layout header + sidebar.
 * Set $pageTitle and $activeNav before including.
 */
$pageTitle = $pageTitle ?? 'Admin';
$activeNav = $activeNav ?? '';
$nav = [
    'dashboard' => ['index.php',            'Dashboard',          'M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10'],
    'users'     => ['users.php',            'Accounts',           'M17 20h5v-2a4 4 0 00-5-3.87M9 20H2v-2a4 4 0 015-3.87m6-4a4 4 0 11-8 0 4 4 0 018 0zm6 2a3 3 0 11-6 0 3 3 0 016 0z'],
    'schools'   => ['schools.php',          'Schools',            'M12 14l9-5-9-5-9 5 9 5zm0 0v6m-7-9.5V16l7 4 7-4v-5.5'],
    'riasec'    => ['riasec_questions.php', 'RIASEC Assessment',  'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
    'quiz'      => ['course_questions.php', 'Degree Quiz',        'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
];
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($pageTitle) ?> &middot; Talunton Admin</title>
    <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/admin.css?v=<?= filemtime(__DIR__ . '/../assets/admin.css') ?>">
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <span class="brand-name">Talunton</span>
            <span class="brand-sub">Admin Panel</span>
        </div>
        <nav>
            <?php foreach ($nav as $key => [$href, $label, $icon]): ?>
                <a href="<?= e($href) ?>" class="<?= $activeNav === $key ? 'active' : '' ?>">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= e($icon) ?>"/></svg>
                    <?= e($label) ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="sidebar-foot">
            <a href="<?= e(app_base()) ?>/" target="_blank" rel="noopener">View public site &nearr;</a>
            <form method="post" action="logout.php">
                <?= csrf_field() ?>
                <button type="submit" class="link-btn">Log out</button>
            </form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <button class="menu-btn" type="button" onclick="document.getElementById('sidebar').classList.toggle('open')" aria-label="Toggle menu">&#9776;</button>
            <h1><?= e($pageTitle) ?></h1>
            <div class="who">Signed in as <strong><?= e($ADMIN['username'] ?: $ADMIN['full_name']) ?></strong></div>
        </header>

        <main class="content">
            <?php foreach (take_flashes() as $f): ?>
                <div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div>
            <?php endforeach; ?>
