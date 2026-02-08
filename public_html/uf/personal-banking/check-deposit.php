<?php include("header.php"); ?>
 <div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-head-sub">
                                </div>
                                <div class="nk-block-between-md g-4 card-bordered">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title fw-normal">Internet Banking Check Deposit.</h4>
                                        <div class="nk-block-des">
                                            <p>you can deposit checks by snapping pictures of the front and back of the check.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <ul class="nk-block-tools gx-3">
                                            <li><a href="transfer" class="btn btn-secondary btn-light text-light"><span>Transfer Fund</span><em class="icon ni ni-wallet-out"></em></a></li>
                                        </ul>

                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                        </div>
                    </div>
                  <div class="card card-bordered">
               <div class="card-header font-weight-bold text-light" style="background-color:#033d75;">Deposit a check</div>
          <div class="card-inner">
        <h5 class="card-title">Check Deposit tips</h5>
        <p class="card-text"><em class="icon ni ni-alert-circle text-danger" style="font-size: 18px; font-weight: 600;"></em> Choose the account to deposit the check and the check amount.</p>
        <p class="card-text"><em class="icon ni ni-alert-circle text-danger" style="font-size: 18px; font-weight: 600;"></em> Ensure the check has been properly endorsed and that it is flat, on a dark, well-lit surface. Then snap pictures of both the front and back of the check, keeping it in the correct parameters. Don’t forget to endorse and write ‘for mobile deposit only’ on the back.
        </p>
         <p class="card-text"><em class="icon ni ni-alert-circle text-danger" style="font-size: 18px; font-weight: 600;"></em> Submit your check for deposit! We’ll send you an email confirmation that we’ve received your deposit and an email confirmation once it is accepted. Be sure to hold on to your check until you receive this confirmation, once received, destroy the check!
        </p>
        <hr>
        <form action="" method="post" class="buysell-form" enctype="multipart/form-data"> 
        	<?php 
        	include("../scripts/userdata.php");
            if (isset($_POST['check'])) {
            	 $amount =  filterString($_POST["amount"]);
            	 if ($amount == "") {
            	 	echo "<div class='alert bg-danger text-light'>Kindly enter the check amount</div>";
            	  }
            	  else{
            	  	if ($amount < 5) {
            	  		echo "<div class='alert bg-danger text-light'>Minimum of 5 $money is allowed for check Deposit</div>";
            	  	}
            	   elseif($amount >= 5){
            	   	$target_dir = "../img/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtoupper(pathinfo($target_file,PATHINFO_EXTENSION));
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                    $uploadOk = 1;
                    } else {
                    echo "<div class='alert alert-danger'>Only image is allowed</div>";
                    $uploadOk = 0;
                    }
   
                    // Allow certain file formats
                    /*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                       && $imageFileType != "gif" ) {
                     echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
                    $uploadOk = 0;
                    }*/
                    if($uploadOk == 0){}else{
                    $newname = "".substr($sitename, 0,3)."IMG".date("YmdHi")."-".randomString(5)."."; 
                    $newname =strtoupper($newname);
                    $target_file = "$target_dir$newname$imageFileType";   
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        //INSERT INTO TRANSACTION RECORDS
                    $ref = randomString(9);
                    $dd = date("my");
                    $dc = substr($sitename, 0, 3);
                    $refNumber = strtoupper("$dc/$ref-$dd");
                    $dated = date("d M Y, g:i a");
                    $acctBal = ($accountbalance + ($amount));
                    $description = strtolower("Mobile Check Deposit-".randomString(5)."/".randomNumber(4)."");
                    $queryForTransfer = $conn->query("INSERT INTO transactions (scope, type, refNumber, dated, amount, accountbalance, userid, description, status) VALUES ('Check Deposit', 'Credit', '$refNumber', '$dated', '$amount', '$acctBal', '$userid', '$description', 0)");
                    $front = "$newname$imageFileType";
                    $dated = date("d M Y, H:i"); 
                    $check_number = randomNumber(9);
                    $query = $conn->query("INSERT INTO check_deposit (user_id, amount, front, date_created, check_number, ref) VALUES ('$userid', '$amount', '$front', '$dated', '$check_number', '$refNumber')");
                    

                    echo"<div class='alert alert-success'>Your check has been successfully deposited</div>";
                     $_SESSION['amount'] = $amount;
                     $_SESSION['dated'] = $dated;
                     $_SESSION['check_number'] = $check_number;
                    ?>
                    <meta http-equiv="refresh" content="3; url=check-mail?check_number='<?php echo $check_number;?>'">
                    <?php
                    } else {
                    echo "<div class='alert alert-danger'>Sorry, there was an error uploading your passport.</div>";
                     }
            	    }
            	   }
            	  }

            }
        	?>
        	<div class="buysell-field form-group"> 
        		<div class="form-label-group"> 
        			<label class="form-label">Select Account</label> 
        		</div>
        		<div class="dropdown buysell-cc-dropdown"> <a href="#" class="buysell-cc-choosen dropdown-indicator" data-toggle="dropdown"> <div class="coin-item coin-btc"> 
        			<div class="coin-icon"> 
        				<em class="icon ni ni-sign-<?php echo strtolower($money); ?>"></em> 
        			</div> 
        			<div class="coin-info"> 
        				<span class="coin-name"><?php echo "$accounttype";?> (<?php echo "$usercurrency";?>)</span> 
        				<span class="coin-text">Available Balance: <?php echo "$usercurrency"; ?> <?php echo number_format(currencyConverter($accountbalance));?></span> 
        			</div> 
        		</div> </a>
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
        	  		 		 	<span class="coin-text">Available Balance:<?php echo "$usercurrency ".number_format(currencyConverter($accountbalance))."";?>
        	  		 		 		
        	  		 		 	</span> 
        		           </div>
        		       </div>
        		      </a>
        		   </li>
        		 </ul> 
        		</div><!-- .dropdown-menu --> </div><!-- .dropdown --> </div><!-- .buysell-field --> <div class="buysell-field form-group"> <div class="result"></div> <div class="form-label-group"> <label class="form-label" for="buysell-amount">Check Amount</label> </div> <div class="form-control-group"> 
        			<input type="number" class="form-control form-control-lg form-control-number" id="amount" name="amount" placeholder="2000"> <div class="form-dropdown"> <div class="text"><?php echo$money; ?><span></span></div> </div> </div> <div class="form-note-group"> <span class="buysell-min form-note-alt"></span> <span class="buysell-rate form-note-alt">You can deposit upto <?php echo $money ?> for each federal check</span> </div> </div>
        	<!-- .buysell-field --> 
           <div class="buysell-field form-group row">
         	<div class="form-group col-md-6">
    <label class="form-label" for="customFileLabel">Front of the check</label>
    <div class="col-md-12 p-0">
    <img class="img-responsive" id="output_imageB" src="../img/size.jpg" style="width:100%; height:130px">
   </div>
   <p class="clear-fix"></p>
    <div class="form-control-wrap">
        <div class="custom-file">
            <input type="file" name="fileToUpload" class="custom-file-input" id="fileTag" accept="image/*" onchange="preview_imageB(event)">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>
</div>
<div class="form-group col-md-6">
    <label class="form-label" for="customFileLabel">Back of the check</label>
    <div class="col-md-12 p-0">
    <img class="img-responsive" id="output_image" src="../img/size.jpg" style="width:100%; height:130px">
   </div>
   <p class="clear-fix"></p>
    <div class="form-control-wrap">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="back" accept="image/*" onchange="preview_image(event)">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>
</div>
<script type='text/javascript'>
function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_image');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}
function preview_imageB(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_imageB');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}
</script>

         </div>
        	<!-- .buysell-field --> 
        <div class="buysell-field form-action">
          <button type="submit" name="check" class="btn btn-lg btn-block btn-primary dep">Submit check</button> 
      </div>
      <!-- .buysell-field --> 
      <div class="form-note text-base text-center">Note: our Flash fund fee will be debucted from your account following the completion of this deposit.</div> 
  </form>
      <!-- .buysell-form -->
    </div>
</div>
 <script src="../assets/js/jquery.min.js"></script>
<?php include("footer.php"); ?>