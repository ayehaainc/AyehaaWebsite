<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 12/9/2017
 * Time: 12:32 PM
 */
?>
<!-- Footer -->
<div class="footer">
    <div class="container">
        <p>&copy; <?php echo date("Y") ?>&nbsp;Ayehaa Inc. All Rights Reserved.</p>
        <ul class="list-inline">
            <li class="list-inline-item">
                <a href="#">Privacy</a>
            </li>
            <li class="list-inline-item">
                <a href="#">Terms</a>
            </li>
            <li class="list-inline-item">
                <a href="#">FAQ</a>
            </li>
        </ul>
        <?php if(SessionManager::getSecurityUserId() > 0   //Security user logged in
            && SessionManager::getCustomerId() == 0) {
            ?>
            <small>Hi, <a href="admin-home.php"><?php echo SessionManager::getUsername(); ?></a> &middot; <a href="logout.php">logout</a></small>
            <?php
        }else if(SessionManager::getCustomerId() > 0){  //customer is logged in
            ?>
            <small>Hi, <a href="customer-profile.php"><?php echo SessionManager::getFirstName(); ?></a> &middot; <a href="logout.php">logout</a></small>
            <?php
        }
        else{   //nobody logged in
            ?>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="login.php">Login</a></li>
                <li class="list-inline-item">&middot;</li>
                <li class="list-inline-item"><a href="create-customer.php">Register</a></li>
            </ul>
            <?php
        }
        ?>
    </div>
</div>

<!-- Scroll to Top Button
<a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>-->