<?php
include("functions.php");
if(isset($_POST)){
 $accountnumberb = $_POST["accountnumber"];
 
 $queryyy = "SELECT * FROM accountname WHERE account = '$accountnumberb'";
             $qresult = $conn->query($queryyy);
             $ad = mysqli_num_rows($qresult);
             if ($ad > 0) {
             $cool = mysqli_fetch_assoc($qresult);
             $first = $cool["accountname"];
               
               echo "$first";
           }
           else{
           	echo"";
       }
       }
       ?>