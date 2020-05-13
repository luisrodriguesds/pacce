<!-- CAIXA DE MENSAGENS -->
<?php 
function paginatorCaixaRe($sql, $npacce, $maxPosts, $paginaAtual, $way){ 
		//PAGINATOR
		$resultsAll = DBread($sql, "WHERE npacceRemetente = '$npacce'");
		
		//Contagem
		$totalPost	= count($resultsAll);
		
		//Paginas
		$paginas	= ceil($totalPost / $maxPosts);
		
		if($paginaAtual > $paginas || $totalPost <= $maxPosts){
		}else{
				
			echo '<div class="pagenav clearfix">';
			
				//Pagina Inicial
				//
				echo '<a href="'.$way.'?action=enviados&&page=1" class="number" title="Primeira Página"> << </a>';
				
				//Pagina Alterior
				if($paginaAtual >= 2){
					$pagePrev = $paginaAtual - 1;
					echo '<a href="'.$way.'?action=enviados&&page='.$pagePrev.'" class="number">'.$pagePrev.'</a>';
				}
				
				//Pagina Atual
				echo '<span>'.$paginaAtual.'</span>';
				
				//Proxima Pagina
				if($paginaAtual != $paginas){
					$pageNext = $paginaAtual + 1;
					echo '<a href="'.$way.'?action=enviados&&page='.$pageNext.'" class="number">'.$pageNext.'</a>';
				}
				
				//Ultima Inicial
				echo '<a href="'.$way.'?action=enviados&&page='.$paginas.'" class="number" title="Última Página"> >> </a>';
			
			echo '</div>';
		}
	}
function paginatorCaixa($sql, $npacce, $maxPosts, $paginaAtual, $way){ 
		//PAGINATOR
		$resultsAll = DBread($sql, "WHERE npacceDestinatario = '$npacce'");
		
		//Contagem
		$totalPost	= count($resultsAll);
		
		//Paginas
		$paginas	= ceil($totalPost / $maxPosts);
		
		if($paginaAtual > $paginas || $totalPost <= $maxPosts){
		}else{
				
			echo '<div class="pagenav clearfix">';
			
				//Pagina Inicial
				//
				echo '<a href="'.$way.'?page=1" class="number" title="Primeira Página"> << </a>';
				
				//Pagina Alterior
				if($paginaAtual >= 2){
					$pagePrev = $paginaAtual - 1;
					echo '<a href="'.$way.'?page='.$pagePrev.'" class="number">'.$pagePrev.'</a>';
				}
				
				//Pagina Atual
				echo '<span>'.$paginaAtual.'</span>';
				
				//Proxima Pagina
				if($paginaAtual != $paginas){
					$pageNext = $paginaAtual + 1;
					echo '<a href="'.$way.'?page='.$pageNext.'" class="number">'.$pageNext.'</a>';
				}
				
				//Ultima Inicial
				echo '<a href="'.$way.'?page='.$paginas.'" class="number" title="Última Página"> >> </a>';
			
			echo '</div>';
		}
	}
?>

<script type="text/javascript">
	
	function marcardesmarcar(){
	    $('.marcar').each(function () {
	        if (this.checked) this.checked = false;
	        else this.checked = true;
	    });
	}

	function marcardesmarcarVet(){
	    $('.marcar').each(function () {
	    	if (this.value != 'articulador-de-celula') {
	    		if (this.checked) this.checked = false;
	        	else this.checked = true;
	    	}   
	    });
	}

</script>
<script src="<?php echo URL_PAINEL; ?>js/tinymce/tinymce.min.js"></script>
<script>

tinymce.init({
  selector: "textarea",
  height: 300,
  plugins: [
    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
  ],

  toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
  toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
  toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

  menubar: false,
  toolbar_items_size: 'small',

  style_formats: [{
    title: 'Bold text',
    inline: 'b'
  }, {
    title: 'Red text',
    inline: 'span',
    styles: {
      color: '#ff0000'
    }
  }, {
    title: 'Red header',
    block: 'h1',
    styles: {
      color: '#ff0000'
    }
  }, {
    title: 'Example 1',
    inline: 'span',
    classes: 'example1'
  }, {
    title: 'Example 2',
    inline: 'span',
    classes: 'example2'
  }, {
    title: 'Table styles'
  }, {
    title: 'Table row 1',
    selector: 'tr',
    classes: 'tablerow1'
  }],

  templates: [{
    title: 'Test template 1',
    content: 'Test 1'
  }, {
    title: 'Test template 2',
    content: 'Test 2'
  }],
  content_css: [
    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    '//www.tinymce.com/css/codepen.min.css'
  ]
});

</script>
<?php 
	if (!isset($_GET['action']) || $_GET['action'] == 'enviados') {
		echo '<form method="post" action="">';
	}
?>
<div id="msg">
	<?php 
	if (isset($_GET['action']) && $_GET['action'] == 'novo') {
		echo '<div class="title"><h2>Enviar Mensagem</h2></div>';
	}else if (isset($_GET['action']) && $_GET['action'] == 'enviados') {
		echo '<div class="title"><h2>Enviados</h2></div>';
	}else if (isset($_GET['action']) && $_GET['action'] != '') {
		echo '<div class="title"><h2>Mensagem</h2></div>';
	}else{
		echo '<div class="title"><h2>Caixa de entrada</h2></div>';
	}
	
	//EXCLUIR
	if (isset($_POST['excluir'])) {
		if (isset($_REQUEST['msg'])) {
			?>
			<script type="text/javascript">
				if(confirm("Deseja excluir essa mensagem?") == true){
		         	 <?php 
			          $cont = 0;
			          	for ($i=0; $i < count($_REQUEST['msg']); $i++) { 
			          		$id = base64_decode($_REQUEST['msg'][$i]);
			          		if (DBDelete('msg', "id = '$id'")){
			          			$cont++;
			          		}
			          	}
			          	if (count($_REQUEST['msg']) == $cont){
			          		echo 'alert("Mensagem excluida com sucesso!");
			          		window.location="'.$way.'";';
			          	}
		          ?>
		        }else{
		        	<?php echo 'window.location="'.$way.'";'; ?>
		        }
			</script>
			<?php
		}else{
			echo '<script>alert("Você precisa marcar alguma mensagem para excluir");</script>';
		}
	}
	//EXCLUIR MENSAGEM SINGLE
	if (isset($_GET['confirm']) && $_GET['confirm'] != '') {
			if (DBDelete('msg', "id = '".$_GET['confirm']."'")) {
			echo '<script type="text/javascript">alert("Mensagem excluida com sucesso!")
			window.location="'.$way.'"</script>';
		}
	}
	?>

<script type="text/javascript">
	//PARA EXCLUIR A MENSAGEM 
	function excluir(){

		if (confirm("Deseja excluir essa mensagem?")){
			window.location="<?php //echo $way.'?confirm='.base64_decode($_GET['action']); ?>";
		}
	}
	//PARA ADD OU REMOVER CAMPOS
	function duplicarCampos(){
				var clone = document.getElementById('origem').cloneNode(true);
				var destino = document.getElementById('destino');
				destino.appendChild (clone);
				var camposClonados = clone.getElementsByTagName('input');
				for(i=0; i<camposClonados.length;i++){
					camposClonados[i].value = '';
				}
			}
	function removerCampos(id){
		var node1 = document.getElementById('destino');
		node1.removeChild(node1.childNodes[0]);
	}
</script>
	<div id="caixa">
	<div id="newMsg">
		<ul>
			<li><a href="<?php echo $way.'?action=novo'; ?>">Novo</a></li>
			<li><a href="<?php echo $way.'?action=enviados'; ?>"> Enviados</a></li>
			<li>
			<?php 
				if (!isset($_GET['action']) || $_GET['action'] == 'enviados') {
					echo '<input type="submit" name="excluir" style="position: absolute; opacity: 0.0; cursor: pointer;"></input><a>Excluir</a>';
				}else{
					echo '<a onclick="excluir();" style="cursor: pointer;" onclick="excluir">Excluir</a>';
				}
			?>
			</li>
			<li><a href="#">Limpar</a></li>
			<?php 
				if (isset($_GET['action'])) {
					$resp = DBread('msg', "WHERE id = '".base64_decode($_GET['action'])."'", "id, npacceDestinatario");
					if ($resp == true) {
						if ($resp[0]['npacceDestinatario'] == $user['npacce']) {
							echo '<li><a href="'.$way.'?action=novo&&resp='.base64_encode($resp[0]['id']).'">Responder</a></li>';
						}
					}	
				}
			?>
		</ul>
	</div><br>
	<?php 
		if (isset($_GET['action']) && $_GET['action'] == 'novo') {
			if (isset($_POST['enviar'])) {
				
				if (isset($_REQUEST['comissao'])) {
					$form['npacceRemetente'] 	= $user['npacce'];
					$form['remetente']			= $user['nome'];
					$form['assunto']			= GetPost('assunto');
					$form['conteudo']			= str_replace("'", "", $_POST['conteudo']);
					$form['registro']			= date('Y-m-d H:i:s');
					$form['status']				= 1;
					$form['ler']				= 0;

					if (empty($form['assunto'])) {
						echo '<script>alert("Campo Assunto vazio");</script>';
					}else if(empty($form['conteudo'])){
						echo '<script>alert("Campo Conteúdo vazio");</script>';
					}else{
						$contFinal = 0;
						$cont = 0;
						for ($i=0; $i < count($_REQUEST['comissao']); $i++) { 
							$membro = DBread('bolsistas', "WHERE tipoSlug = '".$_REQUEST['comissao'][$i]."' AND status = true", "id, npacce, nome, email, nome");
							$contFinal = $contFinal + count($membro);
							for ($j=0; $j < count($membro); $j++) { 
								$form['npacceDestinatario']	= $membro[$j]['npacce'];
								$form['destinatario']		= $membro[$j]['nome'];
								if (DBcreate('msg', $form)) {
									$email 			 =	$membro[$j]['email'];
									$mensagem        = '<meta charset="utf-8"><h2>PACCE - UFC</h2><br><p>Você recebeu uma mensagem do PACCE, por favor verifique sua caixa de entrada em <a href="http://pacce.ufc.br/pacce/login">pacce.ufc.br</a></p><br><br><strong style="color: red;">EMAIL AUTOMÁTICO, POR FAVOR NÃO RESPONDA.</strong>';
									$email_remetente = "pacce.monitoria@eideia.ufc.br";
									$headers = "MINE-Version: 1.1\n";
								    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
								    $headers .= "From: $email_remetente\n";
								    $headers .= "Return: $email_remetente\n";
								    $headers .= "Replay-To: $email\n";
									
								    if (mail("$email", "PACCE - UFC: ".$form['assunto']."", "$mensagem", $headers, "-f$email_remetente")) {
								    	$cont++;
								    }
								}
							}
						}
						if ($contFinal == $cont) {
							echo '<script>alert("Mensagens enviadas com sucesso!");
	        				window.location="'.$way.'";</script>';
						}
					}
				}else{
					$form['npacceRemetente'] 	= $user['npacce'];
					$form['remetente']			= $user['nome'];
					$form['assunto']			= GetPost('assunto');
					$form['conteudo']			= str_replace("'", "", $_POST['conteudo']);
					$form['registro']			= date('Y-m-d H:i:s');
					$form['status']				= 1;
					$form['ler']				= 0;
					//$npacce = DBread('bolsistas', "WHERE npacce = '".$form['npacceDestinatario']."'", "id, email, nome");
					
					if (!isset($_REQUEST['npacce']) || $_REQUEST['npacce'][0] == '') {
						echo '<script>alert("Campo Número PACCE vazio");</script>';
					}else if (empty($form['assunto'])) {
						echo '<script>alert("Campo Assunto vazio");</script>';
					}else if(empty($form['conteudo'])){
						echo '<script>alert("Campo Conteúdo vazio");</script>';
					}else{
						for($i=0; $i< count($_REQUEST['npacce']); $i++){
							$form['npacceDestinatario']	= $_REQUEST['npacce'][$i];
							$npacce = DBread('bolsistas', "WHERE npacce = '".$form['npacceDestinatario']."'", "id, email, nome");
							if ($npacce == true) {
								$form['destinatario'] = $npacce[0]['nome'];
								if (DBcreate('msg', $form)) {
									$email_remetente 	= "pacce.monitoria@eideia.ufc.br";
									$email 	=	$npacce[0]['email'];
									$headers 			= "MINE-Version: 1.1\n";
								    $headers 			.= "Content-type: text/html; charset=iso-8859-1\n";
								    $headers 			.= "From: $email_remetente\n";
								    $headers 			.= "Return: $email_remetente\n";
								    $headers 			.= "Replay-To: $email\n";
								    $mensagem        	= '<meta charset="utf-8"><h2>PACCE - UFC</h2><br><p>Você recebeu uma mensagem do PACCE, por favor verifique sua caixa de entrada em <a href="http://www.pacce.ufc.br/pacce/login">www.pacce.ufc.br</a></p><br>Assunto: '.$form['assunto'].'<br><strong style="color: red;">EMAIL AUTOMÁTICO, POR FAVOR NÃO RESPONDA.</strong>';
								    if (mail("$email", "PACCE - UFC", "$mensagem", $headers, "-f$email_remetente")) {
								    	$cont++;
								    }
									echo '<script>alert("Mensagem enviada com sucesso!");
			        				window.location="'.$way.'";</script>';
									
								}
							}
							$form['npacceDestinatario']	= '';
						}
					}
				}
			}
			if (isset($_GET['resp'])) {
				$resp = DBread('msg', "WHERE id = '".base64_decode($_GET['resp'])."'");
				$resp = $resp[0];
			}else{
				$resp = false;
			}
	?>
		<div id="editar-ativ" class="form">
			 <form action="" method="post" enctype="multipart/form-data">
			<br>
			<div id="origem">
				<label class="label">Número PACCE</label> <span style="color: red">  *</span>
				<input type="text" id="fone" name="npacce[]" value="<?php if($resp == true){ echo $resp['npacceRemetente'];} ?>"  maxlength="7" onkeypress="maiuscula(this)" onkeyup="maiuscula(this)" placeholder="Digite o número PACCE do destinatário"/>
				<br><br>
			</div>
			<img  src="<?php echo URL_PAINEL; ?>imagens/add.gif" style="width: 20px; cursor: pointer; margin-right: 20px;" onclick="duplicarCampos();">
			<img  src="<?php echo URL_PAINEL; ?>imagens/delete.gif" style="width: 20px; cursor: pointer;" onclick="removerCampos(this);"> 
			
			<div id="destino">
			</div>
			<br>
			<label class="label">Ou marque os membros de comissão que irão receber essa mensagem.</label><br><br>
			
			<input type="checkbox" onclick=" marcardesmarcar(this);" name="todos"></input> Todas <br><br>
			<input type="checkbox" onclick=" marcardesmarcarVet(this);" name="todos"></input> Somente Veteranos <br><br>
			<?php 
				$comissoes = DBread('comissoes', "WHERE status = true");
				if ($comissoes == true) {
					for ($i=0; $i < count($comissoes); $i++) {
						if ($user['tipoSlug'] == 'ceo' || $user['tipoSlug'] == 'apoio-tecnico' || $user['tipoSlug'] == 'apoio-interno' || $user['tipoSlug'] == 'comunicacao' || $user['tipoSlug'] == 'avaliacao' || $user['npacce'] == B180697) {
						 	echo '<input type="checkbox" class="marcar" name="comissao[]" value="'.$comissoes[$i]['comissaoSlug'].'"></input>  '.$comissoes[$i]['comissao'].'<br><br>';
					    }else{
						
						 	if ($comissoes[$i]['comissaoSlug'] == 'apoio-interno' || $comissoes[$i]['comissaoSlug'] == 'ceo' || $user['tipoSlug'] == 'comunicacao') {
						 		echo '<input type="checkbox" class="marcar" name="comissao[]" value="'.$comissoes[$i]['comissaoSlug'].'"></input>  '.$comissoes[$i]['comissao'].'<br><br>';
						 	}
						} 
						
					}
				}
			
			?>
		
		<br>	
		<label class="label">Assunto</label> <span style="color: red">  *</span><br>
			<input type="text" name="assunto" value="<?php if($resp==true){ echo '[RE]: '.$resp['assunto'];} ?>" placeholder="Digite o título do assunto"></input>
			<br><br>
			<label class="label">Conteúdo</label> <span style="color: red">  *</span>
			<br><br>
			<textarea name="conteudo"></textarea>			
		<br>
		<center>
			<input type="submit" name="enviar" value="Enviar"></input>
		</center>
		</form>
	</div></div></div>
	<?php
		}else if (isset($_GET['action']) && $_GET['action'] == 'enviados') {
			$paginaAtual 	= (!isset($_GET['page']) || $_GET['page'] == '' ? 1 : $_GET['page']);
			$maxPosts		= 20;
			$start			= ($paginaAtual * $maxPosts) - $maxPosts;
			$selec 	   		= DBread('msg',"WHERE status = 1 AND npacceRemetente = '".$user['npacce']."' ORDER BY registro DESC LIMIT $start, $maxPosts");
			$conta 			= DBread('msg', "WHERE status = 1 AND npacceRemetente = '".$user['npacce']."'", "id");
			if ($selec == false) {
				echo '<br><div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
			}else{
	?>
		<div id="caixa-entrada">
			<table width="100%">
				<?php 
					for ($i=0; $i < count($selec); $i++) { 
				?>
				<tr>
					<td style="width: 20px;"><input type="checkbox" name="msg[]" id="item" value="<?php echo base64_encode($selec[$i]['id']); ?>"></input></td>
					<td onclick="window.location='<?php echo $way.'?action='.base64_encode($selec[$i]['id']); ?>';">
					<?php 
						if ($selec[$i]['ler'] == 0) {
							echo '<h3>'.texto($selec[$i]['assunto'], 35).'</h3>';
						}else{
							echo ''.texto($selec[$i]['assunto'], 35).'';
						}
					?>
					</td>
					<td onclick="window.location='<?php echo $way.'?action='.base64_encode($selec[$i]['id']); ?>'; "><?php echo texto(strip_tags($selec[$i]['conteudo']), 45); ?></td>
					<td onclick="window.location='<?php echo $way.'?action='.base64_encode($selec[$i]['id']); ?>'; " style="text-align: right;"><?php echo $selec[$i]['npacceDestinatario']; ?></td>
					<td onclick="window.location='<?php echo $way.'?action='.base64_encode($selec[$i]['id']); ?>'; " style="text-align: right;"><?php echo date('d/m/y H:i:s', strtotime($selec[$i]['registro'])).''; ?></td>
				</tr>
				<?php }?>
			</table>
			<br>
			<?php 
				paginatorCaixaRe('msg', $user['npacce'] ,$maxPosts, $paginaAtual, $way);
				if (isset($_GET['page'])) {
					$page = $_GET['page'] * count($selec);
				}else{
					$page = count($selec);
				}
				if (count($selec) <= 1) {
					echo '<div style="position: relative; bottom: 0px; text-align:right;">'.$page.' de'.count($conta).' mensagem</div>';
				}else{
					echo '<div style="position: relative; bottom: 0px; text-align:right;">'.$page.' de '.count($conta).' mensagens</div>';
				}
				echo '</div>';
			}
				
		?>
	<?php
		}else if (isset($_GET['action']) && $_GET['action'] != '') {
			$id = base64_decode($_GET['action']);
			$email = DBread('msg', "WHERE id = '".$id."'");
			if ($email == false) {
			 	echo '<br><div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
			 }else{
			 $email = $email[0];
			 $week = array('Sun' => 'Domingo', 'Mon' => 'Segunda-feira','Tue' => 'Terca-feira','Wed' => 'Quarta-feira','Thu' => 'Quinta-feira','Fri' => 'Sexta-feira','Sat' => 'Sábado');
			 $mes_extenso = array('Jan' => 'Janeiro','Feb' => 'Fevereiro','Mar' => 'Marco','Apr' => 'Abril','May' => 'Maio','Jun' => 'Junho','Jul' => 'Julho','Aug' => 'Agosto','Nov' => 'Novembro','Sep' => 'Setembro','Oct' => 'Outubro','Dec' => 'Dezembro');
			 if ($email['npacceDestinatario'] == $user['npacce']) {
			 	if ($email['ler'] == 0) {
					$up['ler'] = 1;
					DBUpDate('msg', $up, "id = '".$email['id']."'");
				}
			 }
	?>		
	<br>
	
			<h2><?php echo $email['assunto']; ?></h2>
			<br>
			<div id="headerr">
				<table>
					<tr>
						<th>De:</th>
						<td><?php echo $email['npacceRemetente'].' - '.$email['remetente'];  ?></td>
					</tr>
					<tr>
						<th>Enviada:</th>
						<td><?php echo $week[date('D', strtotime($email['registro']))]; ?>, <?php echo date('d', strtotime($email['registro'])).' de '.$mes_extenso[date('M', strtotime($email['registro']))].' de '.date('Y', strtotime($email['registro'])).'  '.date('H:i:s', strtotime($email['registro'])).''; ?></td>
					</tr>
					<tr>
						<th>Para:</th>
						<td><?php echo $email['npacceDestinatario'].' - '.$email['destinatario']; ?></td>
					</tr>
				</table>				
			</div>
			<br><br><br>
			<div id="text">
				<?php echo $email['conteudo']; ?>
			</div>
			<div id="clear"></div>
			</div>
			</div>

	<?php
			}
		}else{
	?>
		<?php 
			$paginaAtual 	= (!isset($_GET['page']) || $_GET['page'] == '' ? 1 : $_GET['page']);
			$maxPosts		= 20;
			$start			= ($paginaAtual * $maxPosts) - $maxPosts;

			$selec 	   		= DBread('msg',"WHERE status = 1 AND npacceDestinatario = '".$user['npacce']."' ORDER BY registro DESC LIMIT $start, $maxPosts");
			$conta 			= DBread('msg', "WHERE status = 1 AND npacceDestinatario = '".$user['npacce']."'", "id");
			if ($selec == false) {
				echo '<br><div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
			}else{
		?>
		<div id="caixa-entrada">
		<table width="100%">
			
			<?php 
				for ($i=0; $i < count($selec); $i++) { 
			?>
			<tr>
				<td style="width: 20px;"><input type="checkbox" name="msg[]" id="item" value="<?php echo base64_encode($selec[$i]['id']); ?>"></input></td>
				<td onclick="window.location='<?php echo $way.'?action='.base64_encode($selec[$i]['id']); ?>';">
				<?php 
					if ($selec[$i]['ler'] == 0) {
						echo '<h3>'.texto($selec[$i]['assunto'], 35).'</h3>';
					}else{
						echo ''.texto($selec[$i]['assunto'], 35).'';
					}
				?>
				
				</td>
				<td onclick="window.location='<?php echo $way.'?action='.base64_encode($selec[$i]['id']); ?>'; "><?php echo texto(strip_tags($selec[$i]['conteudo']), 45); ?></td>
				<td onclick="window.location='<?php echo $way.'?action='.base64_encode($selec[$i]['id']); ?>'; " style="text-align: right;"><?php echo date('d/m/y H:i:s', strtotime($selec[$i]['registro'])).''; ?></td>
			</tr>
			<?php }?>
			
		</table>
		<br>
		<?php 
				if (isset($_GET['page'])) {
					$page = $_GET['page'] * count($selec);
				}else{
					$page = count($selec);
				}
				paginatorCaixa('msg', $user['npacce'],$maxPosts, $paginaAtual, $way);
				if (count($selec) <= 1) {
					echo '<div style="position: relative; bottom: 0px; text-align:right;">'.$page.' de'.count($conta).' mensagem</div>';
				}else{
					echo '<div style="position: relative; bottom: 0px; text-align:right;">'.$page.' de '.count($conta).' mensagens</div>';
				}
				echo '</div>';
			}
				
		?>

	<?php }?>
<?php 
	if (!isset($_GET['action']) || $_GET['action'] == 'enviados') {
		echo '</div></div></form>';
	}
	
?>

