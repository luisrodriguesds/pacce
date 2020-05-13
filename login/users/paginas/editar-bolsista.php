<style type="text/css">
.form{ margin-top: 30px; }
.form form fieldset{ border: 0px; margin-top: 15px; margin-bottom: 20px; margin-right: 30px; padding: 5px; width: 40%; float: left; }
.form form select { width: 90%;} 
#central{ margin: 0 auto; width: 90%; }
</style>
<script>
	function ativar(){
		if (confirm("Você tem certeza que desaja ativar esse bolsista??")){
			window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'?status=1'; ?>";
		}
	}
	function desativar(){
		if (confirm("Você tem certeza que deseja desativar esse bolsista??")){
			window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'?status=0'; ?>";
		}
	}
	function efetivar(){
		if (confirm("Você tem certeza que desaja Efetivar esse bolsista??")){
			window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'?situacao=1'; ?>";
		}
	}
	function voluntariar(){
		if (confirm("Você tem certeza que desaja Voluntariar esse bolsista??")){
			window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'?situacao=0'; ?>";
		}
	}
	$(function(){
		$('#rendaPercapita').mask('000.000.000.000.000,00', {reverse: true});
		$('#cep').mask("99999-999");
        $('#fone').mask("(99)99999-9999");
        $('#fone2').mask("(99)99999-9999");
        $('#fone3').mask("(99)99999-9999");

		contador('#memorial', '#contamemorial', 5000, 8000, '#valorMemorial');
	    contador('#colegaNoProjeto', '#contacolegaNoProjeto', 10, 500, '#null');
	    contador('#5problemas', '#conta5problemas', 10, 500, '#null');
	    contador('#eventosAC', '#contaeventosAC', 10, 500, '#null');
	    contador('#gruposVirtuais', "#contagruposVirtuais", 10, 500, '#null');
	    contador('#atExtra', "#contaatExtra", 10, 500, '#null');
	    contador('#ideiasDeProjeto', '#contaideiasDeProjeto', 10, 500, '#null');

	    textarea('#memorial');
	    textarea('#colegaNoProjeto');
	    textarea('#ideiasDeProjeto');
	    textarea('#5problemas');
	    textarea('#eventosAC');
	   	textarea('#gruposVirtuais');
	   	textarea('#atExtra');

	   		function textarea(seletor){
	        $(seletor).focus(function(event) {
	        	$(this).css({
	        		height: '150px',
	        		transition: 'all 1s'
	        	});
	        });
	        $(seletor).focusout(function(event) {
	        	$(this).css({
	        		height: '30px',
	        		transition: 'all 1s'
	        	});
	        });
        }

        function contador(seletorConta, seletorDestino, min, max, seletorValor){
        	$(seletorConta).keyup(function(event) {
        		var conta = $(seletorConta).val().length;
        		var texto = $(seletorConta).val();
        		
        		

        		if (conta <= 1) {
        			$(seletorDestino).empty().html(conta + " caracter");
        			if (conta >= max) { 
           	 			var new_text = texto.substr(0, max);
			            $(seletorConta).val(new_text); 
        			}
        			if (conta < min){
        				$(this).css({
        					borderBottom: '1px red solid'
        				});
        			}else{
        				$(this).css({
        					borderBottom: '1px #069 solid'
        				});
        			}
        		}else{
        			if (conta >= max) { 
           	 			var new_text = texto.substr(0, max);
			            $(seletorConta).val(new_text); 
        			}
        			if (conta < min){
        				$(this).css({
        					borderBottom: '1px red solid'
        				});
        			}else{
        				$(this).css({
        					borderBottom: '1px #069 solid'
        				});
        			}
        			$(seletorDestino).empty().html(conta + " caracteres");
        			
        		}
        	});
        	var conta = $(seletorConta).val().length;
        	$(seletorValor).attr('value', conta);
        }
    	$('.ConfirmaDefiencia').click(function(event) {
			var d = $(this).attr('value');
			if (d == '1'){
				$('#deficiencia').css({display:'block'});
			}else{
				$('#deficiencia').css({display:'none'});
			}
		});

    	
	});

</script>
<?php 

	//RELATÓRIO INDIVIDUAL
	if (isset($url[3]) && $url[3] !='relato' && $url[3] !='' && $url[3] != 'memorial') {
		echo include 'paginas/relatorio-individual.php';
	} else if (isset($url[3]) && $url[3] == 'relato') {
		$bolsista = DBread('bolsistas', "WHERE cpf = '".$url[2]."'");
		$bolsista = $bolsista[0];  
		$relato = DBread('relato', "WHERE npacce = '".$bolsista['npacce']."'");

		?>
		<h3><?php echo date('Y').'.1'; ?></h3>
		<?php
		if ($relato[0]['relato'] == '') {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		} else {
			echo '<p style="fontSize: 10px">'.$relato[0]['relato'].'</p>';
		}

		?>
		<h3><?php echo date('Y').'.2'; ?></h3>
		<?php
		if ($relato[1]['relato'] == '') {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		} else {
			echo '<p style="fontSize: 10px">'.$relato[1]['relato'].'</p>';
		}


	} else if (isset($url[3]) && $url[3] == 'memorial') {
		$bolsista = DBread('bolsistas', "WHERE cpf = '".$url[2]."'");
		$bolsista = $bolsista[0];  
		$memorial = DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."'");
		?>
		<h3><?php echo date('Y').'.1'; ?></h3>
		<?php
		if ($memorial[0]['memorial'] == '') {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		} else {
			echo '<p style="fontSize: 10px">'.$memorial[0]['memorial'].'</p>';
		}
		 

	} else {
	$comissoes = DBread('comissoes', "WHERE status = true");
	$bolsista = DBread('bolsistas', "WHERE cpf = '".$url[2]."'");
	$bolsista = $bolsista[0];  
	if ($bolsista == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
		$pessoal = DBread('dados_pessoais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
		$pessoal = $pessoal[0];
		$acad 	 = DBread('dados_academicos', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
		$acad 	 = $acad[0];
		$bank	 = DBread('dados_bancarios', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."' ");
		$bank    = $bank[0];
		$add	 = DBread('dados_add', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
		$add 	 = $add[0];
		$memorial = DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");

		//SITUACAO
		if (isset($_GET['situacao']) && $_GET['situacao'] != '') {
			$up['situacao'] = DBescape($_GET['situacao']);

			if ($up['situacao'] != $bolsista['situacao']) {
				$antes_t = DBread('trajetoria', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY id DESC");
				if ($antes_t == true) {
					//Enviar o atual
					$trajetoria['data_saida'] = date('Y-m-d H:i:s');
					if (DBUpDate('trajetoria', $trajetoria, "id = '".$antes_t[0]['id']."'")) {
						//Enviar o novo
						$trajetoria = '';
						$trajetoria['npacce'] 		= $bolsista['npacce'];
						$trajetoria['nome']	  		= $bolsista['nome'];
						$trajetoria['situacao']		= $up['situacao'];
						$trajetoria['status']		= $bolsista['status'];
						$trajetoria['tipo']			= $bolsista['tipo'];
						$trajetoria['data_entrada']	= date('Y-m-d H:i:s');
						$trajetoria['npacceRegistro']= $user['npacce'];
						$trajetoria['registro']		= date('Y-m-d H:i:s');
						if (DBcreate('trajetoria', $trajetoria)) {
						}
					}
				}else{
					//Enviar o atual
					$trajetoria['npacce'] 		= $bolsista['npacce'];
					$trajetoria['nome']	  		= $bolsista['nome'];
					$trajetoria['situacao']		= $up['situacao'];
					$trajetoria['status']		= $bolsista['status'];
					$trajetoria['tipo']			= $bolsista['tipo'];
					$trajetoria['data_saida']	= date('Y-m-d H:i:s');
					$trajetoria['npacceRegistro']= $user['npacce'];
					$trajetoria['registro']		= date('Y-m-d H:i:s');
					if (DBcreate('trajetoria', $trajetoria)) {
						//Enviar o novo
						$trajetoria = '';
						$trajetoria['npacce'] 		= $bolsista['npacce'];
						$trajetoria['nome']	  		= $bolsista['nome'];
						$trajetoria['situacao']		= $up['situacao'];
						$trajetoria['status']		= $bolsista['status'];
						$trajetoria['tipo']			= $bolsista['tipo'];
						$trajetoria['data_entrada']	= date('Y-m-d H:i:s');
						$trajetoria['npacceRegistro']= $user['npacce'];
						$trajetoria['registro']		= date('Y-m-d H:i:s');
						if (DBcreate('trajetoria', $trajetoria)) {
						}
					}
				}	
			}

			if (DBUpDate('bolsistas', $up, "npacce = '".$bolsista['npacce']."'")) {
				alertaLoad("Açao realizada com sucesso!", $way.'/'.$url[1].'/'.$url[2]);
			}
		}

		


		//STATUS DO BOLSISTA
		if (isset($_GET['status']) && $_GET['status'] != '') {
			$up['status'] = DBescape($_GET['status']);

			if ($up['status'] != $bolsista['status']) {
				$antes_t = DBread('trajetoria', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY id DESC");
				if ($antes_t == true) {
					//Enviar o atual
					$trajetoria['data_saida'] = date('Y-m-d H:i:s');
					if (DBUpDate('trajetoria', $trajetoria, "id = '".$antes_t[0]['id']."'")) {
						//Enviar o novo
						$trajetoria = '';
						$trajetoria['npacce'] 		= $bolsista['npacce'];
						$trajetoria['nome']	  		= $bolsista['nome'];
						$trajetoria['situacao']		= $bolsista['situacao'];
						$trajetoria['status']		= $up['status'];
						$trajetoria['tipo']			= $bolsista['tipo'];
						$trajetoria['data_entrada']	= date('Y-m-d H:i:s');
						$trajetoria['npacceRegistro']= $user['npacce'];
						$trajetoria['registro']		= date('Y-m-d H:i:s');
						if (DBcreate('trajetoria', $trajetoria)) {
						
						}
					}
				}else{
					//Enviar o atual
					$trajetoria['npacce'] 		= $bolsista['npacce'];
					$trajetoria['nome']	  		= $bolsista['nome'];
					$trajetoria['situacao']		= $bolsista['situacao'];
					$trajetoria['status']		= $up['status'];
					$trajetoria['tipo']			= $bolsista['tipo'];
					$trajetoria['data_saida']	= date('Y-m-d H:i:s');
					$trajetoria['npacceRegistro']= $user['npacce'];
					$trajetoria['registro']		= date('Y-m-d H:i:s');
					if (DBcreate('trajetoria', $trajetoria)) {
						//Enviar o novo
						$trajetoria = '';
						$trajetoria['npacce'] 		= $bolsista['npacce'];
						$trajetoria['nome']	  		= $bolsista['nome'];
						$trajetoria['situacao']		= $bolsista['situacao'];
						$trajetoria['status']		= $bolsista['status'];
						$trajetoria['tipo']			= $bolsista['tipo'];
						$trajetoria['data_entrada']	= date('Y-m-d H:i:s');
						$trajetoria['npacceRegistro']= $user['npacce'];
						$trajetoria['registro']		= date('Y-m-d H:i:s');
						if (DBcreate('trajetoria', $trajetoria)) {
						
						}
					}
				}	
			}

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
	
				//Busca de Atividades
				$apo_insc = DBread('apo_insc', "WHERE status = true AND npacce = '".$bolsista['npacce']."'");
				$for_insc = DBread('for_insc', "WHERE status = true AND npacce = '".$bolsista['npacce']."'");
				$rod_insc = DBread('rod_insc', "WHERE status = true AND npacce = '".$bolsista['npacce']."'");
				$projeto  = DBread('projetos', "WHERE npacce = '".$bolsista['npacce']."'", "id");
				$celula   = DBread('horario_celula', "WHERE npacce = '".$bolsista['npacce']."'", "id");
				$link 	  = DBread('link_av', "WHERE npacce = '".$bolsista['npacce']."'");
				
				//Cancelar inscrição em Apoio
				if ($apo_insc == false) {
				}else{
				 	$apo_sala = DBread('apo_salas', "WHERE sala = '".$apo_insc[0]['sala']."'");
				 	if ($apo_sala == false) {
				 	}else{
				 		$vaga['vagaAtual'] = $apo_sala[0]['vagaAtual'] + 1;
				 		if (DBUpDate('apo_salas', $vaga," sala = '".$apo_sala[0]['sala']."'")) {
				 			DBDelete('apo_insc', "npacce = '".$bolsista['npacce']."' AND sala = '".$apo_insc[0]['sala']."'");
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
				 			DBDelete('for_insc', "npacce = '".$bolsista['npacce']."' AND sala = '".$for_insc[0]['sala']."'");
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
				 			DBDelete('rod_insc', "npacce = '".$bolsista['npacce']."' AND sala = '".$rod_insc[0]['sala']."'");
				 		}
				 	}
				}

				 //Desativar Projeto
				if ($projeto == true) {
				$upi['status'] = 0;
				DBUpDate('projetos', $upi, "npacce = '".$bolsista['npacce']."'");
				}
				 //Desativar Célula
				if ($celula == true) {
				$upi['status'] = 0;
				DBUpDate('horario_celula', $upi, "npacce = '".$bolsista['npacce']."'");
				}
				 //Desativar da avaliação 
				if ($link == true) {
				DBDelete('link_av', "npacce = '".$bolsista['npacce']."'");
				}

				 //Confirmar
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

		//SALVAR ALTERAÇÕES 
		if (isset($_POST['salvar'])) {
			//$form['nome'] 		= GetPost('nome');
			//$form['npacce'] 	= strtoupper(GetPost('npacce'));
			$form['tipo'] 		= GetPost('comissao');
			$form['tipoSlug'] 	= Slug(GetPost('comissao'));
			$form['nomeUsual'] 	= GetPost('nomeUsual'); 
			//$form['matricula']= GetPost('matricula');
			//$form['cpf']		= GetPost('cpf');
			//$form['rg']		= GetPost('rg');
			//$form['curso']	= GetPost('curso');
			//$form['sexo']		= GetPost('sexo');
			//$form['email']	= GetPost('email');

			$apo['sala'] = GetPost('apo');
			$for['sala'] = GetPost('for');
			$rod['sala'] = GetPost('rod');

			$verifyApo = DBread('apo_insc', "WHERE npacce = '".$bolsista['npacce']."' AND status = true", "id, npacce, sala");
			$verifyFor = DBread('for_insc', "WHERE npacce = '".$bolsista['npacce']."' AND status = true", "id, npacce, sala");
			$verifyRod = DBread('rod_insc', "WHERE npacce = '".$bolsista['npacce']."' AND status = true", "id, npacce, sala");
			
			//PARA O APOIO
			if ($apo['sala'] != 1) {
				//Caso não esteja matriculado
				if ($verifyApo == false) {			
					$apo['npacce'] 			= $bolsista['npacce'];
					$apo['nomeCompleto'] 	= $bolsista['nome'];
					$apo['nomeUsual'] 		= GetName($bolsista['nome'], $bolsista['nomeUsual']);
					$apo['status'] 			= 1;
					$apo['registro']		= date('Y-m-d H:i:s');
					$apo['ano'] 			= date('Y');
					if (!empty($apo['sala'])) {
						# code...
						if (DBcreate('apo_insc', $apo)) {
							$vagaApo = DBread('apo_salas', "WHERE sala = '".$apo['sala']."'", "id, vagaAtual");
							$up['vagaAtual'] = $vagaApo[0]['vagaAtual'] - 1;
							DBUpDate('apo_salas', $up, "sala = '".$apo['sala']."'"); 
						}
					}
				}else{
					//caso esteja matriculado em uma sala e deseja fazer a troca
					if ($verifyApo[0]['sala'] != $apo['sala']) {
						if (DBDelete('apo_insc', "npacce = '".$bolsista['npacce']."' AND sala = '".$verifyApo[0]['sala']."' ")) {
							//atulalizar as vagas
							$vagaApo = DBread('apo_salas', "WHERE sala = '".$verifyApo[0]['sala']."'", "id, vagaAtual");
							$up['vagaAtual'] = $vagaApo[0]['vagaAtual'] + 1;

							if (DBUpDate('apo_salas', $up,"sala = '".$verifyApo[0]['sala']."'")) {
								$apo['npacce'] 			= $bolsista['npacce'];
								$apo['nomeCompleto'] 	= $bolsista['nome'];
								$apo['nomeUsual'] 		= GetName($bolsista['nome'], $bolsista['nomeUsual']);
								$apo['status'] 			= 1;
								$apo['registro']		= date('Y-m-d H:i:s');
								$apo['ano'] 			= date('Y');
								if (!empty($apo['sala'])) {
									# code...
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
			}

			//PARA A FORMAÇÃO
			if ($for['sala'] != 1) {
				//Caso não esteja matriculado
				if ($verifyFor == false) {			
					$for['npacce'] 			= $bolsista['npacce'];
					$for['nomeCompleto'] 	= $bolsista['nome'];
					$for['nomeUsual'] 		= GetName($bolsista['nome'], $bolsista['nomeUsual']);
					$for['status'] 			= 1;
					$for['registro']		= date('Y-m-d H:i:s');
					$for['ano'] 			= date('Y');

					if (!empty($for['sala'])) {
						if (DBcreate('for_insc', $for)) {
							$vagaFor = DBread('for_salas', "WHERE sala = '".$for['sala']."'", "id, vagaAtual");
							$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] - 1;
							DBUpDate('for_salas', $up, "sala = '".$for['sala']."'"); 
						}
					}
				}else{
					//caso esteja matriculado em uma sala e deseja fazer a troca
					if ($verifyFor[0]['sala'] != $for['sala']) {
						if (DBDelete('for_insc', "npacce = '".$bolsista['npacce']."' AND sala = '".$verifyFor[0]['sala']."' ")) {
							//atulalizar as vagas
							$vagaFor = DBread('for_salas', "WHERE sala = '".$verifyFor[0]['sala']."'", "id, vagaAtual");
							$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] + 1;

							if (DBUpDate('for_salas', $up,"sala = '".$verifyFor[0]['sala']."'")) {
								$for['npacce'] 			= $bolsista['npacce'];
								$for['nomeCompleto'] 	= $bolsista['nome'];
								$for['nomeUsual'] 		= GetName($bolsista['nome'], $bolsista['nomeUsual']);
								$for['status'] 			= 1;
								$for['registro']		= date('Y-m-d H:i:s');
								$for['ano'] 			= date('Y');
								
								if (!empty($for['sala'])) {
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
			}

				//PARA A RODA VIVA
			if ($rod['sala'] != 1) {
				//Caso não esteja matriculado
				if ($verifyRod == false) {			
					$rod['npacce'] 			= $bolsista['npacce'];
					$rod['nomeCompleto'] 	= $bolsista['nome'];
					$rod['nomeUsual'] 		= GetName($bolsista['nome'], $bolsista['nomeUsual']);
					$rod['status'] 			= 1;
					$rod['registro']		= date('Y-m-d H:i:s');
					$rod['ano'] 			= date('Y');
					if (!empty($rod['sala'])) {
						if (DBcreate('rod_insc', $rod)) {
							$vagaFor = DBread('rod_salas', "WHERE sala = '".$rod['sala']."'", "id, vagaAtual");
							$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] - 1;
							DBUpDate('rod_salas', $up, "sala = '".$rod['sala']."'"); 
						}
					}
				}else{
					//caso esteja matriculado em uma sala e deseja fazer a troca
					if ($verifyRod[0]['sala'] != $rod['sala']) {
						if (DBDelete('rod_insc', "npacce = '".$bolsista['npacce']."' AND sala = '".$verifyRod[0]['sala']."' ")) {
							//atulalizar as vagas
							$vagaFor = DBread('rod_salas', "WHERE sala = '".$verifyRod[0]['sala']."'", "id, vagaAtual");
							$up['vagaAtual'] = $vagaFor[0]['vagaAtual'] + 1;

							if (DBUpDate('rod_salas', $up,"sala = '".$verifyRod[0]['sala']."'")) {
								$rod['npacce'] 			= $bolsista['npacce'];
								$rod['nomeCompleto'] 	= $bolsista['nome'];
								$rod['nomeUsual'] 		= GetName($bolsista['nome'], $bolsista['nomeUsual']);
								$rod['status'] 			= 1;
								$rod['registro']		= date('Y-m-d H:i:s');
								$rod['ano'] 			= date('Y');
								if (!empty($rod['sala'])) {
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

			//Trocar tipo
			if ($form['tipo'] != $bolsista['tipo']) {
				$antes_t = DBread('trajetoria', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY id DESC");
				if ($antes_t == true) {
					//Enviar o atual
					$trajetoria['data_saida'] = date('Y-m-d H:i:s');
					if (DBUpDate('trajetoria', $trajetoria, "id = '".$antes_t[0]['id']."'")) {
						//Enviar o novo
						$trajetoria = '';
						$trajetoria['npacce'] 		= $bolsista['npacce'];
						$trajetoria['nome']	  		= $bolsista['nome'];
						$trajetoria['situacao']		= $bolsista['situacao'];
						$trajetoria['status']		= $bolsista['status'];
						$trajetoria['tipo']			= $form['tipo'];
						$trajetoria['data_entrada']	= date('Y-m-d H:i:s');
						$trajetoria['npacceRegistro']= $user['npacce'];
						$trajetoria['registro']		= date('Y-m-d H:i:s');
						if (DBcreate('trajetoria', $trajetoria)) {
						
						}
					}
				}else{
					//Enviar o atual
					$trajetoria['npacce'] 		= $bolsista['npacce'];
					$trajetoria['nome']	  		= $bolsista['nome'];
					$trajetoria['situacao']		= $bolsista['situacao'];
					$trajetoria['status']		= $bolsista['status'];
					$trajetoria['tipo']			= $bolsista['tipo'];
					$trajetoria['data_saida']	= date('Y-m-d H:i:s');
					$trajetoria['npacceRegistro']= $user['npacce'];
					$trajetoria['registro']		= date('Y-m-d H:i:s');
					if (DBcreate('trajetoria', $trajetoria)) {
						//Enviar o novo
						$trajetoria = '';
						$trajetoria['npacce'] 		= $bolsista['npacce'];
						$trajetoria['nome']	  		= $bolsista['nome'];
						$trajetoria['situacao']		= $bolsista['situacao'];
						$trajetoria['status']		= $bolsista['status'];
						$trajetoria['tipo']			= $form['tipo'];
						$trajetoria['data_entrada']	= date('Y-m-d H:i:s');
						$trajetoria['npacceRegistro']= $user['npacce'];
						$trajetoria['registro']		= date('Y-m-d H:i:s');
						if (DBcreate('trajetoria', $trajetoria)) {
						
						}
					}
				}	
			}

			$form = DBescape($form);
			if (DBUpDate('bolsistas', $form, "cpf = '".$url[2]."'")) {
				alertaLoad("Dados alterados com sucesso", $way.'/'.$url[1].'/'.$url[2]);
			}
		}
		
		//GERAR PDF DO RELATÓRIO INDIVIDUAL
		if (isset($_GET['relatorio-individual'])) {
			include 'gerar-ri-pdf.php';
		}

		if (isset($_GET['declaracao-simples'])) {
			include 'gerar-declaracao-simples.php';
		}

		if (isset($_GET['desistencia'])) {
			include 'gerar-desistencia.php';
		}

		if (isset($_GET['cump-horas'])) {
			include 'gerar-cump-horas.php';
		}
?> 
	<script type="text/javascript">
		// var person = prompt("Please enter your name", "Harry Potter");

		// if (person != null) {
		//     document.getElementById("demo").innerHTML = "Hello " + person + "! How are you today?";
		// }
	</script>
	<br>
	<div class="title"> <h2>	<?php echo $bolsista['nome']; ?></h2> </div>
	<br>
	<div class="title"> <h2>Opções</h2> </div>
	<a style="margin: 2px;" href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$bolsista['npacce']; ?>" class="btn btn-success">Relatório Individual</a>
	<a style="margin: 2px;" href="?relatorio-individual=<?php echo $bolsista['npacce']; ?>" class="btn btn-success">Relatório Individual - PDF</a>
	<a style="margin: 2px;" href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.'relato'; ?>" class="btn btn-warning">Relato de Experiência</a>
	<a style="margin: 2px;" href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.'memorial'; ?>" class="btn btn-warning">Memorial da seleção</a>
	<a style="margin: 2px;" href="?declaracao-simples=<?php echo $bolsista['npacce']; ?>" class="btn btn-danger">Declaração Simples - PDF</a>
	<a style="margin: 2px;" href="?desistencia=<?php echo $bolsista['npacce']; ?>" class="btn btn-danger">Termo de Desistência</a>
	<a style="margin: 2px;" href="?cump-horas=<?php echo $bolsista['npacce']; ?>" class="btn btn-danger">Termo de Cump. de Horas</a>

	<?php 
		if ($bolsista['status'] == 1) {
			echo '<a style=" margin: 0 5px 0 0; cursor: pointer; color:white;" onclick="desativar()" class="btn btn-danger">Desativar Bolsista</a>';
		}else{
			echo '<a style="margin: 0 5px 0 0; cursor: pointer; color:white;" onclick="ativar()" class="btn btn-primary">Ativar Bolsista</a>';
		}
		if ($user['tipoSlug'] == 'ceo') {
			if ($bolsista['situacao'] == 0) {
				echo '<a style="margin: 0; cursor: pointer; color:white;" onclick="efetivar()" class="btn btn-info">Efetivar</a>';
			}else{
				echo '<a style="margin: 0; cursor: pointer; color:white;" onclick="voluntariar()" class="btn btn-secondary">Voluntariar</a>';
			}
		}
	?>

	<div class="form">
		<form method="post">
		<div class="title"> <h2>Dados PACCE</h2> </div>
		<div id="central">
			<fieldset id="F_npacce" style="margin-bottom: 0;">
				<label>Número PACCE </label> 
				<div class="subtitle"> </div>
				<input type="text" name="npacce" id="npacce" placeholder="Digite seu Número PACCE" value="<?php echo $bolsista['npacce']; ?>" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" >
			</fieldset>

			<fieldset id="F_tipo">
					<label>Função </label>
					<div class="subtitle"> </div>
						<?php 
			        $comissoes = DBread('comissoes', "WHERE status = true");
			       ?>
			       <select name="comissao" id="comissao" >
			          <option value="" selected="">Escolha a comissao...</option>
			      <?php 
					for ($i=0; $i < count($comissoes); $i++) { 
						
						?> 
						<option <?php if($bolsista['tipoSlug'] == $comissoes[$i]['comissaoSlug']){
							echo 'selected=""';
							} ?> value="<?php echo $comissoes[$i]['comissao']; ?>"><?php echo $comissoes[$i]['comissao']; ?></option>
						<?php
					}
				?>
			       </select>
			</fieldset>

			<?php 
			
				$apo 	= DBread('apo_salas', "WHERE status = true ORDER BY sala ASC");
				$apoIns = DBread('apo_insc', "WHERE status = true AND npacce = '".$bolsista['npacce']."'", "id, sala, npacce");
				?>
				<fieldset id="F_apo" style="margin-top: 0;">
					<label>Apoio à Célula</label>
					<div class="subtitle"> </div>
					<select name="apo" id="apo">
						<?php 
							if ($apo == false) {
								echo '<option value="">Nenhuma sala encontrada...</option>';
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
				</fieldset>
			<fieldset id="F_nomeUsual" style="float: none;">
				<label>Nome Usual</label> <span class="red">*</span>
				<div class="subtitle"> </div>
				<select id="nomeUsual" name="nomeUsual">
					<option value="0">Escolha seu nome usual</option>
					<?php 
						$nomeUsual = explode(' ', $bolsista['nome']);
						for ($i=0; $i < count($nomeUsual); $i++) {
							$valor = $i + 1; 
							if ($bolsista['nomeUsual'] == $valor) {
								$checkNomeUsual = 'selected';
							}else{
								$checkNomeUsual = '';
							}
							echo '<option '.$checkNomeUsual.' value="'.$valor.'">'.$nomeUsual[$i].'</option>';
						}
					?>
				</select>
			</fieldset>
			<?php 
		
					$for 	= DBread('for_salas', "WHERE status = true ORDER BY sala ASC");
					$forIns = DBread('for_insc', "WHERE status = true AND npacce = '".$bolsista['npacce']."'", "id, sala, npacce");
					?>
				<fieldset id="F_for" style="margin-top: 0;">
					<label>Formação</label>
					<div class="subtitle"> </div>

					<select name="for" id="for">
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

				</fieldset>
				
				<?php 
					$rod 	= DBread('rod_salas', "WHERE status = true ORDER BY sala ASC");
					$rodIns = DBread('rod_insc', "WHERE status = true AND npacce = '".$bolsista['npacce']."'", "id, sala, npacce");
				
				?>
				<fieldset id="F_rod" style="margin-top: 0;">
					<label>História de Vida</label>
					<div class="subtitle"> </div>
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
				</fieldset>
					<?php
				
			?>
			<fieldset>
				<label>Observações</label>
				<div class="subtitle">
				
					<?php 
						if ($bolsista['status'] == 1) {
							echo '<strong>Usuário Ativo</strong>';
						}else{
							echo '<strong>Usuário Inatívo desde '.date('d/m/y - H:i:s', strtotime($bolsista['registroSaida'])).'</strong>';
						}
					?>
				
				 </div>
			</fieldset>
			<div id="clear"></div>
			<center>
				<input type="submit" name="salvar" value="Salvar">
			</center>
			
		</div>
		</form>
		<?php 
		

			if (isset($_POST['enviar'])) {
				
				//DADOS PESSOAIS
				$bol['nome'] 				= GetPost('nome');
				$bol['dataNasc'] 			= GetPost('dataNasc');
				
				//se não estiver vazio
				if ($bol['dataNasc'] !== '') {
					$dataNasc 					= explode('/', $bol['dataNasc']);
					$bol['dataNasc']		= $dataNasc[2].'-'.$dataNasc[1].'-'.$dataNasc[0].' 00:00:00';
				}

				$bol['sexo'] 				= GetPost('sexo');
				$bol['cpf'] 				= GetPost('cpf');
				$bol['rg'] 				= GetPost('rg');

				$bol['curso'] 				= GetPost('curso');
				$bol['campus'] 			= GetPost('campus');
				$bol['campusSlug'] 		= Slug($bol['campus']);

				$bol['matricula'] 			= GetPost('matricula');
				$bol['registroAssTermo'] 	= GetPost('assinatura');

				$bol['email'] 				= GetPost('email');

				$pessoal['endereco'] 			= GetPost('endereco');
				$pessoal['bairro'] 				= GetPost('bairro');
				$pessoal['cidadeEstado'] 		= GetPost('cidadeEstado');
				$pessoal['naturalidade']		= GetPost('naturalidade');
				$pessoal['cep'] 				= GetPost('cep');
				$pessoal['fone'] 				= GetPost('fone');
				$pessoal['fone2'] 				= GetPost('fone2');
				$pessoal['fone3'] 				= GetPost('fone3');
				$pessoal['rendaPercapita']		= GetPost('rendaPercapita');

				$acad['turno'] 					= GetPost('turno');
				$acad['semestre'] 				= GetPost('semestre');
				$acad['semestreEntrada']		= GetPost('semestreEntrada');
				$acad['centro'] 				= GetPost('centro');

				$bank['banco']					= GetPost('banco');
				$bank['agencia']				= GetPost('agencia'); 
				$bank['conta']					= GetPost('conta');
				$bank['operacao']				= GetPost('operacao');

				if (empty($bol['nome'])) {
					echo '<script type="text/javascript">alert("Digite o nome!!");</script>';
				}else if (empty($bol['dataNasc'])) {
					echo '<script type="text/javascript">alert("Digite a Data de nascimento!!");</script>';
				}else if ($bol['sexo'] === '' || $bol['sexo'] === null) {
					echo '<script type="text/javascript">alert("Digite o sexo!!");</script>';
				}else if (empty($bol['cpf'])) {
					echo '<script type="text/javascript">alert("Digite o CPF!!");</script>';
				}else if (empty($bol['rg'])) {
					echo '<script type="text/javascript">alert("Digite o RG!!");</script>';
				}else if (empty($bol['campus'])) {
					echo '<script type="text/javascript">alert("Selecione o campus!!");</script>';
				}else if (empty($bol['matricula'])) {
					echo '<script type="text/javascript">alert("Digite a matrícula!!");</script>';
				}else if (empty($bol['email'])) {
					echo '<script type="text/javascript">alert("Digite o emial!!");</script>';
				}else if (empty($bol['curso'])) {
					echo '<script type="text/javascript">alert("Selecione o curso!!");</script>';
				}else if (empty($pessoal['endereco'])) {
					echo '<script type="text/javascript">alert("Digite o endereço!!");</script>';
				}else if (empty($pessoal['bairro'])) {
					echo '<script type="text/javascript">alert("Digite o bairro!!");</script>';
				}else if (empty($pessoal['cidadeEstado'])) {
					echo '<script type="text/javascript">alert("Digite o Cidade/Estado!!");</script>';
				}else if (empty($pessoal['naturalidade'])) {
					echo '<script type="text/javascript">alert("Digite a Naturalidade!!");</script>';
				}else if (empty($pessoal['cep'])) {
					echo '<script type="text/javascript">alert("Digite o CEP!!");</script>';
				}else if (empty($pessoal['fone'])) {
					echo '<script type="text/javascript">alert("Digite o Fone!!");</script>';
				}else if (empty($pessoal['rendaPercapita'])) {
					echo '<script type="text/javascript">alert("Digite a Renda per capita!!");</script>';
				}else if (empty($acad['turno'])) {
					echo '<script type="text/javascript">alert("Selecione o turno!!");</script>';
				}else if (empty($acad['semestreEntrada'])) {
					echo '<script type="text/javascript">alert("Selecione o semestreEntrada!!");</script>';
				}else if (empty($acad['centro'])) {
					echo '<script type="text/javascript">alert("Digite o Centro!!");</script>';
				}else if (empty($bank['banco'])) {
					echo '<script type="text/javascript">alert("Digite o banco!!");</script>';
				}else if (empty($bank['agencia'])) {
					echo '<script type="text/javascript">alert("Digite o agencia!!");</script>';
				}else if (empty($bank['conta'])) {
					echo '<script type="text/javascript">alert("Digite o conta!!");</script>';
				}else if ($bank['banco'] == "Caixa" && empty($bank['operacao'])) {
					echo '<script type="text/javascript">alert("Digite o operacao!!");</script>';
				}else{
					if (DBUpDate('bolsistas', $bol , "npacce = '".$bolsista['npacce']."'")) {
						if (DBUpDate('dados_pessoais', $pessoal, "npacce = '".$bolsista['npacce']."'")) {
							if (DBUpDate('dados_academicos', $acad, "npacce = '".$bolsista['npacce']."'")) {
								if (DBUpDate('dados_bancarios', $bank, "npacce = '".$bolsista['npacce']."' ")) {
									echo '
					       			<script>
					       			    alert("Dados Alterados com sucesso!!!");
					     			      window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
					   				</script>';
								}
								
							}
						}
					}
				}
				
			}
		?>

		<form method="post">
			<div class="title"> <h2>Dados Pessoais</h2> </div>
			<div id="central">
				<fieldset id="F_nome">
					<label>Nome Completo </label>
					<div class="subtitle"> </div>
					<input type="text" name="nome" id="nome" placeholder="Digite seu nome" value="<?php echo $bolsista['nome']; ?>" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)">
				</fieldset>

				<fieldset id="F_dataNasc">
					<label>Data de Nascimento </label>
					<input type="text" name="dataNasc" id="dataNasc" value="<?php echo date('d/m/Y', strtotime($bolsista['dataNasc'])); ?>" placeholder="Digite a data do seu nascimento" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)">
				</fieldset>

				<fieldset id="F_sexo">
					<label>Sexo </label> 
					<div class="subtitle"> <p> </p> </div>
					
						<span style="margin-right: 30px;"><input type="radio" name="sexo" id="sexo" value="1" <?php echo printRadio($bolsista['sexo'], '1'); ?>> <span class="op">  Masculino 	</span> </span>
				
						<input type="radio" name="sexo" id="sexo" value="0" <?php echo printRadio($bolsista['sexo'], '0'); ?>> <span class="op"> Feminino </span>
				</fieldset>

				<fieldset id="F_cpf">
					<label>CPF </label> 
					<input type="text" name="cpf" id="cpf" value="<?php echo $bolsista['cpf']; ?>" placeholder="Digite seu CPF" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)">
					<span id="checkCPF"> </span>
				</fieldset>
				
				<fieldset id="F_rg">
					<label>RG </label> 
					<input type="text" name="rg" id="rg" placeholder="Digite seu RG" value="<?php echo $bolsista['rg']; ?>" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)">
				</fieldset>
				
				<fieldset id="F_endereco">
					<label>Endereço </label> <span class="red">*</span>
					<div class="subtitle"> </div>
					<input type="text" name="endereco" id="endereco" value="<?php echo $pessoal['endereco']; ?>" placeholder="Ex: Rua Alameda dos Anjos, 6666, apto 6, bloco 6Z." autocomplete="off">
				</fieldset>

				<fieldset id="F_bairro">
					<label>Bairro </label> <span class="red">*</span>
					<div class="subtitle"></div>
					<input type="text" name="bairro" id="bairro" value="<?php echo $pessoal['bairro']; ?>" placeholder="Ex: Castelão" autocomplete="off">
				</fieldset>

				<fieldset id="F_cidadeEstado">
					<label>Cidade/Estado </label> <span class="red">*</span>
					<div class="subtitle"> </div>
					<input type="text" name="cidadeEstado" value="<?php echo $pessoal['cidadeEstado']; ?>" id="cidadeEstado" placeholder="Ex: Fortaleza/CE" autocomplete="off">
				</fieldset>

				<fieldset id="F_naturalidade">
					<label>Naturalidade </label> <span class="red">*</span>
					<div class="subtitle"></div>
					<input type="text" name="naturalidade" value="<?php echo $pessoal['naturalidade']; ?>" id="naturalidade" placeholder="Ex: Russas/CE" autocomplete="off">
				</fieldset>
				
				<fieldset id="F_cep">
					<label>CEP </label> <span class="red">*</span>
					<div class="subtitle"></div>
					<input type="text" name="cep" id="cep" value="<?php echo $pessoal['cep']; ?>" placeholder="Ex: 00000-000" autocomplete="off">
				</fieldset>

				<fieldset id="F_fone">
					<label>Contato </label> <span class="red">*</span>
					<div class="subtitle"> </div>
					<input type="text" name="fone" id="fone" value="<?php echo $pessoal['fone']; ?>" placeholder="Use o seu número principal - Ex: (00)00000-0000" autocomplete="off">
				</fieldset>

				<fieldset id="F_fone2">
					<label>Contato Alternativo </label> <span class="red">*</span>
					<div class="subtitle"> </div>
					<input type="text" name="fone2" id="fone2" value="<?php echo $pessoal['fone2']; ?>" placeholder="Ex: (00)00000-0000" autocomplete="off">
				</fieldset>

				<fieldset id="F_fone3">
					<label>Contato Amigo </label> <span class="red">*</span>
					<div class="subtitle"></div>
					<input type="text" name="fone3" id="fone3" value="<?php echo $pessoal['fone3']; ?>" placeholder="Ex: (00)00000-0000" autocomplete="off">
				</fieldset>

				<fieldset id="F_email">
					<label>Email usual </label> <span class="red">*</span>
					<div class="subtitle"></div>
					<input type="email" name="email" id="email" value="<?php echo $bolsista['email']; ?>" placeholder="Use seu email principal." autocomplete="off">
				</fieldset>

				<fieldset id="F_facebook">
					<label>Facebook </label>
					<div class="subtitle"> <p>Cole abaixo o endereço do perfil do seu Facebook.<br>
					</p></div>
					<input type="text" name="facebook" id="facebook" value="<?php echo $pessoal['facebook']; ?>" placeholder="Cole o link do seu perfil (Campo não Obrigatório)" autocomplete="off">
				</fieldset>

				<fieldset id="F_instagram">
					<label>Instagram </label>
					<div class="subtitle"> <p>Cole abaixo o endereço do perfil do seu Instagram.<br>
					</p></div>
					<input type="text" name="instagram" id="instagram" value="<?php echo $pessoal['instagram']; ?>" placeholder="Cole o link do seu perfil (Campo não Obrigatório)" autocomplete="off">
				</fieldset>
				<fieldset id="F_renda">
					<label>Renda per capita </label> <span class="red">*</span>
					<div class="subtitle"> <p>A renda per capita é a divisão da renda familiar pelo número de pessoas da família. 
					<br>P.ex. Se a renda da família é de 2.000,00 e são 4 pessoas na família, a renda per capita é (2.000/4 = 500,00).</p></div>
					<input type="text" name="rendaPercapita" id="rendaPercapita" value="<?php echo $pessoal['rendaPercapita']; ?>" placeholder="Digite sua Renda per capita" autocomplete="off">
				</fieldset>
				<fieldset id="F_assinatura">
					<label>Assinaturas do termo </label> <span class="red">*</span>
					<div class="subtitle"> <p>Data da assinatura do termo no ano atual.</p></div>
					<input type="date" name="assinatura" id="assinatura" value="<?php echo date('Y-m-d', strtotime($bolsista['registroAssTermo'])); ?>" placeholder="Digite a data da assinatura do termo" autocomplete="off">
				</fieldset>
				<div id="clear"></div>
			
			</div>
			<div class="title"> <h2>Dados Acadêmicos</h2> </div>
			<div id="central" style="">
				
				<fieldset id="F_curso">
					<label>Curso na UFC </label> <span class="red">*</span>
					<div class="subtitle"> </div>
						<?php 
			        $cursos = DBread('cursos_ufc', "WHERE status = true");
			       ?>
			       <select name="curso" id="curso">
			          <option value="" selected="">Escolha o seu curso...</option>
			       <?php
			          for ($i=0; $i < count($cursos); $i++) { 
			       ?>
			         <option <?php echo printSelect($bolsista['curso'], nomeM($cursos[$i]['curso'])); ?> value="<?php echo nomeM($cursos[$i]['curso']); ?>"><?php echo nomeM($cursos[$i]['curso']); ?></option>
			         <?php }?>
			       </select>
				</fieldset>

				<fieldset id="F_turno">
					<label>Turno </label> <span class="red">*</span>
					<div class="subtitle"> </div>
					<select name="turno" id="turno">
						<option value="">Escolha seu turno...</option>
						<option <?php echo (($acad['turno'] == 'Manhã') ? 'selected=""' : '') ?> value="Manhã">Manhã</option>
				        <option <?php echo (($acad['turno'] == 'Tarde') ? 'selected=""' : '') ?> value="Tarde">Tarde</option>
				        <option <?php echo (($acad['turno'] == 'Noite') ? 'selected=""' : '') ?> value="Noite">Noite</option>
				        <option <?php echo (($acad['turno'] == 'Manhã - Tarde') ? 'selected=""' : '') ?> value="Manhã - Tarde">Manhã - Tarde</option>
				        <option <?php echo (($acad['turno'] == 'Tarde - Noite') ? 'selected=""' : '') ?> value="Tarde - Noite">Tarde - Noite</option>
				        <option <?php echo (($acad['turno'] == 'Integral') ? 'selected=""' : '') ?> value="Integral">Integral</option>
					</select>
				</fieldset>

				<fieldset id="F_semestreEntrada">
					<label>Semestre de Ingresso</label> <span class="red">*</span>
					<div class="subtitle"></div>
					<select name="semestreEntrada" id="semestreEntrada">
						<option value="">Escolha seu semestre de ingresso...</option>
						<?php
				          $range = 8; 
				          for ($i=0; $i < $range; $i++) { 
				            $ano = date('Y') - $range;
				            echo '<option '.(($acad['semestreEntrada'] == ($ano+$i+1).'.1') ? 'selected=""' : '').' value="'.($ano+$i+1).'.1">'.($ano+$i+1).'.1</option>';
				            echo '<option '.(($acad['semestreEntrada'] == ($ano+$i+1).'.2') ? 'selected=""' : '').' value="'.($ano+$i+1).'.2">'.($ano+$i+1).'.2</option>';
				          }
				        ?>
					</select>
				</fieldset>

				<fieldset id="F_campus">
					<label>Campus </label> <span class="red">*</span>
					<div class="subtitle"> </div>
					<select name="campus" id="campus">
						<option value="">Escolha seu campus...</option>
						<option <?php echo printSelect($bolsista['campus'], 'Benfica'); ?> value="Benfica">Benfica</option>
						<option <?php echo printSelect($bolsista['campus'], 'Crateús'); ?> value="Crateús">Crateús</option>
						<option <?php echo printSelect($bolsista['campus'], 'LABOMAR'); ?> value="LABOMAR">LABOMAR</option>
						<option <?php echo printSelect($bolsista['campus'], 'PICI'); ?> value="PICI">PICI</option>
						<option <?php echo printSelect($bolsista['campus'], 'Porangabuçu'); ?> value="Porangabuçu">Porangabuçu</option>
						<option <?php echo printSelect($bolsista['campus'], 'Quixadá'); ?> value="Quixadá">Quixadá</option>
						<option <?php echo printSelect($bolsista['campus'], 'Russas'); ?> value="Russas">Russas</option>
						<option <?php echo printSelect($bolsista['campus'], 'Sobral'); ?> value="Sobral">Sobral</option>
						<option <?php echo printSelect($bolsista['campus'], 'Outro'); ?> value="Outro">Outro</option>
					</select>
				</fieldset>

				<fieldset id="F_centro">
					<label>Centro </label> <span class="red">*</span>
					<div class="subtitle"> </div>
					<select name="centro" id="centro">
						<option value="">Escolha seu campus...</option>
						<option <?php echo printSelect($acad['centro'], 'Centro de Ciências'); ?> value="Centro de Ciências">Centro de Ciências</option>
						<option <?php echo printSelect($acad['centro'], 'Centro de Ciências Agrárias'); ?> value="Centro de Ciências Agrárias">Centro de Ciências Agrárias</option>
						<option <?php echo printSelect($acad['centro'], 'Centro de Humanidades'); ?> value="Centro de Humanidades">Centro de Humanidades</option>
						<option <?php echo printSelect($acad['centro'], 'Centro de Tecnologia'); ?> value="Centro de Tecnologia">Centro de Tecnologia</option>
						<option <?php echo printSelect($acad['centro'], 'Faculdade de Direito'); ?> value="Faculdade de Direito">Faculdade de Direito</option>
						<option <?php echo printSelect($acad['centro'], 'Faculdade de Economia, Administração, Atuária, Contabilidade'); ?> value="Faculdade de Economia, Administração, Atuária, Contabilidade">Faculdade de Economia, Administração, Atuária, Contabilidade</option>
						<option <?php echo printSelect($acad['centro'], 'Faculdade de Educação'); ?> value="Faculdade de Educação">Faculdade de Educação</option>
						<option <?php echo printSelect($acad['centro'], 'Faculdade de Farmácia, Odontologia e Enfermagem'); ?> value="Faculdade de Farmácia, Odontologia e Enfermagem">Faculdade de Farmácia, Odontologia e Enfermagem</option>
						<option <?php echo printSelect($acad['centro'], 'Faculdade de Medicina'); ?> value="Faculdade de Medicina">Faculdade de Medicina</option>
						<option <?php echo printSelect($acad['centro'], 'Instituto de Ciências do Mar'); ?> value="Instituto de Ciências do Mar">Instituto de Ciências do Mar</option>
						<option <?php echo printSelect($acad['centro'], 'Instituto de Cultura e Arte'); ?> value="Instituto de Cultura e Arte">Instituto de Cultura e Arte</option>
						<option <?php echo printSelect($acad['centro'], 'Instituto de Educação Física e Esportes'); ?> value="Instituto de Educação Física e Esportes">Instituto de Educação Física e Esportes</option>
						<option <?php echo printSelect($acad['centro'], 'Instituto Universidade Virtual'); ?> value="Instituto Universidade Virtual">Instituto Universidade Virtual</option>
						<option <?php echo printSelect($acad['centro'], 'Campus da UFC em Crateús'); ?> value="Campus da UFC em Crateús">Campus da UFC em Crateús</option>
						<option <?php echo printSelect($acad['centro'], 'Campus da UFC em Quixadá'); ?> value="Campus da UFC em Quixadá">Campus da UFC em Quixadá</option>
						<option <?php echo printSelect($acad['centro'], 'Campus da UFC em Russas'); ?> value="Campus da UFC em Russas">Campus da UFC em Russas</option>
						<option <?php echo printSelect($acad['centro'], 'Campus da UFC em Sobral'); ?> value="Campus da UFC em Sobral">Campus da UFC em Sobral</option>
						<option <?php echo printSelect($acad['centro'], 'Outro'); ?> value="Outro">Outro</option>
					</select>
				</fieldset>

				<fieldset id="F_matricula">
					<label>Matrícula </label> <span class="red">*</span>
					<div class="subtitle"> 
					</div>
					<input type="text" name="matricula" id="matricula" value="<?php echo $bolsista['matricula']; ?>" placeholder="Digite sua matrícula" autocomplete="off">
				</fieldset>
						<div id="clear"></div>
			</div>

			<center>
				<input type="submit" name="enviar" value="Salvar">
			</center>
			<!-- PARTE QUE APENAS OS CEO'S PODEM VER, DADOS BANCÁRIOS -->
			<?php 
			if ($user['tipoSlug'] == 'ceo') {
				?>
				<div class="title"><h2>Dados Bancários</h2></div>
			<div id="central">
				<fieldset id="F_banco">
					<label>Banco</label> <span class="red">*</span>
					<div class="subtitle"></div>
					<select name="banco" id="banco">
						<option value="">Escolha seu banco...</option>
						<option <?php echo (($bank['banco'] == 'BB') ? 'selected=""' : '') ?> value="BB">Banco do Brasil</option>
				        <option <?php echo (($bank['banco'] == 'Bradesco') ? 'selected=""' : '') ?> value="Bradesco">Bradesco</option>
				        <option <?php echo (($bank['banco'] == 'Caixa') ? 'selected=""' : '') ?> value="Caixa">Caixa</option>
				        <option <?php echo (($bank['banco'] == 'Itaú') ? 'selected=""' : '') ?> value="Itaú">Itaú</option>
				        <option <?php echo (($bank['banco'] == 'Santander') ? 'selected=""' : '') ?> value="Santander">Santander</option>
				        <option <?php echo (($bank['banco'] == 'Banco Inter') ? 'selected=""' : '') ?> value="Banco Inter">Banco Inter</option>
					</select>
				</fieldset>

				<fieldset id="F_agencia">
					<label>Agência</label> <span class="red">*</span>
					<div class="subtitle"></div>
					<input type="text" name="agencia" id="agencia" value="<?php echo $bank['agencia']; ?>" placeholder="Digite sua agência" autocomplete="off">
				</fieldset>

				<fieldset id="F_conta">
					<label>Conta</label> <span class="red">*</span>
					<div class="subtitle"></div>
					<input type="text" name="conta" id="conta" value="<?php echo $bank['conta']; ?>" placeholder="Digite sua conta" autocomplete="off">
				</fieldset>

				<fieldset id="F_operacao">
					<label>Operação</label> <span class="red">*</span>
					<div class="subtitle"></div>
					<?php 
						if ($bank['operacao'] == '') {
						?>
						<input type="text" name="operacao" id="operacao" disabled value="<?php echo $bank['operacao']; ?>" placeholder="A conta não exige operação" autocomplete="off">
						<?php
						} else {
						?>
						<input type="text" name="operacao" id="operacao" value="<?php echo $bank['operacao']; ?>" placeholder="Digite sua operação" autocomplete="off">
						<?php
						}
					?>
				</fieldset>
			</div>
				<?php
			}
			?>
			

			
		</form>
	</div>

<?php
	}
} 
?>
