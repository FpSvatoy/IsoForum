<?php 
		session_start();
		include "../includes/db.php";
		include "../includes/varLive.php";
		if(func_varLive("login")&&func_varLive("password")){
			$login = trim($_POST["login"]);
			$password = trim($_POST["password"]);
			$query = "SELECT * FROM user WHERE `login` = '{$login}'";
			$result = mysqli_query($connection, $query);
			var_dump($query);
			if(mysqli_num_rows($result)> 0){
				$row = mysqli_fetch_assoc($result);
				$resultPassword = $row["password"];
				echo $resultPassword;
				echo $password;
				if(password_verify($password,$resultPassword)){
					$_SESSION["auth_user"] = $row["login"];
					$_SESSION["auth_nickname"] = $row["nickname"];	
					header('Location: ../index.php?page_id=1');
				}else{
					$_SESSION["auth_user"] = '';
					$_SESSION["auth_nickname"] = '';
					$_SESSION["auth_message"] = "Пароль неверный. Попробуйте снова.";
					if(isset( $_POST["login"])){
						$_SESSION['login']= $_POST["login"];
					}
					header('Location: ../authAPI.php');
				}
			}else{
				$_SESSION['login']= '';
				$_SESSION["auth_message"] = "Данного пользователя не существует";
				header('Location: ../authAPI.php');
			}
			
		}else{
			$_SESSION["auth_user"] = '';
			$_SESSION["auth_nickname"] = '';
			$_SESSION["auth_message"] ="Заполните все поля.";
			if(isset( $_POST["login"])){
				$_SESSION['login']= $_POST["login"];
			}
			header('Location: ../authAPI.php');
		}
?>