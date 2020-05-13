<div class="title"><h2>Encontros Universitários</h2></div>
<p>Nesta aba serão cadastradas cada etapa do Artigo.</p>
<br>
<br>

<?php 
	if (isset($url[2]) && $url[2] == 'cadastrar-trio') {
		//PÁGINA DE CADASTRO DE TRIO
		if (isset($_POST['enviar'])) {
			$form['npacce1'] = GetPost('npacce1');
			$form['npacce2'] = GetPost('npacce2');
			$form['npacce3'] = GetPost('npacce3');
			$form['npacce4'] = GetPost('npacce4');

			if (empty($form['npacce1'])) {
				echo '<script>alert("Campo número PACCE está vazio!!")</script>';
			}else if (empty($form['npacce2'])) {
				echo '<script>alert("Campo número PACCE está vazio!!")</script>';
			}else if ($form['npacce1'] == $form['npacce2']) {
				echo '<script>alert("Exisite número PACCE repetido")</script>';
			}else if (!empty($form['npacce3']) && $form['npacce1'] == $form['npacce3']) {
				echo '<script>alert("Exisite número PACCE repetido")</script>';
			}else if (!empty($form['npacce3']) && $form['npacce2'] == $form['npacce3']) {
				echo '<script>alert("Exisite número PACCE repetido")</script>';
			}else if (!empty($form['npacce4']) && $form['npacce1'] == $form['npacce4']) {
				echo '<script>alert("Exisite número PACCE repetido")</script>';
			}else if (!empty($form['npacce4']) && $form['npacce2'] == $form['npacce4']) {
				echo '<script>alert("Exisite número PACCE repetido")</script>';
			}else if (!empty($form['npacce4']) && $form['npacce3'] == $form['npacce4']) {
				echo '<script>alert("Exisite número PACCE repetido")</script>';
			}else{
				$npacce1 = DBread('bolsistas', "WHERE npacce = '".$form['npacce1']."'", "id,npacce,nome,cpf, email");
				$npacce2 = DBread('bolsistas', "WHERE npacce = '".$form['npacce2']."'", "id,npacce,nome,cpf, email");
				if (!empty($form['npacce3'])) {
					$npacce3 = DBread('bolsistas', "WHERE npacce = '".$form['npacce3']."'", "id,npacce,nome,cpf, email");
				}else{
					$npacce3 = true;
				}
				if (!empty($form['npacce4'])) {
					$npacce4 = DBread('bolsistas', "WHERE npacce = '".$form['npacce4']."'", "id,npacce,nome,cpf, email");
				}else{
					$npacce4 = true;
				}
				if ($npacce1 == false) {
					echo '<script>alert("O primeiro número PACCE digitado não existe")</script>';
				}else if($npacce2 == false){
					echo '<script>alert("O segunda número PACCE digitado não existe")</script>';
				}else if (!empty($form['npacce3']) && $npacce3 == false) {
					echo '<script>alert("O terceiro número PACCE digitado não existe")</script>';
				}else if (!empty($form['npacce4']) && $npacce4 == false) {
					echo '<script>alert("O terceiro número PACCE digitado não existe")</script>';
				}else{
					$check1 = DBread('encontros_trios', "WHERE npacce1 = '".$form['npacce1']."' OR npacce2 = '".$form['npacce1']."' OR npacce3 = '".$form['npacce1']."' OR npacce4 = '".$form['npacce1']."' ", "id");
					$check2 = DBread('encontros_trios', "WHERE npacce1 = '".$form['npacce2']."' OR npacce2 = '".$form['npacce2']."' OR npacce3 = '".$form['npacce2']."' OR npacce4 = '".$form['npacce2']."' ", "id");
					$check3 = false;
					$check4 = false;
					if (!empty($form['npacce3'])) {
						$check3 = DBread('encontros_trios', "WHERE npacce1 = '".$form['npacce3']."' OR npacce2 = '".$form['npacce3']."' OR npacce3 = '".$form['npacce3']."' OR npacce4 = '".$form['npacce3']."' ", "id");	
					}
					if (!empty($form['npacce4'])) {
						$check4 = DBread('encontros_trios', "WHERE npacce1 = '".$form['npacce4']."' OR npacce2 = '".$form['npacce4']."' OR npacce3 = '".$form['npacce4']."' OR npacce4 = '".$form['npacce4']."' ", "id");	
					}
					if ($check1 == true || $check2 == true || $check3 == true || $check4 == true) {
						echo '<script>alert("Existe Algum número PACCE já cadadastrado em algum trio")</script>';
					}else{
						$select = DBread('encontros_trios', "ORDER BY registro DESC");
						if ($select == false) {
							$form['nome1'] 		= $npacce1[0]['nome'];
							$form['cpf1']		= $npacce1[0]['cpf'];
							$form['email1']		= $npacce1[0]['email'];
							   
							$form['nome2'] 		= $npacce2[0]['nome'];
							$form['cpf2']		= $npacce2[0]['cpf'];
							$form['email2']		= $npacce2[0]['email'];

							$form['nome3'] 		= $npacce3[0]['nome'];
							$form['cpf3']		= $npacce3[0]['cpf'];
							$form['email3']		= $npacce3[0]['email'];

							$form['nome4'] 		= $npacce4[0]['nome'];
							$form['cpf4']		= $npacce4[0]['cpf'];
							$form['email4']		= $npacce4[0]['email'];

							$form['trioSlug'] 	= 'T-01';
							$form['trioCod']	= 1;

							$form['registro'] 	= date('Y-m-d H:i:s');
							$form['status'] 	= 1;
							if (DBcreate('encontros_trios', $form)) {
								 echo '
				                 <script>
				                  alert("Cadastro Realizado com Sucesso!! \n Código do trio: T-01\n Membros:\n '.$form['nome1'].' \n '.$form['nome2'].' \n '.$form['nome3'].' \n '.$form['nome4'].'");
				                    window.location="'.$way.'/'.$url[1].'";
				                  </script>';
							}
						}else{
							$codigo = $select[0]['trioCod'] + 1;
							if ($codigo < 10) {
								$form['trioSlug'] = 'T-0'.$codigo;
							}else{
								$form['trioSlug'] = 'T-'.$codigo;
							}
							$form['trioCod'] 	= $codigo;
							$form['nome1'] 		= $npacce1[0]['nome'];
							$form['cpf1']		= $npacce1[0]['cpf'];
							$form['email1']		= $npacce1[0]['email'];
							
							$form['nome2'] 		= $npacce2[0]['nome'];
							$form['cpf2']		= $npacce2[0]['cpf'];
							$form['email2']		= $npacce2[0]['email'];

							$form['nome3'] 		= $npacce3[0]['nome'];
							$form['cpf3']		= $npacce3[0]['cpf'];
							$form['email3']		= $npacce3[0]['email'];

							$form['nome4'] 		= $npacce4[0]['nome'];
							$form['cpf4']		= $npacce4[0]['cpf'];
							$form['email4']		= $npacce4[0]['email'];

							$form['registro'] 	= date('Y-m-d H:i:s');
							$form['status'] 	= 1;
							if (DBcreate('encontros_trios', $form)) {
								 echo '
				                 <script>
				                  alert("Cadastro Realizado com Sucesso!! \n Código do trio: '.$form['trioSlug'].' \n Membros:\n '.$form['nome1'].' \n '.$form['nome2'].' \n '.$form['nome3'].' \n '.$form['nome4'].'");
				                    window.location="'.$way.'/'.$url[1].'";
				                  </script>';
							}
						}
					}
				}	
			}
		}
?>

	<div class="title"><h2>Cadastro de Trio</h2></div>
	<div id="editar-ativ" class="form">
	   <form action="" method="post" enctype="multipart/form-data">
		   
				<label class="label">Número PACCE</label> <span style="color: red">  *</span>
				<input type="text" name="npacce1" value=""  maxlength="7" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" placeholder="Digite um número PACCE"/>
				<br><br>

				<label class="label">Número PACCE</label> <span style="color: red">  *</span>
				<input type="text" name="npacce2" value=""  maxlength="7" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" placeholder="Digite um número PACCE"/>
				<br><br>

				<label class="label">Número PACCE</label> 
				<input type="text" name="npacce3" value=""  maxlength="7" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" placeholder="Digite um número PACCE"/>
				<br><br>

				<label class="label">Número PACCE</label>
				<input type="text" name="npacce4" value=""  maxlength="7" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" placeholder="Digite um número PACCE"/>
				<br><br>

				<center>
					<input type="submit" name="enviar" value="Enviar">
				</center>
	   </form>
	</div>
<?php
	//FIM PÁGINA DE CADASTRO DE TRIO
	}else if (isset($url[2]) && $url[2] == 'resumo'){
		$v = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$v=$v[0];
			if (isset($_POST['enviar'])) {
				$form['titulo'] = GetPost('titulo');
				$form['area'] = GetPost('area');
				$form['resumo'] = GetPost('resumo');
				$form['palavras_chave'] = GetPost('palavras-chave');
				if (empty($form['titulo'])) {
					echo '<script> alert("Campo título está vazio");</script>';
				}else if ($form['area'] == 1) {
					echo '<script> alert("Campo area está vazio");</script>';
				}else if(strlen($form['resumo']) < 1400){
					echo '<script> alert("Campo resumo está com caracteres insuficientes");</script>';
				}else {
					if (DBUpDate('encontros_trios', $form,"npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3 = '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'")) {
					echo '
	                 <script>
	                  alert("Resumo enviado com Sucesso!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
					}else{
						echo '
		                 <script>
		                  alert("Ocorreu um erro!");
		                    window.location="'.$way.'/'.$url[1].'";
		                  </script>';
					}
				}	
			}
		?>
		<div class="title"><h2>Enviar Resumo</h2></div>
		<div id="editar-ativ" class="form">
	   	<form action="" method="post" enctype="multipart/form-data">
	   	<label class="label"> <strong> Aviso: </strong></label><br>
		<p style="text-align: justify">Prezado(a) Bolsista,

		Para os EU 2019 é necessário que cadastremos os resumos dos trabalhos que serão apresentados, para tanto, precisamos de alguns dados.

		Lembramos que um bolsista será o autor principal e os demais co-autores, porém todos ganharão certificado.

		Não serão aceitos mais de 4 pessoas por trabalho.
		<br>
APENAS UM DO TRIO DEVE CADASTRAR O RESUMO!<br><br></p>
	   		<label class="label"> Título do trabalho </label><span style="color:red;">*</span><br>Atenção: Escreva aqui o título do seu trabalho. Não é o tema.<br>
	   		<input type="text" value="<?php if($v == true){ echo $v['titulo'];} ?>" name="titulo" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" placeholder="Digite o título do seu artigo."/>
	   		<br><br><br>
	   		<label class="label"> Área </label><span style="color:red;">*</span><br>A que área do conhecimento pertence seu trabalho.<br>
	   		<select name="area"> 
	   			<option value="1">Selecione uma área...</option>
	   			<option value="Centro de Ciências" <?php if($v == true && $v['area'] == 'Centro de Ciências'){ echo 'selected=""';} ?>>Centro de Ciências</option>
	   			<option value="Centro de Ciências Agrárias" <?php if($v == true && $v['area'] == 'Centro de Ciências Agrárias'){ echo 'selected=""';} ?>>Centro de Ciências Agrárias</option>
	   			<option value="Centro de Humanidades" <?php if($v == true && $v['area'] == 'Centro de Humanidades'){ echo 'selected=""';} ?>>Centro de Humanidades</option>
	   			<option value="Centro de Tecnologia" <?php if($v == true && $v['area'] == 'Centro de Tecnologia'){ echo 'selected=""';} ?>>Centro de Tecnologia</option>
	   			<option value="Faculdade de Direito" <?php if($v == true && $v['area'] == 'Faculdade de Direito'){ echo 'selected=""';} ?>>Faculdade de Direito</option>
	   			<option value="Faculdade de Economia, Administração, Atuária e Contabilidade" <?php if($v == true && $v['area'] == 'Faculdade de Economia, Administração, Atuária e Contabilidade'){ echo 'selected=""';} ?>>Faculdade de Economia, Administração, Atuária e Contabilidade</option>
	   			<option value="Faculdade de Educação" <?php if($v == true && $v['area'] == 'Faculdade de Educação'){ echo 'selected=""';} ?>>Faculdade de Educação</option>
	   			<option value="Faculdade de Farmácia, Odotologia e Enfermagem" <?php if($v == true && $v['area'] == 'Faculdade de Farmácia, Odotologia e Enfermagem'){ echo 'selected=""';} ?>>Faculdade de Farmácia, Odotologia e Enfermagem</option>
	   			<option value="Faculdade de Medicina" <?php if($v == true && $v['area'] == 'Faculdade de Medicina'){ echo 'selected=""';} ?>>Faculdade de Medicina</option>
	   			<option value="Instituto de Ciências do Mar" <?php if($v == true && $v['area'] == 'Instituto de Ciências do Mar'){ echo 'selected=""';} ?>>Instituto de Ciências do Mar</option>
	   			<option value="Instituto de Cultura e Arte" <?php if($v == true && $v['area'] == 'Instituto de Cultura e Arte'){ echo 'selected=""';} ?>>Instituto de Cultura e Arte</option>
	   			<option value="Instituto de Educação Física e Esportes" <?php if($v == true && $v['area'] == 'Instituto de Educação Física e Esportes'){ echo 'selected=""';} ?>>Instituto de Educação Física e Esportes</option>
	   			<option value="Instituto Universidade Virtual" <?php if($v == true && $v['area'] == 'Instituto Universidade Virtual'){ echo 'selected=""';} ?>>Instituto Universidade Virtual</option>

	   		</select>
	   		<br><br><br>
	   		<label class="label"> Resumo </label><span style="color:red;">*</span><br><p style="text-align: justify">Conforme o (item 2.5 do EDITAL 018/2017 – PROGRAD/UFC): "Os resumos dos trabalhos deverão ser digitados, em um único parágrafo, com mínimo de 1400 e máximo de 2000 caracteres, contendo: introdução, objetivos, metodologia, resultados, conclusões e informações sobre o processamento de grupo." No entanto, após o envio do resumo não será possível fazer alterações.</p><br>
	   		<textarea name="resumo"><?php echo $v['resumo']; ?></textarea>
	   		<span style="color: red;">De 1400 a 2000 caracteres</span>
	   		<br><br><br>
	   		<label class="label"> Palavras-Chave </label><span style="color:red;">*</span><br>Digite até 3 palavras-chave acerca do seu trabalho. Separe-os por ponto e vírgula.<br>
	   		<input type="text" value="<?php echo $v['palavras_chave']; ?>" name="palavras-chave" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" placeholder="Digite as palavras-chave."/>
	   		<br><br><br><br>
	   		<center><input name="enviar" type="submit" value="Enviar"></center>
	   	</form></div>
		<?php

	}else if (isset($url[2]) && $url[2] == 'esqueleto'){

		$v = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$v=$v[0];
		if (isset($_POST['enviar'])) {
			$form['esqueleto'] = str_replace("'", "", $_POST['esqueleto']);
			if (empty($form['esqueleto'])) {
				echo '<script> alert("Campo area está vazio");</script>';
			}else{
				if (DBUpDate('encontros_trios', $form,"trioSlug = '".$v['trioSlug']."'")) {
					echo '
	                 <script>
	                  alert("Esqueleto enviado com Sucesso!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
				}
			}
		}
		?>
		<div class="title"><h2>Enviar Esqueleto</h2></div>
			<div id="editar-ativ" class="form">
			   	<form action="" method="post" enctype="multipart/form-data">
				   	<label class="label"> <strong> Esqueleto: </strong></label><br>
				   	<p>Campo destinado ao esqueleto do seu artigo.</p>
				   	<textarea name="esqueleto"><?php echo $v['esqueleto']; ?></textarea>
				   	<center><input name="enviar" type="submit" value="Enviar"></center>
				</form>
			</div>
		<?php

	}else if (isset($url[2]) && $url[2] == 'introducao'){
		$v = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$v=$v[0];
		if (isset($_POST['enviar'])) {
			$form['introducao'] = str_replace("'", "", $_POST['introducao']);
			if (empty($form['introducao'])) {
				echo '<script> alert("Campo area está vazio");</script>';
			}else{
				if (DBUpDate('encontros_trios', $form,"trioSlug = '".$v['trioSlug']."'")) {
					echo '
	                 <script>
	                  alert("Introdução enviado com Sucesso!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
				}
			}
		}
		?>
		<div class="title"><h2>Enviar introducao</h2></div>
			<div id="editar-ativ" class="form">
			   	<form action="" method="post" enctype="multipart/form-data">
				   	<label class="label"> <strong> Introdução: </strong></label><br>
				   	<p>Campo destinado à introdução do seu artigo.</p>
				   	<textarea name="introducao"><?php echo $v['introducao']; ?></textarea>
				   	<center><input name="enviar" type="submit" value="Enviar"></center>
				</form>
			</div>
		<?php

	}else if (isset($url[2]) && $url[2] == 'refTeorico'){
		$v = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$v=$v[0];
		if (isset($_POST['enviar'])) {
			// $form['refTeorico'] = str_replace("'", "", $_POST['refTeorico']);
			$form['refTeorico'] = str_replace('Ć', 'C', GetPost('refTeorico'));
			if (empty($form['refTeorico'])) {
				echo '<script> alert("Campo area está vazio");</script>';
			}else{
				if (DBUpDate('encontros_trios', $form,"trioSlug = '".$v['trioSlug']."'")) {
					echo '
	                 <script>
	                  alert("Referencial Teórico enviado com Sucesso!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
				}
			}
			// var_dump($form['refTeorico']);
		}
		?>
		<div class="title"><h2>Enviar Referencial Teórico</h2></div>
			<div id="editar-ativ" class="form">
			   	<form action="" method="post" enctype="multipart/form-data">
				   	<label class="label"> <strong> Referencial Teórico: </strong></label><br>
				   	<p>Campo destinado à referência teórica do seu artigo.</p>
				   	<textarea name="refTeorico"><?php echo $v['refTeorico']; ?></textarea>
				   	<center><input name="enviar" type="submit" value="Enviar"></center>
				</form>
			</div>
		<?php
	}else if (isset($url[2]) && $url[2] == 'metodologia'){
		$v = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$v=$v[0];
		if (isset($_POST['enviar'])) {
			$form['metodologia'] = str_replace("'", "", $_POST['metodologia']);
			if (empty($form['metodologia'])) {
				echo '<script> alert("Campo area está vazio");</script>';
			}else{
				if (DBUpDate('encontros_trios', $form,"trioSlug = '".$v['trioSlug']."'")) {
					echo '
	                 <script>
	                  alert("Metodologia enviado com Sucesso!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
				}
			}
		}
		?>
		<div class="title"><h2>Enviar Metodologia</h2></div>
			<div id="editar-ativ" class="form">
			   	<form action="" method="post" enctype="multipart/form-data">
					   	<label class="label"> <strong> Metodologia: </strong></label><br>
					   	<p>Campo destinado à metodologia do seu artigo.</p>
					   	<textarea name="metodologia"><?php echo $v['metodologia']; ?></textarea>
				   	<center><input name="enviar" type="submit" value="Enviar"></center>
				</form>
			</div>
		<?php

	}else if (isset($url[2]) && $url[2] == 'resultados'){
		$v = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$v=$v[0];
		if (isset($_POST['enviar'])) {
			$form['resultados'] = str_replace("'", "", $_POST['resultados']);
			if (empty($form['resultados'])) {
				echo '<script> alert("Campo area está vazio");</script>';
			}else{
				if (DBUpDate('encontros_trios', $form,"trioSlug = '".$v['trioSlug']."'")) {
					echo '
	                 <script>
	                  alert("Resultados enviado com Sucesso!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
				}
			}
		}
		?>
		<div class="title"><h2>Enviar Resultados</h2></div>
			<div id="editar-ativ" class="form">
			   	<form action="" method="post" enctype="multipart/form-data">
				   	<label class="label"> <strong> Resultados: </strong></label><br>
				   	<p>Campo destinado à resultados do seu artigo.</p>
				   	<textarea name="resultados"><?php echo $v['resultados']; ?></textarea>
				   	<center><input name="enviar" type="submit" value="Enviar"></center>
				</form>
			</div>
		<?php
	}else if (isset($url[2]) && $url[2] == 'conclusao'){
		$v = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$v=$v[0];
		if (isset($_POST['enviar'])) {
			$form['conclusao'] = str_replace("'", "", $_POST['conclusao']);
			$form['bibliografia'] = str_replace("'", "", $_POST['bibliografia']);
			if (empty($form['conclusao']) || empty($form['bibliografia'])) {
				echo '<script> alert("Preencha todos os campos!");</script>';
			}else{
				if (DBUpDate('encontros_trios', $form,"trioSlug = '".$v['trioSlug']."'")) {
					echo '
	                 <script>
	                  alert("Conclusão e Bibliografia enviados com Sucesso!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
				}
			}
		}
		?>
		<div class="title"><h2>Enviar Conclusão e Bibliografia</h2></div>
			<div id="editar-ativ" class="form">
			   	<form action="" method="post" enctype="multipart/form-data">
				   	<label class="label"> <strong> Conclusão: </strong></label><br>
				   	<p>Campo destinado à conclusão do seu artigo.</p>
				   	<textarea name="conclusao"><?php echo $v['conclusao']; ?></textarea>
				   	<label class="label"> <strong> Bibliografia: </strong></label><br>
				   	<p>Campo destinado à bibliografia do seu artigo.</p>
				   	<textarea name="bibliografia"><?php echo $v['bibliografia']; ?></textarea>
				   	<center><input name="enviar" type="submit" value="Enviar"></center>
				</form>
			</div>
		<?php
	}else if (isset($url[2]) && $url[2] == 'bibliografia'){
		$v = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$v=$v[0];
		if (isset($_POST['enviar'])) {
			$form['bibliografia'] = str_replace("'", "", $_POST['bibliografia']);
			if (empty($form['bibliografia'])) {
				echo '<script> alert("Campo area está vazio");</script>';
			}else{
				if (DBUpDate('encontros_trios', $form,"trioSlug = '".$v['trioSlug']."'")) {
					echo '
	                 <script>
	                  alert("Bibliografia enviado com Sucesso!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
				}
			}
		}
		?>
		<div class="title"><h2>Enviar Bibliografia</h2></div>
			<div id="editar-ativ" class="form">
			   	<form action="" method="post" enctype="multipart/form-data">
				   	<label class="label"> <strong> Bibliografia: </strong></label><br>
				   	<p>Campo destinado à Bibliografia do seu artigo.</p>
				   	<textarea name="bibliografia"><?php echo $v['bibliografia']; ?></textarea>
				   	<center><input name="enviar" type="submit" value="Enviar"></center>
				</form>
			</div>
		<?php
	}else if (isset($url[2]) && $url[2] == 'artigo'){


		?>
		<div class="title"><h2>Enviar Artigo e Slide</h2></div>
			
			   	<br><br>
				<p>Envie seu slide e artigo, ambos em formato .pdf para o e-mail pacce.monitoria@eideia.ufc.br.</p>
				<p>No e-mail, coloque no assunto da mensagem o título do artigo e no corpo coloque número do trio, nome completo, número PACCE dos integrantes e os dois arquivos (Slide e Artigo completo) em anexo.</p>
				<p>Basta que um dos integrantes do trio faça isso.</p>

	
		<?php

	}else if (isset($url[2]) && $url[2] == 'slide'){

	}else if (isset($url[2]) && substr($url[2], 0, 4) == 'trio'){
		if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico') {
				$trio = str_replace("trio-", "", $url[2]);
				$trio = DBread('encontros_trios', "WHERE trioSlug = '".$trio."'");
				$trio = $trio[0];
			?>
			<div class="title"><h2>Trio - <?php echo $trio['trioSlug']; ?></h2></div>
			<div id="editar-ativ" class="form">
			 <strong> <?php echo $trio['npacce1'].' - '.$trio['nome1']; ?> </strong><br><br>
			 <strong> <?php echo $trio['npacce2'].' - '.$trio['nome2']; ?> </strong><br><br>
			 <?php if ($trio['npacce3'] != '') {
			 	?>
			 	<strong> <?php echo $trio['npacce3'].' - '.$trio['nome3']; ?> </strong><br><br>	
			 	<?php
			 } if ($trio['npacce4'] != '') {
			 	?>
			 	<strong> <?php echo $trio['npacce4'].' - '.$trio['nome4']; ?> </strong><br><br>
			 	<?php
			 }
			 	//salvar alterações
			 	if (isset($_POST['enviar'])) {
			 		$form['resumo'] 		= GetPost('resumo');
			 		$form['esqueleto'] 		= GetPost('esqueleto');
			 		$form['introducao'] 	= GetPost('introducao');
			 		$form['refTeorico'] 	= GetPost('refTeorico');
			 		$form['metodologia'] 	= GetPost('metodologia');
			 		$form['resultados'] 	= GetPost('resultados');
			 		$form['conclusao'] 		= GetPost('conclusao');
			 		$form['bibliografia'] 	= GetPost('bibliografia');
			 		if (DBUpDate('encontros_trios', $form, "trioSlug = '".$trio['trioSlug']."'")) {
			 			echo '
			                 <script>
			                  alert("Dados Salvo com sucesso!!");
			                    window.location="'.$way.'/'.$url[1].'";
			                  </script>';
			 		}

			 	}
			 ?>
			 <br>
			 <form action="" method="post" enctype="multipart/form-data">
			 
				   	<label class="label"> <strong> Título: </strong></label><br>
				   	<p>Campo destinado ao título do seu artigo.</p>
				   	<input type="text" name="titulo" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" value="<?php echo $trio['titulo']; ?>"  />
				   	<br><br>
				   	<label class="label"> <strong> Resumo: </strong></label><br>
				   	<p>Campo destinado ao resumo do seu artigo.</p>
				   	<textarea name="resumo"><?php echo $trio['resumo']; ?></textarea>
				   	<span style="color:red;"><?php echo strlen($trio['resumo']); ?> Caracteres</span>
				   	<br><br>

				   	<label class="label"> <strong> Esqueleto: </strong></label><br>
				   	<p>Campo destinado ao esqueleto do seu artigo.</p>
				   	<textarea name="esqueleto"><?php echo $trio['esqueleto']; ?></textarea><br><br>

					<label class="label"> <strong> Introdução: </strong></label><br>
				   	<p>Campo destinado à introdução do seu artigo.</p>
				   	<textarea name="introducao"><?php echo $trio['introducao']; ?></textarea><br><br>

					<label class="label"> <strong> Referencial Teórico: </strong></label><br>
				   	<p>Campo destinado à referência teórica do seu artigo.</p>
				   	<textarea name="refTeorico"><?php echo $trio['refTeorico']; ?></textarea><br><br>

					<label class="label"> <strong> Metodologia: </strong></label><br>
				   	<p>Campo destinado à metodologia do seu artigo.</p>
				   	<textarea name="metodologia"><?php echo $trio['metodologia']; ?></textarea><br><br>

					<label class="label"> <strong> Resultados: </strong></label><br>
				   	<p>Campo destinado à resultados do seu artigo.</p>
				   	<textarea name="resultados"><?php echo $trio['resultados']; ?></textarea><br><br>
					
					<label class="label"> <strong> Conclusão: </strong></label><br>
				   	<p>Campo destinado à conclusão do seu artigo.</p>
				   	<textarea name="conclusao"><?php echo $trio['conclusao']; ?></textarea><br><br>
					
					<label class="label"> <strong> Bibliografia: </strong></label><br>
				   	<p>Campo destinado à Bibliografia do seu artigo.</p>
				   	<textarea name="bibliografia"><?php echo $trio['bibliografia']; ?></textarea><br><br>

				   	<center><input name="enviar" type="submit" value="Enviar"></center>
			</form>
			 </div>
			
			<?php
		}else{
			echo 'Página não encontrada';
		}
	}else{
		$verifica = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$verifica = $verifica[0];
		
		?>
		<div class="title"><h2>Artigo</h2></div>
			
		<div class="tabela">
		<table>
			<tr>
				<th>Opções</th>
				<th>Semana</th>
			</tr>
			<tr>
				<td><div class=""><h2>
				<?php if($verifica == false){ ?>
				<a href="<?php echo $way.'/'.$url[1].'/cadastrar-trio' ?>">
				Cadastrar Trio
				</a>
				<?php }else{ ?>
					<strike>Cadastrar Trio</strike>
				<?php } ?>
				</h2></div></td>
				<td>24</td>
			</tr>
			
			<tr> 
				<td><div class=""><h2>
				<?php 
				if($verifica == true){ 
					if($verifica['resumo'] == '' || $verifica['resumo'] == NULL){  
				?>
					<a href="<?php echo $way.'/'.$url[1].'/resumo' ?>">
					Resumo
					</a>
				<?php 
					}else{
						?>
						<a href="<?php echo $way.'/'.$url[1].'/resumo' ?>">
						<strike>Resumo</strike>
						</a>
						<?php
					} 

				}else{ 
					?>
					Resumo
				<?php } ?>
				</h2></div>
			</td>
			<td>24</td>
			</tr>

			<!-- <tr>
				<td>	
					<?php 
						$painel = DBread('painel', "WHERE nome = 'esqueleto'");
						if ($painel[0]['chave'] == 0) {
							if ($verifica['esqueleto'] == '') {
								echo '<h2>Esqueleto</h2>';
							}else{
								echo '<h2><strike>Esqueleto</strike></h2>';
							}
						}else{
							if ($verifica['esqueleto'] == '') {
							?>
								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/esqueleto' ?>">
									Esqueleto
									</a>
								</h2>
										<?php
							}else{
								?>

								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/esqueleto' ?>">
									<strike>Esqueleto</strike>
									</a>
								</h2>
								<?php
							}
					?>
					<?php } ?>
				</td>
				<td>24</td>
			</tr> -->
			
			<tr>
				<td>	
					<?php 
						$painel = DBread('painel', "WHERE nome = 'introducao'");
						if ($painel[0]['chave'] == 0) {
							if ($verifica['introducao'] == '') {
								echo '<h2>Introdução</h2>';
							}else{
								echo '<h2><strike>Introdução</strike></h2>';
							}
						}else{
							if ($verifica['introducao'] == '') {
							?>
								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/introducao' ?>">
									Introdução
									</a>
								</h2>
							<?php
							}else{
								?>

								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/introducao' ?>">
									<strike>Introdução</strike>
									</a>
								</h2>
								<?php
							}
					?>
					<?php } ?>
				</td>
				<td>25</td>
			</tr>

			<tr>
				<td>	
					<?php 
						$painel = DBread('painel', "WHERE nome = 'refTeorico'");
						if ($painel[0]['chave'] == 0) {
							if ($verifica['refTeorico'] == '') {
								echo '<h2>Referencial Teórico</h2>';
							}else{
								echo '<h2><strike>Referencial Teórico</strike></h2>';
							}
						}else{
							if ($verifica['refTeorico'] == '') {
							?>
								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/refTeorico' ?>">
									Referencial Teórico
									</a>
								</h2>
							<?php
							}else{
								?>

								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/refTeorico' ?>">
									<strike>Referencial Teórico</strike>
									</a>
								</h2>
								<?php
							}
					?>
					<?php } ?>
				</td>
				<td>27</td>
			</tr>


			<tr>
				<td>	
					<?php 
						$painel = DBread('painel', "WHERE nome = 'metodologia'");
						if ($painel[0]['chave'] == 0) {
							if ($verifica['metodologia'] == '') {
								echo '<h2>Metodologia</h2>';
							}else{
								echo '<h2><strike>Metodologia</strike></h2>';
							}
						}else{
							if ($verifica['metodologia'] == '') {
							?>
								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/metodologia' ?>">
									Metodologia
									</a>
								</h2>
							<?php
							}else{
								?>

								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/metodologia' ?>">
									<strike>Metodologia</strike>
									</a>
								</h2>
								<?php
							}
					?>
					<?php } ?>
				</td>
				<td>28</td>
			</tr>

			<tr>
				<td>	
					<?php 
						$painel = DBread('painel', "WHERE nome = 'resultados'");
						if ($painel[0]['chave'] == 0) {
							if ($verifica['resultados'] == '') {
								echo '<h2>Análise e Discussão de Resultados</h2>';
							}else{
								echo '<h2><strike>Análise e Discussão de Resultados</strike></h2>';
							}
						}else{
							if ($verifica['resultados'] == '') {
							?>
								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/resultados' ?>">
									Análise e Discussão de Resultados
									</a>
								</h2>
							<?php
							}else{
								?>

								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/resultados' ?>">
									<strike>Análise e Discussão de Resultados</strike>
									</a>
								</h2>
								<?php
							}
					?>
					<?php } ?>
				</td>
				<td>30</td>
			</tr>

			<tr>
				<td>	
					<?php 
						$painel = DBread('painel', "WHERE nome = 'conclusao'");
						if ($painel[0]['chave'] == 0) {
							if ($verifica['conclusao'] == '') {
								echo '<h2>Conclusão e Bibliografia</h2>';
							}else{
								echo '<h2><strike>Conclusão e Bibliografia</strike></h2>';
							}
						}else{
							if ($verifica['conclusao'] == '') {
							?>
								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/conclusao' ?>">
									Conclusão e Bibliografia
									</a>
								</h2>
							<?php
							}else{
								?>

								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/conclusao' ?>">
									<strike>Conclusão e Bibliografia</strike>
									</a>
								</h2>
								<?php
							}
					?>
					<?php } ?>
				</td>
				<td>31</td>
			</tr>

			<!-- <tr>
				<td>	
					<?php 
						$painel = DBread('painel', "WHERE nome = 'bibliografia'");
						if ($painel[0]['chave'] == 0) {
							if ($verifica['bibliografia'] == '') {
								echo '<h2>Bibliografia</h2>';
							}else{
								echo '<h2><strike>Bibliografia</strike></h2>';
							}
						}else{
							if ($verifica['bibliografia'] == '') {
							?>
								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/bibliografia' ?>">
									Bibliografia
									</a>
								</h2>
							<?php
							}else{
								?>

								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/bibliografia' ?>">
									<strike>Bibliografia</strike>
									</a>
								</h2>
								<?php
							}
					?>
					<?php } ?>
				</td>
				<td>31</td>
			</tr> -->
			
			<tr>
				<td>	
					<?php 
						$painel = DBread('painel', "WHERE nome = 'artigo'");
						if ($painel[0]['chave'] == 0) {
							if ($verifica['artigo'] == '') {
								echo '<h2>Artigo e Slide</h2>';
							}else{
								echo '<h2><strike>Artigo e Slide</strike></h2>';
							}
						}else{
							if ($verifica['artigo'] == '') {
							?>
								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/artigo' ?>">
									Artigo e Slide
									</a>
								</h2>
							<?php
							}else{
								?>

								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/artigo' ?>">
									<strike>Artigo e Slide</strike>
									</a>
								</h2>
								<?php
							}
					?>
					<?php } ?>
				</td>
				<td>32</td>
			</tr>
			<!-- <tr>
				<td>	
					<?php 
						$painel = DBread('painel', "WHERE nome = 'slide'");
						if ($painel[0]['chave'] == 0) {
							if ($verifica['slide'] == '') {
								echo '<h2>Slide</h2>';
							}else{
								echo '<h2><strike>Slide</strike></h2>';
							}
						}else{
							if ($verifica['slide'] == '') {
							?>
								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/slide' ?>">
									Slide
									</a>
								</h2>
							<?php
							}else{
								?>

								<h2>
									<a href="<?php echo $way.'/'.$url[1].'/slide' ?>">
									<strike>Slide</strike>
									</a>
								</h2>
								<?php
							}
					?>
					<?php } ?>
				</td>
				<td>32</td>
			</tr> -->
		</table>
		</div>
		<br><br>
		<?php
		//Para vizualizar seu trio
		$trio = DBread('encontros_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3= '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'");
		$trio = $trio[0];
		if ($trio == false) {
			# code...
		}else{


		?>
		<div class="title"><h2>Trio Cadastrado</h2></div>
		<div class="tabela">
		<table>
				<tr>
					<th>Trio</th>
					<th>NPACCE</th>
					<th>Membro</th>
					<th>Título</th>
					
				</tr>
				<tr>
					<td> <?php echo $trio['trioSlug']; ?></td>
					<td><?php echo $trio['npacce1']; ?></td>
					<td><?php echo $trio['nome1']; ?></td>
					<td title="<?php echo $trio['titulo']; ?>"><?php echo texto($trio['titulo'], 30); ?></td>
				</tr>
				<tr>
					<td> <meta> </td>
					<td><?php echo $trio['npacce2']; ?></td>
					<td><?php echo $trio['nome2']; ?></td>
					<td> <meta> </td>
				</tr>
				<?php
					//Verifica se existe o terceiro membro 
					if ($trio['npacce3'] != '' || $trio['npacce3'] != NULL) {
				?>
				<tr>
					<td> <meta> </td>
					<td><?php echo $trio['npacce3']; ?></td>
					<td><?php echo $trio['nome3']; ?></td>
					<td> <meta> </td>
				</tr>
				<?php
					}
					//Verifica se existe o quarto membro
					if ($trio['npacce4'] != '' || $trio['npacce4'] != NULL) {
				?>
				<tr>
					<td> <meta> </td>
					<td><?php echo $trio['npacce4']; ?></td>
					<td><?php echo $trio['nome4']; ?></td>
					<td> <meta> </td>
				</tr>
				<?php
					}
				?>
				</table>
				</div>
			<br>
		<?php
			}//Fim mostra trio

		//Para o CEO Ver todos os trios!
		if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
			$trios = DBread('encontros_trios', "ORDER BY trioSlug ASC");

			?>
			<div class="title"><h2>Trios Cadastrados</h2></div>
			<div class="tabela">
				
				<?php 
					for ($i=0; $i < count($trios); $i++) { 
						
				?>
				<table>
				<tr>
					<th>Trio</th>
					<th>NPACCE</th>
					<th>Membro</th>
					<th>Título</th>
					
				</tr>
				<tr>
					<td><a href="<?php echo $way.'/'.$url[1].'/trio-'.$trios[$i]['trioSlug']; ?>"> <?php echo $trios[$i]['trioSlug']; ?></a></td>
					<td><?php echo $trios[$i]['npacce1']; ?></td>
					<td><?php echo $trios[$i]['nome1']; ?></td>
					<td title="<?php echo $trios[$i]['titulo']; ?>"><?php echo texto($trios[$i]['titulo'], 30); ?></td>
				</tr>
				<tr>
					<td> <meta> </td>
					<td><?php echo $trios[$i]['npacce2']; ?></td>
					<td><?php echo $trios[$i]['nome2']; ?></td>
					<td> <meta> </td>
				</tr>
				<?php
					//Verifica se existe o terceiro membro 
					if ($trios[$i]['npacce3'] != '' || $trios[$i]['npacce3'] != NULL) {
				?>
				<tr>
					<td> <meta> </td>
					<td><?php echo $trios[$i]['npacce3']; ?></td>
					<td><?php echo $trios[$i]['nome3']; ?></td>
					<td> <meta> </td>
				</tr>
				<?php
					}
					//Verifica se existe o quarto membro
					if ($trios[$i]['npacce4'] != '' || $trios[$i]['npacce4'] != NULL) {
				?>
				<tr>
					<td> <meta> </td>
					<td><?php echo $trios[$i]['npacce4']; ?></td>
					<td><?php echo $trios[$i]['nome4']; ?></td>
					<td> <meta> </td>
				</tr>
				<?php
					}
				?>
				</table>
				<table style="margin-top: 0px;">
				<tr>
					<th>Resumo </th>
					<!-- <th>Esqueleto </th> -->
					<th>Introdução </th>
					<th>Ref. Teórico </th>
					<th>Metodologia </th>
					<th>Resultados </th>
					<th>Conclusão e Biblio. </th>
					<!--<th>Bibliografia </th>-->
					<th>Artigo e Slide</th>

				</tr>
				<tr>
					<td>
					<?php if($trios[$i]['resumo'] != '' || $trios[$i]['resumo'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					
					</td>
					<!-- <td><?php if($trios[$i]['esqueleto'] != '' || $trios[$i]['esqueleto'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td> -->
					<td><?php if($trios[$i]['introducao'] != '' || $trios[$i]['introducao'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['refTeorico'] != '' || $trios[$i]['refTeorico'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['metodologia'] != '' || $trios[$i]['metodologia'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['resultados'] != '' || $trios[$i]['resultados'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<td><?php if($trios[$i]['conclusao'] != '' || $trios[$i]['conclusao'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
					<!-- <td><?php if($trios[$i]['bibliografia'] != '' || $trios[$i]['bibliografia'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td> -->
					<td><?php if($trios[$i]['artigo'] != '' || $trios[$i]['artigo'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td>
			<!-- 		<td><?php if($trios[$i]['slide'] != '' || $trios[$i]['slide'] != NULL){ echo '<span style="color:green;">True</span>';}else{ echo '<span style="color:red;">False</span>';} ?>
					</td> -->
				</tr>
				</table>
				<?php

				} 
				?>
				
			</div>

			<?php

		}
} 
?>