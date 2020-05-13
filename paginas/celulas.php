<?php 

//Paginador Categoria
	function pagePesq($sql,$pesq,$filtro,$maxPosts, $paginaAtual){
		//PAGINATOR
		if ($filtro == 'titulo') {
			$res = DBread('horario_celula', "WHERE titulo LIKE '%$pesq%' AND status = true");
		}else if ($filtro == 'campus') {
			$res = DBread('horario_celula', "WHERE campus LIKE '%$pesq%' AND status = true");
		}else if ($filtro == 'bloco') {
			$res = DBread('horario_celula', "WHERE bloco LIKE '%$pesq%' AND status = true");
		}else if ($filtro == 'departamento') {
			$res = DBread('horario_celula', "WHERE departamento LIKE '%$pesq%' AND status = true");
		}else if ($filtro == 'diaSemana') {
			$res = DBread('horario_celula', "WHERE diaSemana LIKE '%$pesq%' AND status = true");
		}else{
			$res = DBread('horario_celula', "WHERE inicio LIKE '%$pesq%' AND status = true");
		}
		//$res = DBread($sql, "WHERE status = true AND categoriaSlug = '$categoria'");
		
		//Contagem
		$totalPost	= count($res);
		
		//Paginas
		$paginas	= ceil($totalPost / $maxPosts);
		
		if($paginaAtual > $paginas || $totalPost <= $maxPosts){
		}else{
			if(isset($_GET['url'])){
				$url[0] = $_GET['url'];
			}else{
				$url[0] = '';
			}	
			echo '<div class="pagenav clearfix">';
			
				//Pagina Inicial
				//
				echo '<a href="'.URLBASE.$url[0].'?pesquisar='.$pesq.'&filtro='.$filtro.'&page=1" class="number">Primeira Página</a>';
				
				//Pagina Alterior
				if($paginaAtual >= 2){
					$pagePrev = $paginaAtual - 1;
					echo '<a href="'.URLBASE.$url[0].'?pesquisar='.$pesq.'&filtro='.$filtro.'&page='.$pagePrev.'" class="number">'.$pagePrev.'</a>';
				}
				
				//Pagina Atual
				echo '<span>'.$paginaAtual.'</span>';
				
				//Proxima Pagina
				if($paginaAtual != $paginas){
					$pageNext = $paginaAtual + 1;
					echo '<a href="'.URLBASE.$url[0].'?pesquisar='.$pesq.'&filtro='.$filtro.'&page='.$pageNext.'" class="number">'.$pageNext.'</a>';
				}
				
				//Ultima Inicial
				echo '<a href="'.URLBASE.$url[0].'?pesquisar='.$pesq.'&filtro='.$filtro.'&page='.$paginas.'" class="number">Ultima Página</a>';
			
			echo '</div>';
		}
	}
	function pageAll($sql,$maxPosts, $paginaAtual){
		//PAGINATOR
		
		$res = DBread('horario_celula', "WHERE status = true");
		
		//$res = DBread($sql, "WHERE status = true AND categoriaSlug = '$categoria'");
		
		//Contagem
		$totalPost	= count($res);
		
		//Paginas
		$paginas	= ceil($totalPost / $maxPosts);
		
		if($paginaAtual > $paginas || $totalPost <= $maxPosts){
		}else{
			if(isset($_GET['url'])){
				$url[0] = $_GET['url'];
			}else{
				$url[0] = '';
			}	
			echo '<div class="pagenav clearfix">';
			
				//Pagina Inicial
				//
				echo '<a href="'.URLBASE.$url[0].'?page=1" class="number">Primeira Página</a>';
				
				//Pagina Alterior
				if($paginaAtual >= 2){
					$pagePrev = $paginaAtual - 1;
					echo '<a href="'.URLBASE.$url[0].'?page='.$pagePrev.'" class="number">'.$pagePrev.'</a>';
				}
				
				//Pagina Atual
				echo '<span>'.$paginaAtual.'</span>';
				
				//Proxima Pagina
				if($paginaAtual != $paginas){
					$pageNext = $paginaAtual + 1;
					echo '<a href="'.URLBASE.$url[0].'?page='.$pageNext.'" class="number">'.$pageNext.'</a>';
				}
				
				//Ultima Inicial
				echo '<a href="'.URLBASE.$url[0].'?page='.$paginas.'" class="number">Ultima Página</a>';
			
			echo '</div>';
		}
	}
?>
<style type="text/css">
.tabela{}
.tabela table{border-collapse:collapse; border:1px solid #ccc; width:100%; font-family:arial,​verdana,​sans-serif; font-size:16px; margin-top:20px}
.tabela table th{ padding: 3px 0px; }
.tabela table td{border-collapse:collapse; border:1px solid #ccc; padding:5px 0px; text-align: center; width: auto;}
.tabela a{}
.tabela a:hover{ text-decoration: underline; }
#clear{clear: both;}
#pesquisa input[type=text]{width:50%; height:30px; padding:2px 30px; border:1px #ccc solid; border-radius:5px; margin:5px 0; background: #eee url(images/search.png) no-repeat 8px center;}
#pesquisa form select { margin-top:2px;  margin-right:5px; padding: 5px 5px; width: auto;}
#pagebody ul{list-style: none;}
#pagebody ul li{display: block; margin-bottom: 10px; margin-left:-20px; }

.page-ati-single{}
.page-ati-single .info-single{float: left; width: 50%;}
.page-ati-single .info-single p {text-align: left;}
.page-ati-single .info-single a{ color: #3C87C1; }
.page-ati-single .info-single a:hover{ color: #3C87C1; text-decoration: underline;	 }
.page-ati-single .info-single ul{list-style: none;}
.page-ati-single .info-single ul li{display: block; margin-bottom: 10px;}
.corpo-single .foto-single{float: left;	}
.page-ati-single .foto-single{ float: right; font-size: 13px; width: 150px; height: 190px; line-height: 25px; text-align: center; margin-right: 20px; margin-bottom: 10px;
-webkit-box-shadow: 0px 2px 8px 0px rgba(50, 50, 50, 0.55);
-moz-box-shadow:    0px 2px 8px 0px rgba(50, 50, 50, 0.55);
box-shadow:         0px 2px 8px 0px rgba(50, 50, 50, 0.55);
}
.page-ati-single .foto-single img{width: 150px; height: 150px;}
.page-ati-single .foto-single .nome{width: 150px; height: 20px; background-color: #fff;}
#folha-corpo{ padding: 50px 30px; }
#folha-cabecario table{ margin-top: 40px; font-size: 13px; }
#folha-cabecario th{ text-align: left; padding-bottom: 5px; }
#folha-cabecario td{padding-left: 20px; padding-bottom: 5px;}
#folha-cabecario{ margin: 0px auto; width: 100%; height: 100px; }
#folha-cabecario img{ height: 62px; width: 250px; float: right; }
</style>
<H2>Células de Estudos</H2>
<p>Contém todas as células criadas pelos articuladores do programa, se você deseja procurar algo em especifico basta digitar alguma coisa.</p>
<?php
//Página de cada célula 
if(isset($url[1]) && $url[1] != ''){
		$celula 	= DBescape($url[1]);
		$celula 	= explode('-', $celula);
		$art 		= DBread('bolsistas', "WHERE npacce = '".$celula[0]."'");
		$projeto 	= DBread('projetos', "WHERE npacce = '".$celula[0]."' AND status = true", "sinopse, titulo, id, tema");

		$horario 	= DBread('horario_celula', "WHERE npacce = '".$celula[0]."' AND id = '".$celula[1]."'");
		if ($art == true) {
			$art = $art[0];
		?>
		
			<h3>Articulador da Célula</h3>
			<hr size="1" color="#ccc" style="margin-bottom:20px;">
		<div class="page-ati-single" style="margin-top:15px;">
			<div class="corpo-single">
				<div class="foto-single" style="float: left;">
					<span class="foto"><img src="<?php echo URL_PAINEL.'imagensBolsistas/'.$art['foto'].'';?>"><br></span>
					<div class="nome"><?php echo GetName($art['nome'], $art['nomeUsual']); ?></div>
				</div>
			</div>
		</div>
	
		<div id="folha-cabecario" style="width: 50%; float: left;">
			<table style="font-size: 15px; margin-top:0px;">
				
				<tr>
					<th>Nome: </th>
					<td><?php echo $art['nome']; ?></td>
				</tr>
				<tr>
					<th>Função:</th>
					<td><?php echo $art['tipo']; ?></td>
				</tr>
				<tr>
					<th>Curso:</th>
					<td><?php echo $art['curso']; ?></td>
				</tr>
				<tr>
					<th>Campus:</th>
					<td><?php echo $art['campus']; ?></td>
				</tr>
				
			</table>
		</div>
		<div id="clear"></div>
		<br><br>
		
		<h3>Local e Horário da Célula</h3>
		<hr size="1" color="#ccc" style="margin-bottom:20px;">
		<div id="folha-cabecario">
			<table style="font-size: 15px;" >
				<tr>
					<th>Tema:</th>
					<td><?php echo $projeto[0]['tema']; ?></td>
				</tr>
				<tr>
					<th>Título:</th>
					<td><?php echo $projeto[0]['titulo']; ?></td>
				</tr>
				<tr>
					<th>Campus:</th>
					<td><?php echo $horario[0]['campus']; ?></td>
				</tr>
				<tr>
					<th>Bloco:</th>
					<td><?php echo $horario[0]['bloco']; ?></td>
				</tr>
				<tr>
					<th>Unidade:</th>
					<td><?php echo $horario[0]['departamento']; ?></td>
				</tr>
				<tr>
					<th>Sala:</th>
					<td><?php echo $horario[0]['sala']; ?></td>
				</tr>
				<tr>
					<th>Horário:</th>
					<td><?php echo $horario[0]['diaSemana']; ?> - <?php echo date('H:i', strtotime($horario[0]['inicio'])).'h'; ?> - <?php echo date('H:i', strtotime($horario[0]['fim'])).'h'; ?>
				<?php 
					if ($horario[0]['diaSemana2'] != 1) {
						echo ' e '.$horario[0]['diaSemana2'].' - '. date('H:i', strtotime($horario[0]['inicio2'])).'h - '.date('H:i', strtotime($horario[0]['fim2'])).'h';
					}
				?></td>
				</tr>
			</table>
		</div>
		<div id="clear"></div>
		<br><br><br><br>
		<h3>Projeto</h3>
		<hr size="1" color="#ccc">
		<div id="folha-cabecario">
			<table style="font-size: 15px;" >
				<tr>
					<th>Título:</th>
					<td><?php echo $projeto[0]['titulo']; ?></td>
				</tr>
				<tr>
					<th>Sinopse:</th>
					<td><?php echo str_replace('\r\n', "<br>", $projeto[0]['sinopse']); ?></td>
				</tr>
			</table>
		</div>
		<?php
		}

}else{

?>
<div id="celula">
	<div id="pesquisa">
		<form action="" method="get">

			<input type="text" name="pesquisar"  placeholder="Digite alguma coisa" value="<?php if(isset($_GET['pesquisar'])){ echo $_GET['pesquisar'];} ?>"> 
			<div style="float: right; margin-top:8px;">
				
			Buscar por: 
		 	<select name="filtro" >
		 		<option <?php if(isset($_GET['filtro']) && $_GET['filtro'] == 'tema'){ echo 'selected=""';} ?> value="tema">Tema</option>
		 		<option value="campus" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == 'campus'){ echo 'selected=""';} ?> >Campus</option>
		 		<option value="bloco" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == 'bloco'){ echo 'selected=""';} ?>>Bloco</option>
		 		<option value="departamento" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == 'departamento'){ echo 'selected=""';} ?>>Unidade</option>
		 		<option value="diaSemana" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == 'diaSemana'){ echo 'selected=""';} ?>>Dia da Semana</option>
		 		<option value="inicio" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == 'inicio'){ echo 'selected=""';} ?>>Horário</option>
		 	</select>

			</div>
			<div id="clear">
				
			</div>
		</form>
	</div>
</div>
<?php 
		
	if (isset($_GET['pesquisar']) && $_GET['pesquisar'] != '') {
		$pesq 	= DBescape($_GET['pesquisar']);
		$filtro	= DBescape($_GET['filtro']);
		
		
			
		$paginaAtual 	= (!isset($_GET['page']) || $_GET['page'] == '' ? 1 : $_GET['page']);
		$maxPosts		= 20;
		$start			= ($paginaAtual * $maxPosts) - $maxPosts;

		//$selec 	   = DBread('posts',"WHERE status = 1 ORDER BY titulo ASC LIMIT $start, $maxPosts");

		if ($filtro == 'tema') {
			$projetos = DBread('projetos', "WHERE tema LIKE '%$pesq%' AND status = true ORDER BY tema ASC LIMIT $start, $maxPosts");
			if ($projetos == false) {
				$res = false;
			}else{
				for ($i=0; $i < count($projetos); $i++) { 
					$horario = DBread('horario_celula', "WHERE npacce = '".$projetos[$i]['npacce']."' AND status = true LIMIT 1");
					$res[$i] = $horario[0];
				}
			}
		}else if ($filtro == 'campus') {
			$res = DBread('horario_celula', "WHERE campus LIKE '%$pesq%' AND status = true ORDER BY titulo ASC LIMIT $start, $maxPosts");
		}else if ($filtro == 'bloco') {
			$res = DBread('horario_celula', "WHERE bloco LIKE '%$pesq%' AND status = true ORDER BY titulo ASC LIMIT $start, $maxPosts");
		}else if ($filtro == 'departamento') {
			$res = DBread('horario_celula', "WHERE departamento LIKE '%$pesq%' AND status = true ORDER BY titulo ASC LIMIT $start, $maxPosts");
		}else if ($filtro == 'diaSemana') {
			$res = DBread('horario_celula', "WHERE diaSemana LIKE '%$pesq%' AND status = true ORDER BY titulo ASC LIMIT $start, $maxPosts");
		}else{
			$res = DBread('horario_celula', "WHERE inicio LIKE '%$pesq%' AND status = true ORDER BY titulo ASC LIMIT $start, $maxPosts");
		}

		if($res == false){
			echo '<h2>Nada encontrado</h2>';
			}else{
	?>
	<div style="margin-top:15px;">

	<div style="margin-bottom:10px;">Resultados encontrados <?php echo "(".count($res).")"; ?></div>

	<div class="tabela" style="margin-bottom: 20px;">
		<table>
			<tr>
				<th>Tema</th>
				<th>Campus</th>
				<th>Dia e Hora</th>
				<th>Semestre</th>
			</tr>
			<?php 
				for ($i=0; $i < count($res); $i++) { 
					$tema = DBread('projetos', "WHERE npacce = '".$res[$i]['npacce']."' AND status = true LIMIT 1");
			?>
			<tr>
				<td style="cursor:pointer;" onclick="window.location='<?php echo URLBASE.$url[0].'/'.$res[$i]['npacce'].'-'.$res[$i]['id']; ?>'" title="<?php echo $tema[0]['tema']; ?>"><?php echo texto($tema[0]['tema'], 30); ?></td>
				<td style="cursor:pointer;" onclick="window.location='<?php echo URLBASE.$url[0].'/'.$res[$i]['npacce'].'-'.$res[$i]['id']; ?>'"><?php echo $res[$i]['campus']; ?></td>
				
				<td style="cursor:pointer;" onclick="window.location='<?php echo URLBASE.$url[0].'/'.$res[$i]['npacce'].'-'.$res[$i]['id']; ?>'"><?php echo $res[$i]['diaSemana']; ?> | <?php echo date('H:i', strtotime($res[$i]['inicio'])).'h'; ?> - <?php echo date('H:i', strtotime($res[$i]['fim'])).'h'; ?>
				<?php 
					if ($res[$i]['diaSemana2'] != 1) {
						echo '<br>'.$res[$i]['diaSemana2'].' | '. date('H:i', strtotime($res[$i]['inicio2'])).'h - '.date('H:i', strtotime($res[$i]['fim2'])).'h';
					}
				?>
				</td>
				<td style="cursor:pointer;" onclick="window.location='<?php echo URLBASE.$url[0].'/'.$res[$i]['npacce'].'-'.$res[$i]['id']; ?>'"><?php echo $res[$i]['semestre']; ?></td>
				
			</tr>
			<?php }?>
		</table>
	</div>
	<?php pagePesq('horario_celula', $pesq, $filtro, $maxPosts, $paginaAtual); ?>
	</div>
	<?php
		}
	}else{

		$paginaAtual 	= (!isset($_GET['page']) || $_GET['page'] == '' ? 1 : $_GET['page']);
		$maxPosts		= 20;
		$start			= ($paginaAtual * $maxPosts) - $maxPosts;
		$res = DBread('horario_celula', "WHERE status = true ORDER BY titulo ASC LIMIT $start, $maxPosts");
		$cont = DBread('horario_celula', "WHERE status = true ", "id");
		if($res == false){
			echo '<h2>Nada encontrado</h2>';
			}else{
		?>
		<div style="margin-top:15px;">

	<div style="margin-bottom:10px;">Resultados encontrados <?php echo "(".count($cont).")"; ?></div>

	<div class="tabela" style="margin-bottom: 20px;">
		<table>
			<tr>
				<th>Tema</th>
				<th>Campus</th>
				<th>Dia e Hora</th>
				<th>Semestre</th>
			</tr>
			<?php 
				for ($i=0; $i < count($res); $i++) { 
					$tema = DBread('projetos', "WHERE npacce = '".$res[$i]['npacce']."' AND status = true LIMIT 1");
			?>
			<tr>
				<td style="cursor:pointer;" onclick="window.location='<?php echo URLBASE.$url[0].'/'.$res[$i]['npacce'].'-'.$res[$i]['id']; ?>'" title="<?php echo $tema[0]['tema']; ?>"><?php echo texto($tema[0]['tema'], 30); ?></td>
				<td style="cursor:pointer;" onclick="window.location='<?php echo URLBASE.$url[0].'/'.$res[$i]['npacce'].'-'.$res[$i]['id']; ?>'"><?php echo $res[$i]['campus']; ?></td>
				
				<td style="cursor:pointer;" onclick="window.location='<?php echo URLBASE.$url[0].'/'.$res[$i]['npacce'].'-'.$res[$i]['id']; ?>'"><?php echo $res[$i]['diaSemana']; ?> | <?php echo date('H:i', strtotime($res[$i]['inicio'])).'h'; ?> - <?php echo date('H:i', strtotime($res[$i]['fim'])).'h'; ?>
				<?php 
					if ($res[$i]['diaSemana2'] != 1) {
						echo '<br>'.$res[$i]['diaSemana2'].' | '. date('H:i', strtotime($res[$i]['inicio2'])).'h - '.date('H:i', strtotime($res[$i]['fim2'])).'h';
					}
				?>
				</td>
				<td style="cursor:pointer;" onclick="window.location='<?php echo URLBASE.$url[0].'/'.$res[$i]['npacce'].'-'.$res[$i]['id']; ?>'"><?php echo $res[$i]['semestre']; ?></td>
				
			</tr>
			<?php }?>
		</table>
	</div>
	<?php pageAll('horario_celula', $maxPosts, $paginaAtual); ?>
	</div>
		<?php
		}
	}
}
	?>

