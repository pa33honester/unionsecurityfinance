<?php
error_reporting(0);
include("header.php");
$j = $_SESSION['paymentdetails'];
$otp = $j[6];
if(empty($otp)){
  echo"<script>window.location.href='../personal-banking/pay-bills'; </script>";}
else{
      //INSERT INTO TRANSACTION RECORDS
     $ref = randomString(9);
     $dd = date("my");
     $dc = substr($sitename, 0, 3);
     $refNumber = strtoupper("$dc/$ref-$dd");
     $dated = date("d M Y, g:i a");
     $acctBal = ($accountbalance - ($j[2]));
	$j = $_SESSION['paymentdetails'];
	$query = $conn->query("INSERT INTO paybill (payee, dated, amount, userid, payeeid, status, ref) VALUES('$j[0]', '$j[1]', '$j[2]', '$userid', '$j[5]', 'pending', '$refNumber')");
   
     $queryForTransfer = $conn->query("INSERT INTO transactions (scope, type, refNumber, dated, amount, accountbalance, userid, description, status) VALUES ('Bill Payment', 'Debit', '$refNumber', '$dated', '$j[2]', '$acctBal', '$userid', 'Bill Pay for $j[0]', 0)");

     //UPDATE ACCOUNT BALANCE
     $update = $conn->query("UPDATE users SET accountbalance = '$acctBal' WHERE id = '$userid'");
   }
   ?>

 <div class="container-fluid p-2" style="margin-top:80px;">
       <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                        <h4 class="nk-modal-title">Your Bill Payment is being proccessed</h4>
                        <div class="nk-modal-text">
                            <p class="caption-text">Bill payment of <strong><?php echo $j[2] ?></strong> <?php echo $money ?> from  your <strong><?php echo "$shortname $accounttype"; ?></strong> has been initiated and the Payee (<?php echo$j[0] ?>) will receive your payment shortly.</p>
                            <p class="sub-text-sm">Details of your transaction are as below.</a></p>
                        </div>
                            <ul class="buysell-overview-list">
                            	<li class="buysell-overview-item">
                                    <span class="pm-title">Payee</span>
                                    <span class="pm-currency"><?php echo $j[0] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Total amount</span>
                                    <span class="pm-currency"></em> <span><?php echo $j[2] ?> <?php echo $money ?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Ref number</span>
                                    <span class="pm-currency"><?php echo $refNumber ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Fee</span>
                                    <span class="pm-currency">2 <?php echo $money ?></span>
                                </li>
                            </ul>
                        </div>
                        <div class="nk-modal-action-lg">
                            <ul class="btn-group gx-4">
                                <li><a href="dashboard" class="btn btn-lg btn-mw btn-success">Done</a> <a href="pay-bills" class="btn btn-lg btn-mw btn-primary">Pay another</a></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
  </div>

<?php include ("footer.php"); 
unset($_SESSION['paymentdetails']);
?>
