<?php
$multi_number = -1; // dom="multi"的順序是排在第幾個，從零開始

/*
 * 跑馬燈
 */

$multi_number++;
$rules = $rules_common;
$rules['parent'] = str_replace('GGG', $multi_number, $rules['parent']);
$rules['one'] = str_replace('GGG', $multi_number, $rules['one']);
$rules['kill'] = str_replace('innertext', 'outertext', $rules['parent']);
// 可以把上層整個刪掉，但是要留個參照下來
// $rules['kill'] = 'find("section[class=articleBlockStyle01]",0)->outertext';
// $rules['kill_assign'] = '<ul dom="multi 1"></ul>';
$result = array_merge($result, general_section_php3($rules));

/*
 * 區塊二
 */
$multi_number++;
$rules = $rules_common;
$rules['parent'] = str_replace('GGG', $multi_number, $rules['parent']);
$rules['one'] = str_replace('GGG', $multi_number, $rules['one']);
$rules['kill'] = str_replace('innertext', 'outertext', $rules['parent']);
// $rules['kill'] = 'find("section[class=articleBlockStyle03]",0)->outertext';
// $rules['kill_assign'] = '<span dom="multi 1"></span>';
$result = array_merge($result, general_section_php3($rules));

/*
 * 區塊三(單筆用多筆來解)
 */
$multi_number++;
$rules = $rules_common;
$rules['parent'] = str_replace('GGG', $multi_number, $rules['parent']);
$rules['one'] = str_replace('GGG', $multi_number, $rules['one']);
$rules['kill'] = str_replace('innertext', 'outertext', $rules['parent']);
// $rules['kill_assign'] = '<section class="articleBlockStyle01" dom="multi" dom="1"></section>';
$result = array_merge($result, general_section_php3($rules));

