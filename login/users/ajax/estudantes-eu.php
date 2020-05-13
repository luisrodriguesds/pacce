<?php 
	require_once '../../../sistema/system-chat.php';

	//busca estudante
	if (isset($_POST['matricula'])) {
		$mat = $_POST['matricula'];
		$estudantes = DBread('eu_participantes', "WHERE matricula LIKE '%$mat%' LIMIT 1");

		if ($estudantes == false) {
			echo 'vazio';
		}else{

			echo utf8_encode(json_encode($estudantes));	
		}
	}


	//Presenca do Estudante
	if (isset($_POST['mat']) && isset($_POST['cod'])) {

		$form['codigo'] 	= $_POST['cod'];
		$form['matricula']	= $_POST['mat'];
		$form['nome'] 		= $_POST['nome'];
		$form['curso']		= $_POST['curso'];
		$form['entrada']	= $_POST['inicio'];
		$form['saida']		= $_POST['fim'];
		$form['tipo']		= 'Estudante';
		$form['status']		= 1;
		$form['registro']	= date('Y-m-d H:i:s');

		$form = DBescape($form);

		$check = DBread('eu_eventos_pres', "WHERE codigo = '".$form['codigo']."' AND matricula = '".$form['matricula']."'");
		if ($check ==true) {
			echo 'error2';
		}else{
			if (DBcreate('eu_eventos_pres', $form)) {
				echo 'success';
			}else{
				echo 'error';
			}
		}
	}
?>