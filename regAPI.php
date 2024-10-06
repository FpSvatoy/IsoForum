	<?php include "includes/header.php"; ?>
		<div class="wrapperReg">
			<div class="reg-container">	
			<?php session_start(); 
			
			if (!(isset($_SESSION["login"]))){
				$_SESSION['login']='';
			}
			if (!(isset($_SESSION["surname"]))){
				$_SESSION['surname']='';
			}
			if (!(isset($_SESSION["name"]))){
				$_SESSION['name']='';
			}
			if (!(isset($_SESSION["nickname"]))){
				$_SESSION['nickname']='';
			}
			if (!(isset($_SESSION['reg_message']))){
				$_SESSION['reg_message']='';
			}
			?>		
				<form action="server/registration.php" method="post">
					<p>
						<label for="login">Введите логин:</label>
						<input name="login" id="login" type="text" value=<?php echo ($_SESSION['login']);?>>
					</p>
					<p>
						<label for="password">Введите пароль</label>
						<input name="password" id="password" type="password" >
					</p>
					<p>
						<label for="repassword">Повторите пароль:</label>
						<input name="repassword" id="repassword" type="password" >					
					</p>
					<p>
						<label for="surname">Ваша фамилия:</label>
						<input name="surname" id="surname" type="text" value=<?php echo ($_SESSION['surname']);?>>
					</p>
					<p>
						<label for="name">Ваше имя:</label>
						<input name="name" id="name" type="text" value=<?php echo ($_SESSION['name']);?>>
					</p>
					<p>
						<label for="nickname">Ваш nickname:</label>
						<input name="nickname" id="nickname" type="text" value=<?php echo ($_SESSION['nickname']);?>>
					</p>
					<div id="btnDivReg">
						<button name = "submit" id="btnReg" type="submit">Зарегистрироваться</button>
					</div>
				</form>
				<a id="regRef" href="server/updAuthSession.php">
					Вход
				</a>
				<p  class ="loginMsg"> <?php echo ($_SESSION['reg_message'].'<br>');?></p>
			</div>
		</div>
	<?php 
	include "includes/footer.php"; ?>