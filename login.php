<?php include "classes.php" ?>
<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 12/9/2017
 * Time: 1:04 AM
 */
$errorMessage = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    isset($_POST["email"]) && $_POST["email"] != "" ? $email = $_POST["email"] : $returnVal = false;
    isset($_POST["password"]) && $_POST["password"] != "" ? $password = $_POST["password"] : $returnVal = false;

    $success = Authentication::customerLogin($email,$password);
    if ($success)
    {
        header("location: customer-profile.php");
    }
    else
    {
        $validationMsg = "Incorrect username or password. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include "head.php" ?>

<body class="bg-pattern" id="page-top">
<?php include "navbar.php" ?>
<div class="container">
    <?php if(isset($validationMsg)) { ?>
        <div class="alert alert-danger alert-dismissible fade show mx-auto mt-5" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4> <?php  echo $validationMsg; ?> </h4>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div class="card mx-auto mt-5">
                <div class="card-header">Customer Login</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input class="form-control" id="email" name="email" type="email" aria-describedby="emailHelp" placeholder="Enter Email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input class="form-control" id="password" name="password" type="password" placeholder="Password" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <div class="text-center">
                        <a class="d-block small mt-3" href="create-customer.php">Create Customer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include "scripts.php" ?>

</body>

</html>

