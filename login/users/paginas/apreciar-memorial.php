<style type="text/css">
	.label{ color: #4A85A0; }
</style>
<div class="title"><h2>Apreciar Memorial</h2></div>
<p>Página destinada a apreciação de histórias de vida. Aqui é possível enviar apreciações, editá-las se for necessário e posteriormente ver as mensagens das pessoas que andam apreciando seu memorial. </p>
<br>

<?php 

if (isset($url[2]) && substr($url[2], 0, 6) == 'choose'){

	if (isset($url[3]) && $url[3] == 'apr-memo') {

		if (isset($_GET['contador']) && $_GET['contador'] != '' && isset($_GET['frist']) && $_GET['frist'] != '') {

			if ($_GET['contador'] == 1) {
				?>
				<script type="text/javascript">
					$(function() {
						$("#outro").click(function () {
							$("#outroText").css({'display':'block'});
						});
						$("#onde").click(function () {
							$("#outroText").css({'display':'none'});
						});
						$("#ondee").click(function () {
							$("#outroText").css({'display':'none'});
						});
					});

				</script>
				<?php 

				if (isset($_POST['send'])) {
					$form['contador']	= 1;
					$form['npacce'] 	= $user['npacce'];
					$form['npacce1'] 	= $user['npacce'];
					$form['registro']	= date('Y-m-d H:i:s');
					$form['semana']		= substr($url[2], -2);

					$form['lugar'] 		= GetPost('onde');
					$form['sentimento'] = GetPost('sentimento');
					$form['marcante'] 	= GetPost('marcante');
					$form['sugestoes'] 	= GetPost('sugestoes');

					if ($form['lugar'] == false) {
						echo '<script>alert("Campo Lugar vazio");</script>';
					}else if($form['sentimento'] == false){
						echo '<script>alert("Campo Sentimento vazio");</script>';
					}else if($form['marcante'] == ''){
						echo '<script>alert("Campo Marcante vazio");</script>';
					}else if(strlen($form['marcante']) < 100){
						echo '<script>alert("Campo Marcante não tem 100 caracteres");</script>';
					}else if ($form['sugestoes'] == '') {
						echo '<script>alert("Campo Sugestões vazio");</script>';
					}else{
						if ($form['lugar'] == 3) {
							$form['lugar'] = GetPost('outroText');
						}
						if (DBcreate('apr_me', $form)) {
							echo '<script>alert("Relatório enviado com sucesso.");
							window.location="'.$way.'/'.$url[1].'";</script>';
						}
					}

				}
				?>
				<form action="" method="post" enctype="multipart/form-data">
					<label class="label">Onde </label><span style="color: red">  *</span><br>
					Onde você contou a sua história?<br><br>
					<input type="radio" id="onde" name="onde" value="historia-de-vida"></input> História de vida<br><br>
					<input type="radio" id="ondee" name="onde" value="formacao"></input>  Formação<br><br>
					<input type="radio" id="outro" name="onde" value="3"></input>  Outro
					<input type="text" style="display: none;" id="outroText" name="outroText" placeholder="Digite onde você contou sua história de vida"></input>
					<br><br><br>
					<label class="label">Sentimento </label><span style="color: red">  *</span><br>
					Você se sentiu à vontade ao contar sua história de vida?<br><br>
					<input type="radio" name="sentimento" value="Sim, desde o início"> Sim, desde o início</input><br><br>
					<input type="radio" name="sentimento" value="Inicialmente não, mas depois me senti mais à vontade"> Inicialmente não, mas depois me senti mais à vontade</input><br><br>
					<input type="radio" name="sentimento" value="Não me senti à vontade em nenhum momento"> Não me senti à vontade em nenhum momento</input>
					<br><br><br>
					<label class="label">Marcante </label><span style="color: red">  *</span><br>
					Fale-nos como foi sua experiência, ressaltando o que mais lhe marcou, se teve alguma dificuldade ou não, por exemplo. Como você se sentiu ao contar sua história de vida? 
					<br>
					<textarea id="marcante" name="marcante" onKeyUp="wordcounter(this); document.getElementById('instructions').style.display='none'" onFocus="wordcounter(this); document.getElementById('instructions').style.display='none'" onload="wordcounter(this); document.getElementById('instructions').style.display='none'" ></textarea>
					<p><span id="counted"></span></p>
					<br><br>
					<label class="label">Sugestões  </label><span style="color: red">  *</span><br>
					Ajude-nos a aprimorar a Roda Viva e o compartilhamento de histórias de vida. Diga-nos, a partir de sua experiência, o que você acha que pode melhorar.
					<br>
					<textarea id="sugestoes" name="sugestoes"></textarea>
					<br><br>
					<a href="<?php echo $way.'/'.$url[1].'/'.$url[2]; ?>">
						<input type="submit" name="back" id="back" value="Voltar" style="float: left;"></input>
					</a>
					<input type="submit" name="send" id="enviar" value="Enviar" style="float: right;"></input>
				</form>

				<?php
			} else if ($_GET['contador'] == 2) {
				?>
				<script type="text/javascript">
					$(function() {
						$("#outro").click(function () {
							$("#outroText").css({'display':'block'});
						});
						$("#onde").click(function () {
							$("#outroText").css({'display':'none'});
						});
						$("#ondee").click(function () {
							$("#outroText").css({'display':'none'});
						});
						$("#ondeee").click(function () {
							$("#outroText").css({'display':'none'});
						});
					});
				</script>
				<form action="" method="get" enctype="multipart/form-data">
					<label class="label">Contador(a) da história  </label><span style="color: red">  *</span><br>
					Digite o número o nº PACCE do(a) don(a) da história que você está apreciando. <br>
					Ex: B160000<br><br>
					<input type="text" name="npacce" name="" placeholder="Digite um número pacce"></input><br><br>
					<label class="label">Onde </label><span style="color: red">  *</span><br>
					Onde você ouviu essa história?. <br><br>
					<input type="radio" name="onde" id="onde" value="historia-de-vida">  História de Vida</input><br><br>
					<input type="radio" name="onde" id="ondee" value="formacao">  Formação</input><br><br>
					<input type="radio" name="onde" id="ondeee" value="li-no-blog">  Li no Blog</input><br><br>
					<input type="radio" name="onde" id="outro" value="1">  Outros</input>
					<input type="text" style="display: none;" id="outroText" name="outroText" placeholder="Digite onde você contou sua história de vida"></input><br><br>
					<br>
					<label class="label">Conhece?   </label><span style="color: red">  *</span><br>
					Você já conhecia o(a) dono(a) dessa história?<br><br>
					<input type="radio" name="conhece" value="sim"></input> Sim <br><br>
					<input type="radio" name="conhece" value="nao"></input> Não <br><br>
					<a href="<?php echo $way.'/'.$url[1].'/'.$url[2]; ?>">
						<input type="submit" name="back" id="back" value="Voltar" style="float: left;"></input>
					</a>
					<input type="submit" name="second" id="second" value="Continuar" style="float: right;"></input>
				</form>
				<?php
			}

		} else if (isset($_GET['npacce']) && $_GET['npacce'] != '' && isset($_GET['onde']) && $_GET['onde'] != '' && isset($_GET['conhece']) && $_GET['conhece'] != ''){
			$id  = strtoupper(DBescape(trim(strip_tags($_GET['npacce']))));
			$npacce = DBread('bolsistas', "WHERE npacce = '$id' AND status = true", "id, nome, npacce, nomeUsual, sexo");
			if ($npacce == false || $npacce[0]['npacce'] == $user['npacce']) {
				echo '<script>alert("Número PACCE não encontrado.");
				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';

			}else{

				if ($_GET['conhece'] == 'sim') {
					if ($npacce[0]['sexo'] == 1) {
						echo '<h2>Você está apreciando o memorial do '.GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']).'</h2><br>  ';
					}else{
						echo '<h2>Você está apreciando o memorial da '.GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']).'</h2><br>  ';
					}
					if (isset($_POST['enviar'])) {
						$form['contador']	= 2;
						$form['npacce'] 	= $user['npacce'];
						$form['npacce1']	= $id;
						$form['registro']	= date('Y-m-d H:i:s');
						$form['semana']		= substr($url[2], -2);
						$form['lugar']		= $_GET['onde'];
						$form['conhece'] 	= 'sim';
						if ($form['lugar'] == 1) {
							$form['lugar'] = str_replace("+", " ", $_GET['outroText']);
						}
						$form['mudanca'] = GetPost('mudanca');
						$form['destaque'] = GetPost('destaque');
						$form['recado'] = GetPost('recado');
						if ($form['mudanca'] == false) {
							echo '<script>alert("Campo mudança está vazio");</script>';
						}else if ($form['destaque'] == false) {
							echo '<script>alert("Campo destaque está vazio");</script>';
						}else if ($form['recado'] == false) {
							echo '<script>alert("Campo Recado está vazio");</script>';
						}else if (strlen($form['mudanca']) < 100) {
							echo '<script>alert("Campo Mudança tem menos de 100 caracteres");</script>';
						}else if (strlen($form['destaque']) < 50) {
							echo '<script>alert("Campo Desdaque tem menos de 50 caracteres");</script>';
						}else if(strlen($form['recado']) < 15){
							echo '<script>alert("Campo Recado tem menos de 15 caracteres");</script>';
						}else{
							if (DBcreate('apr_me', $form)) {
								echo '<script>alert("Relatório envia do com sucesso!");
								window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}
					}
					?>
					<form action="" method="post" enctype="multipart/form-data">
						<label class="label">Mudança  </label><span style="color: red">  *</span><br>
						Houve alguma mudança em relação ao que você pensava sobre ele(a)? Justifique. <br>
						<textarea name="mudanca" id="mudanca" onKeyUp="wordcounter(this, 100); document.getElementById('instructions').style.display='none'" onFocus="wordcounter(this, 100); document.getElementById('instructions').style.display='none'"><?php echo GetPost('mudanca'); ?></textarea>
						<p><span id="counted"></span></p><br>
						<label class="label">Marcante  </label><span style="color: red">  *</span><br>
						O que você gostaria de destacar sobre a história de vida do(a) colega? Por quê? <br>
						<textarea name="destaque" id="destaque" onKeyUp="wordcounterr(this, 50); document.getElementById('instructions').style.display='none'" onFocus="wordcounterr(this, 50); document.getElementById('instructions').style.display='none'"><?php echo GetPost('destaque'); ?></textarea><br><br>
						<p><span id="countedd"></span></p><br>
						<label class="label">Deixe seu recado  </label><span style="color: red">  *</span><br>
						Escreva uma pequena mensagem para o(a) dono(a) do memorial, lembrando que cada história é única e que cada um é protagonista de sua história.  <br>
						<textarea name="recado"><?php echo GetPost('recado'); ?></textarea><br><br>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2]; ?>">
							<input type="submit" name="back" id="back" value="Voltar" style="float: left;"></input>
						</a>
						<input type="submit" name="enviar" id="enviar" value="Enviar" style="float: right;"></input>
					</form>
					<?php
				}else if ($_GET['conhece'] == 'nao') {
					if (isset($_POST['enviar'])) {
						$form['contador']	= 2;
						$form['npacce'] 	= $user['npacce'];
						$form['npacce1']	= $id;
						$form['registro']	= date('Y-m-d H:i:s');
						$form['semana']		= substr($url[2], -2);
						$form['lugar']		= $_GET['onde'];
						$form['conhece'] 	= 'nao';	
						if ($form['lugar'] == 1) {
							$form['lugar'] = str_replace("+", " ", $_GET['outroText']);
						}
						$form['identificacao'] = GetPost('identificacao');
						$form['destaque'] = GetPost('destaque');
						$form['recado'] = GetPost('recado');
						if ($form['identificacao'] == false) {
							echo '<script>alert("Campo mudança está vazio");</script>';
						}else if ($form['destaque'] == false) {
							echo '<script>alert("Campo destaque está vazio");</script>';
						}else if ($form['recado'] == false) {
							echo '<script>alert("Campo Recado está vazio");</script>';
						}else if (strlen($form['identificacao']) < 10) {
							echo '<script>alert("Campo Mudança tem menos de 100 caracteres");</script>';
						}else if (strlen($form['destaque']) < 50) {
							echo '<script>alert("Campo Desdaque tem menos de 50 caracteres");</script>';
						}else if(strlen($form['recado']) < 15){
							echo '<script>alert("Campo Recado tem menos de 15 caracteres");</script>';
						}else{
							if (DBcreate('apr_me', $form)) {
								echo '<script>alert("Relatório enviado com sucesso!");
								window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}
					}
					if ($npacce[0]['sexo'] == 1) {
						echo '<h2>Você está apreciando o memorial do '.GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']).'</h2><br>  ';
					}else{
						echo '<h2>Você está apreciando o memorial da '.GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']).'</h2><br>  ';
					}
					?>

					<form action="" method="post" enctype="multipart/form-data">
						<label class="label">Marcante  </label><span style="color: red">  *</span><br>
						O que você gostaria de destacar sobre a história de vida do(a) colega? Por quê? <br>
						<textarea name="destaque" id="destaque" onKeyUp="wordcounterr(this, 50); document.getElementById('instructions').style.display='none'" onFocus="wordcounterr(this, 50); document.getElementById('instructions').style.display='none'"><?php echo GetPost('destaque'); ?></textarea><br><br>
						<p><span id="countedd"></span></p><br>
						<label class="label">Identificação  </label><span style="color: red">  *</span><br>
						Há algo nesta história de vida que você tenha se identificado? Existe algo no(a) sua/seu colega que se pareça com você ou seja bem diferente?  <br>
						<textarea name="identificacao" id="identificacao"><?php echo GetPost('identificacao'); ?></textarea>
						<p><span id="counted"></span></p><br>
						<label class="label">Deixe seu recado  </label><span style="color: red">  *</span><br>
						Escreva uma pequena mensagem para o(a) dono(a) do memorial, lembrando que cada história é única e que cada um é protagonista de sua história.  <br>
						<textarea name="recado"><?php echo GetPost('recado'); ?></textarea><br><br>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2]; ?>">
							<input type="submit" name="back" id="back" value="Voltar" style="float: left;"></input>
						</a>
						<input type="submit" name="enviar" id="enviar" value="Enviar" style="float: right;"></input>
					</form>
					<?php
				}
			}		
		} else {
			?>
			<form action="" method="get" enctype="multipart/form-data">
				<label class="label">Contador(a) da História</label><span style="color: red">  *</span><br>
				Quem contou a história de vida que você está apreciando?
				<br><br>

				<input type="radio" name="contador" value="1"></input>  Eu contei a minha história<br><br>
				<input type="radio" name="contador" value="2"></input>  Eu li/ouvi a história de outra pessoa<br><br>
				<input type="submit" name="frist" value="Continuar"></input>
			</form>
			<?php
		}

		

	} else if (isset($url[3]) && $url[3] == 'relato') {

		if (isset($_POST['enviar'])) {


			
				$form['npacce'] 	= $user['npacce'];
				$form['semana'] 	= str_replace("choose-semana-", "", $url[2]);
				$form['contador']   = 3;
				$form['registro'] 	= date('Y-m-d H:i:s');
				$form['pergunta1']	= GetPost('pergunta1');
				$form['pergunta2']	= GetPost('pergunta2');
				$form['pergunta3']	= GetPost('pergunta3');
				if (empty($form['pergunta1'])) {
					echo '<script>alert("Campo Pergunta 1  está vazio");</script>';
				} else if (empty($form['pergunta2'])) {
					echo '<script>alert("Campo Pergunta 2  está vazio");</script>';
				} else if (empty($form['pergunta3'])) {
					echo '<script>alert("Campo Pergunta 3  está vazio");</script>';
				} else {
					if (DBcreate('apr_me', $form)) {
						echo '<script>alert("Relatório enviado com sucesso.");
						window.location="'.$way.'/'.$url[1].'";</script>';
					}
				}
			
		}
		?>

		<script type="text/javascript">

			// $('.presenca').ready(function (event) {
			// 	console.log($(this).val());
			// 	if (<?php if ($select[0]['presenca'] != '') {echo $select[0]['presenca'];} else { echo 0 ;}  ?> == 1) {
			// 		$(".wrap_form").css('display', 'block');
			// 	} else {
			// 		$(".wrap_form").css('display', 'none');
			// 	}
			// });

			$(function(){
				$('.presenca').click(function(event) {
					/* Act on the event */
					if ($(this).val() == 1) {
						$(".wrap_form").css('display', 'block');
					}else{
						$(".wrap_form").css('display', 'none');
					}
					console.log($(this).val());
				});

			});
		</script>

		<div class="title"><h2>Apreciação - 2º Semestre </h2></div>
		<div id="editar-ativ"  class="form">


			<form method="post">
				<!-- <label>Houve encontro?</label><br><br>
				<input type="radio" class="presenca" name="presenca" value="0"></input> Não<br><br>
				<input type="radio" class="presenca" name="presenca" value="1"></input> Sim<br><br>
				<input type="radio" class="presenca" name="presenca" value="5"></input> Feriado<br><br> -->
				<div class="wrap_form">
					<label><h2>Perguntas sobre o encontro de História de Vida</h2></label>
					<br><br>
					<label>1 - O que você gostaria de destacar do encontro de hoje? Por que?</label><span style="color: red;"> *</span>
					<textarea name="pergunta1"></textarea>
					<br><br>
					<label>2 - Há algo nesse tema que você tenha se identificado com alguém? Algo Parecido? Algo bem distante?</label><span style="color: red;"> *</span>
					<textarea name="pergunta2"></textarea>
					<br><br>
					<label>3 - Escreva um pequeno resumo do encontro de hoje.</label> <span style="color: red;"> *</span>
					<textarea name="pergunta3"></textarea>
					<br><br>
				</div>
				<center>
					<input type="submit" name="enviar" value="Enviar">
				</center>

			</form>
		</div>
		<?php

	} else {

		if (isset($_POST['escolher'])) {
			switch (GetPost('choose')) {
				case 0:
				echo '<script> window.location="'.$way.'/'.$url[1].'/'.$url[2].'/apr-memo"; </script>';
				break;
				case 1:
				echo '<script> window.location="'.$way.'/'.$url[1].'/'.$url[2].'/relato"; </script>';
				break;
				case 2:
				$form['npacce'] 	= $user['npacce'];
				$form['contador']	= 4; 
				$form['semana'] 	= str_replace("choose-semana-", "", $url[2]);
				$form['registro'] 	= date('Y-m-d H:i:s');
				$form['pergunta1']	= 'Não houve encontro';
				$form['pergunta2']	= 'Não houve encontro';
				$form['pergunta3']	= 'Não houve encontro';
				if (DBcreate('apr_me', $form)) {
					echo '<script>alert("Relatório enviado com sucesso.");
					window.location="'.$way.'/'.$url[1].'";</script>';
				}
				break;
				case 3:
				$form['npacce'] 	= $user['npacce'];
				$form['contador']	= 5; 
				$form['semana'] 	= str_replace("choose-semana-", "", $url[2]);
				$form['registro'] 	= date('Y-m-d H:i:s');
				$form['pergunta1']	= 'Feriado';
				$form['pergunta2']	= 'Feriado';
				$form['pergunta3']	= 'Feriado';
				if (DBcreate('apr_me', $form)) {
					echo '<script>alert("Relatório enviado com sucesso.");
					window.location="'.$way.'/'.$url[1].'";</script>';
				}
				break;
			}

		}

		?>

		<div class="title"><h2>Apreciação - 2º Semestre </h2></div>
		<div id="editar-ativ"  class="form">

			<form method="post">
				<label>O que houve no encontro dessa semana?</label><br><br>
				<input type="radio" class="presenca" name="choose" value="0"></input> Apreciar Memorial<br><br>
				<!-- <a href="<?php echo $way.'/'.$url[1].'/toyou-semana-'.$semana_apr[$i]; ?>" class="botao"><?php echo 'Semana '.$week; ?></a> -->
				<input type="radio" class="presenca" name="choose" value="1"></input> Relato de "oficina"<br><br>
				<input type="radio" class="presenca" name="choose" value="2"></input> Não houve encontro<br><br>
				<input type="radio" class="presenca" name="choose" value="3"></input> Feriado<br><br>
				<center>
					<input type="submit" name="escolher" value="Escolher">
				</center>

			</form>
		</div>
		<?php
	}




} else if (isset($url[2]) && substr($url[2], 0, 10) == '1-semestre') {
	if (isset($_POST['enviar'])) {


		if (GetPost('presenca') == '') {
			echo '<script>alert("Escolha uma opção!");</script>';
		} else if (GetPost('presenca') == 5) {
			$form['npacce'] 	= $user['npacce'];
			$form['semana'] 	= str_replace("1-semestre-semana-", "", $url[2]);
			$form['registro'] 	= date('Y-m-d H:i:s');
			$form['pergunta1']	= 'Feriado';
			$form['pergunta2']	= 'Feriado';
			$form['pergunta3']	= 'Feriado';
			if (DBcreate('apr_me', $form)) {
				echo '<script>alert("Relatório enviado com sucesso.");
				window.location="'.$way.'/'.$url[1].'";</script>';
			}
		}  else if (GetPost('presenca') == 0) {
			$form['npacce'] 	= $user['npacce'];
			$form['semana'] 	= str_replace("1-semestre-semana-", "", $url[2]);
			$form['registro'] 	= date('Y-m-d H:i:s');
			$form['pergunta1']	= 'Não houve encontro';
			$form['pergunta2']	= 'Não houve encontro';
			$form['pergunta3']	= 'Não houve encontro';
			if (DBcreate('apr_me', $form)) {
				echo '<script>alert("Relatório enviado com sucesso.");
				window.location="'.$way.'/'.$url[1].'";</script>';
			}
		} else {
			$form['npacce'] 	= $user['npacce'];
			$form['semana'] 	= str_replace("1-semestre-semana-", "", $url[2]);
			$form['registro'] 	= date('Y-m-d H:i:s');
			$form['pergunta1']	= GetPost('pergunta1');
			$form['pergunta2']	= GetPost('pergunta2');
			$form['pergunta3']	= GetPost('pergunta3');
			if (empty($form['pergunta1'])) {
				echo '<script>alert("Campo Pergunta 1  está vazio");</script>';
			} else if (empty($form['pergunta2'])) {
				echo '<script>alert("Campo Pergunta 2  está vazio");</script>';
			} else if (empty($form['pergunta3'])) {
				echo '<script>alert("Campo Pergunta 3  está vazio");</script>';
			} else {
				if (DBcreate('apr_me', $form)) {
					echo '<script>alert("Relatório enviado com sucesso.");
					window.location="'.$way.'/'.$url[1].'";</script>';
				}
			}
		}
	}
	?>

	<script type="text/javascript">

		$('.presenca').ready(function (event) {
			console.log($(this).val());
			if (<?php if ($select[0]['presenca'] != '') {echo $select[0]['presenca'];} else { echo 0 ;}  ?> == 1) {
				$(".wrap_form").css('display', 'block');
			} else {
				$(".wrap_form").css('display', 'none');
			}
		});

		$(function(){
			$('.presenca').click(function(event) {
				/* Act on the event */
				if ($(this).val() == 1) {
					$(".wrap_form").css('display', 'block');
				}else{
					$(".wrap_form").css('display', 'none');
				}
				console.log($(this).val());
			});

		});
	</script>

	<div class="title"><h2>Apreciação - 1º Semestre </h2></div>
	<div id="editar-ativ"  class="form">


		<form method="post">
			<label>Houve encontro?</label><br><br>
			<input type="radio" class="presenca" name="presenca" value="0"></input> Não<br><br>
			<input type="radio" class="presenca" name="presenca" value="1"></input> Sim<br><br>
			<input type="radio" class="presenca" name="presenca" value="5"></input> Feriado<br><br>
			<div class="wrap_form">
				<label><h2>Perguntas sobre o encontro de História de Vida</h2></label>
				<br><br>
				<label>1 - O que você gostaria de destacar do encontro de hoje? Por que?</label><span style="color: red;"> *</span>
				<textarea name="pergunta1"></textarea>
				<br><br>
				<label>2 - Há algo nesse tema que você tenha se identificado com alguém? Algo Parecido? Algo bem distante?</label><span style="color: red;"> *</span>
				<textarea name="pergunta2"></textarea>
				<br><br>
				<label>3 - Escreva um pequeno resumo do encontro de hoje.</label> <span style="color: red;"> *</span>
				<textarea name="pergunta3"></textarea>
				<br><br>
			</div>
			<center>
				<input type="submit" name="enviar" value="Enviar">
			</center>

		</form>
	</div>
	<?php	
} else if (isset($url[2]) && substr($url[2], 0, 5) == 'toyou'){

	$intSemana = str_replace("toyou-semana-", "", $url[2]);
	$memoriais = DBread('apr_me', "WHERE npacce1 = '".$user['npacce']."' AND semana = '$intSemana' AND contador != true");

	if ($memoriais == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
		?>
		<div class="tabela">
			<table>
				<tr>
					<th>Remetente</th>
					<th>Mensagem</th>
				</tr>
				<?php 
				for ($i=0; $i < count($memoriais); $i++) { 
					$foto = DBread('bolsistas', "WHERE npacce = '".$memoriais[$i]['npacce']."'", 'npacce, nome, nomeUsual, foto');
					?>

					<tr>
						<td>
							<div class="foto-single" style="">
								<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto']; ?>"><br></span>
								<div class="nome"><?php echo GetName($foto[0]['nome'], $foto[0]['nomeUsual']); ?></div>
							</div>
						</td>
						<td>
							<?php echo printPost($memoriais[$i]['recado'], 'page'); ?>
						</td>
					</tr>

				<?php } ?>
			</table>
		</div>
		<?php
	}
} else if (isset($url[2]) && $url[2] != '') { 
	?>
	<div class="title"><h2>Apreciação - 2º Semestre </h2></div>
	<div id="editar-ativ" class="form">

		<?php
		if (isset($_GET['contador']) && $_GET['contador'] != '' && isset($_GET['frist']) && $_GET['frist'] != '') {
			if ($_GET['contador'] == 1) { 

				?>
				<script type="text/javascript">
					$(function() {
						$("#outro").click(function () {
							$("#outroText").css({'display':'block'});
						});
						$("#onde").click(function () {
							$("#outroText").css({'display':'none'});
						});
						$("#ondee").click(function () {
							$("#outroText").css({'display':'none'});
						});
					});

				</script>
				<?php 

				if (isset($_POST['send'])) {
					$form['contador']	= 1;
					$form['npacce'] 	= $user['npacce'];
					$form['npacce1'] 	= $user['npacce'];
					$form['registro']	= date('Y-m-d H:i:s');
					$form['semana']		= substr($url[2], -2);

					$form['lugar'] 		= GetPost('onde');
					$form['sentimento'] = GetPost('sentimento');
					$form['marcante'] 	= GetPost('marcante');
					$form['sugestoes'] 	= GetPost('sugestoes');

					if ($form['lugar'] == false) {
						echo '<script>alert("Campo Lugar vazio");</script>';
					}else if($form['sentimento'] == false){
						echo '<script>alert("Campo Sentimento vazio");</script>';
					}else if($form['marcante'] == ''){
						echo '<script>alert("Campo Marcante vazio");</script>';
					}else if(strlen($form['marcante']) < 100){
						echo '<script>alert("Campo Marcante não tem 100 caracteres");</script>';
					}else if ($form['sugestoes'] == '') {
						echo '<script>alert("Campo Sugestões vazio");</script>';
					}else{
						if ($form['lugar'] == 3) {
							$form['lugar'] = GetPost('outroText');
						}
						if (DBcreate('apr_me', $form)) {
							echo '<script>alert("Relatório enviado com sucesso.");
							window.location="'.$way.'/'.$url[1].'";</script>';
						}
					}

				}
				?>
				<form action="" method="post" enctype="multipart/form-data">
					<label class="label">Onde </label><span style="color: red">  *</span><br>
					Onde você contou a sua história?<br><br>
					<input type="radio" id="onde" name="onde" value="historia-de-vida"></input> História de vida<br><br>
					<input type="radio" id="ondee" name="onde" value="formacao"></input>  Formação<br><br>
					<input type="radio" id="outro" name="onde" value="3"></input>  Outro
					<input type="text" style="display: none;" id="outroText" name="outroText" placeholder="Digite onde você contou sua história de vida"></input>
					<br><br><br>
					<label class="label">Sentimento </label><span style="color: red">  *</span><br>
					Você se sentiu à vontade ao contar sua história de vida?<br><br>
					<input type="radio" name="sentimento" value="Sim, desde o início"> Sim, desde o início</input><br><br>
					<input type="radio" name="sentimento" value="Inicialmente não, mas depois me senti mais à vontade"> Inicialmente não, mas depois me senti mais à vontade</input><br><br>
					<input type="radio" name="sentimento" value="Não me senti à vontade em nenhum momento"> Não me senti à vontade em nenhum momento</input>
					<br><br><br>
					<label class="label">Marcante </label><span style="color: red">  *</span><br>
					Fale-nos como foi sua experiência, ressaltando o que mais lhe marcou, se teve alguma dificuldade ou não, por exemplo. Como você se sentiu ao contar sua história de vida? 
					<br>
					<textarea id="marcante" name="marcante" onKeyUp="wordcounter(this); document.getElementById('instructions').style.display='none'" onFocus="wordcounter(this); document.getElementById('instructions').style.display='none'" onload="wordcounter(this); document.getElementById('instructions').style.display='none'" ></textarea>
					<p><span id="counted"></span></p>
					<br><br>
					<label class="label">Sugestões  </label><span style="color: red">  *</span><br>
					Ajude-nos a aprimorar a Roda Viva e o compartilhamento de histórias de vida. Diga-nos, a partir de sua experiência, o que você acha que pode melhorar.
					<br>
					<textarea id="sugestoes" name="sugestoes"></textarea>
					<br><br>
					<a href="<?php echo $way.'/'.$url[1].'/'.$url[2]; ?>">
						<input type="submit" name="back" id="back" value="Voltar" style="float: left;"></input>
					</a>
					<input type="submit" name="send" id="enviar" value="Enviar" style="float: right;"></input>
				</form>

				<?php
			}else if($_GET['contador'] == 2){

				?>
				<script type="text/javascript">
					$(function() {
						$("#outro").click(function () {
							$("#outroText").css({'display':'block'});
						});
						$("#onde").click(function () {
							$("#outroText").css({'display':'none'});
						});
						$("#ondee").click(function () {
							$("#outroText").css({'display':'none'});
						});
						$("#ondeee").click(function () {
							$("#outroText").css({'display':'none'});
						});
					});
				</script>
				<form action="" method="get" enctype="multipart/form-data">
					<label class="label">Contador(a) da história  </label><span style="color: red">  *</span><br>
					Digite o número o nº PACCE do(a) don(a) da história que você está apreciando. <br>
					Ex: B160000<br><br>
					<input type="text" name="npacce" name="" placeholder="Digite um número pacce"></input><br><br>
					<label class="label">Onde </label><span style="color: red">  *</span><br>
					Onde você ouviu essa história?. <br><br>
					<input type="radio" name="onde" id="onde" value="historia-de-vida">  História de Vida</input><br><br>
					<input type="radio" name="onde" id="ondee" value="formacao">  Formação</input><br><br>
					<input type="radio" name="onde" id="ondeee" value="li-no-blog">  Li no Blog</input><br><br>
					<input type="radio" name="onde" id="outro" value="1">  Outros</input>
					<input type="text" style="display: none;" id="outroText" name="outroText" placeholder="Digite onde você contou sua história de vida"></input><br><br>
					<br>
					<label class="label">Conhece?   </label><span style="color: red">  *</span><br>
					Você já conhecia o(a) dono(a) dessa história?<br><br>
					<input type="radio" name="conhece" value="sim"></input> Sim <br><br>
					<input type="radio" name="conhece" value="nao"></input> Não <br><br>
					<a href="<?php echo $way.'/'.$url[1].'/'.$url[2]; ?>">
						<input type="submit" name="back" id="back" value="Voltar" style="float: left;"></input>
					</a>
					<input type="submit" name="second" id="second" value="Continuar" style="float: right;"></input>
				</form>
				<?php
			}
		}else if (isset($_GET['npacce']) && $_GET['npacce'] != '' && isset($_GET['onde']) && $_GET['onde'] != '' && isset($_GET['conhece']) && $_GET['conhece'] != '') {
			$id  = strtoupper(DBescape(trim(strip_tags($_GET['npacce']))));
			$npacce = DBread('bolsistas', "WHERE npacce = '$id' AND status = true", "id, nome, npacce, nomeUsual, sexo");
			if ($npacce == false || $npacce[0]['npacce'] == $user['npacce']) {
				echo '<script>alert("Número PACCE não encontrado.");
				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';

			}else{

				if ($_GET['conhece'] == 'sim') {
					if ($npacce[0]['sexo'] == 1) {
						echo '<h2>Você está apreciando o memorial do '.GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']).'</h2><br>  ';
					}else{
						echo '<h2>Você está apreciando o memorial da '.GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']).'</h2><br>  ';
					}
					if (isset($_POST['enviar'])) {
						$form['contador']	= 2;
						$form['npacce'] 	= $user['npacce'];
						$form['npacce1']	= $id;
						$form['registro']	= date('Y-m-d H:i:s');
						$form['semana']		= substr($url[2], -2);
						$form['lugar']		= $_GET['onde'];
						$form['conhece'] 	= 'sim';
						if ($form['lugar'] == 1) {
							$form['lugar'] = str_replace("+", " ", $_GET['outroText']);
						}
						$form['mudanca'] = GetPost('mudanca');
						$form['destaque'] = GetPost('destaque');
						$form['recado'] = GetPost('recado');
						if ($form['mudanca'] == false) {
							echo '<script>alert("Campo mudança está vazio");</script>';
						}else if ($form['destaque'] == false) {
							echo '<script>alert("Campo destaque está vazio");</script>';
						}else if ($form['recado'] == false) {
							echo '<script>alert("Campo Recado está vazio");</script>';
						}else if (strlen($form['mudanca']) < 100) {
							echo '<script>alert("Campo Mudança tem menos de 100 caracteres");</script>';
						}else if (strlen($form['destaque']) < 50) {
							echo '<script>alert("Campo Desdaque tem menos de 50 caracteres");</script>';
						}else if(strlen($form['recado']) < 15){
							echo '<script>alert("Campo Recado tem menos de 15 caracteres");</script>';
						}else{
							if (DBcreate('apr_me', $form)) {
								echo '<script>alert("Relatório envia do com sucesso!");
								window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}
					}
					?>
					<form action="" method="post" enctype="multipart/form-data">
						<label class="label">Mudança  </label><span style="color: red">  *</span><br>
						Houve alguma mudança em relação ao que você pensava sobre ele(a)? Justifique. <br>
						<textarea name="mudanca" id="mudanca" onKeyUp="wordcounter(this, 100); document.getElementById('instructions').style.display='none'" onFocus="wordcounter(this, 100); document.getElementById('instructions').style.display='none'"><?php echo GetPost('mudanca'); ?></textarea>
						<p><span id="counted"></span></p><br>
						<label class="label">Marcante  </label><span style="color: red">  *</span><br>
						O que você gostaria de destacar sobre a história de vida do(a) colega? Por quê? <br>
						<textarea name="destaque" id="destaque" onKeyUp="wordcounterr(this, 50); document.getElementById('instructions').style.display='none'" onFocus="wordcounterr(this, 50); document.getElementById('instructions').style.display='none'"><?php echo GetPost('destaque'); ?></textarea><br><br>
						<p><span id="countedd"></span></p><br>
						<label class="label">Deixe seu recado  </label><span style="color: red">  *</span><br>
						Escreva uma pequena mensagem para o(a) dono(a) do memorial, lembrando que cada história é única e que cada um é protagonista de sua história.  <br>
						<textarea name="recado"><?php echo GetPost('recado'); ?></textarea><br><br>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2]; ?>">
							<input type="submit" name="back" id="back" value="Voltar" style="float: left;"></input>
						</a>
						<input type="submit" name="enviar" id="enviar" value="Enviar" style="float: right;"></input>
					</form>
					<?php
				}else if ($_GET['conhece'] == 'nao') {
					if (isset($_POST['enviar'])) {
						$form['contador']	= 2;
						$form['npacce'] 	= $user['npacce'];
						$form['npacce1']	= $id;
						$form['registro']	= date('Y-m-d H:i:s');
						$form['semana']		= substr($url[2], -2);
						$form['lugar']		= $_GET['onde'];
						$form['conhece'] 	= 'nao';	
						if ($form['lugar'] == 1) {
							$form['lugar'] = str_replace("+", " ", $_GET['outroText']);
						}
						$form['identificacao'] = GetPost('identificacao');
						$form['destaque'] = GetPost('destaque');
						$form['recado'] = GetPost('recado');
						if ($form['identificacao'] == false) {
							echo '<script>alert("Campo mudança está vazio");</script>';
						}else if ($form['destaque'] == false) {
							echo '<script>alert("Campo destaque está vazio");</script>';
						}else if ($form['recado'] == false) {
							echo '<script>alert("Campo Recado está vazio");</script>';
						}else if (strlen($form['identificacao']) < 10) {
							echo '<script>alert("Campo Mudança tem menos de 100 caracteres");</script>';
						}else if (strlen($form['destaque']) < 50) {
							echo '<script>alert("Campo Desdaque tem menos de 50 caracteres");</script>';
						}else if(strlen($form['recado']) < 15){
							echo '<script>alert("Campo Recado tem menos de 15 caracteres");</script>';
						}else{
							if (DBcreate('apr_me', $form)) {
								echo '<script>alert("Relatório envia do com sucesso!");
								window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}
					}
					if ($npacce[0]['sexo'] == 1) {
						echo '<h2>Você está apreciando o memorial do '.GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']).'</h2><br>  ';
					}else{
						echo '<h2>Você está apreciando o memorial da '.GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']).'</h2><br>  ';
					}
					?>

					<form action="" method="post" enctype="multipart/form-data">
						<label class="label">Marcante  </label><span style="color: red">  *</span><br>
						O que você gostaria de destacar sobre a história de vida do(a) colega? Por quê? <br>
						<textarea name="destaque" id="destaque" onKeyUp="wordcounterr(this, 50); document.getElementById('instructions').style.display='none'" onFocus="wordcounterr(this, 50); document.getElementById('instructions').style.display='none'"><?php echo GetPost('destaque'); ?></textarea><br><br>
						<p><span id="countedd"></span></p><br>
						<label class="label">Identificação  </label><span style="color: red">  *</span><br>
						Há algo nesta história de vida que você tenha se identificado? Existe algo no(a) sua/seu colega que se pareça com você ou seja bem diferente?  <br>
						<textarea name="identificacao" id="identificacao"><?php echo GetPost('identificacao'); ?></textarea>
						<p><span id="counted"></span></p><br>
						<label class="label">Deixe seu recado  </label><span style="color: red">  *</span><br>
						Escreva uma pequena mensagem para o(a) dono(a) do memorial, lembrando que cada história é única e que cada um é protagonista de sua história.  <br>
						<textarea name="recado"><?php echo GetPost('recado'); ?></textarea><br><br>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2]; ?>">
							<input type="submit" name="back" id="back" value="Voltar" style="float: left;"></input>
						</a>
						<input type="submit" name="enviar" id="enviar" value="Enviar" style="float: right;"></input>
					</form>
					<?php
				}
			}		

		}else{
			?>
			<form action="" method="get" enctype="multipart/form-data">
				<label class="label">Contador(a) da História</label><span style="color: red">  *</span><br>
				Quem contou a história de vida que você está apreciando?
				<br><br>

				<input type="radio" name="contador" value="1"></input>  Eu contei a minha história<br><br>
				<input type="radio" name="contador" value="2"></input>  Eu li/ouvi a história de outra pessoa<br><br>
				<input type="submit" name="frist" value="Continuar"></input>
			</form>
			<?php
		}
		?>

	</div>
	<?php
} else{
	?>


	<div class="title"><h2>Semanas - Apreciação - 1º Semestre</h2></div>
	<?php
	for ($i=2; $i <= 21; $i++) { 
		if ($i < 10) {
			$week = '0'.$i;
		}else{
			$week = $i;
		}
		?>
		<a href="<?php echo $way.'/'.$url[1].'/1-semestre-semana-'.$week; ?>" class="botao"><?php echo 'Semana '.$week; ?></a>
		<?php
	}

	?>
	<br><br><br>
	<div class="title"><h2>Semanas - Apreciação - 2º Semestre</h2></div>
	<?php


	for ($i=2; $i <= $semana; $i++) {
		if ($i > 21) { 
			if ($i < 10) {
				$week = '0'.$i;
			}else{
				$week = $i;
			} 
			?>
			<!-- <a href="<?php echo $way.'/'.$url[1].'/semana-'.$i; ?>" class="botao"><?php echo 'Semana '.$week; ?></a> -->
			<a href="<?php echo $way.'/'.$url[1].'/choose-semana-'.$i; ?>" class="botao"><?php echo 'Semana '.$week; ?></a>
			<?php
		}
	}


	$res_apr = DBread('apr_me', "WHERE npacce1 = '".$user['npacce']."' ORDER BY semana ASC");
	
	if ($res_apr == false || $res_apr[0]['npacce'] == $user['npacce']) {

	}else{
		?>

		<br><br><br>
		<div class="title"><h2>Semanas - Apreciação de Remetente</h2></div>

		<?php
		$semana_apr = [];
		$semana_apr[0] = $res_apr[0]['semana'];
		$j = 0;
		for ($i=1; $i < count($res_apr); $i++) { 
			if ($semana_apr[$j] != $res_apr[$i]['semana']) {
				$semana_apr[$j+1] = $res_apr[$i]['semana'];
				$j++;
			}
		}

		for ($i=0; $i < count($semana_apr); $i++) { 

			if ($semana_apr[$i] < 10) {
				$week = '0'.$semana_apr[$i];
			}else{
				$week = $semana_apr[$i];
			}
			?>
			<a href="<?php echo $way.'/'.$url[1].'/toyou-semana-'.$semana_apr[$i]; ?>" class="botao"><?php echo 'Semana '.$week; ?></a>
			<?php
		}

	}

	?>
	<br><br>
	<div class="title"><h2>Histórico de apreciações</h2></div>
	<?php 
	$apr = DBread('apr_me', "WHERE npacce = '".$user['npacce']."' ORDER BY semana");
	if ($apr == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
		?>
		<div class="tabela">
			<table>
				<tr>
					<th>Remetente:</th>
					<th>Destinatário:</th>
					<th>Semana:</th>
					<th>Situação:</th>
				</tr>
				<?php 
				for ($i=0; $i < count($apr); $i++) { 
					$npacce = DBread('bolsistas', "WHERE npacce = '".$apr[$i]['npacce1']."'", "id, nome, nomeUsual");
					?>
					<tr>
						<td>Você</td>
						<td><?php echo GetName($npacce[0]['nome'], $npacce[0]['nomeUsual']); ?></td>
						<td><?php if($apr[$i]['semana'] < 10){ echo '0'.$apr[$i]['semana'];}else{echo $apr[$i]['semana'];} ?></td>
						<td><?php if($apr[$i]['contador'] == 1){echo 'Eu contei minha História de Vida';} else if($apr[$i]['contador'] == 2) {echo 'Eu li/ouvi uma História de Vida';} else if($apr[$i]['contador'] == 3) {echo 'Relatei sobre um tema';} else if ($apr[$i]['contador'] == 4) {echo 'Não houve encontro';} else {echo 'Feriado';} ?></td>
					</tr>
					<?php 
				}
				?>
			</table>
		</div>
		<div id="count">(<?php echo count($apr); ?>)</div>
		<?php
	}
}
?>