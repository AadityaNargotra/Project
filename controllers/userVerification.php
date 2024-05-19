<?php
	require_once(INCLUDES.'db_connect.tpl');
	
	$db_connect = new DatabaseConnection();
	$conn = $db_connect->access();

	$token = $conn->real_escape_string($_GET['id']);

	try {
		$query = $conn->prepare("SELECT * FROM users WHERE user_token = ?;");
		$query->bind_param("i", $token);
		$query->execute();
		$result = $query->get_result(); // $result = $db_connect->read_query($query);
		
		if ($result->num_rows == 0) {
			$_SESSION["alert-msg"] = "Invalid Link!";
			$_SESSION["alert-type"] = "danger";
		}
		else {
			$tuple = $result->fetch_assoc(); // mysqli_fetch_assoc($result);
			$target_id = $tuple["user_id"];
			$date = date('Y-m-d H:i:s', time());
			$query = $conn->prepare("UPDATE users SET user_ver_status = 1, email_verified_at = ?  WHERE user_token = ?;");
			$query->bind_param("ss", $date, $token);
			$query->execute();
			if($query->affected_rows == 1) { //$db_connect->update_query($query)
				$query = $conn->prepare("UPDATE users SET user_token = NULL WHERE user_id = ?;");
				$query->bind_param("i", $target_id);
				$query->execute(); // $db_connect->update_query($query);
				$_SESSION["alert-msg"] = "Verification successful! You can now login.";
				$_SESSION["alert-type"] = "success";
			}
			else {
				$_SESSION["alert-msg"] = "Something went wrong! Please try again.";
				$_SESSION["alert-type"] = "danger";
			}
		}
	}
	catch (mysqli_sql_exception $e) {
		$error = $e->getMessage();
		$_SESSION["alert-msg"] = $error;
		$_SESSION["alert-type"] = "danger";
	}
	finally {
		$query->close();
		$db_connect->close();
		header('location:login');
	}
?>