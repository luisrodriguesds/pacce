<div class="title"><h2>Atividades Coletivas</h2></div>
<p> Página destinada ao cadastro e registro de presença em eventos coletivos</p>
<br><br>
<?php
	//CADASTRAR EVENTO 
	if (isset($url[2]) && $url[2] == 'cadastrar-evento') {
			if (isset($_POST['enviar'])) {
				$form['npacce']		= $user['npacce'];
				$form['codigo']		= GetPost('codigo');
				$form['evento']		= GetPost('evento');
				$form['eventoSlug']	= Slug($form['evento']);
				$form['data']		= GetPost('data');
				$form['inicio']		= GetPost('horaEnt').':'.GetPost('minEnt').':'.GetPost('segEnt');
				$form['fim']		= GetPost('horaSaida').':'.GetPost('minSaida').':'.GetPost('segSaida');
				$form['regiao']		= GetPost('regiao');
				$form['regiaoSlug'] = Slug($form['regiao']);
				$form['local']		= GetPost('local');
				$form['status']		= GetPost('status');
				$form['presenca']	= GetPost('presenca');
				$form['cor']		= GetPost('cor');
				$form['registro']	= date('Y-m-d H:i:s');
				$form['direcao']	= GetPost('direcao');

				if (empty($form['codigo'])) {
					echo '<script>alert("Campo Código vazio");</script>';
				}else if (empty($form['evento'])) {
					echo '<script>alert("Campo Evento vazio");</script>';
				}else if (empty($form['data'])) {
					echo '<script>alert("Campo Data vazio");</script>';
				}else if (empty($form['inicio'])) {
					echo '<script>alert("Campo Inicio vazio");</script>';
				}else if (empty($form['fim'])) {
					echo '<script>alert("Campo Fim vazio");</script>';
				}else if (empty($form['local'])) {
					echo '<script>alert("Campo Local vazio");</script>';
				}else if (empty($form['regiao'])) {
					echo '<script>alert("Campo Região vazio");</script>';
				}else if (empty($form['cor'])) {
					echo '<script>alert("Campo Cor vazio");</script>';
				}else if (empty($form['direcao'])) {
					echo '<script>alert("Nenhuma Direção selecionada");</script>';
				}else{
					$check = DBread('eventos', "WHERE codigo = '".$form['codigo']."'", "id");
					if ($check == true) {
						echo '<script>alert("Código já existente!!");</script>';
					}else{
						$check = DBread('eventos', "WHERE eventoSlug = '".$form['eventoSlug']."'", "id");
						if ($check == true) {
							echo '<script>alert("Evento já existente!!");</script>';
						}else{
							if (DBcreate('eventos', $form)) {
								echo '<script>alert("Dados salvos com sucesso!!");
    							window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}
					}
				}
			}
		?>
		<div class="title"><h2>Cadastrar Evento</h2></div>
		<div class="form center">
			<form method="post">
				<label>Código</label> <span class="red">*</span> <br>	
				<input type="text" name="codigo" onkeyup="maiuscula(this)" value="<?php echo GetPost('codigo'); ?>" autocomplete="off" placeholder="Digite um código"><br><br>

				<label>Evento</label> <span class="red">*</span> <br>	
				<input type="text" name="evento" value="<?php echo GetPost('evento'); ?>" autocomplete="off" placeholder="Digite nome do Evento"><br><br>

				<label>Direção (A comissão que está à frente desse evento)</label> <span class="red">*</span> <br>	
				<select name="direcao">
					<?php  
					$comissoes = DBread('comissoes', "WHERE status = '1'");
					var_dump($comissoes);
					for ($i=0; $i < count($comissoes) ; $i++) { 
						?>

						<option value="<?php echo $comissoes[$i]['comissaoSlug'];?>"><?php echo $comissoes[$i]['comissao']; ?></option>

						<?php
					}
					?>
					<option value="coordenacao">Coordenação</option>
				</select> <br><br>

				<label>Data</label> <span class="red">*</span> <br>
				<input type="date" name="data" value="<?php if(GetPost('data')){ echo date('Y-m-d', strtotime(GetPost('data'))); } ?>"><br><br>

				<label>Início</label> <span class="red">*</span> <br>
				<select name="horaEnt">
			 	<?php
			 	$select = $form['inicio'];
			 	if($select !== false){
		 			$hora = explode(":", $select);
		 		}else{
		 			$hora = '';
		 		}
			 		
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
			 	<br><br><br>
			 	<label>Fim</label> <span class="red">*</span> <br>
			 	<select name="horaSaida">
			 	<?php
			 		$select = $form['fim'];
				 	if($select !== false){
			 			$hora = explode(":", $select);
			 		}else{
			 			$hora = '';
			 		}
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
			 	<br><br><br>
			 	 <label class="label">Região:</label><span style="color:red;"> * </span><br>
			   		 <select name="regiao">
			          <option selected="" value="-1">Escolha um campus...</option>
			          <option value="Fortaleza"	title="Benfica, PICI, Porangabuçu e LABOMAR">Fortaleza</option>
			          <option value="Crateús">Crateús</option>
			          <option value="Quixadá">Quixadá</option>
			          <option value="Russas">Russas</option>
			          <option value="Sobral">Sobral</option>
			       </select>
			 	<br><br>
			 	<label>Local</label> <span class="red">*</span> <br>	
				<input type="text" <?php echo 'value="'.GetPost('local').'"'; ?> name="local" onkeyup="maiuscula(this)" autocomplete="off" placeholder="Digite o local"><br><br>
				<label>Status</label> <span class="red">*</span> <br>
				<select name="status">
					<option value="1" <?php echo printSelect(GetPost('status'), '1'); ?>>Ativo</option>
					<option value="0" <?php echo printSelect(GetPost('status'), '0'); ?>>Inativo</option>
				</select>
				<br><br><br>
			
				<label>Presença</label> <span class="red">*</span> <br>
				<select name="presenca">
					<option value="1" <?php echo printSelect(GetPost('presenca'), '1'); ?>>Ativo</option>
					<option value="0" <?php echo printSelect(GetPost('presenca'), '0'); ?>>Inativo</option>
				</select>
				<br><br><br>

				<center>
					<label>Cor</label> <span class="red">*</span> <br>
					<input type="color" name="cor" value="#a4ddbc">
					<br><br><br><br>
					<input type="submit" name="enviar">
				</center>
			</form>
		</div>
		<?php
	}else if (isset($url[2]) && $url[2] != '') {
		$evento = DBescape($url[2]);
		
		$evento = DBread('eventos', "WHERE codigo = '".$evento."'");
		
		$evento = $evento[0];
		if ($evento == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
		}else{
			//PÁGINA DO EVENTO 

			//GERADOR DE FALTAS
			if ($user['tipoSlug'] == 'ceo') {
				if (isset($_GET['gerar-faltas'])) {
					
					$pres = DBread('eventos_pres', "WHERE codigo = '".$evento['codigo']."'");
					$bolsistas = DBread('bolsistas', "WHERE status = true", "id, nome, npacce, tipoSlug, campusSlug, status");
					if ($pres == false) {
						// echo 'teste';
					}else{
						$msg = 0;
						for ($i=0; $i < count($bolsistas); $i++) { 
							if ($bolsistas[$i]['tipoSlug'] != 'prece-escola' && $bolsistas[$i]['status'] != 0) {
								$cont = 0;
								for ($j=0; $j < count($pres); $j++) { 
										if ($bolsistas[$i]['npacce'] == $pres[$j]['npacce']) {
											$cont++;
										}
									
								}
								if ($cont == 0) {
									//correção
									if ($bolsistas[$i]['campusSlug'] == 'benfica' || $bolsistas[$i]['campusSlug'] == 'pici' || $bolsistas[$i]['campusSlug'] == 'porangabucu' || $bolsistas[$i]['campusSlug'] == 'labomar') {
										$bolsistas[$i]['campusSlug'] = 'fortaleza';
									}

									
									if ($evento['regiaoSlug'] == $bolsistas[$i]['campusSlug']) {
										
										//Cria a falta no evento que era pra ter estado presente
										$form['npacce'] 	= $bolsistas[$i]['npacce'];
										$form['codigo'] 	= $evento['codigo'];
										$form['evento'] 	= $evento['evento'];
										$form['eventoSlug'] = $evento['eventoSlug'];
										$form['presenca']	= 0;
										$form['data']		= $evento['data'];
										$form['status']		= 1;
										$form['registro']	= date('Y-m-d H:i:s');
										DBcreate('eventos_pres', $form);

										//Cria o formulário de avaliação
										$formAv['npacce'] 	= $bolsistas[$i]['npacce'];
										$formAv['codigo'] 	= $evento['codigo'];
										$formAv['evento'] 	= $evento['evento'];
										$formAv['presenca'] = 'nao';
										$formAv['status']	= 1;
										$formAv['registro'] = date('Y-m-d H:i:s');
										DBcreate('eventos_avaliar', $formAv);
									}
									
								}
							}
							$msg++;
						}
						if ($msg == count($bolsistas)) {
							echo '<script>alert("Faltas geradas com sucesso!");
		        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
						}
					}//FIM FALTAS
				}
				if (isset($_GET['action']) && $_GET['action'] != '') {
					switch ($_GET['action']) {
						case 1:
							$up['status'] = 1;
							if (DBUpDate('eventos', $up, "codigo = '".$evento['codigo']."'")) {
									echo '
										<script> 
											alert("Status alterado com sucesso!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
										</script>
									';
							}
						break;
						case 2:
							$up['status'] = 0;
							if (DBUpDate('eventos', $up, "codigo = '".$evento['codigo']."'")) {
									echo '
										<script> 
											alert("Status alterado com sucesso!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
										</script>
									';
							}
						break;
						case 3:
							$up['presenca'] = 0;
							if (DBUpDate('eventos', $up, "codigo = '".$evento['codigo']."'")) {
									echo '
										<script> 
											alert("Presença alterada com sucesso!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
										</script>
									';
							}
						break;
						case 4:
							$up['presenca'] = 1;
							if (DBUpDate('eventos', $up, "codigo = '".$evento['codigo']."'")) {
									echo '
										<script> 
											alert("Presença alterada com sucesso!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
										</script>
									';
							}
						break;
					}
				}
			}
		?>
		<div class="title"><h2>Evento Coletivo</h2></div>
		<br>
			<div class="page-ati-single">
				<div class="cabecario">
					<div class="info-single">
						<ul>
							<li><h3><?php echo $evento['evento']; ?></h3></li>
							<li><?php echo $evento['local']; ?></li>
							<li><?php echo date('d/m/y', strtotime($evento['data'])).''; ?></li>
							<li> <?php echo date('H:i', strtotime($evento['inicio'])).' - '.date('H:i', strtotime($evento['fim'])); ?>
							<br>   <br><?php echo $week[date('D', strtotime($evento['data']))]; ?> </li>
						</ul>
					</div>
					<?php 
						$foto = DBread('bolsistas', "WHERE npacce  = '".$evento['npacce']."'", 'npacce, nome, nomeUsual, foto');
					
					?>
					<div class="foto-single">
						<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto']; ?>"><br></span>
						<div class="nome"> <?php echo GetName($foto[0]['nome'], $foto[0]['nomeUsual']); ?> </div>
					</div>
					<div id="clear"></div>
				</div>
			</div>
			<br>
			<?php
				if (isset($url[3]) && $url[3] == 'avaliar-reuniao') {
					
					if (isset($_POST['enviar'])) {

						$form['npacce']					= $user['npacce'];
						$form['codigo']					= $evento['codigo'];
						$form['evento']					= $evento['evento'];
						$form['presenca']				= "sim";
						$form['divulgacao'] 			= GetPost('divulgacao');
						$form['programacao'] 			= GetPost('programacao');
						$form['organizacao'] 			= GetPost('organizacao');
						$form['pontualidade'] 			= GetPost('pontualidade');
						$form['tematica'] 				= GetPost('tematica');
						$form['instalacoes'] 			= GetPost('instalacoes');
						$form['esclarecimentos'] 		= GetPost('esclarecimentos');
						$form['atividadesCriativas'] 	= GetPost('atividadesCriativas');
						$form['atividadesInformativas'] = GetPost('atividadesInformativas');
						$form['estimuloInteracao'] 		= GetPost('estimuloInteracao');
						$form['intervalo'] 				= GetPost('intervalo');
						$form['procDeGrupo'] 			= GetPost('procDeGrupo');
						$form['comentarios'] 			= GetPost('comentarios');
						$form['autoPontualidade'] 		= GetPost('autoPontualidade');
						$form['disposicao'] 			= GetPost('disposicao');
						$form['envolvimento'] 			= GetPost('envolvimento');
						$form['interacao'] 				= GetPost('interacao');
						$form['protagonismo'] 			= GetPost('protagonismo');
						$form['habilidades'] 			= GetPost('habilidades');
						$form['satisfacao'] 			= GetPost('satisfacao');
						
						$form['status']					= 1;
						$form['registro']				= date('Y-m-d H:i:s');

						if (empty($form['divulgacao'])) {
							echo '<script type="text/javascript">alert("Campo Divulgação vazio!");</script>';
						}else if (empty($form['programacao'])) {
							echo '<script type="text/javascript">alert("Campo Programação vazio!");</script>';
						}else if (empty($form['organizacao'])) {
							echo '<script type="text/javascript">alert("Campo Organização vazio!");</script>';
						}else if (empty($form['pontualidade'])) {
							echo '<script type="text/javascript">alert("Campo Pontualidade vazio!");</script>';
						}else if (empty($form['tematica'])) {
							echo '<script type="text/javascript">alert("Campo tematica vazio!");</script>';
						}else if (empty($form['instalacoes'])) {
							echo '<script type="text/javascript">alert("Campo instalações vazio!");</script>';
						}else if (empty($form['esclarecimentos'])) {
							echo '<script type="text/javascript">alert("Campo Esclarecimento vazio!");</script>';
						}else if (empty($form['atividadesInformativas'])) {
							echo '<script type="text/javascript">alert("Campo atividadesInformativas vazio!");</script>';
						}else if (empty($form['atividadesCriativas'])) {
							echo '<script type="text/javascript">alert("Campo atividadesCriativas vazio!");</script>';
						}else if (empty($form['estimuloInteracao'])) {
							echo '<script type="text/javascript">alert("Campo estimuloInteracao vazio!");</script>';
						}else if (empty($form['intervalo'])) {
							echo '<script type="text/javascript">alert("Campo intervalo vazio!");</script>';
						}else if (empty($form['procDeGrupo'])) {
							echo '<script type="text/javascript">alert("Campo procDeGrupo vazio!");</script>';
						}else if (empty($form['comentarios'])) {
							echo '<script type="text/javascript">alert("Campo comentarios vazio!");</script>';
						}else if (empty($form['autoPontualidade'])) {
							echo '<script type="text/javascript">alert("Campo autoPontualidade vazio!");</script>';
						}else if (empty($form['disposicao'])) {
							echo '<script type="text/javascript">alert("Campo disposicao vazio!");</script>';
						}else if (empty($form['envolvimento'])) {
							echo '<script type="text/javascript">alert("Campo envolvimento vazio!");</script>';
						}else if (empty($form['interacao'])) {
							echo '<script type="text/javascript">alert("Campo interacao vazio!");</script>';
						}else if (empty($form['protagonismo'])) {
							echo '<script type="text/javascript">alert("Campo protagonismo vazio!");</script>';
						}else if (empty($form['habilidades'])) {
							echo '<script type="text/javascript">alert("Campo habilidades vazio!");</script>';
						}else if (empty($form['satisfacao'])) {
							echo '<script type="text/javascript">alert("Campo satisfacao vazio!");</script>';
						}else{
							
							if (DBread('eventos_avaliar', "WHERE npacce = '".$user['npacce']."' AND codigo = '".$evento['codigo']."'")) {
								if (DBUpDate('eventos_avaliar', $form, "npacce = '".$user['npacce']."' AND codigo = '".$evento['codigo']."'")) {
									echo '
						       			<script>
						       			    alert("Avaliação enviada com sucesso!!");
						     			      window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
						   				</script>';
								}
								
							}else{
								if (DBcreate('eventos_avaliar', $form)) {
									echo '
						       			<script>
						       			    alert("Avaliação enviada com sucesso!!");
						     			      window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
						   				</script>';
								}
							}
							
						}

					}

				 	?>
				 	<div class="title"><h2>Avaliação de Reunião Geral</h2></div>
				 	<div class="form center">
				 		<form method="post">
				 			<p>
				 				<strong class="red">Obs:</strong><br><br>
				 				<strong>
				 					
				 				0 – não se aplica<br><br>
								1 a 5 sendo 1 o valor negativo e 5 o maior valor 
								<br><br>
				 				</strong>
				 			</p>
				 			<label>Para cada item, assinale a opção que melhor reflete sua opinião.</label><span class="red"> *</span>
				 			<table>
				 				<tr>
				 					<td></td>
				 					<td>0</td>
				 					<td>1</td>
				 					<td>2</td>
				 					<td>3</td>
				 					<td>4</td>
				 					<td>5</td>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Divulgação prévia da reunião</td>
				 					<td><input type="radio" name="divulgacao" value="0" <?php echo printRadio(GetPost('divulgacao'), '0'); ?> ></td>
				 					<td><input type="radio" name="divulgacao" value="1" <?php echo printRadio(GetPost('divulgacao'), '1'); ?>></td>
				 					<td><input type="radio" name="divulgacao" value="2" <?php echo printRadio(GetPost('divulgacao'), '2'); ?>></td>
				 					<td><input type="radio" name="divulgacao" value="3" <?php echo printRadio(GetPost('divulgacao'), '3'); ?>></td>
				 					<td><input type="radio" name="divulgacao" value="4" <?php echo printRadio(GetPost('divulgacao'), '4'); ?>></td>
				 					<td><input type="radio" name="divulgacao" value="5" <?php echo printRadio(GetPost('divulgacao'), '5'); ?>></td>
				 				</tr>

				 				<tr>
				 					<td style="width: 160px;">Programação do evento</td>
				 					<td><input type="radio" name="programacao" value="0" <?php echo printRadio(GetPost('programacao'), '0'); ?>></td>
				 					<td><input type="radio" name="programacao" value="1" <?php echo printRadio(GetPost('programacao'), '1'); ?>></td>
				 					<td><input type="radio" name="programacao" value="2" <?php echo printRadio(GetPost('programacao'), '2'); ?>></td>
				 					<td><input type="radio" name="programacao" value="3" <?php echo printRadio(GetPost('programacao'), '3'); ?>></td>
				 					<td><input type="radio" name="programacao" value="4" <?php echo printRadio(GetPost('programacao'), '4'); ?>></td>
				 					<td><input type="radio" name="programacao" value="5" <?php echo printRadio(GetPost('programacao'), '5'); ?>></td>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Organização do evento</td>
				 					<td><input type="radio" name="organizacao" value="0" <?php echo printRadio(GetPost('organizacao'), '0'); ?>></td>
				 					<td><input type="radio" name="organizacao" value="1" <?php echo printRadio(GetPost('organizacao'), '1'); ?>></td>
				 					<td><input type="radio" name="organizacao" value="2" <?php echo printRadio(GetPost('organizacao'), '2'); ?>></td>
				 					<td><input type="radio" name="organizacao" value="3" <?php echo printRadio(GetPost('organizacao'), '3'); ?>></td>
				 					<td><input type="radio" name="organizacao" value="4" <?php echo printRadio(GetPost('organizacao'), '4'); ?>></td>
				 					<td><input type="radio" name="organizacao" value="5" <?php echo printRadio(GetPost('organizacao'), '5'); ?>></td>
				 				</tr>

				 				<tr>
				 					<td style="width: 160px;">Pontualidade no início da reunião</td>
				 					<td><input type="radio" name="pontualidade" value="0" <?php echo printRadio(GetPost('pontualidade'), '0'); ?>></td>
				 					<td><input type="radio" name="pontualidade" value="1" <?php echo printRadio(GetPost('pontualidade'), '1'); ?>></td>
				 					<td><input type="radio" name="pontualidade" value="2" <?php echo printRadio(GetPost('pontualidade'), '2'); ?>></td>
				 					<td><input type="radio" name="pontualidade" value="3" <?php echo printRadio(GetPost('pontualidade'), '3'); ?>></td>
				 					<td><input type="radio" name="pontualidade" value="4" <?php echo printRadio(GetPost('pontualidade'), '4'); ?>></td>
				 					<td><input type="radio" name="pontualidade" value="5" <?php echo printRadio(GetPost('pontualidade'), '5'); ?>></td>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Temática da reunião</td>
				 					<td><input type="radio" name="tematica" value="0" <?php echo printRadio(GetPost('tematica'), '0'); ?>></td>
				 					<td><input type="radio" name="tematica" value="1" <?php echo printRadio(GetPost('tematica'), '1'); ?>></td>
				 					<td><input type="radio" name="tematica" value="2" <?php echo printRadio(GetPost('tematica'), '2'); ?>></td>
				 					<td><input type="radio" name="tematica" value="3" <?php echo printRadio(GetPost('tematica'), '3'); ?>></td>
				 					<td><input type="radio" name="tematica" value="4" <?php echo printRadio(GetPost('tematica'), '4'); ?>></td>
				 					<td><input type="radio" name="tematica" value="5" <?php echo printRadio(GetPost('tematica'), '5'); ?>></td>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Adequação das instalações à realização do evento</td>
				 					<td><input type="radio" name="instalacoes" value="0" <?php echo printRadio(GetPost('instalacoes'), '0'); ?>></td>
				 					<td><input type="radio" name="instalacoes" value="1" <?php echo printRadio(GetPost('instalacoes'), '1'); ?>></td>
				 					<td><input type="radio" name="instalacoes" value="2" <?php echo printRadio(GetPost('instalacoes'), '2'); ?>></td>
				 					<td><input type="radio" name="instalacoes" value="3" <?php echo printRadio(GetPost('instalacoes'), '3'); ?>></td>
				 					<td><input type="radio" name="instalacoes" value="4" <?php echo printRadio(GetPost('instalacoes'), '4'); ?>></td>
				 					<td><input type="radio" name="instalacoes" value="5" <?php echo printRadio(GetPost('instalacoes'), '5'); ?>></td>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Esclarecimento de dúvidas</td>
				 					<td><input type="radio" name="esclarecimentos" value="0" <?php echo printRadio(GetPost('esclarecimentos'), '0'); ?>></td>
				 					<td><input type="radio" name="esclarecimentos" value="1" <?php echo printRadio(GetPost('esclarecimentos'), '1'); ?>></td>
				 					<td><input type="radio" name="esclarecimentos" value="2" <?php echo printRadio(GetPost('esclarecimentos'), '2'); ?>></td>
				 					<td><input type="radio" name="esclarecimentos" value="3" <?php echo printRadio(GetPost('esclarecimentos'), '3'); ?>></td>
				 					<td><input type="radio" name="esclarecimentos" value="4" <?php echo printRadio(GetPost('esclarecimentos'), '4'); ?>></td>
				 					<td><input type="radio" name="esclarecimentos" value="5" <?php echo printRadio(GetPost('esclarecimentos'), '5'); ?>></td>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Atividades informativas</td>
				 					<td><input type="radio" name="atividadesInformativas" value="0" <?php echo printRadio(GetPost('atividadesInformativas'), '0'); ?>></td>
				 					<td><input type="radio" name="atividadesInformativas" value="1" <?php echo printRadio(GetPost('atividadesInformativas'), '1'); ?>></td>
				 					<td><input type="radio" name="atividadesInformativas" value="2" <?php echo printRadio(GetPost('atividadesInformativas'), '2'); ?>></td>
				 					<td><input type="radio" name="atividadesInformativas" value="3" <?php echo printRadio(GetPost('atividadesInformativas'), '3'); ?>></td>
				 					<td><input type="radio" name="atividadesInformativas" value="4" <?php echo printRadio(GetPost('atividadesInformativas'), '4'); ?>></td>
				 					<td><input type="radio" name="atividadesInformativas" value="5" <?php echo printRadio(GetPost('atividadesInformativas'), '5'); ?>></td>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Atividades criativas</td>
				 					<td><input type="radio" name="atividadesCriativas" value="0" <?php echo printRadio(GetPost('atividadesCriativas'), '0'); ?>></td>
				 					<td><input type="radio" name="atividadesCriativas" value="1" <?php echo printRadio(GetPost('atividadesCriativas'), '1'); ?>></td>
				 					<td><input type="radio" name="atividadesCriativas" value="2" <?php echo printRadio(GetPost('atividadesCriativas'), '2'); ?>></td>
				 					<td><input type="radio" name="atividadesCriativas" value="3" <?php echo printRadio(GetPost('atividadesCriativas'), '3'); ?>></td>
				 					<td><input type="radio" name="atividadesCriativas" value="4" <?php echo printRadio(GetPost('atividadesCriativas'), '4'); ?>></td>
				 					<td><input type="radio" name="atividadesCriativas" value="5" <?php echo printRadio(GetPost('atividadesCriativas'), '5'); ?>></td>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Estimulo a interação</td>
				 					<td><input type="radio" name="estimuloInteracao" value="0" <?php echo printRadio(GetPost('estimuloInteracao'), '0'); ?>></td>
				 					<td><input type="radio" name="estimuloInteracao" value="1" <?php echo printRadio(GetPost('estimuloInteracao'), '1'); ?>></td>
				 					<td><input type="radio" name="estimuloInteracao" value="2" <?php echo printRadio(GetPost('estimuloInteracao'), '2'); ?>></td>
				 					<td><input type="radio" name="estimuloInteracao" value="3" <?php echo printRadio(GetPost('estimuloInteracao'), '3'); ?>></td>
				 					<td><input type="radio" name="estimuloInteracao" value="4" <?php echo printRadio(GetPost('estimuloInteracao'), '4'); ?>></td>
				 					<td><input type="radio" name="estimuloInteracao" value="5" <?php echo printRadio(GetPost('estimuloInteracao'), '5'); ?>></td>
				 				</tr>

				 				<tr>
				 					<td style="width: 160px;">Intervalo para Lanche</td>
				 					<td><input type="radio" name="intervalo" value="0" <?php echo printRadio(GetPost('intervalo'), '0'); ?>></td>
				 					<td><input type="radio" name="intervalo" value="1" <?php echo printRadio(GetPost('intervalo'), '1'); ?>></td>
				 					<td><input type="radio" name="intervalo" value="2" <?php echo printRadio(GetPost('intervalo'), '2'); ?>></td>
				 					<td><input type="radio" name="intervalo" value="3" <?php echo printRadio(GetPost('intervalo'), '3'); ?>></td>
				 					<td><input type="radio" name="intervalo" value="4" <?php echo printRadio(GetPost('intervalo'), '4'); ?>></td>
				 					<td><input type="radio" name="intervalo" value="5" <?php echo printRadio(GetPost('intervalo'), '5'); ?>></td>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Realização do Processamento de Grupo</td>
				 					<td><input type="radio" name="procDeGrupo" value="0" <?php echo printRadio(GetPost('procDeGrupo'), '0'); ?>></td>
				 					<td><input type="radio" name="procDeGrupo" value="1" <?php echo printRadio(GetPost('procDeGrupo'), '1'); ?>></td>
				 					<td><input type="radio" name="procDeGrupo" value="2" <?php echo printRadio(GetPost('procDeGrupo'), '2'); ?>></td>
				 					<td><input type="radio" name="procDeGrupo" value="3" <?php echo printRadio(GetPost('procDeGrupo'), '3'); ?>></td>
				 					<td><input type="radio" name="procDeGrupo" value="4" <?php echo printRadio(GetPost('procDeGrupo'), '4'); ?>></td>
				 					<td><input type="radio" name="procDeGrupo" value="5" <?php echo printRadio(GetPost('procDeGrupo'), '5'); ?>></td>
				 				</tr>
				 			</table>
				 			<br><br>
				 			
				 			<label>Comentários</label><span class="red"> *</span>
				 			<p>sugestões: quem bom, que pena, que tal:</p>
				 			<textarea name="comentarios"><?php echo printPost(GetPost('comentarios'), 'campo'); ?></textarea>	
				 			<br><br><br>

				 			<label>Autoavaliação</label> <span class="red"> *</span>
				 			<p>Faça uma autoavaliação sobre sua participação na reunião</p>
				 			<table>
				 				<tr>
				 					<th></th>
				 					<th>Pessímo</th>
				 					<th>Fraco</th>
				 					<th>Médio</th>
				 					<th>Bom</th>
				 					<th>Excelente</th>
				 				</tr>
				 				<tr>
				 					<td style="width: 160px;">Pontualidade</td>
				 					<td><input type="radio" name="autoPontualidade" value="1" <?php echo printRadio(GetPost('autoPontualidade'), '1'); ?>> </td>
									<td><input type="radio" name="autoPontualidade" value="2" <?php echo printRadio(GetPost('autoPontualidade'), '2'); ?>> </td>
				 					<td><input type="radio" name="autoPontualidade" value="3" <?php echo printRadio(GetPost('autoPontualidade'), '3'); ?>> </td>
				 					<td><input type="radio" name="autoPontualidade" value="4" <?php echo printRadio(GetPost('autoPontualidade'), '4'); ?>> </td>
				 					<td><input type="radio" name="autoPontualidade" value="5" <?php echo printRadio(GetPost('autoPontualidade'), '5'); ?>> </td>
				 						 				
				 				</tr>
				 				<tr>
				 					<td>Disposição em participar das atividades</td>
				 					<td><input type="radio" name="disposicao" value="1" <?php echo printRadio(GetPost('disposicao'), '1'); ?>> </td>
									<td><input type="radio" name="disposicao" value="2" <?php echo printRadio(GetPost('disposicao'), '2'); ?>> </td>
				 					<td><input type="radio" name="disposicao" value="3" <?php echo printRadio(GetPost('disposicao'), '3'); ?>> </td>
				 					<td><input type="radio" name="disposicao" value="4" <?php echo printRadio(GetPost('disposicao'), '4'); ?>> </td>
				 					<td><input type="radio" name="disposicao" value="5" <?php echo printRadio(GetPost('disposicao'), '5'); ?>> </td>
				 						 				
				 				</tr>
				 				<tr>
				 					<td>Envolvimento nas atividades</td>
				 					<td><input type="radio" name="envolvimento" value="1" <?php echo printRadio(GetPost('envolvimento'), '1'); ?>> </td>
									<td><input type="radio" name="envolvimento" value="2" <?php echo printRadio(GetPost('envolvimento'), '2'); ?>> </td>
				 					<td><input type="radio" name="envolvimento" value="3" <?php echo printRadio(GetPost('envolvimento'), '3'); ?>> </td>
				 					<td><input type="radio" name="envolvimento" value="4" <?php echo printRadio(GetPost('envolvimento'), '4'); ?>> </td>
				 					<td><input type="radio" name="envolvimento" value="5" <?php echo printRadio(GetPost('envolvimento'), '5'); ?>> </td>
				 						 				
				 				</tr>
				 				<tr>
				 					<td>Interação com os colegas</td>
				 					<td><input type="radio" name="interacao" value="1" <?php echo printRadio(GetPost('interacao'), '1'); ?>> </td>
									<td><input type="radio" name="interacao" value="2" <?php echo printRadio(GetPost('interacao'), '2'); ?>> </td>
				 					<td><input type="radio" name="interacao" value="3" <?php echo printRadio(GetPost('interacao'), '3'); ?>> </td>
				 					<td><input type="radio" name="interacao" value="4" <?php echo printRadio(GetPost('interacao'), '4'); ?>> </td>
				 					<td><input type="radio" name="interacao" value="5" <?php echo printRadio(GetPost('interacao'), '5'); ?>> </td>
				 						 				
				 				</tr>
				 				<tr>
				 					<td>Nível de Protagonismo</td>
				 					<td><input type="radio" name="protagonismo" value="1" <?php echo printRadio(GetPost('protagonismo'), '1'); ?>> </td>
									<td><input type="radio" name="protagonismo" value="2" <?php echo printRadio(GetPost('protagonismo'), '2'); ?>> </td>
				 					<td><input type="radio" name="protagonismo" value="3" <?php echo printRadio(GetPost('protagonismo'), '3'); ?>> </td>
				 					<td><input type="radio" name="protagonismo" value="4" <?php echo printRadio(GetPost('protagonismo'), '4'); ?>> </td>
				 					<td><input type="radio" name="protagonismo" value="5" <?php echo printRadio(GetPost('protagonismo'), '5'); ?>> </td>
				 						 				
				 				</tr>
				 				<tr>
				 					<td>Uso das Habilidades Sociais</td>
				 					<td><input type="radio" name="habilidades" value="1" <?php echo printRadio(GetPost('habilidades'), '1'); ?>> </td>
									<td><input type="radio" name="habilidades" value="2" <?php echo printRadio(GetPost('habilidades'), '2'); ?>> </td>
				 					<td><input type="radio" name="habilidades" value="3" <?php echo printRadio(GetPost('habilidades'), '3'); ?>> </td>
				 					<td><input type="radio" name="habilidades" value="4" <?php echo printRadio(GetPost('habilidades'), '4'); ?>> </td>
				 					<td><input type="radio" name="habilidades" value="5" <?php echo printRadio(GetPost('habilidades'), '5'); ?>> </td>
				 						 				
				 				</tr>
				 				<tr>
				 					<td>Satisfação</td>
				 					<td><input type="radio" name="satisfacao" value="1" <?php echo printRadio(GetPost('satisfacao'), '1'); ?>> </td>
									<td><input type="radio" name="satisfacao" value="2" <?php echo printRadio(GetPost('satisfacao'), '2'); ?>> </td>
				 					<td><input type="radio" name="satisfacao" value="3" <?php echo printRadio(GetPost('satisfacao'), '3'); ?>> </td>
				 					<td><input type="radio" name="satisfacao" value="4" <?php echo printRadio(GetPost('satisfacao'), '4'); ?>> </td>
				 					<td><input type="radio" name="satisfacao" value="5" <?php echo printRadio(GetPost('satisfacao'), '5'); ?>> </td>
				 						 				
				 				</tr>
				 			</table>
				 			<br><br>
				 			<center>
				 				<input type="submit" name="enviar" value="Enviar">
				 			</center>
				 		</form>
				 	</div>

				 	<?php
				}else if (isset($url[3]) && $url[3] != '') {
					if ($evento['regiaoSlug'] != 'fortaleza') {
						//Get presença pras demais regiões
						if (isset($_POST['enviar'])) {
							$npacces = GetPost('npacce');
							$msg = 0;
							for ($i=0; $i < count($npacces); $i++) { 
								$form['codigo'] 	= $evento['codigo'];
								$form['npacce'] 	= $npacces[$i];
								$form['evento'] 	= $evento['evento'];
								$form['eventoSlug'] = $evento['eventoSlug'];
								$form['data']		= $evento['data'];
								$form['status']		= 1;
								$form['registro']	= date('Y-m-d H:i:s');
								$form['entrada'] 	= $evento['inicio'];
								$form['saida']  	= $evento['fim'];
								$form['presenca']	= 1;

								if (DBread('eventos_pres', "WHERE npacce = '".$npacces[$i]."' AND codigo = '".$evento['codigo']."'")) {
									if (DBUpDate('eventos_pres', $form, "npacce = '".$npacces[$i]."' AND codigo = '".$evento['codigo']."'")) {
										$msg++;
									}
								}else{
									if (DBcreate('eventos_pres', $form)) {
										$msg++;
									}
								}
								if ($msg == count($npacces)) {
									echo '
										<script> 
											alert("Presenças registradas com sucesso!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";
										</script>
									';
								}
							}
						}
						$us = DBread('bolsistas', "WHERE campusSlug = '".$evento['regiaoSlug']."' ORDER BY nome ASC");
						?>
						<div class="title"><h2>Presença <strong></strong></h2></div>
						<div class="center form">
							<form method="post">
								<label>Lista de presença</label><span style="color: red;"> *</span>
								<p>Marque quem esteve presente</p>
								<br><br>
								<?php 
									for ($i=0; $i < count($us); $i++) { 
									
								?>
								<input type="checkbox" name="npacce[]" value="<?php echo $us[$i]['npacce']; ?>"> <?php echo $us[$i]['npacce'].' - '.$us[$i]['nome']; ?> <br><br>
								<?php } echo '('.count($us).')'; ?>
								<br><br>
								<center>
									<input type="submit" name="enviar" value="Enviar">
								</center>
							</form>
						</div>
						<?php

					}else{
						//Get presença para fortaleza
					$modo = DBescape($url[3]);
					if (isset($_GET['npacce'])) {
						$npacce 	= DBescape($_GET['npacce']);
						$bolsista 	= DBread('bolsistas', "WHERE npacce = '".$npacce."'");
						if ($bolsista == false) {
							echo '
								<script> 
									alert("Bolsista não encontrado");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
								</script>
							';
						}else{
							
							$form['codigo'] 	= $evento['codigo'];
							$form['npacce'] 	= $npacce;
							$form['evento'] 	= $evento['evento'];
							$form['eventoSlug'] = $evento['eventoSlug'];
							$form['data']		= $evento['data'];
							$form['status']		= 1;
							$form['registro']	= date('Y-m-d H:i:s');
							$form['npacceRegistro']= $user['npacce'];
							if ($modo == 'entrada') {
								$form['entrada']  	= date('H:i:s');
								$form['presenca']	= 2;
							}else if ($modo == 'saida') {
								$form['saida'] 	= date('H:i:s');
								$form['presenca']	= 1;
							}
							
							$check = DBread('eventos_pres', "WHERE npacce = '".$npacce."' AND codigo = '".$evento['codigo']."'");
							if ($check == false) {
								if (DBcreate('eventos_pres', $form)) {
									echo '
										<script> 
											alert("Presença registrada com sucesso!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";
										</script>
									';
								}
							}else{
								if (DBUpDate('eventos_pres', $form, "codigo = '".$evento['codigo']."' AND npacce = '".$npacce."'")) {
									echo '
										<script> 
											alert("Presença registrada com sucesso!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";
										</script>
									';
								}
							}
						}
					
					}
				?>
				<script type="text/javascript">
					$(function(){
						$('#enviar').click(function(e) {
							e.preventDefault();
						});
						$('#pesquisar').keyup(function(){
							var pesquisa = $(this).val();
							if (pesquisa != '') {
								var dados = {palavra : pesquisa}

								$.post("../../../ajax/busca-eventos-coletivos.php", dados, function(retorna){
									$('.result').empty().html(retorna);
								});
							}
				  		});
					});
				</script>
				<div class="title"><h2>Presença de <strong><?php if($modo == 'entrada'){ echo 'Entrada';}else{ echo 'Saída';} ?></strong> </h2></div>
					<div id="pesquisa">
						<form action="" method="post">
							<input type="text" value="" id="pesquisar" autocomplete="off" onkeyup="maiuscula(this)"  placeholder="Nome, matricula ou npacce"></input>
							<input type="submit" name="enviar" id="enviar" value="Pesquisar">
						</form>
					</div>
					<div id="clear"></div>
					<div class="result">
					</div>
				<?php
					}//fechar get presença de diferentes regiões					
				}else{

			?>
			<div class="title"><h2>Opções</h2></div>
				<?php 
				$check = DBread('eventos_pres', "WHERE npacce = '".$user['npacce']."' AND presenca = true AND codigo = '".$evento['codigo']."'");
				
				if ($check == true) {
					?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/avaliar-reuniao'; ?>" class="botao">Avaliar Reunião</a>
					<?php
				}
		 
				if ($user['tipoSlug'] == 'ceo') {
					if ($evento['status'] == 0) {
						echo '<a href="?action=1&&cod='.$evento['codigo'].'" class="botao">Ativar</a>';
					}else{
						echo '<a href="?action=2&&cod='.$evento['codigo'].'" class="botao">Desativar</a>';
					}
				?>
				
				<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'?gerar-faltas' ?>" class="botao">Gerar faltas</a>
				<?php 
					if ($evento['presenca'] == 1) {
						echo '<a href="?action=3&&cod='.$evento['codigo'].'" class="botao">Desativar Sistema de Presença</a>';
					}else{
						echo '<a href="?action=4&&cod='.$evento['codigo'].'" class="botao">Ativar Sistema de Presença</a>';
					}
				?>
				
			<?php }
				$permissao = DBread('ev_permissao', "WHERE npacce = '".$user['npacce']."'");

				if ($evento['presenca'] == 1 && $user['tipoSlug'] == 'apoio-interno' || $evento['presenca'] == 1 && $user['tipoSlug'] == 'ceo' || $evento['presenca'] == 1 && $user['tipoSlug'] == 'apoio-tecnico'
					// || $evento['presenca'] == 1 && $permissao == true || $evento['presenca'] == 1 && $user['tipoSlug'] == 'formacao' || $evento['presenca'] == 1 && $user['tipoSlug'] == 'apoio-a-celula' || $evento['presenca'] == 1 && $user['tipoSlug'] == 'avaliacao' || $evento['presenca'] == 1 && $user['tipoSlug'] == 'comunicacao' || $evento['presenca'] == 1 && $user['tipoSlug'] == 'interacao'
				) {
			?>
				<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/entrada'; ?>" class="botao">Presença de Entrada</a>
				<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/saida'; ?>" class="botao">Presença de Saída</a>
			<?php
				}

				$registros = DBread('eventos_pres', "WHERE codigo = '".$evento['codigo']."'");
			?>
			<br><br><br>
			<div class="title"><h2>Presenças Registradas</h2></div>
			<?php 
				if ($registros == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{
			?>

			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th>NPACCE</th>
						<th>Nome</th>
						<th>Curso</th>
						<th>Entrada</th>
						<th>Saída</th>
						<th>Situação</th>
					</tr>
					<?php 
						for ($i=0; $i < count($registros); $i++) { 
						$bol = DBread('bolsistas', "WHERE npacce =  '".$registros[$i]['npacce']."'");
						$bol = $bol[0];
					?>
					<tr>
						<td><?php echo $registros[$i]['npacce']; ?></td>
						<td><?php echo $bol['nome']; ?></td>
						<td title="<?php echo $bol['curso']; ?>"><?php echo texto($bol['curso'], 20); ?></td>
						<td><?php echo date('H:i', strtotime($registros[$i]['entrada'])); ?></td>
						<td><?php echo date('H:i', strtotime($registros[$i]['saida'])); ?></td>
						<td><?php if($registros[$i]['presenca'] == 0){ echo 'Não esteve presente';}else if($registros[$i]['presenca'] == 1){ echo 'Esteve presente';}else if($registros[$i]['presenca'] == 2){ echo 'Saída não registrada';}else if($registros[$i]['presenca'] == 3){ echo 'Reposição aprovada';}else if($registros[$i]['presenca'] == 4){ echo 'Reposição em análise';}else{ echo 'Reposição reprovada';} ?></td>
					</tr>
					<?php } ?>
				</table>
				(<?php echo count($registros); ?>)
			</div>
		<?php
				}
			}
		}
	}else{
		if($user['tipoSlug'] == 'ceo'){
				?>
				<div class="title"><h2>Opções</h2></div>
				<a href="<?php echo $way.'/'.$url[1].'/cadastrar-evento'; ?>" class="botao">Cadastrar Evento</a>
				<br><br>
				<?php
			}
	?>
		<div class="title"><h2>Eventos Coletivos</h2></div>
		<div class="caixa">
	<?php
		$eventos = DBread('eventos', "WHERE status = true ORDER BY data ASC");
		if ($eventos == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div><br><br>';
		}else{
?>

	

	<ul>
	<?php
		for ($i=0; $i < count($eventos); $i++) { 
	?>
		<a href="<?php echo $way.'/'.$url[1].'/'.$eventos[$i]['codigo']; ?>">
			<li style="background-color: <?php echo $eventos[$i]['cor']; ?>">
				<div>
					<div id="box-all-info">
						<div id="all-info">
							<h3><?php echo $eventos[$i]['evento']; ?></h3><br>
							<span><?php echo texto($eventos[$i]['local'], 28); ?></span><br><br>
							<span><?php echo date('d/m/y', strtotime($eventos[$i]['data'])); ?>
							  <br>
							  <?php echo date('H:i', strtotime($eventos[$i]['inicio'])).'hr'; ?> - 
							  <?php echo date('H:i', strtotime($eventos[$i]['fim'])).'hr'; ?> <br> 
							  <?php echo $week[date('D', strtotime($eventos[$i]['data']))]; ?> </span><br><br>
							<span>Hermany Rosa Vieira </span><br>
							<span>Todos os membros do PACCE</span>
						</div>
					</div>
					<div id="tipo">
						Evento Coletivo
					</div>
				</div>
			</li>
		</a>
	<?php 
		}
	?>
	</ul>
</div><br>
<div id="cont">(<?php echo count($eventos) ?>)</div><br>
<?php }//FECHA EXIBIR EVENTOS 
?>

	<div class="title"><h2>Histórico de Presenças</h2></div>
	<?php 
		$atColetiva = DBread('eventos_pres', "WHERE npacce = '".$user['npacce']."'");
		if ($atColetiva == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
	?>
	<div class="tabela">
		<table>
			<tr>
				<th>Evento</th>
				<th>Data</th>
				<th>Entrada</th>
				<th>Saída</th>
				<th>Situação</th>
			</tr>
			<?php 
				for ($i=0; $i < count($atColetiva); $i++) { 
			?>
			<tr>
				<td><?php echo $atColetiva[$i]['evento']; ?></td>
				<td><?php echo date('d/m/y', strtotime($atColetiva[$i]['data'])); ?></td>
				<td><?php echo date('H:i', strtotime($atColetiva[$i]['entrada'])); ?></td>
				<td><?php echo date('H:i', strtotime($atColetiva[$i]['saida'])); ?></td>
				<td><?php if($atColetiva[$i]['presenca'] == 0){ echo 'Não esteve presente, efetue sua reposição!';}else if($atColetiva[$i]['presenca'] == 1){ echo 'Esteve presente!';}else if($atColetiva[$i]['presenca'] == 2){ echo 'Saída não registrada!';}else if($atColetiva[$i]['presenca'] == 3){ echo 'Reposição aprovada!';}else if($atColetiva[$i]['presenca'] == 4){ echo 'Reposição em análise!';}else{ echo 'Reposição reprovada, por favor faça novamente!';} ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php } ?>
<br>
<div class="title"><h2>Histórico de Avaliações</h2></div>
<?php 
	$av = DBread('eventos_avaliar', "WHERE npacce = '".$user['npacce']."'");
	if ($av == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
?>
	<div class="tabela">
		<table>
			<tr>
				<th>Código</th>
				<th>Evento</th>
				<th>Registro</th>
			</tr>
			<?php 
				for ($i=0; $i < count($av); $i++) { 
			?>
			<tr>
				<td><?php echo $av[$i]['codigo']; ?> </td>
				<td><?php echo $av[$i]['evento']; ?></td>
				<td><?php echo date('d/m/y H:i', strtotime($av[$i]['registro'])); ?></td>
			</tr>
			<?php 
				}
			?>
		</table>
	</div>
<?php 
	} 
}   
?>