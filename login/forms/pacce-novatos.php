<?php 
  

  //BACKEND
  if (isset($_POST['nome'])) {
          //DADOS PESSOAIS
    $form['nome']         = GetPost('nome');
    $form['dataNasc']       = GetPost('dataNasc');
    //se não estiver vazio
    if ($form['dataNasc'] !== '') {
      $dataNasc           = explode('/', $form['dataNasc']);
      $form['dataNasc']     = $dataNasc[2].'-'.$dataNasc[1].'-'.$dataNasc[0].' 00:00:00';
    }
    
    $form['sexo']         = GetPost('sexo');
    $form['cpf']          = GetPost('cpf');
    $form['rg']           = GetPost('rg');
    
    $form['registroEntrada']= date('Y-m-d H:i:s');
    $form['situacao']       = 0;
    $form['status']         = 1;
    $form['cadastro']       = 0;

    if ($url[1] == 'pacce') {
      $form['tipo']         = 'Candidato';
      $form['tipoSlug']     = 'candidato';
    }else if ($url[1] == 'prece') {
      $form['tipo']         = 'PRECE - Escola';
      $form['tipoSlug']     = 'prece-escola';
    }else{
      $form['tipo']         = 'Candidato';
      $form['tipoSlug']     = 'candidato';
    }
    $form['foto']           = 'padrao.png';

    $pessoal['cpf']         = $form['cpf'];
    $pessoal['endereco']      = GetPost('endereco');
    $pessoal['bairro']        = GetPost('bairro');
    $pessoal['cidadeEstado']    = GetPost('cidadeEstado');
    $pessoal['naturalidade']    = GetPost('naturalidade');
    $pessoal['cep']             = GetPost('cep');
    $pessoal['fone']            = GetPost('fone');
    $pessoal['trello']          = GetPost('trello');
    $pessoal['rendaPercapita']  = GetPost('rendaPercapita');

    $form['email']              = GetPost('email');
    
    $pessoal['registro']        = date('Y-m-d H:i:s');
    $pessoal['status']          = 1;

    //DADOS ACADÊMICOS
    $form['curso']            = GetPost('curso');
    $acad['cpf']              = $form['cpf'];
    $acad['turno']            = GetPost('turno');
    $acad['modalidade']       = GetPost('modalidade');
    $acad['semestreEntrada']  = GetPost('semestreEntrada');
    
    $form['campus']           = GetPost('campus');
    $form['campusSlug']       = Slug($form['campus']);
    
    $acad['centro']           = GetPost('centro');
    $acad['escolaMedio']      = GetPost('escola');
    $acad['escolaTipo']       = GetPost('tipoEscola');
    $acad['anoConc']          = GetPost('anoConclusao');
    
    $form['matricula']        = GetPost('matricula');
    
    $acad['registro']         = date('Y-m-d H:i:s');
    $acad['status']           = 1;

    //Interesses e Qualificações
    $add['cpf']               = $form['cpf'];
    $add['tempoNaUFC']        = GetPost('tempoNaUFC');
    $add['outraGraduacao']    = GetPost('outraGraduacao');
    $add['mudeiDeCurso']      = GetPost('mudeiDeCurso');
    $add['satisfeito']        = GetPost('satisfeito');
    $add['cursoLingua']       = GetPost('cursoLingua');

    //Disponibilidade de Horários
    $add['disponibilidade']   = GetPost('disponibilidade');
    $add['periodo']           = GetPost('periodo'); //CHECK
    $add['turnoSabado']       = GetPost('turnoSabado');
    $add['atExtra']           = GetPost('atExtra');
    
    //Sobre suas experiências
    $add['eventosAC']         = GetPost('eventosAC');
    $add['soubeDoPACCE']      = GetPost('soubeDoPACCE'); //CHECK
    $add['jaParticipei']      = GetPost('jaParticipei'); //CHECK
    $add['5problemas']        = GetPost('5problemas');
    
    //Sobre a sua ideia de projeto de Aprendizagem para desenvolver no Programa.
    $add['ideiasDeProjeto']   = GetPost('ideiasDeProjeto');
    $add['colegaNoProjeto']   = GetPost('colegaNoProjeto');
    
    $add['registro']          = date('Y-m-d H:i:s');
    $add['status']            = 1;

    //deficiencia
    $defConf = GetPost('ConfirmaDefiencia');
    if ($defConf == 'Sim') {
      $add['deficiencia'] = GetPost('deficiencia'); 
    }else if ($defConf === 'Não') {
      $add['deficiencia'] = 'Não'; 
    }else{
      $add['deficiencia'] = '';
    }

    //turnoSabado
    $turnoSab = GetPost('turnoSabado');
    if ($turnoSab == 'Sim') {
      $add['turnoSabado'] = 'Sim'; 
    }else if ($turnoSab === 'Não') {
      $add['turnoSabado'] = GetPost('motivo_sabado'); 
    }else{
      $add['turnoSabado'] = '';
    }

    //Memorial
    $memorial['cpf']          = $form['cpf'];
    $memorial['memorial']     = GetPost('memorial');
    $memorial['registro']     = date('Y-m-d H:i:s');
    $memorial['status']       = 1;

    $valorMemorial            = GetPost('valorMemorial');
    $check['usoDomemorial']   = GetPost('usoDomemorial');
    
    //SISTEMA
    $form['password']         = md5(GetPost('password'));

    //==========//CHECK ========================================================================================
      $jaParticipei         = '';
      for ($i=0; $i < count($add['jaParticipei']); $i++) { 
        if ($jaParticipei == '') {
          $jaParticipei = $jaParticipei.$add['jaParticipei'][$i];
        }else{
          $jaParticipei = $jaParticipei.';  '.$add['jaParticipei'][$i];
        }
        if ($i+1 == count($add['jaParticipei'])) {
          $jaParticipei = $jaParticipei.';';
        }
      }
      $add['jaParticipei'] = $jaParticipei;

      
//==========//CHECK =========================================================================================
      $soubeDoPACCE = '';
      for ($i=0; $i < count($add['soubeDoPACCE']); $i++) { 
        if ($soubeDoPACCE == '') {
          $soubeDoPACCE = $soubeDoPACCE.$add['soubeDoPACCE'][$i];
        }else{
          $soubeDoPACCE = $soubeDoPACCE.';  '.$add['soubeDoPACCE'][$i];
        }
        if ($i+1 == count($add['soubeDoPACCE'])) {
          $soubeDoPACCE = $soubeDoPACCE.';';
        }
      }
      $add['soubeDoPACCE'] = $soubeDoPACCE;

//==========CHECK==============================================================================================
      $periodo = '';
      for ($i=0; $i < count($add['periodo']); $i++) { 
        if ($periodo == '') {
          $periodo = $periodo.$add['periodo'][$i];
        }else{
          $periodo = $periodo.';  '.$add['periodo'][$i];
        }
        if ($i+1 == count($add['periodo'])) {
          $periodo = $periodo.';';
        }
      }
      $add['periodo'] = $periodo;

      //GERARDOR DE NPACCE
      $bolsistas    = DBread('bolsistas', "WHERE tipoSlug != 'ceo' ORDER BY npacce DESC LIMIT 1", "npacce");
      if (substr($bolsistas[0]['npacce'], 0, 3) == 'B'.date('y')) {
        $npacce     = str_replace("B", "", $bolsistas[0]['npacce']);
        $npacce     = $npacce + 1;
        $npacce     = 'B'.$npacce;
      }else{
        $npacce = 'B'.date('y').'0001';
      }
      //INSERIR NO BANCO
      $form['npacce']     = $npacce;
      $add['npacce']      = $npacce;
      $acad['npacce']     = $npacce;
      $pessoal['npacce']  = $npacce;
      $memorial['npacce'] = $npacce;

      if (DBcreate('bolsistas', $form)) {
        if (DBcreate('dados_academicos', $acad)) {
          if(DBcreate('dados_pessoais', $pessoal)){
            if (DBcreate('dados_add', $add)) {
              if (DBcreate('memoriais', $memorial)) {
                  alertaLoad('!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Parabéns !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! \n Sua inscrição foi efetuada com sucesso!!! \n Fique atento(a) as datas citadas no edital. \n\n ======= Seu número de identificação é '.$npacce.' ======= \n Após a análise dos dados você receberá um email de \nconfirmação em no máximo 3 dias úteis.  \n\n !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Tire print desta tela !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! \n\n Att PACCE. \n Developed by Luis Rodrigues.', URLBASE.'login');
              }
            }
          }
        }
      }else{
        alertaLoad('Ocorreu um erro, tente novamente. \n\n Att PACCE. \n Developed by Luis Rodrigues.', URLBASE.'/login');
      }
  }
?>
<hr>
<form method="post" name="pacce-novatos" id="pacce-novatos">
  <div class="form-divider text-center">
    Inscrição PACCE - NOVATO
  </div>
  <hr>
  <div class="form-divider">
    Dados Pessoais
  </div>
  <div class="row">
    <div class="form-group col-12">
      <label for="nome" class="black">Nome Completo</label>
      <label> </label>
      <input id="nome" type="text" onkeyup="maiuscula(this)" onkeypress="maiuscula(this)" autocomplete="nope" class="form-control field-required" name="nome" >
    </div>

  </div>

  <div class="row">
    <div class="form-group col-6">
      <label for="dataNasc" class="black">Data de Nascimento</label>
      <label></label>
      <input id="dataNasc" type="text" class="form-control field-required" name="dataNasc" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label for="sexo" class="black">Sexo</label>
      <label></label>
      <select class="form-control field-required" name="sexo">
        <option value="">Escolha uma opção...</option>
        <option value="1">Masculino</option>
        <option value="0">Feminimo</option>
      </select>
    </div>

    <div class="form-group col-6">
      <label for="cpf" class="black">CPF</label>
      <label></label>
      <input id="cpf" type="text" class="form-control field-required" name="cpf" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label for="rg" class="black">RG</label>
      <label> - Sem hífen</label>
      <input id="rg" type="text" class="form-control field-required" name="rg" autocomplete="nope">
    </div>

    <div class="form-group col-12">
      <label for="endereco" class="black">Endereço</label>
      <label> - Ex: Rua Alameda dos Anjos, 6666, apto 6, bloco 6Z.</label>
      <input id="endereco" type="text" class="form-control field-required" name="endereco" autocomplete="nope">
    </div>

    <div class="form-group col-6">
      <label for="bairro" class="black">Bairro</label>
      <label></label>
      <input id="bairro" type="text" onkeyup="maiuscula(this)" class="form-control field-required" name="bairro" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label for="cidadeEstado" class="black">Cidade/Estado</label>
      <label> - Ex: Fortaleza/CE</label>
      <input id="cidadeEstado" type="text" onkeyup="maiuscula(this)" class="form-control field-required" name="cidadeEstado" autocomplete="nope">
    </div>

    <div class="form-group col-6">
      <label for="cep" class="black">CEP</label>
      <label></label>
      <input id="cep" type="text" class="form-control field-required" name="cep" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label for="naturalidade" class="black">Naturalidade</label>
      <label> - Ex: Russas/CE</label>
      <input id="naturalidade" type="text" class="form-control field-required" name="naturalidade" autocomplete="nope">
    </div>

    <div class="form-group col-6">
      <label for="fone" class="black">Contato </label>
      <label> - Ex: (00)00000-0000</label>
      <input id="fone" type="text" class="form-control field-required" name="fone" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label for="email" class="black">Email </label>
      <input id="email" type="email" class="form-control field-required" name="email" autocomplete="nope">
    </div>
    <div class="form-group col-12">
      <label for="rendaPercapita" class="black">Renda per capita </label>
      <label>Coloque aqui sua renda per capita. Para calcular, divida o total da renda bruta dos membros de sua núcleo familiar (veja no anexo III dos Editais) pela quantidade de membros. P.ex. Se a renda da família é de (R$2.000,00 e são 4 pessoas na família, a renda per capta é R$2.000,00/4 = R$ 500,00). Os bolsistas que forem efetivados deverão confirmar cada uma das rendas conforme anexo III dos Editais.</label>
      <input id="rendaPercapita" type="text" class="form-control field-required" name="rendaPercapita" autocomplete="nope">
    </div>
    <div class="form-group col-12">
      <label for="fone" class="black">Trello </label>
      <label> 
          O PACCE usa um sistema para gerenciar ações chamado Trello. É um sistema free que nos ajuda a acompanhar nossas atividades permitindo criar times, quadros, listas, anexar documentos, fotos e muito mais. Pedimos que você entre no <a href="https://www.trello.com" target="blank">www.trello.com</a> e faça seu cadastro, lembrando que é grátis. Depois, no campo abaixo coloque o e-mail que você cadastrou. Isso nos ajudará a economizar a impressão de muitas folhas no processo de formação/seleção que você está se inscrevendo. Se você já é cadastro no trello, apenas coloque seu e-mail de cadastro. Não é necessário fazer outro.
      </label>
      <input id="trello" type="email" class="form-control field-required" name="trello" autocomplete="nope">
    </div>

   </div>

  <div class="form-divider">
    Dados Acadêmicos
  </div>
  <div class="row">
    <div class="form-group col-6">
      <label class="black">Curso - UFC</label>
      <select class="form-control field-required" name="curso">
        <option value="">Escolha seu curso ...</option>
        <?php 
        $cursos = DBread('cursos_ufc', "ORDER BY curso ASC");
        
        if ($cursos==true) {
          for ($i=0; $i < count($cursos); $i++) { 
            echo '<option value="'.$cursos[$i]['curso'].'">'.$cursos[$i]['curso'].'</option>';
          }
        }
        ?>
      </select>
    </div>

    <div class="form-group col-6">
      <label class="black">Modalidade</label>
      <select class="form-control field-required" name="modalidade">
        <option value="">Escolha a modalidade do seu curso...</option>
        <option value="Bacharelado">Bacharelado</option>
        <option value="Licenciatura">Licenciatura</option>
      </select>
    </div>

    <div class="form-group col-6">
      <label class="black">Turno</label>
      <select class="form-control field-required" name="turno">
        <option value="">Selecione o turno do seu curso ...</option>
        <option value="Manhã">Manhã</option>
        <option value="Tarde">Tarde</option>
        <option value="Noite">Noite</option>
        <option value="Manhã - Tarde">Manhã - Tarde</option>
        <option value="Tarde - Noite">Tarde - Noite</option>
        <option value="Integral">Integral</option>
      </select>
    </div>

    
    <div class="form-group col-6">
      <label class="black">Campus</label>
      <select class="form-control field-required" name="campus">
        <option value="">Escolha seu campus...</option>
        <option value="Benfica">Benfica</option>
        <option value="Crateús">Crateús</option>
        <option value="LABOMAR">LABOMAR</option>
        <option value="PICI">PICI</option>
        <option value="Porangabuçu">Porangabuçu</option>
        <option value="Quixadá">Quixadá</option>
        <option value="Russas">Russas</option>
        <option value="Sobral">Sobral</option>
      </select>
    </div>

    <div class="form-group col-6">
      <label class="black">Unidade Académica</label>
      <select class="form-control field-required" name="centro" id="centro">
        <option value="">Escolha seu centro...</option>
        <option value="Centro de Ciências">Centro de Ciências</option>
        <option value="Centro de Ciências Agrárias">Centro de Ciências Agrárias</option>
        <option value="Centro de Humanidades">Centro de Humanidades</option>
        <option value="Centro de Tecnologia">Centro de Tecnologia</option>
        <option value="Faculdade de Direito">Faculdade de Direito</option>
        <option value="Faculdade de Economia, Administração, Atuária, Contabilidade">Faculdade de Economia, Administração, Atuária, Contabilidade</option>
        <option value="Faculdade de Educação">Faculdade de Educação</option>
        <option value="Faculdade de Farmácia, Odontologia e Enfermagem">Faculdade de Farmácia, Odontologia e Enfermagem</option>
        <option value="Faculdade de Medicina">Faculdade de Medicina</option>
        <option value="Instituto de Ciências do Mar">Instituto de Ciências do Mar</option>
        <option value="Instituto de Cultura e Arte">Instituto de Cultura e Arte</option>
        <option value="Instituto de Educação Física e Esportes">Instituto de Educação Física e Esportes</option>
        <option value="Instituto Universidade Virtual">Instituto Universidade Virtual</option>
        <option value="Campus da UFC em Crateús">Campus da UFC em Crateús</option>
        <option value="Campus da UFC em Quixadá">Campus da UFC em Quixadá</option>
        <option value="Campus da UFC em Russas">Campus da UFC em Russas</option>
        <option value="Campus da UFC em Sobral">Campus da UFC em Sobral</option>
        <option value="UFC-Virtual">UFC-Virtual</option>
        <option value="Outro">Outro</option>
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
            echo '<option value="'.($ano+$i+1).'.1">'.($ano+$i+1).'.1</option>';
            echo '<option value="'.($ano+$i+1).'.2">'.($ano+$i+1).'.2</option>';
          }
        ?>
      </select>
    </div>
    
    <div class="form-group col-12">
      <label for="matricula" class="black">Matrícula </label>
      <label>Caso seja recém ingresso, digite 0. NESTE CASO , A COMPROVAÇÃO DE MATRÍCULA DEVERÁ SER ENVIADA PARA O E-MAIL <a href="mail:pacce.na.selecao@eideia.ufc.br">pacce.na.selecao@eideia.ufc.br</a>. </label>
      <input id="matricula" type="text" class="form-control field-required" name="matricula" autocomplete="nope">
    </div>

    <div class="form-group col-12">
      <label class="black">Escola </label>
      <label> - Nome da escola onde concluiu o Ensino Médio</label>
      <input id="escola" type="text" class="form-control field-required" name="escola" autocomplete="nope">
    </div>
    <div class="form-group col-6">
      <label class="black">Tipo da Escola</label>
      <label></label>
      <select class="form-control field-required" name="tipoEscola">
        <option value="">Escolha o tipo da sua escola...</option>
        <option value="Pública">Pública</option>
        <option value="Particular">Particular</option>
      </select>
    </div>
    <div class="form-group col-6">
      <label class="black">Ano de Conclusão</label>
      <label> - Conclusão do seu Ensino Médio</label>
      <input id="anoConclusao" type="text" class="form-control field-required" name="anoConclusao" autocomplete="nope">
    </div>
  </div>

  <div class="form-divider">
    Interesses e Qualificações
  </div>
  <div class="row">
    <div class="form-group col-6">
      <label class="black">Tempo na UFC</label>
      <label>Ao final do semestre <?php echo (date('Y')-1); ?>.2, já terei cursado 75% do meu curso.</label>
      <div class="">
        <input type="radio" class="field-required" name="tempoNaUFC" value="Sim">
        <label class="" >Sim</label>
      </div>
      <div class="">
        <input type="radio" class="field-required" name="tempoNaUFC" value="Não">
        <label class="" >Não</label>
      </div>
    </div>
    <div class="form-group col-6">
      <label class="black">Mudei de Curso</label>
      <label>Entrei na UFC para um outro curso, mas não concluí e mudei para o curso atual. </label>
      <div class="">
        <input type="radio" class="field-required" name="mudeiDeCurso" value="Sim">
        <label class="" >Sim</label>
      </div>
      <div class="">
        <input type="radio" class="field-required" name="mudeiDeCurso" value="Não">
        <label class="" >Não</label>
      </div>
    </div>

    <div class="form-group col-6">
      <label class="black">Outra Graduação</label>
      <label>Já conclui pelo menos um curso de graduação.</label>
      <div class="">
        <input type="radio" class="field-required" name="outraGraduacao" value="Sim">
        <label class="" >Sim</label>
      </div>
      <div class="">
        <input type="radio" class="field-required" name="outraGraduacao" value="Não">
        <label class="" >Não</label>
      </div>
    </div>
    <div class="form-group col-6">
      <label class="black">Satisfeito</label>
      <label>Estou satisfeito com meu curso e pretendo concluí-lo. </label>
      <div class="">
        <input type="radio" class="field-required" name="satisfeito" value="Sim">
        <label class="" >Sim</label>
      </div>
      <div class="">
        <input type="radio" class="field-required" name="satisfeito" value="Não">
        <label class="" >Não</label>
      </div>
    </div>

    <div class="form-group col-6">
      <label class="black">Curso de Línguas</label>
      <label>Faço pelo menos um curso de Línguas.</label>
      <div class="">
        <input type="radio" class="field-required" name="cursoLingua" value="Sim">
        <label class="" >Sim</label>
      </div>
      <div class="">
        <input type="radio" class="field-required" name="cursoLingua" value="Não">
        <label class="" >Não</label>
      </div>
    </div>

  </div>
  
  <div class="row">
      <div class="form-group col-12">
        <strong>DOS CRITÉRIOS GERAIS PARA INSCRIÇÃO</strong>
        <p>As informações estão disponíveis no item 6 do edital.</p>
      <ol style="" type="a">
        <li>
          Os candidatos podem se inscrever na condição de novato ou veterano conforme sua situação diante do Programa;
          <ol type="I">
            <li>Será considerado novato o candidato que não tenha participado do Programa ou não tenha completado 75% das Formações no Programa no 1º semestre.</li>
            <li>Será considerado veterano o candidato que tiver participado de quaisquer uma das edições anteriores do Programa.</li>
            <li>Veteranos com inscrições anteriores a 2016 deverão procurar a secretaria do Programa para liberação da inscrição.</li>
          </ol>
        </li>
        <li>Estar regularmente matriculado(a) em um curso de graduação presencial da UFC ou em processo de matrícula. A efetivação no Programa somente ocorrerá se a matrícula estiver confirmada. Não poderão ser efetivados os estudantes com matrícula especial ou institucional; </li>
        <li> Para efetivação e permanência no Programa, é necessário que o bolsista comprove matrícula em <?php echo (date('Y')) ?> e permanência nas disciplinas/atividades, totalizando, pelo menos, 16 créditos a cada semestre. </li>
        <li><strong>Ter 12 (doze) horas semanais disponíveis para o desenvolvimento das atividades da Bolsa em, pelo menos, um turno de quatro horas consecutivas: de 8h às 12h e/ou 14 às 18h e/ou 18h às 22h, de segunda à sexta e sábado 8h às 12h;</strong></li>
        <li>Não exercer qualquer outra atividade remunerada, inclusive estágio dentro ou fora da Universidade;</li>
        <li>Os candidatos novatos no Programa não podem ter integralizado mais de 75% dos créditos até o final do semestre letivo <?php echo (date('Y')-1) ?>.2;</li>
        <li>Os candidatos novatos não poderão concorrer às Equipes de Apoio;</li>
        <li>O tempo máximo para a concessão ininterrupta de bolsa para um mesmo estudante será de quatro (04) anos.</li>
        <li>Os candidatos que pretendem ser efetivados, devem inscrever-se no processo seletivo da Bolsa de Iniciação Acadêmica (BIA) edital 02/2020 - PRAE;</li>
      </ol>
      </div>
    </div>
    <div class="form-divider">
    Disponibilidade de Horários
  </div>
  <div class="row">
    <div class="form-group col-6">
      <label class="black">Horários Disponíveis</label>
      <label>Tenho disponibilidade de 12 horas semanais para me dedicar as atividades do Programa.</label>
      <div class="">
        <input type="radio" class="field-required" name="disponibilidade" value="Sim">
        <label class="" >Sim</label>
      </div>
      <div class="">
        <input type="radio" class="field-required" name="disponibilidade" value="Não">
        <label class="" >Não</label>
      </div>
    </div>
    <div class="form-group col-6">
      <label class="black">Períodos Consecutivos</label>
      <label>Possuo os seguintes períodos de 04 horas consecutivas semanais.</label>
      <div>
        <input type="checkbox" class="field-required" name="periodo[]" value="08h-12h" class="">
        <label class="" >08h às 12h</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="periodo[]" value="14h-18h" class="">
        <label class="" >14h às 18h</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="periodo[]" value="18h30-22h30" class="">
        <label class="" >18h30 às 22h30</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="periodo[]" value="Não tenho nenhum" class="">
        <label class="" >Não tenho nenhum. </label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="periodo[]" value="Ainda não tenho horário definido" class="">
        <label class="" >Ainda não tenho horário definido.</label>
      </div>
    </div>

    <div class="form-group col-6">
      <label class="black">Turno Sábado</label>
      <label>Tenho um turno no sábado, de 08h às 12h, disponível para participar de atividades de formação do Programa. </label>
      <div class="">
        <input type="radio" class="field-required" name="turnoSabado" value="Sim">
        <label class="" >Sim</label>
      </div>
      <div class="">
        <input type="radio" class="field-required" name="turnoSabado" value="Não">
        <label class="" >Não</label>
      </div>
      <input id="motivo_sabado" type="text" style="display: none;" placeholder="Qual(is) motivo(s)?" class="form-control field-required" name="motivo_sabado" autocomplete="nope">
      
    </div>
    <div class="form-group col-12">
      <label for="atExtra" class="black">Atividades Extra Acadêmicas </label>
      <label>Sobre suas atividades extra acadêmicas. Use o espaço abaixo para listar as atividades que não sejam disciplinas regulares tais como curso de línguas, atividades voluntárias de pesquisas, ensino e extensão, grupos religiosos etc. que você possivelmente pretende realizar em <?php echo date('Y') ?>. No máximo 500 caracteres. </label>
      <textarea name="atExtra" class="form-control" placeholder="(Campo não obrigatório)"></textarea>
    </div>
  </div>

  <div class="form-divider">
    Sobre suas experiências
  </div> 
  <div class="row">
    <div class="form-group col-12">
      <label for="eventosAC" class="black">Eventos de Aprendizagem Cooperativa </label>
      <label>Você já participou de eventos de Aprendizagem Cooperativa? Se sim, escreva-o(s) no campo abaixo. No máximo 500 caracteres. </label>
      <textarea name="eventosAC" class="form-control" placeholder="(Campo não obrigatório)"></textarea>
    </div>

    <div class="form-group col-6">
      <label class="black">Como soube da Aprendizagem Cooperativa</label>
      <label>Como você ficou sabendo do nosso Processo Seletivo <?php echo date('Y') ?>?</label>
      <div>
        <input type="checkbox" class="field-required" name="soubeDoPACCE[]" value="Amigos" class="">
        <label class="" >Amigos</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="soubeDoPACCE[]" value="Sala do PACCE" class="">
        <label class="" >Sala do PACCE</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="soubeDoPACCE[]" value="Banners" class="">
        <label class="" >Banners</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="soubeDoPACCE[]" value="Bolsista do PACCE" class="">
        <label class="" >Bolsista do PACCE</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="soubeDoPACCE[]" value="Site da PROGRAD/UFC/EIDEIA" class="">
        <label class="" >Site da PROGRAD/UFC/EIDEIA</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="soubeDoPACCE[]" value="Site do PACCE/UFC" class="">
        <label class="" >Site do PACCE/UFC</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="soubeDoPACCE[]" value="Redes Sociais do PACCE/UFC" class="">
        <label class="" >Redes Sociais do PACCE/UFC</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="soubeDoPACCE[]" value="Outros" class="">
        <label class="" >Outros</label>
      </div>
      
    </div>

    <div class="form-group col-6">
      <label class="black">Já participei</label>
      <label>Dos grupos abaixo, selecione aqueles dos quais você já participou, seja como voluntário ou não.</label>
      <div>
        <input type="checkbox" class="field-required" name="jaParticipei[]" value="Grupos de estudo com colegas" class="">
        <label class="" >Grupos de estudo com colegas</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="jaParticipei[]" value="Atividades religiosas" class="">
        <label class="" >Atividades religiosas</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="jaParticipei[]" value="Organizações Não Governamentais (ONGs)" class="">
        <label class="" >Organizações Não Governamentais (ONGs)</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="jaParticipei[]" value="Grupos de Pesquisa" class="">
        <label class="" >Grupos de Pesquisa</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="jaParticipei[]" value="Grupo de extensão universitária" class="">
        <label class="" >Grupo de extensão universitária</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="jaParticipei[]" value="Centro Acadêmico" class="">
        <label class="" >Centro Acadêmico</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="jaParticipei[]" value="Movimento Estudantil" class="">
        <label class="" >Movimento Estudantil</label>
      </div>
      <div>
        <input type="checkbox" class="field-required" name="jaParticipei[]" value="Partido Político" class="">
        <label class="" >Partido Político</label>
      </div>

    
    </div>
    <div class="form-group col-12">
      <label for="5problemas" class="black">Cinco Problemas </label>
      <label>Cite até cinco problemas que você já enfrentou quando trabalhou em grupo. Use uma linha pra cada problema. Seja sucinto. No máximo 500 caracteres.</label>
      <textarea name="5problemas" class="form-control" placeholder="(Campo não obrigatório)"></textarea>
    </div>

  </div>
  <div class="form-divider">
    Sobre a sua ideia de projeto de Aprendizagem para desenvolver no Programa.
  </div> 
  <div class="row">
    <div class="form-group col-12">
      <label for="ideiasDeProjeto" class="black">Ideias de Projeto </label>
      <label>Suas ideias sobre um projeto a ser desenvolvido na bolsa.. Se você for selecionado 
      como bolsista de Aprendizagem Cooperativa, terá que desenvolver um projeto de aprendizagem, ou seja, organizar 
      um grupo de estudo com colegas. O Projeto deverá ser ideia sua e os participantes podem ser qualquer estudante 
      da UFC, de mesmo curso ou não. No sentido de avaliarmos sua ideia, solicitamos que você escreva um pequeno texto 
      sobre o projeto que você quer desenvolver, bem como a importância deste para você, para seus 
      colegas, para a universidade e para a sociedade como um todo. Recomendamos que guarde uma cópia com você.
      Pense num problema que você acredita que poderia solucionar através de um projeto. Descreva algumas atividades e, diante de dificuldades, que estratégias usaria para tentar superar? No minímo 200 e máximo 500 caracteres.
      <textarea name="ideiasDeProjeto" class="form-control field-required" placeholder=""></textarea>
    </div>

    <div class="form-group col-12">
      <label for="colegaNoProjeto" class="black">Colegas no Projeto </label>
      <label>Agora, cite o nome completo, curso e email das pessoas com as quais você 
      está pensando em desenvolver seu projeto. Use uma linha por membro. Este campo não é necessário 
      para ingressantes na UFC em <?php echo date('Y') ?>.1. No máximo 500 caracteres.</label>
      <textarea name="colegaNoProjeto" class="form-control" placeholder="(Campo não obrigatório)"></textarea>
    </div>
  </div>
  <div class="form-divider">
    Memorial
    <p>Recomendamos que assista ao vídeo </p>
    <p><iframe style="width: 100%; height: 315px;" src="https://www.youtube.com/embed/hJde2TKvU7Q" frameborder="0" allowfullscreen></iframe></p>
  </div> 
  <div class="row">
    <div class="form-group col-12">
      <label for="memorial" class="black">Seu Memorial </label>
      <label>Escreva no espaço abaixo o seu memorial, um relato de no mínimo uma 
      página e meia, relatando as suas memórias de vida (marcos de sua história) que você considera mais 
      importantes, incluindo também as suas experiências de trabalho ou estudo em grupo em qualquer 
      época de sua vida. Sugestão: Cite, pelo menos duas pessoas, além de seus pais, pelas quais você 
      sente muita gratidão por situações específicas que aconteceram com você; uma situação ou 
      experiência marcante (que possa vir a ser publicado em nosso site) e como foi sua trajetória 
      na escolha de seu curso atual. Quantidade mínima de caracteres para esta questão: 3000 e
       no máximo: 8000 caracteres. Recomendamos que guarde uma cópia com você.</label>
      <textarea name="memorial" class="form-control field-required" placeholder="Digite ou cole seu memorial aqui" style="height: 250px;"></textarea>
      <div class="wrap-memorial-conta" style="color: red;">
        <span class="memorial-contador">0</span>/ 3000 caracteres
      </div>
    </div>
    <div class="form-group col-12">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" name="usoDomemorial" class="custom-control-input field-required" id="usoDomemorial">
        <label class="custom-control-label" for="usoDomemorial">Ao enviar este formulário, autorizo o uso de meu Memorial e do meu Projeto para fins acadêmicos, ou seja, no âmbito das ações do Programa de Aprendizagem Cooperativa.</label>
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
        <input type="radio" class="field-required" name="ConfirmaDefiencia" value="Não">
        <label class="" >Não</label>
      </div>
      <input id="deficiencia" type="text" class="form-control field-required" style="display: none;" placeholder="Qual(is)?" name="deficiencia" autocomplete="nope">
    </div>
    <div class="form-group col-12">
      <label for="password" class="black">Senha</label>
      <label>Por meio dessa senha e seu CPF você poderá acessar o sistema de gestão do PACCE, portanto <span style="color: red;">Não perca essa SENHA</span></label>
      <input id="password" type="password" class="form-control field-required" name="password" autocomplete="nope">
    </div>
    <div class="form-group col-12">
      <label for="password" class="black">Confirmar Senha</label>
      <label>Confirme novamente</label>
      <input id="rePassword" type="password" class="form-control field-required" name="rePassword" autocomplete="nope">
    </div>

  </div>

  <div class="form-divider">
    Histórico e Edital
  </div>
  <div class="row">
      <div class="form-group col-12">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="historico" class="custom-control-input field-required" id="historico">
          <label class="custom-control-label" for="historico">Estou ciente que preciso enviar meu Histórico Escolar conforme item 6.3.a do Edital após o envio deste formulário.</label>
        </div>
      </div>
      <div class="form-group col-12">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="lidoEdital" class="custom-control-input field-required" id="lidoEdital">
          <label class="custom-control-label" for="lidoEdital">Declaro ter lido e estar de acordo com o Edital de Seleção.</label>
        </div>
      </div>
      <div class="form-group col-12">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="usodeimagem" class="custom-control-input field-required" id="usodeimagem">
          <label class="custom-control-label" for="usodeimagem">Declaro que o programa pode fazer uso da minha imagem dentro de seu sistema e suas redes sociais.</label>
        </div>
      </div>
      <div class="form-group col-12">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="bia" class="custom-control-input field-required" id="bia">
          <label class="custom-control-label" for="bia">Estou ciente que preciso fazer/ter feito minha inscrição na BIA para, se aprovado no edital da BIA, ser efetivado e receber uma bolsa.</label>
        </div>
      </div>
  </div>

  <div class="form-group">
    <button type="submit" name="enviar" class="btn btn-primary btn-block">Enviar</button>
  </div>
</form>