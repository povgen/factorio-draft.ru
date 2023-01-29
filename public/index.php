<?php
include '../core/Route.php';
include '../controllers/PageController.php';

Route::add('/', [PageController::class, 'showIndexPage']);
Route::add('/admin', [PageController::class, 'showAdminPage']);
Route::add('/cabinet', [PageController::class, 'showCabinetPage']);
Route::add('/library', [PageController::class, 'showLibraryPage']);

Route::callMatches($_SERVER['REQUEST_URI']);

