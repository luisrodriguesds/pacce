<style type="text/css">
	.foto-single{ float: right; font-size: 13px; width: 150px; height: 190px; line-height: 25px; text-align: center; margin-right: 20px; margin-bottom: 10px;
-webkit-box-shadow: 0px 2px 8px 0px rgba(50, 50, 50, 0.55);
-moz-box-shadow:    0px 2px 8px 0px rgba(50, 50, 50, 0.55);
box-shadow:         0px 2px 8px 0px rgba(50, 50, 50, 0.55);
}
.foto-single img{width: 150px; max-width: 100%; height: 150px;}
.foto-single .nome{width: 150px; height: 20px; background-color: #fff;}
.foto-single{float: left;	}
</style>
<?php 
	$membros = DBread('bolsistas', "WHERE tipoSlug = '".$url[0]."' AND status");
	if ($membros == false) {
		echo 'Nada encontrado';
	}else{
		?>

		<div class="title"><h2>Membros da Comissão</h2></div>
		<?php
		for ($i=0; $i < count($membros); $i++) { 
		?>
			<div class="foto-single">
				<?php  
					 $foto = DBread('bolsistas', "WHERE npacce = '".$membros[$i]['npacce']."'", "id, foto");
				?>
				<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto[0]['foto'].''; ?>"><br></span>
				<div class="nome"><?php echo GetName($membros[$i]['nome'], $membros[$i]['nomeUsual']); ?></div>
			</div>
		<?php
		}
	}

?>