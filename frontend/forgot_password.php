<?php
declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . '/../bootstrap.php';

require __DIR__ . '/vendor/autoload.php';

use Google\Auth\Credentials\ServiceAccountCredentials;
use PHPMailer\PHPMailer\PHPMailer;

const FIREBASE_CREDENTIALS_PATH = __DIR__ . '/firebase-service-account.json';
const DASHBOARD_RESET_URL = 'https://lightgrey-owl-201683.hostingersite.com/frontend/chat-dashboard.php';

function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function getPostData(): array {
    $raw = file_get_contents('php://input');
    return json_decode($raw ?: '{}', true) ?? [];
}

function getGoogleAccessToken(string $serviceAccountPath): string {
    if (!file_exists($serviceAccountPath)) {
        throw new RuntimeException('firebase-service-account.json not found.');
    }

    $scopes = ['https://www.googleapis.com/auth/identitytoolkit'];
    $creds = new ServiceAccountCredentials($scopes, $serviceAccountPath);
    $token = $creds->fetchAuthToken();

    if (empty($token['access_token'])) {
        throw new RuntimeException('Failed to fetch Google access token.');
    }

    return $token['access_token'];
}

function firebaseCreatePasswordResetLink(string $email): string {
    $accessToken = getGoogleAccessToken(FIREBASE_CREDENTIALS_PATH);

    $payload = [
        'requestType' => 'PASSWORD_RESET',
        'email' => $email,
        'returnOobLink' => true
    ];

    $ch = curl_init('https://identitytoolkit.googleapis.com/v1/accounts:sendOobCode');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ],
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_TIMEOUT => 30,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        throw new RuntimeException('cURL error: ' . $curlError);
    }

    $data = json_decode($response ?: '{}', true);

    if ($httpCode < 200 || $httpCode >= 300) {
        throw new RuntimeException('Firebase error: ' . ($data['error']['message'] ?? $response));
    }

    if (empty($data['oobLink'])) {
        throw new RuntimeException('Firebase did not return a password reset link.');
    }

    $parts = parse_url((string)$data['oobLink']);
    parse_str($parts['query'] ?? '', $query);

    if (empty($query['oobCode'])) {
        throw new RuntimeException('Password reset code missing from Firebase link.');
    }

    return DASHBOARD_RESET_URL . '?mode=resetPassword&oobCode=' . rawurlencode((string)$query['oobCode']);
}

function sendResetEmail(string $toEmail, string $resetLink): void {
    $safeLink = htmlspecialchars($resetLink, ENT_QUOTES, 'UTF-8');

    $html = "
        <h2>Reset Your Password</h2>
        <p>You requested to reset your Chatroom password.</p>
        <p>
            <a href='{$safeLink}' style='padding:12px 20px;background:#0d6efd;color:#fff;text-decoration:none;border-radius:6px;display:inline-block;'>
                Reset Password
            </a>
        </p>
        <p>If the button does not work, copy this link:</p>
        <p style='word-break:break-all;'>{$safeLink}</p>
        <p>If you did not request this, you can ignore this email.</p>
    ";

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = (int) $_ENV['SMTP_PORT'];

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
    $mail->addAddress($toEmail);

    $mail->isHTML(true);
    $mail->Subject = 'Reset Your Chatroom Password';
    $mail->Body = $html;
    $mail->AltBody = "Reset your password: {$resetLink}";

    $mail->send();
}

try {
    $data = getPostData();
    $email = trim((string)($data['email'] ?? ''));

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonResponse(['success' => false, 'error' => 'Valid email is required.'], 400);
    }

    $resetLink = firebaseCreatePasswordResetLink($email);
    sendResetEmail($email, $resetLink);

    jsonResponse(['success' => true]);
} catch (Throwable $e) {
    jsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
}
