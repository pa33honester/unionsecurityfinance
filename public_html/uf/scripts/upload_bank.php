<?php 
include("functions.php");

if (isset($_POST)) {
	sleep(2);
	// code...
	$accountnumber = filterString($_POST['accountnumber']);
	$bankname = filterString($_POST['bankname']);
	$accountname = filterString($_POST['accountname']);
	$bankbranch = filterString($_POST['bankbranch']);
	$accounttype = filterString($_POST['accounttype']);
	if (empty($accountnumber) || empty($bankname) || empty($bankbranch) || empty($accountname) || empty($accounttype)) {
		// code...
		echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'error',
      title: 'All fields are required',
      showConfirmButton: false,
      timer: 1500
      });
    </script>";
    die();
	}
	else {
		$query = $conn->query("INSERT INTO getbank (accountnumber, bankname, accountname, bankbranch, accounttype) VALUES ('$accountnumber', '$bankname', '$accountname', '$bankbranch', '$accounttype')");
				echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Account Details added',
      showConfirmButton: false,
      timer: 1500
      });
    </script>";
    ?>
   <meta http-equiv="refresh" content="2; url='miscellaneous#details">
    <?php
	}
}


?>