<?php

/*
 * 這個程式是依附在pre_render裡面的程式碼
 */

if(isset($tmp2_gggggg['eval']) and $tmp2_gggggg['eval'] != ''){

	if(isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
		$CCCCCCCCCCCCCCCCCCCC.=$tmp2_gggggg['eval']."\n";
	}

	$cache4_content .= '<'.'?'.'php'."\n";
	$cache4_content .= $tmp2_gggggg['eval']."\n";
	$cache4_content .= '?'.'>'."\n";

	eval($tmp2_gggggg['eval']);
} elseif(isset($tmp2_gggggg['source']) and $tmp2_gggggg['source'] != ''){

	if(isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
		if(isset($tmp2_gggggg['source_eval_start']) and $tmp2_gggggg['source_eval_start'] != ''){ // 2018-09-14
			$CCCCCCCCCCCCCCCCCCCC.=$tmp2_gggggg['source_eval_start']."\n";
		}

		$CCCCCCCCCCCCCCCCCCCC.='?'.'>'.file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'source/'.$tmp2_gggggg['source'].'.php')."\n";

		if(isset($tmp2_gggggg['source_eval_end']) and $tmp2_gggggg['source_eval_end'] != ''){ // 2018-09-14
			$CCCCCCCCCCCCCCCCCCCC.=$tmp2_gggggg['source_eval_end']."\n";
		}
	}

	// 2018-09-14 layoutv3的page_source，source的部份增加eval開頭結尾，為了要讓webmenu/v1能有更多變化
	if(isset($tmp2_gggggg['source_eval_start']) and $tmp2_gggggg['source_eval_start'] != ''){
		eval($tmp2_gggggg['source_eval_start']);

		$cache4_content .= '<'.'?'.'php'."\n";
		$cache4_content .= $tmp2_gggggg['source_eval_start']."\n";
		$cache4_content .= '?'.'>'."\n";
	}

	include _BASEPATH.'/../'.LAYOUTV3_PATH.'source/'.$tmp2_gggggg['source'].'.php';

	$cache4_content .= '<'.'?'.'php include _BASEPATH.\'/../source/'.$tmp2_gggggg['source'].'.php\'?'.'>'."\n";

	// 2018-09-14
	if(isset($tmp2_gggggg['source_eval_end']) and $tmp2_gggggg['source_eval_end'] != ''){
		eval($tmp2_gggggg['source_eval_end']);

		$cache4_content .= '<'.'?'.'php'."\n";
		$cache4_content .= $tmp2_gggggg['source_eval_end']."\n";
		$cache4_content .= '?'.'>'."\n";
	}
}
