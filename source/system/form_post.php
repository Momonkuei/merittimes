<?php

/*
 * 2018-06-29 這裡是通用表單POST程式
 * 目前只有連絡我們在使用 beta版
 */

if(!empty($_POST)){ // and $this->data['router_method'] == 'XXX_1' 編排頁專用
	/*if(!isset($_SESSION['save']['google_token']) or $_SESSION['save']['google_token'] !=true){
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
		//G::alert_and_redirect(G::t(null,'驗證碼錯誤'), $redirect_url, $this->data); // current sample
		G::alert_captcha(t('已被google判斷為機器人，無法使用此功能'), $redirect_url, $this->data); // iframe sample
	}*/
	// 2020-01-21
	// seo在資料夾裡面送出以後，本來如果是tw/contact.php，會被送到tw/tw/contact.php裡面
	if($url_prefix != ''){
		$url_prefix = '/'.$url_prefix;
	}

	if(preg_match('/^(.*)_(.*)$/', $this->data['router_method'], $matches)){ // 編排頁網址
		$redirect_url = $url_prefix.$matches[1].'_'.$this->data['ml_key'].'_'.$matches[2].'.php';
	} else { // 一般網址
		$redirect_url = $url_prefix.$this->data['router_method'].$url_suffix;
	}

	// 2020-08-20
	// 如果是產品洽詢，就回到產品去
	if(preg_match('/^(.*)inquiry$/', $this->data['router_method'], $matches)){
		$redirect_url = $url_prefix.str_replace('inquiry','',$this->data['router_method']).$url_suffix;
	}

	/*** 阻擋垃圾/色情留言****/
	// 2020-02-10 李哥早上已允許修改關鍵字規則和流程
	// if(file_exists(dirname(__FILE__).'/del_sex_contact.php')){
	// 	include_once(dirname(__FILE__).'/del_sex_contact.php');
	// }

	/*
	 * 2018-03-16 radio、select的欄位檢查
	 */
	// if(!isset($_POST['XXX']) or $_POST['XXX'] == ''){
	// 	G::alert_captcha(t('Please Select `XXX`','en'), $redirect_url, $this->data);
	// }

	// 2018-03-31 select[]的欄位檢查 (至少選一項)
	// if(!isset($_POST['XXX']) or empty($_POST['XXX'])){
	// 	G::alert_captcha(t('Please Select `XXX`','en'), $redirect_url, $this->data);
	// }

	// 2018-03-27 電子信箱的再次驗證
	// if (isset($_POST['email'])){
	// 	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	// 		// do nothing
	// 	} else {
	// 	 	G::alert_captcha(t('Incorrent format `Email`','en'), $redirect_url, $this->data);
	// 	}
	// }

	// 2018-04-09 新增gtoken的檢查，下午有給李哥看過這個功能
	// 2020-03-19 如果是透過form_start過來這裡的，就一定會有gtoken
	if(!isset($_POST['gtoken']) or $_POST['gtoken'] == '' or !isset(Yii::app()->session['gtoken']) or Yii::app()->session['gtoken'] == '' or Yii::app()->session['gtoken'] != $_POST['gtoken']){
		//G::alert_captcha(t('Incorrent token, please contact administrator','en'), $redirect_url, $this->data);
		G::alert_captcha(t('網路傳輸延遲，請重新整理網頁'), $redirect_url, $this->data); // 2020-04-29 羊羊建議，李哥說要改 2021-12-09 改提醒文字 winnie建議
	}

	if(preg_match('/^(XXX)$/', $this->data['router_method'])){ // 2020-03-19 因為有些功能是沒有驗證碼的，可以透過這裡來跳脫
		// pass captcha
	} else {
		if(!isset($_POST['captcha']) or $_POST['captcha'] == '' or !isset(Yii::app()->session['captcha']) or Yii::app()->session['captcha'] == '' or Yii::app()->session['captcha'] != $_POST['captcha']){
			// G::alert_and_redirect(G::t(null,'驗證碼錯誤'), $redirect_url, $this->data); // current sample
			G::alert_captcha(t('驗證碼錯誤'), $redirect_url, $this->data); // iframe sample
		}

		// 安全性 2019-12-23 移到orm的下面，因為還是有可能會欄位驗證錯誤，錯誤後，原本的gtoken就會被刷新，造成使用者一定要重整頁面才能繼續
		// Yii::app()->session['gtoken'] = '';
		// $_POST['gtoken'] = '';

		// 安全性
		Yii::app()->session['captcha'] = '';
		$_POST['captcha'] = '';
	}
	//信箱+電話的正規表達式判斷
	if($this->data['ml_key']=='en'){
		$error_msg_p='Please enter the correct mobile number';
		$error_msg_m='Please enter your e-mail';
	}else{
		$error_msg_p='請輸入正確電話';
		$error_msg_m='請輸入正確信箱';
	}	
	if(!preg_match('/(\d{2,3}-?|\(\d{2,3}\))\d{3,4}-?\d{4}|09\d{2}(\d{6}|-\d{3}-\d{3})$/', $_POST['phone'])) {
		G::alert_captcha($error_msg_p, $redirect_url, $this->data);
	}  
	if(!preg_match('/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/', $_POST['email'])) {
		G::alert_captcha($error_msg_m, $redirect_url, $this->data);
	} 
	// 通用post裡面的登入範例
	if($this->data['router_method'] == 'XXX_Y'){
		$user = $_POST['login_account'];
		$pass = $_POST['login_password'];

		//$db = ggg_load_database("mysql://$Db_User:$Db_Pwd@$Db_Server/$Db_Name", true);
		$query = $this->cidb->where('login_account',$user)->where('is_enable',1)->get('customer');
		$row = $query->row_array();
		//$query = $db->where('login_account',$user)->where('login_password','{GGG3AAA}'.str_replace('a','ɢ', sha1(utf8_strrev($pass.$row['salt']))))->where('is_enable',1)->get($filename);
		$query = $this->cidb->where('login_account',$user)->where('login_password',$pass)->where('is_enable',1)->get('customer'); // 2018-06-26 資料表改成customer
		$row = $query->row_array();

		// $redirect_url = 'product_'.$this->data['router_method'].'_2.php';

		// if(isset($_POST['redirect_url']) and $_POST['redirect_url'] != ''){
		// 	$redirect_url = $_POST['redirect_url'];
		// }

		if($row and isset($row['id']) and $row['id'] > 0){
			$_SESSION['authw_admin_id'] = $row['id'];
			$_SESSION['authw_admin_name'] = $row['name'];

			// 2018-06-26 資料表是customer的情況
			// $_SESSION['authw_admin_id'] = $row['id'];

			$ggg = t('Login Success','en');
			$message = <<<XXX
<meta charset="utf-8">
<script type="text/javascript">
alert('$ggg');
window.top.location.href='$redirect_url';
</script>
XXX;
			echo $message;
			die;
		} else {
			$ggg = t('Login fail','en');
			$message = <<<XXX
<meta charset="utf-8">
<script type="text/javascript">
alert('$ggg');
window.location.href='$redirect_url';
</script>
XXX;
			echo $message;

			// 2020-03-19 記得沒有要寄信的時候，要結束程式，要不然一定會寄信
			die;
		}
	}

	/*
	 * 一張圖片
	 * 附加檔案上傳
	 * 
	 * 有要使用的話，在打開
	 * 預設關掉的
	 */
	if(0){
		$target_dir = '_i/assets/upload/'.str_replace('_','',$this->data['router_method']).'/';
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				//echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$uploadOk = 0;
				G::alert_and_redirect(G::t(null,'File is not an image.'), $redirect_url, $this->data);
			}
		}

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 5000000) {
			$uploadOk = 0;
			G::alert_and_redirect(G::t(null,'Sorry, your file is too large.'), $redirect_url, $this->data);
		}
		//Allow certain file formats
		if(
			strtolower($imageFileType) != "jpg" && 
			strtolower($imageFileType) != "png" && 
			strtolower($imageFileType) != "jpeg" && 
			strtolower($imageFileType) != "gif" 
		) {
			G::alert_and_redirect(G::t(null,'Sorry, only JPG, JPEG, PNG & GIF files are allowed.'), $redirect_url, $this->data);
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			G::alert_and_redirect(G::t(null,'Sorry, your file was not uploaded.'), $redirect_url, $this->data);
			$uploadOk = 0;
			// if everything is ok, try to upload file
		} else {
			$target_dir = "_i/assets/upload/".str_replace('_','',$this->data['router_method'])."/";
			$target_file = $target_dir . date('Y-m-d-H-i-s-').basename($_FILES["fileToUpload"]["name"]);
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				// 含相對路徑的檔名
				$_POST['file1'] = $target_file;

				// 上傳後台單檔上傳的格式(只有檔名，沒有路徑)
				// $_POST['pic1'] = str_replace($target_dir,'',$target_file);
			} else {
				G::alert_and_redirect(G::t(null,'Sorry, there was an error uploading your file.'), $redirect_url, $this->data);
			}
		}
	}

	/*
	 * 載入後台的連絡我們，欄位的中文之接對應和取用
	 */
	$admin_field_router_class = str_replace('_','', $this->data['router_method']); // str_replace是為了支援編排頁
	$admin_field_section_id = 0;

	include _BASEPATH.'/../source/system/admin_field_get.php';

	$savedata = $_POST;

	//2019-5-13 這裡的用途在於如果一直被垃圾/色情留言，開啟這裡可以在留言的同時清除資料庫上面的留言及阻擋黑名單內的關鍵字
	//讀取黑名單清單
	//$url = 'https://image.buyersline.com.tw/blacklist_message.txt';
	//$ch = curl_init();
	//curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	//$output = curl_exec($ch);
	//curl_close($ch);
	//eval($output);
	//
	//if(isset($tmp) && count($tmp) > 0){
	//	//刪除有關鍵字的留言
	//	foreach ($tmp as $key => $value) {		
	//		$this->cidb->like('detail', $value); 
	//		$this->cidb->delete($admin_def['table']);
	//	}

	//	//阻擋特定關鍵字送出
	//	if(isset($savedata["detail"]) && $savedata["detail"]!=''){
	//		foreach ($tmp as $key => $value) {
	//			if(stristr($savedata["detail"],$value)){
	//				die;
	//			}
	//		}
	//	}
	//}	

	// 現在連絡我們表單的功能己經改成多語系
	$savedata['ml_key'] = $this->data['ml_key'];

	// 2020-02-07 記錄IP，以及標示為骯髒的IP
	$savedata['ip_addr'] = get_client_ip();
	if($savedata['ip_addr'] != '' and preg_match('/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/', $savedata['ip_addr'])){
		if(hasblacklist($savedata['ip_addr'])){
			$savedata['is_dirty_ip'] = 1;
		}
	}

	// 2018-12-17 讓陣列，自動變成逗點分隔
	if($savedata and !empty($savedata)){
		foreach($savedata as $k => $v){
			if(is_array($v)){
				$savedata[$k] = implode(',', $v);
			}
		}
	}

	/*** 阻擋垃圾/色情留言****/
	// 2020-02-10 李哥早上已允許修改關鍵字規則和流程
	unset($tmp);
	$url = 'https://image3.buyersline.com.tw/blacklist_message.txt';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	$output = curl_exec($ch);
	curl_close($ch);

	eval($output);

	// has_dirty_keywords
	$savedata['has_dirty_keyword_log'] ='';
	$savedata['has_dirty_keyword'] = 0;
	if(isset($tmp) and is_array($tmp) and !empty($tmp)){
		$dirty_keyword = 0;
		foreach(array('detail','name','company_name','email','addr_merge') as $v){
			if(!isset($savedata[$v])){
				continue;
			}
			foreach($tmp as $vv){
				if(stristr($savedata[$v],$vv)){
					$dirty_keyword++;
					$savedata['has_dirty_keyword_log'] .=$v.' - '.$vv;
				}
			}
		}
		if($dirty_keyword > 0){
			$savedata['has_dirty_keyword'] = $dirty_keyword;
		}
	}

	// 產品洽詢(1/3)
	if(preg_match('/inquiry/', $this->data['router_method'])){
		// 寫入後，要回存回去的
		$detail_origin = '';
		//$tmp_inquiry = '';

		/*
		 * 2018-11-08
		 */
		$items = array(); // 洽詢的東西，裡面是存放session save的東西

		// 2018-07-19 如果A方案，要使用V1第二版的Datasource方式掛載，請用LayoutV3，將這個掛載放到head_start去運行
		if(isset($_SESSION['save'][$this->data['router_method']]) and !empty($_SESSION['save'][$this->data['router_method']])){
			$items = $_SESSION['save'][$this->data['router_method']];
		}

		// 2019-10-25
		if(!empty($items)){
			foreach($items as $k => $v){
				if(isset($v['ml_key']) and $v['ml_key'] != '' and $v['ml_key'] != $this->data['ml_key']){
					unset($items[$k]);
				}
			}
		}

		if(empty($items)){
			// 沒有詢問物件的話就轉跳到有詢問的地方 by lota 2018/6/13
			if(1){
				$redirect_url = str_replace('inquiry','',$this->data['router_method']).$url_suffix;		
				G::alert_and_redirect(t('無詢問物件，請先加入詢問'), $redirect_url, $this->data, true);
			} else { // A方案
		?>
<script type="text/javascript" m="body_end">
	$(document).ready(function() {
		alert('<?php echo t('無詢問物件，請先加入詢問','tw')?>');
		window.location.href='index_<?php echo $this->data['ml_key']?>.php';
	});
</script>	
		<?php
			}
		}

		include _BASEPATH.'/../source/system/inquiry.php';

		$form_items = array(); // 洽詢商品

		// 顯示在後台的內容上的
		if(!empty($items)){
			$detail_origin = $savedata['detail']; // 等一下要回存，因為信件內容，不用包含洽詢產品，洽詢的產品是有自己顯示的地方
			$savedata['detail'] .= "\n\n".'洽詢商品：'."\n";
			foreach($items as $k => $v){

				$url = FRONTEND_DOMAIN."/".$table."detail_".$this->data['ml_key'].".php?id=".$v['id'];

				$content1 = "\n\r <a href=\"".$url."\" target=\"_blank\"><img src=\"/".$v['pic']."\" alt=\"".$v['name']."\" style=\"width: 50px;\">".$v['name'];
				//$content2 = "\n\r <a href=\"http://".aaa_url."/".$table."detail_".$this->data['ml_key'].".php?id=".$v['id']."\" target=\"_blank\">".$v['name'];

				// 2019-12-26 李哥說不用圖片
				$form_item = array(
					'name' => $v['name'],
					'url' => $url,
					'amount' => 1, // 都會有這個欄位
				);

				if(isset($v['amount'])){
					if($v['amount'] > 0){
						$content1 .= '*'.$v['amount'];
						//$content2 .= '*'.$v['amount'];
						$form_item['amount'] = $v['amount'];
					} else {
						// #25678 如果有數量，但為零，那就不加上這一筆
						continue;
					}
				}

				$content1 .= "</a>\n\r";
				//$content2 .= "</a><br />\n\r";

				$savedata['detail'] .= $content1;
				$form_items[] = $form_item;

				//$tmp_inquiry .= $content2;
				// }
			}
		} else {
			$redirect_url = $url_prefix.$router_method.$url_suffix.'?status=3';
			G::alert_captcha(t('請先加入產品到詢問車'), $redirect_url, $this->data);
		}
	}

	// if(isset($savedata['addr']) and $savedata['addr'] != ''){
	// 	if(isset($savedata['district']) and $savedata['district'] != '') $savedata['addr'] = $savedata['district'].$savedata['addr'];
	// 	if(isset($savedata['county']) and $savedata['county'] != '') $savedata['addr'] = $savedata['county'].$savedata['addr'];
	// 	if(isset($savedata['zipcode']) and $savedata['zipcode'] != '') $savedata['addr'] = $savedata['zipcode'].$savedata['addr'];
	// }

	// https://redmine.buyersline.com.tw/issues/34615
	$addr_merge = '';
	foreach(array('zipcode','county','district','addr') as $v){
		if(isset($savedata[$v]) and $savedata[$v] != ''){
			$addr_merge .= $savedata[$v];
		}
	}
	$savedata['addr_merge'] = $addr_merge;

	// $empty_orm_data = array(
	// 	'table' => $this->data['router_method'],
	// 	'created_field' => 'create_time', 
	// 	//'updated_field' => 'update_time',
	// 	'primary' => 'id',
	// 	'rules' => array(
	// 		array('name, email', 'required'),
	// 	),
	// );

	// eval($this->data['empty_orm_eval']);
	// $u = new $name('insert', $empty_orm_data);
	// // 修改專用
	// //$u = $c::model()->findByPk($row['id']);
	// $u->setAttributes($savedata);
	// if(!$u->save()){
	// 	G::dbm($u->getErrors());
	// }

	$orm = new gorm($this->cidb, $admin_def['empty_orm_data']);
	$orm->data($savedata);
	$status = $orm->validate(); // 回傳true或false

	if($status === false){
		// var_dump($orm->message());
		G::alert_captcha(t('欄位資料驗證失敗'), $redirect_url, $this->data);
	}

	$status = $orm->insert(); // 回傳寫入狀態
	$id = $this->cidb->insert_id();

	if($status === false){
		G::alert_captcha(t('寫入失敗'), $redirect_url, $this->data);
	}

	// 產品洽詢(2/3)
	if(preg_match('/inquiry/', $this->data['router_method'])){
		// 回存
		$savedata['detail'] = $detail_origin;
	}

	// 安全性 2019-12-23 這個要放在欄位驗證之後才合理
	Yii::app()->session['gtoken'] = '';
	$_POST['gtoken'] = '';

	// 這個是寫入之後才做的東西
	// if(isset($savedata['gender']) and $savedata['gender'] > 0){
	// 	if($savedata['gender'] == '1'){
	// 		$savedata['gender'] = t('男');
	// 	} elseif($savedata['gender'] == '2'){
	// 		$savedata['gender'] = t('女');
	// 	}
	// }


	// 寄件人、網站管理者Mail
	$to = $this->data['sys_configs']['service_admin_mail'];

	// 信件格式，目前只有用到標題
	if(isset($admin_def['admin_title']) and $admin_def['admin_title'] != ''){ // 2018-06-29
		$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic',array(':topic'=>$admin_def['admin_title'],':type'=>'emailformat',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
	}

	// 主旨
	$subject2 = 'Contact Us'; // 預設值
	if(isset($admin_def['admin_title']) and $admin_def['admin_title'] != ''){ // 2018-06-29
		$subject2 = $admin_def['admin_title'];
	}

	// 產品洽詢(3/3)
	if(preg_match('/inquiry/', $this->data['router_method'])){
		$subject2 = 'Product Inquiry';
	}

	$subject = $this->data['sys_configs']['admin_title'].' '.$subject2;

	// 信件格式，這裡只有用到信件的標題而以
	if($emailformat and isset($emailformat['id']) and $emailformat['topic'] != ''){
		$email_topic = $emailformat['topic'];
		$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);

		// 記得最後要加上這一行，把多餘的額外欄位刪掉
		for($x=65;$x<=(65+26);$x++){
			$email_topic = str_replace('{'.chr($x).'}', '', $email_topic);
		}

		$subject = $email_topic;
	}

	$aaa_url = aaa_url;
	$aaa_name = $this->data['sys_configs']['admin_title'];
	$no_reply = t('此信為系統發出，請勿回覆');

	$body = '';
	$body .= $no_reply."\n\n";

	$form_fields = array();
	// $body_html_content = '';
	if(!empty($admin_field)){
		$kk = 0;
		foreach($admin_field as $k => $v){
			if(isset($savedata[$k])){
				$field_name = '';
				if(isset($v['mlabel'][3]) and $v['mlabel'][3] != ''){
					$field_name = $v['mlabel'][3];
				}
				if(isset($v['label']) and $v['label'] != ''){
					$field_name = $v['label'];
				}

				// 2020-09-29 李哥發現到的問題
				$field_name = strip_tags($field_name);
				$field_name = str_replace('(#)','',$field_name);

				if(preg_match('/^(file1)$/', $k)){
					$field_data = '<a href="'.FRONTEND_DOMAIN.'/'.$savedata[$k].'">相片</a>';
				} else {
					$field_data = strip_tags($savedata[$k]);
				}

				$form_field = array(
					'name' => $field_name,
					'value' => $field_data,
					'style' => '',
				);

				if($kk%2 == 0){
					$form_field['style'] = ' background-color:#fff9e0; ';
				}

				$body .= $field_name.': '.$field_data."\n";
				$form_fields[] = $form_field;

				$kk++;
			}
		}
	}

	if(isset($admin_def['updatefield']['sections'][1])){
		$admin_field = $admin_def['updatefield']['sections'][1]['field'];
		if(!empty($admin_field)){
			$kk = 0;
			foreach($admin_field as $k => $v){
				if(isset($savedata[$k])){
					$field_name = '';
					if(isset($v['mlabel'][3]) and $v['mlabel'][3] != ''){
						$field_name = $v['mlabel'][3];
					}
					if(isset($v['label']) and $v['label'] != ''){
						$field_name = $v['label'];
					}

					// 2020-09-29 李哥發現到的問題
					$field_name = strip_tags($field_name);
					$field_name = str_replace('(#)','',$field_name);

					if(preg_match('/^(file1)$/', $k)){
						$field_data = '<a href="'.FRONTEND_DOMAIN.'/'.$savedata[$k].'">相片</a>';
					} else {
						$field_data = strip_tags($savedata[$k]);
					}

					$form_field = array(
						'name' => $field_name,
						'value' => $field_data,
						'style' => '',
					);

					if($kk%2 == 0){
						$form_field['style'] = ' background-color:#fff9e0; ';
					}

					$body .= $field_name.': '.$field_data."\n";
					$form_fields[] = $form_field;

					$kk +=1;
				}
			}
		}
	}

	$embeddedimages = array();
	$embeddedimages[] = array(
		'cid' => 'logo',
		//'path' => _BASEPATH.'/../images/sendmail_title.png',
		'path' => _BASEPATH.'/../images/logo_banner.jpg',
	);
	
	ob_start();
	include _BASEPATH.'/../view/mail_template/inquiry.php';
	$body_html = ob_get_clean();

	// 找一下寄件人有沒有設定
	$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

	// 找一下收件人有沒有設定
	$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

	//設定cc收件者
	if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true){
		$cc_mail = $savedata['email'];
	} else {
		$cc_mail = NULL;
	}
	
	// 2019-04-23 #31761 李哥說，需要做的
	$email_return = array();

	// 要查詢什麼欄位被阻擋，就打開它去看
	// echo $savedata['has_dirty_keyword_nono'];die;

	if($from and !empty($from) and isset($from['id']) and isset($from['email'])
		and $tos and !empty($tos) and isset($tos[0]['id'])
		and $savedata['has_dirty_keyword'] <= 1 // 2020-02-10 李哥決定的
	){
		if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
			$email_return = $this->email_send_to_by_sendmail($from, $tos, $subject, $body, $body_html, $cc_mail, $embeddedimages);
		} else {
			$email_return = $this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
		}
	} else {	
		//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
	}

	// 2019-04-23 #31761 李哥說，需要做的
	if(is_array($email_return) and !empty($email_return)){
		$this->cidb->where('id', $id);
		$this->cidb->update($admin_def['empty_orm_data']['table'], array('email_return'=>var_export($email_return,true))); 
		// echo \$this->cidb->affected_rows();
	}

	$_SESSION['save'][$this->data['router_method']] = array();
	unset($_SESSION['save'][$this->data['router_method']]);
	unset(Yii::app()->session['save']);

	// 動態網址 2017-09-20有跟李哥討論過
	// if(1){
	// 	$redirect_url = '../index'.$url_suffix;
	// }

	//聯絡我們送出後直接轉跳原頁，並加send_ok參數 by lota
	if($this->data['router_method']=='contact')
	{
		$redirect_url = $this->data['router_method'].$url_suffix.'?send_ok=1';
	}

	// 動態網址 (第2版)
	if(file_exists(_BASEPATH.'/assets/_dynamic_url.php')){
		include _BASEPATH.'/assets/_dynamic_url.php';

		if(isset($_dynamic_url) and in_array($this->data['router_method'],$_dynamic_url)){
			$redirect_url = '../index'.$url_suffix;
		}
	}

	G::alert_and_redirect(t('送出成功'), $redirect_url, $this->data,true);
}
