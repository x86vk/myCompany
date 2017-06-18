<?
	require_once("loginLib.php");
	
	$User=$_POST["User"];
	$Password=$_POST["Password"];

	echo login($User,$Password);
?>