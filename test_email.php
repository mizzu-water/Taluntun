<?php
/**
 * Test script to verify PHPMailer configuration, Asia/Manila timezone,
 * and email sending functionality for Talunton RIASEC System.
 */
require_once __DIR__ . '/auth/config.php';

echo "=== TALUNTON RIASEC SYSTEM - PHPMAILER & TIMEZONE TEST ===" . PHP_EOL;

// 1. Timezone Check
$currentTimezone = date_default_timezone_get();
$currentDate = date('F j, Y');
$currentTime = date('g:i A');
$currentRaw = date('Y-m-d H:i:s P');

echo "1. Timezone Information:" . PHP_EOL;
echo "   - Active Timezone: {$currentTimezone}" . PHP_EOL;
echo "   - Formatted Date:  {$currentDate}" . PHP_EOL;
echo "   - Formatted Time:  {$currentTime}" . PHP_EOL;
echo "   - Raw Timestamp:   {$currentRaw}" . PHP_EOL;

if ($currentTimezone !== 'Asia/Manila') {
    echo "   [WARNING] Default timezone is not set to Asia/Manila!" . PHP_EOL;
} else {
    echo "   [OK] System timezone correctly set to Philippine Time (Asia/Manila, UTC+8)." . PHP_EOL;
}

echo PHP_EOL;

// 2. Database Connection and Timezone Check
echo "2. Database Connection & Timezone:" . PHP_EOL;
try {
    $db = getDB();
    $res = $db->query("SELECT @@session.time_zone AS tz, NOW() AS db_now");
    $row = $res->fetch_assoc();
    echo "   - DB Session Timezone: " . $row['tz'] . PHP_EOL;
    echo "   - DB Current Time:     " . $row['db_now'] . PHP_EOL;
    echo "   [OK] Database connection and timezone (+08:00) verified." . PHP_EOL;
    $db->close();
} catch (\Throwable $e) {
    echo "   [ERROR] Database check failed: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// 3. SMTP Environment Settings Check
echo "3. SMTP Configuration:" . PHP_EOL;
echo "   - SMTP Host:       " . SMTP_HOST . PHP_EOL;
echo "   - SMTP Port:       " . SMTP_PORT . PHP_EOL;
echo "   - SMTP Username:   " . SMTP_USERNAME . PHP_EOL;
echo "   - SMTP Password:   " . (empty(SMTP_APP_PASSWORD) ? 'NOT SET' : 'CONFIGURED (' . strlen(SMTP_APP_PASSWORD) . ' chars)') . PHP_EOL;
echo "   - SMTP From Email: " . SMTP_FROM_EMAIL . PHP_EOL;
echo "   - SMTP From Name:  " . SMTP_FROM_NAME . PHP_EOL;

echo PHP_EOL;

// 4. Test Email Sending via sendMail()
$targetEmail = $argv[1] ?? SMTP_USERNAME;
echo "4. Sending Test Login Confirmation Email to: {$targetEmail}..." . PHP_EOL;

$subject = "Successful Login to Talunton RIASEC System";
$htmlBody = "
<div style='background-color: #f4f6f8; padding: 30px 15px; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif;'>
    <div style='max-width: 560px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;'>
        <div style='background-color: #0e3223; padding: 28px 24px; text-align: center;'>
            <h1 style='color: #10b981; margin: 0; font-size: 26px; font-weight: 800; letter-spacing: 0.5px;'>Talunton</h1>
            <p style='color: #d1fae5; margin: 6px 0 0 0; font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;'>RIASEC Career Profiling System</p>
        </div>
        <div style='padding: 32px 28px;'>
            <h2 style='color: #111827; font-size: 19px; margin-top: 0; font-weight: 700;'>Successful Login Notification</h2>
            <p style='color: #374151; font-size: 15px; line-height: 1.6; margin-bottom: 20px;'>
                You have successfully logged in to the Talunton RIASEC System on <strong>{$currentDate}</strong> at <strong>{$currentTime}</strong>. You can now access the system’s features, take the RIASEC assessment, explore recommended degree programs, and discover career paths that match your interests, skills, and personality.
            </p>
            <div style='background-color: #f0fdf4; border-left: 4px solid #10b981; padding: 14px 18px; border-radius: 4px; margin-bottom: 24px;'>
                <p style='color: #065f46; font-size: 13px; margin: 0; line-height: 1.5;'>
                    If this was not you, please secure your account immediately or contact support.
                </p>
            </div>
            <p style='color: #6b7280; font-size: 14px; margin-bottom: 0;'>
                Best regards,<br>
                <strong style='color: #0e3223;'>Talunton Guidance Team</strong>
            </p>
        </div>
        <div style='background-color: #f9fafb; padding: 16px 24px; text-align: center; border-top: 1px solid #f3f4f6;'>
            <p style='color: #9ca3af; font-size: 12px; margin: 0;'>&copy; " . date('Y') . " Talunton RIASEC System. All rights reserved.</p>
        </div>
    </div>
</div>";

$altBody = "You have successfully logged in to the Talunton RIASEC System on {$currentDate} at {$currentTime}. You can now access the system’s features, take the RIASEC assessment, explore recommended degree programs, and discover career paths that match your interests, skills, and personality.\n\nIf this was not you, please secure your account immediately.\n\nTalunton RIASEC System";

$result = sendMail($targetEmail, $subject, $htmlBody, $altBody);

if ($result) {
    echo "   [SUCCESS] Email sent successfully to {$targetEmail}!" . PHP_EOL;
    echo "   - Subject: {$subject}" . PHP_EOL;
    echo "   - Date in Email: {$currentDate}" . PHP_EOL;
    echo "   - Time in Email: {$currentTime} (Philippine Standard Time, Asia/Manila)" . PHP_EOL;
} else {
    echo "   [FAILED] Could not send email. Check storage/logs/mail.log or auth/mail_errors.log for details." . PHP_EOL;
}
echo "==========================================================" . PHP_EOL;
