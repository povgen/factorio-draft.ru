<?php
class View
{
	private static array $parentLayoutsStack = [];
	private static string|null $currentSectionName = null;
	private static array|null $sections = [];

	private static array $directives = [
		'@extends' 		=> 'View::extends',
		'@section' 		=> 'View::section',
		'@endSection' 	=> 'View::endSection',
		'@render' 		=> 'View::render'
	];

	public static function render($view, $data, $is_only_native_php = true): string
	{
		array_unshift(self::$parentLayoutsStack, null); //добавляем в стек, то от чего наследуется текущий шаблон

		extract($data); 				//превращает массив в переменные, где ключ название переменной, а её содержимое соответственно - значение
		ob_start(); 						//перенаправляем вывод данных (echo/print_r/var_dump) в буфер

		if ($is_only_native_php) {
			include '../views/'.$view.'.php'; 	// Подключаем наш шаблон
		} else {
			$tpl = file_get_contents('../views/'.$view.'.php'); //Получаем содержимое нашего шаблона
			$tpl = self::processDirectives($tpl);

			eval('?>'.$tpl.'<?php');	// Т.к. по умолчанию eval работает с php, а не html, сделаем такую не сложную обертку, и "выполним" наш шаблон
		}
		$page = ob_get_clean();  			//Возвращаем наши данные и очищаем буфер

		$parent_layout = array_shift(self::$parentLayoutsStack); //соответственно после редеринга извлекаем
		// родителський шаблон, если он назначался в шаблоне

		//соответственно если родительский шаблон был указан, то мы его отрендерим, с секциями реализованными в текущем шаблоне
		if (!is_null($parent_layout)) { $page = self::render($parent_layout, self::$sections); }

		return $page;
	}

	public static function extends($layout): void
	{
		self::$parentLayoutsStack[0] = $layout;
	}

	public static function section($name, $content = null)
	{
		if ($content) {
			self::$sections[$name] = $content;
		} else {
			if (!is_null(self::$currentSectionName)) throw new Exception("Section ($name) already opened, you need close it, before opened new");
			self::$currentSectionName = $name;
			ob_start();
		}
	}

	public static function endSection(): void
	{
		$sect = ob_get_clean();
		self::$sections[self::$currentSectionName] = $sect;
		self::$currentSectionName = null;
	}

	private static function processDirectives($content)
	{
		foreach (self::$directives as $directive => $callback)
		{
			$content = preg_replace_callback('/' . $directive . '(\(.*\))?/', function ($matches) use ($directive, $callback) {
				return '<?php echo ' . $callback .  ($matches[1] ?? '()') . '; ?>';
			}, $content);

		}
		return $content;
	}

}
