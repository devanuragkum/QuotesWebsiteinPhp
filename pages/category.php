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
$sql = "SELECT DISTINCT category FROM quotes WHERE category IS NOT NULL AND category <> '' GROUP BY category HAVING COUNT(*) > 5";
$resultCategory = $conn->query($sql);

// Check if categories are found
if ($resultCategory->num_rows > 0) {
    // Loop through categories and display them
    while ($row = $resultCategory->fetch_assoc()) {
        $categoryName = $row['category'];
        $categoryName = str_replace(' ', '-', $categoryName);
        echo 
        "<div class='category-card'>".
            "<!--<img class='category-image' src='{$categoryName}.jpg' alt='{$categoryName}'>".
            "<div class='category-title'></div>-->".
            "<a href='/category/{$categoryName}' class='category-link'>{$categoryName}</a>".
        "</div>";

    }
} else {
    echo "No categories found.";
}

?>

</div>

<?php
include_once __DIR__.'/../templates/footer.php'; 

?>
