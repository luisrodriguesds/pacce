<style type="text/css">
	.autoav td{ border-bottom: 1px #a2a2a2 solid; border-collapse:collapse; padding: 3px;}
	
</style>
<div class="title"><h2>Seleção <?php echo date('Y') ?></h2></div>
<p>Página destinada a renovação da bolsa para <?php echo date('Y') ?></p>
<br>

<?php 
	

	if (isset($_GET['formulario'])) {
		$veterano = DBread('ren_insc', "WHERE npacce = '".$user['npacce']."'", "id");
		if ($veterano == true) {
				echo '
                 <script>
                  alert("Você já preenchei esse formulário");
                    window.location="'.$way.'/'.$url[1].'";
                  </script>';
		}

		$npacce   = substr($user['npacce'], 0, 3);
		$npacceAt = 'B'.date('y');
		
		if (isset($_POST['enviar'])) {
			$form['npacce']			= $user['npacce'];
			$email['email'] 		= GetPost('email');
			$form['justificativa'] 	= GetPost('justificativa');

			$form['funcao1'] 		= GetPost('funcao1');
			$form['funcao2'] 		= GetPost('funcao2');
			
			$form['At1'] 			= GetPost('At1');
			$form['At2'] 			= GetPost('At2');
			$form['At3'] 			= GetPost('At3');
			$form['At4'] 			= GetPost('At4');
			$form['At5'] 			= GetPost('At5');
			$form['At6'] 			= GetPost('At6');
			$form['At7'] 			= GetPost('At7');
			$form['At8'] 			= GetPost('At8');

			$form['campus']			= $user['campusSlug'];
			$form['status']			= 1;
			$form['registro']		= date('Y-m-d H:i:s');

			if (empty($email['email'])) {
				echo '<script>alert("Campo email está vazio"); </script>';
			}else if (empty($form['justificativa'])) {
				echo '<script>alert("Campo justificativa ou está vazio ou excedeu o total permitido"); </script>';
			}else if($form['funcao1'] == 1){
				echo '<script>alert("Campo Função I está vazio");</script>';
			}else if($form['funcao2'] == 1){
				echo '<script>alert("Campo Função II está vazio");</script>';
			}else if($form['funcao1'] == $form['funcao2']){
				echo '<script>alert("Campo Função I  e Campo Função II são Iguais");</script>';
			}else if (empty($form['At1'])) {
				echo '<script>alert("Existe item no campo Atividades da Bolsa que está vazio"); </script>';
			}else if (empty($form['At2'])) {
				echo '<script>alert("Existe item no campo Atividades da Bolsa que está vazio"); </script>';
			}else if (empty($form['At3'])) {
				echo '<script>alert("Existe item no campo Atividades da Bolsa que está vazio"); </script>';
			}else if (empty($form['At4'])) {
				echo '<script>alert("Existe item no campo Atividades da Bolsa que está vazio"); </script>';
			}else if (empty($form['At5'])) {
				echo '<script>alert("Existe item no campo Atividades da Bolsa que está vazio"); </script>';
			}else if (empty($form['At6'])) {
				echo '<script>alert("Existe item no campo Atividades da Bolsa que está vazio"); </script>';
			}else if (empty($form['At7'])) {
				echo '<script>alert("Existe item no campo Atividades da Bolsa que está vazio"); </script>';
			}else if (empty($form['At8'])) {
				echo '<script>alert("Existe item no campo Atividades da Bolsa que está vazio"); </script>';
			}else{
				if ($npacce == $npacceAt) {
					
					$form['Cel1'] 			= GetPost('Cel1');
					$form['Cel2'] 			= GetPost('Cel2');
					$form['Cel3'] 			= GetPost('Cel3');
					$form['Cel4'] 			= GetPost('Cel4');
					
										
					$form['Rod1'] 			= GetPost('Rod1');
					$form['Rod2'] 			= GetPost('Rod2');
					$form['Rod3'] 			= GetPost('Rod3');
					
					$form['For1'] 			= GetPost('For1');
					$form['For2'] 			= GetPost('For2');
					$form['For3'] 			= GetPost('For3');

					$form['Int11']			= GetPost('Int1');
					$form['Int22']			= GetPost('Int2');
					$form['Int33']			= GetPost('Int3');
					$form['Int44']			= GetPost('Int4');

					//Articulador
					if (empty($form['Cel1'])) {
						echo '<script>alert("Existe item no campo Célula que está vazio"); </script>';
					}else if (empty($form['Cel2'])) {
						echo '<script>alert("Existe item no campo Célula que está vazio"); </script>';
					}else if (empty($form['Cel3'])) {
						echo '<script>alert("Existe item no campo Célula que está vazio"); </script>';
					}else if (empty($form['Cel4'])) {
						echo '<script>alert("Existe item no campo Célula que está vazio"); </script>';
					}else if (empty($form['For1'])) {
						echo '<script>alert("Existe item no campo Formação que está vazio"); </script>';
					}else if (empty($form['Int11'])) {
						echo '<script>alert("Existe item no campo Interação que está vazio"); </script>';
					}else if (empty($form['Int22'])) {
						echo '<script>alert("Existe item no campo Interação que está vazio"); </script>';
					}else if (empty($form['Int33'])) {
						echo '<script>alert("Existe item no campo Interação que está vazio"); </script>';
					}else if (empty($form['Int44'])) {
						echo '<script>alert("Existe item no campo Interação que está vazio"); </script>';
					}else if (empty($form['For2'])) {
						echo '<script>alert("Existe item no campo Formação que está vazio"); </script>';
					}else if (empty($form['For3'])) {
						echo '<script>alert("Existe item no campo Formação que está vazio"); </script>';
					}else if (empty($form['Rod1'])) {
						echo '<script>alert("Existe item no campo Históriade vida que está vazio"); </script>';
					}else if (empty($form['Rod2'])) {
						echo '<script>alert("Existe item no campo Históriade vida que está vazio"); </script>';
					}else if (empty($form['Rod3'])) {
						echo '<script>alert("Existe item no campo Históriade vida que está vazio"); </script>';
					}else{
						if (DBcreate('ren_insc', $form)) {
							if (DBUpDate('bolsistas', $email, "npacce = '".$user['npacce']."'")) {
						
									echo '
				                 <script>
				                  alert("Formulário enviado com sucesso!");
				                    window.location="'.$way.'/'.$url[1].'";
				                  </script>';
								
							}
						}
					}
						
				}else{
					$form['Com1'] 			= GetPost('Com1');
					$form['Com2'] 			= GetPost('Com2');
					$form['Com3'] 			= GetPost('Com3');
					$form['Com4'] 			= GetPost('Com4');
					$form['Com5'] 			= GetPost('Com5');
					$form['Com6'] 			= GetPost('Com6');
					//Comissao
					if (empty($form['Com1'])) {
						echo '<script>alert("Existe item no campo Comissão que está vazio"); </script>';
					}else if (empty($form['Com2'])) {
						echo '<script>alert("Existe item no campo Comissão que está vazio"); </script>';
					}else if (empty($form['Com3'])) {
						echo '<script>alert("Existe item no campo Comissão que está vazio"); </script>';
					}else if (empty($form['Com4'])) {
						echo '<script>alert("Existe item no campo Comissão que está vazio"); </script>';
					}else if (empty($form['Com5'])) {
						echo '<script>alert("Existe item no campo Comissão que está vazio"); </script>';
					}else if (empty($form['Com6'])) {
						echo '<script>alert("Existe item no campo Comissão que está vazio"); </script>';
					}else{
							if (DBcreate('ren_insc', $form)) {
								if (DBUpDate('bolsistas', $email, "npacce = '".$user['npacce']."'")) {
									echo '
					                 <script>
					                  alert("Formulário enviado com sucesso!");
					                    window.location="'.$way.'/'.$url[1].'";
					                  </script>';
								}
							}
						}
					}
			}
		} 
		

	?>
		<div class="form center">
			<form method="post">
				<h2>SELEÇÃO PACCE 2017</h2>
				<br>

				<label>Email</label><span style="color: red;">*</span>
				<p>Confirme seu email</p><br>
				<input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">
				<br><br><br><br>
				<script type="text/javascript">
					$(function(){
						$('#justificativa').keyup(function(event) {
							var just = $(this).val().length;
							var justText = $(this).val();
							$('#contagem').html(just + " de 500 caracteres");
						});
					});
				</script>
				<label>Justificativa</label><span style="color: red;">*</span>
				<p>Justifique sua renovação da bolsa em termos de ações desenvolvidas durante o ano em que você foi bolsista. No máximo 500 caracteres</p>
				<textarea name="justificativa" id="justificativa"></textarea>
				<span style="color: red;" id="contagem"></span>
				<br><br><br><br>

				<label>Função I</label><span style="color: red;">*</span>
				<p>Escolha sua primeira opção para a qual você quer renovar.</p><br>
				
				<select id="funcao1" name="funcao1">
					<option value="1">Selecione...</option>
					<option value="apoio-a-celula">Apoio à Célula</option>
					<option value="apoio-interno"> Apoio Interno</option>
					<option value="apoio-tecnico">Apoio Técnico </option>
					<option value="avaliacao"> Avaliação</option>
					<option value="comunicacao"> Comunicação e Marketing</option>
					<option value="formacao">Formação </option>
					<option value="historia-de-vida"> História de Vida</option>
					<option value="interacao"> Interação</option>
					<option value="articulador-de-projetos"> Articulador de Projetos</option>
				</select>
				<br><br><br><br>
				<label>Função II</label><span style="color: red;">*</span>
				<p>Escolha sua segunda opção para a qual você quer renovar.</p><br>
				<select id="funcao2" name="funcao2">
					<option value="1">Selecione...</option>
					<option value="apoio-a-celula">Apoio à Célula</option>
					<option value="apoio-interno"> Apoio Interno</option>
					<option value="apoio-tecnico">Apoio Técnico </option>
					<option value="avaliacao"> Avaliação</option>
					<option value="comunicacao"> Comunicação e Marketing</option>
					<option value="formacao">Formação </option>
					<option value="historia-de-vida"> História de Vida</option>
					<option value="interacao"> Interação</option>
					<option value="articulador-de-projetos"> Articulador de Projetos</option>
				</select>
				
				<br><br><br><br>
				<label><h1>Autoavaliação</h1></label>
				<p>Agora, como você se avalia durante o tempo em que você participou do Programa?<br>
				Para as frases a seguir, use os critérios abaixo:<br>

				<br>1. Discordo Totalmente
				<br>2. Discordo Parcialmente
				<br>3. Não Concordo e nem Discordo
				<br>4. Concordo Parcialmente
				<br>5. Concordo Totalmente
				</p>
				<?php 
					if ($npacce == $npacceAt || $user['tipoSlug'] == 'ceo') {
			
				?>
				<br><br><br><br>
				<label>Célula</label><span style="color: red;">*</span>
				<p>Como você avalia seu desempenho como bolsista quanto a Célula?</p>
				<br><br>
				
				<table style=" width: 100%; border-collapse:collapse;" class="autoav">
					<tr style="text-align: center;">
						<th></th>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>5</th>
					</tr>
					<tr style="margin-bottom: 20px;">
						<td style="width: 20%;">Cumpri sempre as 4 horas de célula.</td>
						<td > <center><input type="radio" name="Cel1" value="1"> </center></td>
						<td> <center><input type="radio" name="Cel1" value="2"></center> </td>
						<td> <center><input type="radio" name="Cel1" value="3"></center> </td>
						<td> <center><input type="radio" name="Cel1" value="4"></center> </td>
						<td> <center><input type="radio" name="Cel1" value="5"></center> </td>
					</tr>

					<tr>
						<td style="width: 20%;">Alcancei os objetivos propostos pelo meu projeto.</td>
						<td > <center><input type="radio" name="Cel2" value="1"> </center></td>
						<td> <center><input type="radio" name="Cel2" value="2"></center> </td>
						<td> <center><input type="radio" name="Cel2" value="3"></center> </td>
						<td> <center><input type="radio" name="Cel2" value="4"></center> </td>
						<td> <center><input type="radio" name="Cel2" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Os membros da minha célula participaram de forma satisfatória.</td>
						<td > <center><input type="radio" name="Cel3" value="1"> </center></td>
						<td> <center><input type="radio" name="Cel3" value="2"></center> </td>
						<td> <center><input type="radio" name="Cel3" value="3"></center> </td>
						<td> <center><input type="radio" name="Cel3" value="4"></center> </td>
						<td> <center><input type="radio" name="Cel3" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Sempre soube gerenciar conflitos.</td>
						<td > <center><input type="radio" name="Cel4" value="1"> </center></td>
						<td> <center><input type="radio" name="Cel4" value="2"></center> </td>
						<td> <center><input type="radio" name="Cel4" value="3"></center> </td>
						<td> <center><input type="radio" name="Cel4" value="4"></center> </td>
						<td> <center><input type="radio" name="Cel4" value="5"></center> </td>
					</tr>
				</table>
				<br><br><br><br>
				<label>Interação</label><span style="color: red;">*</span>
				<p>Como você avalia seu desempenho como bolsista quanto a Interação?</p>
				<br><br>
				<table style=" width: 100%; border-collapse:collapse;" class="autoav">
					<tr style="text-align: center;">
						<th></th>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>5</th>
					</tr>
					<tr style="margin-bottom: 20px;">
						<td style="width: 20%;">Sempre participava ativamente das Interações.</td>
						<td > <center><input type="radio" name="Int1" value="1"> </center></td>
						<td> <center><input type="radio" name="Int1" value="2"></center> </td>
						<td> <center><input type="radio" name="Int1" value="3"></center> </td>
						<td> <center><input type="radio" name="Int1" value="4"></center> </td>
						<td> <center><input type="radio" name="Int1" value="5"></center> </td>
					</tr>

					<tr>
						<td style="width: 20%;">As interações me ajudaram a criar novos laços de amizades</td>
						<td > <center><input type="radio" name="Int2" value="1"> </center></td>
						<td> <center><input type="radio" name="Int2" value="2"></center> </td>
						<td> <center><input type="radio" name="Int2" value="3"></center> </td>
						<td> <center><input type="radio" name="Int2" value="4"></center> </td>
						<td> <center><input type="radio" name="Int2" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Senti dificuldade em me relacionar com outros bolsistas.</td>
						<td > <center><input type="radio" name="Int3" value="1"> </center></td>
						<td> <center><input type="radio" name="Int3" value="2"></center> </td>
						<td> <center><input type="radio" name="Int3" value="3"></center> </td>
						<td> <center><input type="radio" name="Int3" value="4"></center> </td>
						<td> <center><input type="radio" name="Int3" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Convidei amigos/colegas de curso para participar das Interações.</td>
						<td > <center><input type="radio" name="Int4" value="1"> </center></td>
						<td> <center><input type="radio" name="Int4" value="2"></center> </td>
						<td> <center><input type="radio" name="Int4" value="3"></center> </td>
						<td> <center><input type="radio" name="Int4" value="4"></center> </td>
						<td> <center><input type="radio" name="Int4" value="5"></center> </td>
					</tr>
				</table>
				<br><br><br><br>
				<label>História de Vida</label><span style="color: red;">*</span>
				<p>Como você avalia seu desempenho como bolsista quanto a Apreciação de Memoriais</p>
				<br><br>
				<table style=" width: 100%; border-collapse:collapse;" class="autoav">
					<tr style="text-align: center;">
						<th></th>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>5</th>
					</tr>
					<tr style="margin-bottom: 20px;">
						<td style="width: 20%;">Gostei de ouvir as Histórias dos meus colegas de bolsa.</td>
						<td > <center><input type="radio" name="Rod1" value="1"> </center></td>
						<td> <center><input type="radio" name="Rod1" value="2"></center> </td>
						<td> <center><input type="radio" name="Rod1" value="3"></center> </td>
						<td> <center><input type="radio" name="Rod1" value="4"></center> </td>
						<td> <center><input type="radio" name="Rod1" value="5"></center> </td>
					</tr>

					<tr>
						<td style="width: 20%;">Gostei das ouvir de História de Vida na Formação.</td>
						<td > <center><input type="radio" name="Rod2" value="1"> </center></td>
						<td> <center><input type="radio" name="Rod2" value="2"></center> </td>
						<td> <center><input type="radio" name="Rod2" value="3"></center> </td>
						<td> <center><input type="radio" name="Rod2" value="4"></center> </td>
						<td> <center><input type="radio" name="Rod2" value="5"></center> </td>
					</tr>
					
					<tr>
						<td style="width: 20%;">Acho a Apreciação de História de Vida uma importante forma de conhecer melhor as pessoas.</td>
						<td > <center><input type="radio" name="Rod3" value="1"> </center></td>
						<td> <center><input type="radio" name="Rod3" value="2"></center> </td>
						<td> <center><input type="radio" name="Rod3" value="3"></center> </td>
						<td> <center><input type="radio" name="Rod3" value="4"></center> </td>
						<td> <center><input type="radio" name="Rod3" value="5"></center> </td>
					</tr>
					</table>
					<br><br><br><br>
				<label>Formação</label><span style="color: red;">*</span>
				<p>Como você avalia seu desempenho como bolsista quanto a Formação?</p>
				<br><br>
				<table style=" width: 100%; border-collapse:collapse;" class="autoav">
					<tr style="text-align: center;">
						<th></th>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>5</th>
					</tr>
					<tr style="margin-bottom: 20px;">
						<td style="width: 20%;">Eu me senti pertencente a minha Formação.</td>
						<td > <center><input type="radio" name="For1" value="1"> </center></td>
						<td> <center><input type="radio" name="For1" value="2"></center> </td>
						<td> <center><input type="radio" name="For1" value="3"></center> </td>
						<td> <center><input type="radio" name="For1" value="4"></center> </td>
						<td> <center><input type="radio" name="For1" value="5"></center> </td>
					</tr>

					<tr>
						<td style="width: 20%;">Eu contribui de forma positiva nas Formações.</td>
						<td > <center><input type="radio" name="For2" value="1"> </center></td>
						<td> <center><input type="radio" name="For2" value="2"></center> </td>
						<td> <center><input type="radio" name="For2" value="3"></center> </td>
						<td> <center><input type="radio" name="For2" value="4"></center> </td>
						<td> <center><input type="radio" name="For2" value="5"></center> </td>
					</tr>
					
					<tr>
						<td style="width: 20%;">Eu aprendi a lidar em grupo com as/nas Formações.</td>
						<td > <center><input type="radio" name="For3" value="1"> </center></td>
						<td> <center><input type="radio" name="For3" value="2"></center> </td>
						<td> <center><input type="radio" name="For3" value="3"></center> </td>
						<td> <center><input type="radio" name="For3" value="4"></center> </td>
						<td> <center><input type="radio" name="For3" value="5"></center> </td>
					</tr>

				</table>
				<?php } ?>
				<br><br><br><br>
				<label>Atividades da Bolsa</label><span style="color: red;">*</span>
				<p>Como você avalia seu desempenho como bolsista quanto às Atividades da bolsa (durante o ano)?</p>
				<br><br>
				<table style=" width: 100%; border-collapse:collapse;" class="autoav">
					<tr style="text-align: center;">
						<th></th>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>5</th>
					</tr>
					<tr style="margin-bottom: 20px;">
						<td style="width: 20%;">Eu me identifiquei com as atividades do Programa.</td>
						<td > <center><input type="radio" name="At1" value="1"> </center></td>
						<td> <center><input type="radio" name="At1" value="2"></center> </td>
						<td> <center><input type="radio" name="At1" value="3"></center> </td>
						<td> <center><input type="radio" name="At1" value="4"></center> </td>
						<td> <center><input type="radio" name="At1" value="5"></center> </td>
					</tr>

					<tr>
						<td style="width: 20%;">Procurei ser pontual nos eventos promovidos pelo Programa.</td>
						<td > <center><input type="radio" name="At2" value="1"> </center></td>
						<td> <center><input type="radio" name="At2" value="2"></center> </td>
						<td> <center><input type="radio" name="At2" value="3"></center> </td>
						<td> <center><input type="radio" name="At2" value="4"></center> </td>
						<td> <center><input type="radio" name="At2" value="5"></center> </td>
					</tr>
					
					<tr>
						<td style="width: 20%;">Meus relatórios foram enviados em dia.</td>
						<td > <center><input type="radio" name="At3" value="1"> </center></td>
						<td> <center><input type="radio" name="At3" value="2"></center> </td>
						<td> <center><input type="radio" name="At3" value="3"></center> </td>
						<td> <center><input type="radio" name="At3" value="4"></center> </td>
						<td> <center><input type="radio" name="At3" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Minha contribuição com o Programa.</td>
						<td > <center><input type="radio" name="At4" value="1"> </center></td>
						<td> <center><input type="radio" name="At4" value="2"></center> </td>
						<td> <center><input type="radio" name="At4" value="3"></center> </td>
						<td> <center><input type="radio" name="At4" value="4"></center> </td>
						<td> <center><input type="radio" name="At4" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Por vezes me senti desmotivado com algumas atividades da bolsa.</td>
						<td > <center><input type="radio" name="At5" value="1"> </center></td>
						<td> <center><input type="radio" name="At5" value="2"></center> </td>
						<td> <center><input type="radio" name="At5" value="3"></center> </td>
						<td> <center><input type="radio" name="At5" value="4"></center> </td>
						<td> <center><input type="radio" name="At5" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Acredito que contribui para o crescimento do Programa.</td>
						<td > <center><input type="radio" name="At6" value="1"> </center></td>
						<td> <center><input type="radio" name="At6" value="2"></center> </td>
						<td> <center><input type="radio" name="At6" value="3"></center> </td>
						<td> <center><input type="radio" name="At6" value="4"></center> </td>
						<td> <center><input type="radio" name="At6" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Só fiz aquilo que me foi proposto.</td>
						<td > <center><input type="radio" name="At7" value="1"> </center></td>
						<td> <center><input type="radio" name="At7" value="2"></center> </td>
						<td> <center><input type="radio" name="At7" value="3"></center> </td>
						<td> <center><input type="radio" name="At7" value="4"></center> </td>
						<td> <center><input type="radio" name="At7" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Aprendi com as atividades do Programa.</td>
						<td > <center><input type="radio" name="At8" value="1"> </center></td>
						<td> <center><input type="radio" name="At8" value="2"></center> </td>
						<td> <center><input type="radio" name="At8" value="3"></center> </td>
						<td> <center><input type="radio" name="At8" value="4"></center> </td>
						<td> <center><input type="radio" name="At8" value="5"></center> </td>
					</tr>
				</table>
				<?php 
					if ($npacce != $npacceAt || $user['tipoSlug'] == 'ceo') {
				?>
				<br><br><br><br>
				<label>Comissão</label><span style="color: red;">*</span>
				<p></p>
				<br><br>
				<table style=" width: 100%; border-collapse:collapse;" class="autoav">
					<tr style="text-align: center;">
						<th></th>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>5</th>
					</tr>
					<tr style="margin-bottom: 20px;">
						<td style="width: 20%;">Fiz o que me foi proposto na comissão.</td>
						<td > <center><input type="radio" name="Com1" value="1"> </center></td>
						<td> <center><input type="radio" name="Com1" value="2"></center> </td>
						<td> <center><input type="radio" name="Com1" value="3"></center> </td>
						<td> <center><input type="radio" name="Com1" value="4"></center> </td>
						<td> <center><input type="radio" name="Com1" value="5"></center> </td>
					</tr>

					<tr>
						<td style="width: 20%;">A Comissão cumpriu com o que foi proposto.</td>
						<td > <center><input type="radio" name="Com2" value="1"> </center></td>
						<td> <center><input type="radio" name="Com2" value="2"></center> </td>
						<td> <center><input type="radio" name="Com2" value="3"></center> </td>
						<td> <center><input type="radio" name="Com2" value="4"></center> </td>
						<td> <center><input type="radio" name="Com2" value="5"></center> </td>
					</tr>
					
					<tr>
						<td style="width: 20%;">Estou satisfeito com o desempenho da comissão.</td>
						<td > <center><input type="radio" name="Com3" value="1"> </center></td>
						<td> <center><input type="radio" name="Com3" value="2"></center> </td>
						<td> <center><input type="radio" name="Com3" value="3"></center> </td>
						<td> <center><input type="radio" name="Com3" value="4"></center> </td>
						<td> <center><input type="radio" name="Com3" value="5"></center> </td>
					</tr>

					<tr>
						<td style="width: 20%;">Minha comissão era uma equipe.</td>
						<td > <center><input type="radio" name="Com4" value="1"> </center></td>
						<td> <center><input type="radio" name="Com4" value="2"></center> </td>
						<td> <center><input type="radio" name="Com4" value="3"></center> </td>
						<td> <center><input type="radio" name="Com4" value="4"></center> </td>
						<td> <center><input type="radio" name="Com4" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Fazíamos Processamento de Grupo.</td>
						<td > <center><input type="radio" name="Com5" value="1"> </center></td>
						<td> <center><input type="radio" name="Com5" value="2"></center> </td>
						<td> <center><input type="radio" name="Com5" value="3"></center> </td>
						<td> <center><input type="radio" name="Com5" value="4"></center> </td>
						<td> <center><input type="radio" name="Com5" value="5"></center> </td>
					</tr>
					<tr>
						<td style="width: 20%;">Comemorávamos os resultados alcançados.</td>
						<td > <center><input type="radio" name="Com6" value="1"> </center></td>
						<td> <center><input type="radio" name="Com6" value="2"></center> </td>
						<td> <center><input type="radio" name="Com6" value="3"></center> </td>
						<td> <center><input type="radio" name="Com6" value="4"></center> </td>
						<td> <center><input type="radio" name="Com6" value="5"></center> </td>
					</tr>
				</table>
				<?php } ?>
					<br><br><br><br>
				<label>Histórico e Edital</label><span style="color: red;">*</span>
				<p></p>
				<br>
				<script type="text/javascript">
					$(function(){
						var cont = 0;
						$('#concordo1').click(function(event) {
							cont++;
							if (cont >= 2) {
								$('#enviar').removeAttr('disabled').css({background:'#069'});
							}	
						});
						$('#concordo2').click(function(event) {
							cont++;
							if (cont >= 2) {
								$('#enviar').removeAttr('disabled').css({background:'#069'});
							}
						});
					});
				</script>
				<input type="checkbox" name="" id="concordo1" value="concordo">  Estou ciente que preciso enviar meu Histórico Escolar conforme item 3.a do Edital após o envio deste formulário<br><br>
				<input type="checkbox" name="" id="concordo2" value="concordo">  Declaro ter lido e estar de acordo com o Edital de Seleção - 02/2016.<br><br>
				<center>
					<input type="submit" name="enviar" value="Enviar" id="enviar" disabled="" style="background: #8e9496;">
				</center>
			</form>
		</div>
	<?php
	}else{
		//Começa a parte da página principal
		//Agendamento
		if (isset($url[2]) && $url[2] == 'agendamento') {
			if (isset($_GET['action']) && $_GET['action']) {
				$form['npacce'] 	= $user['npacce'];
				$form['idAg'] 		= DBescape($_GET['idIns']);
				
				$agend = DBread('ren_horarios_agendamento', "WHERE id = '".$form['idAg']."'");
				switch ($_GET['action']) {
					case 1:
						
						if ($agend[0]['vagas'] <= 0) {
							echo '
			                 <script>
			                  alert("Não há vagas para esse horario");
			                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
			                  </script>';
						}else{
							$form['status'] 	= 1;
							$form['registro']	= date('Y-m-d H:i:s');
							if (DBcreate('ren_insc_agendamento', $form)) {
								$up['vagas'] = $agend[0]['vagas'] - 1;
								if (DBUpDate('ren_horarios_agendamento', $up, " id = '".$form['idAg']."' ")) {
									echo '
					                 <script>
					                  alert("Inscrição realizada com sucesso!");
					                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
					                  </script>';
								}
							}	
						}
						
					break;
					case 2:
						if (DBDelete('ren_insc_agendamento', " idAg = '".$form['idAg']."' AND npacce = '".$user['npacce']."' ")) {
							$up['vagas'] = $agend[0]['vagas'] + 1;
							if (DBUpDate('ren_horarios_agendamento', $up, " id = '".$form['idAg']."'")) {
								echo '
				                 <script>
				                  alert("Cancelamento efetuado com sucesso!");
				                    window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
				                  </script>';
							}
						}
					break;
					
				}
			}
		?>
		<script type="text/javascript">
			$(function(){
				agend();
				var i = setInterval(agend, 5000);

				function agend(){
					$.post('../../ajax/agendamento-entrevista.php', function(data){
						$('.tabela').empty().html(data);
					});
				}

			});
		</script>
		<div class="title"><h2>Agendamento</h2></div>
		<p>Faça seu agendamento até o dia 18/12. O número de vagas disponíveis será atualizada de 5 em 5 segundos</p>
		<div class="tabela">
			
		</div>
		<?php 			
		}else if (isset($url[2]) && $url[2] == 'aviso'){
			?>
				<h2 style="color: red;"> Procure sua coordenação para fazer o agendamento da sua entrevista</h2>
			<?php
		}else if (isset($url[2]) && substr($url[2], 0, 4) == 'sala'){
//==============Páginas das salas =========================================================================
			$getSala = str_replace("sala-", "", $url[2]);
			$sala = DBread('sl_salas', "WHERE sala = '$getSala'");
			$sala = $sala[0];
			if ($sala == false) {
				echo '
					<script> 
						alert("Sala não encontrada");
						window.location="'.$way.'/'.$url[1].'";
					</script>
				';
			}
			$trio  = DBread('sl_trios', "WHERE trio = '".$sala['trio']."'");
			$trio = $trio[0];
			//ATIVAR / DESATIVAR
			if (isset($_GET['action']) && $_GET['action'] != '') {

				switch ($_GET['action']) {
					case 1:
						$up['status'] = 1;
						if (DBUpDate('sl_salas', $up, "sala = '".$sala['sala']."'")) {
							echo '
								<script> 
									alert("Dados Alterados!!!");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
								</script>
							';
						}
					break;
					case 2:
						$up['status'] = 0;
						if (DBUpDate('sl_salas', $up, "sala = '".$sala['sala']."'")) {
							echo '
								<script> 
									alert("Dados Alterados!!!");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
								</script>
							';
						}
					break;
					
				}
			}
			?>
			<div class="title"><h2>Sala <?php echo $sala['sala']; ?></h2></div>
			<br>
			<div class="page-ati-single">
				<div class="cabecario">
					<div class="info-single"  style="width: 50%;">
						<ul>
							<li><h3><?php echo $sala['sala']; ?></h3></li>
							<li><?php echo $sala['local']; ?></li>
							<li><?php echo date('d/m', strtotime($sala['dataInicio'])).' - '.date('d/m', strtotime($sala['dataFim'])); ?></li>
							<li> <?php echo date('H:i', strtotime($sala['inicio'])).' - '.date('H:i', strtotime($sala['fim'])); ?>
							<br>   <br><?php echo $week[date('D', strtotime($sala['dataInicio']))]; ?> </li>
							<li> <?php if($trio == false){ echo 'A definir'; }else{ echo $trio['nomeUsual1'].' & '.$trio['nomeUsual2'].' & '.$trio['nomeUsual3'].' & '.$trio['nomeUsual4'];} ?> </li>
							
						</ul>
					</div>

					<?php 
						if ($trio == false) {
							
						}else{
							$foto1 = DBread('bolsistas', "WHERE npacce = '".$trio['npacce1']."'", "foto");
							$foto2 = DBread('bolsistas', "WHERE npacce = '".$trio['npacce2']."'", "foto");
							$foto3 = DBread('bolsistas', "WHERE npacce = '".$trio['npacce3']."'", "foto");
							$foto4 = DBread('bolsistas', "WHERE npacce = '".$trio['npacce4']."'", "foto");
					?>
					<div class="foto-single">
						<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto1[0]['foto']; ?>"><br></span>
						<div class="nome"><?php echo $trio['nomeUsual1']; ?></div>
					</div>
					<div class="foto-single">
						<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto2[0]['foto']; ?>"><br></span>
						<div class="nome"><?php echo $trio['nomeUsual2']; ?></div>
					</div>
					<div class="foto-single">
						<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto3[0]['foto']; ?>"><br></span>
						<div class="nome"><?php echo $trio['nomeUsual3']; ?></div>
					</div>
					<div class="foto-single">
						<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto4[0]['foto']; ?>"><br></span>
						<div class="nome"><?php echo $trio['nomeUsual4']; ?></div>
					</div>
					<?php } ?>
					<div id="clear"></div>
				</div>

			</div>
			<br>
				<div class="title"><h2>Opções</h2></div>
				<?php 
					if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
						$bool = true;
					}else{
						$bool = false;
					}

					if ($sala['status'] == 0) {
						if ($bool == true) {
						
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'?action=1' ?>" class="botao">Ativar Sala</a>
				<?php
						}
					}else{
						if ($bool == true) {
				?>
					<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'?action=2' ?>" class="botao">Desativar Sala</a>
				<?php 
						}
					}

				?>
				<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/ranking'; ?>" class="botao">Ver Ranking</a>
				<a href="<?php echo URL_PAINEL.'paginas/sl-lista-single.php?sala='.$sala['sala']; ?>" class="botao">Lista de Presença</a>
				<?php 
					if ($bool == true) {
				?>
				<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/editar'; ?>" class="botao">Editar</a>
				<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/add-candidato'; ?>" class="botao">Add Candidato</a>
				<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/remover-candidato'; ?>" class="botao">Remover Candidato</a>
				<?php } ?>
			<br><br><br>
			<?php 
//====================== PAGINAÇÃO DA SALA ======================================================================
		//===============FORMULÁRIOS DE NOTAS=======================================================
				if (isset($url[3]) && substr($url[3], 0, 8) == 'exibicao'){
					$npacce 	= str_replace("exibicao-", "", $url[3]);
					$candidato 	= DBread('sl_sala_insc', "WHERE npacce = '".$npacce."'");
					$candidato 	= $candidato[0];
					$trio 		= DBread('sl_trios', "WHERE trio = '".$sala['trio']."'");
					$trio 		= $trio[0];
					
					$notas1 	= DBread('sl_notas_gerais', "WHERE npacceCand = '".$npacce."' AND npacceFac = '".$trio['npacce1']."'");
					$notas2 	= DBread('sl_notas_gerais', "WHERE npacceCand = '".$npacce."' AND npacceFac = '".$trio['npacce2']."'");
					$notas3 	= DBread('sl_notas_gerais', "WHERE npacceCand = '".$npacce."' AND npacceFac = '".$trio['npacce3']."'");
					$notas4 	= DBread('sl_notas_gerais', "WHERE npacceCand = '".$npacce."' AND npacceFac = '".$trio['npacce4']."'");
					
					$notas1 	= $notas1[0];
					$notas2 	= $notas2[0];
					$notas3 	= $notas3[0];
					$notas4 	= $notas4[0];
				
					?>
					<div class="title"><h2>Notas de <?php echo $candidato['nome']; ?> </h2></div>
				
						<div class="table-responsive" style="overflow-y: auto;">
							<table class="table table-striped">
							<tr>
								<th colspan="9" style="width: 300px;"><?php echo $trio['npacce1'].' - '.$trio['nome1']; ?></th>
								<th colspan="9" style="width: 300px;"><?php echo $trio['npacce2'].' - '.$trio['nome2']; ?></th>
								<th colspan="9" style="width: 300px;"><?php echo $trio['npacce3'].' - '.$trio['nome3']; ?></th>
								<th colspan="9" style="width: 300px;"><?php echo $trio['npacce4'].' - '.$trio['nome4']; ?></th>
								
							</tr>
							<tr>
								<th colspan="9">1º dia</th>
								<th colspan="9">1º dia</th>
								<th colspan="9">1º dia</th>
								<th colspan="9">1º dia</th>
							</tr>
							<tr>
								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

							</tr>
							<tr>
								<td><?php if($notas1['p1'] === '0'){ echo 'Não';}elseif($notas1['p1'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas1['1a']; ?></td>
								<td><?php echo $notas1['1b']; ?></td>
								<td><?php echo $notas1['1c']; ?></td>
								<td><?php echo $notas1['1d']; ?></td>
								<td><?php echo $notas1['1e']; ?></td>
								<td><?php echo $notas1['1f']; ?></td>
								<td><?php echo $notas1['1g']; ?></td>
								<td><?php echo $notas1['1h']; ?></td>

								<td><?php if($notas2['p1'] === '0'){ echo 'Não';}elseif($notas2['p1'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas2['1a']; ?></td>
								<td><?php echo $notas2['1b']; ?></td>
								<td><?php echo $notas2['1c']; ?></td>
								<td><?php echo $notas2['1d']; ?></td>
								<td><?php echo $notas2['1e']; ?></td>
								<td><?php echo $notas2['1f']; ?></td>
								<td><?php echo $notas2['1g']; ?></td>
								<td><?php echo $notas2['1h']; ?></td>
								
								<td><?php if($notas3['p1'] === '0'){ echo 'Não';}elseif($notas3['p1'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas3['1a']; ?></td>
								<td><?php echo $notas3['1b']; ?></td>
								<td><?php echo $notas3['1c']; ?></td>
								<td><?php echo $notas3['1d']; ?></td>
								<td><?php echo $notas3['1e']; ?></td>
								<td><?php echo $notas3['1f']; ?></td>
								<td><?php echo $notas3['1g']; ?></td>
								<td><?php echo $notas3['1h']; ?></td>

								<td><?php if($notas4['p1'] === '0'){ echo 'Não';}elseif($notas4['p1'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas4['1a']; ?></td>
								<td><?php echo $notas4['1b']; ?></td>
								<td><?php echo $notas4['1c']; ?></td>
								<td><?php echo $notas4['1d']; ?></td>
								<td><?php echo $notas4['1e']; ?></td>
								<td><?php echo $notas4['1f']; ?></td>
								<td><?php echo $notas4['1g']; ?></td>
								<td><?php echo $notas4['1h']; ?></td>
							</tr>

							<tr>
								<th colspan="9">2º dia</th>
								<th colspan="9">2º dia</th>
								<th colspan="9">2º dia</th>
								<th colspan="9">2º dia</th>
							</tr>
							<tr>
								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>


								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>
							</tr>
							<tr>
								<td><?php if($notas1['p2'] === '0'){ echo 'Não';}elseif($notas1['p2'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas1['2a']; ?></td>
								<td><?php echo $notas1['2b']; ?></td>
								<td><?php echo $notas1['2c']; ?></td>
								<td><?php echo $notas1['2d']; ?></td>
								<td><?php echo $notas1['2e']; ?></td>
								<td><?php echo $notas1['2f']; ?></td>
								<td><?php echo $notas1['2g']; ?></td>
								<td><?php echo $notas1['2h']; ?></td>

								<td><?php if($notas2['p2'] === '0'){ echo 'Não';}elseif($notas2['p2'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas2['2a']; ?></td>
								<td><?php echo $notas2['2b']; ?></td>
								<td><?php echo $notas2['2c']; ?></td>
								<td><?php echo $notas2['2d']; ?></td>
								<td><?php echo $notas2['2e']; ?></td>
								<td><?php echo $notas2['2f']; ?></td>
								<td><?php echo $notas2['2g']; ?></td>
								<td><?php echo $notas2['2h']; ?></td>
								
								<td><?php if($notas3['p2'] === '0'){ echo 'Não';}elseif($notas3['p2'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas3['2a']; ?></td>
								<td><?php echo $notas3['2b']; ?></td>
								<td><?php echo $notas3['2c']; ?></td>
								<td><?php echo $notas3['2d']; ?></td>
								<td><?php echo $notas3['2e']; ?></td>
								<td><?php echo $notas3['2f']; ?></td>
								<td><?php echo $notas3['2g']; ?></td>
								<td><?php echo $notas3['2h']; ?></td>

								<td><?php if($notas4['p2'] === '0'){ echo 'Não';}elseif($notas4['p2'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas4['2a']; ?></td>
								<td><?php echo $notas4['2b']; ?></td>
								<td><?php echo $notas4['2c']; ?></td>
								<td><?php echo $notas4['2d']; ?></td>
								<td><?php echo $notas4['2e']; ?></td>
								<td><?php echo $notas4['2f']; ?></td>
								<td><?php echo $notas4['2g']; ?></td>
								<td><?php echo $notas4['2h']; ?></td>

								
							</tr>

							<tr>
								<th colspan="9">3º dia</th>
								<th colspan="9">3º dia</th>
								<th colspan="9">3º dia</th>
								<th colspan="9">3º dia</th>
							</tr>
							<tr>
								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

							</tr>
							<tr>
								<td><?php if($notas1['p3'] === '0'){ echo 'Não';}elseif($notas1['p3'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas1['3a']; ?></td>
								<td><?php echo $notas1['3b']; ?></td>
								<td><?php echo $notas1['3c']; ?></td>
								<td><?php echo $notas1['3d']; ?></td>
								<td><?php echo $notas1['3e']; ?></td>
								<td><?php echo $notas1['3f']; ?></td>
								<td><?php echo $notas1['3g']; ?></td>
								<td><?php echo $notas1['3h']; ?></td>

								<td><?php if($notas3['p3'] === '0'){ echo 'Não';}elseif($notas2['p3'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas2['3a']; ?></td>
								<td><?php echo $notas2['3b']; ?></td>
								<td><?php echo $notas2['3c']; ?></td>
								<td><?php echo $notas2['3d']; ?></td>
								<td><?php echo $notas2['3e']; ?></td>
								<td><?php echo $notas2['3f']; ?></td>
								<td><?php echo $notas2['3g']; ?></td>
								<td><?php echo $notas2['3h']; ?></td>
								
								<td><?php if($notas3['p3'] === '0'){ echo 'Não';}elseif($notas3['p3'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas3['3a']; ?></td>
								<td><?php echo $notas3['3b']; ?></td>
								<td><?php echo $notas3['3c']; ?></td>
								<td><?php echo $notas3['3d']; ?></td>
								<td><?php echo $notas3['3e']; ?></td>
								<td><?php echo $notas3['3f']; ?></td>
								<td><?php echo $notas3['3g']; ?></td>
								<td><?php echo $notas3['3h']; ?></td>

								<td><?php if($notas4['p3'] === '0'){ echo 'Não';}elseif($notas4['p3'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas4['3a']; ?></td>
								<td><?php echo $notas4['3b']; ?></td>
								<td><?php echo $notas4['3c']; ?></td>
								<td><?php echo $notas4['3d']; ?></td>
								<td><?php echo $notas4['3e']; ?></td>
								<td><?php echo $notas4['3f']; ?></td>
								<td><?php echo $notas4['3g']; ?></td>
								<td><?php echo $notas4['3h']; ?></td>

							</tr>

							<tr>
								<th colspan="9">4º dia</th>
								<th colspan="9">4º dia</th>
								<th colspan="9">4º dia</th>
								<th colspan="9">4º dia</th>
							</tr>
							<tr>
								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>
							</tr>
							<tr>
								<td><?php if($notas1['p4'] === '0'){ echo 'Não';}elseif($notas1['p4'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas1['4a']; ?></td>
								<td><?php echo $notas1['4b']; ?></td>
								<td><?php echo $notas1['4c']; ?></td>
								<td><?php echo $notas1['4d']; ?></td>
								<td><?php echo $notas1['4e']; ?></td>
								<td><?php echo $notas1['4f']; ?></td>
								<td><?php echo $notas1['4g']; ?></td>
								<td><?php echo $notas1['4h']; ?></td>

								<td><?php if($notas3['p4'] === '0'){ echo 'Não';}elseif($notas2['p4'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas2['4a']; ?></td>
								<td><?php echo $notas2['4b']; ?></td>
								<td><?php echo $notas2['4c']; ?></td>
								<td><?php echo $notas2['4d']; ?></td>
								<td><?php echo $notas2['4e']; ?></td>
								<td><?php echo $notas2['4f']; ?></td>
								<td><?php echo $notas2['4g']; ?></td>
								<td><?php echo $notas2['4h']; ?></td>

								
								<td><?php if($notas3['p4'] === '0'){ echo 'Não';}elseif($notas3['p4'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas3['4a']; ?></td>
								<td><?php echo $notas3['4b']; ?></td>
								<td><?php echo $notas3['4c']; ?></td>
								<td><?php echo $notas3['4d']; ?></td>
								<td><?php echo $notas3['4e']; ?></td>
								<td><?php echo $notas3['4f']; ?></td>
								<td><?php echo $notas3['4g']; ?></td>
								<td><?php echo $notas3['4h']; ?></td>

								<td><?php if($notas4['p4'] === '0'){ echo 'Não';}elseif($notas4['p4'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas4['4a']; ?></td>
								<td><?php echo $notas4['4b']; ?></td>
								<td><?php echo $notas4['4c']; ?></td>
								<td><?php echo $notas4['4d']; ?></td>
								<td><?php echo $notas4['4e']; ?></td>
								<td><?php echo $notas4['4f']; ?></td>
								<td><?php echo $notas4['4g']; ?></td>
								<td><?php echo $notas4['4h']; ?></td>

							</tr>

							<tr>
								<th colspan="9">5º dia</th>
								<th colspan="9">5º dia</th>
								<th colspan="9">5º dia</th>
								<th colspan="9">5º dia</th>
							</tr>
							<tr>
								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>


								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

								<th>P</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>H</th>

							</tr>
							<tr>
								<td><?php if($notas1['p5'] === '0'){ echo 'Não';}elseif($notas1['p5'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas1['5a']; ?></td>
								<td><?php echo $notas1['5b']; ?></td>
								<td><?php echo $notas1['5c']; ?></td>
								<td><?php echo $notas1['5d']; ?></td>
								<td><?php echo $notas1['5e']; ?></td>
								<td><?php echo $notas1['5f']; ?></td>
								<td><?php echo $notas1['5g']; ?></td>
								<td><?php echo $notas1['5h']; ?></td>

								<td><?php if($notas3['p5'] === '0'){ echo 'Não';}elseif($notas2['p5'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas2['5a']; ?></td>
								<td><?php echo $notas2['5b']; ?></td>
								<td><?php echo $notas2['5c']; ?></td>
								<td><?php echo $notas2['5d']; ?></td>
								<td><?php echo $notas2['5e']; ?></td>
								<td><?php echo $notas2['5f']; ?></td>
								<td><?php echo $notas2['5g']; ?></td>
								<td><?php echo $notas2['5h']; ?></td>
								
								<td><?php if($notas3['p5'] === '0'){ echo 'Não';}elseif($notas3['p5'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas3['5a']; ?></td>
								<td><?php echo $notas3['5b']; ?></td>
								<td><?php echo $notas3['5c']; ?></td>
								<td><?php echo $notas3['5d']; ?></td>
								<td><?php echo $notas3['5e']; ?></td>
								<td><?php echo $notas3['5f']; ?></td>
								<td><?php echo $notas3['5g']; ?></td>
								<td><?php echo $notas3['5h']; ?></td>

								<td><?php if($notas4['p5'] === '0'){ echo 'Não';}elseif($notas4['p5'] === '1'){ echo 'Sim';} ?></td>
								<td><?php echo $notas4['5a']; ?></td>
								<td><?php echo $notas4['5b']; ?></td>
								<td><?php echo $notas4['5c']; ?></td>
								<td><?php echo $notas4['5d']; ?></td>
								<td><?php echo $notas4['5e']; ?></td>
								<td><?php echo $notas4['5f']; ?></td>
								<td><?php echo $notas4['5g']; ?></td>
								<td><?php echo $notas4['5h']; ?></td>

							</tr>
							<tr>
								<th colspan="9">Entrevista</th>
								<th colspan="9">Entrevista</th>
								<th colspan="9">Entrevista</th>
								<th colspan="9">Entrevista</th>
							</tr>
							<tr>
								<td colspan="9"><?php echo $notas1['entrevista']; ?></td>
								<td colspan="9"><?php echo $notas2['entrevista']; ?></td>
								<td colspan="9"><?php echo $notas3['entrevista']; ?></td>
								<td colspan="9"><?php echo $notas4['entrevista']; ?></td>
							</tr>
							<tr>
								<th colspan="9">Parecer</th>
								<th colspan="9">Parecer</th>
								<th colspan="9">Parecer</th>
								<th colspan="9">Parecer</th>
							</tr>
							<tr>
								<td colspan="9" style="width: 300px;"><?php echo $notas1['obs']; ?></td>
								<td colspan="9" style="width: 300px;"><?php echo $notas2['obs']; ?></td>
								<td colspan="9" style="width: 300px;"><?php echo $notas3['obs']; ?></td>
								<td colspan="9" style="width: 300px;"><?php echo $notas4['obs']; ?></td>

							</tr>
						</table>
					</div>

					<?php
//====================================FORMULÁRIOS DE NOTAS=========================================================
				}else if (isset($url[3]) && substr($url[3], 0, 5) == 'notas'){


					$aux 	= explode('-', $url[3]);	 
					$dia 	= $aux[1];
					$npacce = $aux[3];

					$candidato = DBread('sl_sala_insc', "WHERE npacce = '".$npacce."'");
					$candidato = $candidato[0];

					//NOTAS QUE O FACILITADOR QUE ESTÁ LOGADO MANDOU
					$notasGerais = DBread('sl_notas_gerais', "WHERE npacceFac = '".$user['npacce']."' AND npacceCand = '$npacce'");
					$notasGerais = $notasGerais[0];
					if ($notasGerais == false) {
						$notas['p'.$dia] = false;
						$notas[$dia.'a'] = '';
						$notas[$dia.'b'] = '';
						$notas[$dia.'c'] = '';
						$notas[$dia.'d'] = '';
						$notas[$dia.'e'] = '';
						$notas[$dia.'f'] = '';
						$notas[$dia.'g'] = '';
						$notas[$dia.'h'] = '';
						if ($dia == 5) {
							$notas['entrevista'] = '';
							$notas['obs'] = '';
						}
					}else{
						$notas['p'.$dia] = $notasGerais['p'.$dia];
						$notas[$dia.'a'] = $notasGerais[$dia.'a'];
						$notas[$dia.'b'] = $notasGerais[$dia.'b'];
						$notas[$dia.'c'] = $notasGerais[$dia.'c'];
						$notas[$dia.'d'] = $notasGerais[$dia.'d'];
						$notas[$dia.'e'] = $notasGerais[$dia.'e'];
						$notas[$dia.'f'] = $notasGerais[$dia.'f'];
						$notas[$dia.'g'] = $notasGerais[$dia.'g'];
						$notas[$dia.'h'] = $notasGerais[$dia.'h'];
						if ($dia == 5) {
							$notas['entrevista'] = $notasGerais['entrevista'];
							$notas['obs'] 		 = $notasGerais['obs'];
						}
					}



				?>
				
				<div class="title"><h2>Notas do <?php echo $dia.'º dia - '.$candidato['nomeUsual']; ?> </h2></div>
				<?php 
					if (!isset($_GET['status'])) {
//==================== ESCOLHER SE ESTAVA COMO FACILITADOR OU APOIO NO TURNO ===============
				?>
					<div id="editar-ativ" class="form">
						<form method="get">
							<label>Nesse turno você estava:</label><span class="red"> *</span> <br>	
							<a href="?status=fac" class="botao" style="width: 100%; text-align: center;">FACILITANDO</a>
							<a href="?status=apoio" class="botao" style="width: 100%; text-align: center;">APOIANDO</a>
						</form>
					</div>
				<?php
					}else if (isset($_GET['status']) && $_GET['status'] == 'fac') {
						if (isset($_POST['enviar'])) {
//=========================PARA FACILITADOR========================================
							$notas['npacceFac'] = $user['npacce'];
							$notas['npacceCand'] = $npacce;
							$notas['p'.$dia] = GetPost('presenca');
							$notas[$dia.'a'] = GetPost('a');
							$notas[$dia.'b'] = GetPost('b');
							$notas[$dia.'c'] = GetPost('c');
							$notas[$dia.'d'] = GetPost('d');
							$notas[$dia.'e'] = GetPost('e');
							$notas[$dia.'f'] = 0;
							$notas[$dia.'g'] = 0;
							$notas[$dia.'h'] = 0;
							$notas['status'] = 1;
							$notas['registro']= date('Y-m-d H:i:s');

							//3 4 5 6 7 8 11
							if ($dia == 5) {
								$ent['entrevista3'] = GetPost('entrevista3')*2;
								$ent['entrevista4'] = GetPost('entrevista4')*1.5;
								$ent['entrevista5'] = GetPost('entrevista5')*1.5;
								$ent['entrevista6'] = GetPost('entrevista6')*2;
								$ent['entrevista7'] = GetPost('entrevista7')*1;
								$ent['entrevista8'] = GetPost('entrevista8')*1;
								$ent['entrevista11'] = GetPost('entrevista11')*1;

								$notas['entrevista'] = $ent['entrevista3'] + $ent['entrevista4'] + $ent['entrevista5'] + $ent['entrevista6'] + $ent['entrevista7'] + $ent['entrevista8'] +$ent['entrevista11'];
								$notas['obs']		 = GetPost('obs');
							}

							if ($notas['p'.$dia] === false) {
								echo '<script>alert("Campo Presença está vazio");</script>';
							}else if ($notas['p'.$dia] == '0') {
								//INSERIR NO BANCO

								$notas[$dia.'a'] = 0;
								$notas[$dia.'b'] = 0;
								$notas[$dia.'c'] = 0;
								$notas[$dia.'d'] = 0;
								$notas[$dia.'e'] = 0;
								
								if ($dia == 5) {

									$notas['entrevista'] = 0;
									
								}
								$trio = DBread('sl_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3 = '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'", "trio");
								if ($sala['trio'] != $trio[0]['trio']) {
									echo '
										<script> 
											alert("Você não tem permissão para enviar essa nota!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
										</script>
									';
								}else{
									
									if ($notasGerais == false) {
										if (DBcreate('sl_notas_gerais', $notas)) {
											echo '
												<script> 
													alert("Dados enviados com sucesso!!");
													window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
												</script>
											';
										}
									}else{
										if (DBUpDate('sl_notas_gerais', $notas, "npacceFac = '".$user['npacce']."' AND npacceCand = '".$npacce."'")) {
											echo '
												<script> 
													alert("Dados enviados com sucesso!!");
													window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
												</script>
											';
										}
									}

								}
							}else if($notas[$dia.'a'] === false){
								echo '<script>alert("Campo A está vazio");</script>';
							}else if($notas[$dia.'b'] === false){
								echo '<script>alert("Campo B está vazio");</script>';
							}else if($notas[$dia.'c'] === false){
								echo '<script>alert("Campo C está vazio");</script>';
							}else if($notas[$dia.'d'] === false){
								echo '<script>alert("Campo D está vazio");</script>';
							}else if($notas[$dia.'e'] === false){
								echo '<script>alert("Campo E está vazio");</script>';
							}else if($dia == 5 && $notas['entrevista'] < 10){
								echo '<script>alert("Campo Entrevista Não atinge o valor mínimo, você esqueceu algum campo");</script>';
							}else{

								//SELECIONA TRIO
								$trio = DBread('sl_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3 = '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'", "trio");
								if ($sala['trio'] != $trio[0]['trio']) {
									echo '
										<script> 
											alert("Você não tem permissão para enviar essa nota!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
										</script>
									';
								}else{
									
									if ($notasGerais == false) {
										if (DBcreate('sl_notas_gerais', $notas)) {
											echo '
												<script> 
													alert("Dados enviados com sucesso!!");
													window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
												</script>
											';
										}
									}else{
										if (DBUpDate('sl_notas_gerais', $notas, "npacceFac = '".$user['npacce']."' AND npacceCand = '".$npacce."'")) {
											echo '
												<script> 
													alert("Dados enviados com sucesso!!");
													window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
												</script>
											';
										}
									}
									

								}
							}
						}
					?>
					
					<div id="editar-ativ" class="form">
						<form method="post">
							<label>Presença</label> <span class="red">*</span> <br>	
							<p><?php echo $candidato['nomeUsual']; ?> esteve presente nesse <?php echo $dia.'º dia?'; ?></p>
							
							<input type="radio" name="presenca" value="1" <?php echo printRadio($notas['p'.$dia], 1); ?> style="margin-right: 10px;"> <span class="op">Sim</span> <br><br>
							<input type="radio" name="presenca" value="0" <?php echo printRadio($notas['p'.$dia], 0); ?> style="margin-right: 10px;"> <span class="op">Não</span> <br><br>
							<br>
							<label>Notas</label> <span class="red">*</span> <br>
							<div class="table-responsive">
								<table class="table table-striped">
								<tr>
									<th></th>
									<th>1</th>
									<th>2</th>
									<th>3</th>
									<th>4</th>
									<th>5</th>
								</tr>
								<tr>
									<th>A</th>
									<td><input type="radio" name="a" value="1" <?php echo printRadio($notas[$dia.'a'], 1); ?> ></td>
									<td><input type="radio" name="a" value="2" <?php echo printRadio($notas[$dia.'a'], 2); ?> ></td>
									<td><input type="radio" name="a" value="3" <?php echo printRadio($notas[$dia.'a'], 3); ?> ></td>
									<td><input type="radio" name="a" value="4" <?php echo printRadio($notas[$dia.'a'], 4); ?> ></td>
									<td><input type="radio" name="a" value="5" <?php echo printRadio($notas[$dia.'a'], 5); ?> ></td>
								</tr>
								<tr>
									<th>B</th>
									<td><input type="radio" name="b" value="1" <?php echo printRadio($notas[$dia.'b'], 1); ?> ></td>
									<td><input type="radio" name="b" value="2" <?php echo printRadio($notas[$dia.'b'], 2); ?> ></td>
									<td><input type="radio" name="b" value="3" <?php echo printRadio($notas[$dia.'b'], 3); ?> ></td>
									<td><input type="radio" name="b" value="4" <?php echo printRadio($notas[$dia.'b'], 4); ?> ></td>
									<td><input type="radio" name="b" value="5" <?php echo printRadio($notas[$dia.'b'], 5); ?> ></td>
								</tr>
								<tr>
									<th>C</th>
									<td><input type="radio" name="c" value="1" <?php echo printRadio($notas[$dia.'c'], 1); ?> ></td>
									<td><input type="radio" name="c" value="2" <?php echo printRadio($notas[$dia.'c'], 2); ?> ></td>
									<td><input type="radio" name="c" value="3" <?php echo printRadio($notas[$dia.'c'], 3); ?> ></td>
									<td><input type="radio" name="c" value="4" <?php echo printRadio($notas[$dia.'c'], 4); ?> ></td>
									<td><input type="radio" name="c" value="5" <?php echo printRadio($notas[$dia.'c'], 5); ?> ></td>
								</tr>
								<tr>
									<th>D</th>
									<td><input type="radio" name="d" value="1" <?php echo printRadio($notas[$dia.'d'], 1); ?> ></td>
									<td><input type="radio" name="d" value="2" <?php echo printRadio($notas[$dia.'d'], 2); ?> ></td>
									<td><input type="radio" name="d" value="3" <?php echo printRadio($notas[$dia.'d'], 3); ?> ></td>
									<td><input type="radio" name="d" value="4" <?php echo printRadio($notas[$dia.'d'], 4); ?> ></td>
									<td><input type="radio" name="d" value="5" <?php echo printRadio($notas[$dia.'d'], 5); ?> ></td>
								</tr>
								<tr>
									<th>E</th>
									<td><input type="radio" name="e" value="1" <?php echo printRadio($notas[$dia.'e'], 1); ?> ></td>
									<td><input type="radio" name="e" value="2" <?php echo printRadio($notas[$dia.'e'], 2); ?> ></td>
									<td><input type="radio" name="e" value="3" <?php echo printRadio($notas[$dia.'e'], 3); ?> ></td>
									<td><input type="radio" name="e" value="4" <?php echo printRadio($notas[$dia.'e'], 4); ?> ></td>
									<td><input type="radio" name="e" value="5" <?php echo printRadio($notas[$dia.'e'], 5); ?> ></td>
								</tr>
							</table>
							</div>
							<br><br>
							<?php 
								if ($dia == 5) {
							?>
								<br>
								<label>Entrevista</label> <span class="red">*</span> 
								<div>
									<p style="color: red;">Atenção para a nova fórmula de avaliar a entrevista:</p>
								</div>
								<div class="table-responsive">
									<table class="table table-striped">
									<tr>
										<th></th>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
											
									</tr>
									<?php 
										for ($i=1; $i <= 11; $i++) { 
									?>
									<tr>
										<th>Pergunta <?php echo $i ?></th>
										<td> <input type="radio" name="entrevista<?php echo $i; ?>" value="1" <?php echo printRadio($notas['entrevista'], 1); ?>> </td>
										<td> <input type="radio" name="entrevista<?php echo $i; ?>" value="2" <?php echo printRadio($notas['entrevista'], 2); ?>> </td>
										<td> <input type="radio" name="entrevista<?php echo $i; ?>" value="3" <?php echo printRadio($notas['entrevista'], 3); ?>> </td>
										<td> <input type="radio" name="entrevista<?php echo $i; ?>" value="4" <?php echo printRadio($notas['entrevista'], 4); ?>> </td>
										<td> <input type="radio" name="entrevista<?php echo $i; ?>" value="5" <?php echo printRadio($notas['entrevista'], 5); ?>> </td>
									</tr>
									<?php } ?>
									</table>
								</div>

								<br><br>
								<label>Parecer</label> 
								<textarea name="obs" placeholder="Digite seu parecer"><?php echo printPost($notas['obs'], 'campo'); ?></textarea> 
								<br><br>
							<?php
								}
							?>

							<center>
								<input type="submit" name="enviar" value="Enviar">
							</center>	
						</form>
					</div>
					
					<?php
					}else if (isset($_GET['status']) && $_GET['status'] == 'apoio') {
						if (isset($_POST['send'])) {
//=========================PARA APOIO========================================
							$notas['npacceFac'] = $user['npacce'];
							$notas['npacceCand'] = $npacce;
							$notas['p'.$dia] = GetPost('presenca');
							$notas[$dia.'a'] = 0;
							$notas[$dia.'b'] = 0;
							$notas[$dia.'c'] = 0;
							$notas[$dia.'d'] = 0;
							$notas[$dia.'e'] = 0;
							$notas[$dia.'f'] = GetPost('f');
							$notas[$dia.'g'] = GetPost('g');
							$notas[$dia.'h'] = GetPost('h');
							if ($dia == 5) {
								$notas['entrevista'] = 0;
								$notas['obs']		 = '';
							}
							$notas['status'] = 1;
							$notas['registro']= date('Y-m-d H:i:s');

							if ($notas['p'.$dia] === false) {
								echo '<script>alert("Campo Presença está vazio");</script>';
							}else if ($notas['p'.$dia] == '0') {
								//INSERIR NO BANCO

								$notas[$dia.'f'] = 0;
								$notas[$dia.'g'] = 0;
								$notas[$dia.'h'] = 0;
								
								$trio = DBread('sl_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3 = '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'", "trio");
								if ($sala['trio'] != $trio[0]['trio']) {
									echo '
										<script> 
											alert("Você não tem permissão para enviar essa nota!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
										</script>
									';
								}else{
									
									if ($notasGerais == false) {
										if (DBcreate('sl_notas_gerais', $notas)) {
											echo '
												<script> 
													alert("Dados enviados com sucesso!!");
													window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
												</script>
											';
										}
									}else{
										if (DBUpDate('sl_notas_gerais', $notas, "npacceFac = '".$user['npacce']."' AND npacceCand = '".$npacce."'")) {
											echo '
												<script> 
													alert("Dados enviados com sucesso!!");
													window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
												</script>
											';
										}
									}

								}
							}else if($notas[$dia.'f'] === false){
								echo '<script>alert("Campo A está vazio");</script>';
							}else if($notas[$dia.'g'] === false){
								echo '<script>alert("Campo B está vazio");</script>';
							}else if($notas[$dia.'h'] === false){
								echo '<script>alert("Campo C está vazio");</script>';
							}else{
								//SELECIONA TRIO
								$trio = DBread('sl_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3 = '".$user['npacce']."' OR npacce4 = '".$user['npacce']."'", "trio");
								if ($sala['trio'] != $trio[0]['trio']) {
									echo '
										<script> 
											alert("Você não tem permissão para enviar essa nota!!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
										</script>
									';
								}else{
									
									if ($notasGerais == false) {
										if (DBcreate('sl_notas_gerais', $notas)) {
											echo '
												<script> 
													alert("Dados enviados com sucesso!!");
													window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
												</script>
											';
										}
									}else{
										if (DBUpDate('sl_notas_gerais', $notas, "npacceFac = '".$user['npacce']."' AND npacceCand = '".$npacce."'")) {
											echo '
												<script> 
													alert("Dados enviados com sucesso!!");
													window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
												</script>
											';
										}
									}
									

								}
							}
						}
					?>
					<div id="editar-ativ" class="form">
						<form method="post">
							<label>Presença</label> <span class="red">*</span> <br>	
							<p><?php echo $candidato['nomeUsual']; ?> esteve presente nesse <?php echo $dia.'º dia?'; ?></p>
							
							<input type="radio" name="presenca" value="1" <?php echo printRadio($notas['p'.$dia], 1); ?> style="margin-right: 10px;"> <span class="op">Sim</span> <br><br>
							<input type="radio" name="presenca" value="0" <?php echo printRadio($notas['p'.$dia], 0); ?> style="margin-right: 10px;"> <span class="op">Não</span> <br><br>
							<br>
							<div class="table-responsive">
								<table class="table table-striped">
									<tr>
										<th></th>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
									</tr>
									<tr>
										<th>A</th>
										<td><input type="radio" name="f" value="1" <?php echo printRadio($notas[$dia.'f'], 1); ?> ></td>
										<td><input type="radio" name="f" value="2" <?php echo printRadio($notas[$dia.'f'], 2); ?> ></td>
										<td><input type="radio" name="f" value="3" <?php echo printRadio($notas[$dia.'f'], 3); ?> ></td>
										<td><input type="radio" name="f" value="4" <?php echo printRadio($notas[$dia.'f'], 4); ?> ></td>
										<td><input type="radio" name="f" value="5" <?php echo printRadio($notas[$dia.'f'], 5); ?> ></td>
									</tr>
									<tr>
										<th>B</th>
										<td><input type="radio" name="g" value="1" <?php echo printRadio($notas[$dia.'g'], 1); ?> ></td>
										<td><input type="radio" name="g" value="2" <?php echo printRadio($notas[$dia.'g'], 2); ?> ></td>
										<td><input type="radio" name="g" value="3" <?php echo printRadio($notas[$dia.'g'], 3); ?> ></td>
										<td><input type="radio" name="g" value="4" <?php echo printRadio($notas[$dia.'g'], 4); ?> ></td>
										<td><input type="radio" name="g" value="5" <?php echo printRadio($notas[$dia.'g'], 5); ?> ></td>
									</tr>
									<tr>
										<th>C</th>
										<td><input type="radio" name="h" value="1" <?php echo printRadio($notas[$dia.'h'], 1); ?> ></td>
										<td><input type="radio" name="h" value="2" <?php echo printRadio($notas[$dia.'h'], 2); ?> ></td>
										<td><input type="radio" name="h" value="3" <?php echo printRadio($notas[$dia.'h'], 3); ?> ></td>
										<td><input type="radio" name="h" value="4" <?php echo printRadio($notas[$dia.'h'], 4); ?> ></td>
										<td><input type="radio" name="h" value="5" <?php echo printRadio($notas[$dia.'h'], 5); ?> ></td>
									</tr>
								</table>
							</div>
							<center>
								<input type="submit" name="send" value="Enviar">
							</center>
						</form>
					</div>
					<?php
					}else{
						echo '
						<script> 
							alert("Nada encotrado
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
						</script>
						';
					}
				?>
				

				<?php
//======================================= RANKING ========================================================
				}else if (isset($url[3]) && $url[3] == 'ranking') {
					$sala = str_replace('sala-', "", $url[2]);

					$candidatos = DBread('sl_sala_insc', "WHERE sala = '".$sala."'");
					$ranking = array();
					for ($i=0; $i < count($candidatos); $i++) { 
						$notas = DBread('sl_notas_gerais', "WHERE npacceCand = '".$candidatos[$i]['npacce']."'");
						if ($notas) {
							$soma = array();
							for ($k=0; $k < count($notas); $k++) { 
								$soma[$k] = 0;
								for ($j=1; $j <= 5; $j++) { 
										$soma[$k]+= $notas[$k][$j.'a'];
										$soma[$k]+= $notas[$k][$j.'b'];
										$soma[$k]+= $notas[$k][$j.'c'];
										$soma[$k]+= $notas[$k][$j.'d'];
										$soma[$k]+= $notas[$k][$j.'e'];
										$soma[$k]+= $notas[$k][$j.'f'];
										$soma[$k]+= $notas[$k][$j.'g'];
										$soma[$k]+= $notas[$k][$j.'h'];
								}
								$soma[$k]+=$notas[$k]['entrevista'];
							}
						}
						$soma_total=0;
						for ($l=0; $l < count($soma); $l++) { 
							$soma_total+=$soma[$l];
						}
						$ranking[$i]['npacce'] 	= $candidatos[$i]['npacce'];
						$ranking[$i]['nome'] 	= $candidatos[$i]['nome'];
						$ranking[$i]['curso'] 	= $candidatos[$i]['curso'];
						$ranking[$i]['nota'] 	= $soma_total;
					}
					
					$ranking = bubbleSort($ranking, 'nota');
				?>
				<div class="title"><h2>Ranking</h2></div>
					<div class="table-responsive">
						<table class="table table-striped">
							<tr>
								<th>Posição</th>
								<th>NPACCE</th>
								<th>Nome</th>
								<th>Curso</th>
								<th>Nota total</th>
							</tr>
							<?php 
								if ($ranking) {
									for ($i=0; $i < count($ranking); $i++) { 
										?>
											<tr>
												<td><?php echo ($i+1).'º'; ?></td>
												<td><?php echo $ranking[$i]['npacce'] ?></td>
												<td><a href="<?php echo $way.$url[0].'/'.$url[1].'/'.$url[2].'/exibicao-'.$ranking[$i]['npacce']; ?>"><?php echo $ranking[$i]['nome'] ?></a></td>
												<td><?php echo $ranking[$i]['curso'] ?></td>
												<td><?php echo $ranking[$i]['nota'] ?></td>
											</tr>
										<?php
									}
								}
							?>
						</table>
					</div>

<?php
//===========================================EDITAR SALA ===================================================
				}else if (isset($userrl[3]) && $url[3] == 'editar') {

					if (isset($_POST['enviar'])) {
						$form['trio'] = GetPost('trio');
						//$form['sala'] 		= GetPost('sala');
						$form['local'] 		= GetPost('local');
						$form['dataInicio'] = GetPost('dataInicio');
						$form['dataFim'] 	= GetPost('dataFim');
						$form['inicio'] 	= GetPost('inicio');
						$form['fim'] 		= GetPost('fim');
						$form['turno'] 		= GetPost('turno');
						$form['cor']		= GetPost('cor');
						$form['status']		= 1;
						$form['registro']	= date('Y-m-d H:i:s');
						if ($form['trio'] == '1') {
							echo '<script>alert("Campo Trio está vazio!");</script>';
						}else if (empty($form['local'])) {
							echo '<script>alert("Campo local está vazio!");</script>';
						}else if (empty($form['dataInicio'])) {
							echo '<script>alert("Campo Data Inicio está vazio!");</script>';
						}else if (empty($form['dataFim'])) {
							echo '<script>alert("Campo Data Fim está vazio!");</script>';
						}else if (empty($form['inicio'])) {
							echo '<script>alert("Campo Inicio Fim está vazio!");</script>';
						}else if (empty($form['fim'])) {
							echo '<script>alert("Campo Fim Fim está vazio!");</script>';
						}else if (empty($form['turno'])) {
							echo '<script>alert("Campo Turno Fim está vazio!");</script>';
						}else if (empty($form['cor'])) {
							echo '<script>alert("Campo Cor está vazio!");</script>';
						}else{
							$form['dataInicio'] = $form['dataInicio'].' '.$form['inicio'];

							if (DBUpDate('sl_salas', $form, "sala = '".$sala['sala']."'")) {
								echo '
									<script> 
										alert("Dados Salvo!!!");
										window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
									</script>
								';
							}
						}
					}

				?>
				<script type="text/javascript">
					$(function(){
						$('#trio').change(function(event) {
							var trio  = $(this).val();
							if (trio != 1) {
								var dados = {trio:trio}
								$.post('../../../ajax/busca-escolha-trio.php', dados, function(data) {
									$('#res').empty().html(data);
								});
							}
						});
					});
				</script>
				<div class="title"><h2>Editar Sala</h2></div>
				<div class="form center">
					<form method="post">
						<label>Sala</label> <span class="red">*</span> <br>	
						<h2><?php echo $sala['sala']; ?></h2>
						<br>
						<label>Trio</label> <span class="red">*</span> <br>
						<select name="trio" id="trio" style="width: 50%;">
							<option value="1">Escolha um trio...</option>

							<?php 
								//SELECIONA TODOS OS TRIOS
								$selectTrios = DBread('sl_trios', "ORDER BY trio ASC", "trio");
								//SELECIONA TODAS AS SALAS ASSOCIADOS COM TRIO
								$selectSalas = DBread('sl_salas', "ORDER BY sala ASC", "sala, trio");
								$disabled= '';
								$check = '';
								for ($i=0; $i < count($selectTrios); $i++) { 
									
									for ($k=0; $k < count($selectSalas); $k++) { 
										if ($selectSalas[$k]['trio'] == $selectTrios[$i]['trio']) {
											$disabled = 'disabled=""';
										}
									}

									if ($sala['trio'] != '') {
										if ($sala['trio'] == $selectTrios[$i]['trio']) {
											$check = 'selected';
											$disabled = '';
										}
									}
									echo '<option '.$disabled.' '.$check.' value="'.$selectTrios[$i]['trio'].'">'.$selectTrios[$i]['trio'].'</option>';
									$disabled = '';
									$check = '';
								}
							?>
						</select>
						<div id="res"></div>
						<br><br>
						<label>Local</label> <span class="red">*</span> <br>
						<input type="text" name="local" value="<?php echo $sala['local']; ?>" placeholder="Digite o Local"> <br><br>
						
						<label>Data de Início</label> <span class="red">*</span> <br>
						<input type="date" name="dataInicio" value="<?php echo date('Y-m-d', strtotime($sala['dataInicio'])); ?>" placeholder="Digite o Local"> <br><br>

						<label>Data de Termino</label> <span class="red">*</span> <br>
						<input type="date" name="dataFim" value="<?php echo date('Y-m-d', strtotime($sala['dataFim'])); ?>" placeholder="Digite a data"> <br><br>

						<label>Início</label> <span class="red">*</span> <br>
						<input type="time" name="inicio" value="<?php echo $sala['inicio']; ?>" placeholder="Digite o horário de Inicio"> <br><br>

						<label>Fim</label> <span class="red">*</span> <br>
						<input type="time" name="fim" value="<?php echo $sala['fim']; ?>" placeholder="Digite o horário de Fim"> <br><br>

						<label>Turno</label> <span class="red">*</span> <br>
						<select name="turno" style="width: 50%;">
							<option <?php echo printSelect($sala['turno'], 'Manha'); ?> value="Manha">Manhã</option>
							<option <?php echo printSelect($sala['turno'], 'Tarde'); ?> value="Tarde">Tarde</option>
						</select>
						<br><br><br>
						<center>
							<label>Cor</label> <span class="red">*</span> <br>
							<input type="color" name="cor" value="<?php echo $sala['cor']; ?>">
						</center>
						<br><br><br>
						<center>
							<input type="submit" name="enviar" value="Enviar">
						</center>
					</form>
				</div>

				<?php
				}else if (isset($url[3]) && $url[3] == 'remover-candidato') {
//===============================================REMOVER CANDIDATO=========================================	
				if (isset($_GET['npacce']) && $_GET['npacce'] != '') {
					$npacce = DBescape($_GET['npacce']);
					$remove = DBread('sl_sala_insc', "WHERE npacce = '".$npacce."'", "nome");
					if ($remove == false) {
						echo '
							<script> 
								alert("Nada encontrado!!");
								window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
							</script>
						';
					}else{
						$form['nome'] = $remove[0]['nome'];
						if (DBDelete('sl_sala_insc', " npacce = '".$npacce."'")) {
							echo '
								<script> 
									alert("'.$form['nome'].' foi removido da sala '.$sala['sala'].' com sucesso!");
									window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";
								</script>
							';
						}
					}
				}		
				?>
				<div class="title"><h2>Remover Candidato</h2></div>
				<?php
				$candidatos = DBread('sl_sala_insc', "WHERE sala = '".$sala['sala']."' ORDER BY nome ASC");
				if ($candidatos == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{
				?>
					<div class="tabela">
						<table>
							<tr>
								<th>NPACCE</th>
								<th>Nome</th>
								<th>Curso</th>
								<th>Remover</th>
								
							</tr>
							<?php 
								for ($i=0; $i < count($candidatos); $i++) { 
							?>
								<tr>
									<td><?php echo $candidatos[$i]['npacce']; ?></td>
									<td><?php echo $candidatos[$i]['nome']; ?></td>
									<td><?php echo $candidatos[$i]['curso']; ?></td>
									<td> <a href="?npacce=<?php echo $candidatos[$i]['npacce']; ?>"> <img  src="<?php echo URL_PAINEL; ?>imagens/delete.gif" style="cursor: pointer;"> </a> </td>
								</tr>
								
							<?php 
								}
							?>
							
						</table>
					</div>
				<?php
					}
	//===========================================ADD CANDIDATO ==============================
				}else if (isset($url[3]) && $url[3] == 'add-candidato') {
					if (isset($_GET['npacce']) && $_GET['npacce']  != '') {
						$npacce = DBescape($_GET['npacce']);
						$ins = DBread('bolsistas', "WHERE npacce = '$npacce' AND status = true AND tipoSlug = 'candidato'");
						if ($ins == false) {
							echo '
									<script> 
										alert("Nada encontrado!!");
										window.location="'.$way.'/'.$url[1].'/'.$url[2].'";
									</script>
								';
						}else{
							$ins = $ins[0];
							$form['sala'] 		= $sala['sala'];
							$form['npacce']		= $ins['npacce'];
							$form['nome']		= $ins['nome'];
							$form['nomeUsual']	= GetName($ins['nome'], $ins['nomeUsual']);
							$form['curso']		= $ins['curso'];
							$form['status']		= 1;
							$form['registro']	= date('Y-m-d H:i:s');
							if (DBcreate('sl_sala_insc', $form)) {
								echo '
									<script> 
										alert("'.$form['nome'].' foi adicionado a sala '.$sala['sala'].' com sucesso!");
										window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";
									</script>
								';	
							}
						}
					}
				?>
				<script type="text/javascript">
					$(function(){
						$('#pesq').click(function(event) {
							event.preventDefault();
						});
						$('#pesquisar').keyup(function(event) {
							var palavra = $(this).val();
							var dados = {palavra:palavra};
							if (palavra != ''){
								$.post('../../../ajax/busca-candidatos-add.php', dados ,function(data) {
									$('#res').empty().html(data);
								});
							}else{
								$.post('../../../ajax/busca-candidatos-add.php',{} ,function(data) {
									$('#res').empty().html(data);
								});
							}
						});

						$.post('../../../ajax/busca-candidatos-add.php',{} ,function(data) {
							$('#res').empty().html(data);
						});
					});
				</script>
				<div class="title"><h2>Adicionar Candidato</h2></div>
				<div id="pesquisa">
					<form action="" method="post" enctype="multipart/form-data">
						<input type="text" id="pesquisar" autocomplete="off" onkeyup="maiuscula(this)" name="pesquisar" OnKeyPress="" value=""  placeholder="Digite o número pacce ou o nome de quem você quer procurar"></input>
						<input type="submit" name="pesq" id="pesq" value="Pesquisar">
					</form>
				</div>
				<div id="clear"></div>
				<div id="res"></div>
				<?php
				}else{
//=====================PÁGINA INICIAL DA SALA==========================================================
			?>
				<div class="title"><h2>Candidatos</h2></div>
				<?php 
				$candidatos = DBread('sl_sala_insc', "WHERE sala = '".$sala['sala']."' ORDER BY nome ASC");
				if ($candidatos == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{
				?>
					<div class="table-responsive">
						<table class="table table-striped">
							<tr>
								<th>NPACCE</th>
								<th>Nome</th>
								<th>Curso</th>
								<th>1º</th>
								<th>2º</th>
								<th>3º</th>
								<th>4º</th>
								<th>5º</th>
							</tr>
							<?php 
								for ($i=0; $i < count($candidatos); $i++) {
								$notas = DBread('sl_notas_gerais', "WHERE npacceCand = '".$candidatos[$i]['npacce']."' AND npacceFac = '".$user['npacce']."'");
								$notas = $notas[0]; 

							?>
								<tr>
									<td><?php echo $candidatos[$i]['npacce']; ?></td>
									<td>
									<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/exibicao-'.$candidatos[$i]['npacce']; ?>">
									<?php echo $candidatos[$i]['nome']; ?>
									</a>
									</td>
									<td><?php echo $candidatos[$i]['curso']; ?></td>
									<td> <a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/notas-1-dia-'.$candidatos[$i]['npacce']; ?>" style="color: <?php if($notas['p1'] === '0' || $notas['p1'] === '1'){ echo 'green'; }else{ echo 'red'; } ?>;">1º Período</a> </td>
									<td> <a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/notas-2-dia-'.$candidatos[$i]['npacce']; ?>" style="color: <?php if($notas['p2'] === '0' || $notas['p2'] === '1'){ echo 'green'; }else{ echo 'red'; } ?>;">2º Período</a> </td>
									<td> <a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/notas-3-dia-'.$candidatos[$i]['npacce']; ?>" style="color: <?php if($notas['p3'] === '0' || $notas['p3'] === '1'){ echo 'green'; }else{ echo 'red'; } ?>;">3º Período</a> </td>
									<td> <a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/notas-4-dia-'.$candidatos[$i]['npacce']; ?>" style="color: <?php if($notas['p4'] === '0' || $notas['p4'] === '1'){ echo 'green'; }else{ echo 'red'; } ?>;">4º Período</a> </td>
									<td> <a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/notas-5-dia-'.$candidatos[$i]['npacce']; ?>" style="color: <?php if($notas['p5'] === '0' || $notas['p5'] === '1'){ echo 'green'; }else{ echo 'red'; } ?>;">5º Período</a> </td>
								</tr>
								
							<?php 
								}
							?>
							
						</table>
					</div>
					(<?php echo count($candidatos); ?>)
				<?php
					}
				}
				?>

			<div id="clear"></div>
			<?php

//==============Páginas das salas =========================================================================


///=============	Paginação	===========================================================================
		}else if (isset($url[2]) && $url[2] == 'cadastrar-sala'){
				if (isset($_POST['enviar'])) {
					$form['sala'] 		= GetPost('sala');
					$form['local'] 		= GetPost('local');
					$form['dataInicio'] = GetPost('dataInicio');
					$form['dataFim'] 	= GetPost('dataFim');
					$form['inicio'] 	= GetPost('inicio');
					$form['fim'] 		= GetPost('fim');
					$form['turno'] 		= 'Integral';
					$form['cor']		= GetPost('cor');
					$form['status']		= 1;
					$form['registro']	= date('Y-m-d H:i:s');
					if ($form['sala'] == '1') {
						echo '<script>alert("Campo Sala está vazio!");</script>';
					}else if (empty($form['local'])) {
						echo '<script>alert("Campo local está vazio!");</script>';
					}else if (empty($form['dataInicio'])) {
						echo '<script>alert("Campo Data Inicio está vazio!");</script>';
					}else if (empty($form['dataFim'])) {
						echo '<script>alert("Campo Data Fim está vazio!");</script>';
					}else if (empty($form['inicio'])) {
						echo '<script>alert("Campo Inicio Fim está vazio!");</script>';
					}else if (empty($form['fim'])) {
						echo '<script>alert("Campo Fim Fim está vazio!");</script>';
					}else if (empty($form['cor'])) {
						echo '<script>alert("Campo Cor está vazio!");</script>';
					}else{
						$form['dataInicio'] = $form['dataInicio'].' '.$form['inicio'].':00';
						if (DBcreate('sl_salas', $form)) {
							echo '
								<script> 
									alert("Dados Salvo!!!");
									window.location="'.$way.'/'.$url[1].'";
								</script>
							';
						}
					}
				}
			?>
				<div class="title"><h2>Cadastro de Sala para Selção</h2></div>
				<div class="form center">
					<form method="post">
						<label>Sala</label> <span class="red">*</span> <br>	
						<select name="sala" style="width: 50%;">
							<option value="1">Escolha uma sala...</option>
							<?php
								$salas = DBread('sl_salas', null, "sala, trio");
								
								for ($i=1; $i <= 20; $i++) {

									if ($i < 10) {
									  	$showSala = 'F-0'.$i;
									 }else{
									 	$showSala = 'F-'.$i;
									 }

									 if ($salas == true) {
									   for ($k=0; $k < count($salas); $k++) { 
									   		if ($showSala == $salas[$k]['sala']) {
									   			$check = 'disabled';
									   		}
									   }
									 }else{
									 	$check = '';
									 }  
									echo '<option '.$check.' value="'.$showSala.'" '.printSelect(GetPost('sala'), $showSala).' >'.$showSala.'</option>';
									$check = '';
								}

								/*$salas = DBread('sl_salas', "WHERE turno = 'Tarde' ORDER BY sala ASC", "sala, trio");
								for ($i=1; $i <= 20; $i++) {

									if ($i < 10) {
									  	$showSala = 'T-0'.$i;
									 }else{
									 	$showSala = 'T-'.$i;
									 }

									 if ($salas == true) {
									   for ($k=0; $k < count($salas); $k++) { 
									   		if ($showSala == $salas[$k]['sala']) {
									   			$check = 'disabled';
									   		}
									   }
									 }else{
									 	$check = '';
									 }  
									echo '<option '.$check.' value="'.$showSala.'" '.printSelect(GetPost('sala'), $showSala).' >'.$showSala.'</option>';
									$check = '';
								}*/

								
							 ?>
						</select>
						<br><br><br>

						<label>Local</label> <span class="red">*</span> <br>
						<input type="text" name="local" value="<?php echo GetPost('local'); ?>" placeholder="Digite o Local"> <br><br>
						
						<label>Data de Início</label> <span class="red">*</span> <br>
						<input type="date" name="dataInicio" value="<?php echo GetPost('dataInicio'); ?>" placeholder="Digite o Local"> <br><br>

						<label>Data de Termino</label> <span class="red">*</span> <br>
						<input type="date" name="dataFim" value="<?php echo GetPost('dataFim'); ?>" placeholder="Digite a data"> <br><br>

						<label>Início</label> <span class="red">*</span> <br>
						<input type="time" name="inicio" value="<?php echo GetPost('inicio'); ?>" placeholder="Digite o horário de Inicio"> <br><br>

						<label>Fim</label> <span class="red">*</span> <br>
						<input type="time" name="fim" value="<?php echo GetPost('fim'); ?>" placeholder="Digite o horário de Fim"> <br><br>

						<!-- <label>Turno</label> <span class="red">*</span> <br>
						<select name="turno" style="width: 50%;">
							<option <?php // echo printSelect(GetPost('turno'), $showSala); ?> value="Manha">Manhã</option>
							<option <?php // echo printSelect(GetPost('turno'), $showSala); ?> value="Tarde">Tarde</option>
						</select>
						<br><br><br> -->
						<center>
							<label>Cor</label> <span class="red">*</span> <br>
							<input type="color" name="cor" value="<?php echo GetPost('cor'); ?>">
						</center>
						<br><br><br>
						<center>
							<input type="submit" name="enviar" value="Enviar">
						</center>
					</form>
				</div>
			<?php
		}else if (isset($url[2]) && $url[2] == 'cadastrar-trio'){
			if (isset($_POST['enviar'])) {
				$npacce1 = GetPost('npacce1');
				$npacce2 = GetPost('npacce2');
				$npacce3 = GetPost('npacce3');
				$npacce4 = GetPost('npacce4');
				if (empty($npacce1)) {
					echo '<script>alert("Campo Vazio!");</script>';
				}else if (empty($npacce2)) {
					echo '<script>alert("Campo Vazio!");</script>';
				}else if (empty($npacce3)) {
					echo '<script>alert("Campo Vazio!");</script>';
				}else if (empty($npacce4)) {
					echo '<script>alert("Campo Vazio!");</script>';
				}else{
					$facilitador1 = DBread('bolsistas', "WHERE npacce = '$npacce1'", 'npacce, nome, nomeUsual, curso');
					$facilitador2 = DBread('bolsistas', "WHERE npacce = '$npacce2'", 'npacce, nome, nomeUsual, curso');
					$facilitador3 = DBread('bolsistas', "WHERE npacce = '$npacce3'", 'npacce, nome, nomeUsual, curso');
					$facilitador4 = DBread('bolsistas', "WHERE npacce = '$npacce4'", 'npacce, nome, nomeUsual, curso');

					$facilitador1 = $facilitador1[0];
					$facilitador2 = $facilitador2[0];
					$facilitador3 = $facilitador3[0];
					$facilitador4 = $facilitador4[0];

					if ($facilitador1 == false) {
						echo '<script>alert("O Primeiro número PACCE digitado não existe!");</script>';
					}else if ($facilitador2 == false) {
						echo '<script>alert("O Segundo número PACCE digitado não existe!");</script>';
					}else if ($facilitador3 == false) {
						echo '<script>alert("O Terceiro número PACCE digitado não existe!");</script>';
					}else if ($facilitador4 == false) {
						echo '<script>alert("O quarto número PACCE digitado não existe!");</script>';
					}else{
						$form['trio'] 		= '';
						$form['npacce1']	= $facilitador1['npacce'];
						$form['nome1']		= $facilitador1['nome'];
						$form['nomeUsual1']	=  GetName($facilitador1['nome'], $facilitador1['nomeUsual']);
						$form['curso1']		= $facilitador1['curso'];

						$form['npacce2']	= $facilitador2['npacce'];
						$form['nome2']		= $facilitador2['nome'];
						$form['nomeUsual2']	=  GetName($facilitador2['nome'], $facilitador2['nomeUsual']);
						$form['curso2']		= $facilitador2['curso'];

						$form['npacce3']	= $facilitador3['npacce'];
						$form['nome3']		= $facilitador3['nome'];
						$form['nomeUsual3']	=  GetName($facilitador3['nome'], $facilitador3['nomeUsual']);
						$form['curso3']		= $facilitador3['curso'];

						$form['npacce4']	= $facilitador4['npacce'];
						$form['nome4']		= $facilitador4['nome'];
						$form['nomeUsual4']	=  GetName($facilitador4['nome'], $facilitador4['nomeUsual']);
						$form['curso4']		= $facilitador4['curso'];

						$form['status']		= 1;
						$form['registro']	= date('Y-m-d H:i:s');

						$trio = DBread('sl_trios', "ORDER BY trio DESC");

						if ($trio == false) {
							$form['trio'] = 'TR-01';
						}else{
							$auxTrio = str_replace("TR-", "", $trio[0]['trio']);
							$auxTrio = $auxTrio + 1;

							if ($auxTrio < 10) {
								$form['trio'] = 'TR-0'.$auxTrio;
							}else{
								$form['trio'] = 'TR-'.$auxTrio;
							}
						}

						if (DBcreate('sl_trios', $form)) {
							echo '
								<script> 
									alert("Dados Salvo!! \n\n Trio - '.$form['trio'].' \n\n '.$form['nomeUsual1'].' - '.$form['curso1'].' \n '.$form['nomeUsual2'].' - '.$form['curso2'].' \n '.$form['nomeUsual3'].' - '.$form['curso3'].' \n '.$form['nomeUsual4'].' - '.$form['curso4'].' ");
									window.location="'.$way.'/'.$url[1].'";
								</script>
							';
						}

					}

				}
			}
		?>
			<br>
			<div class="title"><h2>Cadastro de Quarteto para a seleção</h2></div>
			<div class="form center">
				<form method="post">
					<label>Número PACCE</label> <span class="red">*</span> <br>
					<input type="text" name="npacce1" placeholder="Digite um número PACCE" value="<?php echo GetPost('npacce1'); ?>" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="off" maxlength="7"><br><br>

					<label>Número PACCE</label> <span class="red">*</span> <br>
					<input type="text" name="npacce2" placeholder="Digite um número PACCE" value="<?php echo GetPost('npacce2'); ?>" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="off" maxlength="7"><br><br>

					<label>Número PACCE</label> <span class="red">*</span> <br>
					<input type="text" name="npacce3" placeholder="Digite um número PACCE" value="<?php echo GetPost('npacce3'); ?>" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="off" maxlength="7"><br><br>
					
					<label>Número PACCE</label> <span class="red">*</span> <br>
					<input type="text" name="npacce4" placeholder="Digite um número PACCE" value="<?php echo GetPost('npacce4'); ?>" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="off" maxlength="7"><br><br>
					<br><br><br>
					<center>
						<input type="submit" name="enviar" value="Enviar">
					</center>
				</form>
			</div>
		<?php
		}else if (isset($url[2]) &&  substr($url[2], 0 ,11)  == 'editar-trio'){
//================================Editar trio ====================================================================
			$getTrio = str_replace("editar-trio-", "", $url[2]);
			$trio = DBread('sl_trios', "WHERE trio = '$getTrio'");
			$trio = $trio[0];
			if ($trio == false) {
				echo '
					<script> 
						alert("Trio não encontrado!");
						window.location="'.$way.'/'.$url[1].'";
					</script>
				';
			}

			if (isset($_POST['enviar'])) {
				$npacce1 = GetPost('npacce1');
				$npacce2 = GetPost('npacce2');
				$npacce3 = GetPost('npacce3');
				$npacce4 = GetPost('npacce4');
				
				if (empty($npacce1)) {
					echo '<script>alert("Campo Vazio!");</script>';
				}else if (empty($npacce2)) {
					echo '<script>alert("Campo Vazio!");</script>';
				}else if (empty($npacce3)) {
					echo '<script>alert("Campo Vazio!");</script>';
				}else if (empty($npacce4)) {
					echo '<script>alert("Campo Vazio!");</script>';
				}else{
					$facilitador1 = DBread('bolsistas', "WHERE npacce = '$npacce1'", 'npacce, nome, nomeUsual, curso');
					$facilitador2 = DBread('bolsistas', "WHERE npacce = '$npacce2'", 'npacce, nome, nomeUsual, curso');
					$facilitador3 = DBread('bolsistas', "WHERE npacce = '$npacce3'", 'npacce, nome, nomeUsual, curso');
					$facilitador4 = DBread('bolsistas', "WHERE npacce = '$npacce4'", 'npacce, nome, nomeUsual, curso');

					$facilitador1 = $facilitador1[0];
					$facilitador2 = $facilitador2[0];
					$facilitador3 = $facilitador3[0];
					$facilitador4 = $facilitador4[0];

					if ($facilitador1 == false) {
						echo '<script>alert("O Primeiro número PACCE digitado não existe!");</script>';
					}else if ($facilitador2 == false) {
						echo '<script>alert("O Segundo número PACCE digitado não existe!");</script>';
					}else if ($facilitador3 == false) {
						echo '<script>alert("O Terceiro número PACCE digitado não existe!");</script>';
					}else if ($facilitador4 == false) {
						echo '<script>alert("O Quarto número PACCE digitado não existe!");</script>';
					}else{

						$form['npacce1']	= $facilitador1['npacce'];
						$form['nome1']		= $facilitador1['nome'];
						$form['nomeUsual1']	=  GetName($facilitador1['nome'], $facilitador1['nomeUsual']);
						$form['curso1']		= $facilitador1['curso'];

						$form['npacce2']	= $facilitador2['npacce'];
						$form['nome2']		= $facilitador2['nome'];
						$form['nomeUsual2']	=  GetName($facilitador2['nome'], $facilitador2['nomeUsual']);
						$form['curso2']		= $facilitador2['curso'];

						$form['npacce3']	= $facilitador3['npacce'];
						$form['nome3']		= $facilitador3['nome'];
						$form['nomeUsual3']	=  GetName($facilitador3['nome'], $facilitador3['nomeUsual']);
						$form['curso3']		= $facilitador3['curso'];

						$form['npacce4']	= $facilitador4['npacce'];
						$form['nome4']		= $facilitador4['nome'];
						$form['nomeUsual4']	=  GetName($facilitador4['nome'], $facilitador4['nomeUsual']);
						$form['curso4']		= $facilitador4['curso'];

						$form['status']		= 1;
						$form['registro']	= date('Y-m-d H:i:s');

						if (DBUpDate('sl_trios', $form, "trio = '".$trio['trio']."'")) {
							echo '
								<script> 
									alert("Dados Salvo!! \n\n Trio - '.$trio['trio'].' \n\n '.$form['nomeUsual1'].' - '.$form['curso1'].' \n '.$form['nomeUsual2'].' - '.$form['curso2'].' \n '.$form['nomeUsual3'].' - '.$form['curso3'].' \n '.$form['nomeUsual4'].' - '.$form['curso4'].' ");
									window.location="'.$way.'/'.$url[1].'";
								</script>
							';
						}

					}

				}
			}
			?>

			<br>
			<div class="title"><h2><?php echo $trio['trio'] ?> - Edição</h2></div>
			<div class="form center">
				<form method="post">
					<label>Número PACCE</label> <span class="red">*</span> <br>
					<input type="text" name="npacce1" placeholder="Digite um número PACCE" value="<?php echo $trio['npacce1']; ?>" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="off" maxlength="7"><br><br>

					<label>Número PACCE</label> <span class="red">*</span> <br>
					<input type="text" name="npacce2" placeholder="Digite um número PACCE" value="<?php echo $trio['npacce2']; ?>" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="off" maxlength="7"><br><br>

					<label>Número PACCE</label> <span class="red">*</span> <br>
					<input type="text" name="npacce3" placeholder="Digite um número PACCE" value="<?php echo $trio['npacce3']; ?>" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="off" maxlength="7"><br><br>
					
					<label>Número PACCE</label> <span class="red">*</span> <br>
					<input type="text" name="npacce4" placeholder="Digite um número PACCE" value="<?php echo $trio['npacce4']; ?>" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="off" maxlength="7"><br><br>
					
					<br><br><br>
					<center>
						<input type="submit" name="enviar" value="Enviar">
					</center>
				</form>
			</div>
			
			<?php
		}else{

?>
<div class="title"><h2>Veteranos</h2></div>
<?php 

	$veterano = DBread('ren_insc', "WHERE npacce = '".$user['npacce']."'");
	$veterano = $veterano[0];
	if ($veterano == true) {
		?>
		<div class="tabela">
			<table>
				<tr>
					<th>npacce</th>
					<th>Primeira Opção</th>
					<th>Segunda Opção</th>
					<th>Resultado</th>
				</tr>
				<tr>
					<td><?php echo $veterano['npacce']; ?></td>
					<td>
						<?php 
							$funcao1 = DBread('comissoes', "WHERE comissao = '".$veterano['funcao1']."'");
							echo $funcao1[0]['comissao'];
						?>
					</td>
					<td>
						<?php 
							$funcao2 = DBread('comissoes', "WHERE comissao = '".$veterano['funcao2']."'");
							echo $funcao2[0]['comissao'];
						?>
					</td>
					<td>
						<?php 
							if ($veterano['res'] == 0) {
								echo '---';
							}else if($veterano['res'] == 1){

								if ($veterano['campus'] == 'benfica' ||$veterano['campus'] == 'labomar' || $veterano['campus'] == 'pici'|| $veterano['campus'] == 'porangabucu') {
									echo 'Deferido!';	
								}else{
									echo 'Deferido!<br><a href="'.$url[1].'/aviso" style="color: #069;">Click aqui</a>';
								}
								
							}else{
								echo 'Indeferido';
							}
						?>
					</td>
				</tr>
			</table>
		</div>
		<br><br>
		<div class="title"><h2>Agendamento</h2></div>
		<?php 
			$agendInsc = DBread('ren_insc_agendamento', "WHERE npacce = '".$user['npacce']."'");
			$agend = DBread('ren_horarios_agendamento', "WHERE id = '".$agendInsc[0]['idAg']."'");

			if ($agendInsc == false) {
				echo '<span style="color: red;"><h2>Nada encontrado.</h2></span>';
			}else{


		?>
		<div class="tabela">
			<table>
				<tr>
					<th>Dia</th>
					<th>Dia da semana</th>
					<th>Turno</th>
					<th>Início</th>
					<th>Fim</th>
					<th>Presença</th>
				</tr>
				<tr>
				<td><?php echo date('d/m', strtotime($agend[0]['dia']));  ?></td>
					<td><?php echo $agend[0]['diaSemana']; ?></td>
					<td><?php echo $agend[0]['turno']; ?></td>
					<td><?php echo date('H:i', strtotime($agend[0]['inicio'])); ?></td>
					<td><?php echo date('H:i', strtotime($agend[0]['fim'])); ?></td>
					<td>---</td>
				</tr>
			</table>
		</div>
		<?php
			}
//=========== Lista de Salas =======================================================================================================
?>

		<br><br>
		<div class="title"><h2>Novatos</h2></div>
		<?php 
			if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
			
		?>
		<div class="title"><h2>Opções</h2></div>
		<a href="<?php echo $way.'/'.$url[1].'/cadastrar-sala'; ?>" class="botao">Cadastrar Sala</a>
		<a href="<?php echo $way.'/'.$url[1].'/cadastrar-trio'; ?>" class="botao">Cadastrar Trio</a>
		<?php 
			}
		?>
		<br><br>
		<div class="title"><h2>Salas</h2></div>
		<?php
			$trioUser = DBread('sl_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3 = '".$user['npacce']."' OR npacce4 = '".$user['npacce']."' ");
			if ($trioUser == false) {
				$trioUser['trio']  = '';
			}else{
				$trioUser = $trioUser[0];
			}
			if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno') {
				$salas = DBread('sl_salas', "ORDER BY sala ASC");
			}else{
				$salas = DBread('sl_salas', "WHERE trio = '".$trioUser['trio']."' AND status = true ORDER BY sala ASC");	
			}
			

			if ($salas == false) {
				echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
			}else{
		 ?>
		<div class="caixa">
			<ul>
			<?php 

				for ($i=0; $i < count($salas); $i++) { 
					$getTrio = DBread('sl_trios', "WHERE trio = '".$salas[$i]['trio']."'");
			?>
				<a href="<?php echo $way.'/'.$url[1].'/sala-'.$salas[$i]['sala']; ?>">
					<li style="background-color: <?php echo $salas[$i]['cor']; ?>;">
						<div>
							<div id="box-all-info">
								<div id="all-info">
									<h3><?php echo $salas[$i]['sala']; ?></h3><br>
									<span><?php echo $salas[$i]['local']; ?></span><br><br>
									<span><?php echo date('d/m', strtotime($salas[$i]['dataInicio'])).' - '.date('d/m', strtotime($salas[$i]['dataFim'])); ?> <br>
									  <?php echo date('H:i', strtotime($salas[$i]['inicio'])).' - '.date('H:i', strtotime($salas[$i]['fim'])); ?> <br> 
									  <?php echo $week[date('D', strtotime($salas[$i]['dataInicio']))]; ?> </span><br><br>
									<span><?php echo $salas[$i]['turno']; ?></span><br>
									<span><?php if($salas[$i]['trio'] == ''){ echo 'A definir';}else{ echo $getTrio[0]['nomeUsual1'].' - '.$getTrio[0]['nomeUsual2'].' - '.$getTrio[0]['nomeUsual3'];  } ?></span>
								</div>
							</div>
							<div id="tipo">
								Sala de Seleção
							</div>
						</div>
					</li>
				</a>
			<?php 
				}
			?>
			</ul>
		</div>
		<?php } ?>
		<br><br>
		<div class="title"><h2>Trios</h2></div>
		<?php 
			if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'apoio-tecnico') {
				$trio  = DBread('sl_trios', "ORDER BY trio ASC");
				$check = true;
			}else{
				$trio  = DBread('sl_trios', "WHERE npacce1 = '".$user['npacce']."' OR npacce2 = '".$user['npacce']."' OR npacce3 = '".$user['npacce']."'  ORDER BY trio ASC");
				$check = false;
			}
			
			if ($trio == false) {
				
			}else{
		?>
		<div class="table-responsive">
		<table class="table table-striped">
				<?php 
				for ($i=0; $i < count($trio); $i++) { 
					$sala = DBread('sl_salas', "WHERE trio = '".$trio[$i]['trio']."'", "sala");
				
			?>
				<tr>
					<th>Trio</th>
					<th>Sala</th>
					<th>NPACCE</th>
					<th>Nome</th>
					<th>Curso</th>
				</tr>
				<tr>
					<td> 
					<?php
					if ($check == true) {
						?>
						<a href="<?php echo $way.'/'.$url[1].'/editar-trio-'.$trio[$i]['trio']; ?>">
						<?php
					}
					?>
					<?php echo $trio[$i]['trio'] ?>
					<?php
					if ($check == true) {
						?>
						</a>
						<?php
					}
					?>
					</td>
					<td><?php if($sala == true){ echo $sala[0]['sala']; } ?></td>
					<td><?php echo $trio[$i]['npacce1'] ?></td>
					<td><?php echo $trio[$i]['nome1'] ?></td>
					<td><?php echo $trio[$i]['curso1'] ?></td>
				</tr>
				<tr>
					<td> 
					<?php
					if ($check == true) {
						?>
						<a href="<?php echo $way.'/'.$url[1].'/editar-trio-'.$trio[$i]['trio']; ?>">
						<?php
					}
					?>
					<?php echo $trio[$i]['trio'] ?>
					<?php
					if ($check == true) {
						?>
						</a>
						<?php
					}
					?> 
					</td>
					<td><?php if($sala == true){ echo $sala[0]['sala']; } ?></td>
					<td><?php echo $trio[$i]['npacce2'] ?></td>
					<td><?php echo $trio[$i]['nome2'] ?></td>
					<td><?php echo $trio[$i]['curso2'] ?></td>
				</tr>
				<tr>
					<td> 
					<?php
					if ($check == true) {
						?>
						<a href="<?php echo $way.'/'.$url[1].'/editar-trio-'.$trio[$i]['trio']; ?>">
						<?php
					}
					?>
					<?php echo $trio[$i]['trio'] ?>
					<?php
					if ($check == true) {
						?>
						</a>
						<?php
					}
					?> 
					</td>
					<td><?php if($sala == true){ echo $sala[0]['sala']; } ?></td>
					<td><?php echo $trio[$i]['npacce3'] ?></td>
					<td><?php echo $trio[$i]['nome3'] ?></td>
					<td><?php echo $trio[$i]['curso3'] ?></td>
				</tr>
				<tr>
					<td> 
					<?php
					if ($check == true) {
						?>
						<a href="<?php echo $way.'/'.$url[1].'/editar-trio-'.$trio[$i]['trio']; ?>">
						<?php
					}
					?>
					<?php echo $trio[$i]['trio'] ?>
					<?php
					if ($check == true) {
						?>
						</a>
						<?php
					}
					?> 
					</td>
					<td><?php if($sala == true){ echo $sala[0]['sala']; } ?></td>
					<td><?php echo $trio[$i]['npacce4'] ?></td>
					<td><?php echo $trio[$i]['nome4'] ?></td>
					<td><?php echo $trio[$i]['curso4'] ?></td>
				</tr>
				<?php } ?>
			</table>
			
		</div>
		<?php
		}


//==================================================================================================================
	 }else{

?>
<span style="color: red;"><h2>Prazo esgotado, o periodo de inscrição já acabou.</h2></span>
<!--
<div style="margin-left: 30px;">
	<h3>Deseja participar do processo de renovação para 2017?</h3>
<br>
<a href="?formulario" class="botao">Sim</a>
<a href="#" class="botao" style="margin-left: 20px;">Não</a>

</div>
-->
<?php } ?>



<?php } } ?>

