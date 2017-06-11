<?
	$Name=$_POST["name"];
	$telephone=$_POST["telephone"];
    $address=$_POST["address"];
    $date=$_POST["date"];
    $pid=$_POST["pid"];
    $user=$_POST["user"];
    $datetime=$_POST["datetime"];
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
    $ID = $user.$datetime;
    if ($database->has("product",["id"=>$pid]))
    {
        echo $database->insert("purchase_order",["client_name"=>$Name,
                                                 "telephone"=>$telephone,
                                                     "address"=>$address,
                                                     "date"=>$date,
                                                     "pid"=>$pid,
                                                     "oid"=>$ID,
                                                     "user"=>$user,
                                                     "state"=>"open"]);
    }
    else{
        echo -1;
    }
	
	
?>