<?php
//initialising variables
$username = "";
$email = "";

$errors = array();

//connect to database
$db = mysqli_connect('localhost','root','','practice') or die("Could not connect to database");

//Register Users

if(isset($_POST['sign-up']))
{
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password1 = mysqli_real_escape_string($db, $_POST['password1']);
    $password2 = mysqli_real_escape_string($db, $_POST['password2']);

    //form validation
    if(empty($username))
    {
        array_push($errors, "Username is required");
    }
    if(empty($email))
    {
        array_push($errors, "Email is required");
    }
    if(empty($password1))
    {
        array_push($errors, "Password is required");
    }
    if($password1 != $password2)
    {
        array_push($errors, "Passwords do not match");
    }

    //check db for existing user with same username
    $user_check_query = "SELECT * FROM user WHERE username = '$username' or email = '$email' LIMIT 1";

    $results = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_array($results);

    if($user)
    {
        if($user['username'] === $username)
        {
            array_push($errors, "Username already exists");
        }
        if($user['email'] === $email)
        {
            array_push($errors, "This email id already has a registered user");
        }
    }

    // Register the user if no error
    if(count($errors) == 0)
    {
        $password = md5($password1); //This will encrypt the password
        $query = "INSERT INTO user (username , email , password) VALUES ('$username', '$email','$password')"; 
        mysqli_query($db, $query);
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: apihere.php');
    }
    else
    {

    include 'errors.php';

    }
}


?>
