<?php
$conn = mysqli_connect("localhost", "root", "", "bookstore3");

if(!$conn){
   die('Connection Failed:'.mysqli_connect_error());
}
?>
