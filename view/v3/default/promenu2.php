<?php
/*
 * 這個區塊，是點分類的時候，會換頁
 * 然後到新的頁面的時候，才會展開
 */
?>

<?php if(0):?><!-- body_end -->
<style type="text/css">
.proMenu li:not(.active) ul {display:none;}
</style>
<?php endif?><!-- body_end -->

<!-- proMenu start-->
<?php 
$section_attrs = array(
	'class="navlight"',
	'data-active="li"',
	'data-multimenu="true"',
);
?>

<?php if($this->data['router_method'] == 'product' and preg_match('/\.html$/', $_SERVER['REQUEST_URI'])):?>
	<?php $section_attrs[] = 'data-novalue="true"'?>
<?php endif?>

<?php if(isset($_GET['id']) and $_GET['id'] > 0 and isset($layoutv3_struct_map_keyname['v3/product/list1_1']) and isset($data[$layoutv3_struct_map_keyname['v3/product/list1_1'][0]])):?>
	<?php $section_attrs[] = 'data-defactive="active"'?>
	<?php $section_attrs[] = 'data-defactiveid="navlight_'.$_GET['id'].'"'?>
<?php endif?>

<section <?php echo implode(' ', $section_attrs)?> >
	<ul l="layer" ls="lll" class="proMenu" data-item="li" data-title="li>a" data-content="li>ul" data-nodefault="false">

		<li l="list" id="navlight_{/id/}" ><a attr2="" >{/name/}</a>
			{/child/}
		</li>

		<ul l="box">{split}</ul>

		<li><a href="elements.php">照明元件(子)</a>
			<ul>
				<li><a href="elements.php">PLCC Series</a></li>
				<li><a href="elements.php">COB Series</a></li>
				<li><a href="elements.php">Federal Series</a></li>
				<li><a href="elements.php">ES Series</a></li>
				<li><a href="elements.php">Flash Series</a></li>
				<li><a href="elements.php">Filament Series</a></li>
			</ul>
		</li>
		<li><a href="elements.php">LED模組</a></li>
		<li><a href="elements.php">車用模組(子)</a>
			<ul>
				<li><a href="elements.php">PLCC Series(子)</a>
					<ul>
						<li><a href="elements.php">PLCC Series</a></li>
						<li><a href="elements.php">COB Series</a></li>
						<li><a href="elements.php">Flash Series</a></li>
						<li><a href="elements.php">Filament Series</a></li>
					</ul>
				</li>
				<li><a href="elements.php">Flash Series(子)</a>
					<ul>
						<li><a href="elements.php">PLCC Series</a></li>
						<li><a href="elements.php">COB Series</a></li>
						<li><a href="elements.php">Federal Series</a></li>
					</ul>
				</li>
				<li><a href="elements.php">Flash Series</a></li>
				<li><a href="elements.php">COB Series</a></li>
			</ul>
		</li>
		<li><a href="elements.php">照明成品</a></li>
		<li><a href="elements.php">LED燈條</a></li>
	</ul>
</section>
<!-- proMenu end-->

<?php if(0 and isset($data[$ID]) and count($data[$ID]) > 0)://這是舊的?>
	<?php // http://stackoverflow.com/questions/26003141/php-tree-ul-li-hierarchy-menu-from-array?>
	<?php
//var_dump($this->data);

		$items = $data[$ID];
		$indexedItems = array();

		// index elements by id
		foreach ($items as $item) {
			$item['childs'] = array();
			$indexedItems[$item['id']] = (object) $item;
		}


		// assign to parent
		$topLevel = array();
		foreach ($indexedItems as $item) {
			if ($item->parent_id == 0) {
				$topLevel[] = $item;
			} else {
				$indexedItems[$item->parent_id]->childs[] = $item;
			}
		}

		//$class_id = 0;
		//if($this->data['router_method'] == 'productdetail'){
		//	$row = $this->cidb->where('id',$_GET['id'])->get('product')->row_array();
		//	if($row and isset($row['id'])){
		//		$class_id = $row['class_id'];
		//	}
		//}

		// recursive function
		if(!function_exists('renderMenu')){
			//function renderMenu($items,$router_method='',$class_id=0) {
			function renderMenu($items) {
				$render = '<ul>'."\n";

				foreach ($items as $item) {
					$render .= '<li id="navlight_'.$item->id.'" ';
					//if($router_method == 'productdetail' and isset($_GET['id']) and $item->id == $class_id){
					//	$render .= ' class="active" ';
					//}
					$render .= '><a href="'.$item->url.'">' . $item->name.'</a>'."\n";
					if (!empty($item->childs)) {
						//$render .= renderMenu($item->childs, $router_method,$class_id);
						$render .= renderMenu($item->childs);
					}
					$render .= '</li>'."\n";
				}

				return $render . '</ul>'."\n";
			}
		}

		//$result = renderMenu($topLevel, $this->data['router_method'],$class_id);
		$result = renderMenu($topLevel);
		$tmps = explode("\n", $result);
		// togglearea就是點下去展開，如果要換頁在展開，請拿掉它，或是直接使用promenu2
		$tmps[0] = '<ul class="proMenu" data-item="li" data-title="li>a" data-content="li>ul" data-nodefault="false">';
		$result = implode("\n", $tmps);
	?>
	<!-- proMenu start-->

	<?php 
	$section_attrs = array(
		'class="navlight"',
		'data-active="li"',
		'data-multimenu="true"',
	);
	?>

    <?php if($this->data['router_method'] == 'product' and preg_match('/\.html$/', $_SERVER['REQUEST_URI'])):?>
		<?php $section_attrs[] = 'data-novalue="true"'?>
    <?php endif?>

	<?php if(isset($_GET['id']) and $_GET['id'] > 0 and isset($layoutv3_struct_map_keyname['v3/product/list1_1']) and isset($data[$layoutv3_struct_map_keyname['v3/product/list1_1'][0]])):?>
		<?php $section_attrs[] = 'data-defactive="active"'?>
		<?php $section_attrs[] = 'data-defactiveid="navlight_'.$_GET['id'].'"'?>
    <?php endif?>

	<section <?php echo implode(' ', $section_attrs)?> >
		<?php echo $result?>
	</section>
	<!-- proMenu end-->
<?php endif?>

<?php if(0):?>
	<!-- proMenu start-->
	<section class="navlight" data-active="li" data-multimenu="true">
		<ul class="proMenu togglearea" data-item="li" data-title="li>a" data-content="li>ul" data-nodefault="true">
			<li><a href="elements.php">照明元件(子)</a>
				<ul>
					<li><a href="elements.php">PLCC Series</a></li>
					<li><a href="elements.php">COB Series</a></li>
					<li><a href="elements.php">Federal Series</a></li>
					<li><a href="elements.php">ES Series</a></li>
					<li><a href="elements.php">Flash Series</a></li>
					<li><a href="elements.php">Filament Series</a></li>
				</ul>
			</li>
			<li><a href="elements.php">LED模組</a></li>
			<li><a href="elements.php">車用模組(子)</a>
				<ul>
					<li><a href="elements.php">PLCC Series(子)</a>
						<ul>
							<li><a href="elements.php">PLCC Series</a></li>
							<li><a href="elements.php">COB Series</a></li>
							<li><a href="elements.php">Flash Series</a></li>
							<li><a href="elements.php">Filament Series</a></li>
						</ul>
					</li>
					<li><a href="elements.php">Flash Series(子)</a>
						<ul>
							<li><a href="elements.php">PLCC Series</a></li>
							<li><a href="elements.php">COB Series</a></li>
							<li><a href="elements.php">Federal Series</a></li>
						</ul>
					</li>
					<li><a href="elements.php">Flash Series</a></li>
					<li><a href="elements.php">COB Series</a></li>
				</ul>
			</li>
			<li><a href="elements.php">照明成品</a></li>
			<li><a href="elements.php">LED燈條</a></li>
		</ul>
	</section>
	<!-- proMenu end-->
<?php endif?>
