<?php 
	session_start();
	error_reporting(0);
	if(!$_SESSION['isLogged'] == true){
		echo 'Your session is over or you just have no rights to enter here!' . '<br>';
		echo 'Back to the Index page' . '<br>';
		echo '<a href="register.php">' .'Register new account' . '</a>' .'<br>';
		exit;
	}
 ?>
 <?php 
	if($_POST){
		if(strlen($_POST['title'])> 5 && strlen($_POST['msg_content'])> 5 &&
		   strlen($_POST['title'])< 50 && strlen($_POST['msg_content']) < 500){
			$user = $_SESSION['username'];
			$date = date("y-m-d");
			$con = mysqli_connect('localhost', 'demiro', 'qwerty', 'test');
			mysqli_set_charset($con, 'utf8');	
			if(!$con){
				echo 'No connection with DB';
			}
			$stmt = mysqli_prepare($con, 'INSERT INTO msgs(author,title,content, dateOf) 
									  VALUES (?,?,?,?)' );
			if(!$stmt){
				echo 'error with the statement!';
			}
			mysqli_stmt_bind_param($stmt,'ssss', $user, $_POST['title'], $_POST['msg_content'], $date);
			mysqli_stmt_execute($stmt);
			header('Location: msg_page.php');
			exit;
		}else{
		echo '<div class="container">'.'Имате грешка в дължината на заглавието или съобщението. И на двете минимума е 5 символа!'.'</div>';
		}
	}
	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MSGboard - Create msg</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/msgs.css">
</head>

<body> 
	<div class="container">
		<h4>Въведете съобщението си във формата:</h4>
		<form method="POST">
			<div class="form-group">
				<b>Заглавие:</b> 
				<input type="text" name="title" class="form-control" autofocus>
			</div>
			<div>
				<textarea name="msg_content" cols="100" rows="20" class="form-control"></textarea>
			</div>
			<div>
				<input type="submit" value="Изпрати!" class="form-control btn btn-default">
			</div>
		</form>
		<footer>
			<h4 class="text-center"><a href="msg_page.php">Виж всички съобщения.</a></h4>
			<h5 class="text-center"><a href="session_destruct.php">Излез!</a></h5>
		</footer>
	</div>
	
</body>
</html>

