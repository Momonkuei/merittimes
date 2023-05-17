<?
include _BASEPATH . '/../source/classout/post_11.php';
$classword=$this->cidb->where('type','classword')->get('html')->row_array();
?>
<section class="sectionBlock sectionBlock-classweb" data-about="1">
    <div class="container">
        <div class="class-web">
            <main class="main-page">
                <!-- heroPage -->
                <section class="heroPage">
                    <img src="<?=$data_path?>/<?=$class_data['pic1']?>" alt="heroPage-photo">
                    <div class="heroPage-content">
                        <h1 class="heroPage-title">
                            <?=$class_data['pic_name']?>
                        </h1>
                        <p class="heroPage-txt">
                            <?=$class_data['pic_description']?>
                        </p>
                    </div>
                </section>
                <div class="class-border">
                    <!-- 公佈欄 -->
                    <?if(!empty($billboard_list)){?>
                    <section class="class-billboard">
                        <div class="class-title">
                            公佈欄
                        </div>
                        <div class="newsList newsListType5">
                            <div class="row">
                                <?foreach($billboard_list as $k => $v){?>
                                    <div class="col-lg-6 class-billboard-list">
                                        <div class="item">
                                            <a href="classout_<?=$this->data['ml_key']?>_5.php?bid=<?=$v['id']?>">
                                                <div class="itemImg2">
                                                    <div class="itemImg_line">
                                                        <img src="<?=$data_path?>/<?=$v['pic1']?>">
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="classout_<?=$this->data['ml_key']?>_5.php?bid=<?=$v['id']?>">
                                                <div class="itemTitle"><?=$v['name']?></div>
                                                <div class="itemContent" data-txtlen="150"><?=$v['field_data']?></div>
                                                <div class="moreStyleBlock"><span class="borderLine"></span><span>More 看更多</span></div>
                                            </a>
                                        </div><!-- .item -->
                                    </div>
                                <?}?>
                            </div>
                        </div><!-- .newsList -->
                        <?if(!empty($pageRecordInfo['pagination'])){?>
                <div class="pageNumber">
                    <ul>
                        <?php if(isset($pageRecordInfo['prev_url'])):?>
                            <?php if($pageRecordInfo['prev_url'] != ''):?>
                                <li class="prev"><a href="<?php echo $pageRecordInfo['prev_url']?>"><?php echo t('Prev','en')?></a></li>
                            <?php else:?>
                                <li class="prev disabled"><a href="javascript:;"><?php echo t('Prev','en')?></a></li>
                            <?php endif?>
                        <?php endif?>
                        <li><?php echo $pageRecordInfo['pagination']['control']['now']?></li>
                        <li>/</li>
                        <li><?php echo $pageRecordInfo['pagination']['control']['total']?></li>
                        <?php if(isset($pageRecordInfo['next_url'])):?>
                            <?php if($pageRecordInfo['next_url'] != ''):?>
                                <li class="next"><a href="<?php echo $pageRecordInfo['next_url']?>"><?php echo t('Next','en')?></a></li>
                            <?php else:?>
                                <li class="next disabled"><a href="javascript:;"><?php echo t('Next','en')?></a></li>
                            <?php endif?>
                        <?php endif?>
                    </ul>
                </div>
                <?}?>
                <div class="btn-group class-btn-group">
                    <a class="btn-readMore btn-text" href="classout_tw_1.php">
                        返回首頁
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                </div>
                    </section>
                    <?}?>
                </div>
                <!-- class-border End -->
            </main>
            <div class="sidebar">
                <!-- slogan-board -->
                <div class="slogan-board">
                    <img src="images_v4/classWeb/blackboardImg.png" alt="">
                    <h4 class="slogan-board-title"><?=(!empty($classword['topic'])?$classword['topic']:$this->data['sys_configs']['class_text_'.$this->data['ml_key']])?></h4>
                </div>
                <!-- news-list -->
                <?
                include _BASEPATH . '/../view/v4/class/classadvertise.php';
                ?>
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->