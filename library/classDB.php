<?php

include('traiters.php');

	class dbQuery
	{
		//use helperDB; //{helperDB::_GetHTMLTable2 as GHT;}

		public  $resultQuery;
		public  $useTransaction = false;
		public  $timeExecSQL;

		private $connect_db;
		private $connected = false;
		private $config_db;
		private $textQuery;
		private $patternUUID = '00000000-0000-0000-0000-000000000000';

		public function __construct($strQuery = null) {
			
			include($_SERVER['DOCUMENT_ROOT'].'/maximus/php/config_db.php');

			$this->config_db = ['serverDB' => $serverDB,
								'loginDB'  => $loginDB,
								'passDB'   => $passDB,
								'nameDB'   => $nameDB];

			$this->textQuery = $strQuery;
		}
		
		public function __toString() {
			
			$textHTML = '<br>
						 <table border = "1" width="350" style="border-collapse:collapse;">
						 <caption>Класс: <b>dbQuery</b></caption>
							 <tr>
							 	<th>Параметр</th>
							 	<th>Значение</th>
							 </tr>
							 <tr>
							 	<td>BackEnd</td>
							 	<td>Голубенко Максим</td>
							 </tr>
							 <tr>
							 	<td>FrontEnd</td>
							 	<td>Пальчиков Иван</td>
							 </tr>
							 <tr>
							 	<td>Назначение</td>
							 	<td>Выполнение запросов SQL<br>
							 		Смотри описание:<br>
							 		$a = new dbQuery();<br>
							 		$a.Help();
							 	</td>
							 </tr>
					 	 </table><br>
					 	';

			return $textHTML;
		}

		public function SetParams($arr) {

			foreach ($arr as $key => $value) {
				$this->textQuery = str_replace(':'.$key, $value, $this->textQuery);
			}
		}

		public function GetQueryText() {
			return ($this->textQuery);
		}

		public function SetQueryText($strQuery) {
			$this->textQuery = $strQuery;
		}

		public function commit() {
			
			if ($this->useTransaction === false) {
				exit;
			}
			
			mysqli_commit($this->connect_db);
			mysqli_close($this->connect_db);
			$this->connected = false;
		}
		
		public function rollback() {
			
			if ($this->useTransaction === false) {
				exit;
			}
			
			mysqli_rollback($this->connect_db);
			mysqli_close($this->connect_db);
			$this->connected = false;

		}

		public function ExecQuery($smallQueryText = null, $params = null) {
			
			if (!is_null($smallQueryText)) {
				$this->textQuery = $smallQueryText;
			}

			if (is_null($this->textQuery)) {
				echo 'Запрос пустой!';
				exit;
			}

			if ($this->connected === false) {
				$this->connect_db = mysqli_connect(
										$this->config_db['serverDB'],
										$this->config_db['loginDB'],
										$this->config_db['passDB'],
										$this->config_db['nameDB']
									);

				if($this->connect_db === false) {
					$this->connected = false;
					echo 'Error connect DB!';
					exit;
				}

				$this->connected = true;
			}

			mysqli_autocommit($this->connect_db, !$this->useTransaction);
			
			if (!is_null($params)) {
				$this->SetParams($params);
			}

			$startExecSQL = microtime(true);

			mysqli_set_charset($this->connect_db, "UTF-8");
			$result = mysqli_query($this->connect_db, $this->textQuery);
			
			if ($this->useTransaction === false) {
				mysqli_close($this->connect_db);
			}
			
			$endExecSQL = microtime(true);

			$this->timeExecSQL = $endExecSQL - $startExecSQL;

			if($result === true || $result === false) {
				$this->resultQuery = $result;
				return $this->resultQuery;
			} else {
				$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
				$this->resultQuery = $row;
				return $this->resultQuery;
			}
		}
		
		public function GetNewUUID($idMask = null) {
			
			if(is_null($idMask)){
				$idMask = $this->patternUUID;
			}
			
			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
			
			$result = '';
			for ($i = 0; $i < strlen($idMask); $i++) {
				if ($idMask[$i] == '0') {
					$result .= $characters[mt_rand(0, 34)];
				} else {
					$result .= "-";
				}
			}
			
			return $result;
		}

		public function GetEmptyUUID() {
			return $this->patternUUID;
		}

		public function ViewHTMLTable() {
			//$textHTML = $this->_GetHTMLTable($this->textQuery, $this->resultQuery, $this->timeExecSQL);
			//echo $textHTML;
		}

		public function help() {
			include('classtest1read.txt');
			echo $a;
		}

	}
?>