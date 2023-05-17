<?php // 這支檔案，是分校的功能列表選單，會出現在兩個地方，校區管理的分校修改頁面的左上方，和分校首頁的左邊 ?>

<?php if(!empty($admin_sub_menus)):?>
	<aside id="sidebar" class="grid_3 pull_9">
		<div class="box menu">
		<h2><?php if(isset($updatecontent['name']) and $router_class == 'school'):?><?php echo $updatecontent['name']?>功能<?php endif?><?php if(isset($submenu_title)):?><?php echo $submenu_title?><?php endif?></h2>
			<section>
				<ul>
					<?php foreach($admin_sub_menus as $k =>$v): ?>
						<?php $this->BeginWidget('system.widgets.Gw_acl', array('class' => str_replace('backend.php?', '', $v['link'])))?>
							<li><a href="<?php echo $v['link']?>"><?php echo $v['name']?></a></li>	
						<?php $this->EndWidget('system.widgets.Gw_acl')?>
					<?php endforeach?>
				<ul>
			</section>
		</div>
	</aside>
<?php endif?>
