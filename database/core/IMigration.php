<?php

namespace database\core;

interface  IMigration
{
	/**
	 * Run the migration
	 * @return void
	 */
	public function up(): void;

	/**
	 * Reverse the migration
	 * @return void
	 */
	public function down(): void;
}