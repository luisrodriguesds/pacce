<?php
	if (isset($_POST['npacce'])) {
		include '../../../sistema/system-chat.php';
		$user['npacce'] = DBescape($_POST['npacce']);
		//INFO IMAGEM
		$file 		= $_FILES['croppedImage'];
		$numFile 	= count($file);

		//PASTA
		$destino 	= DIR_IMG_BOL;

		//REQUISITOS
		$permite	= array('image/jpeg', 'image/png', 'image/jpg');
		$maxSize 	= 1024 * 1024 * 20;

		
		//PEGA AS INFORMAÇÕES
		$name  = $file['name'];
		$type  = $file['type'];
		$size  = $file['size'];
		$error = $file['error'];
		$tmp   = $file['tmp_name'];

		if ($error != 0) {
			alertaLoad($errosMsg[$error], URL_PAINEL);
		}else if (!in_array($type, $permite)) {
			alertaLoad('Formato diferente do permitido!', URL_PAINEL);
		}else{
				//VERIFICAÇÃO DE ERROS
				$name = $name.'.'.str_replace('image/', "", $type);
				//TRATAMENTO DE NOME E EXTENSÃO
				$extensao = strrchr($name, '.');
				$extensao = strtolower($extensao);

				$novoNome = md5(time()).$extensao;

				$destino = $destino.$novoNome;
				if (move_uploaded_file($tmp, $destino)) {
					
					//ALTERA A DESCRIÇÃO PESSOAL
					$selec = DBread('bolsistas', "WHERE npacce = '".$user['npacce']."'", 'id, foto, npacce');
					if ($selec == true && $selec[0]['foto'] != 'padrao.png') {
						//EXCLUIR ULTIMA IMAGEM
						if (file_exists(DIR_IMG_BOL.$selec[0]['foto'])) {
							if (unlink(DIR_IMG_BOL.$selec[0]['foto'])) {
								
							}		
						}else{
						
						}
					}

					$form['foto'] = $novoNome;
					if (DBUpDate('bolsistas', $form, "npacce = '".$user['npacce']."'")) {
						echo 'success';
					}
				}else{
					echo 'error';
				}

		}
	}
?>