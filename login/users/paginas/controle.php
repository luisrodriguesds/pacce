<?php

if (isset($_POST['reposicao'])) {

	echo "<script> alert('".$_FILES['arquivo']['name']."'); </script>";

	$codigoEvento = $_POST['codigo'];
	$uploadFile = DIR_REPO.$codigoEvento.".pdf";

	echo $_FILES['arquivo']['type'];

	if ($_FILES['arquivo']['type'] == "application/pdf") {
		if (move_uploaded_file($_FILES['arquivo']['temp_name'], $uploadFile)) {
		    echo "<script> alert('Arquivo válido e enviado com sucesso.\n'); </script>";
		} else {
		    echo "<script> alert('Not uploaded because of error #".$_FILES["arquivo"]["error"]."); </script>";
		}
	} else {
		echo "<script> alert('Arquivo em formato diferente de PDF!'); </script>";
	}

} else if (isset($_POST['toggles'])) {
	echo "<script> alert('Yayyyyyyy'); </script>";
}



?>


<style>
	.switch {
		position: relative;
		display: inline-block;
		width: 32px;
		height: 18px;
	}

	.switch input { 
		opacity: 0;
		width: 0;
		height: 0;
	}

	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 14px;
		width: 14px;
		left: 2px;
		bottom: 2px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .slider {
		background-color: #2196F3;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(14px);
		-ms-transform: translateX(14px);
		transform: translateX(14px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 18px;		
	}

	.slider.round:before {
		border-radius: 50%;
	}
</style>

<h4>Reposição</h4>
<br>
<form method="post">

	<label class="switch">	
		teste
		<input type="checkbox" checked>

		<span class="slider round"></span>

	</label>
	<label class="switch">	
		teste
		<input type="checkbox" checked>

		<span class="slider round"></span>

	</label>
	<label class="switch">	
		
		<input type="checkbox" checked>

		<span class="slider round"></span>
		teste

	</label>
	<input type="submit" name="toggles">
</form>
<h4>Reposição</h4>
<br>
<form enctype="multipart/form-data" method="post">
	<select name="codigo">
		<?php
		$eventos = DBread('eventos');
		for ($i=0; $i < count($eventos); $i++) { 
			?>
			<option value="<?php echo $eventos[$i]['codigo'];?>"><?php echo $eventos[$i]['evento'];?></option>
			<?php
		}
		?>
	</select>
	<br><br>
	<input type="file" name="arquivo">
	<br><br>
	<input type="submit" name="reposicao">
</form>