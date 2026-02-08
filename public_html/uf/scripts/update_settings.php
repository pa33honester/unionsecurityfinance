<?php
include("functions.php"); 
if (isset($_POST)) {
	$sitename = filterString($_POST['sitename']); $shortname = filterString($_POST['shortname']); $email = filterString($_POST['email']);
	$phone = filterString($_POST['phone']); $address = filterString($_POST['address']); $description = filterString($_POST['description']); $cot = filterString($_POST['cot']); $imf = filterString($_POST['imf']);
	    $imf_cot_counter = filterString($_POST['counter']); 
	    $imf_error = filterString($_POST['imf_error']);
	    $cot_error = filterString($_POST['cot_error']);
	    $blocked_msg = filterString($_POST['blocked_msg']);
	    $enable_cot_imf = filterString($_POST['enable_cot_imf']);
	    $rest_msg = filterString($_POST['rest_msg']); $enable_tin_ic_tac = filterString($_POST['enable_tin_ic_tac']); 
		$enable_ic = filterString($_POST['enable_ic']); $enable_tin = filterString($_POST['enable_tin']);
		$tinmsg = filterString($_POST['tinmsg']); $tacmsg = filterString($_POST['tacmsg']);
		$icmsg = filterString($_POST['icmsg']); $tin = filterString($_POST['tin']);
		$tac = filterString($_POST['tac']); $ic = filterString($_POST['ic']); $bots = filterString($_POST['bots']); $crypto = filterString($_POST['crypto']);
	$country = filterString($_POST['country']);
	$site_url = filterString($_POST['site_url']);
	$kyc = filterString($_POST['kyc']);
	$visual_card = filterString($_POST['visual_card']);

	if (filter_var($site_url, FILTER_VALIDATE_URL)) {
    } else {
    feedback("sweet", "error", "Invalid base URL", "Error");
    borderError("red", "site_url");
    die();
     }

	 $query = $conn->query("UPDATE setting SET name = '$sitename', shortname = '$shortname', email = '$email', phone = '$phone', description = '$description', address = '$address', imfmsg = '$imf', cotmsg = '$cot', cot_imf_counter = '$imf_cot_counter',
	 cot_error = '$cot_error', imf_error = '$imf_error', blocked_msg = '$blocked_msg',
	 enable_tin_ic_tac = '$enable_tin_ic_tac', enable_ic = '$enable_ic', enable_tin = '$enable_tin',
	 tinmsg = '$tinmsg', tacmsg = '$tacmsg', icmsg = '$icmsg', userstac = '$tac', usersic = '$ic', userstin = '$tin',
	  enable_cot_imf = '$enable_cot_imf', rest_msg = '$rest_msg', crypto = '$crypto', bots = '$bots', country = '$country', site_url ='$site_url' , kyc = '$kyc', visual_card ='$visual_card'  WHERE id = 1");

	  if($enable_tin_ic_tac == "Yes"){
		$query2 = $conn->query("UPDATE setting SET enable_cot_imf = 'NO' WHERE id = 1"); 
	  }
echo "
	  <script> Swal.fire('Settings Updated', 'site  details have been updated', 'success');
           </script>
      ";
      sleep(3);
     ?>
 <meta http-equiv="refresh" content="2; url=../admin/Settings">
     <?php
}
?>
