<?php
include("functions.php");
if(isset($_POST)){
sleep(3);
	$id = filterString($_POST['id']);
	$amount = filterString($_POST['amount']);
	$memo = filterString($_POST['memo']);
	$scope = filterString($_POST['scope']);
	$frequency = filterString($_POST['frequency']);
	$emailNotify = $_POST['emailnotify'];
if(empty($amount)){
	echo"<script>document.getElementById('amount').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('amount').style.borderColor='green';</script>";}
if(empty($memo)){
	echo"<script>document.getElementById('memo').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('memo').style.borderColor='green';</script>";}
if(empty($scope)){
	echo"<script>document.getElementById('scope').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('scope').style.borderColor='green';</script>";}
if(empty($frequency)){
	echo"<script>document.getElementById('frequency').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('frequency').style.borderColor='green';</script>";}
if(empty($emailNotify)){
	echo"<script>document.getElementById('emailnotify').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('emailnotify').style.borderColor='green';</script>";}   
if (empty($amount) || empty($memo)) {
    echo "<script>    
              toastr.error('All fields are required!', 'Empty field(s)', {\"progressBar\": true});
             </script>";
             die();
   }

  $query = $conn->query("SELECT * FROM users WHERE id = '$id'");
  $row = mysqli_fetch_array($query);
  $firstname = $row['firstname']; 
  $middlename = $row['middlename'];   
  $lastname = $row['lastname'];
  $email = $row['email'];
  $accountbalance = $row['accountbalance'];
  $accountnumber = $row['accountnumber'];
  $f = $amount * $frequency;
  if ($amount * $frequency > $accountbalance) {
       echo "<script>    
              toastr.error('Insufient balance to carry out this transaction', 'Kindly fund user account first', {\"progressBar\": true});
             </script>";
             die();
    }  


  $_SESSION['debitUserDetails'] = array($id, $amount, $memo, $frequency, $scope, $emailNotify, $firstname, $lastname, $middlename, $email, $accountnumber, $accountbalance);
  ?>
   <script type="text/javascript">
         		$("#myModal").modal("show");
                 jQuery("#myModal").on("shown.bs.modal", function() {
                 jQuery(this).data("bs.modal").options.backdrop = "static";
                 jQuery(this).data("bs.modal").options.keyboard = false;
                  });
         	</script>

<div class="modal fade" tabindex="-1" role="dialog" id="myModal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <div class="nk-block-head nk-block-head-xs text-center">
                        <h5 class="nk-block-title">Review Transaction</h5>
                        <div class="nk-block-text">
                            <div class="caption-text">You are about to send <strong><?php echo$amount ?></strong> <?php echo$money ?> to <strong><?php echo "$firstname $middlename $lastname "; ?></strong></div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="buysell-overview">
                            <ul class="buysell-overview-list">
                            	<li class="buysell-overview-item">
                                	
                                    <span class="pm-title">Transaction Scope</span>
                                    <span class="pm-currency"><span><?php echo$scope ?></span></span>
                                </li>
                                <li class="buysell-overview-item">

                                    <span class="pm-title">Account Number</span>
                                    <span class="pm-currency"><span><?php echo$accountnumber ?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Amount</span>
                                    <span class="pm-currency"><?php echo"$amount $money"; ?></span>
                                </li>
                                  <li class="buysell-overview-item">
                                    <span class="pm-title">Description</span>
                                    <span class="pm-currency"><?php echo"$memo"; ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Frequency</span>
                                    <span class="pm-currency"><?php echo"$frequency"; ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Email Notification</span>
                                    <span class="pm-currency"><?php echo"$emailNotify"; ?></span>
                                </li>
                            </ul>
                        </div>
                        <div class="buysell-field form-action text-center">
                            <div>
                                <a href="../email/debit_user-mail.php" class="btn btn-primary btn-lg" >Confirm transaction</a>
                            </div>
                            <div class="pt-3">
                                <a href="#" data-dismiss="modal" class="link link-danger">Modify</a>
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->

  <?php

}
?>