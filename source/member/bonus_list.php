<?php
if(!isset($this->data['admin_id']) or $this->data['admin_id'] <= 0){
	$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('請先登入！'), $redirect_url, $this->data);
	die;
}

$bonus = $this->db->createCommand()->from('shopgoodies_log')->where('member_id=:id', array(':id'=>$this->data['admin_id']))->order('create_time desc')->queryAll();
$bonus_info = array(
	'total' => 0,
	'use' => 0,
);
if($bonus and !empty($bonus)){
	foreach($bonus as $k => $v){
		if($v['order_number'] != ''){ // 使用
			$bonus_info['use'] += $v['point'];
		} else { // 得到
			$bonus_info['total'] += $v['point'];
		}

		if($v['start_date'] == '0000-00-00 00:00:00'){
			$v['start_date_name'] = t('無使用期限');
		} else {
			$v['start_date_name'] = $v['start_date'];
		}

		if($v['end_date'] == '0000-00-00 00:00:00'){
			$v['end_date_name'] = t('無使用期限');
		} else {
			$v['end_date_name'] = $v['end_date'];
		}

		$bonus[$k] = $v;
	}
}

// Kevin 版
// $memberID = $this->data['admin_id'];
// $sql = $this->pdo->prepare("select * from bonus where memberID=:memberID order by id DESC");
// $sql->execute(array(":memberID" => $memberID));
// $bonus = $sql->fetchAll(PDO::FETCH_ASSOC);

// $bonus_info = array(
// 	'total' => 0,
// 	'use' => 0,
// );

// if($bonus and !empty($bonus)){
// 	foreach($bonus as $k => $v){
// 		if ($v['status'] == 2 && $v['bonus'] < 1) {
// 			$v['status'] = '扣除';
// 		} elseif ($v['status'] == 2) {
// 			$v['status'] = '已發放';
// 		} elseif ($v['status'] == 3) {
// 			$v['status'] = '訂單取消';
// 		} elseif ($v['status'] == 1) {
// 			$v['status'] = '待發放';
// 		}
// 		$bonus_info['total'] += $v['bonus']; //計算總紅利
// 		if($v['bonus'] < 0){ //計算使用紅利
// 			$bonus_info['use'] += (0-$v['bonus']);
// 		}
// 	}
// }

$data2[$ID]['single'] = array(
	$bonus_info,
);

$data2[$ID]['multi'] = array(
	$bonus,
);
