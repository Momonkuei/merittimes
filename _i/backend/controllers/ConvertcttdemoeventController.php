<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
			),
		),
		'enable_delete' => true, // 多選刪除
		'default_sort_field' => 'XXX', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('XXX'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'XXX', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'XXX', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'condition' => array(
			array(
				'where',
				'',
			),
		),
		'sortable' => array(
			'enable' => 'true',
			'condition' => '', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
		),
		'listfield' => array(
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			'topic' => array(
				'label' => '英文別名',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '35%',
				'sort' => true,
			),
			'name' => array(
				// 'label' => '名稱',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '60%',
				'sort' => true,
			),
			'xx2' => array(
				'label' => '分類',			
				'width' => '8%',
				'sort' => true,
			),
			'sort_id_home' => array(
				'label' => '結構',
				'width' => '6',
				'align' => 'center',
				'sort' => false,
			),
			'is_top' => array(
				'label' => '提升優先權',
				'width' => '10%',
				'align' => 'center',
				//'sort' => true,
				'ezfield' => 'is_top',
				'ezother'=> '&nbsp;',
			),

			'is_enable' => array(
				//'label' => 'ml:Status',
				'mlabel' => array(
					null, // category
					'Status', // label
					array(), // sprintf
					'狀態', // default
				),
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
			),
			'start_date' => array(
				//'label' => '日期',
				'mlabel' => array(
					null, // category
					'Date', // label
					array(), // sprintf
					'日期', // default
				),
				'width' => '15%',
				'sort' => true,
			),
			'sort_id' => array(
				'label' => 'ml:Sort id',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
		'searchfield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate',
			),
			//'smarty_javascript' => '',
			'smarty_javascript_text' => '',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data_search',
					'name' => 'form_data_search',
					'method' => 'post',
					'action' => '',
				),
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'dest' => array(
							'label' => '目標 | 語系',
							'type' => 'input',
							'attr' => array(
								'id' => 'dest',
								'name' => 'dest',
								'size' => '10',
							),
							'other' => array(
								'html_end' => '例：en',
							),
						),
						//'id_increment_type' => array(
						//	'label' => '　└ 主索引增量(次分類)',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'id_increment_type',
						//		'name' => 'id_increment_type',
						//		'size' => '6',
						//	),
						//	'other' => array(
						//		'html_end' => '例：2000',
						//	),
						//),
						'dest_table_type' => array(
							'label' => '目標 | 分類資料表名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'dest_table_type',
								'name' => 'dest_table_type',
								'size' => '10',
							),
							'other' => array(
								'html_end' => '例：phototype (獨立)',
							),
						),
						'dest_table' => array(
							'label' => '目標 | 分項資料表名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'dest_table',
								'name' => 'dest_table',
								'size' => '10',
							),
							'other' => array(
								'html_end' => '例：photo (通用)',
							),
						),
						'xx00' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '
1. 舊站和新站先做備份<br />
2. 接下來的動作，將會清空目標資料表！<br />
3. 先從舊網站那邊，將要處理的資料表放到新站，資料表為：events_cat,events,events_photo<br />
4. 在這個功能，填入所需要的欄位，並執行它<br />
5. 手動將舊站的圖片複製過來，包含upload/功能/ 和upload/userfiles<br />
',
							),
						),
					),
				),
			),
		),
		'updatefield' => array(
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		$product_table = $this->data['router_class'];
		//$product_table = str_replace('homesort', '', $product_table); // 為了支援產品的首頁排序

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 匯出功能之二
		// $this->def['index_buttons'][0]['onclick'] = 'javascript:location.href=\''.$this->createUrl($this->data['router_class'].'/excelexport').'\'';


		// 商品複製 copy
		if(isset($_GET['param'])){
			$parameter = new Parameter_handle;
			$params = $parameter->get($_GET['param']);
			if(isset($params['value'][1]) and $params['value'][1] and $params['value'][1] == 'copy'){
				$ggg = $this->def['updatefield']['sections'][2];
				$this->def['updatefield']['sections'] = array();
				$this->def['updatefield']['sections'][] = $ggg;
			} else {
				unset($this->def['updatefield']['sections'][2]);
			}
		}

		//2016/1/29 lota 如果是反向排序，則將箭頭對調
		if(isset($this->def['default_sort_direction']) && $this->def['default_sort_direction']=='desc'){
				$this->def['listfield_attr']['smarty_include_top_text'] = '
$aaa_xxx = <<<XXX
<script type="text/javascript">
$(document).ready(function() {
	$(".sortImg").each(function(){
		if($(this).attr(\'src\')==\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_down.gif\')
			$(this).attr(\'src\',\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_up.gif\');
		else if($(this).attr(\'src\')==\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_up.gif\')
			$(this).attr(\'src\',\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_down.gif\');
	});
});
</script>
XXX;
echo str_replace(\'BACKEND_ASSETSURL_DOMAIN\',BACKEND_ASSETSURL_DOMAIN,$aaa_xxx);
';
		}

		// 前台主選單的資料表功能
		$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();

		// A方案的客制功能專用
		if(0){
			$rowg = array(
				'pic2' => 1, // 分類
				'is_news' => 1, // 通用分類
				'class_ids' => 1, // 通用分項
			);
		}

		if($rowg){ 
			if(isset($rowg['pic3']) and $rowg['pic3'] == 1){ // 有日期排序的情況下
				// do nothing
				unset($this->def['listfield']['sort_id']);
				unset($this->def['updatefield']['sections'][0]['field']['sort_id']);
				$this->def['default_sort_field'] = 'start_date';
			} else { // 2018-01-11
				unset($this->def['listfield']['start_date']);
				if(isset($this->def['updatefield']['sections'][0]['field']['start_date'])){
					unset($this->def['updatefield']['sections'][0]['field']['start_date']);
				}
				$this->def['default_sort_field'] = 'sort_id';
				if(isset($this->def['default_sort_direction'])){
					unset($this->def['default_sort_direction']);
				}
			}

			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
				$this->def['table'] = 'html';
				$this->def['empty_orm_data']['table'] = 'html';
				$this->def['empty_orm_data']['rules'][] = array('topic','required');

				$this->def['search_keyword_field'] = array('topic');
				$this->def['search_keyword_assign_field'] = 'topic';
				$this->def['sys_log_name'] = 'topic';

				unset($this->def['listfield']['name']);
				unset($this->def['updatefield']['sections'][0]['field']['name']); // update, copy
			} else {
				$this->def['table'] = $product_table;
				$this->def['empty_orm_data']['table'] = $product_table;
				$this->def['empty_orm_data']['rules'][] = array('name','required');

				$this->def['search_keyword_field'] = array('name');
				$this->def['search_keyword_assign_field'] = 'name';
				$this->def['sys_log_name'] = 'name';

				unset($this->def['listfield']['topic']);
				unset($this->def['updatefield']['sections'][0]['field']['topic']); // update, copy
			}

			if(isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類

				$this->def['empty_orm_data']['rules'][] = array('class_id', 'required');

				if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類
					$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
					if($rows and !empty($rows)){
						foreach($rows as $k => $v){
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
						}
					}
				} else { // 是獨立分類
					// 這裡是從產品那邊複製過來的
				
					// 分類
					$producttype_table = $this->data['router_class'];
					//$producttype_table = str_replace('homesort', '', $producttype_table); // 為了支援產品的首頁排序(這是homesort的另一支後台功能在用的，註解不要打開)
					$producttype_table .= 'type';

					$rows = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
					if($rows and !empty($rows)){
						foreach($rows as $k => $v){
							//大分類不可選
							/*
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
							$rows2 = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid='.$v['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
							*/
							//大分類可選
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';

							//無限層
							$data_1 = $this->layout_show($v['id'],1,'　',$this->data['router_class'].'type');//'　└'	
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'] += $data_1 ;

							/* //兩層
							$rows2 = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid='.$v['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
							if($rows2 and count($rows2) > 0){
								foreach($rows2 as $kk => $vv){
									$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
									$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
								}
							}
							*/
						}
					}
				}
			} else { // 無分類			
				unset($this->def['searchfield']);
				unset($this->def['updatefield']['sections'][0]['field']['class_id']);
				unset($this->def['listfield']['xx2']);
			}
		} else {
			// 沒有跟webmenu掛勾的，這個欄位就不用了，需要的話，自行在funcfieldv3使用
			unset($this->def['updatefield']['sections'][0]['field']['start_date']);
		} // if row


		// funcfieldv3 有需要就打開 4/7
		// $contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		// $contentx = str_replace('<'.'?'.'php', '', $contentx);
		// eval($contentx);

		// 帶入今天日期
		// 這是最新消息功能在使用的
		if($this->data['router_method'] == 'create'){
			$date = date('Y-m-d');
			if(isset($this->def['updatefield']['sections'][0]['field']['start_date'])){
				$this->def['updatefield']['sections'][0]['field']['start_date']['attr']['value'] = $date;
			}
		}
		
		// 2017-04-28 乖哥說，不同的比例，圖片的最小預設值是不一樣的
		if(file_exists('backend/include/image_size_comment.php')){
			include 'backend/include/image_size_comment.php';
		}

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		if(isset($session) and !empty($session) and $session['dest'] != '' ){
			// 這樣子才不會一重整的時候就送
			unset($_SESSION[$ss]);

			/*
			source_table_type 來源 | 分類資料表名稱
			source_table_type_idname 主索引欄位名稱

			source_table 來源 | 分項資料表名稱
			source_table_idname

			dest 目標 | 語系
			is_html 目標 | 是否為通用
			id_increment 　└ 通用主索引增量(通用資料表在使用的)
			dest_table_type 目標 | 分類資料表名稱
			dest_table 目標 | 分項資料表名稱
			 */

			// 當目標要通用的情況下，那主索引增量就是必填欄位
			if(isset($session['is_html']) and $session['is_html'] > 0 and (($session['id_increment_type'] == '' or $session['id_increment_type'] <= 0) or ($session['id_increment'] == '' or $session['id_increment'] <= 0)) ){
				echo 'ID Increment field is require!';die;
			}

			// 通用 | 把所有編號抓出來，都加上增量以後，在去html資料表檢查，是否有重覆的，有就停下來，並且報錯
			// 這個檢查是針對html資料表，不需要帶條件，不用管語系，只管ID有沒有被重覆到
			if(isset($session['is_html']) and $session['is_html'] > 0){
				if($session['source_table_type'] != '' and $session['source_table_type_idname'] != '' and $session['dest'] != '' and $session['dest_table_type']){
					$ids_type = array();
					$ids_tmp = $this->cidb->select($session['source_table_type_idname'].' as id')->get($session['source_table_type'])->result_array();

					if($ids_tmp and !empty($ids_tmp)){
						foreach($ids_tmp as $v){
							$ids_type[] = $v['id'];
						}
					} else {
						echo 'source table is empty, no data';die;
					}

					foreach($ids_type as $k => $v){
						$v += $session['id_increment_type'];
						$ids_type[$k] = $v;
					}
					$sql = 'select id from html where id in ('.implode(',',$ids_type).')';
					$rows = $this->cidb->query($sql)->result_array();
					if(!empty($rows)){
						echo 'please modify your id_increment_type, because duplicate '.count($rows).'.';die;
					}
					
				}

				// 分項的部份，除了要檢查和資料表裡面的資料編號是否有重覆以外，也要檢查和分類未來的資料編號有沒有重覆到
				if($session['source_table'] != '' and $session['source_table_idname'] != '' and $session['dest'] != '' and $session['dest_table']){
					$ids = array();
					$ids_tmp = $this->cidb->select($session['source_table_idname'].' as id')->get($session['source_table'])->result_array();

					if($ids_tmp and !empty($ids_tmp)){
						foreach($ids_tmp as $v){
							$ids[] = $v['id'];
						}
					} else {
						echo 'source table is empty, no data';die;
					}

					foreach($ids as $k => $v){
						$v += $session['id_increment'];
						$ids[$k] = $v;
					}
					$sql = 'select id from html where id in ('.implode(',',$ids).')';
					$rows = $this->cidb->query($sql)->result_array();
					if(!empty($rows)){
						echo 'please modify your id_increment, because duplicate '.count($rows).'.';die;
					}
					if(isset($ids_type) and !empty($ids_type)){
						foreach($ids_type as $v){
							if(in_array($v, $ids)){
								echo 'please modify your id_increment_type or id_increment, because duplicate';die;
							}
						}
					}
					
				}
			}

			//echo 'ggg';
			//die;

			// 'dest' => array(
			// 	'label' => '目標 | 語系',
			// 'dest_table_type' => array(
			// 	'label' => '目標 | 分類資料表名稱',
			// 'dest_table' => array(
			// 	'label' => '目標 | 分項資料表名稱',

			if($session['dest'] != '' and $session['dest_table_type'] and $session['dest_table']){
				// 欄位對應
				$map = array(
					'CatNo as id',
					'cat_name as name',
					'parent as pid',
					'photo as pic1',
					'description as detail',
					'status as is_enable',
					'priority as sort_id',
				);

				/*
				 * 分類(大類)
				 */
				$save = $this->cidb->select(implode(',',$map))->get('events_cat')->result_array();

				//$this->cidb->truncate($session['dest_table_type']);
				$this->cidb->where('id >',0);
				$this->cidb->delete($session['dest_table_type']); 

				$this->cidb->insert_batch($session['dest_table_type'], $save); 
				$this->cidb->update($session['dest_table_type'], array('ml_key'=>$session['dest'])); 

				/*
				 * 相簿(次類)
				 */
				$map = array(
					'EventsNo as id',
					'Subject as name',
					'CatNo as pid',
					'photo_b as pic1',
					//'Content as detail',
					'status as is_enable',
					'priority as sort_id',
				);

				// 預設規則
				$map[] = 'Content as detail';

				// 祖師禪林的客製則規
				// $map[] = 'Content as detail_top';
				// $map[] = 'Content2 as detail_bottom';

				$save = $this->cidb->select(implode(',',$map))->get('events')->result_array();

				$type_tmp = array(); // [通用]存放更改過後分類編號，做為參照用的
				if($save and !empty($save)){
					foreach($save as $k => $v){
						$old_id = $v['id'];
						$new_id = $old_id + 999;

						$v['id'] = $new_id;
						$type_tmp[$old_id] = $new_id;

						$v['ml_key'] = $session['dest'];

						$save[$k] = $v;
					}
				}
				$this->cidb->insert_batch($session['dest_table_type'], $save); 

				/*
				 * 相片(分項)
				 */
				$map = array(
					//'PhotoID as id',
					'EventsNo as class_id',
					'photo_name as topic',
					'photo_b as pic1',
					'photo_description as detail',
					//'status as is_enable',
					'priority as sort_id',
				);

				$save = $this->cidb->select(implode(',',$map))->get('events_photo')->result_array();

				if($save and !empty($save)){
					foreach($save as $k => $v){
						$old_id = $v['class_id'];
						$new_id = $old_id + 999;

						// 這個編號不用先檢查，因為它所關連的是獨立資料表
						$v['class_id'] = $new_id;

						$v['ml_key'] = $session['dest'];
						$v['type'] = $session['dest_table'];
						$v['is_enable'] = 1;

						$save[$k] = $v;
					}
				}
				$this->cidb->insert_batch('html', $save); 
			}

		}

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['class_id'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';


		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
				$condition = ' type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
				$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
			} else {
				$condition = '  ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
				$condition_sortable = ' ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
			}
		} else {
			/*
			 * 2018-01-31
			 * 後台的前台選單的該功能裡面，沒有勾選動態次選單的情況下
			 * 預設是沒有分類的通用分項，並且沒有日期排序
			 */

			// 自定條件
			// $condition = ' 1 ';
			// $condition_sortable = ' 1 ';

			// 沒有日期排序
			unset($this->def['listfield']['start_date']);
			$this->def['default_sort_field'] = 'sort_id';
			if(isset($this->def['default_sort_direction'])){
				unset($this->def['default_sort_direction']);
			}

			// 通用分項
			$this->def['table'] = 'html';
			$this->def['empty_orm_data']['table'] = 'html';
			$this->def['empty_orm_data']['rules'][] = array('topic','required');
			$this->def['search_keyword_field'] = array('topic');
			$this->def['search_keyword_assign_field'] = 'topic';
			$this->def['sys_log_name'] = 'topic';
			unset($this->def['listfield']['name']);
			unset($this->def['updatefield']['sections'][0]['field']['name']); // update, copy

			// 沒有分類
			//unset($this->def['searchfield']);
			unset($this->def['updatefield']['sections'][0]['field']['class_id']);
			unset($this->def['listfield']['xx2']);

			// 通用分項
			$condition = ' type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
			$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		}

		if(trim($condition) != ''){
			$this->def['condition'][] = array(
				'where',
				$condition,
			);
		}
		if(trim($condition_sortable) != ''){
			$this->def['sortable']['condition'] = $condition_sortable;
		}
		

		// 這是SEO的欄位的範本，如果你需要，就打開它 2/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php') && $_constant ){
			$seo_func = 'a';
			include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
		}

		return true;
	}


}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
