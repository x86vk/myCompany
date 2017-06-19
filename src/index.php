<?php
	require_once(dirname(__FILE__).'/config.php');
	require_once(WebRoot.'/login/loginLib.php');
	
	if (isLogin()) {
		if (getUserType()==TypeAdmin){
			Header("Location: ".WebUrl."/admin/index.php");
		}
		if (getUserType()==TypeTeacher){
			Header("Location: ".WebUrl."/commission/index.php");
		}
		if (getUserType()==TypeStudent || getUserType()==HourEmp){
			echo getUserType()."fuck\n";
			Header("Location: ".WebUrl."/employee/index.php");
		}
	}
?>