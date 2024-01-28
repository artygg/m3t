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
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" required>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
            <div class="create-account-link">
                <p>Have an account? <a href="/login.php">Login</a></p>
            </div>
        </form>
    </div>

<?php
} else if($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        $username = strtolower(htmlspecialchars($_POST["username"]));
        $conn = new PDO("mysql:host=127.0.0.1:3306;dbname=m3t-web;charset=utf8", "eagle", "EagleEye11213");
        $stmt= $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1;");
        $stmt->bindParam(username, $username);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        if($rowCount > 0) {
            echo "Choose another username";
            throw new Exception("Username must be unique!");
        }
        $result = $stmt->fetch();
        print_r($result);
        $stmt->closeCursor();

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
        if (empty($username) || empty($password) || empty($name) || empty($surname)) {
            throw new Exception("All fields are required.");
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            throw new Exception("Invalid username. Use only letters, numbers, and underscores.");
        }
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long.");
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (Username, Password, Name, Surname) VALUES (:username, :password, :name, :surname)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->execute();
        $_SESSION["auth"] = true;
        header("Location: index.php");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "FORBIDDEN!";
}
?>
