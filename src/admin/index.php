<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
  $selectOK = $database->get("select_sb","val",[]);
?>
<!DOCTYPE html>
<html>
  <head>		
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="../asset/materialize/css/materialize.min.css"  media="screen,projection"/>
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>管理员-ACME公司管理系统</title>
  <link rel="shortcut icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" size="32x32">
  <link rel="icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" sizes="32x32">
	</head>

  <body class=" grey lighten-3">
  <ul id="slide-out" class="side-nav">
    <li><div class="userView">
      <div class="background">
        <img src="../images/office.jpg">
      </div>
      <a href="#!user"><img class="circle" src="../images/g.jpg"></a>
      <a href="#!name"><span class="white-text name">管理员</span></a>
      <a href="#!email"><span class="white-text email">ACME网络有限公司</span></a>
    </div></li>
    <li><a href="user.php"><i class="material-icons">assignment_ind</i>修改用户</a></li>
    <li><a href="subject.php"><i class="material-icons">recent_actors</i>修改项目</a></li>
    <li><a href="report.php"><i class="material-icons">open_in_browser</i>打印报告</a></li>
    <li><div class="divider"></div></li>
    <li><a class="waves-effect" href="index.php"><i class="material-icons">store</i>主页面</a></li>
    <li><a href="#" onClick="showSettings();"><i class="material-icons">settings</i>设置</a></li>
    <li><a href="../login/index.php" onClick="delAllCookie();"><i class="material-icons">replay</i>登出</a></li>
  </ul>
  
  <nav>
    <div class="nav-wrapper blue">
    <a href="#" class="brand-logo center"><i class="material-icons">supervisor_account</i>管理员</a>
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
        $ret = exec("echo '".$buffer."' | "."awk -F ' ' '{print $3;} '", $output, $var);
        ?>
        <li>
        <div class="collapsible-header"><i class="material-icons">mode_edit</i>
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
}
    ?>

    <?

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
   }
    ?>

    </ul>
  </div>

<div id="settings" class="modal">
  <div class="modal-content">
    <h4 class="center">设置</h4>
    <div class="row">
      <form class="col s10 offset-s1">
        <div class="row">
          <div class="col s8">
              <p>允许员工自由选项目</p>
          </div>
            <div class="switch">
                <label>
                不允许
                <input id="selectCourse" type="checkbox" <?
                if ($selectOK) {
                    echo 'checked="checked"';
                }
                ?>>
                <span class="lever"></span>
                允许
                </label>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col s7 offset-s1">
            <p>当前缓存文件大小：<?
            unset($output);
            $ret = exec("du -sbch /var/www/html/Grade/log | awk '{print $1}'", $output, $var);
            echo $output[0];
            ?></p>
            </div>
            <a class="waves-effect waves-light btn" onClick="clearLog()">删除缓存文件</a>
        </div>
      </form>
    </div>
  </div>
</div>

  <div class="fixed-action-btn" style="bottom: 48px; right: 24px;">
    <a href="#" data-activates="slide-out" class="button-collapse top-nav full modal-trigger btn-floating btn-large waves-effect waves-light orange"><i class="material-icons">menu</i></a>
    </div>
  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="../asset/js/jquery.js"></script>
  <script type="text/javascript" src="../asset/materialize/js/materialize.min.js"></script>  
  <script type="text/javascript">
    $(document).ready(function(){
      $('.modal').modal();
      $(".button-collapse").sideNav();
    });
    function showSettings() {
          $("#settings").modal("open");
    } 
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