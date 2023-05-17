<?php

class Gw_ez extends CWidget
{
	public $e = null;
	public $z = null;
	public $v;

	//public function init() {
	//	ob_start();
	//}

	public function run()
	{
		// 要包起來要需要啟用這行，還有上面的init()
		//$out = ob_get_clean();

		$data = $this->getController()->data;

		if($this->e === null){
			$this->e = G::t($data['theme_lang'], 'Enable', null, '啟用');
		}

		if($this->z === null){
			$this->z = G::t($data['theme_lang'], 'Disable', null, '停用');
		}

		if($this->v == '1'){
			echo $this->e;
		} else {
			echo $this->z;
		}
	} 
}

/*
function smarty_block_ez($params, $content, &$smarty)
{
    $vars = $smarty->_tpl_vars;

    if(!isset($params['e'])) $params['e'] = 'ml:Enable';
    if(!isset($params['z'])) $params['z'] = 'ml:Disable';

    $e = $params['e'];
    $z = $params['z'];
    
    //$e = multi_language_output($e, $vars['ml_key'], $vars['langs'], $vars['router_class']);
    //$z = multi_language_output($z, $vars['ml_key'], $vars['langs'], $vars['router_class']);

    $e = multi_language_output($e, 'tw', $vars['router_class']);
    $z = multi_language_output($z, 'tw', $vars['router_class']);

    if($content == '1'){
        return $e;
    } else {
        return $z;
    }
}
 */
