<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		require_once(INCLUDES.'validations.tpl');
		require_once(INCLUDES.'db_connect.tpl');
		
		if(!empty($_POST['password'])) {

			$validate = new Validation();

			$email = $_POST['email'];
			$pwd = $validate->encryptME($_POST['password']);
			$role = $_POST['role'];
			
			if ($validate->email($email)) {
				$db_connect = new DatabaseConnection();
				$conn = $db_connect->access();

				try {
					$query = $conn->prepare("SELECT * FROM users WHERE user_email = ? AND user_role = ?");
					$query->bind_param("ss", $email, $role);
					$query->execute(); /* We were previouslly using -> $db_connect->read_query($query) */
					$result = $query->get_result();
				/*
					$tuple = mysqli_fetch_assoc($result);
					$result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
				*/
	
					if($result->num_rows == 0) {
						$_SESSION["alert-msg"] = "Email-id doesn't exist against the role!";
						$_SESSION["alert-type"] = "danger";
					}
					else {
						
						$tuple = $result->fetch_assoc();

						if ($pwd == $tuple["user_pwd"]) {
							if ($tuple["user_ver_status"] == 1) {
								$_SESSION["login"] = $role;
								$_SESSION["user_id"] = $tuple["user_id"];
								$_SESSION["name"] = $tuple["user_name"];
								if ($tuple["user_role"] == 'user')
									if (isset($_POST['back_to']))
										header('location:ShowProduct?id='.$_POST["prod_id"]);
									else
										header('location:product_display');
								else
									header('location:dashboard');
								exit();
							}
							else {
								$_SESSION["alert-msg"] = "You have not verified your email yet!";
								$_SESSION["alert-type"] = "warning";
							}
						}
						else {
							$_SESSION["alert-msg"] = "Incorrect password!";
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
				}
			}
			else {
				$_SESSION["alert-msg"] = "What kind of email was that han? Duffer!";
				$_SESSION["alert-type"] = "danger";

			}
		}
		else {
			$_SESSION["alert-msg"] = "Duffer is trying with empty password!";
			$_SESSION["alert-type"] = "danger";
		}
	}
	else {
		$_SESSION["alert-msg"] = "Unauthorised access attempted!";
		$_SESSION["alert-type"] = "danger";
	}
	header('location:login');
?>