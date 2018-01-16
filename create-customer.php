<?php include "classes.php" ?>

<?php

/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 12/9/2017
 * Time: 1:17 AM
 */
$CustomerId = SessionManager::getCustomerId();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $returnVal = true;
    isset($_POST["email"]) && $_POST["email"] != "" ? $email = $_POST["email"] : $returnVal = false;
    isset($_POST["firstname"]) && $_POST["firstname"] != "" ? $firstname = $_POST["firstname"] : $returnVal = false;
    isset($_POST["lastname"]) && $_POST["lastname"] != "" ? $lastname = $_POST["lastname"] : $returnVal = false;

    //don't check password if customer is making new account
    if(!isset($_POST["btnEdit"])){
        isset($_POST["password"]) && $_POST["password"] != "" ? $password = $_POST["password"] : $returnVal = false;

        if(isset($_POST["confirmpassword"]) && $_POST["confirmpassword"] == $password){
            isset($_POST["confirmpassword"]) && $_POST["confirmpassword"] != "" ? $confirmpassword = $_POST["confirmpassword"] : $returnVal = false;
        }
        else{
            $returnVal = false;
            $validationMsg = "Passwords did not match.";
        }
    }


    if($returnVal){
        //customer passed form validation
        if(isset($_POST["btnEdit"]) && is_numeric($_POST["btnEdit"])){
            //existing customer editing their profile
            //val of btn edit is the customer id of the existing customer profile
            //we will check this value agaist the session value before doing any updates on the db
            if($CustomerId == $_POST["btnEdit"])
            $customer = new Customer($_POST["btnEdit"]);
            $customer->setFirstName($firstname);
            $customer->setLastName($lastname);
            $customer->setEmail($email);
            $customer->save();
            header("location:customer-profile.php");
        }
        else {
            //new customer
            $customer = Customer::lookup($email);
            if ($customer != null) {
                // This email is already taken
                $errorMessage = "The provided email is already in use. Please try another email.";
            }
            else {
                $currentDate = date('Y-m-d H:i:s');
                $customer = Authentication::createCustomer($firstname, $lastname, $email, $password, $currentDate);
                if ($customer == null) {
                    // Something went wrong while attempting to create this user
                    $validationMsg = "An error occurred during the creation of this customer. Please try again. If the problem continues, contact the site administrators";
                }
                else {
                    Mailer::sendRegistrationEmail($customer->getEmail());
                    // Set session values for successful login
                    SessionManager::setCustomerId($customer->getId());
                    SessionManager::setFirstName($customer->getFirstName());
                    // Redirect to Dashboard
                    header("location: customer-profile.php");
                }
            }
        }
    }
    else{
        $validationMsg = "Please review your entries!";
    }
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"])
        && is_numeric($_GET["id"])
        && $_GET["id"] > 0
        && isset($_GET["cmd"])
        && $_GET["cmd"] == "edit"
        && $_GET["id"] == $CustomerId){     //validate query string 'id' against customer id in session
        $customer = new Customer($_GET["id"]);
        if($customer != null){
            //success, now use this obj to fill in the values for the form input fields in html below
        }
        else{   //null customer obj
            header("location: index.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include "head.php" ?>

<body class="bg-pattern" id="page-top">
<?php include "navbar.php" ?>
<div class="container content-wrapper">
    <?php if(isset($validationMsg)) { ?>
        <div class="alert alert-danger alert-dismissible fade show mx-auto mt-5" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4> <?php  echo $validationMsg; ?> </h4>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="card mx-auto mt-5">
                <div class="card-header"><?php isset($customer) ? $title = "Edit" : $title = "Create"; echo $ti ?> Account</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="username">First Name</label>
                                    <input class="form-control" id="firstname" name="firstname" type="text" placeholder="First Name" value="<?php if(isset($customer)) echo $customer->getFirstName() ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="username">Last Name</label>
                                    <input class="form-control" id="lastname" name="lastname" type="text" placeholder="Last Name" value="<?php if(isset($customer)) echo $customer->getLastName() ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">Email Address</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Email Address" value="<?php if(isset($customer)) echo $customer->getEmail() ?>" required>
                        </div>
                        <?php
                        if(isset($customer)){
                            ?>
                            <button type="submit" name="btnEdit" id="btnEdit" class="btn btn-primary btn-block" value="<?php echo $customer->getId() ?>">Edit Profile</button>
                            <div class="text-center">
                                <a class="d-block small mt-3" href="customer-profile.php">Cancel</a>
                            </div>
                        <?php
                        }
                        else{
                            ?>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="password">Password</label>
                                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="confirmpassword">Confirm password</label>
                                        <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" placeholder="Confirm password" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                            <div class="text-center">
                                <a class="d-block small mt-3" href="login.php">Login Page</a>
                            </div>
                        <?php
                        }
                        ?>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include "scripts.php" ?>

</body>

</html>

