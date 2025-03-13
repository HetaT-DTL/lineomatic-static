<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // echo "<pre>";print($_POST['name']);exit;

   
    $name = senatize_post_input($_POST['name'], 'string');
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phone = senatize_post_input($_POST['phone'], 'number');
    $state = senatize_post_input($_POST['state'], 'string');
    $country = senatize_post_input($_POST['country'], 'string');
    $pName = senatize_post_input($_POST['pName'], 'varchar');
    $message = senatize_post_input($_POST['message'], 'varchar');

  

    if (empty($name) &&  empty( $email) && empty($phone) && empty($state) && empty($address) && empty($country) && empty($message)) {
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
       
        $_SESSION['success_msg'] = "Your message submitted successfully.";
        header("Location: " . $_POST['redirect_url'] . "?success=1&m=db");

    }
   
} else {
    $_SESSION['error_msg'] =  "Something went to wrong, please try again.";
    header("Location: " . $_POST['redirect_url'] . "?error=1");

}

function senatize_post_input($data, $type) {
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
?>