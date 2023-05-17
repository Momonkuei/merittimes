<!-- // DATA_SINGLE -->
<?php $row = $data[$ID]?>

<!-- // DATA_MULTI -->
<?php $rows_big = $data[$ID]?>

<!-- // DATA_MULTI -->
<?php $rows_small = $data[$ID]?>

<!-- // DATA_SINGLE -->
<?php $row2 = $data[$ID]//用上面那個$row就好了?>

<script>
function switchImg($img,$img_b){
	$("#ShowImg img").attr("src", $img);
    $("#ShowImg a").attr("href",$img_b);
}
</script>
<div class="product_box2">
<div class="pro_des_img">
    <div class="pro_imb" id="ShowImg">
		<a href="<?php echo $rows_big[0]['pic']?>" class="fancybox-button" rel="fancybox-button">
         <img src="<?php echo $rows_big[0]['pic']?>" alt="<?php echo $row['name']?>" border="0" title="<?php echo $row['name']?>" />
       </a>
    </div>
<?
?>
    <div class="pro_imgs">
	<?php if($rows_small and count($rows_small) > 0):?>
		<?php foreach($rows_small as $k => $v):?>
			<?php if($k == 0):?>
				<a class="fancybox-button" rel="fancybox-button" href="<?php echo $rows_big[$k]['pic']?><?php //=$sBigPhoto?>">
				   <img src="<?php echo $v['pic']?><?php //=$sSmallPhoto?>"  onMouseOver="switchImg('<?php echo $rows_big[$k]['pic']?><?php //=$sPhoto?>','<?php echo $rows_big[$k]['pic']?><?php //=$sBigPhoto?>')" style="cursor:pointer;" rel="fancybox-button"/>
				</a>
			<?php else:?>
				<a class="fancybox-button" rel="fancybox-button" href="<?php echo $rows_big[$k]['pic']?><?php //=$startSizePhoto?>">
				   <img src="<?php echo $v['pic']?>" onMouseOver="switchImg('<?php echo $rows_big[$k]['pic']?><?php //=$otherPhoto?>','<?php echo $rows_big[$k]['pic']?><?php //=$startSizePhoto?>')" style="cursor:pointer;"  rel="fancybox-button"/>
				</a> 
			<?php endif?>
		<?php endforeach?>
	<?php endif?>
	</div>
</div><!-- pro_des_img -->

<div class="pro_detail"><h1><?php echo $row['name']?><?php //=$rowProduct->product_name?></h1>
	<?php echo $data[$ID]['name2']?>
	<?php //=$rowProduct->slogan?>

<br />
<?php $share_url = FRONTEND_DOMAIN.'/'.$this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$row['id']?>
<?php $share_title = $row['name']?>
<?php $share_size = ' width="32" height="32" '?>
<!-- I got these buttons from simplesharebuttons.com -->
<div id="share-buttons">
<!-- Facebook -->
<a href="http://www.facebook.com/sharer.php?u=<?php echo $share_url?>" target="_blank"><img src="http://www.simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" <?php echo $share_size?>/></a>
<!-- Twitter -->
<a href="http://twitter.com/share?url=<?php echo $share_url?>&text=<?php echo $share_title?>&hashtags=<?php echo $share_title?>" target="_blank"><img src="http://www.simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" <?php echo $share_size?>/></a>
<!-- Google+ -->
<a href="https://plus.google.com/share?url=<?php echo $share_url?>" target="_blank"><img src="http://www.simplesharebuttons.com/images/somacro/google.png" alt="Google" <?php echo $share_size?>/></a>
<!-- Digg -->
<a href="http://www.digg.com/submit?url=<?php echo $share_url?>" target="_blank"><img src="http://www.simplesharebuttons.com/images/somacro/diggit.png" alt="Digg" <?php echo $share_size?>/></a>
<!-- Reddit -->
<a href="http://reddit.com/submit?url=<?php echo $share_url?>&title=<?php echo $share_title?>" target="_blank"><img src="http://www.simplesharebuttons.com/images/somacro/reddit.png" alt="Reddit" <?php echo $share_size?>/></a>
<!-- LinkedIn -->
<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url?>" target="_blank"><img src="http://www.simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" <?php echo $share_size?>/></a>
<!-- Pinterest -->
<a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());"><img src="http://www.simplesharebuttons.com/images/somacro/pinterest.png" alt="Pinterest" <?php echo $share_size?>/></a>
<!-- StumbleUpon-->
<a href="http://www.stumbleupon.com/submit?url=<?php echo $share_url?>&title=<?php echo $share_title?>" target="_blank"><img src="http://www.simplesharebuttons.com/images/somacro/stumbleupon.png" alt="StumbleUpon" <?php echo $share_size?>/></a>
<!-- Email -->
<a href="mailto:?Subject=<?php echo $share_title?>&Body=I%20saw%20this%20and%20thought%20of%20you!%20 <?php echo $share_url?>"><img src="http://www.simplesharebuttons.com/images/somacro/email.png" alt="Email" <?php echo $share_size?>/></a>
</div> 

	<div class="inquiry_but">
		<form action="save.php" method="get">
			<input border="0"  src="ctt/images/temp_a/prod_inq.png" type="image" name="Image21" />
			<input type="hidden" name="amount" value="1" />
			<input type="hidden" name="primary_key" value="<?php echo $data[$ID]['id']?>" />
			<input type="hidden" name="id" value="productinquiry" />
			<input type="hidden" name="_append" value="" />
		</form>
	</div>

	<script type="text/jscript">
	<!--
	function Facebook() {
	　void(window.open('http://www.facebook.com/share.php?u=' .concat(encodeURIComponent(document.title)) .concat('  ') .concat(encodeURIComponent(location.href))));
	}
	function Plurk() {
	　void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('(') .concat(encodeURIComponent(document.title)) .concat(')')));
	}
	function Twitter() {
	　void(window.open('http://twitter.com/home/?status=' .concat(encodeURIComponent(document.title)) .concat('  ') .concat(encodeURIComponent(location.href))));
	}
	//-->
	</script>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher:'bc3c0177-66ac-414f-8e53-ff02798fa360'});</script>
	<table border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td><?php //=$lang_share_to?></td>
		<!--<td><span class='st_facebook' title="Facebook"></span></td>-->
		<td><a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));" style="margin-right:5px;"><img src="ctt/images/temp_a/ico_facebook.png" name="imageField" border="0" id="imageField" /></a></td>
		<td><a href="javascript:Plurk()" title="噗浪" style="text-decoration:none; color:#000"><img src="ctt/images/temp_a/ico_plurk.png" name="imageField" border="0" id="imageField" /></a></td>
	  </tr>
	</table>

</div>

<div class="pro_titdes"><h1>Trade Description</h1>
	<?php if($row['content1'] != ''):?>
		<div class="title_name"><h2><?php echo G::t(null,'商品說明')?></h2>
		<?php echo $row['content1']?></div>
	<?php endif?>
	<?php if($row['content2'] != ''):?>
		<div class="title_name"><h2><?php echo G::t(null,'商品規格')?></h2>
		<?php echo $row['content2']?></div>
	<?php endif?>
</div><!-- pro_titdes -->
<div class="back"><a href="javascript:history.back();"><img src="ctt/images/temp_a/ico_backlist.png" border="0"/></a></div>
</div>
<iframe name="hidFrame" width="0" height="0" style="display:none;"></iframe>
<p><?php //=$rowProduct->copyright?></p>

<?php if(0):?><!-- head_end -->
<!-- Arquivos utilizados pelo jQuery lightBox plugin -->
<script type="text/javascript" src="ctt/js/fancybox/jquery.fancybox.js?v=2.0.6"></script>
<link rel="stylesheet" type="text/css" href="ctt/js/fancybox/jquery.fancybox.css?v=2.0.6" media="screen" />
<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="ctt/js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
<script type="text/javascript" src="ctt/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="ctt/js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.2" />
<script type="text/javascript" src="ctt/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.2"></script>
<!-- Add Media helper (this is optional) -->
<script type="text/javascript" src="ctt/js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.0"></script>

<!-- / fim dos arquivos utilizados pelo jQuery lightBox plugin -->
<script type="text/javascript">
	$(document).ready(function() {
	$(".fancybox-button").fancybox({
		prevEffect		: 'none',
		nextEffect		: 'none',
		closeBtn		: false,
		helpers		: {
			title	: { type : 'inside' },
			buttons	: {}
		}
	});
});
</script>
<?php endif?><!-- head_end -->
