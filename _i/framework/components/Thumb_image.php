<?php

/*
 * 輸出圖片的smarty block函式
 *
 * 基本使用方式:
 *
 * 輸出大小為200x200商品product01.png縮圖
 * {{img a="200" b="200" c="product"}}product01.png{{/img}}
 *
 * 功能引數:
 *
 * thumb
 *   0不做縮圖
 *   1是預設值，會做縮圖的動作
 *   2會做裁圖
 *   3只回傳縮圖的檔名，而沒有做縮圖
 *   4只回傳原始檔名(return)，而沒有做縮圖
 *
 * x, y 當thumb=2的時候，可以選擇使用這兩個引數，是裁圖的參考座標點
 *
 * size
 *   0預設是不輸出寬高
 *   1輸出寬高，如果是style，就是width:200px, 如果是img tag，那就是width="200"
 *
 * tag
 *   1輸出html img tag，例如<img src="XXX" />
 *   2輸出style css background-image
 *   3只輸出縮圖檔案(有做縮圖的動作)
 *   4只輸出檔案網址絕對路徑，例如/upload/product/product01.png
 *   5回傳檔案內容
 *
 * replace
 *   0預設值，代表如果己經有產生縮圖，就只會去讀縮圖，不會在重新做縮圖或是裁圖的動作
 *   1每次都會重新做縮圖或是載圖的程序
 *
 * other(其它功能)
 *   0無功能，無所事事
 *   1忽略gif不縮圖
 *
 * _html_*
 *   *就是img標籤的html屬性，例如id, title, tag
 *
 * _image_upload_path
 *   用來取代原始路徑的位置
 *
 * HTML屬性引數:
 *
 *   id
 *   title
 *   class
 */
class Thumb_image 
{
	//public $db = NULL;
	function __construct()
	{
		//$this->db = Yii::app()->db;
		$this->session = Yii::app()->session;
	}

	/**
	 * 輸入圖片，輸出前先做縮圖的程序
	 */
	public function core($params)
	{
		// define：
		//image_thumb_path
		//image_upload_path

		// data(vars)：
		// base_url
		// image_thumb_path
		// image_upload_path
		
		$output_array = array();
		$output_array['msg'] = '';

		if(!isset($params['data']) or count($params['data']) <= 0) $params['data'] = array();

		$vars = $params['data'];
		$image_thumb_path = $this->session['image_thumb_path'];
		$image_upload_path = $this->session['image_upload_path'];
		$image_upload_static_path = $this->session['image_upload_static_path'];
		$image_crop_path = $this->session['image_crop_path'];
		$vars['image_thumb_path'] = $image_thumb_path;
		$vars['image_upload_path'] = $image_upload_path;
		$vars['image_upload_static_path'] = $image_upload_static_path;
		$vars['image_crop_path'] = $image_crop_path;
		$output_array['vars'] = $vars;

		$width = '';
		if(isset($params['a']) and $params['a'] != '') $width = $params['a'];
		$output_array['width'] = $width;

		$height = '';
		if(isset($params['b']) and $params['b'] != '') $height = $params['b'];
		$output_array['height'] = $height;

		// 檔名
		$content = '';
		if(isset($params['content']) and $params['content'] != '') $content = $params['content'];

		$path = '';
		if(isset($params['c']) and $params['c'] != '') $path = $params['c'];


		// 因為上傳儲存後的名子不一樣，所以另外寫這個轉換的程式區段
		// ./assets/upload/adv/20130118142003_3_5y..jpg
		// 0 1      2      3   4
		if(preg_match('/^\.\//', $content)){
			$tmp = explode('/', $content);
			$path = $tmp[3];
			$content = $tmp[4];
			//unset($tmp[3]);
			//unset($tmp[4]);
		}

		$output_array['path'] = $path;
		$output_array['content'] = $content;

		//var_dump($output_array);
		//die;

		// 預設是會做縮圖的動作
		// 1: 做縮圖的動作
		// 2: 做裁圖的動作
		$is_thumb = '1';
		if(isset($params['thumb']) and $params['thumb'] != '') $is_thumb = $params['thumb'];
		$output_array['is_thumb'] = $is_thumb;

		// 預設是不顯示寬高
		$is_size = '0';
		if(isset($params['size']) and $params['size'] != '') $is_size = $params['size'];
		$output_array['is_size'] = $is_size;

		// 是否要覆蓋己處理好的縮圖
		// 預設不覆蓋
		$is_replace = '0';
		if(isset($params['replace']) and $params['replace'] != '') $is_replace = $params['replace'];
		$output_array['is_replace'] = $is_replace;

		// 計算裁圖的定位點
		$xx = '-1';
		if(isset($params['x']) and $params['x'] != '') $xx = $params['x'];
		$yy = '-1';
		if(isset($params['y']) and $params['y'] != '') $yy = $params['y'];

		$general_html_attrs = array('id', 'title', 'alt', 'class');
		foreach($general_html_attrs as $k => $v){
			$output_array[$v] = '';
			if(isset($params[$v]) and $params[$v] != '') $output_array[$v] = $params[$v];
		}
		
		// 輸出tag的種類
		$form_tag = '1';
		if(isset($params['tag']) and $params['tag'] != '') $form_tag = $params['tag'];
		$output_array['tag'] = $form_tag;

		// 其它特別功能
		$other = '0';
		if(isset($params['other']) and $params['other'] != '') $other = $params['other'];
		$output_array['other'] = $other;

		// 就是可以轉讀取靜態圖片資料夾的路徑
		$static = '0';
		if(isset($params['static']) and $params['static'] != '') $static = $params['static'];
		$output_array['static'] = $static;

		// 就是可以轉讀取原圖圖片資料夾的路徑(有裁圖的，才會把原圖放在這裡)
		$crop = '0';
		if(isset($params['crop']) and $params['crop'] != '') $crop = $params['crop'];
		$output_array['crop'] = $crop;

		// 指定圖片的網址，通常是指向到前台(現在用不到)
		//$output_array['public_url'] = $vars['base_url'];

		if($content != ''){
			$gggs = explode('.', $content);
			if($other == '0' and isset($gggs[1]) and strtolower($gggs[1]) == 'svg'){
				$is_thumb = '0';
				$output_array['is_thumb'] = $is_thumb;
			} elseif($other == '0' and isset($gggs[1]) and strtolower($gggs[1]) == 'webp'){
				$is_thumb = '0';
				$output_array['is_thumb'] = $is_thumb;
			} elseif($other == '0' and isset($gggs[1]) and strtolower($gggs[1]) == 'dng'){
				$is_thumb = '0';
				$output_array['is_thumb'] = $is_thumb;
			} elseif($other == '1' and isset($gggs[1]) and strtolower($gggs[1]) == 'gif'){
			//if($other == '1' and isset($gggs[1]) and preg_match('/^(gif|svg)$/', strtolower($gggs[1]))){
				$is_thumb = '0';
				$output_array['is_thumb'] = $is_thumb;
			}
		}

		// 把html屬性抓出來
		$output_array['htmls'] = array();
		if(isset($params) and count($params) > 0){
			foreach($params as $k => $v){
				if(preg_match('/^_html_(.*)$/', $k, $matches)){
					$output_array['htmls'][$matches[1]] = $v;
				}
			}
		}

		// 可以指定一個錯誤會回傳的檔案名稱，預設我先給它空白
		$output_array['value'] = '';

		if($content == ''){
			return $this->output_img($output_array);
		}

		$size = $width.'x'.$height;

		// full開頭的變數，是目標圖片
		//$full_path = image_thumb_path.'/'.$path;
		$full_path = $vars['image_thumb_path'].'/'.$path;;
		// echo $full_path;die;
		// 客戶所上傳的圖片
		$source_full_name = $vars['image_upload_path'].'/'.$path.'/'.$content;

		// source開頭的變數，是來源圖片
		if($crop == '1' and file_exists($vars['image_crop_path'].'/'.$path.'/'.$content)){
			// 客戶自己的靜態圖片
			$source_full_name = $vars['image_crop_path'].'/'.$path.'/'.$content;
		}


		//if(isset($gggs[1]) and strtolower($gggs[1]) == 'svg'){
		//	$source_full_name = $vars['image_upload_path'].'/'.$path.'/'.$content;
		//}

		if($is_thumb == '0'){
			$file_name = $content;
		} else {
			$file_name = $size.'_'.$content;
			$full_name = $full_path .'/'.$file_name;
		}
		// 如果還是抓不到圖片，就顯示no_image的圖
		// 另外，有一個程序，是等一下才做，要注意一下
		$is_no_image = '';
		if(!file_exists($source_full_name)){
			// 每一個網站，都可以有自己的no-image，沒有指定的話，也可以共用
			//if(file_exists(image_upload_path.'/_system/no_image.png')){
			//	$source_full_name = image_upload_path.'/_system/no_image.png';
			//}
			if(file_exists($vars['image_upload_path'].'/_system/no_image.png')){
				$source_full_name = $vars['image_upload_path'].'/_system/no_image.png';
			}
			$is_replace = '1';
			$output_array['is_replace'] = $is_replace;
			$is_no_image = '1';
			$file_name = 'no_image.png';
			$path = '_system';
			$output_array['path'] = '_system';
			$full_path = $vars['image_thumb_path'].'/_system';
		}

		//echo $source_full_name;
		if(!file_exists($source_full_name)){
			$output_array['msg'] = 'source file is not exist';
			return $this->output_img($output_array);
		}

		//echo $full_path;
		//die
		if(!file_exists($full_path)){
			if(!mkdir($full_path, 0777, true)){
				$output_array['msg'] = 'create dir fail';
				return $this->output_img($output_array);
			}
		}

		// 如果被標註為不縮圖，那就取用來源圖片(copy過來)
		if($is_thumb == '0'){
			$full_name = $source_full_name;
			list($current_width, $current_height, $current_type, $current_attr) = getimagesize($full_name);
			if($width == ''){
				$output_array['width'] = $current_width;
			} else {
				$output_array['width'] = $width;
			}
			if($height == ''){
				$output_array['height'] = $current_height;
			} else {
				$output_array['height'] = $height;
			}
			
		}

		// 抓不到圖片的話，這裡還會做一個程序，就是指定縮圖位置
		if($is_no_image == '1'){
			$file_name = $width.'x'.$height.'_'.$file_name;
			$full_name = $full_path.'/'.$file_name;
		}

		if($is_thumb == '3'){
			echo $full_name;
			die;
			//$full_name = $source_full_name;
		}
		if($is_thumb == '4'){
			return $source_full_name;
		}

		// 如果圖片存在，就直接回傳圖片的相關東西
		if(file_exists($full_name) and $is_replace == 0){
			$output_array['value'] = $file_name;
			return $this->output_img($output_array);
		}

		if($is_replace == '1' and file_exists($full_name)){
			unlink($full_name);
		}

		/*
		 * 如果圖片不存在，才會繼續下去
		 */

		if($is_thumb == '1'){
			//echo $source_full_name;
			//echo $full_name;
			$phpthumb = new Phpthumb;
			$phpthumb->thumb($source_full_name, substr($full_name, 0, strrpos($full_name, '.')), $output_array['width'], $output_array['height']);
			//echo substr($full_name, 0, strrpos($full_name, '.'));
		} // is_thumb = 1

		if($is_thumb == '2'){
			// 指定變數
			$image_file_name = $source_full_name;
			$new_file_name = substr($full_name, 0, strrpos($full_name, '.'));
			$ww = $output_array['width'];
			$hh = $output_array['height'];
			$format = substr($source_full_name, strrpos($source_full_name, '.')+1);

			$phpthumb = new Phpthumb;
			$phpthumb->thumbcut2($source_full_name, substr($full_name, 0, strrpos($full_name, '.')), $output_array['width'], $output_array['height'], $xx, $yy);
		} // is_thumb = 2
		
		if(!file_exists($full_name)){
			//write_error_log('aaa');
			$output_array['msg'] = 'convert error';
			return $this->output_img($output_array);
		}
		//write_error_log('bbb');
		//write_error_log($msg);
		$output_array['value'] = $file_name;
		return $this->output_img($output_array);
	}

	public function output_img($array) {

		// 把所有的vars路徑，加上前綴路徑
		$array['vars']['image_thumb_path'] = vir_path_c.$array['vars']['image_thumb_path'];
		$array['vars']['image_upload_path'] = vir_path_c.$array['vars']['image_upload_path'];
		$array['vars']['image_upload_static_path'] = vir_path_c.$array['vars']['image_upload_static_path'];
		$array['vars']['image_crop_path'] = vir_path_c.$array['vars']['image_crop_path'];

		$return = '';

		$value = $array['value'];
		$tag = $array['tag'];
		$msg = $array['msg'];
		$path = $array['path'];
		//$public_url = $array['public_url'];
		$is_size = $array['is_size'];
		$is_thumb = $array['is_thumb'];

		// 其它img html屬性
		$id = $array['id'];
		$title = $array['title'];
		$alt = $array['alt'];
		$class = $array['class'];

		// 集合式html屬性群
		$htmls = array();
		if(isset($array['htmls'])){
			$htmls = $array['htmls'];
		}

		$width = '';
		$height = '';
		if(isset($array['width'])) $width = $array['width'];
		if(isset($array['height'])) $height = $array['height'];

		if($tag == '5'){ // 直接回傳檔案內容
			//echo readfile(image_thumb_path.'/'.$path.'/'.$value);
			//if($array['crop'] == '1' and $array['is_thumb'] != 2){
			//if($array['crop'] == '1'){
			//	echo readfile($array['vars']['image_crop_path'].'/'.$path.'/'.$value);
			//} else {
				echo readfile($array['vars']['image_thumb_path'].'/'.$path.'/'.$value);
			//}
		} elseif($tag == '3'){ // 3代表只回傳完整檔名(未縮圖的圖片，在縮圖資料夾)
			if($msg != ''){
				$return = '';
			} else {
				if($path != '' and $value != ''){
					$return = $array['vars']['image_thumb_path'].'/'.$path.'/'.$value;
				}
			}
			//echo $msg;
			return $return;
		} elseif($tag == '4'){ // 4代表回傳原始檔名
			if($msg != ''){
				$return = '';
			} else {
				if($path != '' and $value != ''){
					$return = $array['vars']['image_upload_path'].'/'.$path.'/'.$value;
				}
			}
			return $return;
		}elseif($tag == '2'){
			if($msg != ''){
				$return = 'error:msg('.$msg.');';
			} else {
				$src = '';
				if($path != '' and $value != ''){
					//$src = $public_url.'/pub/upload/'.$path.'/'.$value;
					if($is_thumb == '0'){
						//$src = $public_url.'/upload/'.$path.'/'.$value;
						if($array['static'] == '1'){
							$src = $array['vars']['image_upload_static_path'].'/'.$path.'/'.$value;
						} else {
							$src = $array['vars']['image_upload_path'].'/'.$path.'/'.$value;
						}
					} else {
						//$src = $public_url.'/thumb/'.$path.'/'.$value;
						$src = $array['vars']['image_thumb_path'].'/'.$path.'/'.$value;
					}
				}
				$return = 'background-image:url('.$src.');';
				//$return .= 'background-position:50% 50%;';
				if(isset($htmls) and count($htmls) > 0){
					if(isset($htmls['style']) and $htmls['style'] != ''){
						$return .= $htmls['style'];
					} else {
						$return .= 'background-position:50% 50%;';
						$return .= 'background-repeat:no-repeat;';
					}
					foreach($htmls as $k => $v){
						$return .= ' '.$k.'="'.$v.'" ';
					}
				} else {
					// 要在自己在htmls裡面加上你要的屬性元素進來
					//$return .= 'background-position:50% 50%;';
					//$return .= 'background-repeat:no-repeat;';
				}
				if($is_size == '1'){
					if($width != '') $return .= 'width:'.$width.'px;';
					if($height != '') $return .= 'height:'.$height.'px;';
				}
			}
			return $return;
		} elseif($tag == '1'){
			$src = '';
			if($path != '' and $value != ''){
				if($is_thumb == '0'){
					if($array['static'] == '1'){
						$src = $array['vars']['image_upload_static_path'].'/'.$path.'/'.$value;
					} else {
						$src = $array['vars']['image_upload_path'].'/'.$path.'/'.$value;
					}
				} else {
					$src = $array['vars']['image_thumb_path'].'/'.$path.'/'.$value;
				}
			}
			$return = '<img src="'.$src.'" ';
			if($msg != ''){
				$return .= ' error_msg="'.$msg.'" ';
			}
			if($id != ''){
				$return .= ' id="'.$id.'" ';
			}
			if($title != ''){
				$return .= ' title="'.$title.'" ';
			}
			if($alt != ''){
				$return .= ' alt="'.$alt.'" ';
			}
			if($class != ''){
				$return .= ' class="'.$class.'" ';
			}
			if(isset($htmls) and count($htmls) > 0){
				foreach($htmls as $k => $v){
					$return .= ' '.$k.'="'.$v.'" ';
				}
			}
			if($is_size == '1'){
				if($width != '') $return .= ' width="'.$width.'px" ';
				if($height != '') $return .= ' height="'.$height.'px" ';
			}
			$return .= ' />';
			return $return;
		} else {
			return $value;
		}
	}

}
