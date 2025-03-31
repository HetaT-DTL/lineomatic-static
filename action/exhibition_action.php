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
    $interested_products = senatize_post_input($interested_products, 'varchar');
    $message = senatize_post_input($_POST['message'], 'varchar');



    if (empty($exhibition) && empty($company_name) && empty($first_name) && empty($last_name) && empty($address) && empty($city) && empty($state) && empty($zip) && empty($country) && empty($code) && empty($phone) && empty($mobile) && empty($email) && empty($date) && empty($interested_products) && empty($message)) {
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

        $bodyHTML = '<img src ="https://www.lineomatic.com/assets/images/inner-page-logo.png">
            <br>
            <br>
                
            Hello Admin!<br><br>
                
            <table order=1>
                <tr>
                    <td>Exhibition
                    </td>
                    <td>' . $_POST['exhibition'] . '
                    </td>
                </tr>
                <tr>
                    <td>Company Name
                    </td>
                    <td>' . $_POST['company_name'] . '
                    </td>
                </tr>
                <tr>
                    <td>Name
                    </td>
                    <td>' . $_POST['first_name'] . " " . $_POST['last_name'] . '
                    </td>
                </tr>
                <tr>
                    <td>Address
                    </td>
                    <td>' . $_POST['address'] . '
                    </td>
                </tr>
                <tr>
                    <td>City
                    </td>
                    <td>' . $_POST['city'] . '
                    </td>
                </tr>
                <tr>
                    <td>State
                    </td>
                    <td>' . $_POST['state'] . '
                    </td>
                </tr>
                <tr>
                    <td>Zip
                    </td>
                    <td>' . $_POST['zip'] . '
                    </td>
                </tr>
                <tr>
                    <td>Country
                    </td>
                    <td>' . $_POST['country'] . '
                    </td>
                </tr>
                <tr>
                    <td>Phone Number
                    </td>
                    <td>' . $_POST['code'] . " " . $_POST['phone'] . '
                    </td>
                </tr>
                <tr>
                    <td>Mobile
                    </td>
                    <td>' . $_POST['mobile'] . '
                    </td>
                </tr>
                <tr>
                    <td>Email
                    </td>
                    <td>' . $_POST['email'] . '
                    </td>
                </tr>
                <tr>
                    <td>Date
                    </td>
                    <td>' . $_POST['date'] . '
                    </td>
                </tr>
                <tr>
                    <td>Interested Products
                    </td>
                    <td>' . implode(', ', json_decode($_POST['interested_products'], true)) . '
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
                
            Hello ' . $_POST['first_name'] . " " . $_POST['last_name'] . '!<br><br>
                
            Thank you for pre-registring your visit.<br><br>
                
            Looking forward to our meeting.<br><br>
                
            Team<br>
            Lineomatic
            ';
        $mail = sendMailSMTP('Thank you for pre-registring your visit', $_POST['email'], $bodyHTML);

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
