<?php
include("../scripts/functions.php");
usserAccessCheck();
include("../scripts/userdata.php");
?>
<!DOCTYPE html>
<html lang="en-US" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Smart">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $description ?>">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../images/<?php echo $favicon ?>">
    <!-- Page Title  -->
    <title><?php echo "$firstname $lastname $middlename"; ?> | <?php echo $sitename ?> Online banking</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../scss/sweetalert.css">
    <link rel="stylesheet" href="../assets/css/dashlite.css?ver=2.4.0">
    <link id="skin-default" rel="stylesheet" href="../assets/css/theme.css?ver=2.4.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/libs/fontawesome-icons.css">
    <link href="../css/toastr.css" rel="stylesheet" />
</head>
<link rel="stylesheet" href="https://www.jqueryscript.net/demo/jQuery-International-Telephone-Input-With-Flags-Dial-Codes/build/css/intlTelInput.css">
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

<body class="nk-body npc-crypto bg-white has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head" style="border-bottom: solid #fe473a;">
                    <div class="nk-sidebar-brand">
                        <a href="dashboard" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="../<?php echo $logo; ?>" srcset="../<?php echo $logo; ?> 2x" alt="logo">
                            <img class="logo-dark logo-img" src="../<?php echo $logo; ?>" srcset="../<?php echo $logo; ?> 2x" alt="logo-dark">

                        </a>
                    </div>
                    <div class="nk-menu-trigger mr-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-body" data-simplebar>
                        <div class="nk-sidebar-content">
                            <div class="nk-sidebar-widget d-none d-xl-block">
                                <div class="user-account-info between-center">
                                    <div class="user-account-main">
                                        <h6 class="overline-title-alt">Available Balance</h6>
                                        <div class="user-balance"><?php echo "" . number_format(currencyConverter($accountbalance)) . ""; ?> <small class="currency currency-btc"><?php echo "$usercurrency"; ?></small></div>
                                        <div class="user-balance-alt"><?php echo number_format($accountbalance); ?> <span class="currency currency-btc"><?php echo $money ?></span></div>
                                    </div>
                                    <a href="#" class="btn btn-white btn-icon btn-light"><em class="icon ni ni-line-chart"></em></a>
                                </div>
                                <ul class="user-account-data gy-1">
                                    <li>
                                        <div class="user-account-label">
                                            <span class="sub-text">Income</span>
                                        </div>
                                        <div class="user-account-value">

                                            <span class="text-success ml-2"><?php echo round(getIncomeValue($userid, 'credit'), 2); ?> %<em class="icon ni ni-arrow-long-up"></em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="user-account-label">
                                            <span class="sub-text">Debits</span>
                                        </div>
                                        <div class="user-account-value">
                                            <span class="text-danger ml-2"><?php echo round(getIncomeValue($userid, 'debit'), 2); ?> %<em class="icon ni ni-arrow-long-down"></em></span>
                                        </div>
                                    </li>
                                </ul>
                                <div class="user-account-actions">
                                    <ul class="g-3">
                                        <li><a href="transfer" class="btn btn-lg btn-primary"><span><i class="fas fa-money-bill-alt"></i> Transfer</span></a></li>
                                        <li><a href="pay-bills" class="btn btn-lg btn-secondary"><span><i class="fas fa-file-invoice-dollar"></i> Pay Bills</span></a></li>
                                    </ul>
                                </div>
                            </div><!-- .nk-sidebar-widget -->
                            <div class="nk-sidebar-widget nk-sidebar-widget-full d-xl-none pt-0">
                                <a class="nk-profile-toggle toggle-expand" data-target="sidebarProfile" href="#">
                                    <div class="user-card-wrap">
                                        <div class="user-card">
                                            <div class="user-avatar">
                                                <span><?php echo "" . substr($firstname, 0, 1) . ""; ?><?php echo "" . substr($lastname, 0, 1) . ""; ?></span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text"><?php echo "$fullname"; ?></span>
                                                <span class="sub-text"><?php echo "$accountnumber"; ?></span>
                                            </div>
                                            <div class="user-action">
                                                <em class="icon ni ni-chevron-down"></em>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="nk-profile-content toggle-expand-content" data-content="sidebarProfile">
                                    <div class="user-account-info between-center">
                                        <div class="user-account-main">
                                            <h6 class="overline-title-alt">Available Balance</h6>
                                            <div class="user-balance"><?php echo "" . number_format(currencyConverter($accountbalance)) . ""; ?><small class="currency currency-btc"><?php echo "$usercurrency"; ?></small></div>
                                            <div class="user-balance-alt"><?php echo $accountbalance ?> <span class="currency currency-btc"><?php echo $money ?></span></div>
                                        </div>
                                        <a href="#" class="btn btn-icon btn-light"><em class="icon ni ni-line-chart"></em></a>
                                    </div>
                                    <ul class="user-account-data">
                                        <li>
                                            <div class="user-account-label">
                                                <span class="sub-text">income</span>
                                            </div>
                                            <div class="user-account-value">

                                                <span class="text-success ml-2"><?php echo round(getIncomeValue($userid, 'credit'), 2); ?> %<em class="icon ni ni-arrow-long-up"></em></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-account-label">
                                                <span class="sub-text">Debits</span>
                                            </div>
                                            <div class="user-account-value">

                                                <span class="text-danger ml-2"><?php echo round(getIncomeValue($userid, 'debit'), 2); ?> %<em class="icon ni ni-arrow-long-up"></em></span>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="user-account-links">
                                        <li><a href="transfer.php" class="link"><span> Transfer Funds</span> <em class="icon ni ni-wallet-out"></em></a></li>
                                        <li><a href="authenticate" class="link"><span>Pay Bills</span> <em class="icon ni ni-wallet-in"></em></a></li>
                                    </ul>
                                    <ul class="link-list">
                                        <li><a href="profile"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                        <li><a href="account-setting"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                        <li><a href="activity-logs"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
                                    </ul>
                                    <ul class="link-list">
                                        <li><a href="logout"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                    </ul>
                                </div>
                            </div><!-- .nk-sidebar-widget -->
                            <div class="nk-sidebar-menu">
                                <!-- Menu -->
                                <ul class="nk-menu">
                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title">Menu</h6>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="dashboard" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                            <span class="nk-menu-text">Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="myaccount" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-user-c"></em></span>
                                            <span class="nk-menu-text">My Account</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="summary" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-report-profit"></em></span>
                                            <span class="nk-menu-text">Account summary</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="transfer" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-wallet-out"></em></span>
                                            <span class="nk-menu-text">Transfer</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="paypal" class="nk-menu-link">
                                            <span class="nk-menu-icon">
                                                <em class="icon fab fa-cc-paypal"></em> <!-- PayPal icon from Font Awesome -->
                                            </span>
                                            <span class="nk-menu-text">Paypal</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="wire" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>
                                            <span class="nk-menu-text">Cross-border Transfer</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="check-deposit" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-wallet-in"></em></span>
                                            <span class="nk-menu-text">Deposit Check</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="pay-bills" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-cc-secure"></em></span>
                                            <span class="nk-menu-text">Pay Bills</span>
                                        </a>
                                    </li>
                                    <?php if ($visual_card == 1) { ?>
                                        <li class="nk-menu-item">
                                            <a href="visual-card" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-cc-alt2-fill"></em></span>
                                                <span class="nk-menu-text">Visual Cards</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php
                                    if ($crypto == 1) {
                                    ?>
                                        <li class="nk-menu-item has-sub">
                                            <a href="#" class="nk-menu-link bg-primary text-light nk-menu-toggle">
                                                <span class="nk-menu-icon"><em class="icon ni ni-bitcoin"></em></span>
                                                <span class="nk-menu-text">Crypto Currency</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item">
                                                    <a href="crypto" class="nk-menu-link"><span class="nk-menu-text">Manage Assets</span></a>
                                                </li>
                                                <li class="nk-menu-item">
                                                    <a href="crypto?action=deposit" class="nk-menu-link"><span class="nk-menu-text">Deposit Crypto</span></a>
                                                </li>
                                                <li class="nk-menu-item">
                                                    <a href="crypto?action=withdraw" class="nk-menu-link"><span class="nk-menu-text">Fiat Withdrawal</span></a>
                                                </li>
                                                <li class="nk-menu-item">
                                                    <a href="crypto_transfer" class="nk-menu-link"><span class="nk-menu-text">Transfer Funds</span></a>
                                                </li>
                                            </ul><!-- .nk-menu-sub -->
                                        </li><!-- .nk-menu-item -->
                                    <?php
                                    }
                                    ?>

                                    <?php if ($kyc == 1) {
                                    ?>
                                        <li class="nk-menu-item">
                                            <a href="kyc" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-file-check-fill"></em></span>
                                                <span class="nk-menu-text">KYC Status</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($loan == 1) {
                                    ?>
                                        <li class="nk-menu-item">
                                            <a href="loan" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-invest"></em></span>
                                                <span class="nk-menu-text">Loan/Credit financing </span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="nk-menu-item">
                                        <a href="card" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-cc-alt"></em></span>
                                            <span class="nk-menu-text">Link External card</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="account-setting" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-setting-alt-fill"></em></span>
                                            <span class="nk-menu-text">Account Setting</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="contact" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-help-alt"></em></span>
                                            <span class="nk-menu-text">Support</span>
                                        </a>
                                    </li>
                                </ul><!-- .nk-menu -->
                            </div><!-- .nk-sidebar-menu -->

                            <div class="nk-sidebar-footer">
                                <ul class="nk-menu nk-menu-footer">

                                    <a href="#">
                                        <div id="google_translate_element"></div>
                                    </a>

                                </ul><!-- .nk-footer-menu -->
                            </div><!-- .nk-sidebar-footer -->
                        </div><!-- .nk-sidebar-content -->
                    </div><!-- .nk-sidebar-body -->
                </div><!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fluid nk-header-fixed is-secondary">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ml-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="#" class="logo-link">
                                    <img class="logo-light logo-img" src="../<?php echo $logo ?>" srcset="../<?php echo $logo ?>" alt="logo">
                                    <img class="logo-dark logo-img" src="../<?php echo $logo ?>" srcset="../<?php echo $logo ?>" alt="logo-dark">

                                </a>
                            </div>
                            <div class="nk-header-news d-none d-xl-block">
                                <div class="nk-news-list">
                                    <a class="nk-news-item" href="#">
                                        <div class="nk-news-icon">
                                            <em class="icon ni ni-card-view"></em>
                                        </div>
                                        <div class="nk-news-text">
                                            <p>Do you know the latest update of Covid 2019? <span> An overview of ours is now available here.</span></p>
                                            <em class="icon ni ni-external"></em>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <div class="user-toggle">
                                                <?php if (!empty($user['status']) && $user['status'] == 'held') { ?>
                                                    <div class="user-hold-alert mr-2" title="Account on hold" style="display:flex;align-items:center;color:#e85347;font-size:1.05rem;">
                                                        <em class="icon ni ni-alert-circle-fill"></em>
                                                        <span class="user-hold-text" style="font-weight:600;color:#e85347;margin-left:6px;font-size:0.95rem;">Your Account is On Hold. Please Contact Customer Service. </span>
                                                    </div>
                                                <?php } ?>
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-md-block">
                                                    <div class="user-status user-status-verified">Connected</div>
                                                    <div class="user-name dropdown-indicator"><?php echo $fullname; ?></div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <span><?php echo "" . substr($lastname, 0, 1) . "" ?><?php echo "" . substr($firstname, 0, 1) . "" ?></span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?php echo $fullname; ?></span>
                                                        <span class="sub-text"><?php echo $accountnumber; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner user-account-info">
                                                <h6 class="overline-title-alt"><?php echo $accounttype ?></h6>
                                                <div class="user-balance"><?php echo "" . number_format(currencyConverter($accountbalance)) . ""; ?> <small class="currency currency-btc"><?php echo "$usercurrency"; ?></small></div>
                                                <div class="user-balance-sub">Local <span><?php echo "" . number_format($accountbalance) . ""; ?> <span class="currency currency-btc"><?php echo $money ?></span></span></div>
                                                <a href="transfer" class="link"><span>Transfer Funds</span> <em class="icon ni ni-wallet-out"></em></a>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="profile"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                                    <li><a href="account-setting"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                                    <li><a href="password-reset"><em class="icon ni ni-security"></em><span>Reset Password</span></a></li>
                                                    <li><a href="activity-logs"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
                                                    <li><a class="dark-switch" href="activity-logs"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="logout"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main header @e -->