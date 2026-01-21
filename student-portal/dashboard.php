<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

$theme = $_COOKIE['theme'] ?? "light";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>
	<style>
		body{
			background-color: <?= $theme === "dark" ? "black" : "white" ?>;
			color: <?= $theme === "dark" ? "white" : "black" ?>;
		}
	</style>
</head>
<body>

	<h2>Welcome, <?= $_SESSION['student_name'];?></h2>

<a href="preference.php">Change Theme</a> |
<a href="logout.php">Logout</a>

</body>
</html>