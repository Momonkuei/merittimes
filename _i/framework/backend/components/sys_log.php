<?php

class sys_log {

	//protected $db;

	function __construct() {
		//$this->session = Yii::app()->session;
	}

	/*
	 * @code string 打算存放"$class/$action"
	 * @msg string 詳細的訊息
	 */
	public static function set($msg = '')
	{
		$sql = "insert into sys_log (`log_code`, `log_msg`, `user_id`, `ip_addr`, `create_time`) values (:log_code, :log_msg, :user_id, :ip_addr, :create_time)";
		$params = array(
			':log_code' => Yii::app()->session['sys_log_code'],
			':log_msg' => $msg,
			//':user_id' => Yii::app()->session['auth_admin_id'],
			':ip_addr' => $_SERVER['REMOTE_ADDR'],
			':create_time' => date("Y-m-d H:i:s"),
		);
		if(isset(Yii::app()->session['auth_admin_id']) and Yii::app()->session['auth_admin_id'] != null){
			$params[':user_id'] = Yii::app()->session['auth_admin_id'];
		} else {
			$params[':user_id'] = 0;
		}
		Yii::app()->db->createCommand($sql)->execute($params);
	}

}
