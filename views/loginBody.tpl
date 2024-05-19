<!DOCTYPE html>
<html>
<head>
    <title>Food Formula Cafe - Login</title>
    <style>
        body {
            font-family: latha;
            color: white;
            background: linear-gradient(rgba(0, 0, 0, 0.95), rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0)), url(foodd.jpg);
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            width: 400px;
            padding: 40px;
            background: rgba(0, 0, 0, 0.9);
            text-align: center;
            border-radius: 10px;
        }
        .login-box h2 {
            margin: 0 0 30px;
            padding: 0;
            color: white;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: black;
            border: 1px solid white;
            color: white;
            font-size: 16px;
            border-radius: 5px;
        }
        .login-box input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: green;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .login-box input[type="submit"]:hover {
            background-color: darkgreen;
        }
        .login-box a {
            color: darkgray;
            text-decoration: none;
        }
        .login-box a:hover {
            color: white;
        }
    </style>
</head>
<body>
    <?php
        echo $_SESSION["alert-msg"];
        unset($_SESSION['alert-msg']);
    ?>
		
    <?php
        unset($_SESSION['alert-msg']);
        unset($_SESSION['alert-type']);
    ?>

    <div class="login-box">
        <h2>Login</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <a href="file:///C:/Users/HP/Desktop/html%20css/food%20formula.html/ffc.html">Back to Home</a>
    </div>
</body>
</html>