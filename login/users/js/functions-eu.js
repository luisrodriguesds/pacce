$(function(){
	
	//VARS GLOBAIS
	var cod_pres = $("#codigo").text();
	var wd = $(window).width();

	//VERIFICAÇÕE4S DE INICIO
	if($("#status_presenca").text() == 'Liberada'){
		$("#wrap_buscador").css('display', 'block');
		$("#aviso_presenca").css('display', 'none');
	}else{
		$("#wrap_buscador").css('display', 'none');
		$("#aviso_presenca").css('display', 'block');
	}
	//FUNCOES
	function msg(mensagem){
		$("#model_retorno_msg").text(mensagem);
		$("modal_click").click();
	}

	function presenca(mat, nome, curso, cod, inicio, fim){
		var url = '../ajax/estudantes-eu.php';
		var data = new Date();
		var inicioChegada = data.getHours()+':'+data.getMinutes()+':00';
		$.post(url, {mat:mat, nome:nome, curso:curso, cod:cod, inicio:inicioChegada, fim:fim}, function(data) {
			if (data == 'success') {
				$("#model_retorno_msg").text('Presença de '+nome+' foi coletada com sucesso!!!');
				var dataAtual = new Date();
				var res = '<tr><td>'+mat+'</td>';
					res+= '<td>'+nome+'</td>';
					res+= '<td>'+curso+'</td>';
					res+= '<td>'+dataAtual.getHours()+':'+dataAtual.getMinutes()+'</td>';
					res+= '<td>'+fim+'</td></tr>';
				 	$("#participantes table tbody").append(res);

					if (wd <= 1024){
						alert('Presença de '+nome+' foi coletada com sucesso!!!');
					}
			}else if(data == 'error2'){
				$("#model_retorno_msg").text('Esse estudante já tem presença nesse turno');
				if (wd <= 1024){
					alert('Esse estudante já tem presença nesse turno');
				}	
			}

			$("#modal_click").click();
			$("#buscadorRes table tbody tr td").remove();
			$("#buscador").val('');
			$("#confirmar").css('display', 'none');
		});
	}

	function buscaEstudante(matricula){
		var url = '../ajax/estudantes-eu.php';
		$.post(url, {matricula: matricula}, function(data) {
			if (data == 'vazio'){
				$("#nada_enc").css('display', 'block');
				$("#buscadorRes table tbody tr td").remove();
				$("#confirmar").css('display', 'none');
			}else{
				$("#nada_enc").css('display', 'none');
				$("#confirmar").css('display', 'block');

				$.each($.parseJSON(data), function(index, study) {
					$("#buscadorRes table tbody tr td").remove();
					var res = '<td id="mat">'+study.matricula+'</td>';
					res+= '<td id="nome">'+study.nome+'</td>';
					res+= '<td id="curso">'+study.curso+'</td>';
				 	$("#buscadorRes table tbody tr").append(res);
				});
			}
		});
	}

	function checkPresenca(cod1){
		$.post('../ajax/edicoes-eu.php', {cod: cod1}, function(data) {
			if (data == 'error') {
				$("#model_retorno_msg").text('Ocorreu um error, atualize sua página!!!');
			}else if(data == 'on'){
				$("#btn_presenca").removeClass('btn-primary').addClass('btn-danger').text('Bloquear Presença');
				$("#status_presenca").css('color', 'green').text('Liberada');
				$("#wrap_buscador").css('display', 'block');
				$("#aviso_presenca").css('display', 'none');
			}else if(data == 'off'){
				$("#btn_presenca").removeClass('btn-danger').addClass('btn-primary').text('Liberar Presença');
				$("#status_presenca").css('color', 'red').text('Bloqueada');
				$("#wrap_buscador").css('display', 'none');
				$("#aviso_presenca").css('display', 'block');
			}
		});
	}

	function actionPresenca(cod){
		$.post('../ajax/edicoes-eu.php', {codigo: cod}, function(data) {
			if (data =='error') {
				//mgs de error
				$("#model_retorno_msg").text('Ocorreu um error, atualize sua página!!!');
			}else if (data == 'success1'){
				$("#model_retorno_msg").text('Ação realizada com sucesso!!!');
				$("#btn_presenca").removeClass('btn-primary').addClass('btn-danger').text('Bloquear Presença');
				$("#status_presenca").css('color', 'green').text('Liberada');
				$("#wrap_buscador").css('display', 'block');
				$("#aviso_presenca").css('display', 'none');
			}else if (data == 'success0'){
				$("#model_retorno_msg").text('Ação realizada com sucesso!!!');
				$("#btn_presenca").removeClass('btn-danger').addClass('btn-primary').text('Liberar Presença');
				$("#status_presenca").css('color', 'red').text('Bloqueada');
				$("#wrap_buscador").css('display', 'none');
				$("#aviso_presenca").css('display', 'block');
			}
			$("#modal_click").click();
		});
	}

	
	//AÇOES
	$("#formEnviar").click(function(e) {
		var form = [];
		form.matricula 	= $("#formMatricula").val();
		form.nome 		= $("#formNomeComp").val();
		form.curso 		= $("#formCurso").val();
		form.email 		= $("#formEmail").val(); 
		if (form.matricula == "") {
			alert("Campo Matrícula Vazio");
		}else if(form.nome == ""){
			alert("Campo Nome Vazio");
		}else if (form.curso == "") {
			alert("Campo Curso Vazio");
		}else if (form.email == "") {
			alert("Campo Email Vazio");
		}else{
			$.post('../ajax/edicoes-eu.php', form, function(data) {
				if (data == 'success') {

				}else if(data == 'error1'){
					
				}
			});
		}
	});


	$("#buscador").keyup(function(event) {
		var busca = $(this).val();
		checkPresenca(cod_pres);
		if (busca.length <= 0){
			$("#buscadorRes table tbody tr td").remove();
			buscaEstudante('123456789');
		}else{
			buscaEstudante(busca);
		}
	});

	$("#confirmar").click(function(e) {
		var codigo 	= $("#codigo").text();
		var mat 	= $("#mat").text();
		var nome 	= $("#nome").text();
		var curso 	= $('#curso').text();
		var inicio 	= $('#inicio').text();
		var fim 	= $('#fim').text();
		presenca(mat, nome, curso, codigo, inicio, fim);
		checkPresenca(cod_pres);
	});

	$("#close_modal").click(function(e) {
		e.preventDefault();
		$("#buscador").focus();
	});

	$("#btn_presenca").click(function(e) {
		e.preventDefault();
		actionPresenca(cod_pres);
	});
});