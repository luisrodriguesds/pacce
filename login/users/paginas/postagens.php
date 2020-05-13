
<?php 

//Cadastar Postagem
	if(isset($_POST['cadastrar'])){
		$novoNome 				= '';
		$form['titulo'] 		= GetPost('titulo');
		$form['tituloSlug']		= Slug($form['titulo']).'-'.date('d-m-y');
		$form['autor']			= GetName($user['nome'], $user['nomeUsual']);
		$form['categoria']		= $user['tipo'];
		$form['categoriaSlug']	= $user['tipoSlug'];
		$form['data']			= date('Y-m-d H:i:s');
		$form['status']			= GetPost('status');
		$form['conteudo']		= str_replace('\r\n', "", $_POST['conteudo']);
		$form['visitas']		= 0;
		if(empty($form['titulo'])){
			echo '<script>alert("Digite o Título dessa postagem");</script>';
		}else if($form['status'] == -1){
			echo '<script>alert("Selecione um status");</script>';
		}else if(empty($form['conteudo'])){
			echo '<script>alert("Digite o conteúdo dessa postagem!");</script>';
		}else if(DBread('posts', "WHERE tituloSlug ='".$form['tituloSlug']."'")){
			echo '<script>alert("Já existe postagem com esse Titulo!");</script>';
		}else{
			// verifica se foi enviado um arquivo
    		if(isset($_FILES['arquivo']['name']) && $_FILES["arquivo"]["error"] == 0){
    			$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
    			$nome = $_FILES['arquivo']['name'];
     
    			// Pega a extensao
    			$extensao = strrchr($nome, '.');
 
    			// Converte a extensao para mimusculo
    			$extensao = strtolower($extensao);
 
    			// Somente imagens, .jpg;.jpeg;.gif;.png
    			// Aqui eu enfilero as extesões permitidas e separo por ';'
    			// Isso server apenas para eu poder pesquisar dentro desta String
    			if(strstr('.jpg;.jpeg;.gif;.png', $extensao)){
        			// Cria um nome único para esta imagem
        			// Evita que duplique as imagens no servidor.
        			$novoNome = md5(microtime()).$extensao;
         
        			// Concatena a pasta com o nome
        			$destino = DIR_IMG.$novoNome;
         
        			// tenta mover o arquivo para o destino
        			if( @move_uploaded_file( $arquivo_tmp, $destino  )){    
        			}else{
    					echo '<script>alert("Ocorreu um erro no Upload da sua imagem!");';
					}
				}	
			}
			if($novoNome == ''){
				echo '<script>alert("Insira uma imagem!");</script>';
			}else{
				$form['capa'] = $novoNome;
				if( DBcreate('posts', $form)){
					 echo '<script>alert("Sua postagem foi cadastrada com sucesso!.");
          					window.location="'.$way.'/'.$url[1].'";</script>';
					//Redirect(URL_PAINEL.$dataUser[0]['atributoSlug'].'/posts?msg=1');
				}else{
					echo '<script>alert("Ocorreu um erro na hora de cadastrar sua postagem, por favor informar ao desenvolvedor!.");
          					window.location="'.$way.'/'.$url[1].'";</script>';
					//Redirect(URL_PAINEL.$dataUser[0]['atributoSlug'].'/posts?msg=0');
				}
			}
		}

	}
	if (isset($_GET['action']) && $_GET['action'] != '' && isset($_GET['id']) && $_GET['id'] != '') {
		$id = DBescape(trim(strip_tags($_GET['id'])));
		switch ($_GET['action']) {
			case 1:
				$up['status'] = 1;
				if (DBUpDate('posts', $up, "id = '$id'")) {
					echo '<script>alert("Sua postagem ativada com sucesso!");
          					window.location="'.$way.'/'.$url[1].'";</script>';
				}
			break;
			case 2:
				$up['status'] = 0;
				if (DBUpDate('posts', $up, "id = '$id'")) {
					echo '<script>alert("Sua postagem desativada com sucesso!");
          					window.location="'.$way.'/'.$url[1].'";</script>';
				}
			break;
			case 3:
				if (DBDelete('posts', "id = '$id'")) {
					echo '<script>alert("Sua postagem deletada com sucesso!");
          					window.location="'.$way.'/'.$url[1].'";</script>';
				}
			break;
		}
	}
?>

<script src="<?php echo URL_PAINEL; ?>js/tinymce/tinymce.min.js"></script>
<script>

tinymce.init({
  selector: "textarea",
  height: 500,
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

<div class="title"><h2>Postagens</h2></div>
<p>Página destinada ao envio de informações para o blog. 
Você pode enviar postagens, editar, alterar status e ainda excluir seus posts.</p>
<br>
<?php 
if (isset($_GET['editar']) && $_GET['editar'] != '') {
	include 'paginas/editar-postagens.php';
}else{
?>
<div class="title"><h2>Cadastrar Postagem</h2></div>
<div class="form">
	<form action="" enctype="multipart/form-data" method="post">
	<h2>Capa da Postagem</h2><br>
	<input type="file" name="arquivo"></input><br><br><br>
	<h2>Título</h2>
	<input type="text" name="titulo" placeholder="Digite o título da sua postagem"></input><br><br>
	<h2>Status</h2>
	<select name="status">
		<option value="1">Ativo</option>
		<option value="0">Inativo</option>
	</select>
	<br><br>
	<center>
	<h2>Conteúdo</h2>
	<br>
	</center>
	<textarea name="conteudo"></textarea><br><br>
	<center>
	<input type="submit" name="cadastrar" value="Cadastar"></input>
	</center>
</form>
</div>
<br><br>
<?php 
	if ($user['tipoSlug'] == 'ceo') {
		$posts = DBread('posts', "ORDER BY data DESC");
	}else{
		$posts = DBread('posts', "WHERE categoriaSlug = '".$user['tipoSlug']."' ORDER BY data DESC");
	}
?>
<div class="title"><h2>Gerenciar Postagens</h2></div>
<div class="tabela">
<?php 
	if ($posts == false) {
		echo '<div class="nada-encontrado"><h2>Nada encontrado.</h2></div>';
	}else{
?>
	<table>
		<tr>
			<th>Título:</th>
			<th>Data:</th>
			<th>Autor:</th>
			<th>Visualizações:</th>
			<th>Comentários:</th>
			<th colspan="3">Ações:</th>
		</tr>
		<?php 
			for ($i=0; $i < count($posts); $i++) { 

		?>
		<tr>
			<td style="width: 200px;"><a href="<?php echo URLBASE.''.$posts[$i]['categoriaSlug'].'/'.$posts[$i]['tituloSlug'] ?>"><?php echo $posts[$i]['titulo']; ?></a></td>
			<td><?php echo date('d/m/y', strtotime($posts[$i]['data'])); ?></td>
			<td><?php echo $posts[$i]['autor']; ?></td>
			<td><?php echo $posts[$i]['visitas']; ?></td>
			<td><?php 
					$comment = DBread('comentposts', "WHERE postagem = '".$posts[$i]['id']."'");
					if ($comment == false) {
						$comment = 0;
					}else{
						$comment = count($comment);
					}
					echo $comment;
			?></td>
			<td>
			<?php 
				if ($posts[$i]['status'] == 0) {
			?>
				<a href="<?php echo $way.'/'.$url[1].'?action=1&&id='.$posts[$i]['id']; ?>">Ativar</a>
			<?php
				}else{
			?>
				<a href="<?php echo $way.'/'.$url[1].'?action=2&&id='.$posts[$i]['id']; ?>">Desativar</a>
			<?php
				}
			?>
			
			</td>
			<td><a href="<?php echo $way.'/'.$url[1].'?editar='.$posts[$i]['id'].'';?>">Editar</a></td>
			<td><a href="<?php echo $way.'/'.$url[1].'?action=3&&id='.$posts[$i]['id']; ?>">Deletar</a></td>
		</tr>
		<?php 
			}
		?>
	</table>
	<?php } ?>	
</div>
<?php } ?>