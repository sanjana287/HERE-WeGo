<?php 

//get values from form in signup file
$username = $POST['username'];
//$email = $POST['email'];
$password = $POST['password1'];

//to prevent mysql injection
$username = stripcslashes($username);
//$email = stripcslashes($email);
$password = stripcslashes($password1);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

//connect to the server and select database
mysql_connect("localhost", "root", "");
mysql_select_db("webapp");

//query the database for user
$result = mysql_query("SELECT * from userdetails where Username = $username and Password = $password")
                or die("Failed to query database".mysql_error());
$row = mysql_fetch_array($result);
if($row['Username'] == $username && $row['Password'] == $password)
{
    echo

}else{

}

?>
