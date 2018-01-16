<?php include "classes.php" ?>
<?php



/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 12/9/2017
 * Time: 1:17 AM
 */
$SecurityUserId = SessionManager::getSecurityUserId();
if($SecurityUserId == 0){
    //header("location: admin-login.php");
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $returnVal = true;
    isset($_POST["email"]) && $_POST["email"] != "" ? $email = $_POST["email"] : $returnVal = false;
    isset($_POST["role"]) && $_POST["role"] > 0 ? $roleid = $_POST["role"] : $returnVal = false;

    if(!isset($_POST["btnEdit"])){
        isset($_POST["username"]) && $_POST["username"] != "" ? $username = $_POST["username"] : $returnVal = false;
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
        if(isset($_POST["btnEdit"]) && is_numeric($_POST["btnEdit"])){
            //existing user editing their profile
            //val of btn edit is the user id of the existing user profile
            //we will check this value against the session value before doing any updates on the db
            if($SecurityUserId == $_POST["btnEdit"])
            $securityuser = new Securityuser($_POST["btnEdit"]);
            $securityuser->setEmail($email);
            $securityuser->save();
            header("location:admin-home.php");
        }
        else{
            $securityuser = Securityuser::lookup($username);
            if ($securityuser != null) {
                // This email is already taken
                $errorMessage = "The provided username is already in use. Please try another username.";
            }
            else {
                $currentDate = date('Y-m-d H:i:s');
                $securityuser = Authentication::createSecurityUser($username, $password, $email, $roleid,$currentDate);
                if ($securityuser == null) {
                    // Something went wrong while attempting to create this user
                    $validationMsg = "An error occurred during the creation of this security user. Please try again. If the problem continues, contact OpenDevTools support at opendevtools@gmail.com";
                }
                else {
                    Mailer::sendRegistrationEmail($securityuser->getEmail());
                    // Set session values for successful login
                    SessionManager::setSecurityUserId($securityuser->getId());
                    SessionManager::setRoleId($securityuser->getRoleId());
                    SessionManager::setUsername($securityuser->getUsername());
                    // Redirect to Dashboard
                    header("location: admin-home.php");
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
        && $_GET["id"] == $SecurityUserId){     //validate query string 'id' against customer id in session
        $securityuser = new Securityuser($_GET["id"]);
        if($securityuser != null){
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
                <div class="card-header">Create Security User</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="username">Email Address</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Email Address" value="<?php if(isset($securityuser)) echo $securityuser->getEmail() ?>">
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="username">Username</label>
                                    <input class="form-control" id="username" name="username" type="text" placeholder="Username" value="<?php if(isset($securityuser)) echo $securityuser->getUsername() ?>" <?php if(isset($securityuser)) echo "disabled" ?>>
                                </div>
                                <div class="col-md-6">
                                    <label for="role">Role</label>
                                    <select class="form-control" name="role">
                                        <?php
                                        if(isset($securityuser)){
                                            $role = new Role($securityuser->getRoleId());
                                            ?>
                                            <option value="<?php echo $role->getId() ?>"><?php echo $role->getName() ?></option>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <option value="0">--Select Role--</option>
                                            <?php
                                        }
                                        $roleList = Role::loadall();
                                        if(!empty($roleList)){
                                            foreach ($roleList as $role) {
                                                if($role->getId() == $securityuser->getRoleId()){
                                                    //skip
                                                }
                                                else{
                                                    ?>
                                                    <option value="<?php echo $role->getId() ?>"><?php echo $role->getName() ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($securityuser)){
                          ?>
                            <button type="submit" name="btnEdit" id="btnEdit" class="btn btn-primary btn-block" value="<?php echo $securityuser->getId() ?>">Edit Profile</button>
                            <div class="text-center">
                                <a class="d-block small mt-3" href="admin-home.php">Cancel</a>
                            </div>
                        <?php
                        }
                        else{
                            ?>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="password">Password</label>
                                        <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="confirmpassword">Confirm password</label>
                                        <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" placeholder="Confirm password">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                            <div class="text-center">
                                <a class="d-block small mt-3" href="admin-login.php">Login Page</a>
                            </div>
                        <?php
                        }?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "scripts.php" ?>

</body>

</html>

