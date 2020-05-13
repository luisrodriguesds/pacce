<style type="text/css">
	.label{ color: #4A85A0; }
	.tab{ width: 100%; margin: 0px auto; }
	.tab textarea{ padding:5px 5px; border:1px #ccc solid; border-radius:2px; margin:5px 0; width: 500px; height: 200px; }
	.tab table{border-collapse:collapse; border:1px solid #ccc; width:100%; font-family:arial,​verdana,​sans-serif; font-size:14px; margin-top:20px}
	.tab table th{ padding: 3px 0px; border-collapse:collapse; border:1px solid #ccc; }
	.tab table td{border-collapse:collapse; width: 50%; border:1px solid #ccc; padding:5px 0px; text-align: center; width: auto;}
	.tab form input[type=submit] { background:#069; width: 150px; height:30px; padding:0 10px; border:none; border-radius:2px; color:#FFF; cursor:pointer; margin:5px 0;}
	.tab form input[type=submit]:hover{ background-color: #003E5D; } 
</style>
<div class="title"><h2>Atividades de Célula</h2></div>
<p>Página destinada ao envio do seu projeto, relatório dos encontros de célula, cadastro do horário desses encontros e o cadastro de membros da sua célula. Depois de enviado qualquer um desses formulários, não será possível editá-los, mas poderá ser reenviado, por isso tenha muito cuidado na hora de preenchê-los.</p>
<br><br>
<?php 
	if (isset($url[2]) && $url[2] == 'cadastro-de-celula') {
?>
	<div class="title"><h2>Cadastro de Célula</h2></div>
	<br>
	<?php 
		if (isset($url[3]) && $url[3] == 'cadastrar-celula') {
	?>
	<div class="title"><h2>Cadastrar Horário de Célula</h2></div>
	<?php 
			if (isset($_POST['enviar'])) {
				$projeto = DBread('projetos', "WHERE npacce = '".$user['npacce']."' AND status = true ORDER BY registro DESC", "id, status, titulo");
				$form['npacce']			= $user['npacce'];
				$form['titulo']			= $projeto[0]['titulo'];
				$form['campus'] 		= GetPost('campus');
				$form['departamento'] 	= GetPost('departamento');
				$form['bloco'] 			= GetPost('bloco');
				$form['sala'] 			= GetPost('sala');
				$form['diaSemana'] 		= GetPost('diaSemana');
				$form['inicio'] 		= GetPost('horaIni').':'.GetPost('minIni').':'.GetPost('segIni');
				$form['fim'] 			= GetPost('horaFim').':'.GetPost('minFim').':'.GetPost('segFim');
				$form['diaSemana2'] 	= GetPost('diaSemana2');
				$form['inicio2'] 		= GetPost('horaIni2').':'.GetPost('minIni2').':'.GetPost('segIni2');
				$form['fim2'] 			= GetPost('horaFim2').':'.GetPost('minFim2').':'.GetPost('segFim2');
				$form['status']			= 1;
				$form['registro']		= date('Y-m-d H:i:s');
				$form['semestre']		= $semestre[date('m')];

				if (empty($form['campus'])) {
					echo '<script>alert("Campo campus está vazio");</script>';
				}else if (empty($form['departamento'])) {
					echo '<script>alert("Campo departamento está vazio");</script>';
				}else if (empty($form['bloco'])) {
					echo '<script>alert("Campo bloco está vazio");</script>';
				}else if (empty($form['sala'])) {
					echo '<script>alert("Campo sala está vazio");</script>';
				}else if (empty($form['diaSemana'])) {
					echo '<script>alert("Campo dia Semana está vazio");</script>';
				}else if (empty($form['inicio'])) {
					echo '<script>alert("Campo inicio está vazio");</script>';
				}else if (empty($form['fim'])) {
					echo '<script>alert("Campo fim está vazio");</script>';
				}else{
					$horaCell = DBread('horario_celula', "WHERE npacce = '".$user['npacce']."'");
					if ($horaCell == false) {
						if (DBcreate('horario_celula', $form)) {
							echo '<script>alert("Horário enviado com sucesso.");
	        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
						}
					}else{
						$up['status'] = 0;
						if (DBUpDate('horario_celula', $up, "npacce = '".$user['npacce']."'")) {
							if (DBcreate('horario_celula', $form)) {
								echo '<script>alert("Horário enviado com sucesso.");
	        						window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
							}	
						}
					}
				}
			}
			
		
	?>
	<div id="editar-ativ" class="form">
		<form action="" method="post" enctype="multipart/form-data">
			<label class="label">Campus</label> <span style="color: red">  *</span>
			<br>Indique o Campus.<br><br>
			<input type="radio" name="campus" value="PICI"></input> Pici<br><br>
			<input type="radio" name="campus" value="Benfica"></input> Benfica<br><br>
			<input type="radio" name="campus" value="Porangabuçu"></input> Porangabuçu<br><br>
			<input type="radio" name="campus" value="Labomar"></input> Labomar <br><br>
			<input type="radio" name="campus" value="Quixadá"></input> Quixadá <br><br>
			<input type="radio" name="campus" value="Sobral"></input> Sobral <br><br>
			<input type="radio" name="campus" value="Russas"></input> Russas <br><br>
			<input type="radio" name="campus" value="Crateús"></input> Crateús <br><br>
			<br>
			<label class="label">Departamento </label><span style="color: red">  *</span>
			<br>Indique o Departamento em que irá desenvolver os encontros de sua célula.<br>
			<input type="text" name="departamento" placeholder="Digite o Departamento em que sua célula irá acontecer..."></input><br><br>
			
			<label class="label">Bloco  </label><span style="color: red">  *</span>
			<br>Indique o Bloco em que irá desenvolver os encontros de sua célula.<br>
			<input type="text" name="bloco" placeholder="Digite o Bloco em que sua célula irá acontecer..."></input><br><br>
			<label class="label">Sala  </label><span style="color: red">  *</span>
			<br>Indique a Sala em que irá desenvolver os encontros de sua célula.<br>
			<input type="text" name="sala" placeholder="Digite a Sala em que sua célula irá acontecer..."></input><br><br>
			<br><br>
			<label class="label">Dias e Horários dos Encontros  </label>
			<br>Indique os horários que você irá se reunir. Caso se reúna em dois ou três horários diferentes, marque nas linhas abaixo. Se não tem horário certo, marque o período previsto. <br><br>
			<br><br>
			<label class="label">Dia  </label><span style="color: red">  *</span>
			<br>Dia da Semana<br>
			<select name="diaSemana">
				<option value="1">Escolha um dia da semana...</option>
				<option value="Segunda">Segunda</option>
				<option value="Terça">Terça</option>
				<option value="Quarta">Quarta</option>
				<option value="Quinta">Quinta</option>
				<option value="Sexta">Sexta</option>
			</select>
			<br><br>
			<label class="label">Início  </label><span style="color: red">  *</span>
			<br>Que horas começa sua célula?<br>
			<select name="horaIni">
				<?php 
					for ($i=0; $i <= 23; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="minIni">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="segIni">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			<br><br>
			<label class="label">Término   </label><span style="color: red">  *</span>
			<br>Que horas termina sua célula?<br>
			<select name="horaFim">
				<?php 
					for ($i=0; $i <= 23; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="minFim">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="segFim">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			<br><br>
			<br><br>
			<label class="label">Segundo Horário </label>
			<br>Se sua célula se reúne mais de uma vez por semana preencha os campos abaixo <br><br>		
			<br><br>
			<label class="label">Dia </label>
			<br>Dia da Semana<br>
			<select name="diaSemana2">
				<option value="1">Escolha um dia da semana...</option>
				<option value="Segunda">Segunda</option>
				<option value="Terça">Terça</option>
				<option value="Quarta">Quarta</option>
				<option value="Quinta">Quinta</option>
				<option value="Sexta">Sexta</option>
			</select>
			<br><br>
			<label class="label">Início</label>
			<br>Que horas começa sua célula?<br>
			<select name="horaIni2">
				<?php 
					for ($i=0; $i <= 23; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="minIni2">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="segIni2">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			<br><br>
			<label class="label">Término </label>
			<br>Que horas termina sua célula?<br>
			<select name="horaFim2">
				<?php 
					for ($i=0; $i <= 23; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="minFim2">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="segFim2">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			<br><br><br><br>
			<center>
				<input type="submit" name="enviar" value="Enviar"></input>
			</center>
		</form>
	</div>
	<?php
		}else{
	?>
	<div class="title"><h2>Opções</h2></div>
	<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/cadastrar-celula'; ?>" class="botao">Cadastrar Horário de Célula</a>
	<br><br>
	<div class="title"><h2>Horários Cadastrados</h2></div>

	<?php 
		$horario = DBread('horario_celula', "WHERE npacce = '".$user['npacce']."' ORDER BY registro DESC");
		if ($horario == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
	?>
	<div class="tabela">
		<table>
			<tr>
				<th>Título</th>
				<th>Campus</th>
				<th>Local</th>
				<th>Dia e Hora</th>
				<th>Semestre</th>
				<th>Status</th>
			</tr>
			<?php 
				for ($i=0; $i < count($horario); $i++) { 
			?>
			<tr>
				<td><?php echo texto($horario[$i]['titulo'], 30); ?></td>
				<td><?php echo $horario[$i]['campus']; ?></td>
				<td><?php echo $horario[$i]['bloco'].' - '.$horario[$i]['sala']; ?></td>
				<td><?php echo $horario[$i]['diaSemana']; ?> | <?php echo date('H:i', strtotime($horario[$i]['inicio'])).'hr'; ?> - <?php echo date('H:i', strtotime($horario[$i]['fim'])).'hr'; ?>
				<?php 
					if ($horario[$i]['diaSemana2'] != 1) {
						echo '<br>'.$horario[$i]['diaSemana2'].' | '. date('H:i', strtotime($horario[$i]['inicio2'])).'hr - '.date('H:i', strtotime($horario[$i]['fim2'])).'hr';
					}
				?>
				</td>
				<td><?php echo $horario[$i]['semestre']; ?></td>
				<td><?php if($horario[$i]['status'] == 1){echo "Ativo";}else{echo "Inativo";} ?></td>
			</tr>
			<?php }?>
		</table>
	</div>
		<?php } ?>
	<?php }?>
<?php	
	}
	else if (isset($url[2]) && $url[2] == 'cadastro-de-membros') {

?>	
	<div class="title"><h2>Cadastro de Membros</h2></div>
	<br>
	<?php 
		if (isset($url[3]) && $url[3] == 'cadastrar-membro') {
	?>
	<div class="title"><h2>Cadastrar Membro em Célula</h2></div>
	<?php
		if (isset($_POST['enviar'])) {
			$projeto = DBread('projetos', "WHERE npacce = '".$user['npacce']."' AND status = true ORDER BY registro DESC", "id, status, titulo");
			$form['npacce']		= $user['npacce'];
			$form['titulo']		= $projeto[0]['titulo'];
			$form['membro'] 	= GetPost('membro');
			$form['matricula'] 	= GetPost('matricula');
			$form['curso'] 		= GetPost('curso');
			$form['semestreMem']= GetPost('semestreMem');
			$form['email'] 		= GetPost('email');
			$form['fone'] 		= GetPost('fone');
			$form['fone2'] 		= GetPost('fone2');
			$form['perfil'] 	= GetPost('perfil');
			$form['relacao'] 	= GetPost('relacao');
			$form['status']		= 1;
			$form['registro']	= date('Y-m-d H:i:s');
			$form['semestre']	= $semestre[date('m')];
			if (empty($form['membro'])) {
				echo '<script>alert("Campo membro está vazio");</script>';
			}else if (empty($form['matricula'])) {
				echo '<script>alert("Campo matricula está vazio");</script>';
			}else if (empty($form['curso'])) {
				echo '<script>alert("Campo curso está vazio");</script>';
			}else if (empty($form['semestreMem'])) {
				echo '<script>alert("Campo semestreMem está vazio");</script>';
			}else if (empty($form['email'])) {
				echo '<script>alert("Campo email está vazio");</script>';
			}else if (empty($form['fone'])) {
				echo '<script>alert("Campo fone está vazio");</script>';
			}else if (empty($form['perfil'])) {
				echo '<script>alert("Campo perfil está vazio");</script>';
			}else if (empty($form['relacao'])) {
				echo '<script>alert("Campo relacao está vazio");</script>';
			}else{
				if (DBcreate('membros_celula', $form)) {
					echo '<script>alert("Membro cadastrado com sucesso.");
					window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
				}
			}

		}
	?>
	<div id="editar-ativ" class="form">
		<form action="" method="post" enctype="multipart/form-data">
	<label class="label">Membro</label><span style="color: red;">  *</span>
	<br>Insira o nome completo do membro da sua célula.	<br>
	<input type="text" onkeyup="maiuscula(this)" name="membro" placeholder="Digite o nome completo desse membro"></input>
	<br><br>
	<label class="label">Matrícula </label><span style="color: red;">  *</span>
	<br>Insira o Nº de Matrícula da UFC do membro da sua célula.		<br>
	<input type="number" name="matricula" placeholder="Digite o número de matrícula desse membro"></input>
	<br><br>
	<label class="label">Curso </label><span style="color: red;">  *</span>
	<br>Insira o Nº de Matrícula da UFC do membro da sua célula.<br>
	<select name="curso">
		<option>Escolha o curso desse membro...</option>
		<?php 
		$cursos = DBread('cursos_ufc');
		if ($cursos == false) {
			echo '<option> Nada encontrado.</option>';
		}else{
			for ($i=0; $i < count($cursos); $i++) { 
				echo '<option value="'.nomeM($cursos[$i]['curso']).'"> '.nomeM($cursos[$i]['curso']).'.</option>';
			}
		}
		?>
	</select>
	<br><br>
	<label class="label">Semestre  </label><span style="color: red;">  *</span>
	<br>Indique o semestre em que o membro da sua célula se encontra.<br>
	<select name="semestreMem">
		<option value="1">Escolha o semestre desse membro...</option>
		<?php 
			for ($i=1; $i <= 12; $i++) { 
				echo '<option value="'.$i.'">'.$i.'°</option>';
			}
		 ?>
	</select>
	<br><br>
	<label class="label">Email   </label><span style="color: red;">  *</span>
	<br>Insira o principal e-mail do membro.<br>
	<input type="email" name="email" placeholder="Digite o email desse membro"></input>
	<br><br>
	<script type="text/javascript">
		$(function(){
			$('#fone').mask("(99)99999-9999");
			$('#fone2').mask("(99)99999-9999");
		});
	</script>
	<label class="label">Fone 1   </label><span style="color: red;">  *</span>
	<br>Insira o telefone do membro da sua célula.<br>
	<input type="text"	name="fone" id="fone" maxlength="15" placeholder="Digite o fone desse membro"></input>
	<br><br>
	<label class="label">Fone 2   </label>
	<br>Insira o telefone do membro da sua célula.<br>
	<input type="text"	name="fone2" id="fone2" maxlength="15" placeholder="Digite o fone desse membro"></input>
	<br><br>
	<label class="label">Perfil </label><span style="color: red;">  *</span>
	<br>Escreva um pequeno texto falando sobre o membro de sua célula. Como ele é, pontos em comum com você e o que considera importante nele(a) que contribuirá com o bom desempenho da célula. Cite se ele já teve contato com a Aprendizagem Cooperativa.<br>
	<textarea name="perfil"></textarea>
	<br><br>
	<label class="label">Relação    </label><span style="color: red;">  *</span>
	<br>Marque qual a relação que você tem com o membro da célula.<br>
	<br>
	<input type="radio" name="relacao" value="Amigos antes de entrar na UFC"></input> Amigos antes de entrar na UFC <br><br>
	<input type="radio" name="relacao" value="Amigos, se conheceram aqui na UFC"></input> Amigos, se conheceram aqui na UFC<br><br>
	<input type="radio" name="relacao" value="Colegas de curso que se conhecem muito bem, mas não tem fortes laços de amizade"></input> Colegas de curso que se conhecem muito bem, mas não tem fortes laços de amizade<br><br>
	<input type="radio" name="relacao" value="Apenas colegas de classe"></input> Apenas colegas de classe<br><br>
	<input type="radio" name="relacao" value="Conhecidos"></input> Conhecidos<br><br>
	<input type="radio" name="relacao" value="Se conheceram durante a divulgação da célula"></input> Se conheceram durante a divulgação da célula<br><br>

	<center>
		<input type="submit" name="enviar" value="Enviar"></input>
	</center>
	</form>
	</div>
	<?php
		}else{

	?>
	<div class="title"><h2>Opções</h2></div>
	<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/cadastrar-membro'; ?>" class="botao">Cadastrar Membro em Célula</a>
	<br><br>
	<div class="title"><h2>Membros Cadastrados</h2></div>
	<?php 
		$membros = DBread('membros_celula', "WHERE npacce = '".$user['npacce']."'");
		if ($membros == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
			if (isset($_GET['action']) && $_GET['action'] != '' && isset($_GET['id']) && $_GET['id'] != '') {
				$id = DBescape($_GET['id']);
				switch ($_GET['action']) {
					case 1:
						$up['status'] = 1;
						if (DBUpDate('membros_celula', $up, "id = '".$id."'")) {
							echo '<script>alert("Ação Realizada com sucesso!");
								window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
						}
					break;
					case 2:
						$up['status'] = 0;
						if (DBUpDate('membros_celula', $up, "id = '".$id."'")) {
							echo '<script>alert("Ação Realizada com sucesso!");
								window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
						}
					break;
				}
			}

	?>
	<div class="tabela">
	
		<table>
			<tr>
				<th>Título</th>
				<th>Membros</th>
				<th>Curso</th>
				<th>Status</th>
				<th>Ação</th>
			</tr>
			<?php 
	
				for ($i=0; $i < count($membros); $i++) { 
			?>
			<tr>
				<td><?php echo texto($membros[$i]['titulo'], 25); ?></td>
				<td><?php echo $membros[$i]['membro']; ?></td>
				<td><?php echo  texto($membros[$i]['curso'], 25);?></td>
				<td>
					<?php if ($membros[$i]['status'] == 1) { echo 'Ativo'; }else{ echo 'Inativo';}?>
				</td>
				<td> 
				<?php if ($membros[$i]['status'] == 1) {echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=2&&id='.$membros[$i]['id'].'">Desativar</a>';}else{ echo '<a href="'.$way.'/'.$url[1].'/'.$url[2].'?action=1&&id='.$membros[$i]['id'].'">Ativar</a>';}?></td>
			</tr>
			<?php } ?>
		</table>
		</div>
		<?php } ?>
	<?php } ?>
<?php	
	}else if (isset($url[2]) && $url[2] == 'encontro-de-celula') {

?>
	<div class="title"><h2>Encontros de Célula</h2></div>
	
	<?php 
	if (isset($url[3]) && $url[3] != '') {
		echo '<div id="editar-ativ" class="form">';
		
		$membros = DBread('membros_celula', "WHERE npacce = '".$user['npacce']."' AND status = true", "id, membro");
		$projeto = DBread('projetos', "	WHERE npacce ='".$user['npacce']."' AND status = true", "id, titulo");
		if ($projeto == false) {
			echo '<script>alert("Envie seu projeto!!!!!!");
		    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
		}else{
			$projeto = $projeto[0];
		}
		if (isset($_GET['reuniao']) && $_GET['reuniao'] == 1) {
			$enc = DBread('enc_celula', "WHERE npacce = '".$user['npacce']."' AND semana = '".substr($url[3], -2)."'");
				
			if (isset($_POST['enviar'])) {
				
				$form['npacce'] 			= $user['npacce'];
				$form['titulo']		    	= DBescape($projeto['titulo']);
				$form['semana']				= substr($url[3], -2);
				$form['reuniao']			= 1;
				$form['data'] 				= GetPost('data');
				$form['ch']					= GetPost('hora').':'.GetPost('min').':'.GetPost('seg');
				$form['local'] 				= GetPost('local');
				$form['turno'] 				= GetPost('turno');
				$form['visitantes'] 		= GetPost('visitantes');
				$form['tema'] 				= GetPost('tema');
				$form['membros'] 			= '';
				$form['pilares'] 			= '';
				$form['pontualidade'] 		= GetPost('pontualidade');
				$form['aproveitamento'] 	= GetPost('aproveitamento');
				$form['responsabilidade'] 	= GetPost('responsabilidade');
				$form['colaboracao'] 		= GetPost('colaboracao');
				$form['interesse'] 			= GetPost('interesse');
				$form['participacao'] 		= GetPost('participacao');
				$form['planejado'] 			= GetPost('planejado');
				$form['relato'] 			= GetPost('relato');
				$form['status']				= 1;
				$form['registro']			= date('Y-m-d H:i:s');
				
				//COLOCAR MEMBRO EM LISTA
				if (isset($_REQUEST['membros'])) {
					for ($i=0; $i < count($_REQUEST['membros']); $i++) { 
						 $v = '';
						if ($i == 0) {
							$v = '';
						}else{
							$v = ', ';
						}
						$form['membros'] = $form['membros'].$v.$_REQUEST['membros'][$i];
					}
				}
				if($membros == false){ $form['membros'] = 'Nenhum membro';}
				if (isset($_REQUEST['pilares'])) {
					for ($i=0; $i < count($_REQUEST['pilares']); $i++) { 
						 $v = '';
						if ($i == 0) {
							$v = '';
						}else{
							$v = ', ';
						}
						$form['pilares'] = $form['pilares'].$v.$_REQUEST['pilares'][$i];
					}
				}
				
				if (empty($form['data'])) {
					echo '<script>alert("Campo data vazio!");</script>';
				}else if (empty($form['local'])) {
					echo '<script>alert("Campo local vazio!");</script>';
				}else if (empty($form['turno'])) {
					echo '<script>alert("Campo turno vazio!");</script>';
				}else if (empty($form['tema'])) {
					echo '<script>alert("Campo tema vazio!");</script>';
				}else if (empty($form['membros'])) {
					echo '<script>alert("Campo membros vazio!");</script>';
				}else if (empty($form['pilares'])) {
					echo '<script>alert("Campo pilares vazio!");</script>';
				}else if (empty($form['pontualidade'])) {
					echo '<script>alert("Campo pontualidade vazio!");</script>';
				}else if (empty($form['aproveitamento'])) {
					echo '<script>alert("Campo aproveitamento vazio!");</script>';
				}else if (empty($form['responsabilidade'])) {
					echo '<script>alert("Campo responsabilidade vazio!");</script>';
				}else if (empty($form['interesse'])) {
					echo '<script>alert("Campo interesse vazio!");</script>';
				}else if (empty($form['participacao'])) {
					echo '<script>alert("Campo participacao vazio!");</script>';
				}else if (empty($form['planejado'])) {
					echo '<script>alert("Campo planejado vazio!");</script>';
				}else if (empty($form['relato'])) {
					echo '<script>alert("Campo relato vazio!");</script>';
				}else if (empty($form['colaboracao'])) {
					echo '<script>alert("Campo colaboracao vazio!");</script>';
				}else if (empty($form['ch'])) {
					echo '<script>alert("Campo CH vazio!");</script>';
				}else{
					if ($enc == true) {
						if (DBUpDate('enc_celula', $form, "npacce = '".$user['npacce']."' AND semana = '".substr($url[3], -2)."'")) {
							echo '<script>alert("Relatório enviado com sucesso.");
		        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
						}
					}else{
						if (DBcreate('enc_celula', $form)) {
							echo '<script>alert("Relatório enviado com sucesso.");
		        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
						}
					}
				}
			}
	?>
	<form method="post" enctype="multpart/form-data">
		<label class="label">Data do Encontro</label> <span style="color: red;">  *</span>
		<br>Qual foi a data do encontro?<br>
		<input type="date" name="data"></input><br><br>
		<label class="label">Local do Encontro</label> <span style="color: red;">  *</span>
		<br>Onde você se reuniu essa semana? Indique o Departamento, bloco, sala etc.<br>
		<input type="text" name="local" placeholder="Digite sua o local da sua célula"></input><br><br>
		<label class="label">Turno do Encontro</label> <span style="color: red;">  *</span>
		<br>Que turno foi o encontro da sua célula esta semana?<br><br>
		<input type="radio" name="turno" value="Manhã"></input>  Manhã<br><br>
		<input type="radio" name="turno" value="Tarde"></input>  Tarde<br><br>
		<input type="radio" name="turno" value="Noite"></input>  Noite<br><br>
		<input type="radio" name="turno" value="Integral"></input>  Integral<br><br>
		<label class="label">CH </label> <span style="color: red;">  *</span>
		<br>Quantas horas você passou reunido (estudando) com sua célula nesta semana<br>
		<select name="hora">
				<?php 
					for ($i=0; $i <= 23; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="min">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
			:
			<select name="seg">
				<?php 
					for ($i=0; $i <= 59; $i++) {
						if ($i < 10) {
						 	$value = '0'.$i;
						 }else{
						 	$value = $i;
						 } 
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
				?>
			</select>
		<br><br>
		<?php 
			
		?>
		<label class="label">Membros  </label> <span style="color: red;">  *</span>
		<?php 
			if ($membros == false) {
				echo '<br>Você precisa cadastrar membros em sua célula<br><br>';
			}else if (count($membros) == 1) {
				echo '<br>Esse membro compareceu no encontro essa semana?<br><br>';
			}
			else{
				echo '<br>Quais desses membros esteve presente no encontro dessa semana?<br><br>';
			}
			if ($membros == false) {
				echo '<span style="color: red;">Você não tem Membros cadastrados!</span><br><br>';
			}else{
				for ($i=0; $i < count($membros); $i++) { 
					echo '<input type="checkbox" name="membros[]" value="'.$membros[$i]['membro'].'"></input>  '.$membros[$i]['membro'].'<br><br>';
				}
			}
		?>
		
		<label class="label">Visitantes  </label> <span style="color: red;">  *</span>
		<br>Quantos visitantes (membros não cadastrados da célula) estiveram presentes nos encontros desta semana<br>
		<select name="visitantes">
			<option value="	">Visitantes...</option>
			<?php 
			for ($i=0; $i <= 9; $i++) { 
				echo '<option value="'.$i.'">'.$i.'</option>';
			}
			?>
			<option value="10 ou mais...">10 ou mais...</option>
		</select>
		<br><br>
		<label class="label">Tema   </label> <span style="color: red;">  *</span>
		<br>Qual o tema ou assunto abordado no estudo em grupo nesta semana<br>
		<input type="text" name="tema" placeholder="Digite o tema abordado nesse encontro"></input><br><br>
		<label class="label">Pilares    </label> <span style="color: red;">  *</span>
		<br>Quais os pilares da Aprendizagem Cooperativa você utilizou em sua célula esta semana<br><br>
		<input type="checkbox" name="pilares[]" value="Interdependência Positiva"></input> Interdependência Positiva<br><br>
		<input type="checkbox" name="pilares[]" value="Responsabilização Individual"></input> Responsabilização Individual<br><br>
		<input type="checkbox" name="pilares[]" value="Interação Face a Face"></input> Interação Face a Face<br><br>
		<input type="checkbox" name="pilares[]" value="Habilidades Sociais"></input>  Habilidades Sociais<br><br>
		<input type="checkbox" name="pilares[]" value="Processamento de Grupo"></input>  Processamento de Grupo<br><br>
		<label class="label">AV     </label> <span style="color: red;">  *</span>
		<br>Avalie o desempenho de sua célula esta semana. Dê uma nota de 1 a 5, onde 1 é a menor e 5 é a maior.<br><br>
		<table width="100%">
			<tr>
				<td></td>
				
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
			</tr>
			<tr>
				<td style="width: 150px;padding-right: 10px;padding-right: 10px;">Pontualidade e Assiduidade do Grupo</td>
				
				<td><input type="radio" name="pontualidade" value="1"></input></td>
				<td><input type="radio" name="pontualidade" value="2"></input></td>
				<td><input type="radio" name="pontualidade" value="3"></input></td>
				<td><input type="radio" name="pontualidade" value="4"></input></td>
				<td><input type="radio" name="pontualidade" value="5"></input></td>
			</tr>
			<tr>
				<td><br></td>
			</tr>
			<tr>
				<td style="width: 150px;padding-right: 10px;">Aproveitamento do Tempo</td>
				<td><input type="radio" name="aproveitamento" value="1"></input></td>
				<td><input type="radio" name="aproveitamento" value="2"></input></td>
				<td><input type="radio" name="aproveitamento" value="3"></input></td>
				<td><input type="radio" name="aproveitamento" value="4"></input></td>
				<td><input type="radio" name="aproveitamento" value="5"></input></td>
			</tr>
			<tr>
				<td><br></td>
			</tr>
			<tr>
				<td style="width: 150px;padding-right: 10px;">Responsabilidade do grupo</td>
				<td><input type="radio" name="responsabilidade" value="1"></input></td>
				<td><input type="radio" name="responsabilidade" value="2"></input></td>
				<td><input type="radio" name="responsabilidade" value="3"></input></td>
				<td><input type="radio" name="responsabilidade" value="4"></input></td>
				<td><input type="radio" name="responsabilidade" value="5"></input></td>
			</tr>
			<tr>
				<td><br></td>
			</tr>
			<tr>
				<td style="width: 150px;padding-right: 10px;">Colaboração dos membros (habilidades)</td>
				<td><input type="radio" name="colaboracao" value="1"></input></td>
				<td><input type="radio" name="colaboracao" value="2"></input></td>
				<td><input type="radio" name="colaboracao" value="3"></input></td>
				<td><input type="radio" name="colaboracao" value="4"></input></td>
				<td><input type="radio" name="colaboracao" value="5"></input></td>
			</tr>
			<tr>
				<td><br></td>
			</tr>
			<tr>
				<td style="width: 150px;padding-right: 10px;">Nível de interesse no aprendizado do grupo (interação)</td>
				<td><input type="radio" name="interesse" value="1"></input></td>
				<td><input type="radio" name="interesse" value="2"></input></td>
				<td><input type="radio" name="interesse" value="3"></input></td>
				<td><input type="radio" name="interesse" value="4"></input></td>
				<td><input type="radio" name="interesse" value="5"></input></td>
			</tr>
			<tr>
				<td><br></td>
			</tr>
			<tr>
				<td style="width: 150px;padding-right: 10px;">Nível de participação no Processamento de Grupo</td>
				<td><input type="radio" name="participacao" value="1"></input></td>
				<td><input type="radio" name="participacao" value="2"></input></td>
				<td><input type="radio" name="participacao" value="3"></input></td>
				<td><input type="radio" name="participacao" value="4"></input></td>
				<td><input type="radio" name="participacao" value="5"></input></td>
			</tr>
			<tr>
				<td><br></td>
			</tr>
			<tr>
				<td style="width: 150px;padding-right: 10px;">Quanto cumpriu do planejado</td>
				<td><input type="radio" name="planejado" value="1"></input></td>
				<td><input type="radio" name="planejado" value="2"></input></td>
				<td><input type="radio" name="planejado" value="3"></input></td>
				<td><input type="radio" name="planejado" value="4"></input></td>
				<td><input type="radio" name="planejado" value="5"></input></td>
			</tr>
		</table>
		<br><br>
		<label class="label">Relato    </label> <span style="color: red;">  *</span>
		<br>Escreva um relato da sua célula, contando sobre o quebra-gelo, o seu encontro e o seu processamento de grupo. Neles, você vai descrever quais os pilares foram aplicados e como você desenvolveu eles em cada atividade.
		<br><br>Se você tiver feito encontro em dia ou horário diferente do que está cadastrado no site, diga o dia e o horário que você fez essa semana.
		<br><br>É muito importante também, que você relate sobre o motivo das notas diferentes de 3 na avaliação feita acima.<br>
		<textarea name="relato"></textarea>
		<br><br>
		<center>
			<input type="submit" name="enviar" value="Enviar"></input>
		</center>
		
	</form>
	<?php
		}else if (isset($_GET['reuniao']) && $_GET['reuniao'] == 2) {
			$enc = DBread('enc_celula', "WHERE npacce = '".$user['npacce']."' AND semana = '".substr($url[3], -2)."'");
			$form['npacce'] 			= $user['npacce'];
				$form['titulo']				= DBescape($projeto['titulo']);
				$form['semana']				= substr($url[3], -2);
				$form['reuniao']			= 2;
				$form['ch']					= '00:00:00';
				$form['registro']			= date('Y-m-d H:i:s');
			if ($enc == true) {
				if (DBUpDate('enc_celula', $form, "npacce = '".$user['npacce']."' AND semana = '".substr($url[3], -2)."'")) {
					echo '<script>alert("Relatório enviado com sucesso.");
        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
				}
			}else{
				if (DBcreate('enc_celula', $form)) {
					echo '<script>alert("Relatório enviado com sucesso.");
        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
				}
			}
		}else if (isset($_GET['reuniao']) && $_GET['reuniao'] == 3) {
			$enc = DBread('enc_celula', "WHERE npacce = '".$user['npacce']."' AND semana = '".substr($url[3], -2)."'");
			
			if (isset($_POST['enviar'])) {
				$form['npacce'] 			= $user['npacce'];
				$form['titulo']				= DBescape($projeto['titulo']);
				$form['semana']				= substr($url[3], -2);
				$form['reuniao']			= 3;
				$form['ch']					= GetPost('hora').':'.GetPost('min').':'.GetPost('seg');
				$form['local'] 				= GetPost('local');
				$form['status']				= 1;
				$form['atividades']			= GetPost('atividades');
				$form['relato']				= GetPost('relato');
				$form['registro']			= date('Y-m-d H:i:s');

				if (empty($form['atividades'])) {
						echo '<script>alert("Campo Atividades vazio!");</script>';
					}else if (empty($form['ch'])) {
						echo '<script>alert("Campo CH vazio!");</script>';
					}else if (empty($form['relato'])) {
						echo '<script>alert("Campo Relato vazio!");</script>';
					}else{
						if ($form['atividades'] == 3) {
							$form['atividades'] == GetPost('outroText');
						}
						if ($enc == true) {
							if (DBUpDate('enc_celula', $form, "npacce = '".$user['npacce']."' AND semana = '".substr($url[3], -2)."'")) {
								echo '<script>alert("Relatório enviado com sucesso.");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
							}
						}else{
							if (DBcreate('enc_celula', $form)) {
								echo '<script>alert("Relatório enviado com sucesso.");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
							}
						}
					}
			}				
	?>				<script>
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
							$("#ondeeee").click(function () {
								$("#outroText").css({'display':'none'});
							});
						});
					</script>
					<form method="post">
						<label class="label">Atividades</label> <span style="color: red;">  *</span><br>
						Marque as atividades que Você fez em prol da célula (exceto reunião para estudar)<br><br>
						<input type="radio" id="onde" name="atividades" value="Divulgacao"></input> Divulgação da Célula<br><br>
						<input type="radio" id="ondee" name="atividades" value="Preparação de material"></input> Preparação de material<br><br>
						<input type="radio" id="ondeee" name="atividades" value="Reescrever o projeto"></input> Reescrever o projeto<br><br>
						<input type="radio" id="ondeeee" name="atividades" value="Confraternização"></input> Confraternização da célula<br><br>	
						<input type="radio" id="outro" name="atividades" value="3"></input>  Outro
						<input type="text" style="display: none;" id="outroText" name="outroText" placeholder="Digite onde você contou sua história de vida"></input>
						<br><br>
						<label class="label">CH</label> <span style="color: red;">  *</span><br>
						Informe quantas horas você trabalhou com as atividades acima marcadas <br><br>
						<select name="hora">
						<?php 
							for ($i=0; $i <= 23; $i++) {
								if ($i < 10) {
								 	$value = '0'.$i;
								 }else{
								 	$value = $i;
								 } 
								echo '<option value="'.$value.'">'.$value.'</option>';
							}
						?>
						</select>
						:
						<select name="min">
							<?php 
								for ($i=0; $i <= 59; $i++) {
									if ($i < 10) {
									 	$value = '0'.$i;
									 }else{
									 	$value = $i;
									 } 
									echo '<option value="'.$value.'">'.$value.'</option>';
								}
							?>
						</select>
						:
						<select name="seg">
							<?php 
								for ($i=0; $i <= 59; $i++) {
									if ($i < 10) {
									 	$value = '0'.$i;
									 }else{
									 	$value = $i;
									 } 
									echo '<option value="'.$value.'">'.$value.'</option>';
								}
							?>
						</select>
						<br><br>
						<label class="label">Relato</label> <span style="color: red;">  *</span><br>
						Escreva um breve relato do que aconteceu de mais importante em sua célula esta semana<br><br>
						<textarea name="relato"></textarea><br><br>
						<center>
							<input type="submit" name="enviar" value="Enviar"></input>	
						</center>
					</form>
				<?php
				}else if (isset($_GET['reuniao']) && $_GET['reuniao'] == 5) {
					$enc = DBread('enc_celula', "WHERE npacce = '".$user['npacce']."' AND semana = '".substr($url[3], -2)."'");
					$form['npacce'] 			= $user['npacce'];
					$form['titulo']				= DBescape($projeto['titulo']);
					$form['semana']				= substr($url[3], -2);
					$form['reuniao']			= 5;
					$form['ch']					= '04:00:00';
					$form['status']				= 1;
					$form['atividades']			= GetPost('atividades');
					$form['relato']				= GetPost('relato');
					$form['registro']			= date('Y-m-d H:i:s');

					if ($enc == true) {
						if (DBUpDate('enc_celula', $form, "npacce = '".$user['npacce']."' AND semana = '".substr($url[3], -2)."'")) {
							echo '<script>alert("Relatório enviado com sucesso.");
		        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
						}	
					}else{
						if (DBcreate('enc_celula', $form)) {
							echo '<script>alert("Relatório enviado com sucesso.");
		        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
						}
					}
				}else{


				?>
		<form method="get" enctype="multpart/form-data">
			<label class="label">Reunião </label><span style="color: red;">  *</span>
			<br>Você se reuniu com sua célula durante esta semana?<br><br>
			<input type="radio" name="reuniao" value="1"></input>  Sim, me reuni com a equipe <br><br>
		    <input type="radio" name="reuniao" value="2"></input> Não houve nenhuma atividade <br><br>
		    <input type="radio" name="reuniao" value="3"></input> Não, mas trabalhei para a célula<br><br>
		    <input type="radio" name="reuniao" value="5"></input> Feriado<br><br>
		    <input type="submit" name="enviar" value="Continuar"></input>
		</form>
	<?php
	}
	echo '</div>';
	}else{

		for ($i=1; $i <= $semana; $i++) {
		if ($i < 10) {
		 	$week = '0'.$i;
		 }else{
		 	$week = $i;
		 } 
	?>
	<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/semana-'.$week; ?>" class="botao"> <?php echo 'Semana '.$week; ?></a>
	
	<?php
		}
	?>
	<br><br>
	<div class="title"><h2>Histórico de Relatórios</h2></div>
	<?php 
		$enc = DBread('enc_celula', "WHERE npacce = '".$user['npacce']."' ORDER BY semana ASC", "id, titulo, reuniao, semana, ch");

		if ($enc == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
		}else{
	?>
	<div class="tabela">
		<table>
			<tr>
				<th>Título</th>
				<th>Semana</th>
				<th>Horas</th>
				<th>Situação</th>
			</tr>
			<?php 
				for ($i=0; $i < count($enc); $i++) { 
			
			?>
			<tr>
				<td><?php echo texto($enc[$i]['titulo'], 30	); ?></td>
				<td><?php if($enc[$i]['semana'] < 10){ echo '0'.$enc[$i]['semana'];}else{ echo $enc[$i]['semana'];}  ?></td>
				<td><?php echo date('H:i', strtotime($enc[$i]['ch'])).'hr'; ?></td>
				<td><?php if($enc[$i]['reuniao'] == 1){ echo 'Sim, me reuni com a equipe';}else if($enc[$i]['reuniao'] == 2){ echo 'Não houve nenhuma atividade';}else if($enc[$i]['reuniao'] == 3){ echo 'Não, mas trabalhei para a célula';}else if($enc[$i]['reuniao'] == 5){ echo 'Feriado';} ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php
		}
	}	
	?>


<?php
	}
	else if (isset($url[2]) && $url[2] == 'projeto') {
?>
	<div class="title"><h2>Projeto <?php echo date('Y'); ?></h2>
	</div>
	<?php 
		if (isset($url[3]) && $url[3] == 'cadastrar-projeto') {
	?>
	<br>Preencha os dados abaixo solicitados utilizando o Guia de elaboração de projetos 2016, abaixo:
		<br><br>
		<center><a href="http://www.slideshare.net/slideshow/embed_code/25696108 "target="_blank"><font color="blue"><u>Guia de elaboração do projeto</font></a></u></font></a></center>
	<br>
	<div class="title"><h2>Cadastrar Projeto</h2></div>
	<?php 
		  if (isset($_POST['enviar'])) {
		  	$form['titulo'] 					= GetPost('titulo');
		  	$form['tema']						= GetPost('tema');
			$form['sinopse'] 					= GetPost('sinopse');
			$form['introducao']					= GetPost('introducao');
			$form['justificativa'] 				= GetPost('justificativa');
			$form['publico']					= GetPost('publico');
			$form['local']						= GetPost('local');
			$form['objetivosGerais'] 			= GetPost('objetivosGerais');
			$form['objetivosEspecificos']		= GetPost('objetivosEspecificos');
			$form['produtos'] 					= GetPost('produtos');
			$form['indicadores'] 				= GetPost('indicadores');
			$form['meiosVerificacao'] 			= GetPost('meiosVerificacao');
			$form['atividades'] 				= GetPost('atividades');
			$form['fortalezas'] 				= GetPost('fortalezas');
			$form['fraquezas'] 					= GetPost('fraquezas');
			$form['estrategias']				= GetPost('estrategias');
			$form['insumo']						= GetPost('insumo');
			$form['publicacao'] 				= GetPost('publicacao');
			$form['duracao']					= GetPost('duracao');
			$form['status']						= 1;
			$form['registro']					= date('Y-m-d H:i:s');
			$form['npacce']						= $user['npacce'];
			$form['semestre']					= $semestre[date('m')];

			if (empty($form['titulo'])) {
				echo '<script>alert("Campo titulo está vazio");</script>';
			}else if (empty($form['tema'])) {
				echo '<script>alert("Campo tema está vazio");</script>';
			}else if (empty($form['sinopse'])) {
				echo '<script>alert("Campo sinopse está vazio");</script>';
			}else if (empty($form['introducao'])) {
				echo '<script>alert("Campo introducao está vazio");</script>';
			}else if (empty($form['justificativa'])) {
				echo '<script>alert("Campo justificativa está vazio");</script>';
			}else if (empty($form['publico'])) {
				echo '<script>alert("Campo publico está vazio");</script>';
			}else if (empty($form['local'])) {
				echo '<script>alert("Campo local está vazio");</script>';
			}else if (empty($form['objetivosGerais'])) {
				echo '<script>alert("Campo objetivos Gerais está vazio");</script>';
			}else if (empty($form['objetivosEspecificos'])) {
				echo '<script>alert("Campo objetivos Especificos está vazio");</script>';
			}else if (empty($form['produtos'])) {
				echo '<script>alert("Campo produtos está vazio");</script>';
			}else if (empty($form['indicadores'])) {
				echo '<script>alert("Campo indicadores está vazio");</script>';
			}else if (empty($form['meiosVerificacao'])) {
				echo '<script>alert("Campo meios de Verificacao está vazio");</script>';
			}else if (empty($form['atividades'])) {
				echo '<script>alert("Campo atividades está vazio");</script>';
			}else if (empty($form['fortalezas'])) {
				echo '<script>alert("Campo fortalezas está vazio");</script>';
			}else if (empty($form['fraquezas'])) {
				echo '<script>alert("Campo fraquezas está vazio");</script>';
			}else if (empty($form['estrategias'])) {
				echo '<script>alert("Campo estrategias está vazio");</script>';
			}else if (empty($form['insumo'])) {
				echo '<script>alert("Campo insumo está vazio");</script>';
			}else if (empty($form['publicacao'])) {
				echo '<script>alert("Campo publicacao está vazio");</script>';
			}else if (empty($form['duracao'])) {
				echo '<script>alert("Campo duracao está vazio");</script>';
			}else{
				$projeto = DBread('projetos', "WHERE npacce = '".$user['npacce']."'", "id, status, titulo");
				if ($projeto == true) {
					$up['status'] = 0;
					if (DBUpDate('projetos', $up, "npacce = '".$user['npacce']."'")) {
						if (DBcreate('projetos', $form)) {
							echo '<script>alert("Projeto enviado com sucesso.");
        					window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
						}	
					}
				}else{
					if (DBcreate('projetos', $form)) {
						echo '<script>alert("Projeto enviado com sucesso.");
        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
					}
				}
			} 
		  }

	?>
	<div id="editar-ativ" class="form">
		<form action="" method="post" enctype="multipart/form-data">
			<label class="label">Título </label><span style="color: red;">  *</span>
			<br>Uma palavra ou frase que expresse sua proposta.	<br>
			<input type="text" name="titulo" value="<?php echo printPost(GetPost('titulo'), 'campo'); ?>" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" placeholder="Digite o título desse projeto"></input>
			<br><br>
			<label class="label">Tema </label><span style="color: red;">  *</span>
			<br>Use duas ou três palavras que definem sua célula. Ex: Química Orgânica.	<br>
			<input type="text" name="tema" value="<?php echo printPost(GetPost('tema'), 'campo'); ?>" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" placeholder="Digite o tema desse projeto"></input>
			<br><br>
			<label class="label">Sinopse </label><span style="color: red;">  *</span>
			<br>Pequeno resumo do projeto contendo: a quem se destina, os principais problemas que o mesmo pretende solucionar, as principais atividades que serão executadas e os principais objetivos. Para melhorar seu rendimento, construa a sinopse após o projeto concluído.	<br>
			<textarea name="sinopse"><?php echo GetPost('sinopse'); ?></textarea>
			<br><br>
			<label class="label">Introdução </label><span style="color: red;">  *</span>
			<br>Liste o(s) problema(s) central(is) que motiva(ram) a elaboração do projeto e a(s) oportunidade(s) e potencialidade(s) que são ou sejam fundamentais para que o projeto obtenha sucesso.<br>
			<textarea name="introducao"><?php echo GetPost('introducao'); ?></textarea>
			<br><br>
			<label class="label">Justificativa </label><span style="color: red;">  *</span>
			<br>Motivos pelos quais o projeto precisa ser desenvolvido.<br>
			<textarea name="justificativa"><?php echo GetPost('justificativa'); ?></textarea>
			<br><br>
			<label class="label">Público Alvo </label><span style="color: red;">  *</span>
			<br>As pessoas que serão beneficiadas diretamente pela execução do projeto. Se possível cite o nome dos seus colegas e o curso.<br>
			<textarea name="publico"><?php echo GetPost('publico'); ?></textarea>
			<br><br>
			<label class="label">Duração do Projeto </label><span style="color: red;">  *</span>
			<br>Tempo de duração do projeto.<br><br>
			<input type="radio" name="duracao" value="Um semestre acadêmico"></input> Um semestre acadêmico<br><br>
			<input type="radio" name="duracao" value="Um ano acadêmico"></input> Um ano acadêmico<br><br>
			<label class="label">Local  </label><span style="color: red;">  *</span>
			<br>Onde serão desenvolvidas as atividades do projeto. Ex.: Bloco 708, sala 99 - Campus do Pici Obs: As células devem ter um local base que será divulgado no Blog do PACCE.<br>
			<input type="text" name="local" value="<?php echo GetPost('local'); ?>" placeholder="Digite o local do seu projeto"></input>
			<br><br>
			<label class="label">Objetivos Gerais </label><span style="color: red;">  *</span>
			<br>Impactos a longo prazo para os quais o seu projeto irá contribuir (inspire-se nos objetivos do programa).<br>
			<textarea name="objetivosGerais"><?php echo GetPost('objetivosGerais'); ?></textarea>
			<br><br>
			<label class="label">Objetivos Específicos </label><span style="color: red;">  *</span>
			<br>Efeitos a curto prazo, seis meses ou um ano, que seu projeto terá em específico. Objetivos específicos são os problemas resolvidos. Eles devem ser claros, mensuráveis e tangíveis.<br>
			<textarea name="objetivosEspecificos"><?php echo GetPost('objetivosEspecificos'); ?></textarea>
			<br><br>
			<label class="label">Produtos  </label><span style="color: red;">  *</span>
			<br>Os produtos que retratam a estratégia operacional para o alcance dos objetivos específicos do projeto. Ex.: cartazes, portfólios, trabalhos publicados, etc.<br>
			<textarea name="produtos"><?php echo GetPost('produtos'); ?></textarea>
			<br><br>
			<label class="label">Indicadores de Resultados  </label><span style="color: red;">  *</span>
			<br>Os critérios de sucesso, é através deles que sabemos se os objetivos foram alcançados.<br>
			<textarea name="indicadores"><?php echo GetPost('indicadores'); ?></textarea>
			<br><br>
			<label class="label">Meios de Verificação   </label><span style="color: red;">  *</span>
			<br>Os documentos que evidenciam os resultados, são a comprovação dos resultados.<br>
			<textarea name="meiosVerificacao"><?php echo GetPost('meiosVerificacao'); ?></textarea>
			<br><br>
			<label class="label">Atividades   </label><span style="color: red;">  *</span>
			<br>O que e o como fazer, a partir dos princípios da Aprendizagem Cooperativa, para que os objetivos do projeto sejam alcançados.<br>
			<textarea name="atividades"><?php echo GetPost('atividades'); ?></textarea>
			<br><br>
			<label class="label">Fortalezas    </label><span style="color: red;">  *</span>
			<br>Fatores internos e externos que podem colaborar com a execução do projeto.<br>
			<textarea name="fortalezas"><?php echo GetPost('fortalezas'); ?></textarea>
			<br><br>
			<label class="label">Fraquezas     </label><span style="color: red;">  *</span>
			<br>Fraquezas e ameaças que podem ser obstáculos para a execução do projeto.<br>
			<textarea name="fraquezas"><?php echo GetPost('fraquezas'); ?></textarea>
			<br><br>
			<label class="label">Estratégias de Superação </label><span style="color: red;">  *</span>
			<br>Pense em como você poderá enfrentar os obstáculos.<br>
			<textarea name="estrategias"><?php echo GetPost('estrategias'); ?></textarea>
			<br><br>
			<label class="label">Insumos </label><span style="color: red;">  *</span>
			<br>Os recursos materiais que você necessitará para executar o projeto.<br>
			<textarea name="insumo"><?php echo GetPost('insumo'); ?></textarea>
			<br><br>
			<label class="label">Publicação  </label><span style="color: red;">  *</span>
			<br>Onde e como você comunicará os resultados.<br>
			<textarea name="publicacao"><?php echo GetPost('publicacao'); ?></textarea>
			<br><br>
			<center>
				<input type="submit" name="enviar" value="Enviar"></input>
			</center>
		</form>
	</div>
	<?php		
		}//FIM DE CADASTRAR PROJETO
		else if (isset($url[3]) && substr($url[3], -7) == 'projeto') {
			$projeto = DBread('projetos', "WHERE id = '".str_replace("-projeto", "", $url[3])."' AND npacce = '".$user['npacce']."'");
			$projeto = $projeto[0];
			if ($projeto == false) {
				echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';	
			}else{
				if (isset($_POST['salvar'])) {
					$form['titulo'] 				= GetPost('titulo');
					$form['sinopse'] 				= GetPost('sinopse');
					$form['introducao']				= GetPost('introducao');
					$form['justificativa'] 			= GetPost('justificativa');
					$form['publico']				= GetPost('publico');
					$form['local']					= GetPost('local');
					$form['objetivosGerais'] 		= GetPost('objetivosGerais');
					$form['objetivosEspecificos']	= GetPost('objetivosEspecificos');
					$form['produtos'] 				= GetPost('produtos');
					$form['indicadores'] 			= GetPost('indicadores');
					$form['meiosVerificacao'] 		= GetPost('meiosVerificacao');
					$form['atividades'] 			= GetPost('atividades');
					$form['fortalezas'] 			= GetPost('fortalezas');
					$form['fraquezas'] 				= GetPost('fraquezas');
					$form['estrategias']			= GetPost('estrategias');
					$form['insumo']					= GetPost('insumo');
					$form['publicacao'] 			= GetPost('publicacao');
					$form['duracao']				= GetPost('duracao');
					$form['registro']				= date('Y-m-d H:i:s');
					$form['npacce']					= $user['npacce'];
					$form['cor']					= '#ccc';
					if (DBUpDate('projetos', $form," id = '".str_replace("-projeto", "", $url[3])."'")) {
						echo '<script>alert("Alterações salvas com sucesso!");
        				window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
					}
				}
	?>
		<BR>
		<div class="title"><h2>Exibição do Projeto: <?php echo  $projeto['titulo'];?></h2></div>
		<div class="tab">
			<center>
				<div class="tab">
			<?php 
				if ($projeto['npacceAv'] != '') {
					$nome = DBread('bolsistas', "WHERE npacce = '".$projeto['npacceAv']."'", "nome");
			?>
			<div>
				<center>
					<span><strong>Avaliado por:</strong> <?php echo $projeto['npacceAv'].' - '.$nome[0]['nome']; ?></span>
					<br><br>
				</center>
			</div>
			<?php 
			$foto = DBread('bolsistas', "WHERE npacce = '".$projeto['npacceAv']."' ", 'foto, nomeUsual, nome');
			?>
			<div class="foto-single" style=" float: none;">
				<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto']; ?>"><br></span>
				<div class="nome"><?php echo GetName($foto[0]['nome'], $foto[0]['nomeUsual']); ?></div>
			</div>
			<div id="clear"></div>
			<br><br>
			<?php
				}
			?>
			</center>
			<form method="post">
				<table width="100%">
					
					<tr>
						<th>Título</th>
						<th>Avaliação do Título</th>
					</tr>
					<tr>
						<td class="tam"><textarea name="titulo"><?php echo $projeto['titulo']; ?></textarea></td>
						<td class="espaco">
							<div name="tituloAv"><?php echo $projeto['tituloAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Sinopse </th>
						<th>Avaliação da Sinopse </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="sinopse"><?php echo $projeto['sinopse']; ?></textarea></td>
						<td class="espaco">
							<div name="sinopseAv"><?php echo $projeto['sinopseAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Introdução  </th>
						<th>Avaliação - Introdução </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="introducao"><?php echo $projeto['introducao']; ?></textarea></td>
						<td class="espaco">
							<div name="introducaoAv"><?php echo $projeto['introducaoAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Justificativa   </th>
						<th>Avaliação - Justificativa  </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="justificativa"><?php echo $projeto['justificativa']; ?></textarea></td>
						<td class="espaco">
							<div name="justificativaAv"><?php echo $projeto['justificativaAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Público Alvo   </th>
						<th>Avaliação - Público Alvo  </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="publico"><?php echo $projeto['publico']; ?></textarea></td>
						<td class="espaco">
							<div name="publicoAv"><?php echo $projeto['publicoAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Duração do Projeto   </th>
						<th>Avaliação - Duração do Projeto  </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="duracao"><?php echo $projeto['duracao']; ?></textarea></td>
						<td class="espaco">
							<div name="duracaoAv"><?php echo $projeto['duracaoAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Local    </th>
						<th>Avaliação - Local   </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="local"><?php echo $projeto['local']; ?></textarea></td>
						<td class="espaco">
							<div name="localAv"><?php echo $projeto['localAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Objetivos Gerais    </th>
						<th>Avaliação - Objetivos Gerais   </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="objetivosGerais"><?php echo $projeto['objetivosGerais']; ?></textarea></td>
						<td class="espaco">
							<div name="objetivosGeraisAv"><?php echo $projeto['objetivosGeraisAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Objetivos Específicos    </th>
						<th>Avaliação - Objetivos Específicos   </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="objetivosEspecificos"><?php echo $projeto['objetivosEspecificos']; ?></textarea></td>
						<td class="espaco">
							<div name="objetivosEspecificosAv"><?php echo $projeto['objetivosEspecificosAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Produtos     </th>
						<th>Avaliação - Produtos    </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="produtos"><?php echo $projeto['produtos']; ?></textarea></td>
						<td class="espaco">
							<div name="produtosAv"><?php echo $projeto['produtosAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Indicadores de Resultados     </th>
						<th>Avaliação - Indicadores de Resultados    </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="indicadores"><?php echo $projeto['indicadores']; ?></textarea></td>
						<td class="espaco">
							<div name="indicadoresAv"><?php echo $projeto['indicadoresAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Meios de Verificação     </th>
						<th>Avaliação - Meios de Verificação    </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="meiosVerificacao"><?php echo $projeto['meiosVerificacao']; ?></textarea></td>
						<td class="espaco">
							<div name="meiosVerificacaoAv"><?php echo $projeto['meiosVerificacaoAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Atividades      </th>
						<th>Avaliação - Atividades     </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="atividades"><?php echo $projeto['atividades']; ?></textarea></td>
						<td class="espaco">
							<div name="atividadesAv"><?php echo $projeto['atividadesAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Fortalezas       </th>
						<th>Avaliação - Fortalezas      </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="fortalezas"><?php echo $projeto['fortalezas']; ?></textarea></td>
						<td class="espaco">
							<div name="fortalezasAv"><?php echo $projeto['fortalezasAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Fraquezas        </th>
						<th>Avaliação - Fraquezas       </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="fraquezas"><?php echo $projeto['fraquezas']; ?></textarea></td>
						<td class="espaco">
							<div name="fraquezasAv"><?php echo $projeto['fraquezasAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Estratégias de Superação        </th>
						<th>Avaliação - Estratégias de Superação       </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="estrategias"><?php echo $projeto['estrategias']; ?></textarea></td>
						<td class="espaco">
							<div name="estrategiasAv"><?php echo $projeto['estrategiasAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Insumos        </th>
						<th>Avaliação - Insumos       </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="insumo"><?php echo $projeto['insumo']; ?></textarea></td>
						<td class="espaco">
							<div name="insumoAv"><?php echo $projeto['insumoAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<th>Publicação         </th>
						<th>Avaliação - Publicação        </th>
					</tr>
					<tr>
						<td class="tam"><textarea name="publicacao"><?php echo $projeto['publicacao']; ?></textarea></td>
						<td class="espaco">
							<div name="publicacaoAv"><?php echo $projeto['publicacaoAv']; ?></div>
						</td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					<tr>
						<td colspan="2"><center> <input type="submit" name="salvar" value="Salvar Alterações"></input> </center></td>
					</tr>
					</table>
					</form>
					</div>

	<?php
			}//FIM VERICA PROJETO
		}//FIM DE EXIBIR PROJETO
		else{
		$projeto = DBread('projetos', "WHERE npacce = '".$user['npacce']."' AND status = true ORDER BY registro DESC", "id, status, titulo");
		?>
	
		<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/cadastrar-projeto'; ?>" class="botao">Cadastrar Projeto</a>			

			<br><br>
			<div class="title"><h2>Meus Projetos</h2></div>
			<?php 
				// $projeto = DBread('projetos', "WHERE npacce = '".$user['npacce']."' ORDER BY registro DESC", "id, status, titulo");
				if ($projeto == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
				}else{
			?>
			<div class="tabela">
				<table>
					<tr>
						<th>Título</th>
						<th>Status</th>
					</tr>
					<?php 
						for ($i=0; $i < count($projeto); $i++) { 
					?>
					<tr>
						<td><a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$projeto[$i]['id'].'-projeto'; ?>"><?php echo texto($projeto[$i]['titulo'], 45); ?></a></td>
						<td><?php if($projeto[$i]['status'] == 1){ echo 'Ativo';}else{echo 'Inativo';} ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
<?php			
			}
		}	
	}else{
		?>

		<div class="title"><h2>Opções</h2></div>

		<?php
		$projeto = DBread('projetos', "WHERE npacce = '".$user['npacce']."' AND status = true ORDER BY registro DESC", "id, status, titulo");
		
		if ($projeto == false) {
			
		}else{
?>
			<a href="<?php echo $way.'/'.$url[1].'/cadastro-de-celula'; ?>" class="botao">Cadastro de Célula</a>
			<a href="<?php echo $way.'/'.$url[1].'/cadastro-de-membros'; ?>" class="botao">Cadastro de Membros</a>
			<a href="<?php echo $way.'/'.$url[1].'/encontro-de-celula'; ?>" class="botao">Encontro de Célula</a>
		<?php } ?>
		<a href="<?php echo $way.'/'.$url[1].'/projeto'; ?>" class="botao">Projeto <?php echo date('Y'); ?></a>
<?php 
	}
?>