<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	$user=$_POST["user"];
    $flag=$database->get("user","dimission",["user"=>$user]);
    if($flag==1){
        $tmp=0;
        $database->update("user",["dimission"=>$tmp],["user"=>$user]);
        echo 0;
    }
     else{
        $tmp=1;
        $database->update("user",["dimission"=>$tmp],["user"=>$user]);
        echo 1;
    }

?>