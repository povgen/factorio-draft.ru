<?php

class PageController
{
	 public function showIndexPage ($data): void
	 {
		 $response_message = '';
		 $errors = [];

		 if (isset($data['do_signup'])) { // Считываем нажатие кнопки

			 // Валидация
			 $validated = Validator::validate([
				 'name'  		=> 'required|min:2|max:64',
				 'login' 		=> 'required|min:2|max:64|login',
				 'password' 	=> 'required|min:8|max:16|not_trim',
				 'repeat' 		=> [
					 'required',
					 'not_trim',
					 function ($val, &$msg, $param, $requestData) {
						 $msg = 'Пароли должны совпадать';
						 return $requestData['password'] === $val;
					 }
				 ]
			 ], $data, $errors);

			 if (empty($errors)) { //регистрируем ...
				 $user = R::dispense('users');
				 $user->name = $validated['name'];
				 $user->login = $validated['login'];
				 $user->password = password_hash($validated['password'], PASSWORD_DEFAULT);
				 R::store($user);
				 $response_message = 'Вы успешно зарегистрировались.';
				 $_SESSION['logged_user'] = $user;
			 } else {
				 $response_message = 'Ошибка, проверьте правильность введенных данных';
			 }
		 }// регистрация (конец кода)
		 if (isset($data['do_login'])) {// авторизация (начало кода)

			 // поиск пользователя и присвоение строки массиву user
			 $user = R::findOne('users', 'login = ?', array($data['login']));

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