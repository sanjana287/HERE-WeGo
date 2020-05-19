<?php

session_start();
if(isset($_SESSION['Username']))
{
    $_SESSION['msg'] = "You must log in first to view the page";
    header("location : SCROLL.html");

}
if(isset($_GET['logout']))
{
    session_destroy();
    unset($_SESSION['Username']);
    header("location : SCROLL.html");
}

?>

