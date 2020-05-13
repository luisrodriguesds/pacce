<?php 
if (isset($_POST['alterar'])) {
		if(empty(GetPost('senha-antiga'))){
			echo '<script>alert("Campo Senha Atual está vazio!");</script>';
		}else if(empty(GetPost('senha-nova'))){
			echo '<script>alert("Campo Nova senha está vazio!");</script>';
		}else if(empty(GetPost('re-senha-nova'))){
			echo '<script>alert("Campo Confirmar senha está vazio!");</script>';
		}else if(GetPost('senha-nova') != GetPost('re-senha-nova')){
			echo '<script>alert("As senhas informadas não correspondem!");</script>';
		}else{
			$senhaAtual = md5(GetPost('senha-antiga'));
			if(DBread('bolsistas', "WHERE npacce = '".$dataUser[0]['npacce']."' AND password = '$senhaAtual'")){
				$senha['password'] = md5(GetPost('senha-nova'));
				if(DBUpDate('bolsistas', $senha, "npacce = '".$user['npacce']."'")){
					echo '
		                 <script>
		                  alert("Senha alterada com sucesso!!");
		                    window.location="'.$way.'";
		                  </script>';
				}
			}else{
				echo '<script>alert("A senha que foi informada não é correspondente a senha atual!");</script>';
			}
		}
	}
?>
<div class="title"><h2>Alterar Senha</h2></div>
<div id="editar-ativ" class="form">
	<form action="" method="post" enctype="multipart/form-data">
		<label>Senha Atual:</label><br>
		<input type="password" name="senha-antiga" placeholder="Digite sua senha atual"></input><br><br>
		<label>Nova senha:</label><br>
		<input type="password" name="senha-nova" minlength="6" onpaste="return false" placeholder="Digite um nova senha"></input><br><br>
		<label>Confirmar senha:</label><br>
		<input type="password" name="re-senha-nova" minlength="6" onpaste="return false" placeholder="Redigite sua nova senha"></input><br><br>
		<center>
		<input type="submit" value="Alterar" name="alterar"></input>
		</center>
	</form>
</div>