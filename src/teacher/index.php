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
        <a href="#" class="brand-logo center">委托员工</a>
        <ul id="nav-moblie" class="right hide-on-med-and-down">
          <li><a href="../login/index.php" onClick="delAllCookie();">登出</a></li>
        </ul>
        <ul id="nav-moblie" class="left hide-on-med-and-down">
          <li><a href="#modalChange">设置</a></li>
          <li><a href="employeepurchase.php">订单</a></li>
          <li><a href="#modalReport">打印报告</a></li>
        </ul>
      </div>
    </nav>
    <br>
    <h4 class="center">您好，以下是您管理的部门</h4>
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
    <br>
    <h4 class="center">以下是您项目概要</h4>
    <br>

   <table id="laosan" class="centered white z-depth-3">
          <thead>
            <tr>
              <th type="number">编号</th>
              <th>项目</th>
              <th type="number">优先级</th>
              <th type="number">时长</th>
            </tr>
          </thead>
          <tbody>
        <?
$nowSubjectArray=$database->select("subject",["id","name","GPA"],[]);
if ($User!=0 && $database->has("user",["AND"=>["user"=>$User,"type"=>2]])){
    foreach($nowSubjectArray as $nowSuject){
        if (!$database->has("subjectBel",["AND" =>["user" => trim($User),'subject'=>trim($nowSuject["id"])]])) continue;
        $sbScore=$database->get("grade", "score", ["AND" =>["user" => trim($User),'subject'=>trim($nowSuject["id"])]]);
        ?>
              <tr>
                <td>
                  <?echo $nowSuject["id"];?>
                </td>
                <td>
                  <?echo $nowSuject["name"];?>
                </td>
                <td>
                  <?echo $nowSuject["GPA"];?>
                </td>
                <td>
                  <button class="waves-effect waves-teal btn-flat" type="button" id="edit" <? if ($isEdit){ ?>onClick="onEdit(<?
          echo $nowSuject["id"];
          echo ',\'';
          echo $nowSuject["name"];
          echo '\',';
          echo $User;
          echo ',\'';
          echo $Name;
          echo '\',';
          if (!is_numeric($sbScore)) echo '100'; else echo $sbScore;
                ?>);"
                      <?
        }else{
            ?>onClick="denied();"
                        <?}?>>
                          <? if (!is_numeric($sbScore)) echo '-'; else echo $sbScore; ?>
                  </button>
                </td>
              </tr>

              <?}}else echo '<div class="center">No Such a person.</br>Maybe Error.</div>'?>
          </tbody>
        </table>


  <span class="modal-footer">
  <div class="fixed-action-btn" style="bottom: 120px; right: 24px;">
        <a class="modal-trigger btn-floating btn-large waves-effect waves-light red"
    href="#" id="edit" onClick="onEndtime(<?echo $User;?>,'<?echo $Name;?>','<?echo date("Y-m-d H:i:s",time() + 28800);?>','<?echo $database->get("employeetimecard","project",["id"=>$User])?>');"><i class="material-icons">结束</i></a>
  </div>
  </span> 
  <span class="modal-footer">
  <div class="fixed-action-btn" style="bottom: 192px; right: 24px;">
        <a class="modal-trigger btn-floating btn-large waves-effect waves-light red" 
    href="#" id="edit" onClick="onBegintime(<?echo $User;?>,'<?echo $Name;?>','<?echo date("Y-m-d H:i:s",time() + 28800);?>');"<i class="material-icons">开始</i></a>
  </div>
  </span> 
  <span class="modal-footer">
  <div class="fixed-action-btn" style="bottom: 48px; right: 24px;">
        <a class="modal-trigger btn-floating btn-large waves-effect waves-light red" 

    href="#" id="edit" onClick="onSelectproject(<?echo $User;?>,'<?echo $Name;?>');"<i class="material-icons">项目</i></a>
  </div>
  </span> 


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



<div id="modalProject" class="modal modal-fixed-footer">
    <div class="modal-content">
  <br>
      <h4 class="center" id="Pro_Title">Edit Subject For ???</h4>
    <br>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input disabled value="0" id="Pro_User" type="text" class="validate">
          <label for="Pro_User">员工号</label>
        </div>
        <div class="input-field col s12 offset-s1">
        <select id = "select">
        <option value="" disable selected>Choose your option</option>
        <?
      $nowSubjectArray=$database->select("subject",["id","name"],[]);
      foreach($nowSubjectArray as $nowSubject){
        if (!$database->has("subjectBel",["AND" =>["user" => trim($User),'subject'=>trim($nowSubject["id"])]])) continue;
        ?>
                <option value = "<?echo $nowSubject["id"];?>"><?echo $nowSubject["name"];?></option>  
      <?
      }
      ?>
        </select>
        <label>下拉列表</label>
        </div>
      </div>
  </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="editbelProject();">确定</a>
    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick='window.location.href="";'>取消</a>
    </div>
  </div>



<div id="timecard" class="modal modal-fixed-footer">
    <div class="modal-content">
  <br>
      <h4 class="center" id="SBT_Title">Edit Subject For ???</h4>
    <br>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input disabled value="0" id="SBT_User" type="text" class="validate">
          <label for="SBT_User">员工号</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input disabled value="0" id="SBTT_User" type="text" class="validate">
          <label for="SBTT_User">上班时间</label>
        </div>
      </div>
  </div>
 </div>


<div id="endtimecard" class="modal modal-fixed-footer">
    <div class="modal-content">
  <br>
      <h4 class="center" id="END_Title">Edit Subject For ???</h4>
    <br>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input disabled value="0" id="END_User" type="text" class="validate">
          <label for="END_User">员工号</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input disabled value="0" id="END_name" type="text" class="validate">
          <label for="END_name">姓名</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input disabled value="0" id="END_BTime" type="text" class="validate">
          <label for="END_BTime">上班时间</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input disabled value="0" id="END_Time" type="text" class="validate">
          <label for="END_Time">下班时间</label>
        </div>
      </div>
       <div class="row">
        <div class="input-field col s10 offset-s1">
          <input disabled value="0" id="END_project" type="text" class="validate">
          <label for="END_project">项目</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input disabled value="0" id="END_pname" type="text" class="validate">
          <label for="END_pname">项目</label>
        </div>
      </div>
  </div>
   <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="editTimecard();">确定</a>
    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick='window.location.href="";'>取消</a>
    </div>
  </div>



      <!-- Edit Modal Structure -->
      <div id="modalReport" class="modal modal-fixed-footer">
        <div class="modal-content">
          <h4 class="center">配置报告</h4>
          <div class="row">
            <form class="col s10 offset-s1">
             <div class="row">
                <div class="input-field col s12">
                  <input disabled value="<?echo $User;?>" id="Edit_User" type="text" class="validate">
                  <label>账号</label>
                </div>
              </div>
             <div class="row">
                <div class="input-field col s12">
                  <input disabled value="<?echo $Name;?>" id="Edit_Name" type="text" class="validate">
                  <label>姓名</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <select id="RE_Type">
                    <option value="" disabled selected>请选择报告类型</option>
                    <option value="1">总工作时长</option>
                    <option value="2">年初至今工资</option>
                  </select>
                  <label>类型</label>
                </div>
              </div>
              <label for="RE_Begin">起始日期</label>
              <div class="row">
                <div class="input-field col s12">
                  <input id="RE_Begin" type="date" class="validate" value="">
                </div>
              </div>
              <label for="RE_End">终止日期</label>
              <div class="row">
                <div class="input-field col s12">
                  <input id="RE_End" type="date" class="validate" value="">
                </div>
              </div>

             <div class="row">
                <div class="input-field col s12">
                  <input value="NULL" id="RE_Name" type="text" class="validate">
                  <label for="RE_Name">报名名称</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input disabled value="NULL" id="RE_Pos" type="text" class="validate">
                  <label for="RE_Pos">存储位置</label>
                </div>
              </div>

            </form>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">返回</a>
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="print();">确定</a>
        </div>
      </div>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../asset/js/jquery.js"></script>
    <script type="text/javascript" src="../asset/materialize/js/materialize.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
        $('.modal').modal();
        $('select').material_select();
          $("#RE_Begin").hide();
          $("#RE_End").hide();
          $("#RE_Type").change(function(){
              var p1=$(this).children('option:selected').val();
              if(p1==2){
                $("#RE_Begin").hide();
                $("#RE_End").hide();
              }
              else{
                $("#RE_Begin").show();
                $("#RE_End").show();                
              }
          });
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

function editTimecard()
    {
        $.post("_belfinalTime.php",
    {
      "user":$("#END_User").val(),
            "begintime":$("#END_BTime").val(),
            "endtime":$("#END_Time").val(),
            "name":$("#END_name").val(),
            "project":$("#END_project").val()
    },
    function(data,status){
            if (data == 0)
            {
                Materialize.toast('No Timecard.', 1000);
            }
            else if (data > 0){
               Materialize.toast('Thanks.', 1000);
            }
  
    });
    }
    function onEndtime($user,$name,$time,$project){
    $.post("_belendTime.php",
    {
      "user":$user,
            "time":$time,
            "project":$project
    },
    function(data,status){
            JSON.parse(data,function (k, v) {
                console.log(k);
        console.log(v);
                $(k).val(v);
      });
                $("#END_User").val($user);
          $("#END_Title").text("打卡 - " + $name);
                $("#END_Time").val($time);
                $("#END_name").val($name);
                $("#END_project").val($project);
          $("#endtimecard").modal("open");
    });
  }
    function editbelProject($user)
    {
        $.post("_beleditProject.php",
    {
      "user":$("#Pro_User").val(),
            "project":$("#select").val()
    },
    function(data,status){
            if (data > 0)
            {
               Materialize.toast('Success.', 1000);
               $("#BProject").val($("#select").val());
               window.location.href="";
            }
            else if (data == 0){
               Materialize.toast('Error.', 1000);
               window.location.href="";
            }
            else if (data == -1)
            {
                Materialize.toast('请首先打卡.', 1000);
                window.location.href="";
            }
      
    });
    }
    function onSelectproject($user,$name)
    {
       $.post("_belProject.php",
    {
      "user":$user
    },
    function(data,status){
      $("#Pro_User").val($user);
      $("#Pro_Title").text("选择项目 - " + $name);
      $("#modalProject").modal("open");
    });
    }
    function onBegintime($user,$name,$time){
    $.post("_belTime.php",
    {
      "user":$user,
            "time":$time
    },
    function(data,status){
            if (data == 1)
            {
                $("#SBT_User").val($user);
                $("#SBT_Title").text("打卡 - " + $name);
                $("#SBTT_User").val($time);
                $("#BProject").val("请选择项目");
                $("#timecard").modal("open");
            }
            else{
                $("#SBT_User").val($user);
          $("#SBT_Title").text("打卡 - " + $name);
                $("#SBTT_User").val(data);
          $("#timecard").modal("open");
            }
      
    });
  }

        function print() {
          var p1=$("#RE_Type").val();
          if(p1==1){
          $.post("_printReport.php", {
              "user": $("#Edit_User").val(),
              "name": $("#Edit_Name").val(),
              "re_name": $("#RE_Name").val(),
              "re_begin": $("#RE_Begin").val(),
              "re_end": $("#RE_End").val(),
              "re_path": $("#RE_Pos").val(),
              "type": 1
            },
            function(data, status) {
                console.log(data);
                if(data > 0)
                  Materialize.toast('Requested.', 1000);
                else
                  Materialize.toast('Error.', 1000);
            });
          }
          else if(p1==2){
              $.post("_printReport.php", {
              "user": $("#Edit_User").val(),
              "name": $("#Edit_Name").val(),
              "re_name": $("#RE_Name").val(),
              "re_path": $("#RE_Pos").val(),
              "type": 2
            },
            function(data, status) {
                console.log(data);
                if(data > 0)
                  Materialize.toast('Requested.', 1000);
                else
                  Materialize.toast('Error.', 1000);
            });
          }
          

        }

    </script>
  </body>

  </html>