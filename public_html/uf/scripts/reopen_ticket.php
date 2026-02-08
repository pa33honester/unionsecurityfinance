<?php 
include("functions.php");
$id = $_GET['id'];
$query = $conn->query("UPDATE support SET status = 'active' WHERE id ='$id'");
 echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Ticket have been Reopened',
      showConfirmButton: false,
      timer: 1500
      });
    </script>";
?>
<meta http-equiv="refresh" content="3; url=support">