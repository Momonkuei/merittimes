<?php // 會員登入後?>
<?php if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] != ''):?>
	<li <?php if($this->data['router_class'] == 'member'):?>class="active"<?php endif?> ><a href="<?php echo $this->createUrl('member/index')?>"><span aria-hidden="true" class="glyphicon glyphicon-user"></span></a></li>
	<li><a href="<?php echo $this->createUrl('member/logout')?>" class="btn-link">登出</a></li>
<?php endif?>
