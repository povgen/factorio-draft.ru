<?php require '../limb/connect.php';
if (!isset($_SESSION['logged_user'])){
	echo "<script>alert('Только авторизованные пользователи могут просматривать статьи');
			window.location.href=\"".$_SESSION['url']."\";


	</script>";
	exit();
}

$id = $_GET['id'];
$bean = R::load('articles',$id);
		$title = $bean['title'];
		$description = $bean['description'];
		$code = $bean['code'];
		$imgurl = $bean['imgurl'];
		$author_id = $bean['author_id']	;
		$authorBean = R::load('users',$author_id);
		$author = $authorBean['name'].' ('.$authorBean['login'].')';

		$bean_rate = R::getAll('SELECT `star` FROM `rate` WHERE `id_article` = ?',array($id));
		$rate = 0;
		$count = 0;
		foreach ($bean_rate as $datarate) {
				$datarate = intval($datarate['star']);
				$rate += $datarate;
				$count++;
			}

		if ($count != 0){$rate = ($rate/$count)*20;}
	
		$_SESSION['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<?php require '../blocks/head.php'; ?>
	<meta charset="UTF-8">
	<title><?php echo $title; ?> </title>
	<link rel="stylesheet" href="../stylesheet/watch.css">
	<link rel="stylesheet" href="../stylesheet/rate.css">
	<script>
		function delCom(comId) {
			var	id = encodeURIComponent(comId);
			window.location.href='http://factorio-draft.ru/limb/deleteComment.php?id='+id;
		}
		function EditCom(comId) {
			$('#'+comId).css('display','block');
			$('.'+comId).css('display','none');

		}
	</script>
</head>
<body>
	<div class="wrapper">
		<header>
		<?php require '../blocks/header.php'; ?>
		</header>
		<main>
			<article>
			<?php 
			echo "
				<section>
				$description
				<div><p>Автор: $author</p></div>
				<div id=\"code\" style=\"visibility: hidden;\">$code</div>
				</section>
				<img src=\"../planImg/$imgurl\">
				";
				if (($_SESSION['logged_user']['id'] == $author_id)||($_SESSION['logged_user']['id'] == 0)) {
					echo "<a href=\"editor.php\">Редактировать</a>";
				}
					$_SESSION['id'] = $id;
			?>
			<button id="copy_code">Скопировать код</button>
			<?php	require '../blocks/rate.inc';?>
			</article>
			<article class="comment">
				<h1>Коментарии</h1>
				<section>
					<form method="POST" action="watch.php?id=<?php echo $_GET['id'] ?>">
						<textarea type="text" name="comment" required placeholder="Введите ваш коментарий..."></textarea>
						<div><button onclick="alert('Коментарий добавлен');" type="submit" name="add_com">Добавить коментарий</button></div>
					</form>
						<?php  
						if (isset($_POST['add_com'])) {
							$com_bean = R::dispense('comment');
							$com_bean->text = $_POST['comment'];
							$com_bean->art_id = intval($_GET['id']);
							$com_bean->user_id = $_SESSION['logged_user']['id'];
							R::store($com_bean);
							}
						?>
				</section>
			</article>
				<?php  
				$arrComId = R::getCol('SELECT `id` FROM `comment` WHERE `art_id` = ?',array($_GET['id']));
				foreach ($arrComId as $comId) {
					$comment = R::load('comment',$comId)['text'];
					$userId = R::load('comment',$comId)['user_id'];
					$user = R::load('users',$userId)['login'];
					echo "<article class=\"comment\"><section><h3>$user: </h3><p>$comment</p></section>";
					if (isset($_SESSION['logged_user'])&&(($_SESSION['logged_user']['id'] == 0)||($_SESSION['logged_user']['id'] == $userId))) {
						echo "<form id=\"$comId\"style=\"display: none;\" method=\"POST\"action=\"../limb/comEdit.php\">
								<textarea style=\"width:500px;height:100px;resize:none;\" name=\"text\">$comment</textarea>
								<input style=\"display:none;\" value=\"".$comId."\">
								<button type=\"submit\">Редактировать</button>
							</form>";
						echo "<button onclick=\"delCom($comId);\">Удалить коментарий</button>";
						echo "<button class=\"$comId\" style=\"display:block;\"onclick=\"EditCom($comId);\">Редактировать коментарий</button>";
					}
					echo "</article>";
				}

				?>
		</main>
	
		<footer>
			<?php require '../blocks/footer.php'; ?>
		</footer>

	</div>
</body>
<script type="text/javascript">
	var button = document.getElementById('copy_code');
button.addEventListener('click', function () {
  //нашли наш контейнер
  var ta = document.getElementById('code'); 
  //производим его выделение
  var range = document.createRange();
  range.selectNode(ta); 
  window.getSelection().addRange(range); 
 
  //пытаемся скопировать текст в буфер обмена
  try { 
    document.execCommand('copy'); 
  } catch(err) { 
    console.log('Can`t copy, boss'); 
  } 
  //очистим выделение текста, чтобы пользователь "не парился"
  window.getSelection().removeAllRanges();
});
var button = document.getElementById('copy_code');
button.addEventListener('click', function () {
  //нашли наш контейнер
  var ta = document.getElementById('code'); 
  //производим его выделение
  var range = document.createRange();
  range.selectNode(ta); 
  window.getSelection().addRange(range); 
 
  //пытаемся скопировать текст в буфер обмена
  try { 
    document.execCommand('copy'); 
  } catch(err) { 
    console.log('Can`t copy, boss'); 
  } 
  //очистим выделение текста, чтобы пользователь "не парился"
  window.getSelection().removeAllRanges();
alert('Код успешно скопирован');
});
</script>
</html>