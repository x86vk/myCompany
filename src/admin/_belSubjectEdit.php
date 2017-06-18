<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	
	$User=$_POST["user"];
	$nowSubjectArray=$database->select("subject",["id"],[]);
	
	foreach($nowSubjectArray as $nowSubject){
		$tmpId="Subject-".$nowSubject["id"];
		if ($_POST[$tmpId]=="true"){
			echo $nowSubject["id"]."Have\n";
			if ($database->has("subjectBel",["AND"=>["user"=>$User,"subject"=>$nowSubject["id"]]])){
				
			}else{
				echo $database->insert("subjectBel",["user"=>$User,"subject"=>$nowSubject["id"]]);
			}
		}else{
			echo $nowSubject["id"]."Didn't Have\n";
			if ($database->has("subjectBel",["AND"=>["user"=>$User,"subject"=>$nowSubject["id"]]])){
				echo $database->delete("subjectBel",["AND"=>["user"=>$User,"subject"=>$nowSubject["id"]]]);
			}else{
				//$database->insert("subjectBel",["user"=>$User,"subject"=>$nowSubject["id"]]);
			}
		}
	}
?>