<?php
	if (isset($_GET['confirm'])) {
		$confirm = DBescape($_GET['confirm']);
		$cpf = DBescape($_GET['cpf']);
		$v = DBread('bolsistas', "WHERE cpf = '".$cpf."'");
		if ($v == false) {
			echo '
             <script>
             	alert("Correu um erro, tente novamente!!");
                window.location="'.URLBASE.'confirmacao";
              </script>';
		}else{
			$c = DBread('sl_aprovados', "WHERE cpf = '".$cpf."'");
			if ($c == false) {
				echo '
	             <script>
	             	alert("Sua participação na seleção não foi completa, procure a coordenação do programa!");
	                window.location="'.URLBASE.'confirmacao";
	              </script>';
			}else{
				if ($c[0]['situacao'] == 'aprovado') {
					$form['situacao'] = 'efetivo';
				}else{
	            	$form['situacao'] = 'voluntario';
				}
			}
			
			if ($confirm == 1) {
				$form['confirm'] = 'sim';
			}else{
				$form['confirm'] = 'nao';
			}
			
			$v = $v[0];
			$form['npacce'] = $v['npacce'];
			$form['cpf'] = $v['cpf'];
			$form['nome'] = $v['nome'];
			$form['status'] = 1;
			$form['registro'] = date('Y-m-d H:i:s');

			if (DBread('sl_confirm', "WHERE cpf = '".$cpf."'")) {
				echo '
	             <script>
	             	alert("Você já se manisfetou!!!");
	                window.location="'.URLBASE.'confirmacao";
	              </script>';
			}else{
				if ($form['confirm'] == 'sim') {
					$confirm = '';
				}else{
					$confirm = 'NÃO';
				}
				if (DBcreate('sl_confirm', $form)) {
					echo '
		             <script>
		             	alert("'.$form['nome'].' '.$confirm.' manisfetou interesse em participar do programa como '.$form['situacao'].'");
		                window.location="'.URLBASE.'confirmacao";
		              </script>';	
				}

			}
		}
	}

	if (isset($_POST['enviar'])) {
		$form['cpf'] = GetPost('cpf');
		$v = DBread('bolsistas', "WHERE cpf = '".$form['cpf']."'", 'npacce');
		if ($v == false) {
			echo '<script type="text/javascript"> alert("Você não foi encontrado(a) em nossa base de dados!!");</script>';
		}else{
			
			$c = DBread('sl_aprovados', "WHERE cpf = '".$form['cpf']."'");

			if ($c == false) {
				echo '
	             <script>
	             	alert("Sua participação na seleção não foi completa, procure a coordenação do programa!");
	                window.location="'.URLBASE.'confirmacao";
	              </script>';
				
			}else{
				if ($c[0]['situacao'] == 'aprovado') {
					
					echo '
				 <script>
                 	if (confirm("Você deseja manifestar interesse em participar do programa como EFETIVO?\n\n\n !!Anteção!! \n\n\n Para SIM clique em Ok e para NÃO clique em Cancelar ")){
                 		 window.location="'.URLBASE.'confirmacao?confirm=1&&cpf='.$form['cpf'].'";	
                 	}else{
                 		window.location="'.URLBASE.'confirmacao?confirm=0&&cpf='.$form['cpf'].'";	
                 	}
                   
                  </script>
				';
				}else{

					echo '
					 <script>
	                 	if (confirm("Você deseja manifestar interesse em participar do programa como VOLUNTÁRIO?\n\n\n !!!!!!!!!!!!!!!!!!!!!!!ATENÇÃO!!!!!!!!!!!!!!!!!!!! \n\n\n Para SIM clique em Ok e para NÃO clique em Cancelar")){
	                 		 window.location="'.URLBASE.'confirmacao?confirm=1&&cpf='.$form['cpf'].'";	
	                 	}else{
	                 		window.location="'.URLBASE.'confirmacao?confirm=0&&cpf='.$form['cpf'].'";	
	                 	}
	                  </script>
					';

				}
				
			}
		}
	}


	/*if (isset($_POST['confirmar'])) {
		$cpf = GetPost('cpf');
		$check = DBread('bolsistas', "WHERE cpf = '".$cpf."' LIMIT 1");
		if ($check == false) {
			echo '
		             <script>
		             	alert("Você não foi encontrado em nossa base de dados");
		                window.location="'.URLBASE.'confirmacao";
		              </script>';	
		}else{
			$check = $check[0];
			$res = DBread('ren_insc', "WHERE npacce = '".$check['npacce']."' AND confirm = 0");
			if ($res == false) {
				echo '
		             <script>
		             	alert("Você já manisfeteu interesse");
		                window.location="'.URLBASE.'confirmacao";
		              </script>';	
			}else{
				$up['confirm'] = 1;
				if (DBUpDate('ren_insc', $up, "npacce = '".$check['npacce']."'")) {
					echo '
		             <script>
		             	alert("Parabéns, '.$check['nome'].', você confirmou a sua continuação no processo seletivo PACCE 2018 com a primeira opção: '.$res[0]['funcao1'].' e a segunda opção: '.$res[0]['funcao2'].'");
		                window.location="'.URLBASE.'confirmacao";
		              </script>';
				}
			}
		}
	}
	*/
?>
<div id="PageHeader">
	<h2>Confirmação</h2>
</div>

<?php 
	$painel  = DBread('painel', "WHERE nome = 'confirm' AND chave = true");
	if ($painel == false) {
		?>
		<h2 style="color: red;">Fora do periodo de confirmação, qualquer dúvida, por favor procurar a direção do PACCE</h2>
		<?php
	}else{


?>
<strong>
	<p style="font-size: 14px;"> <!-- Confirmação de Veteranos --> Se deseja manifestar interesse em participar do programa nesse ano basta digitar seu CPF.
	Lembrando que o participante pode ser efetivado a qualquer momento dependendo da disponibilidade de vagas no Programa.</p>
</strong>
<script type="text/javascript">
	$(function(){
		$('#cpf').mask("999.999.999-99");
	});
</script>
<div>
	<form method="post">
		<label style="color: #069;"><strong>CPF:</strong></label><br>
		<input type="text" name="cpf" id="cpf" value="<?php echo GetPost('cpf'); ?>" placeholder="Digite seu CPF" autocomplete="off">
		<br><br>
		<input type="submit" name="enviar" value="Confirmar">

	</form>
</div>
<?php 

}
?>