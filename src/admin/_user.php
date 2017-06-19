<?
	$user=$_POST["user"];
	if (isset($_POST["password"])) $password=$_POST["password"];
	if (isset($_POST["type"]))$type=$_POST["type"];
	if (isset($_POST["name"]))$name=$_POST["name"];
	if (isset($_POST["phone"]))$phone=$_POST["phone"];

	if (isset($_POST["mails"]))$mails=$_POST["mails"];
	if (isset($_POST["tax_deductions"]))$tax=$_POST["tax_deductions"];
	if (isset($_POST["other_deductions"]))$other=$_POST["other_deductions"];
	if (isset($_POST["hourly_rate"]))$hourly_rate=$_POST["hourly_rate"];
	if (isset($_POST["salary"]))$salary=$_POST["salary"];
	if (isset($_POST["com_rate"]))$com_rate=$_POST["com_rate"];
	if (isset($_POST["hour_limit"]))$limit=$_POST["hour_limit"];
	if (isset($_POST["pay_method"]))$pay_method=$_POST["pay_method"];

	/*
	              "mails": $("#New_mail").val(),
              "tax_deductions": $("#New_tax").val(),
              "other_deductions": $("#New_otherDe").val(),
              "hourly_rate": $("#New_hour").val(),
              "salary": $("#New_salary").val(),
              "com_rate": $("#New_comRate").val(),  
              "hour_limit": $("#New_limit").val(),  
    */


	$Etype=$_POST["Etype"];

	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
	if (isLogin() && getUserType()==TypeAdmin){
		if ($Etype==3){
			echo $database->delete("user",["user"=>$user]);
		}else if($Etype==2){
			$ok=$database->insert("user",["user"=>$user,"name"=>$name,"password"=>$password,"type"=>$type,"phone"=>$phone,"mails"=>$mails,"tax_deductions"=>$tax,"other_deductions"=>$other,"hourly_rate"=>$hourly_rate,"salary"=>$salary,"com_rate"=>$com_rate,"hour_limit"=>$limit,"payment_method"=>$pay_method,"cookie"=>"?"]);
			if($ok==0){
				$num=GetUsernum();
				//function createEmployeeRecord($database, $ID){}
    			$database->insert("employee",["ID"=>$user]);
				echo $database->update("user",["number"=>$num],["user"=>$user]);
			}
			else echo $ok;

		}else if($Etype==1){
			echo $database->update("user",["name"=>$name,"password"=>$password,"type"=>$type,"phone"=>$phone,"payment_method"=>$pay_method],["user"=>$user]);
		}
	}else{
		die("Access Denied.");
	}
	
?>