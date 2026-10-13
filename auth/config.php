<?php
// Central DB & SMTP config — include this in every PHP file
// Load environment variables from .env file
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $envVariables = parse_ini_file($envPath);
    foreach ($envVariables as $key => $value) {
        define($key, $value);
    }
} else {
    die("Error: .env file not found.");
}

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getDB(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        http_response_code(500);
        die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}

function jsonResponse(bool $success, string $message, array $data = []): void {
    header('Content-Type: application/json');
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $data));
    exit;
}

function startAuthSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function isLoggedIn(): bool {
    startAuthSession();
    return isset($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.html');
        exit;
    }
}

/**
 * Send an email verification code using PHPMailer.
 * Returns array: ['success' => bool, 'error' => string]
 */
function sendVerificationEmail(string $recipientEmail, string $recipientName, string $verificationCode): array {
    $mail = new PHPMailer(true);
    try {
        // If SMTP credentials have not been configured yet by the user, return early with message
        if (SMTP_USER === 'your_gmail_here@gmail.com' || empty(SMTP_PASS) || SMTP_PASS === 'your_app_password_here') {
            return [
                'success' => false,
                'error' => 'SMTP not configured yet. Please configure your Gmail credentials in auth/config.php.'
            ];
        }

        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        if (SMTP_ENCRYPTION === 'tls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } elseif (SMTP_ENCRYPTION === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }
        $mail->Port       = SMTP_PORT;
        $mail->Timeout    = 10;

        // Recipients
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($recipientEmail, $recipientName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Your Talunton Cavite Verification Code: {$verificationCode}";
        
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 550px; margin: 0 auto; background-color: #fdfaf6; padding: 30px; border-radius: 12px; border: 1px solid #e5e7eb;'>
            <div style='text-align: center; margin-bottom: 24px;'>
                <h1 style='color: #0e3223; margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px;'>TALUNTON CAVITE</h1>
                <p style='color: #059669; font-size: 13px; font-weight: 700; text-transform: uppercase; margin-top: 4px; letter-spacing: 1px;'>RIASEC Career Profiling System</p>
            </div>
            <div style='background-color: #ffffff; padding: 28px; border-radius: 10px; border: 1px solid #f3f4f6;'>
                <h2 style='color: #111827; font-size: 18px; margin-top: 0;'>Hello, " . htmlspecialchars($recipientName) . "!</h2>
                <p style='color: #4b5563; font-size: 15px; line-height: 1.5;'>Thank you for registering. To complete your account registration and unlock your career assessment, enter this 6-digit verification code:</p>
                <div style='text-align: center; margin: 28px 0;'>
                    <span style='display: inline-block; font-size: 34px; font-weight: 800; letter-spacing: 8px; color: #0e3223; background-color: #ecfdf5; padding: 14px 28px; border-radius: 8px; border: 2px dashed #10b981;'>{$verificationCode}</span>
                </div>
                <p style='color: #6b7280; font-size: 13px; line-height: 1.4; margin-bottom: 0;'>This code will expire in <strong>15 minutes</strong>. If you did not request this account, you can safely ignore this email.</p>
            </div>
            <p style='text-align: center; color: #9ca3af; font-size: 12px; margin-top: 20px;'>&copy; " . date('Y') . " Talunton Cavite Guidance. All rights reserved.</p>
        </div>";

        $mail->AltBody = "Hello {$recipientName},\n\nYour Talunton Cavite verification code is: {$verificationCode}\n\nThis code will expire in 15 minutes.\n\nThank you,\nTalunton Cavite Guidance";

        $mail->send();
        return ['success' => true, 'error' => ''];
    } catch (Exception $e) {
        return ['success' => false, 'error' => $mail->ErrorInfo];
    }
}
