<script type="text/javascript">
	$(function(){
		$('#enviar').click(function(event) {
			event.preventDefault();
		});
		$('#pesquisar').keyup(function(){
			var palavra 	= $(this).val();
			var c 			= 0;
			var dados 		= {palavra:palavra} 
			if (palavra != '') {
				$.post('../ajax/busca-bolsista.php', dados, function(data){
					$('#res_bolsistas').empty().html(data);
				});
			}
		});

		carregar('../ajax/busca-bolsista.php', 1);
		function carregar(url, c){
			var dados = {c:c}
			$.post(url, dados, function(data){
				$('#res_bolsistas').empty().html(data);
			});
		}
	});
</script>
<div class="title"><h2>Gerenciar Bolsistas</h2></div>
<p>Esta deve ser manuseada com extremo cuidado, pois nela é possível 
alterar status de bolsista, trocá-lo de comissão, alterar suas permissões e muito mais.</p>
<br>
<?php 
if (isset($url[2]) && $url[2] != '') {
	include 'paginas/editar-bolsista.php';		
}else{
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="pesquisar"><strong>Procurar Bolsista</strong></label>
		<div class="form-inline">
			<input type="text" id="pesquisar" style="width: 40%;" class="form-control" autocomplete="off" name="pesquisar" onkeyup="maiuscula(this)" OnKeyPress="" value=""  placeholder="Digite o número pacce ou o nome de quem você quer procurar"></input>
			<input type="submit" name="enviar" class="btn btn-primary" id="enviar" value="Pesquisar">
		</div>
	</div>
</form>

<div id="clear"></div>
<br>
<div id="res_bolsistas">
<div style="height: 2000px;"></div>
</div>


<?php
}
?>