<?php if (isset($data[$this->data['router_method'] . '_describe']) && $data[$this->data['router_method'] . '_describe'] != '') : //這塊給需要顯示簡述的地方
?>
    <div><?php echo $data[$this->data['router_method'] . '_describe'] ?></div>
<?php endif ?>


<?php
?>

<div class="newsList newsListType26">

    <div class="newsListType26_header">
        <div class="pageTitleStyle-2 text-center">
            <p class="newsListType26_top-secondMark">關於我們</p>
            <h2>LATEST NEWS</h2>
        </div>
    </div>

    <div class="itemList  Bbox_in_1c">
        <ul class="row">
        <?php if (isset($data[$ID])) : ?>
            <?php foreach ($data[$ID] as $k => $v) : ?>
                    <li class="col-12 col-lg-4 col-md-6 ">
                        <div class=" newsListType26_box">
                            <a class="item" href="<?php echo $v['url2'] ?>">
                                <!-- 日期標題 -->
                                <div class="dateStyle_3 newsListType26_box_dateStyle">
                                    <div class="main">
                                        <span class="dateD"><?php echo $v['day'] ?></span>
                                    </div>
                                    <div class="second">
                                        <span class="dateD"><?php echo $v['month'] ?></span>
                                        <small class="dateM"><?php echo $v['year'] ?></small>
                                    </div>
                                </div>
                                <!-- 內容 -->
                                <div class="item-content">
                                    <div class="item-content-main">
                                        <div class="itemTitle">
                                            <h3><?php echo $v['name'] ?></h3>
                                        </div>
                                        <div class="item-content-main-contect">
                                            <?php echo $v['content'] ?>
                                        </div>
                                        <div class="item-content-main-btn">
                                            <span>
                                                Read More
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </li>

                <?php endforeach ?>
            <?php endif ?>
        </ul>

    </div>

</div>