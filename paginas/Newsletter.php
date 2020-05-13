
<style type="text/css"> 
a.nounderline:link 
{ 
 text-decoration:none; 
 font-size: 18px; 

} 
hr {
		border-width: none;
      color: #E8E8E8;
      background-color: #E8E8E8;
      height: 0.5px;
      border-color: #E8E8E8;
    }
</style>

<h2>Newsletter</h2>
<br>
<div id="principal">
<?php 
if (isset($url[1]) && $url[1] != '') {
	//Segundo nível da url
	//Pega só o número da News
	$edicao = str_replace("edicao-", "", DBescape($url[1]));
	//Seleciona banco a edicao que está na url
	$news = DBread('newsletter', "WHERE edicao = '".$edicao."' AND status = true LIMIT 1");
	if ($news == false) {
		echo "<h1>Edição não encontrada</h1>";
	}else{
		echo $news[0]['newsletter'];
	}
}else{
	//Primeiro nível da url
	//Seleciona as news do Banco
	$news = DBread('newsletter', "WHERE status = true");
	if ($news == false) {
		echo '<h1>Não há Postagens de Newsletter</h1>';
	}else{
		//imprime a lista 
		for ($i=0; $i < count($news); $i++) { 
				if ($news[$i]['edicao'] >= 10) {
					$edicao = $news[$i]['edicao'];
				}else{
					$edicao = '0'.$news[$i]['edicao'];
				}
			?>
			<h2><a class="nounderline" style="color: #666" href="<?php echo URLBASE.$url[0].'/edicao-'.$news[$i]['edicao']; ?>"> Edição <?php echo $edicao.'/2016';?></a></h2>
			<hr size="1">
			<?php
		}
	}
}
?>
</div>
