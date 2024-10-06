<?php include "includes/header.php"; ?>
	<div class="wrapperReg">
		<div class="reg-container">	
		<?php session_start(); 
		if (!(isset($_SESSION["login"]))){
			$_SESSION['login']='';
		}
		if (!(isset($_SESSION['auth_message']))){
			$_SESSION['auth_message']='';
		}
		?>	
			<form action="server/authorization.php" method="post">
				<p>
					<label for="login">Введите логин:</label>
					<input name="login" id="login" type="text" value=<?php echo ($_SESSION['login']);?>>
				</p>
				<p>
					<label for="password">Введите пароль</label>
					<input name="password" id="password" type="password">
				</p>
				<div id="btnDivReg">
					<button name = "submit" id="btnReg" type="submit">Авторизация</button>
				</div>
			</form>
			<a id="regRef" href="server/updRegSession.php">
				Регистрация
			</a>
			<p  class ="loginMsg"> <?php echo ($_SESSION['auth_message']);?></p>
		</div>
	</div>
<?php
include "includes/footer.php"; ?>