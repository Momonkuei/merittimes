<?php

class XXXXXXXX_A extends XXXXXXXX_B
{
	/*
	 * 每一個公司會員和個人會員都會先經過這裡，檢查編號，以及檢查是否有購買
	 * @check_payment 代表只是做會員簡單的檢查，不會看有沒有付錢之類的
	 */
	public function member_check($check_payment = true)
	{
		if(!isset($_SESSION['authw_admin_id'])){
			throw new CHttpException(404,'Member not set.');
		}

		// 管理者不需要經過這個檢查
		if(0 and $check_payment and !preg_match('/1/', $_SESSION['auth_admin_type'])){
			$row = $this->db->createCommand()->from('member')->where('id='.$_SESSION['authw_admin_id'])->queryRow();
			if($row and isset($row['id'])){
				$check_status = true;
				if(preg_match('/^company(sell|buy|career|advert)/', $this->data['router_class'], $matches)){
					$service = 'company_'.$matches[1].'_plan_';

					// 先檢查日期欄位是否正常
					if($row[$service.'start_date'] == '0000-00-00'){
						$check_status = false;
					}
					if($row[$service.'end_date'] == '0000-00-00'){
						$check_status = false;
					}
					// 是否在時間範圍內
					if(strtotime($row[$service.'end_date']) >= strtotime(date('Y-m-d'))){
						// do nothing
					} else {
						$check_status = false;
					}
					// 帳號是否正確的啟用，而不是在等待Email確認之類的
					if($row['is_enable'] == '1'){
						// do nothing
					} else {
						$check_status = false;
					}
				} else {
					throw new CHttpException(404,'URL is not support check!');
				}
				if(!$check_status){
					$this->redirect($this->createUrl('memberpayment/index'));
					die;
				}
			} else {
				throw new CHttpException(404,'Member id is not exists!');
			}
		}
	}

	// 開通
	public function member_payment_enable($data_id)
	{
		$payment = $this->db->createCommand()->from('member_payment')->where('id=:id and is_enable=0', array(':id' => $data_id))->queryRow();

		if($payment and isset($payment['id'])){
			// do nothing
		} else {
			return true;
		}

		$service = '';

		// 這是寫死的，不用擔心主選單上面的名稱跟這裡不同步的時候的情況
		if($payment['plan_service'] == 	'買公司'){
			$service = 'buy';
		} elseif($payment['plan_service'] == '賣公司'){
		 	$service = 'sell';
		} elseif($payment['plan_service'] == '聘技師'){
			$service = 'career';
		} else {
			// 刊廣告
			$service = 'advert';
		}


		// 開通要做的事
		// 1. 處理該會員該服務的開啟和結束時間的天數
		// 2. payment該筆要改成is_enable=1
		// * 開通成功

		$member = $this->db->createCommand()->from('member')->where('id=:id and is_enable=1', array(':id' => $payment['member_id']))->queryRow();
		$service_name = 'company_'.$service.'_plan_';
		if($member and isset($member['id'])){

			/*
			 * 情況先大略寫一下
			 * 1. 第一次續費的狀況：開始與結束時間先用當天日期，然後結束時間加上天數
			 */

			$update = array();

			$update[$service_name.'start_date'] = $member[$service_name.'start_date'];
			$update[$service_name.'end_date'] = $member[$service_name.'end_date'];

			// 第一次的情況
			if($update[$service_name.'start_date'] == '0000-00-00'){

				$update[$service_name.'start_date'] = date('Y-m-d');
				$update[$service_name.'end_date'] = date('Y-m-d');

			} else {
				// http://stackoverflow.com/a/1940358
				$ts1 = strtotime($update[$service_name.'end_date']);
				$ts2 = strtotime(date('Y-m-d'));

				// 如果現在日期遠大於到期日，那就從今天開始吧
				if(($ts2 - $ts1) > 0){
					$update[$service_name.'end_date'] = date('Y-m-d');
				}

				// 突然覺得開始日，好像沒有什麼作用
				//unset($update[$service_name.'start_date']);
			}

			// 不管是不是第一次，都會在結束日期上面加上天數
			if($payment['plan_day'] != ''){
				$update[$service_name.'end_date'] = date('Y-m-d', strtotime('+'.$payment['plan_day'].' day', strtotime($update[$service_name.'end_date'])));
			}

			//     /*
			//      * 以下是舊的
			//      */

			//     $start_date_old = $member[$service_name.'start_date'];
			//     $end_date_old = $member[$service_name.'end_date'];

			//     // 第一次續費的設定
			//     if($member[$service_name.'start_date'] == '0000-00-00'){
			//     	$member[$service_name.'start_date'] = date('Y-m-d');
			//     }
			//     if($member[$service_name.'end_date'] == '0000-00-00'){
			//     	$member[$service_name.'end_date'] = date('Y-m-d');
			//     }

			//     if($payment['plan_day'] != ''){
			//     	$member[$service_name.'end_date'] = date('Y-m-d', strtotime('+'.$payment['plan_day'].' day', strtotime($member[$service_name.'end_date'])));
			//     }

			//     // 準備寫入新日期的程式

			//     $update = array();

			//     if($start_date_old != $member[$service_name.'start_date']){
			//     	$update[$service_name.'start_date'] = $member[$service_name.'start_date'];
			//     }

			//     if($end_date_old != $member[$service_name.'end_date']){
			//     	$update[$service_name.'end_date'] = $member[$service_name.'end_date'];
			//     }

			$sys_log_msg = 'enable service user_id:'.$_SESSION['authw_admin_id'].', name:'.$_SESSION['authw_admin_name'];

			$empty_orm_data = array(
				'table' => 'member',
				'created_field' => 'create_time', 
				'updated_field' => 'update_time',
				'primary' => 'id',
				'rules' => array(
				),
			);

			eval($this->data['empty_orm_eval']);
			$c = new $name('insert', $empty_orm_data);
			$u = $c::model()->findByPk($payment['member_id']);
			$u->setAttributes($update);
			if(!$u->update()){
				G::dbm($u->getErrors());
			}

			sys_log::set($sys_log_msg);

			// 標示己處理

			$update = array(
				'is_enable' => '1',
			);

			$empty_orm_data = array(
				'table' => 'member_payment',
				'created_field' => 'create_time', 
				'updated_field' => 'update_time',
				'primary' => 'id',
				'rules' => array(
				),
			);

			eval($this->data['empty_orm_eval']);
			$c = new $name('insert', $empty_orm_data);
			$u = $c::model()->findByPk($data_id);
			$u->setAttributes($update);
			if(!$u->update()){
				G::dbm($u->getErrors());
			}

		}
	}

}
