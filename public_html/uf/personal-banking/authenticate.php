<?php
include("header.php");
// $_SESSION['transaction_session'] = "0";
?>
<div class="nk-content">
<?php echo $stockrate; 

?>
     </div>
          <div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="buysell wide-xs m-auto">
                                <div class="buysell-title text-center">
                                    <h2 class="title"><?php echo$sitename ?> Online Banking.</h2>
                                </div><!-- .buysell-title -->
                               <div class="alert alert-warning">
                                    <div class="alert-cta flex-wrap flex-md-nowrap">
                                        <div class="alert-text">
                                            <p>We take these preventive actions very seriously in order to protect <?php echo$sitename ?> account holder’s funds. We apologize for any inconvenience this may cause, but assure you that this action is taken to protect you and your account.</p>
                                        </div>
                                    </div>
                                </div><!-- .alert -->
                                <div class="buysell-block">
                                    <form action="#" method="post" class="buysell-form">
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <label class="form-label text-danger">Your authentication code is required*</label>
                                            </div>
                                            <input type="hidden" value="btc" name="bs-currency" id="buysell-choose-currency">
                                            <div class="dropdown buysell-cc-dropdown">
                                                <a href="#" class="buysell-cc-choosen dropdown-indicator" data-toggle="dropdown">
                                                    <div class="coin-item coin-btc">
                                                        <div class="coin-icon">
                                                            <em class="icon ni ni-sign-<?php echo strtolower($money); ?>"></em>
                                                        </div>
                                                        <div class="coin-info">
                                                            <span class="coin-name"><?php echo "$accounttype";?> (<?php echo "$usercurrency";?>)</span>
                                                            <span class="coin-text">Available Balance: <?php echo "$usercurrency"; ?> <?php echo number_format(currencyConverter($accountbalance));?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-auto dropdown-menu-mxh">
                                                    <ul class="buysell-cc-list">
                                                        <li class="buysell-cc-item selected">
                                                            <a href="#" class="buysell-cc-opt" data-currency="btc">
                                                                <div class="coin-item coin-btc">
                                                                    <div class="coin-icon">
                                                                        <em class="icon ni ni-sign-<?php echo strtolower($money); ?>"></em>
                                                                    </div>
                                                                    <div class="coin-info">
                                                                        <span class="coin-name"><?php echo "$accounttype";?> (<?php echo "$usercurrency";?>)</span>
                                                                        <span class="coin-text">Available Balance:<?php echo "$usercurrency ".number_format(currencyConverter($accountbalance))."";?></span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div><!-- .dropdown-menu -->
                                            </div><!-- .dropdown -->
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-group">
                                        	<div class="verifyResult"></div>
                                            <div class="form-label-group">
                                                <label class="form-label" for="buysell-amount">Enter your authentication number:</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg form-control-number" id="code" name="code" placeholder="Authentication code">
                                                <div class="form-dropdown">
                                                    <div class="text">CODE<span></span></div>
                                                </div>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-action">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary auth" >Validate Pin</button>
                                        </div><!-- .buysell-field -->
                                    
                                    </form><!-- .buysell-form -->
                                </div><!-- .buysell-block -->

                                </div>

                            </div><!-- .buysell -->
                        </div>
                    </div>
                </div>


<?php include("footer.php"); 

?>