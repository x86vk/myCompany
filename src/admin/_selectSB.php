<?
	$Val=$_POST["val"];

	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");

	if (isLogin() && getUserType()==TypeAdmin){
		echo $database->update("select_sb",["val"=>$Val],[]);
	}else{
		die("Access Denied.");
	}

?>