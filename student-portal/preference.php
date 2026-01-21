<?php
if (isset($_POST['theme'])) {
    setcookie("theme", $_POST['theme'], time() + 86400 * 30);
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<body>
<h2>Select Theme</h2>

<form method="POST">
    <select name="theme">
        <option value="light">Light Mode</option>
        <option value="dark">Dark Mode</option>
    </select>
    <button>Save</button>
</form>
</body>
</html>
