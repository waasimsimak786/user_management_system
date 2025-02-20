<?php
include "db.php";
require "vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "your_secret_key";
$headers = getallheaders();

if (!isset($headers["Authorization"])) {
    echo json_encode(["message" => "Access denied"]);
    exit;
}

$token = str_replace("Bearer ", "", $headers["Authorization"]);

try {
    $decoded = JWT::decode($token, new Key($secret_key, "HS256"));
    $query = "SELECT first_name, last_name, user_id FROM users";
    $stmt = $conn->query($query);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
} catch (Exception $e) {
    echo json_encode(["message" => "Invalid token"]);
}
?>
