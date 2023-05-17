<div class="Bbox_full_1c  margin_base_b interval01">
	<div>
		<div class=" ">
	<div class="Bbox_in_1c  ">
	<div>
		<div class=" ">
	

		
				

            <?php foreach($this->data['scope'] as $k => $v):?>	
				<article class="Bbox_sin_1c_2cL5">

				<div style="border:1px solid #eee;padding-top: 10px;">

				<? if($v['detail']): ?>
					<div>						
						<?php echo $v['detail'];?>
					</div>
				<? endif ?>
					<div class="scope_box">	


						<p class="title-cc"><?php echo $v['topic']?></p>

                        <div class="scope_date">
				<? if($v['url1']): ?>
                        <?php echo $v['url1'];?><br/>
				<? endif ?>
				<? if($v['other1']): ?>
                        TEL：<?php echo $v['other1'];?><br/>
				<? endif ?>
				<? if($v['other2']): ?>
                        FAX：<?php echo $v['other2'];?><br/>
				<? endif ?>
				<? if($v['other3']): ?>
                        E-MAIL：<?php echo $v['other3'];?>
				<? endif ?>
                        </div>


						
					</div>

				</div>

				</article>					
			<?php endforeach?>

				
<?/*
				<article class="Bbox_sin_1c_2cL5">

				<div style="border:1px solid #eee;padding-top: 10px;">

					<div>

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3635.8907690888796!2d120.72908813174864!3d24.31544490610691!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34691ab6857ed48b%3A0x8eb1b4d2228bd28e!2z5YSq6IKv56eR5oqA6IKh5Lu95pyJ6ZmQ5YWs5Y-4!5e0!3m2!1szh-TW!2stw!4v1464332929381" width="100%" min-height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
						
					</div>

					<div class="scope_box">	


						<p class="title-cc">臺北辦事處‧優肯科技股份有限公司</p>

                        <div class="scope_date">                        
                        臺灣42152台中市中部科學園區后里區后科南路26號<br/>
                        TEL：886-4-25591351~9<br/>
                        FAX：886-4-25591362<br/>
                        E-MAIL：ucan@u-can.com.tw ; ucandyna@ms36.hinet.net
                        </div>

						
					</div>

				</div>

				</article>
*/?>
			
		
</div>

	</div>
</div>
</div>

	</div>
</div>