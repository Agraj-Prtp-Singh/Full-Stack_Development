<?php
require 'db.php';

$message = '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        $password = $_POST['password'];

        if(!$email) {
            $message = "Please enter a valid email address";
        }

        elseif (empty($password)) {
            $message = "Password cannot be empty.";
        }

        elseif (strlen($password) < 8) {
            $message = "Password must be at least eight characters long.";
        }

        else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email, $hashedPassword]);

        $message = "User signed up successfully";
        header('refresh:2; url=login.php');
    }
    }

} catch (Exception $e) {
    $message = "Something went wrong.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<body>

<h2>Signup</h2>

<?php if ($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="text" name="email"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Signup</button>
</form>

<br>
<a href="login.php">Go to Login</a>

</body>
</html>
