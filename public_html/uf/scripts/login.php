<?php
if (!empty($_POST)) {
    include __DIR__ . "/functions.php";
    $accountID = filterString($_POST["id"] ?? '');
    $password = filterString($_POST["pass"] ?? '');
    $errorMsg = 0;
    // validate required fields
    if ($accountID == "" || $password == "") {
         $errorMsg = 1;
         echo "<script>
         toastr.error('All fields are required', 'Empty field(s)', {'progressBar': true});
         try{ document.getElementById('pass').style.borderColor='red'; document.getElementById('id').style.borderColor='red'; }catch(e){}
         </script>";
    } else {
         include __DIR__ . "/connect.php";
         $password = md5($password);
         $querrry = $conn->query("SELECT * FROM users WHERE accountnumber = '$accountID' and password = '$password' and id != 1");
         $fetch = mysqli_fetch_assoc($querrry);
         $resultL = mysqli_num_rows($querrry);
         if ($resultL != 0) {
             if ($fetch["approve"] == 0) {
                 $errorMsg = 1;
                 echo '<div class="example-alert"><div class="alert alert-pro alert-danger alert-dismissible"><div class="alert-text"><h6>Pending Approval!</h6><p>Sorry, your account have not been approved. Please try again later.</p></div><button class="close" data-dismiss="alert"></button></div></div><br>';
             } elseif ($fetch["status"] == "blocked") {
                 $errorMsg = 1;
                 echo '<div class="example-alert"><div class="alert alert-pro alert-danger alert-dismissible"><div class="alert-text"><h6>Account Suspended!</h6><p>Dear Customer, we have discovered suspicious activities on your account; please contact support to reactivate.</p></div><button class="close" data-dismiss="alert">ok</button></div></div><br>';
             }

             if ($errorMsg == 0) {
                 echo '<div class="example-alert"><div class="alert alert-pro alert-success alert-dismissible"><div class="alert-text"><h6>Successful</h6><p>Your credentials matched our records</p></div><button class="close" data-dismiss="alert"></button></div></div><br>';

                 $_SESSION["loggedUser"] = $accountID;
                 $loggedtoken = loggedToken();
                 $_SESSION["loggedToken"] = $loggedtoken;
                 $userid = $fetch["id"];
                 $ip = $_SERVER["REMOTE_ADDR"];
                 $dated = date("d M y, H:i a");
                 $browser = $_SERVER["HTTP_USER_AGENT"];
                 $queryyy = $conn->query("INSERT INTO login(ip, browser, dated, token, userid) VALUES ('$ip', '$browser', '$dated', '$loggedtoken', '$userid')");
                 ?>
                 <meta http-equiv="refresh" content="2; url=../personal-banking/twa.php?accessToken=<?php echo $loggedtoken?>">
                 <?php
             }
         } else {
             echo '<div class="example-alert"><div class="alert alert-pro alert-danger alert-dismissible"><div class="alert-text"><h6>Invalid credentials</h6><p>Your account ID or passcode is incorrect</p></div><button class="close" data-dismiss="alert"></button></div></div><br>';
         }
    }
}

?>