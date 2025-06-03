<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require __DIR__ . '/phpmailer/vendor/autoload.php';

class PHP_Email_Form
{
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $body;
    public $ajax = false;
    public $smtp = false;
    private $messages = [];

    public function add_message($content, $label, $length = 0)
    {
        $this->messages[] = "$label: " . trim($content);
    }

    public function send()
    {
        $mail = new PHPMailer(true);

        try {
            if ($this->smtp && is_array($this->smtp)) {
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = $this->smtp['host'];
                $mail->SMTPAuth = true;
                $mail->Username = $this->smtp['username'];
                $mail->Password = $this->smtp['password'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = $this->smtp['port'];

                $mail->setFrom($this->from_email, $this->from_name);
                $mail->addAddress($this->to);
                $mail->Subject = $this->subject;
                $mail->isHTML(true);
                $mail->Body = $this->body;
                $mail->send();
            }

            return $this->ajax ? 'OK' : 'Message sent successfully!';
        } catch (Exception $e) {
            return $this->ajax ? 'ERROR' : 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
