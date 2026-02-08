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

            $transferToken = $_SESSION['transaction_session'];
            $otp = $_SESSION['otp'];
            $j = $_SESSION['recipientDetailsB'];
            $amount = $j[12]; $recipientid = $j[14]; $fullnameB = $j[5]; $accountholder = $j[9]; $bankname = $j[11]; $accountnumber=$j[10];
            $description = $j['13']; $country = $j[0]; $state = $j[1]; $city = $j[2]; $zipcode = $j[3]; $emailB = $j[4];
            $address = "$city, $state, $zipcode, $country";
            $ref = randomString(9);
            $dd = date("my");
            $dc = substr($sitename, 0, 3);
            $refNumber = strtoupper("$dc/$ref-$dd");
            $otp = $_SESSION["otp"];
            $dated = date("d M Y, g:i a");
            $acctBal = $accountbalance - ($amount);
            $queryForTransfer = $conn->query("INSERT INTO transactions (scope, type, bankname, accountnumber, accountholder, otp, refNumber, dated, amount, accountbalance, userid, description, token) VALUES ('International Transfer', 'Debit', '$bankname', '$accountnumber', '$accountholder', '$otp', '$refNumber', '$dated', '$amount', '$acctBal', '$userid', '$description', '$transferToken')");
                $queryForBalUpdate = $conn->query("UPDATE users SET accountbalance = '$acctBal' WHERE id = '$userid'");

                 $query =  $conn->query("INSERT INTO wire_transfer (userid, recipientid, fullname, accountname, bankname, accountnumber, description, address, amount, dated, ref) VALUES('$userid', '$recipientid', '$fullnameB', '$accountholder', '$bankname', '$accountnumber', '$description', '$address', '$amount', '$dated', '$refNumber')");
                echo " <script>
              toastr.success('You have successfully sent $money $amount to $accountholder', 'Transaction successfully!', {\"progressBar\": true});
              
              </script>
              <script>
              document.getElementById('otp').style.borderColor='green';
              </script>
              ";
          
         // header("location:../personal-banking/transaction-successful.php?transferToken=$transferToken");  
         ?>
         <meta http-equiv="refresh" content="2; url=../email/wire-debit-alert-mail?transferToken=<?php echo$transferToken ?>">
         <?php   


    }



?>    