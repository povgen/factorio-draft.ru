<?php
namespace database\core;
require 'DB.php';
require 'IMigration.php';

class Migration
{
	public static function create($name): void
	{
		$time_spot = date('Y_m_d').'_'.(time() - strtotime('today'));
		$tmpl = file_get_contents('migrationTemplate.php');
		file_put_contents('../migrations/'.$time_spot.'_'.$name.'.php', $tmpl);
	}

	public static function getList(): array {
		self::CreateMigrationTableIfNotExist();
		$files = scandir('../migrations/');
		$files = array_filter($files, fn($el) =>  preg_match('/.*\.php/', $el));

		$performed_migrations = DB::run('SELECT * FROM migrations ORDER BY file_name');
		$migration = $performed_migrations->fetch(\PDO::FETCH_ASSOC);

		return array_map(function ($file) use (&$migration, $performed_migrations) {
			$item = ['file_name' => $file, 'date' => null, 'is_performed' => false ];

			if ($migration && $migration['file_name'] === $file) {// Если имя файла совпадает и строки ещё не закончилась
				$item['date'] = $migration['date_run'];
				$item['is_performed'] = true;
				$migration = $performed_migrations->fetch(\PDO::FETCH_ASSOC); //извлекаем следующую строку
			}

			return $item;
		}, $files);
	}

	private static function CreateMigrationTableIfNotExist(): void
	{
		DB::run("CREATE TABLE IF NOT EXISTS migrations (
    		id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    		file_name varchar(255) NOT NULL COMMENT 'name of migration\'s file',
    		date_run datetime NOT NULL DEFAULT NOW() COMMENT 'when the migration was run'
		)");
	}

	public static function migrate($file_name = false): void
	{
		$migrations = self::getList();
		if ($file_name) $migrations = array_filter($migrations, fn($el) => $el['file_name'] == $file_name); //Если указано имя, то отфильтруем оставшиеся миграции

		foreach ($migrations as $migration) {
			if (!$migration['is_performed'])
			{
				DB::startTransaction();
				try {
					(require '../migrations/'.$migration['file_name'])->up();
					echo $migration['file_name'].' is done'.PHP_EOL;
					DB::run('INSERT INTO migrations(file_name) VALUES (?)', [$migration['file_name']]);
					DB::commitTransaction();
				} catch (\Exception $e) {
					echo 'Error in '.$migration['file_name'].':'.PHP_EOL;
					echo $e->getMessage();
					DB::rollbackTransaction();
					return;
				}
			}
		}

		echo 'success: migrate completed';
	}

	public static function rollback($file_name) {
		//todo откат миграции
	}
}