			<section class="proDetail">
				<div>
					<?php // proDetail start ------ ?>
					<div>

<?php echo $AA?>
					<?php if(isset($data[$router_method.'_return_url'])):?>
						<div class="text-center">
							<a href="<?php echo $data[$router_method.'_return_url']?>" class="btn-cis1"><i class="fa fa-reply"></i><?php echo t('回列表')?></a>
						</div>
					<?php endif?>
					</div>
					<?php // proDetailend ------ ?>

				</div>
			</section>

<?php if(0)://2019-10-28 ruby?>
<section class="Bbox_1c">
	<div>
		<div>
		</div>
	</div>
</section>
<?php endif?>
