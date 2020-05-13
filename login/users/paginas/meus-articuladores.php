
<div class="title"><h2>Meus Articuladores</h2></div>
<p>Página destinada ao acompanhamento dos relatórios de Célula dos articuladores.</p>
<br>

<div id="pesquisa">
	<form action="" method="get" enctype="multipart/form-data">
		<input type="text" name="pesquisar" OnKeyPress="" value="<?php if(isset($_GET['pesquisar'])){ echo $_GET['pesquisar'];} ?>"  placeholder="Digite o número pacce ou o nome de quem você quer procurar"></input>
	</form>
</div>
<br>
<div class="title"><h2>Articuladores</h2></div>
<?php
	if (isset($url[2]) && $url[2] != '') {
		$bolsista = DBread('bolsistas', "WHERE npacce = '".$url[2]."' AND status = true AND tipoSlug = 'articulador-de-celula'", "id, npacce, nome, nomeUsual, foto, tipo, curso, campus");
		
		if ($bolsista == false) {
			echo '<div class="nada-encontrado">Nada Encontrado</div>';
		}else{
			$bolsista = $bolsista[0];
	?>
		<br>
			<div class="title"><h2>Avaliação do Articulador</h2></div>
			<div class="page-ati-single">
				<div class="corpo-single">
					<div class="foto-single" style="float: left;">
						<span class="foto"><img src="<?php echo URL_PAINEL.'imagensBolsistas/'.$bolsista['foto'].'';?>"><br></span>
						<div class="nome"><?php echo GetName($bolsista['nome'], $bolsista['nomeUsual']); ?></div>
					</div>
				</div>
				<div id="folha-cabecario" style="width: 50%; float: left;">
					<table style="font-size: 15px; margin-top:20px; float: left;">
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
					</table>
				</div>
				<div id="clear"></div>
			</div>
			<br>
	<?php
			echo '<div class="title"><h2>Horário da Célula</h2></div>';
			$horario = DBread('horario_celula', "WHERE npacce = '".$bolsista['npacce']."' AND status = true");
			if ($horario == false) {
				echo '<div class="nada-encontrado"><h2>Não há célula cadastrada</h2></div>';
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
				<?php
					}
				echo '<br><br><div class="title"><h2>Encontro de Célula</h2></div>';

				// ================== Para a Oberseção ==============
				$obs = DBread('obs_av', "WHERE npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'encontro-de-celula'");
				
				$enc = DBread('enc_celula', "WHERE npacce = '".$bolsista['npacce']."'");
				if ($enc == false) {
					echo '<div class="nada-encontrado"><h2>Não há célula cadastrada</h2></div>';
				}else{

				?>
				<div class="tabela">
					<table>
						<tr>
							<th></th>
							<th>Reunião</th>
							<th>Data</th>
							<th>CH</th>
							<th>Membros</th>
							<th>Pilares</th>
							<th title="Pontualidade e Assiduidade do Grupo">A</th>
							<th title="Aproveitamento do Tempo" >B</th>
							<th title="Responsabilidade do grupo">C</th>
							<th title="Colaboração dos membros (habilidades)">D</th>
							<th title="Nível de interesse no aprendizado do grupo (interação)">E</th>
							<th title="Nível de participação no Processamento de Grupo">F</th>
							<th title="Quanto cumpriu do planejado">G</th>
							<th>Relato</th>
							<th>Atividade</th>
						</tr>
						<?php 
							for ($i=0; $i < count($enc); $i++) { 
						?>
						<tr>
							<td>Semana <?php if($enc[$i]['semana'] <= 10){ echo '0'.$enc[$i]['semana'];}else{ echo $enc[$i]['semana'];} ?></td>
							<td><?php
							if ($enc[$i]['reuniao'] == 1) {
								echo 'Houve reunião';
							}else if ($enc[$i]['reuniao'] == 2) {
								echo 'Não houve <br> nenhuma atividade';
							}else if ($enc[$i]['reuniao'] == 3) {
								echo 'Não houve atividade, <br> mas trabalhou';
							} 
							 ?></td>
							<td><?php if($enc[$i]['reuniao'] == 2 || $enc[$i]['reuniao'] == 3){ echo '--/--/--';}else{ echo date('d/m/y', strtotime($enc[$i]['data']));} ?></td>
							<td><?php if($enc[$i]['reuniao'] == 2){ echo '--:--';}else{ echo date('H:i', strtotime($enc[$i]['ch']));} ?></td>
							<td title="<?php echo $enc[$i]['membros']; ?>"> <meto> </td>
							<td title="<?php echo $enc[$i]['pilares']; ?>"> <meto> </td>
							<td><?php echo $enc[$i]['pontualidade']; ?></td>
							<td><?php echo $enc[$i]['aproveitamento']; ?></td>
							<td><?php echo $enc[$i]['responsabilidade']; ?></td>
							<td><?php echo $enc[$i]['colaboracao']; ?></td>
							<td><?php echo $enc[$i]['interesse']; ?></td>
							<td><?php echo $enc[$i]['participacao']; ?></td>
							<td><?php echo $enc[$i]['planejado']; ?></td>
							<td title="<?php echo $enc[$i]['relato']; ?>"> <meto> </td>
							<td title="<?php echo $enc[$i]['atividades']; ?>"> <meto> </td>
						</tr>
						<?php } ?>
					</table>
					<div id="editar-ativ" class="form">
						<form method="post">
							<label class="label">Observação</label>
							<br><br>
							<div name="obs"><?php if($obs == true){ echo $obs[0]['obs'];}else{ echo 'Nenhuma Observação foi feita ainda.';} ?></div>
						</form>
					</div>
				</div>

		<?php
			}

		}//FIM BOLSISTA
	}else{
		$salas = DBread('apo_salas', "WHERE npacce1 = '".$user['npacce']."'");
		if ($salas == false) {
			echo '<div class="nada-encontrado"><h2>Você não tem nehuma sala.</h2></div>';
		}else{
			?>
			<div class="tabela">
		<table>
			<tr>
				<th>Número PACCE</th>
				<th>Nome</th>
				<th>Sala</th>
			</tr>
			<?php
			for ($i=0; $i < count($salas); $i++) { 
				$insc = DBread('apo_insc', "WHERE sala = '".$salas[$i]['sala']."'");
				if ($insc == false) {
					echo '<tr><td>Não há inscritos na sala '.$salas[$i]['sala'].'</td></tr>';
				}else{
					for ($j=0; $j < count($insc); $j++) { 
				?>
					<tr>
						<td> <?php echo $insc[$j]['npacce']; ?> </td>
						<td><a href="<?php echo $way.'/'.$url[1].'/'.$insc[$j]['npacce']; ?>"><?php echo $insc[$j]['nomeCompleto']; ?></a></td>
						<td><?php echo $insc[$j]['sala']; ?></td>
					</tr>
				<?php
					}
				}
			}
			?>
		</table>
		</div>
			<?php
		}
}
?>