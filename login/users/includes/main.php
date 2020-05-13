<!-- INÍCIO DO MAIN.PHP -->
<div class="main-content">
        <section class="section">
          <!-- MIGALHAS -->
          <h1 class="section-header">
            <div><?php if($semana >=10){echo 'Semana '.$semana; }else{ echo 'Semana 0'.$semana;}  
                $sem_data = DBread('calendario_2016', "WHERE semana = '$semana'");
                echo ' - '.date('d/m', strtotime($sem_data[0]['inicio'])).' até '.date('d/m', strtotime($sem_data[0]['fim']));
            ?></div>
          </h1>
          <style>
          ul.breadcrumb {
            padding: 10px 16px;
            list-style: none;
            background-color: #eee;
          }
          ul.breadcrumb li {
            display: inline;
            font-size: 18px;
          }
          ul.breadcrumb li+li:before {
            padding: 8px;
            color: black;
            content: "/\00a0";
          }
          ul.breadcrumb li a {
            color: #0275d8;
            text-decoration: none;
          }
          ul.breadcrumb li a:hover {
            color: #01447e;
            text-decoration: underline;
          }
          </style>
          <?php
          if ($url[1]!='' && $url[1] != "home") {
            ?>
            <ul class="breadcrumb">
              <li><a href="<?php echo $way?>">Dashboard</a></li>
              <?php 
              for($a=1; $a < count($url); $a++){
                  $link .= "/".$url[$a];
                  if($a+1 < count($url)){

                  ?> <li><a href="<?php echo $way.$link?>"><?php echo $url[$a]; ?></a></li>  

                  <?php }
                  else{ 
                    ?> 
                   <li><?php echo $url[$a]; ?></li> 
                  <?php } 
              } ?>
            </ul>
            <?php
          }/*else{
             ?> 
             <ul class="breadcrumb">
                <li>Dashboard</li> 
             </ul>
             <?php
           }*/
           
          ?>

          <!-- CARREGAMETNO DAS PÁGINAS -->
          <?php

            $paginasf   = array('editar-conta', 'alterar-senha', 'meu-perfil', 'folha', 'dados-bancarios', 'home');

            $casa     = $url[0];

            if(isset($url[1])){
              $paginas = $url[1];
            }
            //exibe msgs de sucesso ou erro do sistema
            //include 'msg-system.php';

            if(isset($_GET['s']) && $_GET['s'] != ''){
              include '../../paginas/search.php';
            }
          
            //Acesso a paginas que todos os bolsistas podem acessar
            else if(isset($paginas) && in_array($paginas, $paginasf)){
              include 'paginas/'.$paginas.'.php';
            }
            //Acesso a paginas de cada atributo do bolsista
            else if(isset($paginas)){
              $searchPage = DBread('menu', "WHERE nomeSlug ='$paginas' AND status = true");
              if($searchPage == false){
                include '404.php';
              }else{
                //Deixa a pagina acessível somente para as comissoes certas
                $cont = 0;
                for ($i=0; $i < count($searchPage); $i++) { 
                  if($searchPage[$i]['acessoSlug'] == $user['tipoSlug']){
                    $cont++;
                  }
                }
                if($cont > 0){
                  include 'paginas/'.$paginas.'.php';
                }else{
                  include '../../paginas/404.php';
                }
              }
            }
            //Acesso a Home
            else if($casa != $user['tipoSlug']){
              load(URL_PAINEL.$user['tipoSlug']);
            }else if($casa == $user['tipoSlug']){
              include 'paginas/home.php';
            }
            
            ?>
        </section>
      </div>