<html>
<body>
<?php 

$link = mysqli_connect("localhost", "root", "");
mysqli_select_db($link,"practice");
//get values from form in signup file

if(isset($_POST["log-in"])){
	$errors = array();
	$username = $_POST["username"];
	$password = md5($_POST["password"]);
	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$username = mysqli_real_escape_string($link,$username);
	$password = mysqli_real_escape_string($link,$password);
	
	$result = mysqli_query($link,"SELECT * from `user` where `username` = '$username' and `password` = '$password'")
	                or die("Failed to query database".mysqli_error($link));
	$row = mysqli_fetch_array($result);

	if($row['username'] == $username && $row['password'] == $password)
	{
	  session_start();
	  $_SESSION['username']=$username;
	  header("Location: apihere.php");

	}
	else{
		array_push($errors, "Invalid Username/Password. Please try again!");
		
	   include 'errors.php';
	   
	}
}


?>
</body>
</html>
