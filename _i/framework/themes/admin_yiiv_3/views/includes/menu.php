<?php //var_dump($menus)?>
<?php if(!empty($menus) and $router_class != 'auth'):?>
<?php
	// 先處理一下，沒有子項的大項，刪掉(main跳過)
	foreach($menus as $k => $v){
		if($v['class'] != 'main'){
			$link_tmp = '';
			if($v['link'] != '' and $v['link'] != '#'){
				$link_tmp = $v['link'];
			}
			if($link_tmp == ''){
				$link_tmp = '#';
			}
			if(empty($submenus[$v['id']]) and $link_tmp == '#'){
				unset($menus[$k]);
			}
		}
	}

	// 重新編流水號
	$x = 0;
	$menus_tmp = array();
	foreach($menus as $k => $v){
		$menus_tmp[$x] = $v;
		$x++;
	}
	$menus = $menus_tmp;
	//var_dump($menus_tmp);

	foreach($menus as $k => $v){
		if($v['class'] == 'main'){
			if(isset($menus[$k+1]) and $menus[$k+1]['class'] == 'main'){
				unset($menus[$k]);
			}
		}
	}
?>
<div class="indexmenu00">
	<div class="menu_nav">
<?php
	foreach($menus as $k => $v){
		$enddata = end($menus);

		if($v['class'] == 'main'){
			// 如果大項是最後一筆，就取消顯示
			if($enddata['id'] == $v['id']){
				continue;
			}
			// 如果大項的下一筆也是大項，
			echo '</div>';
			echo '<div class="menu_nav">';
			echo '<h2>&nbsp;&nbsp;&nbsp;<span class="indexmenu02">'.$v['name'].'</span></h2>';
			continue;
		}

		$link_tmp = '';
		if($v['link'] != '' and $v['link'] != '#'){
			$link_tmp = $v['link'];
		}
		if($link_tmp == ''){
			$link_tmp = '#';
		}
		// 避免只有root層，而沒有子項，而root層又沒有連結的狀況下出現
		//if(isset($submenus[$v['id']])){
		//	echo count($submenus[$v['id']]);
		//}
		if(empty($submenus[$v['id']]) and $link_tmp == ''){
			continue;
		}
		$current_root_menu = '';
		if($v['id'] == $default_menu){
			$current_root_menu = 'target';
		}
?>
		<?php if($current_root_menu != ''):?>
			<div class="menu"> <span class="mtit_current"><?php echo $v['name']?></span><a href="<?php echo $link_tmp?>"></a>
		<?php else:?>
			<div class="menu"> <span class="mtit"><a href="<?php echo $link_tmp?>"><?php echo $v['name']?></a></span>
		<?php endif?>
<?php

		//if(!empty($submenus[$v['id']]) and $current_root_menu != ''){
		if(!empty($submenus[$v['id']])){
			// 子選單會跑兩次迴圈
			$current_sub_menu_showhide = 'none';
			foreach($submenus[$v['id']] as $kk => $vv){
				if($vv['id'] == $default_sub_menu){
					$current_sub_menu_showhide = 'block';
					continue;
				}
			}
?>
			<?php // 第2層開頭，目前沒有?>
<?php
			foreach($submenus[$v['id']] as $kk => $vv){
				if($vv['id'] == $default_sub_menu){
					$current_sub_menu = '_';	
				} else {
					$current_sub_menu = '';	
				}
?>
				<li style="display:<?php echo $current_sub_menu_showhide?>" class="menu_2nd<?php echo $current_sub_menu?>"><a href="<?php echo $vv['link']?>"><?php echo $vv['name']?></a></li>
<?php
			}
		} // if empty
?>
		</div>
<?php
	} // foreach
?>
	</div>
</div>
<img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/indexmenu_07.png" width="212" height="26" />
<?php
$tmpx = <<<XXX
$('.menu span a').click(function(){
	var thisa = $(this);
	if(thisa.attr('href') == 'javascript:;' || thisa.attr('href') == '#'){
	$('.menu_2nd').each(function(i,v){
		//if($(this).is(":visible")){
		//	$(this).hide();
		//}
	});
	thisa.parent().parent().find('.menu_2nd').each(function(i,v){
		$(this).toggle();
	});
	return false;
	}
});
XXX;
	Yii::app()->clientScript->registerScript('menu_footer', $tmpx, CClientScript::POS_READY);
?>
<?php endif;?>

<?php if(0):?>
<h2>&nbsp;&nbsp;&nbsp;<span class="indexmenu02"><a href="<?php echo $this->createUrl('auth/logout', array('current_base64_url'=> $current_base64_url))?>"><?php G::te($theme_lang, 'Logout', null, '登出')?></a></span></h2>
<div class="indexmenu00">
	<div class="menu_nav">
		<h2>&nbsp;&nbsp;&nbsp;<span class="indexmenu02">EOB後台管理選單</span></h2>
		<div class="menu"> <span class="mtit">使用者管理系統</span>
			<li class="menu_2nd"><a href="UserRecord.html">使用者登錄</a></li>
			<li class="menu_2nd_"><a href="EditUser.html">使用者管理</a></li>
		</div>
		<div class="menu"> <span class="mtit"><a href="Member.html" title="會員管理系統" class="indexmenu03">會員管理系統</a></span></div>
		<div class="menu"> <span class="mtit"><a href="Transaction.html" title="交易管理系統" class="indexmenu03">交易管理系統</a></span></div>
		<div class="menu"> <span class="mtit"><a href="EditBalance.html" title="帳務管理系統" class="indexmenu03">帳務管理系統</a></span></div>
		<div class="menu"> <span class="mtit"><a href="Payment.html" title="現金管理系統" class="indexmenu03">現金管理系統</a></span></div>
		<div class="menu"> <span class="mtit"><a href="Report.html" title="月結管理系統" class="indexmenu03">月結管理系統</a></span></div>
		<div class="menu"> <span class="mtit"><a href="YearTurnover.html" title="現金管理系統" class="indexmenu03">年報表管理系統</a></span></div>
		<br />
	</div>
	<div class="menu_nav">
		<h2>&nbsp;&nbsp;&nbsp;<span class="indexmenu02">TCO管理選單</span></h2>
		<div class="menu"> <span class="mtit"><a href="TCOwork.html" title="工作項目系統" class="indexmenu03">工作項目系統</a></span></div>
		<div class="menu"> <span class="mtit"><a href="DirectTrading.html" title="交易管理系統" class="indexmenu03">交易管理系統</a></span></div>
		<div class="menu"> <span class="mtit"><a href="ChangPassword.html" title="其他管理系統" class="indexmenu03">其他管理系統</a></span></div>
		<br />
	</div>
</div>
<img src="images/indexmenu_07.png" width="212" height="26" />
<?php endif;?>
