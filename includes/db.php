<?php
$servername = "localhost";
$username = "root"; // default for XAMPP
$password = "";
$dbname = "course_analysis";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
