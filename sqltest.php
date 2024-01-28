<?php
	try {
		$dbh = new pdo('mysql:host=127.0.0.1:3306;dbname=m3t-web', 'eagle', 'EagleEye11213', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		die(json_encode(array('outcome' => true)));	
	}
	catch(PDOException $ex){
		die(json_encode(array('outcome' => false, 'message' => "Unable to connect!")));
	}
?>