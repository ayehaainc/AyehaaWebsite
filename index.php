<?php include "classes.php" ?>
<?php
$customerId = SessionManager::getCustomerId();
$securityUserId = SessionManager::getSecurityUserId();
$errors = "";
$mailSent = false;

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check for empty fields
    if(empty($_POST['name'])      ||
        empty($_POST['email'])     ||
        empty($_POST['phone'])     ||
        empty($_POST['message'])   ||
        !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
    {
        $errors = "Please complete all required fields to send an email.";
        return false;
    }
    else{
        $name = strip_tags(htmlspecialchars($_POST['name']));
        $email_address = strip_tags(htmlspecialchars($_POST['email']));
        $phone = strip_tags(htmlspecialchars($_POST['phone']));
        $message = strip_tags(htmlspecialchars($_POST['message']));

        // Create the email and send the message
        $email_subject = "Website Contact Form:  $name";
        $email_body = "You have received a new message from your website contact form.<br/><br/>"."Here are the details:<br/><br/>Name: $name<br/><br/>Email: $email_address<br/><br/>Phone: $phone<br/><br/>Message:<br/>$message";
        if($name != "" && $email_address != "" && $message != ""){
            $mailSent = true;
            Mailer::sendContactEmail($email_address,$email_subject,$email_body);
        }
        else{
            $mailSent = false;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ayehaa Inc.</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="css/new-age.min.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Ayehaa!</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#download">Download</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#features">Features</a>
            </li>
              <li class="nav-item">
                  <a class="nav-link js-scroll-trigger" href="#team">Team</a>
              </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead">
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-lg-7 my-auto">
            <div class="header-content mx-auto">
              <h1>Ayehaa Inc.</h1>
                <h3 class="mb-5">Decentralized social media<i class="icon-bubble small"></i></h3>
                <?php
                if($securityUserId > 0){
                    ?>
                    <a href="admin-home.php" class="btn btn-outline btn-xl"><i class="icon-lock"></i> Administration</a>
                    <?php
                }
                else if($customerId > 0){
                    ?>
                    <a href="customer-profile.php" class="btn btn-outline btn-xl"><i class="icon-user"></i> My Profile</a>
                <?php
                }
                else{
                    ?>
                    <a href="#download" class="btn btn-outline btn-xl js-scroll-trigger">Learn More</a>
                <?php
                }
                ?>
            </div>
          </div>
          <div class="col-lg-5 my-auto">

              <div id="divAlertMsg" class="alert alert-primary d-none" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <b id="lblAlertMsg"></b>
              </div>

              <div id="divSubscriberForm">
                  <!--email section-->
                  <label>Sign Up for Launch Updates</label>
                  <div class="form-inline">
                      <label class="sr-only" for="emailAddress">Email Address</label>
                      <input type="email" class="form-control mb-2 mr-sm-2" name="emailAddress" id="emailAddress" placeholder="Example@email.com" required>
                      <a href="#" id="SignUp" name="SignUp" class="btn btn-outline-primary mb-2" onclick="if(doValidation(this.id)) $(this).addClass('d-none');">Submit</a>
                      <a href="#" id="Clear" name="Clear" class="btn btn-outline-danger mb-2 d-none" onclick="if(doValidation(this.id)) $(this).addClass('d-none');">Clear</a>
                  </div>
                  <!--validate against bot-->
                  <div id="divBotValidator" class="d-none">
                      <label for="form_message">What is <span id="lblA1"></span> + <span id="lblA2"></span>?</label>
                      <div class="form-inline">
                          <input id="validationQuestion" type="number" class="form-control mb-2 mr-sm-2" placeholder="Prove you're not a robot *" required>

                          <a href="#" id="Validate" name="Validate" class="btn btn-outline-primary mb-2" onclick="doValidation(this.id)">Verify</a>
                      </div>
                  </div>
              </div>

          </div>
        </div>
      </div>
    </header>

    <section class="download bg-primary text-center" id="download">
      <div class="container">
        <div class="row">
          <div class="col-md-8 mx-auto">
            <h2 class="section-heading">Discover what all the Ayehaa is about!</h2>
            <p>Our app is currently under development and will be available on any mobile device!<br>
                <a class="js-scroll-trigger text-dark" href="#page-top">Sign up for launch updates to stay in the loop!</a></p>

            <div class="badges">
              <a class="badge-link" href="#" data-toggle="modal" data-target="#exampleModal"><img src="img/google-play-badge.svg" alt=""></a>
              <a class="badge-link" href="#" data-toggle="modal" data-target="#exampleModal"><img src="img/app-store-badge.svg" alt=""></a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="features" id="features">
      <div class="container">
        <div class="section-heading text-center">
          <h2>Unlimited Benefits, Unlimited Fun</h2>
          <p class="text-muted">Check out what you can do with this app!</p>
          <hr>
        </div>
        <div class="row">
          <div class="col-lg-12 my-auto">
            <div class="container-fluid">
              <div class="row">
                  <div class="col-lg-4">
                      <div class="feature-item">
                          <i class="icon-bubbles text-primary"></i>
                          <h3>Flexible Use</h3>
                          <p class="text-muted">Put an image, video, animation, or anything else in the screen!</p>
                      </div>
                  </div>
                    <div class="col-lg-4">
                      <div class="feature-item">
                        <i class="icon-wallet text-primary"></i>
                        <h3>Flexible Use</h3>
                        <p class="text-muted">Put an image, video, animation, or anything else in the screen!</p>
                      </div>
                    </div>
                  <div class="col-lg-4">
                      <div class="feature-item">
                          <i class="icon-lock text-primary"></i>
                          <h3>Flexible Use</h3>
                          <p class="text-muted">Put an image, video, animation, or anything else in the screen!</p>
                      </div>
                  </div>
              </div>
                <div class="row">

                    <div class="col-lg-4">
                        <div class="feature-item">
                            <i class="icon-rocket text-primary"></i>
                            <h3>Flexible Use</h3>
                            <p class="text-muted">Put an image, video, animation, or anything else in the screen!</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <i class="icon-bulb text-primary"></i>
                            <h3>Flexible Use</h3>
                            <p class="text-muted">Put an image, video, animation, or anything else in the screen!</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <i class="icon-refresh text-primary"></i>
                            <h3>Flexible Use</h3>
                            <p class="text-muted">Put an image, video, animation, or anything else in the screen!</p>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="cta">
      <div class="cta-content">
        <div class="container">
          <h2>Stop waiting.<br>Start gaining.</h2>
          <a href="#contact" class="btn btn-outline btn-xl js-scroll-trigger">Let's Get Started!</a>
        </div>
      </div>
      <div class="overlay"></div>
    </section>
    <section class="contact bg-light" id="team">
        <div class="container">
            <!-- Introduction Row -->
            <h1 class="my-4">
                It's Nice to Meet You!
            </h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint, explicabo dolores ipsam aliquam inventore corrupti eveniet quisquam quod totam laudantium repudiandae obcaecati ea consectetur debitis velit facere nisi expedita vel?</p>
            <a href="#contact" class="btn btn-outline-dark js-scroll-trigger">Let's Get In Touch!</a>
            <!-- Team Members Row -->
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="my-4">Our Team</h2>
                </div>
                <div class="col-lg-4 col-sm-6 text-center mb-4">
                    <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                    <h3>John Smith</h3>
                    <small class="text-muted">Job Title</small>
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6 text-center mb-4">
                    <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                    <h3>John Smith</h3>
                    <small class="text-muted">Job Title</small>
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6 text-center mb-4">
                    <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                    <h3>John Smith</h3>
                    <small class="text-muted">Job Title</small>
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-4 text-center mb-4">
                    <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                    <h3>John Smith</h3>
                    <small class="text-muted">Job Title</small>
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-4 text-center mb-4">
                    <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                    <h3>John Smith</h3>
                    <small class="text-muted">Job Title</small>
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-4 text-center mb-4">
                    <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                    <h3>John Smith</h3>
                    <small class="text-muted">Job Title</small>
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-4 text-center mb-4">
                    <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                    <h3>John Smith</h3>
                    <small class="text-muted">Job Title</small>
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="icon-social-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="contact bg-dark text-white" id="contact">
      <div class="container">
          <div class="row mb-5">
              <div class="col-md-6 offset-md-3 text-center">
                  <h3>Send us a Message</h3>
                  <form name="contactForm" id="contactForm" method="post">
                      <div class="control-group form-group">
                          <div class="controls">
                              <label>Full Name:</label>
                              <input type="text" class="form-control" id="name" name="name" required
                                     data-validation-required-message="Please enter your name.">
                              <p class="help-block"></p>
                          </div>
                      </div>
                      <div class="control-group form-group">
                          <div class="controls">
                              <label>Phone Number:</label><small> (optional)</small>
                              <input type="tel" class="form-control" id="phone" name="phone">
                          </div>
                      </div>
                      <div class="control-group form-group">
                          <div class="controls">
                              <label>Email Address:</label>
                              <input type="email" class="form-control" id="email" name="email" required
                                     data-validation-required-message="Please enter your email address.">
                          </div>
                      </div>
                      <div class="control-group form-group">
                          <div class="controls">
                              <label>Message:</label>
                              <textarea rows="10" cols="100" class="form-control" id="message" name="message" required
                                        data-validation-required-message="Please enter your message" maxlength="999"
                                        style="resize:none"></textarea>
                          </div>
                      </div>
                      <div id="divDanger" class="d-none"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Please review your entries. </strong></div></div>
                      <div id="divSuccess" class="d-none"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Your message has been sent. </strong></div></div>
                      <!-- For success/fail messages
                      <button type="submit" class="btn btn-primary">Send Message</button>-->
                      <a onclick="sendContactEmail();" class="btn btn-primary">Send Message</a>
                  </form>
              </div>
          </div>
          <h2>We
              <i class="fa fa-heart"></i>
              new friends!</h2>
          <ul class="list-inline list-social">
              <li class="list-inline-item social-twitter">
                  <a href="#">
                      <i class="fa fa-twitter"></i>
                  </a>
              </li>
              <li class="list-inline-item social-facebook">
                  <a href="#">
                      <i class="fa fa-facebook"></i>
                  </a>
              </li>
              <li class="list-inline-item social-google-plus">
                  <a href="#">
                      <i class="fa fa-instagram"></i>
                  </a>
              </li>
          </ul>
      </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
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
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="#" data-toggle="modal" data-target="#exampleModal">Privacy</a>
                </li>
                <li class="list-inline-item">
                    <a href="#" data-toggle="modal" data-target="#exampleModal">Terms</a>
                </li>
                <li class="list-inline-item">
                    <a href="#" data-toggle="modal" data-target="#exampleModal">FAQ</a>
                </li>
            </ul>
            <p>&copy; <?php echo date("Y") ?>&nbsp;Ayehaa Inc. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>

    <script>
        //Document Ready Function for page
        $( document ).ready(function() {
            //generate random numbers for form validation
            randomnum1 = Math.floor((Math.random() * 10) + 1);
            randomnum2 = Math.floor((Math.random() * 10) + 1);
            $("#lblA1").text(randomnum1);   //assign numbers to labels
            $("#lblA2").text(randomnum2);

            $("#emailAddress").on('keyup', function (e) {
                //if user hits enter on email sign up input
                if (e.keyCode == 13) {
                    //enter key
                    doValidation("SignUp");
                }
            });
            $("#validationQuestion").on('keyup', function (e) {
                //if user hits enter on validation question
                if (e.keyCode == 13) {
                    doValidation("Validate");
                }
            });
        });

        function validateEmail(email) {
            //checks if email input is valid format
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email.toLowerCase());
        }

        function doValidation(cmd){
            cmd = cmd.toUpperCase();
            switch (cmd){
                case "SIGNUP":
                    var emailaddress = $("#emailAddress").val();

                    if(emailaddress.length > 0){
                        if(validateEmail(emailaddress)){
                            //valid email address was entered
                            $("#SignUp").addClass("d-none");
                            $("#Clear").removeClass("d-none");
                            $("#emailAddress").addClass("is-valid");
                            $("#emailAddress").prop("disabled", true);  //disable email so we have this email value locked in
                            $('#divBotValidator').removeClass('d-none');    //show random number validation question
                        }
                        else{
                            $("#emailAddress").addClass("is-invalid");
                            return false;
                        }
                    }
                    else{
                        $("#emailAddress").addClass("is-invalid");
                        return false;
                    }
                    return true;
                case "VALIDATE":
                    var validationAnswer = $("#validationQuestion").val();  //capture solution entered by user
                    var validationSolution = randomnum1 + randomnum2;       //calculate solution by random generated numbers
                    if(validationAnswer == validationSolution){
                        //solution entered by user was correct
                        $("#divSubscriberForm").addClass("d-none"); //remove subscriber form

                        //call AJAX function to add subscriber to db
                        addSubscriber($("#emailAddress").val());

                        return true;
                    }
                    $("#validationQuestion").addClass("is-invalid");
                    return false;
                case "CLEAR":
                    //provides a way for the user to clear and re-enter email
                    $("#emailAddress").val(''); //clear email value
                    $("#SignUp").removeClass("d-none"); //show
                    $("#Clear").addClass("d-none");     //hide
                    $("#emailAddress").removeClass("is-valid");
                    $("#emailAddress").prop("disabled", false);  //enable email field
                    $('#divBotValidator').addClass('d-none');    //hide random number validation
                    return true;
            }

        }
        function addSubscriber(email){
            $.ajax({
                type: 'POST',
                url: 'AJAX/addSubscriber.php',
                data: {
                    'email': email
                },
                success: function(msg){
                    if(msg === ""){
                        alert("Posting failed.");
                    }
                    else{
                        $("#divAlertMsg").removeClass("d-none");    //show success message
                        $("#lblAlertMsg").html(msg);
                    }

                }
            });
            return false;
        }
        function sendContactEmail(){
            var returnValue = true;
            var name = $("#name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var message = $("#message").val();
            if(name.length > 0){
                $("#name").addClass("is-valid");
            }
            else {
                $("#name").addClass("is-invalid");
                returnValue = false;
            }
            if(email.length > 0){
                $("#message").addClass("is-valid");
            }
            else {
                $("#email").addClass("is-invalid");
                returnValue = false;
            }
            if(message.length > 0){
                $("#message").addClass("is-valid");
            }
            else {
                $("#message").addClass("is-invalid");
                returnValue = false;
            }
            if(returnValue){
                $.ajax({
                    type: 'POST',
                    url: 'sendContactEmail.php',
                    data: {
                        'name': name,
                        'email': email,
                        'phone': phone,
                        'message': message
                    },
                    success: function(msg){
                        if(msg.toUpperCase() === "SUCCESS"){
                            $("#divSuccess").removeClass("d-none");
                            $("#divDanger").addClass("d-none");
                        }
                        else{
                            $("#divSuccess").addClass("d-none");
                            $("#divDanger").removeClass("d-none");
                        }

                    }
                });
            }
            else{
                $("#divDanger").removeClass("d-none");
            }

        }
    </script>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalTitle"><i class="icon-screen-smartphone"></i> Our App is coming soon!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><i class="icon-rocket"></i> The Ayehaa app is currently under development.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  </body>

</html>
