<a href="http://factorio-draft.ru/limb/exit.php">Выход</a>

<p>Сайт был создан 10.10.2017</p>
<p>Автор Беднарский Геннадий</p>



<?php 
require 'timer.inc';
echo '<p>Зарегестрированных пользователей: '.R::count('users').'</p>';
echo '<p>Всего чертежей на сайте: '.R::count('articls').'</p>';
R::close(); 
?>

