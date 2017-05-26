<?
require_once(dirname(__FILE__).'/../config.php');
require_once(WebRoot."/login/loginLib.php");
require_once(WebRoot."/lib/mysql.php");

$User=getUserID();
$Name=getName($User);
$Phone=$database->get("user","phone",["user"=>$User]);
?>
  <!DOCTYPE html>
  <html>

  <head>
    <!--Import materialize.css-->
    <title>教师-学生成绩管理系统</title>
  <link rel="shortcut icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" size="32x32">
  <link rel="icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" sizes="32x32"><link type="text/css" rel="stylesheet" href="../asset/materialize/css/materialize.min.css" media="screen,projection" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  </head>


  <body class=" grey lighten-3">
    <nav>
      <div class="nav-wrapper">
        <a href="#" class="brand-logo center">教师</a>
        <ul id="nav-moblie" class="right hide-on-med-and-down">
          <li><a href="../login/index.php" onClick="delAllCookie();">登出</a></li>
        </ul>
        <ul id="nav-moblie" class="left hide-on-med-and-down">
          <li><a href="#modalChange">设置</a></li>
        </ul>
      </div>
    </nav>
    <br>
    <h4 class="center">您好，以下是您管理的班级</h4>
    <br>
    <div class="container">
      <ul class="collection z-depth-3">

        <?

if (!(isLogin() && getUserType()==TypeTeacher)) die("Error");
$nowClassArray=$database->select("class",["id","name"],[]);
foreach($nowClassArray as $nowClass){
    if ($database->has("classBel",["AND"=>["user"=>getUserID(),"class"=>$nowClass["id"]]])){
        ?>
          <a href="<?echo WebUrl."/teacher/class.php?Class=".$nowClass["id"]; ?>" target="_blank" class="collection-item">
            <?echo $nowClass["name"];?>
              <span class="badge"> <?
        $num=0;
        $UserArray = $database->select("user",["name","user"],[]);
        foreach($UserArray as $SingleUser){
            if ($database->get("user","type",["user"=>$SingleUser["user"]])==TypeStudent
            && $database->has("classBel",["AND"=>["user"=>$SingleUser["user"],"class"=>$nowClass["id"]]])){
                $num = $num+1;
            }}
            echo $num;
            ?></span>
          </a>
          <?
        }
    }
    
    ?>

      </ul>
    </div>

    <div id="modalChange" class="modal modal-fixed-footer">
      <div class="modal-content">
        <h4 class="center"><div id="Edit_Title">个人信息</div></h4>
        <div class="row">
          <div class="input-field col s10 offset-s1">
            <input disabled value="<?echo $User;?>" id="Teacher_ID" type="text" class="validate">
            <label for="Edit_ID">ID</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s10 offset-s1">
            <input disabled value="<?echo $Name;?>" id="Teacher_Name" type="text" class="validate">
            <label for="Edit_User">姓名</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s10 offset-s1">
            <input value="<?echo $Phone;?>" id="Edit_Phone" type="text" class="validate">
            <label for="Edit_Phone">联系电话</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s10 offset-s1">
            <input id="Edit_Password" type="text" class="validate" value="0">
            <label for="Edit_Password">密码</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="editPassword();">确定</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">取消</a>
      </div>
    </div>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../asset/js/jquery.js"></script>
    <script type="text/javascript" src="../asset/materialize/js/materialize.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
        $('.modal').modal();
      });

      function editPassword() {
        $.post("_userpassword.php", {
            "user": $("#Teacher_ID").val(),
            "name": $("#Teacher_Name").val(),
            "password": $("#Edit_Password").val(),
            "phone": $("#Edit_Phone").val(),
            "type": 3
          },
          function(data, status) {
            if (data == 0) {
              Materialize.toast('No Edition.', 1000);
            } else if (data > 0) {
              Materialize.toast('Edited.', 1000);
              window.location.href = "";
            } else {
              Materialize.toast('Error.', 1000);
            }
          });
      }

      function delAllCookie() {
        $.post("../login/loginLib.php", {
            "logout": true
          },
          function(data, status) {
            window.location.href = "";
          });
      }
    </script>
  </body>

  </html>