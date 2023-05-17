    <!--NAV START-->
    <nav class="navbar navbar-default [OTHER]" [STYLEPOS1] >
[POS1]
        <div class="container">
            <div class="row">       



                    <div class="navbar-header col-sm-1 text-center">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#head_navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>

                      <div class="navbar-brand"><a href="index.html">LOGO</a></div>
                      
                    </div>
                    
                        
                    <div class="col-sm-11 ">
                        <div class="collapse navbar-collapse" id="head_navbar">  

                            


                            <div class="col-sm-9">
								<ul class="nav navbar-nav" >
									<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
										<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
										<li <?php if('index.php?r='.$this->data['current_url'] == $v['url1']):?>class="active"<?php endif?> ><a href="<?php echo $v['url1']?>"><?php echo $v['topic']?></a></li>
										<?php endforeach?>
									<?php endif?>
								</ul>
                              
                            </div>


                            <div class="col-sm-3 navbar-right">
                                <ul class="nav navbar-nav text-right toplink">
                                    <li class="dropdown" style="display:none">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="index-full.html">滿版首頁</a></li>
                                            <li><a href="index.html">一般首頁</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="change_color.php?color=brown_coffee">BROWN COFFEE</a></li>
                                            <li><a href="change_color.php?color=blue_water">BLUE WATER</a></li>
                                            <li><a href="change_color.php?color=pink_lady">PINK LADY</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span><span class="caret"></span></a>
                                      <ul class="dropdown-menu">
										<?php if(isset($this->data['mls']) and count($this->data['mls']) > 0):?>
											<?php foreach($this->data['mls'] as $k => $v):?>
												<li><a href="change_language.php?lang=<?php echo $k?>"><?php echo $v?></a></li>
											<?php endforeach?>
										<?php endif?>
                                      </ul>
                                    </li> 
                                    <li><a href="contact.html"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a></li>
                                </ul>
                            </div>





                        </div>
                    </div>




            </div>
        </div>
    </nav>
    <!--NAV END-->
