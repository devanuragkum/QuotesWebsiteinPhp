<?php
include __DIR__.'/includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quoteId = htmlspecialchars($conn->real_escape_string($_POST['quote_id']));

    // Update the love count in the database
    $query = "UPDATE quotes SET love = love + 1 WHERE id = $quoteId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch the updated love count
    $query = "SELECT love FROM quotes WHERE id = $quoteId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    $loveCount = $row['love'];

    echo json_encode(['success' => true, 'loveCount' => $loveCount]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
