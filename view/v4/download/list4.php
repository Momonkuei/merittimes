<section class="sectionBlock">

    <div class="download_list4">

        <div class="pageTitleStyle-2 text-center">
            <h2>Download</h2>
        </div>

        <div class="">

            <ul class=" download_list4_documentList row">
                <?php if (isset($data[$ID])) : ?>
                    <?php foreach ($data[$ID] as $k => $v) : ?>
                        <li class="download_list4_documentList_listContent col-xl-4 col-lg-6 col-md-6 col-sm-12">
                            <div class="item row">
                                <a class="col-12 col-sm-6" href="<?php echo $v['url1'] ?>">
                                    <div class="imgBox ">
                                        <?if(!empty($v['pic1'])){?>
                                            <img src="/_i/assets/upload/download/<?=$v['pic1']?>">
                                        <?}else{?>
                                            <img src="https://picsum.photos/id/486/390/500">
                                        <?}?>
                                    </div>
                                </a>
                                <div class="content col-12 col-sm-6">
                                    <h3 class="title">
                                        <a href="<?php echo $v['url1'] ?>"><?=$v['topic']?></a>
                                    </h3>
                                    <p class="downlandLink">
                                        <a href="<?php echo $v['url1'] ?>">DOWNLOAD</a>
                                    </p>

                                </div>
                            </div>
                        </li>
                    <?php endforeach ?>
                <?php endif ?>
            </ul>




        </div>
    </div>

</section>