<?php 
	require '../limb/connect.php';
	require 'acces/chek.ink';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Категории</title>
	<script language="javascript" type="text/javascript">
		function del(id, name) {
			var conf = confirm("Удалить Удалить категорию:`"+name+"`?");
			if (conf) {
				var idup = encodeURIComponent(id);window.location.href='http://factorio-draft.ru/admin/manage/delete_category.php?id='+idup;
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
				<td><a href="http://factorio-draft.ru/admin/category.php">id</a></td>
				<td colspan="2"><a href="http://factorio-draft.ru/admin/category.php?sort=2">Название</a></td>
			</tr>
			<?php
			switch ($_GET['sort']) {
				case '2':
					$arrid = R::getCol("SELECT `id` From `category` ORDER BY `name`");
					break;
				default:
					$arrid = R::getCol("SELECT `id` FROM `category` ORDER BY `id`");
					break;
			}
			foreach ($arrid as $id) {
				$user = R::load('category',$id);
				echo'<tr>'.
						'<td>'.$id.'</td>'.
						'<td>'.$user->name.'</td>'.
						'<td>'.'<button onclick="del('.$id.',\''.$user->name.'\');">X</button></td>'.
					
					'</tr>';
			}
			?>
			<tr>
				<td colspan="3">Добавить новую категорию</td>
			</tr>
			<tr>
				<form method="POST" action="manage/add_category.php">
					<td colspan="2"><input required name="name" type="text" placeholder="Название категории"></td>
					<td><button type="submit">+</button></td>
				</form>
			</tr>
		</table>
	</main>
	
</body>
</html>