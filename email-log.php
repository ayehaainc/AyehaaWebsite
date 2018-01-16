<?php include "classes.php" ?>
<?php
$SecurityUserId = SessionManager::getSecurityUserId();
if($SecurityUserId == 0){
    header("location:admin-login.php");
}
$emailLogList = Emaillog::loadall();
?>
<!DOCTYPE html>
<html lang="en">

<?php include "head.php" ?>

<body class="bg-pattern">

<!-- Navigation -->
<?php include "navbar.php" ?>

<!-- Page Content -->
<div class="container content-wrapper">
    <h1 class="mb-3 text-white d-none d-sm-block">Email Log</h1>
    <ol class="breadcrumb bg-dark">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="admin-home.php">Administration</a>
        </li>
        <li class="breadcrumb-item active">Email Log</li>
    </ol>
    <div id="divAlertMsg" class="alert alert-success d-none" role="alert">
        <label id="lblAlertMsg"></label>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            Email Log
                        </div>
                    </div>
                </div>
                <div>
                    <table id="gridEmailLog" class="table">
                        <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Sent</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($emailLogList)){
                            $totalemails = 0;
                            $totalregisteration = 0;
                            $totalcontact = 0;
                            $totalgeneric = 0;
                            foreach ($emailLogList as $emaillog) {
                                $totalemails = $totalemails + 1;
                                //may want to move this to the db ass we scale
                                switch ($emaillog->getEmailTypeId()){
                                    case 1; $totalregisteration = $totalregisteration + 1;
                                        break;
                                    case 2: $totalcontact  = $totalcontact + 1;
                                        break;
                                    case 3: $totalgeneric = $totalgeneric + 1;
                                        break;
                                }
                                ?>
                                <tr id="row_<?php echo $emaillog->getId() ?>">
                                    <td><?php echo $emaillog->getId() ?></td>
                                    <td><?php echo $emaillog->getEmail() ?></td>
                                    <td><?php echo date_format(date_create($emaillog->getSentDate()), 'F j, Y, g:i a') ?></td>
                                    <td><?php $emailType = new Emailtype($emaillog->getEmailTypeId()); echo $emailType->getName(); ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    Total Emails: <span id="lblTotalEmails"><?php echo $totalemails; ?></span>
                </div>
            </div>
        </div>
        <div class="d-none">
            <div class="card">
                <div class="card-header">
                    Email Types
                </div>
                <div id="donut-example"></div>
                <script>
                    Morris.Donut({
                        element: 'donut-example',
                        data: [
                            {label: "Registration Emails", value: <?php echo $totalregisteration; ?>},
                            {label: "Contact Emails", value: <?php echo $totalcontact; ?>},
                            {label: "Generic Emails", value: <?php echo $totalgeneric; ?>}
                        ]
                    });
                </script>
            </div>

        </div>
    </div>
</div>
<!-- /.container -->
<!-- Footer -->
<?php include "footer.php" ?>


<!-- Bootstrap core JavaScript -->
<?php include "scripts.php" ?>
<script>
    $( document ).ready(function() {
        if ($(window).width() < 769) {
            $("#gridEmailLog").addClass("table-responsive");
        }
    });
</script>
</body>

</html>
