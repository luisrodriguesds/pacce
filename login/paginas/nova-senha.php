<?php 
//BACKEND
if(isset($_GET['codigo']) && $_GET['codigo'] != ''){
  $codigo = strip_tags(trim($_GET['codigo']));
    $verCod = DBread('recuperar_senha', "WHERE codigo = '$codigo' LIMIT 1");
    if($verCod == false){
      alertaLoad('Este Link Expirou!', URL_BASE);
    }else{
        $emial_cod  = base64_decode($codigo);
        $dataAtual  = date('Y-m-d H:i:s');
        $dataCod    = $verCod[0]['data'];
        if(strtotime($dataCod) < strtotime($dataAtual)){
          if(DBDelete('recuperar_senha', "codigo = '$codigo'")){
            alertaLoad('Este Link Expirou!', URL_BASE);
          }
        }else{
            if(isset($_POST['enviar'])){
                $Update['password']   = md5(GetPost('password'));
                $novaSenha            = md5(GetPost('confirmPass'));
                if (empty($novaSenha) && empty($Update['password'])) {
                    alerta('Campos vazios!');
                }else if($Update['password'] != $novaSenha){
                    alerta('As senhas não correspondem!');
                }else{
                    if(DBread('bolsistas', "WHERE email = '$emial_cod'")){
                        if(DBUpDate('bolsistas', $Update, "email = '$emial_cod'")){
                          if (DBDelete('recuperar_senha', "codigo = '$codigo'")) {
                              alertaLoad("Sua senha foi alterada com sucesso!!", URL_BASE);
                          }
                        }
                    }
                }
            }
        }
    }
}else{
  alertaLoad("Nenhum código encontrado.", URL_BASE);
}

?>

<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
  <div class="login-brand">
    PACCE- UFC
  </div>

  <div class="card card-primary">
    <div class="card-header"><h4>Nova senha</h4></div>

    <div class="card-body">
      <p class="text-muted">Informe a nova senha e confirme.</p>
      <form method="post">
        <div class="form-group">
          <label for="password">Senha</label>
          <input id="password" value="<?php echo GetPost('password'); ?>" type="password" class="form-control" name="password" tabindex="1" required autofocus>
        </div>

        <div class="form-group">
          <label for="confirmPass">Confirmar senha</label>
          <input id="confirmPass" value="<?php echo GetPost('confirmPass'); ?>" type="password" class="form-control" name="confirmPass" tabindex="1" required>
        </div>

        <div class="form-group">
          <button type="submit" name="enviar" class="btn btn-primary btn-block" tabindex="4">
            Confirmar
          </button>
        </div>
      </form>
    </div>
  </div>
  <?php include 'includes/footer.php'; ?>
</div>