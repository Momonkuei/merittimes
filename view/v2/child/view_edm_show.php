[POS1]
<div>
			<div class="Bbox_in_3c">
				<div>

					<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
						<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
							<!---1個分類 Start-->
							<div class="Bbox_in_1c prolist margin_base_tb">
								<div>
									<div>
										<div class="thumbnail edm_pic">
										<?php if($v['pic1']):?>
											<a href="<?php echo $v['url']?>" target="_BREAK">
												<img src="<?php echo $v['pic']?>" alt="<?php echo $v['topic']?>" class="img-responsive">
											</a>
										<?php endif ?>
										</div>
									</div>
									<div>
										<div class="box_pro_list_txt">
											<a href="<?php echo $v['url']?>"  target="_BREAK"><h5><?php echo $v['topic']?></h5></a>
											<?php if($v['other1']!=''):?>
											<a href="<?php echo $v['other1']?>" target="_BREAK"><div class="col-md-12 btn-primary borderradius_5">檔案下載</div></a>
                                            <?php endif?>
										</div>
									</div>
								</div>
							</div>
							<!---1個分類 END-->
						<?php endforeach?>
					<?php endif?>

				</div>
			</div>
		</div>
		<?php echo $this->renderPartial('//include/_pagi_has_id_nofoor', $this->data)?>
