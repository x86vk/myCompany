<?
	$Id=$_POST["id"];
	$Name=$_POST["name"];
	$GPA=$_POST["GPA"];
	$type=$_POST["type"];

	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	if (isLogin() && getUserType()==TypeAdmin){
		if ($type==3){
			echo $database->delete("subject",["id"=>$Id]);
		}else if($type==2){
			echo $database->insert("subject",["name"=>$Name,"GPA"=>$GPA]);
		}else if($type==1){
			echo $database->update("subject",["name"=>$Name,"GPA"=>$GPA],["id"=>$Id]);
		}
	}else{
		die("Access Denied.");
	}
	
?>