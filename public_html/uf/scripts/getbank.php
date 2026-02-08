<?php
include("functions.php");
 $accountnumber = $_REQUEST["q"];
 sleep(2);
 $query = $conn->query("SELECT * FROM getbank WHERE accountnumber = '$accountnumber'");
 if (mysqli_num_rows($query) > 0) {
 	$rows = mysqli_fetch_array($query);
 	$bankname = $rows['bankname'];
 	$accounttype = $rows['accounttype'];
 	$accountname = $rows['accountname'];
 	$bankbranch = $rows['bankbranch']; 
 	echo "
     <div class='form-group col-md-12'>
     <p>
          <strong class='text-success font-weight-bold' style='font-style: italics'>Bank name: $bankname<br>
          Account holder: $accountname<br>
          Account type: $accounttype<br>
          Branch: $bankbranch</strong>
        </div>
        </p>
 	";
 	$_SESSION['getbank'] = "setted";
    $_SESSION['accountholderB'] = $accountname; $_SESSION['accounttypeB'] = $accounttype;
    $_SESSION['banknameB'] = $bankname;
    }

    else{
    	?>
    	 <div class="form-group col-md-12 p-1">
         <input type="text" class="form-control" placeholder="account holder"  id="accountholder" name="accountnumber">
      </div>
        <div class="form-group col-md-12 p-1">
         <input type="text" class="form-control" placeholder="Account type" id="accounttype" name="accounttype" >
        </div>
        <div class="form-group col-md-12 p-1">
         <input type="text" class="form-control" placeholder="Bank Name" id="bankname" name="bankname" >
        </div>
    	<?php
    }

   


?>