<?
include _BASEPATH . '/../source/class/post_12.php';
?>
<section class="sectionBlock sectionBlock-classweb" data-about="1">
    <div class="container">
        <div class="class-web">
            <main class="main-page">
                <!-- heroPage -->
                <section class="heroPage">
                    <img src="<?= $data_path ?>/<?= $class_data['pic1'] ?>" alt="heroPage-photo">
                    <div class="heroPage-content">
                        <h1 class="heroPage-title">
                            <?= $class_data['pic_name'] ?>
                        </h1>
                        <p class="heroPage-txt">
                            <?= $class_data['pic_description'] ?>
                        </p>
                    </div>
                </section>
                <div class="class-border">
                    <!-- 相片成果 -->
                    <section class="class-photo-album">
                        <div class="class-title">
                            相片成果
                        </div>
                        <? if (!empty($pic_list)) { ?>
                            <section class="sectionBlock cowboyAbout_1" data-about="13.5">
                                <div class="row">
                                    <? foreach ($pic_list as $k => $v) { ?>
                                        <div class="col-lg-4">
                                            <div class="ca1">
                                                <a href="<?= $data_path ?>/<?= $v['pic1'] ?>" data-fancybox="group_2">

                                                    <img src="<?= $data_path ?>/<?= $v['pic1'] ?>" alt="">
                                                    <div class="ca1_cover">
                                                        <div class="subBlockTitle"><?= $v['name'] ?></div>
                                                        <p><?= $v['field_data'] ?></p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            </section><!-- .sectionBlock -->
                        <? } ?>
                        <? if (!empty($pageRecordInfo['pagination'])) { ?>
                            <div class="pageNumber">
                                <ul>
                                    <?php if (isset($pageRecordInfo['prev_url'])) : ?>
                                        <?php if ($pageRecordInfo['prev_url'] != '') : ?>
                                            <li class="prev"><a href="<?php echo $pageRecordInfo['prev_url'] ?>"><?php echo t('Prev', 'en') ?></a></li>
                                        <?php else : ?>
                                            <li class="prev disabled"><a href="javascript:;"><?php echo t('Prev', 'en') ?></a></li>
                                        <?php endif ?>
                                    <?php endif ?>
                                    <li><?php echo $pageRecordInfo['pagination']['control']['now'] ?></li>
                                    <li>/</li>
                                    <li><?php echo $pageRecordInfo['pagination']['control']['total'] ?></li>
                                    <?php if (isset($pageRecordInfo['next_url'])) : ?>
                                        <?php if ($pageRecordInfo['next_url'] != '') : ?>
                                            <li class="next"><a href="<?php echo $pageRecordInfo['next_url'] ?>"><?php echo t('Next', 'en') ?></a></li>
                                        <?php else : ?>
                                            <li class="next disabled"><a href="javascript:;"><?php echo t('Next', 'en') ?></a></li>
                                        <?php endif ?>
                                    <?php endif ?>
                                </ul>
                            </div>
                        <? } ?>
                        <div class="btn-group class-btn-group class-btn-group-detail">
                            <a class="btn-readMore btn-text" href="class_tw_5.php">
                                返回首頁
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            </a>
                        </div>
                    </section>
                </div>
                <!-- class-border End -->
            </main>
            <div class="sidebar">
                <!-- slogan-board -->
                <div class="slogan-board">
                    <img src="images_v4/classWeb/blackboardImg.png" alt="">
                    <h4 class="slogan-board-title"><?= $this->data['sys_configs']['class_text_' . $this->data['ml_key']] ?></h4>
                </div>
                <!-- news-list -->
                <?
                include _BASEPATH . '/../view/v4/class/classadvertise.php';
                ?>
                <!-- ad-photo-board -->
                <div class="ad-photo-board ">
                    <img src="images_v4/classWeb/adImg.jpg" alt="">

                </div>
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->