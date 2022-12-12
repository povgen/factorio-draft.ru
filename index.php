<?php require 'limb/connect.php';
$_SESSION['url'] = 'http://factorio-draft.ru/';
 ?>
<!DOCTYPE html>
<html>
<head>
	<?php require 'blocks/head.php'; ?>	
	<title>Главная</title>
	<link rel="stylesheet" href="stylesheet/rateForIndex.css">
</head>
<body>
	<div class="wrapper">
		<header>
			<?php require 'blocks/header.php'; ?>
		</header>
		
		<main>

			<?php if (!isset($_SESSION['logged_user'])){
			require 'blocks/forma.php';
			}
			?>
			

<?php  
		$arrid = R::getCol("SELECT * FROM `articls` ORDER BY  `id` DESC LIMIT 10");

	foreach ($arrid as $id) {
		$bean = R::load('articls',$id);
		$title = $bean['title'];
		if ((strlen($bean['description']) < 500)) {
			$description = $bean['description'];
		} else {
			$description = substr($bean['description'], 0, 497);
			$description = rtrim($description, "!,.-");
			$description = substr($description, 0, strrpos($description, ' '));
			$description .= "...";
		}
		$code = $bean['code'];
		$imgurl = $bean['imgurl'];
		$author_id = $bean['author_id'];
		$bean_user = R::getAll("SELECT `name`,`login` FROM `users` WHERE `id` = ?",array($author_id));
		$author = $bean_user[0]['name'].' ('.$bean_user[0]['login'].')';
		$url = '<a style="cursor:pointer;" onclick="var id = encodeURIComponent('.$id.');window.location.href= \'http://factorio-draft.ru/pages/watch.php?id=\'+id;">Просмотр</a>';
		echo "<article><h1>$title</h1>".$url."
		<section>
		$description
		<div><p>Автор: $author</p></div>
		</section>
		<img src=\"planImg/$imgurl\">";
		$bean_rate = R::getAll('SELECT `star` FROM `rate` WHERE `id_article` = ?',array($id));
		$rate = 0;
		$count = 0;
		foreach ($bean_rate as $datarate) {
			$datarate = intval($datarate['star']);
			$rate += $datarate;
			$count++;
		}
		// var_dump($rate);
		if ($count != 0){$rate = ($rate/$count)*20;}
		echo '<div style="width: 100px;" class="rate_wrap">
		<ul class="rate">
		<li style="width:'.$rate.'%;" class="current"><span class="star1"></span></li>
		<li><span class="star2"></span></li>
		<li><span class="star3"></span></li>
		<li><span class="star4"></span></li>
		<li><span class="star5"></span></li>
		</ul>
		</div>';
		echo "</article>";

	}


?>
		</main>


		<footer>
		
			<?php require 'blocks/footer.php'; ?>
			<?php 

 if (($_SESSION['logged_user']['id'] == 0)&&(isset($_SESSION['logged_user']['id']))) { 
 	echo 
	 	"<script>var conf = confirm(\"Перейти в панель администратора?\");
	 	if (conf) window.location.href='http://factorio-draft.ru/admin';</script>";
	}
 ?>
			
		</footer>
	</div>
</body>


</html>
