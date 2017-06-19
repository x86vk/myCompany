<?
    $User=$_POST["user"];
    $Password=$_POST["password"];
    $type=$_POST["type"];
    $name=$_POST["name"];
    $Phone=$_POST["phone"];
    $pay_method=$_POST["pay_method"];
    require_once(dirname(__FILE__).'/../config.php');
    require_once(WebRoot."/login/loginLib.php");
    require_once(WebRoot."/lib/mysql.php");

    if (file_exists("../log/log_info.txt")) {
        $logfile = fopen("../log/log_info.txt", "a");
    }else {
        $logfile = fopen("../log/log_info.txt", "w");
    }

    if (isLogin() && getUserType()==TypeStudent){
        if ($type==3){
            echo $database->delete("user",["user"=>$User]);
        }else if($type==2){
            echo ($database->insert("user",["user"=>$User,"name"=>$name,"password"=>$Password,"type"=>$type,"cookie"=>"?"]));
        }else if($type==1) {
            $OldPassword = $database->get("user", "password", ["user" => $User]);
            $OldPhone = $database->get("user", "phone", ["user" => $User]);
            echo $database->update("user", ["name" => $name, "password" => $Password, "phone" => $Phone,"payment_method"=>$pay_method], ["user" => $User]);
            if ($OldPassword != $Password){
                $time = $database->get("user","time",["user"=>$User]);
                $text = $time."\t".$name . "修改密码\r\n";
                fwrite($logfile, $text);
            }
            if ($OldPhone != $Phone){
                $time = $database->get("user","time",["user"=>$User]);
                $text = $time."\t".$name . "修改手机号\r\n";
                fwrite($logfile, $text);
            }
        }
    }else{
        die("Access Denied.");
    }

    fclose($logfile);

?>