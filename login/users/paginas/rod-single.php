

<?php 

	$url[2] = DBescape(trim(strip_tags($url[2])));
	if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno') {
		$rodSalas = DBread('rod_salas', "WHERE sala = '".$url[2]."'");	
	}else{
		$rodSalas = DBread('rod_salas', "WHERE status = true AND sala = '".$url[2]."'");
	}
	$inscritos = DBread('rod_insc', "WHERE sala = '".$url[2]."' ORDER BY nomeCompleto ASC");

	if ($rodSalas == false) {
		echo '<div class="nada-encontrado"><h2>Nada Encontrado.</h2></div>';
	}else{
		$rod = $rodSalas[0];

		if (isset($_GET['editar']) && $_GET['editar'] != '') {
			if ($user['npacce'] == $rod['npacce1'] || $user['npacce'] == $rod['npacce2']  || $user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno') {
				include 'paginas/editar-rod-single.php';
			}
		}else{


?>
<script>
function excluir(){
		if (confirm("Você tem certeza que desaja excluir essa sala?")){
			window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'?action=3&&sala='.$rod['sala']; ?>";
		}
	}	
</script>
	<div class="page-ati-single">
		<div class="cabecario">
					<div class="info-single">
						<ul>
							<li><h3><?php echo $rod['sala']; ?></h3></li>
							<li><?php echo $rod['local']; ?></li>
							<li><?php echo date('d/m', strtotime($rod['dataInicio'])); ?> - <?php echo date('d/m', strtotime($rod['dataFim'])); ?></li>
							<li><?php echo date('H:i', strtotime($rod['inicio'])).'hr'; ?> - <?php echo date('H:i', strtotime($rod['fim'])).'hr'; ?><br> <?php echo $rod['diaSemana']; ?> </li>
							<li><?php echo $rod['bol1']; ?> & <?php echo $rod['bol2']; ?></li>
							<li><?php echo $rod['vagaAtual']; ?>/<?php echo $rod['vagaInicial']; ?> Vagas</li>
							<li><strong><?php echo printPost($rod['disc'], 'page'); ?></strong></li>
							
						</ul>
					</div>
					<?php 
						if ($rod['npacce2'] != '' || $rod['npacce2'] != null) {
					?>
					<div class="foto-single">
					<?php $foto = DBread('bolsistas', "WHERE npacce = '".$rod['npacce2']."'", "id, foto"); ?>
							<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
							<div class="nome"><?php echo $rod['bol2']; ?></div>
					</div>
					<?php } ?>
					<div class="foto-single">
					<?php $foto = DBread('bolsistas', "WHERE npacce = '".$rod['npacce1']."'", "id, foto"); ?>
							<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
							<div class="nome"><?php echo $rod['bol1']; ?></div>
					</div>

					<div id="clear"></div> 
					<?php 
								if ($user['tipoSlug'] == 'articulador-de-celula') {
									if ($semanaFecha == true) {
											$verify = DBread('rod_insc', "WHERE npacce = '".$user['npacce']."' AND status = true", "id, sala");
											if ($verify == false) {
												if($rod['vagaAtual'] > 0){
												echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=1&&ati='.$rod['sala'].'" class="botao">Inscrever-se</a>';
												}
											}else{
												if ($rod['sala'] == $verify[0]['sala']) {
													echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=2&&ati='.$rod['sala'].'" class="botao">Cancelar Inscrição</a>';
												}
											}
										
									}
								}else if ($user['npacce'] == $rod['npacce1'] || $user['npacce'] == $rod['npacce2']  || $user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico'){
									echo '<a href="'.URL_PAINEL.'paginas/rod-lista-single.php?sala='.$rod['sala'].'" target="_blank" class="botao">Lista de Presença</a>';
									if ($user['tipoSlug'] == 'ceo') {
									if ($rod['status'] == 0) {
										echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=1&&sala='.$rod['sala'].'" class="botao">Ativar</a>';
									}else{
										echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=2&&sala='.$rod['sala'].'" class="botao">Desativar</a>';
									}
									echo '<a onclick="excluir()" style="cursor:pointer;" class="botao">Excluir</a>';
									}
									echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?editar='.$rod['sala'].'" class="botao">Editar</a>';	
								}

							?>
		</div><br><br>
		<?php 
			if (isset($url[4]) && $url[4] != '') {
//========================================Formularios=============================================
				if ($user['npacce'] == $rod['npacce1'] || $user['npacce'] == $rod['npacce2'] || $user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno'){
					$ver = 0;
					for ($i=0; $i < count($inscritos); $i++) { 
						if ($inscritos[$i]['npacce'] == $url[4]) {
							$bolsista = $inscritos[$i];
							$ver++;
						}
					}
					if ($ver == 0) {
						echo '<div class="nada-encontrado"><h2>Bolsista não encontrado.</h2></div>';
					}else{
					






					$tabela = 'rod_pres';
					$codigo = $url[3];

					$select =  DBread($tabela, "WHERE codigo = '".$url[3]."' AND npacce = '".$url[4]."'");
					if (isset($_POST['enviar'])) {
						$form['npacce'] 			= $bolsista['npacce'];
						$form['nome']				= $bolsista['nomeCompleto'];
						$form['codigo']				= $url[3];
						$form['sala']				= $rod['sala'];
						$form['npacce1'] 			= $user['npacce'];
						$form['nome1'] 				= $user['nome'];
						$form['registro']			= date('Y-m-d h:i:s');
						$form['semana']				= substr($url[3], -4, 2);

						$form['presenca'] 			= GetPost('presenca');
						$form['entrada'] 			= GetPost('horaEnt').':'.GetPost('minEnt').':'.GetPost('segEnt');
						$form['saida'] 				= GetPost('horaSaida').':'.GetPost('minSaida').':'.GetPost('segSaida');
						$form['participacao'] 		= GetPost('participacao');
						$form['habilidades'] 		= GetPost('habilidades');
						$form['responsabilidade'] 	= GetPost('responsabilidade');
						$form['contribuicao'] 		= GetPost('contribuicao');
						$form['protagonismo'] 		= GetPost('protagonismo');
						$form['obs'] 				= GetPost('obs');
						

						if ($form['presenca'] == '') {
							echo '<script>alert("Campo Presença está vazio");</script>';
						}else if($form['presenca'] == 0 || $form['presenca'] == 2 || $form['presenca'] == 6){
							
							if ($form['presenca'] == 2 || $form['presenca'] == 6) {
								$form['entrada'] 			= $rod['inicio'];
								$form['saida'] 				= $rod['fim'];
							}else{
								$form['entrada'] 			= '';
								$form['saida'] 				= '';
							}
							$form['participacao'] 		= 0;
							$form['habilidades'] 		= 0;
							$form['responsabilidade'] 	= 0;
							$form['contribuicao'] 		= 0;
							$form['protagonismo'] 		= 0;
							$form['obs'] 				= '';
							
							
							if ($select == false) {
								if (DBcreate($tabela, $form)) {
								echo '<script>alert("Relatório enviado com sucesso.");
			        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'#corpo-single";</script>';
								}
							}else{
								if (DBUpDate($tabela, $form, "codigo = '$codigo' AND npacce = '".$bolsista['npacce']."'")){
									echo '<script>alert("Relatório editado com sucesso.");
			        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'#corpo-single";</script>';
									
								}
							}
						}else if(empty($form['entrada'])){
							echo '<script>alert("Campo Entrada está vazio");</script>';
						}else if (empty($form['saida'])) {
							echo '<script>alert("Campo Saida está vazio");</script>';
						}else if (empty($form['participacao'])) {
							echo '<script>alert("Campo Participação está vazio");</script>';
						}else if (empty($form['habilidades'])) {
							echo '<script>alert("Campo Participação está vazio");</script>';
						}else if (empty($form['responsabilidade'])) {
							echo '<script>alert("Campo Participação está vazio");</script>';
						}else if (empty($form['contribuicao'])) {
							echo '<script>alert("Campo Participação está vazio");</script>';
						}else if (empty($form['protagonismo'])) {
							echo '<script>alert("Campo Participação está vazio");</script>';
						}else{
							if ($select == false) {
								if (DBcreate($tabela, $form)) {
								echo '<script>alert("Relatório enviado com sucesso.");
			        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'#corpo-single";</script>';
								}
							}else{
								if (DBUpDate($tabela, $form, "codigo = '$codigo' AND npacce = '".$bolsista['npacce']."'")){
									echo '<script>alert("Relatório editado com sucesso.");
			        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'#corpo-single";</script>';
									
								}
							}
						}
					}
					?> 

	<div class="title"><h2>Formulário de avaliação - <?php echo $bolsista['nomeCompleto']; ?></h2></div>
	<div id="editar-ativ" class="form">
<?php 
	//copiar daaqui até ===================================================================================
		if ($select == true) {
	?>
		<div>
			<span><strong>Avaliado por:<br></strong></span>
			<span><?php echo $select[0]['nome1']; ?></span> <strong> <br>em </strong> <?php echo date('d/m/Y H:i:s', strtotime($select[0]['registro'])).' - '.$week[date('D', strtotime($select[0]['registro']))]; ?><br><br>
		</div>
	<?php 
		}else{
	?>
		<span style="font-weight: 600; color: red;">Este formulário está pré-preenchido pelo sistema</span>
		<br><br>
	<?php
		}
	?>
	<script type="text/javascript">
		$(function(){
			$(".presenca").click(function(e) {
				var presenca = parseInt($(this).val());
				
				if (presenca == 1){
					$("#wramp_form").css({'display':'block'});
				}else{
					$("#wramp_form").css({'display':'none'});
				}
			});
		});
	</script>
	 <form action="" method="post" enctype="multipart/form-data">
	 	<label>Compareceu a reunião?</label><span style="color: red;"> *</span><br><br>
	 	<?php 
		if ($select == true) {
		?>
	 	<input type="radio" name="presenca" <?php if($select == true && $select[0]['presenca'] == 1){echo 'checked=""';} ?> value="1"></input> Sim<br><br>
	 	<input type="radio" name="presenca" <?php if($select == true && $select[0]['presenca'] == 0){echo 'checked=""';} ?> value="0"></input> Não<br><br>
	 	<input type="radio" name="presenca" <?php if($select == true && $select[0]['presenca'] == 2){echo 'checked=""';} ?> value="2"></input> Não, mas efetuou a Reposição<br><br>
	 	<input type="radio" name="presenca" <?php if($select == true && $select[0]['presenca'] == 6){echo 'checked=""';} ?> value="6"></input> Não, mas justificou<br><br>
	 	<input type="radio" name="presenca" <?php if($select == true && $select[0]['presenca'] == 5){echo 'checked=""';} ?> value="5"></input> Feriado<br><br>
	 	

	 	<?php 
	 	}else{
	 	?>
	 	<input type="radio" name="presenca" class="presenca" value="1"></input> Sim<br><br>
	 	<input type="radio" name="presenca" class="presenca" value="0"></input> Não<br><br>
	 	<input type="radio" name="presenca" class="presenca" value="2"></input> Não, mas efetuou a Reposição<br><br>
	 	<input type="radio" name="presenca" class="presenca" value="6"></input> Não, mas justificou<br><br>
	 	<input type="radio" name="presenca" class="presenca" value="5"></input> Feriado<br><br>
	 	<?php
	 	}
	 	?>
	 	
	 	<?php 
	 		if ($select == true && $select[0]['presenca'] == 2) { echo '<strong>Efetuou a Reposição</strong><br><br>';}
	 	
	 	if($select == true){
	 		echo '<div id="wramp_form">';
	 	}else{
	 		echo '<div id="wramp_form" style="display: none;">';
	 	}
	 	?>

	 	<label>Pontualidade:</label><span style="color: red;"> *</span><br><br>
	 	<div style="margin: 0 auto; width: 80%;">
	 	<label>Entrada:</label><span style="color: red;"> *</span><br>
						 	<select name="horaEnt">
						 	<?php
						 	if($select == true){
					 			$hora = explode(":", $select[0]['entrada']);
					 			for ($i=0; $i <= 23; $i++) {
						 			if($i < 10){
						 				$value = '0'.$i;
						 			}else{
						 				$value = $i;
						 			} 
						 			if($value == $hora[0]){
						 				$checked = 'selected=""';
						 			}else{
						 				$checked = '';
						 			}
						 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
						 		}
					 		}else{
					 			$hora = explode(":", $rod['inicio']);
					 			for ($i=0; $i <= 23; $i++) {
						 			if($i < 10){
						 				$value = '0'.$i;
						 			}else{
						 				$value = $i;
						 			} 
						 			if($value == $hora[0]){
						 				$checked = 'selected=""';
						 			}else{
						 				$checked = '';
						 			}
						 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
						 		}
					 		}
						 		
						 		
						 	?>

						 	</select>
						 	:
						 	<select name="minEnt">
						 	<?php 
						 		for ($i=0; $i <= 59; $i++) {
						 			if($i < 10){
						 				$value = '0'.$i;
						 			}else{
						 				$value = $i;
						 			} 
						 			if($value == $hora[1]){
						 				$checked = 'selected=""';
						 			}else{
						 				$checked = '';
						 			}
						 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
						 		}
						 	?>
						 	</select>
						 	:
						 	<select name="segEnt">
						 	<?php 
						 		for ($i=0; $i <= 59; $i++) {
						 			if($i < 10){
						 				$value = '0'.$i;
						 			}else{
						 				$value = $i;
						 			} 
						 			if($value == $hora[2]){
						 				$checked = 'selected=""';
						 			}else{
						 				$checked = '';
						 			}
						 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
						 		}
						 	?>
						 	</select>
						 	<br><br>
						 	<label>Saída:</label><span style="color: red;"> *</span><br>
						 	<select name="horaSaida">
						 	<?php
						 	if($select == true){
					 			$hora = explode(":", $select[0]['saida']);
					 			for ($i=0; $i <= 23; $i++) {
						 			if($i < 10){
						 				$value = '0'.$i;
						 			}else{
						 				$value = $i;
						 			} 
						 			if($value == $hora[0]){
						 				$checked = 'selected=""';
						 			}else{
						 				$checked = '';
						 			}
						 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
						 		}
					 		}else{
					 			$hora = explode(":", $rod['fim']);
					 			for ($i=0; $i <= 23; $i++) {
						 			if($i < 10){
						 				$value = '0'.$i;
						 			}else{
						 				$value = $i;
						 			} 
						 			if($value == $hora[0]){
						 				$checked = 'selected=""';
						 			}else{
						 				$checked = '';
						 			}
						 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
						 		}
					 		} 
						 		
						 	?>
						 	</select>
						 	:
						 	<select name="minSaida">
						 	<?php 
						 		for ($i=0; $i <= 59; $i++) {
						 			if($i < 10){
						 				$value = '0'.$i;
						 			}else{
						 				$value = $i;
						 			} 
						 			if($value == $hora[1]){
						 				$checked = 'selected=""';
						 			}else{
						 				$checked = '';
						 			}
						 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
						 		}
						 	?>
						 	</select>
						 	:
						 	<select name="segSaida">
						 	<?php 
						 		for ($i=0; $i <= 59; $i++) {
						 			if($i < 10){
						 				$value = '0'.$i;
						 			}else{
						 				$value = $i;
						 			} 
						 			if($value == $hora[2]){
						 				$checked = 'selected=""';
						 			}else{
						 				$checked = '';
						 			}
						 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
						 		}
						 	?>
						 	</select>
							</div>
						 	<br><br>
	 		 
	 	<label>Participação:</label><span style="color: red;"> *</span>
	 	<table width="100%">
	 		<tr>
	 			<th>1</th>
	 			<th>2</th>
	 			<th>3</th>
	 			<th>4</th>
	 			<th>5</th>
	 		</tr>
	 		<tr>
	 		<?php 
	 		if($select == true){
	 		?>
	 			<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 1){echo 'checked=""';} ?> name="participacao" value="1"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 2){echo 'checked=""';} ?>  name="participacao" value="2"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 3){echo 'checked=""';} ?>  name="participacao" value="3"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 4){echo 'checked=""';} ?>  name="participacao" value="4"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 5){echo 'checked=""';} ?> name="participacao" value="5"></input></td>
	 		<?php 
	 		}else{
	 		?>
	 		<td><input type="radio"  name="participacao" value="1"></input></td>
 			<td><input type="radio"  name="participacao" value="2"></input></td>
 			<td><input type="radio" checked="" name="participacao" value="3"></input></td>
 			<td><input type="radio"  name="participacao" value="4"></input></td>
 			<td><input type="radio"  name="participacao" value="5"></input></td>
	 		<?php
	 		} 
	 		?>
	 		</tr>
	 	</table>
	 	<br>	<br>
	 	<label>Habilidades:</label><span style="color: red;"> *</span>
	 	<table width="100%">
	 		<tr>
	 			<th>1</th>
	 			<th>2</th>
	 			<th>3</th>
	 			<th>4</th>
	 			<th>5</th>
	 		</tr>
	 		<tr>
	 		<?php 
	 		if($select == true){
	 		?>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 1){echo 'checked=""';} ?> name="habilidades" value="1"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 2){echo 'checked=""';} ?> name="habilidades" value="2"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 3){echo 'checked=""';} ?> name="habilidades" value="3"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 4){echo 'checked=""';} ?> name="habilidades" value="4"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 5){echo 'checked=""';} ?> name="habilidades" value="5"></input></td>
	 		<?php 
	 		}else{
	 		?>
	 		<td><input type="radio" name="habilidades" value="1"></input></td>
 			<td><input type="radio" name="habilidades" value="2"></input></td>
 			<td><input type="radio" checked="" name="habilidades" value="3"></input></td>
 			<td><input type="radio" name="habilidades" value="4"></input></td>
 			<td><input type="radio" name="habilidades" value="5"></input></td>
 		
	 		<?php
	 		}
	 		?>	
	 		</tr>
	 	</table>
	 	<br>	<br>
	 	<label>Responsabilidade:</label><span style="color: red;"> *</span>
	 	<table width="100%">
	 		<tr>
	 			<th>1</th>
	 			<th>2</th>
	 			<th>3</th>
	 			<th>4</th>
	 			<th>5</th>
	 		</tr>
	 		<tr>
	 		<?php 
	 		if($select == true){
	 		?>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 1){echo 'checked=""';} ?> value="1"></input></td>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 2){echo 'checked=""';} ?> value="2"></input></td>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 3){echo 'checked=""';} ?> value="3"></input></td>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 4){echo 'checked=""';} ?> value="4"></input></td>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 5){echo 'checked=""';} ?> value="5"></input></td>
	 		<?php
		 	}else{
		 	?>
		 	<td><input type="radio" name="responsabilidade" value="1"></input></td>
 			<td><input type="radio" name="responsabilidade" value="2"></input></td>
 			<td><input type="radio" name="responsabilidade" checked="" value="3"></input></td>
 			<td><input type="radio" name="responsabilidade" value="4"></input></td>
 			<td><input type="radio" name="responsabilidade" value="5"></input></td>
		 	<?php
		 	}
		 	?>
	 		</tr>
	 	</table>
	 	<br>	<br>
	 	<label>Contribuição:</label><span style="color: red;"> *</span>
	 	<table width="100%">
	 		<tr>
	 			<th>1</th>
	 			<th>2</th>
	 			<th>3</th>
	 			<th>4</th>
	 			<th>5</th>
	 		</tr>
	 		<tr>
	 		<?php 
	 		if($select == true){
	 		?>
	 			<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 1){echo 'checked=""';} ?> value="1"></input></td>
	 			<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 2){echo 'checked=""';} ?> value="2"></input></td>
	 			<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 3){echo 'checked=""';} ?> value="3"></input></td>
	 			<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 4){echo 'checked=""';} ?> value="4"></input></td>
	 			<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 5){echo 'checked=""';} ?> value="5"></input></td>
	 		<?php 
	 		}else{
	 		?>
	 		<td><input type="radio" name="contribuicao" value="1"></input></td>
 			<td><input type="radio" name="contribuicao" value="2"></input></td>
 			<td><input type="radio" name="contribuicao" checked="" value="3"></input></td>
 			<td><input type="radio" name="contribuicao" value="4"></input></td>
 			<td><input type="radio" name="contribuicao" value="5"></input></td>
 		
	 		<?php
	 		}
	 		?>
	 		</tr>
	 	</table>
	 	<br>	<br>
	 	<label>Protagonismo:</label><span style="color: red;"> *</span>
	 	<table width="100%">
	 		<tr>
	 			<th>1</th>
	 			<th>2</th>
	 			<th>3</th>
	 			<th>4</th>
	 			<th>5</th>
	 		</tr>
	 		<tr>
 			<?php 
	 		if($select == true){
	 		?>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 1){echo 'checked=""';} ?> value="1"></input></td>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 2){echo 'checked=""';} ?> value="2"></input></td>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 3){echo 'checked=""';} ?> value="3"></input></td>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 4){echo 'checked=""';} ?> value="4"></input></td>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 5){echo 'checked=""';} ?> value="5"></input></td>
	 		<?php 
	 		}else{
	 		?>
	 		<td><input type="radio" name="protagonismo" value="1"></input></td>
 			<td><input type="radio" name="protagonismo" value="2"></input></td>
 			<td><input type="radio" name="protagonismo" checked="" value="3"></input></td>
 			<td><input type="radio" name="protagonismo" value="4"></input></td>
 			<td><input type="radio" name="protagonismo" value="5"></input></td>
	 		<?php
	 		}
	 		?>
	 		</tr>
	 	</table>
	 	<br><br>
	 	<label>Observações:</label><br>
	 	<textarea name="obs"><?php if($select == true){echo $select[0]['obs'];} ?></textarea>
	 	</div>
	 	<center>
	 	<input type="submit" name="enviar" value="Enviar"></input>
	 	</center>
	 </form>
	 </div>


					<?php
					}
					

				}else{
					echo '<div class="nada-encontrado"><h2>Acesso Negado.</h2></div>';
				}
				echo '</div>';
			}else if (isset($url[3]) && $url[3] != '') {


//========================================Lista de relatórios=====================================
				if ($user['npacce'] == $rod['npacce1'] || $user['npacce'] == $rod['npacce2'] || $user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno'){
				$rodCod = DBread('rod_cod', "WHERE codigo = '".$url[3]."' AND sala = '".$url[2]."'");
				if ($rodCod == false) {
					echo '<div class="nada-encontrado"><h2>Esse código não existe.</h2></div>';
				}else{
				?> 

				<div class="corpo-single" id="corpo-single">
			<div class="title"><h2><?php echo $url[3]; ?></h2></div><br>
			<?php 
			
				if ($inscritos == false) {
					echo '<div class="nada-encontrado"><h2>Não há Inscritos nessa sala.</h2></div>';
				}else{
					for ($i=0; $i < count($inscritos); $i++) { 
					$foto = DBread('bolsistas', "WHERE npacce = '".$inscritos[$i]['npacce']."'", "id, foto");
			?>
			<div class="foto-single">
				<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'/'.$inscritos[$i]['npacce'];	 ?>">
				<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
				<div class="nome"><?php echo $inscritos[$i]['nomeUsual']; ?></div>
				</a>
			</div>
			<?php } } ?>
		</div>
		<div id="clear"></div>
		<div id="cont"><br><?php if($inscritos == true){ echo '('.count($inscritos).')'; } ?></div> </div>


				<?php
//======================================== fim Lista de relatórios=====================================
				}
			}else{
				echo '<div class="nada-encontrado"><h2>Acesso Negado.</h2></div>';
			}
		?>	
		<?php
			}else{
//========================================Inscritos na sala=======================================
		?>
		<div class="corpo-single">
			<div class="title"><h2>Inscritos</h2></div><br>
			<?php 
				
				if ($inscritos == false) {
					echo '<div class="nada-encontrado"><h2>Não há Inscritos nessa sala.</h2></div>';
				}else{
					for ($i=0; $i < count($inscritos); $i++) { 
						$foto = DBread('bolsistas', "WHERE npacce = '".$inscritos[$i]['npacce']."'", "id, foto");
				//PARA ACESSAR OS RELATÓRIOS INDIVIDUAIS
				$cpf = DBread('bolsistas', "WHERE npacce = '".$inscritos[$i]['npacce']."'", "cpf");
				$link = false;
				if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno') {
					$link = true;
				}
				if ($link == true) {
					echo '<a href="'.$way.'/gerenciar-bolsistas/'.$cpf[0]['cpf'].'/'.$inscritos[$i]['npacce'].'">';
				}
			?>
			<div class="foto-single">
				<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
				<div class="nome"><?php echo $inscritos[$i]['nomeUsual']; ?></div>
			</div>
			<?php 
				if($link == true){
					echo '</a>';
				}
				} //EXIBIR INSCRITOS
			}//FIM INSCRITOS NA SALA 
			?>
		</div>
		<div id="clear"></div>
		<div id="cont"><br><?php if($inscritos == true){ echo '('.count($inscritos).')'; } ?></div>
	</div>
	<?php 
		//=============================Relatórios ================================//
		if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico' || $user['npacce'] == $rod['npacce1'] || $user['npacce'] == $rod['npacce2']) {
	?>
	<br><br>
<div class="title"><h2>Presenças</h2></div>
<?php 
	$rodCod = DBread('rod_cod', "WHERE sala = '".$rod['sala']."' AND status = true");
	if ($rodCod == false) {
		echo '<div class="nada-encontrado"><h2>Não há registro de presença.</h2></div>';
	}else{
?>
<div class="tabela">
	<table border="">
		<tr>
			<th>Código:</th>
			<th>Semana:</th>
			<th>Situação:</th>
		</tr>
		<?php
			//Logica das datas para envio de relatório
			//$dia = 5;
			//echo date('d-m-Y', strtotime('+'.$dia.' week', strtotime($rod['dataInicio'])));
			$cn = 0;
			for ($i=0; $i < count($rodCod); $i++) { 
				if (date('Y-m-d H:i:s', strtotime('+'.$i.' week', strtotime($rod['dataInicio']))) < date('Y-m-d H:i:s')) {
					//echo date('Y-m-d H:i:s', strtotime('+'.$i.' week', strtotime($rod['dataInicio']))).'<br>'.date('Y-m-d H:i:s').'<br>';
					$cn++;
		?>
		<tr>
			<td><?php echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'/'.$rodCod[$i]['codigo'].'">'.$rodCod[$i]['codigo'].'</a>'; ?></td>
			<td>
			<?php 
				echo substr($rodCod[$i]['codigo'], -4, 2);
			 ?>
			 </td>
			<td>Esses formulário ainda estão disponíveis</td>
		</tr>
		<?php } }?>
	</table>
	<div id="cont"><br><?php if($cn > 0){ echo '('.$cn.')';} ?></div>
</div>
	<?php 
			}	 }
		}
	}
}
?>