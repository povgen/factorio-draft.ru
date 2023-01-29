<?php

class PageController
{
	 public function showIndexPage (): void
	 {
		 require '../index.php';
	 }
	 public function showAdminPage (): void
	 {
		 require '../pages/admin.php';
	 }
	 public function showCabinetPage (): void
	 {
		 require '../pages/cabinet.php';
	 }
	 public function showLibraryPage (): void
	 {
		 require '../pages/library.php';
	 }
}