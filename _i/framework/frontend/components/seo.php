<?php

//if(isset($this->cidb)){
//	$db = $this->cidb;
//} else {
//	// createUrl的那一層，己經有define了
//	$db = Yii::app()->params['cidb'];
//}

$ml_key = '';

if(isset($this->data)){
	$ml_key = $this->data['ml_key'];
} else {

	/*
	 * 這是從前台的核心檔案copy來的，記得要跟進那邊的修改
	 */

	// 設定語系與抓取語系
	//$ml_key = Yii::app()->session['interface_ml_key'];
	//$ml_key = '';
	$ml_key = domain_ml_key;

	/*
	 * 介面語系的優先權處理過程
	 */

	// 如果是空白，就取用使用者所選擇的語系
	if($ml_key == '' and isset(Yii::app()->session['web_ml_key']) and Yii::app()->session['web_ml_key'] != ''){
		$ml_key = Yii::app()->session['web_ml_key'];
	}

	// 如果還是空白，就取用系統的語系預設值
	if($ml_key == ''){
		$ml_key = Yii::app()->language;
	} else {
		Yii::app()->language = $ml_key;
	}

	// 我就跟你說吧，最終預設語系是繁體(kid)
	if($ml_key == ''){
		$ml_key = 'tw';
	}

	//Yii::app()->session['web_ml_key'] = $ml_key;
	//$this->data['ml_key'] = $ml_key;
}


// 這裡的資料庫變數：$db

/*
 * 為了讓這個檔案可以客製，也可以放子站、也可以放母體
 */

//$row = $this->db->createCommand()->from('sys_config')->where('keyname=:name',array(':name'=>'has_seo_'.Yii::app()->session['web_ml_key']))->queryRow();
$row = $db->where('keyname','has_seo_'.$ml_key)->get('sys_config')->row_array();
if($row and isset($row['keyname']) and $row['keyval'] == '1'){

	// 第一層的檢查，別忘了子站根目錄也要放相對應的檔案才會啟用seo的功能
	// index.php?r=site/aaa	
	if(preg_match('/^site\/(.*)$/', $route, $matches) and (!$params or count($params) <= 0)){
		if(file_exists(_BASEPATH.'/../'.$matches[1].'.php')){
			$url = '/'.$matches[1].'.html';
			return $url;
		}
	}

	/*
	 * 請用cidb的方式來存取資料庫！
	 */

	if($route == 'site/news' and count($params) == 1){

		$row = $db->where('is_enable',1)->where('type','newstype')->where('ml_key',$ml_key)->where('id',$params['id'])->get('html')->row_array();
		$row_seo = $db->where('seo_type','newstype')->where('seo_ml_key',$ml_key)->where('seo_item_id',$row['id'])->get('seo')->row_array();

		if(isset($row_seo['id'])){
			$url = $row_seo['seo_script_name'].'.html';
		} else {
			$url = $row['topic'].'.html';
		}

		// 2017-03-27
		// #22157
		if(isset($params['page'])){
			$url .= '?page=';
		}

		return $url;
	}

	if($route == 'site/newsdetail' and count($params) == 2){
		//$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id', array(':id'=>$params['id'],':type'=>'newstype',':ml_key'=>$this->data['ml_key']))->queryRow();
		$row2 = $db->where('is_enable',1)->where('type','newstype')->where('ml_key',$ml_key)->where('id',$params['id'])->get('html')->row_array();
		$row2_seo = $db->where('seo_type','newstype')->where('seo_ml_key',$ml_key)->where('seo_item_id',$row2['id'])->get('seo')->row_array();

		$url1 = '';

		if(isset($row2_seo['id'])){
			$url1 = $row2_seo['seo_script_name'];
		} else {
			$url1 = $row2['topic'];
		}

		//$row = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id', array(':id'=>$params['id2'],':type'=>'news',':ml_key'=>$this->data['ml_key']))->queryRow();
		$row = $db->where('is_enable',1)->where('type','news')->where('ml_key',$ml_key)->where('id',$params['id2'])->get('html')->row_array();
		$row_seo = $db->where('seo_type','news')->where('seo_ml_key',$ml_key)->where('seo_item_id',$row['id'])->get('seo')->row_array();

		if(isset($row_seo['id'])){
			$url2 = $row_seo['seo_script_name'];
		} else {
			$url2 = $row['topic'];
		}

		$url = $url1.'/'.$url2.'.html';
		return $url;
	}
}

