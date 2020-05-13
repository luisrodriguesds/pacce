
<?php  
  require_once '../../../sistema/system.php';
  AcessPrivate();
  $dataUser = GetUser();
  $user 	= $dataUser[0];
  $semana 	= GetSemana();
  $way 		= URL_PAINEL.$user['tipoSlug'];
  
  if (isset($_GET['sala']) && $_GET['sala'] != '') {
  	$sala = DBescape(strip_tags(trim($_GET['sala'])));
  	$rodSala = DBread('rod_salas', "WHERE sala = '$sala'");
  	if ($rodSala == false) {
  		Redirect($way.'/'.$sala);
  	}else if($rodSala[0]['npacce1'] == $user['npacce']){
  	}else if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico'){
  	}else{
  		Redirect($way.'/'.$sala);
  	}

  	$rodInsc = DBread('rod_insc', "WHERE sala = '$sala' ORDER BY nomeCompleto ASC");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<title>PACCE - UFC</title>
	<link rel="shortcut icon" href="<?php echo URLBASE;?>/images/pacce_icon.png" type="imgen/png">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_PAINEL;?>css/style_freq.css">
	<script src="<?php echo URL_PAINEL;?>js/jquery-1.11.3.min.js"></script>
	<script src="<?php echo URL_PAINEL;?>js/functions.js"></script> 
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
				<h2>História de Vida</h2>
				<h3>Lista de Presença</h3>
			</div>
			<a href="<?php echo $way; ?>">
			<img src="<?php echo URLBASE;?>images/logonova.png">
			</a>
			<div id="clear"></div>
			<table>
				<tr>
					<th>Código:</th>
					<td><?php echo 'ROD'.substr($rodSala[0]['ano'], -2).'___'.substr($rodSala[0]['sala'], -2); ?></td>
					<th class="espaco">Dia:</th>
					<td><?php echo $rodSala[0]['diaSemana']; ?></td>
					
				</tr>
				<tr>
					<th>Sala:</th>
					<td><?php echo $rodSala[0]['sala']; ?></td>
					<th class="espaco">Local:</th>
					<td><?php echo $rodSala[0]['local']; ?></td>
					
				</tr>
				<tr>
					<th>Horário:</th>
					<td><?php echo date('H:i', strtotime($rodSala[0]['inicio'])).'hr - '.date('H:i', strtotime($rodSala[0]['fim'])).'hr'; ?></td>
					<th class="espaco">Facilitador:</th>
					<td><?php echo $rodSala[0]['npacce1']; ?> - <?php echo $rodSala[0]['nomeComp1']; ?></td>
					
				</tr>
				<tr>
					<th>Data:</th>
					<td><?php echo date('d/m/y', strtotime($rodSala[0]['dataInicio'])); ?> - <?php echo date('d/m/y', strtotime($rodSala[0]['dataFim'])); ?></td>
					<th class="espaco">Facilitador:</th>
					<td><?php echo $rodSala[0]['npacce2']; ?> - <?php echo $rodSala[0]['nomeComp2']; ?></td>
				</tr>
			</table>
		</div>

		<div id="folha-content" style="margin-top: 0;">
		<?php 
				if ($rodInsc == false) {
					echo '<div class="nada-encontrado"><h2>Não há inscritos nessa formação.</h2></div>';
				}else{
			?>
		<table>
			<tr>
				<th class="text-left">N PACCE:</th>
				<th class="text-left">Nome:</th>
				<th>Entrada:</th>
				<th>Saída</th>
				<th>Assinatura:</th>
			</tr>
			<?php 
				$bool = true;
				for ($i=0; $i < count($rodInsc); $i++) { 
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
				<td><?php echo $rodInsc[$i]['npacce']; ?></td>
				<td><?php echo $rodInsc[$i]['nomeCompleto']; ?></td>
				<td class="text-center"><div id="hora">___:___</div></td>
				<td class="text-center"><div id="hora">___:___</div></td>
				<td class="underline">_____________________________________</td>
			</tr>
			<?php } ?>
		</table>
		<?php 
			echo '<br>('.count($rodInsc).')';
		} ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>