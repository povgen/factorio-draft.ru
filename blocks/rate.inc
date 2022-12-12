	<div style="width: 100px;" class="rate_wrap">
		<ul class="rate">
		<li style="width: <?php echo $rate ?>%;" class="current"><span class="star1"></span></li>
		<li><span class="star2"></span></li>
		<li><span class="star3"></span></li>
		<li><span class="star4"></span></li>
		<li><span class="star5"></span></li>
		</ul>
	</div>
<script>
		<?php echo "var id=".$id.";";
		if (isset($_SESSION['logged_user'])){
			$act = "window.location.href= 'http://factorio-draft.ru/pages/rate.php?star='+star;";
		} else {
			$act = "alert('Авторизуйтесь, чтобы оставить отзыв');";
		}
		?>

$('.star1').on('click',function() {
	var star = 1;
	<?php echo $act; ?>
	return false;

});
$('.star2').on('click',function() {
	var star =2;
	<?php echo $act; ?>
	return false;

});
$('.star3').on('click',function() {
	var star = 3;
	<?php echo $act; ?>
	return false;

});
$('.star4').on('click',function() {
	var star = 4;
	<?php echo $act; ?>
	return false;

});
$('.star5').on('click',function() {
	var star = 5;
	<?php echo $act; ?>
	return false;

});
	$('.rate_wrap').mouseenter(function() {
		$('.current').attr('style','width:0%;');
	}).mouseleave(function() {
		$('.current').attr('style','width:<?php echo $rate ?>%;');
	});
</script>
