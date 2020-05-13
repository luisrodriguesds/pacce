<?php 
	require_once '../../pdf/mpdf.php';
	
	$codigo = substr(md5(uniqid(rand(), true)), 0, 10);
	$bolsista = DBread('bolsistas', "WHERE npacce = '".DBescape($_GET['declaracao-simples'])."'");
	$bolsista = $bolsista[0];
	$situacao 	= ($bolsista['situacao'] == 1) ? 'Efetivo' : 'Voluntário';
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
								<img src="'.DIR_BASE.'login/users/imagens/ufc-declaracao.gif" style="width: 200px;" />
							</td>
							
							<td>
								<img src="'.DIR_BASE.'login/users/imagens/pacce-declaracao.gif" style="width: 200px;"/>
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
						se fizerem necessários, que <strong>'.$bolsista['nome'].'</strong>, 
						matriculado no curso de <strong>'.$bolsista['curso'].'</strong> com o 
						nº de matrícula <strong>'.$bolsista['matricula'].'</strong>, é bolsista <strong>'.$situacao.'</strong> 
						desde 11 de março de '.date('Y').' 
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

		$form['npacce'] 	= $bolsista['npacce'];
		$form['matricula'] 	= $bolsista['matricula'];
		$form['codigo'] 	= $codigo;
		$form['status'] 	= 1;
		$form['dataEmissao'] = date('Y-m-d');
		$form['registro'] 	= date('Y-m-d H:i:s');

		if (DBcreate('cod_verifica', $form)) {
				echo '<script type="text/javascript">
					window.open("'.URL_PAINEL.'declaracaoSimples.pdf", "_blank");
				</script>';
		}
?>