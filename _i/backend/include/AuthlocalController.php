<?php

// 程式設計師開發專用
class AuthlocalController extends Controller {

	// 本地端後台自動登入
	public function actionIndex($current_base64_url = '')
	{
		//if(empty($_POST)){
		//	Yii::app()->session->destroy();
		//	// //redirect(base_url().'/login');
		//	// $url = $this->data['class_url'];
		//	// if($current_base64_url != ''){
		//	// 	$url .= '/index/_empty/'.$current_base64_url;
		//	// }
		//	//redirect('/');
		//	if($current_base64_url != ''){
		//		$url = base64url::decode($current_base64_url);
		//		$this->redirect($url);
		//	}
		//	$this->redirect($this->createUrl('auth/login'));
		//}

		//if($this->actionCheck('1') == '1'){
		//	$userdata = array(
		//		'auth_admin_id'    => 1,
		//		'auth_admin_name'  => 'gisanfu',
		//		'auth_ml_key'      => 'tw',
		//		'auth_admin_is_hidden' => 1,
		//	);
		//	$this->session->set_userdata($userdata);

		//	if($this->input->post('current_base64_url', true) != ''){
		//		$this->load->library('base64url');

		//		$url = $this->base64url->decode($this->input->post('current_base64_url', true));
		//		redirect($url);
		//	} else {
		//		redirect(base_url().'currenttemplate');
		//	}
		//}
	}

	public function actionCheck($return = '', $ip_tmp = '')
	{
		if($ip_tmp == ''){
			$string = 'ip';
			$is_return = '1';

			$lf = new Load_other_file;
			$ip = $lf->load($string, '', $is_return);
			// 192.168.1.*，星就是我的IP
			//echo $ip;
			//die;
		} else {
			$ip = $ip_tmp;
		}
		//if($ip == '127.0.0.1'){
		if(preg_match('/(127\.0\.0\.1|192\.168\.0\.128|192\.168\.0\.126|192\.168\.0\.40)/', $ip)){
			if($return == '1'){
				return '1';
			} else {
				echo '1';
				die;
			}
		}
	}
}
