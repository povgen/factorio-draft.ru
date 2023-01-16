<?php

namespace database\core;

use PDO;
use PDOStatement;

require '../db_config.php';

class DB
{
	/** @var PDO */
	private static $pdo = false;

	private static function initConnection(): void
	{
		// $dsn='mysql:dbname=testdb;host=127.0.0.1'
		self::$pdo = new PDO(DB_CONNECTION.':'
			.'dbname='.DB_DATABASE
			.';host='.DB_HOST,
			DB_USERNAME,
			DB_PASSWORD);
	}

	/**
	 * @param $sql
	 * @param array $params
	 * @return false|PDOStatement
	 */
	static function run($sql, array $params = []): false|PDOStatement
	{
		if(!self::$pdo) self::initConnection();
		$stm = self::$pdo->prepare($sql);
		$stm->execute($params);
		return $stm;
	}

	static function startTransaction() :void
	{
		self::run('START TRANSACTION');
	}

	static function commitTransaction() :void
	{
		self::run('COMMIT');
	}

	static function rollbackTransaction() :void
	{
		self::run('ROLLBACK');
	}
}