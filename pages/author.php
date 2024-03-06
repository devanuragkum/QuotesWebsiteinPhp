<?php
session_start();

include __DIR__.'/../includes/db_connection.php';
include __DIR__.'/../includes/functions.php';
include __DIR__.'/../templates/header.php';

?>

<div class="about" style="padding-top:20px">

<?php


$request_uri = $_SERVER['REQUEST_URI'];

// Fetch categories from the database
$sql = "SELECT author FROM quotes WHERE author IS NOT NULL AND author <> '' GROUP BY author HAVING COUNT(*) > 5";

$resultCategory = $conn->query($sql);

// Check if categories are found
if ($resultCategory->num_rows > 0) {
    // Loop through categories and display them
    while ($row = $resultCategory->fetch_assoc()) {
        $authorName = $row['author'];
        $authorName = str_replace(' ', '-', $authorName);
        echo 
        "<div class='category-card'>".
            "<!--<img class='category-image' src='{$authorName}.jpg' alt='{$authorName}'>".
            "<div class='category-title'></div>-->".
            "<a href='/author/{$authorName}' class='category-link'>{$authorName}</a>".
        "</div>";

    }
} else {
    echo "No authors found.";
}

?>

</div>

<?php
include __DIR__.'/../templates/footer.php'; 

?>
