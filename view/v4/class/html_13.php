<?
include _BASEPATH . '/../source/class/post_13.php';
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
                    <!-- 影音成果 -->
                    <section class="class-video-album">
                        <div class="class-title">
                            影音成果
                        </div>
                        <? if (!empty($vido_list)) { ?>
                            <div class="row">
                                <? foreach ($vido_list as $k => $v) {
                                    if (!empty($v['other1'])) {
                                        $pic = 'https://img.youtube.com/vi/' . $v['other1'] . '/0.jpg';
                                    } else {
                                        $pic = $data_path . '/' . $v['pic1'];
                                    }
                                ?>
                                    <div class="col-lg-4">
                                        <div class="video">
                                            <div class="videoContent videoContent-index">
                                                <a href="javascript:;" data-url="<?= $v['url1'] ?>" title="">
                                                    <div class="itemImg  itemImgHover hoverEffect1">
                                                        <img src="<?= $pic ?>" onerror="javascript:this.src='images_v4/default.png'">
                                                    </div>
                                                </a>
                                                <div class="subBlockTitle text-center"><?= $v['name'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
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