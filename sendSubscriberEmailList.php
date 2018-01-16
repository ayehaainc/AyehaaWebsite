<?php
/**
 * Created by PhpStorm.
 * User: robsm_5mj
 * Date: 1/15/2018
 * Time: 4:28 PM
 */
session_start();
include_once ("DAL/subscriber.php");
include_once ("Utilities/SessionManager.php");
include_once ("Utilities/Mailer.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $responseText = "";
    if(empty($_POST['subject']) || empty($_POST['message'] || empty($_POST['message'])))
    {
        echo $responseText = "Please complete all required fields.";
        return false;
    }
    else{
        if(SessionManager::getSecurityUserId() == $_POST['securityuserid']){

            $email_list = Subscriber::loadall();



            $subject = strip_tags(htmlspecialchars($_POST['subject']));
            $message = strip_tags(htmlspecialchars($_POST['message']));

            // Create the email and send the message
            $email_subject = $subject;
            $email_body = $message;

            if($email_subject != "" && $email_body != "" && $message != ""){

                foreach ($email_list as $email){
                    Mailer::sendGenericEmail($email->getEmail(),$email_subject,$email_body);
                }
                $responseText = "Success";
            }
            else{
                $responseText = "Failed";
            }
        }
        else{
            $responseText = "Security User Id did not match session value";
        }


    }
    echo $responseText;


}



?>