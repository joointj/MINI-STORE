<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_ia";
$con = mysqli_connect($servername, $username, $password, $dbname);
if (! $con) {
  die("connectionfailed" . mysqli_connect_error());
}
?>