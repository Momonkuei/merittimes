<?php

class Gw_mls extends CWidget
{
	public $v;

	public function run()
	{  
		$data = $this->getController()->data;
		if(isset($data['mls'][$this->v])){
			$label = $data['mls'][$this->v];
			G::te($data['theme_lang'], $label);
		}
	}
}
