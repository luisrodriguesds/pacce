<?php 
	$bolsista = DBread('bolsistas', "WHERE  npacce = '".$user['npacce']."' OR cpf = '".$user['cpf']."'");
	$bolsista = $bolsista[0];
	$pessoal = DBread('dados_pessoais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
	$pessoal = $pessoal[0];
	$acad 	 = DBread('dados_academicos', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
	$acad 	 = $acad[0];
	$add	 = DBread('dados_add', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
	$add 	 = $add[0];
	$memorial = DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
	$memorial = $memorial[0];

	if (isset($_POST['enviar'])) {
		?>
		<script type="text/javascript">
			$(function(){
				$('fieldset').css({border:'0px'});
			});
		</script>
		<?php


		//DADOS PESSOAIS
		//$form['nome'] 				= GetPost('nome');
		$form['dataNasc'] 			= GetPost('dataNasc');
		//se não estiver vazio
		if ($form['dataNasc'] !== '') {
			$dataNasc 					= explode('/', $form['dataNasc']);
			$form['dataNasc']			= $dataNasc[2].'-'.$dataNasc[1].'-'.$dataNasc[0].' 00:00:00';
		}
		
			
		//$form['sexo'] 					= GetPost('sexo');
		//$form['cpf'] 					= GetPost('cpf');
		//$form['rg'] 					= GetPost('rg');
		
		//$form['registroEntrada']		= date('Y-d-m H:i:s');
		//$form['situacao']				= 0;
		//$form['status']					= 1;
		//$form['cadastro']				= 0;
		//$form['tipo']					= 'Candidato';
		//$form['tipoSlug']				= 'candidato';
		//$form['foto']					= 'padrao.png';
		$form['nomeUsual']				= GetPost('nomeUsual');

		$pessoal['cpf']					= $bolsista['cpf'];
		$pessoal['endereco'] 			= GetPost('endereco');
		$pessoal['bairro'] 				= GetPost('bairro');
		$pessoal['cidadeEstado'] 		= GetPost('cidadeEstado');
		$pessoal['naturalidade']		= GetPost('naturalidade');
		$pessoal['cep'] 				= GetPost('cep');
		$pessoal['fone'] 				= GetPost('fone');
		$pessoal['fone2'] 				= GetPost('fone2');
		$pessoal['fone3'] 				= GetPost('fone3');
		$pessoal['rendaPercapita']		= GetPost('rendaPercapita');

		$form['email'] 					= GetPost('email');
		$pessoal['facebook'] 			= GetPost('facebook');
		$pessoal['instagram'] 			= GetPost('instagram');
		
		$pessoal['registro']			= date('Y-m-d H:i:s');
		$pessoal['status']				= 1;

		//DADOS ACADÊMICOS
		//$form['curso'] 			= GetPost('curso');
		$acad['cpf']				= $bolsista['cpf'];
		$acad['turno'] 				= GetPost('turno');
		$acad['semestre'] 			= GetPost('semestre');
		$acad['semestreEntrada']	= GetPost('semestreEntrada');
		
		$form['campus'] 			= GetPost('campus');
		$form['campusSlug'] 		= Slug($form['campus']);
		
		$acad['centro'] 			= GetPost('centro');
		
		//$form['matricula'] 			= GetPost('matricula');
		
		$acad['registro']			= date('Y-m-d H:i:s');
		$acad['status']				= 1;

		//Interesses e Qualificações
		$add['cpf']					= $bolsista['cpf'];
		$add['autonomia'] 			= GetPost('autonomia');
		$add['grupoDeEstudo'] 		= GetPost('grupoDeEstudo');
		$add['tempoNaUFC'] 			= GetPost('tempoNaUFC');
		$add['outraGraduacao'] 		= GetPost('outraGraduacao');
		$add['mudeiDeCurso'] 		= GetPost('mudeiDeCurso');
		$add['satisfeito'] 			= GetPost('satisfeito');
		$add['cursoLingua'] 		= GetPost('cursoLingua');
		$add['softEditordeTexto'] 	= GetPost('softEditordeTexto');
		$add['softPlanilha'] 		= GetPost('softPlanilha');
		$add['softBD'] 				= GetPost('softBD');
		$add['softGerenteEmails'] 	= GetPost('softGerenteEmails');
		$add['softDesenho'] 		= GetPost('softDesenho');
		$add['softInternet'] 		= GetPost('softInternet');

		//Disponibilidade de Horários
		$add['disponibilidade'] 	= GetPost('disponibilidade');
		$add['periodo'] 			= GetPost('periodo'); //CHECK
		$add['turnoSabado'] 		= GetPost('turnoSabado');
		$add['atExtra'] 			= GetPost('atExtra');
		
		//Sobre suas experiências
		$add['gruposVirtuais'] 		= GetPost('gruposVirtuais');
		$add['eventosAC'] 			= GetPost('eventosAC');
		$add['soubeDoPACCE'] 		= GetPost('soubeDoPACCE'); //CHECK
		$add['jaParticipei'] 		= GetPost('jaParticipei'); //CHECK
		$add['5problemas'] 			= GetPost('5problemas');
		
		//Sobre a sua ideia de projeto de Aprendizagem para desenvolver no Programa.
		$add['ideiasDeProjeto'] 	= GetPost('ideiasDeProjeto');
		$add['colegaNoProjeto'] 	= GetPost('colegaNoProjeto');
		
		$add['registro']			= date('Y-m-d H:i:s');
		$add['status']				= 1;

		//deficiencia
		$defConf = GetPost('ConfirmaDefiencia');
		if ($defConf == '1') {
			$add['deficiencia'] = GetPost('deficiencia'); 
		}else if ($defConf === '0') {
			$add['deficiencia'] = 'Não'; 
		}else{
			$add['deficiencia'] = '';
		}

		//Memorial
		$memorial['cpf']			= $bolsista['cpf'];
		$memorial['memorial'] 		= GetPost('memorial');
		$memorial['registro']		= date('Y-m-d H:i:s');
		$memorial['status']			= 1;

		$valorMemorial 				= GetPost('valorMemorial');
		$check['usoDomemorial'] 	= GetPost('usoDomemorial');
		
		//==========//CHECK ========================================================================================
		$jaParticipei 				= '';
		for ($i=0; $i < count($add['jaParticipei']); $i++) { 
			if ($jaParticipei == '') {
				$jaParticipei = $jaParticipei.$add['jaParticipei'][$i];
			}else{
				$jaParticipei = $jaParticipei.';  '.$add['jaParticipei'][$i];
			}
			if ($i+1 == count($add['jaParticipei'])) {
				$jaParticipei = $jaParticipei.';';
			}
		}
		$add['jaParticipei'] = $jaParticipei;
//==========//CHECK =========================================================================================
			$soubeDoPACCE = '';
			for ($i=0; $i < count($add['soubeDoPACCE']); $i++) { 
				if ($soubeDoPACCE == '') {
					$soubeDoPACCE = $soubeDoPACCE.$add['soubeDoPACCE'][$i];
				}else{
					$soubeDoPACCE = $soubeDoPACCE.';  '.$add['soubeDoPACCE'][$i];
				}
				if ($i+1 == count($add['soubeDoPACCE'])) {
					$soubeDoPACCE = $soubeDoPACCE.';';
				}
			}
			$add['soubeDoPACCE'] = $soubeDoPACCE;

//==========CHECK==============================================================================================
			$periodo = '';
			for ($i=0; $i < count($add['periodo']); $i++) { 
				if ($periodo == '') {
					$periodo = $periodo.$add['periodo'][$i];
				}else{
					$periodo = $periodo.';  '.$add['periodo'][$i];
				}
				if ($i+1 == count($add['periodo'])) {
					$periodo = $periodo.';';
				}
			}
			$add['periodo'] = $periodo;

		//SISTEMA
		//$form['password'] 			= md5(GetPost('password'));
		//$check['rePassword'] 		= md5(GetPost('rePassword'));

		//$check['historico'] 		= GetPost('historico');
		//$check['lidoEdital'] 		= GetPost('lidoEdital');

		//validando
		if (empty($pessoal['endereco'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_endereco").css({border:"1px solid red"});
						var top = $("#F_endereco").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($pessoal['bairro'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_bairro").css({border:"1px solid red"});
						var top = $("#F_bairro").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($pessoal['cidadeEstado'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_cidadeEstado").css({border:"1px solid red"});
						var top = $("#F_cidadeEstado").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($pessoal['naturalidade'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_naturalidade").css({border:"1px solid red"});
						var top = $("#F_naturalidade").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($pessoal['cep'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_cep").css({border:"1px solid red"});
						var top = $("#F_cep").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($pessoal['fone'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_fone").css({border:"1px solid red"});
						var top = $("#F_fone").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($pessoal['fone2'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_fone2").css({border:"1px solid red"});
						var top = $("#F_fone2").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($pessoal['fone3'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_fone3").css({border:"1px solid red"});
						var top = $("#F_fone3").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if ($pessoal['fone'] == $pessoal['fone2'] || $pessoal['fone'] == $pessoal['fone3']) {
			echo '<script type="text/javascript">
					alert("Existem contatos repetidos");
					$(function(){
						$("#F_fone2").css({border:"1px solid red"});
						var top = $("#F_fone2").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if ($pessoal['fone2'] == $pessoal['fone3']) {
			echo '<script type="text/javascript">
					alert("Existem contatos repetidos");
					$(function(){
						$("#F_fone3").css({border:"1px solid red"});
						var top = $("#F_fone3").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($form['email'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_email").css({border:"1px solid red"});
						var top = $("#F_email").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($pessoal['rendaPercapita'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_renda").css({border:"1px solid red"});
						var top = $("#F_renda").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($acad['turno'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_turno").css({border:"1px solid red"});
						var top = $("#F_turno").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($acad['semestre'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_semestre").css({border:"1px solid red"});
						var top = $("#F_semestre").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($acad['semestreEntrada'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_semestreEntrada").css({border:"1px solid red"});
						var top = $("#F_semestreEntrada").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($form['campus'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_campus").css({border:"1px solid red"});
						var top = $("#F_campus").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($acad['centro'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_centro").css({border:"1px solid red"});
						var top = $("#F_centro").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['autonomia'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_autonomia").css({border:"1px solid red"});
						var top = $("#F_autonomia").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['grupoDeEstudo'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_grupoDeEstudo").css({border:"1px solid red"});
						var top = $("#F_grupoDeEstudo").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['tempoNaUFC'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_tempoNaUFC").css({border:"1px solid red"});
						var top = $("#F_tempoNaUFC").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['outraGraduacao'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_outraGraduacao").css({border:"1px solid red"});
						var top = $("#F_outraGraduacao").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['mudeiDeCurso'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_mudeiDeCurso").css({border:"1px solid red"});
						var top = $("#F_mudeiDeCurso").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['satisfeito'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_satisfeito").css({border:"1px solid red"});
						var top = $("#F_satisfeito").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['cursoLingua'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_cursoLingua").css({border:"1px solid red"});
						var top = $("#F_cursoLingua").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['softEditordeTexto'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_soft").css({border:"1px solid red"});
						var top = $("#F_soft").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['softPlanilha'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_soft").css({border:"1px solid red"});
						var top = $("#F_soft").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['softBD'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_soft").css({border:"1px solid red"});
						var top = $("#F_soft").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['softGerenteEmails'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_soft").css({border:"1px solid red"});
						var top = $("#F_soft").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['softDesenho'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_soft").css({border:"1px solid red"});
						var top = $("#F_soft").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['softInternet'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_soft").css({border:"1px solid red"});
						var top = $("#F_soft").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['disponibilidade'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_disponibilidade").css({border:"1px solid red"});
						var top = $("#F_disponibilidade").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['periodo'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_periodo").css({border:"1px solid red"});
						var top = $("#F_periodo").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['turnoSabado'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_turnoSabado").css({border:"1px solid red"});
						var top = $("#F_turnoSabado").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['soubeDoPACCE'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_soubeDoPACCE").css({border:"1px solid red"});
						var top = $("#F_soubeDoPACCE").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($add['ideiasDeProjeto']) || strlen($add['ideiasDeProjeto']) < 10) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_ideiasDeProjeto").css({border:"1px solid red"});
						var top = $("#F_ideiasDeProjeto").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if (empty($memorial['memorial'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_memorial").css({border:"1px solid red"});
						var top = $("#F_memorial").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else if ( $valorMemorial < 5000) {
			echo '<script type="text/javascript">
				alert("Campo Memorial está com '.$valorMemorial.' de no mínumo 5000 caracteres, para prosseguir você precisa atingir esse total.");
					$(function(){
						$("#F_memorial").css({border:"1px solid red"});
						var top = $("#F_memorial").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
				
		}else if (empty($check['usoDomemorial'])) {
			echo '<script type="text/javascript">
					$(function(){
						$("#F_usoDomemorial").css({border:"1px solid red"});
						var top = $("#F_usoDomemorial").offset().top;
						$("html,body").animate({scrollTop: top-40}, 1000);
					});
				</script>';
		}else{
			
			//INSERIR NO BANCO
			$form['npacce'] 	= $bolsista['npacce'];
			$acad['npacce'] 	= $bolsista['npacce'];
			$add['npacce'] 		= $bolsista['npacce'];
			$pessoal['npacce'] 	= $bolsista['npacce'];
			$memorial['npacce'] = $bolsista['npacce'];

			//ac_bolsistas
			if (DBUpDate('bolsistas', $form, "npacce = '".$bolsista['npacce']."'")) {
				//Verifica
				if (DBread('dados_academicos', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
					//Atualiza
					if (DBUpDate('dados_academicos', $acad, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
						//verifica
						if (DBread('dados_pessoais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
							//Atualiza
							if (DBUpDate('dados_pessoais', $pessoal, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
								//Verifica
								if (DBread('dados_add', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
									//Atualiza
									if (DBUpDate('dados_add', $add, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
										//vefica
										if (DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
											//Atualiza
											if (DBUpDate('memoriais', $memorial, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}else{
											//Cria
											if (DBcreate('memoriais', $memorial)) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}
									}
								}else{
									//Cria
									if (DBcreate('dados_add', $add)) {
										//Verifica
										if (DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
											//Atualiza
											if (DBUpDate('memoriais', $memorial, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}else{
											//Cria
											if (DBcreate('memoriais', $memorial)) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}
									}
								}
							}
						}else{
							//cria
							if (DBcreate('dados_pessoais', $pessoal)) {
								//Verifica
								if (DBread('dados_add', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
									//Atualiza
									if (DBUpDate('dados_add', $add, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
										//Verifica
										if (DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
											//Atualiza
											if (DBUpDate('memoriais', $memorial, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}else{
											//Cria
											if (DBcreate('memoriais', $memorial)) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}
									}
								}else{
									//Cria
									if (DBcreate('dados_add', $add)) {
										//Verifica
										if (DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
											//Atualiza
											if (DBUpDate('memoriais', $memorial, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}else{
											//Cria
											if (DBcreate('memoriais', $memorial)) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}
									}
								}
							}
						}
					}
				}else{
					//Cria
					if (DBcreate('dados_academicos', $acad)) {
						//Verifica
						if (DBread('dados_pessoais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
							//Atualiza
							if (DBUpDate('dados_pessoais', $pessoal, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
								//Verifica
								if (DBread('dados_add', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
									//Atualiza
									if (DBUpDate('dados_add', $add, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
										//Verifica
										if (DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
											//Atualiza
											if (DBUpDate('memoriais', $memorial, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}else{
											//Cria
											if (DBcreate('memoriais', $memorial)) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}
									}
								}else{
									//Cria
									if (DBcreate('dados_add', $add)) {
										//Verifica
										if (DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
											//Atualiza
											if (DBUpDate('memoriais', $memorial, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}else{
											//Cria 
											if (DBcreate('memoriais', $memorial)) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}
									}
								}
							}
						}else{
							//Cria
							if (DBcreate('dados_pessoais', $pessoal)) {
								//Verifica
								if (DBread('dados_add', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
									//Atualiza
									if (DBUpDate('dados_add', $add, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
										//Verifica
										if (DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
											//Atualiza
											if (DBUpDate('memoriais', $memorial, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}else{
											//Cria
											if (DBcreate('memoriais', $memorial)) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}
									}
								}else{
									//Cria
									if (DBcreate('dados_add', $add)) {
										//Verifica
										if (DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
											//Atualiza
											if (DBUpDate('memoriais', $memorial, "npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'")) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}else{
											//Cria
											if (DBcreate('memoriais', $memorial)) {
												echo '
													<script> 
														alert("Dados Salvos com Sucesso!!");
														window.location="'.$way.'";
													</script>
												';
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

	}
?>
<style type="text/css">
.red{ color: red; }
.op{ font-size: 14px; color: #000; line-height: 20px; position: relative; top: -4px; }
.form{ margin-top: 30px; }

.form img { width:100%; max-width:100%; }
.form form { width:100%; display:table;}
.form form fieldset{ border: 0px; margin-top: 15px; margin-bottom: 20px; margin-right: 30px; padding: 5px; width: 40%; float: left; }
.form form label{ font-size: 18px; color: #4A85A0; 
	font-family:Arial, Helvetica, sans-serif; font-weight: 600; 
}

.form form input[type=text], .form form input[type=password], .form form input[type=email], .form form input[type=number], .form form input[type=date], .form form input[type=time] { 
	width:98%; 
	height:30px; height:30px; 
	padding:0 5px; 
	border-top: 0px; 
	border-left: 0px; border-right: 0px; 
	border-bottom:1.5px #a2a2a2 solid;  
	margin:10px 0;
	-webkit-transition: all ease-in-out .7s; 
	-moz-transition: all ease-in-out .7s; 
	transition: all ease-in-out .7s;
}

.form form input[type=color]{
	width:20%; 
	height:30px; padding:0 5px; 
	border:1px #a2a2a2 solid; 
	border-radius:2px; 
	margin:5px 0;
}

.form form input[type=radio]{ 
	margin-top: 15px; 
	margin-right: 0px; 
	height: 20px; 
	width: 20px; 
	background: #069;
    border-radius: 100%;
    cursor: pointer;
    display: inline-block;
    position: relative;
    -webkit-appearance: none;

    box-shadow: inset 0 1px 1px hsla(0,0%,100%,.8),
                0 1px 2px hsla(0,0%,0%,.4),
                0 1px 6px hsla(0,0%,0%,.2),
                0 1px 6px hsla(0,0%,0%,.2);
}
.form form input[type=radio]:disabled{
	background: #738a96;
}
.form form input[type=radio]:disabled:checked:after{
	background: #3e3e3e;
}
.form form input[type=radio]:after{
	background-color: #545454;
    border-radius: 100%;
    box-shadow: 0 0 0 1px hsla(0,0%,0%,.4), 0 1px 1px hsla(0,0%,100%,.8);
    content: '';
    display: block;
    height: 7px;
    width: 7px;
    left: 6px;
    top: 7px;
    position: relative;
}
.form form input[type=radio]:checked:after{
	background-color: #2197d2;
    box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.4),
                inset 0 2px 2px hsla(0,0%,100%,.4),
                0 1px 1px hsla(0,0%,100%,.8),
                0 0 2px 2px hsla(0,70%,70%,.4);
    

}
.form form select { 
	margin-top:10px;  
	margin-right:5px; 
	padding: 5px 5px; 
	width: 90%;
	border-top: 0px;
	border-right: 0px;
	border-left: 0px;
	border-bottom:1px solid #a2a2a2;
	transition: all 0.7s;
	font-size: 15px;
    color: #000;

}
.form form select:focus, .form form select:hover{
	border-bottom:1px solid #069;
}
.form form select:disabled{
	background: #ebebe4;
}
.form form input[type=checkbox] { 
	margin-right: 5px; 
	height: 20px; 
	width: 20px; 
	background: #069;
    border-radius: 5px;
    cursor: pointer;
    display: inline-block;
    position: relative;
    -webkit-appearance: none;

    box-shadow: inset 0 1px 1px hsla(0,0%,100%,.8),
                0 1px 2px hsla(0,0%,0%,.4),
                0 1px 6px hsla(0,0%,0%,.2),
                0 1px 6px hsla(0,0%,0%,.2);

} 
.form form input[type=checkbox]:after { 
	background-color: #545454;
    border-radius: 1px;
    box-shadow: 0 0 0 1px hsla(0,0%,0%,.4), 0 1px 1px hsla(0,0%,100%,.8);
    content: '';
    display: block;
    height: 7px;
    width: 7px;
    left: 6px;
    top: 7px;
    position: relative;

} 
.form form input[type=checkbox]:checked:after{ 
	background-color: #2197d2;
    box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.4),
                inset 0 2px 2px hsla(0,0%,100%,.4),
                0 1px 1px hsla(0,0%,100%,.8),
                0 0 2px 2px hsla(0,70%,70%,.4);	

} 
.form form input[type=submit] { 
	background:#069; 
	width: 150px; 
	height:30px;
	 padding:0 10px; 
	 border:none; 
	 border-radius:2px; 
	 color:#FFF; 
	 cursor:pointer; 
	 margin:5px 0; 
	 text-decoration: none; 
	 -webkit-transition: all ease-in-out .7s; 
	 -moz-transition: all ease-in-out .7s;
	  transition: all ease-in-out .7s; 
}
.form form input[type=submit]:hover{ 
	background-color: #003E5D; 
} 

.form form input[type=text]:hover, .form form input[type=password]:hover, .form form input[type=number]:hover, .form input[type=email]:hover{
	border-top: 0px; border-left: 0px; border-right: 0px; border-bottom:1.5px #069 solid; } 
.form form input[type=text]:focus, .form form input[type=password]:focus, .form form input[type=email]:focus, .form form input[type=number]:focus, .form form input[type=date]:focus, .form form input[type=time]:focus{
	border-top: 0px; border-left: 0px; border-right: 0px; border-bottom:1.5px #069 solid;
}

.form form textarea{
	resize:none;
	width:97%; 
	padding:5px 5px; 
	border-right: 0px;
	border-top: 0px;
	border-left: 0px;
	border-bottom:1px #a2a2a2 solid;
	margin:5px 0; 
	height: 30px;
	transition: all 1s;
}

.form form textarea:focus, .form form textarea:hover{ 
	border-bottom:1px #069 solid; 
}

.form table{
	margin-top: 30px;
	border-collapse: collapse;
	width: 100%;
}

.form table tr{
	text-align: center;
	padding-bottom: 20px;
	border-bottom: 1px solid #a2a2a2;
}
.form table td{
	text-align: center;	
    padding-bottom: 20px;
    border-bottom: 1px solid #a2a2a2;
}
#central{ margin: 0 auto; width: 90%; }
</style>
<script type="text/javascript">
	$(function(){
		$('#rendaPercapita').mask('000.000.000.000.000,00', {reverse: true});

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

    	$('#cep').mask("99999-999");
        $('#fone').mask("(99)99999-9999");
        $('#fone2').mask("(99)99999-9999");
        $('#fone3').mask("(99)99999-9999");
	});

</script>
<div class="title"><h2>Editar Conta</h2></div>
<p>Página destinada à atualizações de seus dados pessoais entre outros.</p>
<br>
<div id="editar_conta">
	<div class="form">
		<form method="post">
		<div class="title"> <h2>Dados PACCE</h2> </div>
		<div id="central">
		<fieldset id="F_npacce" style="margin-bottom: 0;">
			<label>Número PACCE </label> 
			<div class="subtitle"> </div>
			<input type="text" name="npacce" id="npacce" placeholder="Digite seu Número PACCE" value="<?php echo $bolsista['npacce']; ?>" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" disabled="disabled">
		</fieldset>
		<fieldset id="F_tipo">
				<label>Função </label>
				<div class="subtitle"> </div>
					<?php 
		        $comissoes = DBread('comissoes', "WHERE status = true");
		       ?>
		       <select name="comissao" id="comissao" disabled="disabled">
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
			if ($bolsista['tipoSlug'] == 'articulador-de-celula') {
				?>
				<fieldset id="F_apo" style="margin-top: 0;">
					<label>Apoio à Célula</label>
					<div class="subtitle"> </div>
					<select id="apo" name="apo" disabled="disabled">
						<option value="0">Nada encontrado...</option>
						<?php 
							
						?>
					</select>
				</fieldset>
				<?php
			}
		?>
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
			if ($bolsista['tipoSlug'] == 'articulador-de-celula') {
				?>
			<fieldset id="F_for" style="margin-top: 0;">
				<label>Formação</label>
				<div class="subtitle"> </div>
				<select id="for" name="for" disabled="disabled">
					<option value="0">Nada encontrado...</option>
					<?php 
						
					?>
				</select>
			</fieldset>
			<fieldset id="F_rod" style="margin-top: 0;">
				<label>História de Vida</label>
				<div class="subtitle"> </div>
				<select id="for" name="for" disabled="disabled">
					<option value="0">Nada encontrado...</option>
					<?php 
						
					?>
				</select>
			</fieldset>
				<?php
			}
		?>

		<div id="clear"></div>
		</div>
		<br><br>
			<div class="title"> <h2>Dados Pessoais</h2> </div>
		<div id="central" style="">
		<fieldset id="F_nome">
			<label>Nome Completo </label>
			<div class="subtitle"> </div>
			<input type="text" name="nome" id="nome" placeholder="Digite seu nome" value="<?php echo $bolsista['nome']; ?>" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" disabled="disabled">
		</fieldset>

		<fieldset id="F_dataNasc">
			<label>Data de Nascimento </label>
			<div class="subtitle"> <p> </p> </div>
			<input type="text" name="dataNasc" id="dataNasc" value="<?php echo date('d/m/Y', strtotime($bolsista['dataNasc'])); ?>" placeholder="Digite a data do seu nascimento" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)">
		</fieldset>

		<fieldset id="F_sexo">
			<label>Sexo </label> 
			<div class="subtitle"> <p> </p> </div>
			
				<span style="margin-right: 30px;"><input type="radio" name="sexo" id="sexo" value="1" disabled="disabled" <?php echo printRadio($bolsista['sexo'], '1'); ?>> <span class="op">  Masculino 	</span> </span>
		
				<input type="radio" name="sexo" id="sexo" value="0" disabled="disabled" <?php echo printRadio($bolsista['sexo'], '0'); ?>> <span class="op"> Feminino </span>
		</fieldset>

		<fieldset id="F_cpf">
			<label>CPF </label> 
			<div class="subtitle"></div>
			<input type="text" name="cpf" id="cpf" value="<?php echo $bolsista['cpf']; ?>" placeholder="Digite seu CPF" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" disabled="disabled">
			<span id="checkCPF"> </span>
		</fieldset>
		
				<fieldset id="F_rg">
			<label>RG </label> 
			<div class="subtitle"> </div>
			<input type="text" name="rg" id="rg" placeholder="Digite seu RG" value="<?php echo $bolsista['rg']; ?>" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" disabled="disabled">
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
		<div id="clear"></div>
		</div>

		<br><br>
		<div class="title"> <h2>Dados Acadêmicos</h2> </div>
		<div id="central" style="">
			
			<fieldset id="F_curso">
				<label>Curso na UFC </label> <span class="red">*</span>
				<div class="subtitle"> </div>
					<?php 
		        $cursos = DBread('cursos_ufc', "WHERE status = true");
		       ?>
		       <select name="curso" id="curso" disabled="disabled">
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
					<option <?php echo printSelect($acad['turno'], 'Manhã'); ?> value="Manhã">Manhã</option>
					<option <?php echo printSelect($acad['turno'], 'Tarde'); ?> value="Tarde">Tarde</option>
					<option <?php echo printSelect($acad['turno'], 'Noite'); ?> value="Noite">Noite</option>
					<option <?php echo printSelect($acad['turno'], 'Interal'); ?>  value="Interal">Interal</option>
				</select>
			</fieldset>

			<fieldset id="F_semestre">
				<label>Semestre Atual</label> <span class="red">*</span>
				<div class="subtitle"> </div>
				<select name="semestre" id="semestre">
					<option value="">Escolha seu semestre...</option>
					<?php 
						for ($i=1; $i <= 10 ; $i++) { 
							echo '<option '.printSelect($acad['semestre'], $i).' value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</fieldset>

			<fieldset id="F_semestreEntrada">
				<label>Semestre de Ingresso</label> <span class="red">*</span>
				<div class="subtitle"></div>
				<select name="semestreEntrada" id="semestreEntrada">
					<option value="">Escolha seu semestre de ingresso...</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2010.1'); ?> value="2010.1">2010.1</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2010.2'); ?> value="2010.2">2010.2</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2011.1'); ?> value="2011.1">2011.1</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2011.2'); ?> value="2011.2">2011.2</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2012.1'); ?> value="2012.1">2012.1</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2012.2'); ?> value="2012.2">2012.2</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2013.1'); ?> value="2013.1">2013.1</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2013.2'); ?> value="2013.2">2013.2</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2014.1'); ?> value="2014.1">2014.1</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2014.2'); ?> value="2014.2">2014.2</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2015.1'); ?> value="2015.1">2015.1</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2015.2'); ?> value="2015.2">2015.2</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2016.1'); ?> value="2016.1">2016.1</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2016.2'); ?> value="2016.2">2016.2</option>
					<option <?php echo printSelect($acad['semestreEntrada'], '2017.1'); ?> value="2017.1">2017.1</option>
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
				<input type="text" name="matricula" id="matricula" value="<?php echo $bolsista['matricula']; ?>" placeholder="Digite sua matrícula" disabled="disabled" autocomplete="off">
			</fieldset>
					<div id="clear"></div>
		</div>
		<br><br>
		<div class="title"> <h2>Interesses e Qualificações</h2> </div>
			<div id="central" style="">
				<fieldset id="F_autonomia">
					<label>Autonomia </label> <span class="red">*</span>
					<div class="subtitle"> <p> Tenho interesse em desenvolver minha autonomia intelectual, aprender a planejar e executar projetos de aprendizagem.</p> </div>
					<table>
						<tr>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
						</tr>
						<tr>
							<td>
								<input type="radio" <?php echo printRadio($add['autonomia'], '1'); ?> name="autonomia" id="autonomia" value="1">
							</td>

							<td>
								<input type="radio" <?php echo printRadio($add['autonomia'], '2'); ?> name="autonomia" id="autonomia" value="2">
							</td>

							<td>
								<input type="radio" <?php echo printRadio($add['autonomia'], '3'); ?> name="autonomia" id="autonomia" value="3">
							</td>

							<td>
								<input type="radio" <?php echo printRadio($add['autonomia'], '4'); ?> name="autonomia" id="autonomia" value="4">
							</td>

							<td>
								<input type="radio" <?php echo printRadio($add['autonomia'], '5'); ?> name="autonomia" id="autonomia" value="5">
							</td>
						</tr>
					</table>
				</fieldset>

			<fieldset id="F_grupoDeEstudo">
				<label>Grupo de Estudo </label> <span class="red">*</span>
				<div class="subtitle"> <p> Sinto-me capaz de montar um grupo de estudo com outros estudantes da UFC.</p> </div>
				<br>
				<table>
					<tr>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>5</th>
					</tr>
					<tr>
						<td>
							<input type="radio" <?php echo printRadio($add['grupoDeEstudo'], '1'); ?> name="grupoDeEstudo" id="grupoDeEstudo" value="1">
						</td>

						<td>
							<input type="radio" <?php echo printRadio($add['grupoDeEstudo'], '2'); ?> name="grupoDeEstudo" id="grupoDeEstudo" value="2">
						</td>

						<td>
							<input type="radio" <?php echo printRadio($add['grupoDeEstudo'], '3'); ?> name="grupoDeEstudo" id="grupoDeEstudo" value="3">
						</td>

						<td>
							<input type="radio" <?php echo printRadio($add['grupoDeEstudo'], '4'); ?> name="grupoDeEstudo" id="grupoDeEstudo" value="4">
						</td>

						<td>
							<input type="radio" <?php echo printRadio($add['grupoDeEstudo'], '5'); ?> name="grupoDeEstudo" id="grupoDeEstudo" value="5">
						</td>
					</tr>
				</table>
			</fieldset>

			<fieldset id="F_tempoNaUFC">
				<label>Tempo na UFC </label> <span class="red">*</span>
				<div class="subtitle"> <p>Ao final do semestre 2016.2, já terei cursado 75% do meu curso. </p> </div>
				
					<span style="margin-right: 30px;"><input type="radio" <?php echo printRadio($add['tempoNaUFC'], 'sim'); ?> name="tempoNaUFC" id="tempoNaUFC" value="sim"> <span class="op">  Sim 	</span> </span>
			
					<input type="radio" <?php echo printRadio($add['tempoNaUFC'], 'nao'); ?> name="tempoNaUFC" id="tempoNaUFC" value="nao"> <span class="op"> Não </span>
			</fieldset>

			<fieldset id="F_outraGraduacao">
					<label>Outra Graduação </label> <span class="red">*</span>
					<div class="subtitle"> <p>Já conclui pelo menos um curso de graduação. </p> </div>
					<br>
						<span style="margin-right: 30px;"><input type="radio" <?php echo printRadio($add['outraGraduacao'], 'sim'); ?> name="outraGraduacao" id="outraGraduacao" value="sim"> <span class="op">  Sim 	</span> </span>
				
						<input type="radio" name="outraGraduacao" id="outraGraduacao" <?php echo printRadio($add['outraGraduacao'], 'nao'); ?> value="nao"> <span class="op"> Não </span>
				</fieldset>
				<fieldset id="F_mudeiDeCurso">
					<label>Mudei de Curso </label> <span class="red">*</span>
					<div class="subtitle"> <p>Entrei na UFC para um outro curso, mas não concluí e mudei para o curso atual. </p> </div>
					
						<span style="margin-right: 30px;"><input type="radio" name="mudeiDeCurso" id="mudeiDeCurso" <?php echo printRadio($add['mudeiDeCurso'], 'sim'); ?> value="sim"> <span class="op">  Sim 	</span> </span>
				
						<input type="radio" name="mudeiDeCurso" id="mudeiDeCurso" <?php echo printRadio($add['mudeiDeCurso'], 'nao'); ?> value="nao"> <span class="op"> Não </span>
				</fieldset>

				<fieldset id="F_satisfeito">
					<label>Satisfeito  </label> <span class="red">*</span>
					<div class="subtitle"> <p>Estou satisfeito com meu curso e pretendo concluí-lo. </p> </div><br>
					
						<span style="margin-right: 30px;"><input type="radio" name="satisfeito" id="satisfeito" <?php echo printRadio($add['satisfeito'], 'sim'); ?> value="sim"> <span class="op">  Sim 	</span> </span>
				
						<input type="radio" name="satisfeito" id="satisfeito" value="nao" <?php echo printRadio($add['satisfeito'], 'nao'); ?>> <span class="op"> Não </span>
				</fieldset>
				<fieldset id="F_soft">
				<label>Sobre Software  </label> <span class="red">*</span>
				<div class="subtitle"> <p> </p> </div>
				<table>
					<tr>
						<th></th>
						<th>Nenhum</th>
						<th>Pouco</th>
						<th>Moderado</th>
						<th>Bastante</th>
					</tr>
					<tr>
						<th style="width: 20%;">Editores de Texto</th>
						<td><input type="radio" name="softEditordeTexto" id="softEditordeTexto" <?php echo printRadio($add['softEditordeTexto'], 'nenhum'); ?> value="nenhum"></td>
						<td><input type="radio" name="softEditordeTexto" id="softEditordeTexto" <?php echo printRadio($add['softEditordeTexto'], 'pouco'); ?> value="pouco"></td>
						<td><input type="radio" name="softEditordeTexto" id="softEditordeTexto" <?php echo printRadio($add['softEditordeTexto'], 'moderado'); ?> value="moderado"></td>
						<td><input type="radio" name="softEditordeTexto" id="softEditordeTexto" <?php echo printRadio($add['softEditordeTexto'], 'bastante'); ?> value="bastante"></td>
					</tr>

					<tr>
						<th style="width: 20%;">Planilhas Eletrônicas</th>
						<td><input type="radio" name="softPlanilha" id="softPlanilha" <?php echo printRadio($add['softPlanilha'], 'nenhum'); ?> value="nenhum"></td>
						<td><input type="radio" name="softPlanilha" id="softPlanilha" <?php echo printRadio($add['softPlanilha'], 'pouco'); ?> value="pouco"></td>
						<td><input type="radio" name="softPlanilha" id="softPlanilha" <?php echo printRadio($add['softPlanilha'], 'moderado'); ?> value="moderado"></td>
						<td><input type="radio" name="softPlanilha" id="softPlanilha" <?php echo printRadio($add['softPlanilha'], 'bastante'); ?> value="bastante"></td>
					</tr>

					<tr>
						<th style="width: 20%;">Banco de Dados</th>
						<td><input type="radio" name="softBD" id="softBD" <?php echo printRadio($add['softBD'], 'nenhum'); ?> value="nenhum"></td>
						<td><input type="radio" name="softBD" id="softBD" <?php echo printRadio($add['softBD'], 'pouco'); ?> value="pouco"></td>
						<td><input type="radio" name="softBD" id="softBD" <?php echo printRadio($add['softBD'], 'moderado'); ?> value="moderado"></td>
						<td><input type="radio" name="softBD" id="softBD" <?php echo printRadio($add['softBD'], 'bastante'); ?> value="bastante"></td>
					</tr>

					<tr>
						<th style="width: 20%;">Gerenciadores de Emails</th>
						<td><input type="radio" name="softGerenteEmails" id="softGerenteEmails" <?php echo printRadio($add['softGerenteEmails'], 'nenhum'); ?> value="nenhum"></td>
						<td><input type="radio" name="softGerenteEmails" id="softGerenteEmails" <?php echo printRadio($add['softGerenteEmails'], 'pouco'); ?> value="pouco"></td>
						<td><input type="radio" name="softGerenteEmails" id="softGerenteEmails" <?php echo printRadio($add['softGerenteEmails'], 'moderado'); ?>  value="moderado"></td>
						<td><input type="radio" name="softGerenteEmails" id="softGerenteEmails" <?php echo printRadio($add['softGerenteEmails'], 'bastante'); ?> value="bastante"></td>
					</tr>

					<tr>
						<th style="width: 20%;">Desenho</th>
						<td><input type="radio" name="softDesenho" id="softDesenho" <?php echo printRadio($add['softDesenho'], 'nenhum'); ?> value="nenhum"></td>
						<td><input type="radio" name="softDesenho" id="softDesenho" <?php echo printRadio($add['softDesenho'], 'pouco'); ?> value="pouco"></td>
						<td><input type="radio" name="softDesenho" id="softDesenho" <?php echo printRadio($add['softDesenho'], 'moderado'); ?> value="moderado"></td>
						<td><input type="radio" name="softDesenho" id="softDesenho" <?php echo printRadio($add['softDesenho'], 'bastante'); ?> value="bastante"></td>
					</tr>

					<tr>
						<th style="width: 20%;">Internet</th>
						<td><input type="radio" name="softInternet" id="softInternet" <?php echo printRadio($add['softInternet'], 'nenhum'); ?> value="nenhum"></td>
						<td><input type="radio" name="softInternet" id="softInternet" <?php echo printRadio($add['softInternet'], 'pouco'); ?> value="pouco"></td>
						<td><input type="radio" name="softInternet" id="softInternet" <?php echo printRadio($add['softInternet'], 'moderado'); ?> value="moderado"></td>
						<td><input type="radio" name="softInternet" id="softInternet" <?php echo printRadio($add['softInternet'], 'bastante'); ?> value="bastante"></td>
					</tr>


				</table>
			</fieldset>
			<fieldset id="F_cursoLingua">
				<label>Curso de Línguas  </label> <span class="red">*</span>
				<div class="subtitle"> <p>Faço pelo menos um curso de Línguas. </p> </div>
				
					<span style="margin-right: 30px;"><input type="radio" name="cursoLingua" id="cursoLingua" <?php echo printRadio($add['cursoLingua'], 'sim'); ?> value="sim"> <span class="op">  Sim 	</span> </span>
			
					<input type="radio" name="cursoLingua" id="cursoLingua" <?php echo printRadio($add['cursoLingua'], 'nao'); ?> value="nao"> <span class="op"> Não </span>
			</fieldset>
			<div id="clear"></div>
			</div>
			
		<br><br>
		
		<div class="title"> <h2>Disponibilidade de Horários</h2> </div>
		<div id="central" style="">
			<fieldset id="F_periodo">
				<label>Períodos Consecutivos  </label> <span class="red">*</span>
				<div class="subtitle"> <p>Possuo os seguintes períodos de 04 horas consecutivas semanais. </p> </div>
				<br>
				<?php 
				if ($add['periodo'] !== '') {
					$checkPeriodo = explode('; ', $add['periodo']);
					for ($i=0; $i < count($checkPeriodo); $i++) { 
						$checkPeriodo[$i] = str_replace(";", "", $checkPeriodo[$i]);
						$checkPeriodo[$i] = str_replace(" ", "", $checkPeriodo[$i]);
					}
				}else{
					$checkPeriodo[0] = '';
				}
					
					
				?>
				<input type="checkbox" name="periodo[]" id="periodo" <?php echo printCheckbox($checkPeriodo, '08h-12h'); ?>  value="08h-12h"> <span class="op" style="top: 3px;">  08h às 12h 	</span>
				<br><br>
				<input type="checkbox" name="periodo[]" id="periodo" <?php echo printCheckbox($checkPeriodo, '14h-18h'); ?> value="14h-18h"> <span class="op" style="top: 3px;">  14h às 18h 	</span>
				<br><br>
				<input type="checkbox" name="periodo[]" id="periodo" <?php echo printCheckbox($checkPeriodo, '18h30-22h30'); ?> value="18h30-22h30"> <span class="op" style="top: 3px;">  18h30 às 22h30 	</span>
				<br><br>
				<input type="checkbox" name="periodo[]" id="periodo" <?php echo printCheckbox($checkPeriodo, 'Não tenho nenhum'); ?> value="Não tenho nenhum"> <span class="op" style="top: 3px;">  Não tenho nenhum.	</span>
				<br><br>
				<input type="checkbox" name="periodo[]" id="periodo" <?php echo printCheckbox($checkPeriodo, 'Ainda não tenho horário definido'); ?> value="Ainda não tenho horário definido"> <span class="op" style="top: 3px;">  Ainda não tenho horário definido	</span>
			</fieldset>
			<fieldset id="F_disponibilidade">
				<label>Horários Disponíveis  </label> <span class="red">*</span>
				<div class="subtitle"> <p>Tenho disponibilidade de 12 horas semanais para me dedicar as atividades do Programa. </p> </div>
				
					<span style="margin-right: 30px;"><input type="radio" <?php echo printRadio($add['disponibilidade'], 'sim'); ?> name="disponibilidade" id="disponibilidade" value="sim"> <span class="op">  Sim 	</span> </span>
			
					<input type="radio" name="disponibilidade" id="disponibilidade" <?php echo printRadio($add['disponibilidade'], 'nao'); ?> value="nao"> <span class="op"> Não </span>
			</fieldset>
			<fieldset id="F_turnoSabado" style="margin-bottom: 30px;">
				<label>Turno Sábado  </label> <span class="red">*</span>
				<div class="subtitle"> <p>Tenho um turno no sábado, de 08h às 12h, disponível para participar de atividades de formação do Programa. </p> </div>
				
					<span style="margin-right: 30px;"><input type="radio" name="turnoSabado" id="turnoSabado" <?php echo printRadio($add['turnoSabado'], 'sim'); ?> value="sim"> <span class="op">  Sim 	</span> </span>
			
					<input type="radio" name="turnoSabado" id="turnoSabado" <?php echo printRadio($add['turnoSabado'], 'nao'); ?> value="nao"> <span class="op"> Não </span>
			</fieldset>
			<fieldset id="F_atExtra">
				<label>Atividades Extra Acadêmicas  </label> 
				<div class="subtitle"> <p>Sobre suas atividades extra acadêmicas. Use o espaço abaixo para listar as atividades que não sejam disciplinas regulares tais como curso de línguas, atividades voluntárias de pesquisas, ensino e extensão, grupos religiosos etc. que você possivelmente pretende realizar em 2017. No máximo 500 caracteres. </p> </div>
				<textarea name="atExtra" id="atExtra" placeholder="Digite suas atividades extras acadêmicas em tópicos (Campo não Obrigatório)"><?php echo printPost($add['atExtra'], 'campo'); ?></textarea>
				<span style="color: red;" id="contaatExtra"></span>
			</fieldset>
		<div id="clear"></div>
		</div>
		<br><br>

		<div class="title"> <h2>Sobre suas experiências</h2> </div>
		<div id="central" style="">
			<fieldset id="F_soubeDoPACCE">
				<?php 
					
					if ($add['soubeDoPACCE'] != '') {
						$checkSoube = explode(';  ', $add['soubeDoPACCE']);
						for ($i=0; $i < count($checkSoube); $i++) { 
							$checkSoube[$i] = str_replace(";", "", $checkSoube[$i]);
							//$checkSoube[$i] = str_replace(" ", "", $checkSoube[$i]);
						}
					}else{
						$checkSoube[0] = '-';
					}
					
				?>
				<label>Como soube do PACCE  </label> <span class="red">*</span>
				<div class="subtitle"> <p>Como você ficou sabendo do nosso Processo Seletivo 2017? </p> </div>
				<br><BR>
				<input type="checkbox" name="soubeDoPACCE[]" id="soubeDoPACCE" <?php echo printCheckbox($checkSoube, 'Amigos'); ?> value="Amigos"> <span class="op" style="top: 3px;">  Amigos	</span>
				<br><br>
				<input type="checkbox" name="soubeDoPACCE[]" id="soubeDoPACCE" <?php echo printCheckbox($checkSoube, 'Banners'); ?> value="Banners"> <span class="op" style="top: 3px;">  Banners	</span>
				<br><br>
				<input type="checkbox" name="soubeDoPACCE[]" id="soubeDoPACCE" <?php echo printCheckbox($checkSoube, 'Sala do PACCE'); ?>  value="Sala do PACCE"> <span class="op" style="top: 3px;">  Sala do PACCE	</span>
				<br><br>
				<input type="checkbox" name="soubeDoPACCE[]" id="soubeDoPACCE" <?php echo printCheckbox($checkSoube, 'Bolsista do PACCE'); ?> value="Bolsista do PACCE"> <span class="op" style="top: 3px;">  Bolsista do PACCE	</span>
				<br><br>
				<input type="checkbox" name="soubeDoPACCE[]" id="soubeDoPACCE" <?php echo printCheckbox($checkSoube, 'Site da PROGRAD/UFC/EIDEIA'); ?> value="Site da PROGRAD/UFC/EIDEIA" > <span class="op" style="top: 3px;">  Site da PROGRAD/UFC/EIDEIA	</span>
				<br><br>
				<input type="checkbox" name="soubeDoPACCE[]" id="soubeDoPACCE" <?php echo printCheckbox($checkSoube, 'Site do PACCE/UFC'); ?> value="Site do PACCE/UFC"> <span class="op" style="top: 3px;">  Site do PACCE/UFC	</span>
				<br><br>
				<input type="checkbox" name="soubeDoPACCE[]" id="soubeDoPACCE" <?php echo printCheckbox($checkSoube, 'Redes Sociais do PACCE/UFC'); ?> value="Redes Sociais do PACCE/UFC"> <span class="op" style="top: 3px;">  Redes Sociais do PACCE/UFC	</span>	
				<br><br>
				<input type="checkbox" name="soubeDoPACCE[]" id="soubeDoPACCE" <?php echo printCheckbox($checkSoube, 'Outros'); ?> value="Outros"> <span class="op" style="top: 3px;">  Outros	</span>		
			</fieldset>
			<fieldset id="F_jaParticipei">
			<?php 
				if ($add['jaParticipei'] !== '') {
					$checkjaParticipei = explode(';  ', $add['jaParticipei']);
					for ($i=0; $i < count($checkjaParticipei); $i++) { 
						$checkjaParticipei[$i] = str_replace(";", "", $checkjaParticipei[$i]);
					}
				
				}else{
					$checkjaParticipei[0] = '';
				}
			?>
				<label>Já participei </label>
				<div class="subtitle"> <p>Dos grupos abaixo, selecione aqueles dos quais você já participou, seja como voluntário ou não. </p> </div>
				<br>
				<input type="checkbox" name="jaParticipei[]" <?php echo printCheckbox($checkjaParticipei, 'Grupos de estudo com colegas'); ?> id="jaParticipei" value="Grupos de estudo com colegas"> <span class="op" style="top: 3px;">  Grupos de estudo com colegas	</span>
				<br><br>
				<input type="checkbox" name="jaParticipei[]" id="jaParticipei" <?php echo printCheckbox($checkjaParticipei, 'Atividades religiosas'); ?> value="Atividades religiosas"> <span class="op" style="top: 3px;">  Atividades religiosas	</span>
				<br><br>
				<input type="checkbox" name="jaParticipei[]" id="jaParticipei" <?php echo printCheckbox($checkjaParticipei, 'Organizações Não Governamentais (ONGs)'); ?> value="Organizações Não Governamentais (ONGs)"> <span class="op" style="top: 3px;">  Organizações Não Governamentais (ONGs)	</span>
				<br><br>
				<input type="checkbox" name="jaParticipei[]" id="jaParticipei" <?php echo printCheckbox($checkjaParticipei, 'Grupos de Pesquisa'); ?> value="Grupos de Pesquisa"> <span class="op" style="top: 3px;">  Grupos de Pesquisa	</span>
				<br><br>
				<input type="checkbox" name="jaParticipei[]" id="jaParticipei" <?php echo printCheckbox($checkjaParticipei, 'Grupo de extensão universitária'); ?> value="Grupo de extensão universitária"> <span class="op" style="top: 3px;">  Grupo de extensão universitária	</span>
				<br><br>
				<input type="checkbox" name="jaParticipei[]" id="jaParticipei" <?php echo printCheckbox($checkjaParticipei, 'Centro Acadêmico'); ?> value="Centro Acadêmico"> <span class="op" style="top: 3px;">  Centro Acadêmico	</span>
				<br><br>
				<input type="checkbox" name="jaParticipei[]" id="jaParticipei" <?php echo printCheckbox($checkjaParticipei, 'Movimento Estudantil'); ?> value="Movimento Estudantil"> <span class="op" style="top: 3px;">  Movimento Estudantil	</span>	
				<br><br>
				<input type="checkbox" name="jaParticipei[]" id="jaParticipei" <?php echo printCheckbox($checkjaParticipei, 'Partido Político'); ?> value="Partido Político"> <span class="op" style="top: 3px;">  Partido Político	</span>		
			</fieldset>
			<fieldset id="F_5problemas">
				<label>Cinco Problemas  </label>
				<div class="subtitle"> <p>Cite até cinco problemas que você já enfrentou quando trabalhou em grupo. Use uma linha pra cada problema. Seja sucinto. No máximo 500 caracteres. </p> </div>
				<textarea name="5problemas" id="5problemas" placeholder="Digite os cinco problemas (Campo não Obrigatório)"><?php echo printPost($add['5problemas'], 'campo'); ?></textarea>
				<span style="color: red;" id="conta5problemas"></span>
			</fieldset>
			<fieldset id="F_gruposVirtuais">
				<label>Grupos Virtuais  </label>
				<div class="subtitle"> <p>Você já participou de grupos de discussão em comunidades virtuais? Se sim, escreva-o(s) no campo abaixo. No máximo 500 caracteres. </p> </div>
				<textarea name="gruposVirtuais" id="gruposVirtuais" placeholder="Digite suas atividades extras acadêmicas em tópicos (Campo não Obrigatório)"><?php echo printPost($add['gruposVirtuais'], 'campo'); ?></textarea>
				<span style="color: red;" id="contagruposVirtuais"></span>
			</fieldset>
			<fieldset id="F_eventosAC">
				<label>Eventos de Aprendizagem Cooperativa  </label>
				<div class="subtitle"> <p>Você já participou de eventos de Aprendizagem Cooperativa? Se sim, escreva-o(s) no campo abaixo. No máximo 500 caracteres. </p> </div>
				<textarea name="eventosAC" id="eventosAC" placeholder="Digite suas atividades extras acadêmicas em tópicos (Campo não Obrigatório)"><?php echo printPost($add['eventosAC'], 'campo'); ?></textarea>
				<span style="color: red;" id="contaeventosAC"></span>
			</fieldset>
		<div id="clear"></div>
		</div>
		<br><br>

		<div class="title"> <h2>Sobre a sua ideia de projeto de Aprendizagem para desenvolver no Programa.</h2> </div>
		<div id="central" style="">
		<fieldset id="F_ideiasDeProjeto">
			<label>Ideias de Projeto  </label> <span class="red">*</span>
			<div class="subtitle"> <p>Suas ideias sobre um projeto a ser desenvolvido na bolsa.. Se você for selecionado 
			como bolsista de Aprendizagem Cooperativa, terá que desenvolver um projeto de aprendizagem, ou seja, organizar 
			um grupo de estudo com colegas. O Projeto deverá ser ideia sua e os participantes podem ser qualquer estudante 
			da UFC, de mesmo curso ou não. No sentido de avaliarmos sua ideia, solicitamos que você escreva um pequeno texto 
			sobre o projeto que você quer desenvolver, bem como a importância deste para você, para seus 
			colegas, para a universidade e para a sociedade como um todo. Recomendamos que guarde uma cópia com você. No máximo 500 caracteres. </p> </div>
			<textarea name="ideiasDeProjeto" id="ideiasDeProjeto" placeholder="Digite suas ideias de projeto"><?php echo printPost($add['ideiasDeProjeto'], 'campo'); ?></textarea>
			<span style="color: red;" id="contaideiasDeProjeto"></span>
		</fieldset>
		<fieldset id="F_colegaNoProjeto">
			<label>Colegas no Projeto </label> 
			<div class="subtitle"> <p>Agora, cite o nome completo, curso e email das pessoas com as quais você 
			está pensando em desenvolver seu projeto. Use uma linha por membro. Este campo não é necessário 
			para ingressantes na UFC em 2017.1. No máximo 500 caracteres. </p> </div>
			<textarea name="colegaNoProjeto" id="colegaNoProjeto" placeholder="Digite seus colegas no projeto (Campo não Obrigatório)"><?php echo printPost($add['colegaNoProjeto'], 'campo'); ?></textarea>
			<span style="color: red;" id="contacolegaNoProjeto"></span>
		</fieldset>
			<div id="clear"></div>
		</div>
		<br><br>

		<div class="title"> <h2>Memorial</h2> </div>
		<div id="central" style="">
			<fieldset id="F_memorial" style="width: 90%">
				<label>Seu Memorial  </label> <span class="red">*</span>
				<div class="subtitle"> <p>Escreva no espaço abaixo o seu memorial, um relato de no mínimo duas 
				páginas, relatando as suas memórias de vida (marcos de sua história) que você considera mais 
				importantes, incluindo também as suas experiências de trabalho ou estudo em grupo em qualquer 
				época de sua vida. Sugestão: Cite, pelo menos duas pessoas, além de seus pais, pelas quais você 
				sente muita gratidão por situações específicas que aconteceram com você; uma situação ou 
				experiência marcante (que possa vir a ser publicado em nosso site) e como foi sua trajetória 
				na escolha de seu curso atual. Quantidade mínima de caracteres para esta questão: 5000 e
				 no máximo: 8000 caracteres. Recomendamos que guarde uma cópia com você. </p> </div>
				<textarea name="memorial" id="memorial" placeholder="Digite seu memorial"><?php echo printPost($memorial['memorial'], 'campo'); ?></textarea>
				<input type="hidden" name="valorMemorial" id="valorMemorial" value="<?php echo GetPost('valorMemorial'); ?>">
				<span style="color: red;" id="contamemorial"></span>
			</fieldset>
			
			<fieldset id="F_usoDomemorial" style="width: 90%">
				<label>Uso do Memorial  </label> <span class="red">*</span><br><br>
				<input type="checkbox" name="usoDomemorial[]" id="usoDomemorial" checked="" <?php echo printCheckbox(GetPost('usoDomemorial'), '1'); ?> value="1"> <span class="op">  Ao enviar este formulário, autorizo o uso de meu Memorial e do meu Projeto para fins acadêmicos, ou seja, no âmbito das ações do Programa de Aprendizagem Cooperativa.	</span>		
			</fieldset>
		<div id="clear"></div>
		</div>
		<br><br>
		<div class="title"> <h2>Sistema</h2> </div>
		<div id="central" style="">
			<fieldset id="F_deficiencia">
				<label>Necessidade/Deficiência  </label>
				<div class="subtitle"> <p>Vocêpossui alguma necessidade/deficiência especial? Qual/is? </p> </div>
				<span style="margin-right: 30px;"><input type="radio"  name="ConfirmaDefiencia" class="ConfirmaDefiencia" value="1" <?php if($add['deficiencia'] != 'Não'){ echo 'checked';} ?>> <span class="op">  Sim 	</span> </span>
				<input type="radio" name="ConfirmaDefiencia" class="ConfirmaDefiencia" value="0" <?php if($add['deficiencia'] == 'Não'){ echo 'checked'; } ?>> <span class="op"> Não </span>
				<input type="text" name="deficiencia" id="deficiencia" autocomplete="off" value="<?php echo $add['deficiencia']; ?>" placeholder="Qual/is deficiência possue?" style="display: none; margin-top: 20px;">		
			</fieldset>
		<div id="clear"></div>
		</div>
		<br><br>
			<center>
				<input type="submit" name="enviar" value="Salvar">
			</center>
		</form>
	</div>

</div>
