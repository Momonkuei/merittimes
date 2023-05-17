<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>

<?php ob_start()?>
<meta charset="utf-8">
<span t="* en">who are you?</span>
<ul m="multi" ms="html:news">
	<li m="1 f">{*topic*}</li>
</ul>
<?php $run = ob_get_contents();ob_end_clean()?>

<?php
/*
 * DOM第二版初始化
 */
@session_start();
$simplehtml = ''; // 假裝init
$old_struct = true;
$_SESSION['web_ml_key'] = 'tw';
define('FRONTEND_DOMAIN','');

$Db_Server = 'localhost';
$Db_User = 'ordertrading_use';
$Db_Pwd = '';
$Db_Name = 'rwd_v3'; 

include '../standalone_simplehtmldom.php';
include 'dom4.php';
