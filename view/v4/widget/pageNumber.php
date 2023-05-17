<?php // 2018-06-19 A方案專用?>
<?php // $data[$ID]=$pageRecordInfo?>

<?php //var_dump($data[$ID])?>
<?
$pageresult = $this->cidb->where('keyname','function_constant_page_number')->get('sys_config')->row_array();
$pagestyle=$pageresult["keyval"];
?>
<?php if(isset($data[$ID]) and !empty($data[$ID])):?>
	<div class="pageNumber">
		<?if($pagestyle==0){?>
			<ul>
				<?php if(isset($data[$ID]['prev_url'])):?>
					<?php if($data[$ID]['prev_url'] != ''):?>
						<li class="prev"><a href="<?php echo $data[$ID]['prev_url']?>"><?php echo t('Prev','en')?></a></li>
					<?php else:?>
						<li class="prev disabled"><a href="javascript:;"><?php echo t('Prev','en')?></a></li>
					<?php endif?>
				<?php endif?>
				<li><?php echo $data[$ID]['pagination']['control']['now']?></li>
				<li>/</li>
				<li><?php echo $data[$ID]['pagination']['control']['total']?></li>
				<?php if(isset($data[$ID]['next_url'])):?>
					<?php if($data[$ID]['next_url'] != ''):?>
						<li class="next"><a href="<?php echo $data[$ID]['next_url']?>"><?php echo t('Next','en')?></a></li>
					<?php else:?>
						<li class="next disabled"><a href="javascript:;"><?php echo t('Next','en')?></a></li>
					<?php endif?>
				<?php endif?>
			</ul>
		<?}
		else if($pagestyle==1){?>
			<ul>
			<?php
				if(isset($data[$ID]['prev_url'])){
					if($data[$ID]['prev_url'] != ''){
						echo '<a href="'.$data[$ID]["prev_url"].'"><li class=" pagebox"><i class="fa fa-angle-left"></i></li></a>';
					}else{
						echo '<a href="javascript:;"><li class="disabled pagebox"><i class="fa fa-angle-left"></i></li></a>';
					}
				}
			$totalpage=$data[$ID]['pagination']['control']['total'];
			$nowpage=$data[$ID]['pagination']['control']['now'];
			if($totalpage<=10){
				for($pagei=1;$pagei<=$totalpage;$pagei++){
					if($pagei==$nowpage){
						echo "<a href='".$data[$ID]["nopage_url"].$pagei."'><li class='pageselected pagebox pageselected'>".$pagei."</li></a>";
					}
					else{
						echo "<a href='".$data[$ID]["nopage_url"].$pagei."'><li class='pagebox '>".$pagei."</li></a>";
					}
				}
			}
			else{
				if($nowpage<5){
					$startpage=1;
					$endpage=10;
				}
				else{
					$startpage=$nowpage-4;
					$endpage=$nowpage+5;
					if($endpage>=$totalpage){
						$startpage=$totalpage-9;
						$endpage=$totalpage;
					}
				}
				for($pagei=$startpage;$pagei<=$endpage;$pagei++){
					if($pagei==$nowpage){
						echo "<a href='".$data[$ID]["nopage_url"].$pagei."'><li class='pageselected pagebox '>".$pagei."</li></a>";
					}
					else{
						echo "<a href='".$data[$ID]["nopage_url"].$pagei."'><li class='pagebox '>".$pagei."</li></a>";
					}
				}
			}
			if(isset($data[$ID]['next_url'])){
				if($data[$ID]['next_url'] != ''){
					echo '<a href="'.$data[$ID]['next_url'].'"><li class="pagebox"><i class="fa fa-angle-right"></i></li></a>';
				}else{
					echo '<a href="javascript:;"><li class="pagebox disabled"><i class="fa fa-angle-right"></i></li></a>';
				}
			}
			?>
		</ul>
		<?}
		?>
		
	</div><!-- .pageNumber -->
<?php endif?>
