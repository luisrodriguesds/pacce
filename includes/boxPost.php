<?php 
	$urlAcess = URLBASE.''.$post['categoriaSlug'].'/'.$post['tituloSlug'];
	
	$selecComent = DBread('comentposts', "WHERE postagem = '".$post['id']."' ", 'postagem');

	if ($selecComent == false) {
		$contaComent = 0;	
	}else{
		$contaComent = count($selecComent);
	}

?>

<div class="loops-wrapper list-thumb-image">
		
	<article class="post">
		<figure class="post-image"><a href="<?php echo $urlAcess;?>"><img src="<?php echo URLBASE; ?>/images/<?php echo $post['capa']; ?>" alt="<?php echo $post['titulo']; ?>" height="137" width="158"></a></figure>
			<div class="post-content" style="margin-left: 0px;">	
				<time datetime="<?php echo date('d-M-Y', strtotime($post['data'])); ?>" class="post-date" pubdate="">
					<?php
					$meses = array('Janeiro', 'Fevereiro', 'Março','Abril','Maio','Junho','Julho', 'Agosto', 'Setembro','Outubro','Novembro','Dezembro'); 
					
					$dia = date('d', strtotime($post['data']));
					$mes = date('m', strtotime($post['data'])); 
					$ano = date('Y', strtotime($post['data']));
					echo $dia.' de '.$meses[$mes-1].' de '.$ano; ?></time>
					<h1 class="post-title" title="<?php echo $post['titulo']; ?>"><a href="<?php echo $urlAcess;?>"><?php echo $post['titulo']; ?></a></h1>
				
					<p class="post-meta"> 
						<span class="post-author"><a href="" title="Postado por: <?php echo $post['autor']; ?>" rel="author"><?php echo $post['autor']; ?></a></span>
						<span class="post-category"><a href="<?php echo URLBASE.$post['categoriaSlug'];?>" title="Veja todos os posts de <?php echo $post['categoria']; ?>" rel="category tag"><?php echo $post['categoria']; ?></a></span>
						<span class="post-comment"><a href="<?php echo $urlAcess;?>#place-comment" title="Comentários: <?php echo $contaComent; ?>"><?php echo $contaComent; echo " "; if($contaComent == 0 || $contaComent ==1){echo "Comentário";}else{echo "Comentários";} ?></a></span>
						<span class="post-comment"><a href="<?php echo $urlAcess;?>#views" title="Visualizações: <?php echo $post['visitas'] ?>"><?php echo $post['visitas']; echo " "; if($post['visitas'] == 0 || $post['visitas'] == 1){echo "Visualização";}else{echo "Visualizações";} ?> </a></span>
					</p>
					<p><?php echo texto($post['conteudo'], 300); ?></p>
			</div>

					<!-- /.post-content -->
	</article>
																				
</div>
