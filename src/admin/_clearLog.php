<?
require_once(dirname(__FILE__).'/../config.php');
require_once(WebRoot."/login/loginLib.php");
require_once(WebRoot."/lib/mysql.php");
if($_POST["clear"] == 1) {
    $ret = system("rm ".WebRoot."/log/*", $var);
    echo $ret;
}
?>