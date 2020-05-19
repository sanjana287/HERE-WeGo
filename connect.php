<?php 
$link = mysqli_connect("localhost", "root", "");
mysqli_select_db($link,"practice");
//get values from form in signup file
$username = $_POST['username'];
//$email = $POST['email'];
$password = md5($_POST['password']);
//to prevent mysql injection
$username = stripcslashes($username);
//$email = stripcslashes($email);
$password = stripcslashes($password);
$username = mysqli_real_escape_string($link,$username);
$password = mysqli_real_escape_string($link,$password);

//connect to the server and select database

//query the database for user
$result = mysqli_query($link,"SELECT * from `user` where `username` = '$username' and `password` = '$password'")
                or die("Failed to query database".mysqli_error($link));
$row = mysqli_fetch_array($result);
if($row['username'] == $username && $row['password'] == $password)
{
    header("Location: apihere.php");

}else{

   //header("Location: SCROLL.html");
   //echo "Invalid username and password";
}

?>
