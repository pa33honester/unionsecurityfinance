<?php
include("functions.php");
include("userdata.php");
//ACCEPTING POSTED DATA
if (isset($_POST)) {
	//initiating posted data
	$payeeid = filterString($_POST['payeeid']);
	$dated = filterString($_POST['dated']);
	$amount = filterString($_POST['amount']);
	$memo = filterString($_POST['memo']);
     sleep(3);
	if(empty($payeeid)){ echo "<script> document.getElementById('payeeid').style.borderColor='red';</script>";}else{
		echo "<script> document.getElementById('payeeid').style.borderColor='green';</script>";
	}
    if(empty($dated)){ echo "<script> document.getElementById('dated').style.borderColor='red';</script>";}else{
		echo "<script> document.getElementById('dated').style.borderColor='green';</script>";
	}
	if(empty($amount)){ echo "<script> document.getElementById('amount').style.borderColor='red';</script>";}else{
		echo "<script> document.getElementById('amount').style.borderColor='green';</script>";
	}
	if($payeeid == "" || $dated == "" || $amount == ""){
            echo"<script>
         toastr.error('All fields are required', 'Empty field(s)', {'progressBar': true});</script>";
         die();
         }
    
    if ($amount >= ($accountbalance)) {
    	echo"<script>
         toastr.error('Insufficient account balance', 'Error Occured', {'progressBar': true});
         document.getElementById('amount').style.color='red';
         document.getElementById('amount').style.borderColor='red';
         </script>";
        die();
    } 
    else {
        if ($allowtransfer == 0 && $blocktransfer == 0) {
    echo "<script>
               Swal.fire('Transaction restricted', '$rest_msg', 'error');
         </script>"; 
         die();
  }
    	$ref = randomString(54);
    	$query = $conn->query("SELECT * FROM payee WHERE id = '$payeeid'");
    	$payrow = mysqli_fetch_array($query);
    	$address = $payrow['address']; $city = $payrow['city']; $zipcode = $payrow['zipcode']; $state = $payrow['state']; $name = $payrow['name'];
        //storing payment details as an array
    	 $_SESSION['paymentdetails'] = array($name, $dated, $amount, $memo, $ref, $payeeid);
    	echo"<script>
         document.getElementById('amount').style.color='green';
         </script>";

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
                        <h1 class="nk-block-title display-4 text-success align-text-center"><em class="icon ni ni-info-fill"></em> </h1>
                        <div class="nk-block-text">
                            <div class="caption-text">
                             Review Payment Details
                            </div>
                       </div>
                    <div class="nk-block">
                        <div class="buysell-overview">
                            <ul class="buysell-overview-list">
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Payee Name</span>
                                    <span class="pm-currency"><span><?php echo$payrow['name']; ?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Amount</span>
                                    <span class="pm-currency"><span><?php echo$money; echo" $amount"; ?></span></span>
                                </li>
                                  <li class="buysell-overview-item">
                                    <span class="pm-title">Delivery date</span>
                                    <span class="pm-currency"><span><?php echo$dated ?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Payee Address</span>
                                    <span class="pm-currency"><?php echo "$address, $city, $zipcode, $state";?></span>
                                </li>
                            </ul>
                            <div class="sub-text-sm">* Our transaction fee are included.</div>
                        </div>
                        <?php 
                        $query = $conn->query("SELECT * FROM paybill WHERE payeeid  = '$payeeid' ORDER BY id LIMIT 5");
                        if(mysqli_num_rows($query) < 1) {
                        	echo"<strong>No payment to this Payee so far.</strong>";
                        }
                        else{ 
                        	echo "<strong>Previous payment(s) to this Payee</strong>

                        	<ul class='buysell-overview-list'>";
                        	while($rows = mysqli_fetch_array($query)){?>
                            
                             <li class="buysell-overview-item">
                                    <span class="pm-title">Amount Paid: <?php echo$money ?>  <?php echo$rows['amount'] ?></span>
                                    <span class="pm-currency">Date:  <?php echo$rows['dated'] ?></span>
                                </li>

                        	<?php  }
                        	echo"</ul>";
                            }
                        ?>
                        <div class="buysell-field form-action text-center">
                            <div>
                                <a href="../scripts/billpay-mail?ref<?php echo$ref ?>" class="btn btn-primary btn-lg btn-block">Continue with this payment</a>
                            </div>
                            <div class="pt-3">
                                <a href="#" data-dismiss="modal" class="link link-danger">Cancel Payment</a>
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->
   
    	<?php
    }
   /* else{
    	echo "
          <div class='alert alert-danger'>Bill payment cannot be proccessed at this moment. Please try again later</div>";
    }*/



	
}


?>