<?php 
	$pesquisa = $_GET['s'];
?>
<div id="PageHeader">
	<h2>Pesquisar por: <?php echo $pesquisa; ?></h2>
</div>
<?php 
	$res = DBread('posts', "WHERE titulo LIKE '%$pesquisa%' OR conteudo LIKE '%$pesquisa%'");
	if($res == false){
		echo '<br>
		<h2 style="color: #E03232; font-family:Tahoma, Geneva, sans-serif; font-size:20px; text-align:center;">Nenhum resultado encontrado!</h2>
		<br>';
	}else{
		echo '('.count($res).')Resltados<br>';
		for ($i=0; $i < count($res); $i++) {
		$urlAcess = URLBASE.''.$res[$i]['categoriaSlug'].'/'.$res[$i]['tituloSlug'];
	
		$selecComent = DBread('comentposts', "WHERE postagem = '".$res[$i]['id']."' ", 'postagem');

		if ($selecComent == false) {
		$contaComent = 0;	
		}else{
		$contaComent = count($selecComent);
		} 
			
		?> 
		<div class="loops-wrapper list-thumb-image">
		
	<article class="post">
		<figure class="post-image"><a href="#"><img src="<?php echo URLBASE; ?>/images/<?php echo $res[$i]['capa']; ?>" alt="<?php echo $res[$i]['titulo']; ?>" height="137" width="158"></a></figure>
			<div class="post-content" style="margin-left: 0px;">	
				<time datetime="<?php echo date('d-M-Y', strtotime($res[$i]['data'])); ?>" class="post-date" pubdate="">
					<?php
					$meses = array('Janeiro', 'Ferereiro', 'Março','Abril','Maio','Junho','Julho', 'Agosto', 'Setembro','Outubro','Novembro','Dezembro'); 
					
					$dia = date('d', strtotime($res[$i]['data']));
					$mes = date('m', strtotime($res[$i]['data'])); 
					$ano = date('Y', strtotime($res[$i]['data']));
					echo $dia.' de '.$meses[$mes-1].' de '.$ano; ?></time>
					<h1 class="post-title" title="<?php echo $res[$i]['titulo']; ?>"><a href="<?php echo $urlAcess;?>"><?php echo $res[$i]['titulo']; ?></a></h1>
				
					<p class="post-meta"> 
						<span class="post-author"><a href="" title="Postado por: <?php echo $res[$i]['autor']; ?>" rel="author"><?php echo $res[$i]['autor']; ?></a></span>
						<span class="post-category"><a href="<?php echo URLBASE.$res[$i]['categoriaSlug'];?>" title="Veja todos os posts de <?php echo $res[$i]['categoria']; ?>" rel="category tag"><?php echo $res[$i]['categoria']; ?></a></span>
						<span class="post-comment"><a href="<?php echo $urlAcess;?>#place-comment" title="Comentários: <?php echo $contaComent; ?>"><?php echo $contaComent; echo " "; if($contaComent == 0 || $contaComent ==1){echo "Comentário";}else{echo "Comentários";} ?></a></span>
						<span class="post-comment"><a href="<?php echo $urlAcess;?>#views" title="Visualizações: <?php echo $res[$i]['visitas'] ?>"><?php echo $res[$i]['visitas']; echo " "; if($res[$i]['visitas'] == 0 || $res[$i]['visitas'] == 1){echo "Visualização";}else{echo "Visualizações";} ?> </a></span>
					</p>
					<p><?php echo texto($res[$i]['conteudo'], 300); ?></p>
			</div>

					<!-- /.post-content -->
	</article>
																				
</div>

	<?php
		}
	}
?>