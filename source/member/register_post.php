<?php

/*
 * 想要在這裡寫一個處理Empty_orm的hack
 */
//$tmp = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/share/').'Empty_source_orm.php');
$tmp = file_get_contents(_BASEPATH.ds('/web/controllers/share/').'Empty_source_orm.php');
$this->data['empty_orm'] = explode("\n", $tmp);
$this->data['empty_orm_title'] = ' extends CActiveRecord';
$this->data['empty_orm_count'] = 0;
$this->data['empty_orm'][2] = 'class Empty_orm';
unset($this->data['empty_orm'][0]);
unset($this->data['empty_orm'][1]);

// reindex array
// http://stackoverflow.com/questions/5217721/how-to-remove-array-element-and-then-re-index-array
$this->data['empty_orm'] = array_values($this->data['empty_orm']);

// 使用新款Empty的原始方式
// $this->data['empty_orm_count']++;
// $eval_content = $this->data['empty_orm'];
// $eval_content[0] .= (string)$this->data['empty_orm_count'].$this->data['empty_orm_title'];
// eval(implode("\n", $eval_content));
// $name = 'Empty_orm'.$this->data['empty_orm_count'];
// $u = new $name('insert', $this->def['empty_orm_data']);

$this->data['empty_orm_eval']  = ''; 
$this->data['empty_orm_eval'] .= '$this->data[\'empty_orm_count\']++;'."\n";
$this->data['empty_orm_eval'] .= '$eval_content = $this->data[\'empty_orm\'];'."\n";
$this->data['empty_orm_eval'] .= '$eval_content[0] .= (string)$this->data[\'empty_orm_count\'].$this->data[\'empty_orm_title\'];'."\n";
$this->data['empty_orm_eval'] .= 'eval(implode("\n", $eval_content));'."\n";
$this->data['empty_orm_eval'] .= '$name = \'Empty_orm\'.$this->data[\'empty_orm_count\'];'."\n";

// 使用新款Empty的另一種方式
//eval($this->data['empty_orm_eval']);
//$c = new $name('insert', $this->data['def']['empty_orm_data']);

// 前後台都會用到
$empty_orm_data = array(
	'table' => 'customer',
	'created_field' => 'create_time', 
	'updated_field' => 'update_time',
	'primary' => 'id',
	'rules' => array(
		array('name,email,login_account,login_password', 'required'),
		//array('login_password', 'system.backend.extensions.myvalidators.sha1passchange'),
	),
);

if(!empty($_POST)){
	$post = $_POST;
	if($post['captcha'] != Yii::app()->session['captcha']){

	// 如果成功，就清session，很重要哦
	Yii::app()->session['captcha'] = '';

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('<?php echo t('驗證碼失效，請重新整理')?>');
	window.location.href='guestregister_'.<?php echo $this->data['ml_key'].'.php';
</script>
<?php
		die;
	}

	// 如果驗證碼檢查通過，那就清session，很重要哦
	Yii::app()->session['captcha'] = '';

	//$u = new Empty_orm('insert', $empty_orm_data);

	eval($this->data['empty_orm_eval']);
	$u = new $name('insert', $empty_orm_data);

	//$this->data['datasave'] = $savedata;

	$post['is_enable'] = 1;
	$post['email'] = $post['login_account'];

	/*
	 * 強制用第三種加密方式
	 */

	$post['salt'] = G::GeraHash(10);
	$post['login_password'] = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($post['login_password'].$post['salt'])));

	// 如果是用Social登入的話
	if(isset($post['_social_type']) and $post['_social_type'] != ''){
		if($post['_social_type'] == 'facebook'){
			$post['facebook_id'] = $post['_social_id'];
		} elseif($post['_social_type'] == 'google'){
			$post['googleplus_id'] = $post['_social_id'];
		}
	}

	$u->setAttributes($post);

	// 做了這個動作，才會處理預設值等validator(像是處理create_time和update_time的動作)
	if(!$u->validate()){
		//G::dbm($u->getErrors());
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('<?php echo t('你有欄位沒有填好!')?>');
	window.location.href='guestregister_'.<?php echo $this->data['ml_key'].'.php';
</script>
<?php
		die;
	}

	// save自己會做validate
	if(!$u->save()){
		//G::dbm($u->getErrors());
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('<?php echo t('系統異常')?>');
	window.location.href='guestregister_'.<?php echo $this->data['ml_key'].'.php';
</script>
<?php
		die;
	}

	/*
	//註冊完寄信通知網站管理者 - 從聯絡我們copy過來的
	//處理輸入的資料
	$savedata = $post;
	if(isset($savedata['gender']) and $savedata['gender'] > 0){
		if($savedata['gender'] == '1'){
			$savedata['gender'] = G::t(null,'男');
		} elseif($savedata['gender'] == '2'){
			$savedata['gender'] = G::t(null,'女');
		}
	}

	$contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/controllers/').ucfirst('customer').'Controller.php');
	$contentx = str_replace('<'.'?'.'php', '', $contentx);
	$contentx = str_replace('extends Controller', '', $contentx);
	$contentx = str_replace('protected $def', 'static public $def', $contentx);
	
	// 把懶人機制拿掉
	$contentx = str_replace('$tmps = explode(\'/\',__FILE__);', '', $contentx);
	$contentx = str_replace('$filename = str_replace(\'.php\',\'\',$tmps[count($tmps)-1]);', '', $contentx);
	$contentx = str_replace('eval(\'class \'.$filename.\' extends NonameController {}\');', '', $contentx);
	
	eval($contentx);

	eval('$admin_def = NonameController::$def;');
	$admin_field = $admin_def['updatefield']['sections'][0]['field'];

	//移除不必要的資訊
	unset($admin_field['login_password']);
	unset($admin_field['login_password_confirm']);
	unset($admin_field['is_enable']);

	// 寄件人、網站管理者Mail
	$to = $this->data['sys_configs']['service_admin_mail'];

	// 主旨
	$subject = $this->data['sys_configs']['admin_title'].' Register '.G::t(null,'客戶註冊通知信件');

	$aaa_url = aaa_url;
	$aaa_name = $this->data['sys_configs']['admin_title'];

	$body = G::t(null,'此信為系統發出，請勿回覆')."\n\n";

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
				ob_start();
				//if($k%2 == 0){
				if($kk%2 == 0){ // 2016-11-18 小李建議的
?>
<tr bgcolor="#FBF0BD">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<? } else { ?>		
<tr bgcolor="#FFFFFF">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php echo strip_tags($savedata[$k])?></td>
</tr>
<?php 
				}
				$body_html_content .= ob_get_clean();
				$kk++;
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
	if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true)
		$cc_mail = $savedata['email'];
	else
		$cc_mail = NULL;

	if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
		and $tos and count($tos) > 0 and isset($tos[0]['id'])){
		if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
			$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html,$cc_mail);
		} else {
			$this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
		}
	} else {	
		//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
	}

	*/


	//註冊後直接登入
	$id = $this->db->getLastInsertID();
	Yii::app()->session->add('authw_admin_id', $id);  
	Yii::app()->session->add('authw_admin_account', $post['login_account']);  
	Yii::app()->session->add('authw_admin_name', $post['name']);  
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('<?php echo t('己加入會員')?>');
	window.location.href='index_<?php echo $this->data['ml_key']?>.php';
</script>
<?php
	die;
} // POST結束

if(isset($layoutv3_struct_map_keyname['v3/sub_page_title'][0])){
	$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]] = array(
		'name' => t('會員註冊'),
		'sub_name' => 'join us',
	);
}

if(isset($layoutv3_struct_map_keyname['v3/breadcrumb'][0])){
	$data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]] = array(
		array('name' => 'HOME', 'url' => '/'),
		array('name' => t('會員註冊'), 'url' => 'guestregister_'.$this->data['ml_key'].'.php')
	);
}

// 後台Copy來的
$validation = G::getJqueryValidation($empty_orm_data['rules']);
$validation['captcha']['required'] = true;
$url = 'guestcheckemail.php';
// true就是未被註冊
// false就是己被註冊
$tmp = <<<XXX
{
	url: "$url",
	type: "POST",
	cache: false,
	data: {
		number: function() {
			return $("#login_account").val();
		}
	}
}
XXX;
$tmp = str_replace("\n", '', $tmp);
$tmp = str_replace("\t", '', $tmp);
$validation['login_account'] = array(
	'required' => true,
	'email' => true,
	'remote' => 'gggg',
);
$validation['name'] = array(
	'required' => true,
);
$validation['accept_privacy'] = array(
	'required' => true,
);
$validation['login_password'] = array(
	'required' => true,
);
$validation['login_password_confirm'] = array(
	'required' => true,
	'equalTo' => '#login_password',
);
$validation['terms']['required'] = true;

//$validation['old_time_3']['selectcheck'] = true;
//$validation['service[]']['roles'] = true;
//$validation['GGGAAA']['selects'] = true;

$this->data['jqueryvalidation'] = json_encode($validation);
$this->data['jqueryvalidation'] = str_replace('"gggg"', $tmp, $this->data['jqueryvalidation']);
$this->data['updatecontent_jqueryvalidation'] = $validation;
