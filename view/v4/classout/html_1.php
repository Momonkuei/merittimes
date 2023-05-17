<?
include _BASEPATH . '/../source/classout/post_5.php';
$classword = $this->cidb->where('type', 'classword')->get('html')->row_array();;
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
                            <?= nl2br($class_data['pic_description']) ?>
                        </p>
                    </div>
                </section>
                <div class="class-border">
                    <!-- 班級介紹 -->
                    <?if(!empty($class_data['description'])){?>
                        <section class="class-introduce">
                            <div class="class-title">
                                班級介紹
                            </div>
                            <p class="class-introduce-txt"><?= nl2br($class_data['description']) ?></p>
                        </section>
                    <?}?>  
                    <? if (!empty($billboard_list)) { ?>
                        <!-- 公佈欄 -->
                        <section class="class-billboard">
                            <div class="class-title">
                                公佈欄
                            </div>
                            <div class="newsList newsListType5">
                                <div class="row">
                                    <? foreach ($billboard_list as $k => $v) {
                                        if ($k > 7) {
                                            continue;
                                        }
                                    ?>
                                        <div class="col-lg-6 class-billboard-list">
                                            <div class="item">
                                                <a href="classout_<?= $this->data['ml_key'] ?>_5.php?bid=<?= $v['id'] ?>">
                                                    <div class="itemImg2">
                                                        <div class="itemImg_line">
                                                            <img src="<?= $data_path ?>/<?= $v['pic1'] ?>">
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="classout_<?= $this->data['ml_key'] ?>_5.php?bid=<?= $v['id'] ?>">
                                                    <div class="itemTitle"><?= $v['name'] ?></div>
                                                    <div class="itemContent" data-txtlen="150"><?= $v['field_data'] ?></div>
                                                    <div class="moreStyleBlock"><span class="borderLine"></span><span>More 看更多</span></div>
                                                </a>
                                            </div><!-- .item -->
                                        </div>
                                    <? } ?>
                                </div>
                            </div><!-- .newsList -->
                            <div class="btn-group class-btn-group">

                                <a class="btn-readMore btn-text" href="classout_tw_2.php">
                                    了解更多
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </section>
                    <? } ?>
                    <? if (!empty($pic_list)) { ?>
                        <!-- 相片成果 -->
                        <section class="class-photo-album">
                            <div class="class-title">
                                相片成果
                            </div>
                            <section class="sectionBlock cowboyAbout_1" data-about="13.5">
                                <div class="row">
                                    <? foreach ($pic_list as $k => $v) {
                                        if ($k > 9) {
                                            continue;
                                        }
                                    ?>
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
                            <div class="btn-group class-btn-group">
                                <a class="btn-readMore btn-text" href="classout_tw_3.php">
                                    了解更多
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </section>
                    <? } ?>
                    <? if (!empty($vido_list)) { ?>
                        <!-- 影音成果 -->
                        <section class="class-video-album">
                            <div class="class-title">
                                影音成果
                            </div>
                            <div class="row">
                                <? foreach ($vido_list as $k => $v) {
                                    if ($k > 9) {
                                        continue;
                                    }
                                    if (!empty($v['other1'])) {
                                        $pic = 'https://img.youtube.com/vi/' . $v['other1'] . '/0.jpg';
                                    } else if (!empty($v['pic1'])) {
                                        $pic = $data_path . '/' . $v['pic1'];
                                    } else {
                                        $pic = '';
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
                            <div class="btn-group class-btn-group class-btn-group-last">

                                <a class="btn-readMore btn-text" href="classout_tw_4.php">
                                    了解更多
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </section>
                    <? } ?>
                </div>
                <!-- class-border End -->
            </main>
            <div class="sidebar">
                <!-- slogan-board -->
                <div class="slogan-board">
                    <img src="images_v4/classWeb/blackboardImg.png" alt="">
                    <h4 class="slogan-board-title"><?= (!empty($classword['topic']) ? $classword['topic'] : $this->data['sys_configs']['class_text_' . $this->data['ml_key']]) ?></h4>
                </div>
                <!-- news-list -->
                <?
                include _BASEPATH . '/../view/v4/class/classadvertise.php';
                ?>
                <!-- ad-photo-board -->

            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->