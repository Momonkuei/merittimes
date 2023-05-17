<?php

/*
 * SEM
 */

class XXXXXXXX_A extends XXXXXXXX_B 
{

	public function url($url)
	{
		//return $url;

		/*
		 * url功能1：SEM
		 *
		 * 當啟動SEM功能的時候，網址就會全面變成靜態頁
		 */

		$row = $this->db->createCommand()->from('sys_config')->where('keyname=:name',array(':name'=>'has_seo_'.Yii::app()->session['web_ml_key']))->queryRow();
		if($row and isset($row['keyname']) and $row['keyval'] == '1'){

			$route = '';
			$params = array();

			if(preg_match('/^(.*)\.php\?/', $url, $matches)){
				$tmp = str_replace($matches[1].'.php?', '', $url);
				$tmps = explode('&', $tmp);
				foreach($tmps as $k => $v){
					// r=aaa&id=bbb&id2=ccc
					if(preg_match('/\=/', $v)){
						$tmp2s = explode('=', $v);
						$params[$tmp2s[0]] = $tmp2s[1];
					// r=aaa&del
					} else {
						// r=aaa&del=
						$params[$v] = '';
					}
				}
			}

			if(isset($params['r'])){
				$route = $params['r'];
				unset($params['r']);
			}

			if($route == ''){
				$route = 'site/index';
			}

			// 為了要跟createUrl那一層同步使用cidb，因為那時還沒有init yii db
			$db = $this->cidb;

			if(file_exists(Yii::getPathOfAlias('application.components.seo').'.php')){
				$file = Yii::getPathOfAlias('application.components.seo').'.php';
			} else {
				$file = Yii::getPathOfAlias('system.frontend.components.seo').'.php';
			}

			include $file;

		}
		//echo 'ggg'.$url;

		return $url;
	}

} // Layoutv2 Class end
