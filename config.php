<?php

	//LOCAL=========================
	//BANCO DE DADOS
	define('HOSTNAME', 'localhost:3307');
	define('USERNAME', 'root');
	define('PASSWORD', '');
	define('DATABASE', 'pacce');
	define('PREFIX', 'ac');
	define('CHARSET', 'utf8');

	define('URLBASE', 'http://localhost/pacce2/');

	//URLS
	define('URL_BASE', 'http://localhost/pacce2/login/');
	define('URL_PAINEL', URL_BASE.'users/');

	//DIRS
	define('DIR_BASE', $_SERVER['DOCUMENT_ROOT'].'/pacce2/');
	define('DIR_SYSTEM', DIR_BASE.'sistema/');
	define('DIR_IMG', DIR_BASE.'images/');
	define('DIR_IMG_BOL', DIR_BASE.'login/users/imagensBolsistas/');

	//FILES
	define('FLIE_CONFIG', DIR_SYSTEM.'config.php');
	define('FLIE_HELPERS', DIR_SYSTEM.'helpers.php');
	define('FLIE_DATABASE', DIR_SYSTEM.'database.php');
	define('FILE_CONNECTION', DIR_SYSTEM.'connection.php');
		
	
	
	// //REMOTO
	// //BANCO DE DADOS
	// define('HOSTNAME', '127.0.0.1');
	// define('USERNAME', 'root');
	// define('PASSWORD', 'pacce@bd');
	// define('DATABASE', 'u164494923_pacce');
	// define('PREFIX', 'ac');
	// define('CHARSET', 'utf8');

	// define('URLBASE', 'http://www.pacce.ufc.br/pacce/');

	// //URLS
	// define('URL_BASE', 'http://www.pacce.ufc.br/pacce/login/');
	// define('URL_PAINEL', URL_BASE.'users/');

	// //DIRS
	// define('DIR_BASE', '/var/www/html/pacce/');
	// define('DIR_SYSTEM', DIR_BASE.'sistema/');
	// define('DIR_IMG', DIR_BASE.'images/');
	// define('DIR_IMG_BOL', DIR_BASE.'login/users/imagensBolsistas/');

	// //FILES
	// define('FLIE_CONFIG', DIR_SYSTEM.'config.php');
	// define('FLIE_HELPERS', DIR_SYSTEM.'helpers.php');
	// define('FLIE_DATABASE', DIR_SYSTEM.'database.php');
	// define('FILE_CONNECTION', DIR_SYSTEM.'connection.php');
	
	// DADOS DO BANCO ATUAL - REMOTO

	// define('HOSTNAME', 'srvdbm.ufc.br');
	// define('USERNAME', 'pacce_usr');
	// define('PASSWORD', '5pNjv:Yq3N+2');
	// define('DATABASE', 'pacce');
	// define('PORT', '32306');
	// define('PREFIX', 'ac');
	// define('CHARSET', 'utf8');

	// define('URLBASE', 'http://www.pacce.ufc.br/pacce/');

	// //URLS
	// define('URL_BASE', 'http://www.pacce.ufc.br/pacce/login/');
	// define('URL_PAINEL', URL_BASE.'users/');

	// //DIRS
	// define('DIR_BASE', $_SERVER['DOCUMENT_ROOT'].'/pacce/');
	// define('DIR_SYSTEM', DIR_BASE.'sistema/');
	// define('DIR_IMG', DIR_BASE.'images/');
	// define('DIR_IMG_SLIDE', DIR_BASE.'slick/images/');
	// define('DIR_IMG_BOL', DIR_BASE.'login/users/imagensBolsistas/');

	// //FILES
	// define('FLIE_CONFIG', DIR_SYSTEM.'config.php');
	// define('FLIE_HELPERS', DIR_SYSTEM.'helpers.php');
	// define('FLIE_DATABASE', DIR_SYSTEM.'database.php');
	// define('FILE_CONNECTION', DIR_SYSTEM.'connection.php');
	
?>
