<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
   
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

   

    if (empty($job_post) && 
    empty($fname) &&
    empty($lname) &&
    empty($address) &&
    empty($city) &&
    empty($state) &&
    empty($zip) &&
    empty($country) &&
    empty($p_code) &&
    empty($phone) &&
    empty($mobile) &&
    empty($email) &&
    empty($dob) &&
    empty($present_company) &&
    empty($present_job_location) &&
    empty($present_job_description) &&
    empty($notice_period) &&
    empty($present_designation) &&
    empty($qualification) &&
    empty($t_exp) &&
    empty($p_ctc) &&
    empty($post_apply) &&
    empty($e_ctc) &&
    empty($message)) {

        $_SESSION['error_msg'] = "Something went to wrong, please try again.";
    } else {
        $data = "=============================================\n";
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