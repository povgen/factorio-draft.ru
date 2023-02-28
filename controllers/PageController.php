<?php

class PageController
{
	 public function showIndexPage ($data): void
	 {
		 $response_message = '';
		 $errors = [];

		 // Регистрация (начало кода)
		 if (isset($data['do_signup'])) { // Считываем нажатие кнопки
			 if (trim($data['name']) == '') { // проверка: поле пусто (имя)
				 $errors['name'] = 'Укажите имя';
			 } elseif (strlen($data['name']) < 2) {
				 $errors['name'] = 'Слишком короткое имя';
			 }
			 if (trim($data['login']) == '') {// проверка: поле пусто (логин)
				 $errors['login'] = 'Укажите логин';
			 } elseif (R::count('users', "login = ?", [$data['login']]) > 0) {
				 $errors['login'] = 'Пользователь с данным логином уже зарегистрирован, придумайте другой логин.';
			 } elseif ((strlen($data['login']) < 4) && !preg_match('/^[A-Za-z0-9_-]+$/', $data['login'])) {
				 $errors['login'] = 'Логин может содержать только буквы латинского алфавита, цифры, знак подчёркивание или тире (A-Z,a-z,0-9,"_","-"), логин должен содержать 4 и более символа';
			 }

			 if ($data['password'] == '') {// проверка: поле пусто (1-пароль)
				 $errors['password'] = 'Введите пароль';
			 } elseif (strlen($data['password']) < 8) {
				 $errors['password'] = 'Пароль должен состоять из 8 и более символов.';
			 }

			 if ($data['password'] != $data['repeat']) { // проверка: совпадают ли пароли (2-пароль)
				 $errors['repeat'] = 'Повтор пароля не совпадает с основным';
			 }

			 if (empty($errors)) { //регистрируем ...
				 $user = R::dispense('users');
				 $user->name = $data['name'];
				 $user->login = $data['login'];
				 $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
				 R::store($user);
				 $response_message = 'Вы успешно зарегистрировались.';
				 $_SESSION['logged_user'] = $user;
			 } else {
				 $response_message = 'Ошибка, проверьте правильность введенных данных';
			 }
		 }// регистрация (конец кода)
		 if (isset($data['do_login'])) {// авторизация (начало кода)
			 $user = R::findOne('users', 'login = ?', array($data['login']));// поиск пользователя и присвоение строки массиву user

			 if ($user) {// проверка наличия пользователя
				 if (password_verify($data['password'], $user->password)) {
					 $_SESSION['logged_user'] = $user; // авторизуем
					 $response_message = 'Вы авторизованны.';
				 } else {
					 $response_message = 'Ошибка';
					 $errors['password'] = 'Пароль введён не верно';
				 }
			 } else {
				 $response_message = 'Ошибка';
				 $errors['login'] = 'Пользователь с таким логином не найден, пожалуйста зарегистрируйтесь.';
			 }

		 }// авторизация (конец кода)

		echo View::render('index', [
			'articles'  		   => Article::get(),
			'form_sign_in_up_data' => [
				'data'				=> $data,
				'errors'			=> $errors,
				'response_message'	=> $response_message
			]
		], false);
	 }
	 public function showAdminPage (): void
	 {
		 require '../pages/admin.php';
	 }
	 public function showCabinetPage (): void
	 {
		 require '../pages/cabinet.php';
	 }
	 public function showLibraryPage (): void
	 {
		 require '../pages/library.php';
	 }
}