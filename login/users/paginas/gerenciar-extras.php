
<?php 

	if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno' || $user['npacce'] == 'B160676' || $user['npacce'] == 'B150323') {
		$extraCad = DBread('extra_cad', "ORDER BY data ASC");
	}else{
		$extraCad = DBread('extra_cad', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."'  ORDER BY data ASC");
	}
	if (isset($_GET['action']) && $_GET['action'] != '' && isset($_GET['cod']) && $_GET['cod'] != '') {
		$cod = DBescape(trim(strip_tags($_GET['cod'])));
		$very = DBread('extra_cad', "WHERE codigo = '$cod'");
		if ($very == false) {
			echo ' <script>
			   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
			   </script>';
		}else{

		switch ($_GET['action']) {
			case 1:
				$up['status'] = 1;
				if (DBUpDate('extra_cad', $up, "codigo = '$cod'")) {
					echo ' <script>
				   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
				   </script>';
				}	
			break;
			case 2:
				$up['status'] = 0;
				if (DBUpDate('extra_cad', $up, "codigo = '$cod'")) {
					echo ' <script>
				   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
				   </script>';
				}
			break;
			case 3:
				if (DBDelete('extra_cad', "codigo = '$cod'")) {
					if (DBDelete('extra_insc', "codigo = '$cod'")) {
						echo ' <script>
		                  alert("Ação realizada com sucesso!");
		                    window.location="'.$way.'/'.$url[1].'";
		                  </script>';
					}
				}
			break;
			}	
		}
	}
?>
<div class="title"><h2>Gerenciar Atividades Extras</h2></div>
<p>Você irá visualizar as atividades extras que está ofertando e por meio delas, enviará 
os relatórios semanais dos bolsistas inscritos nas atividades extras que você está ofertando.</p>
<br><br>

<?php 
if (isset($url[2]) && $url[2] == 'cadastrar-extra') {

	?>
	<div class="title"><h2>Cadastrar Interação</h2></div>
	<div id="editar-ativ" class="form">
		<form action="" method="post" enctype="multipart/form-data">
			<?php 
			$sem = $semana + 1;
			if (isset($_POST['enviar'])) {
				
				$form['codigo'] 		= GetPost('codigo');
				$form['titulo'] 		= GetPost('titulo');
				$form['inicio'] 		= GetPost('horaIni').':'.GetPost('minIni').':'.GetPost('segIni');
				$form['fim'] 			= GetPost('horaFim').':'.GetPost('minFim').':'.GetPost('segFim');
				$form['data'] 			= GetPost('data').' '.$form['inicio'];
				$form['data'] 			= date('Y-m-d H:i:s', strtotime($form['data']));
				$form['diaSemana'] 		= date('D', strtotime($form['data']));
				$form['diaSemana'] 		= $week[$form['diaSemana']];
				$form['semana']			= $sem;
				$form['local']			= GetPost('local');
				$form['npacce1'] 		= $user['npacce'];
				$form['bol1'] 			= GetName($user['nome'], $user['nomeUsual']);
				$form['nomeComp1']		= $user['nome'];
				$form['npacce2'] 		= GetPost('npacce2');
				$form['vagaInicial'] 	= GetPost('vagas');
				$form['vagaAtual'] 		= GetPost('vagas');
				$form['status'] 		= GetPost('status');
				$form['registro']		= date('Y-m-d H:i:s');
				$form['regiao']			= 'Fortaleza';
				$form['ano']			= 2016;
				$form['cardName']		= 'Extra';	
				$form['disc'] 			= GetPost('disc');
				$form['cor'] 			= GetPost('cor');
				
				if ($user['campusSlug'] == 'pici' || $user['campusSlug'] == 'benfica' || $user['campusSlug'] == 'porangabucu' || $user['campusSlug'] == 'labomar' || $user['campusSlug'] == 'outro' ) {
					$form['regiao'] = 'Fortaleza';
					$form['regiaoSlug'] = 'fortaleza';
				}else{
					$form['regiao'] = $user['campus'];
					$form['regiaoSlug'] = $user['campusSlug'];
				}

				if (isset($form['npacce2']) && $form['npacce2'] != '') {
					$coExtra = DBread('bolsistas', "WHERE npacce = '".$form['npacce2']."' ", "id, nome, tipo, tipoSlug, nomeUsual, npacce");
					if ($coExtra == true) {
						$form['bol2'] = GetName($coExtra[0]['nome'], $coExtra[0]['nomeUsual']);
						$form['nomeComp2'] = $coExtra[0]['nome'];
						$form['npacce2'] = $coExtra[0]['npacce'];
					}
					
				}
				if (empty($form['codigo'])) {
					echo '<script>alert("Campo Código vazio");</script>';
				}else if (empty($form['titulo'])) {
					echo '<script>alert("Campo Título vazio");</script>';
				}else if (empty($form['data'])) {
					echo '<script>alert("Campo data vazio");</script>';
				}else if (empty($form['inicio'])) {
					echo '<script>alert("Campo inicio vazio");</script>';
				}else if (empty($form['fim'])) {
					echo '<script>alert("Campo fim vazio");</script>';
				}else if (empty($form['local'])) {
					echo '<script>alert("Campo local vazio");</script>';
				}else if (empty($form['vagaAtual'])) {
					echo '<script>alert("Campo vagas vazio");</script>';
				}else if (empty($form['cor']) || $form['cor'] == '#000000') {
					echo '<script>alert("Campo cor vazio");</script>';
				}else{
					if (DBcreate('extra_cad', $form) ){
						alertaLoad("Formulário enviado com sucesso!!", $way.'/'.$url[1]);
					}
				}	
			}
			
			if($semana <10){ $codigo = 'EXT'.date('y').'0'.$sem;}else{ $codigo = 'EXT'.date('y').$sem;}
			?>
			<span style="color: red;"> * </span><label>Campo Obrigatório</label><br><br>
			<label>Código:</label> <span style="color: red;"> *</span><br>
			<span style="color:red;">Não esqueça de informar os dois últimos digitos do código da sua atividade extra!</span><br>
			<strong><?php echo $codigo; ?></strong>
			<select name="codigo">
				
				<?php 
					for ($i=0; $i <100 ; $i++) {
						if($i < 10){
							echo '<option value="'.$codigo.'0'.$i.'">0'.$i.'</option>';

						}else{
							echo '<option value="'.$codigo.''.$i.'">'.$i.'</option>';
						} 
					}
				?>
			</select>
			<br><br>
			<label>Título:</label><span style="color: red;"> *</span><br>
			<input type="text" name="titulo" value="<?php echo GetPost('titulo'); ?>" placeholder="Digite o título dessa atividade extra"></input><br><br>
			<label>Data:</label><span style="color: red;"> *</span><br>
			<input type="date" name="data" value="<?php echo GetPost('data'); ?>"></input><br><br>
			<label>Início:</label><span style="color: red;"> *</span><br>
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
			<label>Fim:</label><span style="color: red;"> *</span><br>
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
			<label>Local:</label><span style="color: red;"> *</span><br>
			<input type="text" name="local" value="<?php echo GetPost('local'); ?>" placeholder="Digite o local dessa atividade extra"></input><br><br>
			<label>Semana:</label><br>
			<strong><?php if($sem < 10){ echo '0'.$sem; }else{ echo $sem;} ?></strong><br><br>
			<label>Número Pacce do Co-facilitador: </label><br><br>
			<input type="text" name="npacce2" value="<?php echo GetPost('npacce2'); ?>" placeholder="Digite o número PACCE do Facilitador"></input>
			<br><br>
			<label>Status:</label><span style="color: red;"> *</span><br>
			<select name="status">
				<option value="1">Ativo</option>
				<option value="0">Inativo</option>
			</select>
			<br><br>
			<label>Número de vagas:</label><span style="color: red;"> *</span><br>
			<input type="number" name="vagas" min="1" value="<?php echo GetPost('vagas'); ?>" max="50" placeholder="Digite o número de vagas dessa atividade extra"></input>
			<br><br><label>Cor do Card:</label><span style="color: red;"> *</span><br>
			<input type="color" name="cor"></input><br><br>

			<label>Descrição:</label><br>
			<textarea name="disc" placeholder="Digite aqui uma breve descrição do que se trata essa interação e ainda os insumos que serão utilizados"><?php echo printPost(GetPost('disc'), 'campo'); ?></textarea>
			<center>
				<input type="submit" name="enviar" value="Enviar"></input>
			</center>
		</form>
	</div>
	<?php
	}

else if (isset($url[2]) && $url[2] != '' && $url[2] != 'cadastrar-extra') {
	include 'paginas/extra-single.php';	
}else{
	?>
	<?php 
//if (date('D') == 'Thu' || date('D') == 'Fri') {
//if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'interacao') {
	echo '<div class="title"><h2>Opções</h2></div>
	<a href="'.$way.'/'.$url[1].'/cadastrar-extra	" class="botao">Cadastrar Atividade Extra</a>
	<br><br>';
//}
//}
?>
	<div class="title"><h2>Minhas Atividade Extras</h2></div>
	<div class="caixa">
	<br>
	<?php 
	if (!isset($_GET['semana'])) {

		echo '<div class="title"><h2>Semanas</h2></div>';
		for ($i=2; $i <= $semana + 1; $i++) { 
		if ($i < 10) {
			$week = '0'.$i;
		}else{
			$week = $i;
		}
	?>
	<a class="botao" href="<?php echo $way.'/'.$url[1].'?semana='.$i; ?>"><?php echo 'Semana '.$week; ?></a>


	<?php 
		}
		echo '</div>';	
	}else{
		$cont = 0;
		for ($i=0; $i < count($extraCad); $i++) { 
			if ($extraCad[$i]['semana'] == $_GET['semana']) {
				$extra[] = $extraCad[$i];
				$cont++;
			}
		}

		if ($cont == 0) {
			echo '<div class="nada-encontrado"><h2>Você não tem atividades extras cadastradas.</h2></div>';
		}else{
	?>
	<ul>
	<?php 
		for ($i=0; $i < count($extra); $i++) { 
		
	?>
		<a href="<?php echo $way.'/'.$url[1].'/'.$extra[$i]['codigo']; ?>">
		<li style="background-color: <?php echo $extra[$i]['cor']; ?>;">
			<div>
				<div id="box-all-info">
					<div id="all-info">
						<h3><?php echo texto($extra[$i]['titulo'], 30); ?></h3><br>
						<span><?php echo texto($extra[$i]['local'], 28); ?></span><br><br>
						<span><?php echo date('d/m', strtotime($extra[$i]['data'])); ?>
						 | <?php echo date('H:i', strtotime($extra[$i]['inicio'])).'hr'; ?> - 
						 <?php echo date('H:i', strtotime($extra[$i]['fim'])).'hr'; ?> <br> <?php echo $extra[$i]['diaSemana']; ?> </span><br><br>
						<span><?php echo $extra[$i]['bol1']; if($extra[$i]['bol2'] == ''){}else{echo ' & '.$extra[$i]['bol2'];} ?></span><br>
						<span><?php echo 'Semana  '; if($extra[$i]['semana'] >= 10){ echo $extra[$i]['semana']; }else{ echo '0'.$extra[$i]['semana']; } ?></span><br>
						<span><?php echo $extra[$i]['vagaAtual'].'/'.$extra[$i]['vagaInicial']; ?> Vagas</span>
					</div>
				</div>
				<div id="tipo">
					<?php echo $extra[$i]['cardName']; ?>
				</div>
			</div>
			
		</li>
		</a>
		<?php } ?>
	</ul>
	<div id="cont"><br><?php echo '('.count($extra).')'; ?></div>
	<?php } ?>
</div>
<?php	
		}
	}
?>

