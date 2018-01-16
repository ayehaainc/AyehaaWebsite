<?php include "classes.php" ?>
<?php
$CustomerId = SessionManager::getCustomerId();
if($CustomerId > 0){
    $customer = new Customer($CustomerId);
}
else{
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include "head.php" ?>

<body class="bg-pattern">

<!-- Navigation -->
<?php include "navbar.php" ?>

<!-- Page Content -->
<div class="container content-wrapper">



    <ol class="breadcrumb mt-5 bg-dark">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active"><?php echo ucfirst($customer->getFirstName())." ".ucfirst($customer->getLastName()); ?></li>
    </ol>
    <div class="card">
        <div class="card-header">
            Customer Information<a href="create-customer.php?cmd=edit&id=<?php echo $customer->getId() ?>" class="btn btn-dark pull-right">Edit</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <b>First Name: </b>
                    <?php echo ucfirst($customer->getFirstName()); ?>
                </div>
                <div class="col-md-4">
                    <b>Last Name: </b>
                    <?php echo ucfirst($customer->getLastName()); ?>
                </div>
                <div class="col-md-4">
                    <b>Email: </b>
                    <?php echo $customer->getEmail(); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <b>Customer ID: </b>
                    <?php echo $customer->getId(); ?>
                </div>
                <div class="col-md-8">
                    <b>Create Date: </b>
                    <?php echo date_format(date_create($customer->getCreateDate()), 'g:ia \o\n l jS F Y'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container -->

<!-- Footer -->
<?php include "footer.php" ?>

<!-- Bootstrap core JavaScript -->
<?php include "scripts.php" ?>

</body>

</html>
