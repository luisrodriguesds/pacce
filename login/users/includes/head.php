<?php 
  require_once '../../sistema/system.php';
  AcessPrivate();
  $dataUser = GetUser();
  $user     = $dataUser[0];
  $semana   = GetSemana();
  $way      = URL_PAINEL.$user['tipoSlug'];
  $url  = (isset($_GET['url'])) ? $_GET['url'] : $user['tipoSlug'];
  $url  = array_filter(explode('/', $url));
   //Semestre
  $semestre = array('01' => date('Y').'.1' , '02' => date('Y').'.1', '03' => date('Y').'.1', '04' => date('Y').'.1', '05' => date('Y').'.1', '06' => date('Y').'.1', '07' => date('Y').'.2', '08' => date('Y').'.2', '09' => date('Y').'.2', '10' => date('Y').'.2', '11' => date('Y').'.2', '12' => date('Y').'.2');
  //Dias da semana 
  $week  = array('Sun' => 'Domingo', 'Mon' => 'Segunda','Tue' => 'Terca','Wed' => 'Quarta','Thu' => 'Quinta','Fri' => 'Sexta','Sat' => 'Sábado');
  $month = array('Jan' => 'Janeiro', 'Feb' => 'Fevereiro', 'Mar' => 'Março',  'Apr' => 'Abril', 'May' => 'Maio', 'Jun' => 'Junho', 'Jul' => 'Julho', 'Aug' => 'Agosto', 'Sep' => 'Setembro', 'Oct' => 'Outubro', 'Nov' => 'Novembro', 'Dec' => 'Dezembro');
  
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
  <title>PACCE | UFC</title>

  <link rel="stylesheet" href="<?php echo URLBASE.'login/'; ?>dist/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo URLBASE.'login/'; ?>dist/modules/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo URLBASE.'login/'; ?>dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
  <link rel="shortcut icon" href="<?php echo URLBASE;?>images/pacce_icon.png" type="image/png">
  <link rel="stylesheet" href="<?php echo URLBASE.'login/'; ?>dist/modules/summernote/summernote-lite.css">
  <link rel="stylesheet" href="<?php echo URLBASE.'login/'; ?>dist/modules/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?php echo URLBASE.'login/'; ?>dist/css/demo.css">
  <link rel="stylesheet" href="<?php echo URLBASE.'login/'; ?>dist/css/style.css">
  <link rel="stylesheet" href="<?php echo URL_PAINEL; ?>css/style-01.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_PAINEL; ?>css/cropper.css">
  <script src="<?php echo URLBASE.'login/'; ?>dist/modules/jquery.min.js"></script>
  <style type="text/css">
    .imgBirth{width: 100%; height: 322px; object-fit: cover; border-radius: 10px;}

    @media (max-width: 600px) {
      .imgBirth 
       {
        height: 180px;
       }
    }

  </style>

</head>