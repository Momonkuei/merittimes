<?php if( empty($_COOKIE['gdprview']) ):?>
  <div class="gdprBlock">
			<div class="gdprBlock_cont">
				<div class="gdprBlockItem__lt" >
					<p class="gdprBlock__txt">我們使用 cookie 來提供我們網站上提供的服務和功能，並改善我們的用戶體驗。 使用本網站，即表示您同意使用 cookie。</p>
				</div>
				<div class="gdprBlockItem__rt" >
					<div class="GDPR__btnArea">
						<a href="javascript:void(0);" class="gdpr__Btn">OK</a>
						<a href="javascript:void(0);" class="gdpr__Closure">NO</a>
						<a href="privacy_<?=$this->data['ml_key']?>_1.php" class="gdpr__Link">隱私權政策</a>
						<!-- <a href="privacy.php" class="gdpr__Link">more information</a> -->
					</div>
				</div>
			</div>
	</div>
  <?php endif?>