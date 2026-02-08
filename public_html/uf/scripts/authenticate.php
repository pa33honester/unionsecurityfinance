<?php
include("functions.php");
if (isset($_POST)) {
	 $code = $_POST["code"];
	 if (empty($code)) {
	 	sleep(2);
					echo "
             <script>
              toastr.danger('Please enter your authentication code', 'Field can't be empty', {\"progressBar\": true});
              document.getElementById('code').style.borderColor='red';
             </script>
					";
	 		 }
	     else{
	 	   sleep(2);
					echo "
             <script>
              toastr.warning('Invalid Code Supplied.', 'Incorrect code', {\"progressBar\": true});
              document.getElementById('code').style.borderColor='red';
             </script>
					";
	 }		 
	}


?>