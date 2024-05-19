<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		require_once(INCLUDES.'validations.tpl');

		$validate = new Validation();

		if ($validate->name($_POST['user_name']) && $validate->email($_POST['email']) && $validate->phone($_POST['mobile_no']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {

			if ($_POST['password'] == $_POST['confirm_password']) {

				$name =ucwords(strtolower($_POST['user_name']));
				$email = $_POST['email'];
				$mobile = $_POST['mobile_no'];
				$gender = $_POST['gender'];
				$dob = $_POST['dob'];
				$pwd = $validate->encryptME($_POST['password']);
				$token = md5(uniqid(rand(), true));				

				require_once(INCLUDES.'db_connect.tpl');
				
				$db_connect = new DatabaseConnection();
				$conn = $db_connect->access();

				$query = $conn->prepare("INSERT INTO users (user_name, user_email, user_gender, user_dob, user_pwd, user_phone, user_role, user_token, user_ver_status) VALUES (?, ?, ?, ?, ?, ?, 'user', ?,0);");
				$query->bind_param("sssssss", $name, $email, $gender, $dob, $pwd, $mobile,$token);
				$query->execute();
				
				if($query->affected_rows == 1) { //$db_connect->insert_query($query)
					$_SESSION["alert-msg"] = "Signed up successfully!";
					$_SESSION["alert-type"] = "success";
					$email_subject = "Account Verification Link | Food Formula";
					$email_from = "Food Formula Support Team";
					$msg = "";
					$msg .= "Dear ".strtok($name, " ").", kindly verify your account by clicking this link below:<br><br><a>".WEBPATH."user_verify?id=".$token."</a><br><br>Regards<br>Food Formula Support Team";
					$ourEmail = "arslanb321@gmail.com";
					//$headers = 'From: '.$email_from."\r\n".'X-Mailer: PHP/'.phpversion();
					$mail = new PHPMailer(true);
					try {
						//Server settings
						$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
						$mail->isSMTP();                                            //Send using SMTP
						$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
						$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
						$mail->Username   = $ourEmail;                     //SMTP username
						$mail->Password   = 'ndmt ltsa wczm gjqx';                               //SMTP password
						$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
						$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

						//Recipients
						$mail->setFrom($ourEmail, $email_from);
						$mail->addAddress($email);     //Add a recipient
						
						//Content
						$mail->isHTML(true);                                  //Set email format to HTML
						$mail->Subject = $email_subject;
						$mail->Body    = $msg;
						//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

						$sentUser = $mail->send();
						if ($sentUser)								
							$_SESSION["alert-msg-2"] ="Just one more step, we've mailed a verification link to you. Kindly click on the link in order to verify your account.";
						else
							$_SESSION["alert-msg-2"] ="We couldn't mail the verification link to you due to some error. Kindly provide your email id through the contact form so that we can get back to you.";
					} 
					catch (Exception $e) {
						$_SESSION["alert-msg-2"] ="We couldn't mail the verification link to you due to some error. Kindly provide your email id through the contact form so that we can get back to you.\n\n".$e->getMessage()."\n\n".$mail->ErrorInfo;
					}
					finally {
						$query->close();
						$db_connect->close();
					}							
				}
				else {
					$_SESSION["alert-msg"] = "Could not sign up! Perhaps the email/phone number maybe already in use.";
					$_SESSION["alert-type"] = "warning";
				}
				
			}
			else {
				$_SESSION["alert-msg"] = "Passwords don't match! Please try again.";
				$_SESSION["alert-type"] = "danger";
			}
		}
		else {
			$_SESSION['alert-msg'] = "Invalid Input! Try again.";
			$_SESSION['alert-type'] = "danger";
		}
	}
	else {
		$_SESSION["alert-msg"] = "Unauthorized access attempted!";
		$_SESSION["alert-type"] = "danger";
	}
	header('location:signup');
?>