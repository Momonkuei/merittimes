<?php //凌航版型，含產品比較功能，比較後連結到比較表頁面，只有PC版才會顯示比較功能?>
<?php //只有同類的產品才能進行比較，一次最多比較4個?>
<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>
        <div class="productListBlock productListStyle15">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6 col-xl-4 img-100 prd-series-item">
                        <div class="item-inner">
                            <div class="img-holder"> <img src="<?php echo $v['pic']?>" <?php if(isset($v['img_alt'])):?> alt="<?php echo $v['img_alt']?>" <?php endif?>> </div>
                            <div class="text">
                                <h3 class="fz-C"><?php echo $v['name']?>
                                    <!-- <br><br>
                                        OD 102 mm  -->
                                </h3>
                            </div>
                            <div class="btn-area"> <a href="<?php echo $v['url'] ?>" class="btn"><?php echo t('詳細內容')?></a> <a href="<?php echo $v['url_inquiry']?>" class="addItemAddCart btn add act-buy" pro-id="<?=$v['id']?>1" data-name="<?php echo $v['name2']?>" stand-id="0"><?php echo t('加入詢問')?></a> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?endforeach?>
<?endif?>