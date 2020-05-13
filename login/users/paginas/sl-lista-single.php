<?php 
	require_once '../../../sistema/system.php';
	AcessPrivate();
	$dataUser = GetUser();
	$user 	= $dataUser[0];
	$semana 	= GetSemana();
	$way 		= URL_PAINEL.$user['tipoSlug'];

	$getSala = DBescape($_GET['sala']);

	$sala = DBread('sl_salas', "WHERE sala = '".$getSala."'");
	if ($sala ==  false) {
		echo '
			<script> 
				alert("Sala não encontrada!");
				window.location="'.$way.'/";
			</script>
		';
	}
	$sala = $sala[0];

	$trio = DBread('sl_trios', "WHERE trio = '".$sala['trio']."'");
	$trio = $trio[0];
	$salaInsc  = DBread('sl_sala_insc', "WHERE sala = '".$sala['sala']."' ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<title>PACCE - UFC</title>
	<link rel="shortcut icon" href="<?php echo URLBASE;?>/images/pacce_icon.png" type="imgen/png">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_PAINEL;?>css/style_freq.css">
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
				<h2>SELEÇÃO <?php echo date('Y'); ?></h2>
				<h3>Lista de Presença</h3>
			</div>
			<a href="<?php echo $way; ?>">
			<img src="<?php echo URLBASE;?>images/logonova.png">
			</a>
			<div id="clear"></div>
			<table>
				<tr>
					<th>Sala:</th>
					<td><?php echo $sala['sala']; ?></td>
					<th class="espaco">Turno:</th>
					<td><?php echo $sala['turno']; ?></td>
				</tr>
				<tr>
					<th>Horário:</th>
					<td><?php echo date('H:i', strtotime($sala['inicio'])).'h - '.date('H:i', strtotime($sala['fim'])).'h'; ?></td>
					<th class="espaco">Facilitador:</th>
					<td><?php echo $trio['npacce1'].' - '.$trio['nome1'];	 ?></td>
				</tr>
				<tr>
					<th>Data:</th>
					<td><?php echo date('d/m/y', strtotime($sala['dataInicio'])).' - '.date('d/m/y', strtotime($sala['dataFim'])); ?> </td>
					<th class="espaco">Facilitador:</th>
					<td><?php echo $trio['npacce2'].' - '.$trio['nome2'];	 ?></td>
				</tr>
				<tr>
					<th>Local:</th>
					<td><?php echo $sala['local']; ?></td>
					<th class="espaco">Facilitador:</th>
					<td><?php echo $trio['npacce3'].' - '.$trio['nome3'];	 ?></td>
				</tr>
			</table>
			</div>
			<div id="folha-content">
				<?php 
					if ($salaInsc == false) {
						echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
					}else{
				?>
					<table>
						<tr>
							<th class="text-left">N PACCE:</th>
							<th class="text-left">Nome:</th>
							<th style="width: 73px;">1º período</th>
							<th style="width: 73px;">2º período</th>
							<th style="width: 73px;">3º período</th>
							<th style="width: 73px;">4º período</th>
							<th style="width: 73px;">5º período</th>
						</tr>
						<?php 
							$bool = true;
							for ($i=0; $i < count($salaInsc); $i++) { 
						?>
							<tr
							<?php  
								if ($bool == true) {
									echo 'class="linecolor"';
									$bool = false;
								}else{
									$bool = true;
								}
							?>
							>
								<td><?php echo $salaInsc[$i]['npacce']; ?></td>
								<td><?php echo $salaInsc[$i]['nome']; ?></td>
								<td> <div class="text-center underline"> __________ </div> </td>
								<td> <div class="text-center underline"> __________ </div> </td>
								<td> <div class="text-center underline"> __________ </div> </td>
								<td> <div class="text-center underline"> __________ </div> </td>
								<td> <div class="text-center underline"> __________ </div> </td>
							</tr>
						<?php
							}
						?>
					</table>

				<?php
					}
				?>
				<div>(<?php echo count($salaInsc); ?>)</div>
			</div>
		
	</div>

</div>


</body>
</html>