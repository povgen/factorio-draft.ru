<?php
require '../limb/connect.php';
$id = $_SESSION['id'];
$bean = R::load('articles',$id);
$title = $bean['title'];
$description = $bean['description'];
$code = $bean['code'];
$imgurl = $bean['imgurl'];
$author_id = $bean['author_id'];
if (!isset($_SESSION['logged_user'])) {
	echo "<script>alert('Вы не авторизованы!'); window.location.href=\"".$_SESSION['url']."\"</script>"; exit();
}
if (!isset($_SESSION['id'])) { echo "<script>alert('У вас не выбран чертёж для редактирования');</script>"; exit();}
if (($_SESSION['logged_user']['id'] != $author_id)&&($_SESSION['logged_user']['id'] != 0)){ echo "<script>alert('У вас нет доступа к этому чертежу!'); window.location.href=\"".$_SESSION['url']."\"</script>"; exit();}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<?php require '../blocks/head.php'; ?>
	<meta charset="UTF-8">
	<title>Редактор:<?php echo $title; ?> </title>
</head>
<body>
	<article>
		<div class="wrap_form">
			
			<form class="clear" method="POST" enctype="multipart/form-data" action="editor.php">
				<div><span>Название схемы</span><input value="<?php echo $title ?>" required type="text" name="title"></div>
				<div>
					<span>Описание схемы</span>
					<textarea required name="description" cols="30" rows="3"><?php echo $description; ?></textarea>
				</div>
				<div><span>Код (строка для импорта) схемы</span><input required value="<?php echo $code; ?>" type="text" name="code"></div>
				<input name="load" style="position: absolute; width: 0%; height: 0%; overflow: hidden; z-index: -1" multiple="1" id="file" type="file" accept="image/jpeg,image/png">
				<div>
					<span style="position: relative; bottom: -16px;">Прикрепите скриншот строений</span><label for="file">Выбрать файл</label>
					<input type="submit" value="Сохранить" name="do_add" class="act">
				</div>
			</form>
			<button style="float: right;  margin: 5px;  width: 50%;  outline: none;" onclick="var id = encodeURIComponent('<?php echo $id ?>');
			window.location.href='http://factorio-draft.ru/limb/deleteArticle.php?id=' + id;">Удалить чертёж</button>
				<div style="clear:both;"></div>

		</div>
	</article>
</body>
<script>
	
</script>
</html>




<?php 
$data = $_POST;
$file = $_FILES;

if (isset($data['do_add'])) {
		$article = R::dispense('articles');
		$article->id = $id;
		$article->title = $data['title'];
		$article->description = $data['description'];
		$article->code = $data['code'];
		$article->author = $author;
		echo '<script type="text/javascript"> alert("Чертёж обновлён.") </script>';
		$chek = R::findOne('articles','imgurl = ?',array($file['load']['name'])); //проверка на уникальность имени файла

if ($chek) {// если файл не уникален, он добавляет к началу имени файла id
	$id = 1;
	do {
		$fName = $i.$file['load']['name'];	
		$i++;
		$chek_r = R::findOne('articles','imgurl = ?',array($fName));
	} while ( $chek_r);
} else {
	$fName = $file['load']['name'];
}

if (!empty($file['load']['name'])){
	move_uploaded_file($file['load']['tmp_name'], '../planImg/'.$fName);
		$article->imgurl = $fName;
} 

		R::store($article);
echo '<script>window.location.href = "http://factorio-draft.ru/pages/watch.php?id='.$id.'"</script>'; 
unset($_SESSION['id']);
}


?>