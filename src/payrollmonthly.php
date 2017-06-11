<!--月结算-->
<?php
/**
 * Created by PhpStorm.
 * User: qianzhiphp
 * Date: 2017/5/28
 * Time: 14:32
 */
    require_once(dirname(__FILE__).'/config.php'); ///root/config.php
    require_once(WebRoot."/lib/mysql.php");
    require_once(WebRoot."/reportLib.php");
    $paycheck=new reportGenereator;
    $paycheck->init2(date('Y-m')."monthPaycheck");
    $paycheck->insert_table_head("ID", "name", "payment method", "pay");

    define("salaried",1);
    define("commissioned",2);
    define("管理员",3);
    define("hour",4);
    $EmployeeArray=$database->select("employee", $columns="*");
    $SalaryArray=Array();
    foreach ($EmployeeArray as $Employee) {
        $userArray = $database->select("user", $columns = "*", ["user" => $Employee['ID']]);
        foreach ($userArray as $user) {
            if ($user['type'] == constant("salaried")) {
                $SalaryArray[$Employee['ID']] = ($user["salary"] - $user['other_deductions']) * (1 - $user['tax_deductions']);
            } elseif ($user["type"] == constant("commissioned")) {
                $SalaryArray[$Employee["ID"]] = ($user["salary"] + $user["com_rate"] * $Employee["sales"] - $user['other_deductions']) * (1 - $user['tax_deductions']);
            } else {
                continue;
            }

            if ($user["payment_method"] == "pickup" || $user["payment_method"] == "mail") {
                $paycheck->insert_table_col($Employee['ID'], $user['name'], $user['payment_method'], $SalaryArray[$Employee['ID']]);
            }
            //else{
            /*银行接口*/
            //}
            if ($Employee["dimission"] == 1) {
                $database->delete("employee", ["ID" => $Employee["ID"]]);
                $database->delete("user", ["user" => $Employee["ID"]]);
            }
            $database->insert("year-to-date", ["ID" => $Employee['ID'], "date" => date("Ymd"), "pay" => $SalaryArray[$Employee['ID']]]);
            $database->update("employee", ["standard_working_hours" => 0, "extra_working_hours" => 0, "sales" => 0], ["ID" => $Employee['ID']]);
            $database->update("employee", ["year-to-date" => $SalaryArray[$Employee['ID']] + $Employee["year-to-date"]], ["ID" => $Employee['ID']]);
        }
    }
    $paycheck->end_table(date("Y-m-d"),"");
    $paycheck->output_html(WebRoot."/".date('Y-m')."monthPaycheck.html");
?>
