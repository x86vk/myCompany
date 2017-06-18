<?

	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
    require_once(dirname(__FILE__).'/../recordpay.php');
    $Name=$_POST["client_name"];
	$telephone=$_POST["telephone"];
    $address=$_POST["address"];
    $date=$_POST["date"];
    $pid=$_POST["pid"];
    $state=$_POST["state"];
    $oid=$_POST["oid"];
    if ($database->has("purchase_order",["oid"=>$oid])){
        $user = $database->get("purchase_order","user",["oid"=>$oid]);
        if ($state == "close"){
            $cost = $database->get("product","product_cost",["id"=>$pid]);
            updateSales($database,$user,$cost);
        }
        echo $database->update("purchase_order",["client_name"=>$Name,
                                                 "telephone"=>$telephone,
                                                 "address"=>$address,
                                                 "pid"=>$pid,
                                                 "date"=>$date,
                                                 "state"=>$state],["oid"=>$oid]);
    }
    else{
        echo -1;
    }
	
?>