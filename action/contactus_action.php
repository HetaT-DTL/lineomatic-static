<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
   
    $name = senatize_post_input($_POST['name'], 'string');
    $company_name = senatize_post_input(($_POST['company_name']), 'string');
    $address = senatize_post_input($_POST['address'], 'varchar');
    $contact_number = senatize_post_input($_POST['contact_number'], 'number');
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $state = senatize_post_input($_POST['state'], 'string');
    $country = senatize_post_input($_POST['country'], 'string');
    $department = senatize_post_input($_POST['subject'], 'string');
    $message = senatize_post_input($_POST['message'], 'varchar');

    $errors = [];

    if (empty($name) && empty($company_name) && empty( $address) && empty($contact_number) && empty($email) && empty($state) && empty($country) && empty($department) && empty( $message)) {
        $_SESSION['error_msg'] = "Something went to wrong, please try again.";
    } else {
        $data = "==================== Date: " . date('d-m-Y h:i A') . " =========================\n";
        $data .= "Name: " . $name . "\n";
        $data .= "Company Name: " . $company_name . "\n";
        $data .= "Address: " . $address . "\n";
        $data .= "Contact Number: " . $contact_number . "\n";
        $data .= "Email: " . $email . "\n";
        $data .= "State: " . $state . "\n";
        $data .= "Country: " . $country . "\n";
        $data .= "Department: " . $department . "\n";
        $data .= "Message: \"" . $message . "\"\n";
        $data .= "=============================================\n\n";
      
        $file = "text-files/contactus_details.txt";
        file_put_contents($file, $data, FILE_APPEND);
       
        $_SESSION['success_msg'] = "Your message submitted successfully.";
        header("Location: " . $_POST['redirect_url'] . "?success=1");
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