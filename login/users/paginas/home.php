<!-- INÍCIO DO HOME.PHP -->



<?php 

	
	include 'paginas/aniversario.php';
	

	include 'paginas/msg.php';
?>
			<?php 
				if ($user['tipoSlug'] == 'articulador-de-celula' && !isset($_GET['action'])) {				
				

			?>
			<br><br>
			<div id="last-int">
			<?php 
				$s = $semana + 1;
				$intInsc = DBread('int_insc', "WHERE npacce = '".$user['npacce']."' AND semana = '$semana' OR npacce = '".$user['npacce']."' AND semana = '$s' ORDER BY semana ASC");
			?>
				<div class="title"> <h2><?php if(count($intInsc) > 1){ echo 'Interações da Semana';}else{ echo 'Interação da Semana';} ?></h2></div>
				<?php 
					if ($intInsc == false) {
						if ($semana < 9) {
							$s = '0'.$semana;
						}else{
							$s = $semana;
						}
						echo '<div class="nada-encontrado"><h2>Você não está inscrito em nenhuma interação nessa semana '.$s.'.</h2></div>';
					}else{						
				?>
				<div class="caixa">
					<ul>
						<?php 
						for ($i=0; $i < count($intInsc); $i++) { 
							$intCad = DBread('int_cad', "WHERE codigo = '".$intInsc[$i]['codigo']."'");

						?>
						<a href="<?php echo $way.'/atividade-de-interacao/'.$intCad[0]['codigo']; ?>">
							<li style="background-color: <?php echo $intCad[0]['cor']; ?>;">
							<div>
								<div id="box-all-info">
									<div id="all-info">
										<h3><?php echo texto($intCad[0]['titulo'], 30); ?></h3><br>
										<span><?php echo texto($intCad[0]['local'], 28); ?></span><br><br>
										<span><?php echo date('d/m', strtotime($intCad[0]['data'])); ?>
										 | <?php echo date('H:i', strtotime($intCad[0]['inicio'])).'hr'; ?> - 
										 <?php echo date('H:i', strtotime($intCad[0]['fim'])).'hr'; ?> <br> <?php echo $intCad[0]['diaSemana']; ?> </span><br><br>
										<span><?php echo $intCad[0]['bol1']; if($intCad[0]['bol2'] == ''){}else{echo ' & '.$intCad[0]['bol2'];} ?></span><br>
										<span><?php echo $intCad[0]['vagaAtual'].'/'.$intCad[0]['vagaInicial']; ?> Vagas</span>
									</div>
								</div>
								<div id="tipo">
									Interação
								</div>
							</div>
						</li>
						</a>
						<?php }?>
					</ul>
				</div>
				<?php } ?>
			</div>
			<br><br>
			<div id="other">
				<div class="title"> <h2>Outras Atividades</h2></div>
				<div class="caixa">
					<?php 
						$forInsc = DBread('for_insc', "WHERE status = true AND npacce = '".$user['npacce']."' ");
						$cont = 0;
					?>

					<ul>
					<?php 
						if ($forInsc == false) {
							$cont++;
						}else{
							for ($i=0; $i < count($forInsc); $i++) { 
								$forSalas = DBread('for_salas', "WHERE sala = '".$forInsc[$i]['sala']."'");
																
					?>
						<a href="<?php echo $way.'/formacao/'.$forSalas[0]['sala']; ?>">
						<li style="background-color: <?php echo $forSalas[0]['cor']; ?>">
							<div>
								<div id="box-all-info">
									<div id="all-info">
										<h3><?php echo $forSalas[0]['sala']; ?></h3><br>
										<span><?php echo texto($forSalas[0]['local'], 28); ?></span><br><br>
										<span><?php echo date('d/m', strtotime($forSalas[0]['dataInicio'])); ?>
										 - <?php echo date('d/m', strtotime($forSalas[0]['dataFim'])); ?> <br>
										  <?php echo date('H:i', strtotime($forSalas[0]['inicio'])).'hr'; ?> - 
										  <?php echo date('H:i', strtotime($forSalas[0]['fim'])).'hr'; ?> <br> <?php echo $forSalas[0]['diaSemana']; ?> </span><br><br>
										<span><?php echo $forSalas[0]['bol1']; ?> & <?php echo $forSalas[0]['bol2']; ?></span><br>
										<span><?php echo $forSalas[0]['vagaAtual']; ?>/<?php echo $forSalas[0]['vagaInicial']; ?> Vagas</span>
									</div>
								</div>
								<div id="tipo">
									Formação
								</div>
							</div>
						</li>
						</a>
						<?php } } ?>

						<?php 
						$rodInsc = DBread('rod_insc', "WHERE status = true AND npacce = '".$user['npacce']."' ");
						$rodSala = DBread('rod_salas', "WHERE sala = '".$rodInsc[0]['sala']."'");
					?>
					<?php 
						if ($rodInsc == false) {
							$cont++;
						}else{
					?>
						<a href="<?php echo $way.'/roda-viva/'.$rodSala[0]['sala']; ?>">
						<li style="background-color: <?php echo $rodSala[0]['cor']; ?>">
							<div>
								<div id="box-all-info">
									<div id="all-info">
										<h3><?php echo $rodSala[0]['sala']; ?></h3><br>
										<span><?php echo texto($rodSala[0]['local'], 28); ?></span><br><br>
										<span><?php echo date('d/m', strtotime($rodSala[0]['dataInicio'])); ?>
										 - <?php echo date('d/m', strtotime($rodSala[0]['dataFim'])); ?> <br>
										  <?php echo date('H:i', strtotime($rodSala[0]['inicio'])).'hr'; ?> - 
										  <?php echo date('H:i', strtotime($rodSala[0]['fim'])).'hr'; ?> <br> <?php echo $rodSala[0]['diaSemana']; ?> </span><br><br>
										<span><?php echo $rodSala[0]['bol1']; ?></span><br>
										<span><?php echo $rodSala[0]['vagaAtual']; ?>/<?php echo $rodSala[0]['vagaInicial']; ?> Vagas</span>
									</div>
								</div>
								<div id="tipo">
									Roda Viva
								</div>
							</div>
						</li>
						</a>
						<?php } ?>

						<?php 

						$apoInsc = DBread('apo_insc', "WHERE status = true AND npacce = '".$user['npacce']."' ");
						$apoSalas = DBread('apo_salas', "WHERE sala = '".$apoInsc[0]['sala']."'");
					
						if ($apoInsc == false) {
							$cont++;
						}else{
					?>
						<a href="<?php echo $way.'/apoio-a-celula/'.$apoSalas[0]['sala']; ?>">
						<li style="background-color: <?php echo $apoSalas[0]['cor']; ?>">
							<div>
								<div id="box-all-info">
									<div id="all-info">
										<h3><?php echo $apoSalas[0]['sala']; ?></h3><br>
										<span><?php echo texto($apoSalas[0]['local'], 28); ?></span><br><br>
										<span><?php echo date('d/m', strtotime($apoSalas[0]['dataInicio'])); ?>
										 - <?php echo date('d/m', strtotime($apoSalas[0]['dataFim'])); ?> <br>
										  <?php echo date('H:i', strtotime($apoSalas[0]['inicio'])).'hr'; ?> - 
										  <?php echo date('H:i', strtotime($apoSalas[0]['fim'])).'hr'; ?> <br> <?php echo $apoSalas[0]['diaSemana']; ?> </span><br><br>
										<span><?php echo $apoSalas[0]['bol1']; ?></span><br>
										<span><?php echo $apoSalas[0]['vagaAtual']; ?>/<?php echo $apoSalas[0]['vagaInicial']; ?> Vagas</span>
									</div>
								</div>
								<div id="tipo">
									Apoio à Célula
								</div>
							</div>
						</li>
						</a>
						<?php } ?>

					</ul>
				</div>
				<?php 
					if ($cont == 3) {
						echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
					}
				?>
			</div>
			<?php } ?>