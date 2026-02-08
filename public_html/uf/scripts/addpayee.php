<?php
include("functions.php");
include("userdata.php");
if (isset($_POST)) {
	$name = filterString($_POST['name']);
	$method = filterString($_POST['method']);
	$account = filterString($_POST['account']);
	$address = filterString($_POST['address']);
	$city = filterString($_POST['city']);
	$state = filterString($_POST['state']);
	$zipcode = filterString($_POST['zipcode']);
	$nickname = filterString($_POST['nickname']);
    sleep(3);
    //CHECKING IF THERE IS ANY EMPTY RECORD
    if (empty($name)) { echo "<script>document.getElementById('name').style.borderColor='red'; </script>";} else{echo"<script>document.getElementById('name').style.borderColor='green'; </script>";}
     if (empty($method)) { echo "<script>document.getElementById('method').style.borderColor='red'; </script>";} else{echo"<script>document.getElementById('method').style.borderColor='green'; </script>";}
      if (empty($account)) { echo "<script>document.getElementById('account').style.borderColor='red'; </script>";} else{echo"<script>document.getElementById('account').style.borderColor='green'; </script>";}
       if (empty($address)) { echo "<script>document.getElementById('address').style.borderColor='red'; </script>";} else{echo"<script>document.getElementById('address').style.borderColor='green'; </script>";}
        if (empty($city)) { echo "<script>document.getElementById('city').style.borderColor='red'; </script>";} else{echo"<script>document.getElementById('city').style.borderColor='green'; </script>";}
         if (empty($state)) { echo "<script>document.getElementById('state').style.borderColor='red'; </script>";} else{echo"<script>document.getElementById('state').style.borderColor='green'; </script>";}
          if (empty($zipcode)) { echo "<script>document.getElementById('zipcode').style.borderColor='red'; </script>";} else{echo"<script>document.getElementById('zipcode').style.borderColor='green';
            
           </script>"; }
 
         if ($name != "" && $method != "" && $account != "" && $address!= "" && $city != "" && $state != "" && $zipcode != "") {
         	 ?>
         	<script type="text/javascript">
         		$("#myModal").modal("show");
                 jQuery("#myModal").on("shown.bs.modal", function() {
                 jQuery(this).data("bs.modal").options.backdrop = "static";
                 jQuery(this).data("bs.modal").options.keyboard = false;
                  });
         	</script>
         <div class="modal fade" tabindex="-1" role="dialog" id="myModal" >
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <div class="nk-block-head nk-block-head-xs text-center">
                        <h5 class="nk-block-title">Review Payee details</h5>
                        <div class="nk-block-text">
                            <div class="caption-text">
                            	<strong>Kindly ensure that all the payee details are entered correctly before continuing</strong>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="buysell-overview">
                            <ul class="buysell-overview-list">
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Pay Name</span>
                                    <span class="pm-currency"><span><?php echo$_POST['name']?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Delivery Method</span>
                                    <span class="pm-currency"><?php echo$_POST['method'] ?></span>
                                </li>
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">Payee Address</span>
                                    <span class="pm-currency"><?php echo$_POST['address'] ?></span>
                                </li>
                                 <li class="buysell-overview-item">
                                    <span class="pm-title">Payee City</span>
                                    <span class="pm-currency"><?php echo$_POST['city'] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Payee State</span>
                                    <span class="pm-currency"><?php echo$_POST['state'] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Zip code</span>
                                    <span class="pm-currency"><?php echo$_POST['zipcode'] ?></span>
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
                        <div class="buysell-field form-action text-center">
                            <div> 
                            	<?php 
                            	$ref = randomString(54);
                            	$_SESSION['payeedetails'] = array($name, $method, $account, $address, $city, $state, $zipcode, $ref);
                            	?>
                                <a href="payee_added?ref=<?php echo$ref ?>" class="btn btn-primary btn-lg payee" name="Confirm_payee" >submit</a>
                                </form>
                            </div>
                            <div class="pt-3">
                                <a href="#" data-dismiss="modal" class="link link-danger">Cancel</a>
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->
    <?php
         	
         }
         else{
            echo"<script>
         toastr.error('All fields are required', 'Empty field(s)', {'progressBar': true});</script>";
         }
       

}

?>