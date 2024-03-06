<?php
// sitemap_generator.php


include __DIR__.'/includes/db_connection.php';

// Set the content type to XML
header('Content-Type: application/xml');

// Start the XML file
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

// Add URLs dynamically from your database or any other source
// Example: Adding a static URL
echo "<url>\n";
echo "   <loc>https://quotesvalley.com/</loc>\n";
echo "   <changefreq>daily</changefreq>\n";
echo "   <priority>1.0</priority>\n";
echo "</url>\n";

// Example: Adding URLs for categories
$queryCategories = "SELECT DISTINCT category FROM quotes";
$resultCategories = mysqli_query($conn, $queryCategories);

while ($rowCategory = mysqli_fetch_assoc($resultCategories)) {
    $category = urlencode($rowCategory['category']);
    echo "<url>\n";
    echo "   <loc>https://quotesvalley.com/category/{$category}</loc>\n";
    echo "   <changefreq>weekly</changefreq>\n";
    echo "   <priority>0.8</priority>\n";
    echo "</url>\n";
}

// Example: Adding URLs for authors
$queryAuthors = "SELECT DISTINCT author FROM quotes";
$resultAuthors = mysqli_query($conn, $queryAuthors);

while ($rowAuthor = mysqli_fetch_assoc($resultAuthors)) {
    $author = urlencode(str_replace(' ', '-', $rowAuthor['author']));
    echo "<url>\n";
    echo "   <loc>https://quotesvalley.com/author/{$author}</loc>\n";
    echo "   <changefreq>weekly</changefreq>\n";
    echo "   <priority>0.8</priority>\n";
    echo "</url>\n";
}

// Add more URLs as needed

// End the XML file
echo "</urlset>";
?>
