<?php 
	require_once '../../../sistema/system.php';
	$dataUser = GetUser();
	$user 	= $dataUser[0];
	$semana 	= GetSemana();
	$way 		= URL_PAINEL.$user['tipoSlug'];

if (isset($_POST['palavra'])) {

	$palavra = $_POST['palavra'];
	$part = DBread('eu_participantes', "WHERE matricula LIKE '%$palavra%' OR nome LIKE '%$palavra%' LIMIT 1");
	if ($part == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{

	?>
	<div class="tabela">
	<table>
		<tr>
			<th>Matrícula</th>
			<th>Nome Completo</th>
			<th>Curso</th>
			<th>Presença</th>
		</tr>
		<?php 
			for ($i=0; $i < count($part); $i++) { 
		?>
		<tr>
			<td><?php echo $part[$i]['matricula']; ?></td>
			<td><?php echo $part[$i]['nome']; ?></td>
			<td><?php echo $part[$i]['curso']; ?></td>
			<td><a href="?confirmar=1&&matricula=<?php echo $part[$i]['matricula']; ?>" class="botao" style="padding-left: 20px; padding-right: 20px; padding-top: 10px;">Confirmar</a></td>
		</tr>
		<?php } ?>
	</table>
	<div id="cont">(<?php echo count($part); ?>)</div>
	</div>
	<?php } 
}
if (isset($_POST['pesq'])) {
	$pesq = $_POST['pesq'];
	$part = DBread('eu_participantes', "WHERE matricula LIKE '%$pesq%' OR nome LIKE '%$pesq%' LIMIT 10");
		if ($part == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
		?>
	<div class="tabela">
		<table>
			<tr>
				<th>Matrícula</th>
				<th>Nome Completo</th>
				<th>Curso</th>
				<th>Tipo</th>
			</tr>
			<?php 
				for ($i=0; $i < count($part); $i++) { 
			?>
			<tr>
				<td><?php echo $part[$i]['matricula']; ?></td>
				<td><?php echo $part[$i]['nome']; ?></td>
				<td><?php echo $part[$i]['curso']; ?></td>
				<td><?php echo $part[$i]['tipo']; ?></td>
			</tr>
			<?php } ?>
		</table>
		<div id="cont">(<?php echo count($part); ?>)</div>
	</div>

		<?php
	}
}
?>
