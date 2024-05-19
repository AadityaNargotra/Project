<?php
	session_start();

	$url = $_SERVER['REQUEST_URI']; // First we get the url that's hit

	$parts = parse_url($url); // Getting access to different parts of the url i.e path, query etc
	$site_path = $parts["path"]; // Accessing the path portion of the url and ignoring the query part
	$sp_array = explode('/', $site_path); // Partitioning the path on slash criteria and storing in site path array

	if (isset($sp_array[SEG_NXT])) // Checking if unnecessary segment of url is set so that it could be routed to error page
		header('location:'.WEBPATH.'error'); // Routing to error page
	elseif ($site_path[strlen($site_path)-1] == '/' && $sp_array[SEG]) { // Checking if last character is slash and whether the necessary segment of url is set
		$site_path = rtrim($site_path,'/'); // Removing the right most slash from the url
		header('location:'.$site_path); // Directing to the just modified url
	}

	if (isset($sp_array[SEG])) { // Checking again if necessary segment of url is set

		require_once(INCLUDES.'validations.tpl'); // Including validations file to enable object creation
		$validate = new Validation(); // Creating an object of validation class to call functions for login check

		switch($sp_array[SEG]) { // Using switch statement for routing based on the necessary segment

// View Cases ------------------------------ Pages that a user gets to see, these pages have both html and php code

			case '':
			case 'home':
				require_once(PAGE.'home.tpl');
				break;

			case 'about':
				require_once(PAGE.'about.tpl');
				break;

			case 'login':
				if (isset($_SESSION['login']))
					header('location:dashboard');
				else
					require_once(PAGE.'login.tpl');
				break;

			case 'error':
				require_once(PAGE.'error.tpl');
				break;

			default:
				header('location:'.WEBPATH.'error');
		}
	}
	else
		header('location:'.WEBPATH.'home');
?>
