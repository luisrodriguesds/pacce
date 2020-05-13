
<style type="text/css">
	.tab textarea{ padding:5px 5px; border:1px #ccc solid; border-radius:2px; margin:5px 0; width: 300px; height: 100%; }
	.tab input[type=submit] { background:#069; width: 150px; height:30px; padding:0 10px; border:none; border-radius:2px; color:#FFF; cursor:pointer; margin:5px 0;}
	.tab input[type=submit]:hover{ background-color: #003E5D; } 
	.tam{ width: 300px; }
	.label{ color: #4A85A0; }
	.enc{ font-size: 12px; }
	.enc table{border-collapse:collapse;}
	.enc table td{ padding:5px 0px; text-align: center; border-collapse:collapse; }
	.enc table th{ padding:5px; text-align: center; }

	#relatoContent {
		position: absolute;
		bottom: 0;
		top: 80px;
		left: 0;
		right: 0;
		display: none;
		align-items: center;
		flex-direction: column;
		justify-content: center;
		background-color: #000000bb;
		border-radius: 8px;
	}

	#relatoContent div {
		background-color: #574B90;
		margin: 10px 30px;
		padding: 20px;
		border-radius: 8px;
		color: #fff;
	}

	#relatoContent a {
		margin: 0px 30px;
		padding: 10px;
		background-color: #574B90;
		border-radius: 8px;
		color: #fff;
	}

</style>



<div class="title"><h2>Acompanhar Articuladores</h2></div>
<p>Página destinada para a avaliação das atividades exercidas pelos Articuladores de Célula. </p>
<br>
<?php 
if (isset($url[2]) && $url[2] != '') {
	$bolsista = DBread('bolsistas', "WHERE npacce = '".$url[2]."' AND status = true AND tipoSlug = 'articulador-de-celula'", "id, npacce, nome, nomeUsual, foto, tipo, curso, campus");

	if ($bolsista == false) {
		echo '<div class="nada-encontrado">Nada Encontrado</div>';
	}else{
		$bolsista = $bolsista[0];
		?>
		<br>
		<div class="title"><h2>Avaliação do Articulador</h2></div>
		<div class="page-ati-single">
			<div class="corpo-single">
				<div class="foto-single" style="float: left;">
					<span class="foto"><img src="<?php echo URL_PAINEL.'imagensBolsistas/'.$bolsista['foto'].'';?>"><br></span>
					<div class="nome"><?php echo GetName($bolsista['nome'], $bolsista['nomeUsual']); ?></div>
				</div>
			</div>
			<div id="folha-cabecario" style="width: 50%; float: left;">
				<table style="font-size: 15px; margin-top:20px; float: left;">
					<tr>
						<th>Número PACCE:</th>
						<td><?php echo $bolsista['npacce']; ?></td>
					</tr>
					<tr>
						<th>Nome: </th>
						<td><?php echo $bolsista['nome']; ?></td>
					</tr>
					<tr>
						<th>Função:</th>
						<td><?php echo $bolsista['tipo']; ?></td>
					</tr>
					<tr>
						<th>Curso:</th>
						<td><?php echo $bolsista['curso']; ?></td>
					</tr>
					<tr>
						<th>Campus:</th>
						<td><?php echo $bolsista['campus']; ?></td>
					</tr>
				</table>
			</div>
			<div id="clear"></div>
		</div>
		<br>
		<?php 
		if (isset($url[3]) && substr($url[3], -7) == 'projeto') {
			$id = str_replace("-projeto", "", $url[3]);
			$projetos = DBread('projetos', "WHERE npacce = '".$bolsista['npacce']."' AND id = '".$id."'");
			$projeto = $projetos[0];
			?>
			<br>
			<div class="title"><h2><?php echo $projeto['titulo']; ?></h2></div>
			<?php 
			if (isset($_POST['salvar'])) {
				$form['tituloAv'] 					= GetPost('tituloAv');
				$form['sinopseAv'] 					= GetPost('sinopseAv');
				$form['introducaoAv']				= GetPost('introducaoAv');
				$form['justificativaAv'] 			= GetPost('justificativaAv');
				$form['publicoAv']					= GetPost('publicoAv');
				$form['localAv']					= GetPost('localAv');
				$form['objetivosGeraisAv'] 			= GetPost('objetivosGeraisAv');
				$form['objetivosEspecificosAv']		= GetPost('objetivosEspecificosAv');
				$form['produtosAv'] 				= GetPost('produtosAv');
				$form['indicadoresAv'] 				= GetPost('indicadoresAv');
				$form['meiosVerificacaoAv'] 		= GetPost('meiosVerificacaoAv');
				$form['atividadesAv'] 				= GetPost('atividadesAv');
				$form['fortalezasAv'] 				= GetPost('fortalezasAv');
				$form['fraquezasAv'] 				= GetPost('fraquezasAv');
				$form['estrategiasAv']				= GetPost('estrategiasAv');
				$form['insumoAv']					= GetPost('insumoAv');
				$form['publicacaoAv'] 				= GetPost('publicacaoAv');
				$form['duracaoAv']					= GetPost('duracaoAv');
				$form['cor']						= GetPost('cor');
				$form['registroAv']					= date('Y-m-d H:i:s');
				$form['npacceAv']					= $user['npacce'];
				if (DBUpDate('projetos', $form,"npacce = '".$bolsista['npacce']."' AND id = '".$id."'")) {
					echo '<script>alert("Processo de Avaliação salvo com sucesso!");
					window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
				}
			}
			?>
			<center>
				<div class="table-responsive">
					<?php 
					if ($projeto['npacceAv'] != '') {
						$nome = DBread('bolsistas', "WHERE npacce = '".$projeto['npacceAv']."'", "nome");
						?>
						<div>
							<center>
								<span><strong>Avaliado por:</strong> <?php echo $projeto['npacceAv'].' - '.$nome[0]['nome']; ?></span>
							</center>
						</div>
						<br><br>
						<?php
					}
					?>
					<form method="post">
						<table class="table table-striped">


							<tr>
								<th>Tema</th>
								<th>Avaliação do tema</th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['tema'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="temaAv"><?php echo printPost($projeto['temaAv'], 'page'); ?></textarea>
								</td>
							</tr>
							<tr>
								<th>Título</th>
								<th>Avaliação do Título</th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['titulo'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="tituloAv"><?php echo printPost($projeto['tituloAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Sinopse </th>
								<th>Avaliação da Sinopse </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['sinopse'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="sinopseAv"><?php echo printPost($projeto['sinopseAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Introdução  </th>
								<th>Avaliação - Introdução </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['introducao'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="introducaoAv"><?php echo printPost($projeto['introducaoAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Justificativa   </th>
								<th>Avaliação - Justificativa  </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['justificativa'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="justificativaAv"><?php echo printPost($projeto['justificativaAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Público Alvo   </th>
								<th>Avaliação - Público Alvo  </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['publico'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="publicoAv"><?php echo printPost($projeto['publicoAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Duração do Projeto   </th>
								<th>Avaliação - Duração do Projeto  </th>
							</tr>
							<tr>
								<td class="tam"><?php echo $projeto['duracao']; ?></td>
								<td class="espaco">
									<textarea name="duracaoAv"><?php echo $projeto['duracaoAv']; ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Local    </th>
								<th>Avaliação - Local   </th>
							</tr>
							<tr>
								<td class="tam"><?php echo $projeto['local']; ?></td>
								<td class="espaco">
									<textarea name="localAv"><?php echo $projeto['localAv']; ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Objetivos Gerais    </th>
								<th>Avaliação - Objetivos Gerais   </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['objetivosGerais'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="objetivosGeraisAv"><?php echo printPost($projeto['objetivosGeraisAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Objetivos Específicos    </th>
								<th>Avaliação - Objetivos Específicos   </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['objetivosEspecificos'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="objetivosEspecificosAv"><?php echo printPost($projeto['objetivosEspecificosAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Produtos     </th>
								<th>Avaliação - Produtos    </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['produtos'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="produtosAv"><?php echo printPost($projeto['produtosAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Indicadores de Resultados     </th>
								<th>Avaliação - Indicadores de Resultados    </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['indicadores'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="indicadoresAv"><?php echo printPost($projeto['indicadoresAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Meios de Verificação     </th>
								<th>Avaliação - Meios de Verificação    </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['meiosVerificacao'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="meiosVerificacaoAv"><?php echo printPost($projeto['meiosVerificacaoAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Atividades      </th>
								<th>Avaliação - Atividades     </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['atividades'], 'page'); ?></td>
								<td class="espaco">
									<textarea style="height: 100%;" name="atividadesAv"><?php echo printPost($projeto['atividadesAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Fortalezas       </th>
								<th>Avaliação - Fortalezas     </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['fortalezas'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="fortalezasAv"><?php echo printPost($projeto['fortalezasAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Fraquezas        </th>
								<th>Avaliação - Fraquezas       </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['fraquezas'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="fraquezasAv"><?php echo printPost($projeto['fraquezasAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Estratégias de Superação        </th>
								<th>Avaliação - Estratégias de Superação       </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['estrategias'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="estrategiasAv"><?php echo printPost($projeto['estrategiasAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Insumos        </th>
								<th>Avaliação - Insumos       </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['insumo'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="insumoAv"><?php echo printPost($projeto['insumoAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<th>Publicação         </th>
								<th>Avaliação - Publicação        </th>
							</tr>
							<tr>
								<td class="tam"><?php echo printPost($projeto['publicacao'], 'page'); ?></td>
								<td class="espaco">
									<textarea name="publicacaoAv"><?php echo printPost($projeto['publicacaoAv'], 'campo'); ?></textarea>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr><td><br></td></tr>
							<tr>
								<th colspan="2">Color</th>
							</tr>
							<tr>
								<td colspan="2">
									<center>
										<input type="color" name="cor" value="<?php echo $projeto['cor']; ?>" style="width: 150px; height: 25px; border: 2px solid #ccc;"></input> 
									</center>
								</td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<td colspan="2"><center> <input type="submit" name="salvar" value="Salvar Processo"></input> </center></td>
							</tr>

						</table>
					</form>
				</div>
			</center>
			<?php	
		}else if(isset($url[3]) && $url[3] == 'formacao'){

			$for = DBread('for_pres', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
			if ($for == false) {
				echo '<div class="title"><h2>Formação - Não há presença registrada</h2></div>';
				echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';

			}else{
				echo '<div class="title"><h2>Formação - F-'.substr($for[0]['codigo'], -2).'</h2></div>';
				?>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th></th>
							<th>Sala</th>
							<th>Participação</th>
							<th>Habilidades</th>
							<th>Responsabilidade</th>
							<th>Contribuição</th>
							<th>Protagonismo</th>
							<th>Obs</th>
						</tr>
						<?php 
						for ($i=0; $i < count($for); $i++) { 
							?>
							<tr>
								<td style="width: 10%">Semana <?php if($for[$i]['semana'] < 10){ echo '0'.$for[$i]['semana'];}else{ echo $for[$i]['semana'];} ?></td>
								<td style="cursor: pointer;width: 10%" title="<?php echo 'Avaliado por: '.$for[$i]['npacce1'].' - '.$for[$i]['nome1']; ?>"><?php echo 'F-'.substr($for[$i]['codigo'], -2);  ?></td>
								<td <?php if($for[$i]['participacao'] == 1 || $for[$i]['participacao'] == 0){  echo 'style="background-color: #E47C7C;';}else if($for[$i]['participacao'] == 2){echo 'style="background-color: #E4AC7C;';}else if($for[$i]['participacao'] == 3){ echo 'style="background-color: #E4E17C;';}else if($for[$i]['participacao'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$for[$i]['participacao'].'</strong>'; ?></td>
								<td <?php if($for[$i]['habilidades'] == 1 || $for[$i]['habilidades'] == 0){  echo 'style="background-color: #E47C7C;';}else if($for[$i]['habilidades'] == 2){echo 'style="background-color: #E4AC7C;';}else if($for[$i]['habilidades'] == 3){ echo 'style="background-color: #E4E17C;';}else if($for[$i]['habilidades'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$for[$i]['habilidades'].'</strong>'; ?></td>
								<td <?php if($for[$i]['responsabilidade'] == 1 || $for[$i]['responsabilidade'] == 0){  echo 'style="background-color: #E47C7C;';}else if($for[$i]['responsabilidade'] == 2){echo 'style="background-color: #E4AC7C;';}else if($for[$i]['responsabilidade'] == 3){ echo 'style="background-color: #E4E17C;';}else if($for[$i]['responsabilidade'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$for[$i]['responsabilidade'].'</strong>'; ?></td>
								<td <?php if($for[$i]['contribuicao'] == 1 || $for[$i]['contribuicao'] == 0){  echo 'style="background-color: #E47C7C;';}else if($for[$i]['contribuicao'] == 2){echo 'style="background-color: #E4AC7C;';}else if($for[$i]['contribuicao'] == 3){ echo 'style="background-color: #E4E17C;';}else if($for[$i]['contribuicao'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$for[$i]['contribuicao'].'</strong>'; ?></td>
								<td <?php if($for[$i]['protagonismo'] == 1 || $for[$i]['protagonismo'] == 0){  echo 'style="background-color: #E47C7C;';}else if($for[$i]['protagonismo'] == 2){echo 'style="background-color: #E4AC7C;';}else if($for[$i]['protagonismo'] == 3){ echo 'style="background-color: #E4E17C;';}else if($for[$i]['protagonismo'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$for[$i]['protagonismo'].'</strong>'; ?></td>
								<td style="cursor: pointer; width:  20%" title="<?php echo $for[$i]['obs']; ?>"> <meto><?php echo $for[$i]['obs']; ?> </td>
							</tr>
							<?php 
						}
						?>
					</table>
				</div>
				<?php 
				$obs = DBread('obs_av', "WHERE npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'formacao'");
				if (isset($_POST['salvar'])) {
					$form['npacce'] 		= $bolsista['npacce'];
					$form['npacceAv']		= $user['npacce'];
					$form['atividade']		= 'Formação';
					$form['atividadeSlug'] 	= 'formacao';
					$form['obs']			= GetPost('obs');
					$form['registro']		= date('Y-m-d H:i:s');
					$form['status']			= 1;

					if($obs == false){
						if (DBcreate('obs_av', $form)) {
							echo '<script>alert("Avaliação enviada com Sucesso!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}else{
						if (DBUpDate('obs_av', $form, "npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'formacao'")) {
							echo '<script>alert("Avaliação enviada com Sucesso!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}
				}
				?>
				<div id="editar-ativ" class="form">
					<form method="post">
						<label class="label">Observação</label>
						<br>Faça sua avaliação geral de formação desse articulador<br>
						<textarea name="obs"><?php if($obs == true){ echo printPost($obs[0]['obs'], 'campo');} ?></textarea>
						<center>
							<input type="submit" name="salvar" value="Salvar"></input>
						</center>
					</form>
				</div>
				<?php
			}
			?>

			<?php
		}else if(isset($url[3]) && $url[3] == 'apoio-a-celula'){
			$apo = DBread('apo_pres', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
			if ($apo == false) {
				echo '<div class="title"><h2>Apoio à Célula - Não há presençaregistrada</h2></div>';
				echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';

			}else{
				echo '<div class="title"><h2>Apoio à Célula - A-'.substr($apo[0]['codigo'], -2).'</h2></div>';
				?>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th></th>
							<th>Sala</th>
							<th>Participação</th>
							<th>Habilidades</th>
							<th>Responsabilidade</th>
							<th>Contribuição</th>
							<th>Protagonismo</th>
							<th>Obs</th>
						</tr>
						<?php 
						for ($i=0; $i < count($apo); $i++) { 
							?>
							<tr>
								<td style="width: 10%">Semana <?php if($apo[$i]['semana'] < 10){ echo '0'.$apo[$i]['semana'];}else{ echo $apo[$i]['semana'];} ?></td>
								<td style="cursor: pointer;width: 10%" title="<?php echo 'Avaliado por: '.$apo[$i]['npacce1'].' - '.$apo[$i]['nome1']; ?>"><?php echo 'F-'.substr($apo[$i]['codigo'], -2);  ?></td>
								<td <?php if($apo[$i]['participacao'] == 1 || $apo[$i]['participacao'] == 0){  echo 'style="background-color: #E47C7C;';}else if($apo[$i]['participacao'] == 2){echo 'style="background-color: #E4AC7C;';}else if($apo[$i]['participacao'] == 3){ echo 'style="background-color: #E4E17C;';}else if($apo[$i]['participacao'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$apo[$i]['participacao'].'</strong>'; ?></td>
								<td <?php if($apo[$i]['habilidades'] == 1 || $apo[$i]['habilidades'] == 0){  echo 'style="background-color: #E47C7C;';}else if($apo[$i]['habilidades'] == 2){echo 'style="background-color: #E4AC7C;';}else if($apo[$i]['habilidades'] == 3){ echo 'style="background-color: #E4E17C;';}else if($apo[$i]['habilidades'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$apo[$i]['habilidades'].'</strong>'; ?></td>
								<td <?php if($apo[$i]['responsabilidade'] == 1 || $apo[$i]['responsabilidade'] == 0){  echo 'style="background-color: #E47C7C;';}else if($apo[$i]['responsabilidade'] == 2){echo 'style="background-color: #E4AC7C;';}else if($apo[$i]['responsabilidade'] == 3){ echo 'style="background-color: #E4E17C;';}else if($apo[$i]['responsabilidade'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$apo[$i]['responsabilidade'].'</strong>'; ?></td>
								<td <?php if($apo[$i]['contribuicao'] == 1 || $apo[$i]['contribuicao'] == 0){  echo 'style="background-color: #E47C7C;';}else if($apo[$i]['contribuicao'] == 2){echo 'style="background-color: #E4AC7C;';}else if($apo[$i]['contribuicao'] == 3){ echo 'style="background-color: #E4E17C;';}else if($apo[$i]['contribuicao'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$apo[$i]['contribuicao'].'</strong>'; ?></td>
								<td <?php if($apo[$i]['protagonismo'] == 1 || $apo[$i]['protagonismo'] == 0){  echo 'style="background-color: #E47C7C;';}else if($apo[$i]['protagonismo'] == 2){echo 'style="background-color: #E4AC7C;';}else if($apo[$i]['protagonismo'] == 3){ echo 'style="background-color: #E4E17C;';}else if($apo[$i]['protagonismo'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$apo[$i]['protagonismo'].'</strong>'; ?></td>
								<td style="cursor: pointer; width:  20%" title="<?php echo $apo[$i]['obs']; ?>"> <meto><?php echo $apo[$i]['obs']; ?> </td>
							</tr>
							<?php 
						}
						?>
					</table>
				</div>
				<?php 
				$obs = DBread('obs_av', "WHERE npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'apoio-a-celula'");
				if (isset($_POST['salvar'])) {
					$form['npacce'] 		= $bolsista['npacce'];
					$form['npacceAv']		= $user['npacce'];
					$form['atividade']		= 'Apoio à Célula';
					$form['atividadeSlug'] 	= 'apoio-a-celula';
					$form['obs']			= GetPost('obs');
					$form['registro']		= date('Y-m-d H:i:s');
					$form['status']			= 1;

					if($obs == false){
						if (DBcreate('obs_av', $form)) {
							echo '<script>alert("Avaliação enviada com Sucesso!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}else{
						if (DBUpDate('obs_av', $form, "npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'apoio-a-celula'")) {
							echo '<script>alert("Avaliação enviada com Sucesso!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}
				}
				?>
				<div id="editar-ativ" class="form">
					<form method="post">
						<label class="label">Observação</label>
						<br>Faça sua avaliação geral de apoio à célula desse articulador<br>
						<textarea name="obs"><?php if($obs == true){ echo printPost($obs[0]['obs'], 'campo');} ?></textarea>
						<center>
							<input type="submit" name="salvar" value="Salvar"></input>
						</center>
					</form>
				</div>

				<?php
			}
		}else if(isset($url[3]) && $url[3] == 'historia-de-vida'){
			$rod = DBread('rod_pres', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
			if ($rod == false) {
				echo '<div class="title"><h2>História de Vida - Não há presença registrada</h2></div>';
				echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';

			}else{
				echo '<div class="title"><h2>História de Vida - H-'.substr($rod[0]['codigo'], -2).'</h2></div>';
				?>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th></th>
							<th>Sala</th>
							<th>Participação</th>
							<th>Habilidades</th>
							<th>Responsabilidade</th>
							<th>Contribuição</th>
							<th>Protagonismo</th>
							<th>Obs</th>
						</tr>
						<?php 
						for ($i=0; $i < count($rod); $i++) { 
							?>
							<tr>
								<td style="width: 10%">Semana <?php if($rod[$i]['semana'] < 10){ echo '0'.$rod[$i]['semana'];}else{ echo $rod[$i]['semana'];} ?></td>
								<td style="cursor: pointer;width: 10%" title="<?php echo 'Avaliado por: '.$rod[$i]['npacce1'].' - '.$rod[$i]['nome1']; ?>"><?php echo 'F-'.substr($rod[$i]['codigo'], -2);  ?></td>
								<td <?php if($rod[$i]['participacao'] == 1 || $rod[$i]['participacao'] == 0){  echo 'style="background-color: #E47C7C;';}else if($rod[$i]['participacao'] == 2){echo 'style="background-color: #E4AC7C;';}else if($rod[$i]['participacao'] == 3){ echo 'style="background-color: #E4E17C;';}else if($rod[$i]['participacao'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$rod[$i]['participacao'].'</strong>'; ?></td>
								<td <?php if($rod[$i]['habilidades'] == 1 || $rod[$i]['habilidades'] == 0){  echo 'style="background-color: #E47C7C;';}else if($rod[$i]['habilidades'] == 2){echo 'style="background-color: #E4AC7C;';}else if($rod[$i]['habilidades'] == 3){ echo 'style="background-color: #E4E17C;';}else if($rod[$i]['habilidades'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$rod[$i]['habilidades'].'</strong>'; ?></td>
								<td <?php if($rod[$i]['responsabilidade'] == 1 || $rod[$i]['responsabilidade'] == 0){  echo 'style="background-color: #E47C7C;';}else if($rod[$i]['responsabilidade'] == 2){echo 'style="background-color: #E4AC7C;';}else if($rod[$i]['responsabilidade'] == 3){ echo 'style="background-color: #E4E17C;';}else if($rod[$i]['responsabilidade'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$rod[$i]['responsabilidade'].'</strong>'; ?></td>
								<td <?php if($rod[$i]['contribuicao'] == 1 || $rod[$i]['contribuicao'] == 0){  echo 'style="background-color: #E47C7C;';}else if($rod[$i]['contribuicao'] == 2){echo 'style="background-color: #E4AC7C;';}else if($rod[$i]['contribuicao'] == 3){ echo 'style="background-color: #E4E17C;';}else if($rod[$i]['contribuicao'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$rod[$i]['contribuicao'].'</strong>'; ?></td>
								<td <?php if($rod[$i]['protagonismo'] == 1 || $rod[$i]['protagonismo'] == 0){  echo 'style="background-color: #E47C7C;';}else if($rod[$i]['protagonismo'] == 2){echo 'style="background-color: #E4AC7C;';}else if($rod[$i]['protagonismo'] == 3){ echo 'style="background-color: #E4E17C;';}else if($rod[$i]['protagonismo'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$rod[$i]['protagonismo'].'</strong>'; ?></td>
								<td style="cursor: pointer; width:  20%" title="<?php echo $rod[$i]['obs']; ?>"> <meto><?php echo $rod[$i]['obs']; ?> </td>
							</tr>
							<?php 
						}
						?>
					</table>
				</div>
				<?php 
				$obs = DBread('obs_av', "WHERE npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'historia-de-vida'");
				if (isset($_POST['salvar'])) {
					$form['npacce'] 		= $bolsista['npacce'];
					$form['npacceAv']		= $user['npacce'];
					$form['atividade']		= 'História de Vida';
					$form['atividadeSlug'] 	= 'historia-de-vida';
					$form['obs']			= GetPost('obs');
					$form['registro']		= date('Y-m-d H:i:s');
					$form['status']			= 1;

					if($obs == false){
						if (DBcreate('obs_av', $form)) {
							echo '<script>alert("Avaliação enviada com Sucesso!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}else{
						if (DBUpDate('obs_av', $form, "npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'historia-de-vida'")) {
							echo '<script>alert("Avaliação enviada com Sucesso!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}
				}
				?>
				<div id="editar-ativ" class="form">
					<form method="post">
						<label class="label">Observação</label>
						<br>Faça sua avaliação geral de história de vida desse articulador<br>
						<textarea name="obs"><?php if($obs == true){ echo printPost($obs[0]['obs'], 'campo');} ?></textarea>
						<center>
							<input type="submit" name="salvar" value="Salvar"></input>
						</center>
					</form>
				</div>	
				<?php
			}
		}else if(isset($url[3]) && $url[3] == 'interacao'){
			$int = DBread('int_insc', "WHERE npacce = '".$bolsista['npacce']."' ORDER BY semana ASC");
			if ($int == false) {
				echo '<div class="title"><h2>Interação - Não há presença registrada</h2></div>';
				echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
			}else{
				echo '<div class="title"><h2>Interação</h2></div>';
				?>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th></th>
							<th>Interação</th>
							<th>Participação</th>
							<th>Habilidades</th>
							<th>Responsabilidade</th>
							<th>Contribuição</th>
							<th>Protagonismo</th>
							<th>Obs</th>
						</tr>
						<?php 
						for ($i=0; $i < count($int); $i++) { 
							?>
							<tr>
								<td style="width: 10%">Semana <?php if($int[$i]['semana'] < 10){ echo '0'.$int[$i]['semana'];}else{ echo $int[$i]['semana'];} ?></td>
								<td style="cursor: pointer; width: 10%" title="<?php echo 'Avaliado por: '.$int[$i]['npacce1'].'  - '.$int[$i]['nome1'].' - '.$int[$i]['titulo']; ?>"><meto></td>
								<td <?php if($int[$i]['participacao'] == 1 || $int[$i]['participacao'] == 0){  echo 'style="background-color: #E47C7C;';}else if($int[$i]['participacao'] == 2){echo 'style="background-color: #E4AC7C;';}else if($int[$i]['participacao'] == 3){ echo 'style="background-color: #E4E17C;';}else if($int[$i]['participacao'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$int[$i]['participacao'].'</strong>'; ?></td>
								<td <?php if($int[$i]['habilidades'] == 1 || $int[$i]['habilidades'] == 0){  echo 'style="background-color: #E47C7C;';}else if($int[$i]['habilidades'] == 2){echo 'style="background-color: #E4AC7C;';}else if($int[$i]['habilidades'] == 3){ echo 'style="background-color: #E4E17C;';}else if($int[$i]['habilidades'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$int[$i]['habilidades'].'</strong>'; ?></td>
								<td <?php if($int[$i]['responsabilidade'] == 1 || $int[$i]['responsabilidade'] == 0){  echo 'style="background-color: #E47C7C;';}else if($int[$i]['responsabilidade'] == 2){echo 'style="background-color: #E4AC7C;';}else if($int[$i]['responsabilidade'] == 3){ echo 'style="background-color: #E4E17C;';}else if($int[$i]['responsabilidade'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$int[$i]['responsabilidade'].'</strong>'; ?></td>
								<td <?php if($int[$i]['contribuicao'] == 1 || $int[$i]['contribuicao'] == 0){  echo 'style="background-color: #E47C7C;';}else if($int[$i]['contribuicao'] == 2){echo 'style="background-color: #E4AC7C;';}else if($int[$i]['contribuicao'] == 3){ echo 'style="background-color: #E4E17C;';}else if($int[$i]['contribuicao'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$int[$i]['contribuicao'].'</strong>'; ?></td>
								<td <?php if($int[$i]['protagonismo'] == 1 || $int[$i]['protagonismo'] == 0){  echo 'style="background-color: #E47C7C;';}else if($int[$i]['protagonismo'] == 2){echo 'style="background-color: #E4AC7C;';}else if($int[$i]['protagonismo'] == 3){ echo 'style="background-color: #E4E17C;';}else if($int[$i]['protagonismo'] == 4){echo 'style="background-color: #7CE497;';}else{ echo 'style="background-color: #7CC2E4;'; } ?> <?php echo 'width: 2% "' ?> ><?php echo '<strong>'.$int[$i]['protagonismo'].'</strong>'; ?></td>
								<td style="cursor: pointer;" title="<?php echo $int[$i]['obs']; ?>"> <?php echo $int[$i]['obs']; ?> </td>
							</tr>
							<?php 
						}
						?>
					</table>
				</div>
				<?php 
				$obs = DBread('obs_av', "WHERE npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'interacao'");
				if (isset($_POST['salvar'])) {
					$form['npacce'] 		= $bolsista['npacce'];
					$form['npacceAv']		= $user['npacce'];
					$form['atividade']		= 'Interação';
					$form['atividadeSlug'] 	= 'interacao';
					$form['obs']			= GetPost('obs');
					$form['registro']		= date('Y-m-d H:i:s');
					$form['status']			= 1;

					if($obs == false){
						if (DBcreate('obs_av', $form)) {
							echo '<script>alert("Avaliação enviada com Sucesso!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}else{
						if (DBUpDate('obs_av', $form, "npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'interacao'")) {
							echo '<script>alert("Avaliação enviada com Sucesso!");
							window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
						}
					}
				}
				?>
				<div id="editar-ativ" class="form">
					<form method="post">
						<label class="label">Observação</label>
						<br>Faça sua avaliação geral de interação desse articulador<br>
						<textarea name="obs"><?php if($obs == true){ echo printPost($obs[0]['obs'], 'campo');} ?></textarea>
						<center>
							<input type="submit" name="salvar" value="Salvar"></input>
						</center>
					</form>
				</div>			
				<?php
			}
		}else if(isset($url[3]) && $url[3] == 'reposicao'){
			echo '<div class="title"><h2>Reposição de Atividade</h2></div>';
			if (isset($_GET['codigo']) && $_GET['codigo'] != '') {
				$rep = DBread('rep_ativ', "WHERE npacce = '".$bolsista['npacce']."' AND codigo = '".$_GET['codigo']."'");
				if ($rep == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{
					if (isset($_POST['salvar'])) {
						$form['codigo']			= $rep[0]['codigo'];
						$form['npacce']			= $bolsista['npacce'];
						$reposicao['presenca'] 	= GetPost('avaliacao');
						$form['parecer'] 		= GetPost('parecer');
						$form['cor']			= GetPost('cor');
						if (empty($reposicao['presenca'])) {
							echo '<script>alert("Campo presença está vazio!");</script>';
						}else if(empty($form['parecer'])){
							echo '<script>alert("Campo parecer está vazio!");</script>';
						}else if(empty($form['cor']) || $form['cor'] == '#fff'){
							echo '<script>alert("Campo cor está vazio!");</script>';
						}else{
							if (substr($form['codigo'], 0,3) == 'FOR') {
								if (DBupDate('for_pres', $reposicao," codigo = '".$form['codigo']."' AND npacce = '".$form['npacce']."' ")) {
									if (DBupDate('rep_ativ', $form, " codigo = '".$form['codigo']."' AND npacce = '".$form['npacce']."'")) {
										$msg['npacceRemetente'] 	= $user['npacce'];
										$msg['remetente']			= $user['nome'];
										$msg['npacceDestinatario']	= $bolsista['npacce'];
										$msg['destinatario']		= $bolsista['nome'];
										$msg['assunto']				= '[Mensagem Automática]';
										$msg['conteudo']			= 'Sua reposição foi avaliada, verifique o resultado <br><br> <strong>SIGA - PACCE</strong>';
										$msg['status']				= 1;
										$msg['ler']					= 0;
										$msg['registro']			= date('y-m-d H:i:s');
										if (DBcreate('msg', $msg)) {
											echo '<script>alert("Processo salvo com sucesso!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
										}
									}
								}	
							}else if (substr($form['codigo'], 0,3) == 'APO') {


								if (DBupDate('apo_pres', $reposicao," codigo = '".$form['codigo']."' AND npacce = '".$form['npacce']."'")) {
									if (DBupDate('rep_ativ', $form, "codigo = '".$form['codigo']."' AND npacce = '".$form['npacce']."'")) {
										$msg['npacceRemetente'] 	= $user['npacce'];
										$msg['remetente']			= $user['nome'];
										$msg['npacceDestinatario']	= $bolsista['npacce'];
										$msg['destinatario']		= $bolsista['nome'];
										$msg['assunto']				= '[Mensagem Automática]';
										$msg['conteudo']			= 'Sua reposição foi avaliada, verifique o resultado <br><br> <strong>SIGA - PACCE</strong>';
										$msg['status']				= 1;
										$msg['ler']					= 0;
										$msg['registro']			= date('y-m-d H:i:s');
										if (DBcreate('msg', $msg)) {
											echo '<script>alert("Processo salvo com sucesso!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
										}
									}
								}

							}else{
								if (DBupDate('eventos_pres', $reposicao," codigo = '".$form['codigo']."' AND npacce = '".$form['npacce']."'")) {
									if (DBupDate('rep_ativ', $form, "codigo = '".$form['codigo']."' AND npacce = '".$form['npacce']."'")) {
										$msg['npacceRemetente'] 	= $user['npacce'];
										$msg['remetente']			= $user['nome'];
										$msg['npacceDestinatario']	= $bolsista['npacce'];
										$msg['destinatario']		= $bolsista['nome'];
										$msg['assunto']				= '[Mensagem Automática]';
										$msg['conteudo']			= 'Sua reposição foi avaliada, verifique o resultado <br><br> <strong>SIGA - PACCE</strong>';
										$msg['status']				= 1;
										$msg['ler']					= 0;
										$msg['registro']			= date('y-m-d H:i:s');
										if (DBcreate('msg', $msg)) {
											echo '<script>alert("Processo salvo com sucesso!");
											window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';
										}
									}
								}
							}
						}
					}

					?>
					<div style="width: 60%; margin: 0 auto;">
						<br>
						<label class="label"><h2>Resgate</h2></label>
						<p>
							<?php echo printPost($rep[0]['resgate'], 'page'); ?>
						</p>
						<br><br>
						<label class="label"><h2>Resenha</h2></label>
						<p style="text-align: justify;">
							<?php echo printPost($rep[0]['resenha'], 'page'); ?>
						</p>
						<div class="form">
							<br><br>
							<label class="label"><h3>Avaliação da Reposição</h3></label><br>
							<form method="post">
								<?php 

								if (substr($rep[0]['codigo'], 0,3) == 'FOR') {
									$pres = DBread('for_pres', "WHERE npacce = '".$bolsista['npacce']."' AND codigo = '".$rep[0]['codigo']."'");

									?>
									<input type="radio" name="avaliacao" value="3" <?php if($pres == true && $pres[0]['presenca'] == 3){ echo 'checked="checked"';} ?> />  Reposição inconsistente, precisa ser refeita. <br><br>
									<input type="radio" name="avaliacao" value="2" <?php if($pres == true && $pres[0]['presenca'] == 2){ echo 'checked="checked"';} ?> />  Reposição consistente, não precisa ser refeita. <br><br>

									<?php
								}else if(substr($rep[0]['codigo'], 0,3) == 'APO'){
									$pres = DBread('apo_pres', "WHERE npacce = '".$bolsista['npacce']."' AND codigo = '".$rep[0]['codigo']."'");
									?>
									<input type="radio" name="avaliacao" value="3" <?php if($pres == true && $pres[0]['presenca'] == 3){ echo 'checked="checked"';} ?> />  Reposição inconsistente, precisa ser refeita. <br><br>
									<input type="radio" name="avaliacao" value="2" <?php if($pres == true && $pres[0]['presenca'] == 2){ echo 'checked="checked"';} ?> />  Reposição consistente, não precisa ser refeita. <br><br>

									<?php
								}else{
									$pres = DBread('eventos_pres', "WHERE npacce = '".$bolsista['npacce']."' AND codigo = '".$rep[0]['codigo']."'");

									?>
									<input type="radio" name="avaliacao" value="5" <?php if($pres == true && $pres[0]['presenca'] == 5){ echo 'checked="checked"';} ?> />  Reposição inconsistente, precisa ser refeita. <br><br>
									<input type="radio" name="avaliacao" value="3" <?php if($pres == true && $pres[0]['presenca'] == 3){ echo 'checked="checked"';} ?> />  Reposição consistente, não precisa ser refeita. <br><br>

									<?php
								}
								?>
								<br>
								<label>Parecer</label>
								<textarea placeholder="Digite um parecer sobre essa Reposição" name="parecer"><?php if($rep[0]['parecer'] != null || $rep[0]['parecer'] != ''){ echo printPost($rep[0]['parecer'], 'campo');}  ?></textarea>
								<center>
									<input type="color" name="cor" <?php if($rep[0]['cor'] != null){ echo 'value="'.$rep[0]['cor'].'"';}else{ echo 'value="#fff"';} ?> /><br><br>
									<input type="submit" name="salvar" value="Salvar" />

								</center>
							</form>	
						</div>
					</div>
					<?php
				}
			}else{
				$rep = DBread('rep_ativ', "WHERE npacce = '".$bolsista['npacce']."'", "id, codigo, cor, registro");
				if ($rep == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{
					?>
					<div class="table-responsive">
						<table class="table table-striped">
							<tr>
								<th>Código</th>
								<th>Atividade</th>
								<th>Semana</th>
								<th>Registro</th>
								<th>Cor</th>
							</tr>
							<?php 
							for ($i=0; $i < count($rep); $i++) {
								$atv = '';
								if (substr($rep[$i]['codigo'], 0, 3) == 'APO') {
									$atv = 'Apoio à Célula';
								}else if (substr($rep[$i]['codigo'], 0, 3) == 'FOR') {
									$atv = 'Formação';
								}else if (substr($rep[$i]['codigo'], 0, 3) == 'ROD') {
									$atv = 'História de Vida';
								}else{
									$atv = 'Atividades Coletivas';
								} 
								?>
								<tr>
									<td><a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/reposicao?codigo='.$rep[$i]['codigo']; ?>"><?php echo $rep[$i]['codigo']; ?></a></td>
									<td><?php echo $atv; ?></td>
									<td><?php echo substr($rep[$i]['codigo'], -4, 2); ?></td>
									<td><?php echo date('d/m/y H:i:s', strtotime($rep[$i]['registro'])); ?></td>
									<td <?php if($rep[$i]['cor'] == null || $rep[$i]['cor'] == ''){ echo 'style="background: #fff;"';}else{ echo 'style="background: '.$rep[$i]['cor'].';"';} ?>></td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<?php
				}
			}
		}else if (isset($url[3]) && $url[3] == 'justificativa') {

			echo '<div class="title"><h2>Justificativas</h2></div>';
			if (isset($_GET['codigo']) && $_GET['codigo'] != '') {
				$just = DBread('just_ativ', "WHERE npacce = '".$bolsista['npacce']."' AND codigo = '".$_GET['codigo']."'");
				if ($just == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{
					if (isset($_POST['salvar'])) {
						$form['situacao'] = GetPost('avaliacao');
						$form['cor'] = GetPost('cor');
						$form['parecer'] = GetPost('parecer');
						if (empty($form['situacao'])) {
							echo '<script>alert("Campo situação está vazio!");</script>';
						}else if (empty($form['cor']) || $form['cor'] == '#fff') {
							echo '<script>alert("Campo cor está vazio!");</script>';
						}else if (empty($form['parecer'])) {
							echo '<script>alert("Campo parecer está vazio!");</script>';
						}else{
							if (DBupDate('just_ativ', $form, "npacce = '".$bolsista['npacce']."' AND codigo = '".$_GET['codigo']."'")) {
								echo '<script>alert("Processo salvo com sucesso!");
								window.location="'.$way.'/'.$url[1].'/'.$url[2].'";</script>';	
							}
						}
					}
					?>
					<div style="width: 60%; margin: 0 auto;">
						<br>
						<label class="label"><h2>Justificativa - <?php echo $_GET['codigo']; ?></h2></label>
						<p>
							<br>
							<?php echo printPost($just[0]['justificativa'], 'page'); ?>
						</p><br><br> 
						<div class="form">
							<form method="post">
								<label class="label">Avaliar Justificativa</label><br><br>
								<input type="radio" name="avaliacao" value="1" <?php if($just == true && $just[0]['situacao'] == 1){ echo 'checked="checked"';} ?> />  Justificativa aprovada. <br><br>
								<input type="radio" name="avaliacao" value="2" <?php if($just == true && $just[0]['situacao'] == 2){ echo 'checked="checked"';} ?> />  Justificativa Reprovada. <br><br>
								<textarea placeholder="Digite um parecer sobre essa Justificativa" name="parecer"><?php if($just[0]['parecer'] != null || $just[0]['parecer'] != ''){ echo printPost($just[0]['parecer'], 'campo');}  ?></textarea>
								<center>
									<input type="color" name="cor" <?php if($just[0]['cor'] != null){ echo 'value="'.$just[0]['cor'].'"';}else{ echo 'value="#fff"';} ?> /><br><br>
									<input type="submit" name="salvar" value="Salvar" />
								</center>
							</form>
						</div>
					</div>

					<?php
				}
			}else{
				$just = DBread('just_ativ', "WHERE npacce = '".$bolsista['npacce']."'", "id, codigo, cor, registro");
				if ($just == false) {
					echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
				}else{
					?>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th>Código</th>
								<th>Atividade</th>
								<th>Semana</th>
								<th>Registro</th>
								<th>Cor</th>
							</tr>
							<?php 
							for ($i=0; $i < count($just); $i++) {
								$atv = '';
								if (substr($just[$i]['codigo'], 0, 3) == 'APO') {
									$atv = 'Apoio à Célula';
								}else if (substr($just[$i]['codigo'], 0, 3) == 'FOR') {
									$atv = 'Formação';
								}else if (substr($just[$i]['codigo'], 0, 3) == 'ROD') {
									$atv = 'História de Vida';
								}else if (substr($just[$i]['codigo'], 0, 3) == 'INT') {
									$atv = 'Interação';
								}else{
									$atv = 'Atividades Coletivas';
								} 
								?>
								<tr>
									<td><a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/justificativa?codigo='.$just[$i]['codigo']; ?>"><?php echo $just[$i]['codigo']; ?></a></td>
									<td><?php echo $atv; ?></td>
									<td><?php echo substr($just[$i]['codigo'], -4, 2); ?></td>
									<td><?php echo date('d/m/y H:i:s', strtotime($just[$i]['registro'])); ?></td>
									<td <?php if($just[$i]['cor'] == null || $just[$i]['cor'] == ''){ echo 'style="background: #000;"';}else{ echo 'style="background: '.$just[$i]['cor'].';"';} ?>></td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<?php
				}
			}
		}else if (isset($url[3]) && $url[3] == 'encontros-de-celula') {
			echo '<div class="title"><h2>Horário da Célula</h2></div>';
			$horario = DBread('horario_celula', "WHERE npacce = '".$bolsista['npacce']."' AND status = true");
			if ($horario == false) {
				echo '<div class="nada-encontrado"><h2>Não há célula cadastrada</h2></div>';
			}else{
				?>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th>Título</th>
							<th>Campus</th>
							<th>Local</th>
							<th>Dia e Hora</th>
							<th>Semestre</th>
							<th>Status</th>
						</tr>
						<?php 
						for ($i=0; $i < count($horario); $i++) { 
							?>
							<tr>
								<td><?php echo texto($horario[$i]['titulo'], 30); ?></td>
								<td><?php echo $horario[$i]['campus']; ?></td>
								<td><?php echo $horario[$i]['bloco'].' - '.$horario[$i]['sala']; ?></td>
								<td><?php echo $horario[$i]['diaSemana']; ?> | <?php echo date('H:i', strtotime($horario[$i]['inicio'])).'hr'; ?> - <?php echo date('H:i', strtotime($horario[$i]['fim'])).'hr'; ?>
								<?php 
								if ($horario[$i]['diaSemana2'] != 1) {
									echo '<br>'.$horario[$i]['diaSemana2'].' | '. date('H:i', strtotime($horario[$i]['inicio2'])).'hr - '.date('H:i', strtotime($horario[$i]['fim2'])).'hr';
								}
								?>
								</td>
								<td><?php echo $horario[$i]['semestre']; ?></td>
								<td><?php if($horario[$i]['status'] == 1){echo "Ativo";}else{echo "Inativo";} ?></td>
							</tr>
							<?php 
						}
						?>
					</table>
				</div>
				<?php
			}
			echo '<br><br><div class="title"><h2>Encontro de Célula</h2></div>';

			$obs = DBread('obs_av', "WHERE npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'encontro-de-celula'");
			if (isset($_POST['salvar'])) {
				$form['npacce'] 		= $bolsista['npacce'];
				$form['npacceAv']		= $user['npacce'];
				$form['atividade']		= 'Encontro de Célula';
				$form['atividadeSlug'] 	= 'encontro-de-celula';
				$form['obs']			= GetPost('obs');
				$form['registro']		= date('Y-m-d H:i:s');
				$form['status']			= 1;

				if($obs == false){
					if (DBcreate('obs_av', $form)) {
						echo '<script>alert("Avaliação enviada com Sucesso!");
						window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
					}
				}else{
					if (DBUpDate('obs_av', $form, "npacce = '".$bolsista['npacce']."' AND atividadeSlug = 'encontro-de-celula'")) {
						echo '<script>alert("Avaliação enviada com Sucesso!");
						window.location="'.$way.'/'.$url[1].'/'.$url[2].'/'.$url[3].'";</script>';
					}
				}
			}

			$enc = DBread('enc_celula', "WHERE npacce = '".$bolsista['npacce']."'");
			if ($enc == false) {
				echo '<div class="nada-encontrado"><h2>Não há encontros de células</h2></div>';
			}else{

				?>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th></th>
							<th>Reunião</th>
							<th>Data</th>
							<th>CH</th>
							<th>Membros</th>
							<th>Pilares</th>
							<th title="Pontualidade e Assiduidade do Grupo">A</th>
							<th title="Aproveitamento do Tempo" >B</th>
							<th title="Responsabilidade do grupo">C</th>
							<th title="Colaboração dos membros (habilidades)">D</th>
							<th title="Nível de interesse no aprendizado do grupo (interação)">E</th>
							<th title="Nível de participação no Processamento de Grupo">F</th>
							<th title="Quanto cumpriu do planejado">G</th>
							<th>Relato</th>
							<th>Atividade</th>
						</tr>
						<?php 
						for ($i=0; $i < count($enc); $i++) { 
							?>
							<tr <?php if ($i != 0) { echo 'style="border-top-style: solid; border-top-width: 1px;"'; } ?> >
								<td>Semana <?php if($enc[$i]['semana'] <= 10){ echo '0'.$enc[$i]['semana'];}else{ echo $enc[$i]['semana'];} ?></td>
								<td>
								<?php
								if ($enc[$i]['reuniao'] == 1) {
									echo 'Houve reunião';
								}else if ($enc[$i]['reuniao'] == 2) {
									echo 'Não houve <br> nenhuma atividade';
								}else if ($enc[$i]['reuniao'] == 3) {
									echo 'Não houve atividade, <br> mas trabalhou';
								} 
								?>
									
								</td>
								<td><?php if($enc[$i]['reuniao'] == 2 || $enc[$i]['reuniao'] == 3){ echo '--/--/--';}else{ echo date('d/m/y', strtotime($enc[$i]['data']));} ?></td>
								<td><?php if($enc[$i]['reuniao'] == 2){ echo '--:--';}else{ echo date('H:i', strtotime($enc[$i]['ch']));} ?></td>
								<td title="<?php echo $enc[$i]['membros']; ?>"> <meto> </td>
								<td title="<?php echo $enc[$i]['pilares']; ?>"> <meto> </td>
								<td><?php echo $enc[$i]['pontualidade']; ?></td>
								<td><?php echo $enc[$i]['aproveitamento']; ?></td>
								<td><?php echo $enc[$i]['responsabilidade']; ?></td>
								<td><?php echo $enc[$i]['colaboracao']; ?></td>
								<td><?php echo $enc[$i]['interesse']; ?></td>
								<td><?php echo $enc[$i]['participacao']; ?></td>
								<td><?php echo $enc[$i]['planejado']; ?></td>
								<td title="<?php echo $enc[$i]['relato']; ?>"> <img onclick="showRelato('<?php echo $enc[$i]['relato']; ?>')" src="<?php echo URL_PAINEL; ?>imagens/text.png"> </td>
								<td title="<?php echo $enc[$i]['atividades']; ?>"> <meto> </td>
							</tr>
							<?php 
						} 
						?>
					</table>
					<div id="editar-ativ" class="form">
						<form method="post">
							<label class="label">Observação</label>
							<br>Faça sua avaliação geral de encontros de célula desse articulador<br>
							<textarea name="obs"><?php if($obs == true){ echo printPost($obs[0]['obs'], 'campo');} ?></textarea>
							<center>
								<input type="submit" name="salvar" value="Salvar"></input>
							</center>
						</form>
					</div>
				</div>
				<?php
			}
		}else{
			?>
			<div class="title"><h2>Atividades</h2></div>
			<div class="caixa">
				<ul>
					<?php 
					$projeto = DBread('projetos', "WHERE npacce = '".$bolsista['npacce']."'");
					if ($projeto == false) {

					}else{			

						$cont = 0;
						for ($i=0; $i < count($projeto); $i++) {

							?>
							<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/'.$projeto[$i]['id'].'-projeto'; ?>">
								<li style="background-color: #67E270;">
									<div>
										<div id="box-all-info">
											<div id="all-info">
												<h3><?php echo texto($projeto[$i]['titulo'], 20); ?></h3><br>
												<span>Status</span><br>
												<span><?php if($projeto[$i]['status'] == 0){ echo 'Inativo';}else{ echo 'Ativo';} ?></span><br><br>
												<span>Última Alteração</span><br>
												<span><?php echo date('d/m/Y', strtotime($projeto[$i]['registro'])).' às '.date('H:i', strtotime($projeto[$i]['registro'])).'hr'; ?></span><br><br>
												<span>Campos Avaliados</span><br>
												<span>0/18</span><br><br>
											</div>
										</div>
										<div id="tipo">
											Projeto 2016
										</div>
									</div>
								</li>
							</a>
							<?php 
						} 
					} 
					$for = DBread('for_insc', "WHERE npacce = '".$bolsista['npacce']."'");
					$obsFor = DBread('obs_av', "WHERE atividadeSlug = 'formacao' AND npacce = '".$url[2]."'");
					if ($for == false) {

					}else{
						?>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/formacao'; ?>">
							<li style="background-color: #E267D9;">
								<div>
									<div id="box-all-info">
										<div id="all-info">
											<h3>Formação</h3><br>
											<span>Sala</span><br>
											<span><?php echo $for[0]['sala']; ?></span><br><br>
											<span>Última Alteração</span><br>
											<span><?php if($obsFor == true){ echo date('d/m/y', strtotime($obsFor[0]['registro'])).' às '.date('H:i:s', strtotime($obsFor[0]['registro']));}else{ echo '--/--/-- às --:--:--';} ?></span><br><br>
											<span>Campos Avaliados</span><br>
											<span>12/23</span>
										</div>
									</div>
									<div id="tipo">
										Formação
									</div>
								</div>
							</li>
						</a>
					<?php } 
					$apo = DBread('apo_insc', "WHERE npacce = '".$bolsista['npacce']."'");
					$obsApo = DBread('obs_av', "WHERE atividadeSlug = 'apoio-a-celula' AND npacce = '".$url[2]."'");
					if ($apo == false) {

					}else{
						?>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/apoio-a-celula'; ?>">
							<li style="background-color: #E26767;">
								<div>
									<div id="box-all-info">
										<div id="all-info">
											<h3>Apoio à Célula</h3><br>
											<span>Sala</span><br>
											<span><?php echo $apo[0]['sala']; ?></span><br><br>
											<span>Última Alteração</span><br>
											<span><?php if($obsApo == true){ echo date('d/m/y', strtotime($obsApo[0]['registro'])).' às '.date('H:i:s', strtotime($obsApo[0]['registro']));}else{ echo '--/--/-- às --:--:--';} ?></span><br><br>
											<span>Campos Avaliados</span><br>
											<span>12/23</span>
										</div>
									</div>
									<div id="tipo">
										Apoio à Célula
									</div>
								</div>
							</li>
						</a>
					<?php } 
					$rod = DBread('rod_insc', "WHERE npacce = '".$bolsista['npacce']."'");
					$obsRod = DBread('obs_av', "WHERE atividadeSlug = 'historia-de-vida' AND npacce = '".$url[2]."'");
					if ($rod == false) {

					}else{
						?>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/historia-de-vida'; ?>">
							<li style="background-color: #E2AB67;">
								<div>
									<div id="box-all-info">
										<div id="all-info">
											<h3>História de Vida</h3><br>
											<span>Sala</span><br>
											<span><?php echo $rod[0]['sala']; ?></span><br><br>
											<span>Última Alteração</span><br>
											<span><?php if($obsRod == true){ echo date('d/m/y', strtotime($obsRod[0]['registro'])).' às '.date('H:i:s', strtotime($obsRod[0]['registro']));}else{ echo '--/--/-- às --:--:--';} ?></span><br><br>
											<span>Campos Avaliados</span><br>
											<span>12/23</span>
										</div>
									</div>
									<div id="tipo">
										História de Vida
									</div>
								</div>
							</li>
						</a>
					<?php } 
					$int = DBread('int_insc', "WHERE npacce = '".$bolsista['npacce']."'");
					$obsInt = DBread('obs_av', "WHERE atividadeSlug = 'historia-de-vida' AND npacce = '".$url[2]."'");
					if ($int == false) {
					}else{
						?>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/interacao'; ?>">
							<li style="background-color: #67BAE2;">
								<div>
									<div id="box-all-info">
										<div id="all-info">
											<h3>Interação</h3><br>
											<span>Total</span><br>
											<span><?php echo count($int); ?></span><br><br>
											<span>Última Alteração</span><br>
											<span>14/06/16 às 14:00:00</span><br><br>
											<span>Campos Avaliados</span><br>
											<span>12/23</span>
										</div>
									</div>
									<div id="tipo">
										Interação
									</div>
								</div>
							</li>
						</a>
					<?php } 
					$rep = DBread('rep_ativ', "WHERE npacce = '".$bolsista['npacce']."'", 'id');
					if ($rep == false) {
					}else{
						?>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/reposicao'; ?>">
							<li style="background-color: #DAE267;">
								<div>
									<div id="box-all-info">
										<div id="all-info">
											<h3>Reposição de Atividade</h3><br>
											<span>Total</span><br>
											<span><?php echo count($rep); ?></span><br><br>
											<span>Última Alteração</span><br>
											<span>--/--/-- às --:--:--</span><br><br>
											<span>Campos Avaliados</span><br>
											<span>0/<?php echo count($rep); ?></span>
										</div>
									</div>
									<div id="tipo">
										Reposição
									</div>
								</div>
							</li>
						</a>
					<?php }
					$just = DBread('just_ativ', "WHERE npacce = '".$bolsista['npacce']."'");
					if ($just == false) {
					}else{
						?>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/justificativa'; ?>">
							<li style="background-color: #6F67E2;">
								<div>
									<div id="box-all-info">
										<div id="all-info">
											<h3>Justificativas</h3><br>
											<span>Total</span><br>
											<span><?php echo count($just); ?></span><br><br>
											<span>Última Alteração</span><br>
											<span>--/--/-- às --:--:--</span><br><br>
											<span>Campos Avaliados</span><br>
											<span>0/<?php echo count($just); ?></span>
										</div>
									</div>
									<div id="tipo">
										Justificativa
									</div>
								</div>
							</li>
						</a>
					<?php } 
					$enc = DBread('enc_celula', "WHERE npacce = '".$bolsista['npacce']."'");
					if ($enc == false) {
					}else{
						?>
						<a href="<?php echo $way.'/'.$url[1].'/'.$url[2].'/encontros-de-celula'; ?>">
							<li style="background-color: #67E2D1;">
								<div>
									<div id="box-all-info">
										<div id="all-info">
											<h3>Encontros de Célula</h3><br>
											<span>Total</span><br>
											<span><?php echo count($enc); ?></span><br><br>
											<span>Última Alteração</span><br>
											<span>--/--/-- às --:--:--</span><br><br>
											<span>Campos Avaliados</span><br>
											<span>0/<?php echo count($enc); ?></span>
										</div>
									</div>
									<div id="tipo">
										Encontros de Célula
									</div>
								</div>
							</li>
						</a>
						<?php
					}
					?>
				</ul>
			</div>
			<?php
		}
	}
}else{
	if ($user['tipoSlug'] == 'ceo') {
		$art = DBread('link_av', "ORDER BY nome ASC");	
	}else{
		$art = DBread('link_av', "WHERE npacceAv = '".$user['npacce']."' ORDER BY nome ASC");
	}

	?>
	<div id="pesquisa">
		<form action="" method="get" enctype="multipart/form-data">
			<input type="text" name="pesquisar" OnKeyPress="" value="<?php if(isset($_GET['pesquisar'])){ echo $_GET['pesquisar'];} ?>"  placeholder="Digite o número pacce ou o nome de quem você quer procurar"></input>
			<input type="submit" name="" value="Pesquisar">
		</form>
	</div>
	<div id="clear"></div>
	<br>

	<div class="title"><h2>Articuladores</h2></div>
	<?php 
	if (isset($_GET['pesquisar']) && $_GET['pesquisar'] != '') {
		$npacce = DBescape($_GET['pesquisar']);
		echo $npacce;
		if ($user['tipoSlug'] == 'ceo') {
			$art = DBread('link_av', "WHERE npacce LIKE '%$npacce%' OR nome LIKE '%$npacce%'", "id, nome, npacce, status");
		}else{
			$art = DBread('link_av', "WHERE npacce LIKE '%$npacce%' AND npacceAv = '".$user['npacce']."' OR nome LIKE '%$npacce%' AND npacceAv = '".$user['npacce']."'", "id, nome, npacce, status");
		}


		if ($art == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
		}else{
			?>
			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th>Número PACCE</th>
						<th>Nome</th>
						<th>Status</th>
					</tr>
					<?php 
					for ($i=0; $i < count($art); $i++) { 
						?>
						<tr>
							<td><?php echo $art[$i]['npacce']; ?></td>
							<td><a href="<?php echo $way.'/'.$url[1].'/'.$art[$i]['npacce']; ?>"><?php echo $art[$i]['nome']; ?></a> </td>
							<td><?php if($art[$i]['status'] == 1){ echo 'Ativo';}else{ echo 'Inativo';} ?></td>
						</tr>
					<?php } ?>
				</table>
				<br>
				<div id="count">(<?php echo count($art); ?>)</div>
			</div>
			<?php
		}
	}else{
		if ($art == false) {
			echo '<div class="nada-encontrado"><h2>Nada encontrado</h2></div>';
		}else{
			?>
			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th>Número PACCE</th>
						<th>Nome</th>
						<th>Projeto</th>
					</tr>
					<?php 
					for ($i=0; $i < count($art); $i++) { 
						$projeto = DBread('projetos', "WHERE npacce = '".$art[$i]['npacce']."' AND status = true", "id, cor, status");
						$resPro = '';
						if ($projeto == false) {
							$resPro = 'Nenhum projeto';
						}else {
							$projeto = $projeto[0];
							if ($projeto['cor'] == null || $projeto['cor'] == '') {
								$resPro = 'Não Avaliado';
							}else if ($projeto['cor'] == '#ccc') {
								$resPro = 'Sofreu Alterações';
							}else{
								$resPro = 'Avaliado';
							}
						}
						?>	
						<tr>
							<td><?php echo $art[$i]['npacce']; ?></td>
							<td><a href="<?php echo $way.'/'.$url[1].'/'.$art[$i]['npacce']; ?>"><?php echo $art[$i]['nome']; ?></a> </td>
							<td><?php echo $resPro; ?></td>
						</tr>
					<?php } ?>
				</table>
				<br>
				<div id="count">(<?php echo count($art); ?>)</div>
			</div>
			<?php 
		} 
	} 
} 
?>



<div id="relatoContent">
	<div><?php echo $enc[6]['relato']; ?></div>
	<a onclick="hideRelato()" href="#">Voltar</a>
</div>

<script type="text/javascript">
	
	function showRelato(text) {
		var divElement = document.querySelector('#relatoContent');
		divElement.style.display = 'flex';

		var contentElement = divElement.querySelector('div');
		contentElement.innerHTML = text;
	}

	function hideRelato() {
		var divElement = document.querySelector('#relatoContent');

		divElement.style.display = 'none';
	}

</script>