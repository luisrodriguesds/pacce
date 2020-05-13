
<?php 
			$sem = $semana + 1;
			if (isset($_POST['enviar'])) {
				$week = array('Sun' => 'Domingo', 'Mon' => 'Segunda','Tue' => 'Terca','Wed' => 'Quarta','Thu' => 'Quinta','Fri' => 'Sexta','Sat' => 'Sábado');
				//$form['codigo'] 		= GetPost('codigo');
				$form['titulo'] 		= GetPost('titulo');
				$form['inicio'] 		= GetPost('inicio');
				$form['data'] 			= GetPost('data').' '.$form['inicio'];
				$form['data'] 			= date('Y-m-d H:i:s', strtotime($form['data']));
				$form['diaSemana'] 		= date('D', strtotime($form['data']));
				$form['diaSemana'] 		= $week[$form['diaSemana']];
				//$form['semana']			= $sem;
				$form['fim'] 			= GetPost('fim');
				$form['local']			= GetPost('local');
				$form['npacce1'] 		= $extra['npacce1'];
				$form['bol1'] 			= $extra['bol1'];
				$form['nomeComp1']		= $extra['nomeComp1'];
				$form['npacce2'] 		= GetPost('npacce2');
				$form['vagaInicial'] 	= GetPost('vagas');
				$form['vagaAtual'] 		= $extra['vagaAtual'];
				$form['status'] 		= GetPost('status');
				$form['registro']		= date('Y-m-d H:i:s');
				$form['regiao']			= 'Fortaleza';
				$form['ano']			= 2016;
				$form['cardName']		= 'Extra';	
				$form['disc'] 			= GetPost('disc');
				$form['cor'] 			= GetPost('cor');
				
				if (isset($form['npacce2']) && $form['npacce2'] != '') {
					$coExtra = DBread('bolsistas', "WHERE npacce = '".$form['npacce2']."'", "id, nome, tipo, tipoSlug, nomeUsual, npacce");
					if ($coExtra == true) {
						$form['bol2'] = GetName($coExtra[0]['nome'], $coExtra[0]['nomeUsual']);
						$form['nomeComp2'] = $coExtra[0]['nome'];
						$form['npacce2'] = $coExtra[0]['npacce'];
					}
					
				}
				if (empty($form['titulo'])) {
					echo '<script>alert("Campo Título vazio");</script>';
				}else if (empty($form['data'])) {
					echo '<script>alert("Campo data vazio");</script>';
				}else if (empty($form['inicio'])) {
					echo '<script>alert("Campo inicio vazio");</script>';
				}else if (empty($form['fim'])) {
					echo '<script>alert("Campo fim vazio");</script>';
				}else if (empty($form['local'])) {
					echo '<script>alert("Campo local vazio");</script>';
				}else if (empty($form['vagaInicial'])) {
					echo '<script>alert("Campo vagas vazio");</script>';
				}else if (empty($form['cor']) || $form['cor'] == '#000000') {
					echo '<script>alert("Campo cor vazio");</script>';
				}else if (empty($form['disc'])) {
					echo '<script>alert("Campo discrição vazio");</script>';
				}else{
					if ($form['vagaInicial'] < $extra['vagaInicial']) {
						$res = $extra['vagaInicial'] - $form['vagaInicial'];
						$form['vagaAtual'] = $form['vagaAtual'] - $res;
					}else if($form['vagaInicial'] > $extra['vagaInicial']){
						$res = $form['vagaInicial'] - $extra['vagaInicial'];
						$form['vagaAtual'] = $form['vagaAtual'] + $res;
					}
					if (DBUpDate('extra_cad', $form, "codigo = '".$extra['codigo']."'") ){
						echo '
		                 <script>
		                  alert("Formulário enviado com sucesso!!.");
		                    window.location="'.$way.'/'.$url[1].'";
		                  </script>';

					}
				}	
			}
?>
<div class="title"><h2>Editar Informações da Interação <?php echo $extra['codigo']; ?></h2></div>
<div id="editar-ativ" class="form">
	 <form action="" method="post" enctype="multipart/form-data">
	 	Código<br><strong>
		<?php echo $extra['codigo']; ?></strong><br><br>
		Título<br>
		<input type="text" name="titulo" value="<?php echo $extra['titulo']; ?>" placeholder="Digite o título dessa interação"></input><br><br>
		Data<br>
		<input type="date" name="data" value="<?php echo date('Y-m-d', strtotime($extra['data'])); ?>"></input><br><br>
		Início<br>
		<input type="time" name="inicio" value="<?php echo $extra['inicio']; ?>"></input><br><br>
		Fim<br>
		<input type="time" name="fim" value="<?php echo $extra['fim']; ?>"></input><br><br>
		Local:<br>
		<input type="text" name="local" onkeypress="masculina(this)" onkeyup="masculina(this)" value="<?php echo $extra['local']; ?>" placeholder="Digite o local dessa interação"></input><br><br>
		Semana:<br>
		<strong><?php echo '0'.$extra['semana']; ?></strong><br><br>
		Número Pacce do Co-facilitador<br>
		*Campo não obrigatório<br>
		<input type="text" name="npacce2" value="<?php echo $extra['npacce2']; ?>" placeholder="Digite o número PACCE do Co-facilitador"></input>
		<br><br>
		Status:<br>
		<select name="status">
			<option value="1">Ativo</option>
			<option value="0">Inativo</option>
		</select>
		<br><br>
		Número de vagas<br>
		<input type="number" name="vagas" min="1" value="<?php echo $extra['vagaInicial']; ?>" max="50" placeholder="Digite o número de vagas dessa interação"></input>
		Vaga Atual:<br>
		<strong><?php echo $extra['vagaAtual']; ?></strong>
		<br><br>Cor do Card:<br>
		<input type="color" name="cor" value="<?php echo $extra['cor']; ?>"></input><br><br>
		Descrição:<br>
		<textarea name="disc" placeholder="Digite aqui uma breve discrição do que se trata essa interação a ainda os insumos que serão utilizados"><?php echo str_replace('\r\n', " ", $extra['disc']); ?></textarea>
		<center>
			<input type="submit" name="enviar" value="Enviar"></input>
		</center>
	 </form>
</div>