<?php

class SiteController extends Controller
{
	protected $def;

	/**
	 * Declares class-based actions.
	 */
	//public function actions()
	//{
	//	return array(
	//		// captcha action renders the CAPTCHA image displayed on the contact page
	//		'captcha'=>array(
	//			'class'=>'CCaptchaAction',
	//			'backColor'=>0xFFFFFF,
	//		),
	//		// page action renders "static" pages stored under 'protected/views/site/pages'
	//		// They can be accessed via: index.php?r=site/page&view=FileName
	//		'page'=>array(
	//			'class'=>'CViewAction',
	//		),
	//	);
	//}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest){
				echo $error['message'];
			} else {
				//echo $error;
				//var_dump($error);
				//die;
				$this->data['error'] = $error;
				$this->data['main_content'] = 'site/error'.$error['code'];
				if($this->main_content_exists($this->data['main_content'], $this->data) === true){
					$this->display('index.htm', $this->data);
				} else {
					$this->render('error', $error);
				}
			}
		}
	}

	// 當使用者連到backend.php的網址的時候，就會連到這裡，我將它導向到auth/main的網站，統一由那邊決定
	public function actionIndex($param = '')
	{
		$this->redirect($this->createUrl('auth/main'));
	}

	//public function actionIndex()
	//{
	//	$this->breadcrumbs = array(
	//		'網站設定',
	//	);
	//	if(empty($_POST)){
	//		$this->render('index', array('detail'=>$this->data['sys_configs']));
	//	} else {
	//		//var_dump($_POST);
	//		//die;
	//		$save = $_POST;
	//		unset($save['send']);

	//		// 看一下有沒有存在，有，而且數值不一樣，就update，沒有就insert
	//		if(count($save) > 0){
	//			$db = Yii::app()->db;
	//			foreach($save as $k => $v){
	//				if(isset($this->data['sys_configs'][$k]) and $v != $this->data['sys_configs'][$k]){
	//					// update
	//					$sql="UPDATE sys_config SET keyval = :value WHERE keyname = :key";
	//					$command=$db->createCommand($sql);
	//					$command->bindParam(":key",$k,PDO::PARAM_STR);
	//					$command->bindParam(":value",$v,PDO::PARAM_STR);
	//					$command->execute();
	//				} elseif(!isset($this->data['sys_configs'][$k]) and $v != ''){
	//					$sql="INSERT INTO sys_config (keyname, keyval) VALUES(:key,:value)";
	//					$command=$db->createCommand($sql);
	//					// PDO::PARAM_STR
	//					// PDO::PARAM_INT
	//					$command->bindParam(":key",$k,PDO::PARAM_STR);
	//					$command->bindParam(":value",$v,PDO::PARAM_STR);
	//					$command->execute();
	//				}
	//			}
	//		}
	//		$this->redirect($this->createUrl('site/index'));
	//	}
	//}

}
