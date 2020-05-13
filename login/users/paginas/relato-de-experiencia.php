
<div class="title"><h2>Relato de Experiência</h2></div>
<p>Aqui você deve contar ao Programa de Aprendizagem Coperativa em Células Estudantis como foram suas experiências 
em relação às atividades do programa.</p>
<br>
<br>
<?php 
	if (isset($url[2]) && $url[2] != '') {
		// $sem[1] = date('Y').'.1';
		// $sem[2] = date('Y').'.2';
		$sem[1] = '2019.1';
		$sem[2] = '2019.2';
		$sem[3] = 'ExpoPACCE';
		if ($url[2] != $sem[1] && $url[2] != $sem[2] && $url[2] != $sem[3]) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
		}else{
			$relato = DBread('relato', "WHERE npacce = '".$user['npacce']."' AND semestre = '".$url[2]."'");
			if (isset($_POST['enviar'])) {
				$form['npacce']		= $user['npacce'];
				$form['situacao']	= 0;
				$form['semestre']	= $url[2];
				$form['status']		= 1;
				$form['registro']	= date('Y-m-d H:i:s');
				$form['relato']		= str_replace("'", "", $_POST['relato']);
				if ((empty($form['relato']) || strlen($form['relato']) < 5000) && $url[2] != "ExpoPACCE")  {
					
					echo '<script>alert("Caracteres insuficientes");</script>';
				
				}else if (empty($form['relato']) || strlen($form['relato']) < 2000){
					echo '<script>alert("Caracteres insuficientes");</script>';
				}else{
					if ($relato == false) {
						if (DBcreate('relato', $form)) {
							echo ' <script>
			                  alert("Relato enviado com sucesso! Lembrando que você pode editá-lo qualquer momento.");
			                    window.location="'.$way.'/'.$url[1].'";
			                  </script>';
						}
					}else{
						if (DBUpDate('relato', $form,"npacce = '".$user['npacce']."' AND semestre = '".$url[2]."'")) {
							echo '<script>
			                  alert("Relato editado com sucesso! Lembrando que você pode editá-lo qualquer momento.");
			                    window.location="'.$way.'/'.$url[1].'";
			                  </script>';
						}
					}
				}
			}

			?>
			<div class="title"><h2>Relato de Experiência referente à <?php echo $url[2]; ?> </h2></div>
			<div id="editar-ativ" class="form">
			<p>
			<?php 
			if ($url[2] == $sem[1]) {
			?>
					Use este modelo para escrever seu relato de experiência referente à <?php echo $url[2]; ?>. Esse é o momento para você nos contar como foi sua experiência durante o primeiro semestre de <?php echo date('Y'); ?> como bolsista da Aprendizagem Cooperativa. No seu relato, você deve abordar os seguintes assuntos: 
					<br>
					<br>• Seu sentimento ao participar da Seleção; 
					<br>• Seu sentimento ao participar dos Encontros Universitários (Edição 2016); 
					<br>• Participação nas formações; 
					<br>• Participação com o Apoio a Célula;
					<br>• Participação nas Rodas Vivas e a apreciação das histórias de vida;
					<br>• Participação nas Interações; 
					<br>• Participação nas Reuniões Gerais; 
					<br>• Desenvolvimento do seu projeto (célula, comissão ou outro); 
					<br>• Resultados alcançados ao longo do semestre;
					<br>• Sua experiência com os objetivos do programa; 
					<br>• Em sua função no PACCE, o que você poderia dizer sobre seu aproveitamento e aprendizagem (articulador, comissão etc.); 
					<br><br>
					Escreva um texto dissertativo e evite usar tópicos apenas. Procure identificar seus sentimentos ao participar de cada uma das atividades. Faça parágrafos, use a letra Times New Roman, tamanho 12. A quantidade mínima é de 2 laudas (5000 caracteres), pode ser mais. Use um editor como o Word para ter o número de caracteres como também uma cópia.
					<br>
					</p>
			<?php 
			}else if ($url[2] == $sem[2]) {
			?>
					<p>Use este modelo para escrever seu relato de experiência referente à <?php echo $url[2]; ?>. Esse é o momento para você nos contar como foi sua experiência durante o segundo semestre de <?php echo date('Y');?> como bolsista da Aprendizagem Cooperativa. No seu relato, você deve abordar os seguintes assuntos: 
					<br>
					<br>• Seu sentimento ao participar da Semana de Julho; 
					<br>• Seu sentimento ao participar da Feira das Profissões;
					<br>• Seu sentimento ao participar dos Encontros Universitários;
					<br>• Seu sentimento ao participar da Semana de Dezembro;
					<br>• Participação nas formações; 
					<br>• Participação nas Interações; 
					<br>• Participação nas Reuniões Gerais; 
					<br>• Desenvolvimento do seu projeto (célula, comissão ou outro); 
					<br>• Participação com o Apoio a Célula; 
					<br>• Como foi a experiência com a apreciação de memoriais e com o autor do memorial; 
					<br>• Resultados alcançados ao longo do semestre; 
					<br>• Sua experiência com os objetivos do programa; 
					<br>• Em sua função no PACCE, o que você poderia dizer sobre seu aproveitamento e aprendizagem (articulador, comissão etc.); 
					<br><br>
					Escreva um texto e evite usar tópicos apenas. Faça parágrafos, use a letra Times New Roman, tamanho 12. A quantidade mínima é de 2 laudas (5000 caracteres), pode ser mais. Use um editor como o Word para ter o número de caracteres como também uma cópia.</p>
			<?php
			}else {
			?>
					<p>Use este modelo para escrever seu relato de experiência referente à <?php echo $url[2]; ?>. Esse é o momento para você nos contar como foi sua experiência durante o evento realizado em <?php echo date('Y');?> como bolsista da Aprendizagem Cooperativa. 
					<br>
					Escreva um texto e evite usar tópicos apenas. Faça parágrafos, use a letra Times New Roman, tamanho 12. A quantidade mínima é de 2000 caracteres, pode ser mais. Use um editor como o Word para ter o número de caracteres como também uma cópia.</p>
			<?php
			}
			?>
			<script type="text/javascript">
				$(function(){
					contador('#relato', '#destino', 5000, 1000000, '#contaRelato');
					function contador(seletorConta, seletorDestino, min, max, seletorValor){
						$(seletorConta).keyup(function(event) {
			        		var conta = $(seletorConta).val().length;
			        		var texto = $(seletorConta).val();
			        		
			        		$(seletorValor).attr('value', conta);

			        		if (conta <= 1) {
			        			$(seletorDestino).empty().html(conta + " caracter");
			        			if (conta >= max) { 
			           	 			var new_text = texto.substr(0, max);
						            $(seletorConta).val(new_text); 
			        			}
			        			if (conta < min){
			        				$(this).css({
			        					borderBottom: '1px red solid'
			        				});
			        			}else{
			        				$(this).css({
			        					borderBottom: '1px #069 solid'
			        				});
			        			}
			        		}else{
			        			if (conta >= max) { 
			           	 			var new_text = texto.substr(0, max);
						            $(seletorConta).val(new_text); 
			        			}
			        			if (conta < min){
			        				$(this).css({
			        					borderBottom: '1px red solid'
			        				});
			        			}else{
			        				$(this).css({
			        					borderBottom: '1px #069 solid'
			        				});
			        			}
			        			$(seletorDestino).empty().html(conta + <?php if ($url[2] == $sem[3]) { echo '"/2000 caracteres"';} else { echo '"/5000 caracteres"'; } ?>);
			        			
			        		}
			        	});
					}
				});
			</script>
			<br><br>
		 	<form action="" method="post" enctype="multipart/form-data">
		 		Meu Relato:<span style="color:red"> * </span><br>
		 		<textarea name="relato" id="relato"><?php if($relato == true){ echo $relato[0]['relato']; }else if(isset($_POST['relato'])){ echo $_POST['relato'];} ?></textarea>
		 		<input type="hidden" id="contaRelato" name="">
		 		<span style="color:red;" id="destino">
		 		<?php 
		 		if ($url[2] == $sem[3]) {
		 			echo "2000 caracteres";
		 		} else {
		 			echo "5000 caracteres";
		 		}
		 		?>
		 		
		 		</span>
		 		<br><br>
		 		<center>
		 		<input type="submit" value="Enviar" name="enviar">
		 		</center>
		 	</form>
		 </div>
			<?php
		}
	}else{

?>
<div class="title"><h2><a href="<?php echo $way.'/'.$url[1].'/2019.1'; ?>">Relato Referente à <?php echo date('Y').'.1'; ?></a></h2></div>
<br>
<div class="title"><h2><a href="<?php echo $way.'/'.$url[1].'/2019.2'; ?>">Relato Referente à <?php echo date('Y').'.2'; ?></a></h2></div>
<br>
<div class="title"><h2><a href="<?php echo $way.'/'.$url[1].'/ExpoPACCE'; ?>">Relato Referente à ExpoPACCE <?php echo date('Y');?></a></h2></div>
<br>


<br>
<div class="title"><h2>Relatos produzidos</h2></div>
<?php 
 $relato = DBread('relato', "WHERE npacce = '".$user['npacce']."'");
 if ($relato == false) {
 	echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
 }else{
?>
<div class="tabela">
	<table>
		
			<tr>
				<th>Tipo</th>
				<th>Semestre</th>
				<th>Situação</th>
				<th>Registro</th>
			</tr>
			<?php
				for ($i=0; $i < count($relato); $i++) { 
			 ?>
			<tr>
				<td>Relato de Experiência</td>
				<td><?php echo $relato[$i]['semestre']; ?></td>
				<td><?php if( $relato[$i]['situacao'] == 0){ echo "Em análise"; }else if($relato[$i]['situacao'] == 1){ echo "Relato aprovado!";}else{ echo "Precisa ser refeito";} ?></td>
				<td><?php echo date('d/m/Y', strtotime($relato[$i]['registro'])); ?></td>
			</tr>
		<?php } ?>
	</table>
</div>
<?php }
}?>