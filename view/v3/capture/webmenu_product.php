<?php

// 2018-09-13 這個檔案只是示範，目的是，可以客製電腦版的主選單的下拉，呈現不同的樣子
// "這裡不能用V1第二版"
//
// 語系的變數：$ml_key (只有這個變數可以用，因為它是從curl那邊傳來的)
//
// 使用這個功能的方式：
// source/menu/v2.php
// 搜尋capture字眼，大略在最下面，把那一段註解打開，填上menu_id，就可以使用了
//
// 或者是把下面這一段，複製到source/menu/v2.php的下面

/*
 * // 2018-09-13 試試看，加上一個可以處理不完全是ul li的結構的情況，幸康、常廣的案子有用到
 * if($position == 1){
 *		$menu_id = 1; // 從零開始的流水號
 * 
 *		$view = 'v3/capture/webmenu_product.php';
 *		$url = FRONTEND_DOMAIN.'/capture.php?ml_key='.$this->data['ml_key'].'&target='.$view;
 *		$ch = curl_init();
 *		curl_setopt($ch, CURLOPT_URL, $url);
 *		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 *		$output = curl_exec($ch);
 *		curl_close($ch);
 * 
 *		// echo $output;die;
 *		$tmp[$menu_id]['_replace_struct_0'] = $output;
 * }
 */

// 獨立分類範例
$rows = $this->cidb->where('is_enable',1)->where('ml_key',$ml_key)->where('pid',0)->order_by('sort_id','asc')->get('producttype')->result_array();

// 通用分類範例
// $rows = $this->cidb->select('*,topic as name')->where('is_enable',1)->where('type','newstype')->where('ml_key',$ml_key)->order_by('sort_id','asc')->get('html')->result_array();

// var_dump($rows);

// 主選單用的
$rowsg = $this->cidb->where('is_enable',1)->where('type','webmenu')->where('ml_key',$ml_key)->order_by('sort_id','asc')->get('html')->result_array();
?>

<li class="moreMenu"><a href="product_<?php echo $ml_key?>.php?id=<?php echo $rows[0]['id']?>"><?php echo $rowsg[1]['topic']?></a>
    <ul>
		<?php if(isset($rows) and count($rows) > 0):?>
			<?php foreach($rows as $k => $v):?>
				<li><a href="product_<?php echo $ml_key?>.php?id=<?php echo $v['id']?>"><?php echo $v['name']?></a></li>
			<?php endforeach?>
		<?php endif?>
    </ul>
</li>
