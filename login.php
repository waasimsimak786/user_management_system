<?php
include "db.php";
require "vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "your_secret_key";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([":user_id" => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password_hash"])) {
        $payload = [
            "user_id" => $user["user_id"],
            "exp" => time() + (60 * 60) // Token valid for 1 hour
        ];

        $jwt = JWT::encode($payload, $secret_key, "HS256");

        echo json_encode(["message" => "Login successful", "token" => $jwt]);
    } else {
        echo json_encode(["message" => "Invalid credentials"]);
    }
}
?>
