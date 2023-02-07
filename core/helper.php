<?php
/**
 * @param string $text - Исходный текст
 * @param int $len - Допустима длина выходной строки
 * @param string $endSymbols - набор символов подставляемых в конце
 * @return string
 */
function cutString(string $text, int $len, string $endSymbols = '...'): string
{
	if ((mb_strlen($text) > $len)) {
		$text = substr($text, 0, $len - mb_strlen($endSymbols));
		$text = rtrim($text, '!,.-');
		$text = substr($text, 0, strrpos($text, ' ')).$endSymbols;
	}


	return $text;
}