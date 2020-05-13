<?php 
require_once '../../../sistema/system.php';
$dataUser 	= GetUser();
$user 		= $dataUser[0];
$semana 	= GetSemana();
$way 		= URL_PAINEL.$user['tipoSlug'];

if (isset($_POST['palavra'])) {
	$palavra = $_POST['palavra'];
	$bolsistas = DBread('bolsistas', "WHERE npacce LIKE '%$palavra%' OR nome LIKE '%$palavra%' OR tipo LIKE '%$palavra%' OR curso LIKE '%$palavra%' ORDER BY npacce DESC LIMIT 40");
}else{
	
	$bolsistas19 = DBread('bolsistas', "where npacce LIKE 'B19%' and status = '1' ORDER BY npacce ");
	$bolsistas18 =  DBread('bolsistas', "where npacce LIKE 'B18%' and status = '1' ORDER BY npacce ");
	$bolsistas17 = DBread('bolsistas', "where npacce LIKE 'B17%' and status = '1' ORDER BY npacce ");
	$bolsistas16 = DBread('bolsistas', "where npacce LIKE 'B16%' and status = '1' ORDER BY npacce ");
	$bolsistas15 = DBread('bolsistas', "where npacce LIKE 'B15%' and status = '1' ORDER BY npacce ");
	$bolsistas14 = DBread('bolsistas', "where npacce LIKE 'B14%' and status = '1' ORDER BY npacce ");

	$bolsistas = array_merge($bolsistas19,$bolsistas18);
	$bolsistas = array_merge($bolsistas,$bolsistas17);
	$bolsistas = array_merge($bolsistas,$bolsistas16);
	$bolsistas = array_merge($bolsistas,$bolsistas15);
	$bolsistas = array_merge($bolsistas,$bolsistas14);

}

if ($bolsistas == false) {
	echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
}else{
	?>
	<script type="text/javascript">
		var wd = $(window).width();
		$('.table-responsive').css('max-width', wd-45);
	</script>
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>N PACCE</th>
				<th>Nome</th>
				<th>Função</th>
				<th>Curso</th>
				<th>Campus</th>
			</tr>
			<?php
				$voluntarios 	= 0;
				$efetivos		= 0;
				$ativos			= 0;
				$invativos		= 0; 
				$candidatos 	= 0;
				for ($i=0; $i < count($bolsistas); $i++) {
					if ($bolsistas[$i]['situacao'] == 1) {
					 	$efetivos++;
					}else{
						$voluntarios++;
					}
					if ($bolsistas[$i]['status'] == 1) {
					 	$ativos++;
					}else{
						$invativos++;
					}
					if ($bolsistas[$i]['tipoSlug'] == 'candidato') {
						$candidatos++;
					}
			?>
			<tr>
				<td><?php echo $bolsistas[$i]['npacce']; ?></td>
				<td><a href="<?php echo $way.'/gerenciar-bolsistas/'.$bolsistas[$i]['cpf']; ?>"><?php echo $bolsistas[$i]['nome']; ?></a></td>
				<td><?php echo $bolsistas[$i]['tipo']; ?></td>
				<td title="<?php echo $bolsistas[$i]['curso']; ?>"><?php echo texto($bolsistas[$i]['curso'], 20); ?></td>
				<td><?php echo $bolsistas[$i]['campus']; ?></td>
			</tr>
			<?php 
				}
			?>
			<div id="info">
				<?php echo count($bolsistas) ?> - Total<br>
				<?php echo $efetivos; ?> - Efetivos<br>
				<?php echo $voluntarios; ?> - Voluntários<br>
				<?php echo $ativos; ?> - Ativos<br>
				<?php echo $invativos; ?> - Inativos<br>
				<?php echo $candidatos; ?> - Candidatos<br>
			</div>
		</table>
	</div>
	<?php
}
?>