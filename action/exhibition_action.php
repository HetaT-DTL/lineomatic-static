<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // echo "<pre>";print($_POST['name']);exit;

   
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
    $interested_products = senatize_post_input( $interested_products, 'varchar');  
    $message = senatize_post_input($_POST['message'], 'varchar');

  

    if (empty($exhibition) && empty($company_name) && empty($first_name) && empty($last_name) && empty($address) && empty($city) && empty($state) && empty($zip) && empty($country) && empty($code) && empty($phone) && empty($mobile) && empty($email) && empty($date) && empty($interested_products) && empty($message) ) {
        $_SESSION['error_msg'] = "Something went to wrong, please try again.";
    } else {
        $data = "=============================================\n";
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