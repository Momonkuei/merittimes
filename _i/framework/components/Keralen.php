<?php

class Keralen {

	protected $per_cycle_bonus_data = array();

	function __construct()
	{
		$this->db = Yii::app()->db;
		$this->cidb = Yii::app()->params['cidb'];
		$this->session = Yii::app()->session;
	}

	// 將庫存、商品、換貨的資訊匯出到eobstore
	// order, product, change
	public function export_barter_to_b2c()
	{
		$send = array();
		$send['order'] = $this->db->createCommand()->from('ten_order')->queryAll();
		$send['product'] = $this->db->createCommand()->from('ten_product')->where('is_enable=1')->queryAll();
		$send['change'] = $this->db->createCommand()->from('ten_change')->queryAll();

		//var_dump($send);
		//die;

		// http://stackoverflow.com/questions/2445276/how-to-post-data-in-php-using-file-get-contents
		$postdata = http_build_query(
				array(
					'send' => $send,
					//'user' => $_POST['account'],
					//'pass' => $_POST['password'],
				)
			);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		$context = stream_context_create($opts);

		$result = '';
		while(1){
			$result = @file_get_contents('http://tw.eobstore.com/_keralen_barter_save.php', false, $context);
			if(trim($result) == '1'){
				//return true;
				$result = '1';
				break;
			} else {
				$result = '';
			}

			// 過了1秒在重試
			sleep(1);
		}
		if($result == '1'){
			return true;
		} else {
			return false;
		}
	}

	//public function export_barter()
	//{
	//	// 送出會員的帳密
	//	$query = $this->cidb->where('is_enable', '0')->get('ten_member');
	//	$htpasswd = '';
	//	foreach($query->reusult_array() as $k => $v){
	//		// 範例htpasswd -nb gisanfu xxx
	//		$user = $v['number'];
	//		$pass = $v['pass'];
	//		$htpasswd .= trim(`htpasswd -nb $user $pass`);
	//	}
	//	echo $htpasswd;
	//	die;
	//}

	public function return_per_cycle_bonus()
	{
		return $this->per_cycle_bonus_data;
	}

	/*
	 * 計算個人循環獎金
	 * 回傳所得到的下線獎金的計錄，例如從哪些人身上得到多少錢之類的，而且是符合幾%
	 *
	 * 要算這個人之前，要先符合當週1000PV以上(含)，才能啟用這個運算式
	 *
	 * 下線第一層10%
	 * 第二層15%
	 * 第三層20%
	 * 緊縮式發放(就是如果其中一層個人業績沒有達到1000PV，繼續往下追，層數也往下推)
	 *
	 * 引數：
	 * @raw 資料庫的會員陣列多筆資料，要先轉成以pid為主的多筆集合陣列
	 * @id 是要算誰的循環獎金
	 * @pid 接下來要累算誰的
	 * @bonus 獎金10,15,20三代，無限代檢查
	 *
	 * 回傳：
	 */
	public function per_cycle_bonus($raw, $pid=0, $bonus=10)
	{
		if(isset($raw[$pid]) and count($raw[$pid]) > 0){
			// @v 會員資料
			foreach($raw[$pid] as $k => $v){
				// pv_week是由其它程序來處理，合併於會員的欄位裡面
				if($v['pv_week'] >= 1000){
					$this->per_cycle_bonus_data[$v['id']]['a'] = $bonus;
					$this->per_cycle_bonus_data[$v['id']]['b'] = ($v['pv_week']/100)*$bonus;

					$next_bonus = 10;
					if($bonus == 10){
						$next_bonus = 15;
					} elseif($bonus == 15){
						$next_bonus = 20;
					} else {
						// 這個節點發完了，沒啦，結束
						return;
					}

					$this->per_cycle_bonus($raw, $v['id'], $next_bonus);
				} else {
					// 個人PV沒有1000，那就在往下找，並且帶原本的獎金%數
					$this->per_cycle_bonus($raw, $v['id'], $bonus);
				}
			}
		} else {
			// 代表目前這個人是沒有組織的
			return;
		}

	} // per_cycle_bonus

	// // 消費獎金
	// public function consume_bonus
}
