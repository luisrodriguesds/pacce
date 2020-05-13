

function duplicarCampos(){
	var clone = document.getElementById('origem').cloneNode(true);
	var destino = document.getElementById('destino');
	destino.appendChild (clone);
	var camposClonados = clone.getElementsByTagName('input');
	for(i=0; i<camposClonados.length;i++){
		camposClonados[i].value = '';
	}
}
function removerCampos(id){
	var node1 = document.getElementById('destino');
	node1.removeChild(node1.childNodes[0]);
}
function formatar(mascara, documento){
  var i = documento.value.length;
  var saida = mascara.substring(0,1);
  var texto = mascara.substring(i)
  
  if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
  }
  
}
function maiuscula(z){
    v = z.value.toUpperCase();
    z.value = v;
}

$(function(){
	var rod = 0;
	var rod1 = 0;
	var op = document.getElementById('img');

	$("#sub-opcoes").css({display:'none'});
	$("#op").removeAttr('href');
	
	//faz o butao de opoes rodar
	$("#img").click(function(){
		rod = rod + 180;
		this.style.transform = "rotate("+rod+"deg)";
		$("#sub-opcoes").toggle();
	});


	//Celular
	var wd = $(window).width();

	if (wd <= 1024){
		$('#menu').css({
			height: 'auto'
		});
		$('#box-menu').css({
			position: 'fixed'
		});
	}

	$('.table-responsive').css('max-width', wd-45);

	/*
	var meunScroll = $("#menu").offset().top;
	console.log(meunScroll);

	$("#menu").animate({scrollTop: 41}, 1);
	*/

});

function goTo(element, speed) {
	var href = element.attr('href');
	var top = $(href).offset().top;
	$("html,body").animate({scrollTop: top-50}, speed);
}