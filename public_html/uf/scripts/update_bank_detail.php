<?php
include("functions.php");
if (isset($_POST)) {
sleep(3);
$id = $_GET['id'];
$accounttype = filterString($_POST['accounttype']);
$accountnumber = filterString($_POST['accountnumber']);
$usercurrency = filterString($_POST['usercurrency']);
$cot = filterString($_POST['cot']);
$imf = filterString($_POST['imf']);
$secretCode = filterString($_POST['secretCode']);
if(empty($accounttype)){
	echo"<script>document.getElementById('accounttype').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('accounttype').style.borderColor='green';</script>";}
if(empty($accountnumber)){
	echo"<script>document.getElementById('accountnumber').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('accountnumber').style.borderColor='green';</script>";}
if(empty($usercurrency)){
	echo"<script>document.getElementById('usercurrency').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('usercurrency').style.borderColor='green';</script>";}
if(empty($cot)){
	echo"<script>document.getElementById('cot').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('cot').style.borderColor='green';</script>";}
if(empty($imf)){
	echo"<script>document.getElementById('imf').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('imf').style.borderColor='green';</script>";}
if(empty($secretCode)){
	echo"<script>document.getElementById('secretCode').style.borderColor='red';</script>";
}else{echo"<script>document.getElementById('secretCode').style.borderColor='green';</script>";}
if (empty($accountnumber) || empty($cot) || empty($imf)) {
	   echo "<script>    
              toastr.error('All fields are required!', 'Empty field', {\"progressBar\": true});
             </script>";
             die();
}
 else{
 	$query = $conn->query("UPDATE users SET accounttype = '$accounttype', accountnumber = '$accountnumber', usercurrency = '$usercurrency', cot = '$cot', imf = '$imf', secretCode = '$secretCode' WHERE id = '$id' ");
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