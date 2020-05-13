<?php 

	$semanaProx = $semana + 1;
	$semanaAnt = $semana - 1;
	$ano 		= date('Y');

	if ($user['tipoSlug'] != 'articulador-de-celula') {
		if ($user['campusSlug'] == 'pici' || $user['campusSlug'] == 'benfica' || $user['campusSlug'] == 'porangabucu' || $user['campusSlug'] == 'labomar' || $user['campusSlug'] == 'outro' ) {
			$intCad = DBread('int_cad', "WHERE status = true AND semana = '$semana' AND regiaoSlug = 'fortaleza' OR status = true AND regiaoSlug = 'fortaleza' AND semana = '$semanaAnt' AND status = true AND regiaoSlug = 'fortaleza' OR semana = '$semanaProx' AND status = true AND regiaoSlug = 'fortaleza' ORDER BY data ASC");
		}else{
			$intCad = DBread('int_cad', "WHERE status = true AND semana = '$semana' AND regiaoSlug = '".$user['campusSlug']."' OR status = true AND regiaoSlug = '".$user['campusSlug']."' AND semana = '$semanaAnt' AND status = true AND regiaoSlug = '".$user['campusSlug']."' OR semana = '$semanaProx' AND status = true AND regiaoSlug = '".$user['campusSlug']."' ORDER BY data ASC");	
		}
		
	}else{
		if ($user['campusSlug'] == 'pici' || $user['campusSlug'] == 'benfica' || $user['campusSlug'] == 'porangabucu' || $user['campusSlug'] == 'labomar' || $user['campusSlug'] == 'outro' ) {
			$intCad = DBread('int_cad', "WHERE status = true AND semana = '$semanaProx' AND regiaoSlug = 'fortaleza' ORDER BY data ASC");
		}else{
			$intCad = DBread('int_cad', "WHERE status = true AND semana = '$semanaProx' AND regiaoSlug = '".$user['campusSlug']."' ORDER BY data ASC");
		}
	}
	//Filtar por regiao
	
	$intInsc 	= DBread('int_insc', "WHERE status = true AND npacce = '".$user['npacce']."' ORDER BY semana ASC");
	

		//Redirect($way.'/'.$url[1]);
?>

<div class="title"><h2>Atividade de Interação</h2></div>
<p>Você pode conferir as atividades de interação que já fez, 
inscrever-se nas interações ofertadas ou anular inscrição na mesma. 
Você pode inscrever-se em quantas interações desejar, contanto que compareça.  
Lembre-se, as interações começam a ser disponibilizadas as quintas e 
serão encerradas aos domingos, por isso inscreva-se nesse período, 
pois não será contada sua presença se for a uma interação e não 
estiver inscrito.</p>
<br><br>

<?php 
	if (isset($url[2]) && $url[2] != '') {
		//pagina da interacao
		include 'paginas/int-single.php';
	}else{
?>
<div class="title"><h2>Interações Ofertadas</h2></div>
<div class="caixa">
	<?php 
		if ($intCad == false) {
			echo '<div class="nada-encontrado"><h2>Não há interações disponíveis no momento.</h2></div>';
		}else{
	?>
	<ul>
	<?php 
		for ($i=0; $i < count($intCad); $i++) { 
		
	?>
		<a href="<?php echo $way.'/'.$url[1].'/'.$intCad[$i]['codigo']; ?>">
		<li style="background-color: <?php echo $intCad[$i]['cor']; ?>;">
			<div>
				<div id="box-all-info">
					<div id="all-info">
						<h3><?php echo texto($intCad[$i]['titulo'], 30); ?></h3><br>
						<span><?php echo texto($intCad[$i]['local'], 28); ?></span><br><br>
						<span><?php echo date('d/m', strtotime($intCad[$i]['data'])); ?>
						 | <?php echo date('H:i', strtotime($intCad[$i]['inicio'])).'hr'; ?> - 
						 <?php echo date('H:i', strtotime($intCad[$i]['fim'])).'hr'; ?> <br> <?php echo $intCad[$i]['diaSemana']; ?> </span><br><br>
						<span><?php echo $intCad[$i]['bol1']; if($intCad[$i]['bol2'] == ''){}else{echo ' & '.$intCad[$i]['bol2'];} ?></span><br>
						<span><?php echo 'Semana  '; if($intCad[$i]['semana'] > 10){ echo $intCad[$i]['semana']; }else{ echo '0'.$intCad[$i]['semana']; } ?></span><br>
						<span><?php echo $intCad[$i]['vagaAtual'].'/'.$intCad[$i]['vagaInicial']; ?> Vagas</span><br><br>

					</div>
				</div>
				<div id="tipo">
					<?php echo $intCad[$i]['cardName']; ?>
				</div>
			</div>
			
		</li>
		</a>
		<?php } ?>
	</ul>
	<div id="cont"><br><?php echo '('.count($intCad).')'; ?></div>
	<?php } ?>
</div>
<br><br>
<div class="title"><h2>Histórico de Interações</h2></div>
<?php 
	if ($intInsc == false) {
		echo '<div class="nada-encontrado"><h2>Não há histórico registrado.</h2></div>';
	}else{
?>
<div class="tabela">
	<table border="">
		<tr>
			<th>Nome:</th>
			<th>Semana:</th>
			<th>Registro:</th>
			<th>Situação:</th>
		</tr>
		<?php 
		for ($i=0; $i < count($intInsc); $i++) { 

		?>
		<tr>
			<td><a href="<?php echo $way.'/'.$url[1].'/'.$intInsc[$i]['codigo']; ?>"><?php echo texto($intInsc[$i]['titulo'], 30); ?></a></td>
			<td><?php if($intInsc[$i]['semana'] >=10){echo $intInsc[$i]['semana'];}else{ echo '0'.$intInsc[$i]['semana'];} ?></td>
			<td><?php echo date('d/m/y', strtotime($intInsc[$i]['registro'])); ?></td>
			<td><?php if($intInsc[$i]['situacao'] == 0){ echo 'Você está inscrito!';}else if($intInsc[$i]['situacao'] == 1){ echo 'Você esteve presente!';}else{echo 'Você faltou essa atividade!';} ?></td>
		</tr>
		<?php } ?>
	</table>
	<div id="cont"><br><?php echo '('.count($intInsc).')'; ?></div>
</div>
<?php }  } ?>