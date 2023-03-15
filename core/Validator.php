<?php

class Rule
{
	public static function min($val, &$msg, $param, $requestData): bool
	{
		$msg = 'Должно быть не меньше '.$param.' символов(а)';
		return mb_strlen($val) >= (int)$param;
	}

	public static function max($val, &$msg, $param, $requestData): bool
	{
		$msg = 'Превышено допустимое кол-во символов - '.$param;
		return mb_strlen($val) <= (int)$param;
	}

	public static function login($val, &$msg, $param, $requestedData): bool
	{
		$msg = 'Допустимы только буквы латинского алфавита, а так же цифры знак тире и нижнее подчёркивание';
		if (!preg_match('/^[A-Za-z0-9_-]+$/', $val)) return false;

		$msg = 'Пользователь с данным логином уже зарегистрирован, придумайте другой логин.';
		return R::count('users', "login = ?", [$val]) == 0;
	}
}

class Validator
{

	/** @var array Список системных правил */
	private static array $system_rules = [
		'required',
		'not_trim'
	];

	/**
	 * Получает на вход правило, возвращает callback этого правила, и параметр
	 * @param $rule - само правило
	 * @param $params - извлеченный параметр правила
	 * @return callable
	 */
	private static function getMethodFromRule($rule, &$params): callable|array
	{
		//Если это у нас анонимный метод (и не входит в наш список методов, тем самым отсеиваем стандартные методы, типа date),
		// то тогда просто возвращаем без изменений
		if (is_callable($rule) && !method_exists(Rule::class, $rule)) return $rule;

		//
		$parts = explode(':', $rule);
		$params = $parts[1] ?? null;
		return ['Rule', $parts[0]];
	}

	/**
	 * Обработки затрагивающие все входящие данные
	 * @param $val
	 * @return string|null
	 */
	private static function valProcessing($val, $rules): string|null
	{
		if (is_string($val) && !in_array('not_trim', $rules)) $val = trim($val);
		if ($val === '') $val = null;

		return $val;
	}

	public static function validate($rules, $input, &$errors): array
	{
		$validated = [];

		// Перебираем наш массив правил
		foreach ($rules as $f_key => $f_rules) {
			$path = strExplode('.', $f_key); // Получаем массив ключей - путь до переменной в пришедших данных
			$f_val = arrayGetElement($input, $path); // Получаем значение из нашего массива

			// Если правила валидации описаны строкой, то преобразуем их в массив
			if (!is_array($f_rules)) $f_rules = strExplode('|', $f_rules);


			// Так же пропускаем массивы т.к. мы пока их не умеем обрабатывать и это вызовет ошибки
			if (is_array($f_val)) {
				$errors[$f_key] =  'ожидается строка';
				continue;
			}

			// Делаем необходимые обработки нашего значения
			$f_val = self::valProcessing($f_val, $f_rules);

			// Если значение у нас отсутствует, то проверяем, переменную на обязательность
			if (is_null($f_val))
			{
				//соответственно либо выводим, ошибку либо устанавливаем значение в null
				if (in_array('required', $f_rules)) {
					$errors[$f_key] =  'Поле обязательно для заполнения';
				} else {
					arraySetElement($validated, null, $path);
				}
				continue;
			}
			//здесь переменная присутствует

			//Убираем из общего массива правил - системные
			foreach ($f_rules as $key => $el)
				if (in_array($el, self::$system_rules, true))
					unset($f_rules[$key]);

			foreach ($f_rules as $f_rule) {
				$callback = self::getMethodFromRule($f_rule, $params);
				$msg = 'Error\'s message unset!!!'; //Сообщение об ошибке по умолчанию
				$is_valid = call_user_func_array($callback, [$f_val, &$msg, $params, $input]);
				if (!$is_valid) {
					$errors[$f_key] = $msg;
					continue 2;
				}
			}

			//если дошли до сюда, то значение корректно и мы добавляем его в обработанные данные
			arraySetElement($validated, $f_val, $path);
		}
		return $validated;
	}

}

