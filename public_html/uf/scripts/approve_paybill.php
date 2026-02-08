<?php 
include("functions.php");

if (isset($_POST)) {
	sleep(2);
	$refNumber = filterString($_POST['refNumber']);
	$query = $conn->query("UPDATE transactions SET status = 1 WHERE refNumber = '$refNumber'");
	$query = $conn->query("UPDATE paybill SET status = 'completed' WHERE ref = '$refNumber'");
	 echo "
           <script> Swal.fire('Bill Payment approved!', 'Transaction details have been updated', 'success');
           </script>
      ";
      sleep(3);
      echo"<script>window.history.go(-1);</script>";
}

?>