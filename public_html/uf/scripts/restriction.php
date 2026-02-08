<?php 
include("functions.php");
if(empty($_GET['id'])){
	header("location:index");
}

if($_GET['action'] == "suspend"){
$id = $_GET['id'];
$query = $conn->query("UPDATE users SET status = 'blocked' WHERE id = '$id'");
echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'User Suspended',
      showConfirmButton: false,
      timer: 1500
      });
       var delayInMilliseconds = 2000;
          setTimeout(function() {
          window.location.reload();
          }, delayInMilliseconds);
    </script>";
}

if($_GET['action'] == "unblock"){
$id = $_GET['id'];
$query = $conn->query("UPDATE users SET status = 'active' WHERE id = '$id'");
echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'User account Unblocked',
      showConfirmButton: false,
      timer: 1500
      });
       var delayInMilliseconds = 2000;
          setTimeout(function() {
          window.location.reload();
          }, delayInMilliseconds);
    </script>";
}
?>