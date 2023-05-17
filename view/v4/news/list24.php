<?php if (isset($data[$this->data['router_method'] . '_describe']) && $data[$this->data['router_method'] . '_describe'] != '') : //這塊給需要顯示簡述的地方
?>
    <div><?php echo $data[$this->data['router_method'] . '_describe'] ?></div>
<?php endif ?>


<?php
//newsListType23 為最新消息兩欄式 newsListType24 為最新消息三欄式、無分類 ，雙方樣式相同只差欄位量與有無分類
?>
<div class="newsList newsListType23">

    <div class="itemList  Bbox_in_1c ">
        <div class="row">
            <?php if (isset($data[$ID])) : ?>
                <?php foreach ($data[$ID] as $k => $v) : ?>

                    <div class="col-12 col-md-6 col-xl-4 ">
                        <a class="item" href="<?php echo $v['url2'] ?>">

                            <!-- 日期標題 -->
                            <div class="dateStyle_3 newsListType23_dateStyle">
                                <span class="dateD"><?php echo $v['day'] ?></span>
                                <small class="dateM"><?php echo $v['month'] ?></small>
                            </div>
                            <!-- 內容 -->
                            <div class="item-content">

                                <div class="item-content-main">
                                    <div href="<?php echo $v['url2'] ?>">
                                        <div class="itemTitle"> <span><?php echo $v['name'] ?></span> </div>

                                    </div>
                                </div>
                                <div class="item-content-subtitle">

                                    <div class="item-content-subtitle-dateStyle">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <span class="dateY"><?php echo $v['year'] ?>.<?php echo $v['month'] ?>.<?php echo $v['day'] ?></span>
                                    </div>
                                </div>
                                <div class="item-content-border"></div>
                            </div>
                        </a>
                    </div>

                <?php endforeach ?>
            <?php endif ?>
        </div>

    </div>

</div>