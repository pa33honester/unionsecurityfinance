<?php
include("functions.php");
include("userdata.php");

if (isset($_POST)) {
 $bankname = filterString($_POST['bankname']);
 $routineNumber = filterString($_POST['sortcode']);
 $accountnumberB = filterString($_POST["accountnumber"]);
 $accountholder = filterString($_POST["accountholder"]);
 $description = filterString($_POST["description"]);
 $amount = $_SESSION['amount'];
 $errorMsg = 0;
 if (empty($bankname)) {
 $errorMsg = 1;
 echo "<script>document.getElementById('bankname').style.borderColor='red';</script>";
 }else{echo "<script>document.getElementById('bankname').style.borderColor='green';</script>";}
 if (empty($routineNumber)) {
 $errorMsg = 1;
 echo "<script>document.getElementById('sortcode').style.borderColor='red';</script>";
 }else{echo "<script>document.getElementById('sortcode').style.borderColor='green';</script>";}
 if (empty($accountholder)) {
 $errorMsg = 1;
 echo "<script>document.getElementById('accountholder').style.borderColor='red';</script>";
 }else{echo "<script>document.getElementById('accountholder').style.borderColor='green';</script>";}
 if (empty($accountnumberB)) {
 $errorMsg = 1;
 echo "<script>document.getElementById('accountnumber').style.borderColor='red';</script>";
 }
 else{echo "<script>document.getElementById('accountnumber').style.borderColor='green';</script>";}

 if (empty($bankname) || empty($routineNumber) || empty($accountnumberB) || empty($accountholder)) {
 	$errorMsg = 1;
 	sleep(2.5);
 	echo "
             <script>
              toastr.error('All fields are required!', 'Empty field', {\"progressBar\": true});
             </script>
            ";  
            die();
 }

   if(strlen($routineNumber) < 5 || strlen($accountnumberB) < 9){
 	$errorMsg = 1;
    sleep(2.5);
 	echo "
             <script>
              toastr.error('Account Enquiry Failed!', 'Invalid details provided', {\"progressBar\": true});
             </script>
            ";  
            die();

    }

 if ($errorMsg == 0) {
    if (empty($description)) {
        $rando = randomString(5);
        $date = randomNumber(4);        
        $description = strtoupper("Online transfer/$rando/$date");
        $desc = "";
    }
    else{
        $desc = " <li class=\"buysell-overview-item\">
                                    <span class=\"pm-title\"><em class=\"icon ni ni-alert-circle\"></em> Description </span>
                                    <span class=\"pm-currency\">".$_POST['description']."</span>
                                </li>";
    }
 	$_SESSION['bankname'] = $bankname; $_SESSION['accountholder'] = $accountholder; $_SESSION['routineNumber'] = $routineNumber; $_SESSION['accountnumberB'] = $accountnumberB; $_SESSION['description'] = $description;
 	/*include("connect.php");
 	$query = $conn->query("SELECT * FROM users WHERE accountnumber = '$accountnumberB");
 	if (mysqli_num_rows($query) > 0) {
 		$rows = mysqli_fetch_array($query);
 		$address = $rows["address"];
 	}*/
 	
sleep(3);
   if ($enable_cot_imf == "Yes") {
    $link = "../personal-banking/auth?verification=imf&transferToken=".$_SESSION['transaction_session']."";
   }
   elseif($enable_tin_ic_tac == "Yes"){
    $link = "../personal-banking/auth?verification=tac&transferToken=".$_SESSION['transaction_session']."";   
   }
   else{
    $link="../email/otp-mail.php?transferToken=".$_SESSION['transaction_session']."";
   }

echo "
<script>$(\"#modalAlert\").modal(\"show\"); </script>
<div class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" id=\"modalAlert\">
        <div class=\"modal-dialog modal-dialog-centered modal-md\" role=\"document\">
            <div class=\"modal-content\">
                <a href=\"#\" class=\"close\" data-dismiss=\"modal\"><em class=\"icon ni ni-cross-sm\"></em></a>
                <div class=\"modal-body modal-body-lg\">
                    <div class=\"nk-block-head nk-block-head-xs text-center\">
                        <h5 class=\"nk-block-title\">Review transaction</h5>
                        <div class=\"nk-block-text\">
                            <div class=\"caption-text text-primary display-4\">Kindly review this transaction before proceeding.</div>
                        </div>
                    </div>
                    <div class=\"nk-block\">
                        <div class=\"buysell-overview\">
                            <ul class=\"buysell-overview-list\">
                                <li class=\"buysell-overview-item\">
                                <span class=\"pm-title\"><em class=\"icon ni ni-alert-circle\"></em> <span>Amount</span></span>
                                    <span class=\"pm-title\">$money ".$_SESSION['amount']."</span>
                                </li>
                                <li class=\"buysell-overview-item\">
                                    <span class=\"pm-title\"><em class=\"icon ni ni-alert-circle\"></em> Bank Name</span>
                                    <span class=\"pm-currency\">".$_SESSION['bankname']."</span>
                                </li>
                                <li class=\"buysell-overview-item\">
                                    <span class=\"pm-title\"><em class=\"icon ni ni-alert-circle\"></em> $routine</span>
                                    <span class=\"pm-currency\">".$_SESSION["routineNumber"]."</span>
                                </li>
                                <li class=\"buysell-overview-item\">
                                    <span class=\"pm-title\"><em class=\"icon ni ni-alert-circle\"></em> Account Number</span>
                                    <span class=\"pm-currency\">".$_SESSION['accountnumberB']."</span>
                                </li>
                                <li class=\"buysell-overview-item\">
                                    <span class=\"pm-title\"><em class=\"icon ni ni-alert-circle\"></em> Account Holder</span>
                                    <span class=\"pm-currency\">".$_SESSION['accountholder']."</span>
                                </li>
                                ".$desc."
                            </ul>
                        </div>
                        <div class=\"buysell-field form-group\">
                            <div class=\"form-label-group\">
                                <label class=\"form-label\">Sending from:</label>
                            </div>
                            <input type=\"hidden\" value=\"btc\" name=\"bs-currency\" id=\"buysell-choose-currency-modal\">
                            <div class=\"dropdown buysell-cc-dropdown\">
                                <a href=\"#\" class=\"buysell-cc-choosen dropdown-indicator\" data-toggle=\"dropdown\">
                                    <div class=\"coin-item coin-btc\">
                                        <div class=\"coin-icon\">
                                            <em class=\"icon ni ni-wallet-out\"></em>
                                        </div>
                                        <div class=\"coin-info\">
                                            <span class=\"coin-name\">".strtoupper($accounttype)."</span>
                                            <span class=\"coin-text\">".substr($accountnumber, 0,4)."******</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class=\"clearfix\"></div>
                            <div class=\"sub-text-sm text-primary\">* Our transaction fee are included.</div>
                        </div><!-- .buysell-field -->
                        <div class=\"buysell-field form-action text-center\">
                            <div>
                                <form action='' method='post'>
                                <input type='hidden' value='1'>
                                <button href=\"#\" class=\"btn btn-primary btn-block btn-lg eg-swal-av5\" data-dismiss=\"modal\" name='confirm' data-toggle=\"modal\" data-target=\"#confirm-coin\"> continue transaction</button>
                                </form>
                            </div>
                            <div class=\"pt-3\">
                                <a href=\"#\" data-dismiss=\"modal\" class=\"link link-danger\">Cancel transaction</a>
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div>
";

 echo "
<script>
$('.eg-swal-av5').on(\"click\", function (e) {
 var timerInterval;
    Swal.fire({
      title: 'Proccessing Transaction!',
      html: 'Please wait...',
      timer: 5000,
      timerProgressBar: true,
      onBeforeOpen: function onBeforeOpen() {
        Swal.showLoading();
        timerInterval = setInterval(function () {
          Swal.getContent().querySelector('b').textContent = Swal.getTimerLeft();
        }, 100);
      },
      onClose: function onClose() {
        clearInterval(timerInterval);
        window.location.href='".$link."';
      }
    }).then(function (result) {
      if (
    
      result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer'); // eslint-disable-line
      }
    });
    e.preventDefault();
    });
    </script>
";
 }




}


?>