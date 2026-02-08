<?php
include("functions.php");
include("userdata.php");
sleep(3);
if (isset($_POST)) {
	$recipient = filterString($_POST['recipient']);
	$dated = filterString($_POST['dated']);
	$amount = filterString($_POST['amount']);
	$description = filterString($_POST['description']);

	if (empty($recipient)) {
		echo "<script>document.getElementById('recipient').style.borderColor='red';</script>";
	}else {echo "<script>document.getElementById('recipient').style.borderColor='green';</script>";}
	if (empty($dated)) {
		echo "<script>document.getElementById('dated').style.borderColor='red';</script>";
	}else {echo "<script>document.getElementById('dated').style.borderColor='green';</script>";}
	if (empty($amount)) {
		echo "<script>document.getElementById('amount').style.borderColor='red';</script>";
	}else {echo "<script>document.getElementById('amount').style.borderColor='green';</script>";}
	if (empty($description)) {
		echo "<script>document.getElementById('description').style.borderColor='red';</script>";
	}else {echo "<script>document.getElementById('description').style.borderColor='green';</script>";}

	if (empty($recipient) || empty($dated) || empty($amount) || empty($description)) {
		echo"<script>    
              toastr.error('All fields are required!', 'Empty field(s)', {\"progressBar\": true});
             </script>";
             die();
	}
      $errorMsg = 0;
	if($amount >= $accountbalance){
       $errorMsg = 1;

		echo"<script> Swal.fire('Insuficient account balance!!', 'Your account balance of $money $accountbalance will not be enough to proccess this transaction.', 'error');
          document.getElementById('amount').style.borderColor='red';
          document.getElementById('amount').style.color='red';</script>
		";	
	   }else{echo "<script>document.getElementById('amount').style.borderColor='green';
        document.getElementById('amount').style.color='green';
	   </script>";}

       

    
    if ($errorMsg == 0) {
         if ($allowtransfer == 0 && $blocktransfer == 0) {
    echo "<script>
               Swal.fire('Transaction restricted', '$rest_msg', 'error');
         </script>"; 
         die();
  }
    	$query = $conn->query("SELECT * FROM wire WHERE id = '$recipient'");
    	$rows = mysqli_fetch_array($query);
    	$bankname = $rows['bankname']; $email = $rows['email']; $accountholder = $rows['accountholder']; $accountnumberB = $rows['account']; $accounttype = $rows['accounttype']; $iban = $rows['iban']; $country = $rows['country']; $state = $rows['state']; $city = $rows['city']; $zipcode = $rows['zipcode']; $fullname = $rows['fullname']; $type = $rows['type'];
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
                <div class="modal-body modal-body-lg">
                    <div class="nk-block-head nk-block-head-xs text-center">
                        <h3 class="nk-block-title">Review recipient details</h3>
                        <div class="nk-block-text">
                            <div class="caption-text">
                            	<strong></strong>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="buysell-overview">
                            <ul class="buysell-overview-list">
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Recipient Name</span>
                                    <span class="pm-currency"><span><?php echo$fullname?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Transfer Type</span>
                                    <span class="pm-currency"><?php echo$rows['type'] ?></span>
                                </li>
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">Recipient Address</span>
                                    <span class="pm-currency"><?php echo$city ?>, <?php echo$zipcode ?>, <?php echo$state ?>, <?php echo$country ?></span>
                                </li>
                                </ul>
                                <p>
                                <b>Recipient's banking details</b>
                                </p>
                                <ul class="buysell-overview-list">
                                
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">Bank Name</span>
                                    <span class="pm-currency"><?php echo$bankname ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Account Holder</span>
                                    <span class="pm-currency"><?php echo$accountholder ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Account Number</span>
                                    <span class="pm-currency"><?php echo$accountnumberB ?></span>
                                </li>
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">Processing Time</span>
                                    <span class="pm-currency">2-3 Business days</span>
                                </li>
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">Applicable fee*</span>
                                    <span class="pm-currency"><?php echo$money ?> 5.70</span>
                                </li>
                                   <li class="buysell-overview-item">
                                    <span class="pm-title">Total amount</span>
                                    <span class="pm-currency"><?php echo$money ?> <?php echo $amount + 5.70;?> </span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Description</span>
                                    <span class="pm-currency"><?php echo$description ?> </span>
                                </li>
                            </ul>
                         </div>
                        <div class="buysell-field form-group">
                            <div class="form-label-group">
                                <label class="form-label"> payment account</label>
                            </div>
                               <input type="hidden" value="btc" name="bs-currency" id="buysell-choose-currency-modal">
                            <div class="dropdown buysell-cc-dropdown">
                                <a href="#" class="buysell-cc-choosen dropdown-indicator" data-toggle="dropdown">
                                    <div class="coin-item coin-btc">
                                        <div class="coin-icon">
                                            <em class="icon ni ni-wallet-out"></em>
                                        </div>
                                        <div class="coin-info">
                                            <span class="coin-name"><?php echo$accounttype ?></span>
                                            <span class="coin-text">Balance(<?php echo$money; echo$accountbalance ?>)</span>
                                        </div>
                                    </div>
                                </a>
                            <div class="dropdown-menu dropdown-menu-auto dropdown-menu-mxh">
                                    <ul class="buysell-cc-list">
                                        <li class="buysell-cc-item selected">
                                            <a href="#" class="buysell-cc-opt" data-currency="btc">
                                                <div class="coin-item coin-btc">
                                                    <div class="coin-icon">
                                                        <em class="icon ni ni-wallet-out"></em>
                                                    </div>
                                                    <div class="coin-info">
                                                        <span class="coin-name"><?php echo$accounttype ?></span>
                                                        <span class="coin-text"><?php echo substr($accountnumber, 0,4); echo"*****"; ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li> <!-- .buysell-cc-item -->
                                    </ul>
                                </div>
                            </div><!-- .dropdown -->
                        </div><!-- .buysell-field -->
                        <div class="buysell-field form-action text-left">
                        	<hr>
                        	<h4 class="text-danger">KINDLY NOTE*</h4>
                        	<strong class="text-dark">This international transfer cannot be cancelled as mentioned in our terms and condition.</strong><br>
                        	<strong class="text-dark">By continueing this transfer, You acknowledged that this International transfer is not intended to anyone else other than the named recipient.</strong><br>
                        	<strong class="text-dark">No third party has Authority over this International Transfer.</strong>
                        	<hr>

                            <div> 
                            	 <?php 
                            	$ref = randomString(54);
                                $_SESSION['transaction_session'] = $ref;
                            	$_SESSION['recipientDetailsB'] = array($country, $state, $city, $zipcode, $email, $fullname, $type, $iban, $accounttype, $accountholder, $accountnumberB, $bankname, $amount, $description, $recipient, $ref);

                                if ($enable_cot_imf == "Yes") {
                            	?>

                                <a href="wire-auth?token=<?php echo$ref ?>&verification=imf" class="btn btn-primary btn-lg btn-block" >Continue</a>

                                <?php }  elseif($enable_tin_ic_tac == "Yes") { ?>
                               <a href="wire-auth?token=<?php echo$ref ?>&verification=tac" class="btn btn-primary btn-lg btn-block" >Continue</a> 
                            <?php } else{ ?>
                                <a href="../email/wire-otp-mail.php" class="btn btn-primary btn-lg btn-block" >Continue</a>
                            <?php } ?>
                                </form>
                            
                            </div>
                            <div class="pt-3">
                                <a href="#" data-dismiss="modal" class="btn btn-sm btn-light">modify</a>
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->
        

        

   

    	<?php
    }
  
}

?>