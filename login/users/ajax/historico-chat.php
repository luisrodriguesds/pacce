<?php
if (isset($_POST['conversacom'])) {
	require_once '../../../sistema/system-chat.php';

	$mensagens 		= array();
	$id_conversa 	= $_POST['conversacom'];
	$online			= $_POST['online'];
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
	$res = DBread('msg_chat', "WHERE npacce_de = '".$online."' AND npacce_para = '".$id_conversa."' OR npacce_de = '".$id_conversa."' AND npacce_para = '".$online."' ORDER BY id DESC LIMIT 10");
	if ($res == true) {
		for ($i=0; $i < count($res); $i++) { 
			if ($online == $res[$i]['npacce_de']) {
				$janela_de = $res[$i]['npacce_para'];
				$getFoto = '';
			}else if ($online == $res[$i]['npacce_para']) {
				$janela_de = $res[$i]['npacce_de'];
				$getFoto = DBread('bolsistas', "WHERE npacce = '".$res[$i]['npacce_de']."'", 'foto');
				$getFoto = $getFoto[0]['foto'];
			}
			$msg = str_replace($emotions, $img, $res[$i]['mensagem']);

			$mensagens[] = array(
				'id' 		=> $res[$i]['id'],
				'mensagem' 	=> $msg,
				'foto'		=> $getFoto,
				'id_de'		=> $res[$i]['npacce_de'],
				'id_para'	=> $res[$i]['npacce_para'],
				'janela_de'	=> $janela_de,
				'url_painel'=> URL_PAINEL
			);
		}
		die(json_encode($mensagens));
	}
}
?>