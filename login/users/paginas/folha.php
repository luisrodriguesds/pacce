
<?php
//CONTAGEM
DBDelete('folha_contagem'); 
$cont = 0;
$bolsista = DBread('bolsistas', "WHERE situacao = 1 AND status = true", "id, npacce, nome, tipo, tipoSlug, situacao, campusSlug");
for ($k=0; $k < count($bolsista); $k++) { 

$form['npacce'] 	= $bolsista[$k]['npacce'];
$form['nome'] 		= $bolsista[$k]['nome'];
$form['tipo']	 	= $bolsista[$k]['tipo'];
$form['tipoSlug']	= $bolsista[$k]['tipoSlug'];
$form['campus']	= $bolsista[$k]['campusSlug'];	
$form['situacao'] 	= $bolsista[$k]['situacao'];
$form['rg']			= 0;
$form['status']		= 1;
$form['registro']	= date('Y-m-d H:i:s');

//Projeto
$projeto = DBread('projetos', "WHERE npacce = '".$bolsista[$k]['npacce']."' AND status = true", "id");
if ($projeto == false) {
	$form['projeto'] = 0;
}else{
	$form['projeto'] = count($projeto);
}

//Horário e local da célula
$horario = DBread('horario_celula', "WHERE npacce = '".$bolsista[$k]['npacce']."' ORDER BY registro DESC", "id");
if ($horario == false) {
	$form['cadastroCelula'] = 0;
}else{
	$form['cadastroCelula'] = count($horario);
}

//Relatório de encontro de célula
$enc = DBread('enc_celula', "WHERE npacce = '".$bolsista[$k]['npacce']."' ORDER BY semana ASC", "id");
if ($enc == false) {
	$form['encontroCelula'] = 0;
}else{
	$form['encontroCelula'] = count($enc);
}

//APOIO A CELULA
$apoPres = DBread('apo_pres', "WHERE npacce = '".$bolsista[$k]['npacce']."' ORDER BY codigo ASC", "id, presenca");
if ($apoPres == false){
	$form['apoioCelula'] = 0;
}else{
	$form['apoioCelula'] = 0;
	for ($i=0; $i < count($apoPres); $i++) { 
		if ($apoPres[$i]['presenca'] == 1 || $apoPres[$i]['presenca'] == 2 || $apoPres[$i]['presenca'] == 5) {
			$form['apoioCelula'] = $form['apoioCelula'] + 1;
		}
	}
}

//FORMAÇÃO
$forPres = DBread('for_pres', "WHERE npacce = '".$bolsista[$k]['npacce']."'", "id, presenca");
if ($forPres == false) {
	$form['formacao'] = 0;
}else{
	$form['formacao'] = 0;
	for ($i=0; $i < count($forPres); $i++) { 
		if ($forPres[$i]['presenca'] == 1 || $forPres[$i]['presenca'] == 2 || $forPres[$i]['presenca'] == 5) {
			$form['formacao'] = $form['formacao'] + 1;
		}
	}
}

//RODA VIVA
$rodPres = DBread('rod_pres', "WHERE npacce = '".$bolsista[$k]['npacce']."' ORDER BY codigo ASC", "id, presenca");
if ($rodPres == false){
	$form['historiaDeVida'] = 0;
}else{
	$form['historiaDeVida'] = 0;
	for ($i=0; $i < count($rodPres); $i++) { 
		if ($rodPres[$i]['presenca'] == 1 || $rodPres[$i]['presenca'] == 2 || $rodPres[$i]['presenca'] == 5) {
			$form['historiaDeVida'] = $form['historiaDeVida'] + 1;
		}
	}
}

//INTERAÇÃO
$intInsc = DBread('int_insc', "WHERE npacce = '".$bolsista[$k]['npacce']."' ORDER BY semana ASC", "id, presenca");
if ($intInsc == false) {
	$form['interacao'] = 0;
}else{
	$form['interacao'] = 0;
	for ($i=0; $i < count($intInsc); $i++) { 
		if ($intInsc[$i]['presenca'] == 1 || $intInsc[$i]['presenca'] == 2) {
			$form['interacao'] = $form['interacao'] + 1;
		}
	}
}

//APRECIAÇÃO DE MEMORIAL
$apr = DBread('apr_me', "WHERE npacce = '".$bolsista[$k]['npacce']."' ORDER BY semana ASC", "id");
if ($apr == false) {
	$form['apreciacao'] = 0;
}else{
	$form['apreciacao'] = count($apr);
}

//ATIVIDADE DE COMISSÃO
$ati = DBread('ati_com', "WHERE npacce = '".$bolsista[$k]['npacce']."' ORDER BY semana ASC", "id");
if ($ati == false) {
	$form['atiComissao'] = 0;		
}else{
	$form['atiComissao'] = count($ati);
}

//PRESENÇA EM REUNIÃO DE COMISSÃO
$comPres = DBread('av_comissao', "WHERE npacce = '".$bolsista[$k]['npacce']."' ORDER BY semana ASC");
if ($comPres == false) {
	$form['presencaReuniao'] = 0;
}else{
	$form['presencaReuniao'] = 0;
	for ($i=0; $i < count($comPres); $i++) { 
		if ($comPres[$i]['presenca'] == 1 || $comPres[$i]['presenca'] == 2 || $comPres[$i]['presenca'] == 3) {
			$form['presencaReuniao'] = $form['presencaReuniao'] + 1;
		}
	}
}

//EVENTOS COLETIVOS
$eventos = DBread('eventos_pres', "WHERE npacce = '".$bolsista[$k]['npacce']."'");
if ($eventos == false) {
	$form['rg'] = 0;
}else{
	$form['rg'] = 0;
	for ($i=0; $i < count($eventos); $i++) { 
		if ($eventos[$i]['presenca'] == 1 || $eventos[$i]['presenca'] == 3) {
			$form['rg'] = $form['rg'] + 1;
		}
	}
}

//Relato de Experiência
$rde = DBread('relato', "WHERE npacce = '".$bolsista[$k]['npacce']."'");
if ($rde == false) {
	$form['relatoDeExperiencia'] = 0;
}else{
	$form['relatoDeExperiencia'] = count($rde);	
	
}


$folha = DBread('folha_contagem', "WHERE npacce = '".$bolsista[$k]['npacce']."'", "id, npacce");
if ($folha == false) {
	if (DBcreate('folha_contagem', $form)) {
		$cont++;
	}
}else{
	if (DBUpDate('folha_contagem', $form, "npacce = '".$bolsista[$k]['npacce']."'")) {
		$cont++;
	}
}
if ($cont == count($bolsista)) {
	echo '<script>alert("Folha de pagamento foi atualizada em '.date('d/m/y H:i:s').'.");
	window.location="'.$way.'/'.$url[1].'";</script>';
}

}
?>