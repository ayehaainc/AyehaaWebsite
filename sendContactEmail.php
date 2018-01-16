<?php
include_once("Utilities/Mailer.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $responseText = "";
    // Check for empty fields
    if(empty($_POST['name'])      ||
        empty($_POST['email'])     ||
        //empty($_POST['phone'])     ||
        empty($_POST['message'])   ||
        !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
    {
        $responseText = "Please complete all required fields to send an email.";
        return false;
    }
    else{
        $name = strip_tags(htmlspecialchars($_POST['name']));
        $email_address = strip_tags(htmlspecialchars($_POST['email']));
        isset($_POST['phone']) && $_POST['phone'] != "" ? $phone = strip_tags(htmlspecialchars($_POST['phone'])): $phone = "Not Provided";
        $message = strip_tags(htmlspecialchars($_POST['message']));

        // Create the email and send the message
        $email_subject = "Website Contact Form:  $name";
        $email_body = "You have received a new message from your website contact form.<br/><br/>"."Here are the details:<br/><br/>Name: $name<br/><br/>Email: $email_address<br/><br/>Phone: $phone<br/><br/>Message:<br/>$message";
        if($name != "" && $email_address != "" && $message != ""){
            Mailer::sendContactEmail($email_address,$email_subject,$email_body);
            $responseText = "Success";
        }
        else{
            $responseText = "Failed";
        }
    }
    echo $responseText;
}
?>