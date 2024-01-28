<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M3T Talent Management</title>
    <link href="styles/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php
if($_SERVER["REQUEST_METHOD"] == "GET") {
    ?>
    <div class="login-container">
        <div class="login-header">
            <h2>M3T Talent Management</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"  class="login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <div class="create-account-link">
                <p>Don't have an account? <a href="/register.php">Create one</a></p>
            </div>
        </form>
    </div>

<?php
} else if($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        if (empty($username) || empty($password)) {
            throw new Exception("Username and password are required.");
        }
        $conn = new PDO("mysql:host=127.0.0.1:3306;dbname=m3t-web;charset=utf8", "eagle", "EagleEye11213");
        $stmt = $conn->prepare("SELECT * FROM users WHERE Username LIKE :username LIMIT 1;");
        $stmt->bindParam('username', $username);
        $stmt->execute();
        $stmt->closeCursor();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user || !password_verify($password, $user['Password'])) {
            throw new Exception("Invalid username or password.");
        } else {
            $_SESSION["id"] =  $user["id"];
            header("Location: index.php");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "FORBIDDEN!";
}
?>
