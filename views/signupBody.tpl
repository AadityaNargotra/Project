<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <div>
		<h4>Signup today, our first 100 users get 50% off on their first order!</h4>
		<br>
		<h3>Signup Form</h3>
		<?php
			echo $_SESSION["alert-msg"];
			unset($_SESSION['alert-msg']);
		?>
		
		<?php

			unset($_SESSION['alert-msg']);
			unset($_SESSION['alert-type']);
		?>

		<form action="save_user" method="post">
			<input type="text" name="user_name" placeholder="Your Full Name" required>
			<input type="email" name="email" placeholder="Your Email" required>
			<input type="number" name="mobile_no" placeholder="Phone Number" required>
			<br>
			<label class="">Gender</label>

			<div>
				<input type="radio" name="gender" value="male">
				<label>M</label>

				<input type="radio" name="gender" value="female">
				<label>F</label>

				<input type="radio" name="gender" value="other">
				<label>Other</label>
			</div>
			<input type="date" name="dob" placeholder="Password" required>
			<br>
			<input type="password" name="password" placeholder="Enter Your Password" required>
			<input type="password" name="confirm_password" placeholder="Confirm Your Password" required>

			<input type="submit" value="Create Account">
		</form>

		</div>
</body>
</html>