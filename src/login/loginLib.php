<?php
require_once(dirname(__FILE__).'/../config.php');
require_once(WebRoot.'/lib/mysql.php');
require_once(dirname(__FILE__).'/../lib/chromePHP.php');
define("TypeStudent",1);
define("TypeTeacher",2);
define("TypeAdmin",3);

if (isset($_POST["logout"]) && $_POST["logout"]==true) logout();

/*
判断登陆状态
*/
function isLogin(){
    $loginUser=$_COOKIE['loginUser'];
    $loginCookie=$_COOKIE['loginCookie'];
    $loginType=$_COOKIE['loginType'];
    global $database;
    if ($database->has("user",["AND" => ["user" => trim($loginUser),"cookie" => trim($loginCookie),"type" =>  trim($loginType)]])){
        return true;
    }else{
        Header("Location: ".WebUrl."/login/index.php");
    }
}

/*
获得用户等级
*/
function getUserType(){
    if (isset($_COOKIE['loginType'])){
        return trim($_COOKIE['loginType']);
    }else{
        return 1;
    }
}

/*
获得用户ID
*/
function getUserID(){
    return $_COOKIE['loginUser'];
}

/*
获得随机字符串
*/
function getRandChar($length){
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol)-1;
    for($i=0;$i<$length;$i++){
        $str.=$strPol[rand(0,$max)];
    }
    return $str;
}

/*
获取用户名字
*/
function getName($User){
    global $database;
    return $database->get("user","name", ["user" => $User]);
}

/*
登陆账户
*/
function login($User,$Password){
    global $database;
    ChromePhp::log($database->error());
    if ($database->has("user",[
        "AND" => [
    "user" => $User,
    "password" => trim($Password)
    ]
    ])){
        //服务器登陆Cookie
        $loginCookie=getRandChar(10);
        $database->update("user",["cookie" => $loginCookie],["user" => $User]);
        //本地登陆Cookie
        setcookie('loginUser',$User,time()+3600*24*31,"/");
        setcookie('loginCookie',$loginCookie,time()+3600*24*31,"/");
        setcookie('loginType',$database->get("user","type", ["user" => $User]),time()+3600*24*31,"/");
        ChromePhp::log($database->error());
        return 1;
    }else{
        var_dump($database->error());
        return 0;
    }
}

/*
登出账户
*/
function logout(){
    setcookie('loginUser',"",time()-36000,"/");
    setcookie('loginCookie',"",time()-36000,"/");
    setcookie('loginType',"",time()-36000,"/");
}

?>