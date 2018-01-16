<?php
session_start();
include_once ("../Utilities/SessionManager.php");
include_once ("../DAL/subscriber.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $securityUserId = $_POST["securityuserid"];
    if($securityUserId == SessionManager::getSecurityUserId()){
        $id = $_POST["Id"];
        Subscriber::remove($id);
        echo $id;
    }
}
?>
