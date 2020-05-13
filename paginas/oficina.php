<style type="text/css">
	
	.workshop {
		margin: 30px 10px;
	}

	.workshop a {
	    background-color: #069;
	 	text-decoration: none;
	    padding: 20px;
	    font-size: 18px;
	    margin: 10px 20px;
	    color: white
	}
	.workshop a:hover {
		background-color: #007DBB;
	}


</style>

<script type="text/javascript">
	
	function changeExpo(elem) {
		var arrow = elem.querySelector('img');
		var page = document.querySelector('#expopacce');

		if (page.style.height == "0px") {
			// page.style.opacity = 1;
			page.style.height = "1300px";
			alert("something");
		} else {
			// page.style.opacity = 0;
			page.style.height = "0px";
			alert("something else");
		}
	}

	function changeNescau(elem){
		var arrow = elem.querySelector('img');
		var page = document.querySelector('#nescau');

		if (page.style.height == "0px") {
			// page.style.opacity = 1;
			page.style.height = "1300px";
			alert("something");
		} else {
			// page.style.opacity = 0;
			page.style.height = "0px";
			alert("something else");
		}
	}

</script>

<script src="https://doity.com.br/js/box_inscricao.js" type="text/javascript"></script>


<div class="workshop">
	


	<!-- <a href="http://www.pacce.ufc.br/pacce/oficina/expopacce">ExpoPACCE</a> -->
	<a href="http://www.pacce.ufc.br/pacce/oficina/nescau">Oficinas PACCE NESCAU</a>

</div>




<!-- <div class="workshop"> -->
<!-- 	<button onclick="changeExpo(this)" class="btn_workshop"><p>ExpoPACCE</p> <img src="<?php echo URLBASE;?>images/next.svg"></button>
 -->	
			<!-- <iframe scrolling="0" id="iframe-inscricao" onload="iframeResizer(event)" style="width: 100%;height: 1000px;border: none;" src="https://doity.com.br/expopacce/passo1?box=1"> </iframe> <p style="text-align:center; color:#666672; font-size:14px; font-family:'Open Sans',Helvetica, Arial, sans-serif; font-weight:bolder;"> Caso n&atilde;o consiga fazer a inscri&ccedil;&atilde;o <a target="_blank" href="https://doity.com.br/expopacce">clique aqui </a> </p>   -->  
	
	
	<!-- <button onclick="changeNescau(this)" class="btn_workshop"><p>NESCAU</p> <img src="<?php echo URLBASE;?>images/next.svg"></button>
	
			<iframe scrolling="0" id="iframe-inscricao" onload="iframeResizer(event)" style="width: 100%;height: 1000px;border: none;" src="https://doity.com.br/oficinas-pacce-nescau/passo1?box=1"> </iframe> <p style="text-align:center; color:#666672; font-size:14px; font-family:'Open Sans',Helvetica, Arial, sans-serif; font-weight:bolder;"> Caso n&atilde;o consiga fazer a inscri&ccedil;&atilde;o <a target="_blank" href="https://doity.com.br/oficinas-pacce-nescau">clique aqui </a> </p>
	
</div> -->
      



        
 