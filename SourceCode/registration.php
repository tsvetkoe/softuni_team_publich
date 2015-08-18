<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/msgs.css">
</head>
<body>
	<div class="container">
		<p class="text-center">Регистрирай нов акаунт:</p>
		<form method="POST">
			<div class="form-group">Име:<input type="text" name="username" class="form-control"></div>
			<div class="form-group">Парола:*<input type="password" name="pass" class="form-control"></div>
			<div class="form-group"><input type="submit" value="Register" class="form-control"></div>
		</form>
		<p class="text-center">*Моля имайте предвид, че това е тестова система и запазва паролите в четим за администраторите вид. 
		Така че използвайте примерни пароли от рода на qwerty, 123456, а не реалните си пароли!</p>
	</div>	
</body>
</html>

<?php 
	error_reporting(0);
	session_start();
	if($_SESSION['username'] == true){
		header('Location: msg_page.php');
		exit;
	}

	if($_POST){
		$con = mysqli_connect('localhost', '***', '***', 'test');
		if (!$con){
			echo 'could not connect with the DB';
		}
		//prepared statement:
		$stmt = mysqli_prepare($con, 'INSERT INTO users(user_name, pass) VALUES (?,?)');
		if(!$stmt){
			echo 'error with the statement';
		}
		mysqli_stmt_bind_param($stmt, 'ss', trim($_POST['username']), trim($_POST['pass']));
		
		if(strlen($_POST['username'])>5){

			if(mysqli_stmt_execute($stmt)){
			$_SESSION['isLogged'] = true;
			$_SESSION['username'] = $_POST['username'];
			header('Location: new_msg.php');
			}else{
			echo '<div class="container text-center text-danger h4">'. 'Вече има потребител с това име.'. '</div>';
			echo '<div class="container text-center h3">'. '<a href="index.php">' . 'Обратно към формата за вход.'. '</a>' .'</div>';
			 }

		} else{
			echo '<div class="container h4 text-danger text-center"> Потребителското име трябва да е минимум 5 символа!</div>';
		}


	}
 ?>