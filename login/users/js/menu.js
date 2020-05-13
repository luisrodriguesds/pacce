$(function(){
	
	//VARS
	var w = $("#box-menu").width();
		w = w + 25;
	var click = 0;
	var altura = window.innerHeight;
	var largura = window.innerWidth;

	//FUNCOES
	
	//EVENTOS

	//EVENTOS MENU 
	window.addEventListener('resize', function () {
	    var altura = window.innerHeight;
	    var largura = window.innerWidth;
	    	largura = largura + 25;
	    if ((largura-25) <= 1024) {
	    	if (click == 0) {
	    		$("#box-menu").css({
		    		left: -largura,
		    		transition: 'all 0s',
	    		});
	    	}
	    	
	    	$("#box-menu").css({
	    		height: '100%',
	    		transition: 'all 0s'
	    	});;
	    }
	    
	});

	//INICIAR COM ALTURA CORRETA
	if (largura <= 1024) {
		$("#box-menu").css('height', '100%');
	
	}else{
		w = 0;
	}
	//CASO PRECISE MEXER COM SCROLL
	$(window).scroll(function(event) {
		var top = $(window).scrollTop();
	});

	$("#box-menu").css('left', -w);
	
	//CLICK BAR
	$(".navBtn").click(function(e) {
		console.log(w);
		e.preventDefault();
		if (click == 0) {
			$("#box-menu").css({
				left: 0,
				transition: 'all 0.5s'
			});
			click = 1;
		}else{
			var w = $("#box-menu").width();
				w = w + 25;
			$("#box-menu").css({
				left: -w,
				transition: 'all 0.5s'
			});
			click = 0
		}

	});

});