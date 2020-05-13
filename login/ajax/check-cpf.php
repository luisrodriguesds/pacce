<?php 
	if (isset($_GET['cpf'])) {
		include '../../sistema/system.php';
		$cpf = DBread('bolsistas', "WHERE cpf = '".$_GET['cpf']."'", 'npacce, cpf');
		if ($cpf == false) {
			echo 'true';
		}else{
			//var_dump($cpf);
			$for = DBread('sl_check_for', "WHERE npacce = '".$cpf[0]['npacce']."' ORDER BY ano DESC");
			if ($for == false) {
				echo 'false';
			}else{
				if ($for[0]['nfor'] < 16) {
					echo 'true';
				}else{
					echo 'false';
				}
			}
		}
	}