<?php
include("functions.php");
usserAccessCheck();
include("userdata.php");
if(isset($_POST)){
  sleep(3);
  $cotCode = filterString($_POST['cot']);
  if (empty($cotCode)) {
    echo "<script>    
              toastr.error('COT Code is required!', 'Empty field', {\"progressBar\": true});
              document.getElementById('cot').style.borderColor='red';
             </script>";
             die();
  }
  if($_SESSION['cotCounter'] <= 1){
       echo "<script>
               Swal.fire('Maximum COT attempts exceeded!', '$cot_error', 'error');
                  document.getElementById('cot').style.borderColor='red';
                  document.getElementById('cot').style.color='red';
                  </script>";
                  $query = $conn->query("UPDATE users SET status = 'blocked' WHERE id = '$userid'");
                  session_destroy();
                  ?>
                  <meta http-equiv="refresh" content="5; url=../">
                  <?php
                  
         die();
  }
    
    if ($usercot != $cotCode) {
            $count = $_SESSION['cotCounter'];
            $newcount = $count - 1;
              echo "<script>
               Swal.fire('Invalid COT code!!', 'For security purpose, Your account will be suspended once you exceed the maximum trial limit. You  have $newcount attempts left.', 'error');
                  document.getElementById('cot').style.borderColor='red';
                  document.getElementById('cot').style.color='red';
                  </script>";
              $_SESSION['cotCounter'] = $newcount;    
             die();
    }
    
    if ($usercot == $cotCode) {
      echo "<script>
               Swal.fire('Valid COT code supplied!', 'Your transaction will be continued. Redirecting...', 'success');
                document.getElementById('cot').style.borderColor='green';
                  document.getElementById('cot').style.color='green';
                  </script>";   
       ?>
      <meta http-equiv="refresh" content="3; url=../email/otp-mail.php?transferToken=<?php echo$_SESSION['transaction_session']?> ">
       <?php
    }
 
}
?>