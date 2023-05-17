<?
include _BASEPATH . '/../source/classout/post_15.php';
$classword = $this->cidb->where('type', 'classword')->get('html')->row_array();
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
                    <section class="class-billboard">
                        <div class="newsD_main">
                            <?php if ($data['pic1'] != '') : ?>
                                <div class="newD_img"><img class="rwd_img" src="<?= $data_path ?>/<?= $data['pic1'] ?>" alt=""></div>
                            <?php endif ?>

                            <div class="blockTitle"><span><?php echo $data['name'] ?></span></div>

                            <div class="editor">
                                <?php echo nl2br($data['detail']) ?>
                            </div>
                        </div><!-- .newsList -->

                        <section class="sectionBlock cowboyAbout_1 class-photo-album class-photo-album-detail" data-about="13.5">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="ca1">
                                        <a href="/_i/assets/upload/class/BLC012/11/southeast.jpg" data-fancybox="group_2">

                                            <img src="https://picsum.photos/380/285" alt="">
                                            <div class="ca1_cover">
                                                <div class="subBlockTitle">1</div>
                                                <p></p>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="ca1">
                                        <a href="/_i/assets/upload/class/BLC012/11/southeast.jpg" data-fancybox="group_2">

                                            <img src="https://picsum.photos/380/285" alt="">
                                            <div class="ca1_cover">
                                                <div class="subBlockTitle">2</div>
                                                <p></p>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="ca1">
                                        <a href="/_i/assets/upload/class/BLC012/11/qwez.png" data-fancybox="group_2">

                                            <img src="https://picsum.photos/380/285" alt="">
                                            <div class="ca1_cover">
                                                <div class="subBlockTitle">3</div>
                                                <p>test</p>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="ca1">
                                        <a href="/_i/assets/upload/class/BLC012/11/southeast.jpg" data-fancybox="group_2">

                                            <img src="https://picsum.photos/380/285" alt="">
                                            <div class="ca1_cover">
                                                <div class="subBlockTitle">4</div>
                                                <p></p>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="class-btn-group">
                            <? if (!empty($last_data)) { ?><a href="classout_<?= $this->data['ml_key'] ?>_5.php?bid=<?= $last_data['id'] ?>" class="btn-cis1"><i class="fa fa-arrow-left" aria-hidden="true"></i>上一則</a><? } ?>
                            <a href="classout_<?= $this->data['ml_key'] ?>_2.php" class="btn-cis1"><i class="fa fa-reply" aria-hidden="true"></i>回列表頁</a>
                            <? if (!empty($newt_data)) { ?><a href="classout_<?= $this->data['ml_key'] ?>_5.php?bid=<?= $newt_data['id'] ?>" class="btn-cis1">下一則<i class="fa fa-arrow-right" aria-hidden="true"></i></a><? } ?>
                        </div>
                    </section>



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
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->