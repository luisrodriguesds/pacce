<?php 
if (isset($url[2]) && $url[2] != '') {
	$cod = str_replace("-reposicao", "", $url[2]);
}
?>
<style type="text/css">
	.label{ color: #4A85A0; }
</style>
<div class="title"><h2>Reposição de Atividades</h2></div>
<p>
	Página destinada a reposição das atividades que você não pode estar presente. 
	Para formação, você deve baixar os arquivos, justificar sua falta e preencher o 
	formulário de reposição. Para o Apoio à Célula, justificar a falta e com os arquivos 
	enviados pelo seu facilitador, preencher o formulário. Quando faltar História de Vida, 
	deve repor em outra sala. Já em Interações, deve repor indo pra outra interação. 
	Lembrando que as reposições e justificativas de faltas serão avaliadas pelos facilitadores e pela Avaliação.
</p><br>
<?php 
if (isset($url[2]) && substr($url[2], -16) == 'justificar-falta') {
	?>
	<br>
	<div class="title"><h2>Justificativa de Faltas - <?php echo str_replace("-justificar-falta", "", $url[2]); ?></h2></div>
	<?php 
	if (isset($_POST['enviar'])) {
		$form['npacce'] = $user['npacce'];
		$form['codigo']	= str_replace("-justificar-falta", "", $url[2]);
		if ($user['tipoSlug'] == 'articulador-de-celula') {
			$form['semana'] = substr(str_replace("-justificar-falta", "", $url[2]), -4, 2);	
		}else{
			$form['semana'] = substr(str_replace("-justificar-falta", "", $url[2]), -2, 2);
		}
		$form['justificativa'] = GetPost('justificativa');
		$form['registro'] = date('Y-m-d H:i:s');
		$form['status']	= 1;
		if (empty($form['justificativa'])) {
			echo '<script>alert("Campo Justificativa vazio!");</script>';
		}else{
			$just = DBread('just_ativ', "WHERE npacce = '".$user['npacce']."' AND codigo = '".$form['codigo']."'");
			if ($just == false) {
				if (DBcreate('just_ativ', $form)) {
					echo '<script>alert("Justificativa enviada com sucesso!!");
					window.location="'.$way.'/'.$url[1].'";</script>';
				}
			}else{
				if (DBUpDate('just_ativ', $form, "codigo = '".$form['noacce']."' AND npacce = '".$user['npacce']."'")) {
					echo '<script>alert("Justificativa enviada com sucesso!!");
					window.location="'.$way.'/'.$url[1].'";</script>';
				}
			}

		}
	}

	$just = DBread('just_ativ', "WHERE codigo = '".str_replace("-justificar-falta", "", $url[2])."' AND npacce = '".$user['npacce']."'");
	?>
	<div id="editar-ativ" class="form">
		<form method="post">
			<label class="label">Justificativa </label><span style="color: red;">   *</span>
			<br>Diga-nos por qual(is) motivo(s) você faltou. Não esqueça de especificar no espaço abaixo a qual reunião/formação você faltou. No caso de Reunião Geral: Reunião Geral de Agosto ou no caso de Formação, coloque o respectivo código fornecido pelo facilitador.<br>
			<textarea name="justificativa"><?php if($just == true){ echo $just[0]['justificativa'];} ?></textarea>
			<center>
				<input type="submit" name="enviar" value="Enviar"></input>
			</center>
		</form>
	</div>
	<?php
}else if(isset($url[2]) && substr($url[2], -9) == 'reposicao'){
	if (substr($cod, 0, 3) == 'FOR' && $user['tipoSlug'] == 'articulador-de-celula') {
		$repo = DBread('rep_ativ', "WHERE npacce = '".$user['npacce']."' AND codigo = '".$cod."'");
		if (isset($_POST['enviar'])) {
			$form['npacce']		= $user['npacce'];
			$form['codigo']	 	= $cod;

			$form['resenha'] 	= GetPost('resenha');
			$form['status']	 	= 1;
			$form['registro']  	= date('Y-m-d H:i:s');
			$rep['presenca'] 	= 4;
			$rep['entrada'] 	= '09:00:00';
			$rep['saida']		= '12:00:00';
			if (strlen($form['resenha']) < 4000) {
				echo '<script>alert("Resenha do Texto com Caracteres insuficiente!");</script>';
			}else{
				if ($repo == false) {
					if (DBcreate('rep_ativ', $form)) {
						if (DBupDate('for_pres', $rep, "codigo = '".$form['codigo']."' AND npacce = '".$user['npacce']."'")) {
							$link = DBread('link_av', "WHERE npacce = '".$user['npacce']."'");
							if ($link == false) {
								echo '<script>alert("Você não está linkado com nenhum avaliador, mas sua reposição foi enviada com sucesso! Procure informar ao seu avaliador");
								window.location="'.$way.'/'.$url[1].'";</script>';	
							}else{
								$msg['npacceRemetente'] 	= $user['npacce'];
								$msg['remetente']			= $user['nome'];
								$msg['npacceDestinatario']	= $link[0]['npacceAv'];
								$msg['destinatario']		= $link[0]['nomeAv'];
								$msg['assunto']				= '[Mensagem Automática]';
								$msg['conteudo']			= 'Esse articulador enviou sua reposição de FORMAÇÃO para análise, por favor a verifique. <br><br> <strong>SIGA - PACCE</strong>';
								$msg['status']				= 1;
								$msg['ler']					= 0;
								$msg['registro']			= date('y-m-d H:i:s');
								if (DBcreate('msg', $msg)) {
									echo '<script>alert("Reposição enviada com sucesso! Agora sua reposição está em análise e uma mensagem automática foi enviada ao seu avaliador, quando sua reposição for avaliada, uma mensagem automática chegará na sua caixa de entrada do sistema, fique atento.");
									window.location="'.$way.'/'.$url[1].'";</script>';
								}
							}
						}
					}
				}else{
					if (DBUpDate('rep_ativ', $form, "npacce = '".$user['npacce']."' AND codigo = '".$form['codigo']."' ")) {
						if (DBupDate('for_pres', $rep, "codigo = '".$form['codigo']."' AND npacce = '".$user['npacce']."' ")) {
							$link = DBread('link_av', "WHERE npacce = '".$user['npacce']."'");
							if ($link == false) {
								echo '<script>alert("Você não está linkado com nenhum avaliador, mas sua reposição foi enviada com sucesso! Procure informar ao seu avaliador");
								window.location="'.$way.'/'.$url[1].'";</script>';	
							}else{
								$msg['npacceRemetente'] 	= $user['npacce'];
								$msg['remetente']			= $user['nome'];
								$msg['npacceDestinatario']	= $link[0]['npacceAv'];
								$msg['destinatario']		= $link[0]['nomeAv'];
								$msg['assunto']				= '[Mensagem Automática]';
								$msg['conteudo']			= 'Esse articulador enviou sua reposição de FORMAÇÃO para análise, por favor a verifique. <br><br> <strong>SIGA - PACCE</strong>';
								$msg['status']				= 1;
								$msg['ler']					= 0;
								$msg['registro']			= date('y-m-d H:i:s');
								if (DBcreate('msg', $msg)) {
									echo '<script>alert("Reposição enviada com sucesso! Agora sua reposição está em análise e uma mensagem automática foi enviada ao seu avaliador, quando sua reposição for avaliada, uma mensagem automática chegará na sua caixa de entrada do sistema, fique atento.");
									window.location="'.$way.'/'.$url[1].'";</script>';
								}
							}
						}
					}
				}

			}
			
		}
		?>
		<br>
		<div class="title"><h2>Reposição de Formação - <?php echo $cod; ?></h2></div>
		<div id="editar-ativ" class="form">		
			<form method="post">

				<label class="label"><h3>Abordagem do Tema</h3></label> <span style="color: red;"></span>
				<p>Desenvolva um texto apartir do tema da semana com os seguintes tópicos
					<ul>
						<li>Introdução</li>
						<li>Desenvolvimento do Tema</li>
						<li title="Buscar um situação no cotidiano no qual o tema por ser aplicado">Aplicação no cotidiano</li>
						<li>Bibliografica</li>
					</ul>
					<span style="color: red;">Escreva sua reposição em um documento de word e após efetuada cole aqui!!</span>
				</p>
				<br>
				<label class="label">Resenha do Texto</label><span style="color: red;">   *</span>
				<br>Transcreva a resenha do texto lido<br>
				<textarea name="resenha"><?php if($repo == true){ echo $repo[0]['resenha'];} ?></textarea>
				<span style="color: red;">Precisa ter pelo menos 4000 caracteres e no máximo 5000.</span>
				<br><br>
				<center>
					<input type="submit" name="enviar" value="Enviar"></input>
				</center>
			</form>
		</div>

		<?php
	}else if(substr($cod, 0, 3) == 'APO' && $user['tipoSlug'] == 'articulador-de-celula'){
		$repo = DBread('rep_ativ', "WHERE npacce = '".$user['npacce']."' AND codigo = '".$cod."'");

		if (isset($_POST['enviar'])) {
			$form['npacce']	 	= $user['npacce'];
			$form['codigo']	 	=  $cod;
			$form['resenha'] 	= str_replace("'", "", $_POST['resenha']);;
			$form['status']	 	= 1;
			$form['registro']  	= date('Y-m-d H:i:s');
			$rep['presenca'] 	= 4;
			$rep['entrada'] 	= '10:00:00';
			$rep['saida']		= '11:00:00';

			if (strlen($form['resenha']) < 1200) {
				echo '<script>alert("Resenha do Texto com Caracteres insuficiente!");</script>';
			}else{
				if ($repo == false) {
					if (DBcreate('rep_ativ', $form)) {
						if (DBupDate('apo_pres', $rep, "codigo = '".$form['codigo']."' AND npacce = '".$user['npacce']."'")) {
							$link = DBread('link_av', "WHERE npacce = '".$user['npacce']."'");
							if ($link == false) {
								echo '<script>alert("Você não está linkado com nenhum avaliador, mas sua reposição foi enviada com sucesso! Procure informar ao seu avaliador");
								window.location="'.$way.'/'.$url[1].'";</script>';	
							}else{
								$msg['npacceRemetente'] 	= $user['npacce'];
								$msg['remetente']			= $user['nome'];
								$msg['npacceDestinatario']	= $link[0]['npacceAv'];
								$msg['destinatario']		= $link[0]['nomeAv'];
								$msg['assunto']				= '[Mensagem Automática]';
								$msg['conteudo']			= 'Esse articulador enviou sua reposição de APOIO À CÉLULA para análise, por favor a verifique. <br><br> <strong>SIGA - PACCE</strong>';
								$msg['status']				= 1;
								$msg['ler']					= 0;
								$msg['registro']			= date('y-m-d H:i:s');
								if (DBcreate('msg', $msg)) {
									echo '<script>alert("Reposição enviada com sucesso! Agora sua reposição está em análise e uma mensagem automática foi enviada ao seu avaliador, quando sua reposição for avaliada, uma mensagem automática chegará na sua caixa de entrada do sistema, fique atento.");
									window.location="'.$way.'/'.$url[1].'";</script>';
								}
							}
						}
					}
				}else{
					if (DBUpDate('rep_ativ', $form, "codigo = '".$form['codigo']."' AND npacce = '".$user['npacce']."'")) {
						if (DBupDate('apo_pres', $rep, "codigo = '".$form['codigo']."' AND npacce = '".$user['npacce']."'")) {
							$link = DBread('link_av', "WHERE npacce = '".$user['npacce']."'");
							if ($link == false) {
								echo '<script>alert("Você não está linkado com nenhum avaliador, mas sua reposição foi enviada com sucesso! Procure informar ao seu avaliador");
								window.location="'.$way.'/'.$url[1].'";</script>';	
							}else{
								$msg['npacceRemetente'] 	= $user['npacce'];
								$msg['remetente']			= $user['nome'];
								$msg['npacceDestinatario']	= $link[0]['npacceAv'];
								$msg['destinatario']		= $link[0]['nomeAv'];
								$msg['assunto']				= '[Mensagem Automática]';
								$msg['conteudo']			= 'Esse articulador enviou sua reposição de APOIO À CÉLULA para análise, por favor a verifique. <br><br> <strong>SIGA - PACCE</strong>';
								$msg['status']				= 1;
								$msg['ler']					= 0;
								$msg['registro']			= date('y-m-d H:i:s');
								if (DBcreate('msg', $msg)) {
									echo '<script>alert("Reposição enviada com sucesso! Agora sua reposição está em análise e uma mensagem automática foi enviada ao seu avaliador, quando sua reposição for avaliada, uma mensagem automática chegará na sua caixa de entrada do sistema, fique atento.");
									window.location="'.$way.'/'.$url[1].'";</script>';
								}
							}
						}
					}
				}
			}
		}
		?>
		<div class="title"><h2>Reposição de Apoio à Célula - <?php echo $cod; ?></h2></div>
		<div id="editar-ativ" class="form">	
			<form method="post">
				<label class="label">Resenha</label><span style="color: red;">   *</span>
				<br>Escreva um resumo tecendo comentários acerca do assunto tratado no encontro que você faltou fornecido pelo Apoiador.<br>
				<textarea name="resenha"><?php if($repo == true){ echo $repo[0]['resenha'];} ?></textarea>
				<span style="color: red;">Precisa ter pelo menos 1200 caracteres.</span>
				<br><br>
				<center>
					<input type="submit" name="enviar" value="Enviar"></input>
				</center>
			</form>	
		</div>
		<?php
	}else if(substr($cod, 0, 3) != 'RGM' && $user['tipoSlug'] != 'articulador-de-celula'){
		if (isset($_POST['enviar'])) {
			$form['npacce']	 = $user['npacce'];
			$form['codigo']	 =  $cod;
			$form['resgate'] = GetPost('resgate');
			$form['resenha'] = GetPost('resenha');
			$form['status']	 = 1;
			$form['registro']  = date('Y-m-d H:i:s');
			$rep['presenca'] = 2;
			$rep['entrada'] = '08:00:00';
			$rep['saida']	= '12:00:00';
			if (strlen($form['resgate']) < 300) {
				echo '<script>alert(" Resgate com Caracteres insuficiente!");</script>';
			}else if (strlen($form['resenha']) < 300) {
				echo '<script>alert("Resenha do Texto com Caracteres insuficiente!");</script>';
			}else{
				if (DBcreate('rep_ativ', $form)) {
					
					echo '<script>alert("Reposição enviada com sucesso!");
					window.location="'.$way.'/'.$url[1].'";</script>';
					
				}
			}
		}
		?>
		<br>
		<div class="title"><h2>Reposição de Reunião de Comissão - <?php echo $cod; ?></h2></div>
		<div id="editar-ativ" class="form">		
			<form method="post">
				
				<br><br>
				<label class="label">Resgate da Reunião de Comissão</label><span style="color: red;">   *</span>
				<p>Faça o resgate da reunião conversando com os seus colegas de comissão que participaram da reunião.<br>
				Siga o roteiro baixado no site</p>
				<br>
				<textarea name="resgate"><?php echo str_replace('\r\n', " ", GetPost('resgate')); ?></textarea>
				<span style="color: red;">Precisa ter pelo menos 300 caracteres.</span>
				<br><br><br>
				<label class="label">Resenha do Texto</label><span style="color: red;">   *</span>
				<p>Este espaço é reservado para você contar qual e como foi a sua reposição combinada com o seu ATec, e vai colocar aqui o resultado dela.<br>
				<span style="color: red;"><b>OBS:</b></span> Lembre-se de fazer a descrição de qual foi o combinado e posterior à isso, coloque a sua reposição.</p>
				<br>
				<textarea name="resenha"><?php echo str_replace('\r\n', " ", GetPost('resenha'));; ?></textarea>
				<br><br>
				<center>
					<input type="submit" name="enviar" value="Enviar"></input>
				</center>
			</form>
		</div>
		<?php
	}else{
		$check = DBread('eventos', "WHERE codigo = '".$cod."'");
		if ($check == false) {
			echo '<script>alert("Código inválido!! Verifique se o código foi passado corretamente para a url");
			window.location="'.$way.'/'.$url[1].'";</script>';
		}
		$repo = DBread('rep_ativ', "WHERE npacce = '".$user['npacce']."' AND codigo = '".$cod."'");
		if (isset($_POST['enviar'])) {
			$form['npacce']	 	= $user['npacce'];
			$form['codigo']	 	=  $cod;
			$form['resgate'] 	= GetPost('resgate');
			$form['resenha'] 	= GetPost('resenha');
			$form['status']	 	= 1;
			$form['registro']  	= date('Y-m-d H:i:s');
			$rep['presenca'] 	= 4;
			$rep['entrada'] 	= '08:00:00';
			$rep['saida']		= '12:00:00';
			if (strlen($form['resgate']) < 300) {
				echo '<script>alert("Resgate com Caracteres insuficiente!");</script>';
			}else if (strlen($form['resenha']) < 5000) {
				echo '<script>alert("Resenha do Texto com Caracteres insuficiente!");</script>';
			}else{
				if ($user['tipoSlug'] == 'articulador-de-celula') {
					$link = DBread('link_av', "WHERE npacce = '".$user['npacce']."'");
				}else{
					$link = false;
				}
				if ($repo == false) {
					if ($link == true) {
						$msg['npacceRemetente'] 	= $user['npacce'];
						$msg['remetente']			= $user['nome'];
						$msg['npacceDestinatario']	= $link[0]['npacceAv'];
						$msg['destinatario']		= $link[0]['nomeAv'];
						$msg['assunto']				= '[Mensagem Automática]';
						$msg['conteudo']			= 'Esse articulador enviou sua reposição de REUNIÃO GERAL para análise, por favor a verifique. <br><br> <strong>SIGA - PACCE</strong>';
						$msg['status']				= 1;
						$msg['ler']					= 0;
						$msg['registro']			= date('y-m-d H:i:s');
						if (DBcreate('msg', $msg)) {
							if (DBcreate('rep_ativ', $form)) {
								if (DBupDate('eventos_pres', $rep, "codigo = '".$form['codigo']."' AND npacce = '".$user['npacce']."'")) {
									echo '<script>alert("Reposição enviada com sucesso!");
									window.location="'.$way.'/'.$url[1].'";</script>';
								}
							}
						}
					}else{
						if (DBcreate('rep_ativ', $form)) {
							if (DBupDate('eventos_pres', $rep, "codigo = '".$form['codigo']."' AND npacce = '".$user['npacce']."'")) {
								echo '<script>alert("Reposição enviada com sucesso!");
								window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}
					}
				}else{
					if ($link == true) {
						$msg['npacceRemetente'] 	= $user['npacce'];
						$msg['remetente']			= $user['nome'];
						$msg['npacceDestinatario']	= $link[0]['npacceAv'];
						$msg['destinatario']		= $link[0]['nomeAv'];
						$msg['assunto']				= '[Mensagem Automática]';
						$msg['conteudo']			= 'Esse articulador enviou sua reposição de REUNIÃO GERAL para análise, por favor a verifique. <br><br> <strong>SIGA - PACCE</strong>';
						$msg['status']				= 1;
						$msg['ler']					= 0;
						$msg['registro']			= date('y-m-d H:i:s');
						if (DBcreate('msg', $msg)) {
							if (DBupDate('rep_ativ', $form, "npacce = '".$user['npacce']."' AND codigo = '".$cod."'")) {
								if (DBupDate('eventos_pres', $rep, "codigo = '".$form['codigo']."' AND npacce = '".$user['npacce']."'")) {
									echo '<script>alert("Reposição enviada com sucesso!");
									window.location="'.$way.'/'.$url[1].'";</script>';
								}
							}
						}
					}else{
						if (DBupDate('rep_ativ', $form, "npacce = '".$user['npacce']."' AND codigo = '".$cod."'")) {
							if (DBupDate('eventos_pres', $rep, "codigo = '".$form['codigo']."' AND npacce = '".$user['npacce']."'")) {
								echo '<script>alert("Reposição enviada com sucesso!");
								window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}
					}
				}
			}
		}
		?>
		<br>
		<div class="title"><h2>Reposição de Reunião Geral - <?php echo $cod; ?></h2></div>
		<div id="editar-ativ" class="form">		
			<form method="post">
				<label class="label"><h3>1ª Etapa - Resgate da Semana</h3></label>
				<p>Faça o resgate da reunião conversando com três bolsistas que participaram da reunião.</p>
				<br><br>
				<label class="label">Resgate da Reunião Geral</label><span style="color: red;">   *</span>
				<br>Resgatar a reunião com 3 entrevistas de pessoas que comprareceram a mesma.<br>
				<textarea name="resgate"><?php echo $repo[0]['resgate']; ?></textarea>
				<span style="color: red;">Precisa ter pelo menos 300 caracteres.</span>
				<br><br><br>
				<label class="label"><h3>2ª Etapa - Leitura do texto</h3></label>
				<p>Nesta etapa você deverá ler o texto que a coordenação lhe disponibilizou e em seguida faça uma resenha dele.</p>
				<br>
				<label class="label">Resenha do Texto</label><span style="color: red;">   *</span>
				<br>Transcreva a resenha do texto lido<br>
				<textarea name="resenha"><?php echo $repo[0]['resenha']; ?></textarea>
				<span style="color: red;">Precisa ter pelo menos 5000 caracteres.</span>
				<br><br>
				<center>
					<input type="submit" name="enviar" value="Enviar"></input>
				</center>
			</form>
		</div>
		<?php
	}

}else{
	?>
	<br>
	<?php 


	if ($user['tipoSlug'] == 'articulador-de-celula') {
		?>
		<div class="title"><h2>Formação</h2></div>
		<?php 
		$for = DBread('for_pres', "WHERE npacce ='".$user['npacce']."' AND presenca = 0 OR npacce ='".$user['npacce']."' AND presenca = 2 OR npacce ='".$user['npacce']."' AND presenca = 3 OR npacce ='".$user['npacce']."' AND presenca = 4 ORDER BY semana ASC");
		if ($for == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
			?>
			<div class="tabela">
				<table>
					<tr>
						<th>Código</th>
						<th>Semana</th>
						<th>Horas</th>
						<th>Situação</th>
						<th colspan="3">Ações</th>
					</tr>
					<?php 
					for ($i=0; $i < count($for); $i++) { 
						?>
						<tr>
							<td><?php echo $for[$i]['codigo']; ?></td>
							<td><?php echo substr($for[$i]['codigo'], -4, 2); ?></td>
							<td>03:00hr</td>
							<td><?php if($for[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($for[$i]['presenca'] == 0){ echo 'Você não esteve presente, por favor faça sua reposição!';}else if($for[$i]['presenca'] == 2){ echo 'Reposição aprovada!';}else if($for[$i]['presenca'] == 4){ echo 'Reposição em análise';}else if($for[$i]['presenca'] == 3){ echo 'Reposição precisa ser refeita';} ?></td>
							<td><a href="<?php echo URL_PAINEL.'reposicao/FOR'.date('y').substr($for[$i]['codigo'], -4, 2).'.pdf'; ?>">Baixar</a></td>
							<td><a href="<?php echo $way.'/'.$url[1].'/'.$for[$i]['codigo'].'-justificar-falta'; ?>">Justificar Falta</a></td>
							<td><a href="<?php echo $way.'/'.$url[1].'/'.$for[$i]['codigo'].'-reposicao'; ?>">Reposição</a></td>
						</tr>
						<?php
					} 
					?>
				</table>
				<div id="cont">(<?php echo count($for); ?>)</div>
			</div>
			<?php
		}
		?>
		<br>
		<div class="title"><h2>História de Vida</h2></div>
		<?php 
		$rod = DBread('rod_pres', "WHERE npacce ='".$user['npacce']."' AND presenca = 0 OR npacce ='".$user['npacce']."' AND presenca = 2 OR npacce ='".$user['npacce']."' AND presenca = 3 OR npacce ='".$user['npacce']."' AND presenca = 4 ORDER BY semana ASC");
		if ($rod == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
			?>
			<div class="tabela">
				<table>
					<tr>
						<th>Código</th>
						<th>Semana</th>
						<th>Horas</th>
						<th>Situação</th>
						<th colspan="3">Ações</th>
					</tr>
					<?php 
					for ($i=0; $i < count($rod); $i++) { 
						?>
						<tr>
							<td><?php echo $rod[$i]['codigo']; ?></td>
							<td><?php echo substr($rod[$i]['codigo'], -4, 2); ?></td>
							<td>01:00hr</td>
							<td><?php if($rod[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($rod[$i]['presenca'] == 0){ echo 'Você não esteve presente, por favor faça sua reposição!';}else if($rod[$i]['presenca'] == 2){ echo 'Você não esteve presente, mas efetuou a reposição!';} ?></td>
							<td>  </td>
							<td><a href="<?php echo $way.'/'.$url[1].'/'.$rod[$i]['codigo'].'-justificar-falta'; ?>">Justificar Falta</a></td>
							<td>  </td>
						</tr>
						<?php 
					} 
					?>
				</table>
				<div id="cont">(<?php echo count($rod); ?>)</div>
			</div>
			<?php
		} 
		?>
		<br>
		<div class="title"><h2>Apoio à Célula</h2></div>
		<?php 
		$apo = DBread('apo_pres', "WHERE npacce ='".$user['npacce']."' AND presenca = 0 OR npacce ='".$user['npacce']."' AND presenca = 2 OR npacce ='".$user['npacce']."' AND presenca = 3 OR npacce ='".$user['npacce']."' AND presenca = 4 ORDER BY semana ASC");
		if ($apo == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
			?>
			<div class="tabela">
				<table>
					<tr>
						<th>Código</th>
						<th>Semana</th>
						<th>Horas</th>
						<th>Situação</th>
						<th colspan="3">Ações</th>
					</tr>
					<?php 
					for ($i=0; $i < count($apo); $i++) { 
						?>
						<tr>
							<td><?php echo $apo[$i]['codigo']; ?></td>
							<td><?php echo substr($apo[$i]['codigo'], -4, 2); ?></td>
							<td>01:00hr</td>
							<td><?php if($apo[$i]['presenca'] == 1){ echo 'Você esteve presente!';}else if($apo[$i]['presenca'] == 0){ echo 'Você não esteve presente, por favor faça sua reposição!';}else if($apo[$i]['presenca'] == 2){ echo 'Reposição aprovada!';}else if($apo[$i]['presenca'] == 4){ echo 'Reposição em análise!';}else if($apo[$i]['presenca'] == 3){ echo 'Reposição precisa ser refeita!';} ?></td>
							<td>  </td>
							<td><a href="<?php echo $way.'/'.$url[1].'/'.$apo[$i]['codigo'].'-justificar-falta'; ?>">Justificar Falta</a></td>
							<td> <a href="<?php echo $way.'/'.$url[1].'/'.$apo[$i]['codigo'].'-reposicao'; ?>">Reposição</a> </td>
						</tr>
						<?php 
					} 
					?>
				</table>
				<div id="cont">(<?php echo count($apo); ?>)</div>
			</div>
			<?php 
		}
		?>
		<br>
		<div class="title"><h2>Interação</h2></div>
		<?php 
		$int = DBread('int_insc', "WHERE npacce ='".$user['npacce']."' AND situacao = 2");
		if ($int == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
			?>
			<div class="tabela">
				<table>
					<tr>
						<th>Código</th>
						<th>Semana</th>
						<th>Horas</th>
						<th>Situação</th>
						<th colspan="3">Ações</th>
					</tr>
					<?php 
					for ($i=0; $i < count($int); $i++) { 
						?>
						<tr>
							<td><?php echo $int[$i]['codigo']; ?></td>
							<td><?php echo substr($int[$i]['codigo'], -4, 2); ?></td>
							<td>02:00hr</td>
							<td><?php if($int[$i]['situacao'] == 0){ echo 'Você está inscrito!';}else if($int[$i]['situacao'] == 1){ echo 'Você esteve presente!';}else{echo 'Você faltou essa atividade!';} ?></td>
							<td>  </td>
							<td><a href="<?php echo $way.'/'.$url[1].'/'.$int[$i]['codigo'].'-justificar-falta'; ?>">Justificar Falta</a></td>
							<td> </td>
						</tr>
						<?php 
					} 
					?>
				</table>
				<div id="cont">(<?php echo count($int); ?>)</div>
			</div>
		<?php } 
	}else{
		?>
		<div class="title"><h2>Reunião de comissão</h2></div>
		<?php 
		$reCom = DBread('av_comissao', "WHERE npacce ='".$user['npacce']."' AND presenca = 0 OR npacce ='".$user['npacce']."' AND presenca = 2");
		if ($reCom == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
			?>
			<div class="tabela">
				<table>
					<tr>
						<th>Código</th>
						<th>Semana</th>
						<th>Horas</th>
						<th>Situação</th>
						<th colspan="2">Ações</th>
					</tr>
					<?php 
					for ($i=0; $i < count($reCom); $i++) { 
						?>
						<tr>
							<td><?php echo $reCom[$i]['codigo']; ?></td>
							<td><?php echo substr($reCom[$i]['codigo'], -2, 2); ?></td> <td>04:00hr</td>
							<td><?php if($reCom[$i]['presenca'] == 0){ echo 'Faltou essa atividade';}else if($reCom[$i]['presenca'] == 2){ echo 'Efetuou a reposição';} ?></td>
							<td><a href="<?php echo $way.'/'.$url[1].'/'.$reCom[$i]['codigo'].'-justificar-falta'; ?>">Justificar Falta</a></td>
							<td><a href="<?php echo $way.'/'.$url[1].'/'.$reCom[$i]['codigo'].'-reposicao'; ?>">Reposição</a></td>
						</tr>
					<?php } ?>
				</table>
				<div id="cont">(<?php echo count($reCom); ?>)</div>
			</div>
			<?php 
		}
		?>
		<br><br>

		<?php
	}
	?>
	<br>
	<div class="title"><h2>Atividades Coletivas</h2></div>
	<?php
	$eventos = DBread('eventos_pres', "WHERE npacce = '".$user['npacce']."' AND presenca = 0 OR npacce = '".$user['npacce']."' AND presenca = 2 OR npacce = '".$user['npacce']."' AND presenca = 3 OR npacce = '".$user['npacce']."' AND presenca = 4 OR npacce = '".$user['npacce']."' AND presenca = 5");
	if ($eventos == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
		?>

		<div class="tabela">
			<table>
				<tr>
					<th>Código</th>
					<th>Evento</th>
					<th>Situação</th>
					<th colspan="3">Opções</th>
				</tr>
				<?php 
				for ($i=0; $i < count($eventos); $i++) { 
					?>	
					<tr>
						<td><?php echo $eventos[$i]['codigo']; ?></td>
						<td><?php echo $eventos[$i]['evento']; ?></td>
						<td><?php if($eventos[$i]['presenca'] == 0){ echo 'Não esteve presente, efetue sua reposição!';}else if($eventos[$i]['presenca'] == 1){ echo 'Esteve presente!';}else if($eventos[$i]['presenca'] == 2){ echo 'Saída não registrada!';}else if($eventos[$i]['presenca'] == 3){ echo 'Reposição aprovada!';}else if($eventos[$i]['presenca'] == 4){ echo 'Reposição em análise!';}else{ echo 'Reposição reprovada, por favor faça novamente!';} ?></td>
						<td><a href="<?php echo URL_PAINEL.'reposicao/'.$eventos[$i]['codigo'].'.pdf'; ?>">Baixar</a></td>
						<td><a href="<?php echo $way.'/'.$url[1].'/'.$eventos[$i]['codigo'].'-justificar-falta'; ?>">Justificar Falta</a></td>
						<td><a href="<?php echo $way.'/'.$url[1].'/'.$eventos[$i]['codigo'].'-reposicao'; ?>">Reposição</a></td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
		<?php
	}
	?>
	<br>
	<?php 
} 
?>