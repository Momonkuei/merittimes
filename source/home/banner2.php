<?php
/*
 * 這個是W09專用的，而且只有首頁才會用到
 */

//$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>'banner',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
if(
	preg_match('/^index/', basename($_SERVER['REQUEST_URI'],'.php')) 
	or basename($_SERVER['REQUEST_URI'],'.php') == ''
	// or basename($_SERVER['REQUEST_URI'],'.php') == 'tw' // SEO在使用的，例http://xxx/tw/ 2017-05-02-by-jerry
){
	$tmp = 'banner';
} else {
	$tmp = 'bannersub';
}
$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>$tmp,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

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

		if($v['pic3'] != ''){
			if(preg_match('/^images\//', $v['pic3'])){
				// 這是為了開環境的程式所寫的，因為欄位名稱剛好相同，所以這行註解掉
				// \$tmps[\$k]['pic3'] = \$v['pic3'];
			} else {
				$tmps[$k]['pic3'] = '_i/assets/upload/'.$tmp.'/'.$v['pic3'];
			}
		}


	}
}
$data[$ID] = $tmps;

/*
 * 想辦法把page_source/home/banner1的資料給找到和刪掉
 */
if(isset($layoutv3_struct_tmp['home/banner1'])){
	$id = $layoutv3_struct_tmp['home/banner1'][0];
	unset($data[$id]);
}
