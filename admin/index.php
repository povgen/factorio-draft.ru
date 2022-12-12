<?php require '../limb/connect.php'; 
require 'acces/chek.ink';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Админка</title>
	<script>
		function accept(name,id,article_id) {
		var answer = confirm('Добавить категорию: `'+name+'` ?');
		if (answer) {
			name = encodeURIComponent(name);
			id = encodeURIComponent(id);
			article_id = encodeURIComponent(article_id);
			window.location.href='http://factorio-draft.ru/admin/manage/add_category.php?name='+name+'&require_id='+id+'&article_id='+article_id;
			}
		}
		function del(id,name){
			var answer = confirm('Удалить запрос на добавление категории: `'+name+'` ?');
			if (answer) {
				id = encodeURIComponent(id);
				window.location.href='http://factorio-draft.ru/admin/manage/deleteRequire.php?id='+id;
			}
		}
	</script>
</head>
<body>
	<header>
		<?php require 'blocks/nav.php'; ?>
	</header>
	<main>
		<table border="2">
			<tr>
				<td>id пользователя</td>
				<td>id статьи</td>
				<td colspan="3">Название категории</td>
			</tr>
			<?php
			$arrid = R::getCol('SELECT `id` FROM `request`');
			foreach ($arrid as $id) {
				$request = R::load('request',$id);
				echo "<tr><td>".$request['user_id']."</td><td>".$request['article_id']."</td><td>".$request['name']."</td><td><button 
				onclick=\"accept('".$request['name']."',".$id.",".$request['article_id'].");\" style=\"width:30px;\">+</button></td><td><button 
				onclick=\"del(".$id.",'".$request['name']."');\" style=\"width:30px;\">X</button></td></tr>";
			}

			?>
		</table>
	</main>
</body>
</html>