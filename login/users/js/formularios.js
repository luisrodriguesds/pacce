$(function(){
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
		
	});
	
	//pacce-novatos
	$('#pacce-novatos').validate({
	    debug: true,
	    rules:{
	    	
	        memorial:{
	            required: true,
	            minlength: 4000,
	            maxlength: 8000
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

});


// $(function(){
//     $.validator.addMethod('filesize', function (value, element, param) {
//         return this.optional(element) || (element.files[0].size <= param)
//     }, 'O arquivo deve ser menor do que {0}MB');

//     if ($('#meu-perfil').length != 0) {
//         $('#meu-perfil').validate({
//                 debug: true,
//                 rules:{
                    
//                     imagem: {
//                         required: false,
//                         extension: "png|jpeg|gif|jpg",
//                         filesize : 20*1024*1024
//                     }
//                 },
//                 messages:{
//                     imagem: {
//                         extension: "Formatos aceitos são: PNG, JPEG, GIF e JPG"
//                     }
//                 },
//                 submitHandler: function(form){
                    
//                 },
//                 highlight: function(element, errorClass, validClass) {
//                     $(element).removeClass('is-valid').addClass('is-invalid');
//                 },
//                 unhighlight: function(element, errorClass, validClass) {
//                     $(element).removeClass('is-invalid').addClass('is-valid');
//                 }
//             });
//     }
// });