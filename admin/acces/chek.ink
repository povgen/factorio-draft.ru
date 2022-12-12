<?php 
if (!isset($_SESSION['logged_user']['id'])||(intval($_SESSION['logged_user']['id']) != 0)) {
	require '../limb/Object not found!.html';
	exit();
}
?>