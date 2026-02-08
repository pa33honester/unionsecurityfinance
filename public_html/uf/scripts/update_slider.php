<?php 
include("functions.php");
  if(isset($_POST)){
 $heading = filterString($_POST['heading']); $text = filterString($_POST['text']); $link = filterString($_POST['link']);
 $content = filterString($_POST['content']);
 $id = filterString($_POST['id']);
 if(empty($heading) || empty($text) || empty($link) || empty($content)){
 sleep(2);	
 echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'error',
      title: 'All fields are required',
      showConfirmButton: false,
      timer: 1500
      });
    </script>";	
    
 } else {
 	$query = $conn->query("UPDATE sliders SET heading = '$heading', `text` = '$text', link = '$link', content = '$content'  WHERE id = '$id' ");
 	echo mysqli_error($conn);
 }
if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['picture']['tmp_name'])) {
$sourcePath = $_FILES['picture']['tmp_name'];
$targetPath = "../images/".$_FILES['picture']['name'];
$imageFileType = strtolower(pathinfo($targetPath,PATHINFO_EXTENSION));
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ){
	  echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'error',
      title: 'Valid Image is required',
      showConfirmButton: false,
      timer: 1500
      });
      </script>";		
      die();
}
if(move_uploaded_file($sourcePath,$targetPath)) {
 $pic =  "images/".htmlspecialchars( basename( $_FILES["picture"]["name"]))."";
  $query = $conn->query("UPDATE sliders SET picture = '$pic' WHERE id = '$id' ");
   echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Slider has been updated',
      showConfirmButton: false,
      timer: 1500
      });
    </script>";	
     ?>
    <meta http-equiv="refresh" content="3; url='edit_slider?id=<?php echo$id ?>'">
    <?php
}
}
else{
   echo "<script>
      Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Slider has been updated',
      showConfirmButton: false,
      timer: 1500
      });
    </script>";	
    ?>
    <meta http-equiv="refresh" content="3; url='edit_slider?id=<?php echo$id ?>'">
    <?php
}
}

}

?>