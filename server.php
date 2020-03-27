<?php

session_start();

//initialising variable
$username = "";
$email = "";

$errors = array();

//connect to database
$db = mysqli_connect('localhost','root','','webapp') or die("Could not connect to database");

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
    $user_check_query = "SELECT * FROM userdetails WHERE Username = '$username' or Email = '$email' LIMIT 1";

    $results = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($results);

    if($user)
    {
        if($user['Username'] === $username)
        {
            array_push($errors, "Username already exists");
        }
        if($user['Email'] === $email)
        {
            array_push($errors, "This email id already has a registered user");
        }
    }

    // Register the user if no error
    if(count($errors) == 0)
    {
        $password = md5($password1); //This will encrypt the password
        $query = "INSERT INTO userdetails (Username , Email , Password) VALUES ('$username', '$email','$password')"; 
        mysqli_query($db, $query);
        $_SESSION['Username'] = $username;
        $_SESSION['success'] = "You are now logged in";

        header('location: display.php');
    }
}

//login user

if(isset($_POST['log-in']))
{
    $username = mysqli_real_escape_string($db, $_POST['user-name']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if(empty($username))
    {
        array_push($errors, "Username is required");
    }
    if(empty($password))
    {
        array_push($errors, "Password is required");
    }

    if(count($errors) == 0)
    {
        $password = md5($password);
        $query = "SELECT * FROM userdetails WHERE Username = '$username' AND Password = '$password' ";
        $results = mysqli_query($db, $query);

        if(mysqli_num_rows($results))
        {
            $_SESSION['user-name'] = $username;
            $_SESSION['success'] = "Logged in successfully";
            header('location : display.php');
        }
        else
        {
            array_push($errors, "Wrong Username / Password. Please try again.");
        }
    }
}


?>
