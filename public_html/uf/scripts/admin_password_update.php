<?php 
include("functions.php");
if (isset($_POST)) {
	sleep(2);
	// code...
	$fpassword = filterString($_POST['password']);
	$cpassword = filterString($_POST['cpassword']);
	$pass = filterString($_POST['pass']);

	if(empty($fpassword)){
		echo"<script>document.getElementById('password').style.borderColor='red';</script>";
	}else{echo"<script>document.getElementById('password').style.borderColor='green';</script>";}
	if(empty($cpassword)){
		echo"<script>document.getElementById('cpassword').style.borderColor='red';</script>";
	}else{echo"<script>document.getElementById('cpassword').style.borderColor='green';</script>";}
	if(empty($pass)){
		echo"<script>document.getElementById('pass').style.borderColor='red';</script>";
	}else{echo"<script>document.getElementById('pass').style.borderColor='green';</script>";}


	if(empty($fpassword) || empty($cpassword) || empty($pass)){
		echo "<script>toastr.error('All fields are required', 'An Occured', {\"progressBar\": true});</script>";
		die();
	}
	$query = $conn->query("SELECT * FROM users WHERE id = 1");
	$r = mysqli_fetch_array($query);

	if(md5($pass) != $r['password']){
	echo "<script>toastr.error('Incorrect old password', 'An Occured', {\"progressBar\": true});
     document.getElementById('pass').style.borderColor='red';
	</script>";
    die();
	}

	if($fpassword == $cpassword){
		$passa = md5($cpassword);
		$query = $conn->query("UPDATE users SET password = '$passa' WHERE id = 1");
		 echo "
           <script> Swal.fire('password have been updated!', 'User password have been successfully updated', 'success');
           </script>
           ";
      sleep(3);
     echo"<script>window.location.href='logout';</script>";
	}
	else{

		echo "<script>toastr.error('Invalid password combination', 'An Occured', {\"progressBar\": true});
             document.getElementById('cpassword').style.borderColor='red'; 
		</script>";
		
	}

}
?>