<?php 
	session_start();
	if($_SESSION && $_SESSION['isLogged'] == true) {		
		header('Location: msg_page.php');
		exit;
	}

		$con = mysqli_connect('localhost', 'demiro', 'qwerty', 'test');
		if(!$con){
			echo 'No connection with DB(dev.note)';
		}
		//1. Prepare the statement:
		$stmt = mysqli_prepare($con, 'SELECT user_name, pass FROM users WHERE user_name = ? AND pass = ?');
		if(!$stmt){
			echo 'Problem with the statement occured!(dev.note)';
		}
		//2. Adding data to the sql statement:
		mysqli_stmt_bind_param($stmt, 'ss', $_POST['username'], $_POST['pass']);
		
		//3. Execute the statement in $stmt:
		mysqli_execute($stmt);
		//4. Bind the info in variables:
		mysqli_stmt_bind_result($stmt, $username, $password);
		$fetching = mysqli_stmt_fetch($stmt);		
		if($fetching){
			header('Location: msg_page.php');
			$_SESSION['isLogged'] = true;
			$_SESSION['username'] = $_POST['username'];
			exit;
		} 
 ?>    

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Softuni - Team Pablich fast message board</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<!-- The code in this documents is not optimized even for general usage.
	The idea of the whole project is to be part of the process for teamwork
	of the softuni quality assurance course. Pls don't laugh on the techniqes 
	used for  gaining the final result of the dynamics in this page. Also pls 
	don't try to hack my system through the security holes, there is nothing more
	to see in my host area. Bye.~demiro -->
<div class="container">

	<p><h2 class="text-center">Welcome</h2></p>	
	<p><h3 class="text-center">Softuni - Team Pablich fast message board</h3></p>	

	<form method="POST">
		<div class="form-group">Име:
		<input type="text" name="username" class="form-control" autofocus></div>
		<div class="form-group">Парола:
		<input type="password" name="pass" class="form-control"></div>
		<div class="form-group">
		<input type="submit" value="Влез!" class="btn btn-default" class="form-control">
		<h5 class="pull-right"><a href="registration.php">Регистрирай се!</a></h5>
		</div>
	</form>
	
</div> <!-- end of container	 -->
</body>
</html>