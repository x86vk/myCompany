<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	
	$User=$_POST["user"];
	
	$nowSubjectArray=$database->select("class",["id"],[]);
	
	$JArray=Array();
	
	foreach($nowSubjectArray as $nowSubject){
		if ($database->has("classBel",["AND"=>["user"=>$User,"class"=>$nowSubject["id"]]])){
			$JArray['#Class-'.$nowSubject["id"]]=1;
		}else{
			$JArray['#Class-'.$nowSubject["id"]]=0;
		}
	}
	
	echo json_encode($JArray);
?>