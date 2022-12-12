<?php 
require 'connect.php';
$get = R::dispense('request');
$get->name = $_GET['nameCat'];
$get->user_id = $_GET['user_id'];
$get->article_id = $_GET['article_id'];
R::store($get);
echo "<script>alert('Запрос на добавление категории отправлен');
window.location.href='".$_SESSION['url']."';</script>";
?>