<?php

// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'salehge901@gmail.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
  include($php_email_form);
} else {
  die('Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = 'MEGAPOS LTD';
$contact->from_email = 'hello@megapos.ltd.uk';
$contact->subject = $_POST['subject'];
$contact->body = "
Name: " . $_POST['name'] . "<br>
Email: " . $_POST['email'] . "<br><br>
Message: " . $_POST['message'] . "
";

// Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
$contact->smtp = array(
  'host' => 'mail.megapos.ltd.uk',
  'username' => 'hello@megapos.ltd.uk',
  'password' => '~n[pg%SO9MYm',
  'port' => '465'
);

// $contact->add_message($_POST['name'], 'From');
// $contact->add_message($_POST['email'], 'Email');
// $contact->add_message($_POST['message'], 'Message', 10);

echo $contact->send();
