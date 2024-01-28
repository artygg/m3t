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
                <p>Don't have an account? <a href="/signup">Create one</a></p>
            </div>
        </form>
    </div>

<?php
} else if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtolower(htmlspecialchars($_POST["username"]));
    $conn = new PDO("mysql:host=mysql;dbname=m3t-web;charset=utf8", "eagle", "EagleEye11213");
    $stmt= $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1;");
    $stmt->bindParam(username, $username);
    $stmt->execute();
    $result = $stmt->fetch();
    print_r($result);
    $stmt->closeCursor();
    print_r($result);
} else {
    echo "FORBIDDEN!";
}
?>
