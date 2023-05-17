<?php

if(!empty($_POST)){
	if(!isset($this->data['admin_id']) or $this->data['admin_id'] <= 0) die;

	$update = $_POST;

	if(isset($update['func'])){
		if($update['func'] == 'profile'){

			$update1 = array(
				'name' => $update['name'],
				// 'gender' => $update['gender'],
				'need_dm' => $update['need_dm'],
				'birthday' => $update['birthday'],
				// 'phone' => $update['phone'],

				// 2020-12-31
				// 'other1' => $update['other1'],
				// 'other2' => $update['other2'],
				// 'other3' => $update['other3'],
			);
			
			if(isset($update['gender'])){
			    $update1['gender'] = $update['gender'];
			}
			if(isset($update['phone'])){
			    $update1['phone'] = $update['phone'];
			}
			if(isset($update['email'])){
			    $update1['email'] = $update['email'];
			}
			if(isset($update['addr_county'])){
			    $update1['addr_county'] = $update['addr_county'];
			}
			if(isset($update['addr_district'])){
			    $update1['addr_district'] = $update['addr_district'];
			}
			if(isset($update['addr_zipcode'])){
			    $update1['addr_zipcode'] = $update['addr_zipcode'];
			}
			if(isset($update['addr'])){
			    $update1['addr'] = $update['addr'];
			}
			//2021-03-11		
			
			if(isset($update['other1'])){
			    $update1['other1'] = $update['other1'];
			}
			if(isset($update['other2'])){
			    $update1['other2'] = $update['other2'];
			}
			if(isset($update['other3'])){
			    $update1['other3'] = $update['other3'];
			}
			
			$update = $update1;
			
			$update = $update1;

			// if(!isset($update['need_dm'])){
			// 	$update['need_dm'] = 0;
			// }

			// $this->cidb->where('id', $this->data['admin_id']);
			// $this->cidb->update('customer', $update); 

			/*
			 * 載入後台的連絡我們，欄位的中文之接對應和取用
			 */
			$admin_field_router_class = 'customer';
			$admin_field_section_id = 0;

			include _BASEPATH.'/../source/system/admin_field_get.php';
			unset($admin_def['empty_orm_data']['rules'][0]); // remove login_account required
			unset($admin_def['empty_orm_data']['rules'][1]); // remove login_account unique 2020-12-31

			//$update = $_POST;

			$orm = new gorm($this->cidb, $admin_def['empty_orm_data']);
			$orm->data($update);
			$orm->find_by_id($this->data['admin_id']);
			$status = $orm->validate(); // 回傳true或false

			$this->data['base_url'] = FRONTEND_DOMAIN; //考慮有可能是https的情況，直接帶入常數

			if($status === false){
				// var_dump($orm->message());
				$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
				G::alert_captcha(t('欄位資料驗證失敗'), $redirect_url, $this->data);
			}

			$status = $orm->update(); // 回傳寫入狀態
			// $id = $db->insert_id();

			if($status === false){
				$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
				G::alert_captcha(t('寫入失敗'), $redirect_url, $this->data);
			}

			$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
			G::alert_captcha(t('修改成功'), $redirect_url, $this->data);

		}
	}

	die;
}
