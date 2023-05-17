<!-- proMenu start-->
<section class="navlight" data-active="li" data-multimenu="true">
	<ul l="layer" ls="lll" class="proMenu togglearea" data-item="li" data-title="li>a" data-content="li>ul" data-nodefault="true">

		<li l="list"><a attr2="" >{/name/}</a>
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

		// recursive function
		if(!function_exists('renderMenu')){
			function renderMenu($items) {
				$render = '<ul>'."\n";

				foreach ($items as $item) {
					$render .= '<li id="navlight_'.$item->id.'" ';
					$render .= '><a href="'.$item->url.'">' . $item->name.'</a>'."\n";
					if (!empty($item->childs)) {
						$render .= renderMenu($item->childs);
					}
					$render .= '</li>'."\n";
				}

				return $render . '</ul>'."\n";
			}
		}

		$result = renderMenu($topLevel);
		$tmps = explode("\n", $result);
		// togglearea就是點下去展開，如果要換頁在展開，請拿掉它，或是直接使用promenu2
		$tmps[0] = '<ul class="proMenu togglearea" data-item="li" data-title="li>a" data-content="li>ul" data-nodefault="true">';
		$result = implode("\n", $tmps);
	?>
	<!-- proMenu start-->
	<section class="navlight" data-active="li" data-multimenu="true">
		<?php if(isset($result)):?>
			<?php echo $result?>
		<?php endif?>
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
