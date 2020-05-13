<?php 
	
	//Diz para o Sistema em qual semana está
	function GetSemana(){
		$date = date('Y-m-d H:i:s');

		$query = DBread('calendario_2016', null);
		//$result = $query[0]['semana'];
		for ($i=0; $i < count($query); $i++) { 
			$inicio = date('Y-m-d H:i:s', strtotime($query[$i]['inicio']));
			$fim 	= date('Y-m-d H:i:s', strtotime($query[$i]['fim']));
			
			if (strtotime($inicio) <= strtotime($date)) {
			 	if (strtotime($date) <= strtotime($fim)) {
			 	 	$result = $query[$i]['semana'];
			 	 	
			 	}
			}
		}

		return ((isset($result)) ? $result : 40);
		
	}

	//Recuperar Dados do Usuario
	function GetUser($key = null){
		if(!IsLogged()){
			return false;
		}else{
			$npacce = UserLog();
			$result = DBread('bolsistas', "WHERE npacce = '$npacce' AND status = true LIMIT 1");

			if($key == null)
				return $result;
			else{
				if(isset($key))
				 	return $result[0][$key];
				else
					return false;
			}
		}
	}

	//Verifica Usuario Logado
	function StayLogged(){
		$userKey = UserLog();
		$result  = DBread('bolsistas', "WHERE npacce = '$userKey' AND status = true");
		
		if($result)
			return true;
		else
			return false; 
	}

	// Recupera Número Pacce
	function GetKey($npacce, $password){
		$dataKey = userVerify($npacce, $password);
		return $dataKey[0]['npacce'];
	}

	/////////////////////////////////////////////////
	// Ganbiarra!!!!
	/////////////////////////////////////////////////
	//Verifica Usuario sem verificar status
	function userSemStatus($npacce, $password){
		$result = DBread('bolsistas', "WHERE npacce = '$npacce' AND password = '".md5($password)."' OR cpf = '$npacce' AND password = '".md5($password)."'");
		if(!$result)
			return false;
		else
			return true;
	}

	//Verifica Usuario com Status
	function userVerify($npacce, $password, $status = false){
		
		$result = DBread('bolsistas', "WHERE npacce = '$npacce' AND password = '".md5($password)."' OR cpf = '$npacce' AND password = '".md5($password)."'");

		if(!$result){
			return false;
		}else{
			$verificaStatus = $result[0]['status'];
			if($verificaStatus == 0){
				return false;
			}else{
				return $result;
			}
		}
	}
	/////////////////////////////////////////////////
	// Ganbiarra!!!!
	/////////////////////////////////////////////////

	//Deletar 
	function DBDelete($table, $where = null){
		$table 	= PREFIX.'_'.$table;
		$where  = ($where) ? " WHERE {$where}" : null;

		$query = "DELETE FROM {$table}{$where}";
		return DBexecute($query);

	}
	//Alterar valor
	function DBUpDate($table, array $data, $where = null, $insertId = false){
		foreach ($data as $key => $value) {
			$filtro[] = "{$key} = '{$value}'";
		}
		$filtro = implode(", ", $filtro);

		$table 	= PREFIX.'_'.$table;
		$campo 	= $data;
		$where  = ($where) ? " WHERE {$where}" : null;
		
		$query = "UPDATE {$table} SET {$filtro}{$where}";
		return DBexecute($query, $insertId);
	}

	//Selecionar no banco de bados
	function DBread($table, $params = null, $fields = '*'){
		$table 	= PREFIX.'_'.$table;
		$params = ($params) ? " {$params}" : null;
		$query 	= "SELECT {$fields} FROM {$table}{$params}";
		$result = DBexecute($query);

		if (!mysqli_num_rows($result)) {
			return false;	
		}else{
			while ($res = mysqli_fetch_assoc($result)) {
				$data[] = $res;
			}
			return $data;
		}
		
	}
	
	//gravar no banco
	function DBcreate($table, array $data, $insertId = false){
		$table 	= PREFIX.'_'.$table;
		$data 	= DBescape($data);
		$campos = implode(", ", array_keys($data));
		$valors = "'".implode("', '", $data)."'";

		$query 	= "INSERT INTO {$table} ({$campos}) VALUES ({$valors})";

		return DBexecute($query, $insertId);
	}

	//Execute query -> banco de dados
	function DBexecute($query, $insertId = false){
		$link = DBconnec();
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		if($insertId){
			$result = mysqli_insert_id($link);
		}
		DBclose($link);

		return $result;
	}
	
	

?>