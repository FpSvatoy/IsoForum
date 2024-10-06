<html>
	<head>
		<meta charset="utf-8">
		<title> Изометрический форум</title>
		<link rel="stylesheet" href="css/styleMain.css">
		<link rel="stylesheet" href="css/fake.css">
		<link rel="stylesheet" href="css/reg.css">
		<link rel="stylesheet" href="css/lkStyle.css">
	</head>
	<body>
	<?php session_start();?>
		<div class="header">
			<span class="menu-item"><a href="index.php?page_id=1">Изометрия</a></span>
			<span class="menu-item"><a href="lk.php">Личный кабинет</a></span>
			<?php if(empty($_SESSION["auth_user"])){?>
				<span class="menu-item"><a href="../server/updAuthSession.php">Войти/Зарегистрироваться</a></span>
			<?php }else{?>
				<span class="menu-item"><a href="../server/updAuthSession.php">Выйти из <?php echo $_SESSION["auth_nickname"]?></a></span>
			<?php }?>
		</div>		
	<?php include "includes/db.php";?>	