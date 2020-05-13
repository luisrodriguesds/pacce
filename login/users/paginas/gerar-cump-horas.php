	
<?php

	require_once '../../pdf/mpdf.php';


	$codigo = substr(md5(uniqid(rand(), true)), 0, 10);
	$bolsista = DBread('bolsistas', "WHERE npacce = '".DBescape($_GET['cump-horas'])."'");
	$bolsista = $bolsista[0];
	$page = '<!DOCTYPE html>
				<html>
				<head>
				<title></title>
					<style type="text/css">
						body{ font-family: "Lucida" Grande, sans-serif; font-size: 12px;}
						#title{	 text-align: center; font-size: 16px; margin-top:0px}
						#dec{ text-align: left; font-size: 14px; margin-top:70px; margin-bottom:70px; margin-left: 50px; margin-right: 50px;}
						#content{ font-size: 18px; margin-bottom: 80px;}
						#date{ text-align: right; margin-left: 50px; margin-right: 50px; font-size: 14px; margin-bottom: 80px;}
						#just{ text-align: center; margin-left: 50px; margin-right: 50px; font-size: 14px; margin-bottom: 80px;}
						table {width: 100%; margin-left: 50px; margin-right: 50px; border-collapse: collapse; }
						table tr {text-align: left;}
						table th, table td {text-align: left; border: 0.5px solid #000000; font-size: 12px; padding-left: 5px;}
					</style>
				</head>
				<body>
					<div id="title">
						<center>
						<br>
						<br>
							<strong>
							Termo de Cumprimento de Atividades/Horas 2019
							</strong>
						</center>
					</div>

					<div id="dec">
						Eu, <strong>'.$bolsista['nome'].'</strong> número PACCE <strong>'.$bolsista['npacce'].'</strong> assumo a responsabilidade de cumprir as horas que ficaram em aberto em minha participação no Programa, conforme discriminação abaixo:

					</div>

					<div id="content">
						<table>
							<tr>
								<th style="width:40%;">Atividade</th>
								<th style="width:20%;">Horas a cumprir</th>
								<th style="width:20%;">Cumprido em</th>
								<th style="width:20%;">Supervisão</th>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</div>
					
					<div id="date">
							Fortaleza, '.date('d').' de '.$month[date('M')].' de '.date('Y').'
					</div>

					<div id="just">
							Justificativa:_______________________________________________________________________________<br><br>
							____________________________________________________________________________________________
					</div> 

					<div id="just" style="font-size: 12px;">
							____________________________________________<br><br>
							'.$bolsista['nome'].'
					</div> 
					
				</body>
				</html>';

		$rodape = '<div id="rodape">
					
					</div>';

		$arq = "relatorio.pdf";
		$mpdf = new mPDF();
		$mpdf->mPDF('utf-8','A4','','','10','10','41','18'); 
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
					window.open("'.URL_PAINEL.'relatorio.pdf", "_blank");
				</script>';
		}

?>