
<?php

			if (isset($_POST['enviar'])) {
				$form['npacce']			= $user['npacce'];
				$form['nome']			= $user['nome'];
				$msg['npacceRemetente']	= $user['npacce'];
				$msg['remetente']		= $user['nome'];
				$form['comissao']		= GetPost('comissao');
				$form['pagina'] 		= GetPost('pagina');
				$form['sugestao'] 		= GetPost('conteudo');
				

				if (empty($form['comissao']) && empty($form['pagina'])) {
					echo '<script>alert("Os dois estão vazios, escolha uma opção!");</script>';
				} else if (!empty($form['comissao']) && !empty($form['pagina'])) {
					echo '<script>alert("Escolha apenas uma opção!");</script>';
				} else {
					if(DBcreate('sugestao', $form)){
						$contFinal = 0;
						$cont = 0;
						if(empty(GetPost('pagina'))){
							for ($i=0; $i < count($_REQUEST['comissao']); $i++) { 
							$membro = DBread('bolsistas', "WHERE tipoSlug = '".$_REQUEST['comissao']."' AND status = 1", "id, npacce, nome, email");
							$contFinal = $contFinal + count($membro);
							for ($j=0; $j < count($membro); $j++) { 
								$msg['npacceDestinatario']	= $membro[$j]['npacce'];
								$msg['destinatario']		= $membro[$j]['nome'];
								$msg['assunto']				= "Nova Sugestão";
								$msg['conteudo']			= GetPost('conteudo');
								$msg['registro']			= date('Y-m-d H:i:s');
								$msg['status']				= 1;
								$msg['ler']				= 0;
								if (DBcreate('msg', $msg)) {
									$email 			 =	$membro[$j]['email'];
									$mensagem        = '<meta charset="utf-8"><h2>PACCE - UFC</h2><br><p>Teste <a href="http://pacce.ufc.br/pacce/login">pacce.ufc.br</a></p><br><br><strong style="color: red;">EMAIL AUTOMÁTICO, POR FAVOR NÃO RESPONDA.</strong>';
									$email_remetente = "pacce.monitoria@eideia.ufc.br";
									$headers = "MINE-Version: 1.1\n";
								    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
								    $headers .= "From: $email_remetente\n";
								    $headers .= "Return: $email_remetente\n";
								    $headers .= "Replay-To: $email\n";
									$cont++;
								   /* if (mail("$email", "PACCE - UFC", "$mensagem", $headers, "-f$email_remetente")) {
								    	$cont++;
								    }*/
								}
							}
						}
						if ($contFinal == $cont) {
							echo '<script>alert("Sugestão enviadas com sucesso!");
	        				window.location="'.$way.'";</script>';
						}
					}else{
						 for ($i=0; $i < count($_REQUEST['comissao']); $i++) { 
							$membro = DBread('bolsistas',"WHERE tipoSlug = 'ceo' AND status = 1","id, npacce, nome, email");
							$contFinal = $contFinal + count($membro);
							for ($j=0; $j < count($membro); $j++) { 
								$msg['npacceDestinatario']	= $membro[$j]['npacce'];
								$msg['destinatario']		= $membro[$j]['nome'];
								$msg['assunto']				= "Nova Sugestão";
								$msg['conteudo']			= GetPost('conteudo');
								$msg['registro']			= date('Y-m-d H:i:s');
								$msg['status']				= 1;
								$msg['ler']				= 0;
								if (DBcreate('msg', $msg)) {
									$email 			 =	$membro[$j]['email'];
									$mensagem        = '<meta charset="utf-8"><h2>PACCE - UFC</h2><br><p>Você recebeu uma sugestão, por favor verifique sua caixa de entrada em <a href="http://pacce.ufc.br/pacce/login">pacce.ufc.br</a></p><br><br><strong style="color: red;">EMAIL AUTOMÁTICO, POR FAVOR NÃO RESPONDA.</strong>';
									$mensagem		= GetPost('conteudo');
									$email_remetente = "pacce.monitoria@eideia.ufc.br";
									$headers = "MINE-Version: 1.1\n";
								    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
								    $headers .= "From: $email_remetente\n";
								    $headers .= "Return: $email_remetente\n";
								    $headers .= "Replay-To: $email\n";
									
								   if (mail("$email", "PACCE - UFC", "$mensagem", $headers, "-f$email_remetente")) {
								    	$cont++;
								    }
								}
							}
						}
						if ($contFinal == $cont) {
							echo '<script>alert("Sugestão enviadas com sucesso!");
	        				window.location="'.$way.'";</script>';
						}
					}
				}
		}
	}
?>

<div id="editar-ativ" class="form">
	<form action="" method="post" enctype="multipart/form-data">
		<br>
		<label class="label">Selecione a comissão que deverá receber essa sugestão. </label>
		<p>
		<select name="comissao"  id=cbPais>
			<option value="">Selecionar</option>
			<?php 
			$nomeComissao = DBread('comissoes',"WHERE status=1 ORDER BY comissao ASC");
			for($i = 0; $i < count($nomeComissao); $i++){
				?> 
				<option value="<?php echo $nomeComissao[$i]['comissaoSlug']; ?>"><?php echo $nomeComissao[$i]['comissao']?></option> 
				<?php
			}
			?>
		</select>
		<br><br>
		<label class="label">Ou selecione a página relacionada a essa sugestão.</label>
		<select  name="pagina" id=cbPais>
			<option value="">Selecionar</option>
			<?php 
			$nomepagina = DBread('menu',"WHERE status=1 AND acessoSlug='".$user[tipoSlug]."' ORDER BY nome ASC","nome, nomeSlug");
			for($i = 0; $i < count($nomepagina); $i++){
				?> 
				<option value="<?php echo $nomepagina[$i]['nomeSlug']; ?>"><?php echo $nomepagina[$i]['nome']?></option> 
				<?php
			}
			?>
		</select>
		<br><br>
		<?php 
			
		?>
		
		<br>	
		<label class="label">Deixa aqui a sua sugestão</label> <span style="color: red">*</span>
		<br>
		<textarea required name="conteudo"></textarea>			
		<br>
		<center>
			<input type="submit" name="enviar" value="Enviar"></input>
		</center>
	</form>
</div>
