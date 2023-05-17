<?
include _BASEPATH . '/../source/class/post_2.php';
?>
<section class="sectionBlock sectionBlock-classweb" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">公布欄</h1> -->
        <?include _BASEPATH . '/../view/v4/class/class_header.php';?>
        <div class="form-border">
            <!-- <div class="application-steps-mark">
                <div class="mark-number">二</div>
                <div class="mark-title">
                    進階搜尋
                </div>
            </div> -->
            <!-- <div class="application-form-title  ">
                新增教師帳號
                <small>請填寫以下表格，<span>「＊」</span>為必填</small>
            </div> -->
            <!-- 進階搜尋表單 -->
            <div class="application-form  advanced-search-form form-border-no-title ">
                <h2 class="title text-center">
                    進階搜尋
                </h2>
                <form action="" method="get" name="applicationForm" id="form_data" class="row cont_form" autocomplete="off">
                    <div class="form_group col-lg-6">
                        <label class="">
                            日期<span>：</span>
                        </label>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="date-label">
                                    開始
                                    <input type="date" id="start_date" name="start_date" placeholder="" value="<?= (isset($_GET['start_date']) && !empty($_GET['start_date']) ? date('Y-m-d', strtotime($_GET['start_date'])) : '') ?>">
                                </label>

                            </div>
                            <div class="col-md-6">
                                <label class="date-label">
                                    結束
                                    <input type="date" id="end_date" name="end_date" placeholder="" value="<?= (isset($_GET['end_date']) && !empty($_GET['end_date']) ? date('Y-m-d', strtotime($_GET['end_date'])) : '') ?>">
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="">搜尋 <span>：</span>
                        </label>
                        <input type="text" id="keyword" name="keyword" placeholder="請輸入關鍵字" value="<?= (isset($_GET['keyword']) && !empty($_GET['keyword']) ? $_GET['keyword'] : '') ?>">
                    </div>
                    <div class=" col-lg-12">
                        <div class="btn-group">
                            <button class="btn-operate btn-text">
                                搜尋
                            </button>
                            <button class="btn-operate btn-text clear_b" type="button">
                                清除
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- 教師帳號管理 -->
            <div class="application-form-details billboard-form-details">
                <div class="top-function-column">
                    <div class='add-area'>

                        <a href="class_tw_8.php" class='btn-register btn-text'>
                            新增
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="responsive_tbl">
                    <table class="tableList">
                        <thead>
                            <tr>
                                <th class="col-1">編號</th>
                                <th class="col-1">圖片</th>
                                <th class="col-6">標題</th>
                                <th class="col-1">日期</th>
                                <th class="col-1">狀態</th>
                                <th class="col-2">操作</th>
                            </tr>

                        </thead>
                        <tbody>
                            <? if (!empty($billboard_data)) {
                                foreach ($billboard_data as $k => $v) { ?>
                                    <tr>
                                        <td>
                                            <?= $k + 1 ?>
                                        </td>
                                        <td>
                                            <div class="img-container">
                                                <img src="<?= $data_path . '/' . $v['pic1'] ?>" alt="">
                                            </div>
                                        </td>
                                        <td class="title"><?= $v['name'] ?></td>
                                        <td><?= date('Y-m-d', strtotime($v['create_time'])) ?></td>
                                        <td>
                                            <label class="permission-checkbox show_or_notshow <?= ($v['is_enable'] == 1 ? 'display-text' : '') ?>" data-cid="<?= $v['id'] ?>">
                                                <?= ($v['is_enable'] == 1 ? '顯示' : '不顯示') ?>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="class_<?= $this->data['ml_key'] ?>_8.php?billboard_id=<?= $v['id'] ?>" class="btn-revise btn-text">
                                                    修改
                                                </a>
                                                <a class="btn-delete btn-text billboard_delete" data-cid="<?= $v['id'] ?>">
                                                    刪除
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                            <? }
                            } ?>
                        </tbody>
                    </table>
                </div>
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
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->


<script m="body_end">
    //清除搜尋
    var clear_b = document.querySelector('.clear_b');
    clear_b.addEventListener('click', function(e) {
        window.location.href = '/class_<?= $this->data['ml_key'] ?>_2.php';
    }, false);
    //個別班級刪除
    var billboard_delete = document.querySelectorAll('.billboard_delete');
    for (let i = 0; i < billboard_delete.length; i++) {
        billboard_delete[i].addEventListener("click", function(e) {
            if (confirm("是否要刪除?") == true) {
                let id = billboard_delete[i].dataset.cid;
                $.ajax({
                    type: "POST",
                    data: {
                        'type': 'del_billboard',
                        'data_id': id,
                    },
                    url: 'class_post.php',
                    success: function(response) {
                        alert('刪除成功!');
                        location.reload();
                    }
                }); // ajax
            }
        });
    }
    var show_or_notshow = document.querySelectorAll('.show_or_notshow');
    for (let i = 0; i < show_or_notshow.length; i++) {
        show_or_notshow[i].addEventListener("click", function(e) {
            if (confirm("是否要切換顯示?") == true) {
                let id = show_or_notshow[i].dataset.cid;
                $.ajax({
                    type: "POST",
                    data: {
                        'type': 'switch_is_enable',
                        'table': 'class_billboard',
                        'data_id': id,
                    },
                    url: 'class_post.php',
                    success: function(response) {
                        // console.log(response);
                        txt = response.split('@@');
                        if (txt[0] != 1) {
                            alert(txt[1]);
                        } else {
                            alert('切換成功!');
                            location.reload();
                        }
                    }
                }); // ajax
            }
        });
    }
</script>