<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="google" content="notranslate">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>php_test</title>
</head>
<body>
	<?php


		// $token = $_POST['token'];
		// echo $token;
		// echo '<br>';
		$ccc = getallheaders();
		echo '<br>';


		echo json_encode($ccc);
		echo '</br>';
		echo md5(json_encode($ccc));


		// Мой класс для работы с запросами
		// Подключение файла для использования класса/ов
		require_once './library/classDB.php';


		//$sqlText = 'select * from jrn_alldoc';
		//$cl = new dbQuery($sqlText);
        

		
		
		/******************************************** *
		// использование транзакций
		$db = new dbQuery();
		$db->useTransaction = true;

		// 1-й запрос, вариант вызова
		$db->SetQueryText('
			INSERT INTO table1 (id, naim)
			VALUES (:id, ":naim")
		');

		$params['id'] = 100;
		$params['naim'] = 'xxx-fff-zzz';
		//$db->SetParams($params);

		$db->ExecQuery(null,$params);
		$res1 = $db->resultQuery;

		// 2-й запрос, вариант вызова,
		// короткий запрос сразу передаем в execQuery
		$res2 = $db->ExecQuery('INSERT INTO table1 (id, naim) VALUES (:id, ":naim")', $params);
		// $db->resultQuery;

		if($res1 !== false && $res2 !== false){
			$db->commit();
			echo 'commit - vsyo zaebis'
		} else {
			$db->rollback();
			echo 'Error_PROCTO_PIZDECZ!!';
		}
		/******************************************** */
	

		/******************************************** */
		// без использования транзакций

		// 1-й запрос, вариант вызова
		
		
		//echo $db->GetNewUUID();
		//echo $db->GetNewUUID('000-000-000');
		
		// $db->SetQueryText('
		// 	INSERT INTO table1 (id, naim)
		// 	VALUES (:id, ":naim")
		// ');
		$query = "INSERT INTO table1 (id, naim)
				  VALUES (:id, ':naim')
				 ";
		
		$db = new dbQuery($query);

		$params['id'] = $db->GetNewUUID();
		$params['naim'] = 'i am not speack english';
		
	
		// Можно метод не использовать, а сразу передать во второй
		// параметр ExecQuery
		 //$db->SetParams($params);

		//$db->ExecQuery();
		//$res1 = $db->resultQuery;

		echo $db;
		echo $db;
		/******************************************** */
		


		//$db->rollback();
		
		//echo $db->ViewHTMLTable();
		//$db->help();
		//echo $db;

		/*****************************************************************************
		$sqlText = 'select * from core_objects';
		
		$cl = new dbQuery($sqlText);
		//$cl->debug = true;

		//$cl->GetHTMLTable();
		$cl->help();
		/*****************************************************************************/


		/*****************************************************************************/
		// Вариант 2
		


		/*****************************************************************************
		$sqlText = '
			SELECT
				*
			FROM core_objects
			WHERE id = ":id" AND
			uid = ":uid";
		';

		$cl = new dbQuery($sqlText);

		$params['id'] = '100';
		$params['uid'] = 'xxx-fff-zzz';
		$cl->SetParams($params);
		
		echo '<br>';
		echo $a;
		//$cl->GetQuery();
		/*****************************************************************************/
		
		// Мой класс для работы с запросами
		// КОНЕЦ //


	?>

</body>
</html>