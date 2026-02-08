<?php
include("functions.php");
usserAccessCheck();
include("userdata.php");
if(isset($_POST)){
  sleep(3);
  $icCode = filterString($_POST['ic']);
  if (empty($icCode)) {
    echo "<script>    
              toastr.error('Insurance Code is required!', 'Empty field', {\"progressBar\": true});
              document.getElementById('ic').style.borderColor='red';
             </script>";
             die();
  }
  if($_SESSION['icCounter'] <= 1){
       echo "<script>
               Swal.fire('Maximum Insurance code attempts exceeded!', '$cot_error', 'error');
                  document.getElementById('ic').style.borderColor='red';
                  document.getElementById('ic').style.color='red';
                  </script>";
                  $query = $conn->query("UPDATE users SET status = 'blocked' WHERE id = '$userid'");
                  session_destroy();
                  ?>
                  <meta http-equiv="refresh" content="5; url=../">
                  <?php
                  
         die();
  }
    
    if ($usersic != $icCode) {
            $count = $_SESSION['icCounter'];
            $newcount = $count - 1;
              echo "<script>
               Swal.fire('Invalid Insurance code !!', 'For security purpose, Your account will be suspended once you exceed the maximum trial limit. You  have $newcount attempts left.', 'error');
                  document.getElementById('ic').style.borderColor='red';
                  document.getElementById('ic').style.color='red';
                  </script>";
              $_SESSION['icCounter'] = $newcount;    
             die();
    }
    
    if ($usersic == $icCode) {
      echo "<script>
               Swal.fire('Valid Insurance Code supplied!', 'Your transaction will be continued. Redirecting...', 'success');
                document.getElementById('ic').style.borderColor='green';
                  document.getElementById('ic').style.color='green';
                  </script>";   
       ?>
      <meta http-equiv="refresh" content="3; url=../personal-banking/auth?verification=tin&transferToken=<?php echo $_SESSION['transaction_session']?>">
       <?php
    }
 
}
?>