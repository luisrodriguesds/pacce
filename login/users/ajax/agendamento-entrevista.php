<?php 
  require_once '../../../sistema/system.php';

  $dataUser = GetUser();
  $user 	= $dataUser[0];
  $semana 	= GetSemana();
  $way 		= URL_PAINEL.$user['tipoSlug'];
?>
<table>
	<tr>
		<th>Dia</th>
		<th>Dia da semana</th>
		<th>Turno</th>
		<th>Início</th>
		<th>Fim</th>
		<th>Vagas</th>
		<th>Inscrição</th>
	</tr>
	<?php 
		$agend = DBread('ren_horarios_agendamento');
		$agendIns = DBread('ren_insc_agendamento', "WHERE npacce = '".$user['npacce']."'");
		if ($agend == true) {
			for ($i=0; $i < count($agend); $i++) { 
			?>
				<tr>
					<td><?php echo date('d/m', strtotime($agend[$i]['dia']));  ?></td>
					<td><?php echo $agend[$i]['diaSemana']; ?></td>
					<td><?php echo $agend[$i]['turno']; ?></td>
					<td><?php echo date('H:i', strtotime($agend[$i]['inicio'])); ?></td>
					<td><?php echo date('H:i', strtotime($agend[$i]['fim'])); ?></td>
					<td><?php echo $agend[$i]['vagas']; ?></td>
					<td> <?php if($agendIns == false && $agend[$i]['vagas'] > 0){ echo '<a href="?idIns='.$agend[$i]['id'].'&&action=1" style="color: #069;">Inscrever-se</a>'; }else if($agendIns[0]['idAg'] == $agend[$i]['id']){ echo '<a href="?idIns='.$agend[$i]['id'].'&&action=2" style="color: #069;">Cancelar Inscrição</a>'; }else{ echo '----'; } ?> </td>
				</tr>
			<?php 
			}
		}
	?>
</table>