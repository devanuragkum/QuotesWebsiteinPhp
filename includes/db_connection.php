<?php
$servername = "localhost";
$username = "contezsg_qtvally";
$password = "qtVally334464%##ggDDD@@@18!!@TT";
$database = "contezsg_quotesvalley";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
