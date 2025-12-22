<?php
require "includes/header.php";
require "includes/function.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $fileName = uploadPortfolioFile($_FILES['portfolio']);
        echo "<p>File uploaded: $fileName</p>";
    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    Upload Portfolio (PDF/JPG/PNG):<br><br>
    <input type="file" name="portfolio" required><br><br>
    <button type="submit">Upload</button>
</form>

<?php require "includes/footer.php"; ?>
