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

    $captchaToken = $_POST['g-recaptcha-response'];
    $result = validateRecaptcha($captchaToken);
    if ($result === 0) {
        // Recaptcha verification failed
        customAddLog("Error - [recaptcha validateRecaptcha error]", print_r($_POST, true));
        header("Location: " . $_POST['redirect_url'] . "?error=1");
        exit;
    }

    $job_post = senatize_post_input($_POST['job_post'], 'string');
    $fname = senatize_post_input(($_POST['fname']), 'string');
    $lname = senatize_post_input(($_POST['lname']), 'string');
    $address = senatize_post_input($_POST['address'], 'varchar');
    $city = senatize_post_input(($_POST['city']), 'string');
    $state = senatize_post_input($_POST['state'], 'string');
    $zip = senatize_post_input($_POST['zip'], 'number');
    $country = senatize_post_input($_POST['country'], 'string');
    $p_code = senatize_post_input($_POST['p_code'], 'number');
    $phone = senatize_post_input($_POST['phone'], 'number');
    $mobile = senatize_post_input($_POST['mobile'], 'number');
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $dob = senatize_post_input($_POST['dob'], 'number');
    $present_company = senatize_post_input($_POST['present_company'], 'string');
    $present_job_location = senatize_post_input($_POST['present_job_location'], 'string');
    $present_job_description = senatize_post_input($_POST['present_job_description'], 'string');
    $notice_period = senatize_post_input($_POST['notice_period'], 'string');
    $present_designation = senatize_post_input($_POST['present_designation'], 'string');
    $qualification = senatize_post_input($_POST['qualification'], 'string');
    $t_exp = senatize_post_input($_POST['t_exp'], 'number');
    $p_ctc = senatize_post_input($_POST['p_ctc'], 'number');
    $post_apply = senatize_post_input($_POST['post_apply'], 'string');
    $e_ctc = senatize_post_input($_POST['e_ctc'], 'number');
    $message = senatize_post_input($_POST['message'], 'varchar');

    if (empty($job_post) && empty($fname) && empty($lname) && empty($address) && empty($city) && empty($state) && empty($zip) && empty($country) && empty($p_code) && empty($phone) && empty($mobile) && empty($email) && empty($dob) && empty($present_company) && empty($present_job_location) && empty($present_job_description) && empty($notice_period) && empty($present_designation) && empty($qualification) && empty($t_exp) && empty($p_ctc) && empty($post_apply) && empty($e_ctc) && empty($message)) {
        customAddLog("Error - [On php side input validation er]", print_r($_POST, true));
        $_SESSION['error_msg'] = "Something went to wrong, please try again.";
    } else {
        $data = "==================== Date: " . date('d-m-Y h:i A') . " =========================\n";
        $data .= "Job Post: " . $job_post . "\n";
        $data .= "First Name: " . $fname . "\n";
        $data .= "Last Name: " . $lname . "\n";
        $data .= "Address: " . $address . "\n";
        $data .= "City: " . $city . "\n";
        $data .= "State: " . $state . "\n";
        $data .= "Zip: " . $zip . "\n";
        $data .= "Country: " . $country . "\n";
        $data .= "Phone Code: " . $p_code . "\n";
        $data .= "Phone Number: " . $phone . "\n";
        $data .= "Mobile Number: " . $mobile . "\n";
        $data .= "Email: " . $email . "\n";
        $data .= "Birth Date: " . $dob . "\n";
        $data .= "Present Company: " . $present_company . "\n";
        $data .= "Present Job Location: " . $present_job_location . "\n";
        $data .= "Present Job Description / Role Responsibilities: " . $present_job_description . "\n";
        $data .= "Notice Period: " . $notice_period . "\n";
        $data .= "Present Designation: " . $present_designation . "\n";
        $data .= "Qualification: " . $qualification . "\n";
        $data .= "Total exp in Yrs: " . $t_exp . "\n";
        $data .= "Present CTC: " . $p_ctc . "\n";
        $data .= "Post Apply For: " . $post_apply . "\n";
        $data .= "Expected CTC: " . $e_ctc . "\n";
        $data .= "Message: \"" . $message . "\"\n";
        $data .= "=============================================\n\n";

        $file = "text-files/career_details.txt";
        file_put_contents($file, $data, FILE_APPEND);
        customAddLog("Success - [After file_put_contents]", print_r($data, true));

        $bodyHTML = '<img src ="https://www.lineomatic.com/assets/images/inner-page-logo.png">
            <br>
            <br>

            Hello Admin!<br><br>

            <table order=1>
                <tr>
                        <td>Name
                        </td>
                        <td>' . $fname . " " . $lname . '
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
                        <td>' . $p_code . " " . $phone . '
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
                        <td>Birth Date
                        </td>
                        <td>' . $dob . '
                        </td>
                    </tr>
                    <tr>
                        <td>Present Company
                        </td>
                        <td>' . $present_company . '
                        </td>
                    </tr>
                    <tr>
                        <td>Present Designation
                        </td>
                        <td>' . $present_designation . '
                        </td>
                    </tr>
                    <tr>
                        <td>Qualification
                        </td>
                        <td>' . $qualification . '
                        </td>
                    </tr>
                    <tr>
                        <td>Total exp in Yrs
                        </td>
                        <td>' . $t_exp . '
                        </td>
                    </tr>
                    <tr>
                        <td>Present CTC
                        </td>
                        <td>' . $p_ctc . '
                        </td>
                    </tr>
                    <tr>
                        <td>Post Apply For
                        </td>
                        <td>' . $post_apply . '
                        </td>
                    </tr>
                    <tr>
                    <td>Expected CTC
                    </td>
                    <td>' . $e_ctc . '
                    </td>
                </tr>
                <tr>
                    <td>Recent Photograph
                    </td>
                    <td><a href="' . str_replace('+', ' ', $photoUrl) . '">Photo</a>
                    </td>
                </tr>
                <tr>
                    <td>Resume
                    </td>
                    <td><a href="' . str_replace('+', ' ', $resumeUrl) . '">Resume</a>
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
            Lineomatic';

        $mail = sendMailSMTP('New career request', 'info@lineomatic.com', $bodyHTML);

        $bodyHTML = '<img src ="https://www.lineomatic.com/assets/images/inner-page-logo.png">
            <br>
            <br>
                
            Hello ' . $fname . " " . $lname . '!<br><br>
                
            Thank you for showing trust in us.<br><br>
                
            We\'ll follow up on this shortly.<br><br>
                
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

    customAddLog('[' . date('d-m-Y H:i A') . ']' . '[recaptcha response validateRecaptcha >>]' , print_r($response, true));

    if ($response && isset($response->success) && $response->success === 1) { //&& $response->score >= $scoreThreshold
        return 1; // Verification successful
    }

    return 0; // Verification failed
}

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
    $logFile = "{$logDir}/{$todayFolder}_career_log.txt";

    if (!file_exists($logDir)) {
        mkdir($logDir, 0750, true);
    }

    // $time = date('Y-m-d H:i:s');
    $logEntry = '[' . date('d-m-Y H:i A') . ']' . '[' . $logType . ']' . $logData;

    file_put_contents($logFile, $logEntry, FILE_APPEND);
}
