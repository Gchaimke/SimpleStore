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
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        }
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isSMTP();
        $this->mail->Host = $config['SMTP_HOST'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $config['SMTP_EMAIL'];
        $this->mail->Password = $config['SMTP_PASS'];
        if ($config['SMTP_ENCRYPTION']) {
            if ($config['SMTP_ENCRYPTION_TYPE'] == "SSL") {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
        }
        $this->mail->Port = $config['SMTP_PORT']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }

    public function send($recipients, $subject = "SimpleStore", $store_name = "SimpleStore", $html_body = "Test SimpleStore", $text_body = "")
    {
        ini_set('max_execution_time', 300);
        global $config;
        try {
            //Recipients
            foreach ($recipients as $value) {
                if ($value != "") {
                    $this->mail->addAddress($value);
                }
            }
            if ($config['SMTP_DEBUG_EMAIL'] != "") {
                $this->mail->addBCC($config['SMTP_DEBUG_EMAIL']);
            }
            $this->mail->setFrom($config['SMTP_EMAIL'], $store_name);
            $this->mail->addReplyTo($config['SMTP_EMAIL'], 'Information');
            //Content
            $this->mail->isHTML(true);
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
