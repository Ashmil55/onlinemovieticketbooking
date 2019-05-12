<?php
// Connecting to the database
$db_host = "localhost";
$db_name = "ashaik3";
$db_user = "ashaik3";
$db_pass = "ashaik3";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name );
if (mysqli_connect_error()){
  echo mysqli_connect_error();
  exit;
}
?>
