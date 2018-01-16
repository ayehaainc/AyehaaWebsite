<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 12/9/2017
 * Time: 1:02 PM
 */
session_start();
include "Utilities/SessionManager.php";
SessionManager::ResetSession();
header("location: index.php");
?>