<?php 
include("functions.php");
if (isset($_POST)) {
	// code...
	sleep(3);
	$firstname = filterString($_POST['firstname']); $middlename = filterString($_POST['middlename']); 
	$lastname = filterString($_POST['lastname']); $phone = filterString($_POST['phone']);
	$email = filterString($_POST['email']);

	if(empty($firstname) || empty($lastname) || empty($middlename) || empty($email)){
		echo"
        <script>toastr.error('All fields are required', 'An Occured', {\"progressBar\": true});</script>
		";
	}
	else{

		$query = $conn->query("UPDATE users SET firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', phone = '$phone', email = '$email' WHERE id = 1");
		 echo "
           <script> Swal.fire('Details Updated', 'User account details have been successfully updated', 'success');
           </script>
           ";
      sleep(3);
     // echo"<script>window.history.go(-1);</script>";
      ?>
     <meta http-equiv="refresh" content="2; url=../admin/admin_profile">
      <?php
	}
}

?>