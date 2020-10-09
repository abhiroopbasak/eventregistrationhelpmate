<?php
session_start();

$name ="";
$college ="";
$contact ="";
$email ="";

$db = mysqli_connect('localhost','root','','registration');

if(isset($_POST['reg_user']))
{
	$name=mysqli_rweal_escape_string($db,$_POST['name']);
	$college=mysqli_rweal_escape_string($db,$_POST['college']);
	$contact=mysqli_rweal_escape_string($db,$_POST['contact']);
	$email=mysqli_rweal_escape_string($db,$_POST['email']);

	if(empty($name))
	{
		array_push($errors,"Name is required");
	}
	if(empty($email))
	{
		array_push($errors,"Email is required");
	}


	$user_check_query = "SELECT * FROM users WHERE name='$name' OR email='$email' LIMIT 1";
	$result =mysqli_query($db, $user_check_query);
	$user =mysqli_fetch_assoc($result);

	if($user)
	{
		if($user['email']==$email)
		{
			array_push($errors,"Email already registered");
		}
	}

	if(count($errors)==0)
	{
		$query = "INSERT INTO users (name, college, contact, email) VALUES('$name','$college','$contact','$email')";
		mysqli_query($db,$query);
		$_SESSION['name'] = $name;
		$_SESSION['success']= "You are now registered";
		header('location: index.php');
	}
}