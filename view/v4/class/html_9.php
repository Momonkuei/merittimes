<?
include _BASEPATH . '/../source/class/post_9.php';
?>
<section class="sectionBlock sectionBlock-classweb" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">相片成果</h1> -->
        <?include _BASEPATH . '/../view/v4/class/class_header.php';?>
        <div class="form-border">
            <!-- <div class="application-steps-mark">
                <div class="mark-number">一</div>
                <div class="mark-title">
                    填寫計畫
                </div>
            </div> -->
            <div class="application-form-title title-bot-border form-border-no-title">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div>
                    填寫相片成果
                    <!-- <small>請填寫以下表格，<span>「＊」</span>為必填</small> -->
                </div>
            </div>
            <div class="application-form teacher-account-management-form">
                <form action="" method="POST" name="applicationForm" id="form_data" class="row cont_form" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateForm()">
                    <div class="form_group col-lg-6">
                        <label class="">相片標題<span>：</span>
                        </label>
                        <input type="text" id="name" name="name" placeholder="請輸入相片標題" value="<?= (!empty($_SESSION['class_9']['name']) ? $_SESSION['class_9']['name'] : '') ?>">
                    </div>
                    <div class="form_group col-lg-6">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="">上傳日期<span>：</span>
                        </label>
                        <input type="datetime-local" id="create_time" name="create_time" placeholder="" value="<?= (!empty($_SESSION['class_9']['create_time']) ? date('Y-m-d H:i:s', strtotime($_SESSION['class_9']['create_time'])) : '') ?>">
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="">相片上傳<span>：</span>
                        </label>
                        <div class='file-input col-lg-6 <?= (!empty($_SESSION['class_9']['pic1']) ? ' -chosen ' : '') ?>'>
                            <input type='file' id="file1" name="file1">
                            <span class='button'>選擇檔案</span>
                            <span class='label' data-js-label>未選擇檔案</span>
                            <? if (!empty($_SESSION['class_9']['pic1'])) { ?><a href="javascript:;" class="delete-file" data-table="class_pic" data-field="pic1" data-name="<?= $_SESSION['class_9']['pic1'] ?>" data-id="<?= $_SESSION['class_9']['id'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a><? } ?>
                        </div>
                        <div class="application-form-title ">
                            <small><span style="color:red">*</span>指定上傳格式: jpg, jpeg, png, gif, svg ，建議上傳圖片尺寸(像素): 900X600</small>
                        </div>
                        <? if (!empty($_SESSION['class_9']['pic1'])) { ?><a href="<?= $data_path . '/' . $_SESSION['class_9']['pic1'] ?>" target="_blank" style="color:red;">點此開啟已上傳圖片</a><? } ?>
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="">相片簡述<span>：</span>
                        </label>
                        <textarea id="field_data" name="field_data" rows="5" cols="33" placeholder="請在此輸入內容"><?= (!empty($_SESSION['class_9']['field_data']) ? $_SESSION['class_9']['field_data'] : '') ?></textarea>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">狀態 <span>：</span>
                        </label>
                        <div class="row">
                            <div class="col-6 col-md-3 radio-label">
                                開啟<input type="radio" name="is_enable" value="1" <?= (empty($_SESSION['class_9']) || $_SESSION['class_9']['is_enable'] == '1' ? 'checked' : '') ?> />
                            </div>
                            <div class="col-6 col-md-3 radio-label">
                                關閉 <input type="radio" name="is_enable" value="0" <?= (isset($_SESSION['class_9']) && $_SESSION['class_9']['is_enable'] == '0' ? 'checked' : '') ?> />
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form_group col-lg-12">
                        <label class="must-label">內容<span>：</span>
                        </label>
                        <textarea id="story" name="story" rows="5" cols="33">編輯器位置
                        </textarea>
                    </div> -->
                    <div class="form_group col-lg-12">
                        <div class="btn-group">
                            <button class="btn-register btn-text">
                                送出
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->


<script m="body_end">
    $('.delete-file').click(function() {
        if (confirm('確定要刪除嗎?')) {
            let id = $(this).data('id');
            let table = $(this).data('table');
            let name = $(this).data('name');
            let field = $(this).data('field');
            $.ajax({
                type: "POST",
                data: {
                    'type': 'pic_del',
                    'field': field,
                    'name': name,
                    'id': id,
                    'table': table,
                    'url': '<?= (isset($data_path) && !empty($data_path) ? $data_path : '') ?>',
                },
                url: 'apply_post.php',
                success: function(response) {
                    // console.log(response);
                    txt = response.split('@@');
                    if (txt[0] != 1) {
                        alert(txt[1]);
                    } else {
                        alert('刪除成功!');
                        location.reload();
                    }
                }
            }); // ajax
        }
    });
    $("input[type='file']").change(function() {
        var filelist = $("input[type='file']");
        var size = 0;
        for (var i = 0; i < filelist.length; i++) {
            if (filelist.get(i).files[0] != undefined) {
                size = size + filelist.get(i).files[0].size;
            }
        }
        var upload_max_filesize = "<?= ini_get('upload_max_filesize') ?>";
        var num_mb = parseInt(upload_max_filesize, 10);
        if (size > 1024 * 1024 * num_mb) {
            alert('您選擇上傳的檔案大小總和超過' + '<?= ini_get('upload_max_filesize') ?>' + '，請重新選擇！');
            $('.subbut').hide();
        } else {
            $('.subbut').show();
        }
    });

    function validateForm() {
        // var is_stop = false;
        // $check_array = ['field_data'];
        // var x = $("form").serializeArray();
        // // console.log(x);
        // $.each(x, function() {
        //     if ($.inArray(this.name, $check_array) != '-1' && this.value == '') {
        //         alert($('#' + this.name).attr('placeholder'));
        //         is_stop = true;
        //         //停止each
        //         return false;
        //     }
        // });
        // if (is_stop == true) {
        //     //不讓表單送出
        //     return false;
        // }
    }
</script>