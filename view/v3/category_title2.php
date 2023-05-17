<?php if(isset($data[$ID])):?>
	<?php
	$output = '';
	if(isset($data[$ID]['url']) and $data[$ID]['url'] != ''){
		$output = '<a href="'.$data[$ID]['url'].'" class="icon-link">';
	}
	$icon = 'fa fa-file-text-o';
	if(isset($data[$ID]['icon']) and $data[$ID]['icon'] != ''){
		$icon = $data[$ID]['icon'];
	}
	$output .= '<i class="'.$icon.'"></i>';
	if(isset($data[$ID]['text']) and $data[$ID]['text'] != ''){
		$output .= $data[$ID]['text'];
		$output .= '</a>';
	} else {
		$output = '';
	}
	?>
<?php endif?>

<?php if(isset($data[$ID]) && 0):?><?php // 2016-12-22 Winnie做的 //#38303 2020-12-20 ming說母版可以不需要顯示了 by lota?>
	<section class="Bbox_view">
		<div>
			<div>
				<div class="Bbox_flexBetween">			
					<div>
						<?php if(isset($data[$ID]['name']) and $data[$ID]['name'] != ''):?>
							<div class="blockTitle"><?php echo $data[$ID]['name']?></div>
						<?php endif?>
					</div>
					<div>
						<?php echo $output?>
					</div>

					<?php if(0):?>
						<div>
							<a href="" class="icon-link"><i class="fa fa-file-text-o"></i>附屬文字或連結</a>
						</div>
					<?php endif?>

				</div>
				<div>
					<?php if(isset($data[$ID]['sub_name']) and $data[$ID]['sub_name'] != ''):?>
						<div class="blockInfoTxt"><?php echo $data[$ID]['sub_name']?></div>
					<?php endif?>
				</div>
			</div>
		</div>
	</section>
<?php endif?>
