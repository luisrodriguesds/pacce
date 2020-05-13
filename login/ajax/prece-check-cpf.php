<?php
if (isset($_GET['cpf'])) {
		include '../../sistema/system.php';
		$cpf = DBread('bolsistas', "WHERE cpf = '".$_GET['cpf']."'", 'npacce, cpf');
		if ($cpf == false) {
			echo 'true';
		}else{
			echo 'false';
		}
	}