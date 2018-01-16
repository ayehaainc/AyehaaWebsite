<?php
/*
 * Author:      Rob Smitha
 * Date:        12/09/2017
 * Description: This utility provides static functions to implement centralized accessor/mutator methods for all session values.
 *
 */


class SessionManager
{
    public static function getSecurityUserId() {
        if (isset($_SESSION['SecurityUserId']))
            return $_SESSION['SecurityUserId'];
        else
            return 0;

    }

    public static function setSecurityUserId($arg1){
        $_SESSION['SecurityUserId'] = $arg1;
    }

    //For roles
    public static function getRoleId() {
        if (isset($_SESSION['RoleId']))
            return $_SESSION['RoleId'];
        else
            return 0;

    }

    public static function setRoleId($arg1){
        $_SESSION['RoleId'] = $arg1;
    }
    //for username
    public static function getUsername() {
        if (isset($_SESSION['Username']))
            return $_SESSION['Username'];
        else
            return 0;

    }

    public static function setUsername($arg1){
        $_SESSION['Username'] = $arg1;
    }

    public static function ResetSession(){
        $_SESSION['Username'] = null;
        $_SESSION['RoleId'] = null;
        $_SESSION['SecurityUserId'] = null;
        $_SESSION['CustomerId'] = null;
        $_SESSION['FirstName'] = null;
        session_destroy();
    }
    public static function getCustomerId() {
        if (isset($_SESSION['CustomerId']))
            return $_SESSION['CustomerId'];
        else
            return 0;

    }

    public static function setCustomerId($arg1){
        $_SESSION['CustomerId'] = $arg1;
    }
    public static function getFirstName() {
        if (isset($_SESSION['FirstName']))
            return $_SESSION['FirstName'];
        else
            return 0;

    }

    public static function setFirstName($arg1){
        $_SESSION['FirstName'] = $arg1;
    }
}

