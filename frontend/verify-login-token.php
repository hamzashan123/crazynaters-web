<?php
declare(strict_types=1);

header('Content-Type: application/json');

require __DIR__ . '/vendor/autoload.php';

use Google\Auth\Credentials\ServiceAccountCredentials;
use Kreait\Firebase\Factory;

const FIREBASE_CREDENTIALS_PATH = __DIR__ . '/firebase-service-account.json';
const PROJECT_ID = 'chatroom-4ecf4';

function jsonResponse(array $data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function getPostData(): array
{
    $raw = file_get_contents('php://input');
    return json_decode($raw ?: '{}', true) ?? [];
}

function getGoogleAccessToken(string $scope = 'https://www.googleapis.com/auth/datastore'): string
{
    $creds = new ServiceAccountCredentials($scope, FIREBASE_CREDENTIALS_PATH);
    $token = $creds->fetchAuthToken();

    if (empty($token['access_token'])) {
        throw new RuntimeException('Failed to fetch Google access token.');
    }

    return $token['access_token'];
}

function firestoreRequest(string $method, string $url, ?array $payload = null): array
{
    $accessToken = getGoogleAccessToken();

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ],
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

function findUserByLoginToken(string $token): ?array
{
    $url = 'https://firestore.googleapis.com/v1/projects/' . PROJECT_ID . '/databases/(default)/documents:runQuery';

    $payload = [
        'structuredQuery' => [
            'from' => [
                ['collectionId' => 'users']
            ],
            'where' => [
                'fieldFilter' => [
                    'field' => ['fieldPath' => 'login_token'],
                    'op' => 'EQUAL',
                    'value' => ['stringValue' => $token]
                ]
            ],
            'limit' => 1
        ]
    ];

    $results = firestoreRequest('POST', $url, $payload);

    foreach ($results as $row) {
        if (empty($row['document'])) {
            continue;
        }

        $doc = $row['document'];
        $fields = $doc['fields'] ?? [];

        $nameParts = explode('/', $doc['name']);
        $docUid = end($nameParts);
        $storedUid = $fields['uid']['stringValue'] ?? '';

        $finalUid = $storedUid !== '' ? $storedUid : $docUid;

        return [
            'uid' => $finalUid,
            'doc_uid' => $docUid,
            'fields' => $fields,
        ];
    }

    return null;
}

try {
    $data = getPostData();
    $token = trim((string)($data['token'] ?? ''));

    if ($token === '') {
        jsonResponse([
            'success' => false,
            'error' => 'Missing login token.'
        ], 400);
    }

    $user = findUserByLoginToken($token);

    if (!$user) {
        jsonResponse([
            'success' => false,
            'error' => 'Invalid login token.'
        ], 403);
    }

    if (empty($user['uid'])) {
        jsonResponse([
            'success' => false,
            'error' => 'User UID missing for login token.'
        ], 500);
    }

    if (($user['fields']['is_banned']['booleanValue'] ?? false) === true) {
        jsonResponse([
            'success' => false,
            'error' => 'You are banned.'
        ], 403);
    }

    $factory = (new Factory())->withServiceAccount(FIREBASE_CREDENTIALS_PATH);
    $auth = $factory->createAuth();

    // IMPORTANT: this must be the registered user's real Firebase Auth UID
    $customToken = $auth->createCustomToken($user['uid']);

    jsonResponse([
        'success' => true,
        'customToken' => $customToken->toString(),
        'uid' => $user['uid'],
        'doc_uid' => $user['doc_uid'],
    ]);
} catch (Throwable $e) {
    jsonResponse([
        'success' => false,
        'error' => $e->getMessage(),
    ], 500);
}