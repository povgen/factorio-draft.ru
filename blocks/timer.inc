<?php 
$const = 1510570031;
$siteAge = array();
$seconds =  time() - $const;
$siteAge['day'] = intval($seconds/86400);
$seconds %= 86400;
$siteAge['hours'] = intval($seconds/3600);
$seconds %= 3600;
$siteAge['minutes'] = intval($seconds/60);
$siteAge['seconds'] = $seconds%60;

	$name = array();
if (($siteAge['seconds']%10 == 1)&&(intval($siteAge['seconds']/10) != 1)   ) {
	$name['seconds'] = 'секунда';
} elseif ((intval($siteAge['seconds']/10) == 1)||(($siteAge['seconds']%10 > 4)||($siteAge['seconds']%10 == 0) )) {
	$name['seconds'] = 'секунд';
} else {$name['seconds'] = 'секунды';}

if (!$siteAge['day']){ $siteAge['day'] = 0;}



if (($siteAge['minutes']%10 == 1)&&(intval($siteAge['minutes']/10) != 1)   ) {
	$name['minutes'] = 'минута';
} elseif ((intval($siteAge['minutes']/10) == 1)||(($siteAge['minutes']%10 > 4)||($siteAge['minutes']%10 == 0) )) {
	$name['minutes'] = 'минут';
} else {$name['minutes'] = 'минуты';}

if (($siteAge['hours']%10 == 1)&&(intval($siteAge['hours']/10) != 1)   ) {
	$name['hours'] = 'час';
} elseif ((intval($siteAge['hours']/10) == 1)||(($siteAge['hours']%10 > 4)||($siteAge['hours']%10 == 0) )) {
	$name['hours'] = 'часов';
} else {$name['hours'] = 'часа';}

if (($siteAge['day']%10 == 1)&&(intval($siteAge['day']/10) != 1)&&!(($siteAge['day'] % 100) == 11)   ) {
	$name['day'] = 'день';
} elseif ((($siteAge['day'] % 100) == 11)||(intval($siteAge['day']/10) == 1)||(($siteAge['day']%10 > 4)||($siteAge['day']%10 == 0) )) {
	$name['day'] = 'дней';
} else {$name['day'] = 'дня';}











echo '<p class="siteAge">Сайту уже: '.$siteAge['day'].' '.$name['day'].' '.$siteAge['hours'].' '.$name['hours'].' '.$siteAge['minutes'].' '.$name['minutes'].' и '.$siteAge['seconds'].' '.$name['seconds'].'</p>';
 ?>
<script>
	$(document).ready(function(){

	var siteAge ={};
	var name ={};
	<?php 
	echo "siteAge['day'] =".$siteAge['day'].";\n";
	echo "siteAge['hours'] =".$siteAge['hours'].";\n";
	echo "siteAge['minutes'] =".$siteAge['minutes'].";\n";
	echo "siteAge['seconds'] =".$siteAge['seconds'].";\n";
	?>
	function timer() {
		siteAge['seconds']++;
		if (siteAge['seconds'] == 60) {
			siteAge['seconds'] = 0;
			siteAge['minutes']++;
			if (siteAge['minutes'] == 60){
				siteAge['minutes'] = 0;
				siteAge['hours']++;
				if (siteAge['hours'] == 24) {
					siteAge['hours'] = 0;
					siteAge['day']++;
				}
			}
		}
		if ((siteAge['seconds']%10 == 1)&&(Math.floor(siteAge['seconds']/10) != 1)   ) {
			name['seconds'] = ' секунда ';
		} else if ((Math.floor(siteAge['seconds']/10) == 1)||((siteAge['seconds']%10 > 4)||(siteAge['seconds']%10 == 0) )) {
			name['seconds'] = ' секунд ';
		} else {name['seconds'] = ' секунды ';}

		if (!siteAge['day']){ siteAge['day'] = 0;}



		if ((siteAge['minutes']%10 == 1)&&(Math.floor(siteAge['minutes']/10) != 1)   ) {
			name['minutes'] = ' минута ';
		} else if ((Math.floor(siteAge['minutes']/10) == 1)||((siteAge['minutes']%10 > 4)||(siteAge['minutes']%10 == 0) )) {
			name['minutes'] = ' минут ';
		} else {name['minutes'] = ' минуты ';}

		if ((siteAge['hours']%10 == 1)&&(Math.floor(siteAge['hours']/10) != 1)   ) {
			name['hours'] = ' час ';
		} else if ((Math.floor(siteAge['hours']/10) == 1)||((siteAge['hours']%10 > 4)||(siteAge['hours']%10 == 0) )) {
			name['hours'] = ' часов ';
		} else {name['hours'] = ' часа ';}

		if ((siteAge['day']%10 == 1)&&(Math.floor(siteAge['day']/10) != 1)&&(siteAge['day']%100 !=11)   ) {
			name['day'] = ' день ';
		} else if ((Math.floor(siteAge['day']/10) == 1)||((siteAge['day']%10 > 4)||(siteAge['day']%10 == 0) )||(siteAge['day']%100 ==11)) {
			name['day'] = ' дней ';
		} else {name['day'] = ' дня ';}
		$(".siteAge").html('Сайту уже: ' + siteAge['day'] + name['day'] + siteAge['hours'] + name['hours'] + siteAge['minutes'] + name ['minutes'] + "и " + siteAge['seconds'] + name['seconds']);
		return false;
	}
var id = setInterval(function(){timer()}, 1000);


	} );
</script>