<?php 
include("functions.php");
if (isset($_POST)) {
	sleep(2);
	// code...
	$password = filterString($_POST['password']);
	$cpassword = filterString($_POST['cpassword']);
	$id = filterString($_POST['id']);

	if(empty($password)){
		echo"<script>document.getElementById('password').style.borderColor='red';</script>";
	}else{echo"<script>document.getElementById('password').style.borderColor='green';</script>";}
	if(empty($cpassword)){
		echo"<script>document.getElementById('cpassword').style.borderColor='red';</script>";
	}else{echo"<script>document.getElementById('cpassword').style.borderColor='green';</script>";}

	if(empty($password) || empty($cpassword)){
		echo "<script>toastr.error('All fields are required', 'An Occured', {\"progressBar\": true});</script>";
		die();
	}

	if($password == $cpassword){
		$pass = md5($password);
		$query = $conn->query("UPDATE users SET password = '$pass' WHERE id = '$id'");
		 echo "
           <script> Swal.fire('password have been updated!', 'User password have been successfully updated', 'success');
           </script>
           ";
      sleep(3);
      echo"<script>window.history.go(-1);</script>";
	}
	else{

		echo "<script>toastr.error('Invalid password combination', 'An Occured', {\"progressBar\": true});
             document.getElementById('cpassword').style.borderColor='red'; 
		</script>";
		
	}

}
?>