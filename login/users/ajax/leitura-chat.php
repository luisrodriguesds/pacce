<?php 
require_once '../../../sistema/system-chat.php';
	if (isset($_POST['ler'])) {
		$online = $_POST['online'];
		$user = $_POST['user'];

		$up['lido'] = 1;

		$selec = DBread('msg_chat', "WHERE npacce_de = '".$user."' AND npacce_para = '".$online."'");
		if (DBUpDate('msg_chat', $up, "npacce_de = '".$user."' AND npacce_para = '".$online."'")) {
			echo 'okay';
			echo 'de: '.$user.'para: '.$online;
		}
	}

?>