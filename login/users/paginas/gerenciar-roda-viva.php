
<?php 
	if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno') {
		$rodSalas = DBread('rod_salas', "ORDER BY sala");
	}else{
		$rodSalas = DBread('rod_salas', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' ORDER BY sala");
	}
	//ALTERAR STATUS
	if (isset($_GET['action']) && $_GET['action'] != '' && isset($_GET['sala']) && $_GET['sala'] != '') {
		$sala = DBescape(trim(strip_tags($_GET['sala'])));
		$very = DBread('rod_salas', "WHERE sala = '$sala'");
		if ($very == false) {
			echo ' <script>
			   window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
			   </script>';
		}else{

		switch ($_GET['action']) {
			case 1:
				$up['status'] = 1;
				if (DBUpDate('rod_salas', $up, "sala = '$sala'")) {
					if (DBUpDate('rod_insc', $up, "sala = '$sala'")) {
					echo ' <script>
			                  alert("Ação realizada com sucesso!");
			                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
			                  </script>';
					}
				}	
			break;
			case 2:
				$up['status'] = 0;
				if (DBUpDate('rod_salas', $up, "sala = '$sala'")) {
					if (DBUpDate('rod_insc', $up, "sala = '$sala'")) {
					echo ' <script>
			                  alert("Ação realizada com sucesso!");
			                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
			                  </script>';
					}
				}
			break;
			case 3:
				if (DBDelete('rod_salas', "sala = '$sala'")) {
					if (DBDelete('rod_cod', "sala = '$sala'")) {
						if (DBDelete('rod_insc', "sala = '$sala'")) {
							echo ' <script>
			                  alert("Ação realizada com sucesso!");
			                    window.location="'.$way.'/'.$url[1].'";
			                  </script>';
						}
					}
				}
			break;
			}	
		}
	}
	
?>
<div class="title"><h2>Gerenciar História de Vida</h2></div>
<p>Você irá visualizar as salas que está como facilitador e por meio delas, enviará 
os relatórios semanais dos bolsistas matriculados na sala que está faciitando.</p>
<br><br>
<?php 
	if (isset($url[2]) && $url[2] == 'cadastrar-historia-de-vida') {
	//====================CADASTRAR FORMAÇÃO===================
		if (isset($_POST['cadastrar'])) {
			$form['sala']		= GetPost('sala');
			$form['npacce1'] 	= GetPost('npacce1');
			$form['bol1']	 	= '';
			$form['nomeComp1']	= '';
			$form['npacce2'] 	= GetPost('npacce2');
			$form['bol2']	 	= '';
			$form['nomeComp2']	= '';
			$form['local']		= GetPost('local');
			$form['inicio']		= GetPost('inicio');
			$form['fim']		= GetPost('fim');
			$form['dataInicio']	= GetPost('dataInicio').' '.$form['inicio'];
			$form['dataFim']	= GetPost('dataFim');
			$form['diaSemana'] 	= date('D', strtotime($form['dataInicio']));
			$form['diaSemana'] 	= $week[$form['diaSemana']];
			$form['disc']		= GetPost('disc');
			$form['cardName']	= 'Formação';
			$form['cor']		= GetPost('cor');
			$form['turno']		= GetPost('turno');
			$form['registro']	= date('Y-m-d H:i:s');
			$form['regiao']		= GetPost('regiao');
			$form['regiaoSlug']	= Slug(GetPost('regiao'));
			$form['semanaInicio']= GetPost('semanaInicio');
			$form['semanaFim']	= GetPost('semanaFim');
			$form['vagaInicial'] = GetPost('vagaInicial');
			$form['vagaAtual'] = GetPost('vagaInicial');
			$form['status']		= GetPost('status');

			$sala 		= DBread('rod_salas', "WHERE sala = '".$form['sala']."'", "id");
			$npacce1 	= DBread('bolsistas', "WHERE npacce = '".$form['npacce1']."'", "id, nome, nomeUsual"); 
			$npacce2 	= DBread('bolsistas', "WHERE npacce = '".$form['npacce2']."'", "id, nome, nomeUsual"); 
			if (empty($form['sala']) || strlen($form['sala']) < 4 || strlen($form['sala']) > 4 || $sala == true) {
				echo '<script>alert("Campo Sala está incoerente!!"); </script>';
			}else if(empty($form['local'])){
				echo '<script>alert("Campo Local está vazio"); </script>';
			}else if(empty($form['dataInicio'])){
				echo '<script>alert("Campo Data do Início está vazio"); </script>';
			}else if(empty($form['dataFim'])){
				echo '<script>alert("Campo Data do Fim está vazio"); </script>';
			}else if(date('Y-m-d', strtotime($form['dataFim'])) < date('Y-m-d', strtotime($form['dataInicio']))){
				echo '<script>alert("As datas estão incoerentes!"); </script>';
			}else if (empty($form['inicio'])) {
				echo '<script>alert("Campo Horário do Início está vazio"); </script>';
			}else if (empty($form['fim'])) {
				echo '<script>alert("Campo Horário do Fim está vazio"); </script>';
			}else if (date('H:i:s', strtotime($form['fim'])) <  date('H:i:s', strtotime($form['inicio']))) {
				echo '<script>alert("Os horário estão incoerentes!!"); </script>';
			}else if (empty($form['regiao']) || $form['regiao'] == -1) {
				echo '<script>alert("Campo Região está vazio"); </script>';
			}else if (empty($form['semanaInicio']) || $form['semanaInicio'] == -1) {
				echo '<script>alert("Campo Semana de Inscrição está vazio"); </script>';
			}else if (empty($form['semanaFim']) || $form['semanaFim'] == -1) {
				echo '<script>alert("Campo Semana do Fim está vazio"); </script>';
			}else if($form['semanaInicio'] > $form['semanaFim']){
				echo '<script>alert("As semanas estão incoerentes!!"); </script>';
			}else if (empty($form['vagaInicial'])) {
				echo '<script>alert("Campo Vagas está vazio"); </script>';
			}else if (empty($form['disc'])) {
				echo '<script>alert("Campo Descrição está vazio está vazio"); </script>';
			}else if (empty($form['cor']) || $form['cor'] == '#ccc') {
				echo '<script>alert("Campo Cor está vazio"); </script>';
			}else if ($npacce1 == false) {
				echo '<script>alert("Esse bolsista não existe!"); </script>';
			}else if (!empty($form['npacce2']) && $npacce2 == false) {
				echo '<script>alert("Esse bolsista não existe!"); </script>';
			}else{
				$form['bol1'] 			= GetName($npacce1[0]['nome'], $npacce1[0]['nomeUsual']);
				$form['nomeComp1']		= $npacce1[0]['nome'];
				if (!empty($form['npacce2'])) {
					$form['bol2'] 			= GetName($npacce2[0]['nome'], $npacce2[0]['nomeUsual']);
					$form['nomeComp2']		= $npacce2[0]['nome'];
				}
				if (DBcreate('rod_salas', $form)) {
					$codigo['codigo'] 	= '';
					$codigo['sala']	 	= $form['sala'];
					$codigo['status'] 	= 1;
					$codigo['registro']	= date('Y-m-d H:i:s');

					$ano  	= date('y');
					$sala 	= explode("-", $form['sala']);
					$sala 	= $sala[1];	
					for ($i=$form['semanaInicio']+1; $i <= $form['semanaFim']; $i++) { 
						if ($i < 10) {
						  $codigo['codigo'] = 'ROD'.$ano.'0'.$i.$sala;
						}else{
						  $codigo['codigo'] = 'ROD'.$ano.$i.$sala;
						}
						DBcreate('rod_cod', $codigo);
					}
					echo '
		                 <script>
		                  alert("Sala Cadastrada com Sucesso!");
		                    window.location="'.$way.'/'.$url[1].'";
		                  </script>';
				}
			}
			

		}
	?>
	<style type="text/css">
	.label{ color: #4A85A0; }
	</style>
	<div class="title"><h2>Cadastrar História de Vida</h2></div>
	<div id="editar-ativ" class="form">
		 <form action="" method="post" enctype="multipart/form-data">
			 <label class="label">Sala:</label><span style="color:red;"> * </span><br>
       	<strong>H-</strong>
       	<select name="sala">
       		<?php 
       		$checkSalas = DBread('rod_salas', null, "sala");


       		for ($i=1; $i < 100 ; $i++) {
       			if ($i < 10) {
       				$k = '0'.$i;
       			}else{
       				$k = $i;
       			}

       			$v = 0;
       			for ($j=0; $j < count($checkSalas); $j++) { 
       				if ($k == str_replace("H-", "", $checkSalas[$j]['sala'])) {
       					$v = 1;
       				}
       			}

       			if ($v == 1) {
				 	$block = 'disabled';
				}else{
					$block = '';
				}
       			
       			echo '<option '.$block.' value="H-'.$k.'">'.$k.'</option>';
       		}
       		?>
       		
       	</select>
       	<br><br>
     	<label class="label">Local:</label><span style="color:red;"> * </span><br>
        <input type="text" name="local" onkeyup="maiuscula(this)" value="" placeholder="Digite o local dessa sala"></input><br><br>
     	<label class="label">Data do Início:</label><span style="color:red;"> * </span><br>
        <input type="date" name="dataInicio"  value="" placeholder="Digite a data de Inicio dessa sala"></input><br><br>
     	<label class="label">Data do Fim:</label><span style="color:red;"> * </span><br>
        <input type="date" name="dataFim"  value="" placeholder="Digite a data do fim dessa sala"></input><br><br>
     	<label class="label">Horário do Início:</label><span style="color:red;"> * </span><br>
        <input type="time" name="inicio"  value="" placeholder="Digite horário do início dessa sala"></input><br><br>
     	<label class="label">Horário do Fim:</label><span style="color:red;"> * </span><br>
        <input type="time" name="fim"  value="" placeholder="Digite horário do início dessa sala"></input><br><br>
     	<label class="label">Turno</label><span style="color:red;"> * </span><br>
			<select name="turno">
        	<option value="Manhã">Manhã</option>
        	<option value="Tarde">Tarde</option>
        	<option value="Noite">Noite</option>
        	</select>
		<br><br>
     	 <label class="label">Região:</label><span style="color:red;"> * </span><br>
   		 <select name="regiao">
          <option selected="" value="-1">Escolha um campus...</option>
          <option value="Fortaleza"	title="Benfica, PICI, Porangabuçu e LABOMAR">Fortaleza</option>
          <option value="Crateús">Crateús</option>
          <option value="Quixadá">Quixadá</option>
          <option value="Russas">Russas</option>
          <option value="Sobral">Sobral</option>
       </select>   	
       <br><br>
     	 <label class="label">Semana de Inscrição:</label><span style="color:red;"> * </span><br>
        	<select name="semanaInicio">
        		<option value="-1">Escolha a Semana que essa sala ficará aberta para inscrição...</option>
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
        <br><br>
        <label class="label">Semana do Fim:</label><span style="color:red;"> * </span><br>
        	<select name="semanaFim">
        		<option value="-1">Escolha a Semana que essa sala encerrará as atividades...</option>
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
        <br><br>
   		<label class="label">Número PACCE do Facilitador:</label><span style="color:red;"> * </span><br>
   		<input type="text" name="npacce1" onkeyup="maiuscula(this)" value="" placeholder="Digite um número PACCE"></input><br><br>
   		 <label class="label">Número PACCE do Facilitador:</label><br>
   		 <input type="text" name="npacce2" onkeyup="maiuscula(this)" value="" placeholder="Digite um número PACCE"></input><br><br>
   		 <label class="label">Status:</label><br>
   		 <select name="status">
   		 	<option value="1">Ativo</option>
   		 	<option value="0">Inativo</option>
   		 </select><br><br>
   		
   		  <label class="label">Vagas:</label><span style="color:red;"> * </span><br>
        <input type="number" max="30" name="vagaInicial" onkeyup="" value="" placeholder="Digite o número de vagas dessa sala"></input><br><br>
  
    	<label class="label">Descrição:</label><span style="color:red;"> * </span><br>
   		<textarea name="disc"></textarea>
   			 
   		 <center>
   		 	<br><label class="label">Cor do Card:</label><span style="color:red;"> * </span><br>
   		 	<input type="color" value="" name="cor"><br><br>
   		 	<input type="submit" name="cadastrar" value="Cadastrar"></input>
   		 </center>
		 </form>
	 </div>
	<?php	
	}else if (isset($url[2]) && $url != '') {
		include 'paginas/rod-single.php';
	}else{
	
?>
<div class="title"><h2><a href="<?php echo $way.'/'.$url[1].'/cadastrar-historia-de-vida'; ?>">Cadastrar História de Vida</a></h2></div>

<br><br>
<div class="title"><h2>Salas</h2></div>
<?php 
	if ($rodSalas == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
	}else{
?>
<div class="caixa">
	<ul>
	<?php 
		for ($i=0; $i < count($rodSalas); $i++) { 
	?>
	<a href="<?php echo $way.'/'.$url[1].'/'.$rodSalas[$i]['sala']; ?>">
		<li style="background-color: <?php if($rodSalas[$i]['status'] == 1){ echo $rodSalas[$i]['cor']; }else{ echo '#ccc'; }  ?>">
			<div>
				<div id="box-all-info">
					<div id="all-info">
						<h3><?php echo $rodSalas[$i]['sala']; ?></h3><br>
						<span><?php echo texto($rodSalas[$i]['local'], 28); ?></span><br><br>
						<span><?php echo date('d/m', strtotime($rodSalas[$i]['dataInicio'])); ?>
						 - <?php echo date('d/m', strtotime($rodSalas[$i]['dataFim'])); ?> <br>
						  <?php echo date('H:i', strtotime($rodSalas[$i]['inicio'])).'hr'; ?> - 
						  <?php echo date('H:i', strtotime($rodSalas[$i]['fim'])).'hr'; ?> <br> <?php echo $rodSalas[$i]['diaSemana']; ?> </span><br><br>
						<span><?php echo $rodSalas[$i]['bol1']; ?> & <?php echo $rodSalas[$i]['bol2']; ?></span><br>
						<span><?php echo $rodSalas[$i]['vagaAtual']; ?>/<?php echo $rodSalas[$i]['vagaInicial']; ?> Vagas</span>
					</div>
				</div>
				<div id="tipo">
					História de Vida
				</div>
			</div>
		</li>
	</a>
		<?php } ?>
	</ul>
	<div id="cont"><br><?php echo '('.count($rodSalas).')' ?></div>
</div>
<?php } }?>