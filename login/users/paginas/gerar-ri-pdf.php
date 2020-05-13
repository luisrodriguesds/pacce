
<?php
	require_once '../../pdf/mpdf.php';
	$npacce = DBescape($_GET['relatorio-individual']);
	$bolsista = DBread('bolsistas', "WHERE npacce = '".$npacce."'");
	$bolsista = $bolsista[0];
	$dadosPessoais = DBread('dados_pessoais', "WHERE npacce = '".$bolsista['npacce']."'");
	$dadosPessoais = $dadosPessoais[0];
	$topo = '
			<table>
				<tr>
					<td>
						<img src="'.DIR_BASE.'login/users/imagens/ufc.gif" style="width:50px;">
					</td>
					<td width="600">
						<div id="title">
							<center>
								<strong>
									SIGAP - Sistema Integrado de Gestão de Atividades no PACCE<br>
									UFC - Universidade Federal do Ceará<br>
									EIDEIA - Escola Inegrada de Desenvolvimento e Inovação Acadêmmica<br>
									PACCE - Programa de Aprendizagem Cooperativa em Células Estudantis<br>
									Av. da Universidade, 2853 - Benfica - Fortaleza - CE- CEP 60020-181<br>
								</strong>
							</center>
						</div>
					</td>
					<td>
						<img src="'.DIR_BASE.'login/users/imagens/logo.gif" style="width:50px; margin-top:10px;">
					</td>
				</tr>
				</table>
				<div id="emissao">
					<strong>
					Relatório Individual - Emitido em: '.date('d/m/Y').' às '.date('H:i:s').'
					</strong>
				</div>

			';
	$dadosPessoais = DBread('dados_pessoais', "WHERE npacce = '".$bolsista['npacce']."'");
	$dadosPessoais = $dadosPessoais[0];
	$sexo 		= ($bolsista['sexo'] == 1) ? 'Masculino' : 'Feminino';
	$situacao 	= ($bolsista['situacao'] == 1) ? 'Efetivo' : 'Voluntário';
	$status 	= ($bolsista['status'] == 1) ? 'Ativo' : 'Inativo';
	$dadosAcademicos = Dbread('dados_academicos', "WHERE npacce = '".$npacce."'");
	$dadosAcademicos = $dadosAcademicos[0];
	$page = '<!DOCTYPE html>
			<html>
			<head>
				<title></title>
				<style type="text/css">
					*{ font-family: "Lucida" Grande, sans-serif; font-size: 10px;}
					body{ font-family: "Lucida" Grande, sans-serif;}
					#title{	 text-align: center; font-size: 12px; }
					#emissao{border-bottom: 2px solid #000; border-top: 2px solid #000; padding-top:5px; padding-bottom:5px;}
					#sessao{background: #ccc; text-align: center; margin-bottom: 6px;}
					#dados_pessoais table{ font-size: 10px;}
					#rodape{font-size: 10px;}
					.sessao table{ width: 100%; }
					.tabela{ font-size: 10px; margin-bottom:10px; }
					.tabela table{border-collapse:collapse; border:1px solid #a2a2a2; width:100%;}
					.tabela table th{ padding: 3px 0px; border: 1px solid #a2a2a2; font-size: 10px; }
					.tabela table td{border-collapse:collapse; border:1px solid #a2a2a2; font-size: 10px;  text-align: center; width: auto;}
				</style>
			</head>
			<body>
				<div id="sessao" style="">
					<strong>
						Dados Pessoais
					</strong>
				</div>
				<div id="dados_pessoais">
					<table>
						<tr>
							<td>Nome: </td>
							<th width="300" style="text-align: left;">'.$bolsista['nome'].'</th>
							<td>Sexo: </td>
							<th width="100" style="text-align: left;">'.$sexo.'</th>
							<td>Data de Nascimento: </td>
							<th style="text-align: left;">'.date('d/m/Y', strtotime($bolsista['dataNasc'])).'</th>
						</tr>
					</table>
					<table>
						<tr>
							<td>Local de Nascimento: </td>
							<th width="150" style="text-align: left;">'.$dadosPessoais['naturalidade'].'</th>
							<td>Identidade: </td>
							<th width="200" style="text-align: left;">'.$bolsista['rg'].'</th>
							<td>CPF: </td>
							<th>'.$bolsista['cpf'].'</th>
						</tr>
					</table>
					<table>
						<tr>
							<td>Matrícula: </td>
							<th width="100" style="text-align: left;">'.$bolsista['matricula'].'</th>
							<td>Curso: </td>
							<th width="250" style="text-align: left;">'.$bolsista['curso'].'</th>
							<td>Turno: </td>
							<th width="100" style="text-align: left;">'.$dadosAcademicos['turno'].'</th>
							<td>Campus: </td>
							<th>'.$bolsista['campus'].'</th>
						</tr>
					</table>
					<table>
						<tr>
							<td>Endereço: </td>
							<th width="300" style="text-align: left;">'.$dadosPessoais['endereco'].'</th>
							<td>Bairro: </td>
							<th width="100" style="text-align: left;">'.$dadosPessoais['bairro'].'</th>
							<td>Cidade/UF: </td>
							<th>'.$dadosPessoais['cidadeEstado'].'</th>
						</tr>
					</table>
					<table>
						<tr>
							<td>Número PACCE: </td>
							<th width="200" style="text-align: left;">'.$bolsista['npacce'].'</th>
							<td>Status: </td>
							<th width="200" style="text-align: left;">'.$status.'</th>
							<td>Situação: </td>
							<th>'.$situacao.'</th>
						</tr>
					</table>
				</div>
				
					';
			$exibir = '';
			$avColetiva = DBread('eventos_avaliar', "WHERE npacce = '".$bolsista['npacce']."'");
			$avColetivaPres = DBread('eventos_avaliar', "WHERE npacce = '".$bolsista['npacce']."'");
			if($avColetiva == true) {
				$exibir = '
				<div id="sessao">
					<strong>
						Atividades Coletivas - Relatório
					</strong>
				</div>
				<div class="tabela"><table>';
				$exibir .= '<tr>
								<th style="width:12%;">Código</th>
								<th style="width:68%;">Evento</th>
								<th style="width:20%;">Presente</th>
							</tr>';

				for ($i=0; $i < count($avColetiva); $i++) { 
					if ($avColetiva[$i]['presenca'] == 'nao') {
						$avColetiva[$i]['presenca'] = 'Não';
					} else if ($avColetiva[$i]['presenca'] == 'sim') {
						$avColetiva[$i]['presenca'] = 'Sim';
					}
					$exibir.='
						<tr>
							<td>'.$avColetiva[$i]['codigo'].'</td>
							<td>'.$avColetiva[$i]['evento'].'</td>
							<td>'.$avColetiva[$i]['presenca'].'</td>
						</tr>';
				}

				$exibir.='<tr>
							<td>('.count($avColetiva).')</td>
							<td></td>
							<td></td>
						</tr>';

				$exibir.='</table></div>';
			}

			$page.='	
				'.$exibir.'
				
				';
			//EXIBE ATIVIDADES COLETIVAS
			$atColetiva = DBread('eventos_pres', "WHERE npacce = '".$bolsista['npacce']."'");
			if ($atColetiva == true) {
				
				$exibir = '
					<div id="sessao">
						<strong>
							Atividades Coletivas - Presença
						</strong>
					</div>
					<div class="tabela"><table>';
				$exibir .= '<tr>
								<th style="width:10%;">Código</th>
								<th style="width:32%;">Evento</th>
								<th style="width:26%;">Direção</th>
								<th style="width:26%;">Presente</th>
								<th style="width:6%;">CH</th>
							</tr>';

				$contAtCol = 0; 
				for ($i=0; $i < count($atColetiva); $i++) {
					if ($atColetiva[$i]['presenca'] == 1 || $atColetiva[$i]['presenca'] == 3  || $atColetiva[$i]['presenca'] == 5 || $atColetiva[$i]['presenca'] == 6) {
					 	$contAtCol++;
					 } 
					if($atColetiva[$i]['presenca'] == 0){ $atColetiva[$i]['presenca'] = 'Não';}else if($atColetiva[$i]['presenca'] == 1){ $atColetiva[$i]['presenca'] = 'Sim';}else if($atColetiva[$i]['presenca'] == 2){ $atColetiva[$i]['presenca'] = 'Saída não registrada';}else if($atColetiva[$i]['presenca'] == 3){ $atColetiva[$i]['presenca'] = 'Não, mas repôs';}else if($atColetiva[$i]['presenca'] == 4){ $atColetiva[$i]['presenca'] =  'Não, mas reposição está em análise';}else if($atColetiva[$i]['presenca'] == 5){$atColetiva[$i]['presenca'] = 'Feriado';}else if($atColetiva[$i]['presenca'] == 6){$atColetiva[$i]['presenca'] = 'Não, mas justificou';}else{ $atColetiva[$i]['presenca'] = 'Não e reposição reprovada';} 
					if ($atColetiva[$i]['presenca'] == 'Não, mas justificou') {
						$hour = '04:00';
					} else {
						// $hour = gmdate('H:i', strtotime($atColetiva[$i]['saida']) - strtotime($atColetiva[$i]['entrada']));
						$hour = '04:00';
					}
					$exibir.='
						<tr>
							<td>'.$atColetiva[$i]['codigo'].'</td>
							<td>'.$atColetiva[$i]['evento'].'</td>
							<td></td>
							<td>'.$atColetiva[$i]['presenca'].'</td>
							<td>'.$hour.'</td>
						</tr>
					';
				}
				$total = $contAtCol*4;
				$totalGeral = $total;
				$exibir.= '
					<tr>
						<td>('.$contAtCol.'/'.count($atColetiva).')</td>
						<td></td>
						<td></td>
						<th>Total</th>
						<td>'.$total.':00</td>
					</tr>
				';
				$exibir.='</table></div>';
			}

			$page.='	
				'.$exibir.'
				
				
				';
			$exibir = '';

			$extraInsc 	= DBread('extra_insc', "WHERE npacce = '".$bolsista['npacce']."' AND situacao != false ORDER BY semana ASC");
				if ($extraInsc == true) {
					$exibir = '
					<div id="sessao">
						<strong>
							Atividades Extras - Presença
						</strong>
					</div>
					<div class="tabela"><table>';
					$exibir .= '<tr>
								<th style="width:12%;">Código</th>
								<th style="width:12%;">Semana</th>
								<th style="width:40%;">Tema</th>
								<th style="width:26%;">Presente</th>
								<th style="width:10%;">CH</th>
							</tr>';
					$total = 0;
					for ($i=0; $i < count($extraInsc); $i++) { 
						if ($extraInsc[$i]['presenca'] == 1 || $extraInsc[$i]['presenca'] == 5 || $extraInsc[$i]['presenca'] == 6) {
							$extraCont++;
						}
						if($extraInsc[$i]['situacao'] == 0){ $extraInsc[$i]['situacao'] = 'Inscrito';}else if($extraInsc[$i]['situacao'] == 1){ $extraInsc[$i]['situacao'] = 'Sim';}else{ $extraInsc[$i]['situacao'] = 'Não'; }
						$exibir.='
							<tr>
								<td>'.$extraInsc[$i]['codigo'].'</td>
								<td> Semana '.$extraInsc[$i]['semana'].'</td>
								<td></td>
								<td>'.$extraInsc[$i]['situacao'].'</td>
								<td>'.gmdate('H:i', strtotime($extraInsc[$i]['saida']) - strtotime($extraInsc[$i]['entrada'])).'</td>
							</tr>
						';
					$total += gmdate('H:i', strtotime($extraInsc[$i]['saida']) - strtotime($extraInsc[$i]['entrada']));
					}
					$totalGeral+=$total;
					$exibir.= '
					<tr>
					<td>('.$extraCont.'/'.count($extraInsc).')</td>
					<td></td>
					<td></td>
					<th>Total</th>
					<td>'.$total.':00</td>
					</tr>';
					$exibir.='</table></div>';
				}

				$page.='
						'.$exibir.'
				
				';
				$exibir = '';

			$forPres = DBread('for_pres', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
			if ($forPres == true) {
				$exibir = '
					<div id="sessao">
						<strong>
							Formação - Presença
						</strong>
					</div>
					<div class="tabela"><table>';
				$exibir .= '<tr>
								<th style="width:12%;">Código</th>
								<th style="width:12%;">Semana</th>
								<th style="width:40%;">Tema</th>
								<th style="width:26%;">Presente</th>
								<th style="width:10%;">CH</th>
							</tr>';
				
				$countFor = 0; 
				for ($i=0; $i < count($forPres); $i++) { 
					if ($forPres[$i]['presenca'] == 1 || $forPres[$i]['presenca'] == 2  || $forPres[$i]['presenca'] == 5 || $forPres[$i]['presenca'] == 6) {
					 	$countFor++;
					 } 
					if($forPres[$i]['presenca'] == 1){ $forPres[$i]['presenca'] = 'Sim';}else if($forPres[$i]['presenca'] == 0){ $forPres[$i]['presenca'] =  'Não';}else if($forPres[$i]['presenca'] == 2){ $forPres[$i]['presenca'] =  'Não, mas repôs';}else if($forPres[$i]['presenca'] == 4){ $forPres[$i]['presenca'] = 'Não, mas reposição está em análise';}else if($forPres[$i]['presenca'] == 3){ $forPres[$i]['presenca'] = 'Não e reposição reprovada';}else if($forPres[$i]['presenca'] == 5){$forPres[$i]['presenca'] = 'Feriado';}else if($forPres[$i]['presenca'] == 6){$forPres[$i]['presenca'] = 'Não, mas justificou';}
					if ($forPres[$i]['presenca'] == 'Não, mas justificou') {
						$hour = '03:00';
					} else {
						$hour = gmdate('H:i', strtotime($forPres[$i]['saida']) - strtotime($forPres[$i]['entrada']));
					}
					$exibir.='
						<tr>
							<td>'.$forPres[$i]['codigo'].'</td>
							<td> Semana '.$forPres[$i]['semana'].'</td>
							<td>'.$forPres[$i]['tema'].'</td>
							<td>'.$forPres[$i]['presenca'].'</td>
							<td>'.$hour.'</td>
						</tr>
					';
				}
				$total = $countFor*3;
				$totalGeral+=$total;
				$exibir.= '
					<tr>
						<td>('.$countFor.'/'.count($forPres).')</td>
						<td></td>
						<td></td>
						<th>Total</th>
						<td>'.$total.':00</td>
					</tr>
				';
				$exibir.='</table></div>';
			}
			
			$page.='
				'.$exibir.'
				
				';
			$exibir = '';
			$apoPres = DBread('apo_pres', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY codigo ASC");
			if ($apoPres == true) {
				$exibir = '
					<div id="sessao">
						<strong>
							Apoio à Célula - Presença
						</strong>
					</div>
					<div class="tabela"><table>';
				$exibir .= '<tr>
								<th style="width:12%;">Código</th>
								<th style="width:12%;">Semana</th>
								<th style="width:40%;">Tema</th>
								<th style="width:26%;">Presente</th>
								<th style="width:10%;">CH</th>
							</tr>';
				$contApo = 0;
				$total = 0; 
				for ($i=0; $i < count($apoPres); $i++) { 
					if ($apoPres[$i]['presenca'] == 1 || $apoPres[$i]['presenca'] == 2 || $apoPres[$i]['presenca'] == 5 || $apoPres[$i]['presenca'] == 6) {
					 	$contApo++;
					 } 
					if($apoPres[$i]['presenca'] == 1){ $apoPres[$i]['presenca'] = 'Sim';}else if($apoPres[$i]['presenca'] == 0){ $apoPres[$i]['presenca'] =  'Não';}else if($apoPres[$i]['presenca'] == 2){ $apoPres[$i]['presenca'] =  'Não, mas repôs';}else if($apoPres[$i]['presenca'] == 4){ $apoPres[$i]['presenca'] = 'Não, mas reposição está em análise';}else if($apoPres[$i]['presenca'] == 3){ $apoPres[$i]['presenca'] = 'Não e reposição reprovada';} else if ($apoPres[$i]['presenca'] == 5){ $apoPres[$i]['presenca'] = 'Feriado';}else if($apoPres[$i]['presenca'] == 6){$apoPres[$i]['presenca'] = 'Não, mas justificou';}
					if ($apoPres[$i]['presenca'] == 'Não, mas justificou') {
						$hour = '01:00';
					} else {
						$hour = gmdate('H:i', strtotime($apoPres[$i]['saida']) - strtotime($apoPres[$i]['entrada']));
					}
					$exibir.='
						<tr>
							<td>'.$apoPres[$i]['codigo'].'</td>
							<td> Semana '.$apoPres[$i]['semana'].'</td>
							<td>'.$apoPres[$i]['tema'].'</td>
							<td>'.$apoPres[$i]['presenca'].'</td>
							<td>'.$hour.'</td>
						</tr>
					';
					$total += $hour;
					
				}
				$totalGeral+=$total;
				$exibir.= '
					<tr>
						<td>('.$contApo.'/'.count($apoPres).')</td>
						<td></td>
						<td></td>
						<th>Total</th>
						<td>'.$total.':00</td>
					</tr>
				';
				$exibir.='</table></div>';
			}
			

			$page.='
					'.$exibir.'
				
				';
				$exibir = '';
				$projeto = DBread('projetos', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY status ASC", "id, titulo, npacce, status");
				if ($projeto == true) {
					$exibir = '
						<div id="sessao">
							<strong>
								Projeto
							</strong>
						</div>
					<div class="tabela"><table>';
					$exibir .= '<tr>
									<th>Título</th>
									<th>Status</th>
								</tr>';
					for ($i=0; $i < count($projeto); $i++) {
						if($projeto[$i]['status'] == 1){ $projeto[$i]['status'] = 'Ativo'; }else{ $projeto[$i]['status'] = 'Inativo'; } 
						$exibir.='
						<tr>
							<td>'.$projeto[$i]['titulo'].'</td>
							<td> '.$projeto[$i]['status'].'</td>
						</tr>';
					}
					$exibir.='
						<tr>
							<td></td>
							<td>('.count($projeto).')</td>
						</tr>
					';
					$exibir.='</table></div>';
				}
				$page.='
					'.$exibir.'
				';
				$exibir = '';
				
				$enc = DBread('enc_celula', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
				if ($enc == true) {
					$exibir = '
						<div id="sessao">
							<strong>
								Atividade de Célula - Relatório
							</strong>
						</div>
					<div class="tabela"><table>';
					$exibir.= '<tr>	
									<th style="width:12%;">Semana</th>
									<th style="width:62%;">Tema</th>
									<th style="width:16%;">Presente</th>
									<th style="width:10%;">CH</th>
								</tr>';
					$total = 0;
					for ($i=0; $i < count($enc); $i++) { 
						if($enc[$i]['reuniao'] == 1){ $enc[$i]['reuniao'] = 'Sim';}else if($enc[$i]['reuniao'] == 2){ $enc[$i]['reuniao'] =  'Não';}else if($enc[$i]['reuniao'] == 3){ $enc[$i]['reuniao'] =  'Não, mas repôs';}else if($enc[$i]['reuniao'] == 5){ $enc[$i]['reuniao'] =  'Feriado';}
						$exibir.='
							<tr>
								<td> Semana '.$enc[$i]['semana'].'</td>
								<td> '.$enc[$i]['tema'].'</td>
								<td> '.$enc[$i]['reuniao'].'</td>
								<td> '.date('H:i', strtotime($enc[$i]['ch'])).'</td>
							</tr>';
						$total += date('H:i', strtotime($enc[$i]['ch']));
					}
					$totalGeral+=$total;
					$exibir.='
						<tr>
							<td>('.count($enc).')</td>
							<td></td>
							<th>Total</th>
							<td>'.$total.':00</td>
						</tr>
					';
					$exibir.='</table></div>';
				}

				$page.='
					'.$exibir.'
			
				';

				$exibir = '';
				$rodPres = DBread('rod_pres', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY codigo ASC");
				if ($rodPres == true) {
					$exibir = '
						<div id="sessao">
							<strong>
								História de Vida - Presença
							</strong>
						</div>
					<div class="tabela"><table>';
					$exibir .= '<tr>
								<th style="width:12%;">Código</th>
								<th style="width:12%;">Semana</th>
								<th style="width:40%;">Tema</th>
								<th style="width:26%;">Presente</th>
								<th style="width:10%;">CH</th>
							</tr>';
					
					$contRod = 0;
					for ($i=0; $i < count($rodPres); $i++) { 
						if ($rodPres[$i]['presenca'] == 1 || $rodPres[$i]['presenca'] == 2 || $rodPres[$i]['presenca'] == 5 || $rodPres[$i]['presenca'] == 6) {
					 		$contRod++;
						 } 
						if($rodPres[$i]['presenca'] == 1){ $rodPres[$i]['presenca'] = 'Sim';}else if($rodPres[$i]['presenca'] == 0){ $rodPres[$i]['presenca'] =  'Não';}else if($rodPres[$i]['presenca'] == 2){ $rodPres[$i]['presenca'] =  'Não, mas repôs';}else if($rodPres[$i]['presenca'] == 4){ $rodPres[$i]['presenca'] = 'Não, mas reposição está em análise';}else if($rodPres[$i]['presenca'] == 3){ $rodPres[$i]['presenca'] = 'Não e reposição reprovada';}else if($rodPres[$i]['presenca'] == 5){$rodPres[$i]['presenca'] = 'Feriado';}else if($rodPres[$i]['presenca'] == 6){$rodPres[$i]['presenca'] = 'Não, mas justificou';}
						
						if ($rodPres[$i]['presenca'] == 'Não, mas justificou') {
							$hour = '01:00';
						} else {
							$hour = gmdate('H:i', strtotime($rodPres[$i]['saida']) - strtotime($rodPres[$i]['entrada']));
						}

						$exibir.='
							<tr>
								<td>'.$rodPres[$i]['codigo'].'</td>
								<td> Semana '.$rodPres[$i]['semana'].'</td>
								<td>'.$rodPres[$i]['tema'].'</td>
								<td>'.$rodPres[$i]['presenca'].'</td>
								<td>'.$hour.'</td>
							</tr>
						';
					}

					$total = $contRod;
					$totalGeral+=$total;
					$exibir.= '
					<tr>
					<td>('.$contRod.'/'.count($rodPres).')</td>
					<td></td>
					<td></td>
					<th>Total</th>
					<td>'.$total.':00</td>
					</tr>';
					$exibir.='</table></div>';
				}

				$page.='
						'.$exibir.'
				
				';
				$exibir = '';
				$apr = DBread('apr_me', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
				
				if ($apr == true) {
					$exibir = '
						<div id="sessao">
							<strong>
								Apreciação de Memorial - Relatório
							</strong>
						</div>
					<div class="tabela"><table>';
					$exibir .= '<tr>
									<th>Destinatário</th>
									<th>Semana</th>
									<th>Situação</th>
									<th>CH</th>
								</tr>';
					
					for ($i=0; $i < count($apr); $i++) { 
						$npacce = DBread('bolsistas', "WHERE npacce = '".$apr[$i]['npacce1']."'", "id, nome, nomeUsual");
						if($apr[$i]['contador'] == 1){$apr[$i]['contador'] = 'Relator'; }else{ $apr[$i]['contador'] = 'Ouvinte';}
						$exibir.='
						<tr>
							<td>'.GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']).'</td>
							<td> Semana '.$apr[$i]['semana'].'</td>
							<td>'.$apr[$i]['contador'].'</td>
							<td>1:00</td>
						</tr>';
					}
					$total = count($apr);
					$totalGeral+=$total;
					$exibir.= '<tr>
									<td>('.count($apr).')</td>
									<td></td>
									<td>Total</td>
									<td>'.$total.':00</td>
								</tr>';
					$exibir.='</table></div>';
				}

				$page.='
						'.$exibir.'
				
				';
				$exibir = '';
				$intInsc 	= DBread('int_insc', "WHERE npacce = '".$bolsista['npacce']."' AND situacao != false ORDER BY semana ASC");
				if ($intInsc == true) {
					$exibir = '
					<div id="sessao">
						<strong>
							Interação - Presença
						</strong>
					</div>
					<div class="tabela"><table>';
					$exibir .= '<tr>
								<th style="width:12%;">Código</th>
								<th style="width:12%;">Semana</th>
								<th style="width:40%;">Tema</th>
								<th style="width:26%;">Presente</th>
								<th style="width:10%;">CH</th>
							</tr>';
					$total = 0;
					for ($i=0; $i < count($intInsc); $i++) { 
						if ($intInsc[$i]['presenca'] == 1 || $intInsc[$i]['presenca'] == 5 || $intInsc[$i]['presenca'] == 6) {
							$contInt++;
						}
						if($intInsc[$i]['situacao'] == 0){ $intInsc[$i]['situacao'] = 'Inscrito';}else if($intInsc[$i]['situacao'] == 1){ $intInsc[$i]['situacao'] = 'Sim';}else{ $intInsc[$i]['situacao'] = 'Não'; }
						$exibir.='
							<tr>
								<td>'.$intInsc[$i]['codigo'].'</td>
								<td> Semana '.$intInsc[$i]['semana'].'</td>
								<td></td>
								<td>'.$intInsc[$i]['situacao'].'</td>
								<td>'.gmdate('H:i', strtotime($intInsc[$i]['saida']) - strtotime($intInsc[$i]['entrada'])).'</td>
							</tr>
						';
					$total += gmdate('H:i', strtotime($intInsc[$i]['saida']) - strtotime($intInsc[$i]['entrada']));
					}
					$totalGeral+=$total;
					$exibir.= '
					<tr>
					<td>('.$contInt.'/'.count($intInsc).')</td>
					<td></td>
					<td></td>
					<th>Total</th>
					<td>'.$total.':00</td>
					</tr>';
					$exibir.='</table></div>';
				}

				$page.='
						'.$exibir.'
				
				';
				$exibir = '';
 				
 				$relato = DBread('relato', "WHERE npacce = '".$bolsista['npacce']."'");
 				if ($relato == true) {
 					$exibir = '
 					<div id="sessao">
						<strong>
							Relato de Experiência - Relatório
						</strong>
					</div>
					<div class="tabela"><table>';
					$exibir.= '	<tr>
									<th>Semestre</th>
									<th>Situação</th>
								</tr>';
					for ($i=0; $i < count($relato); $i++) { 
						if( $relato[$i]['situacao'] == 0){ $relato[$i]['situacao'] = "Em análise"; }else if($relato[$i]['situacao'] == 1){ $relato[$i]['situacao'] = "Feito";}else{ $relato[$i]['situacao'] = "Precisa ser refeito";}
						$exibir.= '<tr>
								<td>'.$relato[$i]['semestre'].'</td>
								<td>'.$relato[$i]['situacao'].'</td>
							</tr>';
					}
					$exibir.='</table></div>';
 				}

				$page.=''.$exibir.'';
				
				$exibir = '';
				$comPres = DBread('av_comissao', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
				if ($comPres == true) {
					$exibir = '<div id="sessao">
									<strong>
										Reunião de Comissão - Presença
									</strong>
								</div>
							<div class="tabela"><table>';
					$exibir.= '<tr>
									<th>Código</th>
									<th>Semana</th>
									<th>Presente</th>
									<th>CH</th>
								</tr>';
					$contCom = 0;
					$total = 0;
					for ($i=0; $i < count($comPres); $i++) { 
						if ($comPres[$i]['presenca'] == 1 || $comPres[$i]['presenca'] == 2 || $comPres[$i]['presenca'] == 3 || $comPres[$i]['presenca'] == 6) {
							$contCom++;
						}
						if($comPres[$i]['presenca'] == 1){ $comPres[$i]['presenca'] = 'Sim';}else if($comPres[$i]['presenca'] == 0){ $comPres[$i]['presenca'] = 'Não';}else if($comPres[$i]['presenca'] == 2){ $comPres[$i]['presenca'] = 'Não, mas repôs';}else if($comPres[$i]['presenca'] == 3){$comPres[$i]['presenca'] = 'Feriado';}else if($comPres[$i]['presenca'] == 6){$comPres[$i]['presenca'] = 'Não, mas justificou';}
							
						if ($comPres[$i]['presenca'] == 'Não, mas repôs') {
							$hourAti = gmdate('H:i', strtotime("14:00:00") - strtotime("12:00:00"));
						} else {
							$hourAti = gmdate('H:i', strtotime($comPres[$i]['saida']) - strtotime($comPres[$i]['entrada']));
						}

						$exibir.= '<tr>
										<td>'.$comPres[$i]['codigo'].'</td>
										<td> Semana '.$comPres[$i]['semana'].'</td>
										<td>'.$comPres[$i]['presenca'].'</td>
										<td>'.$hourAti.'</td>
									</tr>';
						$total += $hourAti;

					}
					$exibir.= '<tr>
									<td>('.$contCom.'/'.count($comPres).')</td>
									<td></td>
									<th>Total</th>
									<td>'.$total.':00</td>
								</tr>';
					$exibir.='</table></div>';	
					$totalGeral+=$total;
				}

				$page.= $exibir;

				$exibir = '';
				$ati = DBread('ati_com', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
				if ($ati == true) {
//====================== ATIVIDADE DE COMISSAO ======================================================
					$exibir .= '
					<div id="sessao">
						<strong>
							Atividades de Comissão - Relatório
						</strong>
					</div>
					<div class="tabela"><table>';
					$exibir.= '<tr>
									<th>Comissão</th>
									<th>Situação</th>
									<th>Semana</th>
									<th>CH</th>
								</tr>';
					$total = 0;
					for ($i=0; $i < count($ati); $i++) { 
						$exibir.= '<tr>
										<td>'.$ati[$i]['comissao'].'</td>
										<td>'.$ati[$i]['trabalhou'].'</td>
										<td> Semana '.$ati[$i]['semana'].'</td>
										<td>'.date('H:i', strtotime($ati[$i]['ch'])).'</td>
									</tr>';
						$total += date('H:i', strtotime($ati[$i]['ch'])); 
					}

					$exibir.= '
					<tr>
					<td>('.count($ati).')</td>
					<td></td>
					<th>Total</th>
					<td>'.$total.':00</td>
					</tr>';

					$exibir.='</table></div>';	
					$totalGeral+=$total;
				}

				$page.='
						'.$exibir.'

				<div id="sessao">
					<strong>
						Total de horas
					</strong>
				</div>
				<div class="tabela"><table>
					<tr>
						<th>Horas Trabalhadas</th>
					</tr>
					<tr>
						<td>'.$totalGeral.':00</td>
					</tr>
				</table>
				

			</body>
			</html>';

	$codigo = substr(md5(uniqid(rand(), true)), 0, 10);
	$rodape = '<div id="rodape">
				Para verificar a autenticidade deste documento entre em http://www.pacce.ufc.br/pacce/documentos   
				informando o número de matrícula, data de emissão e o código de verificação: '.$codigo.'</div>';

	//CONFIGURAÇÕES DA FOLHA
	$arq = "relatorio.pdf";
	$mpdf = new mPDF();
	$mpdf->mPDF('utf-8','A4','','','10','10','44','18'); 
	$mpdf->SetHTMLHeader($topo,'O',true);
	$mpdf->SetHTMLFooter($rodape);
	$mpdf->WriteHTML($page);
	$mpdf->Output($arq, 'F');

	$form['npacce'] 	= $bolsista['npacce'];
	$form['matricula'] 	= $bolsista['matricula'];
	$form['codigo'] 	= $codigo;
	$form['status'] 	= 1;
	$form['dataEmissao'] = date('Y-m-d');
	$form['registro'] 	= date('Y-m-d H:i:s');

	if (DBcreate('cod_verifica', $form)) {
		echo '<script type="text/javascript">
			window.open("'.URL_PAINEL.'relatorio.pdf", "_blank");
		  </script>';
	}


?>