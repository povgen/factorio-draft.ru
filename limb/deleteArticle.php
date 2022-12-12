<?php  
require '../limb/connect.php';
$author_id = R::getCol('SELECT `author_id` FROM `articls` WHERE `id` = ?',array($_GET['id']))['0'];
var_dump($author_id);
if (!isset($_GET['id'])) { echo "<script>alert('У вас не выбран чертёж для удаления');</script>"; exit();}
if (!isset($_SESSION['logged_user'])) {
	echo "<script>alert('Вы не авторизованы!'); window.location.href=\"".$_SESSION['url']."\"</script>"; exit();
}
if (($_SESSION['logged_user']['id'] != $author_id)&&($_SESSION['logged_user']['id'] != 0)){ echo "<script>alert('Вы можете удалять только свои чертежи!'); window.location.href=\"".$_SESSION['url']."\"</script>"; exit();}
R::exec('DELETE FROM `articls` WHERE `id` = ?',array($_GET['id']));
?>
<script>
	alert('Чертёж удалён.');
	window.location.href="<?php echo $_SESSION['url']; ?>";
</script>
