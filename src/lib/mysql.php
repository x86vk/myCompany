<?php
	require("medoo.php");
	$database = new medoo([
		'database_type' => 'mysql',
		'database_name' => 'grade',
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'charset' => 'utf8',
		'port' => 3306,
	]);

?>