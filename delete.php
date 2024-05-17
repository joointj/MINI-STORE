<?php
include "connection.php"; // Using database connection file here
$id = $_GET['id']; // get id through query string
$sql="delete from products where id = '$id'";
$del = mysqli_query($con,$sql); // delete query
if($del)
{
 mysqli_close($con); // Close connection
 header("location:product.php"); // redirects to all records page
}
else
{
 echo "Error deleting record"; // display error message if not delete
}
?>