<?php 
	$getUrl		= URLBASE.''.$categoria.'/'.$postagem;
	$getPost 	= DBread('posts',"WHERE categoriaSlug = '$categoria' AND tituloSlug = '$postagem' AND status = true");
	$error 		= $getPost[0]['tituloSlug'];
	
	
	//editar Comentários!!
	if(isset($_POST['editar'])){
		$editar['comentario'] = strip_tags(trim(DBescape($_POST['recoment'])));
        $idC = base64_decode(GetPost('id'));
    
        if(empty($_POST['recoment'])){
        	echo '<script type="text/javascript">alert("O campo está vazio!!");</script>';
        }else{
        	if(DBread('comentposts', "WHERE id = '$idC'")){
        		if(DBUpDate('comentposts', $editar,"id = '$idC'")){
        			
        			echo '
	                 <script>
	                    window.location="'.$getUrl.'#boxComent";
	                  </script>';
        			
        		}
        	}else{
        		echo '<script type="text/javascript">alert("Comentário não encontrado!");</script>';
        	}
        }
	}
	//Deleta comentarios!!
    if(isset($_GET['acao']) && isset($_GET['id']) &&!empty($_GET['acao']) && !empty($_GET['id'])){
    	$getId = DBescape(strip_tags(trim($_GET['id'])));
        	switch ($_GET['acao']) {
            	case 1:
                	if(DBDelete('comentposts', "id = '{$getId}'")){
                		
                	echo '
	                 <script>
	                  
	                    window.location="'.$getUrl.'#place-comment";
	                  </script>';
                }else{
                	echo '<script type="text/javascript">alert("Não foi possível deletar seu comentário, report esse erro.");</script>';
                }
                	
                break;
                }
            }
	//Envia comentarios!
	if(isset($_POST['enviar'])){

        $form['comentario'] = strip_tags(trim($_POST['comentario']));
        $form = DBescape($form);

        if (empty($form['comentario'])){
            echo '<script type="text/javascript">alert("Preencha o campo Comentário!");</script>';
        }else{
            $form['nome']       = $dadosUser[0]['nome'];
            $form['tipo']       = $dadosUser[0]['tipo'];
            $form['data']       = date("Y-m-d H:i:s");
            $form['postagem']   = $getPost[0]['id'];
            $form['npacce']		= $dadosUser[0]['npacce'];
            $form['status']     = 1;
            if(DBcreate('comentposts', $form)) {
                echo '
	                 <script>
	                  
	                    window.location="'.$getUrl.'#boxComent";
	                  </script>';
            }else{
                echo '
	                 <script>
	                  
	                    window.location="'.$getUrl.'#boxComent";
	                  </script>';
            }
                
        }
	}	

	if(!isset($getPost) || $postagem != $error){
		include 'paginas/404.php';	
	}else{
		$idP = $getPost[0]['id'];
		
		$upVisitas = array('visitas' => $getPost[0]['visitas'] + 1);
		DBUpDate('posts', $upVisitas, "id = '$idP'");
		$selecComent = DBread('comentposts',"WHERE postagem = '".$getPost[0]['id']."' AND status = true");
		if ($selecComent == false) {
			$contaComent = 0;	
		}else{
			$contaComent = count($selecComent);
		}			
?>
<div id="SingleHeader">
	<h2><?php echo $getPost[0]['titulo']; ?></h2>
</div>
<div id="date">
	<time datetime="<?php echo $getPost[0]['data']; ?>" class="post-date" pubdate="">
		<?php
		$meses = array('Janeiro', 'Ferereiro', 'Março','Abril','Maio','Junho','Julho', 'Agosto', 'Setembro','Outubro','Novembro','Dezembro'); 
		$dia = date('d', strtotime($getPost[0]['data']));
		$mes = date('m', strtotime($getPost[0]['data'])); 
		$ano = date('Y', strtotime($getPost[0]['data']));
		$hora = date('H:i:s', strtotime($getPost[0]['data']));
		echo $dia.' de '.$meses[$mes-1].' de '.$ano.' - '.$hora;  
		?>
	</time>
</div>
<div id="PostSingle">
	<p class="post-meta">

		<span class="post-author"><a href="#" title="Postado por: <?php echo $getPost[0]['autor'];?>" rel="author"><?php echo $getPost[0]['autor']; ?></a></span>

		<span class="post-category"><a href="<?php echo URLBASE.$getPost[0]['categoriaSlug'];?>" title="Veja todos os posts de <?php echo $getPost[0]['categoria']; ?>" rel="category tag"><?php echo $getPost[0]['categoria']; ?></a></span>
		<span class="post-comment"><a href="<?php echo $getUrl;?>#place-comment" title="Comentários: <?php echo $contaComent; ?>"><?php echo $contaComent; echo " "; if($contaComent == 0 || $contaComent ==1){echo "Comentário";}else{echo "Comentários";} ?></a></span>
		<span id="views" class="post-comment"><a href="" title="<?php echo $getPost[0]['visitas']; echo " "; if($getPost[0]['visitas'] == 0 || $getPost[0]['visitas'] == 1){echo "Visualização";}else{echo "Visualizações";} ?>"><?php echo $getPost[0]['visitas']; echo " "; if($getPost[0]['visitas'] == 0 || $getPost[0]['visitas'] == 1){echo "Visualização";}else{echo "Visualizações";} ?></a></span>
	</p>
	<div id="SingleImg">
		<center>
		<img src="<?php echo URLBASE; ?>/images/<?php echo $getPost[0]['capa']; ?>">
		</center>
	</div>
	<p><?php echo $getPost[0]['conteudo'] ?></p>
</div>
<div id="place-comment">
<?php 
	if ($selecComent == false){
		if (!IsLogged()){
			 ?>
			 <hr size="1" color="#CCCCCC">
			 <h2 style="color:#666; font-family:Tahoma, Geneva, sans-serif; font-size:20px; text-align:left;">Seja o primeiro a comentar esse post! <a href="<?php echo URL_BASE.'?post='.$getPost[0]['id'];?>">Faça seu Login!</a></h2>
			 <?php
		}else{
			?>
			 <hr size="1" color="#CCCCCC">
			 <h2 style="color:#666; font-family:Tahoma, Geneva, sans-serif; font-size:20px; text-align:left;">Seja o primeiro a comentar esse post!</h2>
			<?php
		}
	}else{
		echo '<hr size="1" color="#CCCCCC">';
		 for($i=0; $i < count($selecComent); $i++) {
			include 'includes/boxComent.php';
		}
		if(!IsLogged()){
			?> 
			<h2 style="color:#666; font-family:Tahoma, Geneva, sans-serif; font-size:20px; text-align:left;">Comente essa Postagem! <a href="<?php echo URL_BASE.'?post='.$getPost[0]['id'];?>">Faça seu Login!</a></h2>
			<?php
		}
	}
	if(!IsLogged()){
	}else{
		include 'includes/formComent.php';
	}
?>


<?php 
	
}
?>
</div>

