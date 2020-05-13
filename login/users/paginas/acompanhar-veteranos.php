<div class="title"><h2>Acompanhar Veteranos</h2></div>
<p></p>
<br><br>

<?php

if(isset($url[2]) && $url[2] != '') {
	if (isset($url[3]) && $url[3] != '') {
		if (isset($url[4]) && $url[4] == 'avaliacao') {
			
			$av = DBread('av_vets', "WHERE npacceVet = '".$url[3]."' AND semana = '".$url[5]."' ORDER BY codigo");
			if ($av == true) {
				$obs = DBread('av_vets_av', "WHERE npacce = '".$url[3]."' AND semana = '".$url[5]."'");
				if (isset($_POST['salvar'])) {
					$form['npacce'] 	= $url[3];
					$form['npacceAv'] 	= $user['npacce'];
					$form['semana'] 	= $url[5];
					$form['obs'] 		= GetPost('obs');
					$form['status'] 	= 1;
					$form['registro'] 	= date('Y-m-d H:i:s');
					if ($obs == false) {
						if (DBcreate('av_vets_av', $form)) {
							alertaLoad("Dados salvos com sucesso!", $way.'/'.$url[1].'/'.$url[2].'/'.$url[3]);
						}
					}else{
						if (DBUpDate('av_vets_av', $form, "id = '".$obs[0]['id']."'")) {
							alertaLoad("Dados salvos com sucesso!", $way.'/'.$url[1].'/'.$url[2].'/'.$url[3]);
						}
					}
				}
				?>
				<div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>Evento</th>
							<th>Nº PACCE</th>
							<th>Organização</th>
							<th>Pontualizade</th>
							<th title="Facilitador estimula a participação">Facilitador es..</th>
							<th title="Estímulo ao uso da aprendizagem cooperativa (HS)[Interd.Positiva]">Estímulo ao us...</th>
							<th title="Protagonismo [Desenvolve sua liderança pessoal]">Protagonismo [D...</th>
							<th title="">Parecer</th>
						</tr>
					<?php
					for ($i=0; $i < count($av); $i++) { 
					?>
						<tr>
							<td><?php echo $av[$i]['codigo']; ?></td>
							<td><?php echo $av[$i]['npacce']; ?></td>
							<td <?php if($av[$i]['criterio1'] == 1 || $av[$i]['criterio1'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio1'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio1'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio1'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio1'] ?></td>
							<td <?php if($av[$i]['criterio2'] == 1 || $av[$i]['criterio2'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio2'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio2'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio2'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio2'] ?></td>
							<td <?php if($av[$i]['criterio3'] == 1 || $av[$i]['criterio3'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio3'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio3'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio3'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio3'] ?></td>
							<td <?php if($av[$i]['criterio4'] == 1 || $av[$i]['criterio4'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio4'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio4'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio4'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio4'] ?></td>
							<td <?php if($av[$i]['criterio5'] == 1 || $av[$i]['criterio5'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio5'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio5'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio5'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio5'] ?></td>
							<td title="<?php echo $av[$i]['parecer'] ?>"><?php echo $av[$i]['parecer']; ?></td>	

						</tr>
					<?php
					}	
					?>
					</table>
				</div>
				<div id="editar-ativ" class="form">
					<form method="post">
						<label class="label">Observação</label>
						<br>Faça uma avaliação geral sobre as avaliações desse veterano<br>
						<textarea name="obs"><?php if($av == true){ echo printPost($obs[0]['obs'], 'campo'); } ?></textarea>
						<center>
							<input type="submit" name="salvar" value="Salvar"></input>
						</center>
					</form>
				</div>
				<?php
			}
			?>

			<?php	
		}else if(isset($url[4]) && $url[4] == 'relatorio'){
			$relat = DBread('ati_com', "WHERE npacce = '".$url[3]."' AND semana = '".$url[5]."'");
			$av = DBread('av_vets', "WHERE npacceVet = '".$url[3]."' AND semana = '".$url[5]."'");
			if ($relat == true) {
				// $obs = DBread('av_vets_av', "WHERE npacce = '".$url[3]."' AND semana = '".$url[5]."'");
				// if (isset($_POST['salvar'])) {
				// 	$form['npacce'] 	= $url[3];
				// 	$form['npacceAv'] 	= $user['npacce'];
				// 	$form['semana'] 	= $url[5];
				// 	$form['obs'] 		= GetPost('obs');
				// 	$form['status'] 	= 1;
				// 	$form['registro'] 	= date('Y-m-d H:i:s');
				// 	if ($obs == false) {
				// 		if (DBcreate('av_vets_av', $form)) {
				// 			alertaLoad("Dados salvos com sucesso!", $way.'/'.$url[1].'/'.$url[2].'/'.$url[3]);
				// 		}
				// 	}else{
				// 		if (DBUpDate('av_vets_av', $form, "id = '".$obs[0]['id']."'")) {
				// 			alertaLoad("Dados salvos com sucesso!", $way.'/'.$url[1].'/'.$url[2].'/'.$url[3]);
				// 		}
				// 	}
				// }

				// $auxAtiv = $relat[0]['atividades'];
				// $auxAtiv = str_replace("\n", '<br>', $relat[0]['atividades']);
				$auxAtiv = str_replace("\\r\\n",'<br/>', $relat[0]['atividades']);
				$auxAval = str_replace("\\r\\n",'<br/>', $relat[0]['avaliacao']);


				?>
				<!-- <div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>Organização</th>
							<th>Pontualizade</th>
							<th title="Facilitador estimula a participação">Facilitador es..</th>
							<th title="Estímulo ao uso da aprendizagem cooperativa (HS)[Interd.Positiva]">Estímulo ao us...</th>
							<th title="Protagonismo [Desenvolve sua liderança pessoal]">Protagonismo [D...</th>
							<th title="">Parecer</th>
						</tr>
					<?php
					for ($i=0; $i < count($av); $i++) { 
					?>
						<tr>
							<td <?php if($av[$i]['criterio1'] == 1 || $av[$i]['criterio1'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio1'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio1'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio1'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio1'] ?></td>
							<td <?php if($av[$i]['criterio2'] == 1 || $av[$i]['criterio2'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio2'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio2'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio2'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio2'] ?></td>
							<td <?php if($av[$i]['criterio3'] == 1 || $av[$i]['criterio3'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio3'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio3'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio3'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio3'] ?></td>
							<td <?php if($av[$i]['criterio4'] == 1 || $av[$i]['criterio4'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio4'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio4'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio4'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio4'] ?></td>
							<td <?php if($av[$i]['criterio5'] == 1 || $av[$i]['criterio5'] == 0){  echo 'style="background-color: #E47C7C;"';}else if($av[$i]['criterio5'] == 2){echo 'style="background-color: #E4AC7C;"';}else if($av[$i]['criterio5'] == 3){ echo 'style="background-color: #E4E17C;"';}else if($av[$i]['criterio5'] == 4){echo 'style="background-color: #7CE497;"';}else{ echo 'style="background-color: #7CC2E4;"'; } ?>><?php echo $av[$i]['criterio5'] ?></td>
							<td title="<?php echo $av[$i]['parecer'] ?>"><?php echo $av[$i]['parecer']; ?></td>	

						</tr>
					<?php
					}	
					?>
					</table>
				</div>
				<div id="editar-ativ" class="form">
					<form method="post">
						<label class="label">Observação</label>
						<br>Faça uma avaliação geral sobre as avaliações desse veterano<br>
						<textarea name="obs"><?php if($av == true){ echo printPost($obs[0]['obs'], 'campo'); } ?></textarea>
						<center>
							<input type="submit" name="salvar" value="Salvar"></input>
						</center>
					</form>
				</div> -->

				<h2>Semana <?php echo $url[5] ?></h2>

				<br><br>
				<h3>Atividades</h3>
				<br>
				<p><?php echo $auxAtiv; ?></p>
				<br>
				<h3>Avaliação</h3>
				<br>
				<p><?php echo $auxAval; ?></p>
				<br>


				<?php
			}
			?>

			<?php
		}else if(isset($url[4]) && $url[4] == 'justificativa'){

			$just = DBread('just_ativ', "WHERE npacce = '".$url[3]."' AND codigo = '".$_GET['codigo']."'");
			// var_dump($just);
			if ($just == false) {
				echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
			}else{
				if (isset($_POST['salvar'])) {
					$form['situacao'] = GetPost('avaliacao');
					$form['cor'] = GetPost('cor');
					$form['parecer'] = GetPost('parecer');
					if (empty($form['situacao'])) {
						echo '<script>alert("Campo situação está vazio!");</script>';
					}else if (empty($form['cor']) || $form['cor'] == '#fff') {
						echo '<script>alert("Campo cor está vazio!");</script>';
					}else if (empty($form['parecer'])) {
						echo '<script>alert("Campo parecer está vazio!");</script>';
					}else{
						if (DBupDate('just_ativ', $form, "npacce = '".$url[3]."' AND codigo = '".$_GET['codigo']."'")) {
							echo '<script>alert("Processo salvo com sucesso!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';	
						}
					}
				}
				?>
				<div style="width: 60%; margin: 0 auto;">
					<br>
					<label class="label"><h2>Justificativa - <?php echo $_GET['codigo']; ?></h2></label>
					<p>
						<br>
						<?php echo printPost($just[0]['justificativa'], 'page'); ?>
					</p><br><br> 
					<div class="form">
						<form method="post">
							<label class="label">Avaliar Justificativa</label><br><br>
							<input type="radio" name="avaliacao" value="1" <?php if($just == true && $just[0]['situacao'] == 1){ echo 'checked="checked"';} ?> />  Justificativa aprovada. <br><br>
							<input type="radio" name="avaliacao" value="2" <?php if($just == true && $just[0]['situacao'] == 2){ echo 'checked="checked"';} ?> />  Justificativa reprovada. <br><br>
							<textarea placeholder="Digite um parecer sobre essa Justificativa" name="parecer"><?php if($just[0]['parecer'] != null || $just[0]['parecer'] != ''){ echo printPost($just[0]['parecer'], 'campo');}  ?></textarea>
							<center>
								<input type="color" name="cor" <?php if($just[0]['cor'] != null){ echo 'value="'.$just[0]['cor'].'"';}else{ echo 'value="#fff"';} ?> /><br><br>
								<input type="submit" name="salvar" value="Salvar" />
							</center>
						</form>
					</div>
				</div>

				<?php
			}
		}else if(isset($url[4]) && $url[4] == 'reposicao'){

			$rep = DBread('rep_ativ', "WHERE npacce = '".$url[3]."' AND codigo = '".$_GET['codigo']."'");
			// var_dump($just);
			if ($rep == false) {
				echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
			}else{
				if (isset($_POST['salvar'])) {
					// $form['situacao'] = GetPost('avaliacao');
					$form['cor'] = GetPost('cor');
					$form['parecer'] = GetPost('parecer');
					$form['situacao'] = GetPost('situacao');
					// if (empty($form['situacao'])) {
					// 	echo '<script>alert("Campo situação está vazio!");</script>';
					// }else 
					if (empty($form['cor']) || $form['cor'] == '#fff') {
						echo '<script>alert("Campo cor está vazio!");</script>';
					}else if (empty($form['parecer'])) {
						echo '<script>alert("Campo parecer está vazio!");</script>';
					}else{


						if($form['situacao']!=0){
							if(DBUpDate('rep_ativ',$form,"npacce = '".$url[3]."' AND codigo = '".$_GET['codigo']."'")){
								$cod = substr($_GET['codigo'], 0, 3);
								if($form['situacao']=1){
									$pres['presenca'] = 2;

									switch ($cod) {
										case 'RGM':
											if(DBUpDate('eventos_pres', $pres, "npacce = '".$url[3]."' AND codigo = '".$_GET['codigo']."'")){
												echo '<script>alert("Processo salvo com sucesso!");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
											}
											break;
										
										default:
											if(DBUpDate('av_comissao',$pres,"npacce = '".$url[3]."' AND codigo = '".$_GET['codigo']."'")){
												echo '<script>alert("Processo salvo com sucesso!");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
											}
											break;
									}
								}else{
									$pres['presenca'] = 3;

									switch ($cod) {
										case 'RGM':
											if(DBUpDate('eventos_pres', $pres, "npacce = '".$url[3]."' AND codigo = '".$_GET['codigo']."'")){
												echo '<script>alert("Processo salvo com sucesso!");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
											}
											break;
										
										default:
											if(DBUpDate('av_comissao',$pres,"npacce = '".$url[3]."' AND codigo = '".$_GET['codigo']."'")){
												echo '<script>alert("Processo salvo com sucesso!");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
											}
											break;
									}
								}
							}
								
						}else{
							echo '<script>alert("Você esqueceu de avaliar essa reposição!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}
				}
				?>
				<div style="width: 60%; margin: 0 auto;">
					<br>
					<label class="label"><h2>Reposição - <?php echo $_GET['codigo']; ?></h2></label>
					<br>
					<br>
					<label class="label"><h3>Resgate</h3></label>
					<?php
					if ($rep[0]['resgate'] == '') {
						?>
						<div class="nada-encontrado"><h2>Nada encontrado</h2></div>
						<?php
					} else {
						?>
						<p>
						<?php echo printPost($rep[0]['resgate'], 'page'); ?>
						</p>
						<?php
					}
					?>
					<br>
					<br> 
					<label class="label"><h3>Resenha</h3></label>
					<?php
					if ($rep[0]['resenha'] == '') {
						?>
						<div class="nada-encontrado"><h2>Nada encontrado</h2></div>
						<?php
					} else {
						?>
						<p>
						<?php echo printPost($rep[0]['resenha'], 'page'); ?>
						</p>
						<?php
					}
					?>
					<div class="form">
						<form method="post">

							<label class="label"><h3>Avaliação da Reposição</h3></label><br>

							<input type="radio" name="situacao" value="2" <?php if($rep == true && $rep[0]['situacao'] == 2){ echo 'checked="checked"';} ?> />  Reposição inconsistente, precisa ser refeita. <br><br>
							<input type="radio" name="situacao" value="1" <?php if($rep == true && $rep[0]['situacao'] == 1){ echo 'checked="checked"';} ?> />  Reposição consistente, não precisa ser refeita. <br><br>

							<textarea placeholder="Digite um parecer sobre essa Reposição" name="parecer"><?php if($rep[0]['parecer'] != null || $rep[0]['parecer'] != ''){ echo printPost($rep[0]['parecer'], 'campo');}  ?></textarea>
							<center>
								<input type="color" name="cor" <?php if($rep[0]['cor'] != null){ echo 'value="'.$rep[0]['cor'].'"';}else{ echo 'value="#fff"';} ?> /><br><br>
								<input type="submit" name="salvar" value="Salvar" />
							</center>
						</form>
					</div>
				</div>

				<?php
			}

		}else{
			// $av = DBread('av_vets', "WHERE npacce = '".."'");
			?><h2>Avaliação</h2> <?php
			for ($i=1; $i <= $semana; $i++) { 
				$av = DBread('av_vets', "WHERE npacceVet = '".$url[3]."' AND semana = '".$i."'");
				// var_dump($av);
				if ($av == true) {
				?>

					<a class="botao" href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'/'.'avaliacao'.'/'.$i; ?>"><?php echo 'Semana '.$i; ?></a>		
				<?php
				}
			}
			
			if ($url[0] == 'ceo' || $url[0] == 'apoio-tecnico' || $user['npacce'] == B180550) {
				?>
				<br> <br><br>
				<h2>Relatório</h2> <?php

				for ($i=1; $i <=$semana ; $i++) { 
					$relat = DBread('ati_com', "WHERE npacce = '".$url[3]."' AND semana = '".$i."'");

					if ($relat == true) {
						?>
							<a class="botao" href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'/'.'relatorio'.'/'.$i; ?>"><?php echo 'Semana '.$i; ?></a>
						<?php
					}

				}

				?> 
				<br> <br><br>
				<h2>Justificativa</h2>

				<?php

				$just = DBread('just_ativ', "WHERE npacce = '".$url[3]."' ORDER BY codigo");

				if ($just != false) {
					?>

					<table class="table">
					<thead>
						<tr>
							<th>Código</th>
							<th>Atividade</th>
							<th>Semana</th>
							<th>Registro</th>
							<th>Cor</th>
						</tr>
					</thead>
					<tbody>
						<?php

						

						for ($i=0; $i < count($just); $i++) { 
							$atv = '';
								if (substr($just[$i]['codigo'], 0, 3) == 'SEF') {
									$atv = 'Semana de Férias';
								}else if (substr($just[$i]['codigo'], 0, 3) == 'FOR') {
									$atv = 'Formação';
								}else if (substr($just[$i]['codigo'], 0, 3) == 'ROD') {
									$atv = 'História de Vida';
								}else if (substr($just[$i]['codigo'], 0, 3) == 'RGM') {
									$atv = 'Reunião Geral';
								}else{
									$atv = 'Reunião de Comissão';
								}
								?>

								<tr>
									<td><a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'/justificativa?codigo='.$just[$i]['codigo']; ?>"><?php echo $just[$i]['codigo']; ?></a></td>
									<td><?php echo $atv; ?></td>
									<td><?php echo $just[$i]['semana']; ?></td>
									<td><?php echo date('d/m/y H:i:s', strtotime($just[$i]['registro'])); ?></td>
									<td <?php if($just[$i]['cor'] == null || $just[$i]['cor'] == ''){ echo 'style="background: #000;"';}else{ echo 'style="background: '.$just[$i]['cor'].';"';} ?>></td>
								</tr>

								<?php
						}



						?>						
					</tbody>
					</table>

					<?php
				} else {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}

				?>
				
				<br> <br><br>
				<h2>Reposição</h2>

				<?php

				$rep = DBread('rep_ativ', "WHERE npacce = '".$url[3]."' ORDER BY codigo");

				if ($rep != false) {
					?>

					<table class="table">
					<thead>
						<tr>
							<th>Código</th>
							<th>Atividade</th>
							<th>Registro</th>
							<th>Cor</th>
						</tr>
					</thead>
					<tbody>
						<?php

						

						for ($i=0; $i < count($rep); $i++) { 
							$atv = '';
								if (substr($rep[$i]['codigo'], 0, 3) == 'SEF') {
									$atv = 'Semana de Férias';
								}else if (substr($rep[$i]['codigo'], 0, 3) == 'FOR') {
									$atv = 'Formação';
								}else if (substr($rep[$i]['codigo'], 0, 3) == 'ROD') {
									$atv = 'História de Vida';
								}else if (substr($rep[$i]['codigo'], 0, 3) == 'RGM') {
									$atv = 'Reunião Geral';
								}else{
									$atv = 'Reunião de Comissão';
								}
								?>

								<tr>
									<td><a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'/reposicao?codigo='.$rep[$i]['codigo']; ?>"><?php echo $rep[$i]['codigo']; ?></a></td>
									<td><?php echo $atv; ?></td>
									<td><?php echo date('d/m/y H:i:s', strtotime($rep[$i]['registro'])); ?></td>
									<td <?php if($rep[$i]['cor'] == null || $rep[$i]['cor'] == ''){ echo 'style="background: #000;"';}else{ echo 'style="background: '.$rep[$i]['cor'].';"';} ?>></td>
								</tr>

								<?php
						}



						?>						
					</tbody>
					</table>

					<?php
				} else {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}

				?>


				<?php

			}

			
		}
	}else{
		$comissao = DBread('comissoes', "WHERE comissaoSlug = '".$url[2]."'");
		if ($comissao == false) {
			echo 'Nada encontrado';
		}else{
			$membros = DBread('bolsistas', "WHERE tipoSlug = '".$comissao[0]['comissaoSlug']."' AND status = true");
			?>
			<div class="title"><h2>Escolha um membro</h2></div>
			<?php		
				for ($i=0; $i < count($membros); $i++) { 
				?>
				<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$membros[$i]['npacce']; ?>">
					<div class="foto-single" style="float: left;">
						<?php  
							 $foto = DBread('bolsistas', "WHERE npacce = '".$membros[$i]['npacce']."'", "id, foto");
						?>
						<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
						<div class="nome"><?php echo GetName($membros[$i]['nome'], $membros[$i]['nomeUsual']); ?></div>
					</div>
				</a>
				<?php
				}
				echo '<div id="clear"></div>';
		}	
	}
}else{
	// COMISSOES ====================================================
	echo '<div class="title"><h2>Comissões</h2></div>';
	$comissoes = DBread('comissoes', "WHERE status = true");
		if ($comissoes == false) {
			echo '<div class="nada-encontrado"><h2>Não há comissões registradas no momento.</h2></div>';
		}else{
			for ($i=0; $i <count($comissoes); $i++) { 
				if($comissoes[$i]['comissao'] != "Articulador de Célula" && $comissoes[$i]['comissao'] !="Projeto Site"){		
				?>		
				<a class="botao" href="<?php echo $way.'/'.$url[1].'/'.$comissoes[$i]['comissaoSlug']; ?>"><?php echo $comissoes[$i]['comissao']; }?></a>		
				<?php 
			}
	}
}
?>

