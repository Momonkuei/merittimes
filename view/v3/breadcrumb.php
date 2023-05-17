<div>
	<ul class="breadcrumb">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<li><a <?php if(isset($v['url']) and $v['url'] != ''):?> href="<?php echo $v['url']?>" <?php endif?> ><?php echo $v['name']?></a></li>
			<?php endforeach?>
		<?php endif?>
<?php if(0):?>
		<li dom="1"><a dom="f" href="{*url*}index.html">{*name*}HOME</a></li>
		<li><a href="">產品介紹</a></li>
		<li><a href="">產品介紹</a></li>
		<li><a>產品介紹</a></li>
<?php endif?>
	</ul>
</div>

<?php // 2018-08-06 A方案的麵包屑範例?>
<?php if(0 and $this->data['router_method'] != 'index'):?>
	<ul class="breadcrumbs" l="layer" ls="_breadcrumb">
		<li l="list"><a href="{/url/}">{/name/}</a></li>
	</ul>
<?php endif?>
