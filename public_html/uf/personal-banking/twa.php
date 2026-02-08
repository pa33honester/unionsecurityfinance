<?php
require_once("../scripts/functions.php");

 ?>   
<!DOCTYPE html>
<html lang="en-US" class="js">

<head>  
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $description ?>">
    <link rel="shortcut icon" href="../<?php echo $favicon ?>" type="image/x-icon">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../<?php echo $favicon ?>">
    <!-- Page Title  -->
    <title>Two factor Authentication |  Welcome to <?php  echo "$sitename";?> Online Banking</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../assets/css/dashlite.css?ver=2.4.0">
    <link rel="stylesheet" href="../scss/sweetalert.css">
    <link id="skin-default" rel="stylesheet" href="../assets/css/theme.css?ver=2.4.0">
         <link href="../css/toastr.css" rel="stylesheet"/>
</head>

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
                            <img class="logo-light logo-img logo-img-lg" src="../<?php echo $logo ?>" srcset="../images/logo2x.png 2x" alt="logo">
                            <img class="logo-dark logo-img logo-img-lg" src="../<?php echo $darklogo ?>" srcset="../images/logo-dark2x.png 2x" alt="logo-dark">
                        </a>
                    </div>
                    <?php  echo $stockrate ?>
                    <br>
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title">Two factor Authentication</h5>
                            <div class="nk-block-des alert alert-pro alert-primary">
                                <p class="alert-text"><?php echo $sitename ?> are committed to providing you with a secure banking experience.</p>
                            </div>
                            <center>
                                <img src="../images/coins/secure.png" height="85" width="85">
                            </center>
                        </div>
                    </div><!-- .nk-block-head -->
                
                    <form action="#" method="post" id="form">
                        <div class="result">
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label class="form-label" for="default-01">Secret Code</label>
                                <a class="link link-primary link-sm" tabindex="-1" href="#">Need Help?</a>
                            </div>
                            <input type="number"  class="form-control form-control-lg" autocomplete="off" id="secretCode" placeholder="Enter your account Secret code" name="secretCode">
                        </div><!-- .foem-group -->
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block secretForm" type="submit">Sign in</button>
                        </div>
                    </form><!-- form -->
                   
                </div><!-- .nk-block -->
                <div class="nk-block nk-auth-footer">
                    <div class="nk-block-between">
                        <ul class="nav nav-sm">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Terms & Condition</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Privacy Policy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Help</a>
                            </li>
                            <li class="nav-item dropup">
                                <a class="dropdown-toggle dropdown-indicator has-indicator nav-link" data-toggle="dropdown" data-offset="0,10"><small>English</small></a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <ul class="language-list">
                                        <li>
                                            <a href="#" class="language-item">
                                                <img src="../images/flags/english.png" alt="" class="language-flag">
                                                <span class="language-name">English</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="language-item">
                                                <img src="../images/flags/spanish.png" alt="" class="language-flag">
                                                <span class="language-name">Español</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="language-item">
                                                <img src="../images/flags/french.png" alt="" class="language-flag">
                                                <span class="language-name">Français</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="language-item">
                                                <img src="../images/flags/turkey.png" alt="" class="language-flag">
                                                <span class="language-name">Türkçe</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul><!-- .nav -->
                    </div>
                    <div class="mt-3">
                        <p>&copy; <?php echo "".date("Y").""; ?> <?php echo$sitename; ?>. All Rights Reserved.</p>
                    </div>
                </div><!-- .nk-block -->
            </div><!-- .nk-split-content -->
             <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                    <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                        <div class="slider-item">
                            <div class="nk-feature nk-feature-center">
                                <div class="nk-feature-img">
                                    <img class="round" src="../images/slides/secure-login.svg" srcset="../images/slides/secure-login.svg 2x" alt="">
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
                                    <img class="round" src="../images/slides/security.svg" srcset="../images/slides/security.svg 2x" alt="">
                                </div>
                                <div class="nk-feature-content py-4 p-sm-5">
                                    <h4><?php echo$sitename ?></h4>
                                    <p>We'll never send an email containing a link to <?php echo "$sitename"; ?>.<br> 
                                      We'll never ask for your passwords or Secret Code.</p>
                                </div>
                            </div>
                        </div><!-- .slider-item -->
                        <div class="slider-item">
                            <div class="nk-feature nk-feature-center">
                                <div class="nk-feature-img">
                                    <img class="round" src="../images/slides/onlinebanking.svg" srcset="../images/slides/onlinebanking.svg 2x" alt="">
                                </div>
                                <div class="nk-feature-content py-4 p-sm-5">
                                    <h4><?php echo $sitename ?></h4>
                                    <p>When accessing <?php echo $sitename ?> online banking, always open a new browser window and type <?php url();?></p>
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
    <script src="../assets/js/bundle.js?ver=2.4.0"></script>
    <script src="../assets/js/scripts.js?ver=2.4.0"></script>
   <script src="../js/vendors/sweetalert.js"></script>
   <script src="../assets/js/jquery.min.js"></script>
   <script src="../assets/js/custom.js"></script>
<script src="../js/toastr.js"></script>
</body>

</html>