<?php
require_once("../scripts/functions.php");
checkAccess();
$n1 = rand(0,9);
$n2 = rand(0,9);
$n3 = rand(0,9);
$n4 = rand(0,9);
$n5 = rand(0,9);
$n6 = rand(0,9);
$captcha = "$n1$n2$n3$n4$n5$n6";
if(isset($_GET['tc'] ) AND $_GET['tc'] == 1){
 ?> 


<!DOCTYPE html>
<html lang="en-US" class="js">
<head>  
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $description ?>">
    <link rel="shortcut icon" href="../images/<?php echo $favicon ?>" type="image/x-icon">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../images/<?php echo $favicon ?>">
    <!-- Page Title  -->
    <title>Register |  Welcome to <?php  echo "$sitename";?> Online Banking</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../assets/css/dashlite.css?ver=2.4.0">
    <link rel="stylesheet" href="../scss/sweetalert.css">
    <link id="skin-default" rel="stylesheet" href="../assets/css/theme.css?ver=2.4.0">
    <link id="skin-default" rel="stylesheet" href="../assets/css/theme.css?ver=2.4.0">
     <link href="../css/toastr.css" rel="stylesheet"/>
</head>
<style type="text/css">
    .btn-primary{
        background-color: #033d75;
    }
    .btn-secondary{
        background-color: #d13636;
    }
    .btn-secondary:hover{opacity: 0.6;}
    .btn-primary:hover{opacity: 0.6;}
</style>

<body class="nk-body npc-crypto bg-white pg-auth">
<div class="nk-content">
 <div class="container-xl wide-lg">
        <div class="nk-content-body">
         <div class="nk-feature-conten p-3">
           <a href="<?php echo$site_url ?>"> <img src="../<?php echo$logo ?>" width="230" class="p-3"></a>
          </div>
     </div>
<div class="card card-bordered s-4 col-lg-12 p-0">
 <div class="card-header font-weight-bold text-light" style="background-color:#033d75;">
    <h5 class="text-white"><em class="icon ni ni-user-add-fill"></em> Kindly provide the information requested below to enable us create an account for you.</h5>
</div>  
<form action="../scripts/auth?action=registerUserAccount" method="post" enctype="multipart/form-data" id="registerForm">
<div class="card-body">
    <b>Personal Details</b>
    <hr>
<div class="row">
  <div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">First Name</label>
     <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
    </div>
   </div>
   <div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">Middle name</label>
     <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name" required>
    </div>
   </div>
    <div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">Last Name</label>
     <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
    </div>
   </div>
   <label class="form-label col-lg-12">Address</label>
   <?php include("../personal-banking/wire2.php"); ?>
    <div class="col-md-2">
   <div class="form-group">
    <label class="form-label" for="phone-no">Zip code</label>
     <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="zipcode/postal code" required>
    </div>
   </div>
   <div class="col-md-2">
   <div class="form-group">
    <label class="form-label" for="phone-no">Date of Birth</label>
     <input type="text" class="form-control date-picker" id="dob" name="dob" placeholder="Date of Birth" required>
    </div>
   </div>
    <div class="col-md-8">
   <div class="form-group">
    <label class="form-label" for="phone-no">House Address</label>
     <input type="text" class="form-control" id="address" name="address" placeholder="House address" required>
    </div>
   </div>
 <div class="col-md-6">
   <div class="form-group">
    <label class="form-label" for="phone-no">Phone Number</label>
     <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
    </div>
   </div>
    <div class="col-md-6">
   <div class="form-group">
    <label class="form-label" for="phone-no">Email address</label>
     <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email address" required>
    </div>
   </div>
</div>  
<hr>
<b>Employment information</b>
<div class="row">
 <div class="col-md-6">
   <div class="form-group">
    <label class="form-label" for="phone-no">Occupation</label>
       <select type="text" class="form-control" id="occupation" name="occupation" value="" required>
           <option value="">Select Type of Employment</option>
                    <option value="Self Employed">Self Employed</option>  
                    <option value="Self Employed">Public/Government Office</option>  
                    <option value="Self Employed">Private/Partnership Office</option>  
                    <option value="Self Employed">Business/Sales</option>  
                    <option value="Self Employed">Trading/Market</option>  
                    <option value="Self Employed">Military/Paramilitary</option>  
                    <option value="Self Employed">Politician/Celebrity</option>  
          </select>
    </div>
   </div>
   <div class="col-md-6">
   <div class="form-group">
    <label class="form-label" for="phone-no">Annual Income range</label>
       <select type="text" class="form-control" id="income" name="income" value="" required>
           <option value="">Select Salary Range</option>
                    <option value="$100.00 - $500.00">$100.00 - $500.00</option> 
                    <option value="$700.00 - $1,000.00">$700.00 - $1,000.00</option> 
                    <option value="$1,000.00 - $2,000.00">$1,000.00 - $2,000.00</option> 
                    <option value="$2,000.00 - $5,000.00">$2,000.00 - $5,000.00</option> 
                    <option value="$5,000.00 - $10,000.00">$5,000.00 - $10,000.00</option> 
                    <option value="$15,000.00 - $20,000.00">$15,000.00 - $20,000.00</option> 
                    <option value="$25,000.00 - $30,000.00">$25,000.00 - $30,000.00</option> 
                    <option value="$30,000.00 - $70,000.00">$30,000.00 - $70,000.00</option> 
                    <option value="$80,000.00 - $140,000.00">$80,000.00 - $140,000.00</option> 
                    <option value="$150,000.00 - $300,000.00">$150,000.00 - $300,000.00</option> 
                    <option value="$300,000.00 - $1,000,000.00">$300,000.00 - $1,000,000.00</option> 
          </select>
    </div>
   </div>
</div>
<hr>
<b>Banking  Details</b>
    <hr>
    <div class="row">
  <div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">SSN/TIN(Or equivalence)</label>
     <input type="text" class="form-control" id="ssn" name="ssn" required>
    </div>
   </div>
   <div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">Account Type</label>
       <select type="text" class="form-control" id="accounttype" name="accounttype" value="" required>
          <option value="">Please select Account Type</option> 
            <option value="Checking Account">Checking Account</option>
            <option value="Savings Account">Saving Account</option>
            <option value="Fixed Deposit Account">Fixed Deposit Account</option>
            <option value="Current Account">Current Account</option>
            <option value="Crypto Currency Account">Crypto Currency Account</option>
            <option value="Business Account">Business Account</option>
            <option value="Non Resident Account">Non Resident Account</option>
            <option value="Cooperate Business Account">Cooperate Business Account</option>
            <option value="Investment Account">Investment Account</option>
          </select>
     </div>
   </div>
    <div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">Account Currency</label>
     <select type="text" class="form-control" id="usercurrency" name="usercurrency">
        <?php include("currency.php"); ?>
     </select>
    </div>
   </div>
    <div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">2FA PIN</label>
     <input type="password" class="form-control" id="secretCode" maxlength="4" minlength="4" name="secretCode" required>
    </div>
   </div>
     <div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">Password</label>
     <input type="password" class="form-control" id="password" name="password"  required>
    </div>
   </div>
     <div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">Confirm Password</label>
     <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm password" required>
    </div>
   </div>
<div class="col-md-4">
   <div class="form-group">
    <label class="form-label" for="phone-no">Passport Photograph</label>
     <img src="passport/sample.png" style="width:100%; height:180px;" id="output_image">
     <input type="file" class="form-control" id="passport" name="passport" accept="image/*" onchange="preview_image(event)" required>
    </div>
   </div>
</div>
<div id="registerResult"></div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary" id="btn">Submit</button>
    <button type="reset" class="btn btn-danger ">Reset</button>
    <button type="button" onclick="window.history.go(-1);" class="btn btn-default "><em class="icon ni ni-arrow-left"></em> back</button>
</div>  
</form> 
</div>
<!-- JavaScript -->
  <script src="../js/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function (e) {
    $("#registerForm").on('submit',(function(e) {
        document.getElementById("btn").disabled = true;
        e.preventDefault();
        $.ajax({
            url: "../scripts/auth?action=registerUserAccount",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            {
            $("#registerResult").html(data);
            document.getElementById("btn").disabled = false;
            },
            error: function()
            {
            }           
       });
    }));
});

    //IMAGE PREVIEW
 function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_image');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}   

  </script>
    <script src="../assets/js/bundle.js?ver=2.4.0"></script>
    <script src="../assets/js/scripts.js?ver=2.4.0"></script>
   <script src="../js/vendors/sweetalert.js"></script>
    <script src="../assets/js/custom.js"></script>
   <script src="../js/toastr.js"></script>
</body>
</html>
<?php } else {i_redirect("index");} ?>