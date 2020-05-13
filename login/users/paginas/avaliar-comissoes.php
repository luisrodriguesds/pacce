<div>
	<div class="title"><h2>Avaliar Comissões</h2></div>
	<p>Você poderá retonar ao Programa de Aprendizagem Cooperativa em Células Estudantis
		o feedback das reuniões das comissões e seus respectivos menbros. Essa avaliação é de extrema importância,
	por isso é necessário a maior seriadade possível na hora de responder essas formulários. </p>
	<br><br>
	<?php 


	if (isset($url[4]) && $url[4] != '' && $url[4] != 'avaliacao-geral') {
		$defaultHoraInicial = '';
		$defaultHoraFinal = '';
		$bolsista = DBread('bolsistas', "WHERE npacce = '".$url[4]."'", "id, npacce, nome, nomeUsual, sexo, tipoSlug");
		if($bolsista == false) {
			echo '<div class="nada-encontrado"><h2>Nenhum bolsista encontrado.</h2></div>';
		}else{
			if ($bolsista[0]['tipoSlug'] == 'apoio-a-celula') {
				$codigo = 'APO';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else if($bolsista[0]['tipoSlug'] == 'interacao'){
				$codigo = 'INT';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else if($bolsista[0]['tipoSlug'] == 'formacao' || $bolsista[0]['tipoSlug'] == 'formacao-sobral'){
				$codigo = 'FOR';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else if($bolsista[0]['tipoSlug'] == 'historia-de-vida'){
				$codigo = 'ROD';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else if($bolsista[0]['tipoSlug'] == 'apoio-interno'){
				$codigo = 'API';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else if($bolsista[0]['tipoSlug'] == 'apoio-tecnico'){
				$codigo = 'ATC';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else if($bolsista[0]['tipoSlug'] == 'avaliacao'){
				$codigo = 'AVA';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else if($bolsista[0]['tipoSlug'] == 'comunicacao'){
				$codigo = 'COM';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else if($bolsista[0]['tipoSlug'] != ''){
				$codigo = 'ARP';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else if($bolsista[0]['tipoSlug'] != ''){
				$codigo = 'ARP';
				$codigo = $codigo.date('y').substr($url[3], -2);
			}else{
				echo '<script>alert("Essa comissão não pode ser avaliada!.");
				window.location="'.$way.'/'.$url[1].'";</script>';

			}


			if ($bolsista[0]['tipoSlug'] != 'apoio-tecnico' && $bolsista[0]['tipoSlug'] != 'ceo' && $bolsista[0]['tipoSlug'] != '') {

				$rCom = DBread('rgc', "WHERE comissaoSlug = '".$bolsista[0]['tipoSlug']."' ");
//var_dump($rCom);
				$rCom = $rCom[0];
				if ($rCom != '') {
					$defaultHoraInicial = explode(':', $rCom['horaInicio']);

					$defaultHoraFinal = explode(':', $rCom['horaTermino']);

				}
//var_dump($rCom['horaInicio']);
			}


			$select = DBread('av_comissao', "WHERE codigo = '".$codigo."' AND npacce = '".$bolsista[0]['npacce']."'");


// echo $codigo;
			$cod = strtolower(substr($codigo, 0, 3));
			$tabela = 'av_comissao';

			if (isset($_POST['enviar'])) {
				$form['npacce'] 			= $bolsista[0]['npacce'];
				$form['nome']				= $bolsista[0]['nome'];
				$form['codigo']				= $codigo;
				$form['npacce1'] 			= $user['npacce'];
				$form['nome1'] 				= $user['nome'];
				$form['registro']			= date('Y-m-d h:i:s');
				$form['semana']				= substr($url[3], -2);

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
				}else if($form['presenca'] == 0){
					$form['presenca'] 			= 0;
					$form['entrada'] 			= '00:00:00';
					$form['saida'] 				= '00:00:00';
					$form['participacao'] 		= '0';
					$form['habilidades'] 		= '0';
					$form['responsabilidade'] 	= '0';
					$form['contribuicao'] 		= '0';
					$form['protagonismo'] 		= '0';
					$form['obs'] 				= '';

					if ($select == false) {
						if (DBcreate($tabela, $form)) {
							echo '<script>alert("Relatório enviado com sucesso.");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}else{
						if (DBUpDate($tabela, $form, "codigo = '$codigo' AND npacce = '".$bolsista[0]['npacce']."'")){
							echo '<script>alert("Relatório editado com sucesso.");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';

						}
					}
				}else if($form['presenca'] == 2){
					$form['presenca'] 			= 2;
//$form['entrada'] 			= '';
//$form['saida'] 				= '';
					$form['participacao'] 		= '0';
					$form['habilidades'] 		= '0';
					$form['responsabilidade'] 	= '0';
					$form['contribuicao'] 		= '0';
					$form['protagonismo'] 		= '0';
//$form['obs'] 				= '';

					if (empty($form['entrada'])) {
						echo '<script>alert("Campo Entrada está vazio");</script>';
					}else if (empty($form['saida'])) {
						echo '<script>alert("Campo Saida está vazio");</script>';
					}else{
						if ($select == false) {
							if (DBcreate($tabela, $form)) {
								echo '<script>alert("Relatório enviado com sucesso.");
								window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
							}
						}else{
							if (DBUpDate($tabela, $form, "codigo = '$codigo' AND npacce = '".$bolsista[0]['npacce']."'")){
								echo '<script>alert("Relatório editado com sucesso.");
								window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';

							}
						}
					}
				}else if($form['presenca'] == 3){
					$form['presenca'] 			= 3;
					if ($rCom['horaInicio'] == '' || $rCom['horaTermino'] == '') {
						$form['entrada'] 			= '';
						$form['saida'] 				= '';
					} else {
						$form['entrada'] 			= $rCom['horaInicio'];
						$form['saida'] 				= $rCom['horaTermino'];

					}

					if (empty($form['entrada']) ||empty($form['saida'])) {
						echo '<script>alert("Horário de Reunião de Comissão não cadastrado!");</script>';
					}else{
						if ($select == false) {
							if (DBcreate($tabela, $form)) {
								echo '<script>alert("Relatório enviado com sucesso.");
								window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
							}
						}else{
							if (DBUpDate($tabela, $form, "codigo = '$codigo' AND npacce = '".$bolsista[0]['npacce']."'")){
								echo '<script>alert("Relatório editado com sucesso.");
								window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';

							}
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
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}else{
						if (DBUpDate($tabela, $form, "codigo = '$codigo' AND npacce = '".$bolsista[0]['npacce']."'")){
							echo '<script>alert("Relatório editado com sucesso.");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';

						}
					}
				}
			} 

			?>
			<div class="title"><h2><?php if($bolsista[0]['sexo'] == 0){ echo 'Formulário de avaliação da '.$bolsista[0]['nome'];}else{echo 'Formulário de avaliação do '.$bolsista[0]['nome'];} ?></h2></div>
			<div id="editar-ativ" class="form">
				<?php 
				if ($select == true) {
					?>
					<div>
						<span><strong>Avaliado por:<br></strong></span>
						<span><?php echo $select[0]['nome1']; ?></span> <strong> <br>em </strong> <?php echo date('d/m/Y H:i:s', strtotime($select[0]['registro'])).' - '.$week[date('D', strtotime($select[0]['registro']))]; ?><br><br>
					</div>
					<?php 
				}
				?>
				<script type="text/javascript">

					$('.presenca').ready(function (event) {
						console.log($(this).val());
						if (<?php if ($select[0]['presenca'] != '') {echo $select[0]['presenca'];} else { echo 0 ;}  ?> == 1) {
							$(".wrap_form").css('display', 'block');
						} else {
							$(".wrap_form").css('display', 'none');
						}
					});

					$(function(){
						$('.presenca').click(function(event) {
							/* Act on the event */
							if ($(this).val() == 1) {
								$(".wrap_form").css('display', 'block');
							}else{
								$(".wrap_form").css('display', 'none');
							}
							console.log($(this).val());
						});

					});
				</script>
				<form action="" method="post" enctype="multipart/form-data">
					<label>Compareceu a reunião?</label><br><br>
					<input type="radio" class="presenca" name="presenca" value="0" <?php if($select == true && $select[0]['presenca'] == 0){echo 'checked=""';} ?> ></input> Não<br><br>
					<input type="radio" class="presenca" name="presenca" value="1" <?php if($select == true && $select[0]['presenca'] == 1){echo 'checked=""';} ?> ></input> Sim<br><br>
					<input type="radio" class="presenca" name="presenca" value="2" <?php if($select == true && $select[0]['presenca'] == 2){echo 'checked=""';} ?>></input> Não, mas efetuou a reposição<br><br>
					<input type="radio" class="presenca" name="presenca" value="6" <?php if($select == true && $select[0]['presenca'] == 6){echo 'checked=""';} ?>></input> Não, mas justificou<br><br>
					<input type="radio" class="presenca" name="presenca" value="3" <?php if($select == true && $select[0]['presenca'] == 3){echo 'checked=""';} ?>></input> Feriado<br><br>
					<div class="wrap_form" style="display: none;">
						<label>Pontualidade:</label> <br><br>

						<label>Entrada:</label><br>
						<select name="horaEnt">
							<?php
							if($select == true){
								$hora = explode(":", $select[0]['entrada']);
							}else{
								$hora = '';
							}

							for ($i=0; $i <= 23; $i++) {
								if($i < 10){
									$value = '0'.$i;
								}else{
									$value = $i;
								} 

								if ($select == true) {
									if($value == $hora[0]){
										$checked = 'selected=""';
									}else{
										$checked = '';
									}
								} else {
									if($value == $defaultHoraInicial[0]){
										$checked = 'selected=""';
									}else{
										$checked = '';
									}
								}


								echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
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
								if ($select == true) {
									if($value == $hora[1]){
										$checked = 'selected=""';
									}else{
										$checked = '';
									}
								} else {
									if($value == $defaultHoraInicial[1]){
										$checked = 'selected=""';
									}else{
										$checked = '';
									}
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

						<label>Saída:</label><br>
						<select name="horaSaida">
							<?php
							if($select == true){
								$hora = explode(":", $select[0]['saida']);
							}else{
								$hora = '';
							} 
							for ($i=0; $i <= 23; $i++) {
								if($i < 10){
									$value = '0'.$i;
								}else{
									$value = $i;
								} 
								if ($select == true) {
									if($value == $hora[0]){
										$checked = 'selected=""';
									}else{
										$checked = '';
									}
								} else {
									if($value == $defaultHoraFinal[0]){
										$checked = 'selected=""';
									}else{
										$checked = '';
									}
								}
								echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
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
								if ($select == true) {
									if($value == $hora[1]){
										$checked = 'selected=""';
									}else{
										$checked = '';
									}
								} else {
									if($value == $defaultHoraFinal[1]){
										$checked = 'selected=""';
									}else{
										$checked = '';
									}
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
						<br><br>

						<label>Participação:</label><br><br>
						<table width="100%">
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>4</td>
								<td>5</td>
							</tr>
							<tr>
								<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 1){echo 'checked=""';} ?> name="participacao" value="1"></input></td>
								<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 2){echo 'checked=""';} ?>  name="participacao" value="2"></input></td>
								<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 3){echo 'checked=""';} else if ($select == '') { echo 'checked=""';} ?>  name="participacao"  value="3"></input></td>
								<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 4){echo 'checked=""';} ?>  name="participacao" value="4"></input></td>
								<td><input type="radio" <?php if($select == true && $select[0]['participacao'] == 5){echo 'checked=""';} ?> name="participacao" value="5"></input></td>
							</tr>
						</table>
						<br>	<br>
						<label>Habilidades:</label><br><br>
						<table width="100%">
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>4</td>
								<td>5</td>
							</tr>
							<tr>
								<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 1){echo 'checked=""';} ?> name="habilidades" value="1"></input></td>
								<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 2){echo 'checked=""';} ?> name="habilidades" value="2"></input></td>
								<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 3){echo 'checked=""';} else if ($select == '') { echo 'checked=""';} ?> name="habilidades"  value="3"></input></td>
								<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 4){echo 'checked=""';} ?> name="habilidades" value="4"></input></td>
								<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 5){echo 'checked=""';} ?> name="habilidades" value="5"></input></td>
							</tr>
						</table>
						<br>	<br>
						<label>Responsabilidade:</label><br><br>
						<table width="100%">
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>4</td>
								<td>5</td>
							</tr>
							<tr>
								<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 1){echo 'checked=""';} ?> value="1"></input></td>
								<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 2){echo 'checked=""';} ?> value="2"></input></td>
								<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 3){echo 'checked=""';} else if ($select == '') { echo 'checked=""';} ?>  value="3"></input></td>
								<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 4){echo 'checked=""';} ?> value="4"></input></td>
								<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 5){echo 'checked=""';} ?> value="5"></input></td>
							</tr>
						</table>
						<br>	<br>
						<label>Contribuição:</label><br><br>
						<table width="100%">
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>4</td>
								<td>5</td>
							</tr>
							<tr>
								<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 1){echo 'checked=""';} ?> value="1"></input></td>
								<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 2){echo 'checked=""';} ?> value="2"></input></td>
								<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 3){echo 'checked=""';} else if ($select == '') { echo 'checked=""';} ?>  value="3"></input></td>
								<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 4){echo 'checked=""';} ?> value="4"></input></td>
								<td><input type="radio" name="contribuicao" <?php if($select == true && $select[0]['contribuicao'] == 5){echo 'checked=""';} ?> value="5"></input></td>
							</tr>
						</table>
						<br>	<br>
						<label>Protagonismo:</label><br><br>
						<table width="100%">
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>4</td>
								<td>5</td>
							</tr>
							<tr>
								<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 1){echo 'checked=""';} ?> value="1"></input></td>
								<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 2){echo 'checked=""';} ?> value="2"></input></td>
								<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 3){echo 'checked=""';} else if ($select == '') { echo 'checked=""';} ?>  value="3"></input></td>
								<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 4){echo 'checked=""';} ?> value="4"></input></td>
								<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 5){echo 'checked=""';} ?> value="5"></input></td>
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
	} else if (isset($url[4]) && $url[4] != '' && $url[4] == 'avaliacao-geral'){
// AVALIAÇÃO GERAL ====================================================
		$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
		if ($comissao == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
			echo '<div class="title"><h2>Avaliação Geral da comissão '.$comissao[0]['comissao'].'</h2></div>';
			$week 	 = substr($url[3], -2); 
			$avGeral = DBread('av_geral', "WHERE comissaoSlug = '".$url[2]."' AND semana = '$week'");

			$rCom = DBread('rgc', "WHERE comissaoSlug = '".$url[2]."' ");
			$rCom = $rCom[0];

			if (isset($_POST['enviar'])) {
				$form['comissao'] 		= $comissao[0]['comissao'];
				$form['comissaoSlug'] 	= $comissao[0]['comissaoSlug'];
				$form['npacce1']		= $user['npacce'];
				$form['nome1']			= $user['nome'];	
				$form['registro']		= date('Y-m-d H:i:s');
				$form['semana']			= $week;

				$form['presenca'] 		= GetPost('presenca');
				$form['inicio'] 		= GetPost('inicio');
				$form['fim'] 			= GetPost('fim');
				$form['qualidade'] 		= GetPost('qualidade');
				$form['obs'] 			= GetPost('obs');
				if ($form['presenca'] == '') {
					echo '<script>alert("Campo Presença está vazio");</script>';
				}else if ($form['presenca'] == 0) {
					$form['presenca'] 		= GetPost('presenca');
					$form['inicio'] 		= '';
					$form['fim'] 			= '';
					$form['qualidade'] 		= 0;
					$form['obs'] 			= '';
					if ($avGeral == false) {
						if (DBcreate('av_geral', $form)) {
							echo '<script>alert("Relatório enviado com sucesso.");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';

						}
					}else{
						if (DBUpDate('av_geral', $form, "comissaoSlug = '".$comissao[0]['comissaoSlug']."' AND semana = '$week'")) {
							echo '<script>alert("Relatório editado com sucesso.");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}
				}else if (empty($form['inicio'])) {
					echo '<script>alert("Campo Horário do Início está vazio");</script>';
				}else if (empty($form['fim'])) {
					echo '<script>alert("Campo Horário de término está vazio");</script>';
				}else if (empty($form['qualidade'])) {
					echo '<script>alert("Campo Qualidade da reunião está vazio");</script>';
				}else{
					if ($avGeral == false) {
						if (DBcreate('av_geral', $form)) {
							echo '<script>alert("Relatório enviado com sucesso.");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';

						}
					}else{
						if (DBUpDate('av_geral', $form, "comissaoSlug = '".$comissao[0]['comissaoSlug']."' AND semana = '$week'")) {
							echo '<script>alert("Relatório editado com sucesso.");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}
				}
			}
			?>
			<div id="editar-ativ" class="form">
				<?php 
				if ($avGeral == true) {
					?>
					<div>
						<span><strong>Avaliado por:<br></strong></span>
						<span><?php echo $avGeral[0]['nome1']; ?></span> <strong> <br>em </strong> <?php echo date('d/m/Y H:i:s - D', strtotime($avGeral[0]['registro'])); ?><br><br>
					</div>
					<?php 
				}
				?>
				<form action="" method="post" enctype="multipart/form-data">
					Houve reunião? <br><br>
					<input type="radio" name="presenca" value="0" <?php if($avGeral == true && $avGeral[0]['presenca'] == 0 ){echo 'checked';} ?>></input>  Não<br><br>
					<input type="radio" name="presenca" value="1" <?php if($avGeral == true && $avGeral[0]['presenca'] == 1 ){echo 'checked';} ?>></input>  Sim<br><br>
					<input type="radio" name="presenca" value="2" <?php if($avGeral == true && $avGeral[0]['presenca'] == 2 ){echo 'checked';} ?>></input>  Feriado<br><br>
					Horário de Início:<br>
					<input type="time" value="<?php if($avGeral == true){echo $avGeral[0]['inicio'];} else if ($avGeral == ''){echo $rCom['horaInicio'];} ?>" name="inicio"></input><br><br>
					Horário do Término:<br>
					<input type="time" value="<?php if($avGeral == true){echo $avGeral[0]['fim'];} else if ($avGeral == ''){echo $rCom['horaTermino'];} ?>" name="fim"></input><br><br>

					Qualidade da reunião:  <br><br>
					<table width="100%">
						<tr>
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
							<td>5</td>
						</tr>
						<tr>
							<td><input type="radio" name="qualidade" <?php if($avGeral == true && $avGeral[0]['qualidade'] == 1){echo 'checked';} ?> value="1"></input></td>
							<td><input type="radio" name="qualidade" <?php if($avGeral == true && $avGeral[0]['qualidade'] == 2){echo 'checked';} ?> value="2"></input></td>
							<td><input type="radio" name="qualidade" <?php if($avGeral == true && $avGeral[0]['qualidade'] == 3){echo 'checked';} ?> checked="" value="3"></input></td>
							<td><input type="radio" name="qualidade" <?php if($avGeral == true && $avGeral[0]['qualidade'] == 4){echo 'checked';} ?> value="4"></input></td>
							<td><input type="radio" name="qualidade" <?php if($avGeral == true && $avGeral[0]['qualidade'] == 5){echo 'checked';} ?> value="5"></input></td>
						</tr>
					</table>
					<br>
					Observações:<br>
					<textarea name="obs"><?php if($avGeral == true){echo $avGeral[0]['obs'];} ?></textarea>
					<center>
						<input type="submit" value="Enviar" name="enviar"></input>
					</center>
				</form>
			</div>

			<?php
		}

	}
// AVALIAÇÃO GERAL E INDIVIDUAVAL ====================================================
	else if (isset($url[3]) && $url[3] != '') {
		$menbros = DBread('bolsistas', "WHERE tipoSlug = '".$url[2]."' AND status = true ORDER BY nome ASC", "id, nome, nomeUsual, npacce");
		echo '<div class="title"><h2><a href="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'/avaliacao-geral">Avaliação Geral</a></h2></div><br><br>';
		echo '<div class="title"><h2>Membros</h2></div>';
		if ($menbros == false) {
			echo '<div class="nada-encontrado"><h2>Não há membros nessa comissão.</h2></div>';
		}else{
			?>
			<div class="page-ati-single">
				<div class="corpo-single">
					<?php 
					for ($i=0; $i < count($menbros); $i++) { 

						?>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'/'.$menbros[$i]['npacce']; ?>">
							<div class="foto-single">
								<?php  
								$foto = DBread('bolsistas', "WHERE npacce = '".$menbros[$i]['npacce']."'", "id, foto");
								?>
								<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
								<div class="nome"><?php echo GetName($menbros[$i]['nome'], $menbros[$i]['nomeUsual']); ?></div>
							</div>
						</a>
						<?php 
					}
					?>
					<div id="clear"></div>
				</div>
			</div>
			<div id="cont"><br><?php echo '('.count($menbros).')';?></div>
			<?php
		}
		?>


		<?php
	}else if (isset($url[2]) && $url[2] != '') {

		if (isset($_GET['actionpage']) && $_GET['actionpage'] == 'cadastrar-reuniao') {
			$reuniao = DBread('rgc', "WHERE comissaoSlug = '".$url[2]."'");
			if (isset($_POST['enviar'])) {

				if ($url[2] == 'apoio-a-celula') {
					$codigo = 'APO';
					$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
				}else if($url[2] == 'interacao'){
					$codigo = 'INT';
					$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
				}else if($url[2] == 'formacao' || $url[2] == 'formacao-sobral'){
					$codigo = 'FOR';
					$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
				}else if($url[2] == 'historia-de-vida'){
					$codigo = 'ROD';
					$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
				}else if($url[2] == 'apoio-interno'){
					$codigo = 'API';
					$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
				}else if($url[2] == 'apoio-tecnico'){
					$codigo = 'ATC';
					$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
				}else if($url[2] == 'avaliacao'){
					$codigo = 'AVA';
					$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
				}else if($url[2] == 'comunicacao'){
					$codigo = 'COM';
					$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
				}else{
					$codigo = 'ARP';
					$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
				}

				$form['codigo'] 		= $codigo;
				$form['comissao'] 		= $comissao[0]['comissao'];
				$form['comissaoSlug'] 	= $url[2];
				$form['local'] 			= GetPost('local');
				$form['diaSemana'] 		= GetPost('diaSemana');
				$form['horaInicio'] 	= GetPost('inicio');
				$form['horaTermino'] 	= GetPost('fim');
				$form['status'] 		= 1;
				$form['registro'] 		= date('Y-m-d H:i:s');
				$form['npacceATec'] 	= $user['npacce'];

				if ($reuniao == false) {
					if (DBcreate('rgc', $form)) {

						alertaLoad("Registro enviado com sucesso", $way.'/'.$url[1].'/'.$url[2]);
					}	
				}else{

					if (DBUpDate('rgc', $form, "comissaoSlug='".$comissao[0]['comissaoSlug']."'")) {
						alertaLoad("Registro enviado com sucesso", $way.'/'.$url[1].'/'.$url[2]);
					}
				}
			}
			?>	

			<h1>Cadastrar reunião de comissão</h1>
			<div id="editar-ativ" class="form">
				<form method="post">
					<label>Horaráio de Início:</label><br>
					<input type="time" value="<?php echo (($reuniao) ? $reuniao[0]['horaInicio'] : ''); ?>" name="inicio"></input><br><br>
					<label>Horaráio do término:</label><br>
					<input type="time" value="<?php echo (($reuniao) ? $reuniao[0]['horaTermino'] : ''); ?>" name="fim"></input><br><br>
					<label>Dia semana:</label><br>
					<select name="diaSemana">
						<option value="Segunda-Feira" <?php echo (($reuniao[0]['diaSemana'] == 'Segunda-Feira')?'selected':''); ?>>Segunda-Feira</option>
						<option value="Terça-Feira" <?php echo (($reuniao[0]['diaSemana'] == 'Terça-Feira')?'selected':''); ?> >Terça-Feira</option>
						<option value="Quarta-Feira" <?php echo (($reuniao[0]['diaSemana'] == 'Quarta-Feira')?'selected':''); ?> >Quarta-Feira</option>
						<option value="Quinta-Feira" <?php echo (($reuniao[0]['diaSemana'] == 'Quinta-Feira')?'selected':''); ?> >Quinta-Feira</option>
						<option value="Sexta-Feira" <?php echo (($reuniao[0]['diaSemana'] == 'Sexta-Feira')?'selected':''); ?> >Sexta-Feira</option>
						<option value="Sábado" <?php echo (($reuniao[0]['diaSemana'] == 'Sábado')?'selected':''); ?> >Sábado</option>
						<option value="Domingo" <?php echo (($reuniao[0]['diaSemana'] == 'Domingo')?'selected':''); ?> >Domingo</option>
					</select>
					<br><br>
					<label>Local:</label>
					<input type="text" name="local" placeholder="Digite o local da reunião" value="<?php echo (($reuniao) ? $reuniao[0]['local'] : ''); ?>">

					<center>
						<input type="submit" class="" name="enviar" value="Enviar">
					</center>
				</form>
			</div>
			<?php

		}else{


			?>
			<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'?actionpage=cadastrar-reuniao'; ?>" class="botao">Cadastrar Reunião</a>
			<a href="<?php echo URL_PAINEL.'paginas/sl-comissao-single.php?comissao='.$url[2]; ?>" target="_blank" class="botao">Lista de Presença</a>
			<?php
// SEMANA ====================================================
			if ($url[2] == 'articulador-de-celula' || $url[2] == 'prece-escola') {
				echo '<div class="nada-encontrado"><h2>Acesso Negado.</h2></div>';
			}else{
				echo '<div class="title"><h2>Semanas</h2></div>';
				for ($i=1; $i <= $semana; $i++) { 
					if ($i < 10) {
						$week = '0'.$i;
					}else{
						$week = $i;
					}
					?>
					<a class="botao" href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/semana-'.$week; ?>"><?php echo 'Semana '.$week; ?></a>

					<?php 
				}
			}
		}	
	}else{

		?>
		<?php 
// COMISSOES ====================================================
		echo '<div class="title"><h2>Comissões</h2></div>';
		$comissoes = DBread('comissoes', "WHERE status = true");
		if ($comissoes == false) {
			echo '<div class="nada-encontrado"><h2>Não há comissões registradas no momento.</h2></div>';
		}else{
			?>


			<?php 

			for ($i=0; $i <count($comissoes); $i++) { 
				if($comissoes[$i]['comissao'] != "Articulador de Célula" && $comissoes[$i]['comissao'] !="Projeto Site"){

					?>

					<a class="botao" href="<?php echo $way.'/'.$url[1].'/'.$comissoes[$i]['comissaoSlug']; ?>"><?php echo $comissoes[$i]['comissao']; }?></a>

					<?php 
				}
				?>

				<?php
			}
		}
		?>
	</div>