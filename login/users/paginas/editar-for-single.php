
<?php 

  if (isset($_POST['editar'])) {
		//$form['sala'] 			= GetPost('sala');
      if ($user['tipoSlug'] == 'ceo') {
        $form['npacce1'] = GetPost('npacce1');
        $form['npacce2'] = GetPost('npacce2');
        $form['npacce3'] = GetPost('npacce3');
        $form['semanaInicio']= GetPost('semanaInicio');
        $form['semanaFim']  = GetPost('semanaFim');
        $form['regiao']       = GetPost('regiao');
        $form['regiaoSlug']   = Slug(GetPost('regiao'));

        $npacce1 = DBread('bolsistas', "WHERE npacce = '".$form['npacce1']."'", "id, nome, npacce, nomeUsual");
        $npacce2 = DBread('bolsistas', "WHERE npacce = '".$form['npacce2']."'", "id, nome, npacce, nomeUsual");
        $npacce3 = DBread('bolsistas', "WHERE npacce = '".$form['npacce3']."'", "id, nome, npacce, nomeUsual");
        
        if ($form['npacce1'] == false) {
           echo '<script> alert("Bolsista não encontrado!"); </script>';
        }else if (!empty($form['npacce2']) && $npacce2 == false) {
          echo '<script>alert("Esse bolsista não existe!"); </script>';
        }else if (!empty($form['npacce3']) && $npacce3 == false) {
          echo '<script>alert("Esse bolsista não existe!"); </script>';
        }else{
            $form['bol1']         = GetName($npacce1[0]['nome'], $npacce1[0]['nomeUsual']);
            $form['nomeComp1']    = $npacce1[0]['nome'];
            if (!empty($form['npacce2'])) {
              $form['bol2']       = GetName($npacce2[0]['nome'], $npacce2[0]['nomeUsual']);
              $form['nomeComp2']    = $npacce2[0]['nome'];
            }
            if (!empty($form['npacce3'])) {
              $form['bol3']       = GetName($npacce3[0]['nome'], $npacce3[0]['nomeUsual']);
              $form['nomeComp3']    = $npacce3[0]['nome'];
            }
         }
         if ($form['semanaInicio'] != $for['semanaInicio'] || $form['semanaFim'] != $for['semanaFim']) {
            if (DBDelete('for_cod', "sala = '".$for['sala']."' ")) {
              $ano                = date('y');
              $sala               = explode("-", $for['sala']);
              $sala               = $sala[1];
              $codigo['codigo']   = '';
              $codigo['sala']     = $for['sala'];
              $codigo['status']   = 1;
              $codigo['registro'] = date('Y-m-d H:i:s');
              for ($i=$form['semanaInicio']+1; $i <= $form['semanaFim']; $i++) { 
                if ($i < 10) {
                  $codigo['codigo'] = 'FOR'.$ano.'0'.$i.$sala;
                }else{
                  $codigo['codigo'] = 'FOR'.$ano.$i.$sala;
                }
                DBcreate('for_cod', $codigo);
              }
            }
            
          } 
      }else{
        $form['regiao']      = $for['regiao'];
        $form['semanaInicio']= $for['semanaInicio'];
        $form['semanaFim']  = $for['semanaFim'];
        $form['npacce1']    = $for['npacce1'];
        $form['npacce2']    = $for['npacce2'];
        $form['npacce3']    = $for['npacce3'];
         $form['regiao']     = $for['regiao'];
        $form['regiaoSlug'] = $for['regiao'];
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


  		$form['vagaInicial'] 	= GetPost('vagaInicial');
      $form['vagaAtual']    = $for['vagaAtual'];
		
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
        if ($form['vagaInicial'] < $for['vagaInicial']) {
            $res = $for['vagaInicial'] - $form['vagaInicial'];
            $form['vagaAtual'] = $form['vagaAtual'] - $res;
        }else if($form['vagaInicial'] > $for['vagaInicial']){
          $res = $form['vagaInicial'] - $for['vagaInicial'];
          $form['vagaAtual'] = $form['vagaAtual'] + $res;
        }
			 if (DBUpDate('for_salas', $form,"sala = '".$for['sala']."' ")) {
				echo '
                 <script>
                  alert("Edição realizada com sucesso!!.");
                    window.location="'.$way.'/'.$url[1].'/'.$for['sala'].'";
                  </script>';
			 }
		}
	}
?>
<div class="title"><h2>Editar Informações da Sala <?php echo $for['sala']; ?></h2></div>
<div id="editar-ativ" class="form">
	 <form action="" method="post" enctype="multipart/form-data">
    <label>Sala:</label><br>
    <span><strong><?php echo $for['sala']; ?></strong></span><br><br>
    <label class="label">Local:</label><span style="color:red;"> * </span><br>
    <input type="text" name="local" onkeyup="maiuscula(this)" value="<?php echo $for['local']; ?>" placeholder="Digite o local dessa sala"></input><br><br>
    <label class="label">Data do Início:</label><span style="color:red;"> * </span><br>
    <input type="date" name="dataInicio"  value="<?php echo date('Y-m-d', strtotime($for['dataInicio'])); ?>" placeholder="Digite a data de Inicio dessa sala"></input><br><br>
    <label class="label">Data do Fim:</label><span style="color:red;"> * </span><br>
    <input type="date" name="dataFim"  value="<?php echo date('Y-m-d', strtotime($for['dataFim'])); ?>" placeholder="Digite a data do fim dessa sala"></input><br><br>
    <label class="label">Horário do Início:</label><span style="color:red;"> * </span><br>
    <input type="time" name="inicio"  value="<?php echo date('H:i:s', strtotime($for['inicio'])); ?>" placeholder="Digite horário do início dessa sala"></input><br><br>
    <label class="label">Horário do Fim:</label><span style="color:red;"> * </span><br>
    <input type="time" name="fim"  value="<?php echo date('H:i:s', strtotime($for['fim'])); ?>" placeholder="Digite horário do início dessa sala"></input><br><br>
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
          <option <?php if($for['regiaoSlug'] == 'fortaleza'){ echo 'selected=""';} ?> value="Fortaleza" title="Benfica, PICI, Porangabuçu e LABOMAR">Fortaleza</option>
          <option <?php if($for['regiaoSlug'] == 'crateus'){ echo 'selected=""';} ?> value="Crateús">Crateús</option>
          <option <?php if($for['regiaoSlug'] == 'quixada'){ echo 'selected=""';} ?> value="Quixadá">Quixadá</option>
          <option <?php if($for['regiaoSlug'] == 'russas'){ echo 'selected=""';} ?> value="Russas">Russas</option>
          <option <?php if($for['regiaoSlug'] == 'sobral'){ echo 'selected=""';} ?> value="Sobral">Sobral</option>
        </select>    
        <br><br>
        <label class="label">Semana de Inscrição:</label><span style="color:red;"> * </span><br>
       
          <select name="semanaInicio">
            <option value="-1">Escolha a Semana que essa sala ficará aberta para inscrição...</option>
            <?php 
            $weeks = DBread('calendario_2016', "ORDER BY semana ASC");
          
            for ($i=0; $i < count($weeks); $i++) {
               $check = '';
              if ($for['semanaInicio'] == $weeks[$i]['semana']) {
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
              if ($for['semanaFim'] == $weeks[$i]['semana']) {
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
        
     <label> Número PACCE do(a) Facilitador(a) Nº1:</label><br>
       <?php 
        if ($user['tipoSlug'] == 'ceo') {
          ?>
        
        <input type="text" name="npacce1" onkeyup="maiuscula(this)" value="<?php echo $for['npacce1']; ?>" placeholder="Digite um número PACCE"></input><br><br>
      
          <?php
        }else{
          ?>
           <span><strong><?php echo $for['npacce1']; ?></strong></span><br><br>
          <?php
        }
       ?>
   		
   		 <label>Nome usual do(a) Facilitador(a) Nº1:</label><br>
   		 <span><strong><?php echo $for['bol1']; ?></strong></span><br><br>
   		 <br>
      <label> Número PACCE do(a) Facilitador(a) Nº2:</label><br>
   		 <?php 
        if ($user['tipoSlug'] == 'ceo') {
          ?>
        <input type="text" name="npacce2" onkeyup="maiuscula(this)" value="<?php echo $for['npacce2']; ?>" placeholder="Digite um número PACCE"></input><br><br>
      
          <?php
        }else{
          ?>
           <span><strong><?php echo $for['npacce2']; ?></strong></span><br><br>
          <?php
        }
       ?>
   		<label> Nome usual do(a) Facilitador(a) Nº2:</label><br>
   		 <span><strong><?php echo $for['bol2']; ?></strong></span><br><br>
       <br>
       <label> Número PACCE do(a) Facilitador(a) Nº3:</label><br>
       <?php 
        if ($user['tipoSlug'] == 'ceo') {
          ?>
        
        <input type="text" name="npacce3" onkeyup="maiuscula(this)" value="<?php echo $for['npacce3']; ?>" placeholder="Digite um número PACCE"></input><br><br>
      
          <?php
        }else{
          ?>
           <span><strong><?php echo $for['npacce3']; ?></strong></span><br><br>
          <?php
        }
       ?>
      
       <label>Nome usual do(a) Facilitador(a) Nº3:</label><br>
       <span><strong><?php echo $for['bol3']; ?></strong></span><br><br>




   		  <label>Vagas:</label><br>
        <input type="number" max="100" name="vagaInicial" onkeyup="" value="<?php echo $for['vagaInicial']; ?>" placeholder="Digite o número de vagas dessa sala"></input><br><br>
     	<label>Vaga Atual:</label><br>
   		 <span><strong><?php echo $for['vagaAtual']; ?></strong></span><br><br>

   		<label class="label">Descrição:</label><span style="color:red;"> * </span><br>
      
   		 <textarea name="disc"><?php echo printPost($for['disc'], 'campo'); ?></textarea>
   		 
   		 <center>
       <br><label>Cor do Card:</label><br>
        <input type="color" value="<?php echo $for['cor']; ?>" name="cor"><br><br>
   		 <input type="submit" name="editar" value="Editar"></input>
   		 </center>
     </form>
</div>