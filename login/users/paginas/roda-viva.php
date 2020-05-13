<?php 
	if ($user['campusSlug'] == 'pici' || $user['campusSlug'] == 'benfica' || $user['campusSlug'] == 'porangabucu' || $user['campusSlug'] == 'labomar' || $user['campusSlug'] == 'outro' ) {
		$rodSalas 	= DBread('rod_salas', "WHERE status = true AND semanaInicio = '$semana' AND regiaoSlug = 'fortaleza' ORDER BY sala ASC");
	}else{
		$rodSalas 	= DBread('rod_salas', "WHERE status = true AND semanaInicio = '$semana' AND regiaoSlug = '".$user['campusSlug']."' ORDER BY sala ASC");
	}

	$rodSalas 	= DBread('rod_salas', "WHERE status = true AND semanaInicio = '$semana' ORDER BY sala ASC");
	

	$rodPres 	= DBread('rod_pres', "WHERE npacce = '".$user['npacce']."'");
	$semanaFecha = false;
	if ($rodSalas == true) {
		$semanaFecha = true;
	}
	$rodInsc 	= DBread('rod_insc', "WHERE status = true AND npacce = '".$user['npacce']."'");

	//Cadastar em formação
	if (isset($_GET['action']) && $_GET['action'] != '' && isset($_GET['ati']) && $_GET['ati'] != '') {
		if($user['tipoSlug'] == 'articulador-de-celula'){
			
			$id = DBescape(trim(strip_tags($_GET['ati'])));
			if($rodSalas == false) {
				echo ' <script>window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
			}else{
				
				switch ($_GET['action']) {
						case 1:
							$conta = 0;
							for ($i=0; $i < count($rodSalas); $i++) { 
								if ($rodSalas[$i]['sala'] == $id){
									$conta++;
									$inscricao['sala'] 			= $rodSalas[$i]['sala'];
									$inscricao['npacce']		= $user['npacce'];
									$inscricao['nomeCompleto'] 	= $user['nome'];
									$inscricao['nomeUsual']		= GetName($user['nome'], $user['nomeUsual']);
									
									$inscricao['registro']		= date('Y-m-d H:i:s');
									$inscricao['ano']			= date('Y');
									$inscricao['status']		= 1;
									$up['vagaAtual']			= $rodSalas[$i]['vagaAtual'];
								}
							}
							if ($conta > 0) {
								$verify = DBread('rod_insc', "WHERE npacce = '".$user['npacce']."' AND status = true");
								if ($verify == false) {
									if (DBcreate('rod_insc', $inscricao)) {
										$up['vagaAtual'] = $up['vagaAtual']	- 1;
										if (DBUpdate('rod_salas', $up ,"sala = '$id'")) {
											echo ' <script>
							                  alert("Inscrição realizada com sucesso!!");
							                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
							                  </script>';
										}
									}
								}
							}	
						break;
						case 2:
							$verify = DBread('rod_insc', "WHERE npacce = '".$user['npacce']."'");
							if ($verify == true) {
								if (DBDelete('rod_insc', "npacce = '".$user['npacce']."' AND sala = '$id'")) {
									//pegar a quantidade de vagas
									for ($i=0; $i < count($rodSalas); $i++) { 
										if ($rodSalas[$i]['sala'] == $id){
											$up['vagaAtual'] = $rodSalas[$i]['vagaAtual'];
										}
									}
									//atualiza o número de vagas
									$up['vagaAtual'] = $up['vagaAtual'] + 1;
									if (DBUpdate('rod_salas', $up, "sala = '$id'")) {
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
<div class="title"><h2>História de Vida</h2></div>
<p>Você pode conferir as atividades de História de Vida em que esteve presente, as que faltou e
 matricular-se nas salas de História de Vida ofertadas quando 
 for o período de inscrição.</p>
 <br><br>
 <?php 
 	if (isset($url[2]) && $url[2] != '') {
 		include 'paginas/rod-single.php';
 	}else{
 		if ($rodSalas == false) {
 		}else{
 ?>
 <div class="title"><h2>Turmas Ofertadas</h2></div>
<div class="caixa">
	<ul>
	<?php 
		for ($i=0; $i < count($rodSalas); $i++) { 

	?>
		<a href="<?php echo $way.'/'.$url[1].'/'.$rodSalas[$i]['sala']; ?>">
		<li style="background-color: <?php echo $rodSalas[$i]['cor']; ?>">
			<div>
				<div id="box-all-info">
					<div id="all-info">
						<h3><?php echo $rodSalas[$i]['sala']; ?></h3><br>
						<span><?php echo texto($rodSalas[$i]['local'], 28); ?></span><br><br>
						<span><?php echo date('d/m', strtotime($rodSalas[$i]['dataInicio'])); ?>
						 - <?php echo date('d/m', strtotime($rodSalas[$i]['dataFim'])); ?> <br>
						  <?php echo date('H:i', strtotime($rodSalas[$i]['inicio'])).'hr'; ?> - 
						  <?php echo date('H:i', strtotime($rodSalas[$i]['fim'])).'hr'; ?> <br> <?php echo $rodSalas[$i]['diaSemana']; ?> </span><br><br>
						<span><?php echo $rodSalas[$i]['bol1']; if(!empty($rodSalas[$i]['bol2'])){ echo ' & '; } echo $rodSalas[$i]['bol2']; ?></span><br>
						<span><?php echo $rodSalas[$i]['vagaAtual']; ?>/<?php echo $rodSalas[$i]['vagaInicial']; ?> Vagas</span>
					</div>
				</div>
				<div id="tipo">
					História de Vida
				</div>
			</div>
		</li>
		</a>
		<?php } ?>
	</ul>
	<div id="cont"><br><?php echo '('.count($rodSalas).')' ?></div>
</div>
<br><br>
<?php } ?>
<div class="title"><h2>História de Vida Cadastrada</h2></div>

<?php 
	if ($rodInsc == false) {
		echo '<div class="nada-encontrado"><h2>Não há História de Vida cadastrada.</h2></div>';
	}else{
?>
<div class="caixa">
	<ul>
	<?php 
		for ($i=0; $i < count($rodInsc); $i++) {
			 $rodDados = DBread('rod_salas', "WHERE sala = '".$rodInsc[$i]['sala']."'");
			 for ($j=0; $j < count($rodDados); $j++) { 
			 	$rodInsc[$i]['cor'] 		= $rodDados[$j]['cor'];
			 	$rodInsc[$i]['local'] 		= $rodDados[$j]['local'];
			 	$rodInsc[$i]['dataInicio'] 	= $rodDados[$j]['dataInicio'];
			 	$rodInsc[$i]['dataFim'] 	= $rodDados[$j]['dataFim'];
			 	$rodInsc[$i]['inicio'] 		= $rodDados[$j]['inicio'];
			 	$rodInsc[$i]['fim'] 		= $rodDados[$j]['fim'];
			 	$rodInsc[$i]['diaSemana'] 	= $rodDados[$j]['diaSemana'];
			 	$rodInsc[$i]['bol1'] 		= $rodDados[$j]['bol1'];
			 	$rodInsc[$i]['bol2'] 		= $rodDados[$j]['bol2'];
			 	$rodInsc[$i]['cardName'] 	= $rodDados[$j]['cardName'];
			 	$rodInsc[$i]['status'] 		= $rodDados[$j]['status'];
			 }
	?>
		<a href="<?php echo $way.'/'.$url[1].'/'.$rodInsc[$i]['sala']; ?>">
		<li style="background-color: <?php echo $rodInsc[$i]['cor']; ?>;">
			<div>
				<div id="box-all-info">
					<div id="all-info">
						<h3><?php echo $rodInsc[$i]['sala']; ?></h3><br>
						<span><?php echo texto($rodInsc[$i]['local'], 28); ?></span><br><br>
						<span><?php echo date('d/m', strtotime($rodInsc[$i]['dataInicio'])); ?>
						 - <?php echo date('d/m', strtotime($rodInsc[$i]['dataFim'])); ?> <br>
						  <?php echo date('H:i', strtotime($rodInsc[$i]['inicio'])).'hr'; ?> - 
						  <?php echo date('H:i', strtotime($rodInsc[$i]['fim'])).'hr'; ?> <br> <?php echo $rodInsc[$i]['diaSemana']; ?> </span><br><br>
						<span><?php echo $rodInsc[$i]['bol1']; if(!empty($rodInsc[$i]['bol2'])){ echo ' & '; } echo $rodInsc[$i]['bol2']; ?></span><br>
						<span><?php if($rodInsc[$i]['status'] == 1){echo 'Ativo';}else{echo 'Inativo';} ?></span>
					</div>
				</div>
				<div id="tipo">
					História de Vida
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
	
	if ($rodPres == false) {
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
			for ($i=0; $i < count($rodPres); $i++) { 

		?>
		<tr>
			<td><?php echo $rodPres[$i]['codigo']; ?></td>
			<td><?php echo 'H-'.substr($rodPres[$i]['codigo'], -2); ?></td>
			<td><?php if($rodPres[$i]['semana'] >= 10){ echo $rodPres[$i]['semana'];}else{echo '0'.$rodPres[$i]['semana'];} ?></td>
			<td><?php echo date('d/m/y', strtotime($rodPres[$i]['registro'])); ?></td>
			<td><?php if($rodPres[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($rodPres[$i]['presenca'] == 0){ echo 'Você não esteve presente, por favor faça sua reposição!';}else if($rodPres[$i]['presenca'] == 2){ echo 'Reposição aprovada!';}else if($rodPres[$i]['presenca'] == 3){ echo 'Reposição precisa ser refeita!';}else if($rodPres[$i]['presenca'] == 4){ echo 'Reposição em análise!';} ?></td>
		</tr>
		<?php } ?>
	</table>
	<div id="cont"><br>(<?php echo count($rodPres);?>)</div>
</div>
<?php } } ?>