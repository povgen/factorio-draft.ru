<?php require 'connect.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<?php require '../blocks/head.php'; ?>
	<meta charset="UTF-8">
	<title>Пасхалка)</title>
</head>
<body>
	<?php
	unset($_SESSION['logged_user']);
	echo '<script>window.location.href = "'.$_SESSION['url'].'"</script>'; 
	?>
</body>
</html>
