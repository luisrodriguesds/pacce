
<script>
	function ativar(){
		if (confirm("Você tem certeza que desaja ativar esse bolsista?")){
			window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'?status=1'; ?>";
		}
	}
	function desativar(){
		if (confirm("Você tem certeza que deseja desativar esse bolsista?")){
			window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'?status=0'; ?>";
		}
	}	
</script>
<?php 

	//RELATÓRIO INDIVIDUAL
	if (isset($url[3]) && $url[3] !='') {
		echo include 'paginas/relatorio-individual.php';
	}else{
	$comissoes = DBread('comissoes', "WHERE status = true");
	$bolsista = DBread('bolsistas', "WHERE cpf = '".$url[2]."'");
	if ($bolsista == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
		//STATUS DO BOLSISTA
		if (isset($_GET['status']) && $_GET['status'] != '') {
			$up['status'] = DBescape($_GET['status']);
			if ($up['status'] == 1) {
				//$up['registroSaida'] = '';
				if (DBUpDate('bolsistas', $up, "cpf = '".$url[2]."'")) {
					echo '
       			<script>
       			    if(confirm("Status Alterado co sucesso!")){
     			      window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
   				     }
   				</script>';
				}
			}else if ($up['status'] == 0) {
				$up['registroSaida'] = date('Y-m-d H:i:s');
				if ($bolsista[0]['tipoSlug'] == 'articulador-de-celula') {
					//Busca de Atividades
					$apo_insc = DBread('apo_insc', "WHERE status = true AND npacce = '".$bolsista[0]['npacce']."'");
					$for_insc = DBread('for_insc', "WHERE status = true AND npacce = '".$bolsista[0]['npacce']."'");
					$rod_insc = DBread('rod_insc', "WHERE status = true AND npacce = '".$bolsista[0]['npacce']."'");
					$projeto  = DBread('projetos', "WHERE npacce = '".$bolsista[0]['npacce']."'", "id");
					$celula   = DBread('horario_celula', "WHERE npacce = '".$bolsista[0]['npacce']."'", "id");
					$link 	  = DBread('link_av', "WHERE npacce = '".$bolsista[0]['npacce']."'");
					
					//Cancelar inscrição em Apoio
					if ($apo_insc == false) {
					 }else{
					 	$apo_sala = DBread('apo_salas', "WHERE sala = '".$apo_insc[0]['sala']."'");
					 	if ($apo_sala == false) {
					 	}else{
					 		$vaga['vagaAtual'] = $apo_sala[0]['vagaAtual'] + 1;
					 		if (DBUpDate('apo_salas', $vaga," sala = '".$apo_sala[0]['sala']."'")) {
					 			DBDelete('apo_insc', "npacce = '".$bolsista[0]['npacce']."' AND sala = '".$apo_insc[0]['sala']."'");
					 		}
					 	}
					 }

					 //Cancelar inscrição em Formação
					 if ($for_insc == false) {
					 }else{
					 	$for_sala = DBread('for_salas', "WHERE sala = '".$for_insc[0]['sala']."'");
					 	if ($for_sala == false) {
					 	}else{
					 		$vaga['vagaAtual'] = $for_sala[0]['vagaAtual'] + 1;
					 		if (DBUpDate('for_salas', $vaga," sala = '".$for_sala[0]['sala']."'")) {
					 			DBDelete('for_insc', "npacce = '".$bolsista[0]['npacce']."' AND sala = '".$for_insc[0]['sala']."'");
					 		}
					 	}
					 }

					 //Cancelar inscrição em História de vida
					 if ($rod_insc == false) {
					 }else{
					 	$rod_sala = DBread('rod_salas', "WHERE sala = '".$rod_insc[0]['sala']."'");
					 	if ($rod_sala == false) {
					 	}else{
					 		$vaga['vagaAtual'] = $rod_sala[0]['vagaAtual'] + 1;
					 		if (DBUpDate('rod_salas', $vaga," sala = '".$rod_sala[0]['sala']."'")) {
					 			DBDelete('rod_insc', "npacce = '".$bolsista[0]['npacce']."' AND sala = '".$rod_insc[0]['sala']."'");
					 		}
					 	}
					 }

					 //Desativar Projeto
					 if ($projeto == true) {
					 	$upi['status'] = 0;
					 	DBUpDate('projetos', $upi, "npacce = '".$bolsista[0]['npacce']."'");
					 }
					 //Desativar Célula
					 if ($celula == true) {
					 	$upi['status'] = 0;
					 	DBUpDate('horario_celula', $upi, "npacce = '".$bolsista[0]['npacce']."'");
					 }
					 //Desativar da avaliação 
					 if ($link == true) {
					 	DBDelete('link_av', "npacce = '".$bolsista[0]['npacce']."'");
					 }

					 //Cofirmar
					if (DBUpDate('bolsistas', $up, "cpf = '".$url[2]."'")) {
						echo '
	       			<script>
	       			    if(confirm("Status Alterado co sucesso!")){
	     			      window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
	   				     }
	   				</script>';
					}
				}else{
					if (DBUpDate('bolsistas', $up, "cpf = '".$url[2]."'")) {
						echo '
	       			<script>
	       			    if(confirm("Status Alterado co sucesso!")){
	     			      window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
	   				     }
	   				</script>';
					}
				}
			}
		}

		//SALVAR ALTERAÇÕES 
		if (isset($_POST['salvar'])) {
			$form['nome'] 		= GetPost('nome');
			$form['npacce'] 	= strtoupper(GetPost('npacce'));
			$form['tipo'] 		= GetPost('comissao');
			$form['tipoSlug'] 	= Slug(GetPost('comissao'));
			$form['matricula'] 	= GetPost('matricula');
			$form['cpf']		= GetPost('cpf');
			$form['rg']			= GetPost('rg');
			$form['curso']		= GetPost('curso');
			$form['sexo']		= GetPost('sexo');
			//$form['email']		= GetPost('email');
			

			if ($bolsista[0]['tipoSlug'] == 'articulador-de-celula') {
				$apo['sala'] = GetPost('apo');
				$for['sala'] = GetPost('for');
				$rod['sala'] = GetPost('rod');

				$verifyApo = DBread('apo_insc', "WHERE npacce = '".$bolsista[0]['npacce']."' AND status = true", "id, npacce, sala");
				$verifyFor = DBread('for_insc', "WHERE npacce = '".$bolsista[0]['npacce']."' AND status = true", "id, npacce, sala");
				$verifyRod = DBread('rod_insc', "WHERE npacce = '".$bolsista[0]['npacce']."' AND status = true", "id, npacce, sala");
				
				//PARA O APOIO
				if ($apo['sala'] != 1) {
					//Caso não esteja matriculado
					if ($verifyApo == false) {			
						$apo['npacce'] 			= $bolsista[0]['npacce'];
						$apo['nomeCompleto'] 	= $bolsista[0]['nome'];
						$apo['nomeUsual'] 		= GetName($bolsista[0]['nome'], $bolsista[0]['nomeUsual']);
						$apo['status'] 			= 1;
						$apo['registro']		= date('Y-m-d H:i:s');
						$apo['ano'] 			= date('Y');
					
						if (DBcreate('apo_insc', $apo)) {
							$vagaApo = DBread('apo_salas', "WHERE sala = '".$apo['sala']."'", "id, vagaAtual");
							$up['vagaAtual'] = $vagaApo[0]['vagaAtual'] - 1;
							DBUpDate('apo_salas', $up, "sala = '".$apo['sala']."'"); 
						}
					}else{
						//caso esteja matriculado em uma sala e deseja fazer a troca
						if ($verifyApo[0]['sala'] != $apo['sala']) {
							if (DBDelete('apo_insc', "npacce = '".$bolsista[0]['npacce']."' AND sala = '".$verifyApo[0]['sala']."' ")) {
								//atulalizar as vagas
								$vagaApo = DBread('apo_salas', "WHERE sala = '".$verifyApo[0]['sala']."'", "id, vagaAtual");
								$up['vagaAtual'] = $vagaApo[0]['vagaAtual'] + 1;

								if (DBUpDate('apo_salas', $up,"sala = '".$verifyApo[0]['sala']."'")) {
									$apo['npacce'] 			= $bolsista[0]['npacce'];
									$apo['nomeCompleto'] 	= $bolsista[0]['nome'];
									$apo['nomeUsual'] 		= GetName($bolsista[0]['nome'], $bolsista[0]['nomeUsual']);
									$apo['status'] 			= 1;
									$apo['registro']		= date('Y-m-d H:i:s');
									$apo['ano'] 			= date('Y');
									
									if (DBcreate('apo_insc', $apo)) {
										$vagaApo = DBread('apo_salas', "WHERE sala = '".$apo['sala']."'", "id, vagaAtual");
										$up['vagaAtual'] = $vagaApo[0]['vagaAtual'] - 1;
										DBUpDate('apo_salas', $up, "sala = '".$apo['sala']."'"); 
									}
								}
							}
						}
					}
				}

				//PARA A FORMAÇÃO
				if ($for['sala'] != 1) {
					//Caso não esteja matriculado
					if ($verifyFor == false) {			
						$for['npacce'] 			= $bolsista[0]['npacce'];
						$for['nomeCompleto'] 	= $bolsista[0]['nome'];
						$for['nomeUsual'] 		= GetName($bolsista[0]['nome'], $bolsista[0]['nomeUsual']);
						$for['status'] 			= 1;
						$for['registro']		= date('Y-m-d H:i:s');
						$for['ano'] 			= date('Y');
					
						if (DBcreate('for_insc', $for)) {
							$vagaFor = DBread('for_salas', "WHERE sala = '".$for['sala']."'", "id, vagaAtual");
							$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] - 1;
							DBUpDate('for_salas', $up, "sala = '".$for['sala']."'"); 
						}
					}else{
						//caso esteja matriculado em uma sala e deseja fazer a troca
						if ($verifyFor[0]['sala'] != $for['sala']) {
							if (DBDelete('for_insc', "npacce = '".$bolsista[0]['npacce']."' AND sala = '".$verifyFor[0]['sala']."' ")) {
								//atulalizar as vagas
								$vagaFor = DBread('for_salas', "WHERE sala = '".$verifyFor[0]['sala']."'", "id, vagaAtual");
								$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] + 1;

								if (DBUpDate('for_salas', $up,"sala = '".$verifyFor[0]['sala']."'")) {
									$for['npacce'] 			= $bolsista[0]['npacce'];
									$for['nomeCompleto'] 	= $bolsista[0]['nome'];
									$for['nomeUsual'] 		= GetName($bolsista[0]['nome'], $bolsista[0]['nomeUsual']);
									$for['status'] 			= 1;
									$for['registro']		= date('Y-m-d H:i:s');
									$for['ano'] 			= date('Y');
									
									if (DBcreate('for_insc', $for)) {
										$vagaFor = DBread('for_salas', "WHERE sala = '".$for['sala']."'", "id, vagaAtual");
										$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] - 1;
										DBUpDate('for_salas', $up, "sala = '".$for['sala']."'"); 
									}
								}
							}
						}
					}
				}

				//PARA A RODA VIVA
				if ($rod['sala'] != 1) {
					//Caso não esteja matriculado
					if ($verifyRod == false) {			
						$rod['npacce'] 			= $bolsista[0]['npacce'];
						$rod['nomeCompleto'] 	= $bolsista[0]['nome'];
						$rod['nomeUsual'] 		= GetName($bolsista[0]['nome'], $bolsista[0]['nomeUsual']);
						$rod['status'] 			= 1;
						$rod['registro']		= date('Y-m-d H:i:s');
						$rod['ano'] 			= date('Y');
					
						if (DBcreate('rod_insc', $rod)) {
							$vagaFor = DBread('rod_salas', "WHERE sala = '".$rod['sala']."'", "id, vagaAtual");
							$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] - 1;
							DBUpDate('rod_salas', $up, "sala = '".$rod['sala']."'"); 
						}
					}else{
						//caso esteja matriculado em uma sala e deseja fazer a troca
						if ($verifyRod[0]['sala'] != $rod['sala']) {
							if (DBDelete('rod_insc', "npacce = '".$bolsista[0]['npacce']."' AND sala = '".$verifyRod[0]['sala']."' ")) {
								//atulalizar as vagas
								$vagaFor = DBread('rod_salas', "WHERE sala = '".$verifyRod[0]['sala']."'", "id, vagaAtual");
								$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] + 1;

								if (DBUpDate('rod_salas', $up,"sala = '".$verifyRod[0]['sala']."'")) {
									$rod['npacce'] 			= $bolsista[0]['npacce'];
									$rod['nomeCompleto'] 	= $bolsista[0]['nome'];
									$rod['nomeUsual'] 		= GetName($bolsista[0]['nome'], $bolsista[0]['nomeUsual']);
									$rod['status'] 			= 1;
									$rod['registro']		= date('Y-m-d H:i:s');
									$rod['ano'] 			= date('Y');
									
									if (DBcreate('rod_insc', $rod)) {
										$vagaFor = DBread('rod_salas', "WHERE sala = '".$rod['sala']."'", "id, vagaAtual");
										$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] - 1;
										DBUpDate('rod_salas', $up, "sala = '".$rod['sala']."'"); 
									}
								}
							}
						}
					}
				}

			}	
		
		$form = DBescape($form);
		if (DBUpDate('bolsistas', $form, "cpf = '".$url[2]."'")) {
				echo '
       			<script>
       			    if(confirm("Dados Alterados com sucesso!!!")){
     			      window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
   				     }
   				</script>';
			}
		}
		
		if(isset($_GET['action']) && $_GET['action'] != '' && isset($_GET['npacce']) && $_GET['npacce']){
			$npacce = DBescape(strip_tags(trim($_GET['npacce'])));
			switch ($_GET['action']) {
				case 1:
					$up['cadastro'] = 1;
					if (DBUpDate('bolsistas', $up, "npacce = '$npacce'")) {
						echo '
         				<script>
       					    if(confirm("Esse Usuário já pode efetuar seu cadastro em nosso sistema!")){
      				       window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
   					       }
   					     </script>';
					}
				break;
				case 2:
					$up['cadastro'] = 0;
					if (DBUpDate('bolsistas', $up, "npacce = '$npacce'")) {
						echo '
         				<script>
       					    if(confirm("Esse Usuário está bloqueado para efetar seu cadastro em nosso sistema!")){
      				       window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
   					       }
   					     </script>';
					}
				break;
			
			}
		}
?> 
	<div id="edita-bol" class="">
	<form action="" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<th>Nome Completo:</th>
				<td>
				<input type="text" name="nome" onkeyup="maiuscula(this)" value="<?php echo $bolsista[0]['nome']; ?>"></input>
				</td>
				<th class="espaco">Curso:</th>
				<td>
				<?php $cursos = DBread('cursos_ufc', "WHERE status = true"); ?>
				<select name="curso">
				<?php 
					for ($i=0; $i < count($cursos); $i++) { 
				?>
					<option value="<?php echo nomeM($cursos[$i]['curso']); ?>" <?php if($bolsista[0]['curso'] == nomeM($cursos[$i]['curso'])){ echo 'selected=""';} ?>><?php echo nomeM($cursos[$i]['curso']); ?></option>
				<?php
					}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<th>CPF:</th>
				<td><input type="text" name="cpf" value="<?php echo $bolsista[0]['cpf']; ?>"></input></td>
				
				<th class="espaco">Matrícula:</th>
				<td><input type="text" name="matricula" value="<?php echo $bolsista[0]['matricula']; ?>"></input></td>
				
			</tr>
			<tr>
				<th>RG:</th>
				<td><input type="text" name="rg" value="<?php echo $bolsista[0]['rg']; ?>"></input></td>
				<th>Sexo:</th>
				<td><select name="sexo">
					<option>Escolha um sexo...</option>
					<option value="1" <?php if($bolsista[0]['sexo'] == 1){ echo 'selected';} ?>>Masculino</option>
					<option value="0" <?php if($bolsista[0]['sexo'] == 0){ echo 'selected';} ?>>Feminino</option>
				</select></td>

			</tr>
			<tr>
				<th>Número PACCE:</th>
				<td><?php if ($bolsista[0]['npacce'] == '') {
					echo '<input type="text" name="npacce" placeholder="Digite o número PACCE desse bolsista"></input>';
				}else{
					echo '<input type="text" name="npacce" value="'.$bolsista[0]['npacce'].'" placeholder="Digite o número PACCE desse bolsista"></input>';
					} ?></td>
				<th class="espaco">Função:</th>
				<td>
					<?php 
						
					?>

					<select name="comissao">
						<option selected="" value=""> Escolha uma comissão para esse bolsista...</option>
						<?php 
							for ($i=0; $i < count($comissoes); $i++) { 
								
								?> 
								<option <?php if($bolsista[0]['tipoSlug'] == $comissoes[$i]['comissaoSlug']){
									echo 'selected=""';
									} ?> value="<?php echo $comissoes[$i]['comissao']; ?>"><?php echo $comissoes[$i]['comissao']; ?></option>
								<?php
							}
						?>
					</select>

					<?php
						/*
							if ($bolsista[0]['tipoSlug'] == '') {
								echo 'Bolsista sem comissão';
							}else{
								echo $bolsista[0]['tipoSlug'];
							}
						*/
						
					?>
					</td>
			</tr>
			<?php 
				if ($bolsista[0]['npacce'] != '' && $bolsista[0]['tipoSlug'] != '') {
			?>
			<?php 
				if ($bolsista[0]['tipoSlug'] == 'articulador-de-celula') {
			?>
			<tr>
				<?php 
					$apo 	= DBread('apo_salas', "WHERE status = true ORDER BY sala ASC");
					$apoIns = DBread('apo_insc', "WHERE status = true AND npacce = '".$bolsista[0]['npacce']."'", "id, sala, npacce");
				?>
				<th>Apoio à Célula:</th>
				<td>
				
				<select name="apo">
					<?php 
						if ($apo == false) {
							echo '<option value="">Nada encontrado...</option>';
						}else{
							//CASO NÃO ESTEJA INSCRITO EM NADA
							if ($apoIns == false) {
								echo '<option value="1">Escolha um sala...</option>';
								
								for ($i=0; $i < count($apo); $i++) { 
									if ($apo[$i]['vagaAtual'] == 0 || $apo[$i]['status'] == 0) {
										$disabled = 'disabled';
									}else{
										$disabled = '';
									}
									echo '<option value="'.$apo[$i]['sala'].'" '.$disabled.' >'.$apo[$i]['sala'].'</option>';
								}
							}else{
								//CASO ESTEJA INSCRITO EM ALGUMA COISA
								echo '<option value="1">Escolha um sala...</option>';
								$selected = '';
								$disabled = '';
								for ($i=0; $i < count($apo); $i++) { 
									if ($apo[$i]['sala'] == $apoIns[0]['sala']) {
										$selected = 'selected=""';
									}else{
										$selected = '';
									}

									if ($apo[$i]['vagaAtual'] == 0) {
										if ($apoIns[0]['sala'] == $apo[$i]['sala']) {
											$disabled = '';
										}else{
											$disabled = 'disabled';	
										}
									}else{
										$disabled = '';
									}
									echo '<option value="'.$apo[$i]['sala'].'" '.$selected.' '.$disabled.' >'.$apo[$i]['sala'].'</option>';
								}
							}
						}
					?>
				</select>

				</td>
				<th>Formação:</th>
				<td>
				<?php 
					$for 	= DBread('for_salas', "WHERE status = true ORDER BY sala ASC");
					$forIns = DBread('for_insc', "WHERE status = true AND npacce = '".$bolsista[0]['npacce']."'", "id, sala, npacce");
				?>
				<select name="for">
					<?php 
						if ($for == false) {
							echo '<option value="">Nenhuma sala encontrada...</option>';
						}else{
							if ($forIns == false) {
								echo '<option value="1">Escolha um sala...</option>';
								
								for ($i=0; $i < count($for); $i++) { 
									if ($for[$i]['vagaAtual'] == 0 || $for[$i]['status'] == 0) {
										$disabled = 'disabled';
									}else{
										$disabled = '';
									}
									echo '<option value="'.$for[$i]['sala'].'" '.$disabled.'>'.$for[$i]['sala'].'</option>';
								}
							}else{
								echo '<option value="1">Escolha um sala...</option>';
								$selected = '';
								for ($i=0; $i < count($for); $i++) { 
									if ($for[$i]['sala'] == $forIns[0]['sala']) {
										$selected = 'selected=""';
									}else{
										$selected = '';
									}
									if ($for[$i]['vagaAtual'] == 0) {
										if ($forIns[0]['sala'] == $for[$i]['sala']) {
											$disabled = '';
										}else{
											$disabled = 'disabled';	
										}
									}else{
										$disabled = '';
									}

									echo '<option value="'.$for[$i]['sala'].'" '.$selected.' '.$disabled.'>'.$for[$i]['sala'].'</option>';
								}
							}
						}
					?>
				</select>

				</td>
			</tr>
			<tr>
				<th>História de Vida:</th>
				<td>
				<?php 
					$rod 	= DBread('rod_salas', "WHERE status = true ORDER BY sala ASC");
					$rodIns = DBread('rod_insc', "WHERE status = true AND npacce = '".$bolsista[0]['npacce']."'", "id, sala, npacce");
				?>
				<select name="rod">
					<?php 
						if ($rod == false) {
							echo '<option value="">Nenhuma sala encontrada...</option>';
						}else{
							if ($rodIns == false) {
								echo '<option value="1">Escolha um sala...</option>';
								for ($i=0; $i < count($rod); $i++) { 
									if ($rod[$i]['vagaAtual'] == 0 || $rod[$i]['status'] == 0) {
										$disabled = 'disabled';
									}else{
										$disabled = '';
									}
									echo '<option value="'.$rod[$i]['sala'].'" '.$disabled.'>'.$rod[$i]['sala'].'</option>';
								}
							}else{
								echo '<option value="1">Escolha um sala...</option>';
								$selected = '';
								for ($i=0; $i < count($rod); $i++) { 
									if ($rod[$i]['sala'] == $rodIns[0]['sala']) {
										$selected = 'selected=""';
									}else{
										$selected = '';	
									}

									if ($rod[$i]['vagaAtual'] == 0) {
										if ($rodIns[0]['sala'] == $rod[$i]['sala']) {
											$disabled = '';
										}else{
											$disabled = 'disabled';	
										}
									}else{
										$disabled = '';
									}
									echo '<option value="'.$rod[$i]['sala'].'" '.$selected.' '.$disabled.'>'.$rod[$i]['sala'].'</option>';
								}
							}
						}
					?>
				</select>
				</td>
			</tr>
			<?php
				}
			?>
			<tr>
				<th>Email:</th>
				<td><input name="email" type="email" value="<?php echo $bolsista[0]['email']; ?>"></input></td>
			</tr>
			<tr>
				<th>Opções:</th>
				<td>
				<?php 
					if ($bolsista[0]['cadastro'] == 0) {
						echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=1&&npacce='.$bolsista[0]['npacce'].'">Permitir Cadastro</a>';
					}else{
						echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=2&&npacce='.$bolsista[0]['npacce'].'">Bloquear Cadastro</a>';
					}
				?>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><?php 
					echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'/'.$bolsista[0]['npacce'].'">Relatório Individual</a>';
				?></td>
			</tr>
			<tr>
				<th></th>
				<td>
				<?php
					if ($bolsista[0]['status'] == 1) {
						echo '<a onclick="desativar()" style="cursor:pointer;" >Desativar Bolsista</a>';
				
					}else{
						echo '<a onclick="ativar()" style="cursor:pointer;" >Ativar Bolsista</a>';	
					}
					?>
				</td>
			</tr>

			<?php
				}
			?>
			<tr>
				<th>Obs:</th>
				<td>
					<?php 
						if ($bolsista[0]['status'] == 0) {
							echo '<i>Inativo</i><br>';
						}else{
							echo '<i>Ativo</i><br>';
						}
						if ($bolsista[0]['situacao'] == 0) {
							if ($bolsista[0]['sexo'] == 1) {
								echo '<strong>Voluntário</strong>';
							}else{
								echo '<strong>Voluntária</strong>';
							}
						}else if ($bolsista[0]['situacao'] == 1) {
							if ($bolsista[0]['sexo'] == 1) {
								echo '<strong>Efetivo</strong>';
							}else{
								echo '<strong>Efetiva</strong>';
							}
						}else if ($bolsista[0]['situacao'] == 2) {
							echo '<strong>BIA</strong>';
						}else{
							echo '<strong>Outra bolsa</strong>';
						}
						if ($bolsista[0]['registroSaida'] != '' || $bolsista[0]['registroSaida'] != null ) {
							echo '<br> Saída em: '.date('d/m/y H:i:s', strtotime($bolsista[0]['registroSaida']));
						}
					?>

				</td>
				<td colspan="8" style="text-align: right;"><input type="submit" name="salvar" value="Salvar"></input></td>
			</tr>
		</table>
		</form>
	</div>
<?php
	}
} 
?>
