<?php require '../limb/connect.php'; 
$_SESSION['url'] = "http://factorio-draft.ru/pages/libray.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php require '../blocks/head.php'; ?>
		<meta charset="UTF-8">
		<title>Библиотека</title>
	</head>
<body>
	<div class="wrapper">
		<header>
			<?php require '../blocks/header.php'; ?>
		</header>
		<main>
			<article>
				<form class="sort" method="POST" action="library.php">
					<select name="category" id="">
						<option value="">Показать все категории</option>
						<?php 
						$arrid = R::getCol("SELECT `id` FROM `category`");
						foreach ($arrid as $idCat) {
							$categ = R::load('category',$idCat);
							echo'<option value="'.$idCat.'">'.$categ['name'].'</option>';}?>
					</select>
					<select name="sort" id="">
						<option value="1">В алфавитном порядке(А->Я)</option>
						<option value="2">В алфавитном порядке(Я->А)</option>
						<option value="3">Самые свежие</option>
						<option value="4">Самые старые</option>
					</select>
					<button type="submit">Отсортировать</button>
					<br>
				</form>
			</article>
<?php  
		if (isset($_POST['category'])) {
			switch ($_POST['sort']) {
			case '2':
			$arrid = R::getCol("SELECT * FROM `articles` WHERE `category_id` = ? ORDER BY  `title` DESC ",array($_POST['category']));
				break;
			case '3':
			$arrid = R::getCol("SELECT * FROM `articles` WHERE `category_id` = ? ORDER BY  `date` DESC  ",array($_POST['category']));
				break;
			case '4':
			$arrid = R::getCol("SELECT * FROM `articles` WHERE `category_id` = ? ORDER BY  `date`  ",array($_POST['category']));
				break;
			
			default:
			$arrid = R::getCol("SELECT * FROM `articles` WHERE `category_id` = ? ORDER BY  `title`  ",array($_POST['category']));
				break;
			}
		} else {
			switch ($_POST['sort']) {
				case '2':
				$arrid = R::getCol("SELECT * FROM `articles` ORDER BY  `title` DESC ");
					break;
				case '3':
				$arrid = R::getCol("SELECT * FROM `articles` ORDER BY  `date` DESC ");
					break;
				case '4':
				$arrid = R::getCol("SELECT * FROM `articles` ORDER BY  `date` ");
					break;
				default:
				$arrid = R::getCol("SELECT * FROM `articles` ORDER BY  `title` ");
					break;
			}
		}
	foreach ($arrid as $id) {
		$bean = R::load('articles',$id);
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
		<img src=\"../planImg/$imgurl\">";
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
			<?php require '../blocks/footer.php'; ?>
		</footer>
	</div>
</body>
</html>