<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_id = $_POST['user_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (first_name, last_name, user_id, password_hash) VALUES (:first_name, :last_name, :user_id, :password)";
    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
            ":first_name" => $first_name,
            ":last_name" => $last_name,
            ":user_id" => $user_id,
            ":password" => $password
        ]);
        // Redirect to the login page after successful registration
        header("Location: login.html");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
