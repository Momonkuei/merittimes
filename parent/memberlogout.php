<?php

// SEO
// @session_start();
// $_SESSION['web_ml_key'] = 'tw';
// $layoutv3_parent_path = 'tw/'; // 本程式在子資料夾內，相關檔案在根目錄 (通常是Yii和cig前台在用) ex: contact/
// $layoutv3_path = ''; // 本程式在子資料夾內，相關檔案也在該層目錄裡面 (通常是cig後台在用) ex: contact/
// include '../layoutv3/init.php';

include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
include 'layoutv3/libs.php'; // pre_render
include 'source/core_seo.php';

Yii::app()->session->destroy();
$redirect_url = 'index.php';
G::alert_and_redirect(t('己登出','tw'), $redirect_url, $this->data);
