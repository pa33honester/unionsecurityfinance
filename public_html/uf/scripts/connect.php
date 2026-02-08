<?php
$servername = "localhost";
// $username = "u416041620_us";
// $password = "@O^~8YbKc2+N";
$username = "root";
$password = "123456";
$dbname = "u416041620_usf";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {

  die("Connection failed: " . $conn->connect_error);

}
?>