<?php


$slides = DBread('slide');
$slides = $slides[0];
$numSlides = $slides['numSlides'];

// Em Teste //

$imgSlides = $slides['imgName'];

$imgSlides = explode(';', $imgSlides);

//////////////

function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}


if(isset($_POST['alterar'])){

	$fullSlide = '';



	$aux = DBread('slide');
	$aux = $aux[0];
	$aux['numSlides'] = GetPost('numSlideJS');


	if (DBUpDate('slide', $aux, "id = '0'")){
		echo $aux;	
	}

	$numSlides = $slides['numSlides'];

	$aux['imgName'] = '';

	for ($i=0; $i <$numSlides ; $i++) { 

		$novoNome[$i] = '';
		if(isset($_FILES['slide'.($i+1)]['name']) && $_FILES['slide'.($i+1)]["error"] == 0){
//DBUpDate('slide', "id = "); 
			$arquivo_tmp[$i] = $_FILES['slide'.($i+1)]['tmp_name'];
			$nome[$i] = $_FILES['slide'.($i+1)]['name'];

// Pega a extensao
			$extensao[$i] = strrchr($nome[$i], '.');

// Converte a extensao para mimusculo
			$extensao[$i] = strtolower($extensao[$i]);


			if(strstr('.jpg;.jpeg;.gif;.png', $extensao[$i])){


//$novoNome[$i] = "img".($i+1).$extensao[$i];
				$novoNome[$i] = md5(microtime()).$extensao[$i];

//$novoNome[$i] = 'img'.($i+1).$extensao[$i];

				$destino[$i] = DIR_IMG.$novoNome[$i];

				if( @move_uploaded_file( $arquivo_tmp[$i], $destino[$i]  )){    
				}else{
					echo '<script>alert("Ocorreu um erro, avise ao desenvolvedor!");';
				}
			}


		}
	}				


	for ($i=0; $i < $numSlides; $i++) { 
		if ($fullSlide != ''){
			$fullSlide = $fullSlide.";".$novoNome[$i];	
		} else {
			$fullSlide = $novoNome[$i];
		}


	}


	$slideNames = explode(';', $fullSlide);
	var_dump($slideNames);

	$error = 0;

	for ($i=0; $i < count($slideNames); $i++) { 
		if ($slideNames[$i] == null || $slideNames[$i] == '') {
			$error++;

			echo "XXX".$slideNames[$i]."XXX";
		}

	}

	if ($error>0) {
		echo '<script>alert("Uma das imagens está faltando!");</script>';
	} else {

		$aux['imgName'] = $fullSlide;
		if( DBUpDate('slide', $aux, "id = '0'")){
			echo '<script>alert("Slide atualizado com sucesso!.");
			window.location="'.$way.'/'.$url[1].'";</script>';
		}else{
			echo '<script>alert("Ocorreu um erro no momento de alteração, por favor informar ao desenvolvedor!.");
			window.location="'.$way.'/'.$url[1].'";</script>';

		}

	}

	echo $fullSlide."     ".$numSlides;

}

?>






<style type="text/css">
	h4 {
		margin: 0 20px;
		padding: 6px;
		display: block;
		border-radius: 8px;
		color: #fff;
	}

	label {
		padding: 20px;
		font-size: 18px;
		color: #fff;
		background-color: #574B90;
		border-radius: 8px;
		margin: 20px;
	}

	input[type=submit] {
		padding: 10px 15px;
		background-color: #069;
		font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
		color: #fff;
		border: none;
	}

	.slideImg {
		width: 250px;
		margin: 20px 0; 
		border-style: solid;
		border-color: #fff;
		box-shadow: 0px 2px 8px 0px rgba(50, 50, 50, 0.55);
	}

	.imageSelector {
		display: flex;
		align-items: flex-end;
	}

	.imageSelector div {
		display: flex;
		flex-direction: column;
		align-items: flex-start;
	}

</style>

<div class="title">
	<h2>Slide</h2>
</div>

<p>Página destinada à modificação das imagens presentes no slide show da página principal.</p>

<br>

<div class="title"><h2>Alterar Imagens</h2></div>
<br><br>
<div>

	<form action="" enctype="multipart/form-data" method="post">

		<input type="number" id="numSlideJS" name="numSlideJS" hidden="true" value="<?php echo $numSlides; ?>">

		<img src="<?php echo URL_PAINEL; ?>imagens/add.gif" style="width: 20px; cursor: pointer; margin-right: 20px;" onclick="addSlide();">

		<img src="<?php echo URL_PAINEL; ?>imagens/delete.gif" style="width: 20px; cursor: pointer;" onclick="removeSlide();"> 

		<div class="imageSelector">
			<img class="slideImg" src="<?php echo URLBASE; ?>/images/<?php echo $imgSlides[0] ?>"> 
			<div>
				<h4 <?php if (filesize(DIR_IMG.$imgSlides[$i]) >= 2097152) { echo 'style="background-color: #BA5959"';	} else { echo 'style="background-color: #5FBA7D"'; } ?>>
				<?php 
					echo formatSizeUnits(filesize(DIR_IMG.$imgSlides[$i])); 
				?>		
				</h4>
				<label for="slide1">
					Selecione uma imagem: <u><?php echo $imgSlides[0]; ?></u>
				</label>	
			</div>
			<input hidden required type="file" id="slide1" name="slide1"></input><br><br>
		</div>

		<div id="destino">
			<?php
			for ($i = 1; $i < $numSlides; $i++) { 
				?>
				<div class="imageSelector"> 
					<img class="slideImg" src="<?php echo URLBASE; ?>/images/<?php echo $imgSlides[$i] ?>">
					<div>
						<h4 <?php if (filesize(DIR_IMG.$imgSlides[$i]) >= 2097152) { echo 'style="background-color: #BA5959"';	} else { echo 'style="background-color: #5FBA7D"'; } ?>>
						<?php 
							
							echo formatSizeUnits(filesize(DIR_IMG.$imgSlides[$i])); 
						?>	
						</h4>
						<label for="slide<?php echo ($i+1) ?>">
							Selecione uma imagem: <u><?php echo $imgSlides[$i]; ?></u>
						</label>
					</div>
					<input hidden required type="file" id="slide<?php echo ($i+1) ?>" name="slide<?php echo ($i+1) ?>"></input><br><br>
				</div>
				<?php
			}
			?>
		</div>
		<center>
			<input type="submit" name="alterar" value="Alterar"></input>
		</center>
	</form>
</div>
<br><br>


<script type="text/javascript">

	function formatBytes(bytes,decimals) {
	   if(bytes == 0) return '0 Bytes';
	   var k = 1024,
	       dm = decimals <= 0 ? 0 : decimals || 2,
	       sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
	       i = Math.floor(Math.log(bytes) / Math.log(k));
	   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
	
	}

	function addInitialSlide(count) {


		var inputElement = document.querySelectorAll('input[type=file]');

		var divElement = inputElement[count].parentNode;
		console.log(divElement);

		var imgElement = divElement.getElementsByTagName('img')[0];

		var labelElement = divElement.getElementsByTagName('label')[0];

		var h4Element = divElement.getElementsByTagName('h4')[0];

		inputElement[count].addEventListener('change', function(e) {
			var url = URL.createObjectURL(e.target.files[0]);
			imgElement.setAttribute('src', url);

			var name = e.target.files[0].name;
			labelElement.innerHTML = "Selecione uma imagem: " + name; 

			var size = e.target.files[0].size;
			h4Element.innerHTML = formatBytes(size);

			if (size >= 2097152) {
				h4Element.style.backgroundColor = '#BA5959';
			} else {
				h4Element.style.backgroundColor = '#5FBA7D';
			}
		});

	}


	function addSlide() {

		var auxCountSlides = document.querySelector('#destino');

		var divElement = document.createElement('div');
		divElement.setAttribute('class','imageSelector');

		var imgElement = document.createElement('img');
		imgElement.setAttribute('class','slideImg');
		imgElement.setAttribute('src','');

		var extraDivElement = document.createElement('div');

		var h4Element = document.createElement('h4');
		h4Element.style.backgroundColor = '#ccc';

		var labelElement = document.createElement('label');
		labelElement.setAttribute('for','slide'+(parseInt(auxCountSlides.childElementCount+2)));
		labelElement.innerHTML = "Selecione uma imagem:";

		var inputElement = document.createElement('input');
		inputElement.setAttribute('hidden', '');
		inputElement.setAttribute('required', '');
		inputElement.setAttribute('type', 'file');
		inputElement.setAttribute('id', 'slide'+(parseInt(auxCountSlides.childElementCount+2)));
		inputElement.setAttribute('name', 'slide'+(parseInt(auxCountSlides.childElementCount+2)));
		inputElement.addEventListener('change', function(e) {
			var url = URL.createObjectURL(e.target.files[0]);
			imgElement.setAttribute('src', url);

			var name = e.target.files[0].name;
			labelElement.innerHTML = "Selecione uma imagem: " + name; 

			var size = e.target.files[0].size;
			h4Element.innerHTML = formatBytes(size);

			if (size >= 2097152) {
				h4Element.style.backgroundColor = '#BA5959';
			} else {
				h4Element.style.backgroundColor = '#5FBA7D';
			}
		});


		var brOneElement = document.createElement('br');
		var brTwoElement = document.createElement('br');

		extraDivElement.appendChild(h4Element);
		extraDivElement.appendChild(labelElement);

		divElement.appendChild(imgElement);
		divElement.appendChild(extraDivElement);
		divElement.appendChild(inputElement);
		divElement.appendChild(brOneElement);
		divElement.appendChild(brTwoElement);

		auxCountSlides.appendChild(divElement);

		var numSlides = document.querySelector('#numSlideJS');
		numSlides.value = auxCountSlides.childElementCount+1;

	}

	function removeSlide() {

		var auxCountSlides = document.querySelector('#destino');

		auxCountSlides.removeChild(auxCountSlides.lastChild);		

		var numSlides = document.querySelector('#numSlideJS');
		numSlides.value = auxCountSlides.childElementCount+1;

	}

	window.onload = function () {
		
		var auxCountSlides = document.querySelectorAll('.imageSelector');
		for (var i = 0; i < auxCountSlides.length; i++) {
			addInitialSlide(i);
			console.log(i);
		}

	};

</script>