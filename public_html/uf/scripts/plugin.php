<?php 
include("functions.php");
if (isset($_POST)) {
	sleep(2);
	$rate = filterString($_POST['stockrate']);
	$tawk = filterString($_POST['tawk']);

	$query = $conn->query("UPDATE setting SET tawk = '$tawk', stock = '$rate' WHERE id = 1");

	 echo "
           <script> Swal.fire('Updated', 'Plugin preference have been updated', 'success');
           </script>
      ";
      ?>
    <meta  http-equiv="refresh" content="3; url=plugins">
      <?php

}

?>