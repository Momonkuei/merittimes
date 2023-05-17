<?php

/*
 * 2018-01-15
 * 這個跟seo.php的用處差不多
 * 不一樣的地方，就是它會自己去找_has_seov2的區塊，而不是只能放在第三個區塊位置
 */

/*
 * seo_func = a 要放在beforeAction
 * seo_func = b 要放在update_show_last
 * seo_func = c 要放在update_run_other_element，並記得之前要加這個 $array['seo_type'] = 'XXXX'; // 可能是product, category, company
 */

/*
 * 使用範例
 *
 *	protected function beforeAction($action)
 *	{
 *		parent::beforeAction($action);
 *
 *		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seo').'.php')){
 *			$seo_func = 'a';
 *			include Yii::getPathOfAlias('system.backend.controllers.seo').'.php';
 *		}
 *
 *		return true;
 *	}
 *
 *	protected function update_show_last($updatecontent)
 *	{
 *		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seo').'.php')){
 *			$seo_func = 'b';
 *			include Yii::getPathOfAlias('system.backend.controllers.seo').'.php';
 *		}
 *	}
 *
 *	protected function update_run_other_element($array)
 *	{
 *		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
 *		$array['type'] = 'XXX';
 *
 *		$array['seo_type'] = 'company';
 *		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seo').'.php')){
 *			$seo_func = 'c';
 *			include Yii::getPathOfAlias('system.backend.controllers.seo').'.php';
 *		}
 *
 *		return $array;
 *	}
 */

if(isset($seo_func) and isset($this->data['sys_configs']['has_seo_'.$this->data['admin_switch_data_ml_key']]) and $this->data['sys_configs']['has_seo_'.$this->data['admin_switch_data_ml_key']] == '1'){
	$acl = new Admin_acl();
	$acl->start();
	if(file_exists(Yii::getPathOfAlias('system.backend.controllers.SeoController').'.php') and $acl->hasAcl($this->data['admin_id'], 'seo', 'update') and $this->data['router_method'] == 'update'){
		if($seo_func == 'a'){
			$contentx = file_get_contents(Yii::getPathOfAlias('system.backend.controllers.SeoController').'.php');
			$contentx = str_replace('<'.'?'.'php', '', $contentx);
			$contentx = str_replace('extends Controller', '', $contentx);
			$contentx = str_replace('protected $def', 'static public $def', $contentx);
			eval($contentx);
			$admin_def = SeoController::$def;
			$admin_field = $admin_def['updatefield']['sections'][0]['field']; // SEO的相關欄位
			unset($admin_field['seo_is_enable']);
			$admin_field['seo_type']['type'] = 'hidden';
			// 只是想在每一個標題前加上全型空白而以
			foreach($admin_field as $k => $v){
				$v['label'] = '　'.$v['label'];
				$admin_field[$k] = $v;
			}
			// 想要加個標題而以
			$tmp = array(
				'xx01' => array(
					'label' => 'SEO：',
					'type' => 'inputn',
					'other' => array('html'=>''),
				)
			);
			// 想要加個刪除而以
			$tmp2 = array(
				'　g_seo_need_delete' => array(
					'label' => '　刪除此筆SEO',
					'type' => 'status',
					'attr' => array(
						'id' => 'g_seo_need_delete',
						'name' => 'g_seo_need_delete',
					),
					'other' => array(
						'default' => '0',
						'other1' => '刪除',
						'other2' => '不動作',
					),
				),
			);
			$admin_field = $tmp + $admin_field + $tmp2;

			// 舊的寫法
			// $this->def['updatefield']['sections'][2]['field'] = $admin_field;

			$has_seov2 = false;
			foreach($this->def['updatefield']['sections'] as $k => $v){
				if(isset($v['_has_seov2']) and $v['_has_seov2'] === true){
					$has_seov2 = true;
					$this->def['updatefield']['sections'][$k]['field'] = $admin_field;
				}
			}

			// 向下支援
			if($has_seov2 === false){
				$this->def['updatefield']['sections'][2]['field'] = $admin_field;
			}
		} elseif($seo_func == 'b'){
			$row = $this->db->createCommand()->from('seo')->where('seo_item_id=:id and seo_ml_key=:ml_key and seo_type=:type',array(':id'=>$this->data['updatecontent']['id'],'ml_key'=>$this->data['admin_switch_data_ml_key'],':type'=>'company'))->queryRow();
			if($row){
				$this->data['updatecontent'] = $this->data['updatecontent'] + $row;
			}
		} elseif($seo_func == 'c'){
			// 相關的欄位
			$array['seo_ml_key'] = $this->data['admin_switch_data_ml_key'];
			$array['seo_item_id'] = $array['hidden_id'];

			// 先刪在說
			$this->cidb->where(array('seo_item_id'=>$array['seo_item_id'],'seo_ml_key'=>$this->data['admin_switch_data_ml_key'],'seo_type'=>$array['seo_type']))->delete('seo');

			// 看一下是否都有填，全部沒填就跳過
			$fields = array(
				'seo_keyword',
				'seo_title',
				'seo_script_name',
				//'seo_path', // 不知做什麼用的
				'seo_link_alt',
				'seo_photo_alt',
				'seo_photo_l_alt',
				'seo_photo_m_alt',
				'seo_photo_s_alt',
				'seo_photo_index_alt',
				'seo_meta_keyword',
				'seo_meta_description',
				'seo_meta_copyright',
				//'seo_copyright', // 不知做什麼用的
			);
			$disabled_seo = true;
			foreach($fields as $k => $v){
				if(isset($array[$v]) and $array[$v] != ''){
					$disabled_seo = false;
					break;
				}
			}

			// 是不是只有輸入keyword，如果是，就順便帶入幾個欄位
			$fields = array(
				//'seo_keyword',
				'seo_title',
				'seo_script_name',
				//'seo_path', // 不知做什麼用的
				//'seo_link_alt',
				//'seo_photo_alt',
				//'seo_photo_l_alt',
				//'seo_photo_m_alt',
				//'seo_photo_s_alt',
				//'seo_photo_index_alt',
				'seo_meta_keyword',
				'seo_meta_description',
				//'seo_meta_copyright',
				//'seo_copyright', // 不知做什麼用的
			);
			if(isset($array['seo_keyword']) and $array['seo_keyword'] != ''){
				$need_assign = true;
				foreach($fields as $k => $v){
					if(isset($array[$v]) and $array[$v] != ''){
						$need_assign = false;
						break;
					}
				}
				if($need_assign){
					foreach($fields as $k => $v){
						$array[$v] = $array['seo_keyword'];
					}
				}
			}

			// 預設是不刪除
			if(isset($array['g_seo_need_delete']) and $array['g_seo_need_delete'] <= 0){
				// do nothing
			} else {
				$disabled_seo = true;
			}

			if(!$disabled_seo){
				// 刪完後寫入
				$empty_orm_data = array(
					'table' => 'seo',
					'created_field' => 'seo_create_time', 
					//'updated_field' => 'update_time',
					'primary' => 'id',
					'rules' => array(
						array('seo_type, seo_ml_key', 'required'),
					),
				);

				//$c = new Empty_orm('insert', $empty_orm_data);
				////$c->autoaddcolumn($savedata);
				//$c->setAttributes($savedata);
				//$c->save();

				// 寫入驗證碼到該會員資料表
				eval($this->data['empty_orm_eval']);
				$u = new $name('insert', $empty_orm_data);
				// 修改專用
				//$u = $c::model()->findByPk($row['id']);
				$u->setAttributes($array);
				if(!$u->save()){
					G::dbm($u->getErrors());
				}
			}
		} else {
			// do nothing
		} // abc
	} // SeoController check
} // seo_func end
