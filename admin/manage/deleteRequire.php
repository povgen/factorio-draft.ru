<?php 
require '../../limb/connect.php';
require '../acces/chek.ink';
R::exec('DELETE FROM `request` WHERE `id` = ? ',array($_GET['id']));
?>
<script>
	alert('Запрос удалён.');
	window.location.href='http://factorio-draft.ru/admin/';
</script>