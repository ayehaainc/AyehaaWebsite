<?php
session_start();
include_once ("Utilities/SessionManager.php");
include_once("Utilities/Mailer.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $responseText = "";
    // Check for empty fields
    if(empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message']) || empty($_POST['securityuserid']))
    {
        $responseText = "Please complete all required fields to send an email.";
        return false;
    }
    else{
        $securityUserId = $_POST['securityuserid'];
        if($securityUserId > 0 && $securityUserId == SessionManager::getSecurityUserId()){
            $email_address = strip_tags(htmlspecialchars($_POST['email']));
            $subject = strip_tags(htmlspecialchars($_POST['subject']));
            $message = strip_tags(htmlspecialchars($_POST['message']));

            // Create the email and send the message
            $email_subject = $subject;
            $email_body = $message;

            if($email_subject != "" && $email_body != "" && $message != ""){
                Mailer::sendGenericEmail($email_address,$email_subject,$email_body);
                $responseText = "Success Message Sent to ".$email_address;
            }
            else{
                $responseText = "Failed";
            }
        }
        else{
            $responseText = "Failed Session Validation";
        }

    }
    echo $responseText;
}
?>