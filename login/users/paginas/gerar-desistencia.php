<?php

	require_once '../../pdf/mpdf.php';

	$codigo = substr(md5(uniqid(rand(), true)), 0, 10);
	$bolsista = DBread('bolsistas', "WHERE npacce = '".DBescape($_GET['desistencia'])."'");
	$bolsista = $bolsista[0];
	$situacao 	= ($bolsista['situacao'] == 1) ? 'Efetivo' : 'Voluntário';
	$page = '<!DOCTYPE html>
				<html>
				<head>
				<title></title>
					<style type="text/css">
						body{ font-family: "Lucida" Grande, sans-serif; font-size: 13px; }
						#logo{ text-align: center; margin-bottom: 20px; }
						#title{	 text-align: center; font-size: 14px; }
						#dec{ text-align: center; font-size: 15px; margin-top:60px; margin-bottom:50px;}
						#content{ line-height: 1.6; text-align: justify; text-justify: inter-word; font-size: 13px; margin-bottom: 90px;padding-left: 60px; padding-right: 60px;}
						#cod{ font-family: "Lucida" Grande, sans-serif; font-size: 16px; text-align: center; width: 60%; border: 2px solid #000; margin: 0 auto; padding: 20px;}
						#ass{ text-align: center; }
					</style>
				</head>
				<body>
				
					
					<div id="logo">
						<img src="'.URL_PAINEL.'imagens/ufc.png" style="width: 80px;" />
					</div>
					<div id="title">
						<center>
							<strong>
							UNIVERSIDADE FEDERAL DO CEARÁ
							<br>
							<br>
							<br>PROGRAMA DE APRENDIZAGEM COOPERATIVA - PACCE
							</strong>
						</center>
					</div>

					<div id="dec">
						<strong>
							DECLARAÇÃO DE DESISTÊNCIA DO PACCE '.date('Y').'
						</strong>
					</div>

					<div id="content">
						&nbsp; &nbsp; &nbsp; &nbsp; Declaro para fins de comprovação junto ao Programa de Aprendizagem Cooperativa em Células Estudantis – PACCE , que eu  <strong>'.$bolsista['nome'].'</strong>, aluno(a) do curso de <strong>'.$bolsista['curso'].'</strong>, com matrícula nº <strong>'.$bolsista['matricula'].'</strong> desisto, em caráter irrevogável, desta bolsa de monitoria pelos motivos que se seguem:
							<br>
							<br>
							
							_______________________________________________________________________________________________
							_______________________________________________________________________________________________
							_______________________________________________________________________________________________
							_______________________________________________________________________________________________
							_______________________________________________________________________________________________
							_______________________________________________________________________________________________
							_______________________________________________________________________________________________
							_______________________________________________________________________________________________
							_______________________________________________________________________________________________
							<br>
							<br>
							Estou ciente de que, em face deste termo, fica o PACCE liberado para preencher a vaga que a mim corresponderia, atribuindo-a a outro candidato(a) da lista de espera.

							<br>
							<br>
							<br>
							Fortaleza, '.date('d').' de '.$month[date('M')].' de '.date('Y').'.

					</div>

					<div id="ass"> 
						____________________________________________
						<br>
						<br>
						'.$bolsista['nome'].'
					</div>
					
						
					
				</body>
				</html>';

		$rodape = '<div id="rodape">
					
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