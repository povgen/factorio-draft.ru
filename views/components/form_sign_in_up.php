<article>
	<section class="desc_form">
		<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
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
		<form method="POST" action="/" align="middle">
			<div class="hide">
				<label for="name">Ваше имя</label>
				<input type="text" name="name" id="name" value="<?= $data['name'] ?? '' ?>">
			</div>
			<div>
				<label for="login">Ваш логин</label>
				<input type="text" name="login" id="login" value="<?= $data['login'] ?? '' ?>">
			</div>
			<div>
				<label for="password">Ваш пароль</label>
				<input type="password" name="password" id="password" value="">
            </div>
			<div class="hide">
				<label for="repeat">Повтор пароля</label>
				<input type="password" name="repeat" id="repeat" value="">
			</div>
			<input type="submit" name="do_signup" value="Зарегистрироваться" class="act">
            <div class="clear-fix"></div>
	</form>
</article>
<?php if (isset($data['do_signup']) || (isset($data['do_login']))) : ?>
<script>
    const errors = JSON.parse('<?= json_encode($errors) ?>');
	const message = '<?= $response_message ?>';
	const field_names = {
	    'name'      : 'Имя',
	    'login'     : 'Логин',
	    'password'  : 'Пароль',
	    'repeat'    : 'Повтор пароля'
    };
	let alert_str = '';
    for (let field in errors) {
		$('#'+field).addClass('border-red');
		alert_str += '\n' + field_names[field]+ ' - ' + errors[field];
	}
	alert(message + alert_str);
</script>
<?php endif; ?>