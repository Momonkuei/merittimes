<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,

		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('topic', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('topic'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'topic', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'topic', // 要給sys_log記錄名稱欄位值的設定
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
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			'topic' => array(
				'label' => '簡述',
				'width' => '10%',
				'sort' => true,
			),
			'video_2' => array(
				'label' => '元素 (好記的名子)',
				'width' => '10%',
				'sort' => true,
			),
			'video_1' => array(
				'label' => '資料流',
				'width' => '10%',
				'sort' => true,
			),
			'is_news' => array(
				'label' => '自動載入',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_news',
				'ezother'=> '&nbsp;',
			),
			'is_top' => array(
				'label' => 'Debug first',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_top',
				'ezother'=> '&nbsp;',
			),
			'is_home' => array(
				'label' => 'Debug',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_home',
				'ezother'=> '&nbsp;',
			),
			'is_enable' => array(
				'label' => '狀態',
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
			),
			'sort_id' => array(
				'label' => '排序',
				'width' => '8%',
				'align' => 'center',
				'sort' => true,
			),
			'id' => array(
				'label' => '編號',
				'width' => '8%',
				'align' => 'center',
			),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', //'fileuploader',
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
				),
				'button_style' => '2',
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'gg01' => array(
							'label' => '',
							'type' => 'label',
						),
						'iframe01' => array(
							'label' => '資料預覽<br /><a href="javascript:;" id="iframe01_open">(打開 / 關閉)</a><br />',
							'type' => 'iframe',
							'attr' => array(
								'id' => 'iframe01',
								'width' => '100%',
								'height' => '400px',
								'src' => '',
								//'src' => 'index_tw.php?__print_table__=1',
							),
							'other' => array(
								'html_start' => '<span id="iframe01_area">',
								'html_end' => '</span>',
							),
						),
						'topic' => array(
							'label' => '簡述',
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						'video_1' => array(
							'label' => '資料流',
							'type' => 'input',
							'attr' => array(
								'id' => 'video_1',
								'name' => 'video_1',
								'size' => '40',
							),
// <span style="color:red"><b>v3_source:XXX,YYY</b></span> 載入V3的程式碼，XXX是不含source/的路徑，而YYY是router_method，這個是V3架構專用的，不支援含有DATA2資料流的程式<br />
							'other' => array(
								'html_end' => '<br />
<span style="color:red"><b>webmenu:XXX</b></span> 主選單，XXX是位置<br />
　有top、bottom、mobile、other1、other2，分別是下方選單的無限層資料，與手機版選單的無限層資料<br />
　還有(位置)___(變數)___(數值)可以更進階的改變核心程式碼的運作<br />
　例如：top___common_has_category_item___1 (取得上方主選單，功能、分類、分項的所有階層資料)<br />
<span style="color:red"><b>top_link_menu:XXX</b></span> 副功能列，XXX是位置，有top和bottom(手機版)，還有空白(PC版)，分別是下方選單的無限層資料，與手機版選單的無限層資料<br />
<span style="color:red"><b>breadcrumb:</b></span> 麵包屑，別忘了首頁沒有<br />
<span style="color:red"><b>v3_source:XXX,YYY</b></span> 載入V3的程式碼，XXX是不含source/的路徑，而YYY是router_method(optional)，這個是V3架構專用的，不支援含有DATA2資料流的程式<br />
　└ v3_source:system/general_item,news (通用資料流範例 - 最新消息)<br />
　└ v3_source:menu/sub,news (懷舊次選單範例 - 最新消息)<br />
　└ v3_source:news/detail,newsdetail (內頁範例 - 最新消息)<br />
<span style="color:red"><b>custom:XXX</b></span> XXX是資料表，而條件可以完全要自己指定<br />
<span style="color:red"><b>其它</b></span> $data[其它]的陣列資料，上面的那個"使用範例"，就是這個例子，$this->data[其它]也可以<br />
<span style="color:red"><b>html:XXX</b></span> 通用資料表，XXX是型態名稱，或是稱為功能名稱<br />
　└ html:webmenu 前台主選單，建議使用上面webmenu:XXX的資料流<br />
　└ html:webmenusub 前台副功能列，建議使用上面top_link_menu:XXX的資料流<br />
　└ html:company 公司簡介<br />
　└ html:newstype 最新消息 - 通用分類(通常)<br />
　└ html:news 最新消息 - 分項(通常)<br />
　└ html:video 影音專區 - 分項(通常)<br />
　└ html:faq 常見問題 - 分項(通常)<br />
　└ html:location 服務據點 - 分項(通常)<br />
<span style="color:red"><b>XXX:</b></span> 獨立資料表，XXX是資料表名稱，如果資料表名稱是其它資料流的保留字，可以加上星號(*)。<br />
　└ webmenuchild: 前台次選單(靜態)，建議搭配下方"分項階段 - index"的專用規則<br />
　└ producttype: 產品 - 獨立分類(通常)<br />
　└ product: 產品 - 獨立分項(通常)<br />
',
							),
						),
						'video_2' => array(
							'label' => '元素名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'video_2',
								'name' => 'video_2',
								'size' => '20',
							),
							'other' => array(
								'html_end' => '預設是"{資料流名稱}_{編號}"，例如$this->data[\'資料流名稱_編號\']，在這裡，你能修改它',
							),
						),
						'is_enable' => array(
							//'label' => 'ml:Status',
							'mlabel' => array(
								null, // category
								'Status', // label
								array(), // sprintf
								'狀態', // default
							),
							'type' => 'status',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'default'=>'1',
								'html_start' => '<div class="radio-list">',
								'html_end' => '</div>',
							),
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		if(isset($_GET['dataonly'])){
			echo '<meta charset="utf-8" />';
			$layoutv3_datasource_id = $_GET['dataonly'];
			$layoutv3_enable_force = true;
			include _BASEPATH.'/../layoutv3/dom5/datasource.php';
			new dBug($content,'',true);
			die;
		}

		$this->def['updatefield']['smarty_javascript_text'] = <<<XXX
$('#iframe01_area').hide();
$('#iframe01_open').click(function(){
	$('#iframe01_area').toggle();
});
XXX;

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\'  ';
		$this->def['sortable']['condition'] = 'type="'.$this->data['router_class'].'" ';
		// $this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		// $this->def['sortable']['condition'] = 'type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

		$map = array(
			1  => array(1,2),
			2  => array(3,4),
			3  => array(5,6),
			4  => array(7,8),
			5  => array(9,10),
			6  => array(11,12),
			7  => array(13,14),
			8  => array(15,16),
			9  => array(17,18),
			10 => array(19,20),
		);
		$this->data['map'] = $map;
		for($x=1;$x<=10;$x++){

			$a = $map[$x][0];
			$b = $map[$x][1];

			$this->def['updatefield']['sections'][1]['field']['other'.$a] = array(
				'label' => '　規則'.$x,
				'type' => 'select3',
				'merge' => 1,
				'attr' => array(
					'id' => 'other'.$a,
					'name' => 'other'.$a,
				),
				'other' => array(
					'values' => array(
						'' => '請選擇',
						'andwhere' => 'ActiveRecord - where (2)',
						'andlike' => 'ActiveRecord - like (3)',
						'orderby' => 'ActiveRecord - order by (1)',
						'get' => '其它 - $_GET',
						'pidas' => '分項 / 無限層階段 - pidas (1) || 改變PID欄位依據',
						'filter_key' => '分項階段 - filter_key (1) || $rows["aa"]["bb"]裡面有10筆，那aa.bb就會取到10筆',
						'filter_key2' => '分項階段 - filter_key2 (1) || $rows["a"]["b"]["c"]有10筆，那a.b.c就會取到 c等於那10筆',
						'callfunc' => '分項階段 - callfunc (3) || CC = AA(BB)，CC會成為新的欄位',
						'search_table_by_field_get_one' => '分項階段 - 分項增加分類名稱 (5) || * 只能用在通用分項，搭配通用分類的情況下',
						'filter' => '分項階段 - filter (2) || 只留下根層的什麼欄位(A)，內容(B)是什麼的資料',
						'index' => '分項階段 - index (2) || 前台次選單(靜態)專用，什麼欄位(A)的內容是什麼(B)',
						'condition_append_element' => '無限層階段 - 符合某個條件，就加上新欄位和值 (5) if(AA BB CC) KK=VV',
						'depth_append_element' => '無限層階段 - 在某一層(A)加上某個新欄位(B)和值(C) (3) ',
						'search_and_get_element' => '資料流結尾 - if(AA == BB) get CC (通常CC是child) (3)',
						'pagenav' => '資料流結尾 - pagenav (3) || 分頁，參數是：新變數名, 一頁幾筆, 網址',
						'assign' => '資料流結尾 - assign (1) || assign to $data[XXX]',
						'depth' => '遞迴階段 - depth (1) || 限制深度只有幾層 - (Render)',
						'limit' => '遞迴階段 - limit (2) || 限制第幾層(A)的資料筆數為幾筆(B) - (Render)',
						'child_class' => '遞迴階段 - child_class (2) || 如果有子層的時候，就加上新欄位(A)和值(B) - (Render)',
					),
					'default' => '',
				),
			);
			$this->def['updatefield']['sections'][1]['field']['other'.$b] = array(
				'label' => '&nbsp;',
				'type' => 'input',
				'merge' => 3,
				'attr' => array(
					'id' => 'other'.$b,
					'name' => 'other'.$b,
					'size' => 70,
				),
			);
			$this->def['updatefield']['sections'][1]['field']['xx'.$x] = array(
				'label' => '&nbsp;',
				'type' => 'label',
			);
		}

		// 2018-08-06 為了修正麵包屑的問題
		$this->def['updatefield']['sections'][1]['field']['other21'] = array(
			'label' => '自定規則',
			'type' => 'input',
			'attr' => array(
				'id' => 'other21',
				'name' => 'other21',
				'size' => 70,
			),
			'other' => array(
				'html_end' => '<br />
single_to_multi_check_ignore:1, 強制轉無限層<br />
single_to_multi_flow_pass:1, 取消轉成無限層資料流的動作<br />
webmenu_navlight_name:navlight_webmenu_, 自定無限層的li的id的prefix名稱<br />
enableurl_by_subclass_haschild:1, // 有次分類的分類，連結是否有效(1:有效)<br />
',
			),
		);

		return true;
	}

	protected function create_show_last()
	{
		unset($this->data['def']['updatefield']['sections'][0]['field']['iframe01']);
	}

	protected function update_show_last($updatecontent)
	{
		$this->data['def']['updatefield']['sections'][0]['field']['iframe01']['attr']['src'] = 'backend.php?r=datasource&dataonly='.$updatecontent['id']; 

		for($x=1;$x<=10;$x++){
			$a = $this->data['map'][$x][0];
			$b = $this->data['map'][$x][1];

			if($this->data['updatecontent']['other'.$a] != ''){
				if($this->data['updatecontent']['other'.$a] == 'ggg'){
					// do nothing
				} elseif($this->data['updatecontent']['other'.$a] == 'andwhere'){
					$this->data['updatecontent']['xx'.$x] = 'XXX---YYY XXX是欄位名稱，例如is_home，或是is_home !=，而YYY是它的數值';
				} elseif($this->data['updatecontent']['other'.$a] == 'andlike'){
					$this->data['updatecontent']['xx'.$x] = 'XXX---YYY---ZZZ XXX是欄位名稱，YYY是like什麼字串，最後ZZZ是%的位置，有0123，分別是both,before,after,none';
				} elseif($this->data['updatecontent']['other'.$a] == 'orderby'){
					$this->data['updatecontent']['xx'.$x] = 'XXX XXX是欄位名稱，如果沒有指定這個條件，預設是用sort_id';
				} elseif($this->data['updatecontent']['other'.$a] == 'get'){
					$this->data['updatecontent']['xx'.$x] = 'XXX---YYY 指定GET[XXX] = YYY';
				} elseif($this->data['updatecontent']['other'.$a] == 'pidas'){
					$this->data['updatecontent']['xx'.$x] = 'XXX XXX是欄位名稱，可修改無限層結構的pid欄位名稱';
				} elseif($this->data['updatecontent']['other'.$a] == 'index'){
					$this->data['updatecontent']['xx'.$x] = 'name---shop_footer_link (欄位name的值，如果是shop_footer_link，那就把它該節點當做索引，把它底下的子層，當做根層，重建無限層資料結構)，無限層結構限定 (*給設計用)';
				} elseif($this->data['updatecontent']['other'.$a] == 'filter'){
					$this->data['updatecontent']['xx'.$x] = 'id---87 只留下根層的欄位id為87的資料，無限層結構限定 (*winnie)';
				} elseif($this->data['updatecontent']['other'.$a] == 'filter_key'){
					$this->data['updatecontent']['xx'.$x] = 'XXX 各元素裡面(key)，存放多層架構，取得該value的內容，可以用"點"來當做階層的分隔';
				} elseif($this->data['updatecontent']['other'.$a] == 'filter_key2'){
					$this->data['updatecontent']['xx'.$x] = 'XXX 跟filter_key很像，不一樣的是，會留下該key的內容(含key)';
				} elseif($this->data['updatecontent']['other'.$a] == 'callfunc'){
					$this->data['updatecontent']['xx'.$x] = 'XXX---YYY---ZZZ XXX是函式名稱(例：trim)，YYY是欄位名稱，ZZZ是新欄位名稱';
				} elseif($this->data['updatecontent']['other'.$a] == 'search_table_by_field_get_one'){
					$this->data['updatecontent']['xx'.$x] = '資料表(1)，分項欄位(2)對應到分類的那個欄位(3)，找到後，分類的欄位(4)，存成新的分項欄位(5)<br />
例：最新消息增加分類名稱 html---class_id---id---topic---class_name (分類和分項，同時都是通用資料表的範例)';
				} elseif($this->data['updatecontent']['other'.$a] == 'condition_append_element'){
					$this->data['updatecontent']['xx'.$x] = 'AAA|BBB|CCC---XXX---YYY 符合某個條件，就加上某個欄位，判斷式(AAA|BBB|CCC，例如name == 123，其中BBB位置可以為 %2== ，可以做偶數和奇數的判斷)，接下來XY是key-value';
				} elseif($this->data['updatecontent']['other'.$a] == 'depth_append_element'){
					$this->data['updatecontent']['xx'.$x] = 'XXX---YYY---ZZZ 在某一層加上某個欄位，XXX是數字層級，接下來YZ是key-value';
				} elseif($this->data['updatecontent']['other'.$a] == 'search_and_get_element'){
					$this->data['updatecontent']['xx'.$x] = 'XXX---YYY---ZZZ 搜尋第一層的欄位(XXX==YYY)，取得它的欄位值(ZZZ)，那個欄位裡面至少要包含分項的結構，抓到以後才是多筆，例如：child';
				} elseif($this->data['updatecontent']['other'.$a] == 'pagenav'){
					$this->data['updatecontent']['xx'.$x] = 'XXX---YYY---ZZZ 分頁功能，XYZ分別是：新變數名, 一頁幾筆, 網址。如果只有一頁，可以在分頁的HTML頂層，加上id或是class為_dom5_layer_pagenav_，條件成立時，就會刪掉';
				} elseif($this->data['updatecontent']['other'.$a] == 'assign'){
					$this->data['updatecontent']['xx'.$x] = 'XXX 把處理完後的東西，另存成一個新的變數，存到$data[XXX]';
				} elseif($this->data['updatecontent']['other'.$a] == 'depth'){
					$this->data['updatecontent']['xx'.$x] = '1 限制深度只有一層';
				} elseif($this->data['updatecontent']['other'.$a] == 'limit'){
					$this->data['updatecontent']['xx'.$x] = '1---4 限制第一層的資料筆數為四筆。通用資料表，請先使用pidas條件，指定一個常為零的欄位，這樣子才會有深度欄位產出';
				} elseif($this->data['updatecontent']['other'.$a] == 'child_class'){
					$this->data['updatecontent']['xx'.$x] = 'XXX---YYY 當有子層的時候，要顯示什麼class名稱，而XY是key-value (*starr)';
				}
			}
		}

		$topic = $this->data['updatecontent']['topic'];
		$datasource = $this->data['updatecontent']['video_1'];
		$id = $this->data['updatecontent']['id'];
		$data_name = str_replace(':','_',$datasource).'_'.$this->data['updatecontent']['id']; // $this->data['XXX']用
		$data_name2 = $this->data['updatecontent']['video_2']; // $this->data['好記的名稱']用

		$good_name = '';
		if($this->data['updatecontent']['is_news'] == 1 and $data_name2 != ''){
			$good_name = "\n".'$this-&gt;data[\''.$data_name2.'\'] = $content; // 好記的名稱';
		}

		$tmps = array();
		for($x=1;$x<=10;$x++){
			$a = $this->data['map'][$x][0];
			$b = $this->data['map'][$x][1];
			if($this->data['updatecontent']['other'.$a] != '' and $this->data['updatecontent']['other'.$b] != ''){
				$tmps[] = $this->data['updatecontent']['other'.$a].':'.$this->data['updatecontent']['other'.$b];
			}
		}
		$layer_params = implode(',', $tmps);

		$this->data['updatecontent']['gg01'] = <<<XXX
<pre>
&lt;?php if(1):?&gt;&lt;!-- head_(如果有alert，請關掉並刪掉括號內容)start --&gt;
&lt;?php
// http://網站的網址/_i/backend.php?r=datasource/update&amp;param=v$id
// $topic - $datasource
// $layer_params
\$layoutv3_datasource_id = $id;
include GGG_BASEPATH.'../../layoutv3/dom5/datasource.php';
// var_dump(\$content);
// \$row = \$content;
\$this-&gt;data['$data_name'] = \$content;$good_name
if(isset(\$this-&gt;data['$data_name']) and count(\$this-&gt;data['$data_name']) > 0){
&nbsp;&nbsp;&nbsp;&nbsp;foreach(\$this-&gt;data['$data_name'] as \$k => \$v){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// 客製欄位使用
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// blha blha 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this-&gt;data['$data_name'][\$k] = \$v;
&nbsp;&nbsp;&nbsp;&nbsp;}
}
// var_dump(\$this-&gt;data['$data_name']);
// \$data[\$ID] = \$this-&gt;data['$data_name'];
?&gt;
&lt;?php if(0)://V1第二版的無限層資料輸出範例，如果想要看看，?&gt;
&lt;ul l="layer" ls="$data_name"&gt;
	&lt;li l="list" &gt;&lt;a href="#"&gt;{/name/}{/topic/}&lt;/a&gt;
		{/child/}
	&lt;/li&gt;
	&lt;ul l="box"&gt;{split}&lt;/ul&gt;
&lt;/ul&gt;
&lt;?php endif?&gt;
&lt;?php if(isset(\$this-&gt;data['$data_name']) and count(\$this-&gt;data['$data_name']) > 0):?&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php foreach(\$this-&gt;data['$data_name'] as \$k => \$v):?&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php // echo \$v['id']?&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php endforeach?&gt;
&lt;?php endif?&gt;
&lt;?php endif?&gt;&lt;!-- head_(如果有alert，請刪掉括號內容)start --&gt;
</pre>
XXX;
	}

	protected function update_run_other_element($array)
	{
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['type'] = $this->data['router_class'];
		return $array;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
