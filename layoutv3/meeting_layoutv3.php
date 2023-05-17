# update: 2016-10-12

	這個檔案的目的，就是在說明以及做範例
	這個東西，是李哥叫我開發的

#
# 所參考的技術
#

	smarty
	layoutv2
	html dom結構

#
# 我的別名
#

	LayoutV3

#
# 為了什麼而做這個LayoutV3？
#

	解決LayoutV2的問題：

	資訊部干涉太多(scss、頁面、樹狀圖)
	MVC程式不好寫，資料夾層級太深

#
# 講解資料夾結構，並和LayoutV2比較
#

	V2：

	  controller的位置
	  _i/web/controllers/
	  
	  struct、data、datalayout、layout、share、post
	  _i/web/controllers/layoutv2/
	  
	  資料夾都在很深好幾層的下面(MVC)
	  
	  如果要建一個全新的全客制功能，前台至少要開啟三個檔案(controller、struct、data)

	V3：

	  功能的位置
	  /
	  
	  版型區塊的位置，要講到include的概念
	  /view
	  
	  程式的位置
	  /source

	  群組的位置
	  /group
	  
	  資料夾都在根目錄
	  
	  如果要建立一個全新的全客制功能，如果程式和規則己經撰寫，那就只要開一個檔案

# 
# V2和V3最大的差異
#

  複雜度、資料和版型區塊串連的方式數量
  
  雖然有差異，但目的相同，而且都有考量到layout、群組、區塊、資料連結、模組化的概念

#
# 最單純的空白頁
#

	要include三支檔案，其中那個註解的下面可能才會說明到
	其中init.php，裡面有一行是開或關支援Yii架構，就看當下要用什麼架構的選擇

	include 'layoutv3/init.php';
	include 'layoutv3/pre_render.php';
	//include 'layoutv3/print_struct.php';
	include 'layoutv3/render.php';

#
# 建立一個最簡單的程式demo1
#

	講述一下最簡單的單筆和多筆的程式套用

	include 'layoutv3/init.php';
	$page = array(
		array(
			'file' => 'demo/layout',
			'hole' => array(
				array(
					'file' => 'demo/demo1',
				),
			),
		),
	);
	include 'layoutv3/pre_render.php';
	// include 'layoutv3/print_struct.php';

	// 單筆的資料範例
	// $data[$ID]['name'] = '123';

	// 多筆的資料範例
	// $data[$ID][0]['name'] = '123';
	// $data[$ID][1]['name'] = '456';
	// $data[$ID][2]['name'] = '789';

	include 'layoutv3/render.php';

	■  來看一下demo1.php的內容

	這是單筆的情況

	<?php echo $data[$ID]['name']?>

	這是多筆的情況

	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<?php echo $v['name']?>
		<?php endforeach?>
	<?php endif?>

	■  來看一下layout.php的內容，AA就是洞

	<html>
		<head>
			<title>demo</title>
		</head>

		<body>
	<?php echo $AA?>
		</body>
	</html>

#
# 在有$page結構的情況下，把print_struct.php的註解打開
#

	你可以選擇性的，把所有的print_struct所輸出的所有內容，複製到程式碼的print_struct和render之間

	■  會出現以下的重點內容：
	各檔案資料編號對照表，能夠直接指定資料給某一塊區塊的方式
	各種存取資料庫的範例，包含Yii、CI的多筆或單純的存取方式範本
	以及在不指定區塊ID的情況下，assign資料到前台的方式

	簡單來說，就是在這裡有兩種傳遞資料到區塊的方式，以及資料庫的存取程式範本

#
# 來說明第三種的傳遞資料到區塊的方式：規則
# 利用規則，來為程式碼和區塊之間的配對
#

	首先，在$page結構的下面，增加這個陣列，減號的左邊，是第一層，右邊是代表第二層

	$page_source = array(
		'webmenu-v1',
	);

	然後在source/page_sources.php規則檔裡面，放置以下的內容

	$page_sources = array(
		'webmenu' => array(
			'v1' => array(
				'alias' => '主選單', // 別名，只是說明而以
				// rule，沒星號，就是絕對的對應，有星號，就是條件的對應，可以下多條的規則
				'file' => array(
					'header/nav_menu*',
					'footer/sitemap_type*',
				),
				'condition' => array(), // NULL無條件-同時這也是預設值, single, multi, single|multi, multi|single|single...
				'source' => 'menu/v1', // 如果規則符合，那就執行什麼程式，當然這個程式也是放在source資料夾裡面
			),
		),
	);

	然後在source/menu/v1.php的程式碼裡面，就放程式碼，最後當然是這行

	$data[$ID] = blha ... blha ... blha ...

	ID不用指定，這個LayoutV3會處理中間這一塊

	■  如果是POST，那在$page結構的下面那個陣列，建立規則後，要放在規則的最上面，請看規則的範例

	$page_sources = array(
		'productinquiry' => array(
			'post' => array(
				'alias' => '商品洽詢的post',
				'source' => 'product/inquiry_post',
			),
		),
	);

#
# 某一區塊有複合式的資料
# 或者說，某一區塊有單筆和多筆的存在，而且又切不開，理還亂的情況
#

	■  規則範例

	$page_sources = array(
		'productdetail' => array(
			'general' => array(
				'alias' => '資料',
				'file' => array(
					'^product/list2_*',
				),
				// 只有單筆、或是只有多筆，或是有同時都有，而且它的順序是這樣子的話 都符合
				'condition' => array('single','multi','multi|multi|single'),
				'source' => 'product/detail',
			),
		),
	);

	■  底下是區塊的內容

	<!-- // DATA_MULTI -->
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div><a class="swipebox" rel="proShow" href="<?php echo $v['pic']?>"><div class="itemImg"><img src="<?php echo $v['pic']?>"></div></a></div>
			<?php endforeach?>
		<?php endif?>

	<!-- // DATA_MULTI -->
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div><div class="itemImg"><img src="<?php echo $v['pic']?>"></div></div>
			<?php endforeach?>
		<?php endif?>

	<!-- // DATA_SINGLE -->
		<div class="itemTitle"><?php echo $data[$ID]['name']?></div>

	■  程式碼撰寫的方式

	if($DATA_SINGLE == true and $DATA_MULTI == false){
		
		// 目前沒有

	} elseif($DATA_SINGLE == false and $DATA_MULTI == true){
		
		// 目前沒有

	} elseif($DATA_SINGLE == true and $DATA_MULTI == true){

		// 多筆、多筆、單筆
		if(count($DATA_SINGLE_MULTI) == 3 and $DATA_SINGLE_MULTI[0] == 'DATA_MULTI' and $DATA_SINGLE_MULTI[1] == 'DATA_MULTI' and $DATA_SINGLE_MULTI[2] == 'DATA_SINGLE'){

			// 單筆
			$tmp = $this->db->createCommand()->from('product')->where('is_enable=1 and id=:id',array(':id'=>$_GET['id']))->queryRow();
			$tmp['name2'] = $tmp['field_data'];
			$tmp['content1'] = $tmp['detail'];
			$tmp['content2'] = $tmp['field_data'];

			// 記得要在編號後面加上底線與數字，數字加1，代表它是複合式的第幾順位的資料
			$data[$ID.'_2'] = $tmp;

			$path = 'webroot._i.assets.members.product'.$tmp['id'].'.member';
			$tmp2 = $this->_getFiles(Yii::getPathOfAlias($path));
			$rows = array();
			if($tmp2){
				foreach($tmp2 as $k => $v){
					$tmp2 = explode('/', $v);
					$tmp3 = $tmp2[count($tmp2)-1];
					// 為了要符合前台版型的規範
					$rows[] = array('pic' => '_i/assets/members/product'.$tmp['id'].'/member/'.$tmp3);
				}
			}
			$data[$ID.'_0'] = $data[$ID.'_1'] = $rows;

		}

	}

#
# 在結構裡面使用群組，然後在群組裡面在使用群組，並從結構帶區塊進去最裡面的那個群組
#

	這樣子test區塊就可以帶入最裡面的那個群組，它的AA裡面

	// 這個是結構
	$page = array(
		array(
			'file' => '$group1',
			'hole' => array(
				array('file' => 'test'),
			),
		),
	);

	// 這個是群組1
	$group_struct = array(
		array(
			// 這一層要加，不然會錯誤，在群組的最上面使用群組，才有需要加
			'hole' => array(
				array(
					'file' => '$group2',
					'hole' => array(
	// AA
					),
				),
			),
		),
	);

	// 這個是群組2
	$group_struct = array(
		array(
			'hole' => array(
	// AA
			),
		),
	);
