<?php

session_start();

// echo "<pre>"; print_r($_POST); exit;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $name = senatize_post_input($_POST['name'], 'string');
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phone = senatize_post_input($_POST['phone'], 'number');
    $state = senatize_post_input($_POST['state'], 'string');
    $country = senatize_post_input($_POST['country'], 'string');
    $message = senatize_post_input($_POST['message'], 'varchar');

    if (empty($name) && empty($email) && empty($phone) && empty($state) && empty($address) && empty($country) && empty($message)) {
        $_SESSION['error_msg'] = "Something went to wrong, please try again.";
    } else {
        $data = "=============================================\n";
        $data .= "Name: " . $name . "\n";
        $data .= "Email: " . $email . "\n";
        $data .= "Phone: " . $phone . "\n";
        $data .= "State: " . $state . "\n";
        $data .= "Country: " . $country . "\n";
        $data .= "Message: \"" . $message . "\"\n";
        $data .= "=============================================\n\n";

        $file = "text-files/request_quote_details.txt";
        file_put_contents($file, $data, FILE_APPEND);

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
