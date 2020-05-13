<?php 

	require_once '../../pdf/mpdf.php';
//==================DECLARAÇÃO SIMPLES==========================================================

if (isset($_GET['declaracaoSimples'])){


	$codigo = substr(md5(uniqid(rand(), true)), 0, 10);
	$situacao 	= ($user['situacao'] == 1) ? 'Efetivo' : 'Voluntário';
	$page = '<!DOCTYPE html>
				<html>
				<head>
				<title></title>
					<style type="text/css">
						body{ font-family: "Lucida" Grande, sans-serif; font-size: 12px;}
						#title{	 text-align: center; font-size: 14px; }
						#dec{ text-align: center; font-size: 18px; margin-top:70px; margin-bottom:70px;}
						#content{ font-size: 18px; margin-bottom: 130px;}
						#cod{ font-family: "Lucida" Grande, sans-serif; font-size: 16px; text-align: center; width: 60%; border: 2px solid #000; margin: 0 auto; padding: 20px;}
					</style>
				</head>
				<body>
				
					<table>
						<tr>
							<td width="600">
								<img src="'.URL_PAINEL.'imagens/ufc-declaracao.gif" style="width: 200px;" />
							</td>
							
							<td>
								<img src="'.URL_PAINEL.'imagens/pacce-declaracao.gif" style="width: 200px;"/>
							</td>
						</tr>
					</table>
					<div id="title">
						<center>
							<strong>
							UNIVERSIDADE FEDERAL DO CEARÁ - UFC
							<br>ESCOLA INTEGRADA DE DESENVOLVIMENTO E INOVAÇÃO ACADÊMICA - EIDEIA
							<br>COORDENADORIA DE INOVAÇÃO E DESENVOLVIMENTO ACADÊMICO - COIDEA
							<br>PROGRAMA DE APRENDIZAGEM COOPERATIVA EM CÉLULAS ESTUDANTIS - PACCE
							</strong>
						</center>
					</div>

					<div id="dec">
						<strong>
							DECLARAÇÃO
						</strong>
					</div>

					<div id="content">
						&nbsp; &nbsp; &nbsp; &nbsp; Declaramos, para os fins a que 
						se fizerem necessários, que <strong>'.$user['nome'].'</strong>, 
						matriculado no curso de <strong>'.$user['curso'].'</strong> com o 
						nº de matrícula <strong>'.$user['matricula'].'</strong>, é bolsista <strong>'.$situacao.'</strong> 
						desde 11 de março de 2019 
						com carga horária semanal de 12h.
						<br><br>
						&nbsp; &nbsp; &nbsp; &nbsp; Programa de Aprendizagem Cooperativa em Células Estudantis – PACCE,   
						<strong> Fortaleza, '.date('d').' de '.$month[date('M')].' de '.date('Y').'</strong>.
					</div>
					
						<div id="cod">
							<center>
								Código de Verificação: <br>
								<strong>
									'.$codigo.'
								</strong>
							</center>
						</div>
					
				</body>
				</html>';

		$rodape = '<div id="rodape">
					Para verificar a autenticidade deste documento entre em http://www.pacce.ufc.br/documentos   
					informando o número de matrícula, data de emissão e o código de verificação: '.$codigo.'
					</div>';

		$arq = "declaracaoSimples.pdf";
		$mpdf = new mPDF();
		$mpdf->WriteHTML($page);
		$mpdf->SetHTMLFooter($rodape);
		$mpdf->Output($arq, 'F');

		$form['npacce'] 	= $user['npacce'];
		$form['matricula'] 	= $user['matricula'];
		$form['codigo'] 	= $codigo;
		$form['status'] 	= 1;
		$form['dataEmissao'] = date('Y-m-d');
		$form['registro'] 	= date('Y-m-d H:i:s');

		if (DBcreate('cod_verifica', $form)) {
				echo '<script type="text/javascript">
					window.open("'.URL_PAINEL.'declaracaoSimples.pdf", "_blank");
				</script>';
		}
}

//==================RELATÓRIO INDIVIDUAL==========================================================
	if (isset($_GET['relatorio'])) {
		$dadosPessoais = DBread('dados_pessoais', "WHERE npacce = '".$user['npacce']."'");
		$dadosPessoais = $dadosPessoais[0];
		$topo = '
				<table>
					<tr>
						<td>
							<img src="'.URL_PAINEL.'/imagens/ufc.gif" style="width:50px;">
						</td>
						<td width="600">
							<div id="title">
								<center>
									<strong>
										SIGAA - Sistema Integrado de Gestão de Atividades Acadêmicas do PACCE<br>
										UFC - Universidade Federal do Ceará<br>
										EIDEIA - Escola Inegrada de Desenvolvimento e Inovação Acadêmmica<br>
										Av. da Universidade, 2853 - Benfica - Fortaleza - CE- CEP 60020-181<br>
									</strong>
								</center>
							</div>
						</td>
						<td>
							<img src="'.URL_PAINEL.'/imagens/logo.gif" style="width:50px; margin-top:10px;">
						</td>
					</tr>
					</table>
					<div id="emissao">
						<strong>
						Relatório Individual - Emitido em: '.date('d/m/Y').' às '.date('H:i:s').'
						</strong>
					</div>

				';
		$dadosPessoais = DBread('dados_pessoais', "WHERE npacce = '".$user['npacce']."'");
		$dadosPessoais = $dadosPessoais[0];
		$sexo 		= ($user['sexo'] == 1) ? 'Masculino' : 'Feminino';
		$situacao 	= ($user['situacao'] == 1) ? 'Efetivo' : 'Voluntário';
		$status 	= ($user['status'] == 1) ? 'Ativo' : 'Inativo';
		$page = '<!DOCTYPE html>
				<html>
				<head>
					<title></title>
					<style type="text/css">
						*{ font-family: "Lucida" Grande, sans-serif;}
						body{ font-family: "Lucida" Grande, sans-serif;}
						#title{	 text-align: center; font-size: 12px; }
						#emissao{border-bottom: 2px solid #000; border-top: 2px solid #000; padding-top:5px; padding-bottom:5px;}
						#sessao{background: #ccc; text-align: center; margin-bottom: 6px;}
						#dados_pessoais table{ font-size: 12px;}
						#rodape{font-size: 10px;}
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
								<th width="450" style="text-align: left;">'.$user['nome'].'</th>
								<td>Sexo: </td>
								<th>'.$sexo.'</th>
							</tr>
						</table>
						<table>
							<tr>
								<td>Data de Nascimento: </td>
								<th width="300" style="text-align: left;">'.date('d/m/Y', strtotime($user['dataNasc'])).'</th>
								<td>Local de Nascimento: </td>
								<th>'.$dadosPessoais['naturalidade'].'</th>
							</tr>
						</table>
						<table>
							<tr>
								<td>Identidade: </td>
								<th width="350" style="text-align: left;">'.$user['rg'].'</th>
								<td>CPF: </td>
								<th>'.$user['cpf'].'</th>
							</tr>
						</table>
						<table>
							<tr>
								<td>Curso: </td>
								<th width="400" style="text-align: left;">'.$user['curso'].'</th>
								<td>Matrícula: </td>
								<th>'.$user['matricula'].'</th>
							</tr>
						</table>
						<table>
							<tr>
								<td>Status: </td>
								<th width="400" style="text-align: left;">'.$status.'</th>
								<td>Situação: </td>
								<th>'.$situacao.'</th>
							</tr>
						</table>
						
					</div>
				</body>
				</html>';
		
		//$rodape = date('d/m/Y H:i:s');

		//RODAPÉ COM 
		/*
		$cr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$max = strlen($cr)-1;
		$gera = null;
		for($i=0; $i < 16; $i++) {
		$gera .= $cr{mt_rand(0, $max)};
		}
		$gera = str_split($gera, 4);
		$rodape = $gera[0]."-".$gera[1]."-".$gera[2]."-".$gera[3];
		*/
		$codigo = substr(md5(uniqid(rand(), true)), 0, 10);
		$rodape = '<div id="rodape">
					Para verificar a autenticidade deste documento entre em http://www.pacce.ufc.br/pacce/documentos   
					informando o número de matrícula, data de emissão e o código de verificação: '.$codigo.'
					</div>
		';
	
		//CONFIGURAÇÕES DA FOLHA
		$arq = "relatorio.pdf";
		$mpdf = new mPDF();
		$mpdf->mPDF('utf-8','A4','','','10','10','41','18'); 
		$mpdf->SetHTMLHeader($topo,'O',true);
		$mpdf->SetHTMLFooter($rodape);
		$mpdf->WriteHTML($page);
		$mpdf->Output($arq, 'F');

		echo '<script type="text/javascript">
				window.open("'.URL_PAINEL.'relatorio.pdf", "_blank");
			  </script>';

	}
	

?>

<div class="title"><h2>Declarações e Certificados</h2></div>
<p>Página destinada a impressão de declarações de vínculo e certificações </p>
<br><br>
<div class="title"><h2>Opções</h2></div>
<a href="?declaracaoSimples" class="botao">Declaração Simples</a> 
<a href="?relatorio" class="botao">Relatório Individual</a> 


