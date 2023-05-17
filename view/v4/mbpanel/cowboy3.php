<?php
$cowboy_mbPanel = array();
include 'source/system/mbpanel2.php';

foreach ($panel['mbPanelSet']['panels'] as $key => $value) {
	//上面	
	if($value['pos']=='navTop' && isset($panel['mbPanelDataSet'][$value['content']['data']])){
		$cowboy_mbPanel['cmpTop'] = $panel['mbPanelDataSet'][$value['content']['data']];
	}
	//下面
	if($value['pos']=='navBottom' && isset($panel['mbPanelDataSet'][$value['content']['data']])){
		$cowboy_mbPanel['cmpBottom'] = $panel['mbPanelDataSet'][$value['content']['data']];
	}
	//語系
	if($value['pos']=='mbPanel_left NavSubMenu' && isset($panel['mbPanelDataSet'][$value['content']['data']])){
		$cowboy_mbPanel['cmpLang'] = $panel['mbPanelDataSet'][$value['content']['data']];
	}
	//選單
	if($value['pos']=='mbPanel_left' && isset($panel['mbPanelDataSet'][$value['content']['data']])){
		$cowboy_mbPanel['cmpMenu'] = $panel['mbPanelDataSet'][$value['content']['data']];
	}

}
if(!function_exists('cowboy_menu_tree')){
	function cowboy_menu_tree($data,$str=''){

		if($_SERVER['REQUEST_URI'] == '/'.$data['link'] ){
			$data['class'] .=' active';
		}

		$str .= '<li><a href="'.$data['link'].'" class="'.$data['class'].'" >'.$data['content'].'</a>'."\r\n";

		if(is_array($data['submenu'])){
			$str .='<ul class="submenu">'."\r\n";

			$str .='<li><a href="javascript:;">'.t('回').$data['content'].'</a></li>'."\r\n";
			
			foreach ($data['submenu'] as $key => $value) {
				$str .= cowboy_menu_tree($value);
			}
			$str .='</ul>'."\r\n";
		}	
					
		$str .= '</li>'."\r\n";

		return $str;
	}
}
foreach($cowboy_mbPanel['cmpTop']['content'] as $k => $v){
	if($v['id']=='455' && isset($_SESSION['member_data'])){
		if($_SESSION['member_data']['member_grade']==1){
			$cowboy_mbPanel['cmpTop']['content'][$k]['attr2']='href="apply_'.$this->data['ml_key'].'_8.php" ';
		}else{
			$cowboy_mbPanel['cmpTop']['content'][$k]['attr2']='href="class_'.$this->data['ml_key'].'_1.php" ';
		}	
		$cowboy_mbPanel['cmpTop']['content'][$k]['content']=str_replace('<i class="fa fa-user"></i>','<i class="fa fa-user mb-icon-login"></i>',$v['content']);
	}
	
}
// print_r($cowboy_mbPanel['cmpTop']['content']);die;
?>
<?if($this->data['router_method'] != 'photocopyform_1'){?>
<div class="cowboy_mbPanel_3" <?php //style="display: block !important;"?>>

	<?php if(isset($cowboy_mbPanel['cmpTop'])):?>
		<div class="cmpTop">
			<?php foreach ($cowboy_mbPanel['cmpTop']['content'] as $key => $value):?>
				<div>
					<a <?php echo $value['attr2']?>>
						<?php echo $value['content']?>
					</a>
				</div>
			<?php endforeach?>	
		</div>
	<?php endif?>

	<div class="cmpContent">
		
		<?/*php if(isset($cowboy_mbPanel['cmpLang'])):?>
			<div class="cmpLang">
				<?php foreach ($cowboy_mbPanel['cmpLang']['content'] as $key => $value):?>
					<?php if(!isset($value['id'])):?>
						<a href="<?php echo $value['link']?>" <?php if($value['target']!=''):?>target="<?php echo $value['target']?>"<?php endif?> ><?php echo $value['content']?></a>
					<?php endif?>
				<?php endforeach?>				
			</div>
		<?php endif*/?>
		<div class="cmpLang">
			<?if(isset($_SESSION['member_data'])){?>
				<a href="memberlogout_<?=$this->data['ml_key']?>.php">登出</a>
			<?}else{?>
				<a href="guestlogin_<?=$this->data['ml_key']?>.php">登入/註冊</a>
			<?}?>
		</div>

		<div class="cmpMenu">
			<p><?php echo t('MENU')?></p>

			<ul class="cmpNav" data-pos="0">
				<?php 				
				foreach ($cowboy_mbPanel['cmpMenu']['content'] as $key => $value){
					if($key!=0){
						echo cowboy_menu_tree($value);
					}		
				}				
				?>				
			</ul>
		</div>
	</div>

	<div class="cmpFooter">
		<p>Email：<a href="mailto:newsmaster@merit-times.com.tw">newsmaster@merit-times.com.tw</a></p>
		<p>Tel：<a href="tel:+886-2-87877828">+886-2-8787-7828</a></p>
		<p><a href="https://goo.gl/maps/FWYoWASiyfcQTXo68" target="_blank">台北市信義區松隆路327號五樓</a></p>
		<p>Design by BLC</p>
	</div>

	<?php if(isset($cowboy_mbPanel['cmpBottom'])):?>
		<div class="cmpBottom">		
			<??>	
			<?php foreach ($cowboy_mbPanel['cmpBottom']['content'] as $key => $value):?>
				<?if($value['id']=='455' && (isset($_SESSION['member_data']) && !empty($_SESSION['member_data']))){
					$value['content']='<i class="fa fa-user"></i><span>登出 </span>';
					$value['attr2']='href="memberlogout_'.$this->data['ml_key'].'.php"';
				}?>
				<div>
					<a <?php echo $value['attr2']?>>
						<?php echo $value['content']?>
					</a>
				</div>
			<?php endforeach?>	
		</div>
	<?php endif?>

</div>



<script m="body_end">
	if($('.cowboy_mbPanel_3').length){
		$('.cmpBtn').click(function(){
			$(this).toggleClass('open');
			$('body').toggleClass('noscroll');
			$('.cmpContent, .cmpFooter, .cmpBottom').toggleClass('open');
		});

		$('.cmpBottom > div').css('width', 'calc(100% / ' + $('.cmpBottom > div').length + ')');

		$(window).on('load',function(){
			$('.cmpContent').css('bottom', $('.cmpFooter').outerHeight() + 50);
			
			$('.cmpNav a.active').parents('.submenu').siblings('a').addClass('active');
			$('.cmpNav .submenu').parent('li').addClass('moremenu');
			$('.cmpNav .submenu').siblings('a').removeAttr('href').attr('href', 'javascript:;');
		});

		$(window).on('load resize',function(){
			if(window.matchMedia('(max-width: 1024px)').matches){
				$('body').addClass('forcmp');
			} else {
				$('body').removeClass('forcmp');
			}
		});

		$('.cmpNav .submenu').siblings('a').click(function(event) {
			var pos = parseInt($('.cmpNav').attr('data-pos'));
			pos = pos - 100;

			$('.cmpNav').attr('data-pos', pos);
			$('.cmpNav').css('transform', 'translateX(' + pos + '%)');

			$('.cmpNav .submenu').removeClass('show');
			$(this).siblings('.submenu').addClass('show');
		});

		$('.cmpNav .submenu > li:first-child > a').click(function(event) {
			var pos = parseInt($('.cmpNav').attr('data-pos'));
			pos = pos + 100;

			$('.cmpNav').attr('data-pos', pos);
			$('.cmpNav').css('transform', 'translateX(' + pos + '%)');

			$('.cmpNav .submenu').removeClass('show');
			$(this).parents('.submenu').parents('.submenu').addClass('show');
		});
	}
</script>
<?}?>