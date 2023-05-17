<?php

class GooglereportController extends Controller {

	protected $def = array();

	protected function beforeAction($action)
	{
		parent::beforeAction($action);
		
		//header('Location: https://accounts.google.com/ServiceLogin?service=analytics&passive=true&nui=1&hl=zh_TW&continue=https://www.google.com/analytics/settings/&followup=https://www.google.com/analytics/settings/');
		header('Location: https://analytics.google.com/analytics/web/?hl=zh-TW');
		die;

		return true;
	}

}
