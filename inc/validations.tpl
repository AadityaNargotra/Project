<?php
	class Validation {
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		function name($input) {
			$name = $this->test_input($input);
			if (preg_match("/^[a-zA-Z ]*$/", $name) && $name != '')
				return 1;
			else
				return 0;
		}

		function email($input) {
			$email = $this->test_input($input);
			if (filter_var($email, FILTER_VALIDATE_EMAIL) && $email != '')
				return 1;
			else
				return 0;
		}

		function msg($input) {
			$msg = $this->test_input($input);
			if (preg_match("/^[a-zA-Z0-9. ]*$/", $msg) && $msg != '')
				return 1;
			else
				return 0;
		}

		function phone($input) {
			if(strlen($input) == '10')
				return 1;
			else
				return 0;
		}

		function oneWord($input) {
			$district = $this->test_input($input);
			if (preg_match("/^[a-zA-Z]*$/", $district) && $district != '')
				return 1;
			else
				return 0;
		}

		function twoDigit($input) {
			$num = $this->test_input($input);
			if (preg_match("/^[0-9]{1,2}$/i", $num) && $num != '')
				return 1;
			else
				return 0;
		}

		function number($input) {
			$num = $this->test_input($input);
			if (preg_match("/^[0-9]{1,9}$/i", $num) && $num != '')
				return 1;
			else
				return 0;
		}

		function bool($input) {
			$num = $this->test_input($input);
			if (preg_match("/^[0-1]{1}$/i", $num) && $num != '')
				return 1;
			else
				return 0;
		}

		function address($input) {
			$address =$this->test_input($input);
			if (preg_match("/^.*[a-z,-]$/i", $address) && $address != '')
				return 1;
			else
				return 0;
		}

		function date($date, $format = 'Y-m-d') {
		    $d = DateTime::createFromFormat($format, $date);
		    return $d && $d->format($format) == $date;
		}

		function AdminLogin() {
			if (isset($_SESSION["login"]) && $_SESSION["login"] == 'admin')
				return 1;
			else {
				$_SESSION["alert-msg"] = "You are not logged in as Admin!";
				$_SESSION["alert-type"] = "warning";
				return 0;
			}
		}

		function DeoLogin() {
			if (isset($_SESSION["login"]) && $_SESSION["login"] == 'deo')
				return 1;
			else {
				$_SESSION["alert-msg"] = "You are not logged in as DEO!";
				$_SESSION["alert-type"] = "warning";
				return 0;
			}
		}

		function UserLogin() {
			if (isset($_SESSION["login"]) && $_SESSION["login"] == 'user')
				return 1;
			else {
				$_SESSION["alert-msg"] = "You are not logged in as a User!";
				$_SESSION["alert-type"] = "warning";
				return 0;
			}
		}

		function encryptME($val) {
			return base64_encode(sha1(md5(sha1(md5($val)))));	
		}
	}
?>