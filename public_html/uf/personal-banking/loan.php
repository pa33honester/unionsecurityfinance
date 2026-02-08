<?php include 'header.php'; ?>
loan?apNum

<?php if(isset($_GET['apNum']) && $_GET['apNum'] != ""){
    $ref = $_GET['apNum'];
    $query = $conn->query("SELECT * FROM loan_application WHERE ref = '$ref'");
    if(mysqli_num_rows($query) < 1){
    	i_redirect("loan");
    }
    else{
    	$loanInfo = mysqli_fetch_array($query);
    }
	?>
<div class="nk-content">
    <div class="container-fluid p-2">
           <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                        <h4 class="nk-modal-title">Your Request has been submitted.</h4>
                        <div class="nk-modal-text">
                            <p class="sub-text-sm">Details are shown below;</a></p>
                        </div>
                            <ul class="buysell-overview-list">
                                <li class="buysell-overview-item">
                                   <span class="pm-title">Ref Number</span>
                                    <span class="pm-currency"></em> 
                                   <span><?php echo $loanInfo['ref']?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Amount</span>
                                    <span class="pm-currency"><?php echo number_format($loanInfo['loan_amount']); echo " $money"; ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Status</span>
                                    <span class="pm-currency"><?php echo $loanInfo['status'] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Repayment Tenure</span>
                                    <span class="pm-currency"><?php echo $loanInfo['tenure'] ?> Months</span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Monthly Repayment amounth</span>
                                    <span class="pm-currency"><?php echo round($loanInfo['interest_amount'], 2); echo " $money"; ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Management Fee</span>
                                    <span class="pm-currency"><?php echo $loanInfo['manage_fee']; echo " $money"; ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Loan/Credit Facilty</span>
                                    <span class="pm-currency"><?php echo $loanInfo['facility']?></span>
                                </li>
                            </ul>
                        </div>
                       <div class="nk-modal-action-lg">
                            <ul class="btn-group gx-4">
                                <li>
                                	<a href="dashboard" class="btn btn-lg btn-mw btn-success">Home</a> 
                                </li>
                            </ul>
                        </div>
                    </div>
              
<?php } elseif(isset($_GET['history'])) { ?>
 <!-- content @s -->
                <div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-between-md g-4">
                                    <div class="nk-block-head-content">
                                        <h2 class="nk-block-title fw-normal">Your Loan Requests</h2>
                                        <div class="nk-block-des">
                                            <p>See full list of loan requests you have made so far.</p>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block nk-block-sm">
                                <div class="tranx-list tranx-list-stretch card card-bordered">
                            <?php $query=$conn->query("SELECT * FROM loan_application WHERE userid = '$userid'");
                            if(mysqli_num_rows($query) < 1){
                              echo "<h2>No data Found</h2>";
                             }else{
                                while($loanInfo = mysqli_fetch_array($query)){
                              if($loanInfo['status'] == "pending"){
                                $stat = '<em class="icon ni ni-check-circle-fill text-warning title h2"></em>';
                              }
                              elseif($loanInfo['status'] == 'success'){
                                $stat = '<em class="icon ni ni-check-circle-fill text-success title h2"></em>';
                              }
                              elseif($loanInfo['status'] == 'rejected'){
                                $stat = '<em class="icon ni ni-check-circle-fill text-danger title h2"></em>';
                              }
                              else{
                                $stat = '<em class="icon ni ni-check-circle-fill text-primary title h2"></em>';
                              }
                             ?>
                            
                                    <div class="tranx-item">
                                        <div class="tranx-col">
                                            <div class="tranx-info">
                                                <div class="tranx-badge">
                                                    <span class="tranx-icon">
                                                       <?php echo$stat ?>
                                                    </span>
                                                </div>
                                                <div class="tranx-data">
                                                    <div class="tranx-label"><?php echo$loanInfo['facility'] ?></div>
                                                    <div class="tranx-date"><?php echo$loanInfo['datecreated'] ?></div>
                                                    <div class="tranx-date">Tenure - <?php echo$loanInfo['tenure'] ?> Months*</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tranx-col">
                                            <div class="tranx-amount">
                                                <div class="number"><?php echo number_format($loanInfo['loan_amount']) ?> <span class="currency currency-btc"><?php echo$money ?></span></div>
                                                <div class="tranx-date"><?php echo round($loanInfo['interest_amount'],2) ?> <span class="tranx-date"><?php echo$money ?></span>/Monthly Interest</div>
                                                 <div class="tranx-date">Ref: <?php echo ($loanInfo['ref']) ?> </div>
                                            </div>
                                        </div>
                                    </div><!-- .nk-tranx-item -->
                                <?php }} ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->

            <?php } else { ?>
                <div class="nk-content nk-content-fluid">
                    <div class="container wide-lg">
                        <div class="nk-content-body">
                            <div class="buysell">
                                <div class="buysell-nav text-center">
                                    <ul class="nk-nav nav nav-tabs nav-tabs-s2">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="">New Loan Request</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-primary" href="loan?history=loans">Loan History</a>
                                        </li>
                                    </ul>
                                </div><!-- .buysell-nav -->
                                <div class="buysell-title text-center">
                                    <h2 class="title">Apply For <?php echo$sitename ?> Loan</h2>
                                </div><!-- .buysell-title -->
                                <div class="buysell-block">
                                    <form action="../scripts/auth?action=loanRequest" class="buysell-form" id="loanRequest" method="post">
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Disbursement Account:</label>
                                            </div>
                                           
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="buysell-amount">Loan Amount</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="number" step="any" class="form-control form-control-lg form-control-number" id="amount" min="<?php echo$loan_mini;  ?>" max="<?php echo$loan_maxi;  ?>" name="amount" placeholder="200.00" required>
                                                <div class="form-dropdown">
                                                    <div class="text"><?php echo $money ?></div>  
                                                </div>
                                            </div>
                                            <div class="form-note-group">
                                                <span class="buysell-min form-note-alt">Minimum:<?php echo$loan_mini; echo " $money"; ?></span>
                                                <span class="buysell-rate form-note-alt">Maximum:<?php echo number_format($loan_maxi); echo " $money"; ?></span>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="row">
                                         <div class="buysell-field form-group col-lg-6">
                                            <div class="form-label-group">
                                                <label class="form-label" for="buysell-amount">Credit Facility</label>
                                            </div>
                                            <div class="form-control-group">
                                                <select type="text" class="form-control form-control-lg" id="facility" name="facility"  required>
                                                 <option selected value="">Select Loan/Credit Facility</option>
                                                 <option value="Personal Home Loans">Personal Home Loans</option>
                                                 <option value="Joint Mortgage ">Joint Mortgage </option>
                                                 <option value="Automobile Loans ">Automobile Loans </option>
                                                 <option value="Salary loans">Salary loans</option>
                                                 <option value="Secured Overdraft">Secured Overdraft</option>
                                                 <option value="Contract Finance">Contract Finance</option>
                                                 <option value="Secured Term Loans">Secured Term Loans</option>
                                                 <option value="StartUp/Products Financing">StartUp/Products Financing</option>
                                                 <option value="Local Purchase Orders Finance">Local Purchase Orders Finance</option>
                                                 <option value="Operational Vehicles">Operational Vehicles</option>
                                                 <option value="Revenue Loans and Overdraft">Revenue Loans and Overdraft</option>
                                                 <option value="Retail TOD">Retail TOD</option>
                                                 <option value="Commercial Mortgage">Commercial Mortgage</option>
                                                 <option value="Office Equipment">Office Equipment</option>
                                                 <option value="Health Finance Product Guideline">Health Finance Product Guideline</option><option value="Health Finance">Health Finance</option>
                                             </select>
                                            </div>
                    
                                        </div><!-- .buysell-field -->
                                         <div class="buysell-field form-group col-lg-6">
                                            <div class="form-label-group">
                                                <label class="form-label" for="buysell-amount">Repayment Tenure</label>
                                            </div>
                                            <div class="form-control-group">
                                                <select type="text" class="form-control form-control-lg" id="tenure" name="tenure" required>
                                                <option value="" selected>Payment Tenure</option>
                                                <option value="6">6 Months</option>
                                                <option value="12">12 Months</option>
                                                <option value="24">2 Years</option>
                                                <option value="36">3 Years</option>
                                                <option value="48">4 Years</option>
                                                <option value="60">5 Years</option>
                                            </select>
                                            </div>
                                         
                                        </div>
                                         <div class="buysell-field form-group col-lg-12">
                                            <div class="form-label-group">
                                                <label class="form-label" for="buysell-amount">Purpose</label>
                                            </div>
                                            <div class="form-control-group">
                                                <textarea type="text" class="form-control form-control-lg" cols="8" id="reason" name="reason" placeholder="Briefly exlain why you're requesting for this loan" required></textarea>
                                            </div>
                                         
                                        </div>
                                        </div>  
                                        <hr>
                                        <p class="title lead">You are requesting for an instant loan, By continueing, you have agreed and accepted the <?php echo$sitename ?> digital loan terms and conditions.</p>
                                        <strong class="text-center bold">Terms & Conditions</strong>
                                                        <ul class="list list-sm list-checked">
                                                            <li>Interest Rate: <?php echo "$interest_rate" ?>%.</li>
                                                            <li>Management Fee: <?php echo "$mana_fee" ?>%.</li>
                                                            <li>Credit Life Insurance Fee: <?php echo "$insurance" ?>%.</li>
                                                            <li>Penal Charge: <?php echo "$penal_charge" ?>%.</li>
                                                            <li>Repayment must be made according to my preffered repayment tenure.</li>
                                                            <li>I waive <?php echo$loan_period ?>-days maximum cooling off period to enable disbursement.</li>
                                                            <li>I accept that <?php echo$sitename ?> reserved the right to decline my loan request.</li>
                                                        </ul>
                                                        <div id="Result"></div>
                                        <div class="buysell-field form-action">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary" id="btn">Continue</button>
                                        </div>
                                    </form><!-- .buysell-form -->
                                </div><!-- .buysell-block -->
                            </div><!-- .buysell -->
                        </div>
                    </div>
                </div>

            <?php } ?>
                  <script src="../js/jquery.min.js"></script>
         <script type="text/javascript">
            $(document).ready(function (e) {
        	$("#loanRequest").on('submit',(function(e) {
        	document.getElementById("btn").disabled = true;	
		    e.preventDefault();
		    $.ajax({
        	url: "../scripts/auth?action=loanRequest",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
		    document.getElementById("btn").disabled = false;	
			$("#Result").html(data);
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
        $(document).ready(function (e) {
        	$("#acceptForm").on('submit',(function(e) {
        	document.getElementById("btn2").disabled = true;	
		    e.preventDefault();
		    $.ajax({
        	url: "../scripts/auth?action=acceptLoan",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
		    document.getElementById("btn2").disabled = false;	
			$("#Result2").html(data);
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>
<?php include 'footer.php'; ?>