$(function(){
	var bottom = $(window).height();
	var url_painel;
	var nao_lidas = 0;
	$("#pesquisar_users_online").css({'top':bottom-100});

	var userOnline 	= $('span.user_online').attr('id');
	var clicou		= [];
	var altura;
	function in_array(valor, array){
		for (var i = 0; i < array.length; i++) {
			if (array[i] == valor) {
				return true;
			}
		}
		return false;
	}

	function add_janela(id, nome, status){
		var janelas = parseInt($("#chats .window").length);
		var pixels = (270+5)*janelas;
		var style = 'float:none; position:absolute; bottom:0; right:'+pixels+'px;';
		//position:absolute; bottom:0; right:'+pixels+'px;
		var splitDados 	= id.split(':');
		var id_user 	= splitDados[1];
		status = status.replace("status", "");

		var janela 	= '<div class="window" id="janela_'+id_user+'" style="'+style+'">';
		janela			+= '<div class="header_window"><span id="'+id_user+'" class="status_window '+status+'"></span><span class="name">'+nome+'</span><a href="#" class="close">X</a></div>';
		janela			+= '<div class="body"><div class="mensagens"><ul></ul></div>';
		janela			+= '<div class="send_mensagem" id="'+id+'"><input type="text" name="menseger" placeholder="Digite uma mensagem..." class="msg" id="'+id+'"></div></div></div>';
		$("#chats").append(janela);
	}

	function retorna_historico(id_conversa) {
		var url = $('#urls_chat').text();
		url += 'ajax/historico-chat.php';
		$.post(url, {conversacom:id_conversa, online:userOnline}, function(retorno) {
			
			$.each($.parseJSON(retorno), function(i, msg) {

			  if ($('#janela_'+msg.janela_de).length > 0) {
			  	if (userOnline == msg.id_de) {
			  		$('#janela_'+msg.janela_de+' .mensagens ul').append('<li id="'+msg.id+'" class="eu"><div><p>'+msg.mensagem+'</p></li>');
			  	}else{
					$('#janela_'+msg.janela_de+' .mensagens ul').append('<li id="'+msg.id+'" class="voce"><div class="img_thumb"><img src="'+msg.url_painel+'imagensBolsistas/'+msg.foto+'"></div><p>'+msg.mensagem+'</p></li>');
			  	}
			  }
			});

			[].reverse.call($('#janela_'+id_conversa+' .mensagens li')).appendTo('#janela_'+id_conversa+' .mensagens ul');
			
			//Muito importante!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Scroll
			var altura = $('#janela_'+id_conversa+' .mensagens').height();
			$('#janela_'+id_conversa+' .mensagens').animate({scrollTop: altura}, 500);

		});
	}

	//Quanod eu clicar em aside users online
	$('body').on('click', '#users_online a', function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		$(this).removeClass('comecar');
		var status = $(this).next().attr('class');
		var splitIds = id.split(':');
		var idJanela = splitIds[1];

		//Se eu tentar incluir uma janela q ainda não está inclusa ai sim ele vai deixar incluir
		if ($('#janela_'+idJanela).length == 0 && parseInt($("#chats .window").length) < 4) {
			//ADD JANELA AO BANCO AQUI
			var nome = $('#users_online #usuariosOn #'+idJanela+' a').text();
			add_janela(id, nome, status);
			retorna_historico(idJanela);
		}else{
			$(this).removeClass('comecar');
		}
		
	});

	/* FAZEEEER SALVE DE JANELAS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
	//Minimizar a chat
	$('body').on('click', '.header_window', function(){
		var next = $(this).next();
		//next.toggle(10);
		var check = next.attr('class');
		
		if (check == 'body body_on' || check == 'body') {
			$(next).removeClass('body_on').addClass('body_off');
		}else{
			$(next).addClass('body_on').removeClass('body_off');
		}
	});

	//FECHAR JANELA
	$('body').on('click', '.close', function(e) {
		e.preventDefault();
		var parent 			= $(this).parent().parent();
		var idParent		= parent.attr('id');
		var sliptParent		= idParent.split('_');
		var idJanelaFechada	= sliptParent[1];

		//PARA SABER QUANTAS JANELAS EXISTEM
		var contagem 	= parseInt($("#chats .window").length)-1;
		var indice		= parseInt($(".close").index(this));
		var restam 		= contagem-indice;

		for (var i = 0; i <= restam; i++) {
			$('.window:eq('+(indice+i)+')').animate({'right':'-=275px'}, 500);
		}
		//REMOVER JANELA DO BANCO AQUI
		parent.remove();
		$('#users_online li#'+idJanelaFechada+' a').addClass('comecar');
	});

	$('body').on('keyup', '.msg', function(e) {
		
		if (e.which == 13) {
			var texto 	= $(this).val();
			if (texto.length != 1){
				var id 		= $(this).attr('id');
				var split 	= id.split(':');
				var para 	= split[1];
				var url 	= $('#urls_chat').text();
				url += 'ajax/submit-chat.php';
				//O post será em todas as páginas, observar se irá  
				$.post(url, {mensagem: texto, de: userOnline, para:para}, function(data) {
					if (data == 'okay'){
						$('.msg').val('');
					}else{
						alert("Ocorreu um erro inesperado ao enviar a mensagem, por favor procurar o desenvolvedor da página");
					}
				});
			}
		}
	});

	//LIDA OU NÃO LIDA
	$('body').on('click', '.mensagens', function(e) {
		
		var janela 		= $(this).parent().parent();
		var janelaId 	= janela.attr('id');
		var idConversa 	= janelaId.split('_');
		console.log(janelaId);
		idConversa = idConversa[1]; 
		
		var url = $('#urls_chat').text();
		url += 'ajax/leitura-chat.php';

		$.post(url, {ler: 'sim', online:userOnline, user: idConversa}, function(data) {
			console.log(data);
		});	
	});

	$('body').on('click', '.msg', function(e) {
		
		var janela 		= $(this).parent().parent();
		var janelaId 	= janela.attr('id');
		var idConversa 	= janelaId.split('_');
		console.log(janelaId);
		idConversa = idConversa[1]; 
		
		var url = $('#urls_chat').text();
		url += 'ajax/leitura-chat.php';

		$.post(url, {ler: 'sim', online:userOnline, user: idConversa}, function(data) {
			console.log(data);
		});	
	});

	function verifica(timestamp, lastid, user){
		var t;
		var url = $('#urls_chat').text();
		url += 'ajax/stream-chat.php';

		$.ajax({
			url: url,
			type: 'GET',
			data: 'timestamp='+timestamp+'&lastid='+lastid+'&user='+user,
			dataType: 'json',
			success: function(retorno){
				clearInterval(t);
				if(retorno.status == 'resultados' || retorno.status == 'vazio'){
					t =setTimeout(function(){
						verifica(retorno.timestamp, retorno.lastid, userOnline);
					}, 1000);

					if(retorno.status == 'resultados'){
						
						$.each(retorno.dados, function(i, msg){
							url_painel = $("#url_painel").text();
							if(msg.id_para == userOnline && msg.lido == 0){
								$.playSound(url_painel+'/sons/effect');
							}

							//QUANDO CARREGA ==============================================================
							
							if($('#janela_'+msg.janela_de).length == 0){
								$('#users_online #'+msg.janela_de+' .comecar').click();
								clicou.push(msg.janela_de);
							}
							
							//QUANDO MANDA MENSAGEM===================================================================================
							if(!in_array(msg.janela_de, clicou)){
								if($('.mensagens ul li#'+msg.id).length == 0){

									if(userOnline == msg.id_de){
										$('#janela_'+msg.janela_de+' .mensagens ul').append('<li id="'+msg.id+'" class="eu"><div><p>'+msg.mensagem+'</p></li>');
									}else{
										$('#janela_'+msg.janela_de+' .mensagens ul').append('<li id="'+msg.id+'" class="voce"><div class="img_thumb"><img src="'+msg.url_painel+'imagensBolsistas/'+msg.foto+'"></div><p>'+msg.mensagem+'</p></li>');
									}

									//SCROLL DA CAIXA DE MENSAGEM QUANDO ENVIA UMA MENSAGEM
									var altura = $('#janela_'+msg.janela_de+' .mensagens ul').height();
									$('#janela_'+msg.janela_de+' .mensagens').animate({scrollTop: altura}, 0);
									var top = $('#janela_'+msg.janela_de+' .mensagens').scrollTop();
									
								}
							}

						});
					}

					clicou = [];

					//NOMEANDO SESSAO DE USUARIOS
					$('#users_online #us').html('USUÁRIOS ('+retorno.users.length+')');
					//NOMEANDO SESSAO DE NÃO LIDAS
					//$('#users_online #sessao_nao_lida').html('MENSAGENS NÃO LIDAS ('+nao_lidas+')');
					//ADD USUARIOS
					$('#users_online ul#usuariosOn').html('');
					url_painel = $("#url_painel").text();
					$.each(retorno.users, function(i, user){
					 	var incluir = '<li id="'+user.npacce+'"><div class="img_thumb"><img src="'+url_painel+'imagensBolsistas/'+user.foto+'" border="0"/></div>';
					 	incluir += '<a href="#" id="'+userOnline+':'+user.npacce+'" class="comecar">'+user.nome+'</a>';
					 	incluir += '<span id="'+user.npacce+'" class="status '+user.status+'"></span></li>';
					 	$('span#'+user.id).attr('class', 'status_window '+user.status);
					 	$('#users_online ul#usuariosOn').append(incluir);
				 	});
				}else if(retorno.status == 'erro'){
					alert('Ficamos confusos, atualize a pagina');
				}
			},
			error: function(retorno){
				clearInterval(t);
				t=setTimeout(function(){
					verifica(retorno.timestamp, retorno.lastid, userOnline);
				},15000);
			}
		});
	}

	verifica(0,0,userOnline);

	
		
});