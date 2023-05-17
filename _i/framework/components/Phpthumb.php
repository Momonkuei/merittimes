<?php
class Phpthumb {
	protected $x;
	protected $y;
	protected $w;
	protected $h;
	protected $q;
	protected $config_output_format;
	protected $sourceFilename;
	protected $imSource;
	protected $imThumb;
	public $err_code; /* <0 is error */
	protected $all_type;
	protected $source_width;
	protected $source_height;
	protected $debug;

	function __construct() {
		$this->debug = 0;
		$this->w = -1;
		$this->h = -1;
		$this->q = 75;
		$this->config_output_format = 'jpg';
		$this->sourceFilename = '';
		$this->err_code = 0;
		$this->all_type = array(
		    "jpg"   => array("create"=>"imagecreatefromjpeg", "output"=>"imagejpeg"  , "exn"=>".jpg"),
		    "gif"   => array("create"=>"imagecreatefromgif" , "output"=>"imagegif"   , "exn"=>".gif"),
		    "jpeg"  => array("create"=>"imagecreatefromjpeg", "output"=>"imagejpeg"  , "exn"=>".jpg"),
		    "png"   => array("create"=>"imagecreatefrompng" , "output"=>"imagepng"   , "exn"=>".png"),
		    "bmp"  => array("create"=>"imagecreatefromwbmp", "output"=>"image2wbmp"  , "exn"=>".bmp")
		);
		if($this->imThumb) imagedestroy($this->imThumb);
		if($this->imSource) imagedestroy($this->imSource);
		$this->imSource = 0;
		$this->imThumb = 0;
	}
	
	function __destruct() {
		if($this->imThumb) imagedestroy($this->imThumb);
		if($this->imSource) imagedestroy($this->imSource);
	}
	
	public function resetObject(){
		$this->__construct();
	}
	
	public function setParameter($param, $value) {
		$this->$param = $value;
		return true;
	}
	
	public function setSourceFilename($sourceFilename){
		$this->err_code = 0;
		$this->sourceFilename = $sourceFilename;
		if(($this->sourceFilename != '') && (is_file($this->sourceFilename) || is_link($this->sourceFilename))){
			$subname = strtolower(substr($this->sourceFilename, strrpos($this->sourceFilename, '.')+1));
			if(isset($this->all_type[$subname])){
				$func_create = (string) $this->all_type[$subname]['create'];
				$this->imSource = @$func_create($this->sourceFilename);
				//echo $this->sourceFilename;
				//die;
				if(!$this->imSource){
					$this->imSource = $this->ImageCreateFromFilename($this->sourceFilename);
				}
				if($this->err_code >= 0){
					$this->source_width   = imagesx($this->imSource);
					$this->source_height  = imagesy($this->imSource);
				}
			}else{
				$this->err_code = -520; // source format error 
			}
		}else{
			$this->err_code = -404; // file not found 
		}
		return $this->err_code;
	}
	
	public function GenerateThumbnail(){
		$this->err_code = 0;
		if($this->imSource){
			if(isset($this->all_type[$this->config_output_format])){
				$func_output = (string) $this->all_type[$this->config_output_format]['create'];
				if($this->w >0 || $this->h > 0){
					if($this->w > 0){
						$this->h = round($this->w * ($this->source_height/$this->source_width));
					}elseif($this->h > 0){
						$this->w = round($this->h * ($this->source_width/$this->source_height));
					}
			   		$this->imThumb = imagecreatetruecolor($this->w, $this->h);
			   		$bgColor = imagecolorallocate($this->imThumb, 123, 255, 123);
			   		imagefill($this->imThumb, 0, 0, $bgColor);
			   		imagealphablending($this->imThumb, false);
				    imagesavealpha($this->imThumb, true);
				    imagecopyresampled($this->imThumb, $this->imSource, 0, 0, 0, 0, $this->w, $this->h, $this->source_width, $this->source_height);
			   		imagecolortransparent($this->imThumb, $bgColor);
				}else{
					$this->err_code = -523; // size error 
				}
			}else{
				$this->err_code = -522; // target error 
			}
		}else{
			$this->err_code = -521; // source error 
		}
		return $this->err_code;
	}
	
	public function cut(){
		$this->err_code = 0;
		if($this->imSource){
			if(isset($this->all_type[$this->config_output_format])){
				$func_output = (string) $this->all_type[$this->config_output_format]['create'];
				if($this->w >0 && $this->h > 0){
			   		$this->imThumb = imagecreatetruecolor($this->w, $this->h);
			   		$bgColor = imagecolorallocate($this->imThumb, 123, 255, 123);
			   		imagefill($this->imThumb, 0, 0, $bgColor);
			   		imagealphablending($this->imThumb, false);
				    imagesavealpha($this->imThumb, true);
				    imagecopyresampled($this->imThumb, $this->imSource, 0, 0, $this->x, $this->y, $this->w, $this->h, $this->w, $this->h);
			   		imagecolortransparent($this->imThumb, $bgColor);
				}else{
					$this->err_code = -523; // size error 
				}
			}else{
				$this->err_code = -522; // target error 
			}
		}else{
			$this->err_code = -521; // source error 
		}
		return $this->err_code;
	}	
	
	public function RenderToFile($output_filename){
		if($this->imThumb){
			if(isset($this->all_type[$this->config_output_format])){
				$func_output = (string) $this->all_type[$this->config_output_format]['output'];
				if($this->config_output_format == 'jpg' || $this->config_output_format == 'jpeg'){
					$func_output($this->imThumb, $output_filename, $this->q);
				}else{
					$func_output($this->imThumb, $output_filename);
				}
			}else{
				$this->err_code = -524; // target format error 
			}
		}else{
			$this->err_code = -522; // target error 
		}
		return $this->err_code;
	}
	
	function ImageCreateFromFilename($filename) {
		$ImageCreateWasAttempted = false;
		$gd_image = false;

		if ($filename && ($getimagesizeinfo = @GetImageSize($filename))) {
				$ImageCreateFromFunction = array(
					1  => 'ImageCreateFromGIF',
					2  => 'ImageCreateFromJPEG',
					3  => 'ImageCreateFromPNG',
					6 => 'ImageCreateFromBMP',
					15 => 'ImageCreateFromWBMP'
				);
				switch (@$getimagesizeinfo[2]) {
					case 1:  // GIF
					case 2:  // JPEG
					case 3:  // PNG
					case 15: // WBMP
						$ImageCreateFromFunctionName = $ImageCreateFromFunction[$getimagesizeinfo[2]];
						if (function_exists($ImageCreateFromFunctionName)) {
							if($this->debug){
								echo 'Calling '.$ImageCreateFromFunctionName.'('.$filename.')';
							}
							$ImageCreateWasAttempted = true;
							$gd_image = @$ImageCreateFromFunctionName($filename);
						} else {
							if($this->debug){
								echo 'NOT calling '.$ImageCreateFromFunctionName.'('.$filename.') because !function_exists('.$ImageCreateFromFunctionName.')';
								$this->err_code = -525;
							}
						}
						break;
					case 6:  // BMP
						$ImageCreateWasAttempted = true;
						$gd_image = @$this->imagecreatefrombmp($filename);
						break;
					case 4:  // SWF
					case 5:  // PSD
					case 7:  // TIFF (LE)
					case 8:  // TIFF (BE)
					case 9:  // JPC
					case 10: // JP2
					case 11: // JPX
					case 12: // JB2
					case 13: // SWC
					case 14: // IFF
					case 16: // XBM
						if($this->debug){
							echo 'No built-in image creation function for image type "'.@$getimagesizeinfo[2].'" ($getimagesizeinfo[2])';
						}
						$this->err_code = -526;
						break;

					default:
						if($this->debug){
							echo 'Unknown value for $getimagesizeinfo[2]: "'.@$getimagesizeinfo[2].'"';
						}
						$this->err_code = -527;
						break;
				}
		} else {
			if($this->debug){
				echo 'empty $filename or GetImageSize('.$filename.') failed';
				$this->err_code = -528;
			}
		}

		if (!$gd_image) {
			if ($ImageCreateWasAttempted) {
				if($this->debug){
					echo @$ImageCreateFromFunctionName.'() was attempted but FAILED';
					$this->err_code = -529;
				}
			}
			$rawimagedata = '';
			if ($fp = @fopen($filename, 'rb')) {
				$filesize = filesize($filename);
				$blocksize = 8192;
				$blockreads = ceil($filesize / $blocksize);
				for ($i = 0; $i < $blockreads; $i++) {
					$rawimagedata .= fread($fp, $blocksize);
				}
				fclose($fp);
			} else {
				if($this->debug){
					echo 'cannot fopen('.$filename.')';
					$this->err_code = -530;
				}
			}
			if ($rawimagedata) {
				$gd_image = @ImageCreateFromString($rawimagedata);
			}
		}
		return $gd_image;
	}
	
	public function ConvertBMP2GD($src, $dest = false) {
		if(!($src_f = fopen($src, "rb"))) {
			return false;
		}
		if(!($dest_f = fopen($dest, "wb"))) {
			return false;
		}
		$header = unpack("vtype/Vsize/v2reserved/Voffset", fread($src_f, 14));
		$info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant",
		fread($src_f, 40));
		extract($info);
		extract($header);
		if($type != 0x4D42) { // signature "BM"
			return false;
		}
		$palette_size = $offset - 54;
		$ncolor = $palette_size / 4;
		$gd_header = "";
		$gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF";
		$gd_header .= pack("n2", $width, $height);
		$gd_header .= ($palette_size == 0) ? "\x01" : "\x00";
		if($palette_size) {
			$gd_header .= pack("n", $ncolor);
		}
		$gd_header .= "\xFF\xFF\xFF\xFF";
		fwrite($dest_f, $gd_header);
		if($palette_size) {
			$palette = fread($src_f, $palette_size);
			$gd_palette = "";
			$j = 0;
			while($j < $palette_size) {
				$b = $palette{$j++};
				$g = $palette{$j++};
				$r = $palette{$j++};
				$a = $palette{$j++};
				$gd_palette .= "$r$g$b$a";
			}
			$gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor);
			fwrite($dest_f, $gd_palette);
		}
		$scan_line_size = (($bits * $width) + 7) >> 3;
		$scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size & 0x03) : 0;

		for($i = 0, $l = $height - 1; $i < $height; $i++, $l--) {
			fseek($src_f, $offset + (($scan_line_size + $scan_line_align) * $l));
			$scan_line = fread($src_f, $scan_line_size);
			if($bits == 24) {
				$gd_scan_line = "";
				$j = 0;
				while($j < $scan_line_size) {
					$b = $scan_line{$j++};
					$g = $scan_line{$j++};
					$r = $scan_line{$j++};
					$gd_scan_line .= "\x00$r$g$b";
				}
			} else if($bits == 8) {
				$gd_scan_line = $scan_line;
			} else if($bits == 4) {
				$gd_scan_line = "";
				$j = 0;
				while($j < $scan_line_size) {
					$byte = ord($scan_line{$j++});
					$p1 = chr($byte >> 4);
					$p2 = chr($byte & 0x0F);
					$gd_scan_line .= "$p1$p2";
				}
				$gd_scan_line = substr($gd_scan_line, 0, $width);
			} else if($bits == 1) {
				$gd_scan_line = "";
				$j = 0;
				while($j < $scan_line_size) {
					$byte = ord($scan_line{$j++});
					$p1 = chr((int) (($byte & 0x80) != 0));
					$p2 = chr((int) (($byte & 0x40) != 0));
					$p3 = chr((int) (($byte & 0x20) != 0));
					$p4 = chr((int) (($byte & 0x10) != 0));
					$p5 = chr((int) (($byte & 0x08) != 0));
					$p6 = chr((int) (($byte & 0x04) != 0));
					$p7 = chr((int) (($byte & 0x02) != 0));
					$p8 = chr((int) (($byte & 0x01) != 0));
					$gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8";
				}
				$gd_scan_line = substr($gd_scan_line, 0, $width);
			}
			fwrite($dest_f, $gd_scan_line);
		}
		fclose($src_f);
		fclose($dest_f);
		return true;
	}

	public function imagecreatefrombmp($filename) {
		$tmp_name = tempnam("/tmp", "GD");
		if($this->ConvertBMP2GD($filename, $tmp_name)) {
			$img = imagecreatefromgd($tmp_name);
			unlink($tmp_name);
			return $img;
		}
		return false;
	}

	public function thumb($big_image_name, $new_name, $max_width, $max_height, $is_cut = '0'){
		// 指定變數
		$format = substr($big_image_name, strrpos($big_image_name, '.')+1);

		/*
		 * 縮圖開始
		 */

		$big_image_name = str_replace("\\", '/', $big_image_name);
		$new_name = str_replace("\\", '/', $new_name);
		
		if($temp_img_type = @getimagesize($big_image_name)) {
			$subject = $temp_img_type['mime'];
			$pattern = '/([A-Za-z]+)$/';
			preg_match($pattern, $subject, $tpn);
			
			$img_type = $tpn[1];
			if($is_cut == '0'){
				$hw = $this->getThumbHW($temp_img_type[0], $temp_img_type[1], $max_width, $max_height);
			} else {
				$hw = $this->getThumbHW_by_cut($temp_img_type[0], $temp_img_type[1], $max_width, $max_height);
			}
			$_thb_w = $hw[0];
		}else{
			$subject = $big_image_name;
			$pattern = '/.([A-Za-z]+)$/';
			preg_match($pattern, $subject, $tpn);

			$img_type = $tpn[1];
			$_thb_w = $max_width;
		}
		
		if($format == ''){
			$format = substr($big_image_name, strrpos($big_image_name, '.') + 1);
		}
		
		$capture_raw_data = false;
		$return_val = false;
		$this->resetObject();
		if($this->setSourceFilename($big_image_name) >= 0){ // your source image file  
			$output_filename = $new_name.'.'.$format; // output file path
			
			$this->setParameter('w', $_thb_w); // thumbnail width  
			
			$lowerFormat = strtolower($format);
			if($lowerFormat == 'jpg' || $lowerFormat == 'jpeg'){  // preferred thumbnail format   
				$this->setParameter('q', 100); // thumbnail quality
				$this->setParameter('config_output_format', 'jpeg');
			}elseif($lowerFormat == 'png'){
				$this->setParameter('config_output_format', 'png');
			}elseif($lowerFormat == 'gif'){
				$this->setParameter('config_output_format', 'gif');
			}elseif($lowerFormat == 'bmp'){
				$this->setParameter('config_output_format', 'bmp');
			}
			
			$return_val = false;
			if ($this->GenerateThumbnail() >= 0){  
				if($this->RenderToFile($output_filename) >= 0){
					$return_val = true;
				} else {  
					$msg = "Thumbnail error: " . $this->err_code; 
					$this->write_error_log($msg);
				}
			} else {  
				$msg = "Thumbnail error: " . $this->err_code;
				$this->write_error_log($msg);
			}
		}else{
			$msg = "Thumbnail error: " . $this->err_code;
			$this->write_error_log($msg);
		}
	}

	// 純裁圖的功能
	public function thumbcut2($image_file_name, $new_file_name, $ww, $hh, $xx = -1, $yy = -1){
		// 指定變數
		$format = substr($image_file_name, strrpos($image_file_name, '.')+1);

		if($xx < 0) $xx = 0;
		if($yy < 0) $yy = 0;

		$hw[0] = $ww;
		$hw[1] = $hh;

		if($format == ''){
			$format = substr($image_file_name, strrpos($image_file_name, '.') + 1);
		}
		
		$capture_raw_data = false;
		$return_val = false;
		$this->resetObject();
		if($this->setSourceFilename($image_file_name) >= 0){ // your source image file  
			$output_filename = $new_file_name.'.'.$format; // output file path
			
			$this->setParameter('x', $xx); // thumbnail width  
			$this->setParameter('y', $yy); // thumbnail width  
			$this->setParameter('w', $hw[0]); // thumbnail width  
			$this->setParameter('h', $hw[1]); // thumbnail width  
			
			$lowerFormat = strtolower($format);
			if($lowerFormat == 'jpg' || $lowerFormat == 'jpeg'){  // preferred thumbnail format   
				$this->setParameter('q', 100); // thumbnail quality
				$this->setParameter('config_output_format', 'jpeg');
			}elseif($lowerFormat == 'png'){
				$this->setParameter('config_output_format', 'png');
			}elseif($lowerFormat == 'gif'){
				$this->setParameter('config_output_format', 'gif');
			}elseif($lowerFormat == 'bmp'){
				$this->setParameter('config_output_format', 'bmp');
			}
			
			$return_val = false;
			if ($this->cut() >= 0){  
				if($this->RenderToFile($output_filename) >= 0){
					$return_val = true;
				} else {  
					$msg = "Thumbnail error: " . $this->err_code; 
					$this->write_error_log($msg);
				}
			} else {  
				$msg = "Thumbnail error: " . $this->err_code;
				$this->write_error_log($msg);
			}
		}else{
			$msg = "Thumbnail error: " . $this->err_code;
			$this->write_error_log($msg);
		}
	}

	public function thumbcut($image_file_name, $new_file_name, $ww, $hh, $xx = -1, $yy = -1){
		// 指定變數
		$format = substr($image_file_name, strrpos($image_file_name, '.')+1);

		// 先進行縮圖的程序，先縮後裁
		$this->thumb($image_file_name, $new_file_name.'_cut_thumb_tmp', $ww, $hh, '1');

		// 把縮好後的圖片當做原始檔，準備做裁圖的動作
		$image_file_name = $new_file_name.'_cut_thumb_tmp.'.$format;

		// 計算中間值，如果沒有指定xx和yy的話
		if($xx == -1 or $yy == -1){
			$temp_img_type = @getimagesize($image_file_name);
		}

		if(isset($temp_img_type) and $temp_img_type !== false){
			if($xx == -1){
				$tmp_cut_1 = $temp_img_type[0] - $ww;
				if($tmp_cut_1 < 0){
					$xx = 0;
				} elseif($tmp_cut_1 > 0){
					$xx = $tmp_cut_1 / 2;
				}
			}
			if($yy == -1){
				$tmp_cut_1 = $temp_img_type[1] - $hh;
				if($tmp_cut_1 < 0){
					$yy = 0;
				} elseif($tmp_cut_1 > 0){
					$yy = $tmp_cut_1 / 2;
				}
			}
		}

		if($xx < 0) $xx = 0;
		if($yy < 0) $yy = 0;

		$image_file_name = str_replace("\\", '/', $image_file_name);
		$new_file_name = str_replace("\\", '/', $new_file_name);
		
		if($temp_img_type = @getimagesize($image_file_name)) {
			$subject = $temp_img_type['mime'];
			$pattern = '/([A-Za-z]+)$/';
			preg_match($pattern, $subject, $tpn);
			
			$img_type = $tpn[1];
			$hw = array();
			$hw[0] = $ww;
			$hw[1] = $hh;
			
			if($hw[0] > $temp_img_type[0]) {
				$hw[0] = $temp_img_type[0];
				$xx = 0;
			}elseif(($xx + $hw[0]) > $temp_img_type[0]) {
				$xx = $temp_img_type[0]-$hw[0];
			}
			if($hw[1] > $temp_img_type[1]) {
				$hw[1] = $temp_img_type[1];
				$yy = 0;
			}elseif(($xx + $hw[1]) > $temp_img_type[1]) {
				$xx = $temp_img_type[1]-$hw[1];
			}
		}else{
			$subject = $image_file_name;
			$pattern = '/.([A-Za-z]+)$/';
			preg_match($pattern, $subject, $tpn);

			$img_type = $tpn[1];
			$hw = array();
			$hw[0] = $ww;
			$hw[1] = $hh;
			
			if($hw[0] > $temp_img_type[0]) {
				$hw[0] = $temp_img_type[0];
				$xx = 0;
			}elseif(($xx + $hw[0]) > $temp_img_type[0]) {
				$xx = $temp_img_type[0]-$hw[0];
			}
			if($hw[1] > $temp_img_type[1]) {
				$hw[1] = $temp_img_type[1];
				$yy = 0;
			}elseif(($yy + $hw[1]) > $temp_img_type[1]) {
				$yy = $temp_img_type[1]-$hw[1];
			}
		}
		
		if($format == ''){
			$format = substr($image_file_name, strrpos($image_file_name, '.') + 1);
		}
		
		$capture_raw_data = false;
		$return_val = false;
		$this->resetObject();
		if($this->setSourceFilename($image_file_name) >= 0){ // your source image file  
			$output_filename = $new_file_name.'.'.$format; // output file path
			
			$this->setParameter('x', $xx); // thumbnail width  
			$this->setParameter('y', $yy); // thumbnail width  
			$this->setParameter('w', $hw[0]); // thumbnail width  
			$this->setParameter('h', $hw[1]); // thumbnail width  
			
			$lowerFormat = strtolower($format);
			if($lowerFormat == 'jpg' || $lowerFormat == 'jpeg'){  // preferred thumbnail format   
				$this->setParameter('q', 100); // thumbnail quality
				$this->setParameter('config_output_format', 'jpeg');
			}elseif($lowerFormat == 'png'){
				$this->setParameter('config_output_format', 'png');
			}elseif($lowerFormat == 'gif'){
				$this->setParameter('config_output_format', 'gif');
			}elseif($lowerFormat == 'bmp'){
				$this->setParameter('config_output_format', 'bmp');
			}
			
			$return_val = false;
			if ($this->cut() >= 0){  
				if($this->RenderToFile($output_filename) >= 0){
					$return_val = true;
				} else {  
					$msg = "Thumbnail error: " . $this->err_code; 
					$this->write_error_log($msg);
				}
			} else {  
				$msg = "Thumbnail error: " . $this->err_code;
				$this->write_error_log($msg);
			}
		}else{
			$msg = "Thumbnail error: " . $this->err_code;
			$this->write_error_log($msg);
		}
	}

	public function getThumbHW($sx, $sy, $tx, $ty){
		if($sx<$tx && $sy<$ty){
			$dim[0]=$sx;
			$dim[1]=$sy;
		} else {
			$tmp1=$sx/$tx;
			$tmp2=$sy/$ty;
			$factor=($tmp1>$tmp2?$tmp1:$tmp2);
		
			$dim[0]=ceil($sx/$factor);
			$dim[1]=ceil($sy/$factor);
		}   
		return $dim;
	}

	public function getThumbHW_by_cut($sx, $sy, $tx, $ty){
		if($sx<$tx && $sy<$ty){
			$dim[0]=$sx;
			$dim[1]=$sy;
		} else {
			$tmp1=$sx/$tx;
			$tmp2=$sy/$ty;
			$factor=($tmp1<$tmp2?$tmp1:$tmp2);
		
			$dim[0]=ceil($sx/$factor);
			$dim[1]=ceil($sy/$factor);
		}   
		return $dim;
	}
	
	// debug用的
	function write_error_log($msg){
		//file_put_contents('/tmp/123.txt', $msg, FILE_APPEND);
	}
}
