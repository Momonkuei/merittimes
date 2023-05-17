<?php if (isset($data[$this->data['router_method'] . '_describe']) && $data[$this->data['router_method'] . '_describe'] != '') : //這塊給需要顯示簡述的地方
?>
    <div><?php echo $data[$this->data['router_method'] . '_describe'] ?></div>
<?php endif ?>


<?php
?>
<div class="container">

    <div class="newsList newsListType27">



        <div class="pageTitleStyle-2 text-center">
            <h2>LATEST NEWS</h2>
        </div>

        <ul class=" documentList row">
            <?php if (isset($data[$ID])) : ?>
                <?php foreach ($data[$ID] as $k => $v) : ?>
                    <li class="listContent col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="item row">
                            <a class="col-12 col-sm-6 imgLink" href="<?php echo $v['url1'] ?>">
                                <div class="imgBox ">
                                    <div class="imgBox_card-hover"></div>
                                    <img src="<?php echo $v['pic'] ?>">
                                </div>
                            </a>
                            <div class="content col-12 col-sm-6">
                                <div class="date">
                                    <?php echo $v['day'] ?> ><?php echo $v['month'] ?> <?php echo $v['year'] ?> <span class="date-line">|</span> News
                                </div>
                                <h3 class="title">
                                    <?php echo $v['name'] ?>
                                </h3>
                                <div class="downlandContent">
                                    <a href="<?php echo $v['url1'] ?>" class="downlandLink_btn">
                                        read the full article
                                        <i class="btn_underline color-1"></i>
                                        <i class="btn_underline btn_underline-hover color-2"></i>
                                    </a>

                                    <div id="News-share-0" class="mediaCard_share ">
                                        <button onclick="openList(event)" class="share_btn">
                                            <i class="fa fa-share-square fa-6 fa-lg " aria-hidden="true"></i>
                                        </button>
                                        <ul class="cardShare_links">
                                            <li>
                                                <a id="News-ssk-share-0" href="#" target="_blank" class="ssk ssk-linkedin">
                                                    <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a id="News-ssk-share-0" href="#" target="_blank" class="ssk ssk-twitter">
                                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a id="News-ssk-share-0" href="#" target="_blank" data-method="facebookShare" class="face-share">
                                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a id="News-ssk-share-0" href="#" target="_blank" class="ssk ssk-email">
                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>



    </div>
</div>