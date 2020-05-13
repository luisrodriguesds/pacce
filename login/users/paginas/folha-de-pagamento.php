
<?php 
	if (isset($_GET['atualizar-folha'])) {
		include 'paginas/folha.php';
	}
?>
<div class="title"><h2>Folha de Pagamento</h2></div>
<p>Página destinada para montagem da folha de pagamento.</p>
<br><br>
<?php 
	if (isset($url[2]) && $url[2] != '') {
		if ($url[2] == 'folha-de-abril') {
			$folha = 'Abril';
			$tabela = 'folha_abril';
			$folhaRes = DBread('folha_abril', "ORDER BY nome ASC");
		}else if ($url[2] == 'folha-de-maio') {
			$folha = 'Maio';
			$tabela = 'folha_maio';
			$folhaRes = DBread('folha_maio', "ORDER BY nome ASC");
		}else if ($url[2] == 'folha-de-junho') {
			$folha = 'Junho';
			$tabela = 'folha_junho';
			$folhaRes = DBread('folha_junho', "ORDER BY nome ASC");
		}else if ($url[2] == 'folha-de-julho') {
			$folha = 'Julho';
			$tabela = 'folha_julho';
			$folhaRes = DBread('folha_julho', "ORDER BY nome ASC");
		}else if ($url[2] == 'folha-de-agosto') {
			$folha = 'Agosto';
			$tabela = 'folha_agosto';
			$folhaRes = DBread('folha_agosto', "ORDER BY nome ASC");
		}else if ($url[2] == 'folha-de-setembro') {
			$folha = 'Setembro';
			$tabela = 'folha_setembro';
			$folhaRes = DBread('folha_setembro', "ORDER BY nome ASC");
		}else if ($url[2] == 'folha-de-outubro') {
			$folha = 'Outubro';
			$tabela = 'folha_outubro';
			$folhaRes = DBread('folha_outubro', "ORDER BY nome ASC");
		}else if ($url[2] == 'folha-de-novembro') {
			$folha = 'Novembro';
			$tabela = 'folha_novembro';
			$folhaRes = DBread('folha_novembro', "ORDER BY nome ASC");
		}else if ($url[2] == 'folha-de-dezembro') {
			$folha = 'Dezembro';
			$tabela = 'folha_dezembro';
			$folhaRes = DBread('folha_dezembro', "ORDER BY nome ASC");
		}else if ($url[2] == 'folha-final') {
			$folha = 'Dezembro';
			$tabela = 'folha_final';
			$folhaRes = DBread('folha_final', "ORDER BY nome ASC");
		}else{
			echo '
             <script>
              alert("Nada encontrado nas tabelas!");
                window.location="'.$way.'/'.$url[1].'";
              </script>';
		}
		if (isset($_GET['folha-res'])) {
			include 'paginas/folha-resultado.php';
		}
	?>
		<?php 
			if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico') {
		?>
		<script>
			function gerar(){
				if (confirm("Deseja gerar a folha de pagamento?")){
					window.location="<?php echo $way.'/'.$url[1].'/'.$url[2].'?folha-res'; ?>";
				}
			}
		</script>
		<div class="title" onclick="gerar()"><h2><a style="cursor:pointer;">Gerar folha de <?php echo $folha; ?> - Última atualização <?php $last = DBread($tabela, "LIMIT 1", "id, registro"); if($last == false){ echo '--/--/-- às --:--';}else{ echo date('d/m/y', strtotime($last[0]['registro'])).' às '.date('H:i:s', strtotime($last[0]['registro']));} ?> </a></h2></div>
		<p>Esse comando verifica a tabela de contagens de atividades e a tabela de valores necessarios para não ir para suplementar. Esse comando pode levar vários minutos, portando, por favor aguade.</p>
		<br><br>
		<?php }?>
		<div class="title"><h2>Resultado desse mês</h2></div>
		<?php 
			if ($folhaRes == false) {
				echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
			}else{
		?>
			<div class="tabela">
			<div class="form">
			<form method="post">
				<table>
					<tr>
						<th>Npacce</th>
						<th>Nome</th>
						<th>Função</th>
						<th>Campus</th>
						<th>Situação</th>
					</tr>
					<?php 
						if (isset($_POST['salvar'])) {
							$cont = 0;
							for ($i=0; $i < count($folhaRes); $i++) { 
								$form['situacao'] = GetPost($folhaRes[$i]['npacce']);
								
								if ($form['situacao'] != $folhaRes[$i]['situacao']) {
									if (DBUpDate($tabela, $form, "npacce = '".$folhaRes[$i]['npacce']."'")) {
										$cont++;
									}
								}else{
									$cont++;
								}
							}
							if ($cont == count($folhaRes)) {
								echo '<script>alert("Dados alterados com sucesso!");
			        			window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
									
							}
						}
						for ($i=0; $i < count($folhaRes); $i++) { 
							
							$cpf = DBread('bolsistas', "WHERE npacce = '".$folhaRes[$i]['npacce']."'", "cpf");
					?>
					<tr>
						<td><?php echo $folhaRes[$i]['npacce']; ?></td>
						<td><a href="<?php echo $way.'/gerenciar-bolsistas/'.$cpf[0]['cpf'].'/'.$folhaRes[$i]['npacce']; ?>"><?php echo $folhaRes[$i]['nome']; ?></a></td>
						<td><?php echo $folhaRes[$i]['tipo']; ?></td>
						<td><?php echo $folhaRes[$i]['campus']; ?></td>
						<td style="<?php if(!empty($folhaRes[$i]['obs'])){ if($folhaRes[$i]['campus'] == 'pici' || $folhaRes[$i]['campus'] == 'benfica' || $folhaRes[$i]['campus'] == 'labomar' || $folhaRes[$i]['campus'] == 'porangabucu'){ echo 'background-color: #eada31;'; } } ?>" title="<?php echo $folhaRes[$i]['obs']; ?>">
						<select name="<?php echo $folhaRes[$i]['npacce']; ?>">
							<option <?php if($folhaRes[$i]['situacao'] == 'Normal'){ echo 'selected=""';} ?> value="Normal">Normal</option>
							<option <?php if($folhaRes[$i]['situacao'] == 'Ainda_nao'){ echo 'selected=""';} ?> value="Ainda_nao">Ainda não</option>
							<option <?php if($folhaRes[$i]['situacao'] == 'Suplementar'){ echo 'selected=""';} ?>  value="Suplementar">Suplementar</option>
						</select>
						</td>
					</tr>
					<?php }?>
				</table>
				<div id="cont">(<?php echo count($folhaRes); ?>)</div>
				<center>
				<input type="submit" value="Salvar Processo" name="salvar"></input>
				</center>
				</form>
				</div>
			</div>
		<?php
			}
		?>

	<?php
	}else{
?>
<script>
	function atulizar(){
		if (confirm("Deseja atualizar a folha de pagamento?")){
			window.location="<?php echo $way.'/'.$url[1].'?atualizar-folha' ?>";
		}
	}
</script>

<div class="title" onclick="atulizar()"><h2><a style="cursor:pointer;">Atualizar Folha - Última atualização <?php $last = DBread('folha_contagem', "LIMIT 1", "id, registro"); if($last == false){ echo '--/--/-- às --:--';}else{ echo date('d/m/y', strtotime($last[0]['registro'])).' às '.date('H:i:s', strtotime($last[0]['registro']));} ?></a></h2> </div>
<p>Esse comando computa todas as atividades de todos os bolsistas no exato momento em que é solicitado. Esse processo de contagem pode levar alguns minutos, então por favor aguarde.</p>
<br>
<br>
<?php 
$folha = DBread('folha_valores');

	for ($i=0; $i < count($folha); $i++) { 
		echo '<div class="title"><h2><a href="'.$way.'/'.$url[1].'/'.$folha[$i]['folhaSlug'].'">'.$folha[$i]['folha'].'</a></h2></div><br>';
	}
}
?>