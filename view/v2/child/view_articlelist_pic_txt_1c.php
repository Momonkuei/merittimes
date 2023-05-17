

<div class="IndexNewsArea  [OTHER]" [STYLEPOS1]>

[POS1]                

                <div class="IndexNewsArea_Item Bbox_in_1c">

                    <div>
							<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['pic'])):?>
                        <div>

                            <a class="thumbnail " href="#_">

								

								<img src="<?php echo $this->data['layoutv2'][$this->data['section']['key']]['pic']?>" class="img-responsive">

								

                            </a>

                        </div>
							<?php endif?>
                        <div>

                            <div>

                                <a href="#">

									<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['content'])):?>

										<p><?php echo $this->data['layoutv2'][$this->data['section']['key']]['content']?></p>

									<?php endif?>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>



               

                        

</div>



<div>

        <p class="text-center">

			<a href="<?php echo $this->createUrl('site/company')?>" class="btn btn-default btn-sm" role="button">READ MORE</a>

        </p>

    </div>

