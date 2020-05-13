<?php include 'includes/head.php'; ?>

<?php 

?>
<body>
  <div id="app">
    <div class="main-wrapper">
      
      <?php include 'includes/header.php'; ?>

      <?php include 'includes/nav.php'; ?>

      <?php include 'includes/main.php'; ?>

      <?php include 'includes/footer.php'; ?>
      
    </div>
  </div>

  <script src="<?php echo URLBASE.'login/'; ?>dist/modules/jquery.min.js"></script>
  <script src="<?php echo URLBASE.'login/'; ?>dist/modules/popper.js"></script>
  <script src="<?php echo URLBASE.'login/'; ?>dist/modules/tooltip.js"></script>
  <script src="<?php echo URLBASE.'login/'; ?>dist/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo URLBASE.'login/'; ?>dist/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?php echo URLBASE.'login/'; ?>dist/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
  <script src="<?php echo URLBASE.'login/'; ?>dist/js/sa-functions.js"></script>
  
  <script src="<?php echo URLBASE.'login/'; ?>dist/modules/chart.min.js"></script>
  <script src="<?php echo URLBASE.'login/'; ?>dist/modules/summernote/summernote-lite.js"></script>

  <script src="<?php echo URLBASE.'login/'; ?>dist/js/scripts.js"></script>
  <script src="<?php echo URLBASE.'login/'; ?>dist/js/custom.js"></script>
  <script src="<?php echo URLBASE.'login/'; ?>dist/js/demo.js"></script>
  <script src="<?php echo URL_PAINEL.''; ?>js/cropper.js"></script>
  <script src="<?php echo URL_PAINEL.''; ?>js/jquery.validate.min.js"></script>
  <script src="<?php echo URL_PAINEL.''; ?>js/additional-methods.min.js"></script>
  <script src="<?php echo URL_PAINEL.''; ?>js/jquery.mask.min.js"></script>
  <script src="<?php echo URL_PAINEL.''; ?>js/functions_1.js"></script>
  <script src="<?php echo URL_PAINEL.''; ?>js/crop.js"></script>
  <script src="<?php echo URL_PAINEL.''; ?>js/formularios.js?v=1.0"></script>


    <!-- Button trigger modal -->
 <?php 
  // if (!isset($_COOKIE['popup'])) {
  //   echo ' <button type="button" class="button-modal" class="btn btn-primary" data-toggle="modal" data-target="#popup_form">
  //         Launch demo modal
  //       </button>
  //     ';
  // }
 ?>
  <!-- Modal -->
  <div class="modal fade" id="popup_form" tabindex="-1" role="dialog" aria-labelledby="popup_formLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="popup_formLabel">Nível de satisfação!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Ajude a contribuir com os desenvolvedores desse projeto e responda o quesquionário a seguir!</p>
          <a href="https://goo.gl/forms/LEL6Ys7PcfnqXVfq2" target="_blank" class="popup btn btn-primary">Responder questionário!</a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
 <script type="text/javascript">
  // $(".button-modal").click();
  // $(".popup").click(function(event) {
  //   $('.modal').click();
  // });

  // $('#popup_form').on('hidden.bs.modal', function (e) {
  //   // do something...
  //   $.post('<?php // echo URL_PAINEL; ?>ajax/cookie.php', {criar:'criar'}, function(data, textStatus, xhr) {
  //     /*optional stuff to do after success */
  //     console.log("cookie criado");
  //   });

  // });
  </script>
</body>
</html>