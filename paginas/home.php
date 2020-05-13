<div id="welcomeHeader">


	<?php 
	if ($dadosUser[0]['tipoSlug'] == 'ceo') {
		
		?>
		<div style="position: relative;">
			<iframe src="<?php echo URLBASE;?>slick/slick.php" style="width: 100%; height: 410px; margin-top: 20px"></iframe>	
		</div>
		<?php

	}
	?>
	
	



	<h2><?php if(!IsLogged()){echo "Seja Bem-Vindo";}else{ if($dadosUser[0]['sexo'] == 1){echo "Seja Bem-Vindo";}else{ echo "Seja Bem-Vinda";} } ?><?php if(IsLogged()){echo ", ".GetName($dadosUser[0]['nome'], 1)."!";}?></h2>
	<p>O Programa de Aprendizagem Cooperativa em Células Estudantis – PACCE está em uma nova fase. Agora, vinculado a todas as Unidades Acadêmicas da Universidade Federal do Ceará. Seus objetivos: dar suporte aos estudantes contribuindo para o aumento da taxa de conclusão nos cursos de graduação da UFC, assim como contribuir para a diminuição de evasão e retenção no processo de formação acadêmica. Sua principal estratégia é a utilização da metodologia da Aprendizagem Cooperativa através da formação de Células Estudantis (grupos de estudo). Desta forma, os estudantes participantes do Programa, recebem formação em Aprendizagem Cooperativa, apoio na formação de suas células de estudo, têm a oportunidade de conviver com estudantes de outros cursos ao longo do ano através de encontros de História de Vida e atividades lúdicas. O PACCE teve seu início em 2009 e, nesses anos de caminhada, mais de 2.000 estudantes passaram pelo Programa.</p>		
</div>


<div id="PageHeader">
	<!-- <h2>Home</h2> -->
</div>

<!-- <?php  

if($dadosUser[0]['tipoSlug'] == 'ceo' || $dadosUser[0]['tipoSlug'] == 'comunicacao'){

?>
<div style="position: relative;margin-bottom: 20px;">
	<iframe src="<?php echo URLBASE;?>slick/slick.php" style="width: 100%; height: 410px; margin-top: 20px"></iframe>	
</div>

<?php
}

?> -->




<?php 
	$paginaAtual 	= (!isset($_GET['page']) || $_GET['page'] == '' ? 1 : $_GET['page']);
	$maxPosts		= 5;
	$start			= ($paginaAtual * $maxPosts) - $maxPosts;

	$selec 	   = DBread('posts',"WHERE status = 1 ORDER BY data DESC LIMIT $start, $maxPosts");

	if(!$selec){
		echo "<h2>Nada Encontrado</h2>";
	}else{
		foreach ($selec as $post) {
			include 'includes/boxPost.php';
		}

		paginator('posts', $maxPosts, $paginaAtual);
	}


?>