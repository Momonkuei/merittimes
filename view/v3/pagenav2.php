
<?php // 2018-06-19 A方案專用?>
<?php // $data[$ID]=$pageRecordInfo?>

<?php //var_dump($data[$ID])?>
<?php if(isset($data[$ID]) and !empty($data[$ID])):?>
	<section>
		<div class="Bbox_1c">
			<div>
				<div>
					<nav class="pageNav">
						<ul>
							<?php if(isset($data[$ID]['prev_url'])):?>
								<?php if($data[$ID]['prev_url'] != ''):?>
									<li class="prev"><a href="<?php echo $data[$ID]['prev_url']?>"><i class="fa fa-angle-left"></i></a></li>
								<?php else:?>
									<li class="prev disabled"><a href="javascript:;"><i class="fa fa-angle-left"></i></a></li>
								<?php endif?>
							<?php endif?>

							<li class="total"><a href="javascript:;" class="toggleBtn" data-target=".pageNav"><?php echo $data[$ID]['pagination']['control']['now']?> / <?php echo $data[$ID]['pagination']['control']['total']?></a></li>

							<?php if(isset($data[$ID]['pages']) and !empty($data[$ID]['pages'])):?>
								<?php foreach($data[$ID]['pages'] as $k => $v):?>
									<li <?php if($v['url'] == ''):?> class="active" <?php endif?> ><a <?php if($v['url'] == ''):?> href="javascript:;" <?php else:?> href="<?php echo $v['url']?>" <?php endif?> ><?php echo $v['name']?></a></li>
								<?php endforeach?>
							<?php endif?>

							<?php if(isset($data[$ID]['next_url'])):?>
								<?php if($data[$ID]['next_url'] != ''):?>
									<li class="next"><a href="<?php echo $data[$ID]['next_url']?>"><i class="fa fa-angle-right"></i></a></li>
								<?php else:?>
									<li class="next disabled"><a href="javascript:;"><i class="fa fa-angle-right"></i></a></li>
								<?php endif?>
							<?php endif?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
<?php endif?>

<?php if(0)://V1第二版的範例 2017-12-12?>

<!--
					<div class="flex4c" l="layer" ls="html:download" lp="pagenav:ggg---1---index_<\?php echo $this->data['ml_key']\?>.php?page=">
						<div l="list">
							<a href=""><div class="itemImg"><img src="<\?=$imgPath;\?>index-img-2.jpg"></div></a>
							<h4>設計</h4>		
							<p>歐洲最大光電產業先驅，擁有全世界超過18 個據點</p>					
						</div>
					</div>

	<section>
		<div class="Bbox_1c">
			<div>
				<div>
					<nav class="pageNav">
						<ul>
							<li class="prev" l="layer list" ls="ggg" lp="filter_key2:control.4"><a href="{/value/}"><i class="fa fa-angle-left"></i></a></li>						
							<li class="total" l="layer list" ls="ggg" lp="filter_key2:control.8"><a href="#_" class="toggleBtn" data-target=".pageNav">{/value/}</a></li>
							<li l="layer list" ls="ggg" lp="filter_key:number" class="{/active/}"><a href="{/value/}">{/name/}</a></li>
							<li class="next" l="layer list" ls="ggg" lp="filter_key2:control.2"><a href="{/value/}"><i class="fa fa-angle-right"></i></a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
-->

<?php endif?>

<?php if(0)://純靜態?>
<section>
	<div class="Bbox_1c">
		<div>
			<div>
				<nav class="pageNav">
					<ul>
						<li class="prev disabled" ><a href=""><i class="fa fa-angle-left"></i></a></li>						
						<li class="total"><a href="#_" class="toggleBtn" data-target=".pageNav">3 / 11</a></li>
						<li><a href="">1</a></li>
						<li><a href="">2</a></li>
						<li class="active"><a href="">3</a></li>
						<li><a href="">4</a></li>
						<li><a href="">5</a></li>
						<li><a href="">6</a></li>
						<li><a href="">7</a></li>
						<li><a href="">8</a></li>
						<li><a href="">9</a></li>
						<li><a href="">10</a></li>
						<li class="next"><a href=""><i class="fa fa-angle-right"></i></a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</section>
<?php endif?>
