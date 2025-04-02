<?php

include('mailer.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    if (!isset($_POST['g-recaptcha-response']) && empty($_POST['g-recaptcha-response'])) {
        customAddLog("Error - [recaptcha g-recaptcha-response empty]", print_r($_POST, true));
        header("Location: " . $_POST['redirect_url'] . "?error=1");
        exit;
    }

    $captcha = $_POST['g-recaptcha-response'];
    $secretKey = "6LdMgfoUAAAAAEUgJiTB-Ictrvhb4TbqGSmMM-gI";
    $ip = $_SERVER['REMOTE_ADDR'];

    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);

    // should return JSON with success as true
    if (isset($responseKeys['error-codes']) && !empty($responseKeys['error-codes'])) {
        customAddLog("Error - [recaptcha error-codes set]", print_r($_POST, true));
        header("Location: " . $_POST['redirect_url'] . "?error=1");
        exit;
    }

    // $recaptchaSecretKey = "6LdMgfoUAAAAAEUgJiTB-Ictrvhb4TbqGSmMM-gI";
    // $recaptchaResponse = $_POST['g-recaptcha-response'];
    // if (validateRecaptcha($recaptchaResponse, $recaptchaSecretKey) === 0) {
    //     customAddLog("Error - [recaptcha validateRecaptcha error]", print_r($_POST, true));
    //     header("Location: " . $_POST['redirect_url'] . "?error=1");
    //     exit;
    // }

    $name = senatize_post_input($_POST['name'], 'string');
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phone = senatize_post_input($_POST['phone'], 'number');
    $state = senatize_post_input($_POST['state'], 'string');
    $country = senatize_post_input($_POST['country'], 'string');
    $pName = senatize_post_input($_POST['pName'], 'string');
    $message = senatize_post_input($_POST['message'], 'varchar');

    if (empty($name) && empty($email) && empty($phone) && empty($state) && empty($address) && empty($country) && empty($message)) {
        customAddLog("Error - [On php side input validation er]", print_r($_POST, true));
        $_SESSION['error_msg'] = "Something went to wrong, please try again.";
    } else {
        $data = "==================== Date: " . date('d-m-Y h:i A') . " =========================\n";
        $data .= "Product Name: \"" . $pName . "\"\n";
        $data .= "Name: " . $name . "\n";
        $data .= "Email: " . $email . "\n";
        $data .= "Phone: " . $phone . "\n";
        $data .= "State: " . $state . "\n";
        $data .= "Country: " . $country . "\n";
        $data .= "Message: \"" . $message . "\"\n";
        $data .= "=============================================\n\n";

        $file = "text-files/request_quote_details.txt";
        file_put_contents($file, $data, FILE_APPEND);
        customAddLog("Success - [After file_put_contents]", print_r($data, true));

        // Admin email
        $bodyHTML = '<img src ="https://www.lineomatic.com/assets/images/inner-page-logo.png">
            <br>
            <br>
                
            Hello Admin!<br><br>
                
            <table order=1>
                <tr>
                    <td>Machine
                    </td>
                    <td>' . $pName . '
                    </td>
                </tr>
                <tr>
                    <td>Name
                    </td>
                    <td>' . $name . '
                    </td>
                </tr>
                <tr>
                    <td>Email
                    </td>
                    <td>' . $email . '
                    </td>
                </tr>
                <tr>
                    <td>Phone
                    </td>
                    <td>' . $phone . '
                    </td>
                </tr>
                <tr>
                    <td>State
                    </td>
                    <td>' . $state . '
                    </td>
                </tr>
                <tr>
                    <td>Country
                    </td>
                    <td>' . $country . '
                    </td>
                </tr>
                <tr>
                    <td>Message
                    </td>
                    <td>' . $message . '
                    </td>
                </tr>
            </table>
            <br><br>
            Team<br>
            Lineomatic
            ';

        $mail = sendMailSMTP($name . ' has inquired for ' . $pName, "info@lineomatic.com", $bodyHTML);

        // Customer mail
        $bodyHTML = '<img src ="https://www.lineomatic.com/assets/images/inner-page-logo.png">
            <br>
            <br>
                
            Hello ' . $name . '!<br><br>
                
            Thank you for requesting a quote for ' . $pName . '.<br><br>
                
            We will get back to you soon with the machine details on your e-mail. <br><br>
                
            Team<br>
            Lineomatic
            ';
        $mail = sendMailSMTP('Thank for inquiring ' . $pName, $email, $bodyHTML);
        customAddLog("Success - [After sendMailSMTP]", print_r($data, true));

        $_SESSION['success_msg'] = "Your message submitted successfully.";
        header("Location: " . $_POST['redirect_url'] . "?success=1&m=raq");
    }
} else {
    $_SESSION['error_msg'] =  "Something went to wrong, please try again.";
    header("Location: " . $_POST['redirect_url'] . "?error=1");
}

function senatize_post_input($data, $type)
{
    if ($type == 'string' || $type == 'number') {
        $data = trim($data);
        $data = preg_replace('/[$&+,:;=?@#|<>.^*()%!]/', ' ', $data);
        return $data;
    } else if ($type == 'varchar') {
        $data = trim($data);
        $data = preg_replace('/[$&;#|<>.^*%!]/', ' ', $data);
        return $data;
    }
}

// function validateRecaptcha($response, $scoreThreshold = 0.5)
// {
//     $url = 'https://www.google.com/recaptcha/api/siteverify';
//     $data = [
//         'secret' => '6LdMgfoUAAAAAEUgJiTB-Ictrvhb4TbqGSmMM-gI',
//         'response' => $response
//     ];

//     $options = [
//         'http' => [
//             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//             'method'  => 'POST',
//             'content' => http_build_query($data)
//         ]
//     ];

//     $context  = stream_context_create($options);
//     $result = file_get_contents($url, false, $context);
//     $response = json_decode($result);

//     customAddLog('[' . date('d-m-Y H:i A') . ']' . '[recaptcha response validateRecaptcha >>]', print_r($response, true));

//     if ($response && isset($response->success) && $response->success === 1) { //&& $response->score >= $scoreThreshold
//         return 1; // Verification successful
//     }

//     return 0; // Verification failed
// }

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
$logEntry .= "HTTP_REFERER: " . $referer . "\n";
$logEntry .= "HEADERS: " . print_r($headers, true) . "\n";
$logEntry .= "REQUEST DATA: " . print_r($request_data, true) . "\n\n";

customAddLog("[Request headers]", $logEntry);

function customAddLog($logType, $logData)
{
    $baseLogDir = '/home/lineomat/lineomatic_logs';
    $todayFolder = date('Y-m-d');
    $logDir = "{$baseLogDir}/{$todayFolder}";
    $logFile = "{$logDir}/{$todayFolder}_brocher_log.txt";

    if (!file_exists($logDir)) {
        mkdir($logDir, 0750, true);
    }

    // $time = date('Y-m-d H:i:s');
    $logEntry = '[' . date('d-m-Y H:i A') . ']' . '[' . $logType . ']' . $logData;

    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

?>


<?php
// function validateRecaptcha($response, $scoreThreshold = 0.5)
// {
//     $url = 'https://www.google.com/recaptcha/api/siteverify';
//     $data = [
//         'secret' => '6LdMgfoUAAAAAEUgJiTB-Ictrvhb4TbqGSmMM-gI',
//         'response' => $response
//     ];

//     $options = [
//         'http' => [
//             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//             'method'  => 'POST',
//             'content' => http_build_query($data)
//         ]
//     ];

//     $context  = stream_context_create($options);
//     $result = file_get_contents($url, false, $context);
//     $response = json_decode($result);

//     // echo '<pre>';
//     // print_r( $response);
//     // print_r( $_REQUEST);
//     // echo '</pre>';

//     // file_put_contents("text-files/log_broucher.txt", '[' . date('d-m-Y H:i A') . ']' . '[recaptcha response]' . print_r($response, true), FILE_APPEND);
//     customAddLog('recaptcha response', print_r($response, true));

//     if ($response && isset($response->success) && $response->success === 1) { //&& $response->score >= $scoreThreshold
//         return 1; // Verification successful
//     }

//     return 0; // Verification failed
// }

// //1.
// $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'No referer';
// // Get all request headers
// $headers = getallheaders();
// // Capture request data
// $request_data = [
//     'GET' => $_GET,
//     'POST' => $_POST,
//     'REQUEST' => $_REQUEST,
//     'FILES' => $_FILES,
//     'SERVER' => $_SERVER
// ];
// // Prepare log data
// $logData = "[" . date("Y-m-d H:i:s") . "]\n";
// $logData .= "HTTP_REFERER: " . $referer . "\n";
// $logData .= "HEADERS: " . print_r($headers, true) . "\n";
// $logData .= "REQUEST DATA: " . print_r($request_data, true) . "\n\n";

// // Log to a file
// // file_put_contents("text-files/log_broucher.txt", '[' . date('d-m-Y H:i A') . ']' . '[headers and request data]' . $logData, FILE_APPEND);
// customAddLog('headers and request data', $logData);

// $captchaToken = $_POST['g-recaptcha-response'];
// $result = validateRecaptcha($captchaToken);
// if ($result === 1) {
//     // Recaptcha verification successful
//     // file_put_contents("text-files/log_broucher.txt", '[' . date('d-m-Y H:i A') . ']' . '[recaptcha verification successful]' . $logData, FILE_APPEND);
//     customAddLog('recaptcha verification successful', $logData);
// }



// function customAddLog($logType, $logData)
// {
//     $baseLogDir = '/home/lineomat/lineomatic_logs';
//     $todayFolder = date('Y-m-d');
//     $logDir = "{$baseLogDir}/{$todayFolder}";
//     $logFile = "{$logDir}/{$todayFolder}_dfromaction.log";

//     if (!file_exists($logDir)) {
//         mkdir($logDir, 0750, true);
//     }

//     // $time = date('Y-m-d H:i:s');
//     $logEntry = '[' . date('d-m-Y H:i A') . ']' . '[' . $logType . ']' . $logData;

//     file_put_contents($logFile, $logEntry, FILE_APPEND);
// }
