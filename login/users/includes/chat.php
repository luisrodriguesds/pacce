<span class="user_online" id="<?php echo $user['npacce']; ?>" style="display: none;" ></span>
<span id="urls_chat" style="display: none;">
	<?php 
		//URL's PARA MENU, POIS OS POST
	  	$url1 = (isset($url[1])) ? $url[1] : '';
	  	$url2 = (isset($url[2])) ? $url[2] : '';
	  	$url3 = (isset($url[3])) ? $url[3] : '';
	  	$url4 = (isset($url[4])) ? $url[4] : '';
	  	$url5 = (isset($url[5])) ? $url[5] : '';

	  	$url1Check = ($url1 != '') ? '../' : '';
	  	$url2Check = ($url2 != '') ? '../' : '';
	  	$url3Check = ($url3 != '') ? '../' : '';
	  	$url4Check = ($url4 != '') ? '../' : '';
	  	$url5Check = ($url5 != '') ? '../' : '';

	  	echo $url1Check.$url2Check.$url3Check.$url4Check.$url5Check;
	?>
</span>
<span id="url_painel" style="display: none;"><?php echo URL_PAINEL; ?></span>
<aside id="users_online">
<div id="pesquisar_users_online">
	<input type="tex" name="pesquisar_on" id="pesquisar_on" placeholder="Search">
</div>
	<span class="divisao" id="us">
		USUÁRIOS ()
	</span>

	<ul id="usuariosOn">
		<?php 
		$select = DBread('bolsistas', "WHERE status = true AND npacce != '".$user['npacce']."'");

		for ($i=0; $i < count($select); $i++) { 
			?>
			<li id="<?php echo $select[$i]['npacce']; ?>">
				<div class="img_thumb">
					<img src="<?php echo URL_PAINEL.'/imagensBolsistas/'.$select[$i]['foto']; ?>">
				</div>
				<a href="#" id="<?php echo $user['npacce'].':'.$select[$i]['npacce']; ?>" class="comecar"><?php echo GetName($select[$i]['nome'], $select[$i]['nomeUsual']); ?></a>
				<span id="<?php $select[$i]['npacce']; ?>" class="status off"></span>
			</li>
			<?php 
		}
		?>

	</ul>
	
	<div id="clear"></div>
</aside>
<aside id="chats">

</aside>

<!-- 
<div class="window" id="janela_x">
		<div class="header_window">
			<span id="5" class="status_window on"></span>
			<span class="name">João Sousa</span>
			<a href="#" class="close">X</a>
		</div>
		<div class="body">
			<div class="mensagens">
				<ul>
					<li class="eu"><p>Exemplo de mensagem que você pode me mandar que desejar conversar ou tirar uma dúvida minha</p></li>
					<li class="voce">
						<div class="img_thumb">
							<img src="imagens/padrao.png" >
						</div>
						<p>Exemplo de mensagem que você pode me mandar que desejar conversar ou tirar uma dúvida minha</p>
					</li>
				</ul>
			</div>
			<div class="send_mensagem" id="de:para">
				<input type="text" name="menseger" class="msg" id="de:para">
				<textarea name="menseger" placeholder="Digite uma mensagem..." class="msg" id="de:para"></textarea>
			</div>
		</div>
	</div>
	-->
