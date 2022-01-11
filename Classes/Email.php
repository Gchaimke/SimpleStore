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
        global $config;
        $this->mail = new PHPMailer(true);

        //Server settings
        if ($config['SMTP_DEBUG']) {
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->mail->addBCC($config['SMTP_DEBUG_EMAIL']);
        }
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = $config['SMTP_HOST'];                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = $config['SMTP_EMAIL'];                     //SMTP username
        $this->mail->Password   = $config['SMTP_PASS'];                               //SMTP password
        if ($config['SMTP_ENCRYPTION']) {
            if ($config['SMTP_ENCRYPTION_TYPE'] == "SSL") {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            } else {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
        }
        $this->mail->Port       = $config['SMTP_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $this->mail->setFrom($config['SMTP_EMAIL'], $config['SMTP_STORE_NAME']);
        $this->mail->addReplyTo($config['SMTP_EMAIL'], 'Information');
    }

    public function send($recipients, $subject = "", $html_body = "", $text_body = "")
    {
        ini_set('max_execution_time', 300);
        try {
            //Recipients
            foreach ($recipients as $value) {
                if ($value != "") {
                    $this->mail->addAddress($value);
                }
            }
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $html_body;
            $this->mail->AltBody = $text_body;

            $this->mail->send();
            return 'Message has been sent';
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
