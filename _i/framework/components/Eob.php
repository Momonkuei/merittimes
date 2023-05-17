<?php

/*
 * 想把大多數的EOB運算都放在這裡
 */
class Eob {

	protected $card_number_prefix = ''; // 等一下要做小合併
	protected $card_number_static = '622043'; // 固定前6碼卡號
	protected $card_number_country = '09'; // 2碼國碼，這是跟隨小杜的規劃，使用BBX總代理的點流水號，台灣(就我們)，是第九個點

	protected $system_member = '6220430900000001'; // 主系統帳戶，層級最高的，並非代理商

	// 滯納金最低起收標準，有可能廢除，廢除的話，改0就可以
	protected $penalty_charge_min = 500;

	// 沒有選代理的會員，就是總公司會員
	protected $layers = array(
		// 代理商1
		array(
			'id' => 1,
			'name' => '台灣總代理商',
			//'rule' => 'a', // 遊戲規則A，也是目前唯一
			//'currency' => 'nt', // 我有一個對應的nt處理函式
			//'card_number_country => '09', // 2位數代理碼(國碼)
			'system_member' => '6220430900000042', // 該代理商的系統帳戶，跟主系統帳戶一樣的話，就不用撽錢之類的
			'marking' => 10, // 入會費10%(每月要撽的)
			'service' => 2,  // 服務費2%(入會費以外的都稱服務費，每月要撽的)
			//'number1' => 0, // 數字1，依照遊戲規則的撰寫方式，這個代理商我定義為無作用
			//'number2' => 0, // 數字2，純呼應數字1而以，目前也是無作用
			'child' => array(
				array(
					'id' => 2,
					'name' => '40%區經1',
					'type' => 1, // 1是40%
					//'system_member' => '6220430900000042',
					'marking' => 10, // 入會費10%(每月要撽的)
					'service' => 2,  // 服務費2%(入會費以外的都稱服務費，每月要撽的)
					//'child' => array(
					//	array(
					//		'id' => '3',
					//		'name' => '業務主管',
					//		'child' => array(
					//			array(
					//				'id' => '4',
					//				'name' => '業務',
					//			),
					//		),
					//	),
					//	array(
					//		'id' => '15',
					//		'name' => 'TCO主管',
					//		'child' => array(
					//			array(
					//				'id' => '16',
					//				'name' => 'TCO',
					//			),
					//		),
					//	),
					//),
				),
				array(
					'id' => 5,
					'name' => '40%區經2',
					'type' => 1, // 1是40%
					//'system_member' => '6220430900000042',
					'marking' => 10, // 入會費10%(每月要撽的)
					'service' => 2,  // 服務費2%(入會費以外的都稱服務費，每月要撽的)
					//'child' => array(
					//	array(
					//		'id' => '6',
					//		'name' => '業務主管',
					//		'child' => array(
					//			array(
					//				'id' => '7',
					//				'name' => '業務',
					//			),
					//		),
					//	),
					//	array(
					//		'id' => '13',
					//		'name' => 'TCO主管',
					//		'child' => array(
					//			array(
					//				'id' => '14',
					//				'name' => 'TCO',
					//			),
					//		),
					//	),
					//),
				),
				array(
					'id' => 8,
					'name' => '一般區經1',
					'type' => 2, // 2是一般
					//'system_member' => '6220430900000042',
					'marking' => 10, // 入會費10%(每月要撽的)
					'service' => 2,  // 服務費2%(入會費以外的都稱服務費，每月要撽的)
					//'child' => array(
					//	array(
					//		'id' => '9',
					//		'name' => '業務主管',
					//		'child' => array(
					//			array(
					//				'id' => '10',
					//				'name' => '業務',
					//			),
					//		),
					//	),
					//	array(
					//		'id' => '11',
					//		'name' => 'TCO主管',
					//		'child' => array(
					//			array(
					//				'id' => '12',
					//				'name' => 'TCO',
					//			),
					//		),
					//	),
					//),
				),
			),
		),
	);

	public function get_agent_option()
	{
		$rows = $this->db->createCommand()->from('layer')->where('is_enable=1 and pid=0')->queryAll();
		$return = array();
		if($rows){
			foreach($rows as $k => $v){
				$return[$v['id']] = $v['name'];
			}
		}
		//if(count($this->layers) > 0){
		//	foreach($this->layers as $k => $v){
		//		$return[$v['id']] = $v['name'];
		//	}
		//}
		return $return;
	}

	public function get_area_option_by_agent_id($agent_id)
	{
		$rows = $this->db->createCommand()->from('layer')->where('is_enable=1 and pid='.$agent_id)->queryAll();
		$return = array();
		if($rows){
			foreach($rows as $k => $v){
				$return[$v['id']] = $v['name'];
			}
		}
		//$return = array();
		//if(count($this->layers) > 0){
		//	foreach($this->layers as $k => $v){
		//		if($v['id'] == $agent_id){
		//			if(!isset($v['child'])){
		//				return $return;
		//			}
		//			foreach($v['child'] as $kk => $vv){
		//				$return[$vv['id']] = $vv['name'];
		//			}
		//		}
		//	}
		//}
		return $return;
	}

	// @force bool 預設只回傳區經底下的角色
	//public function get_role_by_area_id($area_id, $force = false)
	//{
	//	return array(
	//		'1' => '業務主管',
	//		'2' => '業務',
	//		'3' => 'TCO主管',
	//		'4' => 'TCO',
	//	);

	//	$tmp = array();
	//	$return_tmp = array();
	//	$return = array();

	//	if(count($this->layers) > 0){
	//		foreach($this->layers as $k => $v){
	//			if(isset($v['child'])){
	//				foreach($v['child'] as $kk => $vv){
	//					if($vv['id'] == $area_id){
	//						$tmp = $this->layers[$k]['child'][$kk];
	//						$txt = var_export($tmp, true);
	//						$tmp2 = explode("\n", $txt);
	//						$area_return = array();
	//						foreach($tmp2 as $kkk => $vvv){
	//							// 只要是match1，空白大於2的都回傳，因為空白為2的是區經名稱
	//							if(preg_match('/^(.*)\'name\' => \'(.*)\',$/', $vvv, $matches)){
	//								if(strlen($matches[1]) > 2){
	//									$return_tmp[$matches[2]] = '1';
	//									$area_return[$matches[2]] = $matches[2];
	//								}
	//							}
	//						}
	//						if($force == true){
	//							return $area_return;
	//						}
	//					}
	//				}
	//			}
	//		}
	//	}
	//	if(count($return_tmp) > 0){
	//		foreach($return_tmp as $k => $v){
	//			$return[] = $k;
	//			//$return[$k] = $k;
	//		}
	//	}
	//	return $return;
	//}

	public function get_system_card_member()
	{
		return $this->system_member;
	}

	public function get_penalty_charge_min()
	{
		return $this->penalty_charge_min;
	}

	function __construct()
	{
		$this->db = Yii::app()->db;
		$this->cidb = Yii::app()->params['cidb'];
		$this->session = Yii::app()->session;

		$this->card_number_prefix = $this->card_number_static.$this->card_number_country;
	}

	/*
	 * 計算滯納金
	 *
	 * 什麼是abcde
	 * a: 1~29
	 * b: 30~59
	 * c: 60~89
	 * d: 90~119
	 * e: 120+
	 *
	 * @card_number 卡號
	 * @action 如果是,1,1,1，那就會向上移3次，如果卡片內己移了3次，那總共會有6次，月結後要把卡片內的清空
	 */
	public function abcde($card_number, $action = '', $params_return = array())
	{
		// http://stackoverflow.com/questions/9058523/php-date-and-strtotime-return-wrong-months-on-31st
		//$timebase = strtotime(date('Y-m',time()) . '-01 00:00:01');

		if(count($params_return) <= 0){
			$rows = $this->search_member($card_number);
			if($rows and count($rows) == 1){
				$params = $rows[0];
				$params['method_name'] = 'abcdexx';
				$params['disable_save_session'] = true;
				if(isset($params['year_month']) and $params['year_month'] != ''){
					$params['year_month'] = $params_return['year_month'];
				}
				$params_return = $this->role_member($params);
				unset($params['disable_save_session']);
			} else {
				return;
			}
		}
		//echo '<pre>';
		//var_dump($params_return);
		//echo '</pre>';

		// 處理月結後和下個月初中間的時間差
		// 如果在這個時間點會往下延一格
		// 前提是最後一次的月結時間點，是當月的上個月之前，和月結之後中間的時間區中間
		// 才會自動延後下一格
		// 因為這裡寫的滯納金，是依照每個月的月初計算的
		$row = $this->db->createCommand()->select('MAX(create_time) AS last_time')->from('sys_log')->where('log_msg=:msg', array('msg'=>'checkout_'.date('Y').'_'.date('n')))->queryRow();

		if($row and isset($row['last_time']) and $row['last_time'] !== null){
			// 如果最後結帳是本月，而且在本月底之前的話，就往後延一格
			$tmp = explode('-', $row['last_time']);
			if(strtotime($row['last_time']) <= strtotime(date('Y-m').'-31') and date('Y-m') == ($tmp[0].'-'.$tmp[1])){
				// 符合條件，就往後移一格
				$action .= ',2,';
			}
		}

		// 中間那個逗點，是為了避免程式錯誤，而加的，反正implode切割，空白不處理
		$action = $params_return['penalty_action'].','.$action;

		// 分割動作，清掉空的
		$actions = explode(',', $action);
		if(count($actions) > 0){
			foreach($actions as $k => $v){
				if($v == ''){
					unset($actions[$k]);
				}
			}
		}

		/*
		 * 流程：
		 * 1. 以卡號搜尋所有交易(order)(去除系統帳戶、去除繳完的項目、整理要收錢的項目
		 * 2. 重建滯納金結構
		 * 3. 計算各收費名目的總合
		 * 4. 判定卡片狀況
		 */

		// 找出己結帳過的，但是現金未核消的(未繳完的，或是未繳的)
		$sql = '';
		$sql .= '(';
		$sql .= '(';
		//$sql .= '  sell_card_number!=:system_member AND ';
		$sql .= '  sell_card_number="'.$card_number.'" AND ';
		$sql .= '  (';
		$sql .= '    (sell_transation_cash_a > 0 AND sell_transation_cash_a != sell_transation_cash_a_end) OR ';
		$sql .= '    (sell_transation_cash_b > 0 AND sell_transation_cash_b != sell_transation_cash_b_end) OR ';
		$sql .= '    (sell_administrative_cash_a > 0 AND sell_administrative_cash_a != sell_administrative_cash_a_end) ';
		$sql .= '  )';
		$sql .= ')';
		//if(isset($params_return['year_month']) and $params_return['year_month'] != ''){
		//	$sql .= ' and create_time like \'%'.$params_return['year_month'].'%\' ';
		//}
		$sql .= ' OR ';
		$sql .= '(';
		//$sql .= '  buy_card_number!=:system_member AND ';
		$sql .= '  buy_card_number="'.$card_number.'" AND ';
		$sql .= '  (';
		$sql .= '    (buy_transation_cash_a > 0 AND buy_transation_cash_a != buy_transation_cash_a_end) OR ';
		$sql .= '    (buy_transation_cash_b > 0 AND buy_transation_cash_b != buy_transation_cash_b_end) OR ';
		$sql .= '    (buy_administrative_cash_a > 0 AND buy_administrative_cash_a != buy_administrative_cash_a_end) OR ';
		$sql .= '    (buy_sign_marking_cash > 0 AND buy_sign_marking_cash != buy_sign_marking_cash_end) OR ';
		// 2013/12/27補上的，這真是一個bug...
		$sql .= '    (buy_sign_admin_cash > 0 AND buy_sign_admin_cash != buy_sign_admin_cash_end) ';
		$sql .= '  )';
		$sql .= ') ';
		$sql .= ') ';
		$sql .= ' AND is_enable = 1 AND payment_type = 0';

		// 這裡應該不能限制時間
		//if(isset($params_return['year_month']) and $params_return['year_month'] != ''){
		//	$sql .= ' and create_time like \'%'.$params_return['year_month'].'%\' ';
		//}

		// 這行不用，因為未核消的，很有可能也是己結帳，己月結的
		//$sql .= ' AND is_checkout=0';

		//$rows = $this->db->createCommand()->from('order')->where($sql, array('system_member' => $this->system_member) )->queryAll();
		$rows = $this->db->createCommand()->from('order')->where($sql)->queryAll();

		//var_dump($rows);
		//die;

		// 現在是做未結帳的總合處理
		$sql2 = '';
		$sql2 .= '(';
		$sql2 .= '(';
		//$sql2 .= '  sell_card_number!=:system_member AND ';
		$sql2 .= '  sell_card_number="'.$card_number.'"';
		//$sql2 .= '  (';
		//$sql2 .= '    (sell_transation_cash_a > 0 AND sell_transation_cash_a != sell_transation_cash_a_end) OR ';
		//$sql2 .= '    (sell_transation_cash_b > 0 AND sell_transation_cash_b != sell_transation_cash_b_end) OR ';
		//$sql2 .= '    (sell_administrative_cash_a > 0 AND sell_administrative_cash_a != sell_administrative_cash_a_end) ';
		//$sql2 .= '  )';
		//$sql2 .= ')';
		if(isset($params_return['year_month']) and $params_return['year_month'] != ''){
			$sql2 .= ' AND create_time like \'%'.$params_return['year_month'].'%\' ';
		}
		$sql2 .= ' OR ';
		//$sql2 .= '(';
		$sql2 .= '  buy_card_number="'.$card_number.'"';
		//$sql2 .= '  (';
		//$sql2 .= '    (buy_transation_cash_a > 0 AND buy_transation_cash_a != buy_transation_cash_a_end) OR ';
		//$sql2 .= '    (buy_transation_cash_b > 0 AND buy_transation_cash_b != buy_transation_cash_b_end) OR ';
		//$sql2 .= '    (buy_administrative_cash_a > 0 AND buy_administrative_cash_a != buy_administrative_cash_a_end) OR ';
		//$sql2 .= '    (buy_sign_marking_cash > 0 AND buy_sign_marking_cash != buy_sign_marking_cash_end) ';
		//$sql2 .= '  )';
		$sql2 .= ')';
		$sql2 .= ')';
		$sql2 .= ' AND is_checkout=0 AND is_enable = 1 AND payment_type = 0';
		if(isset($params_return['year_month']) and $params_return['year_month'] != ''){
			$sql2 .= ' AND create_time like \'%'.$params_return['year_month'].'%\' ';
		}
		$rows2 = $this->db->createCommand()->from('order')->where($sql2, array('system_member' => $this->system_member) )->queryAll();
		//var_dump($rows2);
		//die;

		// 找出未結帳，有現金簽定費用的項目(要納入賣方的現金帳戶)
		$sql3 = '';
		$sql3 .= 'sell_card_number="'.$card_number.'"';
		$sql3 .= ' AND ';
		$sql3 .= '(';
		$sql3 .= '    buy_sign_marking_cash > 0 OR ';
		$sql3 .= '    buy_sign_admin_cash > 0 OR ';
		$sql3 .= '    buy_sign_debtres_cash > 0 ';
		$sql3 .= ')';
		$sql3 .= ' AND is_checkout=0 and is_enable = 1 and payment_type = 0';
		$rows3 = $this->db->createCommand()->from('order')->where($sql3)->queryAll();

		// 每個月一格，改成2，就是每2個月1格
		//$range = 1;
		//$current_month = $date('n'); // 3月，就3，而不是m的03
		//date("Y/n", strtotime('-1 month'));

		//$fromMYSQL = '2007-10-17 21:46:59';
		//echo date("m/d/Y", strtotime($fromMYSQL));

		//$today = strtotime($todays_date); 
		//$expiration_date = strtotime($exp_date); 
		//if ($expiration_date > $today) {

		/*
		 *  "每筆交易"的週期，以下是週期圖
		 *
		 *  
		 *                                      +----------------------------------\\--+
		 *                                      |  每區間增加2%現金滯納金(每期一直加)  |
		 *                                      +----------------------------------\\--+
		 *
		 *                ||  +--------+--------+----------------------------------\\--+
		 *   帳單項目別名 ||  |下期應撽|本期應撽|           上  期  未  撽             |
		 *                ||  +--------+--------+--------+-------+--------+--------\\--+
		 *   BBX項目別名  ||  | current|  0-29  |  30-59 | 60-89 | 90-119 |    120+    |
		 *                ||  +--------+--------+--------+-------+--------+--------\\--+
		 *   自己的說詞   ||  |    0   |    1   |    2   |   3   |   4    |     5      |
		 *   (期或是區)   ||  +--------+--------+--------+-------+--------+--------\\--+
		 *                ||
		 *                ||                             +-------------------------\\--+
		 *                ||                             |  卡片凍結                   |
		 *                ||                             +-------------------------\\--+
		 *                ||
		 *   BBX的按上按鈕||  3,4,5通通加到2去
		 *   BBX的回復    ||  要2,3,4,5數字全改
		 *   我自己的按上 ||  3,4,5往前堆，3會先推到2
		 *   我自己的回復 ||  清空那些動作，就跟月結清空的意義類似
		 */

		// 建立(定義)區間的日期條件
		$conditions = array();
		// 當月，未月結的，Current
		$conditions[0][0] = date('Y').'-'.date('m').'-'.'01';
		$conditions[0][1] = date('Y').'-'.date('m').'-'.'31';
		$conditions[0][2] = 0;
		$conditions[0][3] = 0;
		// 第一個月
		// strtotime first day，這是PHP 5.3專用的
		$tmp = date("Y/m", strtotime('first day of -1 month'));
		$tmps = explode('/', $tmp);
		$conditions[1][0] = $tmps[0].'-'.$tmps[1].'-'.'01';
		$conditions[1][1] = $tmps[0].'-'.$tmps[1].'-'.'31 23:59:59';
		$conditions[1][2] = 0;
		$conditions[1][3] = 29;
		$conditions[1][4] = $conditions[1][2].'-'.$conditions[1][3];
		// 第二個月
		$tmp = date("Y/m", strtotime('first day of -2 month'));
		$tmps = explode('/', $tmp);
		$conditions[2][0] = $tmps[0].'-'.$tmps[1].'-'.'01';
		$conditions[2][1] = $tmps[0].'-'.$tmps[1].'-'.'31 23:59:59';
		$conditions[2][2] = $conditions[1][2] + 30;
		$conditions[2][3] = $conditions[1][3] + 30;
		$conditions[2][4] = $conditions[2][2].'-'.$conditions[2][3];
		// 第三個月
		$tmp = date("Y/m", strtotime('first day of -3 month'));
		$tmps = explode('/', $tmp);
		$conditions[3][0] = $tmps[0].'-'.$tmps[1].'-'.'01';
		$conditions[3][1] = $tmps[0].'-'.$tmps[1].'-'.'31 23:59:59';
		$conditions[3][2] = $conditions[2][2] + 30;
		$conditions[3][3] = $conditions[2][3] + 30;
		$conditions[3][4] = $conditions[3][2].'-'.$conditions[3][3];
		// 第四個月
		$tmp = date("Y/m", strtotime('first day of -4 month'));
		$tmps = explode('/', $tmp);
		$conditions[4][0] = $tmps[0].'-'.$tmps[1].'-'.'01';
		$conditions[4][1] = $tmps[0].'-'.$tmps[1].'-'.'31 23:59:59';
		$conditions[4][2] = $conditions[3][2] + 30;
		$conditions[4][3] = $conditions[3][3] + 30;
		$conditions[4][4] = $conditions[4][2].'-'.$conditions[4][3];
		// 第五個月
		$tmp = date("Y/m", strtotime('first day of -5 month'));
		$tmps = explode('/', $tmp);
		//$conditions[5][0] = $tmps[0].'-'.$tmps[1].'-'.'01';
		$conditions[5][1] = $tmps[0].'-'.$tmps[1].'-'.'31 23:59:59';
		$conditions[5][2] = $conditions[4][2] + 30;
		//$conditions[5][3] = $conditions[4][3] + 30;
		$conditions[5][4] = $conditions[5][2].'+';

		$result = array();

		// 要撽納的總合
		$all = 0;

		// 各科目的撽納總合
		// $service = 0 // 這個不用，因為服務費 = 總撽費 - 入會費 - 管理費 (等一下最後會計算)
		$marking = 0;
		$admin = 0;

		// 收入 銷售(賣方)
		$in = 0;  // 虛擬幣
		//$in2 = 0; // 現金(不管，因為是他們雙方的事，跟系統沒有關係)

		// 支出 採購(買方)
		$out = 0;  // 虛擬幣
		//$out2 = 0; // 現金(不管，因為是他們雙方的事，跟系統沒有關係)

		// 純銷售和採購
		$sell2 = 0;
		$buy2 = 0;

		if($rows){
			foreach($rows as $k => $v){
				// 先看一下它是賣方還是買方
				//$is_sell = false;
				$type = 'buy';
				$total = 0;

				if($v['sell_card_number'] == $card_number){
					//$is_sell = true;
					$type = 'sell';
				}

				// 不管買方或賣方都要撽的費用
				/*
				 * 服務費用群(現金、行政現金)
				 */
				if($v[$type.'_transation_cash_a'] > 0){
					$total += $v[$type.'_transation_cash_a'] - $v[$type.'_transation_cash_a_end'];
				}
				if($v[$type.'_transation_cash_b'] > 0){
					$total += $v[$type.'_transation_cash_b'] - $v[$type.'_transation_cash_b_end'];
				}
				if($v[$type.'_administrative_cash_a'] > 0){
					$total += $v[$type.'_administrative_cash_a'] - $v[$type.'_administrative_cash_a_end'];
				}
				if($v[$type.'_administrative_cash_b'] > 0){
					$total += $v[$type.'_administrative_cash_b'] - $v[$type.'_administrative_cash_b_end'];
				}

				// 不管買方或賣方都要撽的虛擬幣
				//if($v[$type.'_transation_eob_a'] > 0){
				//	$out += $v[$type.'_transation_eob_a'];
				//}
				//if($v[$type.'_transation_eob_b'] > 0){
				//	$out += $v[$type.'_transation_eob_b'];
				//}
				//if($v[$type.'_administrative_eob_a'] > 0){
				//	$out += $v[$type.'_administrative_eob_a'];
				//}
				//if($v[$type.'_administrative_eob_b'] > 0){
				//	$out += $v[$type.'_administrative_eob_b'];
				//}

				if($v['sell_card_number'] == $card_number){
					//$is_sell = true;
					/*
					 * 服務費用群(現金、行政現金)
					 */
					//if($v['sell_transation_cash_a'] > 0){
					//	$total += $v['sell_transation_cash_a'] - $v['sell_transation_cash_a_end'];
					//}
					//if($v['sell_transation_cash_b'] > 0){
					//	$total += $v['sell_transation_cash_b'] - $v['sell_transation_cash_b_end'];
					//}
					//if($v['sell_administrative_cash_a'] > 0){
					//	$total += $v['sell_administrative_cash_a'] - $v['sell_administrative_cash_a_end'];
					//}
					//if($v['sell_administrative_cash_b'] > 0){
					//	$total += $v['sell_administrative_cash_b'] - $v['sell_administrative_cash_b_end'];
					//}

					/*
					 * 賣方收入
					 */
					if($v['transation_eob'] > 0){
						$sell2 += $v['transation_eob'];
					}
					//if($v[$type.'_sign_marking_eob'] > 0){
					//	$sell2 += $v[$type.'_sign_marking_eob'];
					//}
					//if($v[$type.'_sign_admin_eob'] > 0){
					//	$sell2 += $v[$type.'_sign_admin_eob'];
					//}
					//if($v[$type.'_sign_debtres_eob'] > 0){
					//	$sell2 += $v[$type.'_sign_debtres_eob'];
					//}

					// 不管它，因為買賣雙方的現金，是他們要自己給的，不關我們的事
					//if($v['transation_cash'] > 0){
					//	$in2 += $v['transation_cash'];
					//}
				} else {
					/*
					 * 服務費用群(現金、行政現金[administrative]、入會費[marking]、管理費[admin年費])
					 */
					//if($v['buy_transation_cash_a'] > 0){
					//	$total += $v['buy_transation_cash_a'] - $v['buy_transation_cash_a_end'];
					//}
					//if($v['buy_transation_cash_b'] > 0){
					//	$total += $v['buy_transation_cash_b'] - $v['buy_transation_cash_b_end'];
					//}
					//if($v['buy_administrative_cash_a'] > 0){
					//	$total += $v['buy_administrative_cash_a'] - $v['buy_administrative_cash_a_end'];
					//}
					//if($v['buy_administrative_cash_b'] > 0){
					//	$total += $v['buy_administrative_cash_b'] - $v['buy_administrative_cash_b_end'];
					//}
					if($v[$type.'_sign_marking_cash'] > 0){
						$total   += $v[$type.'_sign_marking_cash'] - $v[$type.'_sign_marking_cash_end'];
						$marking += $v[$type.'_sign_marking_cash'] - $v[$type.'_sign_marking_cash_end'];
					}
					if($v[$type.'_sign_admin_cash'] > 0){
						$total += $v[$type.'_sign_admin_cash'] - $v[$type.'_sign_admin_cash_end'];
						// 2014-01-06 由ryan發現的bug
						$admin += $v[$type.'_sign_admin_cash'] - $v[$type.'_sign_admin_cash_end'];
					}

					
					/*
					 * 買方支出
					 */
					if($v['transation_eob'] > 0){
						$buy2 += $v['transation_eob'];
					}
					if($v[$type.'_sign_marking_eob'] > 0){
						$buy2 += $v[$type.'_sign_marking_eob'];
					}
					if($v[$type.'_sign_admin_eob'] > 0){
						$buy2 += $v[$type.'_sign_admin_eob'];
					}
					if($v[$type.'_sign_debtres_eob'] > 0){
						$buy2 += $v[$type.'_sign_debtres_eob'];
					}

					// 不管它
					//if($v['transation_cash'] > 0){
					//	$out2 += $v['transation_cash'];
					//}
				}
				if($total <= 0) continue;

				/*
				 * 這裡的total，只是小計，all才是大總合
				 * 這裡的小計，是各別的交易的小計
				 */
				$all += $total;

				// 算一下每一筆交易衍生出來的費用，應該規類的區間
				foreach($conditions as $kk => $vv){
					// 先處理結尾的條件，因為結尾一定會有
					$condition = '';
					if(isset($vv[1])){
						$condition = 'strtotime($v[\'create_time\']) <= strtotime($vv[1])';
					}
					if(isset($vv[0])){
						$condition = 'strtotime($v[\'create_time\']) >= strtotime($vv[0]) and '.$condition;
					}
					if($condition == '') continue;
					$status = false;
					$run = 'if('.$condition.') $status = true;';
					eval($run);
					if($status){
						if(!isset($result[$kk])){
							$result[$kk] = 0;
						}
						$result[$kk] += $total;
						// 只要有區間放，就代表可以換下一筆來檢查了
						break;
					}
				}

			} // rows
		}

		// 先確定每一區都有數字可以用，至少要為零
		for($x=0;$x<=5;$x++){
			if(!isset($result[$x])){
				$result[$x] = 0;
			}
		}

		// 剛才是做消帳的動態處理，現在是做未結帳的總合處理
		if($rows2){
			foreach($rows2 as $k => $v){
				// 先看一下它是賣方還是買方
				$type = 'buy';
				$total = 0;

				if($v['sell_card_number'] == $card_number){
					$type = 'sell';
				}

				if($v['sell_card_number'] == $card_number){
					/*
					 * 賣方收入
					 */
					if($v['transation_eob'] > 0){
						$in += $v['transation_eob'];
					}
				} else {
					/*
					 * 買方支出
					 */
					if($v['transation_eob'] > 0){
						$out += $v['transation_eob'];
					}
					if($v[$type.'_sign_marking_eob'] > 0){
						$out += $v[$type.'_sign_marking_eob'];
					}
					if($v[$type.'_sign_admin_eob'] > 0){
						$out += $v[$type.'_sign_admin_eob'];
					}
					// 現金(不是很確定gisanfu)
					//if($v[$type.'_sign_admin_cash'] > 0){
					//	$all += $v[$type.'_sign_admin_cash'];
					//}
				}
				if($v[$type.'_transation_eob_a'] > 0){
					$out += $v[$type.'_transation_eob_a'];
				}
				if($v[$type.'_transation_eob_b'] > 0){
					$out += $v[$type.'_transation_eob_b'];
				}
				
				if($v[$type.'_administrative_eob_a'] > 0){
					$out += $v[$type.'_administrative_eob_a'];
				}
				if($v[$type.'_administrative_eob_b'] > 0){
					$out += $v[$type.'_administrative_eob_b'];
				}

			}
		} // rows2

		// 以動作來重新更動滯納金區間
		// 1 => 往前移一格
		// 2 => 往後移一格
		if(count($actions) > 0){
			foreach($actions as $k => $v){
				if($v == '1'){
					// 因為最多只會移動到凍結卡片的前一期，就是第2期
					$result[2] = $result[2] + $result[3];
					$result[3] = $result[4];
					$result[4] = $result[5];
					$result[5] = 0;
				// 通常會往下，是結帳所在使用，暫時在那個小時間區塊中，能移到下一期
				} elseif($v == '2'){
					$result[5] = $result[5] + $result[4];
					$result[4] = $result[3];
					$result[3] = $result[2];
					$result[2] = $result[1];
					$result[1] = $result[0];
					$result[0] = 0;
				}
			}
		}

		// 來看Payment的項目，抵扣一下，從遠的開始扣，多的會回傳剩下的現金餘額出來，供其它地方的動態計算
		$cash_over = 0; // 多的錢會放這裡
		$cash_over_total = 0; // 這是本月的payment費用
		if(isset($params_return['payments']) and $params_return['payments']){
			foreach($params_return['payments'] as $k => $v){
				//if($v['is_enable'] <= 0) continue; // 這行沒用
				// 小計，或稱它為餘額，就這樣一直扣下去，扣到沒有為止
				$f = $v['buy_payment_admin'] + $v['buy_payment_marking'] + $v['buy_payment_service'];
				//$cash_over_total += $f;
				$all = $all - $f;

				if($f == 0) continue;

				for($x=1;$x<=5;$x++){
					// 付完了，就可以換下一筆了
					if($f <= 0){
						break;
					}
					if($result[$x] > 0){
						if($f > $result[$x]){
							$f = $f - $result[$x];
							$result[$x] = 0;
						} elseif($f < $result[$x]){
							$result[$x] = $result[$x] - $f;
							$f = 0;
						} elseif($f == $result[$x]){
							$f = 0;
							$result[$x] = 0;
						}
					}
				}
				if($f > 0){
					// 因為這時的all己經是負數了，所以在加回去
					$all = $all + $f;
					$cash_over += $f;
				}
			}
		}

		// 做簽訂現金費用的轉移(買方給賣方)
		if($rows3){
			foreach($rows3 as $k => $v){
				$cash_over += $v['buy_sign_marking_cash'];
				$cash_over += $v['buy_sign_admin_cash'];
				$cash_over += $v['buy_sign_debtres_cash'];
			}
		}

		// 做payment費用的轉移(買方給賣方)
		// 這應該是要做會計系統的時候才需要做的 2014-01-14

		// 來看一下卡片狀態，false代表是凍結
		/*
		 * array(6) {
		 *   [1]=>
		 *   int(30)
		 *   [0]=>
		 *   int(100)
		 *   [2]=>
		 *   int(0)
		 *   [3]=>
		 *   int(0)
		 *   [4]=>
		 *   int(0)
		 *   [5]=>
		 *   int(0)
		 * }
		 */
		// 目前只有做超過區間的卡片狀態判定
		$card_status = true;
		if(count($result) > 0){
			$tmp0 = 0;
			foreach($result as $k => $v){
				if($k >= 3){
					$tmp0 += $v;
					if($tmp0 > 0){
						$card_status = false;
						break;
					}
				}
			}
		}

		$result_comma = $result;
		if(count($result_comma) > 0){
			foreach($result_comma as $k => $v){
				$result_comma[$k] = number_format($v);
			}
		}

		// 為了等一下要運算用
		//if(!isset($result[0])){
		//	$result[0] = 0;
		//}

		// 等一下要拿來動態扣
		//$in_tmp = $in;
		//$out_tmp = $out;

		// 交易幣餘額
		//if($params['eob_last_balance'] > 0){
		//	$params['eob_last_balance'] = 0;
		//}

		// 可用餘額
		//$params_return['eob_canuse_balance'] = '123';

		// 算一下服務費(只是一個類群組名稱)
		$service = $all - $marking - $admin;

		// 與會員現金餘額合併的現金餘額
		//$cash_over_merge = ($cash_over + $params_return['money2']) - $marking - $admin;
		//var_dump($cash_over_total);
		//die;
		$cash_over_merge = ($cash_over + $params_return['money2']) - $all;

		$params_return['result'] = $result;                    // 滯納金結果
		$params_return['result_comma'] = $result_comma;        // 滯納金結果(逗號)
		$params_return['conditions'] = $conditions;            // 滯納金結構
		$params_return['status'] = $card_status;             // 此卡片狀態是否正常(到達第3期沒撽就是不正常)

		// Debug
		//$params_return['status'] = false;

		// 這裡指的應該都是現金的部份而以
		$params_return['total'] = $all;                      // 所有未撽費用所有總合
		$params_return['total_comma'] = number_format($all); // 所有未撽費用所有總合(逗號)
		$params_return['total_append'] = $all - $result[0];  // 未撽費用總合(不含當期未撽費用)，月結的時候會用到
		$params_return['total_append_comma'] = $all - $result[0];  // 未撽費用總合(不含當期未撽費用)，1-29的那個地方會用到

		// 會員這期銷售(虛擬幣)
		$params_return['in'] = $in;

		// 會員這期採購(虛擬幣)
		$params_return['out'] = $out;

		// 銷售
		$params_return['sell2'] = $sell2;

		// 採購
		$params_return['buy2'] = $buy2;

		// 服務費(手續費)
		$params_return['service'] = $service;
		$params_return['service_comma'] = number_format($service);

		// 市場行銷費(入會費)
		$params_return['marking'] = $marking;
		$params_return['marking_comma'] = number_format($marking);

		// 管理費(年費)
		$params_return['admin'] = $admin;
		$params_return['admin_comma'] = number_format($admin);

		// 動態計算的多餘的現金餘額
		$params_return['cash_over'] = $cash_over_merge;
		$params_return['cash_over_comma'] = number_format($cash_over_merge);

		// 回傳欠錢的帳單
		$params_return['bill'] = $rows;

		// 回傳未月結的帳單
		$params_return['bill2'] = $rows2;
		
		return $params_return;
	}

	/*
	 * 取得最新的，且無人用的卡號
	 */
	public function getNewCardNumber()
	{
		$row = $this->db->createCommand()->select('MAX(card_number) AS max_card_number')->from('member')->where('card_number LIKE "'.$this->card_number_prefix.'%"')->queryRow();

		// 這個機會應該非常少
		if(!$row){
			return $this->card_number_prefix.'00000001';
		}

		return $row['max_card_number'] + 1;
	}

	/*
	 * 解譯器
	 * 未來如果有v2版本，method名稱就是interpreter_v2
	 */
	protected function _interpreter()
	{
	}

    public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        //echo "Calling object method '$name' "
        //     . implode(', ', $arguments). "\n";

		// 例如get__member__all
		//echo $name;
		$data = false;
		if(preg_match('/^get__(.*)__(all|row)$/', $name, $matches)){
			$run = '$data = $this->get'.strtoupper($matches[2]).'("'.$matches[1].'"';
			if($matches[2] == 'row'){
				$run .= ','.implode(', ', $arguments);
			}
			$run .= ');';
			eval($run);
			return $data;
		} elseif(preg_match('/^get__(.*)__(tmp)$/', $name, $matches)){
			$run = '$data = $this->get__'.$name.'__all('.implode(', ', $arguments).');';
			eval($run);
			$return = array();
			if($data){
				foreach($data as $k => $v){
					$return[$v['id']] = $v;
				}
			}
			return $return;
		} else {
			return '404';
		}
    }

	public function search_member($search_keyword = null)
	{
		// 如果params有指定的欄位，就做一下like，規則寫死好了
		//if($id != null){
		//	return $this->db->createCommand()->from('member')->where('is_enable=1 and id='.$id)->queryRow();
		//}

		// 多筆的，要注意
		if($search_keyword != null){
			return $this->db->createCommand()->from('member')->where('card_number LIKE "%'.$search_keyword.'%" OR company_name LIKE "%'.$search_keyword.'%"')->queryAll();
		}
	}

	// 
	//public function search_member_all($search_keyword = null)
	//{
	//	// 如果params有指定的欄位，就做一下like，規則寫死好了
	//	//if($id != null){
	//	//	return $this->db->createCommand()->from('member')->where('is_enable=1 and id='.$id)->queryRow();
	//	//}

	//	// 多筆的，要注意
	//	if($search_keyword != null){
	//		return $this->db->createCommand()->from('member')->where('(is_enable=1 or is_enable=2) and (card_number LIKE "%'.$search_keyword.'%" OR company_name LIKE "%'.$search_keyword.'%" )')->queryAll();
	//	}
	//}

	// 一般交易的搜尋賣方帳戶的欄位
	public function backend_transation_normal_eob_json()
	{
		// 一般交易金額貼入處理
		// 要計算虛擬幣的10%(cash), 2%(eob)
		// 也要計算現金的10%(cash), 2%(eob)
		$this->_sub_backend_transation_normal_json('a', 'sell','cash');
		$this->_sub_backend_transation_normal_json('a', 'sell','eob');
		$this->_sub_backend_transation_normal_json('a', 'buy','cash');
		$this->_sub_backend_transation_normal_json('a', 'buy','eob');

		// 計算新交易幣餘額
		// 在未交易的時候，先把交易幣餘額算出來，由輸入交易金額的地方觸發
		$this->_sub_backend_transation_normal_calculate_json('sell');
		$this->_sub_backend_transation_normal_calculate_json('buy');

		//$this->_sub_backend_transation_normal_session_json();
	}
	public function backend_transation_normal_cash_json()
	{
		$this->_sub_backend_transation_normal_json('b', 'sell','cash');
		$this->_sub_backend_transation_normal_json('b', 'sell','eob');
		$this->_sub_backend_transation_normal_json('b', 'buy','cash');
		$this->_sub_backend_transation_normal_json('b', 'buy','eob');

		$this->_sub_backend_transation_normal_calculate_json('sell');
		$this->_sub_backend_transation_normal_calculate_json('buy');

		// 接下來，把session裡面的東西倒出來，重新define
		// 因為我手動設定行政費，如果重新輸入交易值，頁面會變零，但session會有值，eob餘額是有值的加總，這樣會有問題
		//$this->_sub_backend_transation_normal_session_json();
	}

	protected function _sub_backend_transation_normal_session_json()
	{
		$ss = 'transation_normal'; // 我只是想讓session的名子短一些而以
		$aa = $this->session[$ss];
		if(count($aa) > 0){
			foreach($aa as $k => $v){
				$cc = <<<XXX
if($('#{$k}').attr('value') != undefined){
	$('#{$k}').attr('value', '{$v}');
} else {
	$('#{$k}').html('{$v}');
}
XXX;
			}
		}
	}

	public function backend_abcde_prev()
	{
        if(!empty($_POST) and isset($_POST['card_number']) and isset($_POST['type'])){
			//$empty_orm_data = array(
			//	'table' => 'member',
			//	'updated_field' => 'update_time',
			//	'primary' => 'id',
			//	'rules' => array(
			//	)
			//);
			//$c = new Empty_orm('insert', $empty_orm_data);
			//$u = $c::model()->findByPk($id);

			$row = $this->db->createCommand()->from('member')->where('card_number=:card', array('card'=>$_POST['card_number']))->queryRow();
			if($row and isset($row['id'])){
				$this->cidb->where('id',$row['id'])->update('member', array('penalty_action'=>$row['penalty_action'].',1,'));
				$_POST['search_keyword'] = $_POST['card_number'];
				$this->_sub_backend_transation_search_member_json($_POST['type']);
			}
		} // post
	}

	// 很單純的，只是做了向上調整的動作
	public function backend_abcde_prev_simple()
	{
        if(!empty($_POST) and isset($_POST['card_number'])){
			$row = $this->db->createCommand()->from('member')->where('card_number=:card', array('card'=>$_POST['card_number']))->queryRow();
			if($row and isset($row['id'])){
				$this->cidb->where('id',$row['id'])->update('member', array('penalty_action'=>$row['penalty_action'].',1,'));
				//$_POST['search_keyword'] = $_POST['card_number'];
				//$this->_sub_backend_transation_search_member_json($_POST['type']);
			}
		} // post
	}

	public function backend_transation_normal_calculate_json()
	{
		$ss = 'transation_normal'; // 我只是想讓session的名子短一些而以
        if(!empty($_POST) and isset($_POST['value']) and isset($_POST['id']) and isset($_POST['type'])){
			//$_SESSION['transation_normal'][$_POST['id']] = $_POST['value'];
			//$this->session[$ss][$_POST['id']] = $_POST['value'];

			// http://www.yiiframework.com/forum/index.php/topic/4262-multi-dimensional-arrays-in-session/ 我真的覺得CI的SESSION好用多了
			$session = $this->session[$ss];
			if($session === null){
				$session = array();
			}
			$session[$_POST['id']] = $_POST['value'];
			$this->session[$ss] = $session;

			$this->_sub_backend_transation_normal_calculate_json($_POST['type']);
		}
	}

	// 計算新交易幣餘額
	// 在未交易的時候，先把交易幣餘額算出來，由輸入交易金額的地方觸發
	protected function _sub_backend_transation_normal_calculate_json($type)
	{
		$balance = 0;
		$ss = 'transation_normal'; // 我只是想讓session的名子短一些而以

		if(isset($this->session['role_'.$type]['eob_last_balance'])){
			$balance += $this->session['role_'.$type]['eob_last_balance'];
		}

		// 把買方的交易幣，交到賣方，所以一邊是加，一邊是減
		if($type == 'sell'){
			if(isset($this->session[$ss]['transation_eob'])){
				$balance += $this->session[$ss]['transation_eob'];
			}
		} else {
			if(isset($this->session[$ss]['transation_eob'])){
				$balance -= $this->session[$ss]['transation_eob'];
			}
		}

		// debug
		//echo 'alert("'.$this->session[$ss]['transation_eob'].'");';
		//echo 'alert("'.$this->session['role_'.$type]['eob_last_balance'].'");';
		//echo 'alert("'.$balance.'");';

		// 交易幣(從幣抽)
		if(isset($this->session[$ss][$type.'_transation_eob_a'])){
			$balance -= $this->session[$ss][$type.'_transation_eob_a'];
		}
		// 交易幣(從現金抽，雖然現金是他們自己之間的交易，不過我們還是會抽)
		if(isset($this->session[$ss][$type.'_transation_eob_b'])){
			$balance -= $this->session[$ss][$type.'_transation_eob_b'];
		}

		// 雙方行政交易幣
		if(isset($this->session[$ss][$type.'_administrative_eob_a'])){
			$balance -= $this->session[$ss][$type.'_administrative_eob_a'];
		}
		if(isset($this->session[$ss][$type.'_administrative_eob_b'])){
			$balance -= $this->session[$ss][$type.'_administrative_eob_b'];
		}

		// 買方簽訂費用
		if($type == 'buy'){
			if(isset($this->session[$ss][$type.'_sign_marking_eob'])){
				$balance -= $this->session[$ss][$type.'_sign_marking_eob'];
			}
			if(isset($this->session[$ss][$type.'_sign_admin_eob'])){
				$balance -= $this->session[$ss][$type.'_sign_admin_eob'];
			}
			if(isset($this->session[$ss][$type.'_sign_debtres_eob'])){
				$balance -= $this->session[$ss][$type.'_sign_debtres_eob'];
			}
		}

		$balance = (int)$balance;
		$run = <<<XXX
$('#{$type}_next_eob_last_balance').html('{$balance}');

XXX;
		//}
		echo $run;
	}

	// 一般交易金額貼入處理
	// 要計算虛擬幣的10%(cash), 2%(eob)
	// 也要計算現金的10%(cash), 2%(eob)
	// @type4 a或b，b就是右邊，反之
	// @type sell或是buy
	// @type2 eob或是cash
	protected function _sub_backend_transation_normal_json($type4, $type, $type2)
	{
		$ss = 'transation_normal'; // 我只是想讓session的名子短一些而以

        if(!empty($_POST) and isset($_POST['value'])){
			if(isset($this->session['role_'.$type])){
				$type3 = ''; // 指的是買方或賣方
				if($type == 'buy'){
					$type3 = 'b'; // 買方
				}
				$price = $_POST['value'];

				$o_transation = $price * ($this->session['role_'.$type]['card_data']['transation'.$type3.'_'.$type2] / 100);

				// 無條件捨去，同floor
				//$o_transation = (int)$o_transation; 

				// 四捨五入
				$o_transation = round($o_transation);

				//if(!isset($this->session['transation_normal'])){
				//	$this->session['transation_normal'] = array();
				//}

				$session = $this->session[$ss];
				if($session === null){
					$session = array();
				}

				// 寫到session
				if($type4 == 'a'){
					$session['transation_eob'] = $price;
					//$_SESSION['transation_normal']['transation_eob'] = $price;
				} else {
					$session['transation_cash'] = $price;
					//$this->session['transation_normal']['transation_cash'] = $price;
					//$_SESSION['transation_normal']['transation_cash'] = $price;
				}
				//echo $type.'_transation_'.$type2.'_'.$type4;

				// 為了要覆寫自訂現金或虛擬幣的數值，因為要重新計算了
				$session[$type.'_transation_'.$type2.'_'.$type4] = $o_transation;

				$this->session[$ss] = $session;
				//$this->session['transation_normal'][$type.'_transation_'.$type2.'_'.$type4] = $price;
				//$_SESSION['transation_normal'][$type.'_transation_'.$type2.'_'.$type4] = $price;

				//var_dump($this->session['role_'.$type]['card_data']);
				$run = <<<XXX
$('#{$type}_transation_{$type2}_{$type4}').attr('value', '{$o_transation}');

XXX;
				echo $run;
			}
		}
	}

	public function backend_transation_search_detail_json()
	{
        if(!empty($_POST)){
			$ss = 'transation_detail';
			$session = $this->session[$ss];
			if($session === null){
				$session = array();
			}
			foreach($_POST as $k => $v){
				$session[$k] = $v;
			}
			$this->session[$ss] = $session;
		}
	}

	// 一般交易的搜尋賣方帳戶的欄位
	public function backend_transation_search_member_sell_json()
	{
		$this->_sub_backend_transation_search_member_json('sell');
	}
	public function backend_transation_search_member_buy_json()
	{
		$this->_sub_backend_transation_search_member_json('buy');
	}

	// 增加付款的搜尋帳戶的欄位
	public function backend_payment_search_member_json()
	{
        if(!empty($_POST) and isset($_POST['search_keyword'])){
			$rows = $this->search_member($_POST['search_keyword']);
			if($rows and count($rows) == 1){
				eval('$this->role_member($rows[0]);');
				if(isset($this->session['role_member']) and count($this->session['role_member']) > 0){
					foreach($this->session['role_member'] as $k => $v){
						// 全部轉字串
						$aa = '$o_'.$k.'="'.$v.'";';
						eval($aa);
					}
				}
				// 滯納金處理
				$abcde_data = $this->abcde($o_card_number);
				//var_dump($abcde_data);
				$service = $abcde_data['service_comma'];
				$marking = $abcde_data['marking_comma'];
				$admin = $abcde_data['admin_comma'];

				// 回傳js執行碼
				$run = <<<XXX
$('#卡號').attr('value', '{$o_card_number}');
$('#buy_card_number').attr('value', '{$o_card_number}');
$('#card_number_company_name').html('{$o_company_name}');
$('#service_require').html('{$service}');
$('#marking_require').html('{$marking}');
$('#admin_require').html('{$admin}');
XXX;
				echo $run;
			} // rows
		}
	}

	protected function _sub_backend_transation_search_member_json($type)
	{
        if(!empty($_POST) and isset($_POST['search_keyword'])){
			$type_name = '賣方';
			if($type == 'buy'){
				$type_name = '買方';
			}

			$rows = $this->search_member($_POST['search_keyword']);
			if($rows and count($rows) == 1){
				eval('$this->role_'.$type.'($rows[0]);');
				if(isset($this->session['role_'.$type]) and count($this->session['role_'.$type]) > 0){
					foreach($this->session['role_'.$type] as $k => $v){
						// 全部轉字串
						$aa = '$o_'.$k.'="'.$v.'";';
						eval($aa);
					}
				}
				// 滯納金處理
				$abcde_data = $this->abcde($o_card_number);
				//var_dump($abcde_data);
				for($x=1;$x<=5;$x++){
					// 先覆寫定義欄位
echo '$("#'.$type.'_abcde tbody tr:eq(0)").find("td").eq('.($x - 1).').html("'.$abcde_data['conditions'][$x][4].'");';

					// 清空資料欄位
echo '$("#'.$type.'_abcde tbody tr:eq(1)").find("td").eq('.$x.').html("0");';
				}
				// 覆寫資料欄位
				if(isset($abcde_data['result_comma']) and count($abcde_data['result_comma']) > 0){
					foreach($abcde_data['result_comma'] as $k => $v){
						if($k == 0) continue;
						if($abcde_data['result'][$k] > 0){
echo '$("#'.$type.'_abcde tbody tr:eq(1)").find("td").eq('.($k-1).').html("<span class=\"w_date02\">-'.$v.'</div>");';
						} else {
echo '$("#'.$type.'_abcde tbody tr:eq(1)").find("td").eq('.($k-1).').html("0");';
						}
					}
				} // comma

				if(isset($abcde_data['total_append']) and $abcde_data['total_append'] > 0){
					// 覆寫總合欄位
echo '$("#'.$type.'_abcde tbody tr:eq(1)").find("td").eq(5).html("<span class=\"w_date02\">-'.$abcde_data['total_append_comma'].'</div>");';
				} // total

				// 回傳訊息
				$status = '';
				if(isset($abcde_data['status']) and $abcde_data['status'] != true){
					$status = '*'.$type_name.'帳戶凍結<br />';
//echo '$("#'.$type.'_error_message").html($("#'.$type.'_error_message").html() + "*'.$type_name.'" + "帳戶凍結<br />");';
//				} else {
//echo '$("#'.$type.'_error_message").html("");';
				}

				if($type == 'buy' and $o_eob_canuse_balance <= 0){
					$status = '*'.$type_name.'無可用餘額<br />';
				}

				if($status != ''){
echo '$("#'.$type.'_error_message").html($("#'.$type.'_error_message").html() + "'.$status.'");';
				} else {
echo '$("#'.$type.'_error_message").html("");';
				}

				// 回傳js執行碼
				$run = <<<XXX
$('#{$type}_card_number').attr('value', '{$o_card_number}');
$('#{$type}_company_name').html('{$o_company_name}');
$('#{$type}_card_name').html('{$o_card_name}');

$('#{$type}_eob_last_balance').html('{$o_eob_last_balance}');
$('#{$type}_eob_canuse_balance').html('{$o_eob_canuse_balance}');

// 加上逗點
$('#{$type}_eob_last_balance').digits();
$('#{$type}_eob_canuse_balance').digits();

// 取消輸入欄位的輸入
$('#{$type}_card_number').addClass('m-wrap');
$('#{$type}_card_number').attr('readonly', 'true');

// 自動打開該客戶的存放檔案的資料夾(kcfinder)
$('#iframe_{$type}').attr('src', vir_path_c + 'kcfinder/browse.php?uploadurl_id=assetsdir&type=member&dir=&school_id={$o_card_number}');
XXX;
				echo $run;
				die;
			} // rows

			$run = <<<XXX
$('#{$type}_card_number').attr('value', '');
$('#{$type}_company_name').html('');
$('#{$type}_card_name').html('');

$('#{$type}_eob_last_balance').html('0');
$('#{$type}_eob_canuse_balance').html('0');
XXX;
				echo $run;
		} // empty
	}

	/*
	 * @params 資料行
	 * @data 功能引數
	 */
	public function save_session($params = array(), $data = array())
	{
		//if(!isset($params['disable_save_session']) and isset($params['method_name'])){
			$this->session[$params['method_name']] = array(); // 先清空，在寫入
			$this->session[$params['method_name']] = $params;
		//}
	}

	/*
	 * 賣東西的人，同時也具有member的角色
	 */
	public function role_sell($params = array())
	{
		$params['method_name'] = __FUNCTION__;

		$params['disable_save_session'] = true;
		$params_return = $this->role_member($params);
		unset($params['disable_save_session']);
		$this->save_session($params_return);
	}

	/*
	 * 買東西的人，同時也具有member的角色
	 */
	public function role_buy($params = array())
	{
		$params['method_name'] = __FUNCTION__;

		$params['disable_save_session'] = true;
		$params_return = $this->role_member($params);
		unset($params['disable_save_session']);
		$this->save_session($params_return);
	}

	// 角色會另外呼叫(應該是說對應)這個額外的method
	public function role_member($params = array())
	{
		if(!isset($params['method_name'])){
			$params['method_name'] = __FUNCTION__;
		}

		/*
		 * Action
		 */

		// 格式化一下卡片的名稱(變成類似信用卡那樣子 )
		if(isset($params['card_number'])){
			$params['card_number_format'] = Eobg::format_card($params['card_number']);
		}

		// 2014-01-02 lillian說要加的
		if(isset($params['company_addr_district']) and $params['company_addr_district'] != '') $params['company_addr'] = $params['company_addr_district'].' '.$params['company_addr'];
		if(isset($params['company_addr_county'])   and $params['company_addr_county']   != '') $params['company_addr'] = $params['company_addr_county'].' '.$params['company_addr'];
		if(isset($params['company_addr_province']) and $params['company_addr_province'] != '') $params['company_addr'] = $params['company_addr_province'].' '.$params['company_addr'];
		if(isset($params['company_addr_zipcode'])  and $params['company_addr_zipcode']  != '') $params['company_addr'] = $params['company_addr_zipcode'].' '.$params['company_addr'];

		// 處理對應的卡別名稱
		$rows = $this->get__card__all();
		$tmp = $this->handle_card_name($rows);
		$tmp2 = $this->handle_data_tmp($rows);
		$current_card_data = array(); // 存這張卡片的特別合併名稱
		$current_card_data2 = array(); // 存這張卡片的完整資料
		$params['card_name'] = '';
		if(isset($params['card_id']) and isset($tmp[$params['card_id']])){
			$params['card_name'] = $tmp[$params['card_id']];
			//$params['card_name_comments'] = $params['card_name'].'a('.$tmp2[$params['card_id']]['comments'].')';
			$current_card_data = $tmp[$params['card_id']];
			$current_card_data2 = $tmp2[$params['card_id']];
		}
		$params['card_data'] = $current_card_data2;

		// 將這個會員的卡別資料，用合併的方式轉存，給home/update所使用
		if(count($params['card_data']) > 0){
			foreach($params['card_data'] as $k => $v){
				$params['card_data_'.$k] = $v;
			}
		}

		// 處理相對應的TCO名稱，和業務名稱
		$params['tco_name'] = '';
		if(isset($params['tco_id']) and $params['tco_id'] > 0){
			$row = $this->db->createCommand()->from('member')->where('id='.$params['tco_id'])->queryRow();
			if($row){
				$params['tco_name'] = $row['name'];
			}
		}

		$params['sales_name'] = '';
		if(isset($params['sales_id']) and $params['sales_id'] > 0){
			$row = $this->db->createCommand()->from('member')->where('id='.$params['sales_id'])->queryRow();
			if($row){
				$params['sales_name'] = $row['name'];
			}
		}

		// 帳單寄送方式，轉換成文字
		$params['bill_type_name'] = '';
		if($params['bill_type'] == 0){
			$params['bill_type_name'] = '郵寄';
		} elseif($params['bill_type'] == 1){
			$params['bill_type_name'] = 'Email';
		}

		/*
		 * 額度
		 */
		$credit_line = 0; // 預設值
		// 讀取卡片的額度
		//if(isset($params['card_data']['credit_line'])){
		//	$credit_line = $params['card_data']['credit_line'];
		//}
		// 如果會員有額外指定額度，以額外指定的額度為主
		// 另外說明額度的名詞，額度除了是member.money的底限，同時也是還錢的依據
		//if($params['credit_line'] > 0){
		//	$credit_line = $params['credit_line']; // 優先權最高
		//}

		// @lillian 2013/9/17下午說的
		$credit_line = $params['credit_line']; // 優先權最高

		$params['current_credit_line'] = $credit_line;

		// 處理交易幣餘額(eob_last_balance)和可用餘額(eob_canuse_balance)
		// 預設值
		$params['eob_last_balance'] = 0;
		$params['eob_canuse_balance'] = 0;

		// 當處理會員的時候，就順便處理它的滯納金結構
		$abcde_data = $this->abcde($params['card_number'], '', $params); 

		// 試著做合併的動作
		if(count($abcde_data) > 0){
			foreach($abcde_data as $k => $v){
				$params[$k] = $v;
			}
		}

		//echo $params['money'];
		$in = $params['in'];
		$out = $params['out'];
		//echo $in;
		//echo $out;

		// 把賺到的動態處理一下
		//if($in > 0 and $params['credit_line_money'] > 0){
		//	$g = $params['credit_line_money'];
		//	// $h 因為這裡沒有要寫入，所以就用註解來表式
		//	if($in > $g){
		//		// 全額沖掉，但有餘額，可以繼續扣
		//		$in = $in - $g;
		//		//$h = $g; 
		//	} elseif($in < $g){
		//		// 部份沖掉，不夠扣
		//		//$h = $h + $params['in']; 
		//		$in = 0;
		//	} elseif($in == $g){
		//		// 全額沖掉，剛好用完
		//		$in = 0;
		//		//$h = $g;
		//	}
		//}

		// 如果賺到的錢就放囗袋
		if($in > 0){
			$params['money'] += $in;
		}

		// 把要付的虛擬幣處理一下
		if($out > 0){
			$params['money'] -= $out;
			//if($params['money'] < 0){
			//	$params['credit_line_money'] += -($params['money']);
			//	$params['money'] = 0;
			//}
		}


		/*
		 * 交易幣餘額(就是交易幣的餘額)
		 * 可用交易幣餘額 = 錢 + 剩餘額度
		 *
		 * 賺到的虛擬幣，要先還不足的額度，然後累積到交易幣餘額
		 */
		//$params['eob_last_balance'] = $params['money'] - $credit_line;
		$params['eob_last_balance'] = $params['money'];

		// 2013/10/3 可用的額度，就是囗袋裡的錢，跟額度相加而以
		//$params['eob_canuse_balance'] = $params['money'] + ($credit_line - $params['credit_line_money']);
		$params['eob_canuse_balance'] = $params['money'] + $credit_line;
		//echo $params['card_number'].',';
		//echo $params['money'].',';
		//echo $credit_line.',';
		//echo $params['eob_canuse_balance']."<br />";

		// 整數
		$params['eob_last_balance'] = (int)$params['eob_last_balance'];
		$params['eob_canuse_balance'] = (int)$params['eob_canuse_balance'];


		// 取得未結帳的Payment，目前是要給滯納金抵扣用
		$sql = 'payment_type > 0 and is_checkout=0 and is_enable=1 and buy_card_number=:card';
		if(isset($params['year_month']) and $params['year_month'] != ''){
			$sql = 'create_time like \'%'.$params['year_month'].'%\' and '.$sql;
		}
		//$params['payments'] = $this->db->createCommand()->from('payment')->where($sql, array('card'=>$params['card_number']))->queryAll();
		$params['payments'] = $this->db->createCommand()->from('order')->where($sql, array('card'=>$params['card_number']))->queryAll();
		
		/*
		 * 看一下這個會員的業務是屬於哪一個區經
		 */

		//$row = $this->db->createCommand()->from('admin_user')->where('id='.$params['sales_id'])->queryRow();
		// 不管是哪一層，都知道區經是誰
		//$params['area_id'] = 0;
		//if($row){
		//	$params['area_id'] = $row['area_id'];
		//}

		// 找出區經的類型
		//$row = $this->db->createCommand()->from('admin_user')->where('id='.$params['area_id'])->queryRow();
		//var_dump($row);
		//$params['area_type'] = 0; // 不明
		//if($row){
		//	$params['area_type'] = $row['area_type'];
		//}

		// 如果上一層就是區經的話
		//if($params['area_id'] == 0 and $row['area_id'] > 0){
		//	$params['area_id'] = $row['area_id'];
		//}

		// 這裡要找兩次，如果剛才那個不是的話
		//if($row and $params['area_id'] == 0){
		//	// 先取得業務的列表，做參考值
		//	$rows = $this->db->createCommand()->from('admin_user')->where('is_enable=1 and is_sales=1')->queryAll();
		//	$sales_tmp = array();
		//	if($rows){
		//		foreach($rows as $k => $v){
		//			$sales_tmp[$v['id']] = $v;
		//		}
		//	}

		//	if($params['area_id'] == 0){
		//		// 如果上一層是主管的話
		//		if(isset($sales_tmp[$row['sales_id']]['area_id']) and $sales_tmp[$row['sales_id']]['area_id'] > 0){
		//			$params['area_id'] = $sales_tmp[$row['sales_id']]['area_id'];
		//		}
		//	}

		//	// 沒了...

		//} // row param
		//echo $params['area_type'];

		// 取得區經的列表
		//$rows = $this->db->createCommand()->from('admin_user')->where('is_enable=1 and is_area=1')->queryAll();
		//$area_tmp = array();
		//if($rows){
		//	foreach($rows as $k => $v){
		//		$area_tmp[$v['id']] = $v;
		//	}
		//}

		$params['area_type'] = '';
		$params['area_data'] = array();
		if(isset($params['area_id']) and $params['area_id'] != ''){
			$row = $this->db->createCommand()->from('layer')->where('is_enable=1 and id='.$params['area_id'])->queryRow();
			if($row){
				$params['area_type'] = $row['type'];
				$params['area_data'] = $row;
			}
		}

		$params['agent_data'] = array();
		if(isset($params['agent_id']) and $params['agent_id'] != ''){
			$row = $this->db->createCommand()->from('layer')->where('is_enable=1 and id='.$params['agent_id'])->queryRow();
			if($row){
				$params['area_data'] = $row;
			}
		}

		// 4個上次
		$params['prev_sell'] = '';
		$params['prev_buy'] = '';
		$params['prev_payment'] = '';
		$params['prev_contactus'] = '';
		$card_number_search = $params['card_number'];
		$row = $this->db->createCommand()->select('MAX(create_time) as max_create_time, transation_eob, transation_cash')->from('order')->where('payment_type = 0 and is_enable=1 and sell_card_number=:card', array('card'=>$card_number_search))->queryRow();
		if($row and isset($row['max_create_time'])){
			$params['prev_sell'] = date('Y-m-d', strtotime($row['max_create_time'])).' ('.number_format($row['transation_eob']+$row['transation_cash']).')';
		}
		$row = $this->db->createCommand()->select('MAX(create_time) as max_create_time, transation_eob, transation_cash')->from('order')->where('payment_type = 0 and is_enable=1 and buy_card_number=:card', array('card'=>$card_number_search))->queryRow();
		if($row and isset($row['max_create_time'])){
			$params['prev_buy'] = date('Y-m-d', strtotime($row['max_create_time'])).' ('.number_format($row['transation_eob']+$row['transation_cash']).')';
		}
		$row = $this->db->createCommand()->select('MAX(create_time) as max_create_time, buy_payment_service, buy_payment_admin, buy_payment_marking')->from('order')->where('payment_type > 0 and is_enable=1 and buy_card_number=:card', array('card'=>$card_number_search))->queryRow();
		if($row and isset($row['max_create_time'])){
			$params['prev_payment'] = date('Y-m-d', strtotime($row['max_create_time'])).' ('.number_format($row['buy_payment_service']+$row['buy_payment_admin']+$row['buy_payment_marking']).')';
		}
		$row = $this->db->createCommand()->select('MAX(create_time) as max_create_time')->from('contactus')->where('card_number=:card', array('card'=>$card_number_search))->queryRow();
		if($row and isset($row['max_create_time'])){
			$params['prev_contactus'] = date('Y-m-d', strtotime($row['max_create_time']));
		}

		/*
		 * 主要連絡人
		 */
		$row = $this->db->createCommand()->select('name, phone, email, addr')->from('member_contact')->where('is_enable=1 and maincontact=1 and data_id=:id', array('id'=>$params['id']))->queryRow();
		if(isset($row['name'])){
			foreach($row as $k => $v){
				$params['member_contact_'.$k] = $v;
			}
		}

		// 取得未結帳的Order，動態計算賣方應得的金額，當然，月結的時候，並需要寫回去
		//$params['sell_orders'] = $this->db->createCommand()->from('orders')->where('is_checkout=0 and is_enable=1 and sell_card_number=:card', array('card'=>$params['card_number']))->queryAll();
		//$params['buy_orders'] = $this->db->createCommand()->from('orders')->where('is_checkout=0 and is_enable=1 and buy_card_number=:card', array('card'=>$params['card_number']))->queryAll();

		if(!isset($params['disable_save_session']) and isset($params['method_name'])){
			$this->save_session($params);
		} else {
			return $params;
		}
	}

	/*
	 * 40%獎金
	 *
	 * @month string 2013-06，跟月結用的那個是一樣的
	 */
	public function bonus40($month)
	{

		// 取得該月的現金進帳
		$rows = $this->db->createCommand()->from('order')->where('payment_type > 0 and is_checkout=1 and checkout_month=:month and is_enable=1', array('month'=>$month))->queryAll();

		//$this->get_area_option_by_agent_id

		// 總業積
		$total = 0; 

		// 各區經收入
		$incoming = array();

		if($rows){
			foreach($rows as $k => $v){
				$card_number = $v['buy_card_number'];
				$rows2 = $this->search_member($card_number);
				if(count($rows2) == 1){
					$this->role_member($rows2[0]);
					$member = $_SESSION['role_member'];
					$area_id = $member['area_id'];
					$area_type = $member['area_type'];

					// 這裡只算直營店的，以及有規類區經的，或是有指定區經的
					//echo 'g';
					if($area_type != 1 or $area_id <= 0) continue;

					if(!isset($incoming[$area_id])){
						$incoming[$area_id] = 0;
					}
					// 入會費以外的
					$subtotal = $v['buy_payment_service'] + $v['buy_payment_admin'];
					$incoming[$area_id] += $subtotal;
					$total += $subtotal;
				}
			}
		}

		// debug
		//var_dump($total);
		//var_dump($incoming);

		arsort($incoming);

		// debug
		//var_dump($incoming);
		
		$a = 5; // 區間
		$c = 6; // 名額

		// 拿來暫時處理的變數(邊處理邊砍的暫時變數)
		$incoming_a = $incoming;

		// 區間名額
		$quota_of_people = array();

		// x 區間
		for($x=1;$x<=$a;$x++){
			// y 名額
			for($y=1;$y<=$c;$y++){
				if(count($incoming_a) > 0){
					// 只想跑第一筆出來
					foreach($incoming_a as $k => $v){
						break;
					}
					unset($incoming_a[$k]);
					$quota_of_people[$x][$y] = $k;
				}
			}
		}

		/*
		 * 區間均分
		 */

		// 獎金
		$bonus = array();

		$b = array(
			28,
			23,
			20,
			17,
			12
		);

		// @k 區間
		foreach($quota_of_people as $k => $v){
			// @kk 名額流水號
			foreach($v as $kk => $vv){
				// 有對應的區間才能繼續處理
				if(isset($b[$k])){
					$bonus[$k][$kk] = (int)round( ( ( $total / 100 ) * $b[$k] ) / $c );
				}
			}
		}

		/*
		 * +------+------+----------+---------------------+------------+------------+
		 * | 級數 | 名額 | 公司名稱 | 卡號                | 營收       | 獎金       |
		 * +------+------+----------+---------------------+------------+------------+
		 * | 28%  |  1   | area1    | XXXX-XXXX-XXXX-XXXX | 30,000,000 |   30,000   |
		 * +------+------+----------+---------------------+------------+------------+
		 * | 28%  |  2   | area2    | XXXX-XXXX-XXXX-XXXX | 30,000,000 |   30,000   |
		 * +------+------+----------+---------------------+------------+------------+
		 * | 23%  |  1   | area3    | XXXX-XXXX-XXXX-XXXX | 30,000,000 |   30,000   |
		 * +------+------+----------+---------------------+------------+------------+
		 */

		return array(
			'total' => $total,
			'incoming' => $incoming,
			'f0' => $b, // 級數
			'quota_of_people' => $quota_of_people,
			'bonus' => $bonus,
		);
	}

	public function report($data, $card_number, $year_month = '', $checkout_time = '')
	{
		// 結帳日期
		$data['checkout_time'] = $checkout_time;

		// 處理公司名稱抓取的部份
		//$eob = new Eob;
		$rows = $this->search_member($card_number);
		if(count($rows) == 1){
			$rows[0]['year_month'] = $year_month;
			$this->role_member($rows[0]);
			$data['updatecontent'] = $_SESSION['role_member'];

			// abcde
			//$rowx = $this->abcde($data['updatecontent']['card_number']);
			//if($rowx and count($rowx) > 0){
			//	foreach($rowx as $k => $v){
			//		$data['updatecontent'][$k] = $v;
			//	}
			//}

			//var_dump($this->data['updatecontent']['result']);

			// debug
			//var_dump($data['updatecontent']);
			//die;

			// 先建立滯納金區間及資料出來
			//$abcde = $eob->abcde($card_number);

			// 把未結帳的滯納金找出來
			$penaltys = $this->db->createCommand()->from('order')->where('payment_type = 0 and buy_card_number="'.$card_number.'" and comments="滯納金" and is_checkout=0 and is_enable=1')->queryAll();
			$penalty = 0;
			if($penaltys){
				foreach($penaltys as $k => $v){
					if($v['buy_transation_cash_b'] > 0){
						$penalty += $v['buy_transation_cash_b'];
					}
				}
			}
			//var_dump($data['updatecontent']['result']);
			//die;

			/*
			 *   上期未繳金額        2%滯納金     本期新增現金費用    本期應繳現金  
			 * +-------------+   +-------------+   +-------------+   +-------------+
			 * |     XX      | + |      XX     | + |      XX     | = |     XX      |
			 * +-------------+   +-------------+   +-------------+   +-------------+
			 *      cash1             cash2             cash3          cash4(1+2+3)
			 */

			// 計算上方現金方塊現金金額
			// cash1: 上期未撽金額(就是滯納金區塊2~5的總合，或者是說，上個月的月結日期~這個月的月底[本月未月結]，或是月結日期[本月己月結])
			// cash2: 本期滯納金(交易的comments=滯納金)，同上解釋
			// cash3: 本期新增金額(滯納金以外的現金費用，例如賣東西的費用等)
			// cash4: 1+2+3

			//var_dump($data['updatecontent']['result']);
			//die;

			// 2014-01-02找到的bug，應該是未繳金額總額，而不是滯納金區塊2~5的總合
			$data['updatecontent']['cash1'] = $data['updatecontent']['result'][1] + $data['updatecontent']['result'][2] + $data['updatecontent']['result'][3] + $data['updatecontent']['result'][4] + $data['updatecontent']['result'][5];
			//$data['updatecontent']['cash1'] = $data['updatecontent']['total'];
			$data['updatecontent']['cash2'] = $penalty;
			$data['updatecontent']['cash3'] = 0;
			// 這兩行是寫錯的
			//$data['updatecontent']['cash3'] = $data['updatecontent']['total_append'] - $penalty - ($data['updatecontent']['result'][2] + $data['updatecontent']['result'][3] + $data['updatecontent']['result'][4] + $data['updatecontent']['result'][5]);
			//$data['updatecontent']['cash4'] = $data['updatecontent']['total_append'];

			/*
			 *    上期餘額           信用額度          本期新增          本期花費          應繳EOB幣        可用EOB幣
			 * +-------------+   +-------------+   +-------------+   +-------------+   +-------------+   +-------------+
			 * |     XX      | + |      XX     | + |      XX     | - |     XX      | - |     XX      | = |     XX      |
			 * +-------------+   +-------------+   +-------------+   +-------------+   +-------------+   +-------------+
			 *      eob1              eob2              eob3              eob4              eob5              eob6
			 */

			// 計算下方EOB方塊的虛擬幣金額
			// eob1: 上期的餘額
			// eob2: 信用額度的餘額
			// eob3: 賣東西新增的金額
			// eob4: 有買東西才會出現的費用, 後面一點才會處理這個變數
			// eob5: 買賣所要衍生的EOB費用
			// eob6: 可用EOB幣，就是"可用餘額"
			//$data['updatecontent']['eob2'] = $data['updatecontent']['money'] - $data['updatecontent']['eob_canuse_balance'];
			$data['updatecontent']['eob2'] = $data['updatecontent']['credit_line'];
			$data['updatecontent']['eob3'] = $data['updatecontent']['in'];
			$data['updatecontent']['eob4'] = 0;
			//$data['updatecontent']['eob5'] = $data['updatecontent']['out'];
			$data['updatecontent']['eob5'] = 0;
			$data['updatecontent']['eob6'] = $data['updatecontent']['eob_canuse_balance'];
			// 反算上期的餘額
			//$data['updatecontent']['eob1'] = $data['updatecontent']['eob6'] + $data['updatecontent']['eob5'] + $data['updatecontent']['eob4'] - $data['updatecontent']['eob3'] - $data['updatecontent']['eob2'];

			// 2013/09/17 @lillian: 不是這樣子算的，這要看上期，而不是關連算
			//$data['updatecontent']['eob1'] = 0;
			//$data['updatecontent']['eob1'] = $data['updatecontent']['prev_eob_canuse_balance'];
			//return $this->db->createCommand()->from($table)->where('id='.$id)->queryRow();
			$row = $this->db->createCommand()->from('prev_eob_canuse_balance')->where('keyname=\''.date('Y-m',strtotime($year_month.'-01 first day of -1 month')).'-'.$card_number.'\'')->queryRow();
			if($row){
				$data['updatecontent']['eob1'] = $row['keyval'];
			}

			for($x=1;$x<=6;$x++){
				if(!isset($data['updatecontent']['eob'.$x])){
					$data['updatecontent']['eob'.$x] = 0;
				}
				//$data['updatecontent']['eob'.$x] = number_format($data['updatecontent']['eob'.$x]);
				$data['updatecontent']['eob'.$x] = $data['updatecontent']['eob'.$x];
			}

			// 回傳欠錢的帳單
			//$this->data['updatecontent']['bill'];

			// 以日期為基礎(key值)，等一下會用key值排序
			$bill_data = array();

			// 做ksort用的
			$bill_data_id = array();

			// 處理未月結的交易
			if(isset($data['updatecontent']['bill2']) and count($data['updatecontent']['bill2']) > 0){
				foreach($data['updatecontent']['bill2'] as $k => $v){

					// 因為滯納金的部份，上面就處理過了，這裡不處理 
					// 2013/12/2-001 lillian說，滯納金也要顯示在交易裡面，本期新增金額不包含滯納金
					//if($v['comments'] == '滯納金'){
					//	continue;
					//}

					// 先看一下是賣方還是買方
					$type = 'buy';
					$type_revert = 'sell';
					if($data['updatecontent']['card_number'] == $v['sell_card_number']){
						$type = 'sell';
						$type_revert = 'buy';
					}

					// a: 帳單
					// b: Payment
					$newkey = $v['create_time'].'a'.$k;

					/*
					 * +------+----------+----------+-------+------+------+----------+-----------+------+
					 * | 日期 | 交易編號 | 交易編號 |  描述 | 銷售 | 採購 | 現金費用 | EOB幣費用 | 付費 |
					 * +------+----------+----------+-------+------+------+----------+-----------+------+
					 * | date |    id    |  target  |comment| sell |  buy |   cash   |    eob    | money|
					 * +------+----------+----------+-------+------+------+----------+-----------+------+
					 */

					// 空的，先定義一下
					$value = array(
						'date' => date('Y-m-d', strtotime($v['create_time'])),
						'id' => $v['id'],
						'target' => '',
						'comments' => $v['comments'],
						'sell' => '',
						'buy' => '',
						'cash' => '',
						'eob' => '',
						'money' => '',
					);

					$value[$type] = $v['transation_eob'];

					$price = 0;
					$price = $v[$type.'_transation_cash_a'] + $v[$type.'_transation_cash_b'] + $v[$type.'_administrative_cash_a'] + $v[$type.'_administrative_cash_b'];
					if($type == 'buy'){
						$price += $v['buy_sign_marking_cash'] + $v['buy_sign_admin_cash'];
					}
					$value['cash'] = $price;

					$price = 0;
					$price = $v[$type.'_transation_eob_a'] + $v[$type.'_transation_eob_b'] + $v[$type.'_administrative_eob_a'] + $v[$type.'_administrative_eob_b'];
					if($type == 'buy'){
						$price += $v['buy_sign_marking_eob'] + $v['buy_sign_admin_eob'] + $v['buy_sign_debtres_eob'];
					}
					$value['eob'] = $price;

					// 這個判斷式是2013/12/2-001加的
					if($v['comments'] != '滯納金'){
						$data['updatecontent']['cash3'] += $value['cash'];
					}

					$rows = $this->search_member($v[$type_revert.'_card_number']);
					$params_return = array();
					if($rows and count($rows) == 1){
						$params = $rows[0];
						$params['method_name'] = 'abcdexx1';
						$params['disable_save_session'] = true;
						$x = $this->role_member($params);
						unset($params['disable_save_session']);
					}

					if(isset($x['company_name'])){
						$value['target'] = $x['company_name'];
					}

					if($value['target'] == '系統帳戶'){
						$value['target'] = 'EOB ACCOUNT';
					}

					$bill_data[$newkey] = $value;
					$bill_data_id[$newkey] = '';

				}
			}

			$rows = $this->search_member($this->get_system_card_member());
			$params_return = array();
			if($rows and count($rows) == 1){
				$params = $rows[0];
				$params['method_name'] = 'abcdexx1';
				$params['disable_save_session'] = true;
				$y = $this->role_member($params);
				unset($params['disable_save_session']);
			}

			// 處理未月結的payment
			if(count($data['updatecontent']['payments']) > 0){
				foreach($data['updatecontent']['payments'] as $k => $v){
					
					// 2013/12/27 要減掉他己繳的費用
					$data['updatecontent']['cash3'] -= $v['buy_payment_admin'];
					$data['updatecontent']['cash3'] -= $v['buy_payment_marking'];
					$data['updatecontent']['cash3'] -= $v['buy_payment_service'];

					// a: 帳單
					// b: Payment
					$newkey = $v['create_time'].'b'.$k;

					// 空的，先定義一下
					$value = array(
						'date' => date('Y-m-d', strtotime($v['create_time'])),
						'id' => $v['id'],
						'target' => '',
						'comments' => $v['comments'],
						'sell' => '',
						'buy' => '',
						'cash' => '',
						'eob' => '',
						'money' => $v['buy_payment_admin'] + $v['buy_payment_marking'] + $v['buy_payment_service'],
					);

					if(isset($y['company_name'])){
						$value['target'] = $y['company_name'];
					}

					// 以下這是為了lillian，初期而不是永久的撰寫方式 2013/10/2
					//if(isset($v['id_replace']) and $v['id_replace'] != ''){
					//	$value['id'] = $v['id_replace'];
					//}
					//if(isset($v['company_name_replace']) and $v['company_name_replace'] != ''){
					//	$value['target'] = $v['company_name_replace'];
					//}

					if($value['target'] == '系統帳戶'){
						$value['target'] = 'EOB ACCOUNT';
					}

					$bill_data[$newkey] = $value;
					$bill_data_id[$newkey] = '';
				}
			}

			ksort($bill_data_id);

			if(count($bill_data_id) > 0){
				foreach($bill_data_id as $k => $v){
					$bill_data_id[$k] = $bill_data[$k];
				}
			}

			// 做總計，以及格式化
			$data['sell'] = 0;
			$data['buy'] = 0;
			$data['cash'] = 0;
			$data['eob'] = 0;
			$data['money'] = 0;

			if(count($bill_data_id) > 0){
				foreach($bill_data_id as $k => $v){

					if(strlen($v['sell']) > 0){
						$data['sell'] += $v['sell'];
						$v['sell'] = number_format((int)$v['sell']);
					}

					if(strlen($v['buy']) > 0){
						$data['buy'] += $v['buy'];
						$v['buy'] = number_format((int)$v['buy']);
					}

					if(strlen($v['cash']) > 0){
						$data['cash'] += $v['cash'];
						$v['cash'] = number_format((int)$v['cash']);
					}

					if(strlen($v['eob']) > 0){
						$data['eob'] += $v['eob'];
						$v['eob'] = number_format((int)$v['eob']);
					}

					if(strlen($v['money']) > 0){
						$data['money'] += $v['money'];
						$v['money'] = number_format((int)$v['money']);
					}

					$bill_data_id[$k] = $v;
				}
			}

			$data['updatecontent']['cash4'] = $data['updatecontent']['cash1'] + $data['updatecontent']['cash2'] + $data['updatecontent']['cash3'];

			$data['sell'] = number_format((int)$data['sell']);
			$data['buy'] = number_format((int)$data['buy']);
			$data['cash'] = number_format((int)$data['cash']);
			$data['eob'] = number_format((int)$data['eob']);
			$data['money'] = number_format((int)$data['money']);

			for($x=1;$x<=4;$x++){
				if(!isset($data['updatecontent']['cash'.$x])){
					$data['updatecontent']['cash'.$x] = 0;
				}
				$data['updatecontent']['cash'.$x] = number_format($data['updatecontent']['cash'.$x]);
			}

			$data['updatecontent']['eob1'] = number_format((int)$data['updatecontent']['eob1']);
			$data['updatecontent']['eob2'] = number_format((int)$data['updatecontent']['eob2']);
			$data['updatecontent']['eob3'] = number_format((int)$data['updatecontent']['eob3']);
			$data['updatecontent']['eob4'] = $data['buy'];
			//$data['updatecontent']['eob5'] = number_format((int)$data['updatecontent']['eob5']);
			$data['updatecontent']['eob5'] = $data['eob'];
			$data['updatecontent']['eob6'] = number_format((int)$data['updatecontent']['eob6']);
			//$data['updatecontent']['eob6'] = $data['updatecontent']['eob6'];


			$data['bill_data'] = $bill_data_id;
			//var_dump($this->data['bill_data']);

			// 如果連絡人1是空白，就就改負責人 2013/10/4 @lillian say
			if($data['updatecontent']['name1'] == ''){
				$data['updatecontent']['name1'] = $data['updatecontent']['name'];
			}

			// X月費用明細及帳單，也就是帳單的右上角
			$data['updatecontent']['month'] = (int)substr($year_month, 5);

			// 處理一下帳單地址
			if($data['updatecontent']['bill_addr_type'] == '0'){
				$data['updatecontent']['bill_addr_other'] = $data['updatecontent']['company_addr'];
			} elseif($data['updatecontent']['bill_addr_type'] == '1'){
				$data['updatecontent']['bill_addr_other'] = $data['updatecontent']['addr'];
			}

			$data['main_content'] = 'billreport/report';
			return $data;
		}
	}

	// 虛擬資料表範本
	//public function table_xxx()
	//{
	//	return array(
	//		array(
	//			'id' => 1,
	//			'name' => 'xxxa',
	//		),
	//		array(
	//			'id' => 2,
	//			'name' => 'xxxb',
	//		),
	//	);
	//}

	public function table_card_x()
	{
		// 信用額度 Credit Line
		$cl = 'credit_line';

		// 滯納金 Belated Payment
		$bp = 'belated_payment';
		$bpm = $bp.'_month'; // 滯納金產生期間
		$bp1 = $bp.'_eob';
		$bp2 = $bp.'_cash';

		// 交易 Transaction 收%數 賣東西 銷售
		$tr = 'transation';
		$tr1 = $tr.'_eob';
		$tr2 = $tr.'_cash';

		// 買東西 買方
		$trb = 'transation'.'b';
		$trb1 = $trb.'_eob';
		$trb2 = $trb.'_cash';

		// 年費 Annual fee
		$af = 'annual_fee';
		$af1 = $af.'_eob';
		$af2 = $af.'_cash';

		// 備註
		$p = 'comments';

		$data = array(
			array('id'=>1, 'name'=>'金卡', $cl=>1000000, $tr1=>2, $tr2=>10, $af1=>5000 ,$af2=>5000, $p=>'一般會員',),
			array('id'=>2, 'name'=>'銀卡', $cl=>500000,  $tr1=>2, $tr2=>10, $af1=>3000 ,$af2=>3000, $p=>'一般會員',),
			array('id'=>3, 'name'=>'銅卡', $cl=>100000,  $tr1=>2, $tr2=>10, $af1=>2000 ,$af2=>2000, $p=>'一般會員',),
			array('id'=>4, 'name'=>'金卡', $cl=>1000000, $tr1=>2, $tr2=>10, $af1=>0 ,$af2=>0, $p=>'免年費',),
			array('id'=>5, 'name'=>'銀卡', $cl=>500000,  $tr1=>2, $tr2=>10, $af1=>0 ,$af2=>0, $p=>'免年費',),
			array('id'=>6, 'name'=>'銅卡', $cl=>100000,  $tr1=>2, $tr2=>10, $af1=>0 ,$af2=>0, $p=>'免年費',),
			array('id'=>7, 'name'=>'金卡', $cl=>1000000, $tr1=>2, $tr2=>8, $af1=>0 ,$af2=>0, $p=>'現金8%',),
			array('id'=>8, 'name'=>'銀卡', $cl=>500000,  $tr1=>2, $tr2=>8, $af1=>0 ,$af2=>0, $p=>'現金8%',),
			array('id'=>9, 'name'=>'金卡', $cl=>3000000, $tr1=>2, $tr2=>10, $af1=>0 ,$af2=>0, $p=>'信用額度3百萬',),
		);

		if(count($data) > 0){
			foreach($data as $k => $v){
				// 滯納金
				$v[$bpm] = 1;
				$v[$bp1] = 0;
				$v[$bp2] = 0;

				// 買方費用
				$v[$trb1] = 0;
				$v[$trb2] = 0;

				$data[$k] = $v;
			}
		}

		//var_dump($data);
		return $data;
	}

	// 資料編號的拉出參考
	public function handle_data_tmp($data)
	{
		$tmp = array();
		if($data and count($data) > 0){
			foreach($data as $k => $v){
				if(!isset($v['id'])){
					return $data;
				}
				$tmp[$v['id']] = $v;
			}
		}
		return $tmp;
	}

	// 卡的顯示，通常有一個格式，而且會統一，例如金卡(免年費)
	public function handle_card_name($data)
	{
		$cards = array();
		if($data and count($data) > 0){
			foreach($data as $k => $v){
				//$cards[$v['id']] = $v['name'].'('.$v['comments'].')';
				$cards[$v['id']] = $v['name'];
				if($v['comments'] != ''){
					$cards[$v['id']] .= '('.$v['comments'].')';
				}
			}
		}
		return $cards;
	}

	public function getAll($table, $params = array())
	{
		$v_table = '404';
		//$run = '$v_table = $this->table_'.$table.'('.$this->_function_params_generate($params).');';
		$run = '$v_table = $this->table_'.$table.'();';
		eval($run);
		if($v_table != '404' and $v_table != null){
			return $v_table;
		}

		return $this->db->createCommand()->from($table)->queryAll();
	}

	public function getRow($table, $id, $params = array())
	{
		$v_table = '404';
		//$run = '$v_table = $this->table_'.$table.'_tmp('.$id.$this->_function_params_generate($params, true).');';
		$run = '$v_table = $this->table_'.$table.'_tmp('.$id.');';
		eval($run);
		if($v_table != '404' and $v_table != null){
			return $v_table;
		}

		return $this->db->createCommand()->from($table)->where('id='.$id)->queryRow();
	}

	/*
	 * 把array(0=>xx1, 1=>xx2...
	 * 轉成xx1, xx2, ...
	 * @params 資料
	 * @need_comma 需要逗點，加在前面
	 */
	protected function _function_params_generate($params = array(), $need_comma = false)
	{
		$return = '';
		if(count($params) > 0){
			if($need_comma == true){
				$return .= ',';
			}
			// @k 純無用的流水號
			// 先把值左右加上逗點
			foreach($params as $k => $v){
				$params[$k] = '\''.$v.'\'';
			}
			$return .= implode(',', $params);
		}
		return $return;
	}

}

