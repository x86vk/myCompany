<?
	$Subject=$_POST["subject"];
	$User=$_POST["user"];
	$Score=$_POST["score"];
	$type=$_POST["type"];

	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	if (isLogin() && getUserType()==TypeTeacher){
		if ($type==3){
			echo $database->delete("grade",["AND" =>["user" => trim($User),'subject'=>trim($Subject)]]);
		}else if($type==2 || $type==1){
			if ($database->has("grade",["AND" =>["user" => trim($User),'subject'=>trim($Subject)]])){
				echo $database->update("grade",["score"=>$Score],["AND" =>["user" => trim($User),'subject'=>trim($Subject)]]);
			}else{
				echo $database->insert("grade",["user"=>$User,"subject"=>$Subject,"score"=>$Score]);
			}
		}
	}else{
		die("Access Denied.");
	}
	
?>