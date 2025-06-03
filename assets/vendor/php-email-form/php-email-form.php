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
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            // $mail->isSMTP();                                            //Send using SMTP
            // $mail->Host       = 'mail.megapos.ltd.uk';                     //Set the SMTP server to send through
            // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            // $mail->Username   = 'hello@megapos.ltd.uk';                     //SMTP username
            // $mail->Password   = '~n[pg%SO9MYm';                               //SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // //Recipients
            // $mail->setFrom('hello@megapos.ltd.uk', 'Megapos Ltd');
            // $mail->addAddress('salehge901@gmail.com', 'Saleh');     //Add a recipient                        
            // // $mail->addReplyTo('info@example.com', 'Information');
            // // $mail->addCC('cc@example.com');
            // // $mail->addBCC('bcc@example.com');

            // //Attachments
            // // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // //Content
            // $mail->isHTML(true);                                  //Set email format to HTML
            // $mail->Subject = 'Here is the subject';
            // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            // // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // $mail->send();
            // SMTP settings
            if ($this->smtp && is_array($this->smtp)) {
                $mail->isSMTP();
                $mail->Host = $this->smtp['host'];
                $mail->SMTPAuth = true;
                $mail->Username = $this->smtp['username'];
                $mail->Password = $this->smtp['password'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $this->smtp['port'];
            }

            // // Email setup
            $mail->setFrom($this->from_email, $this->from_name);
            $mail->addAddress($this->to);
            $mail->Subject = $this->subject;

            $body = implode("\n", $this->messages);
            $mail->Body = $body;

            $mail->send();
            return $this->ajax ? 'OK' : 'Message sent successfully!';
        } catch (Exception $e) {
            return $this->ajax ? 'ERROR' : 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
