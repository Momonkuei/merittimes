<?php

class WatermarkController extends Controller
{
	protected $def = array(
		//'title' => 'ml:Product',
		'table' => 'product',
		'orm' => 'G_product_orm',
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('name_en'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name_en', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name_en', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'data_multilanguage_update' => 'model', // 在資料內頁中，切換多國語系，依照某一個欄位
		'sortable' => array(
			//'enable' => 'true',
			//'condition' => 'class_id = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=product/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		'listfield_attr' => array(
			//'smarty_include_top' => 'product/main_content_top.htm',
		),
		'listfield' => array(
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			//'smarty_javascript' => 'product/update_javascript.htm',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data',
					'name' => 'form_data',
					'method' => 'post',
					'action' => '',
					'enctype' => 'multipart/form-data',
				),
				'button_style' => '2',
			),
			'sections' => array(
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'xx01' => array(
							'label' => '浮水印1',
							'type' => 'inputn',
							'other' => array(
								'html' => '<img src="/_i/all.png" />',
							),
						),
						'xx01a' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '<input type="file" name="file1" />',
							),
						),
						'xx' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '&nbsp;',
							),
						),
					/*
						'xx02' => array(
							'label' => '浮水印2',
							'type' => 'inputn',
							'other' => array(
								'html' => '<img src="/_i/all_small.png" />',
							),
						),
					
						'xx02a' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '<input type="file" name="file2" />',
							),
						),
						
						'gg' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '&nbsp;',
							),
						),
							*/
						'sys_config_watermark_pos' => array(
							'label' => '位置',
							'type' => 'select3',
							//'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'sys_config_watermark_pos',
								'name' => 'sys_config_watermark_pos',
							),
							'other' => array(
								'values' => array(
									'1' => '左上',
									'2' => '中上',
									'3' => '右上',
									'4' => '正左',
									'5' => '正中',
									'6' => '正右',
									'7' => '左下',
									'8' => '正下',
									'9' => '右下',
								),
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								//'values' => array(
								//	'0' => '請選擇',
								//),
								'default' => '5',
							),
						),
						'sys_config_watermark_opacity' => array(
							'label' => '透明度',
							'type' => 'select3',
							//'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'sys_config_watermark_opacity',
								'name' => 'sys_config_watermark_opacity',
							),
							'other' => array(
								'values' => array(
									'0' => '不放置',
									'10' => '最淡',
									'20' => '20%',
									'30' => '30%',
									'40' => '40%',
									'50' => '50%',
									'60' => '60%',
									'70' => '70%',
									'80' => '80%',
									'90' => '最深',
								),
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								//'values' => array(
								//	'0' => '請選擇',
								//),
								'default' => '50',
							),
						),
					),
				),
			),
		), // updatefield
	);

	// protected function beforeAction($action)
	// {
	// 	parent::beforeAction($action);

	// 	$tmp = $this->def['updatefield']['sections'][0]['field']['sys_config_articlesingle'];
	// 	$tmp['attr']['id'] .= '_'.$this->data['admin_switch_data_ml_key'];
	// 	$tmp['attr']['name'] .= '_'.$this->data['admin_switch_data_ml_key'];
	// 	$this->def['updatefield']['sections'][0]['field']['sys_config_articlesingle_'.$this->data['admin_switch_data_ml_key']] = $tmp;

	// 	unset($this->def['updatefield']['sections'][0]['field']['sys_config_articlesingle']);

	// 	return true;
	// }

	public function actionIndex($param='')
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;

			//強迫圖片更新
			$date = time();
			$this->data['def']['updatefield']['sections'][0]['field']['xx01']['other']['html'] = '<img src="/_i/all.png?uptime='.$date .'" />';

			$list = array(
				'watermark_pos',
				'watermark_opacity',
			);

			$load = array();
			$sys_configs = $this->data['sys_configs'];

			if(count($list) > 0){
				foreach($list as $k => $v){
					if(!isset($sys_configs[$v])){
						$sys_configs[$v] = '';
					}
					$load['sys_config_'.$v] = $sys_configs[$v];
				}
			}

			$this->data['updatecontent'] = $load;
			//var_dump($this->data['updatecontent']);
			$this->data['main_content'] = 'default/update';
			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
			$this->display('index.htm', $this->data);
		} else {
			$save = $_POST;

			// 看一下有沒有存在，有，而且數值不一樣，就update，沒有就insert
			if(count($save) > 0){
				$db = Yii::app()->db;
				foreach($save as $k => $v){
					if(!preg_match('/^sys_config_(.*)$/', $k, $matches)){
						continue;
					}
					$k = $matches[1];

					//if($k == 'smtp_password' and $v == ''){
					//	continue;
					//}

					if(isset($this->data['sys_configs'][$k]) and $v != $this->data['sys_configs'][$k]){
						// update
						$sql="UPDATE sys_config SET keyval = :value WHERE keyname = :key";
						$command=$db->createCommand($sql);
						$command->bindParam(":key",$k,PDO::PARAM_STR);
						$command->bindParam(":value",$v,PDO::PARAM_STR);
						$command->execute();
					} elseif(!isset($this->data['sys_configs'][$k]) and $v != ''){
						$sql="INSERT INTO sys_config (keyname, keyval) VALUES(:key,:value)";
						$command=$db->createCommand($sql);
						// PDO::PARAM_STR
						// PDO::PARAM_INT
						$command->bindParam(":key",$k,PDO::PARAM_STR);
						$command->bindParam(":value",$v,PDO::PARAM_STR);
						$command->execute();
					}
				}
			}

			/*
			 * 寫入浮水印的設定檔
			 */

			$tmp = array(
				'pos' => $save['sys_config_watermark_pos'],
				'opacity' => $save['sys_config_watermark_opacity'],
			);

			file_put_contents(tmp_path.'/../watermark_config.php', '<'.'?'.'php $watermark_config='.var_export($tmp,true).';');

			/*
			 * 浮水印1
			 */

			// http://www.w3schools.com/php/php_file_upload.asp
			//$allowedExts = array("gif", "jpeg", "jpg", "png");
			$allowedExts = array("png");
			$temp = explode(".", $_FILES["file1"]["name"]);
			$extension = end($temp);

			if ((($_FILES["file1"]["type"] == "image/gif")
				|| ($_FILES["file1"]["type"] == "image/jpeg")
				|| ($_FILES["file1"]["type"] == "image/jpg")
				|| ($_FILES["file1"]["type"] == "image/pjpeg")
				|| ($_FILES["file1"]["type"] == "image/x-png")
				|| ($_FILES["file1"]["type"] == "image/png"))
				//&& ($_FILES["file"]["size"] < 20000)
				&& in_array($extension, $allowedExts)) {
					if ($_FILES["file1"]["error"] > 0) {
						//echo "Return Code: " . $_FILES["file1"]["error"] . "<br>";
						$redirect_url = '';
						G::alert_and_redirect($_FILES["file1"]["error"], $redirect_url, $this->data);
					} else {
						//$newfilename = $sample[$_POST['b']]['type'].$sample[$_POST['b']]['size'].'.'.$extension;
						$newfilename = 'all.'.$extension;
						move_uploaded_file($_FILES["file1"]["tmp_name"], tmp_path.'/../'.$newfilename);
						chmod(tmp_path.'/../'.$newfilename, 0666);
						//header('Location: '.$func.'#'.$_POST['b']);
						//header('Location: '.$func);
					}
				//} else {
				//	? >
				//	<meta charset="utf-8" />
				//	<script type="text/javascript">
				//		alert('請上傳PNG圖片');
				//		window.location.href='watermark.php';
				//	</script>
				//	< ? php
					//echo "Invalid file";
			} // 浮水印1

			/*
			 * 浮水印2
			 */

			// http://www.w3schools.com/php/php_file_upload.asp
			//$allowedExts = array("gif", "jpeg", "jpg", "png");
		if(isset($_FILES['file2'])){
			$allowedExts = array("png");
			$temp = explode(".", $_FILES["file2"]["name"]);
			$extension = end($temp);
			if ((($_FILES["file2"]["type"] == "image/gif")
				|| ($_FILES["file2"]["type"] == "image/jpeg")
				|| ($_FILES["file2"]["type"] == "image/jpg")
				|| ($_FILES["file2"]["type"] == "image/pjpeg")
				|| ($_FILES["file2"]["type"] == "image/x-png")
				|| ($_FILES["file2"]["type"] == "image/png"))
				//&& ($_FILES["file"]["size"] < 20000)
				&& in_array($extension, $allowedExts)) {
					if ($_FILES["file2"]["error"] > 0) {
						//echo "Return Code: " . $_FILES["file2"]["error"] . "<br>";
						$redirect_url = '';
						G::alert_and_redirect($_FILES["file2"]["error"], $redirect_url, $this->data);
					} else {
						//$newfilename = $sample[$_POST['b']]['type'].$sample[$_POST['b']]['size'].'.'.$extension;
						$newfilename = 'all_small.'.$extension;
						move_uploaded_file($_FILES["file2"]["tmp_name"], tmp_path.'/../'.$newfilename);
						chmod(tmp_path.'/../'.$newfilename, 0666);
						//header('Location: '.$func.'#'.$_POST['b']);
						//header('Location: '.$func);
					}
				//} else {
				//	? >
				//	<meta charset="utf-8" />
				//	<script type="text/javascript">
				//		alert('請上傳PNG圖片');
				//		window.location.href='watermark.php';
				//	</script>
				//	< ? php
					//echo "Invalid file";
			}
		} // 浮水印2
			
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method']));
		}
	}

}
