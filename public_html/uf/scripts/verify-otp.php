<?php
    include("functions.php");
    include("userdata.php");
    if (isset($_POST)) {
        sleep(3);
    $otpB  = $_POST["otp"];
    $errorMsg = 0;
    if (empty($otpB)) {
        $errorMsg = 1;
        sleep(2.5);
        echo " <script>
              toastr.error('OTP code required!', 'Empty field', {\"progressBar\": true});
              </script>
                            <script>
              document.getElementById('otp').style.borderColor='red';
              </script>
              ";  
              die();    
         }

     if ($_SESSION['otp'] != $otpB) {
        $errorMsg = 1;
        sleep(2.5);
        echo " <script>
              toastr.error('Invalid OTP!', 'Error', {\"progressBar\": true});
              
              </script>
              <script>
              document.getElementById('otp').style.borderColor='red';
              </script>
              "; 
                die();
             
             
         }  

            $bankname =  $_SESSION["bankname"];
            $routineNumber = $_SESSION["routineNumber"];;
            $accountnumberB = $_SESSION["accountnumberB"];
            $transferToken = $_SESSION["transaction_session"];
            $accountholder = $_SESSION["accountholder"];
            $description = $_SESSION['description'];
            $amount = $_SESSION['amount'];
            include("connect.php");
            include("userdata.php");
            $ref = randomString(9);
            $dd = date("my");
            $dc = substr($sitename, 0, 3);
            $refNumber = strtoupper("$dc/$ref-$dd");
            $otp = $_SESSION["otp"];
            $dated = date("d M Y, g:i a");
            $acctBal = ($accountbalance - ($_SESSION["amount"]));
            $queryForTransfer = $conn->query("INSERT INTO transactions (scope, type, bankname, routineNumber, accountnumber, accountholder, otp, refNumber, dated, amount, accountbalance, userid, description, token) VALUES ('Local Transfer', 'Debit', '$bankname', '$routineNumber', '$accountnumberB', '$accountholder', '$otpB', '$refNumber', '$dated', '$amount', '$acctBal', '$userid', '$description', '$transferToken')");
                $queryForBalUpdate = $conn->query("UPDATE users SET accountbalance = '$acctBal' WHERE id = '$userid'");
                echo " <script>
              toastr.success('You have successfully sent $money $amount to $accountholder', 'Transaction successfully!', {\"progressBar\": true});
              
              </script>
              <script>
              document.getElementById('otp').style.borderColor='green';
              </script>
              ";

          
         // header("location:../personal-banking/transaction-successful.php?transferToken=$transferToken");  
         ?>
         <meta http-equiv="refresh" content="0; url=../email/debit-alert-mail?transferToken=<?php echo$transferToken ?>">
         <?php   


    }



?>    