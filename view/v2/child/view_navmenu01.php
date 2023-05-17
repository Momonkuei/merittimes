<!--    <a  class="btn dropdown" data-toggle="collapse" data-target=".navmenu01 .collapse" aria-expanded="false">
        <span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
    </a>
	-->
    <div class="navbar-collapse collapse">        
        <ul class="navbar-nav">
<?php echo $AA?>
		<?php if(0 and isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
				<?php if($v['url1'] == 'index.php?r=site/contact' and 0):?><?php continue?><?php endif?>
				<?php if(isset($v['field_tmp']) && preg_match('/1/i',$v['field_tmp'])): //這邊判斷後台的前台選單顯示區域是否開啟?>
					<?php $other1 = ($v['other1'])?$v['other1']:L::top(null,$v['topic'])?>					
           			<li <?php if(preg_match('/'.$this->data['router_method'].'/i',$v['url1']) && $this->data['router_method']!='index') echo 'class="active"'?>><a href="<?php echo $v['url1']?>" <?php if(isset($v['other2']) && $v['other2']) echo 'target="'.$v['other2'].'"'?>><span><?php echo L::top(null,$v['topic'])?></span><span><?php echo $other1?></span></a></li>
           		<?php endif?>
			<?php endforeach?>
		<?php endif?>
			<?php /*
			//單一型態 
			<li><a href="<?php echo $v['url1']?>"><?php echo G::t(null,$v['topic'])?><h6>English</h6></a></li>
			//滑動變換型態
			<li><a href="<?php echo $v['url1']?>"><span><?php echo G::t(null,$v['topic'])?></span><span><?php echo G::t(null,$v['topic'])?></span></a></li>	
            <li><a href=""><span>SERVICE</span><span>MENU 2</span></a></li>
            <li><a href=""><span>NEWS</span><span>MENU 3</span></a></li>
            <li><a href=""><span>MENU</span><span>MENU 4</span></a></li>
            <li><a href=""><span>FAQ</span><span>MENU 5</span></a></li>
            <li><a href=""><span>CONTACT</span><span>MENU 6</span></a></li>    
			*/?>
        </ul>
    </div>
