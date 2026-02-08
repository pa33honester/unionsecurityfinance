<?php
include("header.php");
$token = $_GET["transferToken"];
include("../scripts/connect.php");
$query = $conn->query("SELECT * FROM transactions WHERE token = '$token'");
$rows = mysqli_fetch_assoc($query);
$amount = $rows['amount'];
$refNumber = $rows['refNumber'];
$accountholder = $rows['accountholder'];
$bankname = $rows['bankname'];
$dated = $rows['dated'];
$avalbal = $rows['accountbalance'];
?>           
        <?php if($allowtransfer == 1) { ?>
             <div class="nk-content nk-content-fluid">
              <div class="container-xl wide-lg">
               <div class="nk-content-body">
             <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                        <h4 class="nk-modal-title">Transaction successful!</h4>
                        <div class="nk-modal-text">
                            <p class="caption-text">You have successfully transfered <strong><?php echo $amount ?></strong> <?php echo "$money"; ?> to <strong><?php echo $accountholder ?></strong>.</p>
                           <p class="sub-text-sm"><?php echo$localmsg ?></p>
                           <b>Details of your transaction are shown below;</b>
                        </div>
                        <ul class="buysell-overview-list">
                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Amount Debited</span></span>
                                    <span class="pm-title"><?php echo"$money ".number_format($amount).""; ?></span>
                                </li>
                                 <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Transaction refrence:</span></span>
                                    <span class="pm-title"><?php echo "$refNumber"; ?></span>
                                </li>

                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Account holder:</span></span>
                                    <span class="pm-title"><?php echo "$accountholder"; ?></span>
                                </li>

                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Bank Name:</span></span>
                                    <span class="pm-title"><?php echo "$bankname"; ?></span>
                                </li>

                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Date:</span></span>
                                    <span class="pm-title"><?php echo "$dated"; ?></span>
                                </li>

                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Available Balance:</span></span>
                                    <span class="pm-title"><?php echo "$money ".number_format($avalbal).""; ?></span>
                                </li>


                            </ul>
                        <div class="nk-modal-action-lg">
                            <ul class="btn-group gx-4">
                                <li><a href="transfer" class="btn btn-lg btn-mw btn-primary">New transaction</a></li>
                                <li><a href="dashboard" class="btn btn-lg btn-mw btn-secondary">Back to home</a></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- .modal-body -->
                <div class="modal-footer bg-lighter">
                    <div class="text-center w-100">
                        <p>All electronic fund transfers to or from your accounts at <?php echo$sitename ?> are governed by the Electronic Fund Transfer Disclosure provided to you when you established your account or when you requested other electronic fund transfer services.</p>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </div>
<?php } else { 
   $query=$conn->query("UPDATE transactions SET status = 0 WHERE refNumber = '$refNumber'");
   $query2=$conn->query("UPDATE users SET blocktransfer = 0 WHERE id = '$userid'");
    ?>
    <div class="nk-content nk-content-fluid">
              <div class="container-xl wide-lg">
               <div class="nk-content-body">
             <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                        <h4 class="nk-modal-title">Transaction pending!</h4>
                        <div class="nk-modal-text">
                            <p class="caption-text">Your transfer of <strong><?php echo $amount ?></strong> <?php echo "$money"; ?> to <strong><?php echo $accountholder ?> cannot be completed at the moment.</strong>.</p>
                           <p class="sub-text-sm"><?php echo$localmsg ?></p>
                           <b>Details of your transaction are shown below;</b>
                        </div>
                        <ul class="buysell-overview-list">
                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Amount Debited</span></span>
                                    <span class="pm-title"><?php echo"$money ".number_format($amount).""; ?></span>
                                </li>
                                 <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Transaction refrence:</span></span>
                                    <span class="pm-title"><?php echo "$refNumber"; ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Account holder:</span></span>
                                    <span class="pm-title"><?php echo "$accountholder"; ?></span>
                                </li>

                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Bank Name:</span></span>
                                    <span class="pm-title"><?php echo "$bankname"; ?></span>
                                </li>

                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Date:</span></span>
                                    <span class="pm-title"><?php echo "$dated"; ?></span>
                                </li>

                                <li class="buysell-overview-item">
                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Available Balance:</span></span>
                                    <span class="pm-title"><?php echo "$money ".number_format($avalbal).""; ?></span>
                                </li>
                            </ul>
                        <div class="nk-modal-action-lg">
                            <ul class="btn-group gx-4">
                                <li><a href="dashboard" class="btn btn-lg btn-mw btn-secondary">Back to home</a></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- .modal-body -->
                <div class="modal-footer bg-lighter">
                    <div class="text-center w-100">
                        <p>All electronic fund transfers to or from your accounts at <?php echo$sitename ?> are governed by the Electronic Fund Transfer Disclosure provided to you when you established your account or when you requested other electronic fund transfer services.</p>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </div>
<?php } ?>
<?php
include("footer.php");
unset($_SESSION["transaction_session"]);
?>