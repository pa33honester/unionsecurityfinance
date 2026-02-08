<?php 
include("functions.php");
if(empty($_GET['id'])){
	header("location:index");
}

$id = $_GET['id'];
$query=$conn->query("UPDATE users SET allowtransfer = 0 WHERE id = '$id'");
echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Funds Transfer Suspended',
      showConfirmButton: false,
      timer: 1500
      });
       var delayInMilliseconds = 2000;
          setTimeout(function() {
          window.location.reload();
          }, delayInMilliseconds);
    </script>";

?>