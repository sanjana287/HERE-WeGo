<?php
//echo "Hello";
include 'connect.php';
if(isset($_SESSION['username']))
{
	session_start();
  $_SESSION['msg'] = "You must log in first to view the page";
header("location : SCROLL.php");

}
if(isset($_GET['logout']))
{
	session_start();
	unset($_SESSION['username']);
    session_destroy();
    echo "Hello";
 	header("Location:SCROLL.php");
    exit;
}

?>

