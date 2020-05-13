<?php
	$bd = parse_ini_file("config.ini");

	//REMOTO
	//BANCO DE DADOS
	define('HOSTNAME', $bd['servidor']);
	define('USERNAME', $bd['usuario']);
	define('PASSWORD', $bd['senha']);
	define('DATABASE', $bd['banco']);
	define('PORT', $bd['porta']);
	define('PREFIX', $bd['prefix']);
	define('CHARSET', $bd['charset']);

	define('URLBASE', $bd['url']);

	//URLS
	define('URL_BASE', $bd['url'].'login/');
	define('URL_PAINEL', URL_BASE.'users/');

	//DIRS
	define('DIR_BASE', $_SERVER['DOCUMENT_ROOT'].'/pacce/');
	define('DIR_SYSTEM', DIR_BASE.'sistema/');
	define('DIR_IMG', DIR_BASE.'images/');
	define('DIR_IMG_SLIDE', DIR_BASE.'slick/images/');
	define('DIR_IMG_BOL', DIR_BASE.'login/users/imagensBolsistas/');

	//FILES
	define('FLIE_CONFIG', DIR_SYSTEM.'config.php');
	define('FLIE_HELPERS', DIR_SYSTEM.'helpers.php');
	define('FLIE_DATABASE', DIR_SYSTEM.'database.php');
	define('FILE_CONNECTION', DIR_SYSTEM.'connection.php');

?>
