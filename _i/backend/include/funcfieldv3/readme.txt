# update: 2018-02-14

/*
 * 這個是要放在listfield
 */
'funcfieldv3_split_1' => array(
	// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
	'width' => '',
),

/*
 * 這個是要放在updatefield
 */

// funcfieldv3的產出欄位，放在任何位置都可以，有需要就打開 2/7
array(
	'form' => array('enable' => false),
	'type' => '1',
	'_has_funcfieldv3_result' => true, // 要記得這個要加
	'field' => array(
	),
),


// funcfieldv3的自定欄位，放在任何位置都可以，有需要就打開 3/7
array(
	'form' => array('enable' => false),
	'type' => '1',
	'_has_funcfieldv3_custom' => true, // 要記得這個要加
	'field' => array(
	),
),

/*
 * 這個是要放在beforeAction
 */

// funcfieldv3 有需要就打開 4/7
$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
$contentx = str_replace('<'.'?'.'php', '', $contentx);
eval($contentx);

/*
 * 這個是要放在create_show_last
 */

// funcfieldv3 有需要就打開 5/7
$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
$contentx = str_replace('<'.'?'.'php', '', $contentx);
eval($contentx);

/*
 * 這個是要放在update_show_last
 */

// funcfieldv3 有需要就打開 6/7
$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
$contentx = str_replace('<'.'?'.'php', '', $contentx);
eval($contentx);

/*
 * 這個是要放在update_run_other_element
 */

// funcfieldv3 有需要就打開 7/7
$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
$contentx = str_replace('<'.'?'.'php', '', $contentx);
eval($contentx);
