<div id="loginPanel_pwd" class="loginPanel_pwd popBox">
	<div class="closeSpace closeBtn" data-target="#loginPanel_pwd"></div>
	<div class="boxContent">
		<a href="#_" class="closeBtn" data-target="#loginPanel_pwd"><i class="fa fa-times"></i></a>
		<div class="mainContent">
			
			<div class="">
				
				<div class="userLogin">
					<div class="boxTitle"><?php echo t('登入')?></div>
					<section class="">
						<form action="media.php" method="post" name="memberForm" id="memberForm" >
							<div class="formItem">
								<label class="must"><?php echo t('密碼')?></label>
								<input type="password" name="login_password" id="<?php echo t('密碼')?>" placeholder="Password" />
							</div>	
												
							<div class="formItem oneLine">
								<button><i class="fa fa-user"></i><?php echo t('登入')?></button> 
								<?php if(0):?>
								<a class="icon-link" href="member.php?type=forgot"><i class="fa fa-lock"></i><?php echo t('忘記密碼')?></a>
								<?php endif?>
							</div>
						</form>
					</section>
					
				</div>
				
			</div>

		</div>
	</div>
</div>
