<?
include _BASEPATH . '/../source/class/post_15.php';
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
                                <?php echo $data['detail'] ?>
                            </div>
                        </div><!-- .newsList -->
                        <div class="text-center">
                            <a href="class_<?= $this->data['ml_key'] ?>_11.php" class="btn-cis1"><i class="fa fa-reply" aria-hidden="true"></i>回列表頁</a>
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