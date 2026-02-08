<?php
include("functions.php");
include("connect.php");
include("userdata.php");
/*echo "
<script>
 var timerInterval;
    Swal.fire({
      title: 'Auto close alert!',
      html: 'I will close in <b></b> milliseconds.',
      timer: 2000,
      timerProgressBar: true,
      onBeforeOpen: function onBeforeOpen() {
        Swal.showLoading();
        timerInterval = setInterval(function () {
          Swal.getContent().querySelector('b').textContent = Swal.getTimerLeft();
        }, 100);
      },
      onClose: function onClose() {
        clearInterval(timerInterval);
      }
    }).then(function (result) {
      if (
    
      result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer'); // eslint-disable-line
      }
    });
    e.preventDefault();
    </script>
";*/

if (isset($_POST)) {
	$amount = filterString($_POST["amount"]);

	if (empty($amount)) {
		sleep(2.4);
		echo "
             <script>
              toastr.error('Enter transfer Amount', 'Empty field', {\"progressBar\": true});
              document.getElementById('amount').style.borderColor='red';
             </script>
             
            ";
            die();
	}

	if ($amount > $accountbalance) {
	sleep(2.5);
	 echo  "
             <script>
              toastr.error('Your balance is $money $accountbalance', 'Insufficient account balance', {\"progressBar\": true});
             </script>
             
            ";
            die();

	}
  if ($allowtransfer == 0 && $blocktransfer == 0) {
    echo "<script>
               Swal.fire('Transaction restricted', '$rest_msg', 'error');
         </script>"; 
  }
	else {
		 $transferSession = randomString(64);
		 $_SESSION['transaction_session'] = $transferSession;
		 $_SESSION['amount']= $amount;
		 ?>
         <meta http-equiv="refresh" content="3; url=transfer.php?transaction_session=<?php echo $transferSession ?>">
		 <?php
	}
}

?>