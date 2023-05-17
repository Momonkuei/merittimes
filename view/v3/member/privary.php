<div id="memberPrivacy" class="popBox">
	<div class="closeSpace closeBtn" data-target="#memberPrivacy"></div>
	<div class="boxContent">
		<a href="#_" class="closeBtn" data-target="#memberPrivacy"><i class="fa fa-times"></i></a>
		<div class="mainContent">
		<?php //2020-12-28 改為新資料流
			$_row1 = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','shoparticle5')->get('html')->row_array();
			if(isset($_row1['detail']) && $_row1['detail']!=''):?>
				<?php echo $_row1['detail']?>
			<?php endif?>
		</div>
	</div>
</div>
