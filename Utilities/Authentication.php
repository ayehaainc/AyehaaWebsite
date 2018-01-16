<?php
/**
 * Author:      Rob Smitha
 * Date:        12/09/2017
 * Description: Class for managing authentication routines
 */

include_once("SessionManager.php");
include_once("DAL/securityuser.php");
include_once("DAL/customer.php");

class Authentication
{

    // Returns boolean indication if user is found
    public static function authLogin($username,$password) {

        $securityuser = Securityuser::lookup($username);
        if($securityuser != null && password_verify($password, $securityuser->getPassword())) {
            SessionManager::setSecurityUserId($securityuser->getId());
            SessionManager::setRoleId($securityuser->getRoleId());
            SessionManager::setUsername($securityuser->getUsername());
            return true;
        }
        else {
            return false;
        }
    }
    public static function createSecurityUser($paramUsername,$paramPassword,$paramEmail, $paramRoleId, $paramCreateDate) {
        // Create password using the code below to generate a hash

        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $hash = password_hash($paramPassword, PASSWORD_BCRYPT, $options);

        $securityuser = new Securityuser(0,$paramUsername, $hash, $paramEmail, $paramRoleId, $paramCreateDate);
        $securityuser->save();

        return $securityuser;
    }
    public static function updatePassword($paramSecurityUserId,$paramPassword)
    {
        // Hash the new password and update the user

        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];

        $hash = password_hash($paramPassword, PASSWORD_BCRYPT, $options);
        $securityuser = new Securityuser($paramSecurityUserId);
        $securityuser->setPassword($hash);
        $securityuser->save();
    }
    public static function customerLogin($username,$password) {

        $customer = Customer::lookup($username);
        if($customer != null && password_verify($password, $customer->getPassword())) {
            SessionManager::setCustomerId($customer->getId());
            SessionManager::setFirstName($customer->getFirstName());
            return true;
        }
        else {
            return false;
        }
    }
    public static function createCustomer($paramFirstName,$paramLastName,$paramEmail, $paramPassword, $paramCreateDate) {
        // Create password using the code below to generate a hash

        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $hash = password_hash($paramPassword, PASSWORD_BCRYPT, $options);

        $customer = new Customer(0,$paramFirstName,$paramLastName,$paramEmail, $hash, $paramCreateDate);
        $customer->save();

        return $customer;
    }
}

?>