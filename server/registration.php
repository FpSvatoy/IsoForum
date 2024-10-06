	<?php 
		session_start();
		include "../includes/db.php";
		include "../includes/varLive.php";
		if(func_varLive("login")&&func_varLive("password")&&func_varLive("repassword")
		&&func_varLive("surname")&&func_varLive("name")&&func_varLive("nickname")){
			$login = trim(strip_tags($_POST["login"]));
			$password = trim(strip_tags($_POST["password"]));
			$repassword = trim(strip_tags($_POST["repassword"]));
			$surname = trim(strip_tags($_POST["surname"]));
			$name = trim(strip_tags($_POST["name"]));
			$nickname = trim(strip_tags($_POST["nickname"]));
		
			$_SESSION['reg_message'] = '';
			$querylogin = "SELECT login FROM user WHERE `login` = '{$login}'";
			$checklog = mysqli_query($connection, $querylogin);
			$querynickname = "SELECT nickname FROM user WHERE `nickname` = '{$nickname}'";
			$checknick = mysqli_query($connection, $querynickname);
			if (mysqli_num_rows($checklog) > 0 || mysqli_num_rows($checknick)> 0) {
				$_SESSION['reg_message'] = "Ошибка:";
				if (mysqli_num_rows($checklog) > 0 ) {
					$_SESSION["reg_message"] .= "Логин занят.";
					$_SESSION['login'] = '';
				}else{
					$_SESSION['login'] = $login;
				}
				if (mysqli_num_rows($checknick) > 0 ) {
					$_SESSION['reg_message'] .= "Никнейм занят.";
					$_SESSION['nickname'] = '';
				}else{
					$_SESSION['nickname'] = $nickname;
				}
				$_SESSION['surname'] = $surname;
				$_SESSION['name'] = $name;
				$_SESSION['reg_message'] .= "Введите новые данные.";
				header('Location: ../regAPI.php');
			}

			$user_group = 1;
			$hashPassword = password_hash($password, PASSWORD_DEFAULT);
			$insert_query = "INSERT INTO user ( `login`, `password`, `surname`,`name`,`nickname`,`user_group`)";
			$insert_query .= "VALUE('{$login}', '$hashPassword', '{$surname}', '{$name}', '{$nickname}', '{$user_group}')";
			$insert_res = mysqli_query($connection, $insert_query);//выполняем запрос к бд
			if(!$insert_res){
				$_SESSION['reg_message'] = 'Ошибка при запросе';
			}
			session_unset();
			$_SESSION['auth_message'] = 'Вы зарегестрированы!';
   			header('Location: ../authAPI.php');
		}else{
			if ((isset($_POST["login"]))){
				$_SESSION["login"]=$_POST["login"];
			}
			if ((isset($_POST["surname"]))){
				$_SESSION["surname"]=$_POST["surname"];
			}
			if ((isset($_POST["name"]))){
				$_SESSION["name"]=$_POST["name"];
			}
			if ((isset($_POST["nickname"]))){
				$_SESSION["nickname"]=$_POST["nickname"];
			}
			$_SESSION["reg_message"]="Заполните все поля.";
			header('Location: ../regAPI.php');
		}
	?>