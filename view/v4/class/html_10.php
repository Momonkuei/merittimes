<?
include _BASEPATH . '/../source/class/post_10.php';
?>
<section class="sectionBloc sectionBlock-classweb" data-about="1">
    <div class="container">
        <h1 class="text-center apply-title">影音成果</h1>
        <? include _BASEPATH . '/../view/v4/class/class_header.php'; ?>
        <div class="form-border">
            <!-- <div class="application-steps-mark">
                <div class="mark-number">一</div>
                <div class="mark-title">
                    填寫計畫
                </div>
            </div> -->
            <div class="application-form-title title-bot-border form-border-no-title ">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div>
                    填寫影音成果
                    <!-- <small>請填寫以下表格，<span>「＊」</span>為必填</small> -->
                </div>
            </div>
            <div class="application-form teacher-account-management-form">
                <form action="" method="POST" name="applicationForm" id="form_data" class="row cont_form" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateForm()">
                    <div class="form_group col-lg-6">
                        <label class="">影音標題<span>：</span>
                        </label>
                        <input type="text" id="name" name="name" placeholder="請輸入影音標題" value="<?= (!empty($_SESSION['class_10']['name']) ? $_SESSION['class_10']['name'] : '') ?>">
                    </div>
                    <div class="form_group col-lg-6">
                    </div>
                    <div class="form_group col-lg-6 ">
                        <label class="">YouTube網址<span>：</span>
                        </label>
                        <input type="text" id="url1" name="url1" placeholder="請輸入YouTube網址" value="<?= (!empty($_SESSION['class_10']['url1']) ? $_SESSION['class_10']['url1'] : '') ?>">
                    </div>
                    <div class="form_group col-lg-6">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="reminder-text">
                            <div class="top">
                                YouTube代碼
                                <a data-fancybox='' data-options='{"touch" : false}' data-src="#videoCode" href="javascript:;" class="remind-mark">?</a>
                                <span>：</span>
                            </div>
                            <div class="bottom">
                                <small class="">如有輸入代碼，則代表圖自動替換為影片截圖</small>
                            </div>
                        </label>
                        <input type="text" id="other1" name="other1" placeholder="請輸入YouTube代碼" value="<?= (!empty($_SESSION['class_10']['other1']) ? $_SESSION['class_10']['other1'] : '') ?>">
                    </div>
                    <div class="form_group col-lg-6">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="">上傳日期<span>：</span>
                        </label>
                        <input type="datetime-local" id="create_time" name="create_time" placeholder="" value="<?= (!empty($_SESSION['class_10']['create_time']) ? date('Y-m-d H:i:s', strtotime($_SESSION['class_10']['create_time'])) : '') ?>">
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="">代表圖上傳<span>：</span>
                        </label>
                        <div class='file-input col-lg-6 <?= (!empty($_SESSION['class_10']['pic1']) ? ' -chosen ' : '') ?>'>
                            <input type='file' id="file1" name="file1">
                            <span class='button'>選擇檔案</span>
                            <span class='label' data-js-label>未選擇檔案</span>
                            <? if (!empty($_SESSION['class_10']['pic1'])) { ?><a href="javascript:;" class="delete-file" data-table="class_vido" data-field="pic1" data-name="<?= $_SESSION['class_10']['pic1'] ?>" data-id="<?= $_SESSION['class_10']['id'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a><? } ?>
                        </div>
                        <div class="application-form-title ">
                            <small><span style="color:red">*</span>指定上傳格式: jpg, jpeg, png, gif, svg ，建議上傳圖片尺寸(像素): 900X600</small>
                        </div>
                        <? if (!empty($_SESSION['class_10']['pic1'])) { ?><a href="<?= $data_path . '/' . $_SESSION['class_10']['pic1'] ?>" target="_blank" style="color:red;">點此開啟已上傳圖片</a><? } ?>
                    </div>
                    <!-- <div class="form_group col-lg-12">
                        <label class="must-label">相片簡述<span>：</span>
                        </label>
                        <textarea id="story" name="story" rows="5" cols="33">請在此輸入內容
                        </textarea>
                    </div> -->
                    <div class="form_group col-lg-6">
                        <label class="must-label">狀態 <span>：</span>
                        </label>
                        <div class="row">
                            <div class="col-3 radio-label">
                                開啟<input type="radio" name="is_enable" value="1" <?= (empty($_SESSION['class_10']) || $_SESSION['class_10']['is_enable'] == '1' ? 'checked' : '') ?> />
                            </div>
                            <div class="col-3 radio-label">
                                關閉 <input type="radio" name="is_enable" value="0" <?= (isset($_SESSION['class_10']) && $_SESSION['class_10']['is_enable'] == '0' ? 'checked' : '') ?> />
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


<!-- 影片代碼示範 -->

<div id="videoCode" class="modal modal_half sign-off-form" >
    <div class="pageTitleStyle-1">
        <span>示範說明</span>
    </div>
    <!-- <div class="pageTitleStyle-3">
        <span></span>
    </div> -->
    <div class="content">
        <p>
            每一個 YouTube 影片都有各自的影片代碼，在?v=後方為此影片的代碼，例：https://www.youtube.com/watch?v=影片代碼
        </p>
        <p>
            比如以下面的影片為例，影片網址如下：
            https://www.youtube.com/watch?v=<span >6Qapd3sjxEM</span><br>
            此影片的代碼為<span >6Qapd3sjxEM</span>
        </p>
        <p>之後請在 YouTube代碼 欄位貼上代碼，
            影片代碼為<span>6Qapd3sjxEM</span><br>
            即可將代表圖自動替換為影片截圖。
        </p>
    </div>
    <button data-fancybox-close="" class="fancybox-close-small" title="Close"></button>
</div>

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
        var is_stop = false;
        $check_array = ['field_data'];
        var x = $("form").serializeArray();
        // console.log(x);
        $.each(x, function() {
            if ($.inArray(this.name, $check_array) != '-1' && this.value == '') {
                alert($('#' + this.name).attr('placeholder'));
                is_stop = true;
                //停止each
                return false;
            }
        });
        if (is_stop == true) {
            //不讓表單送出
            return false;
        }
    }
</script>