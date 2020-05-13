<?php 
//BACKEND
  if(isset($_POST['enviar'])){
    $email = GetPost('email');
    if(empty($email)){
        alerta("Campo email vazio");
    }else{
      $verificaEmail = DBread('bolsistas', "WHERE email = '$email' LIMIT 1");
      if($verificaEmail == false){
        alerta("Este email não está cadastrado! ");
      }else{
        $codigo           = base64_encode($email);
        $date_expirar     = date('Y-m-d H:i:s', strtotime('+2 hours'));
        $mensagem         = '<meta charset="utf-8"><p>Recebemos uma tentativa de recuperacao de senha, caso nao tenha sido voce que solicitou, por favor
        desconcidarar este email, caso contrario click no link a baixo <br> <a href="http://'.URLBASE.'/login/nova-senha?codigo='.$codigo.'">Recuperar Senha</a> </p>
        <br><p>OBS: Este email e automatico, por favor nao o responda!';
        $email_remetente  = "pacce.monitoria@eideia.ufc.br";
        $insert['codigo'] = $codigo;
        $insert['data']   = $date_expirar;
        
        $headers = "MIME-Version: 1.1\n";
        $headers .= "Content-type: text/plain; charset=iso-8859-1\n"; // ou UTF-8, como queira
        $headers .= "From: $email_remetente\n"; // remetente
        $headers .= "Return-Path: $email_remetente\n"; // return-path
        $headers .= "Replay-To: $email\n";

        if(DBread('recuperar_senha', "WHERE codigo = '$codigo'")){
            alerta("Um link já foi enviado para esse email! Confira sua caixa de entrada!");
        }else{
          if(DBcreate('recuperar_senha', $insert)){
            
            $mail = @mail("$email", "PACCE - Recuperar Senha", "$mensagem", $headers, "-f$email_remetente");
            
            if ($mail) {
              alerta("Email enviado com sucesso! Confira sua caixa de entrada!");
            }else{
              alerta('Ocorreu um problema, tente mais tarde');
            }
            
          }

        }
      }
  }
}
?>

<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
  <div class="login-brand">
    PACCE- UFC
  </div>

  <div class="card card-primary">
    <div class="card-header"><h4>Esqueci minha senha</h4></div>

    <div class="card-body">
      <p class="text-muted">O link de recuperação será enviado para o seu email.</p>
      <form method="post">
        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" value="<?php echo GetPost('email'); ?>" type="email" class="form-control" name="email" tabindex="1" required autofocus>
        </div>

        <div class="form-group">
          <button type="submit" name="enviar" class="btn btn-primary btn-block" tabindex="4">
            Enviar
          </button>
        </div>
      </form>
    </div>
  </div>
  <?php include 'includes/footer.php'; ?>
</div>