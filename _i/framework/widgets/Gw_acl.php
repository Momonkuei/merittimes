<?php

class Gw_acl extends CWidget
{
	public $class = '';
	public $method = 'index';

	public function init() {
		ob_start();
	}

	public function run()
	{
		// 要包起來要需要啟用這行，還有上面的init()
		$content = ob_get_clean();

		$data = $this->getController()->data;

		$class = $data['router_class'];
		if(isset($this->class) and $this->class != ''){
			$class = $this->class;
		}

		$acl = new Admin_acl();
		$acl->start();

		if($acl->hasAcl($data['admin_id'], $class, $this->method)){
			echo $content;
		}
	}
}
