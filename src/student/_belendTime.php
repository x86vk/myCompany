<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	
	$User=$_POST["user"];
	$Time=$_POST["time"];
    $Project=$_POST["project"];
    $JArray=Array();
    if ($database->has("employeetimecard",["id"=>$User])){
        $JArray['#END_BTime'] = $database->get("employeetimecard","uptime",["id"=>$User]);
        $JArray['#END_pname'] = $database->get("subject","name",["id"=>$Project]);
    }
    echo json_encode($JArray);
?>