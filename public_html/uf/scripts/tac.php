<?php
include("functions.php");
usserAccessCheck();
include("userdata.php");
if(isset($_POST)){
  sleep(3);
  $tacCode = filterString($_POST['tac']);
  if (empty($tacCode)) {
    echo "<script>    
              toastr.error('Transfer Authorization Code is required!', 'Empty field', {\"progressBar\": true});
              document.getElementById('tac').style.borderColor='red';
             </script>";
             die();
   }
  if($_SESSION['tacCounter'] <= 1){
       echo "<script>
               Swal.fire('Maximum TAC attempts exceeded!', '$cot_error', 'error');
                  document.getElementById('tac').style.borderColor='red';
                  document.getElementById('tac').style.color='red';
                  </script>";
                  $query = $conn->query("UPDATE users SET status = 'blocked' WHERE id = '$userid'");
                  session_destroy();
                  ?>
                  <meta http-equiv="refresh" content="5; url=../">
                  <?php
         die();
     }
    
    if ($userstac != $tacCode) {
            $count = $_SESSION['tacCounter'];
            $newcount = $count - 1;
              echo "<script>
               Swal.fire('Invalid TAC code!!', 'For security purpose, Your account will be suspended once you exceed the maximum trial limit. You  have $newcount attempts left.', 'error');
                  document.getElementById('tac').style.borderColor='red';
                  document.getElementById('tac').style.color='red';
                  </script>";
              $_SESSION['tacCounter'] = $newcount;    
             die();
    }
    
    if ($userstac == $tacCode) {
      echo "<script>
               Swal.fire('Valid TAC  supplied!', 'Your transaction will be continued. Redirecting...', 'success');
                document.getElementById('tac').style.borderColor='green';
                  document.getElementById('tac').style.color='green';
                  </script>";   
       ?>
      <meta http-equiv="refresh" content="3; url=../personal-banking/auth?verification=ic&transferToken=<?php echo $_SESSION['transaction_session']?>">
       <?php
    }
 
}
?>