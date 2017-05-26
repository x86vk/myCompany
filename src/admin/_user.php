<?
	$user=$_POST["user"];
	if (isset($_POST["password"])) $password=$_POST["password"];
	if (isset($_POST["type"]))$type=$_POST["type"];
	if (isset($_POST["name"]))$name=$_POST["name"];
	if (isset($_POST["phone"]))$phone=$_POST["phone"];
	$Etype=$_POST["Etype"];

	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	if (isLogin() && getUserType()==TypeAdmin){
		if ($Etype==3){
			echo $database->delete("user",["user"=>$user]);
		}else if($Etype==2){
			echo ($database->insert("user",["user"=>$user,"name"=>$name,"password"=>$password,"type"=>$type,"phone"=>$phone,"cookie"=>"?"]));
		}else if($Etype==1){
			echo $database->update("user",["name"=>$name,"password"=>$password,"type"=>$type,"phone"=>$phone],["user"=>$user]);
		}
	}else{
		die("Access Denied.");
	}
	
?>