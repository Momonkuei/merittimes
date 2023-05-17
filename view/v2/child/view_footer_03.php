<section class="Bbox_1c">
    <div>
        <div class="Bbox_in_2c_L3">
            <div>
			<?php 
				$logo_img = 'images/logo2_'.$this->data['ml_key'].'.png';
				if(!is_file($logo_img)) $logo_img = 'images/logo.png';
			?>
                    <div class="logo"><a href="./"><img src="<?php echo $logo_img?>"></a></div>
					<div class="copylink">


								<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):
									$i=0;
									$ii = count($this->data['layoutv2'][$this->data['section']['key']]);
										foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):
								?>
									<?php //if($i==0 || $ii < 6) echo '<div>'?>
										<li><a href="<?php echo $v['url1']?>"><?php echo G::t(null,$v['topic'])?></a></li>
									<?php //if($i==1 || $ii < 6) echo '</div>'?>
									<?php //if($i==0) $i++; else $i=0;?>
									
									<?php endforeach?>
								<?php endif?>



								<?php /*
					                    <div><p><a href="">Link 1</a></p><p><a href="">Link 2</a></p></div>
					                    <div><p><a href="">Link 1</a></p><p><a href="">Link 2</a></p></div>
					                    <div><p><a href="">Link 1</a></p><p><a href="">Link 2</a></p></div>
					                    <div><p><a href="">Link 1</a></p><p><a href="">Link 2</a></p></div>
									*/?>



					</div>

			
            </div>
        </div>                
    </div>
</section>

<div>
    <p class="copyright text-center"><?php if(isset($this->data['sys_configs']['footer_'.$this->data['ml_key']])) echo $this->data['sys_configs']['footer_'.$this->data['ml_key']]; else '© YOURNAME. All rights reserved.';?>　<a href="http://buyersline.com.tw">網頁設計</a> 百邇來</p>
</div> 


<?php /* 備份用
<div>
    <p class="copyright text-center">© YOURNAME. All rights reserved.　<a href="http://buyersline.com.tw">網頁設計</a> 百邇來</p>
</div> 
*/ ?>