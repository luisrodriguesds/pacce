<?php 

  // if ( (date('Y-m-d H:i:s', strtotime('2019-02-05 02:00:00')) < date('Y-m-d H:i:s'))) {
  //   alertaLoad('Inscrições fora do prazo', URLBASE.'/login');
  // }
?>
<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
    <div class="login-brand">
      PACCE - UFC
    </div>

    <div class="card card-primary">
      <div class="card-header"><h4>INSCRIÇÃO PARA AS BOLSAS PACCE</h4></div>

      <div class="card-body">
        <div class="row">
          <div class="col-12 text-center bold">
              <p>
                <a href="<?php echo URLBASE.'login/registro'; ?>"><img src="<?php echo URL_BASE.'dist/img/pacce.png'; ?>" style="width: 90%;"></a>
              </p>
              <p>UNIVERSIDADE FEDERAL DO CEARÁ - UFC</p>
              <p>PROGRAMA DE APRENDIZAGEM COOPERATIVA EM CÉLULAS ESTUDANTIS – PACCE</p>
              <!-- <p>PROGRAMA DE ESTÍMULO À COOPERAÇÃO NA ESCOLA – PRECE</p> -->
              <p><a href="https://drive.google.com/file/d/1hZqW0R_60yk1ui6be2-rXgn4TL7b2MQ5/view" target="_blank">PROCESSO SELETIVO 01/2020</a> <!-- | <a href="https://drive.google.com/file/d/1ocBRlJJohTT283fyw1gXqrBD8We2UY1D/view?usp=sharing" target="_blank">DATAS</a> --></p>
              <!-- <p><a href="#" target="_blank">EDITAL 02/2019 - PRECE</a> | <a href="#" target="_blank">DATAS</a></p> -->
              <p>>> ORIENTAÇÕES GERAIS <<</p>
              <p>Para preencher este formulário você precisará dos números dos seguintes documentos:</p>  
              <ul style="list-style: none;">
                <li>1. RG</li>
                <li>2. CPF</li>
                <li>3. Número de matrícula do seu curso na UFC</li>
                <li>3.1 No caso de recém ingresso na UFC, a comprovação de matrícula deverá ser enviado pelo e-mail <a href="mail:pacce.na.selecao@eideia.ufc.br">pacce.na.selecao@eideia.ufc.br</a> com o título "comprovante de matrícula".</li>
                <li>4. Ao final do formulário, você será desafiado a escrever um breve memorial, mais informações serão dadas durante o preenchimento do formulário. Não esqueça de mandar para pacce.na.selecao@eideia.ufc.br seu Histórico emitido pelo SIGAA atualizado.</li>
              </ul>
          </div>
        </div>
        <?php 
          //PAGINACAO
          // ==== ESCOLHER PACCE OU PRECCE ->
          // ==== ESCOLHER NOVATO OU VETERANO ->
          // ==== FORMULÁRIO 
          $url[1] = (isset($url[1])) ? $url[1] : 'home';
          if ($url[1] == 'home') {
            //ESCOLHE PACCE OU PRECE
            ?>
            <hr>
              <div class="row">
                  <div class="col-8 offset-2 text-center">
                    <h4 class="">Clique no link abaixo para realizar sua inscrição</h4>
                    <!-- <p>A seleção de ambas as bolsas irão ocorrer nas mesmas datas, portanto poderá haver inscrição em somemente uma modalidade.</p> -->
                  </div>
                  <div class="col-6 offset-3 text-center">
                    <div class="row">
                      <div class="col-12" style="margin-bottom: 20px;">
                        <a href="<?php echo URL_BASE.$url[0].'/pacce'; ?>" class="btn btn-primary btn-block">PACCE</a>
                      </div>
                      <div class="col-12">
                        <!-- <a href="<?php // echo URL_BASE.$url[0].'/prece'; ?>" class="btn btn-primary btn-block">PRECE</a> -->
                      </div>
                    </div>
                  </div>
              </div>
            <?php
          }else if($url[1] == 'pacce' || $url[1] == 'prece'){
            $url[2] = (isset($url[2])) ? $url[2] : 'home';
            if ($url[2] == 'home') {
              //ESCOLHE NOVATO OU VETERANO
              ?>
              <hr>
              <div class="row">
                  <div class="col-8 offset-2 text-center">
                    <h4>Você escolheu o programa:</h4>
                    <br>
                    <p><img src="<?php echo URL_BASE.'dist/img/'.$url[1].'.png'; ?>" style="width: 100%;"></p>
                    <br>
                    <h4>Escolha sua modalidade:</h4>
                    <p>Leia o edital do programa escolhido e verifique em qual modalidade você se enquadra.</p>
                  </div>
                  <div class="col-6 offset-3 text-center">
                    <div class="row">
                      <div class="col-12" style="margin-bottom: 20px;">
                        <a href="<?php echo URL_BASE.$url[0].'/'.$url[1].'/novato'; ?>" class="btn btn-primary btn-block">NOVATO</a>
                      </div>
                      <div class="col-12">
                        <a href="<?php echo URL_BASE.$url[0].'/'.$url[1].'/veterano'; ?>" class="btn btn-primary btn-block">VETERANO</a>
                      </div>
                    </div>
                  </div>
              </div>
              <?php
            }else if ($url[1] == 'pacce' && $url[2] == 'novato') {
              //FORMULÁRIO PACCE - NOVATOS ========================
              include 'forms/pacce-novatos.php';
            }else if ($url[1] == 'pacce' && $url[2] == 'veterano') {
              //FORMULÁRIO PACCE - VETERANO ========================
              include 'forms/pacce-veteranos.php';
            }else if ($url[1] == 'prece' && $url[2] == 'novato') {
              //FORMULÁRIO PRECE - NOVATOS ========================
              include 'forms/prece-novatos.php';
            }else if ($url[1] == 'prece' && $url[2] == 'veterano') {
              //FORMULÁRIO PRECE - VETERANO ========================
              include 'forms/prece-veteranos.php';
            }else{
              include 'paginas/404.php';
            }
          }else{
            include 'paginas/404.php';
          }
        ?>
        <!-- <form method="POST">
          <div class="row">
            <div class="form-group col-6">
              <label for="frist_name">First Name</label>
              <input id="frist_name" type="text" class="form-control" name="frist_name" autofocus>
            </div>
            <div class="form-group col-6">
              <label for="last_name">Last Name</label>
              <input id="last_name" type="text" class="form-control" name="last_name">
            </div>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control" name="email">
            <div class="invalid-feedback">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-6">
              <label for="password" class="d-block">Password</label>
              <input id="password" type="password" class="form-control" name="password">
            </div>
            <div class="form-group col-6">
              <label for="password2" class="d-block">Password Confirmation</label>
              <input id="password2" type="password" class="form-control" name="password-confirm">
            </div>
          </div>

          <div class="form-divider">
            Your Home
          </div>
          <div class="row">
            <div class="form-group col-6">
              <label>Country</label>
              <select class="form-control">
                <option>Indonesia</option>
                <option>Palestine</option>
                <option>Syria</option>
                <option>Malaysia</option>
                <option>Thailand</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label>Province</label>
              <select class="form-control">
                <option>West Java</option>
                <option>East Java</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-6">
              <label>City</label>
              <input type="text" class="form-control">
            </div>
            <div class="form-group col-6">
              <label>Postal Code</label>
              <input type="text" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" name="agree" class="custom-control-input" id="agree">
              <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">
              Register
            </button>
          </div>
        </form> -->

      </div>
    </div>
    <?php include 'includes/footer.php'; ?>
  </div>