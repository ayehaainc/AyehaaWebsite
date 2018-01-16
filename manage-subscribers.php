<?php include "classes.php" ?>
<?php
$SecurityUserId = SessionManager::getSecurityUserId();
if($SecurityUserId == 0){
    header("location:admin-login.php");
}
$subscriberList = Subscriber::loadall();
?>
<!DOCTYPE html>
<html lang="en">

<?php include "head.php" ?>

<body class="bg-pattern">

<!-- Navigation -->
<?php include "navbar.php" ?>

<!-- Page Content -->
<div class="container content-wrapper">
    <h1 class="mb-3 text-white d-none d-sm-block">Manage Subscribers</h1>
    <ol class="breadcrumb bg-dark">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="admin-home.php">Administration</a>
        </li>
        <li class="breadcrumb-item active">Manage Subscribers</li>
    </ol>
    <div id="divAlertMsg" class="alert alert-success d-none" role="alert">
        <label id="lblAlertMsg"></label>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10 col-md-9 com-sm-8 col-6">
                    Manage Subscribers
                </div>
                <div class="col-lg-2 col-md-3 com-sm-4 col-6">
                    <a id="SendAll" onclick="setSendAllModal(this.id)" data-toggle="modal" data-target="#exampleModal" href="#" class="btn btn-danger btn-block">Contact All</a>
                </div>
            </div>
        </div>
        <div>
            <table id="gridSubscribers" class="table">
                <thead class="bg-light">
                <tr>
                    <th class="d-none d-sm-table-cell">ID</th>
                    <th>Email</th>
                    <th class="d-none d-sm-table-cell">Created</th>
                    <th>Message</th>
                    <th>Remove</th>
                    <th class="d-none"><input type="checkbox" onchange="selectAll(this.checked)" /> Toggle All<br/></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($subscriberList)){
                    $totalsubscribers = 0;
                    foreach ($subscriberList as $subscriber) {
                        $totalsubscribers = $totalsubscribers + 1;
                        ?>
                        <tr id="row_<?php echo $subscriber->getId() ?>">
                            <td class="d-none d-sm-table-cell">
                                <?php echo $subscriber->getId() ?>
                            </td>
                            <td>
                                <?php echo $subscriber->getEmail() ?>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <?php echo date_format(date_create($subscriber->getCreateDate()), 'F j, Y, g:i a'); ?>
                            </td>
                            <td>
                                <a title="<?php echo $subscriber->getEmail() ?>" onclick="setEmailRecipient(this.title)" href="#" class="text-success" data-toggle="modal" data-target="#exampleModal"><i class="icon-paper-plane"></i></a>
                            </td>
                            <td>
                                <a id="<?php echo $subscriber->getId() ?>" onclick="deleteSubscriber(this.id)" href="#" class="text-danger"><i class="icon-close"></i></a>
                            </td>
                            <td class="d-none">
                                <input name="emailcheck" type="checkbox" id="chk_<?php echo $subscriber->getId() ?>">
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            Total Subscribers: <span id="lblTotalSubscribers"><?php echo $totalsubscribers; ?></span>
        </div>
    </div>
</div>
<!-- /.container -->

<!-- Footer -->
<?php include "footer.php" ?>

<!-- Bootstrap core JavaScript -->
<?php include "scripts.php" ?>
<script>
    //function for checking all checkboxes
    function selectAll(isChecked){
        checkboxes = document.getElementsByName('emailcheck');  //gather array of checkboxes in grid

        for(var i = 0; i < checkboxes.length; i++){
           document.getElementById(checkboxes[i].id).checked = isChecked;   //toggle select/deselect all
        }
    }
    //single recipient
    function setEmailRecipient(emailAddress){
        $("#txtEmailAddress").val(emailAddress);    //set recipient
    }
    function sendSubscriberEmail(){
        returnValue = true;
        var subject = $("#txtEmailSubject").val();
        var email = $("#txtEmailAddress").val();
        var message = $("#txtEmailBody").val();
        //do some validation before submitting
        if(subject.length > 0){
            $("#txtEmailSubject").addClass("is-valid");
        }
        else{
            $("#txtEmailSubject").addClass("is-invalid");
            returnValue = false;
        }
        if(email.length > 0){
            $("#txtEmailAddress").addClass("is-valid");
        }
        else{
            $("#txtEmailAddress").addClass("is-invalid");
            returnValue = false;
        }
        if(message.length > 0){
            $("#txtEmailBody").addClass("is-valid");
        }
        else{
            $("#txtEmailBody").addClass("is-invalid");
            returnValue = false;
        }
        if(returnValue){
            //script that send email to individual subscriber
            $.ajax({
                type: 'POST',
                url: 'sendSubscriberEmail.php',
                data: {
                    'subject': subject,
                    'email': email,
                    'securityuserid': '<?php echo $SecurityUserId ?>',
                    'message': message
                },
                success: function(msg){
                    $("#exampleModal").modal('hide');
                    $("#divAlertMsg").removeClass("d-none");
                    $("#lblAlertMsg").text(msg);
                    setTimeout(function () { $("#divAlertMsg").fadeOut(); }, 5000)
                }
            });
        }
        else{
            //please review entries
        }
    }
    //send all
    function setSendAllModal(){
        $("#txtEmailAddress").addClass("d-none");
        $("#lblEmail").html("Send To:<br> <b>All Subscribers</b>");
        $("#btnSendEmailList").removeClass("d-none");
        $("#btnSendEmail").addClass("d-none");
    }
    function sendSubscriberListEmail(){
        returnValue = true;
        var subject = $("#txtEmailSubject").val();
        var message = $("#txtEmailBody").val();
        if(subject.length > 0){
            $("#txtEmailSubject").addClass("is-valid");
        }
        else{
            $("#txtEmailSubject").addClass("is-invalid");
            returnValue = false;
        }
        if(message.length > 0){
            $("#txtEmailBody").addClass("is-valid");
        }
        else{
            $("#txtEmailBody").addClass("is-invalid");
            returnValue = false;
        }
        if(returnValue){
            $.ajax({
                type: 'POST',
                url: 'sendSubscriberEmailList.php',
                data: {
                    'subject': subject,
                    'securityuserid': '<?php echo $SecurityUserId ?>',
                    'message': message
                },
                success: function(msg){
                    $("#exampleModal").modal('hide');
                    $("#divAlertMsg").removeClass("d-none");
                    $("#lblAlertMsg").text(msg);
                    setTimeout(function () { $("#divAlertMsg").fadeOut(); }, 5000)
                }
            });
        }
        else{
            //please review entries
        }
    }
    function deleteSubscriber(e){
        $.ajax({
            type: 'POST',
            url: 'AJAX/deleteSubscriber.php',
            data: {
                'Id': e,
                'securityuserid': '<?php echo $SecurityUserId ?>'
            },
            success: function(msg){
                //remove row
                $("#row_" + msg).addClass("d-none");

                //update total
                var total = $("#lblTotalSubscribers").text();
                total = total - 1;
                $("#lblTotalSubscribers").text(total);
            }
        });
    }
    $( document ).ready(function() {
        if ($(window).width() < 769) {
            $("#gridSubscribers").addClass("table-responsive");
        }
        $('#exampleModal').on('hidden.bs.modal', function (e) {
            // clear out modal
            $("#txtEmailAddress").val("");
            $("#txtEmailAddress").removeClass("d-none");
            $("#lblEmail").html("Send To:");
            $("#btnSendEmailList").addClass("d-none");
            $("#btnSendEmail").removeClass("d-none");
        });
    });
</script>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="lblEmail">Send To:</label>
                            <input class="form-control" name="txtEmailAddress" id="txtEmailAddress" disabled>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Subject:</label>
                            <input class="form-control" name="txtEmailSubject" id="txtEmailSubject">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email Body:</label>
                            <textarea class="form-control" name="txtEmailBody" id="txtEmailBody" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="btnSendEmail" href="#" onclick="sendSubscriberEmail()" class="btn btn-outline-danger"><i class="icon-paper-plane"></i> Send</a>
                <a id="btnSendEmailList" href="#" onclick="sendSubscriberListEmail()" class="btn btn-outline-danger d-none"><i class="icon-paper-plane"></i> Send All</a>
            </div>
        </div>
    </div>
</div>
</body>

</html>
