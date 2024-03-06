<?php
session_start();
include './includes/db_connection.php';
include './includes/functions.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Validate the submitted mathematical CAPTCHA
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $userCaptcha = isset($_POST["captcha"]) ? htmlspecialchars($_POST["captcha"]) : '';

    if (!is_numeric($userCaptcha) || $userCaptcha != $_SESSION['math_captcha']) {
        die("CAPTCHA verification failed. Please prove you are human.");
    }

    $quote = htmlspecialchars($conn->real_escape_string($_POST["quote"]));
    $author = htmlspecialchars($conn->real_escape_string($_POST["author"]));
    $category = htmlspecialchars($conn->real_escape_string($_POST["category"]));
    $status ='pendingapproval';

    // Use prepared statement to insert the quote into the database
    $stmt = $conn->prepare("INSERT INTO quotes (quote, author,status,category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $quote, $author, $status,$category);

    if ($stmt->execute()) {
        echo "Quote submitted successfully.It will show on website only after approval";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>
