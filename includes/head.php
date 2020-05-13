<?php 
require_once 'sistema/system.php';
$dadosUser = GetUser();
?><head>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141070125-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-141070125-1');
  </script>

  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <?php GetTitle(); ?>

  <link rel="shortcut icon" href="<?php echo URLBASE;?>images/pacce_icon.png" type="image/png">
  <link rel="stylesheet" id="themify-styles-css" href="<?php echo URLBASE;?>/style_1.css" type="text/css" media="all">
  <link rel="stylesheet" id="themify-media-queries-css" href="<?php echo URLBASE;?>/media-queries.css" type="text/css" media="all">

  <script src="<?php echo URLBASE;?>/js/jquery-1.11.3.min.js"></script>
  <script src="<?php echo URLBASE;?>/js/jquery.mask.min.js"></script>


  <style type="text/css">
    .recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}
  </style>

  <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/82b8bcfee3bb03ae5cc2aba4c/c697615746849cf455dbe54d2.js");</script>

</head>
<body class="home blog">
  <!-- teste -->