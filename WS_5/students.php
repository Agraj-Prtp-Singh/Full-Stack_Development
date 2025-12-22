<?php
require "includes/header.php";

if (file_exists("students.txt")) {
    $lines = file("students.txt");

    foreach ($lines as $line) {
        list($name, $email, $skills) = explode("|", trim($line));
        $skillsArray = explode(",", $skills);

        echo "<p>";
        echo "<strong>Name:</strong> $name<br>";
        echo "<strong>Email:</strong> $email<br>";
        echo "<strong>Skills:</strong> ";
        echo implode(",",$skillsArray);
        echo "</p><hr>";
    }
} else {
    echo "<p>No students found.</p>";
}

require "includes/footer.php";
?>
