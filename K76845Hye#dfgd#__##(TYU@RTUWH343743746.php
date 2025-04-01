<?php


// $data = "==================== Date: " . date('d-m-Y h:i A') . " =========================\n";
// $data .= "HTTP_REFERER: \"" . print_r($_SERVER['HTTP_REFERER'], true) . "\"\n";
// file_put_contents("text-files/log_broucher.txt", print_r($_SERVER['HTTP_REFERER'], true), FILE_APPEND);


// $headers = getallheaders(); // Get all headers

// $logFile = 'headers_log.txt'; // Log file path

// $logData = "[" . date("Y-m-d H:i:s") . "]\n" . print_r($headers, true) . "\n\n";

// // Append headers data to the log file
// file_put_contents("text-files/log_broucher.txt", $logData, FILE_APPEND);

// // echo "Headers logged successfully.";


$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'No referer';

// Get all request headers
$headers = getallheaders();

// Capture request data
$request_data = [
    'GET' => $_GET,
    'POST' => $_POST,
    'REQUEST' => $_REQUEST,
    'FILES' => $_FILES,
    'SERVER' => $_SERVER
];

// Prepare log data
$logData = "[" . date("Y-m-d H:i:s") . "]\n";
$logData .= "HTTP_REFERER: " . $referer . "\n";
$logData .= "HEADERS: " . print_r($headers, true) . "\n";
$logData .= "REQUEST DATA: " . print_r($request_data, true) . "\n\n";

// Log to a file
file_put_contents("text-files/log_broucher.txt", $logData, FILE_APPEND);

// // Print to screen for debugging
// echo "<pre>";
// echo "HTTP_REFERER: " . $referer . "\n";
// echo "HEADERS:\n";
// print_r($headers);
// echo "\nREQUEST DATA:\n";
// print_r($request_data);
// echo "</pre>";