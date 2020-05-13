<!-- INÍCIO DO ANIVERSARIO.PHP -->
<?php

// $sem_data = DBread('calendario_2016', "WHERE semana = '$semana'");
// echo $sem_data[0]['inicio'].' até '.$sem_data[0]['fim'];
$teste1 = "2019-09-16 00:00:00";
$teste2 = "2019-09-22 23:59:59";
// if (check_in_range($start_date, $end_date, $date_from_user) == false) {
// 	echo "falso";
// }
//check_in_range($start_date, $end_date, $date_from_user);
$bolsistasNiver = DBread('bolsistas', "WHERE status = 1 and (campusSlug = 'benfica' or campusSlug = 'pici' or campusSlug = 'labomar' or campusSlug = 'porangabucu') ORDER BY dataNasc");

$yearPattern = mb_substr($sem_data[0]['inicio'], 0, 4);

$npacceYearArray = array();


for ($i=0; $i <count($bolsistasNiver) ; $i++) {

	$bolsistasNiver[$i]['dataNasc'] = preg_replace('/([\d]{4})/', $yearPattern, $bolsistasNiver[$i]['dataNasc']);

	if (check_in_range($sem_data[0]['inicio'], $sem_data[0]['fim'], $bolsistasNiver[$i]['dataNasc'])) {
		array_push($npacceYearArray, $bolsistasNiver[$i]['npacce']);
	}
}


// var_dump($npacceYearArray);


function check_in_range($start_date, $end_date, $date_from_user) {
	// Convert to timestamp
	$start_ts = strtotime($start_date);
	$end_ts = strtotime($end_date);
	$user_ts = strtotime($date_from_user);
 
	// Check that user date is between start & end
 
	return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));

}

?>

<div class="title"><h2>&#x1F389 &#x1F973 Aniversariantes da Semana! &#x1F973 &#x1F389</h2></div>

<div class="birth-holder">

	<?php

	for ($i=0; $i < count($npacceYearArray); $i++) { 
		
		$bolsistaAtual = DBread('bolsistas', "WHERE npacce ='".$npacceYearArray[$i]."'");
		$bolsistaAtual = $bolsistaAtual[0];
		
		?>

		<div class="foto-single-birth">
			<img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$bolsistaAtual['foto']; ?>">
			<!-- <div class="nome"><?php echo GetName($bolsistaAtual['nome'], $bolsistaAtual['nomeUsual']).'<br>'.substr(date('d/m/y',strtotime($bolsistaAtual['dataNasc'])), 0, 5) ; ?></div> -->
			<div>

				<div class="nome"><?php echo $bolsistaAtual['npacce']; ?></div>

				<div class="nome"> <?php echo GetName($bolsistaAtual['nome'], $bolsistaAtual['nomeUsual']) ; ?></div>
				
				<div class="nome"><?php echo substr(date('d/m/y',strtotime($bolsistaAtual['dataNasc'])), 0, 5); ?></div>

			</div>
		</div>

		<?php

		
	}

	?>

	
</div>


<style type="text/css">
	
	.birth-holder {
		display: flex;
		flex-wrap: wrap;
		margin-bottom: 10px;
	}

	.foto-single-birth > div{
		width: 50%;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}

	.foto-single-birth{ 
		background-color: #fff;
		display: flex;
		font-size: 12px; 
		width: 180px; 
		height: 90px; 
		text-align: center; 
		margin: 10px;
		-webkit-box-shadow: 0px 2px 8px 0px rgba(50, 50, 50, 0.55);
		-moz-box-shadow:    0px 2px 8px 0px rgba(50, 50, 50, 0.55);
		box-shadow:         0px 2px 8px 0px rgba(50, 50, 50, 0.55);
	}

	.foto-single-birth img{height: 100%;}
	.foto-single-birth .nome{margin: 2px 0; background-color: #fff;}
	
</style>