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
	<title>订单-管理员-学生成绩管理系统</title>
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="../asset/materialize/css/materialize.min.css"  media="screen,projection"/>
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="shortcut icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" size="32x32">
  <link rel="icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" sizes="32x32">
	</head>

  <body class=" grey lighten-3">
  <? 
  $isEdit=false;
  $User=0;
  $Name="";
  $Select_sb=false;
  if (isset($_GET["User"])) $User=$_GET["User"];
  if (isLogin() && getUserType()==1){
	  $isEdit=false;
	  $User=getUserID();
      $Name=getName($User);
      $Phone=$database->get("user","phone",["user"=>$User]);
	  if($database->get("select_sb","val",[])==1)  $Select_sb=true;
  }else{
	  $isEdit=true;
	  
  }?>
  <nav>
    <div class="nav-wrapper blue">
    <a href="#" class="brand-logo center"><? echo $database->get("user","name",["user"=>$User]);?></a>
    <ul id="nav-moblie" class="left hide-on-med-and-down">
    <li><a href="#" onClick="showSettings();">设置</a></li>
    <li><a href="employeepurchase.php">订单</a></li>
    </ul>
    <ul id="nav-moblie" class="right hide-on-med-and-down">
		<li><a href="index.php">主页面</a></li>
		<li><a href="../login/index.php" onClick="delAllCookie();">登出</a></li>
	</ul>
	</div>
  </nav>

<div class="row">
	<br>
  <h5 class="center">以下为订单记录</h1>
	<br>
</div>
  <div class="container">
<table id="nihao" class="responsive-table centered z-depth-3 white">
        <thead>
          <tr>
              <th data-field="name">客户姓名</th>
              <th data-field="telephone" type="number">客户电话</th>
              <th data-field="address">客户地址</th>
			  <th data-field="date">订单日期</th>
			  <th data-field="pid">产品号</th>
              <th date-field="oid">订单号</th>
              <th date-field="edit">创建</th>
          </tr>
        </thead>
        <tbody>
        
					<?
						$purchaseArray=$database->select("purchase_order",["client_name","telephone","address","pid","date","oid"],["user"=>$User]);
						foreach($purchaseArray as $purchase){
					?>
					<tr>
							<td><?echo $purchase["client_name"];?></td>
							<td><?echo $purchase["telephone"];?></td>
							<td><?echo $purchase["address"];?></td>
							<td><?echo $purchase["date"];?></td>
                            <td><?echo $purchase["pid"];?></td>
                            <td><?echo $purchase["oid"];?></td>
					</tr>
					<?}?>
					</tbody>
	</table>

  <div class="fixed-action-btn" style="bottom: 120px; right: 24px;">
  	<a class="modal-trigger btn-floating btn-large waves-effect waves-light red"  href="#modalEdit"><i class="material-icons">修改</i></a>
	</div>

  <div class="fixed-action-btn" style="bottom: 48px; right: 24px;">
  	<a class="modal-trigger btn-floating btn-large waves-effect waves-light red"  href="#modalNew"><i class="material-icons">add</i></a>
	</div>
  <!-- Edit Modal Structure -->
  <div id="modalNew" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4 class="center">添加订单</h4>
      <div class="row">
				<form class="col s10 offset-s1">
	  <div class="row">
        <div class="input-field col s12">
          <input id="New_Name" type="text" class="validate" value="">
          <label for="New_Name">客户名称</label>
        </div>
      </div>
	  <div class="row">
        <div class="input-field col s12">
          <input id="New_Telephone" type="text" class="validate" value="">
          <label for="New_Telephone">客户电话</label>
        </div>
      </div>
	  <div class="row">
        <div class="input-field col s12">
          <input id="New_Address" type="text" class="validate" value="">
          <label for="New_Address">客户地址</label>
        </div>
      </div>
	  <div class="row">
        <div class="input-field col s12">
          <input id="New_Date" type="text" class="validate" value="">
          <label for="New_Date">日期</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="New_Pid" type="text" class="validate" value="">
          <label for="New_Pid">产品号</label>
        </div>
      </div>
			</form>
      </div>
    </div>
      <div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">返回</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="newPurchase(<?echo $User;?>,'<?echo time();?>');">新建</a>
    </div>
  </div>
  </div>



<div id="modalEdit" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4 class="center">查询订单</h4>
      <div class="row">
				<form class="col s10 offset-s1">
      <div class="row">
        <div class="input-field col s6">
          <input value="" id="purchase_id" type="text" class="validate">
          <label class="active" for="purchase_id">订单号</label>
        </div>
      </div>
			</form>
      </div>
    </div>
      <div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">返回</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="newEditPurchase(<?echo $User;?>);">查询</a>
    </div>
  </div>
  </div>



<div id="modaleditpurchase" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4 class="center">修改订单</h4>
      <div class="row">
				<form class="col s10 offset-s1">
        <div class="row">
        <div class="input-field col s12 offset-s1">
          <input disabled value="0" id="POid" type="text" class="validate">
          <label for="POid">订单号</label>
        </div>
      </div>
        <div class="row">
        <div class="input-field col s10 offset-s1">
          <input value="0" id="PClient_name" type="text" class="validate">
          <label for="PClient_name">客户姓名</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input value="0" id="PTelephone" type="text" class="validate">
          <label for="PTelephone">客户电话</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input value="0" id="PAdress" type="text" class="validate">
          <label for="PAdress">客户地址</label>
        </div>
      </div>
       <div class="row">
        <div class="input-field col s10 offset-s1">
          <input value="0" id="PPid" type="text" class="validate">
          <label for="PPid">产品号</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s10 offset-s1">
          <input value="0" id="PDate" type="text" class="validate">
          <label for="PDate">日期</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s10 offset-s1">
        <select id="PState">
          <option value="open">open</option>
          <option value="close">close</option>
        </select>
        <label>订单状态</label>
      </div>
      </div>
			</form>
      </div>
    </div>
      <div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">返回</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="newChangePurchase();">修改</a>
    </div>
  </div>
  </div>





  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="../asset/js/jquery.js"></script>
  <script type="text/javascript" src="../asset/materialize/js/materialize.min.js"></script>


  <script type="text/javascript">
	$(document).ready(function(){
		// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
		$('.modal').modal();
    Materialize.updateTextFields();
    $('select').material_select();
	});

  function newEditPurchase($user){
    $.post("_editpurchase.php",
			{
          "user":$user,
          "purchase_id":$("#purchase_id").val()
			},
			function(data,status){
				if (data== -1){
					Materialize.toast('订单不属于你或订单不存在.', 1000);
				}else{
					JSON.parse(data,function (k, v) {
                console.log(k);
			        	console.log(v);
                $(k).val(v);
			      });
          $("#modaleditpurchase").modal("open");

				}
			});
  }

  function newChangePurchase(){
    $.post("_changepurchase.php",
			{
				"client_name":$("#PClient_name").val(),
        "telephone":$("#PTelephone").val(),
        "address":$("#PAdress").val(),
        "pid":$("#PPid").val(),
        "date":$("#PDate").val(),
        "state":$("#PState").val(),
        "oid":$("#POid").val()
			},
			function(data,status){
        console.log("changeafter");
        console.log($("#PClient_name").val());
				if (data == -1){
					Materialize.toast('找不到订单', 1000);
					window.location.href="";
				}else{
          console.log(data);
					Materialize.toast('修改成功', 1000);
          window.location.href="";
				}
			});
  }
  function newPurchase($user,$datetime){	
		$.post("_employeepurchase.php",
			{
				"name":$("#New_Name").val(),
				"telephone":$("#New_Telephone").val(),
                "address":$("#New_Address").val(),
                "date":$("#New_Date").val(),
                "pid":$("#New_Pid").val(),
                "user":$user,
                "datetime":$datetime
			},
			function(data,status){
				if (data == -1){
					Materialize.toast('请输入正确的产品号.', 1000);
				}
        else if (data >0){
					Materialize.toast('success', 1000);
					window.location.href="";
				}
			});
		
	}
    </script>
  </body>
</html>