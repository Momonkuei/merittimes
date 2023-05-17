<?php

/*
 * 2018-06-29 這裡的東西，己經併到view/system/form_start.php裡面
 * 這裡的東西留著，只是為了參考而以
 */

/* JQuery.validate
required：必填欄位
email：格式要符合E-Mail格式
url：格式要符合網址格式，如：https://www.minwt.com
number：數字格包含小數點
digits：數字為正整數
date：日期格式
dateISO：日期格式，格式必需為YYYY/MM/DD、YYYY-MM-DD、YYYYMMDD
equalTo：與某一欄位值相同

minValue：最小字元長度
maxValue：最大字元長度
rangeValue：字元長度區間長度

minLength：最小字元長度(漢字算一個字符)
maxLength：最大字元長度(漢字算一個字符)
rangeLength：字元長度區間長度(漢字算一個字符)
 */

$admin_field_router_class = $this->data['router_method'];
$admin_field_section_id = 0;
include _BASEPATH.'/../source/system/admin_field_get.php';

$validation = G::getJqueryValidation($admin_def['empty_orm_data']['rules']);

// 其它額外條件
$validation['captcha']['required'] = true;

// 其它範本
// $validation['old_time_3']['selectcheck'] = true;
// $validation['old_time_4']['selectcheck'] = true;
// $validation['old_time_5']['selectcheck'] = true;
// $validation['old_time_1']['selectcheck'] = true;
// //$validation['old_time_2']['selectcheck'] = true; // #13507
// $validation['old_addr_1']['selectcheck'] = true;
// $validation['old_addr_1_2']['selectcheck'] = true;
// $validation['new_addr_1']['selectcheck'] = true;
// $validation['new_addr_1_2']['selectcheck'] = true;
// $validation['service[]']['roles'] = true;
// $validation['GGGAAA']['selects'] = true;

$this->data['jqueryvalidation'] = json_encode($validation);
$this->data['updatecontent_jqueryvalidation'] = $validation;
