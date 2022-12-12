<?php 
require '../limb/connect.php';
$id = $_SESSION['id'];
$star = $_GET['star'];
$user_id = $_SESSION['logged_user']['id'];
$rate = R::dispense('rate');
$unic = R::FindOne('rate','id_user = ? AND id_article = ?',array($user_id,$id));
if ($unic){
	echo "<script>alert('Вы уже оставляли отзыв');</script>";
	echo "<script>window.location.href= 'http://factorio-draft.ru/pages/watch.php?id='+".$id.";</script>";
} else{
	$rate->id_user = $user_id;
	$rate->id_article = $id;
	$rate->star = $star;
	R::store($rate); 
	echo "<script>alert('Спасибо за ваш отзыв');</script>";
	echo "<script>window.location.href= 'http://factorio-draft.ru/pages/watch.php?id='+".$id.";</script>";
}


?>