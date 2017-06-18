<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	
	$User=$_POST["user"];
	
    echo $database->get("user","type",["user" => $User]);
	
?>