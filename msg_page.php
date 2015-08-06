<?php 
	session_start();
	error_reporting(0);	
	if(!$_SESSION['isLogged'] == true){ 
		echo 'Your session is over or you just have no rights to enter here!' . '<br>';
		echo '<a href="index.php">'.'Back to the Index page'.'</a>'.'<br>';
		echo '<a href="register.php">' .'Register new account' . '</a>' .'<br>';
		exit;
		}
	 ?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MSGboard Team Publich </title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/msgs.css">
</head>
<body>
	<div class="container">
			<header>
			<form method="POST" id="optionForm">
					</form>
				<?php 
					if($_POST && $_POST['delete']){
				 	$con = mysqli_connect("localhost", "demiro", "qwerty", "test");
				 	$query2 = 'DELETE FROM msgs WHERE msg_id = 10+'. $_POST['delete'];			 	
				 	if(mysqli_query($con, $query2)){
				 		echo '<div class="container text-center h3">' . 'Success with deleteting' . '</div>';			 		
				 	}
				}
				 ?>
			<a href="new_msg.php">Създай съобщение</a>
			<a href="session_destruct.php" class="pull-right">Излез!</a>
			</header>

			 <?php
				$link = mysqli_connect("localhost", "demiro", "qwerty", "test");
				$query = "SELECT author,title,content,dateOf,msg_id FROM msgs";				
				if (mysqli_connect_errno()) {
				    printf("Problem with the statement occured!(dev.note)");
				    exit();
				}				
				if ($stmt = mysqli_prepare($link, $query)) {
				    /* execute statement */
				    mysqli_stmt_execute($stmt);
				    /* bind result variables */
				    mysqli_stmt_bind_result($stmt, $author, $title, $content, $dateOf,$msg_id);
				    /* fetch values */	    
				    while (mysqli_stmt_fetch($stmt)) {
				       echo '<table class="table table-striped ">';
				       echo '<tr class="success"><td>' .'Author(:) ' . $author. '</td>'. '<td class="text-right">' .$dateOf. '</td></tr>';
				       echo '<tr><th colspan="2" class="text-center">'.$title.'</th></tr>';
				       echo '<tr><td colspan="2" class="text-justify">'.$content.'</td></tr>';
				       if ($_SESSION['username'] === $author) {
				       	//div.btn-group to group more than one button :)(use btn-default on buttons)
				       	echo '<tr><td colspan="2" class="text-right">'.
				       	''.  '<span class="h5">Изтриване?</span>' .
				       		 '<button name="delete" type="submit" class="btn btn-default"
				       		  value="'.
				       	      $msg_id.'" form="optionForm">'.
				       	 	 '<span class=" glyphicon glyphicon-remove" ></span>
				       		 </button>'.
				       		 '</td></tr>';		       	
				       }
				       echo '</table>';				      
				    }
				    /* close statement */
				    mysqli_stmt_close($stmt);
				}
				/* close connection */
				mysqli_close($link);
			?>	
		<footer>
		<a href="new_msg.php">Създай съобщение</a>
		<a href="session_destruct.php" class="pull-right">Излез!</a>
		</footer>
	</div>
</body>
</html>
