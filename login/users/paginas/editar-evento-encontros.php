<?php 
	$codigo = $url[2];
	$evento = DBread('eu_eventos', "WHERE codigo = '".$codigo."'");
	$evento = $evento[0];
	if ($evento == false) {
		
	}else{
		$npacces = DBread('eu_eventos_resp', "WHERE codigo = '".$evento['codigo']."'");

?>
<script type="text/javascript">
	$(function(){
		$('.botao').click(function(e) {
				e.preventDefault();
			});
	});
</script>
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

					for ($i=0; $i <= 99 ; $i++) {
						 
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
			<input type="text" id="eventoRe" value="<?php echo $evento['evento']; ?>" name="evento" placeholder="Digite o nome do evento">
			<br><br><br>
			<label>Local:</label><span style="color: red;">*</span><br>
			<input type="text" id="localRe" value="<?php echo $evento['local']; ?>" name="local" placeholder="Digite o local do evento">
			<br><br><br>
			<label>Data:</label><span style="color: red;">*</span><br>
			<input type="date" id="dataRe" value="<?php echo date('Y-m-d', strtotime($evento['data'])); ?>" name="data">
			<br><br><br>
			<label>Inicio:</label><span style="color: red;">*</span><br>
		 	<select name="horaIni"  id="horaIniRe">
		 	<?php
		 	if($evento == true){
	 			$hora = explode(":", $evento['inicio']);
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
		 	if($evento == true){
	 			$hora = explode(":", $evento['fim']);
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
			<input type="text" id="responsavelRe" value="<?php echo $evento['responsavel']; ?>" name="responsavel" placeholder="Digite o responsável pelo evento">
			
			<br><br><br>
			<label>Destinado:</label><span style="color: red;">*</span><br>
			<input type="text" id="destinadoRe" value="<?php echo $evento['destinado']; ?>" name="destinado" placeholder="Digite a quem é destinado o evento">
			
			<br><br><br>
			<label>Responsáveis pela presença:</label><span style="color: red;">*</span><br>
			<p>Digite o(s) número(s) PACCE do(s) Responsáveis pela coleta de presença</p><br>
			<div id="origem">

				<input type="text" name="npacceResp[]" value="<?php echo $npacces[0]['npacceResp']; ?>" class="rpres" id="rpres" onkeyup="maiuscula(this)" maxlength="7"  placeholder="Digite o npacce do responsável pela presença do evento">
				<span id="resnpacce" class="resnpacce"></span><br><br>
			</div>
			<div id="destino">
				<?php 
					if (count($npacces) > 1) {
						for ($i=1; $i < count($npacces); $i++) { 
							
						?>
						<input type="text" name="npacceResp[]" value="<?php echo $npacces[$i]['npacceResp']; ?>" class="rpres" id="rpres" onkeyup="maiuscula(this)" maxlength="7"  placeholder="Digite o npacce do responsável pela presença do evento">
						<?php 
						}
					}
				?>
			</div>
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
<?php } ?> 