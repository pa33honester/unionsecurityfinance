<?php
include("functions.php");
include("userdata.php");
if (isset($_POST)) {
	$country = filterString($_POST['countryId']); $state = filterString($_POST['stateId']); $city = filterString($_POST['cityId']); 
	$address = filterString($_POST['address']); $zipcode = filterString($_POST['zipcode']); $email = filterString($_POST['email']); 
	$phone = filterString($_POST['phone']); $fullname = filterString($_POST['fullname']); $type = filterString($_POST['type']); 
	$iban = filterString($_POST['iban']); $swiftcode = filterString($_POST['swiftcode']);
sleep(3);
if($_POST['accountnumber'] != ""){
if(empty($_SESSION['getbank'])){
	$accountholder = filterString($_POST['accountholder']); $accounttype = filterString($_POST['accounttype']);  $bankname = filterString($_POST['bankname']);
    if(empty($accountholder)){echo"<script>document.getElementById('accountholder').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('accountholder').style.borderColor='green'";}
     if(empty($accounttype)){echo"<script>document.getElementById('accounttype').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('accounttype').style.borderColor='green';</script>";}
     if(empty($bankname)){echo"<script>document.getElementById('bankname').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('bankname').style.borderColor='green';</script>";}

    	    if ($accountholder != "" && $accounttype != "" & $bankname != "") {
    	    	$_SESSION['getbank'] = "setted";
    	    	$_SESSION['accountholderB'] = $accountholder; $_SESSION['accounttypeB'] = $accounttype;
    	    	$_SESSION['banknameB'] = $bankname;
    	    }	 	       	    
  }}

     if(empty($country)){echo"<script>document.getElementById('countryId').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('countryId').style.borderColor='green';</script>";}
     if(empty($state)){echo"<script>document.getElementById('stateId').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('stateId').style.borderColor='green';</script>";}
     if(empty($city)){echo"<script>document.getElementById('cityId').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('cityId').style.borderColor='green';</script>";}	 	
     if(empty($address)){echo"<script>document.getElementById('address').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('address').style.borderColor='green';</script>";}	 	
    	     	    
     if(empty($zipcode)){echo"<script>document.getElementById('zipcode').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('zipcode').style.borderColor='green';</script>";}	 
     if(empty($email)){echo"<script>document.getElementById('email').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('email').style.borderColor='green';</script>";}	 	
     if(empty($fullname)){echo"<script>document.getElementById('fullname').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('fullname').style.borderColor='green';</script>";}	 	
     if(empty($type)){echo"<script>document.getElementById('type').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('type').style.borderColor='green';</script>";}	
     if(empty($iban)){echo"<script>document.getElementById('iban').style.borderColor='red';</script>";
    	    }else{echo"<script>document.getElementById('iban').style.borderColor='green';</script>";}
     if(empty($account)){echo"<script>document.getElementById('account').style.borderColor='red';</script>";}
    	    else{echo"<script>document.getElementById('account').style.borderColor='green';</script>";}

     if (empty($country) || empty($state) || empty($city) || empty($address) || empty($zipcode) || empty($email) || empty($fullname) || empty($type) || empty($iban) || empty($_POST['accountnumber'])) {
      	echo "<script>
         Swal.fire('All fields are required!', 'You are required to fill all empty fields', 'error');        
      	</script>";
      	die();
      } 
     $errorMsg = 0; 

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo"<script>
    document.getElementById('email').style.borderColor='green';
    </script>";} else {
     $errorMsg = 1;	
    echo"<script>toastr.error('Valid email address is required', 'Invalid email address', {'progressBar': true});
    document.getElementById('email').style.borderColor='red';
    </script>";
    }

    if (strlen($address) <= 8) {
     $errorMsg = 1;	
    echo"<script>toastr.error('A valid recipient address is required', 'Address too short', {'progressBar': true});
    document.getElementById('address').style.borderColor='red';
    </script>";
    }else{
    	 echo"<script>
    document.getElementById('address').style.borderColor='green';
    </script>";
    }
   
    if ($errorMsg == 0 && $_SESSION['getbank'] == "setted") {
        $_SESSION['country'] = $country; $_SESSION['state']= $state; $_SESSION['city'] = $city; $_SESSION['address']=$address; $_SESSION['zipcode']=$zipcode; $_SESSION['email'] =$email; $_SESSION['phone'] = $phone; $_SESSION['fullname']= $fullname; $_SESSION['type'] = $type; $_SESSION['iban'] = $iban; $_SESSION['swiftcode'] = $swiftcode;
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
                        <h5 class="nk-block-title">Review Recipient details</h5>
                        <div class="nk-block-text">
                            <div class="caption-text">
                            	<strong>Kindly ensure that all the recipient's details are entered correctly before continuing</strong>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="buysell-overview">
                            <ul class="buysell-overview-list">
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Recipient Name</span>
                                    <span class="pm-currency"><span><?php echo$_POST['fullname']?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Transfer Type</span>
                                    <span class="pm-currency"><?php echo$_POST['type'] ?></span>
                                </li>
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">Recipient Address</span>
                                    <span class="pm-currency"><?php echo$_POST['address'] ?>, <?php echo$_POST['cityId'] ?>, <?php echo$_POST['zipcode'] ?>, <?php echo$_POST['stateId'] ?>, <?php echo$_POST['countryId'] ?></span>
                                </li>
                                </ul>
                                <p>
                                <b>Recipient's banking details</b>
                                </p>
                                <ul class="buysell-overview-list">
                                
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">Bank Name</span>
                                    <span class="pm-currency"><?php echo$_SESSION['banknameB'] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Account Holder</span>
                                    <span class="pm-currency"><?php echo$_SESSION['accountholderB'] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Account Number</span>
                                    <span class="pm-currency"><?php echo$_POST['accountnumber'] ?></span>
                                </li>
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">IBAN</span>
                                    <span class="pm-currency"><?php echo$_POST['iban'] ?></span>
                                </li>
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">Swift Code</span>
                                    <span class="pm-currency"><?php echo$_POST['swiftcode'] ?></span>
                                </li>
                            </ul>
                         </div>
                        <div class="buysell-field form-group">
                            <div class="form-label-group">
                                <label class="form-label">Choose payment account</label>
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
                        	<strong class="text-dark">I confirmed that the information provided about this recipient is accurate and complete.</strong><br>
                        	<strong class="text-dark">I aknowledged that the transfer maybe refused by the recipient bank if the informaton is inaccurate. The recipient will then have to be deleted and the information will be entered again since the modification feature for international recipient is not available at the moment.</strong>
                        	<hr>

                            <div> 
                            	 <?php 
                            	$ref = randomString(54);
                            	$_SESSION['recipientDetails'] = array($country, $state, $city, $address, $zipcode, $email, $phone, $fullname, $type, $iban, $_SESSION['accounttypeB'], $_SESSION['accountholderB'], $_SESSION['banknameB'], $_POST['email'], $_POST['phone'], $_POST['swiftcode'], $_POST['accountnumber'], $ref);
                            	?>
                                <a href="recipient_added?ref=<?php echo$ref ?>" class="btn btn-primary btn-lg btn-block" name="Confirm_payee" >submit</a>
                                </form>
                            </div>
                            <div class="pt-3">
                                <a href="#" data-dismiss="modal" class="btn btn-sm btn-danger">Cancel</a>
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