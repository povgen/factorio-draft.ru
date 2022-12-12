<?php 
require '../limb/connect.php';
require 'acces/chek.ink';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Пользователи</title>
	<script src="../scripts/jquery-3.2.1.js"></script>
	<script language="javascript" type="text/javascript">
		function del(id, name) {
			var conf = confirm("Удалить пользователя с логином:`"+name+"`?");
			if (conf) {
				var idup = encodeURIComponent(id);window.location.href='http://factorio-draft.ru/admin/manage/delete_user.php?id='+idup;
			}
		}
	</script>
</head>
<body>
	<header>
		<?php require 'blocks/nav.php'; ?>
	</header>
	<main>
		<table border="1">
			<tr>
				<td><a href="http://factorio-draft.ru/admin/users.php">id</a></td>
				<td><a href="http://factorio-draft.ru/admin/users.php?sort=2">Логин</a></td>
				<td colspan="3"><a href="http://factorio-draft.ru/admin/users.php?sort=3">Имя</a></td>
			</tr>
			<?php
			switch ($_GET['sort']) {
				case '2':
					$arrid = R::getCol("SELECT `id` From `users` ORDER BY `login`");
					break;
				case '3':
					$arrid = R::getCol("SELECT `id` From `users` ORDER BY `name`");
					break;
				default:
					$arrid = R::getCol("SELECT `id` FROM `users` ORDER BY `id`");
					break;
			}
			foreach ($arrid as $id) {
				if ($id == 0) continue;
				$user = R::load('users',$id);
				echo'<tr>'.
						'<td>'.$id.'</td>'.
						'<td>'.$user->login.'</td>'.
						'<td>'.$user->name.'</td>'.
						'<td>'.'<button onclick="del('.$id.',\''.$user->login.'\');">X</button></td>'.
					
					'</tr>';
			}



			?>
		</table>
	</main>
	<footer></footer>
</body>
</html>
