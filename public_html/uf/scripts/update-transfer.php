<?php 

if(isset($_POST)){
  include("functions.php");
	sleep(1);
	$refNumber = filterString($_POST['refNumber']); $amount = filterString($_POST['amount']);
	$dated = filterString($_POST['dated']); $description = filterString($_POST['description']);
	$scope = filterString($_POST['scope']); $type = filterString($_POST['type']);
	$status = filterString($_POST['status']);
    if(empty($refNumber)){
    	echo"<script>
          document.getElementById('refNumber').style.borderColor='red';
    	</script>";
    }else{echo"<script>
          document.getElementById('refNumber').style.borderColor='green';
    	</script>";}
    	    if(empty($amount)){
    	echo"<script>
          document.getElementById('amount').style.borderColor='red';
    	</script>";
    }else{echo"<script>
          document.getElementById('amount').style.borderColor='green';
    	</script>";}
    	    if(empty($dated)){
    	echo"<script>
          document.getElementById('dated').style.borderColor='red';
    	</script>";
    }else{echo"<script>
          document.getElementById('dated').style.borderColor='green';
    	</script>";}
    	    if(empty($description)){
    	echo"<script>
          document.getElementById('description').style.borderColor='red';
    	</script>";
    }else{echo"<script>
          document.getElementById('description').style.borderColor='green';
    	</script>";}
    	    if(empty($scope)){
    	echo"<script>
          document.getElementById('scope').style.borderColor='red';
    	</script>";
    }else{echo"<script>
          document.getElementById('scope').style.borderColor='green';
    	</script>";}
        if(($status)){
      echo"<script>
          document.getElementById('status').style.borderColor='red';
      </script>";
    }else{echo"<script>
          document.getElementById('status').style.borderColor='green';
      </script>";}
    	    if(empty($type)){
    	echo"<script>
          document.getElementById('type').style.borderColor='red';
    	</script>";
    }else{echo"<script>
          document.getElementById('type').style.borderColor='green';
    	</script>";}
    if (empty($refNumber) || empty($amount) || empty($dated) || empty($description) || empty($type) || empty($scope)) {
    	 echo "<script>    
              toastr.error('All fields are required!', 'Empty field', {\"progressBar\": true});
             </script>";
             die();
    }

    else{
      $query=$conn->query("UPDATE transactions SET scope = '$scope', type = '$type', dated = '$dated', status = '$status', amount = '$amount', description = '$description' WHERE refNumber = '$refNumber'");
      echo "
           <script> Swal.fire('Details Updated!', 'Transaction details have been updated', 'success');
          var delayInMilliseconds = 2000;
          setTimeout(function() {
          window.location.reload();
          }, delayInMilliseconds);
           </script>
          
      ";

    	

    }
}

?>