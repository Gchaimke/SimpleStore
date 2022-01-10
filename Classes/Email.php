<?php

namespace SimpleStore;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    private $mail;
    function __construct()
    {
        $smtp_mail = "sp@mc88.co.il";
        $debug_mail = "gchaimke@gmail.com";
        $store_name = 'Simple Store';
        $this->mail = new PHPMailer(true);

        //Server settings
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = $smtp_mail;                     //SMTP username
        $this->mail->Password   = 'secret';                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $this->mail->setFrom($smtp_mail, $store_name);
        $this->mail->addReplyTo('info@example.com', 'Information');
        $this->mail->addCC($debug_mail);
    }

    function send()
    {
        $admin_mail = "sp@mc88.co.il";
        $user_mail = "sp@mc88.co.il";
        try {
            //Recipients
            $this->mail->addAddress($admin_mail, 'Admin');     //Add a recipient
            $this->mail->addAddress($user_mail);               //Name is optional

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = 'Here is the subject';
            $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $this->mail->send();
            return 'Message has been sent';
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
