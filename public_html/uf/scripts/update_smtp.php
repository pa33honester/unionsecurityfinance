<?php
    require_once('functions.php');
    require ('../includes/PHPMailer.php');
    require ('../includes/SMTP.php');
    require ('../includes/Exception.php'); 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;  

if (isset($_POST)) {
	$host = filterString($_POST['host']); $username = filterString($_POST['username']); $password = filterString($_POST['password']);
	$auth = filterString($_POST['auth']); $port = filterString($_POST['port']); $name = filterString($_POST['name']);
    //TEXT SMTP
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->SMTPAuth = true;
    $mail->CharSet = "UTF-8";
    $mail->Username = $username; 
    $mail->Password = $password;
    $mail->SMTPSecure = $auth;
    $mail->Port = $port;
    $mail->setFrom($username , $display_name);
    $mail->addReplyTo($username , $display_name);
    $mail->addAddress($username );
    $mail->Subject = "SMTP Testing";
    $mail->isHTML(true);

    $mail->Body='Hi there';
    if(!$mail->Send()){
    echo "
      <script> Swal.fire('Error Occured', 'Unable to connect to SMTP server, Kindly reviewed your SMTP credentials', 'error');
           </script>
      ";
    print redirect ("4", "smtp");
    }else{
      $query = $conn->query("UPDATE smtp_setting SET host = '$host', password = '$password', username = '$username', port = '$port', smtp_auth = '$auth', display_name = '$name' WHERE id = 1");
      echo "
      <script> Swal.fire('Settings Updated', 'site  details have been updated', 'success');
           </script>
      ";  
      print redirect ("4", "smtp");
    }

}
?>