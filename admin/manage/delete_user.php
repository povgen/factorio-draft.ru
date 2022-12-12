<?php 
require '../../limb/connect.php';
require '../acces/chek.ink';
R::exec('DELETE FROM `users` WHERE `id` = ?',array($_GET['id']));
?>
<script>
	alert('Пользователь удалён');
	window.location.href='http://factorio-draft.ru/admin/users.php';
</script>