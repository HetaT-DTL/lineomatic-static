<?php
include('mailer.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    if (!isset($_POST['g-recaptcha-response'])) {
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

    // $captchaToken = $_POST['g-recaptcha-response'];
    // $result = validateRecaptcha($captchaToken);
    // if ($result === 0) {
    //     // Recaptcha verification failed
    //     customAddLog("Error - [recaptcha validateRecaptcha error]", print_r($_POST, true));
    //     header("Location: " . $_POST['redirect_url'] . "?error=1");
    //     exit;
    // }

    $exhibition = senatize_post_input($_POST['exhibition'], 'string');
    $company_name = senatize_post_input($_POST['company_name'], 'string');
    $first_name = senatize_post_input($_POST['first_name'], 'string');
    $last_name = senatize_post_input($_POST['last_name'], 'string');
    $address = senatize_post_input($_POST['address'], 'varchar');
    $city = senatize_post_input($_POST['city'], 'string');
    $state = senatize_post_input($_POST['state'], 'string');
    $zip = senatize_post_input($_POST['zip'], 'number');
    $country = senatize_post_input($_POST['country'], 'string');
    $code = senatize_post_input($_POST['code'], 'number');
    $phone = senatize_post_input($_POST['phone'], 'number');
    $mobile = senatize_post_input($_POST['mobile'], 'number');
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $date = senatize_post_input($_POST['date'], 'number');
    $interested_products = isset($_POST['interested_products']) ? implode(", ", $_POST['interested_products']) : '';
    $interested_products = senatize_post_input($interested_products, 'varchar');
    $message = senatize_post_input($_POST['message'], 'varchar');



    if (empty($exhibition) && empty($company_name) && empty($first_name) && empty($last_name) && empty($address) && empty($city) && empty($state) && empty($zip) && empty($country) && empty($code) && empty($phone) && empty($mobile) && empty($email) && empty($date) && empty($interested_products) && empty($message)) {
        customAddLog("Error - [On php side input validation er]", print_r($_POST, true));
        $_SESSION['error_msg'] = "Something went to wrong, please try again.";
    } else {
        $data = "==================== Date: " . date('d-m-Y h:i A') . " =========================\n";
        $data .= "Exhibition: " . $exhibition . "\n";
        $data .= "Company Name: " . $company_name . "\n";
        $data .= "First Name: " . $first_name . "\n";
        $data .= "Last Name: " . $last_name . "\n";
        $data .= "Address: " . $address . "\n";
        $data .= "City: " . $city . "\n";
        $data .= "State: " . $state . "\n";
        $data .= "Zip: " . $zip . "\n";
        $data .= "Country: " . $country . "\n";
        $data .= "Pin Code: " . $code . "\n";
        $data .= "Phone: " . $phone . "\n";
        // $data .= "Phone Number: ". "Pin Code:" .$code." Phone : " . $phone . "\n";
        $data .= "Mobile Number: " . $mobile . "\n";
        $data .= "Email: " . $email . "\n";
        $data .= "Date: " . $date . "\n";
        $data .= "Interested Products: " . $interested_products . "\n";
        $data .= "Message: \"" . $message . "\"\n";
        $data .= "=============================================\n\n";

        $file = "text-files/exhibition_details.txt";
        file_put_contents($file, $data, FILE_APPEND);
        customAddLog("Success - [After file_put_contents]", print_r($data, true));
        
        $bodyHTML = '<img src ="https://www.lineomatic.com/assets/images/inner-page-logo.png">
            <br>
            <br>
                
            Hello Admin!<br><br>
                
            <table order=1>
                <tr>
                    <td>Exhibition
                    </td>
                    <td>' . $exhibition . '
                    </td>
                </tr>
                <tr>
                    <td>Company Name
                    </td>
                    <td>' . $company_name . '
                    </td>
                </tr>
                <tr>
                    <td>Name
                    </td>
                    <td>' . $first_name . " " . $last_name . '
                    </td>
                </tr>
                <tr>
                    <td>Address
                    </td>
                    <td>' . $address . '
                    </td>
                </tr>
                <tr>
                    <td>City
                    </td>
                    <td>' . $city . '
                    </td>
                </tr>
                <tr>
                    <td>State
                    </td>
                    <td>' . $state . '
                    </td>
                </tr>
                <tr>
                    <td>Zip
                    </td>
                    <td>' . $zip . '
                    </td>
                </tr>
                <tr>
                    <td>Country
                    </td>
                    <td>' . $country . '
                    </td>
                </tr>
                <tr>
                    <td>Phone Number
                    </td>
                    <td>' . $code . " " . $phone . '
                    </td>
                </tr>
                <tr>
                    <td>Mobile
                    </td>
                    <td>' . $mobile . '
                    </td>
                </tr>
                <tr>
                    <td>Email
                    </td>
                    <td>' . $email . '
                    </td>
                </tr>
                <tr>
                    <td>Date
                    </td>
                    <td>' . $date . '
                    </td>
                </tr>
                <tr>
                    <td>Interested Products
                    </td>
                    <td>' . $interested_products . '
                    </td>
                </tr>
                
            </table>
            <br><br>
            Team<br>
            Lineomatic
            ';
        $mail = sendMailSMTP('Pre-registration for event request received', 'info@lineomatic.com', $bodyHTML);

        $bodyHTML = '<img src ="https://www.lineomatic.com/assets/images/inner-page-logo.png">
            <br>
            <br>
                
            Hello ' . $first_name . " " . $last_name . '!<br><br>
                
            Thank you for pre-registring your visit.<br><br>
                
            Looking forward to our meeting.<br><br>
                
            Team<br>
            Lineomatic
            ';
        $mail = sendMailSMTP('Thank you for pre-registring your visit', $email, $bodyHTML);
        customAddLog("Success - [After sendMailSMTP]", print_r($data, true));
        
        $_SESSION['success_msg'] = "Your message submitted successfully.";
        header("Location: " . $_POST['redirect_url'] . "?success=1");
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
    $logFile = "{$logDir}/{$todayFolder}_exhibition_log.txt";

    if (!file_exists($logDir)) {
        mkdir($logDir, 0750, true);
    }

    // $time = date('Y-m-d H:i:s');
    $logEntry = '[' . date('d-m-Y H:i A') . ']' . '[' . $logType . ']' . $logData;

    file_put_contents($logFile, $logEntry, FILE_APPEND);
}
