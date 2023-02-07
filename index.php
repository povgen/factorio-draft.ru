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
			<?php if (!isset($_SESSION['logged_user'])){ require 'blocks/forma.php'; } ?>
<?php 	foreach ($articles as $article) : ?>
            <article>
                <h1><?= $article->title ?></h1>
                <a style="cursor:pointer;" href="http://factorio-draft.ru/pages/watch.php?id=<?= $article->id ?>" >Просмотр</a>
                <section>
					<?= cutString($article->description, 500) ?>
                    <div><p>Автор: <?= $article->author ?></p></div>
                </section>
                <img src="planImg/<?= $article->imgurl ?>">
                <div style="width: 100px;" class="rate_wrap">
                    <ul class="rate">
                        <li style="width:<?= $article->rate*20 ?>%;" class="current"><span class="star1"></span></li>
                        <li><span class="star2"></span></li>
                        <li><span class="star3"></span></li>
                        <li><span class="star4"></span></li>
                        <li><span class="star5"></span></li>
                    </ul>
                </div>
            </article>
<?php endforeach; ?>
		</main>
		<footer>
			<?php require 'blocks/footer.php';
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
