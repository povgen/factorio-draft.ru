<?php require '../limb/connect.php'; ?>
<?php if ($_SESSION['logged_user']['id'] != 0){exit();} ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php// require '../blocks/head.php'; ?>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<header>
		<nav>
			<ul>
				<li>Зарегестрированные пользователи</li>
				<li>Категоирии</li>
				<li>Достижения</li>
			</ul>
		</nav>
	</header>
	
</body>
</html>