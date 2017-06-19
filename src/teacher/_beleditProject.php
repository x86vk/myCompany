<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	
	$User=$_POST["user"];
	$Project=$_POST["project"];
    if ($database->has("employeetimecard",["id"=>$User])){
        echo $database->update("employeetimecard",["project"=>$Project],["id"=>$User]);
    }
    else{
        echo -1;
    }

?>