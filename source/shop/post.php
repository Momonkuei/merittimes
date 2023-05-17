<?php

/*
 * 購物車的session的key值的定義
 *
 * 形式(normal|ip|ap)_產品編號_規格編號
 * normal: 一般產品
 * ip: 加價購產品
 * ap: 加購產品
 * promo:滿額加價購產品
 */

$prefix = $this->data['router_method'];
if(!empty($_POST)){
	$post = $_POST;
	if(!isset($post['func']) or $post['func'] == '') die;

	$t_refresh = t('請重新整理頁面');
	$t_select_spec = t('請選擇規格');
		
	if($post['func'] == 'addfavorite'){ // 這裡的ADD是會員哦
		$row = $this->db->createCommand();
		// 先看有沒有(此時不管時間)
		$row = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id',array(':id'=>$post['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
		if($row and isset($row['id'])){
			$update = array(
				'start_date' => $post['add_date'],
			);
			$this->cidb->where('id', $row['id']);
			$this->cidb->update('html', $update); 
		} else {
			$save = array(
				'type' => 'favorite',
				'ml_key' => $this->data['ml_key'],
				'is_enable' => 1,
				'start_date' => $post['add_date'],
				'other1' => $post['id'],
				'other2' => '', // 沒有選規格
				'member_id' => $this->data['admin_id'],
			);
			$this->cidb->insert('html', $save); 
			// $id = $this->cidb->insert_id();
		}
		$t = t('己加入我的收藏');
		echo <<<XXX
		thisobj.addClass('active');
		alert('$t');
		XXX;

	} elseif($post['func'] == 'delcar'){
		// 這裡的post['id']是normal_xx_xx
		if(isset($_SESSION['save'][$prefix.'_car'][$post['id']])){

			unset($_SESSION['save'][$prefix.'_car'][$post['id']]);
			//購物車剩餘產品是否只剩加購品--------------------------------------------------------------start
			$promotext='';
			$have_normal=false;//是否有普通商品
			$to_fullcount=false;//滿額加購價--
			if(isset($_SESSION['save']['shop_car']) && !empty($_SESSION['save']['shop_car'])){
				foreach($_SESSION['save']['shop_car'] as $k => $v){
					if(strpos($k,'normal')!==false){	
						$have_normal=true;
					}
					
				}				
			}
			if($have_normal==false){
				unset($_SESSION['save']);
				$promotext=t('\n請勿單獨購買加購品');
			}
			//檢測價格是否達到門檻
			if(!empty($_SESSION['save']['shop_car']) && $to_fullcount==true){
			}
			//購物車剩餘產品是否只剩加購品--------------------------------------------------------------end
			$t = t('己刪除此項產品').$promotext;
			echo <<<XXX
				alert('$t');
				window.location.reload();
				XXX;
			die;
		}
	} elseif($post['func'] == 'addcar'){
		if(!isset($_SESSION['save'][$prefix.'_car'])) $_SESSION['save'][$prefix.'_car'] = array();
		$car = $_SESSION['save'][$prefix.'_car'];
		// 這個是非產品內頁使用加入購物車會用到的
		// 因為非產品內頁，不會有加價購，所以那邊我就沒有用到tid
		$tid = '';
		if(isset($post['tid']) and $post['tid'] != ''){
			$tid = $post['tid'];
		}
		$check = false; // 這種狀態是不會加入購物車的，除非照正常的檢查程序
		// 規格暫存
		//$spec = false;
		$spec = array();
		//if(isset($post['specid']) and $post['specid'] != '' and $post['specid'] > 0){
		//	// 收藏有規格的情況
		//	$spec = array(
		//		'specid' => $post['specid'],
		//		//'amount' => 1,
		//	);
		if(isset($_SESSION['save'][$prefix.'_spec'][$post['id']])){
			// 產品內頁，有點選規格屬性的情況
			$spec = $_SESSION['save'][$prefix.'_spec'][$post['id']];
		}

		// 2020-05-25 試試看
		if(isset($post['specid']) and $post['specid'] > 0 and !isset($spec['specid'])){
			$spec['specid'] = $post['specid'];
		}

		// 產品內頁，和非產品內頁都會有相同的情況，因為預設值都是1，但是沒有觸發的情況下，是不會寫入session的
		if(!isset($spec['amount'])){
			$spec['amount'] = 1;
		}


		if(isset($spec['refresh']) and $spec['refresh'] == '1' && 0){ //2021-06-08 這邊應該是限制到列表頁加入購物車了..先關閉這個功能 by lota
			// 不打算讓他在內頁不斷的加入購物車
			echo <<<XXX
				$('#amount_status').html('$t_refresh');
				alert('$t_refresh');
				XXX;
			die;
		}
		// print_r($_SESSION['save']);die;
		//增加購物車加購品判斷----------------------------------------------------------------------------start
		//普通加購品
		if(isset($post['has_additional_purchase']) and $post['has_additional_purchase'] == '1'){
			$have_normal=false;
			if(isset($_SESSION['save']['shop_car']) && !empty($_SESSION['save']['shop_car'])){
				foreach($_SESSION['save']['shop_car'] as $k => $v){
					if(strpos($k,'normal')!==false){	
						$have_normal=true;
					}
				}
			}
			if($have_normal==false){
				$t = t('請勿單獨購買加購商品');
				echo <<<XXX
				
				alert('$t');
				location.reload();
				XXX;
				die;
			}
		}
		//滿額加購品
		if(isset($post['has_additional_promo']) and $post['has_additional_promo'] == '1'){
			$have_normal=false;
			if(isset($_SESSION['save']['shop_car']) && !empty($_SESSION['save']['shop_car'])){
				foreach($_SESSION['save']['shop_car'] as $k => $v){
					if(strpos($k,'normal')!==false){	
						$have_normal=true;
					}
				}
			}
			if($have_normal==false){
				$t = t('請勿單獨購買滿額加購商品');
				echo <<<XXX
				
				alert('$t');
				location.reload();
				XXX;
				die;
			}
		}
		//增加購物車加購品判斷----------------------------------------------------------------------------end		
		// 先檢查每一筆加價購的數量
		$ip = array();
		if(isset($_SESSION['save'][$prefix.'_increase_purchase'])){
			$ip = $_SESSION['save'][$prefix.'_increase_purchase'];
		}
		if(!empty($ip)){
			foreach($ip as $k => $v){
				//$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and specid=:specid', array(':id'=>$k,':specid'=>$v['specid']))->queryRow();
				$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and id=:specid', array(':id'=>$k,':specid'=>$v['specid']))->queryRow();
				$row2 = $this->db->createCommand()->from($prefix)->where('is_enable=1 and id=:id', array(':id'=>$k))->queryRow();
				$name = $row2['name'];
				if($row){
					if($v['amount'] > $row['inventory']){
						$t = t('請重新選擇數量');
						$t1 = t('您所購買的');
						$t2 = t('的加價購數量己超過購買數量');
						echo <<<XXX
						$('#amount_status').html('$t');
						alert('$t1"$name"$t2');
						XXX;
						die;
					}else if($v['price2'] <= 0){ //2020/08/19 檢查金額是否為0，若是則不給加入 by lota
						$t = t('操作異常');
					echo <<<XXX
					$('#amount_status').html('$t');
					alert('$t_refresh');
					XXX;
					die;
					} else {
						// 繼續往下一個步驟走
					}
				} else {
					$t1 = t('請選擇');
					$t2 = t('規格');
					echo <<<XXX
					$('#amount_status').html('$t_select_spec');
					alert('$t1"$name"$t2');
					XXX;
				}
			}
		}

		//var_dump($spec);die;

		// 接下來檢查規格
		// var_dump($spec);die;
		if(isset($spec['specid']) and $spec['specid'] > 0){
			//$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and specid=:specid', array(':id'=>$post['id'],':specid'=>$spec['specid']))->queryRow();
			$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and id=:specid', array(':id'=>$post['id'],':specid'=>$spec['specid']))->queryRow();
			if($row){
				if(!empty($car["normal_".$post['id']."_".$spec['specid']]) ){//20220729 lin 增加判斷有購物車時加購數量上限
					if(isset($post['id_key_name']) and $post['id_key_name'] != ''){

					}
					else{
						if($car["normal_".$post['id']."_".$spec['specid']]["amount"]+$spec['amount'] > $row['inventory']){
							$t = t('請重新選擇數量');
							$t1 = t('您所購買的數量己超過購買數量');
							echo <<<XXX
							$('#amount_status$tid').html('$t');
							alert('$t1');
							XXX;
							die;
						}
					}
					
				} 
				if($spec['amount'] > $row['inventory']){
					$t = t('請重新選擇數量');
					$t1 = t('您所購買的數量己超過購買數量');
					echo <<<XXX
					$('#amount_status$tid').html('$t');
					alert('$t1');
					XXX;
					die;
				}
				else if($spec['amount'] == 0){
					$t = t('請選擇購買的數量');
					$t1 = t('請選擇購買的數量');
					echo <<<XXX
					$('#amount_status$tid').html('$t');
					alert('$t1');
					XXX;
					die;
				}
				else if($row['price2'] <= 0){ //2020/08/19 檢查金額是否為0，若是則不給加入 by lota
					$t = t('操作異常');
					echo <<<XXX
					$('#amount_status$tid').html('$t');
					alert('$t_refresh');
					XXX;
					die;
				} else {
					// 繼續往下一個步驟走
					$check = true;

					$row_tmp = array(
						array(
							//'id' => $row['specid'],
							'id' => $row['id'],
						),
					);
				}
			} else {
				echo <<<XXX
				$('#amount_status$tid').html('$t_select_spec');
				alert('$t_select_spec');
				XXX;
			}
		} elseif(
			(isset($spec['attr1']) and $spec['attr1'] != '')
			or (isset($spec['attr2']) and $spec['attr2'] != '')
			or (isset($spec['attr3']) and $spec['attr3'] != '')
			or (isset($spec['attr4']) and $spec['attr4'] != '')
		){
			$search_data = array(':type'=>$prefix.'spec',':ml_key'=>$this->data['ml_key']);
			$search_fields = array();
			$search_field = '';

			for($x=1;$x<=4;$x++){
				if(isset($spec['attr'.$x]) and $spec['attr'.$x] != ''){
					$search_fields[] = 'other'.$x.'=:other'.$x;
					$search_data[':other'.$x] = $spec['attr'.$x];
				}
			}
			$search_field = implode(' and ', $search_fields);
			//echo $search_field;
			//var_dump($search_data);
			//die;

			$row_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and '.$search_field,$search_data)->queryAll();
			//echo $post['id'];
			//var_dump($row_tmp[0]);die;
			$_count = count($row_tmp);
			if($row_tmp and $_count == 1){
				//$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and specid=:specid', array(':id'=>$post['id'],':specid'=>$row_tmp[0]['id']))->queryRow();
				$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and id=:specid', array(':id'=>$post['id'],':specid'=>$row_tmp[0]['id']))->queryRow();

				if($row){
					if($spec['amount'] > $row['inventory']){
						$t = t('您所購買的數量己超過購買數量');
						echo <<<XXX
							$('#amount_status$tid').html('$t_refresh');
							alert('$t');
							XXX;
						die;
					} else {
						// 繼續往下一個步驟走
						$check = true;
					}
				} else {
					echo <<<XXX
						$('#amount_status$tid').html('$t_select_spec');
						alert('$t_select_spec');
						XXX;
					die;
				}
			} else {
				//var_dump($row_tmp);die;
				echo <<<XXX
					$('#amount_status$tid').html('$t_select_spec');
					alert('$t_select_spec');
					XXX;
				die;
			}
		} else {
			echo <<<XXX
				$('#amount_status$tid').html('$t_select_spec');
				alert('$t_select_spec');
				XXX;
			die;
		}
		
		// 如果有指定購物車內的產品編號(例：normal_1_326)，那就刪掉它，這個是step1的列表修改功能在用的
		if(isset($post['id_key_name']) and $post['id_key_name'] != ''){
			unset($_SESSION['save'][$prefix.'_car'][$post['id_key_name']]);
			unset($car[$post['id_key_name']]);
		}
		
		$item_type = 'normal'; // 預設的形式是一般般的購物產品
		if(isset($post['has_additional_purchase']) and $post['has_additional_purchase'] == '1'){
			$item_type = 'ap';
		}
		if(isset($post['has_additional_promo']) and $post['has_additional_promo'] == '1'){
			$item_type = 'promo';
		}
		/*
		 * 一般產品(累加)
		 */

		$tmp = array();
		if(isset($car[$item_type.'_'.$post['id'].'_'.$row_tmp[0]['id']])){
			$tmp = $car[$item_type.'_'.$post['id'].'_'.$row_tmp[0]['id']];
		}
		if(isset($tmp['amount']) and $tmp['amount'] > 0){
			$tmp['amount'] += $spec['amount'];
		} else {
			$tmp['amount'] = $spec['amount'];
		}

		$tmp['specid'] = $row_tmp[0]['id'];

		$tmp['specname'] = $row['name']; //2021-06-05 lota add
		$_SESSION['save'][$prefix.'_car'][$item_type.'_'.$post['id'].'_'.$row_tmp[0]['id']] = $tmp;

		// 加價購產品(覆寫)
		$tmp = array();
		if(!empty($ip)){
			foreach($ip as $k => $v){
				$tmp = $v;
				$tmp['pid'] = $post['id'];
				$_SESSION['save'][$prefix.'_car']['ip_'.$k.'_'.$v['specid']] = $tmp;
			}
		}
		
		/*
		 * 收藏
		 * 加入購物車，會順便加入收藏
		 */

		// #35830 李哥說先註解，之後有用到在打開
		// if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
		// 	// 加入購物車，會有規格，所以先刪掉同品項沒規格的
		// 	$del = array(
		// 		'type' => 'favorite',
		// 		'is_enable' => '1',
		// 		'ml_key' => $this->data['ml_key'],
		// 		'member_id' => $this->data['admin_id'],
		// 		'other1' => $post['id'],
		// 		'other2' => '',
		// 	);
		// 	$this->cidb->delete('html', $del); 

		// 	$row = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id',array(':id'=>$post['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
		// 	if($row and isset($row['id'])){
		// 		$update = array(
		// 			'start_date' => date('Y-m-d'),
		// 		);
		// 		$this->cidb->where('id', $row['id']);
		// 		$this->cidb->update('html', $update); 
		// 	} else {
		// 		$save = array(
		// 			'type' => 'favorite',
		// 			'ml_key' => $this->data['ml_key'],
		// 			'is_enable' => 1,
		// 			'start_date' => date('Y-m-d'),
		// 			'other1' => $post['id'],
		// 			'other2' => $row_tmp[0]['id'],
		// 			'member_id' => $this->data['admin_id'],
		// 		);
		// 		$this->cidb->insert('html', $save); 
		// 		// $id = $this->cidb->insert_id();
		// 	}
		// } else {
		// 	// 先把沒有規格的該產品收藏給刪掉
		// 	if(isset($_SESSION['save'][$prefix.'_favorite'][$post['id'].'_0'])){
		// 		unset($_SESSION['save'][$prefix.'_favorite'][$post['id'].'_0']);
		// 	}

		// 	// 加入收藏
		// 	$_SESSION['save'][$prefix.'_favorite'][$post['id'].'_'.$row_tmp[0]['id']] = array(
		// 		'add_date' => date('Y-m-d'),
		// 	);
		// }
		
		// 清除快取
		$_SESSION['save'][$prefix.'_spec'][$post['id']]['refresh'] = 1;
		unset($_SESSION['save'][$prefix.'_increase_purchase']);
		$tid_other = '';
		//if($tid != ''){ // 2017/7/ 因為不一定有加價購區塊，所以這邊先預設強迫重整 by lota 3
			//location.reload();
			$tid_other = 'location.reload();';
		//}

		// 直接購買
		if(isset($post['now']) and $post['now'] == 1){
			if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){ // 2020-06-18
				$tid_other = 'window.location.href="checkout_'.$this->data['ml_key'].'.php";';
			} else {
				if(LAYOUTV3_THEME_NAME=='v4'){
					$tid_other = '$("#_check_now").click()';//V4
				}else{
					$tid_other = '$("#loginPanel").addClass("open")';//V3
				}
				
			}
		}
		if(isset($post['id_key_name']) and $post['id_key_name'] != ''){
			$t = t('成功修改購物車');
			echo <<<XXX
				$('#amount_status$tid').html('');
				alert('$t');

				$tid_other

				XXX;
		} else {
			$t = t('成功加入購物車');
			echo <<<XXX
				$('#amount_status$tid').html('');
				alert('$t');

				$tid_other

				XXX;
		}
		die;

	} else if($post['func'] == 'changSpec'){
		$num = $_POST["num"];//數量
		$color = $_POST["color"];//規格ID
		$ProductNo = $_POST["productno"];//主產品ID

		$spec_data = $this->db->createCommand()->from('shopspec')->where('data_id=:data_id and id=:id', array(':id'=>$color,':data_id'=>$ProductNo))->queryRow();
		if($spec_data['inventory']-$num>=0){
			$msg=1;
		}else{
			$msg=0;
		}
		echo $msg;
	} // addcar
	die;
}
