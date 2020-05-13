
<?php  
  require_once '../../../sistema/system.php';
  AcessPrivate();
  $dataUser = GetUser();
  $user 	= $dataUser[0];
  $semana 	= GetSemana();
  $way 		= URL_PAINEL.$user['tipoSlug'];
  
  if (isset($_GET['comissao']) && $_GET['comissao'] != '') {
	$cod = DBescape(strip_tags(trim($_GET['comissao'])));
	$comissao = DBread('comissoes', "WHERE comissaoSlug = '$cod'");

	$rCom = DBread('rgc', "WHERE comissaoSlug = '$cod' ");
	$rCom = $rCom[0];

	$atec = DBread('bolsistas', "WHERE npacce = '".$rCom['npacceATec']."'");
	$atec = $atec[0];

	if ($comissao == false) {
		Redirect($way.'/'.$sala);
	}else if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico'){
	}else{
		Redirect($way);
	}
  	$membros = DBread('bolsistas', "WHERE tipoSlug = '$cod' && status = '1' ORDER BY nome ASC");

  	if ($cod == "ceo") {
  		$bolPacce;
  		for ($i=0; $i < count($membros); $i++) { 
  			if ($membros[$i]['npacce'] == 'B180671') {
  				$bolPacce[0] = $membros[$i];
  			}
  			if ($membros[$i]['npacce'] == 'B190024') {
  				$bolPacce[1] = $membros[$i];
  			}
  		}
  		$membros = $bolPacce;
  	}
  	
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<title>PACCE - UFC</title>
	<link rel="shortcut icon" href="<?php echo URLBASE;?>/images/pacce_icon.png" type="imgen/png">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_PAINEL;?>css/style_new_2.css">
	<script src="<?php echo URL_PAINEL;?>js/jquery-1.11.3.min.js"></script>
	<!-- <script src="<?php// echo URL_PAINEL;?>js/functions.js"></script>  -->
	<style>
		@import url('https://fonts.googleapis.com/css?family=Open+Sans');
		body{ font-family: 'Open Sans', sans-serif; }
	</style>
</head>
<body>
<div id="folha">
	<div id="folha-corpo">
		<div id="folha-cabecario">
			<div id="folha-titulo">
				<h2>Reunião de Comissão </h2>
				<h3><?php echo $comissao[0]['comissao']; ?></h3>
				<h3>Lista de Presença</h3>
			</div>
			<a href="<?php echo $way; ?>">
			<img src="<?php echo URLBASE;?>images/logonova.png?>">
			</a>
			<div id="clear"></div>

			
			
				<table>
				<tr>
					<th style="width: 150px">Código:</th>
					<td></td>
					<th class="espaco">Local: <?php echo $rCom['local']; ?></th>
					<td></td>
				</tr>
				<tr>
					<th>Horário: <?php echo substr($rCom['horaInicio'], 0, 5); ?> - <?php echo substr($rCom['horaTermino'], 0, 5); ?> </th>
					<td></td>
					<th class="espaco">Atec: <?php echo $atec['nome']; ?></th>
					<td></td>
				</tr>
				<tr>
					<th>Data: ____/____/_______</th>
					<td></td>
					<th class="espaco">Dia da semana: <?php echo $rCom['diaSemana']; ?></th>
					<td></td>
				</tr>
				</table>
		</div>

		<div id="folha-content" style="margin-top: 0;">
		<?php 
				if ($membros == false) {
					echo '<div class="nada-encontrado"><h2>Não há membros.</h2></div>';

				}else{
			?>




		<table>
			<tr>
				<th class="text-left" style="width: 90px;">N PACCE:</th>
				<th class="text-left">Nome:</th>
				<th>Entrada:</th>
				<th>Saída</th>
				<th>Assinatura:</th>
			</tr>
			<?php 
				$bool = true;
				for ($i=0; $i < count($membros); $i++) { 
			?>
			<tr 
			<?php  
				if ($bool == true) {
					echo 'class="linecolor"';
					$bool = false;
				}else{
					$bool = true;
				}
			?>>
				<td><?php echo $membros[$i]['npacce']; ?></td>
				<td><?php echo $membros[$i]['nome']; ?></td>
				<td class="text-center"><div id="hora">___:___</div></td>
				<td class="text-center"><div id="hora">___:___</div></td>
				<td class="underline">_____________________________________</td>
			</tr>
			<?php } ?>
		</table>
		<?php 
			echo '<br>('.count($membros).')';
		} ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>