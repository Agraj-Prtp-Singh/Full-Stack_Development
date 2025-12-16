<?php 

// Initialize variables
$name = $email = $password = $confirm = "";
$nameErr = $emailErr = $passwordErr = $confirmErr = "";
$errors = [];
$success = "";

// Function to clean user input
function test_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* ---------- Name Validation ---------- */
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    /* ---------- Email Validation ---------- */
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    /* ---------- Password Validation ---------- */
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } elseif (strlen($_POST["password"]) < 8) {
        $passwordErr = "Password must be at least 8 characters";
    } elseif (!preg_match("/[@!%*#?]/", $_POST["password"])) {
        $passwordErr = "Password must include at least one special character";
    } else {
        $password = test_input($_POST["password"]);
    }

    /* ---------- Confirm Password Validation ---------- */
    if (empty($_POST["confirm_password"])) {
        $confirmErr = "Confirm password is required";
    } elseif ($_POST["password"] !== $_POST["confirm_password"]) {
        $confirmErr = "Passwords do not match";
    } else {
        $confirm = test_input($_POST["confirm_password"]);
    }

    /* ---------- Final Validation ---------- */
    if (
        empty($nameErr) &&
        empty($emailErr) &&
        empty($passwordErr) &&
        empty($confirmErr)
    ) {

        $file = "users.json";

        // Create file if not exists
        if (!file_exists($file)) {
            if (file_put_contents($file, json_encode([])) === false) {
                $errors[] = "Unable to create user file.";
            }
        }

        // Read existing users
        $data = file_get_contents($file);
        if ($data === false) {
            $errors[] = "Unable to read user data.";
        } else {
            $users = json_decode($data, true);
            if (!is_array($users)) {
                $users = [];
            }
        }

        // Check for duplicate email
        foreach ($users as $user) {
            if (strtolower($user["email"]) === strtolower($email)) {
                $emailErr = "Email already registered";
                break;
            }
        }

        // Save user
        if (empty($emailErr) && empty($errors)) {
            $newUser = [
                "name"     => $name,
                "email"    => $email,
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ];

            $users[] = $newUser;

            if (file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT)) === false) {
                $errors[] = "Error saving user data.";
            } else {
                $success = "Registration successful!";
                $name = $email = $password = $confirm = "";
            }
        }
    }
}
?>


<!-- //Error -->

<?php if (!empty($errors)) : ?>
    <div style="color:red; border:1px solid red; padding:10px;">
        <?php foreach ($errors as $err) : ?>
            <p><?= $err ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- //Success -->
<?php if (!empty($success)) : ?>
    <div style="color:green; border:1px solid green; padding:10px;">
        <?= $success ?>
    </div>
<?php endif; ?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workshop 4</title>
</head>
<body>
    <h1>User Registration</h1>
    <form method = "post">
        <!-- name -->
        <label>Name</label>
        <br>
        <input type="text" name="name" value="<?= $name ?>">
        <span style="color:red"><?= $nameErr ?></span>

        <br>
        <br>
        <label>Email</label>
        <br>
<input type="email" name="email" value="<?= $email ?>">
<span style="color:red"><?= $emailErr ?></span>     <br>
        <br>
        <label>Password</label>
        <br>
<input type="password" name="password">
<span style="color:red"><?= $passwordErr ?></span>      <br>
        <br>
        <label>Confirm Password</label>
        <br>
        <br>
<input type="password" name="confirm_password">
<span style="color:red"><?= $confirmErr ?></span>       <br>
        <br>
        <input type="submit">


    </form>

</body>
</html>