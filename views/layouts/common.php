<!DOCTYPE html>
<html>
<head>
	<?php require '../blocks/head.php'; ?>
	<title><?= $title ?></title>
	<link rel="stylesheet" href="stylesheet/rateForIndex.css">
</head>
<body>
<div class="wrapper">
	<header>
		<?php require '../blocks/header.php'; ?>
	</header>
	<main>
		<?= $content ?>
	</main>
	<footer>
		<?php require '../blocks/footer.php';
		if (($_SESSION['logged_user']['id'] == 0)&&(isset($_SESSION['logged_user']['id']))) {
			echo
			"<script>var conf = confirm(\"Перейти в панель администратора?\");
	 	if (conf) window.location.href='http://factorio-draft.ru/admin';</script>";
		}
		?>
	</footer>
</div>
</body>
</html>
