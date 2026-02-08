<?php
include ('functions.php');
if (isset($_POST)) {
	include("userdata.php");
	$secretCode = $_POST["secretCode"];
	 $userid = $_SESSION['loggedUser'];
	 if (empty($secretCode)) {
	        sleep(2);
		echo "
             <script>
              toastr.error('Secret Code is required ', 'Empty field', {\"progressBar\": true});
              document.getElementById('secretCode').style.borderColor='red';
             </script>
            ";
		 
			}

			else{
				include("connect.php");
				$query = $conn->query("SELECT * FROM users WHERE accountnumber = '$userid'");
				$fetch = mysqli_fetch_assoc($query);
				if ($secretCode != $fetch["secretCode"]) {
					sleep(2);
					echo "
             <script>
              toastr.warning('Invalid Code Supplied', 'Incorrect code', {\"progressBar\": true});
              document.getElementById('secretCode').style.borderColor='red';
             </script>
					";
				}

				if ($secretCode == $fetch["secretCode"]) {
					sleep(2);
					echo "
             <script>
              toastr.success('Login successful', 'Welcome $firstname $lastname $middlename', {\"progressBar\": true});
              document.getElementById('secretCode').style.borderColor='green';
             </script>
					";
					$token = $_SESSION['loggedToken'];
					?>
                   <meta http-equiv="refresh" content="2; url=../personal-banking/dashboard.php?accessToken=<?php echo $token; ?>">
					<?php
				}


			}

}







?>