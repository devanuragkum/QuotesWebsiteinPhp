<?php
session_start();

include __DIR__.'/includes/db_connection.php';
include __DIR__.'/includes/functions.php';
//include __DIR__.'/includes/submit_quote.php';

$viewDir = '/pages/';

require __DIR__ . $viewDir . 'quotes.php';
 


?>