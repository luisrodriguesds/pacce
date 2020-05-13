<style type="text/css">
	.label{ color: #4A85A0; }
</style>
<div class="title"><h2>Atividades de Comissão</h2></div>
<p>Use esta página para descrever as atividades que você desenvolveu durante a semana como participante de uma comissão. Use um formulário por semana.</p>
<br>

<?php
	if (isset($url[2]) && $url[2] != '') {

?>
	<br>
	<div class="title"><h2>Relatório de atividades de Comissão - <?php echo $user['tipo']; ?></h2></div>
		<div id="editar-ativ" class="form">
			<?php 

			if (isset($_GET['trabalhou']) && $_GET['trabalhou'] == 1) {
				if (isset($_POST['enviar'])) {
					$form['npacce']		= $user['npacce'];
					$form['comissao']	= $user['tipo'];
					$form['comissaoSlug'] = $user['tipoSlug'];
					$form['trabalhou']	= 'Sim, trabalhei pela comissão';
					$form['local'] 		= '';
					$form['ch'] 		= GetPost('hora').':'.GetPost('min').':'.GetPost('seg');
					$form['atividades'] = GetPost('atividades');
					$form['avaliacao'] 	= GetPost('avaliacao');
					$form['status']		= 1;
					$form['registro']	= date('Y-m-d H:i:s');
					$form['semana']		= substr($url[2], -2);

					//PARA COLOCAR O CHECKBOX EM UM CAMPO SÓ
					if (isset($_REQUEST['local'])) {
						for ($i=0; $i < count($_REQUEST['local']); $i++) { 
						 $v = '';
						if ($i == 0) {
							$v = '';
						}else{
							$v = ', ';
						}
						if ($_REQUEST['local'][$i]	== 'Outro') {
							$_REQUEST['local'][$i] = GetPost('outro');
						}
						$form['local'] = $form['local'].$v.$_REQUEST['local'][$i];
					}
					}
					if ($form['local'] == '') {
						echo '<script>alert("Campo local vazio!");</script>';
					}else if (empty($form['ch'])) {
						echo '<script>alert("Campo ch vazio!");</script>';
					}else if (empty($form['atividades'])) {
						echo '<script>alert("Campo atividades vazio!");</script>';
					}else if (empty($form['avaliacao'])) {
						echo '<script>alert("Campo avaliacao vazio!");</script>';
					}else{
						$semanaSend = str_replace("semana-", "", $url[2]);
						$ati = DBread('ati_com', "WHERE npacce= '".$user['npacce']."' AND semana = '".$semanaSend."'");
						if($ati == false){
							if (DBcreate('ati_com', $form)) {
								echo '<script>alert("Relatório enviado com sucesso.");
		        				window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}else{
							if (DBUpDate('ati_com', $form, "npacce = '".$user['npacce']."' AND semana = '".$semanaSend."'")) {
									echo '<script>alert("Relatório enviado com sucesso.");
		        				window.location="'.$way.'/'.$url[1].'";</script>';
							}	
						}
					}
					
				}
			?>
				<form action="" method="post" enctype="multipart/form-data">
					<label class="label">Descrição das Atividades </label><br>
					Relate aqui tudo que você fez durante essa semana na bolsa<br><br> 

					<label class="label">Local  </label><span style="color: red">  *</span><br>
					Indique onde você trabalhou essa semana<br><br> 
					<input type="checkbox" name="local[]" value="No PACCE"></input> No PACCE<br><br>
					<input type="checkbox" name="local[]" value=" Em Casa"></input>  Em Casa<br><br>
					<input type="checkbox" name="local[]" value="On Line"></input>  On Line<br><br>
					<input type="checkbox" name="local[]" value="No meu Campus"></input>  No meu Campus<br><br>
					<input type="checkbox" name="local[]" id="outro" value="Outro"></input> Outro: <input type="text" name="outro" style="width: 30%; height: 20px; margin: 0;"></input><br><br>		
					<br>
					<label class="label">CH  </label><span style="color: red">  *</span><br>
					Indique quantas horas você trabalhou essa semana<br><span style="color:red;">Não coloque as horas em que as presenças já foram registradas de outra forma como: Reunião Geral ou Reunião de comissão.</span><br>
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
					<label class="label">Atividades   </label><span style="color: red">  *</span><br>
					Liste as atividades que você desenvolveu essa semana. Use o formato 1- Reunião semanal; (tecle enter) 2- Reunião com a Coordenação; (tecle enter) e assim até terminar<br>
					<textarea name="atividades"></textarea><br><br>
					<label class="label">Avaliação    </label><span style="color: red">  *</span><br>
					Faça uma autoavaliação de como foi sua semana. Se ela foi produtiva, o que foi bom e o que não foi muito bem e o que você pretende fazer para melhorar seu desempenho.<br>
					<textarea name="avaliacao"></textarea><br><br>
					<center>
						<input type="submit" name="enviar" value="Enviar"></input>
					</center>				
				</form>
			<?php 
			//=====================================================================
			}else if (isset($_GET['trabalhou']) && $_GET['trabalhou'] == 2){
				if (isset($_POST['enviar'])) {
					$form['npacce']		= $user['npacce'];
					$form['comissao']	= $user['tipo'];
					$form['comissaoSlug'] = $user['tipoSlug'];
					$form['trabalhou']	= 'Sim, trabalhei pela comissão e outras atividades na bolsa';
					$form['local'] 		= '';
					$form['ch'] 		= GetPost('hora').':'.GetPost('min').':'.GetPost('seg');
					$form['atividades'] = GetPost('atividades');
					$form['avaliacao'] 	= GetPost('avaliacao');
					$form['status']		= 1;
					$form['registro']	= date('Y-m-d H:i:s');
					$form['semana']		= substr($url[2], -2);

					//PARA COLOCAR O CHECKBOX EM UM CAMPO SÓ
					if (isset($_REQUEST['local'])) {
						for ($i=0; $i < count($_REQUEST['local']); $i++) { 
						 $v = '';
						if ($i == 0) {
							$v = '';
						}else{
							$v = ', ';
						}
						if ($_REQUEST['local'][$i]	== 'Outro') {
							$_REQUEST['local'][$i] = GetPost('outro');
						}
						$form['local'] = $form['local'].$v.$_REQUEST['local'][$i];
					}
					}
					if ($form['local'] == '') {
						echo '<script>alert("Campo local vazio!");</script>';
					}else if (empty($form['ch'])) {
						echo '<script>alert("Campo ch vazio!");</script>';
					}else if (empty($form['atividades'])) {
						echo '<script>alert("Campo atividades vazio!");</script>';
					}else if (empty($form['avaliacao'])) {
						echo '<script>alert("Campo avaliacao vazio!");</script>';
					}else{
						$semanaSend = str_replace("semana-", "", $url[2]);
						$ati = DBread('ati_com', "WHERE npacce= '".$user['npacce']."' AND semana = '".$semanaSend."'");
						if($ati == false){
							if (DBcreate('ati_com', $form)) {					
								echo '<script>alert("Relatório enviado com sucesso.");
		        				window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}else{
							if (DBUpDate('ati_com', $form, "npacce = '".$user['npacce']."' AND semana = '".$semanaSend."'")) {
							echo '<script>alert("Relatório enviado com sucesso.");
							window.location="'.$way.'/'.$url[1].'";</script>';
							}	
						}
						
					}
				}
			?>

			<form action="" method="post" enctype="multipart/form-data">
					<label class="label">Descrição das Atividades </label><br>
					Relate aqui tudo que você fez durante essa semana na bolsa<br><br> 

					<label class="label">Local  </label><span style="color: red">  *</span><br>
					Indique onde você trabalhou essa semana<br><br> 
					<input type="checkbox" name="local[]" value="No PACCE"></input> No PACCE<br><br>
					<input type="checkbox" name="local[]" value=" Em Casa"></input>  Em Casa<br><br>
					<input type="checkbox" name="local[]" value="On Line"></input>  On Line<br><br>
					<input type="checkbox" name="local[]" value="No meu Campus"></input>  No meu Campus<br><br>
					<input type="checkbox" name="local[]" id="outro" value="Outro"></input> Outro: <input type="text" name="outro" style="width: 30%; height: 20px; margin: 0;"></input><br><br>		
					<br>
					<label class="label">CH  </label><span style="color: red">  *</span><br>
					Indique quantas horas você trabalhou essa semana<br>
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
					<label class="label">Atividades   </label><span style="color: red">  *</span><br>
					Liste as atividades que você desenvolveu essa semana. Use o formato 1- Reunião semanal; (tecle enter) 2- Reunião com a Coordenação; (tecle enter) e assim até terminar<br>
					<textarea name="atividades"></textarea><br><br>
					<label class="label">Avaliação    </label><span style="color: red">  *</span><br>
					Faça uma autoavaliação de como foi sua semana. Se ela foi produtiva, o que foi bom e o que não foi muito bem e o que você pretende fazer para melhorar seu desempenho.<br>
					<textarea name="avaliacao"></textarea><br><br>
					<center>
						<input type="submit" name="enviar" value="Enviar"></input>
					</center>				
				</form>
			<?php
			}else if (isset($_GET['trabalhou']) && $_GET['trabalhou'] == 3) {
				if (isset($_POST['enviar'])) {
					$form['npacce']		= $user['npacce'];
					$form['comissao']	= $user['tipo'];
					$form['comissaoSlug'] = $user['tipoSlug'];
					$form['trabalhou']	= 'Não, mas fiz outros trabalhos na bolsa';
					$form['local'] 		= '';
					$form['ch'] 		= GetPost('hora').':'.GetPost('min').':'.GetPost('seg');
					$form['atividades'] = GetPost('atividades');
					$form['avaliacao'] 	= GetPost('avaliacao');
					$form['status']		= 1;
					$form['registro']	= date('Y-m-d H:i:s');
					$form['semana']		= substr($url[2], -2);

					if (empty($form['ch'])) {
						echo '<script>alert("Campo ch vazio!");</script>';
					}else if (empty($form['atividades'])) {
						echo '<script>alert("Campo atividades vazio!");</script>';
					}else if (empty($form['avaliacao'])) {
						echo '<script>alert("Campo avaliacao vazio!");</script>';
					}else{
						$semanaSend = str_replace("semana-", "", $url[2]);
						$ati = DBread('ati_com', "WHERE npacce= '".$user['npacce']."' AND semana = '".$semanaSend."'");
						if($ati == false){
							if (DBcreate('ati_com', $form)) {					
								echo '<script>alert("Relatório enviado com sucesso.");
		        				window.location="'.$way.'/'.$url[1].'";</script>';
							}
						}else{
							if (DBUpDate('ati_com', $form, "npacce = '".$user['npacce']."' AND semana = '".$semanaSend."'")) {
									echo '<script>alert("Relatório enviado com sucesso.");
		        				window.location="'.$way.'/'.$url[1].'";</script>';
							}	
						}
					}
				}
			?>
			<form action="" method="post" enctype="multipart/form-data">
					<label class="label">Descrição das Atividades </label><br>
					Relate aqui tudo que você fez durante essa semana na bolsa<br><br> 

					<label class="label">CH  </label><span style="color: red">  *</span><br>
					Indique quantas horas você trabalhou essa semana<br>
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
					<label class="label">Atividades   </label><span style="color: red">  *</span><br>
					Liste as atividades que você desenvolveu essa semana. Use o formato 1- Reunião semanal; (tecle enter) 2- Reunião com a Coordenação; (tecle enter) e assim até terminar<br>
					<textarea name="atividades"></textarea><br><br>
					<label class="label">Avaliação    </label><span style="color: red">  *</span><br>
					Faça uma autoavaliação de como foi sua semana. Se ela foi produtiva, o que foi bom e o que não foi muito bem e o que você pretende fazer para melhorar seu desempenho.<br>
					<textarea name="avaliacao"></textarea><br><br>
					<center>
						<input type="submit" name="enviar" value="Enviar"></input>
					</center>				
				</form>
			<?php
			}else if (isset($_GET['trabalhou']) && $_GET['trabalhou'] == 4){
				$form['npacce']		= $user['npacce'];
				$form['comissao']	= $user['tipo'];
				$form['comissaoSlug'] = $user['tipoSlug'];
				$form['trabalhou']	= 'Não, essa semana não trabalhei';
				$form['local'] 		= '';
				$form['ch']			= '00:00:00';
				$form['atividades'] = GetPost('atividades');
				$form['avaliacao'] 	= GetPost('avaliacao');
				$form['status']		= 1;
				$form['registro']	= date('Y-m-d H:i:s');
				$form['semana']		= substr($url[2], -2);
				$semanaSend = str_replace("semana-", "", $url[2]);
				$ati = DBread('ati_com', "WHERE npacce= '".$user['npacce']."' AND semana = '".$semanaSend."'");
				if($ati == false){
					if (DBcreate('ati_com', $form)) {					
						echo '<script>alert("Relatório enviado com sucesso.");
        				window.location="'.$way.'/'.$url[1].'";</script>';
					}
				}else{
					if (DBUpDate('ati_com', $form, "npacce = '".$user['npacce']."' AND semana = '".$semanaSend."'")) {
							echo '<script>alert("Relatório enviado com sucesso.");
        				window.location="'.$way.'/'.$url[1].'";</script>';
					}	
				}
			}else{
			?>
			<form action="" method="get" enctype="multipart/form-data">
				<label class="label">Trabalhou  </label><span style="color: red">  *</span><br>
					Informe se você desenvolveu alguma atividade de comissão nessa semana<br><br>
					<input type="radio" name="trabalhou" value="1"></input>   Sim, trabalhei pela comissão<br><br>
					<input type="radio" name="trabalhou" value="2"></input>   Sim, trabalhei pela comissão e outras atividades na bolsa<br><br>
					<input type="radio" name="trabalhou" value="3"></input>   Não, mas fiz outros trabalhos na bolsa<br><br>
					<input type="radio" name="trabalhou" value="4"></input>   Não, essa semana não trabalhei<br><br>
					<input type="submit" name="continuar" value="Continuar"></input>
			</form>
			<?php } ?>
		</div>
<?php
	}else{

		echo '<br>';

	for ($i=1; $i <= $semana; $i++) { 
	if ($i < 10) {
		$week = '0'.$i;
	}else{
		$week = $i;
	}
?>
<a href="<?php echo $way.'/'.$url[1].'/semana-'.$week; ?>" class="botao"><?php echo 'Semana '.$week; ?></a>

<?php
	}
?>
<br><br>
<div class="title"><h2>Histórico de Relatórios</h2></div>
<?php 
	$ati = DBread('ati_com', "WHERE npacce = '".$user['npacce']."' ORDER BY semana ASC");
	if ($ati == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';		
	}else{
?>
	<div class="tabela">
		<table>
			<tr>
				<th>Comissão:</th>
				<th>Situação:</th>
				<th>Semana:</th>
				<th>Horas:</th>
				<th>Registro:</th>
			</tr>
			<?php 
				for ($i=0; $i < count($ati); $i++) { 

			?>
			<tr>
				<td><?php echo $ati[$i]['comissao']; ?></td>
				<td><?php echo $ati[$i]['trabalhou']; ?></td>
				<td><?php if($ati[$i]['semana'] < 10){ echo '0'.$ati[$i]['semana'];}else{echo $ati[$i]['semana'];} ?></td>
				<td><?php echo date('H:i', strtotime($ati[$i]['ch'])); ?></td>
				<td><?php echo date('d/m/y', strtotime($ati[$i]['registro'])); ?></td>
			</tr>
			<?php } ?>
		</table>
		<br>
		<div class="count"><?php echo '('.count($ati).')'; ?></div>
	</div>
<?php
	}
?>
<?php
}
?>