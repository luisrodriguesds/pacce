<?php 
if (isset($_GET)) {
	require_once '../../../sistema/system-chat.php';

	$userOnline = $_GET['user'];
	$timestamp = ($_GET['timestamp'] == 0) ? time() : strip_tags(trim($_GET['timestamp']));
	$lastid = (isset($_GET['lastid']) && !empty($_GET['lastid'])) ? $_GET['lastid'] : 0;

	$usersOn = array();
	$agora = date('Y-m-d H:i:s');
	$expira = date('Y-m-d H:i:s', strtotime('+1 min'));

	$form['limite'] = $expira;
	
	DBUpDate('bolsistas', $form,"npacce = '".$userOnline."'");

	$pegaOnline = DBread('bolsistas', "WHERE status = true AND npacce != '".$userOnline."' ORDER BY nome ASC", 'id, npacce, nome, nomeUsual, foto, limite, horario');

	for ($i=0; $i < count($pegaOnline); $i++) { 
		if ($agora >= $pegaOnline[$i]['limite']) {
			$usersOn[] = array('npacce' => $pegaOnline[$i]['npacce'], 'nome' => GetName($pegaOnline[$i]['nome'], $pegaOnline[$i]['nomeUsual']), 'foto' => $pegaOnline[$i]['foto'], 'status' => 'off');
		}else{
			$usersOn[] = array('npacce' => $pegaOnline[$i]['npacce'], 'nome' => GetName($pegaOnline[$i]['nome'], $pegaOnline[$i]['nomeUsual']), 'foto' => $pegaOnline[$i]['foto'], 'status' => 'on');
		}
	}

	if (empty($timestamp)) {
		die(json_encode(array('status' => 'error')));
	}

	$tempoGasto = 0;
	$lastidQuery = '';

	if (!empty($lastid)) {
		$lastidQuery = ' AND id > '.$lastid;
	}


	if ($_GET['timestamp'] == 0) {
		$verifica = DBread('msg_chat', "WHERE (lido = 0 AND npacce_de = '".$userOnline."') OR (lido = 0 AND npacce_para = '".$userOnline."') ORDER BY id DESC");
	}else{
		$verifica = DBread('msg_chat', "WHERE (time >= '$timestamp''$lastidQuery' AND lido = 0 AND npacce_de = '".$userOnline."') OR (time >= '$timestamp''".$lastidQuery."' AND lido = 0 AND npacce_para = '".$userOnline."') ORDER BY id DESC");
	}

	if ($verifica == false) {
		while ($verifica == false) {
			if ($verifica == false) {
				//durar 30s vifificando
				if ($tempoGasto >= 30) {
					die(json_encode(array('status' => 'vazio', 'lastid' => 0, 'timestamp' => time(), 'users' => $usersOn)));
					exit();
				}
				//descansar o script por 1s
				sleep(1);
				$verifica = DBread('msg_chat', "WHERE (time >= '$timestamp''$lastidQuery' AND lido = 0 AND npacce_de = '".$userOnline."') OR (time >= '$timestamp''".$lastidQuery."' AND lido = 0 AND npacce_para = '".$userOnline."') ORDER BY id DESC");
				$tempoGasto += 1;
			}
		}
	}
	$novasMensagens = array();
	if ($verifica == true) {

		$emotions = array(':)', ':@', 'B)',':D', ':3', ':(', ';)');
		$img = array(
			'<img src="'.URL_PAINEL.'emotions/nice.png" width="14" />',
			'<img src="'.URL_PAINEL.'emotions/angry.png" width="14" />',
			'<img src="'.URL_PAINEL.'emotions/cool.png" width="14" />',
			'<img src="'.URL_PAINEL.'emotions/happy.png" width="14" />',
			'<img src="'.URL_PAINEL.'emotions/ooh.png" width="14" />',
			'<img src="'.URL_PAINEL.'emotions/sad.png" width="14" />',
			'<img src="'.URL_PAINEL.'emotions/right.png" width="14" />',
		);
		for ($i=0; $i < count($verifica); $i++) { 
			$getFoto = '';
			$janela_de = 0;
			if ($userOnline == $verifica[$i]['npacce_de']) {
				$janela_de = $verifica[$i]['npacce_para'];
				$getFoto = '';
			}else if ($userOnline == $verifica[$i]['npacce_para']) {
				$janela_de = $verifica[$i]['npacce_de'];
				$getFoto = DBread('bolsistas', "WHERE npacce = '".$verifica[$i]['npacce_de']."'", 'foto');
				$getFoto = $getFoto[0]['foto'];
			}

			$msg = str_replace($emotions, $img, $verifica[$i]['mensagem']);
			$novasMensagens[] = array(
				'id' 		=> $verifica[$i]['id'],
				'mensagem' 	=> $msg,
				'foto'		=> $getFoto,
				'id_de'		=> $verifica[$i]['npacce_de'],
				'id_para'	=> $verifica[$i]['npacce_para'],
				'janela_de'	=> $janela_de,
				'url_painel'=> URL_PAINEL,
				'lido'		=> $verifica[$i]['lido']
			);
		}
	}

	$ultimaMsg = end($novasMensagens);
	$ultimoId  = $ultimaMsg['id'];
	die(json_encode(array('status' => 'resultados', 'timestamp' => time(), 'lastid' => $ultimoId, 'dados' =>$novasMensagens, 'users' => $usersOn)));
}

?>