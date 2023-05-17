<?php $row_inherit_start = $row_inherit_end = '';include 'view/system/row_inherit.php'?>

<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>
		<?php echo $row_inherit_start?>
			<?php if($v['pic1'] != ''):?>
				<a href="javascript:;">
					<div class="itemImg img-rectangle itemImgHover hoverEffect1">
						<img src="_i/assets/upload/<?php echo $this->data['router_method']?>/<?php echo $v['pic1']?>" alt="<?php echo $v['name']?>"  onerror="javascript:this.src='images_v4/default.png';img.onerror=null;">
					</div>
				</a>
			<?php endif?>
			<div class="subBlockTitle"><?php echo $v['name']?></div>
			<ul class="listStyle_faicon">
				<li><i class="fa fa-map-marker" aria-hidden="true"></i><a href="<?php echo $v['address_url']?>" target="_blank"><?php echo $v['url1']?></a></li>
				<?php if(isset($v['phone']) and $v['phone'] != ''):?><li><i class="fa fa-phone" aria-hidden="true"></i><?php echo $v['phone']?></li><?php endif?>
				<?php if(isset($v['fax']) and $v['fax'] != ''):?><li><i class="fa fa-fax" aria-hidden="true"></i><?php echo $v['fax']?></li><?php endif?>
				<?php if(isset($v['email']) and $v['email'] != ''):?><li><i class="fa fa-envelope" aria-hidden="true"></i><a href="<?php echo $v['email_url']?>"><?php echo $v['email']?></a></li><?php endif?>
				<?php if(isset($v['website_url']) and $v['website_url'] != ''):?><li><i class="fa fa-external-link-square" aria-hidden="true"></i><a href="<?php echo $v['website_url']?>" target="_blank"><?php echo $v['website_url']?></a></li><?php endif?>
			</ul>
		<?php echo $row_inherit_end?>
	<?php endforeach?>
<?php endif?>

<?php if(0)://下面為新增的區塊，有需要的時候再處理?>

<div class="locationContent">

  <section class="sectionBlock">
    <div class="container">

      <div class="pageTitleStyle-1">
        <span>LOCATION</span>
      </div>
      <p>此段文字非正式文字，他青法從神響、代大手北，樂的信下真登老學甚有球又學不看路。是資兒家是現，遊識夠成到調合不王同原明著輕外這起坐心集集沒以在的有臺，了位青間年口能樹人汽修研不條家密度連喜早元出力原居。</p>

      <div class="innerBlock">
        <div class="pageTitleStyle-3">
          <span>中部地區</span>
        </div>
        <p>中部地區各分店訊息，這裡是簡述，以下文字為非正式文字，區到環氣求果那出，層學水離，去業帶談計業調動無經，如亞路場、意象長而把！天任問喜己強程電然的對他顧讀常。中部地區各分店訊息，這裡是簡述，以下文字為非正式文字，區到環氣求果那出，層學水離，去業帶談計業調動無經，如亞路場、意象長而把！天任問喜己強程電然的對他顧讀常。</p>

        <div class="spaceList">
          <div class="row">
            <?php for ($i=0; $i < 4; $i++) {?>
            <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="subBlockTitle">西屯店</div>
              <ul class="listStyle_faicon">
                <li><i class="fa fa-map-marker" aria-hidden="true"></i><a href="" target="_blank">台中市文心路三段155-1號3F</a></li>
                <li><i class="fa fa-phone" aria-hidden="true"></i>04-2317-8388</li>
                <li><i class="fa fa-fax" aria-hidden="true"></i>04-2316-8668</li>
                <li><i class="fa fa-envelope" aria-hidden="true"></i>service@buyersline.com.tw</li>
                <li><i class="fa fa-external-link-square" aria-hidden="true"></i><a href="" target="_blank">www.buyersline.com.tw</a></li>
              </ul>
            </div>
            <?}?>
          </div>
        </div><!-- .spaceList -->
      </div><!-- .innerBlock -->

      <div class="innerBlock">
        <div class="pageTitleStyle-3">
          <span>中部地區</span>
        </div>
        <p>中部地區各分店訊息，這裡是簡述，以下文字為非正式文字，區到環氣求果那出，層學水離，去業帶談計業調動無經，如亞路場、意象長而把！天任問喜己強程電然的對他顧讀常。中部地區各分店訊息，這裡是簡述，以下文字為非正式文字，區到環氣求果那出，層學水離，去業帶談計業調動無經，如亞路場、意象長而把！天任問喜己強程電然的對他顧讀常。</p>

        <div class="spaceList">
          <div class="row">
            <?php for ($i=0; $i < 4; $i++) {?>
            <div class="col-lg-3 col-md-4 col-sm-6">
              <a href="productsdetail.php">
                <div class="itemImg img-rectangle itemImgHover hoverEffect1">
                  <img src="https://via.placeholder.com/800x600" alt="">
                </div>
              </a>
              <div class="subBlockTitle">北屯店</div>
              <ul class="listStyle_faicon">
                <li><i class="fa fa-map-marker" aria-hidden="true"></i><a href="" target="_blank">台中市文心路三段155-1號3F</a></li>
                <li><i class="fa fa-phone" aria-hidden="true"></i>04-2317-8388</li>
                <li><i class="fa fa-fax" aria-hidden="true"></i>04-2316-8668</li>
                <li><i class="fa fa-envelope" aria-hidden="true"></i>service@buyersline.com.tw</li>
                <li><i class="fa fa-external-link-square" aria-hidden="true"></i><a href="" target="_blank">www.buyersline.com.tw</a></li>
              </ul>
            </div>
            <?}?>
          </div>
        </div><!-- .spaceList -->
      </div><!-- .innerBlock -->

    </div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .locationContent -->

<?php endif?>