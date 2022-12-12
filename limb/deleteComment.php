<?php 
require 'connect.php';
$author_id = R::load('comment',$_GET['id'])['user_id'];
if ((($_SESSION['logged_user']['id'] == $author_id)||($_SESSION['logged_user']['id'] == 0))) {
	require '../blocks/head.php';
	R::exec('DELETE FROM `comment` WHERE `id` = ?',array($_GET[id]));
echo "<script>alert('Коментарий удалён');window.location.href='".$_SESSION['url']."';</script>";
	
} else require 'Object not found!.html';


?>