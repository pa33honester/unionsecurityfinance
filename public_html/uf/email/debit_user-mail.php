   <?php
    include("../scripts/functions.php");
    require ('../includes/PHPMailer.php');
    require ('../includes/SMTP.php');
    require ('../includes/Exception.php');       
    //defining name spacess
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    $j = $_SESSION['debitUserDetails'];
    if($j[0] == ""){
    	echo"<script>window.location.href='../admin/debit_user'</script>";
    }
    $id = $j[0]; $amount = $j[1]; $memo = $j[2]; $frequency= $j[3]; $scope= $j[4]; $emailNotify= $j[5]; $firstname= $j[6]; $lastname= $j[7]; $middlename= $j[8]; $email= $j[9]; $accountnumber= $j[10]; $accountbalance = $j[11];   
    for ($i=0; $i < $frequency; $i++) { 
		       $query = $conn->query("SELECT * FROM users WHERE id = '$id'");
            $row = mysqli_fetch_array($query);
            $accountbalance = $row['accountbalance']; 
            $phone = $row['phone'];
		        $transferToken = randomString(64);
            $ref = randomString(9);
            $dd = date("my");
            $dc = substr($sitename, 0, 3);
            $refNumber = strtoupper("$dc/$ref-$dd");
            $otp = randomNumber(6);
            $dated = date("d M Y, g:i a");
            $acctBal = $accountbalance - ($amount);
            $queryForTransfer = $conn->query("INSERT INTO transactions (scope, type, otp, refNumber, dated, amount, accountbalance, userid, description, token) VALUES ('$scope', 'Debit', '$otp', '$refNumber', '$dated', '$amount', '$acctBal', '$id', '$memo', '$transferToken')");
                $queryForBalUpdate = $conn->query("UPDATE users SET accountbalance = '$acctBal' WHERE id = '$id'");

     if ($emailNotify == "Yes") {
     $fullname = "$firstname $middlename $lastname";	
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
    $mail->Subject = "Debit alert Notification[$money $amount]";
    $mail->isHTML(true);
    $mail->Body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    .tablehead{
        padding: 5px;
        background-color:gray;
        text-align:left;
    }
    .tablecontent{
        padding:5px;
        text-align:left;
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
                Debit alert notification
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
                      <h2>Dear '.$fullname.',</h2>
                        <p>Your account have been Debited.</p>
                        <!-- Action -->
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                <tr>
                                  <td align="center">
                                   <center>
                                   <h2 style=" text-align:center;"> With</h2>
                                   <h1 style=" text-align:center;"> '.$money.' '.$amount.'</h1>
                                   </center>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <p><b>Details of the transaction are shown below;</b></p>
                             <b>Account Number: '.$accountnumber.'</b><br>
                            <b>Account Name: '.$fullname.'</b><br>
                             <b>Description: '.$memo.'</b><br>
                             <b>Total Amount: '.$money.' '.$amount.'</b><br>
                             <b>Date: '.date("d M Y, H:i a").'</b><br>
                             <b>Available Balance: '.$money.' '.$acctBal.'</b><br>
                        <!-- Sub copy -->
                        <table class="body-sub" role="presentation">
                          <tr>
                            <td>
                              <p class="f-fallback sub">DISCLAIMER: this message was automatically generated via '.$shortname.'  secured online channel, please do not reply this message. all
                                  correspondent should be address to customer Services.</p>
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
         $recipient = str_replace("+", "", $phone);
         $recipient = str_replace(" ", "", $phone);
         $dex = $_SESSION['description'];
         $dated = date("d/m/Y, H:ia");
         $msg = "Debit alert\nAcct: ".substr($accountnumber, 0,3)."****".substr($accountnumber, 7,10)."\nAmt: $money ".number_format($amount)." DR\nDesc: $dex\nAcct Balance: $money ".number_format($acctBal)."\nTotal: $money ".number_format($acctBal)."\nDate: $dated";
         $sendSms = alertNotification($sms, $api, $sender_id, $msg, $recipient);
    if(!$mail->Send() && $sendSms == 0)
    {
    unset($_SESSION['debitUserDetails']);
    echo "<script>window.location.href='../admin/user_profile?id=$id';</script>";
    }
    else
    {
    	unset($_SESSION['debitUserDetails']);
     echo "<script>window.location.href='../admin/user_profile?id=$id';</script>";   	
    }  
   }
     else{
     	unset($_SESSION['debitUserDetails']);
        echo "<script>window.location.href='../admin/user_profile?id=$id';</script>";
      } 
   
}
?>