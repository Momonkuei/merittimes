<li <?php if(preg_match('/^shoppingcar/', $this->data['router_class'])):?>class="active"<?php endif?> >
	<a href="<?php echo $this->createUrl('shoppingcar/index')?>">
	<span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span>
	<span class="badge"><?php if(isset($_SESSION['productshop']) and count($_SESSION['productshop']) > 0):?><?php echo count($_SESSION['productshop'])?><?php else:?>0<?php endif?> </span></a>
</li>
