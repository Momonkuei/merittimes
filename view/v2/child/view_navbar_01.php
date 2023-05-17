<?php 
	$logo_img = 'images/logo_'.$this->data['ml_key'].'.png';
	//if(!is_file($logo_img)) $logo_img = 'images/index02/logo.png';
	if(!is_file($logo_img)) $logo_img = 'images/logo.png';
?>
    <div class="logo">
        <a href="./"><img src="<?php echo $logo_img?>" class=""></a>
    </div> 
	
    <div class="toplink">
        <ul>

		<?php if(isset($mls) and count($mls) > 1 || SIMPLE_TRANSLATE):?>
			<?php foreach($mls as $k => $v):?>
				<?php if($k == $this->data['ml_key']):?>
					<?php if($k=='tw' && SIMPLE_TRANSLATE):?>
						<li><a id="translateLink" href="javascript:translatePage();">简体</a></li>
					<?php else:?>
						<li><a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a></li>
					<?php endif?>
				<?php else:?>
					<li><a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a></li>
				<?php endif?>
			<?php endforeach?>  
		<?php endif?>

        <?php /*<li><a href=""><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span><span class="badge">0</span></a></li>*/?>

			<?php if(GOOGLE_TRANSLATE==true): //Google 翻譯器?>
			<li >
				<div class="googleTranslate pc"></div>
			</li>
			<?php endif?>

			<?php if(MEMBER_OPEN==true)://會員功能?>
			<?php if((isset($_SESSION['authw_admin_account']) && $_SESSION['authw_admin_account']!='')):?>
				<li><a href="index.php?r=member" >會員中心</a></li>
				<li><a href="index.php?r=member/logout" >會員登出</a></li>	
			<?php else:?>
				<li><a href="" data-toggle="modal" data-target=".login">會員登錄</a></li>
				<li><a href="index.php?r=guest/register" >會員註冊</a></li>
				<li><a href="index.php?r=guest/forget" >忘記密碼</a></li>
			<?php endif?>			
			<?php endif?>

        </ul>
    </div>
	

  <div class="sm text-center hidden-sm hidden-md hidden-lg">
        <a  class="btn dropdown" data-toggle="collapse" data-target=".Bbox_navbar_01 .sm nav" aria-expanded="false">
                <span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
        </a>
        <nav class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
                <li class="dropdown <?php if(stristr($v['url1'],$this->data['router_method']) && $this->data['router_method']!='index' ) echo ' active'?>" ><a href="<?php echo $v['url1']?>" <?php if(isset($this->data['menu_sub_'.$this->data['router_method']]) && $this->data['menu_sub_'.$this->data['router_method']]['method']==$this->data['router_method']):?>data-toggle="dropdown"<?php endif?>><?php echo L::top(null,$v['topic'])?></a>
				<?php if(isset($this->data['menu_sub_'.$this->data['router_method']]) && $this->data['menu_sub_'.$this->data['router_method']]['method']==$this->data['router_method']):?>
                    <ul class="dropdown-menu">
						<?php foreach($this->data['menu_sub_'.$this->data['router_method']]['menu'] as $k1 => $v1):?>
                        <li><a href="<?php echo $v1['url1']?>" <?php if($v['other2']) echo 'target="'.$v['other2'].'"'?>><?php echo L::top(null,$v1['topic'])?></a></li>
						<?php endforeach?>                        
                    </ul>
					<?php endif?>
                </li>
				<?php endforeach?>
			<?php endif?>
            </ul>
        </nav>
    </div>
    <nav class="normal">
        <ul class="">
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
            <li <?php if(stristr($v['url1'],$this->data['router_method']) && $this->data['router_method']!='index' ) echo 'class="active"'?>><a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
				<?php if(isset($this->data['menu_sub_'.$this->data['router_method']]) && $this->data['menu_sub_'.$this->data['router_method']]['method']==$v['url1']):?>
				<ul>
					<?php foreach($this->data['menu_sub_'.$this->data['router_method']]['menu'] as $k1 => $v1):?>
                        <li><a href="<?php echo $v1['url1']?>"><?php echo L::top(null,$v1['topic'])?></a></li>
					<?php endforeach?> 
				</ul>
				<?php endif?>
			</li>
			<?php endforeach?>
		<?php endif?>
        </ul>
    </nav>    


	<?php /* //備份用
    <div class="sm text-center hidden-sm hidden-md hidden-lg">
        <a  class="btn dropdown" data-toggle="collapse" data-target=".Bbox_navbar_01 .sm nav" aria-expanded="false">
                <span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
        </a>
        <nav class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown"><a href="#" data-toggle="dropdown">ABOUT</a>
                    <ul class="dropdown-menu">
                        <li><a href="">A次選單一</a></li>
                        <li><a href="">A次選單二</a></li>
                        <li><a href="">A次選單三</a></li>
                        <li><a href="">A次選單四</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#" data-toggle="dropdown">NEWS</a>
                    <ul class="dropdown-menu">
                        <li><a href="">B次選單一</a></li>
                        <li><a href="">B次選單二</a></li>
                        <li><a href="">B次選單三</a></li>
                        <li><a href="">B次選單四</a></li>
                    </ul>
                </li>
                <li><a href="">FAQ</a></li>
                <li><a href="">PRODUCTS</a></li>
                <li><a href="">CONTACT US</a></li>
            </ul>
        </nav>
    </div>
    <nav class="normal">
        <ul class="">
            <li><a href="">ABOUT</a>
                <ul>
                    <li><a href="">次選單一</a>
                        <ul>
                            <li><a href="">次次選單一</a></li>
                            <li><a href="">次次選單二</a>
                                <ul>
                                    <li><a href="">次次次選單一</a></li>
                                    <li><a href="">次次次選單二</a>
                                        <ul>
                                            <li><a href="">次次次次選單一</a></li>
                                            <li><a href="">次次次次選單二</a></li>
                                            <li><a href="">次次次次選單三</a></li>
                                            <li><a href="">次次次次選單四</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="">次次選單三</a></li>
                            <li><a href="">次次選單四</a></li>
                        </ul>
                    </li>
                    <li><a href="">次選單二</a></li>
                    <li><a href="">次選單三</a></li>
                    <li><a href="">次選單四</a></li>
                </ul>
            </li>
            <li><a href="">NEWS</a></li>
            <li><a href="">PRODUCTS</a></li>
            <li><a href="">FAQ</a></li>
            <li><a href="">CONTACT</a></li>
        </ul>
    </nav>    

	*/ ?>