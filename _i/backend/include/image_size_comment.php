<?php

// 2017-04-28 乖哥說，不同的比例，圖片的最小預設值是不一樣的
$row = $this->db->createCommand()->from('scss_config')->where('is_enable=1')->queryRow();
if($row and isset($row['id'])){
	$html_end = '圖片最小尺寸：';
	if(preg_match('/^(product|shop)$/', $this->data['router_class']) and isset($row['proImgSizeType']) and $row['proImgSizeType'] > 0){
		if($row['proImgSizeType'] == 1){
			$html_end .= '600*600';
		} elseif($row['proImgSizeType'] == 2){
			$html_end .= '800*600';
		} elseif($row['proImgSizeType'] == 3){
			$html_end .= '600*800';
		}
	}
	if(preg_match('/^(album|photo)$/', $this->data['router_class']) and isset($row['albumImgSizeType']) and $row['albumImgSizeType'] > 0){
		if($row['albumImgSizeType'] == 1){
			$html_end .= '600*600';
		} elseif($row['albumImgSizeType'] == 2){
			$html_end .= '800*600';
		} elseif($row['albumImgSizeType'] == 3){
			$html_end .= '600*800';
		}
	}
	if(preg_match('/^(video)$/', $this->data['router_class']) and isset($row['videoImgSizeType']) and $row['videoImgSizeType'] > 0){
		if($row['videoImgSizeType'] == 1){
			$html_end .= '600*600';
		} elseif($row['videoImgSizeType'] == 2){
			$html_end .= '800*600';
		} elseif($row['videoImgSizeType'] == 3){
			$html_end .= '600*800';
		}
	}
	if(preg_match('/^(news)$/', $this->data['router_class']) and isset($row['newsImgSizeType']) and $row['newsImgSizeType'] > 0){
		if($row['newsImgSizeType'] == 1){
			$html_end .= '600*600';
		} elseif($row['newsImgSizeType'] == 2){
			$html_end .= '800*600';
		} elseif($row['newsImgSizeType'] == 3){
			$html_end .= '600*800';
		}
	}
	if(isset($this->def['updatefield']['sections'][0]['field']['pic1']['other'])){
		$this->def['updatefield']['sections'][0]['field']['pic1']['other']['html_end'] = $html_end;
	}
}
