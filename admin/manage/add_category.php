<?php 
require '../../limb/connect.php';
require '../acces/chek.ink';

$cat = R::dispense('category');
if (isset($_GET['name'])) {
	$cat->name = $_GET['name'];
	R::exec('DELETE FROM `request` WHERE `id` = ?',array($_GET['require_id']));
	R::store($cat);
	$category_id = R::getCol('SELECT `id` FROM `category` ORDER BY `id` DESC')[0];
	$artId = $_GET['article_id'];
	$catArt = R::load('articls',$artId);
	$catArt->category_id = $category_id;
	var_dump($category_id);
	R::store($catArt);
	echo "<script>
	alert('Категория добавлена, запрос удалён, категория статьи изменена');
	window.location.href='http://factorio-draft.ru/admin/';
</script>";
} else {$cat->name = $_POST['name'];
R::store($cat);
}

?>
<script>
	alert('Категория добавлена');
	window.location.href='http://factorio-draft.ru/admin/category.php';
</script>