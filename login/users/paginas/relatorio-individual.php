<?php 
if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
	//EXCKUIR INTERAÇAO
	if (isset($_GET['confirmInteracao']) && $_GET['confirmInteracao'] != '') {
		?>
		<script type="text/javascript">
			if (confirm("Deseja excluir o registro de interação de <?php echo $url['3'] ?> ?")) {
				window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?interacao='.$_GET['confirmInteracao']; ?>";
			}else{
				window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3]; ?>";
			}
		</script>
		<?php
	}
	if (isset($_GET['interacao']) && $_GET['interacao'] != ''){
		$form['codigo'] = $_GET['interacao'];
		$form['npacce'] = $url[3];
		if (DBDelete('int_insc', "npacce = '".$form['npacce']."' AND codigo = '".$form['codigo']."'")) {
			echo '<script>
	          alert("Ação realizado com sucesso!");
	            window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'#interacao";
	          </script>';
		}
	}
	//ALTERAR ATIVIDADE COLETIVAS
	if (isset($_GET['actionrg1']) && $_GET['actionrg1'] != '') {
		switch ($_GET['actionrg1']) {
			case 1:
				?>
				<script type="text/javascript">
					if (confirm("Deseja confirmar a Presença de Atividade coletiva de <?php echo $url['3'] ?> ?")) {
						window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?codigo='.$_GET['atividade'].'&&actionrg2=1'; ?>";
					}else{
						window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3]; ?>";
					}
				</script>
				<?php
				break;
			case 2:
					?>
				<script type="text/javascript">
					if (confirm("Deseja confirmar a Reposição de Atividade coletiva de <?php echo $url['3'] ?> ?")) {
						window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?codigo='.$_GET['atividade'].'&&actionrg2=2'; ?>";
					}else{
						window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3]; ?>";
					}
				</script>
				<?php
				break;

				case 3:
					?>
				<script type="text/javascript">
					if (confirm("Deseja confirmar a Ausência de Atividade coletiva de <?php echo $url['3'] ?> ?")) {
						window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?codigo='.$_GET['atividade'].'&&actionrg2=3'; ?>";
					}else{
						window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3]; ?>";
					}
				</script>
				<?php
				break;
			
		}
	}

	if (isset($_GET['actionrg2']) && $_GET['actionrg2'] != '') {
		$event = DBread('eventos', "WHERE codigo = '".$_GET['codigo']."'");
		switch ($_GET['actionrg2']) {
			case 1:
				if ($event == true) {
					$codigo 			= $_GET['codigo'];
					$form['presenca']	= 1;
					$form['entrada']	= $event[0]['inicio'];
					$form['saida']		= $event[0]['fim'];
					if (DBUpDate('eventos_pres', $form, "npacce = '".$url[3]."' AND codigo = '".$codigo."'")) {
						echo '<script>
		                  alert("Ação realizada com sucesso!");
		                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'#atividade-coletiva";
		                  </script>';
					}
				}
			break;
			case 2:
				if ($event == true) {
					$codigo 			= $_GET['codigo'];
					$form['presenca']	= 3;
					$form['entrada']	= $event[0]['inicio'];
					$form['saida']		= $event[0]['fim'];
					if (DBUpDate('eventos_pres', $form, "npacce = '".$url[3]."' AND codigo = '".$codigo."'")) {
						echo '<script>
		                  alert("Ação realizada com sucesso!");
		                   window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'#atividade-coletiva";
		                  </script>';
					}
				}
			break;
			case 3:
				$codigo 			= $_GET['codigo'];
				$form['presenca']	= 0;
				$form['entrada']	= '00:00:00';
				$form['saida']		= '00:00:00';
				if (DBUpDate('eventos_pres', $form, "npacce = '".$url[3]."' AND codigo = '".$codigo."'")) {
					echo '<script>
	                  alert("Ação realizada com sucesso!");
	                   window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'#atividade-coletiva";
	                  </script>';
				}
			break;
			
		}
	}
}
?>
<div class="title"><h2>Relatório Individual</h2></div>
<p>Página destinada à visualização das suas atividades de <?php echo date('Y'); ?> no programa. Esse relatório irá servir de base para a montagem da folha de pagamento mensal, por isso você deve acompanhá-la regularmente para saber se suas atividades estão coerentes às exigidas pela folha de cada mês.</p>
<br>
<?php 
if (isset($url[3])) {
	$bolsista = DBread('bolsistas', "WHERE npacce = '".trim($url[3])."'", "id, npacce, nome, nomeUsual, tipo, tipoSlug ,curso, campus, status, sexo, foto, situacao");
	$bolsista = $bolsista[0];
}else{
	$bolsista = $user;
}
?>
<div class="page-ati-single">
		<div class="corpo-single">
			<div class="foto-single" style="float: left;">
				<span class="foto"><img src="<?php echo URL_PAINEL.'imagensBolsistas/'.$bolsista['foto'].'';?>"><br></span>
				<div class="nome"><?php echo GetName($bolsista['nome'], $bolsista['nomeUsual']); ?></div>
			</div>
		</div>
</div>
<div id="folha-cabecario" style="width: 50%; float: left;">
	<table style="font-size: 15px; margin-top:10px; float: left;">
		<tr>
			<th>Número PACCE:</th>
			<td><?php echo $bolsista['npacce']; ?></td>
		</tr>
		<tr>
			<th>Nome: </th>
			<td><?php echo $bolsista['nome']; ?></td>
		</tr>
		<tr>
			<th>Função:</th>
			<td><?php echo $bolsista['tipo']; ?></td>
		</tr>
		<tr>
			<th>Curso:</th>
			<td><?php echo $bolsista['curso']; ?></td>
		</tr>
		<tr>
			<th>Campus:</th>
			<td><?php echo $bolsista['campus']; ?></td>
		</tr>

		<?php 
			$bool = false;
			if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
			$bool = true;
		?>
		<tr>
			<th>Situação:</th>
			<td>
			<?php  
				if ($bolsista['situacao'] == 1) {
					if ($bolsista['sexo'] == 0) {
						echo 'Efetiva';
					}else{
						echo 'Efetivo';
					}
				}else if($bolsista['situacao'] == 0){
					if ($bolsista['sexo'] == 0) {
						echo 'Voluntária';
					}else{
						echo 'Voluntário';
					}
				}else if ($bolsista['situacao'] == 2) {
					echo '<strong>BIA</strong>';
				}else{
					echo '<strong>Outra bolsa</strong>';
				}
			?></td>
		</tr>
		<?php
			}
		?>
		<tr>
			<th>Status:</th>
			<td><?php if($bolsista['status'] == 1){ echo 'Ativo';}else{ echo 'Inativo';} ?></td>
		</tr>
	</table>
</div>

<div id="clear"></div>
<br><br>
<div class="title"><h2>Relato de Experiencia</h2></div>
<?php 
 $relato = DBread('relato', "WHERE npacce = '".$bolsista['npacce']."'");
 if ($relato == false) {
 	echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
 }else{
?>
<div class="tabela">
	<table>
		
			<tr>
				<th>Tipo</th>
				<th>Semestre</th>
				<th>Situação</th>
				<th>Registro</th>
			</tr>
			<?php
				for ($i=0; $i < count($relato); $i++) { 
			 ?>
			<tr>
				<td>Relato de Experiência</td>
				<td><?php echo $relato[$i]['semestre']; ?></td>
				<td><?php if( $relato[$i]['situacao'] == 0){ echo "Em análise"; }else if($relato[$i]['situacao'] == 1){ echo "Relato aprovado!";}else{ echo "Precisa ser refeito";} ?></td>
				<td><?php echo date('d/m/Y', strtotime($relato[$i]['registro'])); ?></td>
			</tr>
		<?php } ?>
	</table>
</div>
<?php }?>
<br><br>

<div class="title"><h2>Atividades Coletivas - Relatório</h2></div>
<?php 
	$atColetiva = DBread('eventos_avaliar', "WHERE npacce = '".$bolsista['npacce']."'");
	if ($atColetiva == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
?>
<div class="tabela">
	<table>
		<tr>
			<th>Código</th>
			<th>Evento</th>
			<th>Presente</th>
		</tr>
		<?php
			$contAtCol = 0; 
			for ($i=0; $i < count($atColetiva); $i++) {
				if ($avColetiva[$i]['presenca'] == 'nao') {
					$avColetiva[$i]['presenca'] = 'Não';
				} else if ($avColetiva[$i]['presenca'] == 'sim') {
					$avColetiva[$i]['presenca'] = 'Sim';
				}
		?>
		<tr>
			<td><?php echo $atColetiva[$i]['codigo']; ?></td>
			<td><?php echo $atColetiva[$i]['evento']; ?></td>
			<td><?php echo $atColetiva[$i]['presenca']; ?></td>

			<?php }  ?>
		</tr>
		
		<tr>
			<th>Total</th>
			<td></td>
			<td></td>
		</tr>
	</table>
	<div id="cont">(<?php echo $contAtCol.'/'.count($atColetiva); ?>)</div>
</div>
<?php } ?>


<br><br>

<div class="title"><h2>Atividades Coletivas - Presença</h2></div>
<?php 
	$atColetiva = DBread('eventos_pres', "WHERE npacce = '".$bolsista['npacce']."'");
	if ($atColetiva == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
?>
<div class="tabela">
	<table>
		<tr>
			<th>Código</th>
			<th>Evento</th>
			<th>Data</th>
			<th>Entrada</th>
			<th>Saída</th>
			<th>Total</th>
			<th>Situação</th>
			<?php if(isset($url[3]) && $url != ''){
			if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') { ?>
			<th colspan="3">Opções</th>
			<?php }} ?>
		</tr>
		<?php
			$contAtCol = 0; 
			for ($i=0; $i < count($atColetiva); $i++) {
				if ($atColetiva[$i]['presenca'] == 1 || $atColetiva[$i]['presenca'] == 3) {
				 	$contAtCol++;
				 	$hourAtCol = "04:00";
				 } else {
				 	$hourAtCol = "00:00";
				 }  
		?>
		<tr>
			<td><?php echo $atColetiva[$i]['codigo']; ?></td>
			<td><?php echo $atColetiva[$i]['evento']; ?></td>
			<td><?php echo date('d/m/y', strtotime($atColetiva[$i]['data'])); ?></td>
			<td><?php echo date('H:i', strtotime($atColetiva[$i]['entrada'])); ?></td>
			<td><?php echo date('H:i', strtotime($atColetiva[$i]['saida'])); ?></td>
			<td><?php echo $hourAtCol; ?></td>
			<td><?php if($atColetiva[$i]['presenca'] == 0){ echo 'Não esteve presente, efetue sua reposição!';}else if($atColetiva[$i]['presenca'] == 1){ echo 'Esteve presente!';}else if($atColetiva[$i]['presenca'] == 2){ echo 'Saída não registrada!';}else if($atColetiva[$i]['presenca'] == 3){ echo 'Reposição aprovada!';}else if($atColetiva[$i]['presenca'] == 4){ echo 'Reposição em análise!';}else{ echo 'Reposição reprovada, Por favor faça novamente!';} ?></td>
			<?php
			if(isset($url[3]) && $url != ''){ 
			if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') { ?>
			<td title="Confirmar Presença"><a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?actionrg1=1&&atividade='.$atColetiva[$i]['codigo']; ?>"><img height="16" width="16"  src="<?php echo URL_PAINEL; ?>imagens/confirm.png" style="cursor: pointer;"></a></td>
			<td title="Confirmar Reposição"><a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?actionrg1=2&&atividade='.$atColetiva[$i]['codigo']; ?>"><img  src="<?php echo URL_PAINEL; ?>imagens/add.gif" style="cursor: pointer;"></a></td>
			<td><a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?actionrg1=3&&atividade='.$atColetiva[$i]['codigo']; ?>"><img  src="<?php echo URL_PAINEL; ?>imagens/delete.gif" style="cursor: pointer;"></a></td>
			<?php } } ?>
		</tr>
		<?php } ?>
		<tr>
			<th>Total</th>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td> 
				<?php $total = $contAtCol*4;
				if($total>=10){ echo $total.':00'; }else{ echo '0'.$total.':00'; } ?>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<div id="cont">(<?php echo $contAtCol.'/'.count($atColetiva); ?>)</div>
</div>
<?php } ?>


<br><br>

<div class="title" id="interacao"><h2>Atividades Extras</h2></div>
<?php 
	$extraInsc 	= DBread('extra_insc', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
	if ($extraInsc == false) {
		echo '<div class="nada-encontrado"><h2>Não há histórico registrado.</h2></div>';
	}else{
?>
<div class="tabela">
	<table border="">
		<tr>
			<th>Código:</th>
			<th>Título:</th>
			<th>Semana:</th>
			<th>Duração:</th>
			<th>Situação:</th>
			<?php if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno' ){ echo '<th>Opções</th>';} ?>
		</tr>
		<?php 
		$contExtra = 0;
		for ($i=0; $i < count($extraInsc); $i++) { 
			if ($extraInsc[$i]['presenca'] == 1 || $extraInsc[$i]['presenca'] == 6) {
				$contExtra++;
			}
		?>
		<tr>
			<td><?php echo $extraInsc[$i]['codigo']; ?></td>
			<td title="<?php echo $extraInsc[$i]['titulo']; ?>"><?php echo texto($extraInsc[$i]['titulo'],30); ?></td>
			
			<td><?php if($extraInsc[$i]['semana'] >=10){echo $extraInsc[$i]['semana'];}else{ echo '0'.$extraInsc[$i]['semana'];} ?></td>
			<td><?php 
				$horaExtra[$i] = $extraInsc[$i]['saida'] - $extraInsc[$i]['entrada'];
				echo '0'.$horaExtra[$i].':00';
			 ?></td>
			<td><?php if($extraInsc[$i]['situacao'] == 0){ echo 'Você está inscrito!';}else if($extraInsc[$i]['situacao'] == 1){ echo 'Você esteve presente!';}else if($extraInsc[$i]['situacao'] == 0){echo 'Falta justificada';}else{echo 'Você faltou essa atividade!';} ?></td>
			<?php 
			if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno' ){ ?> <td><a href="<?php echo  $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?confirmInteracao='.$intInsc[$i]['codigo']; ?>"><img  src="<?php echo URL_PAINEL; ?>imagens/delete.gif" style="cursor: pointer;"></a></td> <?php } ?>
		</tr>
		<?php } ?>
		<tr>
			<th>Total</th>
			<?php 
			if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno' ){ echo '<td></td>';} ?>
			<td></td>
			
			<th><?php 
			$somaHE = 0;
			for ($i=0; $i < count($horaExtra); $i++) { 
				$somaHE = $somaHE + $horaExtra[$i];
			}
			if ($somaHE < 10) {
				echo '0'.$somaHE.':00';
			}else{
				echo $somaHE.':00';
			}
			?></th>
			<td></td>
			<td></td>
		</tr>
	</table>
	<div id="cont">(<?php echo $contExtra.'/'.count($extraInsc); ?>)</div>
</div>
<?php } ?>
<br><br>

<div class="title"><h2>Projeto <?php echo date('Y'); ?></h2></div>
<?php 
	$projeto = DBread('projetos', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY status ASC", "id, titulo, npacce, status");
	if ($projeto == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
		?>
		<div class="tabela">
			<table>
				<tr>
					<th>Título</th>
					<th>Status</th>
				</tr>
				<?php 
				for ($i=0; $i < count($projeto); $i++) { 
				?>
				<tr>
					<td title="<?php echo $projeto[$i]['titulo']; ?>"><?php echo texto($projeto[$i]['titulo'], 30); ?></td>
					<td><?php if($projeto[$i]['status'] == 1){echo 'Ativo';}else{echo 'Inativo';} ?></td>
				</tr>
				<?php }?>
			</table>
		</div>
		<div id="cont">(<?php echo count($projeto); ?>)</div>
		<?php
	}


?>

<br><br>

<div class="title"><h2>Horário de Encontro de Célula</h2></div>
<?php 
		$horario = DBread('horario_celula', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY registro DESC");
		if ($horario == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
	?>
	<div class="tabela">
		<table>
			<tr>
				<th>Título</th>
				<th>Campus</th>
				<th>Local</th>
				<th>Dia e Hora</th>
				<th>Semestre</th>
				<th>Status</th>
			</tr>
			<?php 
				for ($i=0; $i < count($horario); $i++) { 
			?>
			<tr>
				<td><?php echo texto($horario[$i]['titulo'], 30); ?></td>
				<td><?php echo $horario[$i]['campus']; ?></td>
				<td><?php echo $horario[$i]['bloco'].' - '.$horario[$i]['sala']; ?></td>
				<td><?php echo $horario[$i]['diaSemana']; ?> | <?php echo date('H:i', strtotime($horario[$i]['inicio'])).'hr'; ?> - <?php echo date('H:i', strtotime($horario[$i]['fim'])).'hr'; ?>
				<?php 
					if ($horario[$i]['diaSemana2'] != 1) {
						echo '<br>'.$horario[$i]['diaSemana2'].' | '. date('H:i', strtotime($horario[$i]['inicio2'])).'hr - '.date('H:i', strtotime($horario[$i]['fim2'])).'hr';
					}
				?>
				</td>
				<td><?php echo $horario[$i]['semestre']; ?></td>
				<td><?php if($horario[$i]['status'] == 1){echo "Ativo";}else{echo "Inativo";} ?></td>
			</tr>
			<?php }?>
		</table>
	</div>
	<div id="cont">(<?php echo count($horario); ?>)</div>
<?php } ?>

<br><br>

<div class="title"><h2>Encontros de Célula</h2></div>

<?php 
		$enc = DBread('enc_celula', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC", "id, titulo, reuniao, semana, ch, registro");

		if ($enc == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
	?>
	<div class="tabela">
		<table>
			<tr>
				<th>Título</th>
				<th>Semana</th>
				<th>Horas</th>
				<th>Situação</th>
				<th>Registro</th>
			</tr>
			<?php 
				for ($i=0; $i < count($enc); $i++) { 
			?>
			<tr>
				<td><?php echo texto($enc[$i]['titulo'], 30	); ?></td>
				<td><?php if($enc[$i]['semana'] < 10){ echo '0'.$enc[$i]['semana'];}else{ echo $enc[$i]['semana'];}  ?></td>
				<td><?php echo date('H:i', strtotime($enc[$i]['ch'])).'hr'; ?></td>
				<td><?php if($enc[$i]['reuniao'] == 1){ echo 'Sim, me reuni com a equipe';}else if($enc[$i]['reuniao'] == 2){ echo 'Não houve nenhuma atividade';}else if($enc[$i]['reuniao'] == 3){ echo 'Não, mas trabalhei para a célula';} ?></td>
				<td><?php echo date('d/m/y', strtotime($enc[$i]['registro'])); ?></td>
			</tr>
			<?php } ?>
		</table>
		<div id="cont">(<?php echo count($enc); ?>)</div>
	</div>
	<?php
		}
	?>


<?php

if ($bolsista['tipoSlug'] == 'articulador-de-celula') {

?>

<br><br>
<div class="title"><h2>Apoio à Célula</h2></div>
<?php 
	$apoPres = DBread('apo_pres', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY codigo ASC", "id, npacce, semana, entrada, saida, presenca, codigo");
		
?>
<div class="tabela">
	<?php 
	if ($apoPres == false){
		echo '<div class="nada-encontrado"><h2>Nenhuma presença registrada ainda.</h2></div>';
	}else{
	?>
	<table border="">
		<tr>
			<th>Codigo</th>
			<th>Sala</th>
			<th>Semana</th>
			<th>Duração</th>
			<th>Situação</th>
		</tr>
		<?php
			$contApo = 0; 
			$horaApoInt = 0;
			for ($i=0; $i < count($apoPres); $i++) {
				if ($apoPres[$i]['presenca'] == 1 || $apoPres[$i]['presenca'] == 2 || $apoPres[$i]['presenca'] == 6) {
				 	$contApo++;
				 } 
		?>

		<tr>
			<td><?php echo $apoPres[$i]['codigo']; ?></td>
			<td><?php echo 'A-'.substr($apoPres[$i]['codigo'], -2); ?></td>
			<td><?php if($apoPres[$i]['semana'] >= 10){ echo $apoPres[$i]['semana'];}else{echo '0'.$apoPres[$i]['semana'];} ?></td>
			<td>
			<?php 
			$horaApo[$i] = $apoPres[$i]['saida'] - $apoPres[$i]['entrada'];
			echo '0'.$horaApo[$i].':00';
			if ($apoPres[$i]['semana'] <=4) {
				$horaApoInt++;
			}
			?>
			</td>
			<td>
			<?php if($apoPres[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($apoPres[$i]['presenca'] == 0){ echo 'Você não esteve presente, por favor faça sua reposição!';}else if($apoPres[$i]['presenca'] == 2){ echo 'Reposição aprovada!';}else if($apoPres[$i]['presenca'] == 4){ echo 'Reposição em análise';}else if($apoPres[$i]['presenca'] == 3){ echo 'Reposição precisa ser refeita';} else if ($apoPres[$i]['presenca'] == 5){ echo 'Feriado'; } else if ($apoPres[$i]['presenca'] == 6) {echo 'Falta justificada';}?>		
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th>Total</th>
			<td></td>
			<td></td>
			<th><?php if((count($horaApo)+$horaApoInt) < 10){ echo '0'.(count($horaApo)+$horaApoInt).':00';}else{echo (count($horaApo)+$horaApoInt).':00';} ?></th>
			<td></td>
		</tr>
	</table>
	<div id="cont">(<?php echo $contApo.'/'.count($apoPres); ?>)</div>
</div>
<?php } ?>
<br><br>
<div class="title"><h2>Formação</h2></div>
<?php 
	$forPres = DBread('for_pres', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC", "id, codigo, npacce, semana, entrada, saida, presenca");
?>
<div class="tabela">
<?php 
	if ($forPres == false) {
		echo '<div class="nada-encontrado"><h2>Nenhuma presença registrada ainda.</h2></div>';
	}else{
	?>

	<table border="">
		<tr>
			<th>Código</th>
			<th>Sala</th>
			<th>Semana</th>
			<th>Duração</th>
			<th>Situação</th>
		</tr>
		<?php
			$countFor = 0; 
			for ($i=0; $i < count($forPres); $i++) {
				if ($forPres[$i]['presenca'] == 1 || $forPres[$i]['presenca'] == 2 || $forPres[$i]['presenca'] == 6) {
				 	$countFor++;
				 } 
		?>
		<tr>
			<td><?php echo $forPres[$i]['codigo']; ?></td>
			<td><?php echo 'F-'.substr($forPres[$i]['codigo'], -2); ?></td>
			<td><?php if($forPres[$i]['semana'] >= 10){ echo $forPres[$i]['semana'];}else{echo '0'.$forPres[$i]['semana'];} ?></td>
			<td><?php 
				$horaFor[$i] = $forPres[$i]['saida'] - $forPres[$i]['entrada'];
				echo '0'.$horaFor[$i].':00';
			 ?></td>
			<td><?php if($forPres[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($forPres[$i]['presenca'] == 0){ echo 'Você não esteve presente, por favor faça sua reposição!';}else if($forPres[$i]['presenca'] == 2){ echo 'Reposição aprovada!';}else if($forPres[$i]['presenca'] == 4){ echo 'Reposição em análise';}else if($forPres[$i]['presenca'] == 3){ echo 'Reposição precisa ser refeita';} else if ($forPres[$i]['presenca'] == 5){ echo 'Feriado'; } else if($forPres[$i]['presenca'] == 6){echo 'Falta justificada';}?>
				
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th>Total</th>
			<td></td>
			<td></td>
			<th><?php 
			$somaHF = 0;
			for ($i=0; $i < count($horaFor); $i++) { 
				$somaHF = $somaHF + $horaFor[$i];
			}
			if ($somaHF < 10) {
				echo '0'.$somaHF.':00';
			}else{
				echo $somaHF.':00';
			}
			?></th>
			<td></td>
		</tr>
	</table>
	<div id="cont">(<?php echo $countFor.'/'.count($forPres);?>)</div>
</div>
<?php } ?>
<br><br>
<div class="title"><h2>História de Vida</h2></div>
<?php 
	$rodPres = DBread('rod_pres', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY codigo ASC", "id, npacce, semana, entrada, saida, presenca, codigo");
?>
<div class="tabela">

<?php 
	if ($rodPres == false){
		echo '<div class="nada-encontrado"><h2>Nenhuma presença registrada ainda.</h2></div>';
	}else{

	?>
	<table border="">
		<tr>
			<th>Codigo</th>
			<th>Sala</th>
			<th>Semana</th>
			<th>Duração</th>
			<th>Situação</th>
		</tr>
		<?php 
			$contRod = 0;
			for ($i=0; $i < count($rodPres); $i++) { 
				if ($rodPres[$i]['presenca'] == 1 || $rodPres[$i]['presenca'] == 2 || $rodPres[$i]['presenca'] == 6) {
					$contRod++;
				}
		?>
		<tr>
			<td><?php echo $rodPres[$i]['codigo']; ?></td>
			<td><?php echo 'H-'.substr($rodPres[$i]['codigo'], -2); ?></td>
			<td><?php if($rodPres[$i]['semana'] >= 10){ echo $rodPres[$i]['semana'];}else{echo '0'.$rodPres[$i]['semana'];} ?></td>
			<td>
			<?php 
			$horaRod[$i] = $rodPres[$i]['saida'] - $rodPres[$i]['entrada'];
			echo '0'.$horaRod[$i].':00';
			?>
			</td>
			<td><?php if($rodPres[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($rodPres[$i]['presenca'] == 0){ echo 'Você não esteve presente, por favor faça sua reposição!';}else if($rodPres[$i]['presenca'] == 2){ echo 'Você não esteve presente, mas efetuou a reposição!';}else if($rodPres[$i]['presenca'] == 6){echo 'Falta justificada';} else{ echo 'Feriado'; } ?></td>
		</tr>
		<?php } ?>
		<tr>
			<th>Total</th>
			<td></td>
			<td></td>
			<th><?php 
			$somaHH = 0;
			for ($i=0; $i < count($horaRod); $i++) { 
				$somaHH = $somaHH + $horaRod[$i];
			}
			if ($somaHH < 10) {
				echo '0'.$somaHH.':00';
			}else{
				echo $somaHH.':00';
			}
			 ?></th>
			<td></td>
		</tr>
	</table>
	<div id="cont">(<?php echo $contRod.'/'.count($rodPres); ?>)</div>
</div>
<?php } ?>

<?php 
}
?>
<br><br>
<div class="title" id="interacao"><h2>Interação</h2></div>
<?php 
	$intInsc 	= DBread('int_insc', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
	if ($intInsc == false) {
		echo '<div class="nada-encontrado"><h2>Não há histórico registrado.</h2></div>';
	}else{
?>
<div class="tabela">
	<table border="">
		<tr>
			<th>Código:</th>
			<th>Título:</th>
			<th>Semana:</th>
			<th>Duração:</th>
			<th>Situação:</th>
			<?php if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno' ){ echo '<th>Opções</th>';} ?>
		</tr>
		<?php 
		$contInt = 0;
		for ($i=0; $i < count($intInsc); $i++) { 
			if ($intInsc[$i]['presenca'] == 1 || $intInsc[$i]['presenca'] == 6 ) {
				$contInt++;
			}
		?>
		<tr>
			<td><?php echo $intInsc[$i]['codigo']; ?></td>
			<td title="<?php echo $intInsc[$i]['titulo']; ?>"><?php echo texto($intInsc[$i]['titulo'],30); ?></td>
			
			<td><?php if($intInsc[$i]['semana'] >=10){echo $intInsc[$i]['semana'];}else{ echo '0'.$intInsc[$i]['semana'];} ?></td>
			<td><?php 
				$horaInt[$i] = $intInsc[$i]['saida'] - $intInsc[$i]['entrada'];
				echo '0'.$horaInt[$i].':00';
			 ?></td>
			<td><?php if($intInsc[$i]['situacao'] == 0){ echo 'Você está inscrito!';}else if($intInsc[$i]['situacao'] == 1){ echo 'Você esteve presente!';}else if($intInsc[$i]['situacao'] == 6){echo 'Falta justificada';}else{echo 'Você faltou essa atividade!';} ?></td>
			<?php 
			if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno' ){ ?> <td><a href="<?php echo  $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?confirmInteracao='.$intInsc[$i]['codigo']; ?>"><img  src="<?php echo URL_PAINEL; ?>imagens/delete.gif" style="cursor: pointer;"></a></td> <?php } ?>
		</tr>
		<?php } ?>
		<tr>
			<th>Total</th>
			<?php 
			if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno' ){ echo '<td></td>';} ?>
			<td></td>
			
			<th><?php 
			$somaHI = 0;
			for ($i=0; $i < count($horaInt); $i++) { 
				$somaHI = $somaHI + $horaInt[$i];
			}
			if ($somaHI < 10) {
				echo '0'.$somaHI.':00';
			}else{
				echo $somaHI.':00';
			}
			?></th>
			<td></td>
			<td></td>
		</tr>
	</table>
	<div id="cont">(<?php echo $contInt.'/'.count($intInsc); ?>)</div>
</div>
<?php } ?>
<br><br>
<div class="title"><h2>Apreciação de Memoriais</h2></div>
<?php 
	$apr = DBread('apr_me', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
	if ($apr == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
?>
	<div class="tabela">
		<table>
			<tr>
				<th>Remetente:</th>
				<th>Destinatário:</th>
				<th>Semana:</th>
				<th>Situação:</th>
			</tr>
			<?php 
			for ($i=0; $i < count($apr); $i++) { 
				$npacce = DBread('bolsistas', "WHERE npacce = '".$apr[$i]['npacce1']."'", "id, nome, nomeUsual");
			?>
			<tr>
				<td>Você</td>
				<td><?php echo GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']); ?></td>
				<td><?php if($apr[$i]['semana'] < 10){ echo '0'.$apr[$i]['semana'];}else{echo $apr[$i]['semana'];} ?></td>
				<td><?php if($apr[$i]['contador'] == 1){echo 'Eu contei minha História de Vida';}else{echo 'Eu li/ouvi uma História de Vida';} ?></td>
			</tr>
			<?php 
				}
			?>
		</table>
	</div>
	<div id="cont">(<?php echo count($apr); ?>)</div>
<?php
	}
?>
<br><br>
<div class="title"><h2>Reposição de Atividades</h2></div>
<?php 
	$forRep = DBread('for_pres', "WHERE npacce = '".$bolsista['npacce']."' AND presenca = 0 OR npacce ='".$bolsista['npacce']."' AND presenca = 2", "id, codigo, semana, presenca, npacce");
	$rodRep = DBread('rod_pres', "WHERE npacce = '".$bolsista['npacce']."' AND presenca = 0 OR npacce = '".$bolsista['npacce']."' AND presenca = 2", "id, codigo, semana, presenca, npacce");
	$apoRep = DBread('apo_pres', "WHERE npacce = '".$bolsista['npacce']."' AND presenca = 0 OR npacce = '".$bolsista['npacce']."' AND presenca = 2", "id, codigo, semana, presenca, npacce");
	$intRep = DBread('int_insc', "WHERE npacce = '".$bolsista['npacce']."' AND presenca = 0 OR npacce = '".$bolsista['npacce']."' AND presenca = 2", "id, codigo,semana, situacao, npacce");
	$extRep = DBread('extra_insc', "WHERE npacce = '".$bolsista['npacce']."' AND presenca = 0 OR npacce = '".$bolsista['npacce']."' AND presenca = 2", "id, codigo,semana, situacao, npacce");
	
	$cont = 5;

	if ($forRep == false) {
		$cont--;	
	}
	if ($rodRep == false) {
		$cont--;	
	}
	if ($apoRep == false) {
		$cont--;	
	}
	if ($intRep == false) {
		$cont--;	
	}
	if ($extRep == false) {
		$cont--;	
	}
	if ($cont == 0) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div><br>';
	}else{
		?>
		<div class="tabela">
			<table>
				<tr>
					<th>Código da Atividade</th>
					<th>Semana</th>
					<th>Situação</th>
				</tr>
				<?php 
				if ($forRep == true) {
					for ($i=0; $i < count($forRep); $i++) { 
				?>
				<tr>
					<td><?php echo $forRep[$i]['codigo']; ?></td>
					<td><?php if($forRep[$i]['semana'] < 10){echo '0'.$forRep[$i]['semana'];}else{ echo $forRep[$i]['semana'];} ?></td>
					<td><?php if($forRep[$i]['presenca'] == 1 || $forRep[$i]['presenca'] == 6){ echo 'Esteve presente!';}else if($forRep[$i]['presenca'] == 0){ echo 'Não esteve presente, precisa fazer reposição!';}else if($forRep[$i]['presenca'] == 2){ echo 'Não esteve presente, mas efetuou a reposição!';} ?></td>
				</tr>
				<?php } }?>
				<?php 
					if ($rodRep == true) {	
					for ($i=0; $i < count($rodRep); $i++) { 
				?>
				<tr>
					<td><?php echo $rodRep[$i]['codigo']; ?></td>
					<td><?php if($rodRep[$i]['semana'] < 10){echo '0'.$rodRep[$i]['semana'];}else{ echo $rodRep[$i]['semana'];} ?></td>
					<td><?php if($rodRep[$i]['presenca'] == 1 || $rodRep[$i]['presenca'] == 6){ echo 'Esteve presente!';}else if($rodRep[$i]['presenca'] == 0){ echo 'Não esteve presente, precisa fazer reposição!';}else if($rodRep[$i]['presenca'] == 2){ echo 'Não esteve presente, mas efetuou a reposição!';} ?></td>
				</tr>
				<?php } }?>
				<?php 
				if ($apoRep == true) {
					for ($i=0; $i < count($apoRep); $i++) { 
				?>
				<tr>
					<td><?php echo $apoRep[$i]['codigo']; ?></td>
					<td><?php if($apoRep[$i]['semana'] < 10){echo '0'.$apoRep[$i]['semana'];}else{ echo $apoRep[$i]['semana'];} ?></td>
					<td><?php if($apoRep[$i]['presenca'] == 1 || $apoRep[$i]['presenca'] == 6){ echo 'Esteve presente!';}else if($apoRep[$i]['presenca'] == 0){ echo 'Não esteve presente, precisa fazer reposição!';}else if($apoRep[$i]['presenca'] == 2){ echo 'Não esteve presente, mas efetuou a reposição!';} ?></td>
				</tr>
				<?php } }?>
				<?php 
					if ($intRep == true) {
					for ($i=0; $i < count($intRep); $i++) { 
				?>
				<tr>
					<td><?php echo $intRep[$i]['codigo']; ?></td>
					<td><?php if($intRep[$i]['semana'] < 10){echo '0'.$intRep[$i]['semana'];}else{ echo $intRep[$i]['semana'];} ?></td>
					<td> <?php if($intRep[$i]['situacao'] == 0){ echo 'Você está inscrito!';}else if($intRep[$i]['situacao'] == 1 || $intRep[$i]['situacao'] == 6){ echo 'Você esteve presente!';}else{echo 'Você faltou essa atividade!';} ?></td>
				</tr>
				<?php } }?>
				<?php 
					if ($extRep == true) {
					for ($i=0; $i < count($extRep); $i++) { 
				?>
				<tr>
					<td><?php echo $extRep[$i]['codigo']; ?></td>
					<td><?php if($extRep[$i]['semana'] < 10){echo '0'.$extRep[$i]['semana'];}else{ echo $extRep[$i]['semana'];} ?></td>
					<td> <?php if($extRep[$i]['situacao'] == 0){ echo 'Você está inscrito!';}else if($extRep[$i]['situacao'] == 1 || $extRep[$i]['situacao'] == 6){ echo 'Você esteve presente!';} else{echo 'Você faltou essa atividade!';} ?></td>
				</tr>
				<?php } }?>
			</table>
		</div>
		<?php
	}
if ($bolsista['tipoSlug'] != 'articulador-de-celula'){

?>
	<br><br>
	<div class="title"><h2>Relatório de Comissão</h2></div>
	<?php 
	$ati = DBread('ati_com', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
	if ($ati == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';		
	}else{
?>
	<div class="tabela">
		<table>
			<tr>
				<th>Comissão:</th>
				<th>Situação:</th>
				<th>Semana:</th>
				<th>Horas:</th>
				<th>Registro:</th>
			</tr>
			<?php 
				for ($i=0; $i < count($ati); $i++) { 

			?>
			<tr>
				<td><?php echo $ati[$i]['comissao']; ?></td>
				<td><?php echo $ati[$i]['trabalhou']; ?></td>
				<td><?php if($ati[$i]['semana'] < 10){ echo '0'.$ati[$i]['semana'];}else{echo $ati[$i]['semana'];} ?></td>
				<td><?php echo date('H:i', strtotime($ati[$i]['ch'])).'hr'; ?></td>
				<td><?php echo date('d/m/y', strtotime($ati[$i]['registro'])); ?></td>
			</tr>
			<?php }?>
			<tr>
				<th>Total</th>
				<td></td>
				<td></td>
				<th><?php
				$horas = 0;
				for ($i=0; $i < count($ati); $i++) { 
				 	$horas = $horas + $ati[$i]['ch'];
				 } 
				 echo $horas.':00';
				?></th>
				<td></td>
			</tr>
			
		</table>
		<div id="cont"><?php echo '('.count($ati).')'; ?></div>
	</div>
<?php
	}
?>
<br><br>
<div class="title"><h2>Presenças em Reunião</h2></div>
<?php
	$comPres = DBread('av_comissao', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
	if ($comPres == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div><br>';
	}else{
	?>
		<div class="tabela">
			<table>
				<tr>
					<th>Código</th>
					<th>Semana</th>
					<th>Horas</th>
					<th>Situação</th>
				</tr>
				<?php 
					$contCom = 0;
					for ($i=0; $i < count($comPres); $i++) { 
						$auxSaida = explode(":", $comPres[$i]['saida']);
						$auxEntrada = explode(":", $comPres[$i]['entrada']);
						if ($comPres[$i]['presenca'] == 1 || $comPres[$i]['presenca'] == 2) {
							$contCom++;
						}
				?>
				<tr>
					<td><?php echo $comPres[$i]['codigo']; ?></td>
					<td><?php if($comPres[$i]['semana'] < 10){ echo '0'.$comPres[$i]['semana'];}else{ echo $comPres[$i]['semana'];} ?></td>
					<td><?php echo $auxSaida[0] - $auxEntrada[0].':00'; ?></td>
					<td><?php if($comPres[$i]['presenca'] == 1){ echo 'Esteve presente!';}else if($comPres[$i]['presenca'] == 0){ echo 'Não esteve presente!';}else if($comPres[$i]['presenca'] == 2){ echo 'Não esteve presente, mas efetuou a reposição!';}else if($comPres[$i]['presenca'] == 3){ echo 'Feriado';} ?></td>
				</tr>
				<?php }?>
				<tr>
					<th>Total</th>
					<td></td>
					<th><?php 
					$horas = 0;
					for ($i=0; $i < count($comPres); $i++) {
						
						$horas = $horas + ($auxSaida[0] - $auxEntrada[0]);
					}
					echo $horas.':00';
					?></th>
					<td></td>
				</tr>
			</table>
			<div id="cont">(<?php echo $contCom.'/'.count($comPres); ?>)</div>
		</div>
	<?php
	}
}
?>

<br><br>
<div class="title"><h2>Justificativa de Faltas</h2></div>
<?php 
	$just = DBread('just_ativ', "WHERE npacce ='".$bolsista['npacce']."'", "id, codigo, npacce, semana, registro, justificativa, situacao");
	if ($just == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div><br>';
	}else{
	?>
		<div class="tabela">
			<table>
				<tr>
					<th>Código da Atividade</th>
					<th>Semana</th>
					<th>Situação</th>
					<th>Registro</th>
				</tr>
				<?php 
					for ($i=0; $i < count($just); $i++) { 
				?>
				<tr>
					<td title="<?php echo $just[$i]['codigo']; ?>"><?php echo $just[$i]['codigo']; ?></td>
					<td><?php if($just[$i]['semana']){ echo '0'.$just[$i]['semana'];}else{ echo $just[$i]['semana'];} ; ?></td>
					<td title="<?php echo $just[$i]['justificativa']; ?>">
					<?php if($just[$i]['situacao'] == 1)
						echo "Justificativa Aprovada";
						elseif($just[$i]['situacao'] == 2)
						 echo "Justificativa Reprovada"; 
						else{echo"Justificativa em Análise"; } ?> </td>
					<td><?php echo date('d/m/y H:i', strtotime($just[$i]['registro'])).'hr'; ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	<?php
	}
	if ($bolsista['situacao'] == 1) {
	
		//Para vizualizar seu trio
		$trios = DBread('encontros_trios', "WHERE npacce1 = '".$bolsista['npacce']."' OR npacce2 = '".$bolsista['npacce']."' OR npacce3= '".$bolsista['npacce']."' OR npacce4 = '".$bolsista['npacce']."'");
		
		if ($trios == false) {
			
		}else{
		
		?>
		<div class="title"><h2>Trio Cadastrado</h2></div>
			<div class="tabela">
				
				<?php 
					for ($i=0; $i < count($trios); $i++) { 
						
				?>
				<table>
				<tr>
					<th>Trio</th>
					<th>NPACCE</th>
					<th>Membros</th>
					<th>Título</th>
					
				</tr>
				<tr>
					<td> <?php echo $trios[$i]['trioSlug']; ?></td>
					<td><?php echo $trios[$i]['npacce1']; ?></td>
					<td><?php echo $trios[$i]['nome1']; ?></td>
					<td title="<?php echo $trios[$i]['titulo']; ?>"><?php echo texto($trios[$i]['titulo'], 30); ?></td>
				</tr>
				<tr>
					<td> <meta> </td>
					<td><?php echo $trios[$i]['npacce2']; ?></td>
					<td><?php echo $trios[$i]['nome2']; ?></td>
					<td> <meta> </td>
				</tr>
				<?php
					//Verifica se existe o terceiro membro 
					if ($trios[$i]['npacce3'] != '' || $trios[$i]['npacce3'] != NULL) {
				?>
				<tr>
					<td> <meta> </td>
					<td><?php echo $trios[$i]['npacce3']; ?></td>
					<td><?php echo $trios[$i]['nome3']; ?></td>
					<td> <meta> </td>
				</tr>
				<?php
					}
					//Verifica se existe o quarto membro
					if ($trios[$i]['npacce4'] != '' || $trios[$i]['npacce4'] != NULL) {
				?>
				<tr>
					<td> <meta> </td>
					<td><?php echo $trios[$i]['npacce4']; ?></td>
					<td><?php echo $trios[$i]['nome4']; ?></td>
					<td> <meta> </td>
				</tr>
				<?php
					}
				?>
				</table>
				<table style="margin-top: 0px;">
				<tr>
					<th>Resumo </th>
					<th>Esqueleto </th>
					<th>Introdução </th>
					<th>Ref. Teórico </th>
					<th>Metodologia </th>
					<th>Resultados </th>
					<th>Conclusão </th>
					<th>Bibliografia </th>
					<th>Artigo </th>
					<th>Slide </th>
				</tr>
				<tr>
					<td>
					<?php if($trios[$i]['resumo'] != '' || $trios[$i]['resumo'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					
					</td>
					<td><?php if($trios[$i]['esqueleto'] != '' || $trios[$i]['esqueleto'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['introducao'] != '' || $trios[$i]['introducao'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['refTeorico'] != '' || $trios[$i]['refTeorico'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['metodologia'] != '' || $trios[$i]['metodologia'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['resultados'] != '' || $trios[$i]['resultados'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['conclusao'] != '' || $trios[$i]['conclusao'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['bibliografia'] != '' || $trios[$i]['bibliografia'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['artigo'] != '' || $trios[$i]['artigo'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['slide'] != '' || $trios[$i]['slide'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
				</tr>
				</table>
				<?php

				} 
				?>
			</div>
		<?php } ?>
<br><br>
<div class="title"><h2>Resultados da Folha de Pagamento</h2></div>
<div class="tabela">
	<table>
		<tr>
			<th>Mês</th>
			<th>Pendências</th>
			<th>Resultado</th>
		</tr>

		<?php 
		//Abril
		$folha = DBread('folha_abril', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Abril</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim abril
		?>
		<?php 
		//Maiio
		$folha = DBread('folha_maio', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Maio</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim maio
		?>
		<?php 
		//JUNHO
		$folha = DBread('folha_junho', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Junho</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim JUNHO
		?>
		<?php 
		//Julho
		$folha = DBread('folha_julho', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Julho</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim JULHO
		?>
		<?php 
		//agosto
		$folha = DBread('folha_agosto', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Agosto</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim agosto
		?>

		<?php 
		//setembro
		$folha = DBread('folha_setembro', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Setembro</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim setembro
		?>
		<?php 
		//outubro
		$folha = DBread('folha_outubro', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Outubro</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim outubro
		?>
		<?php 
		//Novembro
		$folha = DBread('folha_novembro', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Novembro</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim novembro
		?>
		<?php 
		//Dezembro
		$folha = DBread('folha_dezembro', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Dezembro</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim dezembro
		?>
		<?php 
		//Final
		$folha = DBread('folha_final', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY nome ASC");
		if ($folha == true) {
		?>
		<tr>
			<td>Dezembro</td>
			<td>
				<?php 
					if ($folha[0]['obs'] == '' || $folha[0]['obs'] == null) {
						echo 'Nenhuma Pendência';
					}else{
						echo $folha[0]['obs'];
					}
				?>
			</td>
			<td> --- </td>
		</tr>
		<?php
		}//fim final
		?>
		
	</table>
</div>
<?php } ?>
</div>
	
</div>
</div>