<?
require_once(dirname(__FILE__).'/../config.php');
require_once(WebRoot."/login/loginLib.php");
require_once(WebRoot."/lib/mysql.php");

?>
  <!DOCTYPE html>
  <html>

  <head>
    <!--Import materialize.css-->
    <title>部门-委托员工-ACME公司管理系统</title>
  <link rel="shortcut icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" size="32x32">
  <link rel="icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" sizes="32x32">
<link type="text/css" rel="stylesheet" href="../asset/materialize/css/materialize.min.css" media="screen,projection" />
    <!--Let browser know website is optimized for mobile-->
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  </head>

  <body class=" grey lighten-3">
    <nav>
      <div class="nav-wrapper">
        <a href="#" class="brand-logo center"><i class="material-icons">perm_identity</i>委托员工</a>
      </div>
    </nav>
    <div class="container">
    <br>
     <h4 class="center">这些是部门<?echo $_GET["Class"];?>的员工</h4>
     <br>
    <ul class="table z-depth-3">
    <table id="ahaha" class="centered white">
    <thead>
      <tr>
        <th data-field="name">姓名</th>
        <th data-field="user" type="number">工号</th>
        <th data-field="modify">修改</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <?
if (!(isLogin() && getUserType()==TypeTeacher)) die("Error");
if (!isset($_GET["Class"])) die("Error");
$UserArray = $database->select("user",["name","user","number"],[]);
foreach($UserArray as $SingleUser){
    if ($database->get("user","type",["user"=>$SingleUser["user"]])==TypeStudent
    && $database->has("classBel",["AND"=>["user"=>$SingleUser["user"],"class"=>$_GET["Class"]]])){
        ?>
        <td><?echo $SingleUser["name"];?></td>
        <td><?echo $SingleUser["number"];?></td>
        <td>
        <a class="btn-floating waves-effect waves-light" href="<?echo WebUrl."/teacher/grade.php?User=".$SingleUser["user"]; ?>" target="_blank">
        <i class="material-icons">mode_edit</i>
        </a></td></tr>
        <?
    }
}

?>
</tbody>
</table>
    </ul>

</div>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../asset/js/jquery.js"></script>
    <script type="text/javascript" src="../asset/materialize/js/materialize.min.js"></script>

      <!--Sort function starts-->
	<script type="text/javascript">
        $(function () {
            var tableObject = $('#ahaha'); //获取id为tableSort的table对象
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
      //删除cookie中所有定变量函数
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