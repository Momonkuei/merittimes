<?php
/* 如果網站是放在根目錄,那這邊的變數就是空白
 * 如果網站放在次層目錄,例如 http://www.abc.com.tw/ggg
 * 那變數請填入 $web_folder = '/ggg';
 * 這隻程式 layoutv3/init.php , parent/core.php , layoutv3/cig_frontend/init.php  會引入 
 * 變數除了上述三隻程式有使用外
 * _i/config/environment.php , layoutv3/yii/init.php 
 *  layoutv3/ci3_frontend/init.php , yii_ctt/init.php ,layoutv3/dom4.php
 * contact/_subdir_page.php , parent/_subdir_page.php
 * 以上七隻程式有使用到
 * by lota
*/

// $web_folder = '/AAA/BBB/';
$web_folder = '';
