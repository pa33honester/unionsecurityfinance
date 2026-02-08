<?php
if (isset($_POST)) {
	include("functions.php");
	$id = $_GET['id'];
	$r= "reply$id";
	$t = "ticketid$id";
	$reply = filterString($_POST[$r]);
	$ticketid = filterString($_POST[$t]);
	if (empty($reply)) {
		echo"<script>document.getElementById('reply$id').style.background='red';</script>";
		die();
	}else {echo"<script>document.getElementById('reply$id').style.background='white';</script>";}
	
	$dated = date("d M Y, H:i a");
    $query = $conn->query("INSERT INTO reply (userid, ticketid, datecreated, message) VALUES (1, '$ticketid', '$dated', '$reply')");
    echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Your reply have been sent',
      showConfirmButton: false,
      timer: 1500
      });
    </script>";
    
       echo '<script>      
       $(document).ready(function(){
             setInterval(function(){
           $("#chatSection'.$id.'").load(window.location.href + " #chatSection'.$id.'" );
           }, 1000);
            });
          </script>';
   
}

 ?>