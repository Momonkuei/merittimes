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
			
			foreach ($data['submenu'] as $key => $value) {
				$str .= cowboy_menu_tree($value);
			}
			$str .='</ul>'."\r\n";
		}	
					
		$str .= '</li>'."\r\n";

		return $str;
	}
}

?>

<div class="cowboy_mbPanel_1" <?php //style="display: block !important;"?>>
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
		<?php if(isset($cowboy_mbPanel['cmpLang'])):?>
			<div class="cmpLang">
				<?php foreach ($cowboy_mbPanel['cmpLang']['content'] as $key => $value):?>
					<?php if(!isset($value['id'])):?>
						<a href="<?php echo $value['link']?>" <?php if($value['target']!=''):?>target="<?php echo $value['target']?>"<?php endif?> ><?php echo $value['content']?></a>
					<?php endif?>
				<?php endforeach?>				
			</div>
		<?php endif?>

		<div class="cmpMenu">
			<p><?php echo t('MENU')?></p>

			<ul class="cmpNav">
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
		<p>Email：<a href="mailto:service@buyersline.com">service@buyersline.com</a></p>
		<p>Tel：<a href="tel:+886-4-23178388">+886-4-2317-8388</a></p>
		<p><a href="https://goo.gl/maps/FWYoWASiyfcQTXo68" target="_blank">台中市西屯區寧夏路121路</a></p>
		<p>Design by BLC</p>
	</div>

	<?php if(isset($cowboy_mbPanel['cmpBottom'])):?>
		<div class="cmpBottom">			
			<?php foreach ($cowboy_mbPanel['cmpBottom']['content'] as $key => $value):?>
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
	if($('.cowboy_mbPanel_1').length){
		$('.cmpBtn').click(function(){
			$(this).toggleClass('open');
			$('body').toggleClass('noscroll');
			$('.cmpContent, .cmpFooter, .cmpBottom').toggleClass('open');
		});

		$('.cmpBottom > div').css('width', 'calc(100% / ' + $('.cmpBottom > div').length + ')');

		$(window).on('load',function(){
			$('.cmpContent').css('bottom', $('.cmpFooter').outerHeight() + 50);
			
			$('.cmpNav .submenu').parent('li').addClass('moremenu');
			$('.cmpNav .submenu').siblings('a').removeAttr('href').attr('href', 'javascript:;');

			$('.cmpNav .submenu').hide();
			$('.cmpNav a.active').parents('.submenu').siblings('a').addClass('active');
			$('.cmpNav a.active').addClass('open');
			$('.cmpNav a.active').siblings('.submenu').addClass('open').show();
		});

		$(window).on('load resize',function(){
			if(window.matchMedia('(max-width: 1024px)').matches){
				$('body').addClass('forcmp');
			} else {
				$('body').removeClass('forcmp');
			}
		});

		$('.cmpNav a').click(function(){
			$(this).toggleClass('open');
			$(this).siblings('.submenu').slideToggle(200);
			$(this).siblings('.submenu').toggleClass('open');
		});
	}
</script>