<?php if (isset($data[$this->data['router_method'] . '_describe']) && $data[$this->data['router_method'] . '_describe'] != '') : //這塊給需要顯示簡述的地方
?>
    <div><?php echo $data[$this->data['router_method'] . '_describe'] ?></div>
<?php endif ?>

<div class="newsList newsListType22">

    <?php if (isset($data[$ID])) : ?>
        <?php foreach ($data[$ID] as $k => $v) : ?>
            <div class="item item_list22">
                <!-- 圖片連結 -->
                <a class="col-xl-3  col-md-4 item_list22_imgLink" href="<?php echo $v['url1'] ?>">

                    <div class="imgBox imgHoverBox">
                        <div class="<?php echo $data['image_ratio']; //變數在source/core.php
                                    ?>  ">
                            <img src="<?php echo $v['pic'] ?>">
                        </div>
                    </div>
                    <!-- <div class="img-w100 imgHoverBox">
                        <img src="https://picsum.photos/id/20/800/800">
                    </div> -->
                </a>

                <!-- 標題&內文 -->
                <div class=" col-xl-7  col-md-5  item_list22_content">
                    <div class=" list-info ">
                        <a class="" href="<?php echo $v['url1'] ?>">
                            <div class="itemTitle">
                                <?php echo $v['name'] ?>
                            </div>
                        </a>


                        <div class="list_info_divider_block">

                        </div>
                        <div class="itemContent" data-txtlen="150"><?php echo $v['content'] ?></div>
                    </div>
                </div>


                <div class="col-xl-2  col-md-3  item_list22_dateStyle">

                    <div class="main-date-title">
                        <!-- 籃底白字方塊 -->
                        <div class="date-mark">
                            <span class="dateD"><?php echo $v['day'] ?></span>
                            <span class="dateM"><?php echo $v['month'] ?></span>
                        </div>
                        <!-- 年分與分類 -->
                        <div class="second-title-part">
                            <span class="dateY"><?php echo $v['year'] ?></span>
                            <div class="itemTitle">
                                <span><?php echo $v['name2'] ?></span>
                            </div>
                            <!-- 藍色底部線條 -->
                            <div class="second-title-mark"></div>

                            <!-- more 連結 -->
                            <div class="second-title ">
                                <div class="third-link">
                                    <a class="third-link-a_link" href="<?php echo $v['url2'] ?>">
                                        More<i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div><!-- .item -->
        <?php endforeach ?>
    <?php endif ?>
</div><!-- .newsList -->