
<?php if($this->data['editmode']):?>    

<?php endif?>









<div class="IndexNewsArea  [OTHER]" [STYLEPOS1]>
[POS1]                

			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<div class="IndexNewsArea_Item Bbox_in_2c_L3 margin_base_b">
						<div>
							<div>
								<a class="thumbnail " href="<?php echo $v['url']?>">
									<img src="<?php echo $v['pic']?>" class="img-responsive">
								</a>
							</div>
							<div>
								<div>
									<a href="<?php echo $v['url']?>">
										<h5><b><?php echo $v['name']?></b></h5>
										<p><?php echo mb_strimwidth(strip_tags($v['content']),0,28*2,'...','utf-8')?></p>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach?>
			<?php endif?>

			<?php if(0):?>
                <div class="IndexNewsArea_Item Bbox_in_2c_L3">
                    <div>
                        <div>
                            <a class="thumbnail " href="#_">
                                <img src="images/man1.jpg" class="img-responsive">
                            </a>
                        </div>
                        <div>
                            <div>
                                <a href=" ">
                                    <h5><b>高力芳照</b></h5>
                                    <p>＜ヨシモト・タダシ　1943年生まれ＞ 1964年に藤原啓 ...</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="IndexNewsArea_Item Bbox_in_2c_L3">
                    <div>
                        <div>
                            <a class="thumbnail " href="#_">
                                <img src="images/man1.jpg" class="img-responsive">
                            </a>
                        </div>
                        <div>
                            <div>
                                <a href=" ">
                                    <h5><b>高力芳照</b></h5>
                                    <p>＜ヨシモト・タダシ　1943年生まれ＞ 1964年に藤原啓 ...</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="IndexNewsArea_Item Bbox_in_2c_L3">
                    <div>
                        <div>
                            <a class="thumbnail " href="#_">
                                <img src="images/man1.jpg" class="img-responsive">
                            </a>
                        </div>
                        <div>
                            <div>
                                <a href=" ">
                                    <h5><b>高力芳照</b></h5>
                                    <p>＜ヨシモト・タダシ　1943年生まれ＞ 1964年に藤原啓 ...</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
			<?php endif?>
                        
</div>

<div>
        <p class="text-center">
            <a href="<?php echo $this->createUrl('site/product')?>" class="btn btn-default btn-sm" role="button">READ MORE</a>
        </p>
    </div>
