<?php

// if(
// 	preg_match('/^index/', basename($_SERVER['REQUEST_URI'],'.php')) 
// 	or basename($_SERVER['REQUEST_URI'],'.php') == ''
// 	// or basename($_SERVER['REQUEST_URI'],'.php') == 'tw' // SEO在使用的，例http://xxx/tw/ 2017-05-02-by-jerry
// ){

/*
 * 2018-09-13
 * A方案，如果要用layoutv3 / datasource / _banner
 * 要記得沒有預設圖片的功能
 */

// unset($_constant);
// eval('$_constant = '.strtoupper('shop_open').';');
// if($_constant){

// 2020-06-18 購物站要加上廣告管理的功能(李哥說的)
$o = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key']);

if($this->data['router_method'] == 'index'){
	//$tmp = 'banner';
	//$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$tmp,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

	unset($_constant);
	eval('$_constant = '.strtoupper('shop_open').';');
	if($_constant){
		$tmp = 'shopbanner';
		$o->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00")');
	} else {
		$tmp = 'banner';
	}
	$o = $o->where('type',$tmp);
	$tmps = $o->order_by('sort_id')->get('html')->result_array();
} else {
	//$tmp = 'bannersub';
	//$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1="" and other2=""',array(':type'=>$tmp,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
	//$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$tmp,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

	unset($_constant);
	eval('$_constant = '.strtoupper('shop_open').';');
	if($_constant){
		$tmp = 'shopbannersub';
		$o->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00")');
	} else {
		$tmp = 'bannersub';
	}
	$o = $o->where('type',$tmp);
	$tmps = $o->order_by('sort_id')->get('html')->result_array();

	//2017/9/1 加入可在後台自訂各主選單頁面的banner by Lota 
	$ggg = $router_method_lll = str_replace('_'.$this->data['ml_key'],'',$this->data['router_method']);
	// 新版編排頁網址，這裡只是跳脫掉company_XXX上的(_XXX)，為了讓後續處理沒問題而以
	for($i=1;$i<99;$i++){
		$router_method_lll = str_replace('_'.$i,'',$router_method_lll);
	}

	//如果是編排頁，則抓取編排頁的編號
	$router_method_num = str_replace($router_method_lll.'_','',$ggg);

	// 把三種情況先分門別類放好，第三種情況的優先權最高，這三種情況，依據優先權分別是…
	// 3:有指定功能名稱和編號, 2:只有指定功能名稱, 1:通用(都沒有指定)
	// 2018-9-11 增加可指定編排頁編號更換內頁大圖 ，編排頁編號不能跟資料編號混合使用 by lota
	$tmps_1 = $tmps_2 = $tmps_3 = array();
	foreach ($tmps as $key => $value) {
		if($value['other1'] == ''){
			$tmps_1[] = $value;		
		}else{
			if($value['other1'] == $router_method_lll){
				//2017/12/13 加入指定編號顯示內頁banner(需配合選單代號) by lota
				//2021-06-08 新增判斷沒有指定靜態頁編號的話，才是功能全體繼承 by lota
				if($value['other2'] == '' && $value['other3'] == ''){
					$tmps_2[] = $value;
				}
				if(is_numeric($router_method_num)){
					if($value['other3'] != '' && $router_method_num == $value['other3'] ){
						$tmps_3[] = $value;	
					}
				}else if($value['other2'] != '' && isset($_GET['id']) && $_GET['id'] == $value['other2'] ){
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
}

if($tmps and count($tmps) > 0){
	foreach($tmps as $k => $v){
		$v['describe'] = $v['detail'];
		$v['url'] = $v['url1'];

		if(0){ //SEO
			$alt = '';
			if($k == 0){
				$alt = '台北防水工程';
			} elseif($k == 1){
				$alt = '台北防水抓漏';
			}
			$v['topic'] = $alt;
		}

		// 套程式
		if(preg_match('/^images\//', $v['pic1'])){
			// 這是為了開環境的程式所寫的
			$v['pic1g'] = $v['pic1'];
		} else {
			$v['pic1g'] = '_i/assets/upload/'.$tmp.'/'.$v['pic1'];
		}

		if(!isset($v['pic2']) or $v['pic2'] == ''){
			$v['pic2g'] = $v['pic1g'];
		} else {
			if(preg_match('/^images\//', $v['pic2'])){
				$v['pic2g'] = $v['pic2'];
			} else {
				$v['pic2g'] = '_i/assets/upload/'.$tmp.'/'.$v['pic2'];
			}
		}
		$tmps[$k] = $v;
		//#43829 
		if($v['field_data']!=''){
			$data['pagebanner_field_data'] = $v['field_data'];
		}else{
			#46680  內頁大圖 在欄位未輸入情況下 出現標題 
			$topic_name='';
			if(stristr($this->data['router_method'],'detail')){
				$is_detail=true;
				$type_name=str_replace('detail','',$this->data['router_method']);
			}else{
				$is_detail=false;
				$type_name=$this->data['router_method'];
			}
			// echo $this->data['router_method'].'<hr>';
			//判斷頁面
			$is_edit=count(explode('_',$this->data['router_method']));
			if($is_edit==1){
				//非編輯頁
				foreach($this->data['webmenu_top_1692'] as $k => $v){
					if(stristr($v['url'],$type_name) && !empty($this->data['_breadcrumb'])){
						//判斷 總覽頁 or 列表頁+內頁
						if(isset($_GET['id'])){	
							//列表頁+內頁
							if($is_detail){
								//內頁	
								$num=count($this->data['_breadcrumb'])-1;	
							}else{
								//列表頁	
								$num=count($this->data['_breadcrumb'])-1;	
							}		
							// print_r($this->data['_breadcrumb']);
							$topic_name=$this->data['_breadcrumb'][$num]['name'];												
						}else{
							//總覽頁
							$topic_name=$v['topic'];
						}
					}
				}
			}else if($is_edit>=2 && !empty($this->data['_breadcrumb'])){
				//編輯頁
				$num=count($this->data['_breadcrumb'])-2;
				$topic_name=$this->data['_breadcrumb'][$num]['name'];				
				// print_r($this->data['_breadcrumb'][$num]);die;
			}
			if(!empty($topic_name)){
				$data['pagebanner_field_data']='
					<div class="banner_content">	
						<p class="banner_txt_two  v4_animate fadeUp delay_04">'.$topic_name.'</p>
					</div>';
			}
		}
	}
}





// 2017-10-19 李哥說，這是購物站常見的功能，建議併到母版，但是先註解，不打開 , 開啟後 記得要在資料表增加 pic3及pic4 以及後台產品分類要開相對應功能
// 每個分類，都有不同的內頁Banner圖
// 2020-11-27 購物產品 shopbannersub； 因為product 跟 shop 是分開的，所以改常駐開啟 by lota
// 2021-07-14 購物產品詳細頁要帶入對應cid的banner by lota
if(1 and $tmp == 'shopbannersub' and isset($_GET['id']) and $_GET['id'] > 0){

	if($this->data['router_method'] == 'shop' or $this->data['router_method'] == 'shopdetail'){
		if($this->data['router_method'] =='shopdetail' && isset($_GET['cid'])){
			$_id = $_GET['cid'];
		}else{
			$_id = $_GET['id'];
		}

		$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_id)->get(str_replace('detail', '', $this->data['router_method']).'type')->row_array();
		if($row and isset($row['id']) and $row['id'] > 0){
			if($row['pic3'] != '' and $row['pic4'] != ''){
				$tmps = array(
					array(
						'topic' => '',
						'describe' => '',
						'url' => 'javascript:;',
						'pic1g' => '_i/assets/upload/'.str_replace('detail', '', $this->data['router_method']).'type/'.$row['pic3'],
						'pic2g' => '_i/assets/upload/'.str_replace('detail', '', $this->data['router_method']).'type/'.$row['pic4'],
					),
				);
			// 2018-12-19 #30128 如果該層的該分類，沒有上圖，那就用最頂層的圖
			} elseif($row['pid'] != 0 and isset($this->data['_breadcrumb'])){ // 
				if(isset($this->data['_breadcrumb'][2]['id'])){
					$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$this->data['_breadcrumb'][2]['id'])->get(str_replace('detail', '', $this->data['router_method']).'type')->row_array();
					if($row and isset($row['id']) and $row['id'] > 0 and $row['pic3'] != '' and $row['pic4'] != ''){
						$tmps = array(
							array(
								'topic' => '',
								'describe' => '',
								'url' => 'javascript:;',
								'pic1g' => '_i/assets/upload/'.str_replace('detail', '', $this->data['router_method']).'type/'.$row['pic3'],
								'pic2g' => '_i/assets/upload/'.str_replace('detail', '', $this->data['router_method']).'type/'.$row['pic4'],
							),
						);
					}
				}					
			}
		}
	}

}

// 客製 產品內頁套用上層產品分類圖片(兩層) by lota
if(0 and $this->data['router_method']=='productdetail' && isset($_GET['id'])){
	$_id = intval($_GET['id']);
	$_router_method = str_replace('detail','',$this->data['router_method']);
	$_gg = $this->db->createCommand()->from($_router_method)->where('is_enable=1 and ml_key=:ml_key and id='.$_id,array(':ml_key'=>$this->data['ml_key']))->queryRow();
	if($_gg['class_id'] > 0){
		$_ggg = $this->db->createCommand()->from($_router_method.'type')->where('is_enable=1 and ml_key=:ml_key and id='.$_gg['class_id'],array(':ml_key'=>$this->data['ml_key']))->queryRow();
		if($_ggg['pic3']=='' && $_ggg['pic4']=='' ){
			$_gggg = $this->db->createCommand()->from($_router_method.'type')->where('is_enable=1 and ml_key=:ml_key and id='.$_ggg['pid'],array(':ml_key'=>$this->data['ml_key']))->queryRow();
			if($_gggg['pic3']!='' or $_gggg['pic4']!='' ){
				$tmps = array(
					array(
						'topic' => '',
						'describe' => '',
						'url' => 'javascript:;',
						'pic1g' => '_i/assets/upload/'.$_router_method.'type/'.$_gggg['pic3'],
						'pic2g' => '_i/assets/upload/'.$_router_method.'type/'.$_gggg['pic4'],
					),
				);			
			}
		}else{
			$tmps = array(
				array(
					'topic' => '',
					'describe' => '',
					'url' => 'javascript:;',
					'pic1g' => '_i/assets/upload/'.$_router_method.'type/'.$_ggg['pic3'],
					'pic2g' => '_i/assets/upload/'.$_router_method.'type/'.$_ggg['pic4'],
				),
			);	
		}
	}
}

$data[$ID] = $tmps;
