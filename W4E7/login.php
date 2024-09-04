<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;

$secret_key = 'cT4F!v9Bx8@jKlM2p3sT5q7#r8Vx1Z*5';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestBody = json_decode(file_get_contents('php://input'), true);
    if (!isset($requestBody['username']) && !isset($requestBody['password'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Missing username or password']);
        return;
    }
    $username = $requestBody["username"];
    $password = $requestBody["password"];
    $teachers = json_decode(file_get_contents('./teachers.json'), true);
    foreach ($teachers as $teacher) {
        if ($username == $teacher["username"] && $password == $teacher["password"]) {
            $issued_at = time();
            $expires_at = $issued_at + 3600;

            $payload = array(
                "iss" => "testdomain.com",
                "iat" => $issued_at,
                "exp" => $expires_at,
                "data" => array(
                    "username" => $username,
                )
            );
            $jwt = JWT::encode($payload, $secret_key, 'HS256');
            echo json_encode([
                "jwt" => $jwt,
                "message" => "Login successful"
            ]);
            return;
        }
    }
    http_response_code(401);
    echo json_encode(["message" => "Invalid username or password"]);
}