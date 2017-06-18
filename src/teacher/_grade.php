<?
	$Subject=$_POST["subject"];
	$User=$_POST["user"];
	$name=$_POST["name"];
	$Sb_name=$_POST["sb_name"];
	$Score=$_POST["score"];
	$type=$_POST["type"];

	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");

	if (file_exists("../log/log_s.txt")){
	    $logfile = fopen("../log/log_s.txt", "a");
	} else{
	    $logfile = fopen("../log/log_s.txt", "w");
    }

	if (isLogin() && getUserType()==TypeTeacher){
		if ($type==3){
			echo $database->delete("grade",["AND" =>["user" => trim($User),'subject'=>trim($Subject)]]);
		}else if($type==2 || $type==1){
			$Old_score = $database->get("grade", "score", ["user" => $User]);
			if ($database->has("grade",["AND" =>["user" => trim($User),'subject'=>trim($Subject)]])){
				echo $database->update("grade",["score"=>$Score],["AND" =>["user" => trim($User),'subject'=>trim($Subject)]]);
			}else{
				echo $database->insert("grade",["user"=>$User,"subject"=>$Subject,"score"=>$Score]);
			}
	        if ($Old_score != $Score){
	            $time = $database->get("grade","time",["AND" =>["user"=>$User, 'subject'=>trim($Subject)]]);
	            $te_name=$database->get("user","name",["user"=>getUserID()]);
	            $text = $time."\t".$name."的".$Sb_name."工作时长被".$te_name."[委托员工]修改为".$Score."小时\r\n";
	            fwrite($logfile, $text);

	        }
		}
	}else{
		die("Access Denied.");
	}
	fclose($logfile);
	
?>