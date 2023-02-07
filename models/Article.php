<?php

use database\core\DB;

class Article
{
	public static function get($id = null): object|array
	{
		$sql = "SELECT a.*,
       				   u.name | ' (' | u.login | ')' AS author,
       				   (SELECT AVG(star) FROM factorio.rate) AS rate
				  FROM articles AS a
					   LEFT JOIN users u 
					   ON a.author_id = u.id";
		$args = [];

		if ($id) {
			$sql .= ' WHERE id = ?';
			$args[] = $id;
		}

		$res = DB::run($sql, $args);
		return $id ? $res->fetch(PDO::FETCH_OBJ) : $res->fetchAll(PDO::FETCH_OBJ);
		// конструкция
		// $cond ? if_true : if_false
		// называется тернарным оператором
	}
}