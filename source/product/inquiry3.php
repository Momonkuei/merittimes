<?php

$items = array(); // 洽詢的東西，裡面是存放session save的東西

// 2018-07-19 如果A方案，要使用V1第二版的Datasource方式掛載，請用LayoutV3，將這個掛載放到head_start去運行
if(isset($_SESSION['save'][$this->data['router_method']]) && !empty($_SESSION['save'][$this->data['router_method']]) ){ //加入判斷SESSION有無資料 by lota 2018/12/7
	$items = $_SESSION['save'][$this->data['router_method']];
}

// 2019-10-25
if(!empty($items)){
	foreach($items as $k => $v){
		if(isset($v['ml_key']) and $v['ml_key'] != '' and $v['ml_key'] != $this->data['ml_key']){
			unset($items[$k]);
		}
	}
}

if(empty($items)){
	// 沒有詢問物件的話就轉跳到有詢問的地方 by lota 2018/6/13
	if(1){
		$redirect_url = str_replace('inquiry','',$this->data['router_method']).$url_suffix;		
		G::alert_and_redirect(t('無詢問物件，請先加入詢問'), $redirect_url, $this->data);
	} else { // A方案
?>
<script type="text/javascript" m="body_end">
	$(document).ready(function() {
		alert('<?php echo t('無詢問物件，請先加入詢問','tw')?>');
		window.location.href='index_<?php echo $this->data['ml_key']?>.php';
	});
</script>	
<?php
	}
}

include _BASEPATH.'/../source/system/inquiry.php';

$data[$ID] = $items;
