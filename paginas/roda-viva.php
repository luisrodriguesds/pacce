
<?php 
	//pesquiso os links dos vídeos que tem no bd
	$link = DBread('post_rod',"WHERE status = 1", "link");
?>
<center>
	<?php 
	//se o botao video foi acionado, imprime o iframe dos vídeos
	if (isset($_POST['video'])) {
		for ($i=0; $i < count($link) ; $i++) {
			echo $link[$i]['link'].'<p>';
		}
	}/*else if(isset($_POST['cadastrar'])){
		//verifica se foi pedido para cadastrar um vídeo
		$link['link'] = $_POST['link'];
		$link['status'] = 

		DBcreate('post_rod', $link);
	}*/
	else{
	?>
		<h1>Um pouco sobre a História de vida</h1>
		<iframe src="https://onedrive.live.com/embed?cid=29135ADD463F8DFC&amp;resid=29135ADD463F8DFC%21107&amp;authkey=ABzCUN4hZAi1CW0&amp;em=2&amp;wdAr=1.4148802017654476" width="100%" height="400px" frameborder="0">Este é um apresentação do <a target="_blank" href="https://office.com">Microsoft Office</a> incorporado, da plataforma <a target="_blank" href="https://office.com/webapps">Office</a>.</iframe><br><br><br><br>
		<form method="post">
			<h3>Confira também os nossos vídeos</h3>
			<button type="submite" name="video" class="btn btn-primary">Vídeos</button>
		</form>

	<?php	
	}			
	?>
</center>

<center>

</center>