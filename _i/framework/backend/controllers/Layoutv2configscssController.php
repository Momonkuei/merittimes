<?php

class Layoutv2configscssController extends Controller {

	protected $def = array(
		'table' => 'layoutv2_config_scss',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'layoutv2_config_scss',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('name', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'name', // 預設要排序的欄位
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'condition' => array(
		//	array(
		//		'where',
		//		'',
		//	),
		//),
		//'sortable' => array(
		//	'enable' => 'true',
		//	'condition' => '', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=articlenormal1/sort', // ajax post都會有個目標
		//),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		// 建立前端要顯示的欄位
		'listfield_attr' => array(
			'smarty_include_top' => '',
		),
		'listfield' => array(
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
				// blha...
			),
		),
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'jquery.datepicker','jquery.colorpicker',
			),
			'smarty_javascript' => '',
			'smarty_javascript_text' => "
",
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data',
					'name' => 'form_data',
					'method' => 'post',
					'action' => '',
				),
				'button_style' => '1',
			),
			'sections' => array(
				// blha...
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 無法帶入的變數中的變數，在這裡帶入
		foreach($this->def['updatefield']['sections'][0]['field'] as $k => $v){
			$v['attr']['size'] = '50';
			$v['attr_td1']['width'] = '230';
			$this->def['updatefield']['sections'][0]['field'][$k] = $v;

			//if(!preg_match('/^(name|is_enable)$/', $v)){
			//}
		}

		return true;
	}

	protected function update_show_last($updatecontent)
	{
		$rows = $this->db->createCommand()->from('layoutv2_config_scss_list')->where('data_id=:id',array(':id'=>$updatecontent['id']))->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				$this->data['updatecontent'][$v['keyname']] = $v['keyval'];
			}
		}
		// 清除
		$opts = array('http'=>array('header'=>array('Referer: '.FRONTEND_DOMAIN."\r\n")));
		$context = stream_context_create($opts);
		//echo FRONTEND_LAYOUTV2.'/html/a/css/style.css?clearonly=';
		//die;
		file_get_contents(FRONTEND_LAYOUTV2.'/html/a/css/style.css?clearonly=',false,$context);
		// 重新編譯
		//file_get_contents(FRONTEND_LAYOUTV2.'/html/a/css/style.css',false,$context);
	}

	protected function update_run_last()
	{
		$this->db->createCommand()->delete('layoutv2_config_scss_list', 'data_id=:id', array(':id'=> $this->data['id']));

		if($_POST){
			$save = array();
			foreach($_POST as $k => $v){
				//if(preg_match('/^x-(.*)$/', $k)){
					$tmp = array(
						'data_id' => $this->data['id'],
						'keyname' => $k,
						'keyval' => $v,
					);
					$save[] = $tmp;
				//}
			}
			$this->cidb->insert_batch('layoutv2_config_scss_list', $save);
		}

		// 儲存後，轉到列表頁 #12645
		//$_POST['prev_url'] = $this->createUrl($this->data['router_class'].'/index');
	}

	/*
	 * 寫入預設值
	 */
	protected function create_run_last()
	{
		$this->db->createCommand()->delete('layoutv2_config_scss_list', 'data_id=:id', array(':id'=> $this->data['_last_insert_id']));

		$save = array();

		$tmp = array(
			'cis-color-1' => '#000',
			'cis-color-2' => '#333',
			'cis-color-3' => '#999',
			'imgurl' => '\'../images/\'',
			'bootstrap-sass-asset-helper' =>  'false',
			'font-family-sans-serif' => '\'Helvetica Neue\', Helvetica, Arial, sans-serif,\'Microsoft JhengHei\'',
			'font-family-monospace' => 'Menlo, Monaco, Consolas, \'Courier New\', monospace',
			'font-size-base' => '14px',
			'line-height-base' => '1.8',
			'line-height-computed' => 'floor(($font-size-base * $line-height-base))',
			'line-height-large' => '1.33',
			'line-height-small' => '1.5',
			'bootstrap-sass-asset-helper' => 'false',
			'icon-font-path' => '\'../fonts/bootstrap/\'',
			'gray-base' => '#000',
			'gray-darker' => 'lighten($gray-base, 13.5%)',
			'gray-dark' => 'lighten($gray-base, 20%)',
			'gray' => 'lighten($gray-base, 33.5%)',
			'gray-light' => 'lighten($gray-base, 46.7%)',
			'gray-lighter' => 'lighten($gray-base, 93.5%)',
			'cis-color-1-darker' => 'darken($cis-color-1, 16%)',
			'cis-color-1-dark' => 'darken($cis-color-1, 8%)',
			'cis-color-1-light' => 'lighten($cis-color-1, 8%)',
			'cis-color-1-lighter' => 'lighten($cis-color-1, 16%)',
			'cis-color-2-darker' => 'darken($cis-color-2, 16%)',
			'cis-color-2-dark' => 'darken($cis-color-2, 8%)',
			'cis-color-2-light' => 'lighten($cis-color-2, 8%)',
			'cis-color-2-lighter' => 'lighten($cis-color-2, 16%)',
			'cis-color-3-darker' => 'darken($cis-color-3, 16%)',
			'cis-color-3-dark' => 'darken($cis-color-3, 8%)',
			'cis-color-3-light' => 'lighten($cis-color-3, 8%)',
			'cis-color-3-lighter' => 'lighten($cis-color-3, 16%)',
			'brand-primary' => 'darken(#428bca, 6.5%)',
			'brand-success' => '#5cb85c',
			'brand-info' => '#5bc0de',
			'brand-warning' => '#f0ad4e',
			'brand-danger' => '#d9534f',
			'body-bg' => '#fff',
			'text-color' => '$gray-dark',
			'link-color' => '$gray-light',
			'link-hover-color' => '$cis-color-3-darker',
			'link-hover-decoration' => 'none',
			'nav-link-padding' => '5px 15px',
			'nav-link-hover-bg' => '$cis-color-3-light',
			'nav-disabled-link-color' => '$gray-light',
			'nav-disabled-link-hover-color' => '$gray-light',
			'screen-xs' => '480px',
			'screen-sm' => '768px',
			'screen-md' => '992px',
			'screen-lg' => '1200px',
			'grid-gutter-width' => '20px',
			'view-area-s' => '720px',
			'view-area-m' => '940px',
			'view-area-l' => '1140px',
			'container-tablet' => '($view-area-s + $grid-gutter-width)',
			'container-desktop' => '($view-area-m + $grid-gutter-width)',
			'container-large-desktop' => '($view-area-l + $grid-gutter-width)',
			'border-base' => '1px',
			'border-lg' => '$border-base*1.25',
			'border-sm' => '$border-base*0.75',
			'border-gray' => '$border-base solid $gray-base',
			'border-gray-dark' => '$border-base solid $gray-dark',
			'border-gray-light' => '$border-base solid $gray-lighter',
			'border-cis1' => '$border-base solid $cis-color-1',
			'border-cis1-dark' => '$border-base solid $cis-color-1-dark',
			'border-cis1-light' => '$border-base solid $cis-color-1-light',
			'border-cis2' => '$border-base solid $cis-color-2',
			'border-cis2-dark' => '$border-base solid $cis-color-2-dark',
			'border-cis2-light' => '$border-base solid $cis-color-2-light',
			'border-cis3' => '$border-base solid $cis-color-3',
			'border-cis3-dark' => '$border-base solid $cis-color-3-dark',
			'border-cis3-light' => '$border-base solid $cis-color-3-light',
			'padding-base-vertical' => '3px',
			'padding-base-horizontal' => '6px',
			'padding-large-vertical' => '10px',
			'padding-large-horizontal' => '16px',
			'padding-small-vertical' => '2px',
			'padding-small-horizontal' => '3px',
			'padding-xs-vertical' => '1px',
			'padding-xs-horizontal' => '5px',
			'border-radius-base' => '4px',
			'border-radius-large' => '6px',
			'border-radius-small' => '3px',
			'component-active-color' => '#fff',
			'component-active-bg' => '$cis-color-3',
			'caret-width-base' => '4px',
			'caret-width-large' => '$caret-width-base*1.25',
			'table-cell-padding' => '8px',
			'table-condensed-cell-padding' => '5px',
			'table-bg' => 'transparent',
			'table-bg-accent' => '#f9f9f9',
			'table-bg-hover' => '#f5f5f5',
			'table-border-color' => '#ddd',
			'navbar-height' => '50px',
			'navbar-margin-bottom' => '0',
			'navbar-border-radius' => '$border-radius-base',
			'navbar-collapse-max-height' => '340px',
			'navbar-default-color' => '$gray',
			'navbar-default-bg' => 'rgba($cis-color-3-darker,.9)',
			'navbar-default-border' => 'darken($navbar-default-bg, 6.5%)',
			'navbar-default-link-color' => 'lighten($navbar-default-bg, 50%)',
			'navbar-default-link-hover-color' => '#fff',
			'navbar-default-link-hover-bg' => '$cis-color-3-darker',
			'navbar-default-link-active-color' => '$navbar-default-link-color',
			'navbar-default-link-active-bg' => '$cis-color-3-darker',
			'navbar-default-link-disabled-color' => '$gray-light',
			'navbar-default-link-disabled-bg' => 'transparent',
			'navbar-default-brand-color' => '$navbar-default-link-color',
			'navbar-default-brand-hover-color' => 'darken($navbar-default-brand-color, 10%)',
			'navbar-default-brand-hover-bg' => 'transparent',
			'navbar-default-toggle-hover-bg' => '$cis-color-3-dark',
			'navbar-default-toggle-icon-bar-bg' => '$cis-color-3-light',
			'navbar-default-toggle-border-color' => '$cis-color-3-dark',
			'nav-pills-border-radius' => '$border-radius-base',
			'nav-pills-active-link-hover-bg' => '$cis-color-3-darker',
			'nav-pills-active-link-hover-color' => '$cis-color-3-lighter',
			'input-bg' => 'transparent',
			'input-bg-disabled' => '$gray-lighter',
			'input-color' => '$cis-color-3-darker',
			'input-border' => '$cis-color-3-light',
			'input-border-focus' => '$cis-color-3-darker',
			'input-color-placeholder' => '$cis-color-3-darker',
			'legend-border-color' => '#e5e5e5',
			'dropdown-bg' => 'rgba($cis-color-3-lighter,.9)',
			'dropdown-border' => 'rgba(0,0,0,.15)',
			'dropdown-fallback-border' => 'rgba($cis-color-3,.5)',
			'dropdown-divider-bg' => '$cis-color-3',
			'dropdown-link-color' => '$cis-color-3-darker',
			'dropdown-link-hover-color' => '$cis-color-3-lighter',
			'dropdown-link-hover-bg' => '$cis-color-3-darker',
			'dropdown-link-active-color' => '$component-active-color',
			'dropdown-link-active-bg' => '$component-active-bg',
			'dropdown-link-disabled-color' => '$cis-color-3-light',
			'dropdown-header-color' => '$gray-light',
			'dropdown-caret-color' => '#000',
			'btn-font-weight' => 'normal',
			'btn-default-color' => 'lighten($cis-color-3-lighter,20%)',
			'btn-default-bg' => '$cis-color-3-dark',
			'btn-default-border' => '$cis-color-3-darker',
			'btn-primary-color' => '$cis-color-3-darker',
			'btn-primary-bg' => 'lighten($cis-color-3-lighter,20%)',
			'btn-primary-border' => '$cis-color-3',
			'btn-success-color' => '#fff',
			'btn-success-bg' => '$brand-success',
			'btn-success-border' => 'darken($btn-success-bg, 5%)',
			'btn-info-color' => '#fff',
			'btn-info-bg' => '$brand-info',
			'btn-info-border' => 'darken($btn-info-bg, 5%)',
			'btn-warning-color' => '#fff',
			'btn-warning-bg' => '$brand-warning',
			'btn-warning-border' => 'darken($btn-warning-bg, 5%)',
			'btn-danger-color' => '#fff',
			'btn-danger-bg' => '$brand-danger',
			'btn-danger-border' => 'darken($btn-danger-bg, 5%)',
			'btn-link-disabled-color' => '$gray-light',
			'breadcrumb-padding-vertical' => '8px',
			'breadcrumb-padding-horizontal' => '15px',
			'breadcrumb-bg' => 'transparent',
			'breadcrumb-color' => '$link-color',
			'breadcrumb-active-color' => '$link-hover-color',
			'breadcrumb-separator' => '\'/\'',
			'thumbnail-padding' => '4px',
			'thumbnail-bg' => '$body-bg',
			'thumbnail-border' => '$gray-lighter',
			'thumbnail-border-radius' => '$border-radius-base',
			'thumbnail-caption-color' => '$text-color',
			'thumbnail-caption-padding' => '9px',
			'pagination-color' => '$link-color',
			'pagination-bg' => 'transparent',
			'pagination-border' => '$cis-color-3-light',
			'pagination-hover-color' => '$link-hover-color',
			'pagination-hover-bg' => '$cis-color-3-light',
			'pagination-hover-border' => '$cis-color-3',
			'pagination-active-color' => '#fff',
			'pagination-active-bg' => '$brand-primary',
			'pagination-active-border' => '$brand-primary',
			'pagination-disabled-color' => '$gray-light',
			'pagination-disabled-bg' => '#fff',
			'pagination-disabled-border' => '#ddd',
		);

		foreach($tmp as $k => $v){
			$tmp = array(
				'data_id' => $this->data['_last_insert_id'],
				'keyname' => $k,
				'keyval' => $v,
			);
			$save[] = $tmp;
		}
		$this->cidb->insert_batch('layoutv2_config_scss_list', $save);
	}

	//protected function index_last()
	//{
	//	//var_dump($this->data['listcontent']);
	//	if($this->data['listcontent']){
	//		foreach($this->data['listcontent'] as $k => $v){
	//			if($v['pic1'] != ''){
	//				$v['pic1'] = $this->data['image_upload_path'].'/articlenormal1/'.$v['pic1'];
	//			}
	//			$this->data['listcontent'][$k] = $v;
	//		}
	//	}
	//}

	//protected function update_run_other_element($array)
	//{
	//	$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
	//	$array['type'] = 'articlenormal1';
	//	return $array;
	//}

	//protected function create_run_other_element($array)
	//{
	//	$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
	//	$array['type'] = 'articlenormal1';
	//	return $array;
	//}

}
