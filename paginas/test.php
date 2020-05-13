<?php 
require_once '../sistema/system.php';
	$nome = $_POST['name'];
	$select = DBread('bolsistas', "WHERE nome LIKE '%$nome%'");
	for ($i=0; $i < count($select); $i++) { 
		echo $select[$i]['nome'].'  ';
	}
	
?>