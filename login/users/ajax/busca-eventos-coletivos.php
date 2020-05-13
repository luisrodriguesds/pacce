<?php	
	require_once '../../../sistema/system.php';
	$dataUser = GetUser();
	$user 	= $dataUser[0];
	$semana 	= GetSemana();
	$way 		= URL_PAINEL.$user['tipoSlug'];

if (isset($_POST['palavra'])) {
	$palavra = $_POST['palavra'];

	$bolsistas = DBread('bolsistas', "WHERE npacce LIKE '%$palavra%' OR nome LIKE '%$palavra%' OR matricula LIKE '%$palavra%' LIMIT 1");

	if ($bolsistas == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';	
	}else{
		?>
		<div class="tabela">
			<table>
				<tr>
					<th>NPACCE</th>
					<th>Nome</th>
					<th>Curso</th>
					<th>Presença</th>
				</tr>
				<?php 
					for ($i=0; $i < count($bolsistas); $i++) { 
				?>
				<tr>
					<td><?php echo $bolsistas[$i]['npacce']; ?></td>
					<td><?php echo $bolsistas[$i]['nome']; ?></td>
					<td><?php echo $bolsistas[$i]['curso']; ?></td>
					<td><a href="?npacce=<?php echo $bolsistas[$i]['npacce']; ?>" class="botao" style="padding-left: 20px; padding-right: 20px; padding-top: 10px;">Confirmar</a></td>
				</tr>
				<?php
					}
				?>
			</table>
		</div>
		<?php
	}
}

?>