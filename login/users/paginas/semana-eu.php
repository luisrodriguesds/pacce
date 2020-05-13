
<div class="title"><h2>Semana dos Encontros Universitários</h2></div>
<p> <!-- Página destina à semana das atividades dos encontros universitário. Nessa página os membros
do Programa de Aprendizagem Cooperativa em Células Estudantis ficarão responsável pela coleta 
de presenças dos alunos da Universidade Fedaral do Céará que participarem das atividades.--> </p>
<br><br>
<a href="<?php echo URL_PAINEL.'paginas/sistema-eu.php' ?>" class="botao">Acessar o Sistema</a>
<br><br>
<?php 
//PAGINAÇÃO
if (isset($url[2]) && $url[2] == 'criar-evento') {
	if (isset($_POST['enviar'])) {
		$form['codigo']			= 'EU16'.GetPost('codigo');
		$form['evento'] 		= GetPost('evento');
		$form['eventoSlug']		= Slug($form['evento']);
		$form['local']			= GetPost('local');
		$form['data']			= GetPost('data');
		$form['inicio'] 		= GetPost('horaIni').':'.GetPost('minIni').':'.GetPost('segIni');
		$form['fim'] 			= GetPost('horaFim').':'.GetPost('minFim').':'.GetPost('segFim');
		$form['responsavel']	= GetPost('responsavel');
		$form['destinado']		= GetPost('destinado');
		//$form['desc'] 			= GetPost('desc');
		
		$form['status']			= GetPost('status');
		$form['cor']			= GetPost('cor');
		$form['registro']		= date('Y-m-d H:i:s');
			
		$form2['codigo']		= $form['codigo'];
		$form2['npacceResp']	= GetPost('npacceResp');

		if (empty($form['evento'])) {
			echo '<script>alert("Campo evento está vazio");</script>';
		}else if (empty($form['local'])) {
			echo '<script>alert("Campo local está vazio");</script>';
		}else if (empty($form['data'])) {
			echo '<script>alert("Campo data está vazio");</script>';
		}else if (date('H', strtotime($form['inicio'])) > date('H', strtotime($form['fim']))) {
			echo '<script>alert("Campo Início está maior que o campo Fim")</script>';
		}else if (empty($form['responsavel'])) {
			echo '<script>alert("Campo responsável está vazio");</script>';
		}else if (empty($form['destinado'])) {
			echo '<script>alert("Campo destinado está vazio");</script>';
		}else if (empty($form['cor'])) {
			echo '<script>alert("Campo cor está vazio");</script>';
		}else{
			$npacceV = true;
			for($i=0; $i < count($form2['npacceResp']); $i++) { 
				$npacce = DBread('bolsistas', "WHERE npacce = '".$form2['npacceResp'][$i]."'", "id");
				if ($npacce == false) {
					$npacceV = false;
				}
			}
			if ($npacceV == false) {
				echo '<script>alert("Um número PACCE informado não foi encontrado");</script>';
			}else{
				
				if (DBcreate('eu_eventos', $form)) {
					for ($i=0; $i < count($form2['npacceResp']); $i++) { 
						$formEvento['codigo'] 		= $form2['codigo'];
						$formEvento['npacceResp']	= $form2['npacceResp'][$i];
						
						DBcreate('eu_eventos_resp', $formEvento);
					}
					echo '<script>alert("Evento Cadastrado com sucesso.");
					window.location="'.$way.'/'.$url[1].'";</script>';
				}
				
			}
		} 
}					
?>
	<script type="text/javascript">
		$(function(){
			$('.botao').click(function(e) {
				e.preventDefault();
			});
			
			typeText('#eventoRe', '#eventoDe');
			typeText('#localRe', '#localDe');
			typeText('#responsavelRe', '#responsavelDe');
			typeText('#destinadoRe', '#destinadoDe');
			typeText('#dataRe', '#dataDe');
			typeDate('#dataRe', '#dataDe');
			typeDate('#horaIniRe', '#horaIniDe');
			typeDate('#minIniRe', '#minIniDe');
			typeDate('#horaFimRe', '#horaFimDe');
			typeDate('#minFimRe', '#minFimDe');
			typeColor('#corRe', '#corDe');
			function typeColor(seletorRe, seletorDe){
				$(seletorRe).click(function() {
					var data = $(seletorRe).val();
					$(seletorDe).css({background:data});
					console.log(data);
				});
				$(seletorRe).hover(function() {
					/* Stuff to do when the mouse enters the element */
					var data = $(seletorRe).val();
					$(seletorDe).css({background:data});
					console.log(data);
				}, function() {
					/* Stuff to do when the mouse leaves the element */
					var data = $(seletorRe).val();
					$(seletorDe).css({background:data});
					console.log(data);
				});
			}
			function typeDate(seletorRe, seletorDe){
				$(seletorRe).click(function() {
					var data = $(seletorRe).val();
					$(seletorDe).html(data);
				});
				$(seletorRe).hover(function() {
					/* Stuff to do when the mouse enters the element */
					var data = $(seletorRe).val();
					$(seletorDe).html(data);
				}, function() {
					/* Stuff to do when the mouse leaves the element */
					var data = $(seletorRe).val();
					$(seletorDe).html(data);
				});
			}
			function typeText(seletorRe, seletorDe){
				$(seletorRe).keyup(function(event) {
					var palavra = $(seletorRe).val();
					if (palavra.length >= 25){
						palavra = palavra.substring(0, 25) + '...';
						$(seletorDe).html(palavra);
					}else{
						$(seletorDe).html(palavra);
					}
				});
			}
		});
	</script>
	<div class="title"><h2>Criar Evento</h2></div>
	<br><br>
<div id="wrap-formEvento">
	<div class="form" id="formEvento">
		<form method="post">
			<label>Código:</label><span style="color: red;">*</span><br>
			<span><strong>EU16</strong></span>
				<?php 
				$codEvento = DBread('eu_eventos', null, 'codigo');
				?>
				<select name="codigo">
				<?php 

					for ($i=0; $i <= 200 ; $i++) {
						 
						if ($i < 10) {
							$j = '0'.$i;
						}else{
							$j = $i;							
						}

						$v = 0;
						for ($k=0; $k < count($codEvento); $k++) { 
						 	if ($j == str_replace("EU16", "", $codEvento[$k]['codigo'])){
						 		$v = 1;
						 	}
						}
						 
						 if ($v == 1) {
						 	$block = 'disabled';
						 }else{
						 	$block = '';
						 }
						echo '<option '.$block.' value="'.$j.'">'.$j.'</option>';
					}
				?>
				</select>
				<br><br><br>
			<label>Título:</label><span style="color: red;">*</span><br>
			<input type="text" id="eventoRe" name="evento" placeholder="Digite o nome do evento">
			<br><br><br>
			<label>Local:</label><span style="color: red;">*</span><br>
			<input type="text" id="localRe" name="local" placeholder="Digite o local do evento">
			<br><br><br>
			<label>Data:</label><span style="color: red;">*</span><br>
			<input type="date" id="dataRe" name="data">
			<br><br><br>
			<label>Inicio:</label><span style="color: red;">*</span><br>
		 	<select name="horaIni"  id="horaIniRe">
		 	<?php
		 	if($select == true){
	 			$hora = explode(":", $select[0]['entrada']);
	 		}else{
	 			$hora = '';
	 		}
		 		
		 		for ($i=0; $i <= 23; $i++) {
		 			if($i < 10){
		 				$value = '0'.$i;
		 			}else{
		 				$value = $i;
		 			} 
		 			if($value == $hora[0]){
		 				$checked = 'selected=""';
		 			}else{
		 				$checked = '';
		 			}
		 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
		 		}
		 	?>

		 	</select>
		 	:
		 	<select name="minIni" id="minIniRe">
		 	<?php 
		 		for ($i=0; $i <= 23; $i++) {
		 			if($i < 10){
		 				$value = '0'.$i;
		 			}else{
		 				$value = $i;
		 			} 
		 			if($value == $hora[1]){
		 				$checked = 'selected=""';
		 			}else{
		 				$checked = '';
		 			}
		 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
		 		}
		 	?>
		 	</select>
		 	:
		 	<select name="segIni">
		 	<?php 
		 		for ($i=0; $i <= 23; $i++) {
		 			if($i < 10){
		 				$value = '0'.$i;
		 			}else{
		 				$value = $i;
		 			} 
		 			if($value == $hora[2]){
		 				$checked = 'selected=""';
		 			}else{
		 				$checked = '';
		 			}
		 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
		 		}
		 	?>
		 	</select>
		 	<br><br>
		 	<label>Fim:</label><span style="color: red;">*</span><br>
		 	<select name="horaFim" id="horaFimRe">
		 	<?php
		 	if($select == true){
	 			$hora = explode(":", $select[0]['saida']);
	 		}else{
	 			$hora = '';
	 		} 
		 		for ($i=0; $i <= 23; $i++) {
		 			if($i < 10){
		 				$value = '0'.$i;
		 			}else{
		 				$value = $i;
		 			} 
		 			if($value == $hora[0]){
		 				$checked = 'selected=""';
		 			}else{
		 				$checked = '';
		 			}
		 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
		 		}
		 	?>
		 	</select>
		 	:
		 	<select name="minFim" id="minFimRe">
		 	<?php 
		 		for ($i=0; $i <= 23; $i++) {
		 			if($i < 10){
		 				$value = '0'.$i;
		 			}else{
		 				$value = $i;
		 			} 
		 			if($value == $hora[1]){
		 				$checked = 'selected=""';
		 			}else{
		 				$checked = '';
		 			}
		 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
		 		}
		 	?>
		 	</select>
		 	:
		 	<select name="segFim">
		 	<?php 
		 		for ($i=0; $i <= 23; $i++) {
		 			if($i < 10){
		 				$value = '0'.$i;
		 			}else{
		 				$value = $i;
		 			} 
		 			if($value == $hora[2]){
		 				$checked = 'selected=""';
		 			}else{
		 				$checked = '';
		 			}
		 			echo '<option value="'.$value.'" '.$checked.'>'.$value.'</option>';
		 		}
		 	?>
		 	</select>
		 	<br><br><br>
			<label>Responsável:</label><span style="color: red;">*</span><br>
			<input type="text" id="responsavelRe" name="responsavel" placeholder="Digite o responsável pelo evento">
			
			<br><br><br>
			<label>Destinado:</label><span style="color: red;">*</span><br>
			<input type="text" id="destinadoRe" name="destinado" placeholder="Digite a quem é destinado o evento">
			
			<br><br><br>
			<label>Responsáveis pela presença:</label><span style="color: red;">*</span><br>
			<p>Digite o(s) número(s) PACCE do(s) Responsáveis pela coleta de presença</p><br>
			<div id="origem">

				<input type="text" name="npacceResp[]" class="rpres" id="rpres" onkeyup="maiuscula(this)" maxlength="7"  placeholder="Digite o npacce do responsável pela presença do evento">
				<span id="resnpacce" class="resnpacce"></span><br><br>
			</div>
			<div id="destino"></div>
			<a href="#" class="botao" onclick="duplicarCampos();">Add</a>
			<a href="#" class="botao" onclick="removerCampos(this);">Remover</a>
			
			<br><br><br>
			<label>Descrição:</label><span style="color: red;">*</span><br>
			<textarea name="desc"></textarea>

			<br><br><br>
			<center>
				<label>Status:</label><span style="color: red;">*</span><br>
				<select name="status">
					<option value="1">Ativo</option>
					<option value="0">Inativo</option>
				</select>
			<br><br><br>
				<label>Cor:</label><span style="color: red;">*</span><br>
				<input type="color" id="corRe" value="#a93b3b" name="cor">
				<br><br><br>
				<input type="submit" name="enviar" value="Enviar">
			</center>
			
			
		</form>
	</div>
	<div id="wrap-caixa" style="position: fixed; right: 0;">
				<div class="caixa">
					<ul>
						<a href="#">
							<li style="background: #a93b3b;" id="corDe">
								<div>
									<div id="box-all-info">
										<div id="all-info">
											<h3 id="eventoDe">Título</h3><br>
											<span id="localDe">Local do Evento</span><br><br>
											<span><span id="dataDe">Data</span>
											  <br>
											  <span id="horaIniDe">00</span>:<span id="minIniDe">00</span> - 
											  <span id="horaFimDe">00</span>:<span id="minFimDe">00</span>
											  <br> 
											  Dia da semana </span><br><br>
											<span id="responsavelDe">Responsável </span><br>
											<span id="destinadoDe">Destinado</span>
										</div>
									</div>
									<div id="tipo">
										Encontros Universitários
									</div>
								</div>
							</li>
						</a>
					</ul>
				</div>
	</div>
	<div id="clear"></div>
</div>
<?php
//Paginas======================================
}else if (isset($url[3]) && $url[3] == 'editar') {
	include 'editar-evento-encontros.php';
}else if (isset($url[2]) && $url[2] == 'add-estudante') {
		
	if (isset($_POST['enviar'])) {
		$form['matricula'] 	= GetPost('matricula');
		$form['nome'] 		= GetPost('nome');
		$form['curso'] 		= GetPost('curso');
		$form['email'] 		= GetPost('email');
		$form['tipo'] 		= 'Estudante';
		$form['status']		= 1;
		$form['registro']	= date('Y-m-d H:i:s');

		if (empty($form['matricula'])) {
			echo '<script>alert("Campo Matrícula Vazio");</script>';
		}else if (empty($form['nome'])) {
			echo '<script>alert("Campo Nome Vazio");</script>';
		}if (empty($form['curso'])) {
			echo '<script>alert("Campo curso Vazio");</script>';
		}if (empty($form['email'])) {
			echo '<script>alert("Campo Email Vazio");</script>';
		}else{
			$check = DBread('eu_participantes', "WHERE matricula = '".$form['matricula']."'");
			if ($check == true) {
				echo '<script>alert("Matrícula já existente");</script>';
			}else{
				if (DBcreate('eu_participantes', $form)) {
					echo '<script>alert("Estudante cadastrado com sucesso!");</script>
							window.location="'.$way.'/'.$url[1].'";
					';	
				
				}
			}
		}
		
	}
	?>
	<div class="form" id="divCenter">
		<form method="post">
			<label>Matrícula</label><span style="color: red;"> *</span><br>
			<input type="text" name="matricula" value="<?php echo GetPost('matricula'); ?>" placeholder="Digite sua matrícula" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)"><br><br>	

			<label>Nome Completo</label><span style="color: red;"> *</span><br>
			<input type="text" name="nome" value="<?php echo GetPost('nome'); ?>" placeholder="Digite um nome" autocomplete="off" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)"><br><br>

			<label>Curso na UFC </label> <span class="red">*</span>
				<?php 
	        $cursos = DBread('cursos_ufc', "WHERE status = true");
	       ?>
	       <select name="curso" id="curso">
	          <option value="" selected="">Escolha o seu curso...</option>
	       <?php
	          for ($i=0; $i < count($cursos); $i++) { 
	       ?>
	         <option <?php echo printSelect(GetPost('curso'), nomeM($cursos[$i]['curso'])); ?> value="<?php echo nomeM($cursos[$i]['curso']); ?>"><?php echo nomeM($cursos[$i]['curso']); ?></option>
	         <?php }?>
	       </select>
	       <br><br><br>
	       <label>Email</label><span style="color: red;"> *</span><br>
			<input type="email" name="email" autocomplete="off" value="<?php echo GetPost('email'); ?>" placeholder="Digite seu email"><br><br>
			<center>
				<input type="submit" name="enviar" value="Enviar">
			</center>
		</form>
	</div>
	<?php
}else if (isset($url[2]) && $url[2] != '') {
	$codigo = DBescape($url[2]);
	$evento = DBread('eu_eventos', "WHERE codigo = '".$codigo."'");
	if ($evento == false) {
		echo '<div class="nada-encontrado"><h2>Evento não encontrado.</h2></div>';
	}else{
		$evento = $evento[0];
		//PAGINACAO DE EVENTO
		if (isset($url[3]) && $url[3] == 'presenca-entrada' || isset($url[3])  && $url[3] == 'presenca-saida') {
			$presenca = str_replace("presenca-", "", DBescape($url[3]));
			//confirmar
			if (isset($_GET['confirmar'])) {
				?>
				<script type="text/javascript">
					if (confirm("Você registrar a presença desse participante?")){
						window.location='<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'/?presenca=1&&matricula='.$_GET['matricula']; ?>';
					}else{
						window.location='<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].''; ?>';
					}
				</script>
				<?php
			}
			//GET PRESENÇA
			if (isset($_GET['presenca']) && $_GET['presenca'] == 1) {
				$matricula = DBescape($_GET['matricula']);
				$part = DBread('eu_participantes', "WHERE matricula = '".$matricula."'");
				$form['codigo'] 	= $url[2];
				$form['matricula']	= $part[0]['matricula'];
				$form['nome']		= $part[0]['nome'];
				$form['curso']		= $part[0]['curso'];
				$form['tipo']		= $part[0]['tipo'];
				$form['status']		= 1;
				$form['registro']	= date('Y-m-d H:i:s');
				if ($presenca == 'entrada') {
					$form['entrada'] = date('H:i:s');	
				}else{
					$form['saida'] = date('H:i:s');
				}
				$check = DBread('eu_eventos_pres', "WHERE codigo = '".$form['codigo']."' AND matricula = '".$form['matricula']."'");
				if ($check == false) {
					if (DBcreate('eu_eventos_pres', $form)) {
						echo '<script>alert("Presença registrada com sucesso!!!");
						window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';	
					}
				}else{
					if (DBUpDate('eu_eventos_pres', $form, "codigo = '".$form['codigo']."' AND matricula = '".$form['matricula']."'")) {
						echo '<script>alert("Presença registrada com sucesso!!!");
						window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
					}
				}
				
			}
			?>
			<script type="text/javascript">
				$(function(){
					$('#enviar').click(function(e) {
						e.preventDefault();
					});
					$('#pesquisar').keyup(function(){
						var pesquisa = $(this).val();
						if (pesquisa != '') {
							var dados = {palavra : pesquisa}

							$.post("../../../ajax/busca.php", dados, function(retorna){
								$('.result').empty().html(retorna);
							});
						}
			  		});
				});
			</script>
			<style type="text/css">
				#pesquisa input[type=text], input[type=number]{width:60%; height:100px; font-size: 30px; padding:2px 30px; border:1px #069 solid; border-radius:5px; margin:5px 0; background: #eee url(../../../images/search.png) no-repeat 8px center;}
			</style>
			<div class="title"><h2>Presença de <?php if($presenca == 'entrada'){ echo 'Entrada';}else{ echo 'Saída';} ?></h2></div>
			<div id="wrap-presenca" style="width: 99%; margin: 0 auto;">
				<div id="wrap-pesquisa">
					<div id="pesquisa">
						<form action="" method="post">
							<input type="number" id="pesquisar" autocomplete="off"  placeholder="Digite o número de matrícula"></input>
							<input type="submit" name="enviar" id="enviar" value="Pesquisar">
						</form>
					</div>
					<div id="clear"></div>
					<br><br><br><br>

					<div class="result">
						<?php 
							$part =  false; //DBread('eu_participantes', "LIMIT 0");
							if ($part == false) {
								//echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
							}else{

						?>
						<div class="tabela">
							<table>
								<tr>
									<th>Matrícula</th>
									<th>Nome Completo</th>
									<th>Curso</th>
									<th>Presença</th>
								</tr>
								<?php 
									for ($i=0; $i < count($part); $i++) { 
								?>
								<tr>
									<td><?php echo $part[$i]['matricula']; ?></td>
									<td><?php echo $part[$i]['nome']; ?></td>
									<td><?php echo $part[$i]['curso']; ?></td>
									<td><a href="?confirmar=1&&matricula=<?php echo $part[$i]['matricula']; ?>" class="botao" style="padding-left: 20px; padding-right: 20px; padding-top: 10px;">Confirmar</a></td>
								</tr>
								<?php } ?>
							</table>
							<div id="cont">(<?php echo count($part); ?>)</div>
						</div>
						<?php } ?>
					</div>
					
				</div>
			</div>	
			<?php
		}else{
		
		?>
		<div class="title"><h2>Evento - <?php echo $evento['codigo']; ?></h2></div>
		<br>
		<div id="wrap-evento" style="width: 99%; margin: 0 auto;">
			<div class="page-ati-single" style="margin-bottom: 20px;">
				<div class="cabecario">
					<div class="info-single">
						<ul>
							<li><h2><?php echo $evento['evento']; ?></h2></li>
							<li><?php echo $evento['local']; ?></li>
							<li><?php echo date('d/m/y', strtotime($evento['data'])); ?></li>
							<li><?php echo date('H:i', strtotime($evento['inicio'])).'h'; ?> - 
							  <?php echo date('H:i', strtotime($evento['fim'])).'h'; ?></li>
							  <li><?php echo $week[date('D', strtotime($evento['data']))]; ?> </li>
							  <li><?php echo $evento['responsavel']; ?> </li>
							  <li><?php echo $evento['destinado']; ?></li>
						</ul>
					</div>
				</div>
			</div>
			<div id="clear"></div>
			<div id="evento-opcoes">
			<br>
				<div class="title"><h2>Opções</h2></div>
				<?php 
					if (isset($_GET['action']) && $_GET['action'] != '') {
						switch ($_GET['action']) {
							case 1:
								$form['presenca'] = $_GET['presenca'];
								if (DBUpDate('eu_eventos', $form, "codigo = '".$evento['codigo']."'")) {
									echo '<script>alert("Ação realizada com sucesso");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
								}
							break;
							case 2:
								$form['status'] = $_GET['status'];
								if (DBUpDate('eu_eventos', $form, "codigo = '".$evento['codigo']."'")) {
									echo '<script>alert("Ação realizada com sucesso");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';	
								}
							break;
							
						}
					}
					if ($user['tipoSlug'] == 'ceo') {
						echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'/editar" class="botao">Editar</a>';
						if ($evento['status'] == 1) {
						echo '<a href=" '.$way.'/'.$url[1].'/'.$url[2].'?action=2&&status=0" class="botao">Desativar</a>';
						}else{
							echo '<a href=" '.$way.'/'.$url[1].'/'.$url[2].'?action=2&&status=1" class="botao">Ativar</a>';
						}

						if ($evento['presenca'] == 1) {
							echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=1&&presenca=0" class="botao">Desativar coleta de Presença</a>';
						}else{
							echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=1&&presenca=1" class="botao">Ativar coleta de Presença</a>';
						}
					}
					if ($evento['presenca'] == 1) {
						echo '<br>';
						echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'/presenca-entrada" class="botao">Presença de Entrada</a>';
						echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'/presenca-saida" class="botao">Presença de Saída</a>';
					}
				?>

			</div>
			<br><br>

			<div class="title"><h2>Responsáveis pela presença</h2></div>
			<?php 
				$resp = DBread('eu_eventos_resp', "WHERE codigo = '".$evento['codigo']."'");
				if ($resp == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{
				echo '<div class="corpo-single">';
					for ($i=0; $i < count($resp); $i++) { 
					$foto = DBread('bolsistas', "WHERE npacce = '".$resp[$i]['npacceResp']."'", "id, foto, nome, nomeUsual");
					$resp[$i]['nomeUsual'] = GetName($foto[0]['nome'], $foto[0]['nomeUsual']);
			?>
			<div class="foto-single">
				<a href="#" title="<?php echo $resp[$i]['npacceResp']; ?>">
				<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
				<div class="nome"><?php echo $resp[$i]['nomeUsual']; ?></div>
				</a>
			</div>
			<?php } 
				echo '</div><div id="clear"></div>';
			}?>
			<br><br>
			<div class="title"><h2>Participantes</h2></div>
			<?php 
				$part = DBread('eu_eventos_pres', "WHERE codigo = '".$evento['codigo']."'");
				if ($part == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{

					?>
					<div class="tabela">
						<table>
							<tr>
								<th>Matrícula</th>
								<th>Nome</th>
								<th>Curso</th>
								<th>Tipo</th>
								<th>Entrada</th>
								<th>Saída</th>
							</tr>
							<?php 
								for ($i=0; $i < count($part); $i++) { 
							?>
								<tr>
									<td><?php echo $part[$i]['matricula']; ?></td>
									<td><?php echo $part[$i]['nome']; ?></td>
									<td><?php echo $part[$i]['curso']; ?></td>
									<td><?php echo $part[$i]['tipo']; ?></td>
									<td><?php if($part[$i]['entrada'] == NULL){ echo '--:--';}else{ echo date('H:i', strtotime($part[$i]['entrada']));} ?></td>
									<td><?php if($part[$i]['saida'] == NULL){ echo '--:--';}else{ echo date('H:i', strtotime($part[$i]['saida']));} ?></td>
								</tr>
							<?php
								}
							?>
						</table>
					</div>
					<?php
				}
			?>
		</div>
		
		<?php
			}
		}//EVENTO -INICIAL
}else{

?>

<!-- <div class="title"><h2>Opções</h2></div> -->
<?php 
	if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno') {
	
?>
<!-- <div id="wrap-opcoes">
	<a href="<?php // echo $way.'/'.$url[1].'/criar-evento'; ?>" class="botao">Criar Evento</a>
	<a href="<?php // echo $way.'/'.$url[1].'/add-estudante'; ?>" class="botao">Adicionar Estudante</a>
</div>
 --><?php 
}
?>
<!-- <br><br> -->

<!-- <div class="title"><h2>Eventos</h2></div> -->
<?php 
	
	if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
		$eventos = DBread('eu_eventos', "ORDER BY data ASC");
	}else{
		$eventos = DBread('eu_eventos', "ORDER BY data ASC");

	}
	
	if ($eventos == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
?>
<!-- <div class="tabela">
	<table>
	
	<tr>
		<th>Evento</th>
		<th>Local</th>
		<th>Data</th>
		<th>Início</th>
		<th>Fim</th>
	</tr> -->		
<?php
	for ($i=0; $i < count($eventos); $i++) { 
?>
	<!-- 	<tr>
			<td> <a href="<?php //echo $way.'/'.$url[1].'/'.$eventos[$i]['codigo']; ?>"><?php //echo $eventos[$i]['evento']; ?></a></td>
			<td><?php //echo $eventos[$i]['local']; ?></td>
			<td><?php //echo date('d/m', strtotime($eventos[$i]['data'])); ?></td>
			<td><?php //echo date('H:i', strtotime($eventos[$i]['inicio'])); ?></td>
			<td><?php //echo date('H:i', strtotime($eventos[$i]['fim'])); ?></td>
		</tr> -->
<?php 
	}
?>

	<!-- </table>

</div> -->
<?php 
}
}//FIM PAGINA INICIAL
?>