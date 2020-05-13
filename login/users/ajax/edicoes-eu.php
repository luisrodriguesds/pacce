<?php 
	require_once '../../../sistema/system-chat.php';

	//Muda o status da presenca
	if (isset($_POST['codigo'])) {
		$check = DBread('eu_eventos', "WHERE codigo = '".$_POST['codigo']."' LIMIT 1");
		if ($check == false) {
			echo 'error';
		}else{
			if ($check[0]['presenca'] == 0) {
				$form['presenca'] = 1;
				if (DBUpDate('eu_eventos', $form, "codigo = '".$_POST['codigo']."'")) {
					echo 'success1';
				}
			}else{
				$form['presenca'] = 0;
				if (DBUpDate('eu_eventos', $form, "codigo = '".$_POST['codigo']."'")) {
					echo 'success0';
				}
			}
		}
	}

	//verifica status presenca
	if (isset($_POST['cod'])) {
		$check = DBread('eu_eventos', "WHERE codigo = '".$_POST['cod']."' LIMIT 1");
		if ($check == false) {
			echo 'error';
		}else{
			$check = $check[0];
			if ($check['presenca'] == 0) {
				echo 'off';
			}else{
				echo 'on';
			}
		}
	}

	if (isset($_POST['matricula'])) {
		$form['matricula'] 	= $_POST['matricula'];
		$form['nome'] 		= $_POST['nome'];
		$form['curso'] 		= $_POST['curso'];
		$form['email'] 		= $_POST['email'];
		$form['status']		= 1;
		$form['tipo']		= 'Estudantes';
		$form['registro']	= date('Y-m-d H:i:s');
		$check = DBread("eu_participantes", "WHERE matricula = '".$form['matricula']."'");
		if ($check == false) {
			echo 'error1';
		}else{
			if (DBcreate('eu_participantes', $form)) {
				echo 'success';
			}else{
				echo 'error2';
			}
		}
	}
?>