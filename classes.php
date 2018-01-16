<?php
session_start();
include_once("DAL/customer.php");
include_once("DAL/securityuser.php");
include_once("DAL/role.php");
include_once("DAL/subscriber.php");
include_once ("DAL/emaillog.php");
include_once ("DAL/emailtype.php");

//Utilities
include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");
include_once("Utilities/Mailer.php");
?>