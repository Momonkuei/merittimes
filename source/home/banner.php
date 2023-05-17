<?php

if(
	preg_match('/^index/', basename($_SERVER['REQUEST_URI'],'.php')) 
	or basename($_SERVER['REQUEST_URI'],'.php') == ''
	// or basename($_SERVER['REQUEST_URI'],'.php') == 'tw' // SEO在使用的，例http://xxx/tw/ 2017-05-02-by-jerry
){
	$tmp = 'banner';
} else {
	$tmp = 'bannersub';
}
$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$tmp,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

//      //2017/9/1 加入可在後台自訂各主選單頁面的banner by Lota 
//      $router_method_lll = str_replace('_'.$this->data['ml_key'],'',$this->data['router_method']);
//      // 新版編排頁網址，這裡只是跳脫掉company_XXX上的(_XXX)，為了讓後續處理沒問題而以
//      for($i=1;$i<6;$i++){
//      	$router_method_lll = str_replace('_'.$i,'',$router_method_lll);
//      }

// 2018-08-15 oia網站有26頁編排頁
$tmpsg = explode('_',$this->data['router_method']);
$router_method_lll = $tmpsg[0];

// 把三種情況先分門別類放好，第三種情況的優先權最高，這三種情況，依據優先權分別是…
// 3:有指定功能名稱和編號, 2:只有指定功能名稱, 1:通用(都沒有指定)
$tmps_1 = $tmps_2 = $tmps_3 = array();
foreach ($tmps as $key => $value) {
	if($value['other1'] == ''){
		$tmps_1[] = $value;		
	}else{
		if($value['other1'] == $router_method_lll){
			//2017/12/13 加入指定編號顯示內頁banner(需配合選單代號) by lota
			if($value['other2'] == ''){
				$tmps_2[] = $value;
			}
			if($value['other2'] != '' && isset($_GET['id']) && $_GET['id'] == $value['other2'] ){
				$tmps_3[] = $value;	
			}
		}
	}
}

if($tmps_3 and count($tmps_3) > 0){
	$tmps = $tmps_3;
}else if($tmps_2 and count($tmps_2) > 0){
	$tmps = $tmps_2;
}else{
	$tmps = $tmps_1;
}


//$tmps_lll =  $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:router_method',array(':type'=>$tmp,':ml_key'=>$this->data['ml_key'],':router_method'=>$this->data['router_method']))->order('sort_id')->queryAll();


if($tmps and count($tmps) > 0){
	foreach($tmps as $k => $v){
		$tmps[$k]['topic'] = $v['topic'];
		$tmps[$k]['describe'] = $v['detail'];
		$tmps[$k]['url'] = $v['url1'];

		// 套程式
		if(preg_match('/^images\//', $v['pic1'])){
			// 這是為了開環境的程式所寫的
			$tmps[$k]['pic'] = $v['pic1'];
		} else {
			$tmps[$k]['pic'] = '_i/assets/upload/'.$tmp.'/'.$v['pic1'];
		}

		if(!isset($v['pic2']) or $v['pic2'] == ''){
			$tmps[$k]['pic2'] = $tmps[$k]['pic'];
		} else {
			if(preg_match('/^images\//', $v['pic2'])){
				// 這是為了開環境的程式所寫的，因為欄位名稱剛好相同，所以這行註解掉
				// \$tmps[\$k]['pic2'] = \$v['pic2'];
			} else {
				$tmps[$k]['pic2'] = '_i/assets/upload/'.$tmp.'/'.$v['pic2'];
			}
		}


	}
}

// 2017-10-19 李哥說，這是購物站常見的功能，建議併到母版，但是先註解，不打開
// 每個分類，都有不同的內頁Banner圖
if(0 and $tmp == 'bannersub' and isset($_GET['id']) and $_GET['id'] > 0){

	if($this->data['router_method'] == 'product'){
		$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get($this->data['router_method'].'type')->row_array();
		if($row and isset($row['id']) and $row['id'] > 0 and $row['pic3'] != '' and $row['pic4'] != ''){
			$tmps = array(
				array(
					'topic' => '',
					'describe' => '',
					'url' => 'javascript:;',
					'pic' => '_i/assets/upload/'.$this->data['router_method'].'type/'.$row['pic3'],
					'pic2' => '_i/assets/upload/'.$this->data['router_method'].'type/'.$row['pic4'],
				),
			);
		}
	}

}

$data[$ID] = $tmps;
