<?php 
	require_once '../../../sistema/system-chat.php';

	$db = DBread('eu_eventos');

	if ($db == false) {
		echo 'vazio';
	}else{
		echo json_encode($db);
	}

?>