<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/reportLib.php");
	require_once(WebRoot."/lib/mysql.php");
	
	$type=$_POST["type"];

	if($type==1){
		$user=$_POST["user"];
		$name=$_POST["name"];
		$re_begin=$_POST["re_begin"];
	    $re_end=$_POST["re_end"];
	    $re_name=$_POST["re_name"];
	    $re_path=$_POST["re_path"];

		$report = new reportGenereator();
		$report->init($user, $name, $re_begin, $re_end, $re_name);


		$report->insert_table_head("开始时间", "结束时间", "项目");//["user" => $user]

		$userArray=$database->select("AllTimecard",["uptime","downtime","project"],["user" => $user]);
		foreach($userArray as $nowUser){
			if($re_begin<=$nowUser["uptime"] && $re_end>=$nowUser["downtime"]){
				$project_name=$database->get("subject", "name", ["id" => $nowUser["project"]]);
				$report->insert_table_col($nowUser["uptime"], $nowUser["downtime"], $project_name);
			}
		}
		
		//$report->insert_table_col("2019", "100元");
		$report->end_table(date('Y-m-d H:i:s',time()), "你工资真是太低了");
		$report->output_html("./".$name."work_report.html");
		echo 1;
	}
	else if($type==2){
		$user=$_POST["user"];
		$name=$_POST["name"];
		$re_begin=date('Y',time());
		$re_begin.='-01-01';
		$re_begin=strtotime($re_begin);
		$re_begin=date('Y-m-d',$re_begin);
		$re_end=date('Y-m-d H:i:s',time());
	    $re_name=$_POST["re_name"];
	    $re_path=$_POST["re_path"];

		$report = new reportGenereator();
		$report->init($user, $name, $re_begin, $re_end, $re_name);

		$report->insert_table_head("发放工资时间", "工资金额");//["user" => $user]

		$userArray=$database->select("year-to-date",["date","pay"],["ID" => $user]);
		foreach($userArray as $nowUser){
			if($re_begin<=$nowUser["date"] && $re_end>=$nowUser["date"]){
				//$project_name=$database->get("Subject", "name", ["id" => $nowUser["project"]]);
				$report->insert_table_col($nowUser["date"], $nowUser["pay"]);
			}
		}
		
		$report->end_table(date('Y-m-d H:i:s',time()), "你工资真是太低了");
		$report->output_html("./".$name."pay_report.html");
		echo 2;	
	}
	echo 0;
?>
