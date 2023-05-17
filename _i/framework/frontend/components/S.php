<?php

/*
 * S，代表Search，不過不一定搜尋的東西放在這裡，什麼都可以放
 */
class S
{

	public static function img($pic)
	{
		return '_i/'.$pic;
	}

	// 產生搜尋的網址
	// search.html?q=台北萬華學生搬家
	public static function search($params = array())
	{
		$area1 = false;
		$area2 = false;
		$service = false;
		$keyword = false;

		//var_dump($params);

		if(isset($params['area1']) and $params['area1'] != ''){
			$area1 = $params['area1'];
		}

		if(isset($params['area2']) and $params['area2'] != ''){
			$area2 = $params['area2'];
		}

		if(isset($params['service']) and $params['service'] != ''){
			$service = $params['service'];
		}

		if(isset($params['keyword']) and $params['keyword'] != ''){
			$keyword = $params['keyword'];
		}

		if($area1 == 'none'){
			$area1 = '';
		}

		if($area2 == 'none'){
			$area2 = '';
		}

		if($service == 'none'){
			$service = '';
		}

		if($keyword == 'none'){
			$keyword = '';
		}

		if($area2 == '全區'){
			$area2 = '';
		}


		// 把縣市拿掉, 但是有個案
		if($area1 != '' and !preg_match('/^新竹縣|嘉義縣$/', $area1)){
			$area1 = mb_substr($area1, 0, mb_strlen($area1, "UTF-8")-1, "UTF-8");
		}

		// 把鄉鎮市區拿掉，但是有個案
		if($area2 != '' and mb_strlen($area2, "UTF-8") > 2){
			$area2_tmp = $area2;
			// 如果去掉最後那個字，而且跟area1一模一樣，那就把area1清空
			$area2 = mb_substr($area2, 0, mb_strlen($area2, "UTF-8")-1, "UTF-8");

			// 桃園桃圓市
			if(strcmp($area2, $area1) == 0){
				$area1 = '';
				$area2 = $area2_tmp;
			}
		}

		$result = '';
		$result .= $area1;
		$result .= $area2;
		$result .= $service;
		$result .= $keyword;

		if(isset($params['area1_handle']) and $params['area1_handle'] == true){
			return $area1;
		}

		if(isset($params['area2_handle']) and $params['area2_handle'] == true){
			return $area2;
		}

		//return 'search.html?q='.$result;
		return 'search_'.$result.'.html';
	}
}
