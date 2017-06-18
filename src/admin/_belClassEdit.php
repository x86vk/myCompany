<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	
	$User=$_POST["user"];
	$nowSubjectArray=$database->select("class",["id"],[]);
	
	foreach($nowSubjectArray as $nowSubject){
		$tmpId="Class-".$nowSubject["id"];
		if ($_POST[$tmpId]=="true"){
			echo $nowSubject["id"]."Have\n";
			if ($database->has("classBel",["AND"=>["user"=>$User,"class"=>$nowSubject["id"]]])){
				
			}else{
				echo $database->insert("classBel",["user"=>$User,"class"=>$nowSubject["id"]]);
			}
		}else{
			echo $nowSubject["id"]."Didn't Have\n";
			if ($database->has("classBel",["AND"=>["user"=>$User,"class"=>$nowSubject["id"]]])){
				echo $database->delete("classBel",["AND"=>["user"=>$User,"class"=>$nowSubject["id"]]]);
			}else{

			}
		}
	}
?>