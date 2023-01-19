<?php

use database\core\DB;
use database\core\IMigration;


return new class implements IMigration {

	/**
	 * Start the migration
	 *
	 * @return void
	 */
	public function up(): void
	{
		$sqls = [
			'CREATE TABLE users (
				  id 		int(11) UNSIGNED PRIMARY KEY,
				  name 		varchar(191)  DEFAULT NULL,
				  login 	varchar(191)  NOT NULL,
				  password 	varchar(191)  NOT NULL 
				)',
			'CREATE TABLE articles (
				  id 			int(11) UNSIGNED PRIMARY KEY,
				  title 		varchar(191) NOT NULL,
				  description 	varchar(191) DEFAULT \'\',
				  code 			varchar(191) NOT NULL,
				  category_id 	int(11) DEFAULT NULL,
				  author_id 	int(11) NOT NULL REFERENCES users (id),
				  imgurl 		varchar(191) DEFAULT NULL
				)',
			'CREATE TABLE comment (
				  id 		int(11) UNSIGNED PRIMARY KEY,
				  text 		text NOT NULL,
				  art_id 	int(11) UNSIGNED REFERENCES articles(id),
				  user_id 	int(11) UNSIGNED REFERENCES users(id)
				)',
			'CREATE TABLE rate (
				  id 			int(11) UNSIGNED PRIMARY KEY,
				  id_user 		int(11) UNSIGNED NOT NULL REFERENCES users(id),
				  id_article 	int(11) UNSIGNED NOT NULL REFERENCES articles(id),
				  star 			tinyint(1) UNSIGNED NOT NULL
			);'
		];

		foreach ($sqls as $sql) DB::run($sql);
	}


	/**
	 * Revers the migration
	 *
	 * @return void
	 */
	public function down(): void
	{
		DB::run('DROP TABLE IF EXISTS rate');
		DB::run('DROP TABLE IF EXISTS comment');
		DB::run('DROP TABLE IF EXISTS articles');
		DB::run('DROP TABLE IF EXISTS users');
	}
};