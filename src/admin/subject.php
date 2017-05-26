<?
	require_once(dirname(__FILE__).'/../config.php');
	require_once(WebRoot."/login/loginLib.php");
	require_once(WebRoot."/lib/mysql.php");
isLogin();

$selectOK = $database->get("select_sb","val",[]);
?>
<!DOCTYPE html>
<html>
  <head>		
	<title>修改科目-管理员-学生成绩管理系统</title>
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="../asset/materialize/css/materialize.min.css"  media="screen,projection"/>
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="shortcut icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" size="32x32">
  <link rel="icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" sizes="32x32">
	</head>

  <body class=" grey lighten-3">
  <nav>
    <div class="nav-wrapper blue">
    <a href="#" class="brand-logo center">管理员</a>
    <ul id="nav-moblie" class="left hide-on-med-and-down">
		<li><a href="user.php">修改用户</a></li>
    <li><a href="#" onClick="showSettings();">设置</a></li>
    </ul>
    <ul id="nav-moblie" class="right hide-on-med-and-down">
		<li><a href="index.php">主页面</a></li>
		<li><a href="../login/index.php" onClick="delAllCookie();">登出</a></li>
	</ul>
	</div>
  </nav>
<div class="row">
	<br>
  <h5 class="center">以下为本学期全部的课程</h1>
	<br>
</div>
  <div class="container">
<table id="nihao" class="responsive-table centered z-depth-3 white">
        <thead>
          <tr>
              <th data-field="name">课程名称</th>
              <th data-field="gpa" type="number">课程绩点</th>
              <th data-field="teacher">任课老师</th>
							<th data-field="class">上课地点</th>
							<th data-field="edit">修改</th>
          </tr>
        </thead>
        <tbody>
        
					<?
						$nowSubjectArray=$database->select("subject",["id","name","GPA"],[]);
						foreach($nowSubjectArray as $nowSuject){
					?>
					<tr>
							<td><?echo $nowSuject["name"];?></td>
							<td><?echo $nowSuject["GPA"];?></td>
							<td><?echo "洪琦均";?></td>
							<td><?echo "南二-427";?></td>
							<td><button class="btn waves-effect waves-light" type="button" id="edit" onClick="onEdit(<?echo $nowSuject["id"];?>,'<?echo $nowSuject["name"];?>','<?echo $nowSuject["GPA"];?>');">修改</button>
		</td>
					</tr>
					<?}?>
					</tbody>
	</table>
  

  <!-- Edit Modal Structure -->
  <div id="modalEdit" class="modal modal-fixed-footer">
    <div class="modal-content">
				<h4 class="center">修改课程</h4>
				<div class="row">
					<form class="col s10 offset-s1">
					<div class="row">
						<div class="input-field col s12">
							<input disabled value="0" id="Edit_Id" type="text" class="validate">
							<label for="Edit_Id">课程ID</label>
						</div>
					</div>
				<div class="row">
						<div class="input-field col s12">
							<input id="Edit_Name" type="text" class="validate" value="NULL">
							<label for="Edit_Name">课程名称</label>
						</div>
					</div>
				<div class="row">
						<div class="input-field col s12">
							<input id="Edit_GPA" type="text" class="validate" value="NULL">
							<label for="Edit_GPA">课程绩点</label>
						</div>
					</div>

				<div class="row">
					<div class="input-field col s12">
						<input id="Edit_Teacher" type="text" class="validate" value="0">
						<label for="Edit_Teacher">任课教师</label>
					</div>
				</div>
			<div class="row">
					<div class="input-field col s12">
						<input id="Edit_Place" type="text" class="validate" value="0">
						<label for="Edit_Place">上课地点</label>
					</div>
				</div>

				</form>
			</div>
    </div>
      <div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">返回</a>
	  		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" type="submit" onClick="editSubject();">修改</a>
				<a href="#!" class="modal-action modal-close waves-effect  tooltipped waves-red btn-flat" data-position="bottom" data-delay="50" data-tooltip="请三思而后行！" onClick="deleteSubject();">删除</a>
    </div>
  </div>	
     <div id="settings" class="modal">
        <div class="modal-content">
          <h4 class="center">设置</h4>
          <div class="row">
            <form class="col s10 offset-s1">
				<div class="row">
					<div class="col s8">
						<p>允许学生自由选课</p>
					</div>
						<div class="switch">
							<label>
							不允许
							<input id="selectCourse" type="checkbox" <?
							if($selectOK)
								echo 'checked="checked"';
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
  <!-- Modal Trigger -->
	<div class="fixed-action-btn" style="bottom: 48px; right: 24px;">
  	<a class="modal-trigger btn-floating btn-large waves-effect waves-light red"  href="#modalNew"><i class="material-icons">add</i></a>
	</div>
  <!-- Edit Modal Structure -->
  <div id="modalNew" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4 class="center">添加课程</h4>
      <div class="row">
				<form class="col s10 offset-s1">
        <div class="row">
        <div class="input-field col s12">
          <input disabled value="Unknown" id="New_Id" type="text" class="validate">
          <label for="New_Id">课程ID</label>
        </div>
      </div>
	  <div class="row">
        <div class="input-field col s12">
          <input id="New_Name" type="text" class="validate" value="">
          <label for="New_Name">课程名称</label>
        </div>
      </div>
	  <div class="row">
        <div class="input-field col s12">
          <input id="New_GPA" type="text" class="validate" value="0">
          <label for="New_GPA">课程绩点</label>
        </div>
      </div>
	  <div class="row">
        <div class="input-field col s12">
          <input id="New_Teacher" type="text" class="validate" value="0">
          <label for="New_Teacher">任课教师</label>
        </div>
      </div>
	  <div class="row">
        <div class="input-field col s12">
          <input id="New_Place" type="text" class="validate" value="0">
          <label for="New_Place">上课地点</label>
        </div>
      </div>
			</form>
      </div>
    </div>
      <div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">返回</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="newSubject();">新建</a>
    </div>
  </div>
  </div>
  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="../asset/js/jquery.js"></script>
  <script type="text/javascript" src="../asset/materialize/js/materialize.min.js"></script>

	  <!--Sort function starts-->
	<script type="text/javascript">
        $(function () {
            var tableObject = $('#nihao'); //获取id为tableSort的table对象
            var tbHead = tableObject.children('thead'); //获取table对象下的thead
            var tbHeadTh = tbHead.find('tr th'); //获取thead下的tr下的th
            var tbBody = tableObject.children('tbody'); //获取table对象下的tbody
            var tbBodyTr = tbBody.find('tr'); //获取tbody下的tr

            var sortIndex = -1;

            tbHeadTh.each(function () {//遍历thead的tr下的th
                var thisIndex = tbHeadTh.index($(this)); //获取th所在的列号
                //给表态th增加鼠标位于上方时发生的事件
                $(this).mouseover(function () {
                    tbBodyTr.each(function () {//编列tbody下的tr
                        var tds = $(this).find("td"); //获取列号为参数index的td对象集合
                        $(tds[thisIndex]).addClass("hover");//给列号为参数index的td对象添加样式
                    });
                }).mouseout(function () {//给表头th增加鼠标离开时的事件
                    tbBodyTr.each(function () {
                        var tds = $(this).find("td");
                        $(tds[thisIndex]).removeClass("hover");//鼠标离开时移除td对象上的样式
                    });
                });

                $(this).click(function () {//给当前表头th增加点击事件
                    var dataType = $(this).attr("type");//点击时获取当前th的type属性值
                    checkColumnValue(thisIndex, dataType);
                });
            });

            $("tbody tr").removeClass(); //先移除tbody下tr的所有css类
            //table中tbody中tr鼠标位于上面时添加颜色,离开时移除颜色
            $("tbody tr").mouseover(function () {
                $(this).addClass("hover");
            }).mouseout(function () {
                $(this).removeClass("hover");
            });

            //对表格排序
            function checkColumnValue(index, type) {
                var trsValue = new Array();

                tbBodyTr.each(function () {
                    var tds = $(this).find('td');
                    //获取行号为index列的某一行的单元格内容与该单元格所在行的行内容添加到数组trsValue中
                    trsValue.push(type + ".separator" + $(tds[index]).html() + ".separator" + $(this).html());
                    $(this).html("");
                });

                var len = trsValue.length;

                if (index == sortIndex) {
                //如果已经排序了则直接倒序
                    trsValue.reverse();
                } else {
                    for (var i = 0; i < len; i++) {
                        //split() 方法用于把一个字符串分割成字符串数组
                        //获取每行分割后数组的第一个值,即此列的数组类型,定义了字符串\数字\Ip
                        type = trsValue[i].split(".separator")[0];
                        for (var j = i + 1; j < len; j++) {
                            //获取每行分割后数组的第二个值,即文本值
                            value1 = trsValue[i].split(".separator")[1];
                            //获取下一行分割后数组的第二个值,即文本值
                            value2 = trsValue[j].split(".separator")[1];
                            //接下来是数字\字符串等的比较
                            if (type == "number") {
                                value1 = value1 == "" ? 0 : value1;
                                value2 = value2 == "" ? 0 : value2;
                                if (parseFloat(value1) > parseFloat(value2)) {
                                    var temp = trsValue[j];
                                    trsValue[j] = trsValue[i];
                                    trsValue[i] = temp;
                                }
                            } else if (type == "ip") {
                                if (ip2int(value1) > ip2int(value2)) {
                                    var temp = trsValue[j];
                                    trsValue[j] = trsValue[i];
                                    trsValue[i] = temp;
                                }
                            } else {
                                if (value1.localeCompare(value2) > 0) {//该方法不兼容谷歌浏览器
                                    var temp = trsValue[j];
                                    trsValue[j] = trsValue[i];
                                    trsValue[i] = temp;
                                }
                            }
                        }
                    }
                }

                for (var i = 0; i < len; i++) {
                    $("tbody tr:eq(" + i + ")").html(trsValue[i].split(".separator")[2]);
                }

                sortIndex = index;
            }

            //IP转成整型
            function ip2int(ip) {
                var num = 0;
                ip = ip.split(".");
                num = Number(ip[0]) * 256 * 256 * 256 + Number(ip[1]) * 256 * 256 + Number(ip[2]) * 256 + Number(ip[3]);
                return num;
            }

        })
    </script>
	<!--Sort function ends-->

  <script type="text/javascript">
	$(document).ready(function(){
		// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
		$('.modal').modal();
	});
	
$("#selectCourse").change(function() {
			if ($("#selectCourse").is(':checked')) {
				onEditSelectSB(1);
			}
			else {
				onEditSelectSB(0);
			}
		});

	function onEdit($id,$name,$GPA){
		$("#Edit_Id").val($id);
		$("#Edit_Name").val($name);
		$("#Edit_GPA").val($GPA);
		$("#modalEdit").modal("open");
	}
	
	function editSubject(){
		$.post("_subject.php",
			{
				"id":$("#Edit_Id").val(),
				"name":$("#Edit_Name").val(),
				"GPA":$("#Edit_GPA").val(),
				"type":1
			},
			function(data,status){
				if (data==0){
					Materialize.toast('No Edition.', 1000);
				}else if (data>0){
					Materialize.toast('Edited.', 1000);
					window.location.href="";
				}else{
					Materialize.toast('Error.', 1000);
				}
			});
	}
	
	function newSubject(){
		
		$.post("_subject.php",
			{
				"id":$("#New_Id").val(),
				"name":$("#New_Name").val(),
				"GPA":$("#New_GPA").val(),
				"type":2
			},
			function(data,status){
				if (data>0){
					Materialize.toast('Succeed.', 1000);
					window.location.href="";
				}else{
					Materialize.toast('Error.', 1000);
				}
			});
		
	}
	function showSettings() {
          $("#settings").modal("open");
        } 

		function clearLog() {
			$.post("_clearLog.php", 
			{
				"clear": 1
			}, function(data, status) {
				Materialize.toast('已删除缓存文件。', 1000);
			});
		}
 function onEditSelectSB($val) {
          $.post("_selectSB.php", {
              "val": $val
            },
            function(data, status) {
              if (data > 0) {
                Materialize.toast('Accepted.', 1000);
                //window.location.href = "";
              } else {
                Materialize.toast('Error.', 1000);
              }
            });
        }


	function deleteSubject(){
		$.post("_subject.php",
			{
				"id":$("#Edit_Id").val(),
				"name":$("#Edit_Name").val(),
				"GPA":$("#Edit_GPA").val(),
				"type":3
			},
			function(data,status){
				if (data>0){
					Materialize.toast('Deleted.', 1000);
					window.location.href="";
				}else{
					Materialize.toast('Error.', 1000);
				}
			});
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