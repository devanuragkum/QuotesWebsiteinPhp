<?php

ini_set('display_errors', 1);
// Check if the admin is authenticated
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header("Location: /adminlogin");
    exit();
}



require_once __DIR__.'/../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(!empty($_POST["quote_id"]) && !empty($_POST["quote_id"]))
        {
            
             $quoteId = $_POST["quote_id"];
             $action = $_POST["action"]; // "approve" or "reject" 
        
            approval($conn,$quoteId,$action);
        }else if(!empty($_POST["quotes"]) && !empty($_POST["category"])){
            
            processQuotes($conn);
        }
        
        
}
// Fetch unapproved quotes from the database
$sql = "SELECT * FROM quotes WHERE status='pendingapproval'";
$result = $conn->query($sql);



function approval($conn,$quoteId,$action) {
        
        // Update the status of the quote in the database
        if($quoteId && $action == 'approve'){
            $updateSql = "UPDATE quotes SET status = '$action' WHERE id = $quoteId";
        }else if($quoteId && $action == 'reject'){
            $updateSql = "DELETE FROM quotes WHERE id = $quoteId";
        }
        
        $conn->query($updateSql);
}


function processQuotes($conn){

    // Get quotes from form
    $quotes = trim($_POST["quotes"]);
    
    // Split quotes into lines
    $quoteLines = explode("\n", $quotes);
    
    // Loop through each line
    foreach ($quoteLines as $line) {
        // Remove extra spaces and trim the line
        $line = trim(preg_replace('/\s+/', ' ', $line));
    
        // Check if line is empty or invalid format
        if (empty($line) || !strpos($line, '|')) {
            continue;
        }
    
        // Separate quote and author
        list($quote, $author) = explode('|', $line, 2);
    
        // Trim quote and author
        $quote = trim($quote);
        $author = trim($author);
        $category = $_POST["category"]; // Add this line
        
        // Check if quote already exists
        $sql_check = "SELECT id FROM quotes WHERE quote = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $quote);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        // If quote already exists, skip insertion
        if ($result_check->num_rows > 0) {
            // Handle the case where the quote already exists, for example, you might display an error message.
            // In this example, I'm just exiting the script.
           continue;  
        }

    
        // Author lookup query
        $sql = "SELECT id FROM author WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $author);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Check if author exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $authorId = $row["id"];
        } else {
            // Insert new author
            $sql = "INSERT INTO author (name) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $author);
            $stmt->execute();
            $authorId = $conn->insert_id;
        }
        
        $approvalStatus = 'approve';
        
        $sql = "INSERT INTO quotes (quote, author, author_id, category,status) VALUES (?, ?, ?, ?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiss", $quote, $author, $authorId, $category, $approvalStatus); // Add $category to bind_param
        $stmt->execute();
    
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
     <!-- Add CSS styling -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h2 {
            color: #333;
        }

        p {
            color: #555;
        }

        nav {
            background-color: #444;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
            width: 100%;
        }

        nav a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            margin: 0 10px;
        }

        nav a:hover {
            background-color: #555;
        }
                
                
        .quote-container {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        blockquote {
            font-size: 16px;
            margin: 0;
            padding: 0;
        }
        
        form {
            margin-top: 10px;
        }
        
        .action-button {
            background-color: #007bff;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        
        .action-button:hover {
            background-color: #0056b3;
        }
        
        .approve-button {
            background-color: #28a745;
        }
        
        .reject-button {
            background-color: #dc3545;
        }
        
        
        h1 {
          text-align: center;
          margin-bottom: 20px;
        }
        
        
        textarea {
          width: 900px; /* Set width to 700px */
          height: 250px;
          border: 1px solid #ccc;
          border-radius: 4px;
          padding: 10px; /* Add padding for textarea */
          font-size: 16px;
        }
        
        select {
          width: 200px; /* Adjust width as needed */
          border: 1px solid #ccc;
          border-radius: 4px;
          padding: 5px 10px; /* Add padding for select */
          font-size: 16px;
        }
        
        button {
          background-color: #4CAF50;
          color: white;
          border: none;
          padding: 10px 20px; /* Add padding for button */
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          border-radius: 4px;
          cursor: pointer;
        }
        
        button:hover {
          background-color: #45a049;
        }


    </style>
</head>
<body>
    <h2>Admin Panel</h2>
  
    <nav>
        <a href="/">Home</a>
        <a href="/adminpanel">Admin Panel</a>
        <a href="/adminlogout">Logout</a>
        <!-- Add more navigation links as needed -->
    </nav>
    <h2>Add New Quotes</h2>
    
    <form action="/adminpanel" method="post">
        <textarea name="quotes" rows="10" placeholder="Enter quotes one per line (Quote - Author)"></textarea>
        <br>
        <select name="category">
          <?php
            // Connect to database (same as process.php)
            // Fetch unique categories from quotes table
            $sql = "SELECT DISTINCT category FROM quotes";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $category = $row["category"];
                echo "<option value='$category'>$category</option>";
              }
            }
          ?>
        </select>
        <br>
        <button type="submit">Submit Quotes</button>
    </form>
    
    <h1>Approve Submitted Quotes</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            echo "<div class='quote-container'>";
            echo "<blockquote>{$row['quote']} - {$row['author']}</blockquote>";
            echo "<form action='/adminpanel' method='post'>";
            echo "<input type='hidden' name='quote_id' value='{$row['id']}'>";
            echo "<button class='action-button approve-button' type='submit' name='action' value='approve'>Approve</button>";
            echo "<button class='action-button reject-button' type='submit' name='action' value='reject'>Reject</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "No unapproved quotes.";
    }

    $conn->close();
    ?>
</body>
</html>
