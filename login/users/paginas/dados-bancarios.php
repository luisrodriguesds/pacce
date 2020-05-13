<?php 
	$form = DBread('dados_bancarios', "WHERE npacce = '".$user['npacce']."'");
	$form = $form[0];

	if (isset($_POST['enviar'])) {
		$form['npacce'] 	= $user['npacce'];
		$form['cpf'] 		= $user['cpf'];

		$form['banco'] 		= GetPost('banco');
		$form['agencia'] 	= GetPost('agencia');
		$form['conta'] 		= GetPost('conta');
		$form['operacao'] 	= GetPost('operacao');
		$form['status']		= 1;
		$form['registro']	= date('Y-m-d H:i:s');

		if ($form['banco'] == "1") {
			echo '<script>alert("Selecione um banco!");</script>';
		}elseif (empty($form['agencia'])) {
			echo '<script>alert("Digite sua Agência!");</script>';
		}elseif (empty($form['conta'])) {
			echo '<script>alert("Digite sua Conta Corrente!");</script>';
		}else{

			if (DBread('dados_bancarios', "WHERE npacce = '".$user['npacce']."'")) {
				if (DBUpDate('dados_bancarios', $form, "npacce = '".$user['npacce']."'")) {
					echo '
	                 <script>
	                  alert("Dados alterados com sucesso!! \n\n\n Você pode alterar seus dados Bancários quando quiser, não esqueça de sempre mantê-los atualizados!!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
				}
			}else{
				if (DBcreate('dados_bancarios', $form)) {
					echo '
	                 <script>
	                  alert("Dados alterados com sucesso!! \n\n\n Você pode alterar seus dados Bancários quando quiser, não esqueça de sempre mantê-los atualizados!!");
	                    window.location="'.$way.'/'.$url[1].'";
	                  </script>';
				}
			}
		}
	}
?>

<div class="title"><h2>Dados Bancários</h2></div>
<div class="form center">
	<form method="post">
		<label>Banco</label> <span style="color: red;"> *</span>
		<br>
		<p>Somente conta corrente</p>

		<select name="banco">
			<option value="1">Selecione um banco...</option>
			<option value="BB" <?php echo printSelect($form['banco'], 'BB'); ?>>BANCO DO BRASIL S.A.</option>
			<option value="Bradesco" <?php echo printSelect($form['banco'], 'Bradesco'); ?>>BANCO BRADESCO S.A.</option>
			<option value="Itaú" <?php echo printSelect($form['banco'], 'Itaú'); ?>>BANCO ITAU S.A.</option>
			<option value="Caixa" <?php echo printSelect($form['banco'], 'Caixa'); ?>>CAIXA ECONOMICA FEDERAL</option>
			<option value="Santander"<?php echo printSelect($form['banco'], 'Santander'); ?>>BANCO SANTANDER DO BRASIL S/A</option>
			<option value="Banco Inter"<?php echo printSelect($form['banco'], 'Banco Inter'); ?>>BANCO INTER S/A</option>
		</select>
		<br><br><br>
		<label>Agência</label> <span style="color: red;"> *</span>
		<br>
		<p>Com a mesma pontuação que se encontra em seu cartão, <span style="color: red;">NÃO ESQUEÇA NENHUM DÍGITO</span></p>
		<input type="text" name="agencia" autocomplete="off" value="<?php echo $form['agencia']; ?>" placeholder="Digite sua agência como está no cartão">
		<br><br><br>
		<label>Conta Corrente</label> <span style="color: red;"> *</span>
		<br>
		<p>Com a mesma pontuação que se encontra em seu cartão, <span style="color: red;">NÃO ESQUEÇA NENHUM DÍGITO</span></p>
		<input type="text" name="conta" autocomplete="off" value="<?php echo $form['conta']; ?>" placeholder="Digite sua conta corrente como está no cartão">
		<br><br><br>
		<label>Operação</label>
		<br>
		<p>Caso houver</p>
		<input type="text" name="operacao" autocomplete="off" value="<?php echo $form['operacao']; ?>" placeholder="Digite sua operação(Campo não obrigatório)">
		<br><br>
		<center>
			<input type="submit" name="enviar" value="Enviar">
		</center>

	</form>

</div>