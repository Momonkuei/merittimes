<?php if (isset($data[$this->data['router_method'] . '_describe']) && $data[$this->data['router_method'] . '_describe'] != '') : //這塊給需要顯示簡述的地方
?>
    <div><?php echo $data[$this->data['router_method'] . '_describe'] ?></div>
<?php endif ?>


<div class="newsList newsListType25">

    <div class="row ">

        <?php if (isset($data[$ID])) : ?>
            <?php foreach ($data[$ID] as $k => $v) : ?>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <article class="newsListType25_box">
                        <div class="imgBox ">
                            <a href="<?php echo $v['url1'] ?>">
                                <div class="<?php echo $data['image_ratio']; //變數在source/core.php
                                            ?>  imgHoverBox">
                                    <img src="<?php echo $v['pic'] ?>">
                                </div>
                            </a>
                        </div>
                        <div class="newsListType25_box_body">
                            <div class="newsListType25_box_body-classMark">
                                <a class="second-title" href="<?php echo $v['url1'] ?>">
                                    <?php echo $v['name2'] ?>
                                </a>

                                <? if (!empty($v['day']) && !empty($v['month'])) { ?>
                                    <a class="second-date" href="<?php echo $v['url1'] ?>">
                                        <span class="dateD"><?php echo $v['day'] ?></span>
                                        <span class="dateM"><?php echo $v['month'] ?></span>
                                    </a>
                                <? } ?>
                            </div>
                            <div class="newsListType25_box_body-content">

                                <h5 class="heading">
                                    <a href="<?php echo $v['url1'] ?>"><?php echo $v['name'] ?>
                                    </a>
                                </h5>
                                <p class="text"><?php echo $v['content'] ?></p>
                            </div>
                            <a class="newsListType25_box_body-link" href="<?php echo $v['url1'] ?>">
                                Read More<i class="fa fa-angle-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>