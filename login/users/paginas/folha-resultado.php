
<?php 
	$valores = DBread('folha_valores', "WHERE folhaSlug = '".$url[2]."'");
	if ($valores == false) {
		echo '
             <script>
              alert("Insira os valores desse mês!");
                window.location="'.$way.'/'.$url[1].'";
              </script>';
	}else{
		DBDelete($tabela, "status = true"); 
		$bolsistas = DBread('folha_contagem', "WHERE situacao = 1");
		if ($bolsistas == false) {
			echo '
             <script>
              alert("Você precisa atualizar a folha!");
                window.location="'.$way.'/'.$url[1].'";
              </script>';
		}else{
			$cont = 0;
			for ($i=0; $i < count($bolsistas); $i++) { 
				$form['npacce'] 	= $bolsistas[$i]['npacce'];
				$form['nome']		= $bolsistas[$i]['nome'];
				$form['tipo']		= $bolsistas[$i]['tipo'];
				$form['tipoSlug']	= $bolsistas[$i]['tipoSlug'];
				$form['campus']		= $bolsistas[$i]['campus'];
				$form['registro']	= date('Y-m-d H:i:s');
				$form['status']		= 1;
				$projeto 	= '';
				$cadast 	= '';
				$encont 	= '';
				$apoio 		= '';
				$formacao 	= '';
				$rod 		= '';
				$int 		= '';
				$ape 		= '';
				$atiCom 	= '';
				$preRe 		= '';
				$rg 		= '';
				$preRGC 	= '';
				$preRG  	= '';
				$RdE 		= '';
				$situacao   = 0; 

				//EVENTOS
				if ($bolsistas[$i]['rg'] < $valores[0]['rg']) {
						$situacao++;
						$conRG  =  $valores[0]['rg'] - $bolsistas[$i]['rg'];
						//
						$preRG = 'Presença em Atividade Coletiva: Faltando '.$conRG.';';
					}else{
						$preRG = '';
					}
				//Relato de experiência
				if ($bolsistas[$i]['relatoDeExperiencia'] < $valores[0]['relatoDeExperiencia']) {
						$situacao++;
						$contRdE  =  $valores[0]['relatoDeExperiencia'] - $bolsistas[$i]['relatoDeExperiencia'];
						//
						$RdE = 'Relato de Experiência: Faltando '.$contRdE.';';
					}else{
						$RdE = '';
					}

				if ($bolsistas[$i]['campus'] == 'crateus' || $bolsistas[$i]['campus'] == 'quixada' || $bolsistas[$i]['campus'] == 'russas' || $bolsistas[$i]['campus'] == 'sobral') {
					$situacao = 0;
					$projeto 	= '';
					$cadast 	= '';
					$encont 	= '';
					$apoio 		= '';
					$formacao 	= '';
					$rod 		= '';
					$int 		= '';
					$ape 		= '';
					$atiCom 	= '';
					$preRe 		= '';
					$rg 		= '';
					$preRG 		= '';
					$preRGC 	= '';
					$RdE 		= '';
				}else if ($bolsistas[$i]['tipoSlug'] == 'articulador-de-celula') {
			
					if ($bolsistas[$i]['projeto'] < $valores[0]['projeto']) {
						$situacao++;
						$conPro  =  $valores[0]['projeto'] - $bolsistas[$i]['projeto'];
						//
						$projeto = 'Projeto: Faltando '.$conPro.';';
					}else{
						$projeto = '';
					}
					if ($bolsistas[$i]['cadastroCelula'] < $valores[0]['cadastroCelula']) {
						$situacao++;
						$conCast  =  $valores[0]['cadastroCelula'] - $bolsistas[$i]['cadastroCelula'];
						//
						$cadast = 'Cadastro de Célula: Faltando '.$conCast.';';
					}else{
						$cadast = '';
					}
					if ($bolsistas[$i]['encontroCelula'] < $valores[0]['encontroCelula']) {
						$situacao++;
						$conEnc  =  $valores[0]['encontroCelula'] - $bolsistas[$i]['encontroCelula'];
						//
						$encont = 'Encontro de Célula: Faltando '.$conEnc.';  ';
					}else{
						$encont = '';
					}

					if ($bolsistas[$i]['apoioCelula'] < $valores[0]['apoioCelula']) {
						$situacao++;
						$conApo  =  $valores[0]['apoioCelula'] - $bolsistas[$i]['apoioCelula'];
						//
						$apoio = 'Apoio à Célula: Faltando '.$conApo.';  ';
					}else{
						$apoio = '';
					}
					if ($bolsistas[$i]['formacao'] < $valores[0]['formacao']) {
						$situacao++;
						$conFor  =  $valores[0]['formacao'] - $bolsistas[$i]['formacao'];
						//
						$formacao = 'Formação: Faltando '.$conFor.';  ';
					}else{
						$formacao = '';
					}

					if ($bolsistas[$i]['historiaDeVida'] < $valores[0]['historiaDeVida']) {
						$situacao++;
						$conRod  =  $valores[0]['historiaDeVida'] - $bolsistas[$i]['historiaDeVida'];
						//
						$rod = 'História de Vida: Faltando '.$conRod.';  ';
					}else{
						$rod = '';
					}

					if ($bolsistas[$i]['interacao'] < $valores[0]['interacao']) {
						$situacao++;
						$conInt  =  $valores[0]['interacao'] - $bolsistas[$i]['interacao'];
						//
						$int = 'Interação: Faltando '.$conInt.';  ';
					}else{
						$int = '';
					}

					if ($bolsistas[$i]['apreciacao'] < $valores[0]['apreciacao']) {
						$situacao++;
						$conApe  =  $valores[0]['apreciacao'] - $bolsistas[$i]['apreciacao'];
						//
						$ape = 'Apreciação de Memorial: Faltando '.$conApe.';  ';
					}else{
						$ape = '';
					}	
					
				}else if ($bolsistas[$i]['tipoSlug'] == 'prece-escola') {
					$situacao = 0;
					$projeto 	= '';
					$cadast 	= '';
					$encont 	= '';
					$apoio 		= '';
					$formacao 	= '';
					$rod 		= '';
					$int 		= '';
					$ape 		= '';
					$atiCom 	= '';
					$preRe 		= '';
					$rg 		= '';
					$preRGC 	= '';
					$RdE 		= '';
				}else{
			
					$projeto 	= '';
					$cadast 	= '';
					$encont 	= '';
					$apoio 		= '';
					$formacao 	= '';
					$rod 		= '';
					$int 		= '';
					$ape 		= '';
					$preRe 		= '';
					$rg 		= '';
					$preRGC 	= '';

					if ($bolsistas[$i]['atiComissao'] < $valores[0]['atiComissao']) {
						$situacao++;
						$conAti  =  $valores[0]['atiComissao'] - $bolsistas[$i]['atiComissao'];
						//
						$atiCom = 'Atividade de Comissão: Faltando '.$conAti.';  ';
					}else{
						$atiCom = '';
					}

					if ($bolsistas[$i]['presencaReuniao'] < $valores[0]['presencaReuniao']) {
						$situacao++;
						$conRe  =  $valores[0]['presencaReuniao'] - $bolsistas[$i]['presencaReuniao'];
						//
						$preRe = 'Presença em Reunião de Comissão: Faltando '.$conRe.';  ';
					}else{
						$preRe = '';
					}

				}

				$form['obs'] = $projeto.$cadast.$encont.$apoio.$formacao.$rod.$int.$ape.$atiCom.$preRe.$preRGC.$preRG.$RdE;
				
				if ($situacao > 0) {
					$form['situacao'] = 'Ainda_nao';
				}else{
					$form['situacao'] = 'Normal';
				}

				$tabelaFolha = DBread($tabela, "WHERE npacce = '".$form['npacce']."'");
				if ($tabelaFolha == false) {
					if (DBcreate($tabela, $form)) {
						$cont++;
					}
				}else{
					if (DBUpDate($tabela, $form, "npacce = '".$form['npacce']."'")) {
						$cont++;
					}
				}
				if ($cont == count($bolsistas)) {
					echo '
		             <script>
		              alert("Folha atualizada com sucesso em '.date('d/m/y H:i:s').'");
		                window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
		              </script>';
				}
			}
			
		}
	}
?>