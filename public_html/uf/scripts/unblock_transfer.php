<?php 
include("functions.php");
if(empty($_GET['id'])){
	header("location:index");
}

$id = $_GET['id'];
$query=$conn->query("UPDATE users SET allowtransfer = 1 WHERE id = '$id'");
$query2=$conn->query("UPDATE users SET blocktransfer = 1 WHERE id = '$id'");
echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Funds Transfer Unblocked',
      showConfirmButton: false,
      timer: 1500
      });
       var delayInMilliseconds = 2000;
          setTimeout(function() {
          window.location.reload();
          }, delayInMilliseconds);
    </script>";

?>