<?php

unset($function_list_tmp);
$run = '$function_list_tmp = $html->'.$nothing_parent.'->outertext;';

// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
@eval($run); // gg
if(!isset($function_list_tmp)){
	if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
		continue;
	} else {
		return;
	}
}

$run = '$html->'.$nothing_parent.'->outertext = \'\';';
eval($run);
