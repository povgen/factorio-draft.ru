<?php

class View
{
	public static function render($view, $data): string
	{
		extract($data); 				//превращает массив в переменные, где ключ название переменной, а её содержимое соответственно - значение
		ob_start(); 						//перенаправляем вывод данных (echo/print_r/var_dump) в буфер
		include '../views/'.$view.'.php'; 	// Соответственно подключаем наш шаблон
		return ob_get_clean();  			//Возвращаем наши данные и очищаем буфер
	}

	public static function implement($layout, $data)
	{
		return self::render($layout, [
			'view' => 'index',
			'data' => $data
		]);
	}
}