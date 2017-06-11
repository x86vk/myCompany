<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");

?>
<!DOCTYPE html>
<html>
  <head>		
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="../asset/materialize/css/materialize.min.css"  media="screen,projection"/>
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>管理员-学生成绩管理系统</title>
  <link rel="shortcut icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" size="32x32">
  <link rel="icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" sizes="32x32">
	</head>

  <body class=" grey lighten-3">
  <nav>
    <div class="nav-wrapper blue" >
    <a href="#" class="brand-logo center">管理员</a>
    <ul id="nav-moblie" class="left hide-on-med-and-down">
		<li><a href="subject.php">修改项目</a></li>
		<li><a href="user.php">修改用户</a></li>
	</ul>
	<ul id="nav-moblie" class="right hide-on-med-and-down">
		<li><a href="../login/index.php" onClick="delAllCookie();">登出</a></li>
	</ul>
	</div>
  </nav>
  <div class="container">
    <div class="row">
      <h1 class="center">您好，以下为最新的动向。</h1>
	  <br>
	  </div>
    <ul class="collapsible popout" data-collapsible="accordion">
    <?
    $handle = @fopen(WebRoot."/log/log_s.txt", "r");
    if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        if($buffer == "") {
          break;
        }
        unset($output);
        //$ret = exec("echo '".$buffer."' | "."awk -F ' ' '{print $3;} '", $output, $var);
        ?>
        <li>
        <div class="collapsible-header"><i class="material-icons">mode_edit</i>
        <?//echo $output[0];?>
        </div>
        <div class="collapsible-body grey lighten-4"><p>
        时间:<?
        unset($output);
       // $ret = exec("echo '".$buffer."' | "."awk -F ' ' '{print $1 \" \" $2;} '", $output, $var);
        //echo $output[0];
        ?></p>
    <?}?>
   <? fclose($handle);
}
    ?>

    <?
    /*
    $handle = @fopen(WebRoot."/log/log_info.txt", "r");
    if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        if($buffer == "") {
          break;
        }
        unset($output);
        $ret = exec("echo '".$buffer."' | "."awk -F ' ' '{print $3;} '", $output, $var);
        ?>
        <li>
        <div class="collapsible-header"><i class="material-icons">lock outline</i>
        <?echo $output[0];?>
        </div>
        <div class="collapsible-body grey lighten-4"><p>
        时间:<?
        unset($output);
        $ret = exec("echo '".$buffer."' | "."awk -F ' ' '{print $1 \" \" $2;} '", $output, $var);
        echo $output[0];
        ?></p>
    <?}?>
   <? fclose($handle);
}*/
    ?>

    </ul>
  </div>
  
  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="../asset/js/jquery.js"></script>
  <script type="text/javascript" src="../asset/materialize/js/materialize.min.js"></script>  
  <script type="text/javascript">
    function delAllCookie(){    
        $.post("../login/loginLib.php",
			{
				"logout":true
			},
			function(data,status){
				window.location.href="";
			});  
      } 
  </script>
  </body>
</html>