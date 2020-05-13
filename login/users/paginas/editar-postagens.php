
<?php 
 	$ed 	= DBescape(trim(strip_tags($_GET['editar'])));
 	$post 	= DBread('posts', "WHERE id = '$ed'");
 	
 	if ($post == false) {
 	 	
 	 }else{
 	 	if(isset($_POST['send'])){
		$novoNome 				= '';
		$form['titulo'] 		= GetPost('titulo');
		$form['tituloSlug']		= Slug($form['titulo']).'-'.date('d-m-y');
		//$form['autor']			= GetName($user['nome'], $user['nomeUsual']);
		//$form['categoria']		= $user['tipo'];
		//$form['categoriaSlug']	= $user['tipoSlug'];
		$form['data']			= date('Y-m-d H:i:s');
		$form['status']			= GetPost('status');
		$form['conteudo']		= str_replace('\r\n', "", GetPost('conteudo'));

		if(empty($form['titulo'])){
			echo '<script>alert("Digite o Título dessa postagem");</script>';
		}else if(empty($form['conteudo'])){
			echo '<script>alert("Digite o conteúdo dessa postagem!");</script>';
		}else{
			$novoNome == '';
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
    				 echo '<script>alert("Sucesso!!");';  
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
			}else{
				$form['capa'] = $novoNome;
			}
			if( DBUpDate('posts', $form, "id = '$ed'")){
					 echo '<script>alert("Sua postagem foi editada com sucesso!.");
          					window.location="'.$way.'/postagens";</script>';
				}else{
					echo '<script>alert("Ocorreu um erro na hora de cadastrar sua postagem, por favor informar ao desenvolvedor!.");
          					window.location="'.$way.'/postagens";</script>';
				}
		}

	}
?>
<div class="title"><h2>Editar Postagem</h2></div>
<div class="form">
	<form action="" enctype="multipart/form-data" method="post">
	<h2>Capa da Postagem</h2><br>
	<input type="file" name="arquivo"></input><br><br>
	<span style="color: red;">*caso você não selecione nenhuma imagem, continuará com a mesma capa</span>
	<br><br>
	<h2>Título</h2>
	<input type="text" name="titulo" value="<?php echo $post[0]['titulo']; ?>" placeholder="Digite o título da sua postagem"></input><br><br>
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
	<textarea name="conteudo"><?php echo $post[0]['conteudo']; ?></textarea><br><br>
	<center>
	<input type="submit" name="send" value="Editar"></input>
	</center>
</form>
</div>
<br><br>
<?php }?>