<?php
$host = "sql304.infinityfree.com";
$user = "if0_38574572";
$pass = "847MaKkCTGv5ycm";
$db   = "if0_38574572_users_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
