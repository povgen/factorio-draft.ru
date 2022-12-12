
<article>
	<section class="desc_form">
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>
	</section>
		<form action="">
			<button id="reg" class="active">Регистрация</button> 
			<button id="avt">Авторизация</button>
		</form>
			
<?php // Регистрация (начало кода)
$data = $_POST;



if( isset($data['do_signup'] ) ) { // Считываем нажати кнопки 


	$errors = array();
	
	
	if(trim($data['name']) == '' ) { $errors[0] = true;} // проверка: поле пусто (имя)
	// elseif (!preg_match("#^[А-Яа-я]+$#", $data['name'])){
	// $errors[6] = true;
	// echo '<script type="text/javascript"> alert("Используйте в имени только русские буквы (А-Я,	а-я)")</script>';
	// }
	 elseif (strlen($data['name'])<2){$errors[6] = true;
		echo '<script type="text/javascript"> alert("Слишко короткое имя")</script>';
	}

	if(trim($data['login']) == '') { $errors[1] = true; } // проверка: поле пусто (логин)
	elseif (R::count('users',"login = ?",array($data['login'])) > 0) { $errors[4] = true;
		echo '<script type="text/javascript"> alert("Пользователь с данным логином уже зарегистрирован, придумайте другой логин.")</script>';}
		elseif ((strlen($data['login']) < 4)&&!preg_match("#^[A-Za-z0-9_-]+$#", $data['login'])){
	$errors[5] = true;
	echo '<script type="text/javascript"> alert("Логин может содержать только буквы латинского алфавита, цифры, знак подчёркивание или тире (A-Z,a-z,0-9,\"_\",\"-\"), логин должен содержать 4 и более сиимвола")</script>';
	}

	if($data['password'] == '') { $errors[2] = true;}// проверка: поле пусто (1-пароль)
	elseif(strlen($data['password']) < 8) { $errors[6] = true; echo '<script type="text/javascript"> alert("Пароль должен состоять из 8 и более символов.")</script>';}	

	if($data['password'] != $data['repeat']) { $errors[3] =  true;}// проверка: совпадают ли пароли (2-пароль)



	
	if( empty($errors)) {
		//регестрируем ... 
		$user = R::dispense('users');
		$user->name = $data['name'];
		$user->login = $data['login'];
		$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
		R::store($user);
		echo '<script type="text/javascript"> alert("Вы успешно зарегестрировались.") </script>';
		$_SESSION['logged_user'] = $user;
		echo '<script>window.location.href = "'.$_SESSION['url'].'"</script>'; //Обнвление страницы


	}
}// регистрация (конец кода)
 
if( isset($data['do_login']) ) {// авторизация (начало кода)
	$errors = array();
	$user = R::findOne('users','login = ?', array($data['login']));// поиск пользователя и присвоение строки массиву user

	if ($user) {// проверка наличия пользователя
		if ( password_verify($data['password'], $user->password)) {
			// авторизуем
			$_SESSION['logged_user'] = $user;
			echo '<script type="text/javascript"> alert("Вы авторизованны.") </script>';
		echo '<script>window.location.href = "'.$_SESSION['url'].'"</script>'; //Обнвление страницы
		} else {
			$errors[2] = true;
			echo '<script type="text/javascript"> alert("Пароль введён не верно") </script>';// неправильный пароль
		}

	} else {
		$errors[1] = true;
		echo '<script type="text/javascript"> alert("Пользователь с таким логином не найден, пожалуйста зарегистрируйтесь.") </script>'; //пользователь не найден
	}

}// авторизация (конец кода)

?>

		<form method="POST" action="
		<?php echo $_COOKIE['url'] ?>
		" align="middle"/>

			<div class="hide">
				<span>Ваше имя</span>
				<input style="
					<?php 
						if ( $errors[0]||$errors[5]) {echo "border:1px solid red;";} // Выделение пустого поля (имя)
					?> "
				type="text" name="name" value="<?php echo @$data['name'] ?>"
				>
			</div>
			<div>
				<span>Ваш логин</span>
				<input style="
					<?php 
						if ( $errors[1]||$errors[4]) {echo  "border:1px solid red;";} // Выделение пустого поля (логин)
					?> "
				type="text" name="login" value="<?php echo @$data['login'] ?>"
				>
			</div>
			<div>
				<span>Ваш пароль</span>
				<input style="
					<?php 
						if ( $errors[2]||$errors[3]) {echo "border:1px solid red;";} // Выделение пустого поля (1-пароль)
						if ( $errors[6]){echo "border:1px solid red;";}
					?>" 
				type="password" name="password" value=""></div>
			<div class="hide">
				<span>Повтор пароля</span>
				<input style="
					<?php 
						if ( !$errors[2]&&$errors[3]) {echo "border:1px solid red;";} // Выделение несовподения (2-Пароль)
						if ( $errors[6]){echo "border:1px solid red;";}
					?> "
				type="password" name="repeat" value="">
			</div>
			<script type="text/javascript">
				
				<?php 
					if ( !$errors[2]&&$errors[3])  { echo "alert('Пароли не совпадают!')";}
				?>
			</script>
			<input type="submit" name="do_signup" value="Зарегестрироваться" class="act"> <!-- кнопка регистрации -->
			<div></div>
	</form>
</article>