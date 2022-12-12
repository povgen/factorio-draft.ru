<?php 
require '../../limb/connect.php';
require '../acces/chek.ink';
R::exec('DELETE FROM `category` WHERE `id` = ?',array($_GET['id']));
?>
<script>
	alert('Категория удалена');
	window.location.href='http://factorio-draft.ru/admin/category.php';
</script>