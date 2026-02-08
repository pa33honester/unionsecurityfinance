<?php

include("functions.php");
if (isset($_POST)) {
	sleep(3);

$id = $_GET['id'];
$firstname = filterString($_POST['firstname']);
$middlename = filterString($_POST['middlename']);
$lastname = filterString($_POST['lastname']);
$phone = filterString($_POST['phone']);
$email = filterString($_POST['email']);
$dob = filterString($_POST['dob']);
$address = filterString($_POST['addressB']);
if(empty($firstname)){
	echo"<script>document.getElementById('firstname').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('firstname').style.borderColor='green';</script>";}
if(empty($middlename)){
	echo"<script>document.getElementById('middlename').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('middlename').style.borderColor='green';</script>";}
if(empty($lastname)){
	echo"<script>document.getElementById('lastname').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('lastname').style.borderColor='green';</script>";}
if(empty($phone)){
	echo"<script>document.getElementById('phone').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('phone').style.borderColor='green';</script>";}
if(empty($email)){
	echo"<script>document.getElementById('email').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('email').style.borderColor='green';</script>";}
if(empty($dob)){
	echo"<script>document.getElementById('dob').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('dob').style.borderColor='green';</script>";}
if(empty($address)){
	echo"<script>document.getElementById('addressB').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('addressB').style.borderColor='green';</script>";}
if (empty($firstname) || empty($email) || empty($phone) || empty($address) || empty($dob)) {
	   echo "<script>    
              toastr.error('All fields are required!', 'Empty field', {\"progressBar\": true});
             </script>";
             die();
}
 else{
 	$query = $conn->query("UPDATE users SET firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', phone = '$phone', dob = '$dob', email = '$email', address = '$address' WHERE id = '$id' ");
 	echo mysqli_error($conn);
 	echo"
    <script>toastr.success('User details have been updated', 'Successful', {\"progressBar\": true});
    </script>
 	";
 	?>
     <meta http-equiv="refresh" content="2; url=../admin/user_profile?id=<?php echo $id ?>">
 	<?php
 }
}
 ?>