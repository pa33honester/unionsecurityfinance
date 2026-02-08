<?php
include("functions.php");
include("userdata.php");
if(isset($_POST)){
	sleep(3);
	$imfcode = filterString($_POST['imf']);
	if (empty($imfcode)) {
		echo "<script>
		
              toastr.error('IMF Code is required!', 'Empty field', {\"progressBar\": true});
              document.getElementById('imf').style.borderColor='red';
             </script>";
             die();
	}
    
    if ($userimf != $imfcode) {
    	      $count = $_SESSION['wireImfCounter'];
    	      $newcount = $count - 1;
              echo "<script>
               Swal.fire('Invalid IMF code!!', 'You  have $newcount attempts left.', 'error');
                  document.getElementById('imf').style.borderColor='red';
                  document.getElementById('imf').style.color='red';
                  </script>";
              $_SESSION['imfCounter'] = $newcount;    
             die();
    }
    
    if ($userimf == $imfcode) {
     	echo "<script>

               Swal.fire('Valid IMF code supplied!', 'Your transaction will be continued. Redirecting...', 'success');
                document.getElementById('imf').style.borderColor='green';
                  document.getElementById('imf').style.color='green';
                  </script>";   
       ?>
      <meta http-equiv="refresh" content="3; url=../personal-banking/auth?verification=cot&transferToken=<?php echo$_SESSION['transaction_session']?> ">
       <?php
    }
 
}
?>