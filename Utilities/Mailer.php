<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

include_once ("SessionManager.php");
include_once ("DAL/emaillog.php");

class Mailer
{
    protected static $emailTypeId;

    // This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
    protected static function getMailSettings() { return "mail_localsettings.php"; }

    public static function sendRegistrationEmail($recipientEmail) {
        include_once(self::getMailSettings());

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host = $smtpHost;                        // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                         // Enable SMTP authentication
            $mail->Username = $smtpUsername;                // SMTP username
            $mail->Password = $smtpPassword;                // SMTP password
            $mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                              // TCP port to connect to

            //Recipients
            $mail->setFrom($smtpUsername, 'Ayehaa!');
            $mail->addAddress($recipientEmail);
            $mail->addReplyTo($smtpUsername, 'NoReply');

            //Content
            $body = '<p>Greetings! An account was recently created on <a href="https://ayehaa.com">ayehaa.com</a> using this email address</p>';
            $body = $body . '<br/><p>If you believe you have received this message in error, please contact our <a href="mailto:r.smitha@ayehaa.com">Site Administrators</a>.</p>';

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Ayehaa Account Registration Successful';
            $mail->Body    = $body;

            $altBody = strip_tags($body);
            $mail->AltBody = $altBody;

            // Set SMTP Options
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();

            $emailTypeId = 1;
            $currentDate = date('Y-m-d H:i:s');
            // Message sent
            // We want to log emails in the database...
            $emailLog = new Emaillog(0,$recipientEmail,$currentDate,$emailTypeId);
            $emailLog->save();
        } catch (Exception $e) {
            // Log error
            die('Mailer Error: ' . $mail->ErrorInfo);
        }
    }

    public static function sendContactEmail($email_address,$email_subject,$email_body) {
        include_once(self::getMailSettings());

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host = $smtpHost;                        // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                         // Enable SMTP authentication
            $mail->Username = $smtpUsername;                // SMTP username
            $mail->Password = $smtpPassword;                // SMTP password
            $mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                              // TCP port to connect to

            //Recipients
            $mail->setFrom($email_address,"Ayehaa!");
            $mail->addAddress($smtpUsername);   // This email is to ourselves
            $mail->addReplyTo($email_address,$email_address);

            //Content

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $email_subject;
            $mail->Body    = $email_body;

            $altBody = strip_tags($email_body);
            $mail->AltBody = $altBody;

            // Set SMTP Options
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();

            $emailTypeId = 2;
            $currentDate = date('Y-m-d H:i:s');
            // Message sent
            // We want to log emails in the database...
            $emailLog = new Emaillog(0,$smtpUsername,$currentDate,$emailTypeId);
            $emailLog->save();
        } catch (Exception $e) {
            // Log error
            die('Mailer Error: ' . $mail->ErrorInfo);
        }
    }

    public static function sendGenericEmail($email_address,$email_subject,$email_body) {
        include(self::getMailSettings());

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host = $smtpHost;                        // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                         // Enable SMTP authentication
            $mail->Username = $smtpUsername;                // SMTP username
            $mail->Password = $smtpPassword;                // SMTP password
            $mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                              // TCP port to connect to

            //Recipients
            $mail->setFrom($smtpUsername,"Ayehaa!");
            $mail->addAddress($email_address);
            $mail->addReplyTo($smtpUsername,"Ayehaa!");

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $email_subject;
            $mail->Body    = $email_body;

            $altBody = strip_tags($email_body);
            $mail->AltBody = $altBody;

            // Set SMTP Options
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();

            $emailTypeId = 3;
            $currentDate = date('Y-m-d H:i:s');
            // Message sent
            // We want to log emails in the database...
            $emailLog = new Emaillog(0,$email_address,$currentDate,$emailTypeId);
            $emailLog->save();
        } catch (Exception $e) {
            // Log error
            die('Mailer Error: ' . $mail->ErrorInfo);
        }
    }

}