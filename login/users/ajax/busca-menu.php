<?php 

 if (isset($_POST['palavra'])) {
 	?>
 	<script type="text/javascript">
 	$(function(){
 		var url  = '<?php echo $_POST['url1']; ?>';
		if (url != '') {
			var id = $('#'+url).attr('id');
	 		var altura = $("#inicio").offset().top;
	 		var busca = $('#'+url).attr('id');
	 		var scrollId = $('#'+url).offset().top;

	 		$("#menu").animate({scrollTop: scrollId-altura},1000);
		}
 		

 	});
 	</script>
 	<?php
 	require_once '../../../sistema/system.php';
 	$dataUser = GetUser();
	$user 		= $dataUser[0];
	//$semana 	= GetSemana();
	$way 		= URL_PAINEL.$user['tipoSlug'];

 	$word = DBescape($_POST['palavra']);

 	$url1 = $_POST['url1'];
 	if ($word == '') {
 		$menu = DBread('menu', "WHERE acessoSlug = '".$user['tipoSlug']."' AND status = true ORDER BY nome ASC");
 	}else{
 		$menu = DBread('menu', "WHERE acessoSlug = '".$user['tipoSlug']."' AND nome LIKE '%$word%' AND status = true ORDER BY nome ASC");
 	}

 	if ($menu == false) {
 	}else{
 		for ($i=0; $i < count($menu); $i++) { 
 			?>
 			<a href="<?php echo $way.'/'.$menu[$i]['nomeSlug']; ?>" id="<?php echo $menu[$i]['nomeSlug']; ?>">
				<li <?php if($url1 == $menu[$i]['nomeSlug']){echo 'style="background:#e5e5e5; border-left: 3px solid #6091B7;"';} ?>>
					<?php echo $menu[$i]['nome']; ?>	
				</li>
			</a>
 			<?php
 		}
 	}
 }
?>