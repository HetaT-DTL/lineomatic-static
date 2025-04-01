<?php
include('mailer.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    if (!isset($_POST['g-recaptcha-response'])) {
        header("Location: " . $_POST['redirect_url'] . "?error=1");
    }
    $captcha = $_POST['g-recaptcha-response'];
    $secretKey = "6LdMgfoUAAAAAEUgJiTB-Ictrvhb4TbqGSmMM-gI";
    $ip = $_SERVER['REMOTE_ADDR'];

    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
    // should return JSON with success as true
    if ($responseKeys["success"]) {
        // echo '<h2>Thanks for posting comment</h2>';
    } else {
        header("Location: " . $_POST['redirect_url'] . "?error=1");
    }


    $name = senatize_post_input($_POST['name'], 'string');
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $dLink = filter_var(trim($_POST['dLink']), FILTER_VALIDATE_URL);
    $phone = senatize_post_input($_POST['phone'], 'number');
    $state = senatize_post_input($_POST['state'], 'string');
    $country = senatize_post_input($_POST['country'], 'string');
    $pName = senatize_post_input($_POST['pName'], 'varchar');
    $message = senatize_post_input($_POST['message'], 'varchar');



    if (empty($name) &&  empty($email) && empty($phone) && empty($state) && empty($address) && empty($country) && empty($message)) {
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

        $file = "text-files/brochure_details.txt";
        file_put_contents($file, $data, FILE_APPEND);

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

        $mail = sendMailSMTP('Brochure Downloaded from ' . $pName, 'info@lineomatic.com', $bodyHTML);

        $bodyHTML = '<img src ="https://www.lineomatic.com/assets/images/inner-page-logo.png">
            <br>
            <br>
                
            Hello ' . $name . '!<br><br>
                
            Thank you for showing interest in ' . $pName . '.<br><br>
                
            Here is a link for you to download the brochure. <a href="' . $dLink . '" target="_blank"> ' . $dLink . '</a><br><br>
                
            Team<br>
            Lineomatic
            ';

        $mail = sendMailSMTP('Thanks for downloading Brochure for ' . $pName, $email, $bodyHTML);

        $_SESSION['success_msg'] = "Your message submitted successfully.";
        header("Location: " . $_POST['redirect_url'] . "?success=1&m=db");
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
