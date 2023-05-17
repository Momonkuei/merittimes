<?php if(0):?>
[POS1]
<?php endif?>


<div class="toplink">
	<div class="Bbox_1c">
		<div>
			<?php if(isset($this->data['mls']) and count($this->data['mls']) > 1 || SIMPLE_TRANSLATE):?>
				<?php foreach($this->data['mls'] as $k => $v):?>
					<?php if($k == $this->data['ml_key']):?>
						<?php if($k=='tw' && SIMPLE_TRANSLATE):?>
							<a id="translateLink" href="javascript:translatePage();">简体</a>
						<?php else:?>
							<a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a>
						<?php endif?>
					<?php else:?>
						<a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a>
					<?php endif?>
				<?php endforeach?>  
			<?php endif?>			
		</div>
	</div>
</div>


<?php /* //備份用
<div class="toplink">
	<div class="Bbox_1c">
		<div>
			<a href="">Link1</a>
			<a href="">Link1</a>
			<a href="">Link1</a>
		</div>
	</div>
</div>
*/?>
