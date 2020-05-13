<?php 

	if ($user['campusSlug'] == 'pici' || $user['campusSlug'] == 'benfica' || $user['campusSlug'] == 'porangabucu' || $user['campusSlug'] == 'labomar' || $user['campusSlug'] == 'outro' ) {
		$forSalas 	= DBread('for_salas', "WHERE status = true AND semanaInicio = '$semana' AND regiaoSlug = 'fortaleza' ORDER BY sala ASC");
	}else{
		$forSalas 	= DBread('for_salas', "WHERE status = true AND semanaInicio = '$semana' AND regiaoSlug = '".$user['campusSlug']."' ORDER BY sala ASC");
	}
	
	$forPres 	= DBread('for_pres', "WHERE npacce = '".$user['npacce']."'");
	$semanaFecha = false;
	if ($forSalas == true) {
		$semanaFecha = true;
	}
	$forInsc 	= DBread('for_insc', "WHERE status = true AND npacce = '".$user['npacce']."'");

	//Cadastar em formação
	if (isset($_GET['action']) && $_GET['action'] != '' && isset($_GET['ati']) && $_GET['ati'] != '') {
		
			$id = DBescape(trim(strip_tags($_GET['ati'])));
			if($forSalas == false) {
				echo ' <script>window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
			}else{
				
				switch ($_GET['action']) {
						case 1:
							$conta = 0;
							for ($i=0; $i < count($forSalas); $i++) { 
								if ($forSalas[$i]['sala'] == $id){
									$conta++;
									$inscricao['sala'] 			= $forSalas[$i]['sala'];
									$inscricao['npacce']		= $user['npacce'];
									$inscricao['nomeCompleto'] 	= $user['nome'];
									$inscricao['nomeUsual']		= GetName($user['nome'], $user['nomeUsual']);
									
									$inscricao['registro']		= date('Y-m-d H:i:s');
									$inscricao['ano']			= date('Y');
									$inscricao['status']		= 1;
									$up['vagaAtual']			= $forSalas[$i]['vagaAtual'];
								}
							}
							if ($conta > 0) {
								$verify = DBread('for_insc', "WHERE npacce = '".$user['npacce']."' AND sala = '".$id."' AND status = true");
								$sala_for = DBread('for_salas', "WHERE sala = '$id'", 'vagaAtual');
								if ($verify == false && $sala_for[0]['vagaAtual'] > 0) {
									if (DBcreate('for_insc', $inscricao)) {
										$up['vagaAtual'] = $sala_for[0]['vagaAtual'] - 1;
										if (DBUpdate('for_salas', $up ,"sala = '$id'")) {
											echo ' <script>
							                  alert("Inscrição realizada com sucesso!!");
							                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
							                  </script>';
										}
									}
								}else{
									alertaLoad("Ocorreu um erro com seu inscrição! Tente novamente!", $way.'/'.$url[1].'/'.$url[2]);
								}
							}	
						break;
						case 2:
							$verify = DBread('for_insc', "WHERE npacce = '".$user['npacce']."' AND sala = '$id'");
							if ($verify == true) {
								if (DBDelete('for_insc', "npacce = '".$user['npacce']."' AND sala = '$id'")) {
									//pegar a quantidade de vagas
									$sala_for = DBread('for_salas', "WHERE sala = '$id'", 'vagaAtual');
									
									//atualiza o número de vagas
									$up['vagaAtual'] = $sala_for[0]['vagaAtual'] + 1;
									if (DBUpdate('for_salas', $up, "sala = '$id'")) {
										echo ' <script>
							                  alert("Cancelamento de inscrição realizada com sucesso!!");
							                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
							                  </script>';	
									}
								}
							}
						break;
				}
			}
		
	}//fim da inscricao
?>
<div class="title"><h2>Formação</h2></div>
<p>Você pode conferir as formações que esteve presente, as que faltou e
 matricular-se nas salas de formação ofertadas quando 
 for o período de inscrição.</p>
 <br><br>
 <?php 
 	if (isset($url[2]) && $url[2] != '') {
 		include 'paginas/for-single.php';
 	}else{
 		if ($forSalas == false) {
 		}else{
 ?>
 <div class="title"><h2>Turmas Ofertadas</h2></div>
<div class="caixa">
	<ul>
	<?php 
		for ($i=0; $i < count($forSalas); $i++) { 

	?>
		<a href="<?php echo $way.'/'.$url[1].'/'.$forSalas[$i]['sala']; ?>">
		<li style="background-color: <?php echo $forSalas[$i]['cor']; ?>">
			<div>
				<div id="box-all-info">
					<div id="all-info">
						<h3><?php echo $forSalas[$i]['sala']; ?></h3><br>
						<span><?php echo texto($forSalas[$i]['local'], 28); ?></span><br><br>
						<span><?php echo date('d/m', strtotime($forSalas[$i]['dataInicio'])); ?>
						 - <?php echo date('d/m', strtotime($forSalas[$i]['dataFim'])); ?> <br>
						  <?php echo date('H:i', strtotime($forSalas[$i]['inicio'])).'hr'; ?> - 
						  <?php echo date('H:i', strtotime($forSalas[$i]['fim'])).'hr'; ?> <br> <?php echo $forSalas[$i]['diaSemana']; ?> </span><br><br>
						<span><?php echo $forSalas[$i]['bol1']; ?> & <?php echo $forSalas[$i]['bol2']; ?></span><br>
						<span><?php echo $forSalas[$i]['vagaAtual']; ?>/<?php echo $forSalas[$i]['vagaInicial']; ?> Vagas</span>
					</div>
				</div>
				<div id="tipo">
					Formação
				</div>
			</div>
		</li>
		</a>
		<?php } ?>
	</ul>
	<div id="cont"><br><?php echo '('.count($forSalas).')' ?></div>
</div>
<br><br>
<?php } ?>
<div class="title"><h2>Formação Cadastrada</h2></div>
<?php 
	if ($forInsc == false) {
		echo '<div class="nada-encontrado"><h2>Não há formação cadastrada.</h2></div>';
	}else{
?>
<div class="caixa">
	<ul>
	<?php 
		for ($i=0; $i < count($forInsc); $i++) {
			 $forDados = DBread('for_salas', "WHERE sala = '".$forInsc[$i]['sala']."'");
			 for ($j=0; $j < count($forDados); $j++) { 
			 	$forInsc[$i]['cor'] 		= $forDados[$j]['cor'];
			 	$forInsc[$i]['local'] 		= $forDados[$j]['local'];
			 	$forInsc[$i]['dataInicio'] 	= $forDados[$j]['dataInicio'];
			 	$forInsc[$i]['dataFim'] 	= $forDados[$j]['dataFim'];
			 	$forInsc[$i]['inicio'] 		= $forDados[$j]['inicio'];
			 	$forInsc[$i]['fim'] 		= $forDados[$j]['fim'];
			 	$forInsc[$i]['diaSemana'] 	= $forDados[$j]['diaSemana'];
			 	$forInsc[$i]['bol1'] 		= $forDados[$j]['bol1'];
			 	$forInsc[$i]['bol2'] 		= $forDados[$j]['bol2'];
			 	$forInsc[$i]['cardName'] 	= $forDados[$j]['cardName'];
			 	$forInsc[$i]['status'] 		= $forDados[$j]['status'];
			 }
	?>
		<a href="<?php echo $way.'/'.$url[1].'/'.$forInsc[$i]['sala']; ?>">
		<li style="background-color: <?php echo $forInsc[$i]['cor']; ?>;">
			<div>
				<div id="box-all-info">
					<div id="all-info">
						<h3><?php echo $forInsc[$i]['sala']; ?></h3><br>
						<span><?php echo texto($forInsc[$i]['local'], 28); ?></span><br><br>
						<span><?php echo date('d/m', strtotime($forInsc[$i]['dataInicio'])); ?>
						 - <?php echo date('d/m', strtotime($forInsc[$i]['dataFim'])); ?> <br>
						  <?php echo date('H:i', strtotime($forInsc[$i]['inicio'])).'hr'; ?> - 
						  <?php echo date('H:i', strtotime($forInsc[$i]['fim'])).'hr'; ?> <br> <?php echo $forInsc[$i]['diaSemana']; ?> </span><br><br>
						<span><?php echo $forInsc[$i]['bol1']; ?> & <?php echo $forInsc[$i]['bol2']; ?></span><br>
						<span><?php if($forInsc[$i]['status'] == 1){echo 'Ativo';}else{echo 'Inativo';} ?></span>
					</div>
				</div>
				<div id="tipo">
					<?php echo $forInsc[$i]['cardName']; ?>
				</div>
			</div>
		</li>
		</a>
	<?php }?>
	</ul>
</div>
<?php } ?>
<br><br>
<div class="title"><h2>Histórico de Presenças</h2></div>
<?php 
	
	if ($forPres == false) {
		echo '<div class="nada-encontrado"><h2>Nenhuma presença registrada ainda.</h2></div>';
	}else{
?>
<div class="tabela">
	<table border="">
		<tr>
			<th>Código:</th>
			<th>Sala:</th>
			<th>Semana:</th>
			<th>Registro:</th>
			<th>Situação:</th>
		</tr>
		<?php 
			for ($i=0; $i < count($forPres); $i++) { 

		?>
		<tr>
			<td><?php echo $forPres[$i]['codigo']; ?></td>
			<td><?php echo 'F-'.substr($forPres[$i]['codigo'], -2); ?></td>
			<td><?php if($forPres[$i]['semana'] >= 10){ echo $forPres[$i]['semana'];}else{echo '0'.$forPres[$i]['semana'];} ?></td>
			<td><?php echo date('d/m/y', strtotime($forPres[$i]['registro'])); ?></td>
			<td><?php if($forPres[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($forPres[$i]['presenca'] == 0){ echo 'Você não esteve presente, por favor faça sua reposição!';}else if($forPres[$i]['presenca'] == 2){ echo 'Reposição aprovada!';}else if($forPres[$i]['presenca'] == 3){ echo 'Reposição precisa ser refeita!';}else if($forPres[$i]['presenca'] == 4){ echo 'Reposição em análise!';} else {echo 'Feriado';} ?></td>
		</tr>
		<?php } ?>
	</table>
	<div id="cont"><br>(<?php echo count($forPres);?>)</div>
</div>
<?php } } ?>