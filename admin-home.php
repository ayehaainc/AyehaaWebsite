<?php include "classes.php" ?>
<?php
if(SessionManager::getSecurityUserId() == 0){
    header("location: admin-login.php");
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

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3 text-white d-none d-sm-block">
        Hello, <?php echo SessionManager::getUsername() ?>
        <a class="small" href="create-user.php?cmd=edit&id=<?php echo SessionManager::getSecurityUserId() ?>">
            <i class="icon-pencil"></i>
        </a>
    </h1>

    <ol class="breadcrumb bg-dark">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">Administration</li>
    </ol>
    <div class="row">
        <div class="col-sm-4 mb-2">
            <a href="manage-subscribers.php">
                <div class="tile">
                    <div class="tile-title">
                        <h3 class="text-white">Manage Subscribers</h3>
                        <p class="lead">Manage Subscribers who signed up for updates.</p>
                    </div>
                    <div class="tile-footer">
                        <i class="icon-arrow-right-circle pull-right fa-2x text-white"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4 mb-2">
            <a href="email-log.php">
                <div class="tile">
                    <div class="tile-title">
                        <h3 class="text-white">Email Log</h3>
                        <p class="lead">View email log records</p>
                    </div>
                    <div class="tile-footer">
                        <i class="icon-arrow-right-circle pull-right fa-2x text-white"></i>
                    </div>
                </div>
            </a>
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
