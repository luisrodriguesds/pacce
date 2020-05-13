<?php 
	require_once '../../../sistema/system.php';

	if (isset($_POST['trio'])) {
		$trio = DBread('sl_trios', "WHERE trio  = '".$_POST['trio']."'");
		if ($trio == true) {
			$trio = $trio[0];
			/*echo '<br><ul>';
			echo '<li>'.$trio['npacce1'].' - '.$trio['nome1'].'<br>'.$trio['curso1'].'</li><br>';
			echo '<li>'.$trio['npacce2'].' - '.$trio['nome2'].'<br>'.$trio['curso2'].'</li><br>';
			echo '<li>'.$trio['npacce3'].' - '.$trio['nome3'].'<br>'.$trio['curso3'].'</li><br>';
			echo '<ul>';*/
			$foto1 = DBread('bolsistas', "WHERE npacce = '".$trio['npacce1']."'", "foto");
			$foto2 = DBread('bolsistas', "WHERE npacce = '".$trio['npacce2']."'", "foto");
			$foto3 = DBread('bolsistas', "WHERE npacce = '".$trio['npacce3']."'", "foto");
			$foto4 = DBread('bolsistas', "WHERE npacce = '".$trio['npacce4']."'", "foto");
			?>
			<br>
			<div class="foto-single" style="float: left;" title="<?php echo $trio['npacce1'].' - '.$trio['nome1']; ?>">
				<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto1[0]['foto']; ?>"><br></span>
				<div class="nome"><?php echo $trio['nomeUsual1']; ?></div>
			</div>
			<div class="foto-single" style="float: left;" title="<?php echo $trio['npacce2'].' - '.$trio['nome2']; ?>">
				<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto2[0]['foto']; ?>"><br></span>
				<div class="nome"><?php echo $trio['nomeUsual2']; ?></div>
			</div>
			<div class="foto-single" style="float: left;" title="<?php echo $trio['npacce3'].' - '.$trio['nome3']; ?>">
				<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto3[0]['foto']; ?>"><br></span>
				<div class="nome"><?php echo $trio['nomeUsual3']; ?></div>
			</div>
			<div class="foto-single" style="float: left;" title="<?php echo $trio['npacce4'].' - '.$trio['nome4']; ?>">
				<span class="foto"><img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$foto4[0]['foto']; ?>"><br></span>
				<div class="nome"><?php echo $trio['nomeUsual4']; ?></div>
			</div>
			<div id="clear"></div>
			<?php
		}
	}
?>