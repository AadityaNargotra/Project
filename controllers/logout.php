<?php
	//session_start();
	if(isset($_SESSION["login"])){
		session_unset(); //Frees all session variables
		//unset($_SESSION["login"], $_SESSION["user_id"], $_SESSION["name"]); Freeing selected session variables
		$_SESSION["alert-msg"] = "Logged out!";
		$_SESSION["alert-type"] = "success";
	}
	else {
		$_SESSION["alert-msg"] = "No one is logged in here!";
		$_SESSION["alert-type"] = "info";
	}
	header('location:login');
	
?>