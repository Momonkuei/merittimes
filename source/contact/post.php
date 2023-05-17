<?php

if(!empty($_POST)){

	/*** 阻擋垃圾/色情留言****/
	if(file_exists(dirname(__FILE__).'/del_sex_contact.php')){
		include_once(dirname(__FILE__).'/del_sex_contact.php');
	}

	/*
	 * 2018-03-16 radio、select的欄位檢查
	 */
	// if(!isset($_POST['XXX']) or $_POST['XXX'] == ''){
	// 	$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
	// 	G::alert_captcha(t('Please Select `XXX`','en'), $redirect_url, $this->data);
	// }

	// 2018-03-31 select[]的欄位檢查 (至少選一項)
	// if(!isset($_POST['XXX']) or count($_POST['XXX']) <= 0){
	// 	$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=2';
	// 	G::alert_captcha(t('Please Select `XXX`','en'), $redirect_url, $this->data);
	// }
	
	// 2018-03-27 電子信箱的在次驗證
	if (isset($_POST['email'])){
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			// do nothing
		} else {
			$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=2';
		 	G::alert_captcha(t('Incorrent format `Email`','en'), $redirect_url, $this->data);
		}
	}

	// 2018-04-09 新增gtoken的檢查，下午有給李哥看過這個功能
	if(!isset($_POST['gtoken']) or $_POST['gtoken'] == '' or !isset(Yii::app()->session['gtoken']) or Yii::app()->session['gtoken'] == '' or Yii::app()->session['gtoken'] != $_POST['gtoken']){
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
		//G::alert_and_redirect(G::t(null,'驗證碼錯誤'), $redirect_url, $this->data); // current sample
		 G::alert_captcha(t('Incorrent token, please contact administrator','en'), $redirect_url, $this->data);
	}

	// if(!isset($_POST['captcha']) or Yii::app()->session['captcha'] != $_POST['captcha']){ // 疑似有問題 2017-08-28下午發現的
	if(!isset($_POST['captcha']) or $_POST['captcha'] == '' or !isset(Yii::app()->session['captcha']) or Yii::app()->session['captcha'] == '' or Yii::app()->session['captcha'] != $_POST['captcha']){
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=2';
		//G::alert_and_redirect(G::t(null,'驗證碼錯誤'), $redirect_url, $this->data); // current sample
		G::alert_captcha(t('驗證碼錯誤'), $redirect_url, $this->data); // iframe sample
	}

	// 安全性
	Yii::app()->session['gtoken'] = '';
	$_POST['gtoken'] = '';

	Yii::app()->session['captcha'] = '';
	$_POST['captcha'] = '';

	/*
	 * 一張圖片
	 * 附加檔案上傳
	 */
	//      $target_dir = "_i/assets/upload/".$this->data['router_method']."/";
	//      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	//      $uploadOk = 1;
	//      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	//      // Check if image file is a actual image or fake image
	//      if(isset($_POST["submit"])) {
	//      	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	//      	if($check !== false) {
	//      		//echo "File is an image - " . $check["mime"] . ".";
	//      		$uploadOk = 1;
	//      	} else {
	//      		$uploadOk = 0;
	//      		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=3';
	//      		G::alert_and_redirect(G::t(null,'File is not an image.'), $redirect_url, $this->data);
	//      	}
	//      }

	// Check file size
	//if ($_FILES["fileToUpload"]["size"] > 500000) {
	//	$uploadOk = 0;
	//	$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=3';
	//	G::alert_and_redirect(G::t(null,'Sorry, your file is too large.'), $redirect_url, $this->data);
	//}
	// Allow certain file formats
	// if(
	// 	strtolower($imageFileType) != "jpg" && 
	// 	strtolower($imageFileType) != "png" && 
	// 	strtolower($imageFileType) != "jpeg" && 
	// 	strtolower($imageFileType) != "gif" 
	// ) {
	// 		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=3';
	// 		G::alert_and_redirect(G::t(null,'Sorry, only JPG, JPEG, PNG & GIF files are allowed.'), $redirect_url, $this->data);
	// 		$uploadOk = 0;
	// 	}
	// // Check if $uploadOk is set to 0 by an error
	// if ($uploadOk == 0) {
	// 	$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=3';
	// 	G::alert_and_redirect(G::t(null,'Sorry, your file was not uploaded.'), $redirect_url, $this->data);
	// 	$uploadOk = 0;
	// 	// if everything is ok, try to upload file
	// } else {
	// 	$target_dir = "_i/assets/upload/".$this->data['router_method']."/";
	// 	$target_file = $target_dir . date('Y-m-d-H-i-s-').basename($_FILES["fileToUpload"]["name"]);
	// 	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	// 		//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	// 		$_POST['file1'] = $target_file;
	// 	} else {
	// 		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=3';
	// 		G::alert_and_redirect(G::t(null,'Sorry, there was an error uploading your file.'), $redirect_url, $this->data);
	// 	}
	// }

	/*
	 * 載入後台的連絡我們，欄位的中文之接對應和取用
	 */
	$admin_field_router_class = $this->data['router_method'];
	$admin_field_section_id = 0;

	include _BASEPATH.'/../source/system/admin_field_get.php';

	$savedata = $_POST;

	// 現在連絡我們表單的功能己經改成多語系
	$savedata['ml_key'] = $this->data['ml_key'];

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
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
		G::alert_captcha(t('欄位資料驗證失敗'), $redirect_url, $this->data);
	}

	$status = $orm->insert(); // 回傳寫入狀態
	$id = $this->cidb->insert_id();

	if($status === false){
		$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
		G::alert_captcha(t('寫入失敗'), $redirect_url, $this->data);
	}

	// 這個是寫入之後才做的東西
	if(isset($savedata['gender']) and $savedata['gender'] > 0){
		if($savedata['gender'] == '1'){
			$savedata['gender'] = t('男');
		} elseif($savedata['gender'] == '2'){
			$savedata['gender'] = t('女');
		}
	}

	if(isset($savedata['addr']) and $savedata['addr'] != ''){
		if(isset($savedata['district']) and $savedata['district'] != '') $savedata['addr'] = $savedata['district'].$savedata['addr'];
		if(isset($savedata['county']) and $savedata['county'] != '') $savedata['addr'] = $savedata['county'].$savedata['addr'];
		if(isset($savedata['zipcode']) and $savedata['zipcode'] != '') $savedata['addr'] = $savedata['zipcode'].$savedata['addr'];
	}

	// 寄件人、網站管理者Mail
	$to = $this->data['sys_configs']['service_admin_mail'];

	// 信件格式，目前只有用到標題
	$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic',array(':topic'=>'聯絡我們',':type'=>'emailformat',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

	// 主旨
	$subject = $this->data['sys_configs']['admin_title'].' Contact Us '.t('客戶聯絡信件');

	// 信件格式，這裡只有用到信件的標題而以
	if($emailformat and isset($emailformat['id']) and $emailformat['topic'] != ''){
		$email_topic = $emailformat['topic'];
		$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);
		// 記得最後要加上這一行，把多餘的額外欄位刪掉
		for($x=65;$x<=(65+26);$x++) $email_topic = str_replace('{'.chr($x).'}', '', $email_topic);
		$subject = $email_topic;
	}

	$aaa_url = aaa_url;
	$aaa_name = $this->data['sys_configs']['admin_title'];

	$body = t('此信為系統發出，請勿回覆')."\n\n";

	$body_html_content = '';
	if(count($admin_field) > 0){
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
				$body .= $field_name.': '.strip_tags($savedata[$k])."\n";

				if(preg_match('/^(file1)$/', $k)){
					$field_data = '<a href="'.FRONTEND_DOMAIN.'/'.$savedata[$k].'">相片</a>';
				} else {
					$field_data = strip_tags($savedata[$k]);
				}

				ob_start();
				//if($k%2 == 0){
				if($kk%2 == 0){ // 2016-11-18 小李建議的
?>
<tr bgcolor="#FBF0BD">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo $field_data?></td>
</tr>
<? } else { ?>		
<tr bgcolor="#FFFFFF">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo $field_data?></td>
</tr>
<?php 
				}
				$body_html_content .= ob_get_clean();
				$kk++;
			}
		}
	}

	if(isset($admin_def['updatefield']['sections'][1])){
		$admin_field = $admin_def['updatefield']['sections'][1]['field'];
		if(count($admin_field) > 0){
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
					$body .= $field_name.': '.strip_tags($savedata[$k])."\n";

					if(preg_match('/^(file1)$/', $k)){
						$field_data = '<a href="'.FRONTEND_DOMAIN.'/'.$savedata[$k].'">相片</a>';
					} else {
						$field_data = strip_tags($savedata[$k]);
					}

					ob_start();
					if($kk%2 == 0){
?>
<tr bgcolor="#FBF0BD">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo $field_data?></td>
</tr>
<? } else { ?>		
<tr bgcolor="#FFFFFF">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo $field_data?></td>
</tr>
<?php 
					}
					$body_html_content .= ob_get_clean();
					$kk +=1;
				}
			}
		}
	}

	$body_html = <<<XXX
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="0" cellpadding="4" cellspacing="1" bordercolorlight="#ffffff" bordercolordark="#666666" bgcolor="#CCCCCC" >
$body_html_content
</table>
<p style="font-size:13px;color:#999">$aaa_name $aaa_url</p>
XXX;

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

	if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
		and $tos and count($tos) > 0 and isset($tos[0]['id'])){
		if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
			$email_return = $this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html,$cc_mail);
		} else {
			$email_return = $this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
		}
	} else {	
		//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
	}

	// 2019-04-23 #31761 李哥說，需要做的
	if(is_array($email_return) and count($email_return) > 0){
		$this->cidb->where('id', $id);
		$this->cidb->update($admin_def['empty_orm_data']['table'], array('email_return'=>var_export($email_return,true))); 
		// echo \$this->cidb->affected_rows();
	}

	$redirect_url = $url_prefix.$this->data['router_method'].$url_suffix;

	$_SESSION['save'][$router_method] = array();
	unset($_SESSION['save'][$router_method]);
	unset(Yii::app()->session['save']);

	// 動態網址 2017-09-20有跟李哥討論過
	// if(1){
	// 	$redirect_url = '../index_'.$this->data['ml_key'].'.php';
	// }

	// 動態網址 (第2版)
	if(file_exists(_BASEPATH.'/assets/_dynamic_url.php')){
		include _BASEPATH.'/assets/_dynamic_url.php';

		if(isset($_dynamic_url) and in_array($this->data['router_method'],$_dynamic_url)){
			$redirect_url = '../index_'.$this->data['ml_key'].'.php';
		}
	}

	G::alert_and_redirect(t('送出成功'), $redirect_url, $this->data,true);
}
