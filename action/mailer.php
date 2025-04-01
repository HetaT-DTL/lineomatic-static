<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

function sendMailSMTP($subject, $to, $body)
{
    $ret = array();
    $mail = new PHPMailer();
    try {
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->IsSMTP();
        $mail->ContentType = PHPMailer::CONTENT_TYPE_TEXT_HTML;
        $mail->IsHTML(true);
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp-mail.outlook.com';
        $mail->Port = '587';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Username = 'info@lineomatic.com';
        $mail->Password = 'M0t0r0l@7780';

        $from_name  = "Lineomatic";
        $from_email = "info@lineomatic.com";
        $mail->setFrom($from_email, $from_name);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AddAddress($to);
        $mail->SMTPDebug   = 0; // Debug Off 

        $mail->Send();
        $mail->ClearAddresses();
        $mail->ClearAllRecipients();
    } catch (\Exception $e) {
        $ret['error'] = $mail->ErrorInfo;
    } catch (\Throwable $e) {
        $ret['error'] = $mail->ErrorInfo;
    }
    return $ret;
    // return true;
}
