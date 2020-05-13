<?php 
require_once '../sistema/system.php';
	$slide = DBread('slide');
	$slide = $slide[0];
	//$selecSlides = $selecSlides[0];
	//$i = 1;
	// var_dump($selecSlides);
	//var_dump($selecSlides['img'.$i]);

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="slick.css"/>
	<link rel="stylesheet" type="text/css" href="slick-theme.css"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script type="text/javascript" src="jquery-3.3.1.js"></script>
	<script type="text/javascript" src="slick.js"></script>
	<script type="text/javascript" src="func_slide.js"></script>
</head>
<body>
	<div class="teste" id="imgBox">
		

	<?php

		$selecSlides = explode(';', $slide['imgName']);

		for ($i=0; $i < $slide['numSlides']; $i++) { 
				
			if ($selecSlides[$i] != '') {
				?>
				<div>
					<img src="<?php echo URLBASE; ?>/images/<?php echo $selecSlides[$i] ?>" alt="slider image" style="width: 100%">
				</div>
				<?php
			} 


		}

	?>
	</div>
</body>
</html>