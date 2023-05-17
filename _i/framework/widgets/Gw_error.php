<?php

class Gw_error extends CWidget
{
	public $message = '';
	public $heading = 'Error';
	public $errorcode = 500;

	//public function init() {
	//	ob_start();
	//}

	public function run()
	{
		// 要包起來要需要啟用這行，還有上面的init()
		//$content = ob_get_clean();

		$data = $this->getController()->data;

		$main_content = 'error/error_general';

		$data['message'] = $this->message;
		$data['heading'] = $this->heading;
		$data['errorcode'] = $this->errorcode;

		$this->render($main_content, $data);
	}
}
