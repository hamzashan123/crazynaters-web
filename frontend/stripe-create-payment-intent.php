<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$amount = isset($input['amount']) ? (int) round(((float) $input['amount']) * 100) : 0;
$email = isset($input['email']) ? trim((string) $input['email']) : '';
$uid = isset($input['uid']) ? trim((string) $input['uid']) : '';

// if (!in_array($amount, [100, 200], true)) {
//     http_response_code(422);
//     echo json_encode(['error' => 'Invalid plan amount']);
//     exit;
// }
$stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'];


$payload = [
    'amount' => $amount,
    'currency' => 'usd',
    'automatic_payment_methods[enabled]' => 'true',
    'metadata[uid]' => $uid,
    'metadata[email]' => $email,
    'metadata[product]' => 'private_chatroom_access'
];

$ch = curl_init('https://api.stripe.com/v1/payment_intents');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD => $stripeSecretKey . ':',
    CURLOPT_POSTFIELDS => http_build_query($payload),
    CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => $curlError ?: 'Stripe request failed']);
    exit;
}

$data = json_decode($response, true);
if ($httpCode >= 400 || empty($data['client_secret'])) {
    http_response_code($httpCode ?: 500);
    echo json_encode(['error' => $data['error']['message'] ?? 'Unable to create payment intent']);
    exit;
}

echo json_encode([
    'clientSecret' => $data['client_secret'],
    'paymentIntentId' => $data['id'] ?? ''
]);
