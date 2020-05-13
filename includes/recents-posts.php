<div id="themify-feature-posts-3" class="widget feature-posts">
<h4 class="widgettitle">Últimos Posts</h4>
<?php 
	$page = ((isset($_GET['page'])) ? $_GET['page'] : 1);
	// var_dump($page);
	$selecPost = DBread('posts',"WHERE status = true  ORDER BY data DESC LIMIT ".($page*5).", 4");
	
	if($selecPost == false){
		echo "<h2>Nada encontrado</h2>";
	}else{
		foreach ($selecPost as $recentPots) {
			$Acess = URLBASE.''.$recentPots['categoriaSlug'].'/'.$recentPots['tituloSlug'];
?>
		<ul class="feature-posts-list">
			<li><a href="<?php echo $Acess;  ?>"><img src="<?php echo URLBASE; ?>/images/<?php echo $recentPots['capa'] ?>" alt="<?php echo $recentPots['titulo'] ?>" class="post-img" height="40" width="40"></a>
			<a href="<?php echo $Acess;  ?>" class="feature-posts-title"><?php echo $recentPots['titulo'] ?></a> <br><small style="padding-left: 55px;"><?php echo date('d-m-Y', strtotime($recentPots['data'])); ?></small> <br></li>
			
	</ul>


<?php 

	}
}
?>

</div>