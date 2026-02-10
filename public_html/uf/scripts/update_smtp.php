<?php
    require_once('functions.php');
    require ('../includes/PHPMailer.php');
    require ('../includes/SMTP.php');
    require ('../includes/Exception.php'); 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;  

if (isset($_POST)) {
  $host = filterString($_POST['host']);
  $username = filterString($_POST['username']);
  // read raw password (do not run through filterString which escapes special chars like &)
  $password_raw = $_POST['password'] ?? '';
  $password = $password_raw; // used for PHPMailer
  $password_db = mysqli_real_escape_string($conn, $password_raw); // safe for DB storage
  $auth = filterString($_POST['auth']); $port = filterString($_POST['port']); $name = filterString($_POST['name']);
    //TEXT SMTP
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->SMTPAuth = true;
    $mail->CharSet = "UTF-8";
    $mail->Username = $username; 
    $mail->Password = $password;
    // choose appropriate encryption constant
    $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER; // enable server debug output (remove or set to 0 in production)
    $mail->SMTPSecure = (strtolower($auth) === 'ssl') ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = intval($port);
    // allow self-signed / relaxed TLS for debugging local environments
    $mail->SMTPOptions = [
      'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
      ],
    ];
    $mail->setFrom($username , $display_name);
    $mail->addReplyTo($username , $display_name);
    $mail->addAddress($username );
    $mail->Subject = "SMTP Testing";
    $mail->isHTML(true);

    $mail->Body='Hi there';
    if(!$mail->Send()){
      $err = $mail->ErrorInfo;
      @file_put_contents('/tmp/smtp_test.log', date('c') . " SMTP test failed: " . $err . "\nPOST:" . print_r($_POST, true) . "\n", FILE_APPEND);
      $err_html = htmlspecialchars($err, ENT_QUOTES);
      // show visible alert on page and trigger toastr (fallback to alert)
      echo "<div id='smtpError' class='alert alert-danger' style='margin:10px 0;'>SMTP test failed: " . $err_html . "</div>";
      $err_js = json_encode($err);
      echo "<script>
        if (typeof toastr !== 'undefined') {
          toastr.error('SMTP test failed: ' + $err_js, 'SMTP Error', {timeOut:0, extendedTimeOut:0, closeButton:true});
        } else {
          alert('SMTP test failed: ' + $err_js);
        }
        </script>";
      // do not redirect so user can inspect the page output
    } else {
      $query = $conn->query("UPDATE smtp_setting SET host = '$host', password = '$password_db', username = '$username', port = '$port', smtp_auth = '$auth', display_name = '$name' WHERE id = 1");
      echo "
      <script> Swal.fire('Settings Updated', 'site  details have been updated', 'success');
           </script>
      ";  
      // print redirect ("4", "smtp");
    }

}
?>