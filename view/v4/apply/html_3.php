<?
include _BASEPATH . '/../source/apply/post_3.php';
?>
<section class="sectionBlock" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">上傳申請</h1> -->
        <div class="application-steps">
            <div class="btn-group ">
                <a href="apply_tw_1.php">
                    <div class="btn-apply-1 btn-text ">
                        1.填寫計畫
                    </div>
                </a>
                <a href="apply_tw_2.php">
                    <div class="btn-apply-1 btn-text ">
                        2.班級申請
                    </div>
                </a>
                <a href="apply_tw_3.php">
                    <div class="btn-apply-1 btn-text active">
                        3.上傳申請
                    </div>
                </a>
                <a href="apply_tw_4.php">
                    <div class="btn-apply-1 btn-text">
                        4.審查進度
                    </div>
                </a>
                <a href="apply_tw_5.php">
                    <div class="btn-apply-1 btn-text">
                        5.期末成果
                    </div>
                </a>
            </div>
            <div class="btn-group ">
                <a href="apply_tw_6.php">
                    <div class="btn-apply-2 btn-text">
                        開創教師帳號
                    </div>
                </a>
                <a href="apply_tw_7.php">
                    <div class="btn-apply-2 btn-text">
                        成果預覽
                    </div>
                </a>
                <a href="apply_tw_8.php">
                    <div class="btn-apply-2 btn-text">
                        修改資料
                    </div>
                </a>
            </div>
        </div>
        <div class="form-border">
            <div class="application-steps-mark">
                <div class="mark-number">三</div>
                <div class="mark-title">
                    專案步驟
                </div>
            </div>
            <div class="application-form-title title-bot-border  ">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div>
                    上傳申請表單
                    <!-- <small>請填寫以下表格，<span>「＊」</span>為必填</small> -->
                </div>

            </div>
            <!--申請明細  -->
            <div class="application-form-details">
                <div class="responsive_tbl">
                    <table class="tableList">
                        <thead>
                            <tr>
                                <th>申請學期</th>
                                <th>送審日期</th>
                                <th>希望報份</th>
                                <th>列印表單</th>
                                <th>核章檔案上傳</th>
                                <th>詳細閱讀</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? if (!empty($writeplan_array)) {
                                foreach ($writeplan_array as $k => $v) { ?>
                                    <tr>
                                        <td>
                                            <?= $semester[$v['semester']] ?>
                                        </td>
                                        <td><?= ($v['submission_date'] == '0000-00-00 00:00:00' ? '---' : $v['submission_date']) ?></td>
                                        </td>
                                        <td><?= $v['apply_num'] ?></td>
                                        <td><button class='btn-action btn-text photocopyform' data-cid="<?= $v['id'] ?>"><i class="fa fa-print" aria-hidden="true"></i>前往</button>
                                        <td>
                                            <? if ($v['a_results'] != '核可') { ?><a class="act_<?= $v['id'] ?>" href="#uploadForm_<?= $v['id'] ?>" data-fancybox="" data-src="#uploadForm_<?= $v['id'] ?>"><i class="fa fa-upload" aria-hidden="true"></i><?= (!empty($v['file3']) ? '前往更新' : '前往上傳') ?></a><? } else { ?>已審核無法修改<? } ?>
                                        </td>
                                        <td>
                                            <a href="apply_<?= $this->data['ml_key'] ?>_9.php?writeplan_id=<?= $v['id'] ?>" ><i class="fa fa-file-text-o" aria-hidden="true"></i><?=($v['a_results']!='核可'?'編輯':'檢視')?></a>
                                        </td>
                                    </tr>
                            <? }
                            } ?>
                        </tbody>
                    </table>
                </div><!-- .responsive_tbl -->
                <!-- 按鈕 -->
                <!-- <div class="application-form-details-end">
                    <button class='btn-register btn-text'>
                        確認無誤
                    </button>
                    target="_blank"
                </div> -->
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->

<!-- 核章檔案上傳 -->
<? if (!empty($writeplan_array)) {
    //檔案上傳-資料夾判斷
    $school = (!empty($_SESSION['member_data']['code']) ? $_SESSION['member_data']['code'] : 'all_school');
    //檔案上傳-路徑
    $data_path = '/_i/assets/file/writeplan/' .$school;
    foreach ($writeplan_array as $k => $v) {

?>
        <div id="uploadForm_<?= $v['id'] ?>" class="modal modal_half sign-off-form" style="display: none;">
            <div class="pageTitleStyle-1">
                <span>核章上傳</span>
            </div>
            <div class="pageTitleStyle-3">
                <span><?= $semester[$v['semester']] ?></span>
            </div>
            <button class='btn-action btn-text photocopyform' data-cid="<?= $v['id'] ?>">
                <i class="fa fa-print" aria-hidden="true"></i>
                列印表單
            </button>
            <form class="upload_form" action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="writeplan_id" name="writeplan_id" value="<?= $v['id'] ?>" />
                <label class='upload_form-label'>核章檔案上傳：</label>
                <div class="row">
                    <div class="form_group col-12">
                        <div class="row file-input-group">
                            <div class="col-12">
                                <div class='file-input <?= (!empty($v['file3']) ? ' -chosen ' : '') ?>'>
                                    <input type='file' id="file3" name="file3">
                                    <span class='button'>選擇檔案</span>
                                    <span class='label' data-js-label>未選擇檔案</span>
                                    <?if(!empty($v['file3'])){?><a href="javascript:;" class="delete-file" data-table="writeplan" data-field="file3" data-name="<?=$v['file3']?>" data-id="<?=$v['id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a><? } ?>
                                </div>
                            </div>
                            <? if (!empty($v['file3'])) { ?><a href="<?= $data_path .'/'.$v['id'].'/'. $v['file3'] ?>" target="_blank" style="color:red;">點此開啟已上傳檔案</a><? } ?>
                        </div>
                    </div>
                </div>

                <label class="remind"><span>檔案大小限制</span>： <?= $num_mb ?>MB以下</label>
                <div><button class="btn-operate btn-text subbut">確定上傳</button></div>
            </form><!-- .cont_form -->
            <button data-fancybox-close="" class="fancybox-close-small" title="Close"></button>
        </div>
<? }
} ?>

<script m="body_end">
    //檔案刪除
    var delete_file = document.querySelectorAll('.delete-file');
    for (let i = 0; i < delete_file.length; i++) {
        delete_file[i].addEventListener("click", function(e) {
            if (confirm("是否要刪除?") == true) {
                let id = delete_file[i].dataset.id;
                let table = delete_file[i].dataset.table;
                let name = delete_file[i].dataset.name;
                let field = delete_file[i].dataset.field;
                $.ajax({
                    type: "POST",
                    data: {
                        'type': 'file_del',
                        'name': name,
                        'id': id,
                        'table': table,
                        'field': field,
                        'url': '<?= (isset($data_path) && !empty($data_path) ? $data_path : '') ?>'+'/'+id,
                    },
                    url: 'apply_post.php',
                    success: function(response) {
                        // console.log(response);
                        txt = response.split('@@');
                        if (txt[0] != 1) {
                            alert(txt[1]);
                        }else{
                            alert('刪除成功!');
                            location.reload();
                        }
                    }
                }); // ajax
            }
        });
    }
    $("input[type='file']").change(function() {
        var filelist = $("input[type='file']");
        var size = 0;
        for (var i = 0; i < filelist.length; i++) {
            if (filelist.get(i).files[0] != undefined) {
                size = size + filelist.get(i).files[0].size;
            }
        }
        var upload_max_filesize = "<?= ini_get('upload_max_filesize') ?>";
        var upload_max_filesize = parseInt(upload_max_filesize, 10);
        var post_max_size = "<?= ini_get('post_max_size') ?>";
        var post_max_size = parseInt(post_max_size, 10);

        num_mb = Math.min(post_max_size, upload_max_filesize);

        if (size > 1024 * 1024 * num_mb) {
            alert('您選擇上傳的檔案大小總和超過' + num_mb + '，請重新選擇！');
            $('.subbut').hide();
        } else {
            $('.subbut').show();
        }
    });
    //另開影印頁面
    var photocopyform = document.querySelectorAll('.photocopyform');
    for (let i = 0; i < photocopyform.length; i++) {
        photocopyform[i].addEventListener("click", function(e) {
            let id = photocopyform[i].dataset.cid;
            window.open('photocopyform_tw_1.php?writeplan_id=' + id, '_blank');
        });
    }
</script>