<?php 
    $foto = DBread('bolsistas', "WHERE npacce = '".$selecComent[$i]['npacce']."'", "foto, id");
?>
<div id="boxComent">
	<img src="<?php echo URLBASE; ?>login/users/imagensBolsistas/<?php echo $foto[0]['foto']; ?>" width="80" height="80">
    <div>
        <strong>Nome:</strong>  <?php echo GetName($selecComent[$i]['nome'], 1); ?> 
        <strong>   Tipo:</strong>
        <?php echo $selecComent[$i]['tipo']; ?>  
        <br>comentou em 
        <strong>data:</strong>  <?php echo date('d-M-Y', strtotime($selecComent[$i]['data'])); ?> <strong>ás</strong> 
        <strong>hora:</strong>  <?php echo date('H:i:s', strtotime($selecComent[$i]['data'])).'hr'; ?>
        <p><?php echo printPost($selecComent[$i]['comentario'], 'page');?></p>
        
    </div>
    <?php 
            if(IsLogged() && $selecComent[$i]['npacce'] == $dadosUser[0]['npacce']){
        ?>
        <div id="opcoes">
            <a href="?acao=1&&id=<?php echo $selecComent[$i]['id'];?>">Deletar</a>  
            <div  class="commented" style="width: 110px;"><a>Editar Comentário</a></div>
            <form action="" method="post" name="form-coment" id="show-edit"> 

                <input  type="text" name="recoment" value="<?php echo $selecComent[$i]['comentario'];?>">
                <input type="text" name="id" value="<?php echo base64_encode($selecComent[$i]['id']);?>" style="display:none;">
                <input type="submit" name="editar" value="Enviar Comentário" style="display:none;">
            </form>
        </div>
        <?php
        }
        ?>
</div>
