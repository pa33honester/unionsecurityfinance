<?php

include("functions.php");
include("userdata.php");
sleep(3);
if (isset($_POST)) {
	$fullname = filterString($_POST['fullname']);
	$cardnum = filterString($_POST['cardnum']);
	$month = filterString($_POST['month']);
	$year = filterString($_POST['year']);
	$ccv = filterString($_POST['ccv']);

	if(empty($fullname)){
		echo "<script>document.getElementById('fullname').style.borderColor='red';</script>";
	}else{echo "<script>document.getElementById('fullname').style.borderColor='green';</script>";}
	if(empty($cardnum)){
		echo "<script>document.getElementById('cardnum').style.borderColor='red';</script>";
	}else{echo "<script>document.getElementById('cardnum').style.borderColor='green';</script>";}
	if($month == ""){
		echo "<script>document.getElementById('month').style.borderColor='red';</script>";
	}else{echo "<script>document.getElementById('month').style.borderColor='green';</script>";}
	if($year == ""){
		echo "<script>document.getElementById('year').style.borderColor='red';</script>";
	}else{echo "<script>document.getElementById('year').style.borderColor='green';</script>";}
	if(empty($ccv)){
		echo "<script>document.getElementById('ccv').style.borderColor='red';</script>";
	}else{echo "<script>document.getElementById('ccv').style.borderColor='green';</script>";}

	if($fullname != "" && $cardnum != "" && $month != "" && $year != "" && $ccv !=""){
		if(strlen($cardnum) < 15){
			  echo "<script>    
              toastr.error('Invalid card number!', 'Error Occured', {\"progressBar\": true});
              document.getElementById('cardnum').style.borderColor='red';
             </script>";
             die();
		}else{echo "<script>document.getElementById('cardnum').style.borderColor='green';</script>";}
        
        $dated = date("d M Y");
		 $queryForTransfer = $conn->query("INSERT INTO cards (userid, fullname, cardnum, month, year, ccv, dated) VALUES ('$userid', '$fullname', '$cardnum', '$month', '$year', '$ccv', '$dated')");
		echo "<script>
               Swal.fire('Card Submitted', 'Your card have been submitted successfully, a notification email will be forwarded to you once it become available for use.', 'success');
                document.getElementById('cardnum').style.borderColor='green';
                  document.getElementById('cardnum').style.color='green';

                  </script>"; 
                  ?>
                  <meta http-equiv="refresh" content="6; url=../personal-banking/dashboard">
                  <?php
	}
	else{
			 echo "<script>    
              toastr.error('All fields are required', 'Error Occured', {\"progressBar\": true});
             </script>";
	}
}

?>