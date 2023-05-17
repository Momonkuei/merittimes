[POS1]
 <div data-toggle="collapse" data-target=".menu_s_view" aria-expanded="false" rulev1="1">        
            <p class="title text-center margin_sm_tb" style="cursor:pointer" rulev1="n"><?php echo $this->data['layoutv2'][$this->data['section']['key']]['topic']?><span class="caret hidden-md hidden-lg"></span></p>
        </div>                   

        <div class="menu_s_view collapse hidden-md hidden-lg">
            <div>
                <div>
                    <ul class="nav nav-pills nav-stacked" rulv1="1">
					<?php if(isset($this->data['lettle_menu'])):?>
						<?php foreach($this->data['lettle_menu'] as $k => $v):?>
                            <li class="active"><a href="<?php echo $this->createUrl('site/'.$this->data['router_method'],array('id'=>$v['id']))?>" rulv1="n"><?php echo $v['topic']?></a></li>
						<?php endforeach?>
					<?php endif?>
                     </ul>
                </div>
            </div>
        </div>

		<div>
			<?php echo $this->data['layoutv2'][$this->data['section']['key']]['detail']?>
		</div>