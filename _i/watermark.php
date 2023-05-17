<?php   

// /mr_lian/watermark.php/product/photo_m_139831629336.jpg
if(isset($timthumb_argv)){
	// 跟timthumb合併使用
	$tmp = $timthumb_argv;
} else {
	$tmp = $_SERVER['REQUEST_URI'];
}

if(0){
	echo $tmp;
	die;
}

/*
 *	編輯器的圖片的情況
 *  array(5) {
 *   [0]=>
 *   string(0) ""
 *   [1]=>
 *   string(6) "upload"
 *   [2]=>
 *   string(9) "userfiles"
 *   [3]=>
 *   string(5) "image"
 *   [4]=>
 *   string(24) "14013326161347375749.jpg"
 * }
 */
$tmps = explode('/', $tmp);
// /_i/assets/members/member/aaa.jpg
$img = $tmps[count($tmps)-1];
$img_source = str_replace('/_i/', '', $tmp);
$type = $tmps[count($tmps)-2];

// 其它語系的參考 ../en_upload
$upload_dir = ''; // 為了其它語系而寫的，如果是預設語系，這個值後面處理過後，應該會是upload的字串
$include_path = 'include/';

if(0){
	var_dump($tmps);
	die;
}

// 檢查路徑，如果是編輯器的圖，就跳過
// 這裡是判斷開發站或是正式站的情況
//$tmp2 = $tmps;
//foreach($tmp2 as $k => $v){
//	unset($tmp2[$k]);
//	//if($v == 'upload') break;
//	if(preg_match('/upload$/', $v) and $upload_dir == ''){
//		$upload_dir = $v;
//		break;
//	}
//}

// 為了支援編輯器上傳的圖
//if(count($tmps) > 3){
//	unset($tmp2[count($tmps)-1]); // 檔名
//	unset($tmp2[0]); // 空白
//	unset($tmp2[1]); // upload
//	$type = implode('/', $tmp2);
//}

// 有時會圖片後面會有GET引數，這時要把它拿掉，不然會抓不到檔名
// 例如: http://demo.changwoen.com.tw/upload/banner/index/ad03.png?1402020617745
if(preg_match('/\?/', $img)){
	$tmps = explode('?', $img);
	$img = $tmps[0];
}

$size = 'all';
define('filePrependSecurityBlock',  "<?"."php die('Execution denied!'); //");

if(0){
	echo $img.'|<br />';
	echo $type.'|<br />';
	die;
}


// The requested URL /mr_lian/watermarkg.php/photo_m_139831629336.jpg was not found on this server.

// <meta http-equiv="content-type" content="text/html; charset=utf-8" />

if(0){
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}

// 先檢查一下有沒有尺寸
//if(preg_match('/(_b_|_l_|_m_|_s_|_b_)/', $img, $matches)){
//	$size = str_replace('.', '', $matches[1]);
//}

//$imgFileName = 'upload/'.$type.'/'.$img;
//$imgFileName = $upload_dir.'/'.$type.'/'.$img;


$imgFileName = $img_source;

// 檢查暫存檔是否存在，存在的話就直接輸出
@mkdir('cache2', 0777);
@chmod('cache2', 0777);
//$cachefile = __DIR__.'/cache2/'.md5($imgFileName);
//$cachefile = 'cache2/'.md5($_GET['src']);

// assets/upload/product/ggg.jpg
$cachefile_tmp = $_GET['src'];
$cachefile3_tmp = '';

if(isset($_GET['w'])){
	$cachefile_tmp .= 'w'.$_GET['w'];
	$cachefile3_tmp .= 'w'.$_GET['w'];
}
if(isset($_GET['h'])){
	$cachefile_tmp .= 'h'.$_GET['h'];
	$cachefile3_tmp .= 'h'.$_GET['h'];
}
if(isset($_GET['zc'])){
	$cachefile_tmp .= 'zc'.$_GET['zc'];
	$cachefile3_tmp .= 'zc'.$_GET['zc'];
}
$cachefile = 'cache2/'.md5($cachefile_tmp);

// 2018-01-04 為了要產出可直接取用的靜態圖
$tmp3 = str_replace('assets/', '', $_GET['src']); // upload/product/ggg.jpg
$tmp3s = explode('/', $tmp3);
$tmp3_name = $tmp3s[count($tmp3s)-1]; // ggg.jpg
unset($tmp3s[count($tmp3s)-1]);
$path3 = 'cache3/'.implode('/', $tmp3s); // upload/product
@mkdir($path3, 0777, true);
@chmod($path3, 0777);
if($cachefile3_tmp != ''){
	$cachefile3_tmp .= '_';
}
$cachefile3 = $path3.'/'.$cachefile3_tmp.$tmp3_name; // cache3/upload/product/w?h?zc3?_ggg.jpg
// echo $cachefile3;die;

if(file_exists($cachefile) and !isset($_GET['nocache']) and 0){
	$srcImg_info = getimagesize($cachefile);

    switch ($srcImg_info[2]) {
        case 3:
            $im = imagecreatefrompng($cachefile);   

			// PNG圖片的處理方式
			// http://www.01happy.com/php-save-png-alpha/
			$newImg = imagecreatetruecolor($srcImg_info[0], $srcImg_info[1]);
			$alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
			imagefill($newImg, 0, 0, $alpha);

			imagecopyresampled($newImg, $im, 0, 0, 0, 0, $srcImg_info[0], $srcImg_info[1], $srcImg_info[0], $srcImg_info[1]);
			imagesavealpha($newImg, true);

			$im = $newImg;

            break 1;
        case 2:
            $im = imagecreatefromjpeg($cachefile);   
            break 1;
        case 1:
            $im = imagecreatefromgif($cachefile);   
            break 1;
    }   

	// 輸出圖片
	switch ($srcImg_info[2]) {   
	case 3:   
		header('Content-Type: image/png');
		imagepng($im);
		break 1;   
	case 2:   
		header('Content-Type: image/jpeg');
		imagejpeg($im, null, 100);
		break 1;   
	case 1:   
		header('Content-Type: image/gif');
		imagegif($im);
		break 1;   
	default:   
		die('添加水印失败！');
		break;   
	}   
	die;
}

// 檢查一下尺寸所對應的浮水印有沒有存在，不存在就不用玩了，而且只有商品的圖片才會處理
//if(!file_exists('images/watermark/'.$type.$size.'.png')){
//if(!file_exists('images/watermark/all.png')){
if(!file_exists('all.png')){
	//$im = imagecreatefrompng($imgFileName);
	/*
	 array(6) {
	  [0]=>
	  int(716)
	  [1]=>
	  int(965)
	  [2]=>
	  int(3)
	  [3]=>
	  string(24) "width="716" height="965""
	  ["bits"]=>
	  int(8)
	  ["mime"]=>
	  string(9) "image/png"
	}
	 */
	$srcImg_info = getimagesize($imgFileName);

    switch ($srcImg_info[2]) {
        case 3:
            $im = imagecreatefrompng($imgFileName);   

			// PNG圖片的處理方式
			// http://www.01happy.com/php-save-png-alpha/
			$newImg = imagecreatetruecolor($srcImg_info[0], $srcImg_info[1]);
			$alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
			imagefill($newImg, 0, 0, $alpha);

			imagecopyresampled($newImg, $im, 0, 0, 0, 0, $srcImg_info[0], $srcImg_info[1], $srcImg_info[0], $srcImg_info[1]);
			imagesavealpha($newImg, true);

			$im = $newImg;

            break 1;
        case 2:
            $im = imagecreatefromjpeg($imgFileName);   
            break 1;
        case 1:
            $im = imagecreatefromgif($imgFileName);   
            break 1;
        default:
			if(preg_match('/^cache/', $imgFileName)){
				$fp = fopen($imgFileName, 'rb');
				if(! $fp){ return $this->error("Could not open cachefile."); }
				fseek($fp, strlen(filePrependSecurityBlock), SEEK_SET);
				$srcImg_info = array();
				$srcImg_info[2] = fread($fp, 3);
				fclose($fp);

				if($srcImg_info[2] == 'jpg'){
					$srcImg_info[2] = 2;
				} elseif($srcImg_info[2] == 'png'){
					$srcImg_info[2] = 3;
				} else {
					$srcImg_info[2] = 1;
				}

				$content = file_get_contents ($imgFileName);
                $content = substr($content, strlen(filePrependSecurityBlock) + 6);

				$im = imagecreatefromstring($content);   
				$srcImg_info[0] = imagesx($im);
				$srcImg_info[1] = imagesy($im);
			} else {
				die('原图片（'.$imgFileName.'）格式不对，只支持PNG、JPEG、GIF。(watermark)');   
			}
			break;
    }   

	// 輸出圖片
	switch ($srcImg_info[2]) {   
	case 3:   
		header('Content-Type: image/png');
		imagepng($im);   
		break 1;   
	case 2:   
		header('Content-Type: image/jpeg');
		imagejpeg($im, null, 100);
		break 1;   
	case 1:   
		header('Content-Type: image/gif');
		imagegif($im);   
		break 1;   
	default:   
		die('添加水印失败！');   
		break;   
	}   
	die;
}

/*
 * 這裡是第三個版本的浮水印，使用的是ImageMagick
 * https://gist.github.com/rodneyrehm/1161975
 * 目的是為了，加浮水印不要有損失、也不要有模糊
 * 2018-01-16 李哥下午有允許做這件事情
 */

if(!function_exists('gravity2coordinates')){
	function gravity2coordinates($image, $watermark, $gravity, $xOffset=0, $yOffset=0) {
		// theoretically this should work
		// $im->setImageGravity( Imagick::GRAVITY_SOUTHEAST );
		// but it doesn't so here goes the workaround
		
        switch ($gravity) {   
            case 0:     //随机位置   
                $x = rand(0,$image->getImageWidth()-$watermark->getImageWidth());   
                $y = rand(0,$image->getImageHeight()-$watermark->getImageHeight());   
                break 1;   
            case 1:     //上左   
                $x = 0;   
                $y = 0;   
                break 1;   
            case 2:     //上中   
                $x = ($image->getImageWidth()-$watermark->getImageWidth())/2;   
                $y = 0;   
                break 1;   
            case 3:     //上右   
                $x = $image->getImageWidth()-$watermark->getImageWidth();
                $y = 0;   
                break 1;   
            case 4:     //中左   
                $x = 0;   
                $y = ($image->getImageHeight()-$watermark->getImageHeight())/2;   
                break 1;   
            case 5:     //中中   
                $x = ($image->getImageWidth()-$watermark->getImageWidth())/2;   
                $y = ($image->getImageHeight()-$watermark->getImageHeight())/2;   
                break 1;   
            case 6:     //中右   
                $x = $image->getImageWidth()-$watermark->getImageWidth();
                $y = ($image->getImageHeight()-$watermark->getImageHeight())/2;   
                break 1;   
            case 7:     //下左   
                $x = 0;   
                $y = $image->getImageHeight()-$watermark->getImageHeight();   
                break 1;   
            case 8:     //下中   
                $x = ($image->getImageWidth()-$watermark->getImageWidth())/2;   
                $y = $image->getImageHeight()-$watermark->getImageHeight();   
                break 1;   
            case 9:     // 下右 
				$x = $image->getImageWidth()-$watermark->getImageWidth();   
				$y = $image->getImageHeight()-$watermark->getImageHeight(); 
                break 1;   
            case 10:    // 填滿  
                $x = 999;
                $y = 999;
                break 1;   
            default:    // 預設隨機
                $x = rand(0,$image->getImageWidth()-$watermark->getImageWidth());   
                $y = rand(0,$image->getImageHeight()-$watermark->getImageHeight());   
                break 1;   
        }   

		return array(
			'x' => $x, 
			'y' => $y
		);
	}
}

if(preg_match('/cache/', $imgFileName)){
	$fp = fopen($imgFileName, 'rb');
	if(! $fp){ return $this->error("Could not open cachefile."); }
	fseek($fp, strlen(filePrependSecurityBlock), SEEK_SET);
	// $type = fread($fp, 3);
	// $this->srcImg_info = array();
	// $this->srcImg_info[2] = fread($fp, 3);

	$ext = fread($fp, 3); // 2020-09-23 因為後面的getFormat，抓到的東西是空白

	fclose($fp);

	// if($this->srcImg_info[2] == 'jpg'){
	// 	$this->srcImg_info[2] = 2;
	// } elseif($this->srcImg_info[2] == 'png'){
	// 	$this->srcImg_info[2] = 3;
	// } else {
	// 	$this->srcImg_info[2] = 1;
	// }

	$content = file_get_contents ($imgFileName);
    $content = substr($content, strlen(filePrependSecurityBlock) + 6);

	//$srcImg_info[2] = fread($fp, 3);

	$image = new Imagick();
	$image->readImageBlob($content);
	$image->setFormat($ext); // 2020-09-23

	// $this->im = imagecreatefromstring($content);   
	// $this->srcImg_info[0] = imagesx($this->im);
	// $this->srcImg_info[1] = imagesy($this->im);
} else {
	$image = new Imagick($imgFileName);
}

$watermark_file = 'all.png';
// $watermark_file = 'buyersline_watermark2.png'; // 填滿功能測試用

// $watermark = new Imagick('all.png');
$watermark = new Imagick($watermark_file);

if(file_exists('watermark_config.php')){
	include 'watermark_config.php';
}

if(isset($_GET['pos']) and $_GET['pos'] != ''){
	$watermark_config['pos'] = $_GET['pos'];
}

/* 元素參考
$tmp = array(
	'pos' => $save['sys_config_watermark_pos'],
	'opacity' => $save['sys_config_watermark_opacity'],
);
 */
// if(isset($watermark_config['opacity']) and $watermark_config['opacity'] != ''){
// 	$obj->settransparent($watermark_config['opacity']);
// } else {
// 	// 預設值
// 	$obj->settransparent(35);	//水印透明度  
// }

if(isset($watermark_config['opacity']) and $watermark_config['opacity'] != ''){
	$watermark->evaluateImage(Imagick::EVALUATE_MULTIPLY, $watermark_config['opacity']/100, Imagick::CHANNEL_ALPHA);
} else {
	// 預設值
	$watermark->evaluateImage(Imagick::EVALUATE_MULTIPLY, 0.35, Imagick::CHANNEL_ALPHA);
}

$percent = 45;
if(isset($watermark_config['percent']) and $watermark_config['percent'] != ''){
	$percent = $watermark_config['percent'];
}

if($image->getImageWidth() <= $watermark->getImageWidth() || $image->getImageHeight() <= $watermark->getImageHeight()){   
	$waterImageThumbPercent = $percent / 100;
	$width2 = (int)($image->getImageWidth() * $waterImageThumbPercent);
	$height2 = (int)($image->getImageHeight() * $waterImageThumbPercent);

	// 等比縮
	if($watermark->getImageWidth() > $width2){
		$percent = $width2/$watermark->getImageWidth();
	} else {
		$percent = $height2/$watermark->getImageHeight();
	}
	$new_width = $watermark->getImageWidth() * $percent;
	$new_height = $watermark->getImageHeight() * $percent;

	// 2017-12-26 浮水印縮圖
	$waterImg_info = getimagesize($watermark_file);   
	switch ($waterImg_info[2]) {   
		case 3:   
			$water_im = imagecreatefrompng($watermark_file);
			break 1;   
		case 2:   
			$water_im = imagecreatefromjpeg($watermark_file);   
			break 1;   
		case 1:   
			$water_im = imagecreatefromgif($watermark_file);   
			break 1;   
		default:   
			die('水印图片（'.$watermark_file.'）格式不对，只支持PNG、JPEG、GIF。(watermark3)');   
	}   
	$newImage = imagecreatetruecolor($new_width, $new_height);
	imagealphablending($newImage, false);
	imagesavealpha($newImage,true);
	$transparency = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
	imagefilledrectangle($newImage, 0, 0, $new_width, $new_height, $transparency);
	imagecopyresampled($newImage, $water_im, 0, 0, 0, 0, $new_width, $new_height, $watermark->getImageWidth(), $watermark->getImageHeight());
	$water_im = $newImage;

	// https://stackoverflow.com/questions/14491163/using-a-gd-image-file-to-create-a-new-imagick-image
	ob_start();
	switch ($waterImg_info[2]) {   
		case 3:   
			imagepng($water_im, null);
			break 1;   
		case 2:   
			imagejpeg($water_im, null, 100);
			break 1;   
		case 1:   
			imagegif($water_im);   
			break 1;   
		default:   
			die('輸出失敗！');   
			break;   
	}   
	$blob = ob_get_clean();
	$watermark = new imagick();  
	$watermark->readImageBlob($blob);
}

if(isset($watermark_config['pos']) and $watermark_config['pos'] != ''){
	// translate named gravity to pixel position
	if($watermark_config['pos'] == 10){
		$image = $image->textureImage($watermark);
	} else {
		$position = gravity2coordinates($image, $watermark, $watermark_config['pos'], 5, 5);

		// compose watermark onto image
		$image->compositeImage( $watermark, $watermark->getImageCompose(), $position['x'], $position['y'] );
	}
} else {
	// 預設值
	$position = gravity2coordinates($image, $watermark, 9, 5, 5);

	// compose watermark onto image
	$image->compositeImage( $watermark, $watermark->getImageCompose(), $position['x'], $position['y'] );
}


// you'll never guess what this does…
$image->writeImage($cachefile);
@chmod($cachefile, 0777);
$image->writeImage($cachefile3);
@chmod($cachefile3, 0777);

// Output the image
$output = $image->getimageblob();
$outputtype = $image->getFormat();

header("Content-type: image/$outputtype");
echo $output;
die;


//    /*
//     * 這裡是第二個版本的浮水印套件, 需要主機的finfo.so的支援(動物園沒有)
//     */
//    use gdenhancer\GDEnhancer;
//    include_once $include_path.'gdenhancer/GDEnhancer.php'; //path of your GDEnhancer.php
//    $obj = new GDEnhancer($imgFileName);
//    $obj->layerImage('images/watermark/all.png'); //This is layer 0
//    
//    // 可用的設定
//    $pos_sample = array(
//    	1 => 'topleft',
//    	2 => 'topcenter',
//    	3 => 'topright',
//    	4 => 'centerleft',
//    	5 => 'center',
//    	6 => 'centerright',
//    	7 => 'bottomleft',
//    	8 => 'bottomcenter',
//    	9 => 'bottomright',
//    );
//    if(isset($watermark_common_config['all'][$size]['pos'])){
//    	if($watermark_common_config['all'][$size]['pos'] == '-1'){
//    		// 預設值
//    		$obj->layerMove(0, $pos_sample[5]);
//    	} else {
//    		$obj->layerMove(0, $pos_sample[$watermark_common_config['all'][$size]['pos']]);
//    	}
//    } else {
//    	// 預設值
//    	$obj->layerMove(0, $pos_sample[5]);
//    }
//    
//    // 可用的設定
//    if(isset($watermark_common_config['all'][$size]['opacity'])){
//    	$obj->settransparent($watermark_common_config['all'][$size]['opacity']);
//    } else {
//    	// 預設值
//    	$obj->settransparent(50);	//水印透明度  
//    }
//    
//    $save = $obj->save();
//    header('content-type:' . $save['mime']);
//    echo $save['contents'];
//    
//    // 以下結束！！！
//    die;

/*
 * 這裡是第一個版本的浮水印套件
 */
$obj = new WaterMask($imgFileName, $cachefile, $cachefile3);         //实例化对象  

//if($type == 'other_photo'){
//}
if(isset($_GET['smallw'])){
	$obj->setwaterImg('all_small.png');
} else {
	$obj->setwaterImg('all.png');
}

if(file_exists('watermark_config.php')){
	include 'watermark_config.php';
}

if(isset($_GET['pos']) and $_GET['pos'] != ''){
	$watermark_config['pos'] = $_GET['pos'];
}

/* 元素參考
$tmp = array(
	'pos' => $save['sys_config_watermark_pos'],
	'opacity' => $save['sys_config_watermark_opacity'],
);
 */
if(isset($watermark_config['opacity']) and $watermark_config['opacity'] != ''){
	$obj->settransparent($watermark_config['opacity']);
} else {
	// 預設值
	$obj->settransparent(35);	//水印透明度  
}

if(isset($watermark_config['pos']) and $watermark_config['pos'] != ''){
	$obj->setpos($watermark_config['pos']);
} else {
	// 預設值
	$obj->setpos(9);
}

if(isset($watermark_config['percent']) and $watermark_config['percent'] != ''){
	$obj->setwaterImageThumbPercent($watermark_config['percent']);
} else {
	// 預設值
	$obj->setwaterImageThumbPercent(45);
}

// 這是參考的，不能用
//$obj->waterType = 1;                       //类型：0为文字水印、1为图片水印  
//$obj->waterStr = 'www.itwhy.org';          //水印文字  
//$obj->fontSize = 16;                       //文字字体大小  
//$obj->fontColor = array(255,0255);         //水印文字颜色（RGB）  
//$obj->fontFile = 'AHGBold.ttf';          //字体文件  
//$obj->output();                             //输出水印图片文件覆盖到输入的图片文件  

//if(isset($crop_custom_config[$img]['0'])){
//	$obj->outputa($img);
//} else {
//	$obj->outputb();
//}

$obj->outputb();

/**  
 * 加水印类，支持文字图片水印的透明度设置、水印图片背景透明。  
 * 日期：2011-09-27
 * 作者：www.itwhy.org
 * 使用：
 *      $obj = new WaterMask($imgFileName);         // 实例化对象
 *      $obj->$waterType = 1;                       // 类型：0为文字水印、1为图片水印
 *      $obj->$transparent = 45;                    // 水印透明度
 *      $obj->$waterStr = 'www.itwhy.org';          // 水印文字
 *      $obj->$fontSize = 16;                       // 文字字体大小
 *      $obj->$fontColor = array(255,0255);         // 水印文字颜色（RGB）
 *      $obj->$fontFile = = 'AHGBold.ttf';          // 字体文件
 *      $obj->output();                             // 输出水印图片文件覆盖到输入的图片文件
 */  
class WaterMask{   
    public  $waterType          = 1;                // 水印类型：0为文字水印、1为图片水印   
    public  $pos                = 5;                // 水印位置
    public  $transparent        = 45;               // 水印透明度
  
    public  $waterStr           = 'www.buyersline.com.tw';  //水印文字
    public  $fontSize           = 16;               // 文字字体大小
    public  $fontColor          = array(255,0,255); // 水印文字颜色（RGB）
    public  $fontFile           = 'AHGBold.ttf';    // 字体文件
  
    public  $waterImg           = 'logo.png';       // 水印图片
	public  $waterImageThumbPercent  = 45;          // 浮水印縮圖百分比
  
    private $srcImg             = '';               // 需要添加水印的图片
    private $im                 = '';               // 图片句柄
    private $water_im           = '';               // 水印图片句柄
    private $srcImg_info        = '';               // 图片信息
    private $waterImg_info      = '';               // 浮水印图片信息
    private $str_w              = '';               // 浮水印文字宽度
    private $str_h              = '';               // 浮水印文字高度
    private $x                  = '';               // 浮水印X坐標，就是x1啦
    private $y                  = '';               // 浮水印y坐標，就是y1啦

	public $cachefile = '';                         // md5 cache file(2)
	public $cachefile3 = '';                        // phy cache file(3)

	public function setwaterImg($img = 'logo.png'){ $this->waterImg = $img;}
	public function settransparent($tmp = 45){ $this->transparent = $tmp;}
	public function setpos($tmp = 5){ $this->pos = $tmp;}
	public function setwaterImageThumbPercent($tmp = 45){ $this->waterImageThumbPercent = $tmp;}
  
    function __construct($img, $cachefile = '', $cachefile3 = '') {        //析构函数   
        //$this->srcImg = file_exists($img) ? $img : die('"'.$img.'" 源文件不存在！');   
		if(file_exists($img)){
			$this->srcImg =  $img;
		} else {
			header("HTTP/1.0 404 Not Found");
			die;
		}
		$this->cachefile = $cachefile; 
		$this->cachefile3 = $cachefile3;
    }   

    private function imginfo() {                //获取需要添加水印的图片的信息，并载入图片。   
        $this->srcImg_info = getimagesize($this->srcImg);   
		//var_dump($this->srcImg_info);
        switch ($this->srcImg_info[2]) {   
            case 3:   
                //$this->im = imagecreatefrompng($this->srcImg);   

				$im = imagecreatefrompng($this->srcImg);   

				// PNG圖片的處理方式
				// http://www.01happy.com/php-save-png-alpha/
				$newImg = imagecreatetruecolor($this->srcImg_info[0], $this->srcImg_info[1]);
				$alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
				imagefill($newImg, 0, 0, $alpha);

				imagecopyresampled($newImg, $im, 0, 0, 0, 0, $this->srcImg_info[0], $this->srcImg_info[1], $this->srcImg_info[0], $this->srcImg_info[1]);
				imagesavealpha($newImg, true);

				$this->im = $newImg;

                break 1;   
            case 2:   
                $this->im = imagecreatefromjpeg($this->srcImg);   
                break 1;   
            case 1:   
                $this->im = imagecreatefromgif($this->srcImg);   
                break 1;   
            default:   
				if(preg_match('/cache/', $this->srcImg)){
					$fp = fopen($this->srcImg, 'rb');
					if(! $fp){ return $this->error("Could not open cachefile."); }
					fseek($fp, strlen(filePrependSecurityBlock), SEEK_SET);
					$this->srcImg_info = array();
					$this->srcImg_info[2] = fread($fp, 3);
					fclose($fp);

					if($this->srcImg_info[2] == 'jpg'){
						$this->srcImg_info[2] = 2;
					} elseif($this->srcImg_info[2] == 'png'){
						$this->srcImg_info[2] = 3;
					} else {
						$this->srcImg_info[2] = 1;
					}

					$content = file_get_contents ($this->srcImg);
                    $content = substr($content, strlen(filePrependSecurityBlock) + 6);

					$this->im = imagecreatefromstring($content);   
					$this->srcImg_info[0] = imagesx($this->im);
					$this->srcImg_info[1] = imagesy($this->im);
				} else {
					die('原图片（'.$this->srcImg.'）格式不对，只支持PNG、JPEG、GIF。(sourcefile)');   
				}
				break;
        }   
    }   
    private function waterimginfo() {           //获取水印图片的信息，并载入图片。   
        $this->waterImg_info = getimagesize($this->waterImg);   
        switch ($this->waterImg_info[2]) {   
            case 3:   
				$this->water_im = imagecreatefrompng($this->waterImg);

                //    $im = imagecreatefrompng($this->waterImg);   
				//    
				//    // PNG圖片的處理方式
				//    // http://www.01happy.com/php-save-png-alpha/
				//    $newImg = imagecreatetruecolor($this->waterImg_info[0], $this->waterImg_info[1]);
				//    $alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
				//    imagefill($newImg, 0, 0, $alpha);

				//    imagecopyresampled($newImg, $im, 0, 0, 0, 0, $this->waterImg_info[0], $this->waterImg_info[1], $this->waterImg_info[0], $this->waterImg_info[1]);
				//    imagesavealpha($newImg, true);

				//    $this->water_im = $newImg;

                break 1;   
            case 2:   
                $this->water_im = imagecreatefromjpeg($this->waterImg);   
                break 1;   
            case 1:   
                $this->water_im = imagecreatefromgif($this->waterImg);   
                break 1;   
            default:   
                die('水印图片（'.$this->srcImg.'）格式不对，只支持PNG、JPEG、GIF。(watermark2)');   
        }   
    }   
    private function waterpos() {               //水印位置算法   
        switch ($this->pos) {   
            case 0:     //随机位置   
                $this->x = rand(0,$this->srcImg_info[0]-$this->waterImg_info[0]);   
                $this->y = rand(0,$this->srcImg_info[1]-$this->waterImg_info[1]);   
                break 1;   
            case 1:     //上左   
                $this->x = 0;   
                $this->y = 0;   
                break 1;   
            case 2:     //上中   
                $this->x = ($this->srcImg_info[0]-$this->waterImg_info[0])/2;   
                $this->y = 0;   
                break 1;   
            case 3:     //上右   
                $this->x = $this->srcImg_info[0]-$this->waterImg_info[0];   
                $this->y = 0;   
                break 1;   
            case 4:     //中左   
                $this->x = 0;   
                $this->y = ($this->srcImg_info[1]-$this->waterImg_info[1])/2;   
                break 1;   
            case 5:     //中中   
                $this->x = ($this->srcImg_info[0]-$this->waterImg_info[0])/2;   
                $this->y = ($this->srcImg_info[1]-$this->waterImg_info[1])/2;   
                break 1;   
            case 6:     //中右   
                $this->x = $this->srcImg_info[0]-$this->waterImg_info[0];   
                $this->y = ($this->srcImg_info[1]-$this->waterImg_info[1])/2;   
                break 1;   
            case 7:     //下左   
                $this->x = 0;   
                $this->y = $this->srcImg_info[1]-$this->waterImg_info[1];   
                break 1;   
            case 8:     //下中   
                $this->x = ($this->srcImg_info[0]-$this->waterImg_info[0])/2;   
                $this->y = $this->srcImg_info[1]-$this->waterImg_info[1];   
                break 1;   
            case 9:     // 下右 
				$this->x = $this->srcImg_info[0]-$this->waterImg_info[0];   
				$this->y = $this->srcImg_info[1]-$this->waterImg_info[1]; 
                break 1;   
            case 10:    // 填滿  
                $this->x = 999;
                $this->y = 999;
                break 1;   
            default:    // 預設隨機
                $this->x = rand(0,$this->srcImg_info[0]-$this->waterImg_info[0]);   
                $this->y = rand(0,$this->srcImg_info[1]-$this->waterImg_info[1]);   
                break 1;   
        }   
    }   
    private function waterimg() {   
		// oswell的網站所發現，尺寸相同會出不來，不能相同
        if ($this->srcImg_info[0] <= $this->waterImg_info[0] || $this->srcImg_info[1] <= $this->waterImg_info[1]){   

			$waterImageThumbPercent = $this->waterImageThumbPercent / 100;
			$width2 = (int)($this->srcImg_info[0] * $waterImageThumbPercent);
			$height2 = (int)($this->srcImg_info[1] * $waterImageThumbPercent);

			// 等比縮
			if($this->waterImg_info[0] > $width2){
				$percent = $width2/$this->waterImg_info[0];
			} else {
				$percent = $height2/$this->waterImg_info[1];
			}
			$new_width = $this->waterImg_info[0] * $percent;
			$new_height = $this->waterImg_info[1] * $percent;

			// 2017-12-22 新機制，依照比例，縮浮水印的圖 (查理建議) (這個版本是有問題的)
			// http://rwd_v3.web.buyersline.com.tw/_i/timthumb.php?src=all.png&zc=3&w=640&h=426.4&nocache=&nowatermark=1
			// $this->water_im = imagecreatefromstring(file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/_i/timthumb.php?src=all.png&zc=3&nowatermark=1&w='.$new_width.'&h='.$new_height.'&nocache='));
			// $this->waterImg_info = getimagesize($this->waterImg);   

			// 2017-12-26 浮水印縮圖
			$newImage = imagecreatetruecolor($new_width, $new_height);
			imagealphablending($newImage, false);
			imagesavealpha($newImage,true);
			$transparency = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
			imagefilledrectangle($newImage, 0, 0, $new_width, $new_height, $transparency);
			imagecopyresampled($newImage, $this->water_im, 0, 0, 0, 0, $new_width, $new_height, $this->waterImg_info[0], $this->waterImg_info[1]);
			$this->water_im = $newImage;
			$this->waterImg_info[0] = $new_width;
			$this->waterImg_info[1] = $new_height;
			
			// 如果浮水印比原圖大，那就只好不顯示浮水印，只顯示圖片
			// switch ($this->srcImg_info[2]) {   
			// 	case 3:   
			// 		header('Content-Type: image/png');
			// 		// imagepng($this->im, $this->cachefile); // 2017-09-11 疑似浮水印太大，但是在cache模式中，還是做了cache
			// 		imagepng($this->im);
			// 		break 1;   
			// 	case 2:   
			// 		header('Content-Type: image/jpeg');
			// 		// imagejpeg($this->im, $this->cachefile, 100); // 2017-09-11 疑似浮水印太大，但是在cache模式中，還是做了cache
			// 		imagejpeg($this->im, null, 100);
			// 		break 1;   
			// 	case 1:   
			// 		header('Content-Type: image/gif');
			// 		// imagegif($this->im, $this->cachefile); // 2017-09-11 疑似浮水印太大，但是在cache模式中，還是做了cache
			// 		imagegif($this->im);   
			// 		break 1;   
			// 	default:   
			// 		die('處理浮水印失敗！');   
			// 		break;   
			// }   
			// die;

        } // if 當浮水印的圖，和原圖一樣的情況

        $this->waterpos();   

		// 因為png的圖片和png做merge會有問題，所以要另外處理
		switch ($this->srcImg_info[2]) {   
			case 3:   
				$pct = $this->transparent;   
				$this->im = $this->imagecopymerge_alpha($this->im,$this->water_im,$this->x,$this->y,0,0,$this->waterImg_info[0],$this->waterImg_info[1],$pct);
				break 1;
			default:   
				$pct = $this->transparent;   
				$cut = imagecreatetruecolor($this->waterImg_info[0],$this->waterImg_info[1]);   
				imagecopy($cut,$this->im,0,0,$this->x,$this->y,$this->waterImg_info[0],$this->waterImg_info[1]);   
				imagecopy($cut,$this->water_im,0,0,0,0,$this->waterImg_info[0],$this->waterImg_info[1]);   

				break 1;
		}

		// 2017-12-22
		if($this->pos == 10){
			// 填滿
			imagesettile($this->im, $this->water_im);
			imagefilledrectangle($this->im, 0, 0, $this->srcImg_info[0],$this->srcImg_info[1], IMG_COLOR_TILED);
		} else {
			if($this->srcImg_info[2] == 3){ // PNG
				$this->im = $this->imagecopymerge_alpha($this->im,$this->water_im,$this->x,$this->y,0,0,$this->waterImg_info[0],$this->waterImg_info[1],$pct);
			} else { // JPEG, GIF
				imagecopymerge($this->im,$cut,$this->x,$this->y,0,0,$this->waterImg_info[0],$this->waterImg_info[1],$pct);   
			}
		}

    }   

	// http://php.net/manual/en/function.imagecopymerge.php#88456
	private function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
		if(!isset($pct)){
			return false;
		}
		$pct /= 100;
		// Get image width and height
		$w = imagesx( $src_im );
		$h = imagesy( $src_im );
		// Turn alpha blending off
		imagealphablending( $src_im, false );
		// Find the most opaque pixel in the image (the one with the smallest alpha value)
		$minalpha = 127;
		for( $x = 0; $x < $w; $x++ )
			for( $y = 0; $y < $h; $y++ ){
				$alpha = ( imagecolorat( $src_im, $x, $y ) >> 24 ) & 0xFF;
				if( $alpha < $minalpha ){
					$minalpha = $alpha;
				}
			}
		//loop through image pixels and modify alpha for each
		for( $x = 0; $x < $w; $x++ ){
			for( $y = 0; $y < $h; $y++ ){
				//get current alpha value (represents the TANSPARENCY!)
				$colorxy = imagecolorat( $src_im, $x, $y );
				$alpha = ( $colorxy >> 24 ) & 0xFF;
				//calculate new alpha
				if( $minalpha !== 127 ){
					$alpha = 127 + 127 * $pct * ( $alpha - 127 ) / ( 127 - $minalpha );
				} else {
					$alpha += 127 * $pct;
				}
				//get the color index with new alpha
				$alphacolorxy = imagecolorallocatealpha( $src_im, ( $colorxy >> 16 ) & 0xFF, ( $colorxy >> 8 ) & 0xFF, $colorxy & 0xFF, $alpha );
				//set pixel with the new color + opacity
				if( !imagesetpixel( $src_im, $x, $y, $alphacolorxy ) ){
					return false;
				}
			}
		}
		// The image copy
		imagecopy($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);

		return $dst_im;
	} 
    private function waterstr() {   
        $rect = imagettfbbox($this->fontSize,0,$this->fontFile,$this->waterStr);   
        $w = abs($rect[2]-$rect[6]);   
        $h = abs($rect[3]-$rect[7]);   
        $fontHeight = $this->fontSize;   
        $this->water_im = imagecreatetruecolor($w, $h);   
        imagealphablending($this->water_im,false);   
        imagesavealpha($this->water_im,true);   
        $white_alpha = imagecolorallocatealpha($this->water_im,255,255,255,127);   
        imagefill($this->water_im,0,0,$white_alpha);   
        $color = imagecolorallocate($this->water_im,$this->fontColor[0],$this->fontColor[1],$this->fontColor[2]);   
        imagettftext($this->water_im,$this->fontSize,0,0,$this->fontSize,$color,$this->fontFile,$this->waterStr);   
        $this->waterImg_info = array(0=>$w,1=>$h);   
        $this->waterimg();   
    }   

	// 覆蓋原圖
    function output() {   
		//echo '123';
        $this->imginfo();   
        if ($this->waterType == 0) {   
            $this->waterstr();   
        }else {   
            $this->waterimginfo();   
            $this->waterimg();   
        }   
        switch ($this->srcImg_info[2]) {   
            case 3:   
                imagepng($this->im,$this->srcImg);
                break 1;   
            case 2:   
                imagejpeg($this->im,$this->srcImg, 100);
                break 1;   
            case 1:   
                imagegif($this->im,$this->srcImg);   
                break 1;   
            default:   
                die('處理浮水印失敗！');   
                break;   
        }   
        imagedestroy($this->im);   
        imagedestroy($this->water_im);   
    }   

	// 純輸出
    function outputb() {
        $this->imginfo();   
        if ($this->waterType == 0) {   
            $this->waterstr();   
        }else {   
            $this->waterimginfo();   
            $this->waterimg();   
        }   
		$error = false;
        switch ($this->srcImg_info[2]) {   
            case 3:   
				header('Content-Type: image/png');

				imagesavealpha($this->im, true); 
                imagepng($this->im, $this->cachefile);
				@chmod($this->cachefile, 0777);
                imagepng($this->im, $this->cachefile3);
				@chmod($this->cachefile3, 0777);
                imagepng($this->im, null);
				//die;

                //    $im = $this->im;   

				//    // PNG圖片的處理方式
				//    // http://www.01happy.com/php-save-png-alpha/
				//    $newImg = imagecreatetruecolor($this->srcImg_info[0], $this->srcImg_info[1]);
				//    $alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
				//    imagefill($newImg, 0, 0, $alpha);

				//    imagecopyresampled($newImg, $im, 0, 0, 0, 0, $this->srcImg_info[0], $this->srcImg_info[1], $this->srcImg_info[0], $this->srcImg_info[1]);
				//    imagesavealpha($newImg, true);

                //    imagepng($newImg);

                break 1;   
            case 2:   
				header('Content-Type: image/jpeg');
                imagejpeg($this->im, $this->cachefile, 100);
				@chmod($this->cachefile2, 0777);
                imagejpeg($this->im, $this->cachefile3, 100);
				@chmod($this->cachefile3, 0777);
                imagejpeg($this->im, null, 100);
                break 1;   
            case 1:   
				header('Content-Type: image/gif');
                imagegif($this->im, $this->cachefile);   
				@chmod($this->cachefile2, 0777);
                imagegif($this->im, $this->cachefile3);   
				@chmod($this->cachefile3, 0777);
                imagegif($this->im);   
                break 1;   
            default:   
                die('處理浮水印失敗！');   
                break;   
        }   

		//if($error){
        //    $this->im = imagecreatefrompng($this->srcImg);   
		//	$this->srcImg_info = getimagesize($this->srcImg);   
		//	switch ($this->srcImg_info[2]) {   
		//		case 3:   
		//			header('Content-Type: image/png');
		//			imagepng($this->im);   
		//			break 1;   
		//		case 2:   
		//			header('Content-Type: image/jpeg');
		//			imagejpeg($this->im);   
		//			break 1;   
		//		case 1:   
		//			header('Content-Type: image/gif');
		//			imagegif($this->im);   
		//			break 1;   
		//		default:   
		//			// 如果失敗，就顯示原圖
		//			$error = true;
		//			//die('添加水印失败！');   
		//			break;   
		//	}   
		//}

        imagedestroy($this->im);   
        imagedestroy($this->water_im);   
    }   
}   
?>
