
<div class="title"><h2>Avaliar Veteranos</h2></div>
<p>Você poderá avaliar os seus facilitadores e outros bolsistas veteranos por meio deste formulário seguindo alguns critérios.
É importante que você seja bastante sincero/a em sua avaliação. <br> 
Usando uma escala de 1 a 5 em que 3 é o ponto de partida, se você acha que seu/sua facilitador/a esteve um pouco acima do esperado, coloque 4. 
Se foi bem acima, coloque 5. Inversamente, se ele/a não foi muito bem em algum item, coloque 2 ou 1 para situações em que não foi cumprido nada do esperado.<br>
</p>
<br>



<?php 
	if (isset($url[2]) && substr($url[2], 0, 9) == 'comissoes') {
		if (isset($url[3]) && $url[3] != '') {
			$comissao = str_replace("comissoes-", "", $url[2]);
			$com = DBread('comissoes', "WHERE comissaoSlug = '$comissao'");
			$npacce = DBread('bolsistas', "WHERE npacce = '".DBescape($url[3])."' AND status = true", 'id, npacce, nome, nomeUsual');
			if ($npacce == false) {
				alerta("Nada encontrado", $way.'/'.$url[1]);
			}else{

				if (isset($_POST['enviar'])) {
					$form['npacce']		= $user['npacce'];
					$form['npacceVet']	= $npacce[0]['npacce'];
					$form['semana']		= GetPost('semana');
					$form['atividade']	= $com[0]['comissao'].'-esporádico';
					// $form['codigo']		= $codigo;
					$form['criterio1'] 	= GetPost('criterio1');
					$form['criterio2'] 	= GetPost('criterio2');
					$form['criterio3'] 	= GetPost('criterio3');
					$form['criterio4'] 	= GetPost('criterio4');
					$form['parecer']	= GetPost('parecer');
					$form['status']		= 1;
					$form['registro']	= date('Y-m-d H:i:s');
					if (empty($form['criterio1'])) {
						alerta("Campo critério 1 está vazio");
					}else if (empty($form['criterio2'])) {
						alerta("Campo critério 2 está vazio");
					}else if (empty($form['criterio3'])) {
						alerta("Campo critério 3 está vazio");
					}else if (empty($form['criterio4'])) {
						alerta("Campo critério 4 está vazio");
					}else if (empty($form['parecer'])) {
						alerta("Campo parecer obrigatório");
					}else{
						if (DBcreate('av_vets', $form)) {
							alertaLoad("Avaliação realizada com sucesso!", $way.'/'.$url[1]);
						}
					}
				}
				?>

<style type="text/css">
	table{ margin-top: 0 !important; }
</style>
<div id="editar-ativ" class="form">
	<form method="post">
		<div class="form-group">
			<label>Avaliação - <?php echo $npacce[0]['nome']; ?></label>
		</div>
		<hr>
		<label>Semana</label>
		<div class="form-group">
			<select class="control-form" name="semana">
				<?php 
				$weeks = DBread('calendario_2016');
        		for ($i=0; $i < count($weeks); $i++) {
        			if ($weeks[$i]['semana'] < 10) {
        			 	echo '<option value="'.$weeks[$i]['semana'].'">Semana 0'.$weeks[$i]['semana'].' - '.date('d/m/y', strtotime($weeks[$i]['inicio'])).' até '.date('d/m/y', strtotime($weeks[$i]['fim'])).'</option>';
        			 }else{
        			 	echo '<option value="'.$weeks[$i]['semana'].'">Semana '.$weeks[$i]['semana'].' - '.date('d/m/y', strtotime($weeks[$i]['inicio'])).' até '.date('d/m/y', strtotime($weeks[$i]['fim'])).'</option>';
        			 } 
        		}

				?>
			</select>
		</div>
		<br>
		<div class="form-group">
			<label for="nome">Disponibilidade</label>
        	<table width="100%" class="table table-striped">
		 		<tr>
		 			<th>1</th>
		 			<th>2</th>
		 			<th>3</th>
		 			<th>4</th>
		 			<th>5</th>
		 		</tr>
		 		<tr>
		 			<td><input type="radio" name="criterio1" value="1"></td>
		 			<td><input type="radio" name="criterio1" value="2"></td>
		 			<td><input type="radio" name="criterio1" value="3"></td>
		 			<td><input type="radio" name="criterio1" value="4"></td>
		 			<td><input type="radio" name="criterio1" value="5"></td>
		 		</tr>
		 	</table>
        </div>
 
		<div class="form-group">
			<label for="nome">Interação com articulador</label>
			<label></label>
        	<table width="100%" class="table table-striped">
		 		<tr>
		 			<th>1</th>
		 			<th>2</th>
		 			<th>3</th>
		 			<th>4</th>
		 			<th>5</th>
		 		</tr>
		 		<tr>
		 			<td><input type="radio" name="criterio2" value="1"></td>
		 			<td><input type="radio" name="criterio2" value="2"></td>
		 			<td><input type="radio" name="criterio2" value="3"></td>
		 			<td><input type="radio" name="criterio2" value="4"></td>
		 			<td><input type="radio" name="criterio2" value="5"></td>
		 		</tr>
		 	</table>
        </div>

        <div class="form-group">
			<label for="nome"><?php if($comissao == 'apoio-interno'){ echo 'Solícito/ Acessível'; }else if($comissao == 'apoio-tecnico'){ echo 'Solícito'; }else if($comissao == 'avaliacao'){ echo 'Acessibilidade '; }else if($comissao == 'comunicacao'){ echo 'Acessível/Divulgação da célula'; }else{ echo 'Solícito'; } ?></label>
			<label></label>
        	<table width="100%" class="table table-striped">
		 		<tr>
		 			<th>1</th>
		 			<th>2</th>
		 			<th>3</th>
		 			<th>4</th>
		 			<th>5</th>
		 		</tr>
		 		<tr>
		 			<td><input type="radio" name="criterio3" value="1"></td>
		 			<td><input type="radio" name="criterio3" value="2"></td>
		 			<td><input type="radio" name="criterio3" value="3"></td>
		 			<td><input type="radio" name="criterio3" value="4"></td>
		 			<td><input type="radio" name="criterio3" value="5"></td>
		 		</tr>
		 	</table>
        </div>

        <div class="form-group">
			<label for="nome"><?php if($comissao == 'apoio-interno'){ echo 'Pontualidade'; }else if($comissao == 'apoio-tecnico'){ echo 'Clareza '; }else if($comissao == 'avaliacao'){ echo 'Prazos '; }else if($comissao == 'comunicacao'){ echo 'Clareza (videos, informações)'; }else{ echo 'Pontualidade'; } ?></label>
			<label></label>
        	<table width="100%" class="table table-striped">
		 		<tr>
		 			<th>1</th>
		 			<th>2</th>
		 			<th>3</th>
		 			<th>4</th>
		 			<th>5</th>
		 		</tr>
		 		<tr>
		 			<td><input type="radio" name="criterio4" value="1"></td>
		 			<td><input type="radio" name="criterio4" value="2"></td>
		 			<td><input type="radio" name="criterio4" value="3"></td>
		 			<td><input type="radio" name="criterio4" value="4"></td>
		 			<td><input type="radio" name="criterio4" value="5"></td>
		 		</tr>
		 	</table>
        </div>
        <div class="form-group">
        	<label>Parecer</label>
        	<textarea name="parecer" class="form-control" placeholder="Digite um breve parecer (campo obrigatório)"></textarea>
        </div>
		<center>
	 		<input type="submit" name="enviar" value="Enviar"></input>
	 	</center>
	</form>
</div>
				<?php
			}
		}else{
			$comissao = str_replace("comissoes-", "", $url[2]);
			$membros = DBread('bolsistas', "WHERE tipoSlug = '".$comissao."' AND status = true", 'id, npacce, nome, nomeUsual');
			
			if ($membros == false) {
				alerta("Nada encontrado", $way.'/'.$url[1]);
			}else{
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
	}else if (isset($url[2]) && $url[2] != '') {
		$link 	= explode('-', DBescape($url[2]));
		$at 	= $link[0];
		$fac 	= $link[1];
		$fac 	= DBread('bolsistas', "WHERE npacce = '$fac'");
 		$sem 	= $link[3];
		$codigo = $link[4];

		if (isset($_POST['enviar'])) {
			$form['npacce']		= $user['npacce'];
			$form['npacceVet']	= $fac[0]['npacce'];
			$form['semana']		= $sem;
			$form['atividade']	= $at;
			$form['presenca']	= GetPost('presenca');
			$form['codigo']		= $codigo;
			$form['criterio1'] 	= GetPost('criterio1');
			$form['criterio2'] 	= GetPost('criterio2');
			$form['criterio3'] 	= GetPost('criterio3');
			$form['criterio4'] 	= GetPost('criterio4');
			$form['criterio5'] 	= GetPost('criterio5');
			$form['parecer']	= GetPost('parecer');
			$form['status']		= 1;
			$form['registro']	= date('Y-m-d H:i:s');
			if ($form['presenca'] == '') {
				alerta("Campo presença está vazio");
			}else if (empty($form['criterio1'])) {
				alerta("Campo critério 1 está vazio");
			}else if (empty($form['criterio2'])) {
				alerta("Campo critério 2 está vazio");
			}else if (empty($form['criterio3'])) {
				alerta("Campo critério 3 está vazio");
			}else if (empty($form['criterio4'])) {
				alerta("Campo critério 4 está vazio");
			}else if (empty($form['criterio5'])) {
				alerta("Campo critério 5 está vazio");
			}else if (empty($form['parecer'])) {
				alerta("Campo parecer obrigatório!");
			}else{
				if (DBcreate('av_vets', $form)) {
					alertaLoad("Avaliação realizada com sucesso!", $way.'/'.$url[1]);
				}
			}
		}
?>
<style type="text/css">
	table{ margin-top: 0 !important; }
</style>
<div id="editar-ativ" class="form">
	<form method="post">
		<div class="form-group">
			<label>Avaliação - <?php echo $fac[0]['nome']; ?></label>
		</div>
		<hr>
		<label for="nome">O Facilitador estava presente?</label>
		<br>
		<input type="radio" class="presenca" name="presenca" value="0" ></input> Não<br><br>
	 	<input type="radio" class="presenca" name="presenca" value="1" ></input> Sim<br><br>

		<div class="form-group">
			<label for="nome">Organização</label>
        	<table width="100%" class="table table-striped">
		 		<tr>
		 			<th>1</th>
		 			<th>2</th>
		 			<th>3</th>
		 			<th>4</th>
		 			<th>5</th>
		 		</tr>
		 		<tr>
		 			<td><input type="radio" name="criterio1" value="1"></td>
		 			<td><input type="radio" name="criterio1" value="2"></td>
		 			<td><input type="radio" name="criterio1" value="3"></td>
		 			<td><input type="radio" name="criterio1" value="4"></td>
		 			<td><input type="radio" name="criterio1" value="5"></td>
		 		</tr>
		 	</table>
        </div>
 
		<div class="form-group">
			<label for="nome">Pontualidade</label>
			<label></label>
        	<table width="100%" class="table table-striped">
		 		<tr>
		 			<th>1</th>
		 			<th>2</th>
		 			<th>3</th>
		 			<th>4</th>
		 			<th>5</th>
		 		</tr>
		 		<tr>
		 			<td><input type="radio" name="criterio2" value="1"></td>
		 			<td><input type="radio" name="criterio2" value="2"></td>
		 			<td><input type="radio" name="criterio2" value="3"></td>
		 			<td><input type="radio" name="criterio2" value="4"></td>
		 			<td><input type="radio" name="criterio2" value="5"></td>
		 		</tr>
		 	</table>
        </div>

        <div class="form-group">
			<label for="nome">Facilitador estimula a participação</label>
			<label></label>
        	<table width="100%" class="table table-striped">
		 		<tr>
		 			<th>1</th>
		 			<th>2</th>
		 			<th>3</th>
		 			<th>4</th>
		 			<th>5</th>
		 		</tr>
		 		<tr>
		 			<td><input type="radio" name="criterio3" value="1"></td>
		 			<td><input type="radio" name="criterio3" value="2"></td>
		 			<td><input type="radio" name="criterio3" value="3"></td>
		 			<td><input type="radio" name="criterio3" value="4"></td>
		 			<td><input type="radio" name="criterio3" value="5"></td>
		 		</tr>
		 	</table>
        </div>

        <div class="form-group">
			<label for="nome">Estímulo ao uso da aprendizagem cooperativa (HS)[Interd.Positiva]</label>
			<label></label>
        	<table width="100%" class="table table-striped">
		 		<tr>
		 			<th>1</th>
		 			<th>2</th>
		 			<th>3</th>
		 			<th>4</th>
		 			<th>5</th>
		 		</tr>
		 		<tr>
		 			<td><input type="radio" name="criterio4" value="1"></td>
		 			<td><input type="radio" name="criterio4" value="2"></td>
		 			<td><input type="radio" name="criterio4" value="3"></td>
		 			<td><input type="radio" name="criterio4" value="4"></td>
		 			<td><input type="radio" name="criterio4" value="5"></td>
		 		</tr>
		 	</table>
        </div>

        <div class="form-group">
			<label for="nome">Protagonismo [Desenvolve sua liderança pessoal]</label>
			<label></label>
        	<table width="100%" class="table table-striped">
		 		<tr>
		 			<th>1</th>
		 			<th>2</th>
		 			<th>3</th>
		 			<th>4</th>
		 			<th>5</th>
		 		</tr>
		 		<tr>
		 			<td><input type="radio" name="criterio5" value="1"></td>
		 			<td><input type="radio" name="criterio5" value="2"></td>
		 			<td><input type="radio" name="criterio5" value="3"></td>
		 			<td><input type="radio" name="criterio5" value="4"></td>
		 			<td><input type="radio" name="criterio5" value="5"></td>
		 		</tr>
		 	</table>
        </div>
        <div class="form-group">
        	<label>Parecer</label>
        	<textarea name="parecer" class="form-control" placeholder="Digite um breve parecer (campo obrigatório)"></textarea>
        </div>
		<center>
	 		<input type="submit" name="enviar" value="Enviar"></input>
	 	</center>
	</form>
</div>
<?php
	}else{


?>

<div class="title"><h2>Formação</h2></div>
<?php 
	//FORMACAO
	$for = DBread('for_pres', "WHERE npacce = '".$user['npacce']."' AND presenca = 1 ORDER BY semana ASC");
	if ($for == false) {
	}else{
		$at = 'for';
?>
<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<th>Semana</th>
			<th>Sala</th>
			<th>Facilitador 1</th>
			<th>Enviado</th>
			<th>Facilitador 2</th>
			<th>Enviado</th>
			<th>Facilitador 3</th>
			<th>Enviado</th>
		</tr>

		<?php 
			for ($i=0; $i < count($for); $i++) { 
				
				$fac = DBread('for_salas', "WHERE sala = '".$for[$i]['sala']."'");
				$fac = $fac[0];
		?>
		<tr>
			<th>Semana <?php if($for[$i]['semana'] < 10){ echo '0'.($for[$i]['semana']); }else{ echo ($for[$i]['semana']); } ?></th>
			<th>
				<?php 
					echo $fac['sala'];
					$send1 = DBread('av_vets', "WHERE npacce = '".$user['npacce']."' AND npacceVet = '".$fac['npacce1']."' AND semana = '".$for[$i]['semana']."' AND atividade = '".$at."' AND codigo = '".$for[$i]['codigo']."'");
					$send2 = DBread('av_vets', "WHERE npacce = '".$user['npacce']."' AND npacceVet = '".$fac['npacce2']."' AND semana = '".$for[$i]['semana']."' AND atividade = '".$at."' AND codigo = '".$for[$i]['codigo']."'");
					$send3 = DBread('av_vets', "WHERE npacce = '".$user['npacce']."' AND npacceVet = '".$fac['npacce3']."' AND semana = '".$for[$i]['semana']."' AND atividade = '".$at."' AND codigo = '".$for[$i]['codigo']."'");
				?>		
			</th>
			<td>
				<?php 
					if ($send1 == false) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$at.'-'.$fac['npacce1'].'-semana-'.$for[$i]['semana'].'-'.$for[$i]['codigo']; ?>" style="text-decoration: underline;"><?php echo $fac['bol1']; ?></a>
				<?php
					}else{
				?>
					<span style="text-decoration: line-through;"><?php echo $fac['bol1']; ?></span>
				<?php
					}
				?>
			</td>
			<td>
				<?php 
					if ($send1 == true) {
						echo 'SIM';
					}else{
						echo 'NÃO';
					}
				?>
			</td>
			<td>
				<?php 
					if ($send2 == false) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$at.'-'.$fac['npacce2'].'-semana-'.$for[$i]['semana'].'-'.$for[$i]['codigo']; ?>" style="text-decoration: underline;"><?php echo $fac['bol2']; ?></a>
				<?php
					}else{
				?>
					<span style="text-decoration: line-through;"><?php echo $fac['bol2']; ?></span>
				<?php
					}
				?>
			</td>
			<td>
				<?php 
					if ($send2 == true) {
						echo 'SIM';
					}else{
						echo 'NÃO';
					}
				?>
			</td>
			<td>
				<?php 
					if ($send3 == false) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$at.'-'.$fac['npacce3'].'-semana-'.$for[$i]['semana'].'-'.$for[$i]['codigo']; ?>" style="text-decoration: underline;"><?php echo $fac['bol3']; ?></a>
				<?php
					}else{
				?>
					<span style="text-decoration: line-through;"><?php echo $fac['bol3']; ?></span>
				<?php
					}
				?>
			</td>
			<td>
				<?php 
					if ($send3 == true) {
						echo 'SIM';
					}else{
						echo 'NÃO';
					}
				?>
			</td>
			<td>
		</tr>	
	<?php  } ?>
	</table>	
</div>
<?php } ?>

<br><br>
<div class="title"><h2>Roda Viva</h2></div>
<?php 
	//Rod viva
	$rod = DBread('rod_pres', "WHERE npacce = '".$user['npacce']."' AND presenca = 1 ORDER BY semana ASC");
	if ($rod == false) {
	}else{
		$at = 'rod';
?>
<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<th>Semana</th>
			<th>Sala</th>
			<th>Facilitador 1</th>
			<th>Enviado</th>
			<th>Facilitador 2</th>
			<th>Enviado</th>
		</tr>

		<?php 
			for ($i=0; $i < count($rod); $i++) { 
				
				$fac = DBread('rod_salas', "WHERE sala = '".$rod[$i]['sala']."'");
				$fac = $fac[0];
		?>
		<tr>
			<th>Semana <?php if($rod[$i]['semana'] < 10){ echo '0'.($rod[$i]['semana']); }else{ echo ($rod[$i]['semana']); } ?></th>
			<th>
				<?php 
					echo $fac['sala'];
					$send1 = DBread('av_vets', "WHERE npacce = '".$user['npacce']."' AND npacceVet = '".$fac['npacce1']."' AND semana = '".$rod[$i]['semana']."' AND atividade = '".$at."' AND codigo = '".$rod[$i]['codigo']."'");
					$send2 = DBread('av_vets', "WHERE npacce = '".$user['npacce']."' AND npacceVet = '".$fac['npacce2']."' AND semana = '".$rod[$i]['semana']."' AND atividade = '".$at."' AND codigo = '".$rod[$i]['codigo']."'");
				?>		
			</th>
			<td>
				<?php 
					if ($send1 == false) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$at.'-'.$fac['npacce1'].'-semana-'.$rod[$i]['semana'].'-'.$rod[$i]['codigo']; ?>" style="text-decoration: underline;"><?php echo $fac['bol1']; ?></a>
				<?php
					}else{
				?>
					<span style="text-decoration: line-through;"><?php echo $fac['bol1']; ?></span>
				<?php
					}
				?>
			</td>
			<td>
				<?php 
					if ($send1 == true) {
						echo 'SIM';
					}else{
						echo 'NÃO';
					}
				?>
			</td>
			<td>
				<?php 
					if ($send2 == false) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$at.'-'.$fac['npacce2'].'-semana-'.$rod[$i]['semana'].'-'.$rod[$i]['codigo']; ?>" style="text-decoration: underline;"><?php echo $fac['bol2']; ?></a>
				<?php
					}else{
				?>
					<span style="text-decoration: line-through;"><?php echo $fac['bol2']; ?></span>
				<?php
					}
				?>
			</td>
			<td>
				<?php 
					if ($send2 == true) {
						echo 'SIM';
					}else{
						echo 'NÃO';
					}
				?>
			</td>
		</tr>	
	<?php  } ?>
	</table>	
</div>
<?php } ?>

<br><br>
<div class="title"><h2>Apoio à Célula</h2></div>
<?php 
	//Apoio a celula
	$apo = DBread('apo_pres', "WHERE npacce = '".$user['npacce']."' AND presenca = 1 ORDER BY semana ASC");

	if ($apo == false) {
	}else{
		$at = 'apo';
?>
<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<th>Semana</th>
			<th>Sala</th>
			<th>Facilitador 1</th>
			<th>Enviado</th>
			<th>Facilitador 2</th>
			<th>Enviado</th>
		</tr>

		<?php 
			for ($i=0; $i < count($apo); $i++) { 
				
				$fac = DBread('apo_salas', "WHERE sala = '".$apo[$i]['sala']."'");
				$fac = $fac[0];
		?>
		<tr>
			<th>Semana <?php if($apo[$i]['semana'] < 10){ echo '0'.($apo[$i]['semana']); }else{ echo ($apo[$i]['semana']); } ?></th>
			<th>
				<?php 
					echo $fac['sala'];
					$send1 = DBread('av_vets', "WHERE npacce = '".$user['npacce']."' AND npacceVet = '".$fac['npacce1']."' AND semana = '".$apo[$i]['semana']."' AND atividade = '".$at."' AND codigo = '".$apo[$i]['codigo']."'");
					$send2 = DBread('av_vets', "WHERE npacce = '".$user['npacce']."' AND npacceVet = '".$fac['npacce2']."' AND semana = '".$apo[$i]['semana']."' AND atividade = '".$at."' AND codigo = '".$apo[$i]['codigo']."'");
				?>		
			</th>
			<td>
				<?php 
					if ($send1 == false) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$at.'-'.$fac['npacce1'].'-semana-'.$apo[$i]['semana'].'-'.$apo[$i]['codigo']; ?>" style="text-decoration: underline;"><?php echo GetName($fac['nomeComp1'], 1); ?></a>
				<?php
					}else{
				?>
					<span style="text-decoration: line-through;"><?php echo GetName($fac['nomeComp1'], 1); ?></span>
				<?php
					}
				?>
			</td>
			<td>
				<?php 
					if ($send1 == true) {
						echo 'SIM';
					}else{
						echo 'NÃO';
					}
				?>
			</td>
			<td>
				<?php 
					if ($send2 == false) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$at.'-'.$fac['npacce2'].'-semana-'.$apo[$i]['semana'].'-'.$apo[$i]['codigo']; ?>" style="text-decoration: underline;"><?php echo GetName($fac['nomeComp2'], 1); ?></a>
				<?php
					}else{
				?>
					<span style="text-decoration: line-through;"><?php echo GetName($fac['nomeComp2'], 1); ?></span>
				<?php
					}
				?>
			</td>
			<td>
				<?php 
					if ($send2 == true) {
						echo 'SIM';
					}else{
						echo 'NÃO';
					}
				?>
			</td>
		</tr>	
	<?php  } ?>
	</table>	
</div>
<?php } ?>

<br><br>
<div class="title"><h2>Interação</h2></div>
<?php 

	//Int
	$int = DBread('int_insc', "WHERE npacce = '".$user['npacce']."' AND presenca = 1 ORDER BY semana ASC");
	if ($int == false) {
		
	}else{
		$at = 'int';
	?>
<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<th>Semana</th>
			<th>Interação</th>
			<th>Facilitador 1</th>
			<th>Enviado</th>
			<th>Facilitador 2</th>
			<th>Enviado</th>
		</tr>
		<?php 
			for ($i=0; $i < count($int); $i++) { 
				
				$fac = DBread('int_cad', "WHERE codigo = '".$int[$i]['codigo']."'");
				$fac = $fac[0];
				$send1 = DBread('av_vets', "WHERE npacce = '".$user['npacce']."' AND npacceVet = '".$fac['npacce1']."' AND semana = '".$int[$i]['semana']."' AND atividade = '".$at."' AND codigo = '".$int[$i]['codigo']."'");
				$send2 = DBread('av_vets', "WHERE npacce = '".$user['npacce']."' AND npacceVet = '".$fac['npacce2']."' AND semana = '".$int[$i]['semana']."' AND atividade = '".$at."' AND codigo = '".$int[$i]['codigo']."'");
		?>
		<tr>
			<th>Semana <?php if($int[$i]['semana'] < 10){ echo '0'.($int[$i]['semana']); }else{ echo ($int[$i]['semana']); } ?></th>
			<td><?php echo $int[$i]['titulo']; ?></td>
			<td>
				<?php 
					if ($send1 == false) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$at.'-'.$fac['npacce1'].'-semana-'.$int[$i]['semana'].'-'.$int[$i]['codigo']; ?>" style="text-decoration: underline;"><?php echo $fac['bol1']; ?></a>
				<?php
					}else{
				?>
					<span style="text-decoration: line-through;"><?php echo $fac['bol1']; ?></span>
				<?php
					}
				?>
			</td>
			<td>
				<?php 
					if ($send1 == true) {
						echo 'SIM';
					}else{
						echo 'NÃO';
					}
				?>
			</td>
			<td>
				<?php 
					if ($send2 == false) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$at.'-'.$fac['npacce2'].'-semana-'.$int[$i]['semana'].'-'.$int[$i]['codigo']; ?>" style="text-decoration: underline;"><?php echo $fac['bol2']; ?></a>
				<?php
					}else{
				?>
					<span style="text-decoration: line-through;"><?php echo $fac['bol2']; ?></span>
				<?php
					}
				?>
			</td>
			<td>
				<?php 
					if ($send2 == true) {
						echo 'SIM';
					}else{
						echo 'NÃO';
					}
				?>
			</td>
		</tr>

		<?php
			 }
		?>

	</table>
</div>
	<?php
	}
?>

<?php 
	$comissoes = DBread('comissoes', "WHERE status = true ORDER BY comissao ASC");

?>
<br><br>
<div class="title"><h2>Encontros Esporádicos</h2></div>
<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<th>Comissão</th>
		</tr>
		<?php 
		for ($i=0; $i < count($comissoes); $i++) { 
			if ($comissoes[$i]['comissaoSlug'] != 'articulador-de-celula' && $comissoes[$i]['comissaoSlug'] != 'interacao' && $comissoes[$i]['comissaoSlug'] != 'prece-escola' && $comissoes[$i]['comissaoSlug'] != 'formacao-sobral' && $comissoes[$i]['comissaoSlug'] != 'candidato') {
			
		?>
		<tr>
			<td><a href="<?php echo $way.'/'.$url[1].'/comissoes-'.$comissoes[$i]['comissaoSlug'].''; ?>"><?php echo $comissoes[$i]['comissao']; ?></a></td>
		</tr>
	<?php } } ?>
	</table>
</div>
<?php 
//FIM DA PAGINACAO
} 
?>
