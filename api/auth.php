<?php
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

if ($input['username'] === 'admin' && $input['password'] === 'admin') {
    $payload = [
        'username' => $input['username'],
        'exp' => time() + 3600
    ];
    $jwt = JWT::encode($payload, 'secret_key', 'HS256');
    echo json_encode(['token' => $jwt]);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
}
?>