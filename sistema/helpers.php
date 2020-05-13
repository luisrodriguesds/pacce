<?php
	function bubbleSort($array, $index)
	{
	  for($i = 0; $i < count($array); $i++)
	  {
	     for($j = 0; $j < count($array) - 1; $j++)
	     {
	       if($array[$j][$index] < $array[$j + 1][$index])
	       {
	         $aux = $array[$j];
	         $array[$j] = $array[$j + 1];
	         $array[$j + 1] = $aux;
	       }
	     }
	  }
	  return $array;
	}


	function alerta($text){
		echo '<script>alert("'.$text.'");</script>';
	}

	function alertaLoad($text, $url){
		echo '<script>alert("'.$text.'");
	        window.location="'.$url.'";</script>';
	}

	function load($url){
		echo '<script>
	        window.location="'.$url.'";</script>';
	}

	function alertaQuest($text, $url1, $url2){
		echo '<script>
			if(confirm("'.$text.'")){
	        	 window.location="'.$url1.'";
	        }else{
	        	window.location="'.$url2.'";
	        }</script>';
	}

	//SOMENTE PARA O FORUM
	function alertaConfirm($text, $url, $get){

		echo '<script>
			if(confirm("'.$text.'")){
	        	 window.location="'.$url.'?forum='.$get.'&&confirm=sim";
	        }else{
	        	window.location="'.$url.'?forum='.$get.'";
	        }</script>';

	}
	function printCheckbox($post, $valor){
		if ($post !== false) {
			for ($i=0; $i < count($post); $i++) { 
				if ($post[$i] == $valor) {
					return 'checked';
				}
			}
		}
	}

	function printSelect($post, $valor){
		if ($post !== false) {
			if ($post == $valor) {
				return 'selected';
			}else{
				return '';
			}
		}else{
			return '';
		}
	}
	function printRadio($post, $valor){
		
		if ($post !== false) {
			if ($post == $valor) {
				return 'checked';
			}else{
				return '';
			}
		}else{
			return '';
		}
	}


	function printPost($post, $ind){
		if ($post == null) {
			$post = '';
		}
		if ($ind == 'page') {
			$post = printPostHTML($post);
			return $post;
		}else if($ind == 'campo'){
			$post = printPostTextarea($post);
			return $post;
		}else{
			$post = printPostHTML($post);
			return $post;
		}
	}
	function printPostHTML($post){
		$post = str_replace('\r\n', "<br>", $post);
		$post = str_replace('\\', "", $post);
		return $post;
	}
	function printPostTextarea($post){
		$post = str_replace('\r\n', "&#10;", $post);
		$post = str_replace('\\', "", $post);
		return $post;
	}

	//Pegar a primeira, segunda... n palavra de uma string 
	function GetName($nome, $n){
		if ($n === null || $n === false) {
			$n = 1;
		}
		$nome 	= explode(" ", $nome);
		$n 		= $n-1;
		return $nome[$n];
	}
	function GetCampo($key = null){
		if($key == null)
			return $_POST;
		else
			return (isset($_POST[$key])) ? str_replace("'", "", $_POST[$key]) : false;
	}
	
	function GetTitle(){
		$url 	 	= (isset($_GET['url'])) ? $_GET['url'] : 'home';
		$url		= array_filter(explode('/', $url));
		$paginas 	= array('fale-conosco', 'metodologia','celulas','Newsletter', 'documentos', 'confirmacao', 'encontros-universitarios', 'oficina');
		$oficinas   = array('expopacce', 'nescau');

		$categoria 	= $url[0];
		$categoriaOficina = $url[1];

		if(isset($url[1])){
			$postagem = $url[1];
		}

		//buscador
		if(isset($_GET['s']) && $_GET['s'] != ''){
			echo '<title>Pesquisa</title>';
		}
		//HOME
		else if($categoria == 'home'){
			echo '<title>PACCE - UFC</title>';
		}
		//PAGINAS fIXAS
		else if (isset($categoriaOficina) && in_array($categoriaOficina, $oficinas)) {
			switch ($categoriaOficina) {
				case 'expopacce':
					echo '<title>ExpoPACCE</title>';;
					break;
				
				case 'nescau':
					echo '<title>NESCAU</title>';;
					break;
			}
		}
		else if(isset($categoria) && in_array($categoria, $paginas)){
			if ($categoria == 'celulas') {
				echo '<title>Células de Estudo</title>';
			}else if ($categoria == 'metodologia') {
				echo '<title>Metodologia</title>';
			}else if ($categoria == 'documentos') {
				echo '<title>Documentos</title>';
			}else if ($categoria == 'confirmacao') {
				echo '<title>Confirmação</title>';
			}else if ($categoriaOficina == 'expopacce') {
				echo '<title>ExpoPACCE</title>';
			}else if ($categoriaOficina == 'nescau') {
				echo '<title>NESCAU</title>';
			}else if ($categoria == 'oficina') {
				echo '<title>Oficinas</title>';			
			}else if ($categoria == 'encontros-universitarios') {
				echo '<title>Encontros Universitários</title>';
			}else{
				echo '<title>'.$categoria.'</title>';
			}
			
		}
		//POSTAGEM
		else if(isset($postagem) && $postagem != ''){
			$resPost = DBread('posts', "WHERE tituloSlug = '$postagem'");
			if($resPost == true){
				echo '<title>'.$resPost[0]['titulo'].'</title>';
			}else{
				echo '<title>Error 404 - Página não encontrada</title>';
			}
		}
		else if (isset($categoria) && !in_array($categoria, $paginas)) {
			$resCat = DBread('posts', "WHERE categoriaSlug = '$categoria'");
			if($resCat == true){
				echo '<title>'.$resCat[0]['categoria'].'</title>';
			}else{
				echo '<title>Error 404 - Página não encontrada</title>';
			}
		}else{
			echo '<title>Error 404 - Página não encontrada!</title>';
		}
	}
	//CONVER EM MAIÚSCULA
	 function nomeM($nome){
          $nome = str_replace("-", "1", $nome);
          $nome = strtoupper($nome);
          $nome = str_replace("ç", "Ç", $nome); $nome = str_replace("â", "Â", $nome);
          $nome = str_replace("ã", "Ã", $nome); $nome = str_replace("á", "Á", $nome);
          $nome = str_replace("ê", "Ê", $nome); $nome = str_replace("é", "É", $nome);
          $nome = str_replace("í", "Í", $nome); $nome = str_replace("ó", "Ó", $nome);
          $nome = str_replace("ô", "Ô", $nome); $nome = str_replace("ú", "Ú", $nome);
          $nome = str_replace("1", "-", $nome);
          return $nome;

    }

	//Converte para Slug
	function Slug($name){
		$name = str_replace(" - ", " ", $name);
		$name = str_replace(" ", "-", $name);
		$name = str_replace("à", "a", $name); $name = str_replace("á", "a", $name); $name = str_replace("ã", "a", $name); $name = str_replace("â", "a", $name);
		$name = str_replace("À", "a", $name); $name = str_replace("Á", "a", $name); $name = str_replace("Ã", "a", $name); $name = str_replace("Â", "a", $name);

		$name = str_replace("è", "e", $name); $name = str_replace("é", "e", $name); $name = str_replace("ê", "e", $name); 
		$name = str_replace("È", "e", $name); $name = str_replace("É", "e", $name); $name = str_replace("Ê", "e", $name);

		$name = str_replace("ì", "i", $name); $name = str_replace("í", "i", $name); $name = str_replace("î", "i", $name); 
		$name = str_replace("Ì", "i", $name); $name = str_replace("Í", "i", $name); $name = str_replace("Î", "i", $name); 

		$name = str_replace("ò", "o", $name); $name = str_replace("ó", "o", $name); $name = str_replace("õ", "o", $name); $name = str_replace("ô", "o", $name);
		$name = str_replace("Ò", "o", $name); $name = str_replace("Ó", "o", $name); $name = str_replace("Õ", "o", $name); $name = str_replace("Ô", "o", $name);

		$name = str_replace("ù", "u", $name); $name = str_replace("ú", "u", $name); $name = str_replace("û", "u", $name); 
		$name = str_replace("Ù", "u", $name); $name = str_replace("Ú", "u", $name); $name = str_replace("Û", "u", $name);
		$name = str_replace("ç", "c", $name); $name = str_replace("Ç", "c", $name); $name = str_replace(".", "", $name); $name = str_replace(";", "", $name);
		$name = str_replace("[", "", $name);  $name = str_replace("]", "", $name); $name = str_replace("[]", "", $name); $name = str_replace("|", "", $name);
		$name = str_replace("/", "", $name);  $name = str_replace("''", "", $name); $name = str_replace(":", "-", $name);
		$name = str_replace('"', "", $name);  $name = str_replace('""', "", $name);  $name = str_replace(",", "", $name);  $name = str_replace("#", "", $name); 
		$name = str_replace("?", "", $name); 
		$name = strtolower($name);
		return $name;
	}
	//Redimensionar Imagem para upLoad
	function Redimensionar($tmp, $name, $largura, $pasta){
		$img 	= imagecreatefromjpeg($tmp);
		$x 		= imagesx($img);
		$y		= imagesy($img);

		$altura = ($largura*$y)/$x;
		$nova = imagecreatetruecolor($largura, $altura);
		imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);	
		imagejpeg($nova, "$pasta/$name");
		imagedestroy($img);
		imagedestroy($nova);
		return $name;

	}

	//VERIFICA SE EXTISTE O COOKIE CONECTADO
	function VerifyConectado(){

		if (isset($_COOKIE["conectado"]) && $_COOKIE["conectado"] == '1') {
			
			$npacce = $_COOKIE["npacce"];
			if (strlen($npacce) > 8) {
				$part1 = substr($npacce, 0, 3);
				$part2 = substr($npacce, 0, 6);
				$part2 =  substr($part2, 3);
				$part3 = substr($npacce, 0, 9);
				$part3 = substr($part3, 3);
				$part3 = substr($part3, 3);
				$part4 = substr($npacce, 9, 11);
				$npacce = $part1.'.'.$part2.'.'.$part3.'-'.$part4;
			}
			$senha		= $_COOKIE["senha"];
			$conectado 	= $_COOKIE["conectado"];

			if(empty($npacce)){
				$msg = "Informe seu Número PACCE!";

			}else if(empty($senha)){
				$msg = "Informe sua Senha!";

			}else{
				// PARA O CHAT
				$agora = date('Y-m-d H:i:s');
				$limite = date('Y-m-d H:i:s', strtotime('+2 min'));
				$form['horario'] = $agora;
				$form['limite']	= $limite;
				if (DBUpDate('bolsistas', $form,"npacce = '".$npacce."'")) {
					CreateSession($npacce, $senha);
				}
			}
		}
	}

	//Valida Login
	function ValidaLogin(){
		if(!!GetPost('logar')){
			$msg = null;

			$npacce = strtoupper(GetPost('npacce'));
			$cpfSave = $npacce;
			if (strlen($npacce) > 8) {
				$part1 = substr($npacce, 0, 3);
				$part2 = substr($npacce, 0, 6);
				$part2 =  substr($part2, 3);
				$part3 = substr($npacce, 0, 9);
				$part3 = substr($part3, 3);
				$part3 = substr($part3, 3);
				$part4 = substr($npacce, 9, 11);
				$npacce = $part1.'.'.$part2.'.'.$part3.'-'.$part4;
			}
			$senha		= GetPost('password');
			$conectado 	= GetPost('remember');

			if(empty($npacce)){
				$msg = "Informe seu Número PACCE!";

			}else if(empty($senha)){
				$msg = "Informe sua Senha!";

			}else{
				if(!userSemStatus($npacce, $senha)){
					$msg = "Número PACCE ou Senha Errado(s)!";
				}else if(!userVerify($npacce, $senha)){
					$msg = "Esta conta está Desativada";
				}else{
					//PARA MANTER CONECTADO
					if ($conectado == 'on' || $conectado == true || $conectado == '1') {
						setcookie('conectado', true, time() + 3600 * 24 * 30 * 12, '/');
						setcookie('npacce', $cpfSave, time() + 3600 * 24 * 30 * 12, '/');
						setcookie('senha', $senha, time() + 3600 * 24 * 30 * 12, '/');	
					}else{
						setcookie('conectado', '', time() - 3600 * 24 * 30 * 12, '/');
						setcookie('npacce', '', time() - 3600 * 24 * 30 * 12, '/');
						setcookie('senha', '', time() - 3600 * 24 * 30 * 12, '/');
					}
					// PARA O CHAT
					$agora = date('Y-m-d H:i:s');
					$limite = date('Y-m-d H:i:s', strtotime('+2 min'));
					$form['horario'] = $agora;
					$form['limite']	= $limite;
					if (DBUpDate('bolsistas', $form,"npacce = '".$npacce."'")) {
						CreateSession($npacce, $senha);
					}
					
				}
				
			}

			// echo ($msg != null) ? $msg.'<hr size="1" color="#CCCCCC">' : null;
			if ($msg != null) {
				alerta($msg);
			}
		}
	}

	//Validar Formulario de cadrastro ==== Terminar
	function ValidaFormRegister(){
		if(!!GetPost('NomeDoBotao')){
		}
	}


	/* ======================================== */
	//PROTECAO
	//Controla Acesso Publico
	function AcessPublic(){
  		if(IsLogged()){
       		$post = (isset($_GET['post']) ? $_GET['post'] : '');
       		$var =  (isset($_GET['post']) ? '?post=' : '');
			Redirect(URL_PAINEL.$var.$post);
		}
	}

	//Controla Acesso Privado
	function AcessPrivate(){
		if(!IsLogged()){
			Redirect(URLBASE.'login');
		}
	}

	/* ======================================== */
	
	/* ======================================== */
	//SESSÃO

	//Executa Logout
	function DoLogout(){
		if(isset($_GET['logout'])){
			//MATA OS COOKIES QUE SALVAM SUA SESSÃO
			if (isset($_COOKIE["conectado"]) && $_COOKIE["conectado"] == '1'){
				setcookie('conectado', '', time() - 3600 * 24 * 30 * 12, '/');
				setcookie('npacce', '', time() - 3600 * 24 * 30 * 12, '/');
				setcookie('senha', '', time() - 3600 * 24 * 30 * 12, '/');
			}
			DestroySession();
		}
	}

	//Destroi Sessao
	function DestroySession(){
		unset($_SESSION['userLog']);
		AcessPrivate();
	}

	//Cria Sessao
	function CreateSession($npacce, $password){
		$key = GetKey($npacce, $password);
		UserLog($key);
		AcessPublic();
	}

	//Seta ou Recupera USER LOG
	function UserLog($value = null){
		if($value === null)
			return $_SESSION['userLog'];
		else
			$_SESSION['userLog'] = $value;

	}

	//Verifica Login
	function IsLogged(){
		if(!isset($_SESSION['userLog']) || empty($_SESSION['userLog']))
			return false;
		else{
			if(StayLogged())
				return true;
			else
				DestroySession();
		}
	}

	/* ======================================== */
	
	//Crypt Senha
	function CryptPassword($password){
		$password = sha1($password);
		return $password;
	}


	//Gera key
	function KeyGeneration(){
		return sha1(rand().time());
	}

	//recuperar POST[]
	function GetPost($key = null){
		if($key == null)
			return $_POST;
		else
			return (isset($_POST[$key])) ? DBescape($_POST[$key]) : false;
	}	

	//redirecinar
	function Redirect($url){
		header("Location: ".$url);
		die();
	}

//Limita Texto
	function texto($texto, $maximo = 200){
		$texto = strip_tags($texto);
		$conta = strlen($texto);
		
		if($conta <= $maximo){
			return $texto;
		}else{
			$limita = substr($texto, 0, $maximo);
			$espaco	= strrpos($limita, " ");
			$limita = substr($texto, 0, $espaco);
			return $limita.'...';
		}
	}

//Paginador
	function paginator($sql, $maxPosts, $paginaAtual){
		//PAGINATOR
		$resultsAll = DBread($sql, "WHERE status = true");
		
		//Contagem
		$totalPost	= count($resultsAll);
		
		//Paginas
		$paginas	= ceil($totalPost / $maxPosts);
		
		if($paginaAtual > $paginas || $totalPost <= $maxPosts){
		}else{
			if(isset($_GET['url'])){
				$GetUrl = $_GET['url'];
			}else{
				$GetUrl = '';
			}	
			echo '<div class="pagenav clearfix">';
			
				//Pagina Inicial
				//
				echo '<a href="'.URLBASE.''.$GetUrl.'?page=1" class="number">Primeira Pagina</a>';
				
				//Pagina Alterior
				if($paginaAtual >= 2){
					$pagePrev = $paginaAtual - 1;
					echo '<a href="'.URLBASE.''.$GetUrl.'?page='.$pagePrev.'" class="number">'.$pagePrev.'</a>';
				}
				
				//Pagina Atual
				echo '<span>'.$paginaAtual.'</span>';
				
				//Proxima Pagina
				if($paginaAtual != $paginas){
					$pageNext = $paginaAtual + 1;
					echo '<a href="'.URLBASE.''.$GetUrl.'?page='.$pageNext.'" class="number">'.$pageNext.'</a>';
				}
				
				//Ultima Inicial
				echo '<a href="'.URLBASE.''.$GetUrl.'?page='.$paginas.'" class="number">Ultima Pagina</a>';
			
			echo '</div>';
		}
	}
	//Paginador Categoria
	function paginatorCategoria($sql,$categoria,$maxPosts, $paginaAtual){
		//PAGINATOR
		
		$resultsAll = DBread($sql, "WHERE status = true AND categoriaSlug = '$categoria'");
		
		//Contagem
		$totalPost	= count($resultsAll);
		
		//Paginas
		$paginas	= ceil($totalPost / $maxPosts);
		
		if($paginaAtual > $paginas || $totalPost <= $maxPosts){
		}else{
			if(isset($_GET['url'])){
				$GetUrl = $_GET['url'];
			}else{
				$GetUrl = '';
			}	
			echo '<div class="pagenav clearfix">';
			
				//Pagina Inicial
				//
				echo '<a href="'.URLBASE.''.$GetUrl.'?page=1" class="number">Primeira Página</a>';
				
				//Pagina Alterior
				if($paginaAtual >= 2){
					$pagePrev = $paginaAtual - 1;
					echo '<a href="'.URLBASE.''.$GetUrl.'?page='.$pagePrev.'" class="number">'.$pagePrev.'</a>';
				}
				
				//Pagina Atual
				echo '<span>'.$paginaAtual.'</span>';
				
				//Proxima Pagina
				if($paginaAtual != $paginas){
					$pageNext = $paginaAtual + 1;
					echo '<a href="'.URLBASE.''.$GetUrl.'?page='.$pageNext.'" class="number">'.$pageNext.'</a>';
				}
				
				//Ultima Inicial
				echo '<a href="'.URLBASE.''.$GetUrl.'?page='.$paginas.'" class="number">Ultima Página</a>';
			
			echo '</div>';
		}
	}
?>