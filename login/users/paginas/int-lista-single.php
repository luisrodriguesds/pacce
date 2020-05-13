
<?php  
  require_once '../../../sistema/system.php';
  AcessPrivate();
  $dataUser = GetUser();
  $user 	= $dataUser[0];
  $semana 	= GetSemana();
  $way 		= URL_PAINEL.$user['tipoSlug'];
  
  if (isset($_GET['cod']) && $_GET['cod'] != '') {
  	$cod = DBescape(strip_tags(trim($_GET['cod'])));
  	$intCad = DBread('int_cad', "WHERE codigo = '$cod'");
  	if ($intCad == false) {
  		Redirect($way.'/'.$sala);
  	}else if($intCad[0]['npacce1'] == $user['npacce']){
  	}else if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico'){
  	}else{
  		Redirect($way);
  	}
  	$intInsc = DBread('int_insc', "WHERE codigo = '$cod' ORDER BY nomeCompleto ASC");
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
				<h2>INTERAÇÃO</h2>
				<h3>Lista de Presença</h3>
			</div>
			<a href="<?php echo $way; ?>">
			<img src="<?php echo URLBASE;?>images/logonova.png">
			</a>
			<div id="clear"></div>
			<table>
				<tr>
					<th>Código:</th>
					<td><?php echo $intCad[0]['codigo']; ?></td>
					<th class="espaco">Local:</th>
					<td><?php echo $intCad[0]['local']; ?></td>
				</tr>
				<tr>
					<th>Horário:</th>
					<td><?php echo date('H:i', strtotime($intCad[0]['inicio'])).'hr - '.date('H:i', strtotime($intCad[0]['fim'])).'hr'; ?></td>
					<th class="espaco">Facilitador:</th>
					<td><?php echo $intCad[0]['npacce1']; ?> - <?php echo $intCad[0]['nomeComp1']; ?></td>
				</tr>
				<tr>
					<th>Data:</th>
					<td><?php echo date('d/m/y', strtotime($intCad[0]['data'])); ?></td>
					<?php 
						if ($intCad[0]['bol2'] != '') {
							?> 
							<th class="espaco">Co-Facilitador:</th>
							<td><?php echo $intCad[0]['npacce2']; ?> - <?php echo $intCad[0]['nomeComp2']; ?></td>
							<?php
						}
					?>
				</tr>
				<tr>
					<th>Dia:</th>
					<td><?php echo $intCad[0]['diaSemana']; ?></td>
					<th class="espaco">Título:</th>
					<td><?php echo $intCad[0]['titulo']; ?> </td>
				</tr>
			</table>
		</div>

		<div id="folha-content" style="margin-top: 0;">
		<?php 
				if ($intInsc == false) {
					echo '<div class="nada-encontrado"><h2>Não há inscritos.</h2></div>';
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
				for ($i=0; $i < count($intInsc); $i++) { 
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
				<td><?php echo $intInsc[$i]['npacce']; ?></td>
				<td><?php echo $intInsc[$i]['nomeCompleto']; ?></td>
				<td class="text-center"><div id="hora">___:___</div></td>
				<td class="text-center"><div id="hora">___:___</div></td>
				<td class="underline">_____________________________________</td>
			</tr>
			<?php } ?>
		</table>
		<?php 
			echo '<br>('.count($intInsc).')';
		} ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>