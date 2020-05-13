<?php
	if (isset($_POST['mensagem'])) {
		require_once '../../../sistema/system-chat.php';

		$form['mensagem'] 	= strip_tags(trim($_POST['mensagem']));
		$form['npacce_de']	= $_POST['de'];
		$form['npacce_para']= $_POST['para'];
		$form['time']		= time();
		$form['lido']		= 0;

		if (!empty($form['mensagem'])) {
			if (DBcreate('msg_chat', $form)) {
				echo 'okay';
			}else{
				echo 'no';
			}
		}
	}
?>
