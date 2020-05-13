<?php 
	require_once '../../../sistema/system.php';

	if (isset($_POST['palavra'])) {
		$palavra = $_POST['palavra'];
		$candidato = DBread('bolsistas', "WHERE tipoSlug = 'candidato' AND npacce LIKE '%$palavra%' ORDER BY npacce ASC");
	}else{
		$candidato = DBread('bolsistas', "WHERE tipoSlug = 'candidato' ORDER BY npacce ASC LIMIT 20");
	}

	if ($candidato == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
	}else{

?>

<div class="tabela">
	<table>
		<tr>
			<th>NPACCE</th>
			<th>Nome</th>
			<th>Curso</th>
			<th>Add</th>
		</tr>
		<?php 
			for ($i=0; $i < count($candidato); $i++) { 
			?>
				<tr>
					<td><?php echo $candidato[$i]['npacce']; ?></td>
					<td><?php echo $candidato[$i]['nome']; ?></td>
					<td><?php echo $candidato[$i]['curso']; ?></td>
					<td> 
						<?php 
							$check = DBread('sl_sala_insc', "WHERE npacce = '".$candidato[$i]['npacce']."'", "sala");
							if ($check == false) {
						?>
						<a href="?npacce=<?php echo $candidato[$i]['npacce']; ?>" style="color: #069;"> 
						Add a Sala 
						</a>
						<?php 
							}else{
								echo 'Add a '.$check[0]['sala'];
							}
						?>
					</td>
				</tr>
			<?php 
			}
		?>
	</table>
	(<?php echo count($candidato) ?>)
</div>
<?php } ?>
