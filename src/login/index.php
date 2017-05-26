<?
	require_once(dirname(__FILE__).'/../config.php');

?>




<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8" />
  <title>登录-学生成绩管理系统</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
 <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700|Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="../css/login.css">
   
  <link rel="shortcut icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" size="32x32">
  <link rel="icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" sizes="32x32">
</head>

<!-- BEGIN BODY -->
<body class="login login-background">
 
 <div class="container">

    <div id="cookie-header" class="topbar" style="background-color:#3D3F4D;height: 25px;display:none;">
      <span style="font-size: 12px;margin-left: 10px;"> 
        <i class="mdi mdi-verified" style="font-size: 12px;"></i>
       请使用Cookie以获得最佳体验。<a id="cookie-agree" style="text-decoration:underline">好的</a></span>
    </div>
    <!-- BEGIN LOGIN ROW -->
    <div class="row sign-in">
      <!-- LOGIN CONTENT -->
      <div class="content col2 push2 sheet sheet-page">
    
        <!-- HEADER ROW -->
        
    
        <div class="row">
          <div class="content col4 text-center">
            <span class="sign-up-head">登录你的账户</span>
          </div>
        </div>   
          <div class="row">
            <div class="content col4">
              <label for="email">用户名</label>
              <input
                id=user
                required
                data-parsley-required
                data-parsley-required-message="请输入用户名"
                >
            </div>
          </div>
          <div class="row">
            <div class="content col4">
              <div class="row">
                <div class="col1 content">
                  <label for="email">密码</label>
                </div>
                <div class="col3 content text-right">
                  <label class="legend forgot-psw-text" id="forgot-psw-switch">忘了密码？</label>
                </div>
              </div>
              <input
                type="password"
                required
                data-parsley-required
                data-parsley-required-message="请输入密码"
                placeholder=""
                id="password">
            </div>
          </div>
    
          <div class="row bottompadded">
            <div class="content col4">
              <button id="login" class="btn btn-primary ">登录</button>
            </div>
          </div>
        </form>
    <!--
            <div class="content col1 text-center" style="padding-top:10px; height:20px;">
              <label class="legend">or</label>
            </div>
     -->
          
    
      <!-- END LOGIN CONTENT -->
      </div>
    <!-- END LOGIN ROW -->
    </div>
    <!-- BEGIN DONT ACCOUNT ROW -->    
    
  <div id="success-notification" class="notification notification-positive">
    <button class="iconbtn mdi mdi-close closebtn"></button>
    <h2 class="notification-title"></h2>
    <p class="notification-body"></p>
  </div>  <div id="error-notification" class="notification notification-negative">
    <button class="iconbtn mdi mdi-close closebtn"></button>
    <h2 class="notification-title"></h2>
    <p class="notification-body"></p>
  </div>
  <script src="https://drrjhlchpvi7e.cloudfront.net/editor/01a263e/dist/login.gz.js"></script>
 
  </body>
</html>
  <script type="text/javascript" src="../asset/js/jquery.js"></script>
  <script type="text/javascript" src="../asset/materialize/js/materialize.min.js"></script>
  <script type="text/javascript">
	$("#login").click(function(){
		$.post("_login.php",
		{
			"User":$("#user").val(),
			"Password":$("#password").val()
		},
		function(data,status){
      var $loginbtn = $("#login");
			if (data==1){
				Materialize.toast('Welcome~', 1000);
				window.location.href="<?echo WebUrl;?>";
			}else{
        document.getElementById('login').innerHTML = '登录失败！';
        setTimeout(function() {
          document.getElementById('login').innerHTML = '登录';
        }, 1000);
      }
		});
	});
  </script>
  </body>
</html>