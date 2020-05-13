$(function(){

	//METODOS
    jQuery.validator.addMethod("notEqual", function(value, element, param) {
    	console.log(value);
    	console.log($(param).val());
	 return this.optional(element) || value != $(param).val();
	}, "As função precisam ser diferentes");

	//MASCARAS
	$("[name=cpf]").mask('000.000.000-00');
	$("[name=cep]").mask('00000-000');
	$("[name=dataNasc]").mask('00/00/0000');
	$("[name=fone]").mask('(00)00000-0000');
	$("[name=rendaPercapita]").mask('000.000.000.000.000,00', {reverse: true});

	//CONTADOR MEMORIAL
	$('[name=memorial]').keyup(function(e) {
		var texto = $(this).val();
			texto = $.trim(texto);
		$('.memorial-contador').html(texto.length);
		console.log();
	});

	//MOSTRAR INPUT TEXT QUANDO SIM PARA O CAMPO ConfirmaDefiencia 
	$('[name=ConfirmaDefiencia]').change(function(event) {
		var texto = $(this).val();
		if (texto == 'Sim') {
			$('[name=deficiencia]').css('display', 'block');
		}else{
			$('[name=deficiencia]').css('display', 'none');
		}
	});

	//MOSTRAR INPUT TEXT QUANDO NAO PARA O CAMPO turnoSabado 
	$('[name=turnoSabado]').change(function(event) {
		var texto = $(this).val();
		if (texto != 'Sim') {
			$('[name=motivo_sabado]').css('display', 'block');
		}else{
			$('[name=motivo_sabado]').css('display', 'none');
		}
	});

	//VALIDACAO
	//pacce-novatos
	$('#pacce-novatos').validate({
	    debug: true,
	    rules:{
	    	cpf:{
	    		remote: '../../ajax/pacce-check-cpf.php',
	    		minlength: 14,
	    		maxlength: 14 
	    	},
	        memorial:{
	            required: true,
	            minlength: 2500,
	            maxlength: 8000
	        },
	        rePassword:{
	        	equalTo: '#password',
	        	minlength: 6
	        }
	    },
	    messages:{
	    	cpf:{
	    		remote: 'Seu CPF consta em nosso Banco de Dados como veterano. Procure a Coordenação do PACCE.'
	    	},
	        memorial:{
	            required: 'O campo está vazio',
	            minlength: 'Campo com número de caracteres insuficiente. 5000 é mínimo.'
	        },
	        rePassword:{
	        	equalTo: "As senhas não correspondem"
	        }
	    },
	    highlight: function(element, errorClass, validClass) {
	        $(element).removeClass('is-valid').addClass('is-invalid');
	    },
	    unhighlight: function(element, errorClass, validClass) {
	        $(element).removeClass('is-invalid').addClass('is-valid');
	    },
	    submitHandler: function(form){
	        //SUBMITA
	        $('[name=enviar]').attr('disabled', 'true');
	        form.submit();
	    }
	 });

    $('#pacce-novatos .field-required').each(function(inex, el) {
        $(this).rules("add", {
            required: true,
            messages:{
                required: "Campo obrigatório"
            }
        });
    });

    //prece novatos
    $('#prece-novatos').validate({
	    debug: true,
	    rules:{
	    	cpf:{
	    		remote: '../../ajax/prece-check-cpf.php',
	    		minlength: 14,
	    		maxlength: 14 
	    	},
	    	ideiasDeProjeto:{
	    		minlength:200,
	    		maxlength:500
	    	},
	        memorial:{
	            required: true,
	            minlength: 2000,
	            maxlength: 4000
	        },
	        rePassword:{
	        	equalTo: '#password',
	        	minlength: 6
	        }
	    },
	    messages:{
	    	cpf:{
	    		remote: 'Seu CPF consta em nosso Banco de Dados como veterano. Procure a Coordenação do PRECE.'
	    	},
	        memorial:{
	            required: 'O campo está vazio',
	            minlength: 'Campo com número de caracteres insuficiente. 2000 é mínimo.'
	        },
	        rePassword:{
	        	equalTo: "As senhas não correspondem"
	        }
	    },
	    highlight: function(element, errorClass, validClass) {
	        $(element).removeClass('is-valid').addClass('is-invalid');
	    },
	    unhighlight: function(element, errorClass, validClass) {
	        $(element).removeClass('is-invalid').addClass('is-valid');
	    },
	    submitHandler: function(form){
	        //SUBMITA
	        $('[name=enviar]').attr('disabled', 'true');
	        form.submit();
	    }
	 });

    $('#prece-novatos .field-required').each(function(inex, el) {
        $(this).rules("add", {
            required: true,
            messages:{
                required: "Campo obrigatório"
            }
        });
    });

    //pacce - veteranos
    $('#pacce-veteranos').validate({
	    rules:{
	    	cpf:{
	    		remote: '../../ajax/check-veterano.php',
	    		minlength: 14,
	    		maxlength: 14 
	    	},
	    	funcao1:{
	    		notEqual: '[name=funcao2]'
	    	},
	    	funcao2:{
	    		notEqual: '[name=funcao1]'
	    	}
	    },
	    messages:{
	    	cpf:{
	    		remote: 'Seu CPF consta em nosso Banco de Dados como Novato. Procure a Coordenação do PACCE.'
	    	}
	    },
	    highlight: function(element, errorClass, validClass) {
	        $(element).removeClass('is-valid').addClass('is-invalid');
	    },
	    unhighlight: function(element, errorClass, validClass) {
	        $(element).removeClass('is-invalid').addClass('is-valid');
	    },
	    submitHandler: function(form){
	        //SUBMITA
	        $('[name=enviar]').attr('disabled', 'true');
	        form.submit();
	    }
	 });

    $('#pacce-veteranos .field-required').each(function(inex, el) {
        $(this).rules("add", {
            required: true,
            messages:{
                required: "Campo obrigatório"
            }
        });
    });

    $('#pacce-veteranos [name=cpf]').keyup(function(event) {
    	$.post('../../ajax/check-veterano.php', {check_cpf: $(this).val()}, function(data, textStatus, xhr) {
    		if (data != 'false') {
    			data = $.parseJSON(data);
    			$('#pacce-veteranos [name=npacce]').val(data.npacce);
    			$('#pacce-veteranos [name=nome]').val(data.nome);
    		}
    	});
    });

    //pacce - veteranos
    $('#prece-veteranos').validate({
	    rules:{
	    	cpf:{
	    		remote: '../../ajax/check-veterano.php',
	    		minlength: 14,
	    		maxlength: 14 
	    	},
	    	funcao1:{
	    		notEqual: '[name=funcao2]'
	    	},
	    	funcao2:{
	    		notEqual: '[name=funcao1]'
	    	}
	    },
	    messages:{
	    	cpf:{
	    		remote: 'Seu CPF consta em nosso Banco de Dados como Novato. Procure a Coordenação do PACCE.'
	    	}
	    },
	    highlight: function(element, errorClass, validClass) {
	        $(element).removeClass('is-valid').addClass('is-invalid');
	    },
	    unhighlight: function(element, errorClass, validClass) {
	        $(element).removeClass('is-invalid').addClass('is-valid');
	    },
	    submitHandler: function(form){
	        //SUBMITA
	        $('[name=enviar]').attr('disabled', 'true');
	        form.submit();
	    }
	 });

    $('#prece-veteranos .field-required').each(function(inex, el) {
        $(this).rules("add", {
            required: true,
            messages:{
                required: "Campo obrigatório"
            }
        });
    });

    $('#prece-veteranos [name=cpf]').keyup(function(event) {
    	$.post('../../ajax/check-veterano.php', {check_cpf: $(this).val()}, function(data, textStatus, xhr) {
    		if (data != 'false') {
    			data = $.parseJSON(data);
    			$('#prece-veteranos [name=npacce]').val(data.npacce);
    			$('#prece-veteranos [name=nome]').val(data.nome);
    		}
    	});
    });

});