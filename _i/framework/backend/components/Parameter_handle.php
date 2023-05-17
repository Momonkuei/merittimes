<?php

/**
 * 這個是處理controller引數的程序，把1個引數，透過切割(-)，抓出裡面的變數出來
 *
 * 以下是網址引數的格式，請把括號拿掉來看
 * http://adminurl.net/product/index/p(3)-r(1)-l(10)-f(sort_id)-s(fdsafdsafds)-v999-vaaa-vnnn
 *
 * 有些功能變數會寫入session，依照每個controller的英文名稱去存
 * 例如搜尋。
 *
 * 以下的引數模式定義，是可以替換的，主導寫在後端，改了後端，前端也會跟著改
 *
 * 當第一次用get或是post送搜尋的時候，會將分頁改成1，其它時候不會改
 *
 * @p 所要去的分頁，它的編號(CurrentPageNumber)
 * @r 每幾筆分成1頁(TotalRecord)
 * @l 每次顯示的分頁數量，例如1~10或是10~20(ListPage)這個可能暫時不會使用，因為可能是固定的
 * @f 要排序的欄位(FieldSort)
 * @s string SearchKeyword(思考一下要不要這樣子做，或是參考一下sjcoudweb v2)應該要先做encode的動作
 * @z 移除搜尋
 *
 * @v 除了上面以外，其它的就是parameter群，依照順序(Values)
 *
 * 底下是使用的範例：
 * public function index($param = '')
 * {
 *		$this->load->library('Parameter_handle', '', 'parameter');
 *		$params = $this->parameter->get($param);
 *		$param_define = $this->data['parameter'] = $this->parameter->getDefine();
 * 
 *		$this->load->library('base64url');
 * 
 *		// 排序的欄位
 *		if($params['sort'] == ''){
 *			// 這裡指定預設要排序的欄位
 *			$sort_field = $this->def['default_sort_field'];
 *		} else {
 *			$sort_field = $this->base64url->decode($params['sort']);
 *		}
 *		$this->data['sort_field'] = $this->base64url->encode($sort_field);
 *		$this->data['sort_field_nobase64'] = $sort_field;
 * 
 *		// 排序欄位的方向(asc, desc)
 *		if($params['direction'] == ''){
 *			$sort_direction = 'asc';
 *			$next_sort_direction = 'desc';
 *		} else {
 *			$sort_direction = $params['direction'];
 *			if($sort_direction == 'asc'){
 *				$next_sort_direction = 'desc';
 *			} else {
 *				$next_sort_direction = 'asc';
 *			}
 *		}
 *		$this->data['sort_direction'] = $sort_direction;
 *		$this->data['next_sort_direction'] = $next_sort_direction;
 *
 *		// 設定每頁顯示的筆數
 *		if($params['record'] != ''){
 *			$record = $params['record'];
 *			$this->session->set_userdata('record', (int)$record);
 *		} else {
 *			$record = $this->session->userdata('record');
 *			if($record === false or $record == ''){
 *				$record = '10';
 *				$this->session->set_userdata('record', (int)$record);
 *			}
 *		}
 *		$this->data['record'] = (int)$record;
 *
 *		// 分頁區塊
 *		$this->load->library('splitpage');
 *		$this->splitpage->set($params['page'], $total_rows, $record, $params['list']); //set($page, $total_records, $records_per_page, $listPage)
 *		$base_url = $this->config->item('base_url').'/'.$this->data['router_class'];
 *		if(isset($params['module_serial_id']) and $params['module_serial_id'] != ''){
 *			$base_url .= '_'.$params['module_serial_id'];
 *		}
 *		$base_url .= '/'.$this->data['router_method'];
 *		$base_url2 = $base_url;
 *		$base_url .= '/'.$this->parameter->getDefine('page');
 *		$this->data['pagination'] = $this->splitpage->setViewList_for_rewrite($base_url, $base_url2); // 取得分頁bar的變數
 *
 *		// 取得資料
 *        $u = new $this->def['orm']();
 *		if($search_keyword != '' and isset($this->def['search_keyword_field']) and count($this->def['search_keyword_field']) > 0){
 *			// 範例SQL語法，因為要括號起來，比較特別，所以在這裡寫個範例
 *			// select * from html where type='faq' and ml_key='en' and (topic like '%b%' or detail like '%b%')
 *			$search_sql_append = '(';
 *			$search_sql_appends = array();
 *			foreach($this->def['search_keyword_field'] as $k => $v){
 *				$search_sql_appends[] = ' `'.$v.'` LIKE \'%'.$search_keyword.'%\' ';
 *			}
 *			$search_sql_append .= implode(' OR ', $search_sql_appends);
 *			$search_sql_append .= ')';
 *			$u->where($search_sql_append);
 *		}
 *		$u->limit($record, ($params['page']-1)*$record);
 *		$u->order_by($sort_field, $params['direction']);
 *		if(isset($this->def['condition'])){
 *			// @k active record method
 *			// @v array, string
 *			foreach($this->def['condition'] as $k => $v){
 *				$u->{$k}($v);
 *			}
 *		}
 *		$u->get();
 *		$listcontent = array();
 *		if($u->result_count() > 0){
 *			 $listcontent = $u->all_to_array();
 *		}
 *		$this->data['listcontent'] = $listcontent;
 * } // end function index
 */
class Parameter_handle {

	protected $_splitchar = '-';

	protected $_define_a = array(
		'module_serial_id' => 'm', // 模組
		'page' => 'p', // 第幾頁，或是從第幾筆開始
		'record' => 'r', // 幾筆一頁
		'list' => 'l', // 一次顯示幾個分頁
		'sort' => 'f', // 要排序的欄位
		'direction' => 'e',  // 排序的方向
		'search' => 's', // 要搜尋的字串(base64)
		'nosearch' => 'z', // 移除搜尋
		'prev' => 'a', // 記錄上一頁的完整網址(base64)
		'value' => 'v', // 真正程式的引數
	);

	// 值不能為value
	protected $_define_b = array(
		'm' => 'module_serial_id',
		'p' => 'page', // 第幾頁
		'r' => 'record', // 幾筆一頁
		'l' => 'list', // 一次顯示幾個分頁
		'f' => 'sort', // 要排序的欄位
		'e' => 'direction', // 排序的方向desc, asc
		's' => 'search', // 要搜尋的字串
		'z' => 'nosearch', // 移除搜尋
		'a' => 'prev', // 記錄上一頁的完整網址
		'v' => 'value', // 真正程式的引數
	);

	// 預設值
	protected $_define_c = array(
		'module_serial_id' => '',
		'page' => 1, // 適合從1開始的分頁函式(splitpage)，入賢版的分頁是從0零開
		'record' => '',
		'list' => 10,
		'sort' => '',
		// 想要改成空白，我為我有另外為它準備程式碼填預設值
		//'direction' => 'asc', // desc, asc
		'direction' => '', // desc, asc
		'search' => '',
		'nosearch' => '',
		'prev' => '',
		'value' => array(), // 2019-04-19 php7
		//'value' => '',
	);

	public function getDefine($aaa = '')
	{
		if($aaa != ''){
			return $this->_define_a[$aaa];
		}

		return $this->_define_a;
	}

	/**
	 * @default_params	array	會重新覆蓋欄位預設值(_define_c)
	 */
	function __construct($default_params = array())
	{
		$this->_define_c = array_merge($this->_define_c, $default_params);
	}

	public function splitchar($splitchar)
	{
		$this->_splitchar = $splitchar;
	}

	/*
	 * 設定網址變數，每個參數開頭的英文字母
	 */
	public function seta($data)
	{
		$this->_define_a = array_merge($this->_define_a, $data);
	}
	public function setb($data)
	{
		$this->_define_b = array_merge($this->_define_b, $data);
	}

	public function setc($data)
	{
		$this->_define_c = array_merge($this->_define_c, $data);
	}

	public function get($param)
	{
		$return = $this->_define_c;

		// 設定空的
		//if(isset($this->_define_b) and count($this->_define_b) > 0){
		//	foreach($this->_define_b as $k => $v){
		//		$return[$v] = '';
		//	}
		//	$return['value'] = array();
		//}

		// 檢查有沒有切割字元
		//if(!preg_match('/'.$this->_splitchar.'/', $param)){
		//   	return $return;
		//}

		$params_split = explode($this->_splitchar, $param);

		// 切割後，做match配對
		if(count($params_split) > 0){
			foreach($params_split as $k => $v){
				$tmp1 = '';
				if(strlen($v) > 1){
					$tmp1 = substr($v, 1);
				}
				if(strlen($v) >= 1){
					$tmp = substr($v, 0, 1);
					if(isset($this->_define_b[$tmp]) and $this->_define_b[$tmp] != ''){
						$tmp3 = $this->_define_b[$tmp];
						if($tmp1 == ''){
							// 取得預設值
							$tmp1 = $this->_define_c[$tmp3];
						}
						if($tmp3 == 'value'){
							if(isset($return['value']) && !is_array($return['value'])){
								unset($return['value']);//php7 以上 要先初始化，不然會報錯
							}
							$return['value'][] = $tmp1;
						} else {
							$return[$tmp3] = $tmp1;
						}
						unset($params_split[$k]);
					}	
				}
			} // foreach
		}

		if(count($params_split) > 0){
			if(isset($return['value']) && !is_array($return['value'])){
				unset($return['value']);//php7 以上 要先初始化，不然會報錯
			}	
			foreach($params_split as $k => $v){
				$return['value'][] = $v;
			}
		}

		return $return;
	}
}

