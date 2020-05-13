<div id="content">
	
	<!-- loops-wrapper -->
	<?php 
		
		$url 	 	= (isset($_GET['url'])) ? $_GET['url'] : 'home';
		$url		= array_filter(explode('/', $url));
		$paginas 	= array('fale-conosco', 'metodologia','celulas','Newsletter', 'documentos', 'confirmacao', 'historia', 'oficina');
		$oficinas   = array('expopacce', 'nescau');

		$categoria 	= $url[0];
		$categoriaOficina = $url[1];
		if(isset($url[1])){
			$postagem = $url[1];
		}

		//buscador
		if(isset($_GET['s']) && $_GET['s'] != ''){
			include 'paginas/search.php';
		}
		//HOME
		else if($categoria == 'home'){
			include 'paginas/home.php';
		}
		//PAGINAS fIXAS
		else if(isset($categoriaOficina) && in_array($categoriaOficina, $oficinas)){
			include ("paginas/oficinas/".$categoriaOficina.".php");
		}
		else if(isset($categoria) && in_array($categoria, $paginas)){
			include ("paginas/".$categoria.".php");
		}
		else if(isset($celulas) && in_array($celulas, $paginas)){
			include ("paginas/".$celulas.".php");
		}
		else if(isset($metodologia) && in_array($metodologia, $paginas)){
			include ("paginas/".$metodologia.".php");
		}
		else if(isset($Newsletter) && in_array($Newsletter, $paginas)){
			include ("paginas/".$Newsletter.".php");
		}
		//POSTAGEM
		else if(isset($postagem) && $postagem != ''){
			include 'paginas/single.php';
		}
		else if (isset($categoria) && !in_array($categoria, $paginas)) {
			include 'paginas/categoria.php';
		}else{
			include 'paginas/404.php';
		}
	?>

	<!-- /loops-wrapper -->
			
	<!-- NEVEGADOR! -->
		
</div>