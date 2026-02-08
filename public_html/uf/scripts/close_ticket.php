<?php 
include("functions.php");

$id = $_GET['id'];
$ticket = "closeT$id";
$query = $conn->query("UPDATE support SET status = 'closed' WHERE id ='$id'");
 echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Ticket have been closed',
      showConfirmButton: false,
      timer: 1500
      });
    </script>";
?>
<meta http-equiv="refresh" content="3; url=support">