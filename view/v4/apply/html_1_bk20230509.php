<?
include _BASEPATH . '/../source/apply/post_1.php';
?>
<section class="sectionBlock" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">填寫計畫</h1> -->
        <div class="application-steps">
            <div class="btn-group ">
                <a href="apply_tw_1.php">
                    <div class="btn-apply-1 btn-text active">
                        1.填寫計畫
                    </div>
                </a>
                <a href="apply_tw_2.php">
                    <div class="btn-apply-1 btn-text ">
                        2.班級申請
                    </div>
                </a>
                <a href="apply_tw_3.php">
                    <div class="btn-apply-1 btn-text">
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
                <div class="mark-number">一</div>
                <div class="mark-title">
                    專案步驟
                </div>
            </div>
            <div class="application-form-title title-bot-border ">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div class="content">
                    填寫註冊表格
                    <small>請填寫以下表格，<span>「＊」</span>為必填</small>
                </div>
            </div>
            <div class="application-form ">
                <form action="" method="POST" name="applicationForm" id="form_data" class="row cont_form" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateForm()">
                    <div class="form_group col-lg-6">
                        <label class="must-label">學校全銜<span>：</span>
                        </label>
                        <input type="text" id="school_name" name="school_name" value="<?= $_SESSION['member_data']['school_name'] ?>" disabled="disabled">
                    </div>
                    <!-- <div class="form_group col-lg-6">
                        <label class="must-label">申請期別 <span>：</span>
                        </label>
                        <div class="selection-radio">
                            <div class="select">
                                <span class="placeholder">請選擇</span>
                                <ul>
                                    <li>112學年度第1學期</li>
                                    <li>112學年度第2學期</li>
                                    <li>113學年度第1學期</li>
                                    <li>113學年度第2學期</li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                    <? if (!empty($semester_array)) { ?>
                        <div class="form_group col-lg-6">
                            <label class="must-label">申請期別 <span>：</span>
                            </label>
                            <select name="cars" id="cars" class="select-radio">
                                <option value="">請選擇學期</option>
                                <? foreach ($semester_array as $k => $v) { ?>
                                    <option <?= (isset($v['have_sem']) ? 'disabled="disabled"' : '') ?> value="<?= $v['id'] ?>" <?= (isset($_SESSION['apply_1']['cars']) && $_SESSION['apply_1']['cars'] == $v['id'] ? 'selected' : '') ?>><?= $v['topic'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                    <? } ?>
                    <div class="form_group col-lg-6">
                        <label class="must-label">校長姓名 <span>：</span>
                        </label>
                        <input type="text" id="president_name" name="president_name" placeholder="請輸入姓名" value="<?= (isset($_SESSION['apply_1']['president_name']) && !empty($_SESSION['apply_1']['president_name']) ? $_SESSION['apply_1']['president_name'] : '') ?>">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">連絡電話<span>：</span>
                        </label>
                        <div class="fax-detail ">
                            <input type="tel" id="landline" name="landline" placeholder="請輸入號碼" value="<?= (isset($_SESSION['apply_1']['landline']) && !empty($_SESSION['apply_1']['landline']) ? $_SESSION['apply_1']['landline'] : '') ?>">
                            <div class=" linkmark">
                                –
                            </div>
                            <input type="tel" id="extension" name="extension" placeholder="分機" value="<?= (isset($_SESSION['apply_1']['extension']) && !empty($_SESSION['apply_1']['extension']) ? $_SESSION['apply_1']['extension'] : '') ?>" class="extension">
                        </div>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">行動電話<span>：</span>
                        </label>
                        <input type="tel" id="phone" name="phone" placeholder="請輸入號碼" value="<?= (isset($_SESSION['apply_1']['phone']) && !empty($_SESSION['apply_1']['phone']) ? $_SESSION['apply_1']['phone'] : '') ?>">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="">E-mail<span>：</span>
                        </label>
                        <input type="email" id="email" name="email" placeholder="請輸入信箱" value="<?= (isset($_SESSION['apply_1']['email']) && !empty($_SESSION['apply_1']['email']) ? $_SESSION['apply_1']['email'] : '') ?>">
                    </div>
                    <div class=" col-12">
                        <div class="application-form-title">
                            計畫簡述
                        </div>
                    </div>
                    <div class="form_group col-12">
                        <p class="remind-text">
                            ※計畫書內容務必包含學校概況、實施時間、方式及歷程，請以條列方式說明學校概況、實施時間、方式
                        </p>
                    </div>
                    <div class="form_group col-12">
                        <a class='btn-action btn-text' type="button" href="_i/assets/file/demo/112學年第2學期敦化國中計畫簡述參考範例.pdf" target=_blank>
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            範例參考
                        </a>
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="must-label ">學校概況
                            <a data-fancybox='' data-options='{"touch" : false}' data-src="#schoolProfile" href="javascript:;" class="remind-mark">?</a>
                            <span>：</span>
                        </label>
                        <textarea id="description" name="description" rows="5" cols="33" placeholder="請在此輸入學校概況..."><?= (isset($_SESSION['apply_1']['description']) && !empty($_SESSION['apply_1']['description']) ? $_SESSION['apply_1']['description'] : '') ?></textarea>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="">實施時間<span>：</span>
                        </label>
                        <input type="date" id="implement_date" name="implement_date" placeholder="請選擇日期..." value="<?= (isset($_SESSION['apply_1']['implement_date']) && !empty($_SESSION['apply_1']['implement_date']) ? $_SESSION['apply_1']['implement_date'] : '') ?>">
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="must-label">方式及歷程
                            <a data-fancybox='' data-options='{"touch" : false}' data-src="#methodAndProcess" href="javascript:;" class="remind-mark">?</a>
                            <span>：</span>
                        </label>
                        <textarea id="course" name="course" rows="5" cols="33" placeholder="請在此輸入方式及歷程..."><?= (isset($_SESSION['apply_1']['course']) && !empty($_SESSION['apply_1']['course']) ? $_SESSION['apply_1']['course'] : '') ?></textarea>
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="">備註說明<span>：</span>
                        </label>
                        <textarea id="remark" name="remark" rows="5" cols="33" placeholder="請在此輸入備註說明..."><?= (isset($_SESSION['apply_1']['remark']) && !empty($_SESSION['apply_1']['remark']) ? $_SESSION['apply_1']['remark'] : '') ?></textarea>
                    </div>

                    <div class="form_group col-lg-12" style="margin-bottom: 0;">
                        <label class="">檔案上傳<span>：</span>
                        </label>
                    </div>

                    <div class="form_group col-lg-6">
                        <div class='file-input'>
                            <input type='file' id="file1" name="file1">
                            <span class='button'>選擇檔案</span>
                            <span class='label' data-js-label>未選擇檔案</span>
                            <a href="javascript:;" class="delete-file" data-file="file1" onclick="clear_file(this);"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="form_group col-lg-6">
                        <div class='file-input'>
                            <input type='file' id="file2" name="file2">
                            <span class='button'>選擇檔案</span>
                            <span class='label' data-js-label>未選擇檔案</span>
                            <a href="javascript:;" class="delete-file" data-file="file2" onclick="clear_file(this);"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="form_group col-lg-12">
                        <div class="btn-group">
                            <button class="btn-register btn-text subbut">
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

<!-- 學校概況示範 -->

<!--lightBox 資料內容-->
<section class="lightBoxDataBlock">
    <!--Data1-->
    <div id="schoolProfile" class="lightData modal modal_half">
        <div class="pageTitleStyle-1">
            <span>示範說明</span>
        </div>
        <div class="pageTitleStyle-3">
            <span>範例一：</span>
        </div>
        <div class="content">
            <p>本校於88年8月成立並招生。全校教職員60人，學生480人(有7年級6班，8年級6班，9年級6班)。本校位置鄰近市區，學生興趣多元、個性活潑，對動態性教學活動參與力強，但弱勢及單親家庭學生多，家庭教育有時無法彰顯功能，學生學習狀況及意願不高。希望藉由推動讀報教育，彌補家庭教育之不足，並培養學生閱讀習慣，以及增加規劃語文閱讀及藝文創作等活動建立學生正確價值觀，並加強指導學生生活教育及品格教育之實施，以引導學生適性之均衡發展。</p>
        </div>
        <div class="pageTitleStyle-3">
            <span>範例二：</span>
        </div>
        <div class="content">
            <p>本校座落於XX路上，前身為XX中學，60學年度由王小明先生接任首任校長，並創設至今為一所職業學校，設立科別有美容、廣告，餐飲、觀光、資處、資訊等科，班別為編制班、實用技能班、建教班，學制為職校與進修學校，修業年限各為三年，目前學生人數職進校合計約為2000人。</p>
        </div>
    </div>
    <!--Data1 End-->


    <!-- 學校概況示範 -->

    <div id="methodAndProcess" class="modal modal_half ">
        <div class="pageTitleStyle-1">
            <span>示範說明</span>
        </div>
        <div class="pageTitleStyle-3">
            <span>範例一：</span>
        </div>
        <div class="content">
            實施方式：
            <ol>
                <li>報紙張貼報架自由閱讀。</li>
                <li>時事、文章閱讀剪貼及自由創作。</li>
                <li>新聞時事、國內外大事提問及討論。</li>
                <li>運用“少年天地”等版，輔助作文教學。</li>
                <li>運用“另類財富”、“醫藥”等版面，實施品德、生命及健康教育。</li>
            </ol>
            實施歷程：
            <ol>
                <li>從三年級開始實施，落實紮根工作，讓學生墊定讀報基本能力。</li>
                <li>由認識報紙，到蒐集資料、運用資料，充分發揮報紙功能。</li>
                <li>藉由人間福報涵養三好性格，落實品德教育。</li>
            </ol>
        </div>

        <div class="pageTitleStyle-3">
            <span>範例二：</span>
        </div>
        <div class="content">
            方式及歷程：
            <ol>
                <li>以人間福報為主，晨間閱讀為輔。</li>
                <li>學校提供三年級、四年級各班一份人間福報。</li>
                <li>新聞時事、國內外大事提問及討論。</li>
                <li>教師辦公室提供閱讀資料，供老師影印指導讀報教育之用。</li>
                <li>教師辦公室教學資料補給站，提供過期人間福報剪報資料。</li>
            </ol>

        </div>
        <button data-fancybox-close="" class="fancybox-close-small" title="Close"></button>
    </div>

</section>
<!--lightBox 資料內容 End-->



<script m="body_end">
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
            alert('您選擇上傳的檔案大小總和超過' + num_mb + 'MB，請重新選擇！');
            $('.subbut').hide();
        } else {
            $('.subbut').show();
        }
    });

    function clear_file(e) {
        $('#' + $(e).data('file')).val('');
        // console.log($('#'+$(e).data('file')).val());
        $(e).prev().html("<span class='label' data-js-label>未選擇檔案</span>");
    }

    function validateForm() {
        var is_stop = false;
        $check_array = ['president_name', 'landline', 'phone', 'description', 'course'];
        var x = $("form").serializeArray();
        // console.log(x);
        $.each(x, function() {
            if (this.name == 'cars' && this.value == '') {
                alert('請選擇學期');
                is_stop = true;
                //停止each
                return false;
            } else if ($.inArray(this.name, $check_array) != '-1' && this.value == '') {
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