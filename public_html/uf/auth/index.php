<?php
require_once("../scripts/functions.php");
checkAccess();
$n1 = rand(0, 9);
$n2 = rand(0, 9);
$n3 = rand(0, 9);
$n4 = rand(0, 9);
$n5 = rand(0, 9);
$n6 = rand(0, 9);
$captcha = "$n1$n2$n3$n4$n5$n6";
?>
<!DOCTYPE html>
<html lang="en-US" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $description ?>">
    <link rel="shortcut icon" href="../images/<?php echo $favicon ?>" type="image/x-icon">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../images/<?php echo $favicon ?>">
    <!-- Page Title  -->
    <title>Home | Welcome to <?php echo "$sitename"; ?> Online Banking</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../assets/css/dashlite.css?ver=2.4.0">
    <link rel="stylesheet" href="../scss/sweetalert.css">
    <link id="skin-default" rel="stylesheet" href="../assets/css/theme.css?ver=2.4.0">
    <link id="skin-default" rel="stylesheet" href="../assets/css/theme.css?ver=2.4.0">
    <link href="../css/toastr.css" rel="stylesheet" />
</head>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<style>
    .goog-te-gadget-simple {
        border: none;
    }

    .goog-te-gadget-simple a {
        color: #000;
    }
</style>
<style type="text/css">
    .btn-primary {
        background-color: #033d75;
    }

    .btn-secondary {
        background-color: #d13636;
    }

    .btn-secondary:hover {
        opacity: 0.6;
    }

    .btn-primary:hover {
        opacity: 0.6;
    }
</style>
<style>
    input[type=number] {
        height: 50px;
        width: 50px;
        font-size: 25px;
        color: #033d75;
        text-align: center;
        border: 3px solid #033d75;
        box-shadow: 4px #033d75;
        border-radius: 7px;
        font-weight: 600;
    }

    input[type=number]:focus {
        border-bottom: 5px solid #008000;

    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<body class="nk-body npc-crypto bg-white pg-auth">
    <!-- app body @s -->
    <div class="nk-app-root">
        <div class="nk-split nk-split-page nk-split-md">
            <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                    <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                </div>
                <div class="nk-block nk-block-middle nk-auth-body">
                    <div class="brand-logo pb-5">
                        <a href="../" class="logo-link">
                            <img class="logo-light logo-img logo-img-lg" src="../<?php echo $logo ?>" srcset="../<?php echo $logo ?>" alt="logo">
                            <img class="logo-dark logo-img logo-img-lg" src="../<?php echo $logo ?>" srcset="../<?php echo $logo ?>" alt="logo-dark">
                        </a>
                    </div>

                    <br>
                    <?php if (isset($_GET['action']) and $_GET['action'] == "verify") { ?>
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title">Authentication</h3>
                                <div class="nk-block-des alert alert-pro alert-primary">
                                    <p class="alert-text">Let's make sure it's really you. We just sent a verification code to the email address that is associated with your <?php echo $sitename ?> account. Enter the 4 digits code below;</p>
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <form action="../scripts/auth?action=userVerify2fa" id="2faForm" method="post">
                            <div class="form-group nk-feature-center">
                                <input id="codeBox1" name="codeBox1" type="number" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)" />
                                <input id="codeBox2" name="codeBox2" type="number" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)" />
                                <input id="codeBox3" name="codeBox3" type="number" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)" />
                                <input id="codeBox4" name="codeBox4" type="number" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)" />
                            </div><!-- foem-group -->
                            <div class="form-group">
                                <div id="loginResult"></div>
                            </div><!-- .foem-group -->
                            <div class="form-group">
                                <button class="btn btn-lg btn-primary btn-block" type="submit" id="btn">Verify</button>
                            </div>
                        </form><!-- form -->
                        <center class="p-3">
                            <a href="../personal-banking/logout" class="btn btn-sm btn-secondary"><em class="icon ni ni-delete"></em>Cancel</a>
                        </center>
                        <!------------Password Reset--------->
                    <?php } elseif (isset($_GET['action']) and $_GET['action'] == "resetpass") { ?>
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title">Reset Account password</h3>
                                <div class="nk-block-des alert alert-pro alert-primary">
                                    <p class="alert-text">Kindly provide your <?php echo $sitename ?> Account ID.</p>
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <form action="../scripts/auth?action=userPassReset" id="resetForm" method="post">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="default-01">Account ID</label>
                                </div>
                                <input type="text" class="form-control form-control-lg" autocomplete="off" id="id" placeholder="Enter your Account ID" name="id" required>
                            </div><!-- foem-group -->
                            <div class="form-group">
                                <link href="https://fonts.googleapis.com/css?family=Henny+Penny&display=swap" rel="stylesheet">
                                <div style="height: 46px; line-height: 46px; width:100%; text-align: center; background-color: #033d75; color: #ffffff!important; font-size: 26px; font-weight: bold; letter-spacing: 20px; font-family: 'Henny Penny', cursive;  -webkit-user-select: none; -moz-user-select: none;-ms-user-select: none;user-select: none;  display: flex; justify-content: center;" class="captcha"><span style="    float:left;     -webkit-transform: rotate(55deg);"><?php echo $n1 ?></span><span style="    float:left;     -webkit-transform: rotate(17deg);"><?php echo $n2 ?></span><span style="    float:left;     -webkit-transform: rotate(-56deg);"><?php echo $n3 ?></span><span style="    float:left;     -webkit-transform: rotate(-51deg);"><?php echo $n4 ?></span><span style="    float:left;     -webkit-transform: rotate(0deg);"><?php echo $n5 ?></span><span style="    float:left;     -webkit-transform: rotate(-45deg);"><?php echo $n6 ?></span></div><input type="hidden" name="captcha_secret" value="da6f040a13868b805eb3654ba0607afef7fa0c157ee5c3a5352eb625efb7bd32">
                            </div>
                            <div id="resetResult"></div>
                            <div class="form-group">
                                <input type="text" name="captcha" id="captcha" class="form-control form-control-xl" placeholder="Enter code" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-lg btn-primary btn-block secretFordm" type="submit" id="btn">Continue</button>
                            </div>
                        </form><!-- form -->
                        <center class="p-3">
                            <a href="index?action=enroll&access=<?php echo $_SESSION['accessBanking'] ?>" class="btn btn-sm btn-secondary"><em class="icon ni ni-regen"></em> Enroll for Online Banking</a>
                        </center>
                        <center class="p-3">
                            <a href="index" class="btn btn-sm btn-default"><em class="icon ni ni-forward-ios"></em> Login</a>
                        </center>

                        <!---PASSWORD RESET CONFIRMATION -------->
                    <?php } elseif (isset($_GET['action']) and $_GET['action'] == "resetPass") {
                        if (!isset($_GET['userToken']) or empty($_GET['userToken'])) {
                            print i_redirect("../");
                        } else {
                            $token = $_GET['userToken'];
                            $query = $conn->query("SELECT * FROM password_resets WHERE token = '$token'");
                            if (mysqli_num_rows($query) < 1) {
                                print i_redirect("../");
                            } elseif (mysqli_num_rows($query) == 1) {
                                $r = mysqli_fetch_array($query);
                                $user = $r['user_id'];
                            } else {
                                print i_redirect("../");
                            }
                        }
                    ?>
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title">Change Account password</h3>
                                <div class="nk-block-des alert alert-pro alert-primary">
                                    <p class="alert-text">Accurately fill in the form below to change your account password.</p>
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <form action="../scripts/auth?action=userPassResetConfirm&token=<?php echo $token ?>&code=<?php echo $captcha ?>" id="resetFormConfirm" method="post">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="npassword">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input type="password" required class="form-control form-control-lg" id="npassword" placeholder="Enter new password" name="npassword">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="cnpassword">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input type="password" required class="form-control form-control-lg" id="cnpassword" placeholder="Confirm password" name="cnpassword">
                                </div>
                            </div>
                            <div class="form-group">
                                <link href="https://fonts.googleapis.com/css?family=Henny+Penny&display=swap" rel="stylesheet">
                                <div style="height: 46px; line-height: 46px; width:100%; text-align: center; background-color: #033d75; color: #ffffff!important; font-size: 26px; font-weight: bold; letter-spacing: 20px; font-family: 'Henny Penny', cursive;  -webkit-user-select: none; -moz-user-select: none;-ms-user-select: none;user-select: none;  display: flex; justify-content: center;" class="captcha"><span style="    float:left;     -webkit-transform: rotate(55deg);"><?php echo $n1 ?></span><span style="    float:left;     -webkit-transform: rotate(17deg);"><?php echo $n2 ?></span><span style="    float:left;     -webkit-transform: rotate(-56deg);"><?php echo $n3 ?></span><span style="    float:left;     -webkit-transform: rotate(-51deg);"><?php echo $n4 ?></span><span style="    float:left;     -webkit-transform: rotate(0deg);"><?php echo $n5 ?></span><span style="    float:left;     -webkit-transform: rotate(-45deg);"><?php echo $n6 ?></span></div><input type="hidden" name="captcha_secret" value="da6f040a13868b805eb3654ba0607afef7fa0c157ee5c3a5352eb625efb7bd32">
                            </div>
                            <div id="resetResultConfirm"></div>
                            <div class="form-group">
                                <input type="text" name="captcha" id="captcha" class="form-control form-control-xl" placeholder="Enter code" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-lg btn-primary btn-block" type="submit" id="btn">Change password</button>
                            </div>
                        </form><!-- form -->
                        <center class="p-3">
                            <a href="index" class="btn btn-sm btn-secondary"><em class="icon ni ni-forward-ios"></em> Login</a>
                        </center>
                        <script src="../js/jquery.min.js"></script>
                        <script type="text/javascript">
                            //PASSWORD RESET CONFIRMATION
                            $(document).ready(function(e) {
                                $("#resetFormConfirm").on('submit', (function(e) {
                                    document.getElementById("btn").disabled = true;
                                    e.preventDefault();
                                    $.ajax({
                                        url: "../scripts/auth?action=userPassResetConfirm&token=<?php echo $token ?>&code=<?php echo $captcha ?>",
                                        type: "POST",
                                        data: new FormData(this),
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        success: function(data) {
                                            $("#resetResultConfirm").html(data);
                                            document.getElementById("btn").disabled = false;
                                        },
                                        error: function() {}
                                    });
                                }));
                            });
                        </script>
                    <?php } elseif (isset($_GET['action']) and $_GET['action'] == "enroll") { ?>

                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title">Enroll a new Account</h3>
                                <div class="nk-block-des alert alert-pro alert-primary">
                                    <p class="alert-text">Before you continue, Kindly read and accept our terms and conditions.</p>
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <form action="../scripts/auth?action=userLogin" id="loginForm" method="post">
                            <h3 style="font-weight:700; color:Purple;">TERMS AND CONDITIONS</h3>

                            <textarea name="terms" rows="12" class="form-control" readonly="readonly" cols="70" style="text-align: justify;
 width:100%; padding: 10px; font-size:16px;" autocomplete="off">
                                    Before you can start using our online service you must agree to be bound by the conditions below.  You must read the conditions before you 
                                    decide whether to accept them.  If you agree to be bound by these conditions, please click the I accept button below.  If you click on the
                                    Decline button, you will not be able to continue your registration for our online services. We strongly recommend that you print a copy of 
                                    these conditions for your reference.

                                    1. DEFINITIONS.
                                    In these conditions the following words have the following meanings.

                                    - ACCOUNT:  any account which you hold and access via our online service.

                                    - ADDITIONAL SECURITY DETAILS:  the additional information you give us to
                                    help us identify you including the additional security question you 
                                    provide yourself.

                                    - IDENTITY DETAILS:  the access code we may provide you with.

                                    - <?php echo $sitename ?> ACCOUNT ID, PASSWORD and ACCOUNT PIN   you choose to identify 
                                    yourself when you use our online service.


                                    - YOU, YOUR and YOURSELF  refer to the person who has entered into this 
                                    agreement with us.

                                    2. USING THE ONLINE SERVICE.

                                    a. These conditions apply to your use of our online service and in relation to any accounts.  They explain the relationship between you and
                                    us in relation to our online service.  You should read these conditions carefully to understand how these services work and your and our rights
                                    and duties under them.  If there is a conflict between these conditions and your account conditions, these conditions will apply.  This means 
                                    that, when you use our online service both sets of conditions will apply unless they contradict each other in which case, the relevant condition
                                    in these conditions apply.

                                    b. If any of your accounts is a joint account, these conditions apply to all of you together and any of you separately.  If more than one of you
                                    uses our online service you must each choose your own username, password and additional security details.

                                    c. By registering to use our online service, you accept these conditions and agree that we may communicate with you by e-mail or through our website.

                                    d. When you use our online service you must follow the instructions we give you from time to time.  You are responsible for ensuring that your 
                                    computer, software and other equipment are capable of being used with our online service.

                                    e. Our online sites are secure.  Disconnection from the Internet or leaving these sites will not automatically log you off.  You must always
                                    use the log off facility when you are finished and never leave your machine unattended while you are logged in.  As a security measure, if 
                                    you have not used the sites for more than a specified period of time we will ask you to log in again. 

                                    3. WHAT RULES APPLY TO SECURITY?

                                    a. As part of the registration for our online service you must provide us with identity details before we will allow you to use the services 
                                    for the first time.  You must enter your identity details immediately after signing in, so we can identify you.

                                    b. Every time you use our online service you must give us your username, your password and the answer to an additional security question.

                                    c. You can change your username or password online by following the instructions on the screen.  

                                    d. For administration or security reasons, we can require you to choose a new username or change your password before you use (or carry on using)
                                    our online service.

                                    e. You must not write down, store (whether encrypted or otherwise) on your computer or let anyone else know your password, identity details or
                                    additional security details, and the fact that they are for use with your accounts.

                                    f. If you think that someone else knows your password or any of your additional security details or has used any of them to use our online 
                                    service, you must do the following:

                                    - For your password, change it online as soon as possible.  If you have difficulty changing your password, you must phone us on +1 234 567 8910
                                    immediately.  You can give us your username if you phone to change your password.

                                    - For your additional security details, you will need to phone us immediately to change your additional security details.

                                    g. We may give the police or any prosecuting authority any information they need if we think it will help them find out if someone else is 
                                    using your username, password or any of your additional security details.

                                    h. We may also keep any e-mails sent to or from us.  We do this to check what was written and also to help train our staff.

                                    i. If we think that:

                                    - someone else is trying to use our service for your accounts;

                                    - the wrong username, password or any of your additional security 
                                    details have has been used for your account;

                                    - you or someone else is using our online service illegally;

                                    - you are not keeping to these conditions or the conditions of any of 
                                    your accounts; or 

                                    - your username, password  or any of your additional security details 
                                    might be known or used by someone else,

                                    we can stop you (or someone else) using our online service.  We will tell you as soon as possible if we do this.

                                    j. We may require you to provide one or more of the additional security details and/or enter your password again before we accept instructions 
                                    about your account.

                                    k. You must not tell anyone your password or additional security details.  You can give the Helpdesk your username if you need help to 
                                    change your password or need to report that someone else knows your password, username or additional security details.

                                    l. For your protection, we occasionally check requests to move or transfer money. Therefore, some transactions may be subject to a delay 
                                    of up to 24 hours whilst these checks are carried out.

                                    4. WHAT IS THE EXTENT OF YOUR LIABILITY?

                                    a. If you are a victim of online fraud, we guarantee that you wont lose any money on your accounts and will always be reimbursed in full.

                                    b. Unless you are a victim of fraud you are responsible for all instructions and other information sent using your username, password or
                                    additional security details.

                                    c. You will not be held responsible for any instructions or information sent after you have told us that someone knows your password or 
                                    additional security details and has used any of them to access our online service.

                                    d. <?php echo $sitename ?> do not accept responsibility for any loss you or anybody else may suffer because any instructions or information you sent us are sent in 
                                    error, fail to reach us or are distorted unless you have been the victim of fraud.

                                    e. <?php echo $sitename ?> do not accept responsibility for any loss you or anybody else may suffer because any instructions or information we send you fail to reach
                                    you or are distorted unless you have been the victim of fraud.

                                    5. HOW WE CAN CHANGE THESE CONDITIONS

                                    a. <?php echo $sitename ?> change these conditions for any reason by giving you written notice or publishing the change on our website.

                                    b. We may send all written notices to you at the last e-mail address you gave us.  You must let us know immediately if you change your e-mail 
                                    address (you can do so online), to make sure that we have your current e-mail address at all times.

                                    6. GENERAL

                                    <?php echo $sitename ?> service is available to you if you are 18 years of age or over.
                                </textarea>
                            <br><br>
                            <button id="btn1" class="btn btn-secondary"><a href="index" style="color:white;">Decline</a></button>&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            <button id="btn1" class="btn btn-primary"><a href="register?tc=1" style="color:white;">I Accept</a></button>
                        </form><!-- form -->

                    <?php } else { ?>

                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title">Sign-In</h3>
                                <div class="nk-block-des alert alert-pro alert-primary">
                                    <p class="alert-text">Access the <?php echo $sitename ?> online banking panel using your Account ID and password.</p>
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <form action="../scripts/auth?action=userLogin" id="loginForm" method="post">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="default-01">Account ID</label>
                                </div>
                                <input type="text" class="form-control form-control-lg" required autocomplete="off" id="id" placeholder="Enter your Account ID" name="id">
                            </div><!-- foem-group -->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="password">Passsword</label>
                                    <a class="link link-primary link-sm" tabindex="-1" href="index?action=resetpass&access=<?php echo $_SESSION['accessBanking'] ?>">Forgot Code?</a>
                                </div>
                                <div class="form-control-wrap">
                                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="pass">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input type="password" class="form-control form-control-lg" id="pass" required placeholder="Enter your password" name="pass">
                                </div>
                                <div id="loginResult"></div>
                            </div><!-- .foem-group -->
                            <div class="form-group">
                                <button class="btn btn-lg btn-primary btn-block secretFordm" type="submit" id="btn">Continue</button>
                            </div>
                        </form><!-- form -->
                        <center class="p-3">
                            <a href="index?action=enroll&access=<?php echo $_SESSION['accessBanking'] ?>" class="btn btn-sm btn-secondary"><em class="icon ni ni-regen"></em> Enroll for Online Banking</a>
                        </center>
                    <?php } ?>
                </div><!-- .nk-block -->
                <div class="nk-block nk-auth-footer">
                    <a href="#" style="">
                        <div id="google_translate_element"></div>
                    </a>
                    <div class="mt-3">
                        <p>&copy; <?php echo "" . date("Y") . ""; ?> <?php echo $sitename; ?>. All Rights Reserved.</p>
                    </div>
                </div><!-- .nk-block -->
            </div><!-- .nk-split-content -->
            <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                    <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                        <div class="slider-item">
                            <div class="nk-feature nk-feature-center">
                                <div class="nk-feature-img">
                                    <img class="round" src="../images/security.svg" srcset="../images/security.svg 2x" alt="">
                                </div>
                                <div class="nk-feature-content py-4 p-sm-5">
                                    <h4>Protect your online banking.</h4>
                                    <p>We have security measures in place to safeguard your money, because we are committed to providing you with a secure banking experience. When we come across any hoaxes or scams that target customers, we will raise them to your attention.</p>
                                </div>
                            </div>
                        </div><!-- .slider-item -->
                        <div class="slider-item">
                            <div class="nk-feature nk-feature-center">
                                <div class="nk-feature-img">
                                    <img class="round" src="../images/banking.svg" srcset="../images/banking.svg 2x" alt="">
                                </div>
                                <div class="nk-feature-content py-4 p-sm-5">
                                    <h4><?php echo $sitename ?></h4>
                                    <p>We'll never send an email containing a link to <?php echo "$sitename"; ?>.<br>
                                        We'll never ask for your passwords or Secret Code.</p>
                                </div>
                            </div>
                        </div><!-- .slider-item -->
                        <div class="slider-item">
                            <div class="nk-feature nk-feature-center">
                                <div class="nk-feature-img">
                                    <img class="round" src="../images/onlinebanking.svg" srcset="../images/onlinebanking.svg 2x" alt="">
                                </div>
                                <div class="nk-feature-content py-4 p-sm-5">
                                    <h4><?php echo $sitename ?></h4>
                                    <p>When accessing <?php echo $sitename ?> online banking, always open a new browser window and type <?php echo $_SERVER['HTTP_HOST']; ?></p>
                                </div>
                            </div>
                        </div><!-- .slider-item -->
                    </div><!-- .slider-init -->
                    <div class="slider-dots"></div>
                    <div class="slider-arrows"></div>
                </div><!-- .slider-wrap -->
            </div><!-- .nk-split-content -->
        </div><!-- .nk-split -->
    </div><!-- app body @e -->
    <!-- JavaScript -->
    <script src="../js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#loginForm").on('submit', (function(e) {
                document.getElementById("btn").disabled = true;
                e.preventDefault();
                $.ajax({
                    url: "../scripts/auth?action=userLogin",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $("#loginResult").html(data);
                        // execute any inline scripts returned by server
                        $("#loginResult").find('script').each(function(){
                            try { $.globalEval($(this).text() || this.textContent || this.innerHTML); } catch(e) { console.error('script eval error', e); }
                        });
                        document.getElementById("btn").disabled = false;
                    },
                    error: function(xhr, status, err) {
                        $("#loginResult").html('<div class="alert alert-danger">Request failed: '+status+'</div>');
                        console.error('auth userLogin AJAX error', status, err, xhr.responseText);
                    }
                });
            }));
        });
        //2FA FORM VERIFICATION
        $(document).ready(function(e) {
            $("#2faForm").on('submit', (function(e) {
                document.getElementById("btn").disabled = true;
                e.preventDefault();
                $.ajax({
                    url: "../scripts/auth?action=userVerify2fa",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $("#loginResult").html(data);
                        $("#loginResult").find('script').each(function(){
                            try { $.globalEval($(this).text() || this.textContent || this.innerHTML); } catch(e) { console.error('script eval error', e); }
                        });
                        document.getElementById("btn").disabled = false;
                    },
                    error: function(xhr, status, err) {
                        $("#loginResult").html('<div class="alert alert-danger">Request failed: '+status+'</div>');
                        console.error('auth 2fa AJAX error', status, err, xhr.responseText);
                    }
                });
            }));
        });

        //USER PASSWORD RESET
        $(document).ready(function(e) {
            $("#resetForm").on('submit', (function(e) {
                document.getElementById("btn").disabled = true;
                e.preventDefault();
                $.ajax({
                    url: "../scripts/auth?action=userPassReset&code=<?php echo $captcha ?>",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $("#resetResult").html(data);
                        document.getElementById("btn").disabled = false;
                    },
                    error: function() {}
                });
            }));
        });



        //2FA INPUTS
        function getCodeBoxElement(index) {
            return document.getElementById('codeBox' + index);
        }

        function onKeyUpEvent(index, event) {
            const eventCode = event.which || event.keyCode;
            if (getCodeBoxElement(index).value.length === 1) {
                if (index !== 4) {
                    getCodeBoxElement(index + 1).focus();
                } else {
                    getCodeBoxElement(index).blur();
                    // Submit code
                    console.log('submit code ');
                }
            }
            if (eventCode === 8 && index !== 1) {
                getCodeBoxElement(index - 1).focus();
            }
        }

        function onFocusEvent(index) {
            for (item = 1; item < index; item++) {
                const currentElement = getCodeBoxElement(item);
                if (!currentElement.value) {
                    currentElement.focus();
                    break;
                }
            }
        }
        var max_chars = 1;

        $('#codeBox1').keydown(function(e) {
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
        });

        $('#codeBox1').keyup(function(e) {
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
        });
        $('#codeBox2').keydown(function(e) {
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
        });

        $('#codeBox2').keyup(function(e) {
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
        });
        $('#codeBox3').keydown(function(e) {
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
        });

        $('#codeBox3').keyup(function(e) {
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
        });
        $('#codeBox4').keydown(function(e) {
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
        });

        $('#codeBox4').keyup(function(e) {
            if ($(this).val().length >= max_chars) {
                $(this).val($(this).val().substr(0, max_chars));
            }
        });
    </script>
    <script src="../assets/js/bundle.js?ver=2.4.0"></script>
    <script src="../assets/js/scripts.js?ver=2.4.0"></script>
    <script src="../js/vendors/sweetalert.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../js/toastr.js"></script>
</body>

</html>