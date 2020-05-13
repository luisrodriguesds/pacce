<?php
	if (isset($_GET['cpf'])) {
		include '../../sistema/system.php';
		$cpf = DBread('bolsistas', "WHERE cpf = '".$_GET['cpf']."'", 'cpf');
		if ($cpf == true) {
			echo 'true';
		}else{
			echo 'false';
		}
	}

	if (isset($_POST['check_cpf'])) {
		include '../../sistema/system.php';
		$cpf = DBread('bolsistas', "WHERE cpf = '".$_POST['check_cpf']."'", 'nome, npacce');
		if ($cpf == false) {
			echo 'false';
		}else{
			$cpf = $cpf[0];
			echo json_encode( $cpf );
		}
	}