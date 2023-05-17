<div class="toplink">
	<a href="./"><img src="images/home.svg"></a>
	<?/* 搜尋 <a href=""><img src="images/search.svg"></a> */?>
	<?php if((isset($mls) and count($mls) > 1 || SIMPLE_TRANSLATE)):?>
		<div class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span><span class="caret"></span></a>
			<ul class="dropdown-menu">
				<?php foreach($mls as $k => $v):?>	
					<?php if($k == $this->data['ml_key']):?>
						<?php if($k=='tw' && SIMPLE_TRANSLATE):?>
							<li><a id="translateLink" href="javascript:translatePage();">简体</a></li>
						<?php else:?>										
							<li><a href="change_language.php?lang=<?php echo $k?>">[ <?php echo $v?> ]</a></li>		
						<?php endif?>
					<?php else:?>
						<li><a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a></li>
					<?php endif?>

				<?php endforeach?>
			</ul>
		</div>
	<?php endif?>
	<?php if(defined('GOOGLE_TRANSLATE') && GOOGLE_TRANSLATE):?>
		<div id="googleTransLate">
			<a>
				<div class="googleTranslate pc"></div>
			</a>        
		</div>
	<?php endif?>

</div>