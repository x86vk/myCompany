<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	
	$User=$_POST["user"];
	$Time=$_POST["time"];
    if ($database->has("employeetimecard",["id"=>$User])){
        echo $database->get("employeetimecard","uptime",[id=>$User]);
    }
    else{
        $database->insert("employeetimecard",["id"=>$User,"uptime"=>$Time]);
        echo 1;
    }

?>