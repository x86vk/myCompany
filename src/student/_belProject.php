<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	
	$User=$_POST["user"];
	
	$nowSubjectArray=$database->select("subject",["id"],[]);
	
	$JArray=Array();
	
	foreach($nowSubjectArray as $nowSubject){
			$JArray['#Subject-'.$nowSubject["id"]]=0;
	}
	
	echo json_encode($JArray);
?>