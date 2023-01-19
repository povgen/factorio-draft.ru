<article>
				<form method="POST" enctype="multipart/form-data" action="myLibray.php">
					<div><span>Название схемы</span><input required="required" type="text" name="title"></div>
					<div><span>Категория</span>
						<select name="category">
							<?php 
							$arrid = R::getCol("SELECT `id` FROM `category`");
							foreach ($arrid as $idCat) {
								$categ = R::load('category',$idCat);
								echo'<option value="'.$idCat.'">'.$categ['name'].'</option>';}?>
						</select>
					</div>
					<div>
						<span>Описание схемы</span>
						<textarea required="required" name="description" id="" cols="30" rows="3"></textarea>
					</div>
					<div><span>Код (строка для импорта) схемы</span><input required="required" type="text" name="code"></div>
					<input name="load" style="position: absolute; width: 0%; height: 0%; overflow: hidden; z-index: -1" multiple="1" id="file" type="file" accept="image/jpeg,image/png">
					<div>
						<span style="position: relative; bottom: -16px;">Прикрепите скриншот строений</span><label for="file">Выбрать файл</label>
						<input type="submit" name="do_add" class="act">
					</div>
					<div></div>
				</form>

<?php 
// require '../limb/connect.php';
$data = $_POST;
$file = $_FILES;


if (isset($data['do_add'])) {
		$article = R::dispense('articles');
		$article->title = $data['title'];
		$article->description = $data['description'];
		$article->code = $data['code'];
		$article->category_id = $_POST['category'];
		$article->author_id = $_SESSION['logged_user']->id;
		echo '<script type="text/javascript"> alert("Чертёж добавлен.") </script>';
		$chek = R::findOne('articles','imgurl = ?',array($file['load']['name'])); //проверка на уникальность имени файла

if ($chek) {// если файл не уникален, он добавляет к началу имени файла id
	$id = 1;
	do {
		$fName = $id.$file['load']['name'];
		$id++;
		$chek_r = R::findOne('articles','imgurl = ?',array($fName));
	} while ( $chek_r);
} else {
	$fName = $file['load']['name'];
}

if (!empty($file['load']['name'])){
	move_uploaded_file($file['load']['tmp_name'], '../planImg/'.$fName);
} else{
	$fName = 'default.png'; //если изображения не добавлено ставит его по умалчанию
	
}

		$article->imgurl = $fName;
		R::store($article);
		if ($_POST['category'] == 0) {
		$id = R::getCol('SELECT `id` FROM `articles` ORDER BY `id` DESC');
			echo "<script>var answer = confirm('Хотите добавить категорию?');
				if (answer){
					var nameCat = prompt('Введите название категории');
					nameCat = encodeURIComponent(nameCat);
					var article_id = encodeURIComponent(".$id[0].");
					var user_id = encodeURIComponent(".$_SESSION['logged_user']['id'].");
					window.location.href='http://factorio-draft.ru/limb/sentGet.php?nameCat='+nameCat+'&article_id='+article_id+'&user_id='+user_id;
				}
			</script>";
		}
}
?>

</article>