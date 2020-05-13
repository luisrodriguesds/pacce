<script type="text/javascript">

	$(function(){
		$('#cpf').mask("999.999.999-99");
	});
</script>
<div id="controller" ng-controller="AppEuCtrl">
</div>

<div id="PageHeader">
	<h2>Encontros Universitários</h2>
</div>
<?php 
	//FAZER A VERIFICAÇÃO=====================================================
	if (isset($_GET['cpf'])) {
?>
	<h3>Formulário Para Cadastro de Evento</h3>
	<span style="color: red; ">
		Por favor, utilize o Google Chorme como navegador para enviar seus eventos.

	</span>
	<br><br>
	<style type="text/css">
		.form input[type=text]{
			width: 50%;
			padding: 8px;
		}
		.form input[type=date]{
			width: 50%;
		}
		label{
			color: #069;
			font-size: 20px;
			font-weight: bold;
		}
		select{
			padding: 5px;
			background: #f3f3f3;
		}
		textarea{
			width: 50%;
		}
		span{
			color: red;
		}
		.form input[type=submit]{
			width: 40%;
		}
	</style>
	<?php 
		if (isset($_POST['enviar'])) {

			$ev = DBread('eu_eventos', "ORDER BY codigo DESC LIMIT 1", "codigo");
			if ($ev == false) {
				$codigo = 'EU1701';
			}else{
				$n = str_replace("EU", "", $ev[0]['codigo']);
				$codigo = $n+1;
				$codigo = 'EU'.$codigo;
			}
			$form['codigo']		= $codigo;
			$form['evento'] 	= GetPost('evento');
			$form['eventoSlug'] = Slug($form['evento']);
			$form['data'] 		= GetPost('data');
			$form['local'] 		= GetPost('local');
			$form['inicio']		= GetPost('horaIni').':'.GetPost('minIni').':00';
			$form['fim']		= GetPost('horaFim').':'.GetPost('minFim').':00';
			$form['responsavel']= GetPost('responsavel');
			$form['destinado']	= GetPost('destinado');
			$form['descricao']	= GetPost('desc');
			$form['status']		= 1;
			$form['cor']		= GetPost('cor');
			$form['registro']	= date('Y-m-d H:i:s');
			$form['presenca']	= 0;
			$form['enviadopor'] = $_GET['cpf'];
			
			if (empty($form['evento'])) {
				echo '<script>alert("Campo Evento vazio!");</script>';
			}else if(empty($form['data']) || $form['data'] == '0000-00-00'){
				echo '<script>alert("Campo Data vazio!");</script>';	
			}else if(empty($form['local'])){
				echo '<script>alert("Campo local vazio!");</script>';
			}else if(empty($form['inicio']) || $form['inicio'] == '00:00:00'){
				echo '<script>alert("Campo Início vazio!");</script>';
			}else if(empty($form['fim']) || $form['fim'] == '00:00:00'){
				echo '<script>alert("Campo Fim vazio!");</script>';
			}else if(empty($form['responsavel'])){
				echo '<script>alert("Campo Responsável vazio!");</script>';
			}else if(empty($form['descricao'])){
				echo '<script>alert("Campo Responsável vazio!");</script>';
			}else{
				if (DBcreate('eu_eventos', $form)) {
					echo '<script>alert("Evento Cadastrado com sucesso!!! \n Para verificar seus eventos cadastrados, basta acessar o site com sua chave.");
					window.location="'.URLBASE.'encontros-universitarios/?cpf='.$_GET['cpf'].'";</script>';
				}
			}
		}
	?>
	<div class="form">
	<form method="post">
			<label>Título:</label><span style="color: red;">*</span><br>
			<span>O título deve contar resumidamente o foco do evento.</span><br>
			<input type="text" id="eventoRe" name="evento" value="<?php echo GetPost('evento'); ?>" placeholder="Digite o nome do evento">
			<br><br><br>
			<label>Local:</label><span style="color: red;">*</span><br>
			<span>O local do evento deve conter o maior detalhamento possível. Ex: Sala CS216 - ICA - Segundo Andar</span><br>
			<input type="text" id="localRe" name="local" value="<?php echo GetPost('local'); ?>" placeholder="Digite o local do evento">
			<br><br><br>
			<label>Data:</label><span style="color: red;">*</span><br>
			<input type="date" id="dataRe" name="data" value="<?php echo GetPost('data'); ?>">
			<br><br><br>
			<label>Inicio:</label><span style="color: red;">*</span><br>
			<span>Horário de início do evento.</span><br>
		 	<select name="horaIni"  id="horaIniRe">
		 	<?php
		 	
		 	if($select == true){
	 			$hora = explode(":", $select[0]['entrada']);
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
	
		 	<br><br>
		 	<label>Fim:</label><span style="color: red;">*</span><br>
		 	<span>Horário de término do evento.</span><br>
		 	<select name="horaFim" id="horaFimRe">
		 	<?php

		 	if($select == true){
	 			$hora = explode(":", $select[0]['saida']);
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
		 	<br><br><br>
			<label>Responsável:</label><span style="color: red;">*</span><br>
			<span>O Responsável pelo evento, ex: Nome do(a) Palestrante</span>
			<input type="text" id="responsavelRe" value="<?php echo GetPost('responsavel'); ?>" name="responsavel" placeholder="Digite o responsável pelo evento">
			
			<br><br><br>
			<label>Destinado:</label><span style="color: red;">*</span><br>
			<span>O público para o qual o evento é direcionado, Ex: Público aberto, Pós Graduação, Doutorado.</span>
			<input type="text" id="destinadoRe" value="<?php echo GetPost('destinado'); ?>" name="destinado" placeholder="Digite a quem é destinado o evento">
		
			<br><br><br>
			<label>Descrição:</label><span style="color: red;">*</span><br>
			<span>Uma breve descrição do que se trata o evento.</span><br>
			<textarea name="desc"><?php echo GetPost('desc'); ?></textarea>

			<br><br><br>
				<label>Cor:</label><span style="color: red;">*</span><br>
				<input type="color" id="corRe" value="#a93b3b" name="cor">
				<br><br><br>
				<input type="submit" name="enviar" value="Enviar">
			
		</form>
	</div>
<?php		
	}else{

?>
<h3>Área de Acesso</h3>
<form action="" method="get">
	<label style="color: #069;"><strong>Chave:</strong></label><span style="color: red;"> *</span><br>
	<input type="text" name="cpf" id="cpf"  placeholder="Digite sua chave" value="<?php if(isset($_GET['user'])){ echo $_GET['user'];} ?>"> 
	<br><br>
</form>

<?php 
	}
?>