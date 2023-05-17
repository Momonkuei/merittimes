<section class="sectionBlock">

    <div class="download_list5">
        
        <div class="pageTitleStyle-2 text-center">
            <h2>Download</h2>
        </div>

        <ul class=" documentList row">
            <?php if (isset($data[$ID])) : ?>
                <?php foreach ($data[$ID] as $k => $v) : ?>
                    <li class="listContent col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="item row">
                            <a class="col-12 col-sm-6 imgLink" href="<?php echo $v['url1'] ?>">
                                <div class="imgBox ">
                                    <div class="imgBox_card-hover"></div>
                                    <?if(!empty($v['pic1'])){?>
                                        <img src="/_i/assets/upload/download/<?=$v['pic1']?>">
                                    <?}else{?>
                                        <img src="https://picsum.photos/id/486/390/500">
                                    <?}?>
                                </div>
                            </a>
                            <div class="content col-12 col-sm-6">
                                <div class="date">
                                    18 Jul 2022 <span class="date-line">|</span> News
                                </div>
                                <h3 class="title">
                                    2022 FULL COME CATALOG
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
                                                <a id="News-ssk-share-0" href="#"  target="_blank" class="ssk ssk-twitter">
                                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a id="News-ssk-share-0" href="#" target="_blank" data-method="facebookShare" class="face-share">
                                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a id="News-ssk-share-0" href="#"  target="_blank" class="ssk ssk-email">
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

</section>