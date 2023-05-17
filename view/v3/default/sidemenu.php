<?php 
	// $def_activeid = 'navlight_5'; //亮燈的id
	$link_act = 'false'; //true: 點了換頁(就像是以前的promenu2), false: 點了展開(就像是以前的promenu)
?>
<!-- sidemenu start-->
<section class="navlight" 
		data-active="li" 
		data-multimenu="true" 
		data-defactive="active" 

		<?php if(isset($this->data['func_name_sub_id'])):?>
			data-defactiveid="<?php echo $this->data['func_name_sub_id']?>"
		<?php endif?>
	>

	<ul l="layer" 
		ls="lll" 
		class="menuBlock togglearea" 
		data-item="li" 
		data-title="li>a" 
		data-content="li>ul" 
		data-nodefault="true" 
		data-prevent="<?php echo $link_act?>">

		<li l="list" attr1="" <?php if(0):?> idx="navlight_{/id/}" <?php endif?> ><a attr2="" >{/pic2_src/}{/name/}</a>
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
<!-- sidemenu end-->

