
<?php 
	$semanaProx = $semana + 1;
	$semanaAnt = $semana - 1;
	$ano 		= date('Y');
	//Validação de inscricao em interação
	if (isset($_GET['action']) && $_GET['action'] != '' && isset($_GET['ati']) && $_GET['ati'] != '') {
		//if($user['tipoSlug'] == 'articulador-de-celula'){
		
		$id = DBescape(trim(strip_tags($_GET['ati'])));
		//Caso não encontre inteacoes
		if ($extraCad == false) {
			echo ' <script>
				   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
				   </script>';
		}else{
			echo "Teste";
			//encontrou -  agora verifica se já está inscrito
			switch ($_GET['action']) {
				case 1:
					//Se já estiver inscrito - redireciona
					$verify 	= DBread('extra_insc', "WHERE npacce = '".$user['npacce']."' AND codigo = '$id'");
					if ($verify == true) {
						echo ' <script>
				   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
				   </script>';
					}else{
						//se nao, inseri no banco
							$conte = 0; 
							for ($i=0; $i < count($extraCad); $i++) { 
								if ($extraCad[$i]['codigo'] == $id) {
									$conte++;
									$inscricao['npacce'] 	= $user['npacce'];
									$inscricao['nome']	 	= GetName($user['nome'], $user['nomeUsual']);	
									$inscricao['nomeCompleto']= $user['nome'];
									$inscricao['codigo'] 	= $extraCad[$i]['codigo'];
									$inscricao['titulo'] 	= $extraCad[$i]['titulo'];
									$inscricao['semana'] 	= $extraCad[$i]['semana'];
									$up['vagaAtual']		= $extraCad[$i]['vagaAtual'];
									$inscricao['situacao'] 	= 0;
									$inscricao['registro']	= date('Y-m-d H:i:s');
									$inscricao['ano'] 		= date('Y');
									$inscricao['status'] 	= 1;
								}
							}
							if ($conte > 0) {
								if (DBcreate('extra_insc', $inscricao)) {
									$up['vagaAtual'] = $up['vagaAtual'] - 1;
									if (DBUpdate('extra_cad', $up, "codigo = '$id'")) {
										echo ' <script>
										   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
										   </script>';
									}
								}else{
									echo ' <script>
									   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
									   </script>';
								}
							}else{
								echo ' <script>
								   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
								   </script>';
							}
							
					}//fim do verify
				break;
				case 2:
				$verify = DBread('extra_insc', "WHERE npacce = '".$user['npacce']."' AND codigo = '$id'");
					if ($verify == true) {
						if (DBDelete('extra_insc', "npacce = '".$user['npacce']."' AND codigo = '$id'")) {
							for ($i=0; $i < count($extraCad); $i++) { 
								if ($extraCad[$i]['codigo'] == $id) {
									$up['vagaAtual']		= $extraCad[$i]['vagaAtual'];
								}
							}
							$up['vagaAtual'] = $up['vagaAtual'] + 1;
							if (DBUpdate('extra_cad', $up, "codigo = '$id'")) {
								echo ' <script>
								   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
								   </script>';
							}
						}
					}else{
						echo ' <script>
						   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
						   </script>';			
					}
				break;		
			}// fim do switch	
		}//fim verifica se int esta disponivel
	  //}//fim - verifica se e articulador
	}//fim da GET

	$data = date('Y-m-d H:i:s');
	$url[2] = DBescape(trim(strip_tags($url[2])));
	
	$extraCad = DBread('extra_cad', "WHERE codigo = '".$url[2]."' ");
	$inscritos = DBread('extra_insc', "WHERE status = true AND codigo = '$url[2]' ORDER BY nome ASC");


	if($extraCad == false) {
		echo '<div class="nada-encontrado"><h2>Nenhuma atividade de interação encontrada.</h2></div>';
	}else{
		for ($i=0; $i < count($extraCad); $i++) { 
			if ($extraCad[$i]['codigo'] == $url[2]) {
				$extra['codigo'] 			= $extraCad[$i]['codigo'];
				$extra['titulo'] 			= $extraCad[$i]['titulo'];
				$extra['semana'] 			= $extraCad[$i]['semana'];
				$extra['local'] 			= $extraCad[$i]['local'];
				$extra['data'] 			= $extraCad[$i]['data'];
				$extra['inicio'] 			= $extraCad[$i]['inicio'];
				$extra['fim'] 			= $extraCad[$i]['fim'];
				$extra['diaSemana'] 		= $extraCad[$i]['diaSemana'];
				$extra['bol1'] 			= $extraCad[$i]['bol1'];
				$extra['bol2'] 			= $extraCad[$i]['bol2'];
				$extra['npacce1'] 		= $extraCad[$i]['npacce1'];
				$extra['npacce2'] 		= $extraCad[$i]['npacce2'];
				$extra['nomeComp1'] 		= $extraCad[$i]['nomeComp1'];
				$extra['nomeComp2'] 		= $extraCad[$i]['nomeComp2'];
				$extra['vagaAtual'] 		= $extraCad[$i]['vagaAtual'];
				$extra['vagaInicial'] 	= $extraCad[$i]['vagaInicial'];
				$extra['disc'] 			= $extraCad[$i]['disc'];
				$extra['status'] 			= $extraCad[$i]['status'];
				$extra['cor'] 			= $extraCad[$i]['cor'];
			}
		}
		if (isset($_GET['editar']) && $_GET['editar'] != '') {
			if ($user['npacce'] == 'B140084' ||  $user['npacce'] == $extra['npacce1'] || $user['npacce'] == $extra['npacce2'] || $user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico') {
				include 'paginas/editar-extra-single.php';
			}
		}else{
?>	
	<script type="text/javascript">
		$(function(){
			$(".cadastar").click(function(){
				$("#divcad").toggle();
			});
		});
	</script>
	<?php 
	//===============Cadastrar em interação ================
		if (isset($_POST['send'])) {
			$form['npacce'] 	= GetPost('npacce'); 
			$form['codigo'] 	= $extra['codigo'];
			$form['semana'] 	= $extra['semana'];
			$form['titulo'] 	= $extra['titulo'];
			$form['status'] 	= 1;
			$form['situacao'] 	= 0;
			$up['vagaAtual']	= $extra['vagaAtual'];
			$form['registro']	= date('Y-m-d H:i:s');
			$form['ano'] 		= date('Y');

			$bol = DBread('bolsistas', "WHERE npacce = '".$form['npacce']."'", "id, npacce, nome, nomeUsual");
			if ($bol == false) {
				echo '<script>alert("Bolsista não encontrado!");
        					window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
			}else{
				$form['nomeCompleto'] 	= $bol[0]['nome'];
				$form['nome']			= GetName($bol[0]['nome'], $bol[0]['nomeUsual']);
				$extraInsc = DBread('extra_insc', "WHERE npacce = '".$form['npacce']."' AND codigo = '".$extra['codigo']."'", "id");
				if ($extraInsc == true) {
				 	echo '<script>alert("Esse bolsista já está cadastrado nessa interação!");
        					window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
				 }else{
				 	if ($up['vagaAtual'] <= 0) {
				 		echo '<script>alert("Não há vagas nessa interação");
        					window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
				 	}else{
				 		if (DBcreate('extra_insc', $form)) {
					 		$up['vagaAtual'] = $up['vagaAtual'] - 1; 
					 		if (DBUpDate('extra_cad', $up, "codigo = '".$extra['codigo']."'")) {
					 			echo '<script>alert("Cadastro efetuado com sucesso!!");
	        					window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
					 		}
				 		}
				 	}
				 } 
			}
		}
	?>
	<script>
	function excluir(){
			if (confirm("Você tem certeza que deseja excluir essa sala?")){
				window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'?action=3&&cod='.$extra['codigo']; ?>";
			}
		}	
	</script>
	<div class="page-ati-single">
		<div class="cabecario">
					<div class="info-single">
						<ul>
							<li><h3><?php echo $extra['titulo']; ?></h3></li>
							<li><?php echo $extra['local']; ?></li>

							<li><?php echo date('d/m', strtotime($extra['data'])); ?> -  <?php echo $extra['diaSemana']; ?></li>
							 <li><?php echo date('H:i', strtotime($extra['inicio'])).'hr'; ?>
							  - <?php echo date('H:i', strtotime($extra['fim'])).'hr'; ?> </li>

							<li>Semana <?php if($extra['semana'] >= 10){echo $extra['semana'];}else{echo '0'.$extra['semana'];} ?></li>

							<li><?php echo $extra['bol1']; if($extra['bol2'] == ''){}else{echo ' & '.$extra['bol2'];} ?></li>
							
							<li><?php echo $extra['vagaAtual']; ?>/<?php echo $extra['vagaInicial']; ?> Vagas</li>
							<li><p><strong> <?php echo printPost($extra['disc'], 'page'); ?> </strong> </p></li>
						</ul>
					</div>
					
					<div class="foto-single">
						<?php $foto = DBread('bolsistas', "WHERE npacce = '".$extra['npacce1']."'", "id, foto"); ?>
							<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
							<div class="nome"><?php echo $extra['bol1']; ?></div>
					</div>
					<?php 
						if($extra['bol2'] == ''){
						}else{
							$foto = DBread('bolsistas', "WHERE npacce = '".$extra['npacce2']."'", "id, foto");
						?> 
						<div class="foto-single">
							<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
							<div class="nome"><?php echo $extra['bol2']; ?></div>
						</div>
						<?php 
						}
					?>
					<div id="clear"></div>
					<?php
							if($user['npacce'] == $extra['npacce1'] || $user['npacce'] == 'B160676' || $user['npacce'] == 'B150323' || $user['npacce'] == $extra['npacce2'] || $user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
								
								echo '<a href="'.URL_PAINEL.'paginas/extra-lista-single.php?cod='.$extra['codigo'].'" target="_blank" class="btn btn-primary">Lista de Presença</a>';
								
								if ($extra['semana'] == $semanaProx) {
									
										$verify 	= DBread('extra_insc', "WHERE npacce = '".$user['npacce']."' AND codigo = '".$url[2]."'");
								  		if ($verify == false) {
								  			if($extra['vagaAtual'] > 0){
								  			echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=1&&ati='.$extra['codigo'].'" class="btn btn-primary">Inscrever-se</a>';
								  			}
								  		}else{
								  			echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=2&&ati='.$extra['codigo'].'" class="btn btn-primary">Cancelar Inscrição</a>';
								  		}
									
							  	}
							  	
								if ($extra['status'] == 0) {
									echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=1&&cod='.$extra['codigo'].'" class="btn btn-primary">Ativar</a>';
								}else{
									echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=2&&cod='.$extra['codigo'].'" class="btn btn-primary">Desativar</a>';
								}
				
								echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?editar='.$extra['codigo'].'" class="btn btn-primary">Editar</a>'; 
								echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'/remover-inscrito" class="btn btn-primary">Remover</a>'; 
								
		//=======================Cadastrar bolsista ==========================================//
								if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['npacce'] == $extra['npacce1'] || $user['npacce'] == $extra['npacce2']) {
									echo '<a onclick="excluir()" style="cursor:pointer;" class="btn btn-primary">Excluir</a>';

									echo '<br><a class="cadastar btn btn-primary" style="cursor: pointer;">Cadastrar Bolsista</a>';	
									echo '<div class="form" id="divcad" style="margin-left: 0px; width:30%; display:none;">
										<form action="" method="post" enctype="multipart/form-data">
											<input type="text" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" name="npacce"  placeholder="Digite o número PACCE do bolsista"></input><br><br>
				 							<input type="submit" style="display:none;" name="send"></input>
				 						</form></div>';
			 					}
							}else{
								if ($extra['semana'] == $semanaProx) {
										$verify 	= DBread('extra_insc', "WHERE npacce = '".$user['npacce']."' AND codigo = '".$url[2]."'");
								  		if ($verify == false) {
								  			if($extra['vagaAtual'] > 0){
								  				echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=1&&ati='.$extra['codigo'].'" class="btn btn-primary">Inscrever-se</a>';
								  			}
								  		}else{
								  			echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=2&&ati='.$extra['codigo'].'" class="btn btn-primary">Cancelar Inscrição</a>';
								  		}
							  	}					
							} 
							 ?>
							
		</div><br><br>
		<?php 
			if(isset($url[3]) && $url[3] == 'remover-inscrito'){
				if (isset($_GET['npacce']) && $_GET['npacce'] != '') {
					if (DBDelete('extra_insc', "npacce = '".$_GET['npacce']."' AND codigo = '".$extra['codigo']."'")) {
							
							$up['vagaAtual'] = $extra['vagaAtual'] + 1;
							if (DBUpdate('extra_cad', $up, "codigo = '".$extra['codigo']."'")) {
								# code...
							}
							echo '<script>alert("Exclusão efetuada com sucesso!!");
	        					window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
					}	
				}
			?>
			<div class="title"><h2>Remover Inscrito</h2></div>
			<?php 
				if ($inscritos == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{
			?>
			<div class="tabela">
				<table>
					<tr>
						<th>NPACCE</th>
						<th>Nome</th>
						<th>Curso</th>
						<th>Remover</th>
					</tr>
					<?php 
						for ($i=0; $i < count($inscritos); $i++) { 
							$curso = DBread('bolsistas', "WHERE npacce = '".$inscritos[$i]['npacce']."'", "curso");
							$curso = $curso[0];
					?>
					<tr>
						<td><?php echo $inscritos[$i]['npacce']; ?></td>
						<td><?php echo $inscritos[$i]['nomeCompleto']; ?> </td>
						<td><?php echo $curso['curso']; ?></td>
						<td> <a href="?npacce=<?php echo $inscritos[$i]['npacce']; ?>"> <img  src="<?php echo URL_PAINEL; ?>imagens/delete.gif" style="cursor: pointer;"> </a> </td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<?php
				}
			}elseif (isset($url[3]) && $url[3] != '') {
		//==================================Relatório================================================
				if ($user['npacce'] == $extra['npacce1'] || $user['npacce'] == $extra['npacce2']  || $user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
					 	if (strtotime($data) > strtotime($extra['data'])) {
					 		$ver = 0;
							for ($i=0; $i < count($inscritos); $i++) { 
								if ($inscritos[$i]['npacce'] == $url[3]) {
									$bolsista = $inscritos[$i];
									$ver++;
								}
							}
							if ($ver == 0) {
								echo '<div class="nada-encontrado"><h2>Bolsista não encontrado.</h2></div>';
					        }else{
					        	$tabela = 'extra_insc';
								$codigo = $url[2];
								$select =  DBread($tabela, "WHERE codigo = '".$url[2]."' AND npacce = '".$url[3]."'");
								if (isset($_POST['enviar'])) {
									$form['npacce'] 			= $bolsista['npacce'];
									$form['nomeCompleto']		= $bolsista['nomeCompleto'];
									$form['codigo']				= $url[2];
									$form['npacce1'] 			= $user['npacce'];
									$form['nome1'] 				= $user['nome'];
									$form['data']			= date('Y-m-d h:i:s');
									$form['semana']				= substr($url[2], -4, 2);

									$form['presenca'] 			= GetPost('presenca');
									if ($form['presenca'] == 1) {
										$form['situacao'] = 1;
									}else if($form['presenca'] == 0){
										$form['situacao'] = 2;
									}else if($form['presenca'] == 6){
										$form['situacao'] = 1;
									}

									if ($form['presenca'] == 6) {
										$form['entrada'] 			= GetPost('horaEnt').':'.GetPost('minEnt').':'.GetPost('segEnt');
										$form['saida'] 				= GetPost('horaSaida').':'.GetPost('minSaida').':'.GetPost('segSaida');
										$form['participacao'] 		= 3;
										$form['habilidades'] 		= 3;
										$form['responsabilidade'] 	= 3;
										$form['contribuicao'] 		= 3;
										$form['protagonismo'] 		= 3;
										$form['obs'] 				= '';
									} else{
										$form['entrada'] 			= GetPost('horaEnt').':'.GetPost('minEnt').':'.GetPost('segEnt');
										$form['saida'] 				= GetPost('horaSaida').':'.GetPost('minSaida').':'.GetPost('segSaida');
										$form['participacao'] 		= GetPost('participacao');
										$form['habilidades'] 		= GetPost('habilidades');
										$form['responsabilidade'] 	= GetPost('responsabilidade');
										$form['contribuicao'] 		= GetPost('contribuicao');
										$form['protagonismo'] 		= GetPost('protagonismo');
										$form['obs'] 				= GetPost('obs');
									}
									

									if ($form['presenca'] == '') {
										echo '<script>alert("Campo Presença está vazio");</script>';
									}else if($form['presenca'] == 0){
										$form['presenca'] 			= 0;
										$form['entrada'] 			= '';
										$form['saida'] 				= '';
										$form['participacao'] 		= 0;
										$form['habilidades'] 		= 0;
										$form['responsabilidade'] 	= 0;
										$form['contribuicao'] 		= 0;
										$form['protagonismo'] 		= 0;
										$form['obs'] 				= '';
										
										if (DBUpDate($tabela, $form, "codigo = '$codigo' AND npacce = '".$bolsista['npacce']."'")){
											echo '<script>alert("Relatório editado com sucesso.");
					        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'#corpo-single";</script>';
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
						        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'#corpo-single";</script>';
											}
										}else{
											if (DBUpDate($tabela, $form, "codigo = '$codigo' AND npacce = '".$bolsista['npacce']."'")){
												echo '<script>alert("Relatório Enviado com sucesso.");
						        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'#corpo-single";</script>';
											}
										}
									}
								}
					 		?> 
	<div class="title"><h2>Formulário de avaliação - <?php echo $bolsista['nomeCompleto']; ?></h2></div>
	<div id="editar-ativ" class="form">
	<?php 
		if ($select == true && $select[0]['situacao'] != 0) {
	?>
		<div>
			<span><strong>Avaliado por:<br></strong></span>
			<span><?php echo $select[0]['nome1']; ?></span> <strong> <br>em </strong> <?php echo date('d/m/Y H:i:s', strtotime($select[0]['data'])).' - '.$week[date('D', strtotime($select[0]['data']))]; ?><br><br>
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
	 	
	 	<label>Compareceu a reunião?</label><br><br>
	 	<?php
		if($select == true && $select[0]['situacao'] != 0){
		?>
	 	<input type="radio" name="presenca" <?php if($select == true && $select[0]['presenca'] == 1){echo 'checked=""';} ?> value="1"></input> Sim<br><br>
	 	<input type="radio" name="presenca" <?php if($select == true && $select[0]['presenca'] == 0){echo 'checked=""';} ?> value="0"></input> Não<br><br>
	 	<input type="radio" name="presenca" <?php if($select == true && $select[0]['presenca'] == 6){echo 'checked=""';} ?> value="6"></input> Não, mas justificou<br><br>
	 	<?php 
	 	}else{
 		?>
 		<input type="radio" name="presenca" class="presenca" <?php echo printRadio(GetPost('presenca'), '1'); ?> value="1"></input> Sim<br><br>
	 	<input type="radio" name="presenca" class="presenca" <?php echo printRadio(GetPost('presenca'), '0'); ?> value="0"></input> Não<br><br>
	 	<input type="radio" name="presenca" class="presenca" <?php echo printRadio(GetPost('presenca'), '6'); ?> value="6"></input> Não, mas justificou<br><br>
 		<?php
	 	}
	 	if($select == true && $select[0]['situacao'] != 0){
	 		echo '<div id="wramp_form">';
	 	}else{
	 		echo '<div id="wramp_form" style="display: none;">';
	 	}
	 	?>
	 	
	 		
	 	
	 	<label>Pontualidade:</label><span style="color: red;"> *</span> <br><br>
	 	<div style="margin: 0 auto; width: 80%;">
	 	<label>Entrada:</label><span style="color: red;"> *</span><br>
						 	<select name="horaEnt">
						 	<?php
						 	if($select == true && $select[0]['situacao'] != 0){
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
					 			$hora = $hora = explode(":", $extra['inicio']);;
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
						 	if($select == true && $select[0]['situacao'] != 0){
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
					 			$hora = explode(":", $extra['fim']);
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
	 			if($select == true && $select[0]['situacao'] != 0){
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
	 			<td><input type="radio"   name="participacao" value="2"></input></td>
	 			<td><input type="radio"  checked="" name="participacao" value="3"></input></td>
	 			<td><input type="radio"   name="participacao" value="4"></input></td>
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
	 			if($select == true && $select[0]['situacao'] != 0){
	 			?>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 1){echo 'checked=""';} ?> name="habilidades" value="1"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 2){echo 'checked=""';} ?> name="habilidades" value="2"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 3){echo 'checked=""';} ?> name="habilidades" value="3"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 4){echo 'checked=""';} ?> name="habilidades" value="4"></input></td>
	 			<td><input type="radio" <?php if($select == true && $select[0]['habilidades'] == 5){echo 'checked=""';} ?> name="habilidades" value="5"></input></td>
	 			<?php 
	 			}else{
	 			?>
	 			<td><input type="radio"  name="habilidades" value="1"></input></td>
	 			<td><input type="radio"  name="habilidades" value="2"></input></td>
	 			<td><input type="radio" checked="" name="habilidades" value="3"></input></td>
	 			<td><input type="radio"  name="habilidades" value="4"></input></td>
	 			<td><input type="radio"  name="habilidades" value="5"></input></td>
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
	 			if($select == true && $select[0]['situacao'] != 0){
	 			?>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 1){echo 'checked=""';} ?> value="1"></input></td>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 2){echo 'checked=""';} ?> value="2"></input></td>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 3){echo 'checked=""';} ?> value="3"></input></td>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 4){echo 'checked=""';} ?> value="4"></input></td>
	 			<td><input type="radio" name="responsabilidade" <?php if($select == true && $select[0]['responsabilidade'] == 5){echo 'checked=""';} ?> value="5"></input></td>
	 			<?php 
	 			}else{
	 			?>
	 			<td><input type="radio" name="responsabilidade"  value="1"></input></td>
	 			<td><input type="radio" name="responsabilidade"  value="2"></input></td>
	 			<td><input type="radio" name="responsabilidade" checked="" value="3"></input></td>
	 			<td><input type="radio" name="responsabilidade"  value="4"></input></td>
	 			<td><input type="radio" name="responsabilidade"  value="5"></input></td>
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
	 			if($select == true && $select[0]['situacao'] != 0){
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
	 			<td>1</td>
	 			<td>2</td>
	 			<td>3</td>
	 			<td>4</td>
	 			<td>5</td>
	 		</tr>
	 		<tr>
	 			<?php 
	 			if($select == true && $select[0]['situacao'] != 0){
	 			?>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 1){echo 'checked=""';} ?> value="1"></input></td>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 2){echo 'checked=""';} ?> value="2"></input></td>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 3){echo 'checked=""';} ?> value="3"></input></td>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 4){echo 'checked=""';} ?> value="4"></input></td>
	 			<td><input type="radio" name="protagonismo" <?php if($select == true && $select[0]['protagonismo'] == 5){echo 'checked=""';} ?> value="5"></input></td>
	 			<?php 
	 			}else{
	 			?>
	 			<td><input type="radio" name="protagonismo"  value="1"></input></td>
	 			<td><input type="radio" name="protagonismo"  value="2"></input></td>
	 			<td><input type="radio" name="protagonismo" checked="" value="3"></input></td>
	 			<td><input type="radio" name="protagonismo"  value="4"></input></td>
	 			<td><input type="radio" name="protagonismo"  value="5"></input></td>
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
				}else{
					echo '<div class="nada-encontrado"><h2>Acesso Negado.</h2></div>';
				}
		?>
		<?php	
			}else{
		?>
		<div class="corpo-single" id="corpo-single">
			<div class="title"><h2>Inscritos</h2></div><br>

			<?php 
				if ($inscritos == false) {
					echo '<div class="nada-encontrado"><h2>Não há Inscritos nessa interação.</h2></div>';
				}else{
					$cn = 0;
					for ($i=0; $i < count($inscritos); $i++) {
					
					if ($user['npacce'] == $extra['npacce2'] || $user['npacce'] == $extra['npacce1'] || $user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
					 	if (strtotime($data) > strtotime($extra['data'])) {
					 		echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'/'.$inscritos[$i]['npacce'].'">';
					 		$cn++;
					 	}
					 } 
					 $foto = DBread('bolsistas', "WHERE npacce = '".$inscritos[$i]['npacce']."'", "id, foto");
					 $numero  = DBread('dados_pessoais', "WHERE npacce = '".$inscritos[$i]['npacce']."'");

			?>
			<div class="foto-single">
				<span class="foto">
				<img title="<?php echo $numero[0]['fone']; ?>" src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>">
				<br>
				</span>
				<div class="nome"><?php echo $inscritos[$i]['nome']; ?></div>
			</div>
			<?php 
				if ($cn > 0){
					echo '</a>';
				}
			} }?>
		</div>
		<div id="clear"></div>
		<div id="cont"><br><?php if($inscritos == false){}else{echo '('.count($inscritos).')';} ?></div>
		<?php 
			}
		?>
	</div>
<?php 
	}
}
?>