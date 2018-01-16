<?php
session_start();
include_once ("../Utilities/SessionManager.php");
include_once ("../DAL/subscriber.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $securityUserId = $_POST["securityuserid"];
    if($securityUserId > 0){    //so we dont allow 0 == 0
        if($securityUserId == SessionManager::getSecurityUserId()){
            $id = $_POST["Id"];
            Subscriber::remove($id);
            echo $id;
        }
    }

}
?>
