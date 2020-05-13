<?php 
  $bolsista = DBread('bolsistas', "WHERE  npacce = '".$user['npacce']."' OR cpf = '".$user['cpf']."'");
  $bolsista = $bolsista[0];
  $pessoal = DBread('dados_pessoais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
  $pessoal = $pessoal[0];
  $acad    = DBread('dados_academicos', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
  $acad    = $acad[0];
  // $add   = DBread('dados_add', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
  // $add   = $add[0];
  $memorial = DBread('memoriais', "WHERE npacce = '".$bolsista['npacce']."' OR cpf = '".$bolsista['cpf']."'");
  $memorial = $memorial[0];
?>

<?php 
  

  //BACKEND
  if (isset($_POST['endereco'])) {
    $pessoal = array();
    $acad = array();
    $memorial = array();
          //DADOS PESSOAIS
    // $form['nome']         = GetPost('nome');
    // $form['dataNasc']       = GetPost('dataNasc');
    // //se não estiver vazio
    // if ($form['dataNasc'] !== '') {
    //   $dataNasc           = explode('/', $form['dataNasc']);
    //   $form['dataNasc']     = $dataNasc[2].'-'.$dataNasc[1].'-'.$dataNasc[0].' 00:00:00';
    // }
    
    // $form['sexo']         = GetPost('sexo');
    // $form['cpf']          = GetPost('cpf');
    // $form['rg']           = GetPost('rg');
    
    // $form['registroEntrada']= date('Y-m-d H:i:s');
    // $form['situacao']       = 0;
    // $form['status']         = 1;
    // $form['cadastro']       = 0;

    // if ($url[1] == 'pacce') {
    //   $form['tipo']         = 'Candidato';
    //   $form['tipoSlug']     = 'candidato';
    // }else if ($url[1] == 'prece') {
    //   $form['tipo']         = 'PRECE - Escola';
    //   $form['tipoSlug']     = 'prece-escola';
    // }else{
    //   $form['tipo']         = 'Candidato';
    //   $form['tipoSlug']     = 'candidato';
    // }
    // $form['foto']           = 'padrao.png';

    // $pessoal['cpf']         = $form['cpf'];
    $pessoal['endereco']      = GetPost('endereco');
    $pessoal['bairro']        = GetPost('bairro');
    $pessoal['cidadeEstado']    = GetPost('cidadeEstado');
    $pessoal['naturalidade']    = GetPost('naturalidade');
    $pessoal['cep']             = GetPost('cep');
    $pessoal['fone']            = GetPost('fone');
    $pessoal['trello']          = GetPost('trello');
    $pessoal['rendaPercapita']  = GetPost('rendaPercapita');

    $form['email']              = GetPost('email');
    
    // $pessoal['registro']        = date('Y-m-d H:i:s');
    // $pessoal['status']          = 1;

    //DADOS ACADÊMICOS
    // $form['curso']            = GetPost('curso');
    // $acad['cpf']              = $form['cpf'];
    $acad['turno']            = GetPost('turno');
    $acad['modalidade']       = GetPost('modalidade');
    $acad['semestreEntrada']  = GetPost('semestreEntrada');
    
    $form['campus']           = GetPost('campus');
    $form['campusSlug']       = Slug($form['campus']);
    
    $acad['centro']           = GetPost('centro');
    $acad['escolaMedio']      = GetPost('escola');
    $acad['escolaTipo']       = GetPost('tipoEscola');
    $acad['anoConc']          = GetPost('anoConclusao');
    
    // $form['matricula']        = GetPost('matricula');
    
    // $acad['registro']         = date('Y-m-d H:i:s');
    // $acad['status']           = 1;

    //deficiencia
    $defConf = GetPost('ConfirmaDefiencia');
    if ($defConf == 'Sim') {
      $add['deficiencia'] = GetPost('deficiencia'); 
    }else if ($defConf === 'Não') {
      $add['deficiencia'] = 'Não'; 
    }else{
      $add['deficiencia'] = '';
    }

    //Memorial
    // $memorial['cpf']          = $form['cpf'];
    $memorial['memorial']     = GetPost('memorial');
    // $memorial['registro']     = date('Y-m-d H:i:s');
    // $memorial['status']       = 1;

    // $valorMemorial            = GetPost('valorMemorial');
    // $check['usoDomemorial']   = GetPost('usoDomemorial');
    
    //SISTEMA
    // $form['password']         = md5(GetPost('password'));

    
      //INSERIR NO BANCO
      // $form['npacce']     = $npacce;
      // $add['npacce']      = $npacce;
      // $acad['npacce']     = $npacce;
      // $pessoal['npacce']  = $npacce;
      // $memorial['npacce'] = $npacce;

    if (DBUpDate('bolsistas', $form, "npacce = '".$user['npacce']."'")) {
        if ($acad) {
          if (DBUpDate('dados_academicos', $acad, "npacce = '".$user['npacce']."'")) {
          }
        }else{
          $acad['npacce'] = $user['npacce'];
          if (DBcreate('dados_academicos', $acad)) {
          }
        }

        if ($pessoal) {
          if (DBUpDate('dados_pessoais', $pessoal, "npacce = '".$user['npacce']."'")) {
          }
        }else{
          $pessoal['npacce'] = $user['npacce'];
          if (DBcreate('dados_pessoais', $pessoal)) {
          }
        }

        if ($memorial) {
          if (DBUpDate('memoriais', $memorial, "npacce = '".$user['npacce']."'")) {
          }
        }else{
          $memorial['npacce'] = $user['npacce'];
          if (DBcreate('memoriais', $memorial)) {
          }
        }
        alertaLoad("Dados alterados com sucesso", $way.'editar-conta');
    }

  }
?>

<hr>
<form method="post" name="pacce-novatos" id="pacce-novatos">
  <div class="form-divider text-center">
    Editar Conta
  </div>
  <hr>
  <div class="form-divider">
    Dados Pessoais
  </div>
  <div class="row">
    <div class="form-group col-12">
      <label for="nome" class="black">Nome Completo</label>
      <label> </label>
      <input id="nome" type="text" disabled="" value="<?php echo $bolsista['nome']; ?>" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="nope" class="form-control field-required" name="nome" autofocus="">
    </div>

    <div class="form-group col-6">
        <label for="npacce" class="black">Número PACCE</label>
        <label></label>
        <input id="npacce" type="text" disabled="" value="<?php echo $bolsista['npacce']; ?>" class="form-control" name="npacce" autocomplete="nope">
      </div>
      <div class="form-group col-6">
        <label for="funcao" class="black">Função</label>
        <label></label>
        <input id="funcao" type="text" disabled="" value="<?php echo $bolsista['tipo']; ?>" class="form-control" name="tipo" autocomplete="nope">
      </div>
     <div class="form-group col-6">
        <label for="cpf" class="black">CPF</label>
        <label></label>
        <input id="cpf" disabled="" value="<?php echo $bolsista['cpf']; ?>" type="text" class="form-control field-required" name="cpf" autocomplete="nope">
      </div>
      <div class="form-group col-6">
        <label for="rg" class="black">RG</label>
        <label> - Sem hífen</label>
        <input id="rg" disabled="" value="<?php echo $bolsista['rg']; ?>" type="text" class="form-control field-required" name="rg" autocomplete="nope">
      </div>
  </div>
  

  <div class="row">
    <div class="form-group col-6">
      <label for="dataNasc" class="black">Data de Nascimento</label>
      <label></label>
      <input id="dataNasc" type="text" disabled="" value="<?php echo date('d/m/Y', strtotime($bolsista['dataNasc'])); ?>" class="form-control field-required" name="dataNasc" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label for="sexo" class="black">Sexo</label>
      <label></label>
      <select class="form-control field-required" name="sexo" disabled="">
        <option value="">Escolha uma opção...</option>
        <option <?php echo (($bolsista['sexo'] == '1') ? 'selected' : '' ) ?> value="1">Masculino</option>
        <option <?php echo (($bolsista['sexo'] == '0') ? 'selected' : '' ) ?> value="0">Feminimo</option>
      </select>
    </div>

    

    <div class="form-group col-12">
      <label for="endereco" class="black">Endereço</label>
      <label> - Ex: Rua Alameda dos Anjos, 6666, apto 6, bloco 6Z.</label>
      <input value="<?php echo $pessoal['endereco']; ?>" id="endereco" type="text" class="form-control field-required" name="endereco" autocomplete="nope">
    </div>

    <div class="form-group col-6">
      <label for="bairro" class="black">Bairro</label>
      <label></label>
      <input id="bairro" value="<?php echo $pessoal['bairro']; ?>" type="text" onkeyup="maiuscula(this)" class="form-control field-required" name="bairro" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label for="cidadeEstado" class="black">Cidade/Estado</label>
      <label> - Ex: Fortaleza/CE</label>
      <input value="<?php echo $pessoal['cidadeEstado']; ?>" id="cidadeEstado" type="text" onkeyup="maiuscula(this)" class="form-control field-required" name="cidadeEstado" autocomplete="nope">
    </div>

    <div class="form-group col-6">
      <label for="cep" class="black">CEP</label>
      <label></label>
      <input id="cep" type="text" value="<?php echo $pessoal['cep']; ?>" class="form-control field-required" name="cep" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label for="naturalidade" class="black">Naturalidade</label>
      <label> - Ex: Russas/CE</label>
      <input id="naturalidade" value="<?php echo $pessoal['naturalidade']; ?>" type="text" class="form-control field-required" name="naturalidade" autocomplete="nope">
    </div>

    <div class="form-group col-6">
      <label for="fone" class="black">Contato </label>
      <label> - Ex: (00)00000-0000</label>
      <input id="fone" value="<?php echo $pessoal['fone']; ?>" type="text" class="form-control field-required" name="fone" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label for="email" class="black">Email </label>
      <input id="email" value="<?php echo $bolsista['email']; ?>" type="email" class="form-control field-required" name="email" autocomplete="nope">
    </div>
    <div class="form-group col-12">
      <label for="rendaPercapita" class="black">Renda per capita </label>
      <label>Coloque aqui sua renda per capita. Para calcular, divida o total da renda bruta dos membros de sua núcleo familiar (veja no anexo III dos Editais) pela quantidade de membros. P.ex. Se a renda da família é de (R$2.000,00 e são 4 pessoas na família, a renda per capta é R$2.000,00/4 = R$ 500,00). Os bolsistas que forem efetivados deverão confirmar cada uma das rendas conforme anexo III dos Editais.</label>
      <input id="rendaPercapita" value="<?php echo $pessoal['rendaPercapita']; ?>" type="text" class="form-control field-required" name="rendaPercapita" autocomplete="nope">
    </div>
    <div class="form-group col-12">
      <label for="trello" class="black">Trello </label>
      <label> 
          O PACCE usa um sistema para gerenciar ações chamado Trello. É um sistema free que nos ajuda a acompanhar nossas atividades permitindo criar times, quadros, listas, anexar documentos, fotos e muito mais. Pedimos que você entre no <a href="https://www.trello.com" target="blank">www.trello.com</a> e faça seu cadastro, lembrando que é grátis. Depois, no campo abaixo coloque o e-mail que você cadastrou. Isso nos ajudará a economizar a impressão de muitas folhas no processo de formação/seleção que você está se inscrevendo. Se você já é cadastro no trello, apenas coloque seu e-mail de cadastro. Não é necessário fazer outro.
      </label>
      <input id="trello"  type="email" value="<?php echo $pessoal['trello']; ?>" class="form-control field-required" name="trello" autocomplete="nope">
    </div>

   </div>

  <div class="form-divider">
    Dados Acadêmicos
  </div>
  <div class="row">
    <div class="form-group col-6">
      <label class="black">Curso - UFC</label>
      <select class="form-control field-required" name="curso" disabled="">
        <option value="">Escolha seu curso ...</option>
        <?php 
        $cursos = DBread('cursos_ufc', "ORDER BY curso ASC");
        
        if ($cursos==true) {
          for ($i=0; $i < count($cursos); $i++) { 
            echo '<option '.(($bolsista['curso'] == $cursos[$i]['curso']) ? 'selected=""' : '').' value="'.$cursos[$i]['curso'].'">'.$cursos[$i]['curso'].'</option>';
          }
        }
        ?>
      </select>
    </div>

    <div class="form-group col-6">
      <label class="black">Modalidade</label>
      <select class="form-control field-required" name="modalidade">
        <option value="">Escolha a modalidade do seu curso...</option>
        <option <?php echo (($acad['modalidade'] == 'Bacharelado') ? 'selected=""' : '') ?> value="Bacharelado">Bacharelado</option>
        <option <?php echo (($acad['modalidade'] == 'Licenciatura') ? 'selected=""' : '') ?> value="Licenciatura">Licenciatura</option>
      </select>
    </div>

    <div class="form-group col-6">
      <label class="black">Turno</label>
      <select class="form-control field-required" name="turno">
        <option value="">Selecione o turno do seu curso ...</option>
        <option <?php echo (($acad['turno'] == 'Manhã') ? 'selected=""' : '') ?> value="Manhã">Manhã</option>
        <option <?php echo (($acad['turno'] == 'Tarde') ? 'selected=""' : '') ?> value="Tarde">Tarde</option>
        <option <?php echo (($acad['turno'] == 'Noite') ? 'selected=""' : '') ?> value="Noite">Noite</option>
        <option <?php echo (($acad['turno'] == 'Manhã - Tarde') ? 'selected=""' : '') ?> value="Manhã - Tarde">Manhã - Tarde</option>
        <option <?php echo (($acad['turno'] == 'Tarde - Noite') ? 'selected=""' : '') ?> value="Tarde - Noite">Tarde - Noite</option>
        <option <?php echo (($acad['turno'] == 'Integral') ? 'selected=""' : '') ?> value="Integral">Integral</option>
      </select>
    </div>

    
    <div class="form-group col-6">
      <label class="black">Campus</label>
      <select class="form-control field-required" name="campus">
        <option value="">Escolha seu campus...</option>
        <option <?php echo (($bolsista['campus'] == 'Benfica') ? 'selected=""' : '') ?> value="Benfica">Benfica</option>
        <option <?php echo (($bolsista['campus'] == 'Crateús') ? 'selected=""' : '') ?> value="Crateús">Crateús</option>
        <option <?php echo (($bolsista['campus'] == 'LABOMAR') ? 'selected=""' : '') ?> value="LABOMAR">LABOMAR</option>
        <option <?php echo (($bolsista['campus'] == 'PICI') ? 'selected=""' : '') ?> value="PICI">PICI</option>
        <option <?php echo (($bolsista['campus'] == 'Porangabuçu') ? 'selected=""' : '') ?> value="Porangabuçu">Porangabuçu</option>
        <option <?php echo (($bolsista['campus'] == 'Quixadá') ? 'selected=""' : '') ?> value="Quixadá">Quixadá</option>
        <option <?php echo (($bolsista['campus'] == 'Russas') ? 'selected=""' : '') ?> value="Russas">Russas</option>
        <option <?php echo (($bolsista['campus'] == 'Sobral') ? 'selected=""' : '') ?> value="Sobral">Sobral</option>
      </select>
    </div>

    <div class="form-group col-6">
      <label class="black">Unidade Académica</label>
      <select class="form-control field-required" name="centro" id="centro">
        <option value="">Escolha seu centro...</option>
        
        <option <?php echo printSelect($acad['centro'], 'Centro de Ciências'); ?> value="Centro de Ciências">Centro de Ciências</option>
        <option <?php echo printSelect($acad['centro'], 'Centro de Ciências Agrárias'); ?> value="Centro de Ciências Agrárias">Centro de Ciências Agrárias</option>
        <option <?php echo printSelect($acad['centro'], 'Centro de Humanidades'); ?> value="Centro de Humanidades">Centro de Humanidades</option>
        <option <?php echo printSelect($acad['centro'], 'Centro de Tecnologia'); ?> value="Centro de Tecnologia">Centro de Tecnologia</option>
        <option <?php echo printSelect($acad['centro'], 'Faculdade de Direito'); ?> value="Faculdade de Direito">Faculdade de Direito</option>
        <option <?php echo printSelect($acad['centro'], 'Faculdade de Economia, Administração, Atuária, Contabilidade'); ?> value="Faculdade de Economia, Administração, Atuária, Contabilidade">Faculdade de Economia, Administração, Atuária, Contabilidade</option>
        <option <?php echo printSelect($acad['centro'], 'Faculdade de Educação'); ?> value="Faculdade de Educação">Faculdade de Educação</option>
        <option <?php echo printSelect($acad['centro'], 'Faculdade de Farmácia, Odontologia e Enfermagem'); ?> value="Faculdade de Farmácia, Odontologia e Enfermagem">Faculdade de Farmácia, Odontologia e Enfermagem</option>
        <option <?php echo printSelect($acad['centro'], 'Faculdade de Medicina'); ?> value="Faculdade de Medicina">Faculdade de Medicina</option>
        <option <?php echo printSelect($acad['centro'], 'Instituto de Ciências do Mar'); ?> value="Instituto de Ciências do Mar">Instituto de Ciências do Mar</option>
        <option <?php echo printSelect($acad['centro'], 'Instituto de Cultura e Arte'); ?> value="Instituto de Cultura e Arte">Instituto de Cultura e Arte</option>
        <option <?php echo printSelect($acad['centro'], 'Instituto de Educação Física e Esportes'); ?> value="Instituto de Educação Física e Esportes">Instituto de Educação Física e Esportes</option>
        <option <?php echo printSelect($acad['centro'], 'Instituto Universidade Virtual'); ?> value="Instituto Universidade Virtual">Instituto Universidade Virtual</option>
        <option <?php echo printSelect($acad['centro'], 'Campus da UFC em Crateús'); ?> value="Campus da UFC em Crateús">Campus da UFC em Crateús</option>
        <option <?php echo printSelect($acad['centro'], 'Campus da UFC em Quixadá'); ?> value="Campus da UFC em Quixadá">Campus da UFC em Quixadá</option>
        <option <?php echo printSelect($acad['centro'], 'Campus da UFC em Russas'); ?> value="Campus da UFC em Russas">Campus da UFC em Russas</option>
        <option <?php echo printSelect($acad['centro'], 'Campus da UFC em Sobral'); ?> value="Campus da UFC em Sobral">Campus da UFC em Sobral</option>
        <option <?php echo printSelect($acad['centro'], 'Outro'); ?> value="Outro">Outro</option>
      </select>
    </div>

    <div class="form-group col-6">
      <label class="black">Semestre de Ingresso</label>
      <select class="form-control field-required" name="semestreEntrada">
        <option value="">Selecione o seu semestre de entrada ...</option>
        <?php
          $range = 8; 
          for ($i=0; $i < $range; $i++) { 
            $ano = date('Y') - $range;
            echo '<option '.(($acad['semestreEntrada'] == ($ano+$i+1).'.1') ? 'selected=""' : '').' value="'.($ano+$i+1).'.1">'.($ano+$i+1).'.1</option>';
            echo '<option '.(($acad['semestreEntrada'] == ($ano+$i+1).'.2') ? 'selected=""' : '').' value="'.($ano+$i+1).'.2">'.($ano+$i+1).'.2</option>';
          }
        ?>
      </select>
    </div>
    
    <div class="form-group col-12">
      <label for="matricula" class="black">Matrícula </label>
      <label></label>
      <input id="matricula" disabled="" value="<?php echo $bolsista['matricula']; ?>" type="text" class="form-control field-required" name="matricula" autocomplete="nope">
    </div>

    <div class="form-group col-12">
      <label class="black">Escola </label>
      <label> - Nome da escola onde concluiu o Ensino Médio</label>
      <input value="<?php echo $acad['escolaMedio']; ?>" id="escola" type="text" class="form-control field-required" name="escola" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label class="black">Tipo da Escola</label>
      <label></label>
      <select class="form-control field-required" name="tipoEscola">
        <option value="">Escolha o tipo da sua escola...</option>
        <option <?php echo printSelect($acad['escolaTipo'], 'Pública'); ?> value="Pública">Pública</option>
        <option <?php echo printSelect($acad['escolaTipo'], 'Particular'); ?> value="Particular">Particular</option>
      </select>
    </div>
    <div class="form-group col-6">
      <label class="black">Ano de Conclusão</label>
      <label> - Conclusão do seu Ensino Médio</label>
      <input value="<?php echo $acad['anoConc']; ?>" id="anoConclusao" type="text" class="form-control field-required" name="anoConclusao" autocomplete="nope">
    </div>
  </div>


  <div class="form-divider">
    Memorial
  </div> 
  <div class="row">
    <div class="form-group col-12">
      <label for="memorial" class="black">Seu Memorial </label>
      <label>Escreva no espaço abaixo o seu memorial, um relato de no mínimo duas 
      páginas, relatando as suas memórias de vida (marcos de sua história) que você considera mais 
      importantes, incluindo também as suas experiências de trabalho ou estudo em grupo em qualquer 
      época de sua vida. Sugestão: Cite, pelo menos duas pessoas, além de seus pais, pelas quais você 
      sente muita gratidão por situações específicas que aconteceram com você; uma situação ou 
      experiência marcante (que possa vir a ser publicado em nosso site) e como foi sua trajetória 
      na escolha de seu curso atual. Quantidade mínima de caracteres para esta questão: 5000 e
       no máximo: 8000 caracteres. Recomendamos que guarde uma cópia com você.</label>
      <textarea name="memorial" class="form-control field-required" placeholder="Digite ou cole seu memorial aqui" style="height: 250px;"><?php echo $memorial['memorial']; ?></textarea>
      <div class="wrap-memorial-conta" style="color: red;">
        <span class="memorial-contador">0</span>/ 5000 caracteres
      </div>
    </div>
  </div>

  <div class="form-divider">
    Sistema
  </div>
  <div class="row">
    <div class="form-group col-6">
      <label class="black">Necessidade/Deficiência</label>
      <label>Vocêpossui alguma necessidade/deficiência especial? Qual/is? </label>
      <div class="">
        <input type="radio" class="field-required" name="ConfirmaDefiencia" value="Sim">
        <label class="" >Sim</label>
      </div>
      <div class="">
        <input type="radio" class="field-required" checked="" name="ConfirmaDefiencia" value="Não">
        <label class="" >Não</label>
      </div>
      <input id="deficiencia" type="text" class="form-control field-required" style="display: none;" placeholder="Qual(is)?" name="deficiencia" autocomplete="nope">
    </div>
  </div>

  <div class="form-group">
    <button type="submit" name="enviar" class="btn btn-primary btn-block">Enviar</button>
  </div>
</form>