<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'disable_create' => true,
		'disable_delete' => true,
		'table' => 'chat_message',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'chat_message',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
			),
		),
		'default_sort_field' => 'create_time', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('detail'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'detail', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'detail', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'condition' => array(
			array(
				'where',
				'',
			),
		),
		'listfield' => array(
			//'room_id' => array(
			//	'label' => '房間編號',
			//	//'mlabel' => array(
			//	//	null, // category
			//	//	'Title', // label
			//	//	array(), // sprintf
			//	//	'標題', // default
			//	//),
			//	'width' => '30%',
			//	'sort' => true,
			//),
			'last_message' => array(
				'label' => '最後訊息',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			'create_time' => array(
				'label' => '時間',
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
			),
		),
		// 定義修改要顯示的欄位
		'updatefield' => array(
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
					'onsubmit' => 'return false;',
				),
				'button_style' => '2',
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						//'room_id' => array(
						//	'label' => '房間編號',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'topic',
						//	//	'name' => 'topic',
						//	//	'size' => '40',
						//	//),
						//),
						'detailg' => array(
							'label' => '訊息',
							'type' => 'input',
							'merge' => 1,
							'attr' => array(
								'id' => 'detailg',
								'name' => 'detailg',
								'size' => '40',
							),
						),
						'xx01' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'merge' => 3,
							'other' => array(
								'html' => '<button id="submit01" class="btn blue" type="submit">送出訊息</button>',
							),
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						'message' => array(
							'label' => '&nbsp;',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'message',
								'name' => 'message',
								'rows' => '20',
								'cols' => '40',
							),
						),
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		$website_id = 1;
		$this->data['website_id'] = $website_id;

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'detail=\'__init__\' and website_id='.$this->data['website_id'].' ';

		if(isset($_GET['param'])){
			$parameter = new Parameter_handle;
			$params = $parameter->get($_GET['param']);
			if(isset($params['value'][0]) and $params['value'][0] > 0){
				$id = $params['value'][0];
				$rowgg = $this->cidb->where('id',$id)->get('chat_message')->row_array();
				$room_id = $rowgg['room_id'];
				$member_id = $this->data['admin_id'];
				$this->def['updatefield']['smarty_javascript_text'] = <<<XXX
$(document).ready(function(){

	var room_id = '$room_id';
	var website_id = '$website_id';
	var member_id = '$member_id';

	// if (typeof $.cookie('room_id') === 'undefined'){
	// 	room_id = makeid();
	// 	$.cookie('room_id', room_id);
	// } else {
	// 	room_id = $.cookie('room_id');
	// }

	// $('#room_id').attr('value', room_id);

	function load(room_id) {
		data = {
			func:'read_member',
			website_id:website_id,
			room_id:room_id
		};
		setInterval(function () {
			$.ajax({
				url: "/chat/server.php",
				type: "POST",
				data: data,
				dataType: 'html',  
				success: function (result) {
					$('#message').html(result);
					//alert(result);
				}
				//complete: load
			});

		}, 2000);
	}
	load(room_id);

	$('#submit01').click(function(){
		datag = {
			func:'save_member',
			website_id:website_id,
			room_id:room_id,
			member_id:member_id,
			detail: $('#detailg').attr('value')
		};
		$.ajax({
			url: "/chat/server.php",
			type: "POST",
			data: datag,
			dataType: 'html',  
			success: function (result) {
				$('#detailg').attr('value','');
				//alert(result);
			}
		});
	});

});
XXX;
			}
		} else {
				$this->def['searchfield']['smarty_javascript_text'] = <<<XXX
function myrefresh()
{
     window.location.reload();
}
setTimeout('myrefresh()',5000);

//\$('.container-fluid').find('.row',1).find('.portlet',1).hide();
\$('.portlet-title').parent().hide();
XXX;
		}


		return true;
	}

	protected function update_show_last($updatecontent)
	{
		$this->data['router_method_view'] = '1';
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
