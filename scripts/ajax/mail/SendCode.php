<?php
require_once '../../../config/bd.php';
//require_once '../../../mail/send.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../../vendor/autoload.php';
require 'mail_connect.php';



function sendEmail($email, $html)
{
    $mail = new PHPMailer(true);

//Server settings
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//$mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'mail.imdibil.ru';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = SMTP_USER;                     //SMTP username
    $mail->Password = SMTP_PASS;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = "utf-8";
//Recipients
    $mail->setFrom('noreply@imdibil.ru');



    //Create an instance; passing `true` enables exceptions
    //Add a recipient
//    $email = 'kochura2017@yandex.ru';
//    $email = 'maximka_shamin@mail.ru';
//    $email = 'test-bqywsdvbn@srv1.mail-tester.com';
    $mail->addAddress($email);               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Подтвердите адрес электронной почты';
    $mail->Body = $html;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


    $mail->send();

}



//$query = 'SELECT * FROM subscribers where state = 1 and center = 1 LIMIT 200';
//$query = 'SELECT email, id FROM subscribers where id in(0) and state = 1 limit 20';
$db = new DB();
$code = uniqid();
$code= rand(1000, 9999);
$db->Query_try("UPDATE expert set code = '$code', email = '{$_POST['email']}' where id_e = '{$_POST['id']}'");
$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="GENERATOR" content="MSHTML 11.00.10570.1001"></head>
<body style="background-color: rgb(255, 255, 255);" bgcolor="#ffffff">
  <style>
    a {
      text-decoration: none;
      color: red;
    }
  </style>
<table width="100%" height="auto" style="color: rgb(0, 0, 0); text-transform: none; text-indent: 0px; letter-spacing: normal; font-family: Arial, sans-serif; font-size: 15px; font-style: normal; font-weight: 400; word-spacing: 0px; white-space: normal; orphans: 2; widows: 2; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-decoration-style: initial; text-decoration-color: initial;" bgcolor="#f3f3f3" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <tr>
    <td align="middle" valign="top" style="background-color: rgb(243, 243, 243);" bgcolor="#dec476"><span size="3"></span>
      <table bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
          <td style="background-color: rgb(255, 255, 255);" bgcolor="#ffffff">
            <table width="600" style="width: 600px; min-width: 250px; max-width: 600px;" border="0" cellspacing="0" cellpadding="0">
              <tbody>
              <tr>
                <td valign="top">
                  <table width="600" border="0" cellspacing="0" cellpadding="0"><tbody>
                    <tr>
                      <td>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div style="margin: 20px 10px">
                           <div style="margin: 0 25px;  padding: 5px; border: 1px solid #a37648; border-radius: 5px;" >
                                    <p>Подтвердите адрес электронной почты!</p>
                                  </div>

                                  <div style="margin-top: 20px">
                                    Благодарим за регистрацию на imdibil.ru. Для подтверждения электронной почты перейдите по 
            <br>                                    код: '.$code.'
                                  
                                  </div>


                          </div>



                        </td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr>
</tbody></table></td></tr></tbody></table></body></html>';


$res = sendEmail($_POST['email'], $html);

echo json_encode([$res, $code]);
