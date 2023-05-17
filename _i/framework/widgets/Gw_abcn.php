<?php

class Gw_abcn extends CWidget
{
	public $list = array();
	public $v;

	//public function init() {
	//	ob_start();
	//}

	public function run()
	{
		// 要包起來要需要啟用這行，還有上面的init()
		//$out = ob_get_clean();

		$data = $this->getController()->data;

		//$this->e = G::t($data['theme_lang'], 'Enable', null, '啟用');

		if(count($this->list) > 0){
			foreach($this->list as $kk => $vv){
				if($v == $kk){
					return $vv;
				}
			}
		}
	} 
}
