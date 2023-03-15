<?php
/**
 * @param string $text - Исходный текст
 * @param int $len - Допустима длина выходной строки
 * @param string $endSymbols - набор символов подставляемых в конце
 * @return string
 */
function strCut(string $text, int $len, string $endSymbols = '...'): string
{
	if ((mb_strlen($text) > $len)) {
		$text = substr($text, 0, $len - mb_strlen($endSymbols));
		$text = rtrim($text, '!,.-');
		$text = substr($text, 0, strrpos($text, ' ')).$endSymbols;
	}


	return $text;
}
function d($var): void {
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}

function dd($var): void {
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
	die();
}

/**
 * Разделяет строку по разделителю, с возможностью экранирования разделителя в исходной строке
 * @param string $string - исходная строка
 * @param string $separator - строка разделитель
 * @return array
 */
function strExplode(string $separator, string $string): array
{
	//Экранируем спец символы, используемые в регулярных вырождениях (напр. '.')
	$d = preg_quote($separator, '/');

	//разделяем по "разделителю", с игнорированием экранированного разделителя
	$parts = preg_split('/(?<![^\\\\]\\\\)'.$d.'/', $string);

	//обходим полученные строки, убирая обратный слэш и возвращая порченый результат
	return array_map(fn($el) => str_replace('\\'.$separator, $separator, $el), $parts);
}

/**
 * Получает ссылку на вложенный элемент массива,
 * если элемент или ключ отсутствует, то он будет проинициализирован, со значением null
 * @param $array - многомерный массив, дынных
 * @param $path - путь до элемента
 * @return mixed
 */
function arrayGetElement(&$array, $path)
{
	$key = array_shift($path);
	return $key ? arrayGetElement($array[$key], $path) : $array;
}

/**
 * Устанавливает в массив значение по вложенному ключу
 * @param $array - исходный массив
 * @param $val - значение
 * @param $path - путь до элемента
 * @return void
 */
function arraySetElement(&$array, $val, $path): void {
	$key = array_shift($path);

	if ($key) {
		arraySetElement($array[$key], $val, $path);
	} else  {
		$array = $val;
	}
}