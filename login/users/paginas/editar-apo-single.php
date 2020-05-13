
<?php 

  if (isset($_POST['editar'])) {
    //$form['sala']       = GetPost('sala');
      if ($user['tipoSlug'] == 'ceo') {
        $form['npacce1'] = GetPost('npacce1');
        $form['npacce2'] = GetPost('npacce2');
        $form['semanaInicio']= GetPost('semanaInicio');
        $form['semanaFim']  = GetPost('semanaFim');
        $form['regiao']       = GetPost('regiao');
        $form['regiaoSlug']   = Slug(GetPost('regiao'));
        $npacce1 = DBread('bolsistas', "WHERE npacce = '".$form['npacce1']."'", "id, nome, npacce, nomeUsual");
        $npacce2 = DBread('bolsistas', "WHERE npacce = '".$form['npacce2']."'", "id, nome, npacce, nomeUsual");
        
        if ($form['npacce1'] == false) {
           echo '<script> alert("Bolsista não encontrado!"); </script>';
        }else if (!empty($form['npacce2']) && $npacce2 == false) {
          echo '<script>alert("Esse bolsista não existe!"); </script>';
        }else{
            $form['bol1']         = GetName($npacce1[0]['nome'], $npacce1[0]['nomeUsual']);
            $form['nomeComp1']    = $npacce1[0]['nome'];
            if (!empty($form['npacce2'])) {
              $form['bol2']       = GetName($npacce2[0]['nome'], $npacce2[0]['nomeUsual']);
              $form['nomeComp2']    = $npacce2[0]['nome'];
            }
         }
         if ($form['semanaInicio'] != $apo['semanaInicio'] || $form['semanaFim'] != $apo['semanaFim']) {
            if (DBDelete('apo_cod', "sala = '".$apo['sala']."' ")) {
              $ano                = date('y');
              $sala               = explode("-", $apo['sala']);
              $sala               = $sala[1];
              $codigo['codigo']   = '';
              $codigo['sala']     = $apo['sala'];
              $codigo['status']   = 1;
              $codigo['registro'] = date('Y-m-d H:i:s');
              for ($i=$form['semanaInicio']+1; $i <= $form['semanaFim']; $i++) { 
                if ($i < 10) {
                  $codigo['codigo'] = 'APO'.$ano.'0'.$i.$sala;
                }else{
                  $codigo['codigo'] = 'APO'.$ano.$i.$sala;
                }
                DBcreate('apo_cod', $codigo);
              }
            }
            
          } 
      }else{
        $form['semanaInicio']= $apo['semanaInicio'];
        $form['semanaFim']  = $apo['semanaFim'];
        $form['npacce1']    = $apo['npacce1'];
        $form['npacce2']    = $apo['npacce2'];
        $form['regiao']     = $apo['regiao'];
        $form['regiaoSlug'] = $apo['regiao'];

      }
      $form['local']        = GetPost('local');
      $form['inicio']       = GetPost('inicio');
      $form['fim']          = GetPost('fim');
      $form['dataInicio']   = GetPost('dataInicio').' '.$form['inicio'];
      $form['dataFim']      = GetPost('dataFim');
      $form['diaSemana']    = date('D', strtotime($form['dataInicio']));
      $form['diaSemana']    = $week[$form['diaSemana']];
      $form['disc']         = GetPost('disc');
      $form['cardName']     = 'Formação';
      $form['cor']          = GetPost('cor');
      $form['turno']        = GetPost('turno');
      $form['registro']     = date('Y-m-d H:i:s');
      

      $form['vagaInicial']  = GetPost('vagaInicial');
      $form['vagaAtual']    = $apo['vagaAtual'];
    
      if(empty($form['local'])){
        echo '<script>alert("Campo Local está vazio"); </script>';
      }else if(empty($form['dataInicio'])){
        echo '<script>alert("Campo Data do Início está vazio"); </script>';
      }else if(empty($form['dataFim'])){
        echo '<script>alert("Campo Data do Fim está vazio"); </script>';
      }else if(date('Y-m-d', strtotime($form['dataFim'])) < date('Y-m-d', strtotime($form['dataInicio']))){
        echo '<script>alert("As datas estão incoerentes!"); </script>';
      }else if (empty($form['inicio'])) {
        echo '<script>alert("Campo Horário do Início está vazio"); </script>';
      }else if (empty($form['fim'])) {
        echo '<script>alert("Campo Horário do Fim está vazio"); </script>';
      }else if (date('H:i:s', strtotime($form['fim'])) <  date('H:i:s', strtotime($form['inicio']))) {
        echo '<script>alert("Os horário estão incoerentes!!"); </script>';
      }else if (empty($form['regiao']) || $form['regiao'] == -1) {
        echo '<script>alert("Campo Região está vazio"); </script>';
      }else if (empty($form['semanaInicio']) || $form['semanaInicio'] == -1) {
        echo '<script>alert("Campo Semana de Inscrição está vazio"); </script>';
      }else if (empty($form['semanaFim']) || $form['semanaFim'] == -1) {
        echo '<script>alert("Campo Semana do Fim está vazio"); </script>';
      }else if($form['semanaInicio'] > $form['semanaFim']){
        echo '<script>alert("As semanas estão incoerentes!!"); </script>';
      }else if (empty($form['vagaInicial'])) {
        echo '<script>alert("Campo Vagas está vazio"); </script>';
      }else if (empty($form['disc'])) {
        echo '<script>alert("Campo Descrição está vazio está vazio"); </script>';
      }else if (empty($form['cor']) || $form['cor'] == '#ccc') {
        echo '<script>alert("Campo Cor está vazio"); </script>';
      }else{
        if ($form['vagaInicial'] < $apo['vagaInicial']) {
            $res = $apo['vagaInicial'] - $form['vagaInicial'];
            $form['vagaAtual'] = $form['vagaAtual'] - $res;
        }else if($form['vagaInicial'] > $apo['vagaInicial']){
          $res = $form['vagaInicial'] - $apo['vagaInicial'];
          $form['vagaAtual'] = $form['vagaAtual'] + $res;
        }
       if (DBUpDate('apo_salas', $form,"sala = '".$apo['sala']."' ")) {
        echo '
                 <script>
                  alert("Edição realizada com sucesso!!.");
                    window.location="'.$way.'/'.$url[1].'/'.$apo['sala'].'";
                  </script>';
       }
    }
  }
?>
<div class="title"><h2>Editar Informações da Sala <?php echo $apo['sala']; ?></h2></div>
<div id="editar-ativ" class="form">
   <form action="" method="post" enctype="multipart/form-data">
    <label>Sala:</label><br>
    <span><strong><?php echo $apo['sala']; ?></strong></span><br><br>
    <label class="label">Local:</label><span style="color:red;"> * </span><br>
    <input type="text" name="local" onkeyup="maiuscula(this)" value="<?php echo $apo['local']; ?>" placeholder="Digite o local dessa sala"></input><br><br>
    <label class="label">Data do Início:</label><span style="color:red;"> * </span><br>
    <input type="date" name="dataInicio"  value="<?php echo date('Y-m-d', strtotime($apo['dataInicio'])); ?>" placeholder="Digite a data de Inicio dessa sala"></input><br><br>
    <label class="label">Data do Fim:</label><span style="color:red;"> * </span><br>
    <input type="date" name="dataFim"  value="<?php echo date('Y-m-d', strtotime($apo['dataFim'])); ?>" placeholder="Digite a data do fim dessa sala"></input><br><br>
    <label class="label">Horário do Início:</label><span style="color:red;"> * </span><br>
    <input type="time" name="inicio"  value="<?php echo date('H:i:s', strtotime($apo['inicio'])); ?>" placeholder="Digite horário do início dessa sala"></input><br><br>
    <label class="label">Horário do Fim:</label><span style="color:red;"> * </span><br>
    <input type="time" name="fim"  value="<?php echo date('H:i:s', strtotime($apo['fim'])); ?>" placeholder="Digite horário do início dessa sala"></input><br><br>
    <label class="label">Turno</label><span style="color:red;"> * </span><br>
    <select name="turno">
      <option value="Manhã">Manhã</option>
      <option value="Tarde">Tarde</option>
      <option value="Noite">Noite</option>
    </select>
    <br><br>
    

       <?php 
        if ($user['tipoSlug'] == 'ceo') {
       ?>
       <label class="label">Região:</label><span style="color:red;"> * </span><br>
        <select name="regiao">
          <option selected="" value="-1">Escolha um campus...</option>
          <option <?php if($apo['regiaoSlug'] == 'fortaleza'){ echo 'selected=""';} ?> value="Fortaleza" title="Benfica, PICI, Porangabuçu e LABOMAR">Fortaleza</option>
          <option <?php if($apo['regiaoSlug'] == 'crateus'){ echo 'selected=""';} ?> value="Crateús">Crateús</option>
          <option <?php if($apo['regiaoSlug'] == 'quixada'){ echo 'selected=""';} ?> value="Quixadá">Quixadá</option>
          <option <?php if($apo['regiaoSlug'] == 'russas'){ echo 'selected=""';} ?> value="Russas">Russas</option>
          <option <?php if($apo['regiaoSlug'] == 'sobral'){ echo 'selected=""';} ?> value="Sobral">Sobral</option>
        </select>    
        <br><br>
        <label class="label">Semana de Inscrição:</label><span style="color:red;"> * </span><br>
          <select name="semanaInicio">
            <option value="-1">Escolha a Semana que essa sala ficará aberta para inscrição...</option>
            <?php 
            $weeks = DBread('calendario_2016', "ORDER BY semana ASC");
           
            for ($i=0; $i < count($weeks); $i++) {
               $check = '';
              if ($apo['semanaInicio'] == $weeks[$i]['semana']) {
                $check = 'selected=""';
              }else{
                $check = '';
              }
              if ($weeks[$i]['semana'] < 10) {
                echo '<option '.$check.' value="'.$weeks[$i]['semana'].'">Semana 0'.$weeks[$i]['semana'].' - '.date('d/m/y', strtotime($weeks[$i]['inicio'])).' até '.date('d/m/y', strtotime($weeks[$i]['fim'])).'</option>';
               }else{
                echo '<option '.$check.' value="'.$weeks[$i]['semana'].'">Semana '.$weeks[$i]['semana'].' - '.date('d/m/y', strtotime($weeks[$i]['inicio'])).' até '.date('d/m/y', strtotime($weeks[$i]['fim'])).'</option>';
               } 
            }
            ?>
          </select>
        <br><br>

        <label class="label">Semana do Fim:</label><span style="color:red;"> * </span><br>
          <select name="semanaFim">
            <option value="-1">Escolha a Semana que essa sala encerrará as atividades...</option>
            <?php 
            $weeks = DBread('calendario_2016', "ORDER BY semana ASC");
         
            for ($i=0; $i < count($weeks); $i++) {
              $check = '';
              if ($apo['semanaFim'] == $weeks[$i]['semana']) {
                $check = 'selected=""';
              }else{
                $check = '';

              }
              if ($weeks[$i]['semana'] < 10) {
                echo '<option '.$check.' value="'.$weeks[$i]['semana'].'">Semana 0'.$weeks[$i]['semana'].' - '.date('d/m/y', strtotime($weeks[$i]['inicio'])).' até '.date('d/m/y', strtotime($weeks[$i]['fim'])).'</option>';
               }else{
                echo '<option '.$check.' value="'.$weeks[$i]['semana'].'">Semana '.$weeks[$i]['semana'].' - '.date('d/m/y', strtotime($weeks[$i]['inicio'])).' até '.date('d/m/y', strtotime($weeks[$i]['fim'])).'</option>';
               } 
            }
            ?>
          </select>
        <br><br>
        <?php } ?>
        
      <label>Número PACCE do Facilitador:</label><br>
       <?php 
        if ($user['tipoSlug'] == 'ceo') {
          ?>
        
        <input type="text" name="npacce1" onkeyup="maiuscula(this)" value="<?php echo $apo['npacce1']; ?>" placeholder="Digite um número PACCE"></input><br><br>
      
          <?php
        }else{
          ?>
           <span><strong><?php echo $apo['npacce1']; ?></strong></span><br><br>
          <?php
        }
       ?>
      
      <label> Nome usual do Facilitador:</label><br>
       <span><strong><?php echo $apo['bol1']; ?></strong></span><br><br>
       <br>
       <label>Número PACCE do Facilitador:</label><br>
       <?php 
        if ($user['tipoSlug'] == 'ceo') {
          ?>
        <input type="text" name="npacce2" onkeyup="maiuscula(this)" value="<?php echo $apo['npacce2']; ?>" placeholder="Digite um número PACCE"></input><br><br>
      
          <?php
        }else{
          ?>
           <span><strong><?php echo $apo['npacce2']; ?></strong></span><br><br>
          <?php
        }
       ?>
       <label>Nome usual do Facilitador:</label><br>
       <span><strong><?php echo $apo['bol2']; ?></strong></span><br><br>
       <label> Vagas:</label><br>
        <input type="number" max="100" name="vagaInicial" onkeyup="" value="<?php echo $apo['vagaInicial']; ?>" placeholder="Digite o número de vagas dessa sala"></input><br><br>
     <label> Vaga Atual:</label><br>
       <span><strong><?php echo $apo['vagaAtual']; ?></strong></span><br><br>

      <label class="label">Descrição:</label><span style="color:red;"> * </span><br>
       <textarea name="disc"><?php echo printPost($apo['disc'], 'campo'); ?></textarea>
       
       <center>
       <br><label>Cor do Card:</label><br>
        <input type="color" value="<?php echo $apo['cor']; ?>" name="cor"><br><br>
       <input type="submit" name="editar" value="Editar"></input>
       </center>
     </form>
</div>