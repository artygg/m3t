<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=m3t-web;charset=utf8", "eagle", "EagleEye11213");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user information from the database using the stored session variable
    $userId = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Welcome, " . $user['Name'] . " " . $user['Surname'] . "!";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>