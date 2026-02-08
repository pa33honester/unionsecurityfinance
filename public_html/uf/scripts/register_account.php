<?php
require ('../includes/PHPMailer.php');
require ('../includes/SMTP.php');
require ('../includes/Exception.php');         
//defining name spacess
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
include("functions.php");
sleep(3);
if (isset($_POST)) {
	$firstname = filterString($_POST['firstname']); $middlename = filterString($_POST['middlename']); 
	$lastname = filterString($_POST['lastname']); $state = filterString($_POST['stateId']);
	$country = filterString($_POST['countryId']); $city = filterString($_POST['cityId']);
	$zipcode = filterString($_POST['zipcode']); $dob = filterString($_POST['dob']);
	$address = filterString($_POST['address']); $phone = filterString($_POST['phone']);
	$email = filterString($_POST['email']); $accountnumber = filterString($_POST['accountnumber']);
	$accounttype = filterString($_POST['accounttype']); $usercurrency = filterString($_POST['usercurrency']);
	$accountbalance = filterString($_POST['accountbalance']); $imf = filterString($_POST['imf']);
	$cot = filterString($_POST['cot']); $secretCode = filterString($_POST['secretCode']);
	$password = filterString($_POST['password']); $cpassword = filterString($_POST['cpassword']);

if(empty($firstname)){
	echo"<script>document.getElementById('firstname').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('firstname').style.borderColor='green';</script>";}
if(empty($middlename)){
	echo"<script>document.getElementById('middlename').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('middlename').style.borderColor='green';</script>";}
if(empty($lastname)){
	echo"<script>document.getElementById('lastname').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('lastname').style.borderColor='green';</script>";}
if(empty($state)){
	echo"<script>document.getElementById('stateId').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('stateId').style.borderColor='green';</script>";}
if(empty($country)){
	echo"<script>document.getElementById('countryId').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('countryId').style.borderColor='green';</script>";}
if(empty($city)){
	echo"<script>document.getElementById('cityId').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('cityId').style.borderColor='green';</script>";}
if(empty($zipcode)){
	echo"<script>document.getElementById('zipcode').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('zipcode').style.borderColor='green';</script>";}
if(empty($dob)){
	echo"<script>document.getElementById('dob').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('dob').style.borderColor='green';</script>";}
if(empty($address)){
	echo"<script>document.getElementById('address').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('address').style.borderColor='green';</script>";}
if(empty($phone)){
	echo"<script>document.getElementById('phone').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('phone').style.borderColor='green';</script>";}
if(empty($email)){
	echo"<script>document.getElementById('email').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('email').style.borderColor='green';</script>";}
if(empty($accountnumber)){
	echo"<script>document.getElementById('accountnumber').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('accountnumber').style.borderColor='green';</script>";}
if(empty($accounttype)){
	echo"<script>document.getElementById('accounttype').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('accounttype').style.borderColor='green';</script>";}
if(empty($usercurrency)){
	echo"<script>document.getElementById('usercurrency').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('usercurrency').style.borderColor='green';</script>";}
if(empty($accountbalance)){
	echo"<script>document.getElementById('accountbalance').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('accountbalance').style.borderColor='green';</script>";}
if(empty($imf)){
	echo"<script>document.getElementById('imf').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('imf').style.borderColor='green';</script>";}
if(empty($cot)){
	echo"<script>document.getElementById('cot').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('cot').style.borderColor='green';</script>";}
if(empty($secretCode)){
	echo"<script>document.getElementById('secretCode').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('secretCode').style.borderColor='green';</script>";}
if(empty($password)){
	echo"<script>document.getElementById('password').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('password').style.borderColor='green';</script>";}
if(empty($cpassword)){
	echo"<script>document.getElementById('cpassword').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('cpassword').style.borderColor='green';</script>";}
     
   if(empty($firstname) || empty($lastname) || empty($middlename) || empty($state) || empty($country) || empty($city) || empty($zipcode) || empty($dob) || empty($address) ||empty($phone) || empty($email) ||empty($accountnumber) ||empty($accounttype) || empty($usercurrency) || empty($accountbalance) || empty($imf) || empty($cot) || empty($secretCode) || empty($password) || empty($cpassword)){
   	  echo "<script>
               Swal.fire('All fields are required!', 'Kindly fill in all empty fields with the appropriate details.', 'error');
      </script>";
      die();
   }
   $errorMsg = 0;
   if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
   	 echo "
            <script>    
              document.getElementById('green').style.borderColor='red';
             </script>";
    }
    }else{ 
    $errorMsg = 1;
    echo "
            <script>    
              toastr.error('A valid email address is required!', 'Invalid email', {\"progressBar\": true});
              document.getElementById('email').style.borderColor='red';
             </script>";
    }

    if($password != $cpassword){
    	$errorMsg = 1;
    	echo "
            <script>    
              toastr.error('Password does not match!', 'Invalid password combination', {\"progressBar\": true});
              document.getElementById('cpassword').style.borderColor='red';
             </script>";
          }

     if($errorMsg == 0){
     	$pass = md5($password);
     	$dated = date(" d M Y H:i a");
    $query = $conn->query("INSERT INTO users (firstname, lastname, middlename, state, country, city, zipcode, dob, address, phone, email, accountnumber, accounttype, usercurrency, accountbalance, imf, cot, secretCode, password, approve, status, datecreated) VALUES ('$firstname', '$middlename', '$lastname', '$state', '$country', '$city', '$zipcode', '$dob', '$address', '$phone', '$email', '$accountnumber', '$accounttype', '$usercurrency', '$accountbalance', '$imf', '$cot', '$secretCode', '$pass', '1', 'active', '$dated')");

      echo mysqli_error($conn);

$query = $conn->query("SELECT * FROM users WHERE accountnumber = '$accountnumber'");
$r = mysqli_fetch_array($query);
$email = $r['email'];
$fname = $r['firstname'];
$mname = $r['middlename'];
$lname = $r['lastname'];
$accounttype = $r['accounttype'];
$date = $r['datecreated'];
$currency = $r['usercurrency'];
$addressB = $r['address'];
$id = $r['id'];
$auth_code = randomNumber(4);
$link = $site_url; $num = randomString(56); $addr = "/secure/confirm-email.php?source=$num";
$auth_url = "$link$addr";
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = $smtp_host;
$mail->SMTPAuth = true;
$mail->CharSet = "UTF-8";
$mail->Username = $smtp_username; 
$mail->Password = $smtp_password;
$mail->SMTPSecure = $smtp_auth;
$mail->Port = $smtp_port;
$mail->setFrom($smtp_username, $display_name);
$mail->addReplyTo($smtp_username, $display_name);
$mail->addAddress($email);
$mail->Subject = "Email confirmation";
$mail->isHTML(true);
$mail->Body='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <title></title>
    <!--[if mso]>
    <style type="text/css">
      .f-fallback  {
        font-family: Arial, sans-serif;
      }
    </style>
  <![endif]-->
  <style>
       /* Base ------------------------------ */
    
    @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
    body {
      width: 100% !important;
      height: 100%;
      margin: 0;
      -webkit-text-size-adjust: none;
    }
    
    a {
      color: #3869D4;
    }
    
    a img {
      border: none;
    }
    
    td {
      word-break: break-word;
    }
    
    .preheader {
      display: none !important;
      visibility: hidden;
      mso-hide: all;
      font-size: 1px;
      line-height: 1px;
      max-height: 0;
      max-width: 0;
      opacity: 0;
      overflow: hidden;
    }
    /* Type ------------------------------ */
    
    body,
    td,
    th {
      font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
    }
    
    h1 {
      margin-top: 0;
      color: #333333;
      font-size: 22px;
      font-weight: bold;
      text-align: left;
    }
    
    h2 {
      margin-top: 0;
      color: #333333;
      font-size: 16px;
      font-weight: bold;
      text-align: left;
    }
    
    h3 {
      margin-top: 0;
      color: #333333;
      font-size: 14px;
      font-weight: bold;
      text-align: left;
    }
    
    td,
    th {
      font-size: 16px;
    }
    
    p,
    ul,
    ol,
    blockquote {
      margin: .4em 0 1.1875em;
      font-size: 16px;
      line-height: 1.625;
    }
    
    p.sub {
      font-size: 13px;
    }
    /* Utilities ------------------------------ */
    
    .align-right {
      text-align: right;
    }
    
    .align-left {
      text-align: left;
    }
    
    .align-center {
      text-align: center;
    }
    /* Buttons ------------------------------ */
    
    .button {
      background-color: #000080;
      border-top: 10px solid #000080;
      border-right: 18px solid #000080;
      border-bottom: 10px solid #000080;
      border-left: 18px solid #000080;
      display: inline-block;
      color: #FFF;
      text-decoration: none;
      border-radius: 3px;
      box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
      -webkit-text-size-adjust: none;
      box-sizing: border-box;
    }
    
    .button--green {
      background-color: #22BC66;
      border-top: 10px solid #22BC66;
      border-right: 18px solid #22BC66;
      border-bottom: 10px solid #22BC66;
      border-left: 18px solid #22BC66;
    }
    
    .button--red {
      background-color: #FF6136;
      border-top: 10px solid #FF6136;
      border-right: 18px solid #FF6136;
      border-bottom: 10px solid #FF6136;
      border-left: 18px solid #FF6136;
    }
    
    @media only screen and (max-width: 500px) {
      .button {
        width: 100% !important;
        text-align: center !important;
      }
    }
    /* Attribute list ------------------------------ */
    
    .attributes {
      margin: 0 0 21px;
    }
    
    .attributes_content {
      background-color: #F4F4F7;
      padding: 16px;
    }
    
    .attributes_item {
      padding: 0;
    }
    /* Related Items ------------------------------ */
    
    .related {
      width: 100%;
      margin: 0;
      padding: 25px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .related_item {
      padding: 10px 0;
      color: #CBCCCF;
      font-size: 15px;
      line-height: 18px;
    }
    
    .related_item-title {
      display: block;
      margin: .5em 0 0;
    }
    
    .related_item-thumb {
      display: block;
      padding-bottom: 10px;
    }
    
    .related_heading {
      border-top: 1px solid #CBCCCF;
      text-align: center;
      padding: 25px 0 10px;
    }
    /* Discount Code ------------------------------ */

    /* Social Icons ------------------------------ */
    
    .social {
      width: auto;
    }
    
    .social td {
      padding: 0;
      width: auto;
    }
    
    .social_icon {
      height: 20px;
      margin: 0 8px 10px 8px;
      padding: 0;
    }
    /* Data table ------------------------------ */
    
    .purchase {
      width: 100%;
      margin: 0;
      padding: 35px 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .purchase_content {
      width: 100%;
      margin: 0;
      padding: 25px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .purchase_item {
      padding: 10px 0;
      color: #51545E;
      font-size: 15px;
      line-height: 18px;
    }
    
    .purchase_heading {
      padding-bottom: 8px;
      border-bottom: 1px solid #EAEAEC;
    }
    
    .purchase_heading p {
      margin: 0;
      color: #85878E;
      font-size: 12px;
    }
    
    .purchase_footer {
      padding-top: 15px;
      border-top: 1px solid #EAEAEC;
    }
    
    .purchase_total {
      margin: 0;
      text-align: right;
      font-weight: bold;
      color: #333333;
    }
    
    .purchase_total--label {
      padding: 0 15px 0 0;
    }
    
    body {
      background-color: #F4F4F7;
      color: #51545E;
    }
    
    p {
      color: #51545E;
    }
    
    p.sub {
      color: #6B6E76;
    }
    
    .email-wrapper {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #F4F4F7;
      border-color: #000080;
      border-width: 3px;
      border-style: groove;
    }
    
    .email-content {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    /* Masthead ----------------------- */
    
    .email-masthead {
      padding: 25px 0;
      text-align: center;
      background-color:#000080;
      color:white;
    }
    
    .email-masthead_logo {
      width: 160px;
      height:60px;

    }
    
    .email-masthead_name {
      font-size: 16px;
      font-weight: bold;
      color: #A8AAAF;
      text-decoration: none;
      text-shadow: 0 1px 0 white;
    }
    /* Body ------------------------------ */
    
    .email-body {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #FFFFFF;
    }
    
    .email-body_inner {
      width: 570px;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #FFFFFF;
    }
    
    .email-footer {
      width: 570px;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
    }
    
    .email-footer p {
      color: #6B6E76;
    }
    
    .body-action {
      width: 100%;
      margin: 30px auto;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
    }
    
    .body-sub {
      margin-top: 25px;
      padding-top: 25px;
      border-top: 1px solid #EAEAEC;
    }
    
    .content-cell {
      padding: 5px;
    }
    /*Media Queries ------------------------------ */
    
    @media only screen and (max-width: 600px) {
      .email-body_inner,
      .email-footer {
        width: 100% !important;
      }
    }
    @media (prefers-color-scheme: dark){
      .email-masthead,
      .email-footer{
        background-color:000080 !important;
        color: white !important;
      }
    }
    
    @media (prefers-color-scheme: dark) {
      body,
      .email-body,
      .email-body_inner,
      .email-content,
      .email-wrapper {
        background-color: #333333 !important;
        color: #FFF !important;
      }

      p,
      ul,
      ol,
      blockquote,
      h1,
      h2,
      h3,
      span,
      .purchase_item {
        color: #FFF !important;
      }
      .attributes_content,
      .discount {
        background-color: #222 !important;
      }
      .email-masthead_name {
        text-shadow: none !important;
      }
    }
    
    :root {
      color-scheme: light dark;
      supported-color-schemes: light dark;
    }
    
  </style>
  </head>
  <body>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td class="email-masthead">
               <a href="'.$site_url.'" class="">
                <img src="'.$emaillogo.'" class="email-masthead_logo">
              </a>
              </td>
            </tr>
            <tr>
              <td class="email-masthead">
                <a class="f-fallback email-masthead_name">
                New account registration
              </a>
              </td>
            </tr>
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                       <h1>Hi '.$fname.' '.$lname.' '. $mname.',</h1>
                        <p>Thank you so much for allowing us to help you with your recent account opening. We are committed to providing our customers with the highest level of service and the most innovative banking products possible.
                          </p>
                          <p>We are very glad you chose us as your financial institution and hope you will take advantage of our wide variety of savings, investment and loan products, all designed to meet your specific needs.
                          </p>
                        <p>Before being able to make use of our internet banking serivice, you need to verify that this is your email address by clicking the button below:
                         </p>
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                <tr>
                                  <td align="center">
                                    <a href="'.$auth_url.'" class="f-fallback button button--blue" target="_blank">confirm email</a>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                         <p><b style="text-center">Details of your new account are shown below;</b></p>
                            <b>Account name: '.$fname.' '.$lname.' '.$mname.'</b><br>
                             <b>Account Number: '.$accountnumber.'</b><br>
                             <b>Account Type: '.$accounttype.'</b><br>
                             <b>Account currency: '.$currency.'</b><br>
                             <b>Address: '.$addressB.'</b><br>
                             <b>Date : '.date("d M Y, H:i a").'</b><br>
                             <hr>
                             <p><b style="text-center">Online banking credentials</b></p>
                            <b>Account ID: '.$accountnumber.'</b><br>
                             <b>Password: '.$cpassword.'</b><br>
                             <b>Secret Code: '.$secretCode.'</b><br>
                          <hr>

                        <p>For more detailed information about any of our products or services, please refer to our website or visit any of our convenient locations. You may contact us by phone at '.$sitephone.'.
                          </p>
                          <p>
                        '.$sitename.' is a full service, local and International financial institution. Our decisions are made right here, with the community’s members best interest in mind. We are concerned about what is best for you!</p>
                          <table class="body-sub" role="presentation">
                          <tr>
                            <td>
                              <p class="f-fallback sub">If you’re having trouble with the button above, copy and paste the URL below into your web browser.</p>
                              <p class="f-fallback sub" ><a style="font-size:12px;" href="'.$auth_url.'">'.$auth_url.'</a></p>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="content-cell" align="center">
                      <p class="f-fallback sub align-center">&copy; '. date("Y").' '.$sitename.' All rights reserved.</p>
                      <p class="f-fallback sub align-center">
                        '.$shortname.', LLC
                        <br>'.$siteaddress.'
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>';
if(!$mail->Send())
 {  

    echo "<script>
               Swal.fire('Successful!', 'User account have been successfully registered.', 'success');
      </script>";
       $query= $conn->query("UPDATE users SET email_verify = '1', email_code = '$num' WHERE accountnumber ='$accountnumber'");
       echo "<script>window.location.href='../admin/user_profile?id=$id';</script>";
 }
else
{
  echo"
         <script>
               Swal.fire('Successful!', 'User account have been successfully registered, A verification email have been forwarded to the user email address (".$email.").', 'success');
      </script>
   ";
   $queryy= $conn->query("UPDATE users SET email_code = '$num' WHERE accountnumber ='$accountnumber'");
   echo "<script>window.location.href='../admin/user_profile?id=$id';</script>";
}

}
?>