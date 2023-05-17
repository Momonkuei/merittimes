<?php

class Web_checklogin extends CWidget
{
	//public $class = '';
	//public $method = 'index';

	public function run()
	{
		//$data = $this->getController()->data;

		$return = '0';

		if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] != ''){
			$return = '1';
			echo $return;
		}
		echo $return;
		//die;
	}
}
