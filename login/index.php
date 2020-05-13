<?php
  ini_set('smtp_port', '587');
  require_once '../sistema/system.php';
  AcessPublic();
  VerifyConectado();
  $url = (isset($_GET['url'])) ? $_GET['url'] : 'home';
  $url = array_filter(explode('/', $url));
  ValidaLogin(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
  <title>PACCE - LOGIN</title>

  <link rel="stylesheet" href="<?php echo URLBASE.'login'; ?>/dist/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo URLBASE.'login'; ?>/dist/modules/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo URLBASE.'login'; ?>/dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">

  <link rel="stylesheet" href="<?php echo URLBASE.'login'; ?>/dist/css/demo.css">
  <link rel="stylesheet" href="<?php echo URLBASE.'login'; ?>/dist/css/style.css">
  <link rel="shortcut icon" href="<?php echo URLBASE;?>images/pacce_icon.png" type="imgen/png">

</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <?php 
            if ($url[0] == 'home') {
              include 'paginas/login.php';
            }else if ($url[0] == 'registro') {
              include 'paginas/registro.php';
            }else if ($url[0] == 'recuperar-senha') {
              include 'paginas/recuperar-senha.php';
            }else if ($url[0] == 'nova-senha') {
              include 'paginas/nova-senha.php';
            }else{
              include 'paginas/404.php';
            }
          ?>
        </div>
      </div>
    </section>
  </div>

  <script src="<?php echo URLBASE.'login'; ?>/dist/modules/jquery.min.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/dist/modules/popper.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/dist/modules/tooltip.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/dist/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/dist/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/dist/modules/moment.min.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/dist/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/dist/js/sa-functions.js"></script>
  
  <script src="<?php echo URLBASE.'login'; ?>/dist/js/scripts.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/dist/js/custom.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/dist/js/demo.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/js/jquery.validate.min.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/js/additional-methods.min.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/js/jquery.mask.js"></script>
  <script src="<?php echo URLBASE.'login'; ?>/js/function.js?v=v2.0"></script>
<script type="text/javascript">
  function maiuscula(z){
    v = z.value.toUpperCase();
    z.value = v;
  }
</script>
</body>
</html>