<?php
function validateRecaptcha($response, $scoreThreshold = 0.5)
{
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => '6LdMgfoUAAAAAEUgJiTB-Ictrvhb4TbqGSmMM-gI',
        'response' => $response
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    // echo '<pre>';
    // print_r( $response);
    // print_r( $_REQUEST);
    // echo '</pre>';

    // file_put_contents("text-files/log_broucher.txt", '[' . date('d-m-Y H:i A') . ']' . '[recaptcha response]' . print_r($response, true), FILE_APPEND);
    customAddLog('recaptcha response', print_r($response, true));

    if ($response && isset($response->success) && $response->success === 1) { //&& $response->score >= $scoreThreshold
        return 1; // Verification successful
    }

    return 0; // Verification failed
}

//1.
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
// file_put_contents("text-files/log_broucher.txt", '[' . date('d-m-Y H:i A') . ']' . '[headers and request data]' . $logData, FILE_APPEND);
customAddLog('headers and request data', $logData);

$captchaToken = $_POST['g-recaptcha-response'];
$result = validateRecaptcha($captchaToken);
if ($result === 1) {
    // Recaptcha verification successful
    // file_put_contents("text-files/log_broucher.txt", '[' . date('d-m-Y H:i A') . ']' . '[recaptcha verification successful]' . $logData, FILE_APPEND);
    customAddLog('recaptcha verification successful', $logData);
}



function customAddLog($logType, $logData) {
    $baseLogDir = '/home/lineomat/lineomatic_logs';   
    $todayFolder = date('Y-m-d');                
    $logDir = "{$baseLogDir}/{$todayFolder}";    
    $logFile = "{$logDir}/{$todayFolder}_dfromaction.log";   

    if (!file_exists($logDir)) {
        mkdir($logDir, 0750, true);            
    }

    // $time = date('Y-m-d H:i:s');
    $logEntry = '[' . date('d-m-Y H:i A') . ']' . '[' . $logType . ']' . $logData;

    file_put_contents($logFile, $logEntry, FILE_APPEND);
}