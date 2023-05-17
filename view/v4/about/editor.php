<?php //#43828

	// $_fb_description = '';
	// if(isset($data[$ID]['detail_top']) and trim(strip_tags($data[$ID]['detail_top'])) != ''){
	// 	$detail = trim($data[$ID]['detail_top']);
	// 	$detail = str_replace("\t",'',$detail);
	// 	$detail = str_replace("\r\n",'',$detail);
	// 	$detail = str_replace("\n",'',$detail);
	// 	$detail = strip_tags($detail);
	// 	$detail = mb_substr($detail, 0, 80, 'UTF-8');
	// 	$detail = trim($detail);
	// 	$_fb_description = $detail;
	// }
	/******#46369 增加社群分享設定********************************************************start */
	$og_data='';
	$universal_data='';
	// 後台/最大/常數/開啟購物功能 要打開，才會執行裡面的東西

	$og_data_array=$this->cidb->where('type','bannersub')->where('is_enable','1')->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('html')->result_array();
	
	//抓當前單元名稱
	$page_type=explode('_',$this->data['router_method']);
	$page_type=$page_type[0];
	if(!empty($og_data_array)){
		foreach($og_data_array as $k => $v){
			if(stristr($v['other1'],$page_type)){
				$og_data=$v;
			}else if(empty($v['other1'] && empty($v['other2']) && empty($v['other3']) && empty($universal_data))){
				//通用資料
				$universal_data=$v;
			}
		}
	}
	
	//後台未設定社群分享單元  皆用通用資料
	if(empty($og_data)){
		$og_data=$universal_data;
	}
	// print_r($og_data);die;
	if(!empty($og_data)){
		if(is_file(dirname(dirname(__FILE__)).'/_i/assets/upload/bannersub/'.$og_data['pic3'])){
			//社群圖
			$pic=FRONTEND_DOMAIN.'/_i/assets/upload/bannersub/'.$og_data['pic3'];
		}else if(is_file(dirname(dirname(__FILE__)).'/_i/assets/upload/bannersub/'.$og_data['pic1'])){
			//社群圖未上 抓大圖
			$pic=FRONTEND_DOMAIN.'/_i/assets/upload/bannersub/'.$og_data['pic1'];
		}else if(is_file(dirname(dirname(__FILE__)).'/_i/assets/upload/bannersub/'.$og_data['pic2'])){
			//社群圖+大圖未上 抓小圖
			$pic=FRONTEND_DOMAIN.'/_i/assets/upload/bannersub/'.$og_data['pic2'];
		}else{
			//三種皆未上 抓預設圖
			$pic=FRONTEND_DOMAIN.'/images/fb_share.jpg';
		}
	}else{
		$pic=FRONTEND_DOMAIN.'/images/fb_share.jpg';
	}

	if(!empty($og_data['other30'])){
		//抓標題
		if(!empty($this->data['_breadcrumb'])){
			$topic=end($this->data['_breadcrumb']);	
			$topic=$topic['topic'];
		}else{
			$topic=$this->data['func_name'].' | '.$data['head_title'];
		}
	}else{
		if(!empty($this->data['_breadcrumb'])){
			$topic=end($this->data['_breadcrumb']);	
			$topic=$topic['topic'];
		}else{
			if(isset($data['head_title'])){
				$topic=$data['head_title'];
			}else{
				$topic='';
			}
		}
	}
	/******#46369 增加社群分享設定********************************************************end */
?>
<?/*
<meta property="og:url"           content="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" m="head_end" />
<meta property="og:type"          content="website"  m="head_end" />
<meta property="og:title"         content="<?php echo $data[$ID]['name']?>"  m="head_end" />
<meta property="og:description"   content="<?php echo $_fb_description?>"  m="head_end"  />
<?php if(isset($data[$ID]['pic1']) and $data[$ID]['pic1'] != ''):?>
	<?php if(is_file(dirname(dirname(__FILE__)).'/_i/assets/thumb/abouttype/200x200_'.$data[$ID]['pic1'])):?>
		<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN.'/_i/assets/thumb/abouttype/200x200_'.$data[$ID]['pic1']?>"  m="head_end"  />
	<?php else:?>
		<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN.'/_i/assets/upload/abouttype/'.$data[$ID]['pic1']?>"  m="head_end"  />
	<?php endif?>
<?php else:?>
	<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN?>/images/fb_share.jpg" m="head_end" />
<?php endif?>
*/?>
<meta property="og:url"           content="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" m="head_end" />
<meta property="og:type"          content="website"  m="head_end" />
<meta property="og:title"         content="<?=$topic?>"  m="head_end" />
<meta property="og:description"   content="<?=(!empty($og_data['other30'])?$og_data['other30']:'')?>"  m="head_end"  />
<meta property="og:image"         content="<?=$pic?>" m="head_end" />
<?php //var_dump($data[$ID])?>
<?php if(0)://#38046?>
<div class="blockTitle">
	<span><?php echo $data[$ID]['name']?></span>
</div>
<?php endif?>

<div class="editor ">
<?php if(isset($data[$ID]['detail'])):?>
	<?php echo $data[$ID]['detail']?>
<?php endif?>
</div>
