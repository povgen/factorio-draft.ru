var main = function () {
	// body...

$('#reg').on('click',function() {
	// body...
	// alert('reg');
	$('#reg').attr('class','active')
	$('#avt').removeClass('active');
	$('.hide').show();
	$('.act').attr('value','Зарегестрироваться').attr('name','do_signup');
	return false;

});
$('#avt').on('click',function() {
	// body...
	// alert('avt');
	$('#avt').attr('class','active');
	$('#reg').removeClass('active');
	$('.hide').hide();
	$('.act').attr('value','Авторизоваться').attr('name','do_login');
	return false;
});
return false
}

$(document).ready(main);
