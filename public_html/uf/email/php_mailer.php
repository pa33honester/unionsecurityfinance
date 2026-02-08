<?php
    require ('./includes/PHPMailer.php');
    require ('./includes/SMTP.php');
    require ('./includes/Exception.php');

          
    //defining name spacess
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    $mail = new PHPMailer();
    //$mail->isSMTP();
    $mail->Host = $smtp_host;
    $mail->SMTPAuth = true;
    $mail->CharSet = "UTF-8";
    $mail->Username = $smtp_username; 
    $mail->Password = $smtp_password;
    $mail->SMTPSecure = $smtp_auth;
    $mail->Port = $smtp_port;
    $mail->setFrom($smtp_username, $display_name);
    $mail->addReplyTo($smtp_username, $display_name);
