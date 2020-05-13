
<?php 
	
	if ($user['campusSlug'] == 'pici' || $user['campusSlug'] == 'benfica' || $user['campusSlug'] == 'porangabucu' || $user['campusSlug'] == 'labomar' || $user['campusSlug'] == 'outro' ) {
		$apoSalas 	= DBread('apo_salas', "WHERE status = true AND semanaInicio = '$semana' AND regiaoSlug = 'fortaleza' ORDER BY sala ASC");
	}else{
		$apoSalas 	= DBread('apo_salas', "WHERE status = true AND semanaInicio = '$semana' AND regiaoSlug = '".$user['campusSlug']."' ORDER BY sala ASC");
	}

	$apoPres 	= DBread('apo_pres', "WHERE npacce = '".$user['npacce']."'");
	$semanaFecha = false;
	if ($apoSalas == true) {
		$semanaFecha = true;
	}
	$apoInsc 	= DBread('apo_insc', "WHERE status = true AND npacce = '".$user['npacce']."'");

	//Cadastar em apoio
	if (isset($_GET['action']) && $_GET['action'] != '' && isset($_GET['ati']) && $_GET['ati'] != '') {
		if($user['tipoSlug'] == 'articulador-de-celula'){
			
			$id = DBescape(trim(strip_tags($_GET['ati'])));
			if($apoSalas == false) {
				echo ' <script>window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
			}else{
			
				switch ($_GET['action']) {
						case 1:
							$conta = 0;
							for ($i=0; $i < count($apoSalas); $i++) { 
								if ($apoSalas[$i]['sala'] == $id){
									$conta++;
									$inscricao['sala'] 			= $apoSalas[$i]['sala'];
									$inscricao['npacce']		= $user['npacce'];
									$inscricao['nomeCompleto'] 	= $user['nome'];
									$inscricao['nomeUsual']		= GetName($user['nome'], $user['nomeUsual']);
									$inscricao['registro']		= date('Y-m-d H:i:s');
									$inscricao['ano']			= date('Y');
									$inscricao['status']		= 1;
									$up['vagaAtual']			= $apoSalas[$i]['vagaAtual'];
								}
							}
							if ($conta > 0) {
								// $verify = DBread('apo_insc', "WHERE npacce = '".$user['npacce']."' AND status = true");
								// if ($verify == false) {
									if (DBcreate('apo_insc', $inscricao)) {
										$up['vagaAtual'] = $up['vagaAtual']	- 1;
										if (DBUpdate('apo_salas', $up ,"sala = '$id'")) {
											echo ' <script>
							                  alert("Inscrição realizada com sucesso!!");
							                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
							                  </script>';
										}
									}
								// }
							}	
						break;
						case 2:
							$verify = DBread('apo_insc', "WHERE npacce = '".$user['npacce']."'");
							if ($verify == true) {
								if (DBDelete('apo_insc', "npacce = '".$user['npacce']."' AND sala = '$id'")) {
									//pegar a quantidade de vagas
									for ($i=0; $i < count($apoSalas); $i++) { 
										if ($apoSalas[$i]['sala'] == $id){
											$up['vagaAtual'] = $apoSalas[$i]['vagaAtual'];
										}
									}
									//atualiza o número de vagas
									$up['vagaAtual'] = $up['vagaAtual'] + 1;
									if (DBUpdate('apo_salas', $up, "sala = '$id'")) {
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
		}else{
			Redirect($way.'/'.$url[1]);
		}
	}//fim da inscricao
?>
<div class="title"><h2>Apoio à Célula</h2></div>
<p>Você pode conferir as atividades de Apoio à Célula em que esteve presente, as que faltou e
 matricular-se nas salas de Apoio à Célula ofertadas quando 
 for o período de inscrição.</p>
 <br><br>
 <?php 
 	if (isset($url[2]) && $url[2] != '') {
 		include 'paginas/apo-single.php';
 	}else{
 		if ($apoSalas == false) {
 		}else{
 ?>
 <div class="title"><h2>Turmas Ofertadas</h2></div>
<div class="caixa">
	<ul>
	<?php 
		for ($i=0; $i < count($apoSalas); $i++) { 

	?>
		<a href="<?php echo $way.'/'.$url[1].'/'.$apoSalas[$i]['sala']; ?>">
		<li style="background-color: <?php echo $apoSalas[$i]['cor']; ?>">
			<div>
				<div id="box-all-info">
					<div id="all-info">
						<h3><?php echo $apoSalas[$i]['sala']; ?></h3><br>
						<span><?php echo texto($apoSalas[$i]['local'], 28); ?></span><br><br>
						<span><?php echo date('d/m', strtotime($apoSalas[$i]['dataInicio'])); ?>
						 - <?php echo date('d/m', strtotime($apoSalas[$i]['dataFim'])); ?> <br>
						  <?php echo date('H:i', strtotime($apoSalas[$i]['inicio'])).'hr'; ?> - 
						  <?php echo date('H:i', strtotime($apoSalas[$i]['fim'])).'hr'; ?> <br> <?php echo $apoSalas[$i]['diaSemana']; ?> </span><br><br>
						<span><?php echo $apoSalas[$i]['bol1']; if(!empty($apoSalas[$i]['bol2'])){ echo ' & '; } echo $apoSalas[$i]['bol2']; ?></span><br>
						<span><?php echo $apoSalas[$i]['vagaAtual']; ?>/<?php echo $apoSalas[$i]['vagaInicial']; ?> Vagas</span>
					</div>
				</div>
				<div id="tipo">
				 	Apoio à Celula
				</div>
			</div>
		</li>
		</a>
		<?php } ?>
	</ul>
	<div id="cont"><br><?php echo '('.count($apoSalas).')' ?></div>
</div>
<br><br>
<?php } ?>
<div class="title"><h2>Apoio à Célula Cadastrado</h2></div>
<?php 
	if ($apoInsc == false) {
		echo '<div class="nada-encontrado"><h2>Não há Apoio à Célula cadastrada.</h2></div>';
	}else{
?>
<div class="caixa">
	<ul>
	<?php 
		for ($i=0; $i < count($apoInsc); $i++) {
			 $apoDados = DBread('apo_salas', "WHERE sala = '".$apoInsc[$i]['sala']."'");
			 for ($j=0; $j < count($apoDados); $j++) { 
			 	$apoInsc[$i]['cor'] 		= $apoDados[$j]['cor'];
			 	$apoInsc[$i]['local'] 		= $apoDados[$j]['local'];
			 	$apoInsc[$i]['dataInicio'] 	= $apoDados[$j]['dataInicio'];
			 	$apoInsc[$i]['dataFim'] 	= $apoDados[$j]['dataFim'];
			 	$apoInsc[$i]['inicio'] 		= $apoDados[$j]['inicio'];
			 	$apoInsc[$i]['fim'] 		= $apoDados[$j]['fim'];
			 	$apoInsc[$i]['diaSemana'] 	= $apoDados[$j]['diaSemana'];
			 	$apoInsc[$i]['bol1'] 		= $apoDados[$j]['bol1'];
			 	$apoInsc[$i]['bol2'] 		= $apoDados[$j]['bol2'];
			 	$apoInsc[$i]['cardName'] 	= $apoDados[$j]['cardName'];
			 	$apoInsc[$i]['status'] 		= $apoDados[$j]['status'];
			 }
	?>
		<a href="<?php echo $way.'/'.$url[1].'/'.$apoInsc[$i]['sala']; ?>">
		<li style="background-color: <?php echo $apoInsc[$i]['cor']; ?>;">
			<div>
				<div id="box-all-info">
					<div id="all-info">
						<h3><?php echo $apoInsc[$i]['sala']; ?></h3><br>
						<span><?php echo texto($apoInsc[$i]['local'], 28); ?></span><br><br>
						<span><?php echo date('d/m', strtotime($apoInsc[$i]['dataInicio'])); ?>
						 - <?php echo date('d/m', strtotime($apoInsc[$i]['dataFim'])); ?> <br>
						  <?php echo date('H:i', strtotime($apoInsc[$i]['inicio'])).'hr'; ?> - 
						  <?php echo date('H:i', strtotime($apoInsc[$i]['fim'])).'hr'; ?> <br> <?php echo $apoInsc[$i]['diaSemana']; ?> </span><br><br>
						<span><?php echo $apoInsc[$i]['bol1']; if(!empty($apoInsc[$i]['bol2'])){ echo ' & '; } echo $apoInsc[$i]['bol2']; ?></span><br>
						<span><?php if($apoInsc[$i]['status'] == 1){echo 'Ativo';}else{echo 'Inativo';} ?></span>
					</div>
				</div>
				<div id="tipo">
					Apoio à Célula
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
	
	if ($apoPres == false) {
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
			for ($i=0; $i < count($apoPres); $i++) { 

		?>
		<tr>
			<td><?php echo $apoPres[$i]['codigo']; ?></td>
			<td><?php echo 'A-'.substr($apoPres[$i]['codigo'], -2); ?></td>
			<td><?php if($apoPres[$i]['semana'] >= 10){ echo $apoPres[$i]['semana'];}else{echo '0'.$apoPres[$i]['semana'];} ?></td>
			<td><?php echo date('d/m/y', strtotime($apoPres[$i]['registro'])); ?></td>
			<td><?php if($apoPres[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($apoPres[$i]['presenca'] == 0){ echo 'Você não esteve presente, por favor faça sua reposição!';}else if($apoPres[$i]['presenca'] == 2){ echo 'Reposição aprovada!';}else if($apoPres[$i]['presenca'] == 3){ echo 'Reposição precisa ser refeita!';}else if($apoPres[$i]['presenca'] == 4){ echo 'Reposição em análise!';} ?></td>
		</tr>
		<?php } ?>
	</table>
	<div id="cont"><br>(<?php echo count($apoPres);?>)</div>
</div>
<?php } } ?>