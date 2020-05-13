<?php 
  require_once '../../../sistema/system.php';

if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
	//EXCKUIR INTERAÇAO

	//ALTERAR ATIVIDADE COLETIVAS
}
?>
<meta charset="UTF-8">
<div class="title"><h2>Relatório Individual - PACCE -UFC</h2></div>

<?php 
// if (isset($url[3])) {
// 	$bolsista = DBread('bolsistas', "WHERE npacce = '".trim($url[3])."'", "id, npacce, nome, nomeUsual, tipo, tipoSlug ,curso, campus, status, sexo, foto, situacao");
// 	$bolsista = $bolsista[0];
// }else{
	if (isset($_GET['npacce'])) {
		
		$bolsista = DBread('bolsistas', "WHERE npacce = '".$_GET['npacce']."'", "id, npacce, nome, nomeUsual, tipo, tipoSlug ,curso, campus, status, sexo, foto, situacao");

	}else{
		$nome = 'B150082';
		$bolsista = DBread('bolsistas', "WHERE npacce = '".$nome."'", "id, npacce, nome, nomeUsual, tipo, tipoSlug ,curso, campus, status, sexo, foto, situacao");

	}
	$bolsista = $bolsista[0];
// }
?>

<div id="folha-cabecario">
	<table border="">
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

<?php 
 $relato = DBread('relato', "WHERE npacce = '".$bolsista['npacce']."'");
 if ($relato == false) {
 	
 }else{
?>
<div class="title"><h2>Relato de Experiência</h2></div>
<div class="tabela">
	<table border="">
		
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

<div id="atividade-coletiva"></div>
<div class="title"><h2>Atividades Coletivas</h2></div>
<?php 
	$atColetiva = DBread('eventos_pres', "WHERE npacce = '".$bolsista['npacce']."'");
	if ($atColetiva == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
?>
<div class="tabela">
	<table border="">
		<tr>
			<th>Código</th>
			<th>Evento</th>
			<th>Data</th>
			<th>Entrada</th>
			<th>Saída</th>
			<th>Duração</th>
			<th>Situação</th>
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
			<td><?php echo 'yay'; ?></td>
			<td><?php if($atColetiva[$i]['presenca'] == 0){ echo 'Não esteve presente, efetue sua reposição!';}else if($atColetiva[$i]['presenca'] == 1){ echo 'Esteve presente!';}else if($atColetiva[$i]['presenca'] == 2){ echo 'Saída não registrada!';}else if($atColetiva[$i]['presenca'] == 3){ echo 'Reposição aprovada!';}else if($atColetiva[$i]['presenca'] == 4){ echo 'Reposição em análise!';}else{ echo 'Reposição reprovada, Por favor faça novamente!';} ?></td>
			
		</tr>
		<?php } ?>
		<tr>
			<th>Total</th>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
			<td> 
				<?php $i = $i*4;
				if($i < 9){ echo '0'.$i.':00'; }else{ echo $i.':00'; } ?>
			</td>
			
		</tr>
	</table>
	<div id="cont">(<?php echo $contAtCol.'/'.count($atColetiva); ?>)</div>
</div>
<?php } ?>


<?php 
	if ($bolsista['tipoSlug'] == 'articulador-de-celula') {
?>


<div class="title"><h2>Encontros de Célula</h2></div>

<?php 
		$enc = DBread('enc_celula', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC", "id, titulo, reuniao, semana, ch");

		if ($enc == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
	?>
	<div class="tabela">
		<table border="">
			<tr>
				<th>Título</th>
				<th>Semana</th>
				<th>Horas</th>
				<th>Situação</th>
			</tr>
			<?php 
				for ($i=0; $i < count($enc); $i++) { 
			?>
			<tr>
				<td><?php echo texto($enc[$i]['titulo'], 30	); ?></td>
				<td><?php if($enc[$i]['semana'] < 10){ echo '0'.$enc[$i]['semana'];}else{ echo $enc[$i]['semana'];}  ?></td>
				<td><?php echo date('H:i', strtotime($enc[$i]['ch'])); ?></td>
				<td><?php if($enc[$i]['reuniao'] == 1){ echo 'Sim, me reuni com a equipe';}else if($enc[$i]['reuniao'] == 2){ echo 'Não houve nenhuma atividade';}else if($enc[$i]['reuniao'] == 3){ echo 'Não, mas trabalhei para a célula';} ?></td>
			</tr>
			<?php } ?>
		</table>
		<div id="cont">(<?php echo count($enc); ?>)</div>
	</div>
	<?php
		}
	?>

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
			for ($i=0; $i < count($apoPres); $i++) {
				if ($apoPres[$i]['presenca'] == 1 || $apoPres[$i]['presenca'] == 2) {
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
			?>
			</td>
			<td><?php if($apoPres[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($apoPres[$i]['presenca'] == 0){ echo 'Você não esteve presente';}else if($apoPres[$i]['presenca'] == 2){ echo 'Reposição aprovada!';}else if($apoPres[$i]['presenca'] == 4){ echo 'Reposição em análise!';}else if($apoPres[$i]['presenca'] == 3){ echo 'Reposição precisa ser refeita!';}else if($apoPres[$i]['presenca'] == 5){ echo 'Feriado';} ?></td>
		</tr>
		<?php } ?>
		<tr>
			<th>Total</th>
			<td></td>
			<td></td>
			<th><?php if(count($horaApo) < 10){ echo '0'.count($horaApo).':00';}else{echo count($horaApo).':00';} ?></th>
			<td></td>
		</tr>
	</table>
	<div id="cont">(<?php echo $contApo.'/'.count($apoPres); ?>)</div>
</div>
<?php } ?>

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
				if ($forPres[$i]['presenca'] == 1 || $forPres[$i]['presenca'] == 2) {
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
			<td><?php if($forPres[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($forPres[$i]['presenca'] == 0){ echo 'Você não esteve presente';}else if($forPres[$i]['presenca'] == 2){ echo 'Reposição aprovada!';}else if($forPres[$i]['presenca'] == 4){ echo 'Reposição em análise';}else if($forPres[$i]['presenca'] == 3){ echo 'Reposição precisa ser refeita';} ?></td>
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
				if ($rodPres[$i]['presenca'] == 1 || $rodPres[$i]['presenca'] == 2) {
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
			<td><?php if($rodPres[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($rodPres[$i]['presenca'] == 0){ echo 'Você não esteve presente';}else if($rodPres[$i]['presenca'] == 2){ echo 'Você não esteve presente, mas efetuou a reposição!';} ?></td>
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
			if ($intInsc[$i]['presenca'] == 1) {
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
			<td><?php if($intInsc[$i]['situacao'] == 0){ echo 'Você está inscrito!';}else if($intInsc[$i]['situacao'] == 1){ echo 'Você esteve presente!';}else{echo 'Você faltou essa atividade!';} ?></td>
			<?php 
			if($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno' ){ ?> <td><a href="<?php echo  $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'?confirmInteracao='.$intInsc[$i]['codigo']; ?>"><img  src="<?php echo URL_PAINEL; ?>imagens/delete.gif" style="cursor: pointer;"></a></td> <?php } ?>
		</tr>
		<?php } ?>
		<tr>
			<th>Total</th>
			<td></td>
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
			
		</tr>
	</table>
	<div id="cont">(<?php echo $contInt.'/'.count($intInsc); ?>)</div>
</div>
<?php } ?>

<div class="title"><h2>Apreciação de Memoriais</h2></div>
<?php 
	$apr = DBread('apr_me', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
	if ($apr == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
?>
	<div class="tabela">
		<table border="">
			<tr>
				<th>Remetente:</th>
				<th>Destinatário:</th>
				<th>Semana:</th>
				<th>Situação:</th>
				<th>Duração</th>
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
				<td>01:00</td>
			</tr>
			<?php 
				}
			?>
		</table>
	</div>
	<div id="cont">(<?php echo count($apr); ?>)</div>
<?php
	}

	if ($bolsista['tipoSlug'] != 'articulador-de-celula') {

?>

	<div class="title"><h2>Relatório de Comissão</h2></div>
	<?php 
	$ati = DBread('ati_com', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
	if ($ati == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';		
	}else{
?>
	<div class="tabela">
		<table border="">
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
				<td><?php echo date('H:i', strtotime($ati[$i]['ch'])); ?></td>
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

<div class="title"><h2>Presenças em Reunião</h2></div>
<?php
	$comPres = DBread('av_comissao', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
	if ($comPres == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div><br>';
	}else{
	?>
		<div class="tabela">
			<table border="">
				<tr>
					<th>Código</th>
					<th>Semana</th>
					<th>Horas</th>
					<th>Situação</th>
				</tr>
				<?php 
					$contCom = 0;
					for ($i=0; $i < count($comPres); $i++) { 
						if ($comPres[$i]['presenca'] == 1 || $comPres[$i]['presenca'] == 2) {
							$contCom++;
						}
				?>
				<tr>
					<td><?php echo $comPres[$i]['codigo']; ?></td>
					<td><?php if($comPres[$i]['semana'] < 10){ echo '0'.$comPres[$i]['semana'];}else{ echo $comPres[$i]['semana'];} ?></td>
					<td><?php echo $comPres[$i]['saida'] - $comPres[$i]['entrada'].':00'; ?></td>
					<td><?php if($comPres[$i]['presenca'] == 1){ echo 'Esteve presente!';}else if($comPres[$i]['presenca'] == 0){ echo 'Não esteve presente!';}else if($comPres[$i]['presenca'] == 2){ echo 'Não esteve presente, mas efetuou a reposição!';} ?></td>
				</tr>
				<?php }?>
				<tr>
					<th>Total</th>
					<td></td>
					<th><?php 
					$horas = 0;
					for ($i=0; $i < count($comPres); $i++) { 
						$horas = $horas + ($comPres[$i]['saida'] - $comPres[$i]['entrada']);
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
?>

<?php
}
?>
<div class="title"><h2>Total de Horas</h2></div>
	<div class="tabela">
		<table border="">
			<tr>
				<th>Mês:</th>
				<th>
					Total:
				</th>
			</tr>
			<tr>
				<td>Março</td>
				<td>
					

				</td>
			</tr>
			<tr>
				<td>Abril</td>
				<td></td>
			</tr>
		</table>
	</div>

</div>
	
</div>
</div>