<?php
/**
 * Created by PhpStorm.
 * User: qianzhi
 * Date: 2017/6/9
 * Time: 15:13
 */

/*通过数据库变量，ID，起始时间和终止时间查询工资记录，返回"date"和"pay"的列表*/
function getPayHistory($database, $ID, $start, $end){
    $history=$database->select("year-to-date", ["date", "pay"], ["AND"=>["ID"=>$ID, "date[<>]"=>[$start, $end]]]);
    return $history;
}

/*创建一个新的员工记录*/
function createEmployeeRecord($database, $ID){
    $database->insert("employee",["ID"=>$ID]);
}

/*更新当月员工总工作时间（标准时间，加班时间）*/
function updateTimeard($database, $ID, $std, $ext){
    $database->update("employee",["standard_working_hours[+]"=>$std, "extra_working_hours[+]"=>$ext], ["ID"=>$ID]);
}

/*更新销售当月订单总额*/
function updateSales($database, $ID, $sale){
    $database->update("employee",["sales[+]"=>$sale],["ID"=>$ID]);
}