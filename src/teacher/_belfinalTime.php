<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
    require_once(dirname(__FILE__).'/../recordpay.php');
	$User=$_POST["user"];
	$BTime=$_POST["begintime"];
    $Time=$_POST["endtime"];
    $Name=$_POST["name"];
    $Project=$_POST["project"];
    if ($database->has("employeetimecard",["id"=>$User]))
    {
        $database->delete("employeetimecard",["id"=>$User]);
        $finaltime = (int)((strtotime($Time) - strtotime($BTime))/3600);
        if ($database->has("grade",["AND"=>["user"=>$User,"subject"=>$Project]]))
        {
            $score = $database->get("grade","score",["user"=>$User]);
            $finaltime = $score + $finaltime;
            $database->update("grade",["score"=>$finaltime],["user"=>$User]);
        }
        else
        {
            $database->insert("grade",["user"=>$User,"subject"=>$Project,"score"=>$finaltime]);
        }
        $finaltime = 9;
        if ($finaltime >8)
        {
            $normaltime = 8;
            $extratime = $finaltime - 8;
        }
        else
        {
            $normaltime = $finaltime;
            $extratime = 0;
        }
        updateTimeard($database,$User,$normaltime,$extratime);
        $datatime = new DateTime($BTime);
        $ID = $datatime->format('Y-m-d H:i:s').$User;
        echo $database->insert("AllTimecard",["id"=>$ID,"user"=>$User,"name"=>$Name,"uptime"=>$BTime,"downtime"=>$Time,"project"=>$Project]);
    }

?>