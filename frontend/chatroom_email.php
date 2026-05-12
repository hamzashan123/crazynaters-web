<?php
declare(strict_types=1);

header('Content-Type: application/json');

require __DIR__ . '/vendor/autoload.php';

use Google\Auth\Credentials\ServiceAccountCredentials;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

const FIREBASE_CREDENTIALS_PATH = __DIR__ . '/firebase-service-account.json';
const PROJECT_ID = 'chatroom-4ecf4';

// ✅ Separate URLs
const DASHBOARD_URL = 'https://lightgrey-owl-201683.hostingersite.com/frontend/chat-dashboard.php';
const MOBILE_URL = 'https://lightgrey-owl-201683.hostingersite.com/frontend/mobile.php';

const SMTP_HOST = 'smtp.hostinger.com';
const SMTP_PORT = 465;
const SMTP_USERNAME = 'admin@mundiatech.online';
const SMTP_PASSWORD = '2/y]patC';
const SMTP_FROM_EMAIL = 'admin@mundiatech.online';
const SMTP_FROM_NAME = 'CrazyNaters';

function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function getPostData(): array {
    $raw = file_get_contents('php://input');
    return json_decode($raw ?: '{}', true) ?? [];
}

// ✅ Detect device
function isMobileDevice(): bool {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    return preg_match('/Android|iPhone|iPad|iPod|Mobile/i', $userAgent) === 1;
}

function buildQrUrl(string $link): string {
    return 'https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=' . rawurlencode($link);
}

function generatePermanentToken(): string {
    return bin2hex(random_bytes(32));
}

function getGoogleAccessToken(string $scope = 'https://www.googleapis.com/auth/datastore'): string {
    $creds = new ServiceAccountCredentials($scope, FIREBASE_CREDENTIALS_PATH);
    $token = $creds->fetchAuthToken();

    if (empty($token['access_token'])) {
        throw new RuntimeException('Failed to fetch Google access token.');
    }

    return $token['access_token'];
}

function firestoreRequest(string $method, string $url, ?array $payload = null): array {
    $accessToken = getGoogleAccessToken();

    $ch = curl_init($url);

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ];

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 30,
    ]);

    if ($payload !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    }

    $response = curl_exec($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        throw new RuntimeException('cURL error: ' . $curlError);
    }

    $data = json_decode($response ?: '{}', true);

    if ($httpCode < 200 || $httpCode >= 300) {
        $message = $data['error']['message'] ?? $response ?? 'Firestore request failed';
        throw new RuntimeException('Firestore error: ' . $message);
    }

    return $data;
}

function findUserByEmail(string $email): ?array {
    $url = 'https://firestore.googleapis.com/v1/projects/' . PROJECT_ID . '/databases/(default)/documents:runQuery';

    $payload = [
        'structuredQuery' => [
            'from' => [
                ['collectionId' => 'users']
            ],
            'where' => [
                'fieldFilter' => [
                    'field' => ['fieldPath' => 'email'],
                    'op' => 'EQUAL',
                    'value' => ['stringValue' => $email]
                ]
            ],
            'limit' => 1
        ]
    ];

    $results = firestoreRequest('POST', $url, $payload);

    foreach ($results as $row) {
        if (!empty($row['document'])) {
            $doc = $row['document'];
            $fields = $doc['fields'] ?? [];
            $nameParts = explode('/', $doc['name']);
            $uid = end($nameParts);

            return [
                'uid' => $uid,
                'docName' => $doc['name'],
                'fields' => $fields,
            ];
        }
    }

    return null;
}

function patchUserFields(string $uid, array $fields): void {
    $queryParams = [];
    foreach (array_keys($fields) as $fieldPath) {
        $queryParams[] = 'updateMask.fieldPaths=' . rawurlencode($fieldPath);
    }

    $url = 'https://firestore.googleapis.com/v1/projects/' . PROJECT_ID . '/databases/(default)/documents/users/' . rawurlencode($uid);
    if (!empty($queryParams)) {
        $url .= '?' . implode('&', $queryParams);
    }

    $payload = ['fields' => $fields];

    firestoreRequest('PATCH', $url, $payload);
}

function getOrCreateLoginToken(string $uid, array $fields): string {
    $existing = $fields['login_token']['stringValue'] ?? '';

    if ($existing !== '') {
        return $existing;
    }

    $newToken = generatePermanentToken();

    patchUserFields($uid, [
        'login_token' => ['stringValue' => $newToken],
    ]);

    return $newToken;
}

function sendEmail(string $toEmail, string $name, string $loginLink, string $loginToken): void {
    $qrImage = buildQrUrl($loginLink);
    
    
    $safeName = htmlspecialchars($name !== '' ? $name : 'User', ENT_QUOTES, 'UTF-8');
    // $safeLoginLink = htmlspecialchars($loginLink, ENT_QUOTES, 'UTF-8');
    $safeLoginLink = htmlspecialchars(DASHBOARD_URL . '?login_token=' . urlencode($loginToken), ENT_QUOTES, 'UTF-8' );
    
    $safeQrImage = htmlspecialchars($qrImage, ENT_QUOTES, 'UTF-8');

    $html = "
        <div style='font-family:Arial,sans-serif;max-width:620px;margin:0 auto;padding:24px;background:#f6f8fb;'>
            <div style='background:#ffffff;padding:28px;border-radius:14px;box-shadow:0 8px 28px rgba(0,0,0,0.08);'>
                <h2>Quick Login</h2>
              
                <p>Click below to login:</p>
                
                <p>Or scan QR:</p>

                <img src='{$safeQrImage}' width='220' />

                <p style='font-size:12px;word-break:break-all;margin-top:10px;'>
                    {$safeLoginLink}
                    
                </p>
            </div>
        </div>
    ";

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = SMTP_PORT;

    $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
    $mail->addAddress($toEmail, $name);

    $mail->isHTML(true);
    $mail->Subject = 'Quick Login';
    $mail->Body = $html;

    $mail->send();
}

try {
    $data = getPostData();
    $email = trim((string)($data['email'] ?? ''));
    $name = trim((string)($data['name'] ?? 'User'));

    if ($email === '') {
        jsonResponse(['success' => false, 'error' => 'Email required'], 400);
    }

    $user = findUserByEmail($email);

    if (!$user) {
        jsonResponse(['success' => false, 'error' => 'User not found'], 404);
    }

    if (($user['fields']['is_banned']['booleanValue'] ?? false) === true) {
        jsonResponse(['success' => false, 'error' => 'User banned'], 403);
    }

    $loginToken = getOrCreateLoginToken($user['uid'], $user['fields']);

    // ✅ Device-based link
    if (isMobileDevice()) {
        $baseUrl = MOBILE_URL;
    } else {
        $baseUrl = MOBILE_URL;
    }

    $loginLink = $baseUrl . '?login_token=' . urlencode($loginToken);

    sendEmail($email, $name, $loginLink,$loginToken);

    jsonResponse([
        'success' => true,
        'message' => 'Email sent successfully',
        'debug_link' => $loginLink // optional for testing
    ]);

} catch (Throwable $e) {
    jsonResponse([
        'success' => false,
        'error' => $e->getMessage()
    ], 500);
}