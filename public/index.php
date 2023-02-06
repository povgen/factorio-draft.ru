<?php
require '../core/Route.php';
require '../controllers/PageController.php';
require '../database/db_config.php';
require '../database/core/DB.php';

Route::add('/', [PageController::class, 'showIndexPage']);
Route::add('/admin', [PageController::class, 'showAdminPage']);
Route::add('/cabinet', [PageController::class, 'showCabinetPage']);
Route::add('/library', [PageController::class, 'showLibraryPage']);
Route::add('/limb/exit.php', function () {require '../limb/exit.php'; });

Route::callMatches($_SERVER['REQUEST_URI']);

