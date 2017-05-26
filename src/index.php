<?php
	require_once(dirname(__FILE__).'/config.php');
	require_once(WebRoot.'/login/loginLib.php');
	
	if (isLogin()) {
		if (getUserType()==TypeAdmin){
			Header("Location: ".WebUrl."/admin/index.php");
		}
		if (getUserType()==TypeTeacher){
			Header("Location: ".WebUrl."/teacher/index.php");
		}
		if (getUserType()==TypeStudent){
			Header("Location: ".WebUrl."/student/index.php");
		}
	}
?>