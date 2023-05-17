<?php

// 擴充
if(isset($this->data['def']['updatefield']['sections']) and count($this->data['def']['updatefield']['sections']) > 0){
	foreach($this->data['def']['updatefield']['sections'] as $kg => $vg){
		if(isset($vg['field']) and count($vg['field']) > 0){
			foreach($vg['field'] as $kkg => $vvg){
				if(!isset($vvg['type']) or $vvg['type'] == '') continue;

				unset($this->data['vv_type_kk']);
				unset($this->data['vv_type_vv']);
				unset($this->data['vv_type_formattr']);
				unset($this->data['vv_type_select']);

				$this->data['vv_type_kk'] = $kkg;
				$this->data['vv_type_vv'] = $vvg;

				// echo __METHOD__;die; // Coremodule3::update_show_first
				//$this->data['vv_type_select'] = 'update_show_first';
				$tmps = explode('::', __METHOD__);
				$this->data['vv_type_select'] = $tmps[1];

				// 例如 source - update_show_first_disable => true
				if(isset($vvg['source'][$tmps[1].'_disable']) and $vvg['source'][$tmps[1].'_disable'] === true){
					continue;
				}


				$path = 'system.themes.admin_yiiv_3.views.default.updatefields';
				$path_file = Yii::getPathOfAlias($path).'/'.$vvg['type'].'.php';
				if(file_exists($path_file)){
					include $path_file;
				}

				unset($this->data['vv_type_kk']);
				unset($this->data['vv_type_vv']);
				unset($this->data['vv_type_formattr']);
				unset($this->data['vv_type_select']);
			}
		}
	}
	unset($this->data['vv_type_kk']);
	unset($this->data['vv_type_vv']);
	unset($this->data['vv_type_formattr']);
	unset($this->data['vv_type_select']);
}
