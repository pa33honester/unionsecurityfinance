<?php 
if (isset($_POST)) {
	sleep(3);
	include("functions.php");
	include("userdata.php");
	$department = filterString($_POST['department']);
	$message = filterString($_POST['message']);
if(empty($department)){
	echo"<script>document.getElementById('department').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('department').style.borderColor='green';</script>";}
if(empty($message)){
	echo"<script>document.getElementById('message').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('message').style.borderColor='green';</script>";}

if (empty($message) || empty($department)) {
	   echo "<script>    
              toastr.error('All fields are required!', 'Empty field', {\"progressBar\": true});
             </script>";
          die();
}
if (strlen($message) <= 6) {
	   echo "<script>    
              toastr.error('Your message or complaint must be concise!', 'An error occured', {\"progressBar\": true});
              document.getElementById('message').style.borderColor='red';
             </script>";
          die();
}else{ echo"<script> document.getElementById('message').style.borderColor='green';</script> ";}
	
}
$ticket = "".strtoupper(randomString(7)."/".randomNumber(4)."/".date("m-Y"))."";
$dated = date("d M Y H:i a");
$query = $conn->query("INSERT INTO support (department, message, ticketid, userid, datecreated) VALUES ('$department', '$message', '$ticket', '$userid', '$dated')");
     echo "
           <script> Swal.fire('Support ticket have been created!', 'We would like to let you know that sending us multiple replies in this ticket does not speed up its processing,  We process tickets in chronological order, and sending new updates only move your ticket to the end of the queue.', 'success');
           </script>
       ";
      sleep(3);
      echo"<script>window.location.reload();</script>";
 
?>