<script src='https://www.google.com/recaptcha/api.js'></script>



<div id="PageHeader">
	<h2>Autenticação de Documentos</h2>
</div>

<?php 
if (isset($url[1]) && $url[1]) {
	if ($url[1] == 'declaracao-simples') {
		$modo = "Declaração Simples";
	}else if ($url[1] == 'declaracao-de-efetivo') {
		$modo = "Declaração de Efetivo";
	}else if ($url[1] == 'relatorio-individual') {
		$modo = "Relatório Individual";
	}else{
		echo '<script>
		alert("Nada encontrado");
		window.location="'.URLBASE.'"</script>';
	}
	
	?>
	<style type="text/css">
		label{ font-size: 12px; font-weight: 600; }
		input[type=submit]:hover{background: #4d6a79;}
	</style>
	<h2><?php echo $modo; ?></h2>
	<?php 
		if (isset($_GET['cod']) && $_GET['cod'] != '') {
			$cod = DBescape($_GET['cod']);
			$check = DBread('cod_verifica', "WHERE codigo = '".$cod."'");
			if ($check == true) {
				$check = $check[0];
				if (date('Y-m-d') > date('Y-m-d', strtotime('+6 month', strtotime($check['registro'])))) {
					echo 'Certificação Expirado';
				}else{
					?>
					<div id="" style="width: 80%; margin: 0 auto; border: 2px solid #94da95; background: #cfffd0; text-align: center; padding: 30px; color: #000; font-size: 18px; font-weight: 600; font-style: italic; ">
						<center>
							<img src="<?php echo URL_PAINEL.'imagens/autenticacao.gif'; ?>">
						</center>
						<br>
					Documento válido e emitido pelo SIGAP - PACCE!
					</div>
					
					<?php
				}
				?>
				<?php
			}else{

			}
		}else{
			   

			if (isset($_POST['verificar'])) {
				$form['matricula'] 	= GetPost('matricula');
				$form['data'] 		= GetPost('data');
				$form['cod'] 		= GetPost('cod');
				if (empty($form['matricula'])) {
					echo '<script>alert("Campo matrícula está vazio!");</script>';
				}else if (empty($form['data'])) {
					echo '<script>alert("Campo data da emissão está vazio!");</script>';
				}else if (empty($form['cod'])) {
					echo '<script>alert("Campo código de verificação está vazio!");</script>';
				}else{
					$check = DBread('cod_verifica', "WHERE codigo = '".$form['cod']."' AND matricula = '".$form['matricula']."' AND dataEmissao = '".$form['data']."'");
					if ($check == false) {
						echo '<script>alert("Nada encontrado");</script>';
					}else{
						echo '<script>				
							window.location="'.URLBASE.'/'.$url[0].'/'.$url[1].'?cod='.$form['cod'].'"</script>';
					}
				}
			}
	?>
	<form method="post">
		<label>Matrícula:</label><br>
		<input type="text" name="matricula" value="<?php echo GetPost('matricula'); ?>" placeholder="Digite sua Matrícula">
		<br><br>
		<label>Data da emissão:</label><br>
		<input type="date" name="data" value="<?php echo GetPost('data'); ?>" placeholder="Digite sua Matrícula" style="background: #f3f3f3; border: solid 1px #ddd; padding: 6px 10px; border-radius: 5px; width: 36%;-webkit-appearance: none;-webkit-border-radius: 5px; -moz-border-radius: 5px;">
		<br><br>
		<label>Código de Verificação:</label><br>
		<input type="text" name="cod" value="<?php echo GetPost('cod'); ?>" placeholder="Digite o código de Verificação">
		<br><br>
		<div 
		class="g-recaptcha"
		data-sitekey="6LdSOhcUAAAAABplxyjJ8ndcqEPxBZXhwcVqMK-Y"
		data-callback="YourOnSubmitFn">

		</div>

		<br>
		<input type="submit" name="verificar" value="Verificar">
	</form>
	<?php
	}
}else{

?>
<h2><img src="<?php echo URL_PAINEL ?>imagens/confirm.png" style="width: 20px;"> <a href="<?php echo URLBASE.'pdf/cc-2019.pdf'; ?>" target="_blank">Contrato de Convivência</a></h2>

<h2><img src="<?php echo URL_PAINEL ?>imagens/confirm.png" style="width: 20px;"> <a href="<?php echo URLBASE.$url[0]; ?>/declaracao-simples">Declaração Simples</a></h2>

<h2><img src="<?php echo URL_PAINEL ?>imagens/confirm.png" style="width: 20px;"> <a href="<?php echo URLBASE.$url[0]; ?>/declaracao-de-efetivo">Declaração de Efetivo</a></h2>

<h2><img src="<?php echo URL_PAINEL ?>imagens/confirm.png" style="width: 20px;"> <a href="<?php echo URLBASE.$url[0]; ?>/relatorio-individual">Relatório Individual</a></h2>
<div id="PageHeader">
	<h2>Pedidos de Documentos</h2>

	<h2><img src="<?php echo URL_PAINEL ?>imagens/confirm.png" style="width: 20px;"> <a href="https://docs.google.com/forms/d/e/1FAIpQLScPfzjwDlGumMGoHsZlC_5cPZL5h1YoV37EFs-uC6cTzbS86Q/viewform" target="_blank">Link</a></h2>
	<br>
	<h2>Editais</h2>
	<h2><img src="<?php echo URL_PAINEL ?>imagens/confirm.png" style="width: 20px;"> <a href="http://sysprppg.ufc.br/eu/2017/Documentos/edital-eu2017-ac.pdf" target="_blank">Encontros Universitários 2017</a></h2>
</div>
<?php 
}
?>