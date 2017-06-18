<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
    $User=$_POST["user"];
    $Purchase_id=$_POST["purchase_id"];
    $JArray=Array();
    if ($database->has("purchase_order",["AND"=>["oid"=>$Purchase_id,"user"=>$User,"state"=>"open"]]))
	{
        $_purchase=$database->select("purchase_order","*",["oid"=>$Purchase_id]);
        foreach($_purchase as $purchase)
        {
        $JArray['#PClient_name'] = $purchase["client_name"];
        $JArray['#PTelephone'] = $purchase["telephone"];
        $JArray['#PAdress'] = $purchase["address"];
        $JArray['#PPid'] = $purchase["pid"];
        $JArray['#PDate'] = $purchase["date"];
        $JArray['#PUser'] = $purchase["user"];
        $JArray['#POid'] = $purchase["oid"];
        $JArray['#PState'] = $purchase["state"];
        }

        echo json_encode($JArray);
    }
    else{
        echo -1;
    }
?>