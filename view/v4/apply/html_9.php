<?
include _BASEPATH . '/../source/apply/post_9.php';
?>
<section class="sectionBlock" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">資料編輯</h1> -->
        <!-- <div class="application-steps">
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
        </div> -->
        <div class="form-border">
            <!-- <div class="application-steps-mark">
                <div class="mark-number">一</div>
                <div class="mark-title">
                    專案步驟
                </div>
            </div> -->
            <div class="application-form-title title-bot-border form-border-no-title ">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div class="content">
                    修改註冊表格
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

                    <? if (!empty($semester_data)) { ?>
                        <div class="form_group col-lg-6">
                            <label class="must-label">申請期別 <span>：</span>
                            </label>
                            <select <?=($is_revise==false?' disabled="disabled" ':'')?> name="cars" id="cars" class="select-radio">
                                <option value="<?= $semester_data['id'] ?>"><?= $semester_data['topic'] ?></option>

                            </select>
                        </div>
                    <? } ?>
                    <div class="form_group col-lg-6">
                        <label class="must-label">校長姓名 <span>：</span>
                        </label>
                        <input <?=($is_revise==false?' disabled="disabled" ':'')?> type="text" id="president_name" name="president_name" placeholder="請輸入姓名" value="<?= $writeplan_array['president_name'] ?>">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">連絡電話<span>：</span>
                        </label>
                        <div class="fax-detail ">
                            <input <?=($is_revise==false?' disabled="disabled" ':'')?> type="tel" id="landline" name="landline" placeholder="請輸入號碼" value="<?= $writeplan_array['landline'] ?>">
                            <div class=" linkmark">
                                –
                            </div>
                            <input <?=($is_revise==false?' disabled="disabled" ':'')?> type="tel" id="extension" name="extension" placeholder="分機" value="<?= $writeplan_array['extension'] ?>" class="extension">
                        </div>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">行動電話<span>：</span>
                        </label>
                        <input <?=($is_revise==false?' disabled="disabled" ':'')?> type="tel" id="phone" name="phone" placeholder="請輸入號碼" value="<?= $writeplan_array['phone'] ?>">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="">E-mail<span>：</span>
                        </label>
                        <input <?=($is_revise==false?' disabled="disabled" ':'')?> type="email" id="email_p" name="email_p" placeholder="請輸入信箱" value="<?= $writeplan_array['email'] ?>">
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
                        <button class='btn-action btn-text' type="button">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            範例參考
                        </button>
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="must-label">計畫簡述<span>：</span>
                        </label>
                        <textarea <?=($is_revise==false?' disabled="disabled" ':'')?> id="description" name="description" rows="5" cols="33" placeholder="請在此輸入計畫簡述"><?= $writeplan_array['description'] ?></textarea>
                    </div>
                    <div class="form_group col-12">
                        <label class="">實施時間<span>：</span>
                        </label>
                        <input <?=($is_revise==false?' disabled="disabled" ':'')?> type="date" id="implement_date" name="implement_date" placeholder="請選擇日期" value="<?= date('Y-m-d', strtotime($writeplan_array['implement_date'])) ?>">
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="must-label">方式及歷程<span>：</span>
                        </label>
                        <textarea <?=($is_revise==false?' disabled="disabled" ':'')?> id="course" name="course" rows="5" cols="33" placeholder="請在此輸入方式及歷程"><?= $writeplan_array['course'] ?></textarea>
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="">備註說明<span>：</span>
                        </label>
                        <textarea <?=($is_revise==false?' disabled="disabled" ':'')?> id="remark" name="remark" rows="5" cols="33" placeholder="請在此輸入備註說明"><?= $writeplan_array['remark'] ?></textarea>
                    </div>
                    <div class="form_group col-lg-12" style="margin-bottom: 0;">
                        <label class="">檔案上傳<span>：</span>
                        </label>
                    </div>
                    <div class="form_group col-lg-6">
                        <div class='file-input <?= (!empty($writeplan_array['file1']) ? ' -chosen ' : '') ?>'>
                            <?if($is_revise!=false){?>
                                <input type='file' id="file1" name="file1">
                                <span class='button'>選擇檔案</span>
                                <span class='label' data-js-label>未選擇檔案</span>
                            <?}?>
                            <?if(!empty($writeplan_array['file1']) && $is_revise!=false){?><a href="javascript:;" class="delete-file" data-table="writeplan" data-field="file1" data-name="<?=$writeplan_array['file1']?>" data-id="<?=$writeplan_array['id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a><? } ?>
                        </div>
                        <? if (!empty($writeplan_array['file1'])) { ?><a href="<?= $data_path . '/' . $writeplan_array['file1'] ?>" target="_blank" style="color:red;">點此開啟已上傳檔案</a><? } ?>
                    </div>
                    <div class="form_group col-lg-6">
                        <div class='file-input <?= (!empty($writeplan_array['file2']) ? ' -chosen ' : '') ?>'>
                            <?if($is_revise!=false){?>
                                <input type='file' id="file2" name="file2">
                                <span class='button'>選擇檔案</span>
                                <span class='label' data-js-label>未選擇檔案</span>
                            <?}?>    
                            <?if(!empty($writeplan_array['file2']) && $is_revise!=false){?><a href="javascript:;" class="delete-file" data-table="writeplan" data-field="file2" data-name="<?=$writeplan_array['file2']?>" data-id="<?=$writeplan_array['id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a><? } ?>
                        </div>
                        <? if (!empty($writeplan_array['file2'])) { ?><a href="<?= $data_path . '/' . $writeplan_array['file2'] ?>" target="_blank" style="color:red;">點此開啟已上傳檔案</a><? } ?>
                    </div>
                </form>
                <div class="title-bot-border col-lg-12 back_top"></div>
                
                <div class="form_group col-lg-12 ">
                    <div class="application-form-title  ">
                        <div class="title-label">
                            <div class="title-label-border"></div>
                            <p>步驟.A</p>

                        </div>
                        班級資料
                    </div>
                </div>

                <div class="form_group col-lg-12 addclassdiv" style="display:none">
                    <form action="POST" name="form_data_c" id="form_data_c" class=" cont_form" autocomplete="off">
                        <!-- 班級資料 -->
                        <input type="hidden" id="writeplan_id" name="writeplan_id" value="<?= $_GET['writeplan_id'] ?>">
                        <input type="hidden" id="semester" name="semester" value="<?= $semester_data['id'] ?>">
                        <input type="hidden" id="class_id" name="class_id" value="">
                        <div class="application-form">
                            <div class="row">
                                <div class="form_group col-lg-6">
                                    <label class="must-label">年級班級<span>：</span>
                                    </label>
                                    <input type="text" id="class_name" name="class_name" placeholder="請輸入年級班別" value="">
                                </div>
                                <div class="form_group col-lg-6">
                                    <label class="must-label">學生數 <span>：</span>
                                    </label>
                                    <input type="text" id="student_num" name="student_num" placeholder="請輸入學生數" value="">
                                </div>

                                <div class="form_group col-lg-6">
                                    <label class="must-label">教師姓名 <span>：</span>
                                    </label>
                                    <input type="text" id="teacher_name" name="teacher_name" placeholder="請輸入教師姓名" value="">
                                </div>

                                <div class="form_group col-lg-6">
                                    <label class="must-label">Email <span>：</span>
                                    </label>
                                    <input type="text" id="email" name="email" placeholder="請輸入Email" value="">
                                </div>
                            </div>
                            <div class="first-group-paragraphs col-lg-12">
                                <div class="btn-group">
                                    <button class="btn-operate btn-text addclass_sub" type="button">
                                        確定新增
                                    </button>
                                    <button class="btn-operate btn-text upclass_sub" type="button" style="display:none">
                                        確定修改
                                    </button>
                                    <button class="btn-operate btn-text closureaddclass" type="button">
                                        結束新增
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--申請明細  -->

                <div class="application-form-details">

                    <div class="top-function-column">
                        <div class='add-area'>
                            <button class='btn-register btn-text addclass' <?= ($is_revise == true ? '' : 'style="display:none"') ?>>
                                增加班級
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="responsive_tbl">
                        <table class="tableList ">
                            <thead>
                                <tr>
                                    <th>年級/班別</th>
                                    <th>教師姓名</th>
                                    <th>學生數</th>
                                    <th>E-mail</th>
                                    <th>操作</th>

                                </tr>

                            </thead>
                            <tbody>
                                <? if (!empty($writeplan_class)) {
                                    foreach ($writeplan_class as $k => $v) { ?>
                                        <tr>
                                            <td><?= $v['class_name'] ?></td>
                                            <td><?= $v['teacher_name'] ?></td>
                                            <td><?= $v['student_num'] ?></td>
                                            <td><?= $v['email'] ?></td>
                                            <td>
                                                <? if ($is_revise == true) { ?>
                                                    <div class="btn-group">
                                                        <a class="btn-revise btn-text class_upload" data-cid="<?= $v['id'] ?>">
                                                            修改
                                                        </a>
                                                        <a class="btn-delete btn-text class_delete" data-cid="<?= $v['id'] ?>">
                                                            刪除
                                                        </a>
                                                    </div>
                                                <? } ?>
                                            </td>
                                        </tr>
                                <? }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 table-footer">
                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <div class="row label-group">
                                    <div class="col-12 col-lg-4 ">
                                        <div class="footer-label">
                                            總計： <span> <?= $writeplan_array['class_name'] ?></span> 班
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="footer-label">
                                            人數： <span> <?= $writeplan_array['student_name'] ?></span> 人
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="footer-label">
                                            實際報份： <span> <?= $writeplan_array['actual_num'] ?></span> 份
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="row label-group">
                                    <div class="footer-label application-field ">
                                        希望報份： <input <?=($is_revise==false?' disabled="disabled" ':'')?> type="text" id="apply_num" name="apply_num" placeholder="請輸入數量" value="<?= $writeplan_array['apply_num'] ?>"> 份
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <? if ($writeplan_array['a_results'] != '核可') { ?>
                        <!-- 按鈕 -->
                        <div class="form_group col-lg-12">
                            <div class="btn-group">
                                <button class="btn-register btn-text subbut" <?= ($is_revise == true ? '' : 'style="display:none"') ?>>
                                    確認修改
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    <? } ?>
                <? if ($writeplan_array['a_results'] != '') { ?>        
                    <div class="application-form-title title-bot-border ">
                        <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                        <div class="content">
                            審核結果
                        </div>
                    </div>

                    <div class="cont_form">
                        <div class="row">
                            <div class="form_group col-lg-6">
                                <label class="">審查意見<span>：</span>
                                </label>
                                <input type="text" id="name" name="name" placeholder="" value="<?=$writeplan_array['r_comments']?>" disabled="disabled">
                            </div>

                            <div class="form_group col-lg-6">
                                <label class="">審查結果<span>：</span>
                                </label>
                                <input type="text" id="name" name="name" placeholder="" value="<?=$writeplan_array['a_results']?>" disabled="disabled">
                            </div>
                            <?if($writeplan_array['a_results']=='核可'){?>
                            <div class="form_group col-lg-6">
                                <label class="">核可報份<span>：</span>
                                </label>
                                <input type="text" id="name" name="name" placeholder="" value="<?=$writeplan_array['approved_num']?>" disabled="disabled">
                            </div>
                            <?}?>
                            <div class="form_group col-lg-6">
                                <label class="">審查日期<span>：</span>
                                </label>
                                <input type="text" id="name" name="name" placeholder="" value="<?=$writeplan_array['review_time']?>" disabled="disabled">
                            </div>
                        </div>
                    </div>
                <?}?>    
                    <div class="btn-group class-btn-group">
                        <a class="btn-apply-1 btn-text" href="apply_tw_4.php">
                            返回列表
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- .container -->
</section><!-- .sectionBlock -->
<? if ($writeplan_array['a_results'] != '核可') { ?>
    <script>
        //顯示班級新增欄位
        var addclass = document.querySelector('.addclass');
        //關閉班級新增欄位
        var closureaddclass = document.querySelector('.closureaddclass');
        //送出班級新增欄位
        var addclass_sub = document.querySelector('.addclass_sub');
        //個別班級刪除
        var class_delete = document.querySelectorAll('.class_delete');
        //個別班級修改
        var class_upload = document.querySelectorAll('.class_upload');
        //送出修改班級欄位
        var upclass_sub = document.querySelector('.upclass_sub');
        //表單送出
        var subbut = document.querySelector('.subbut');

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
        }
        //顯示班級新增欄位
        addclass.addEventListener('click', function(e) {
            $('.addclassdiv').show();
            $('.upclass_sub').hide();
            $('.addclass_sub').show();
            $('.add_class_data').html('新增班級資料');
            //欄位清空
            $('#class_name').val('');
            $('#student_num').val('');
            $('#teacher_name').val('');
            $('#email').val('');
            $('#class_id').val('');
            document.querySelector('.back_top').scrollIntoView(true)
        }, false);
        //關閉班級新增欄位
        closureaddclass.addEventListener('click', function(e) {
            $('.addclassdiv').hide();
        }, false);
        //送出班級新增欄位
        addclass_sub.addEventListener('click', function(e) {
            $check_array = ['class_name', 'student_num', 'teacher_name', 'email'];
            var is_stop = false;
            var x = $("#form_data_c").serializeArray();
            console.log(x);
            $.each(x, function() {
                if ($.inArray(this.name, $check_array) != '-1' && this.value == '') {
                    alert($('#' + this.name).attr('placeholder'));
                    is_stop = true;
                    return false;
                }
            });
            if (is_stop == false) {
                $.ajax({
                    type: "POST",
                    data: {
                        'type': 'add_class',
                        'writeplan_id': x[0].value,
                        'semester': x[1].value,
                        'class_name': x[3].value,
                        'student_num': x[4].value,
                        'teacher_name': x[5].value,
                        'email': x[6].value,
                    },
                    url: 'apply_post.php',
                    success: function(response) {
                        // console.log(response);
                        txt = response.split('@@');
                        if (txt[0] != 1) {
                            alert(txt[1]);
                        } else {
                            // console.log(response);
                            $('.class_list').html(txt[1]);
                            $('.all_class').html('總計： ' + txt[2] + ' 班');
                            $('.all_num').html('人數： ' + txt[3] + ' 人');
                            $('.report_num').html('實際報份： ' + txt[4] + ' 份');
                            alert('新增成功!');
                            location.reload();
                        }
                    }
                }); // ajax
            }
        }, false);
        //個別班級刪除
        for (let i = 0; i < class_delete.length; i++) {
            class_delete[i].addEventListener("click", function(e) {
                if (confirm("是否要刪除?") == true) {
                    let id = class_delete[i].dataset.cid;
                    $.ajax({
                        type: "POST",
                        data: {
                            'type': 'del_class',
                            'data_id': id,
                            'writeplan_id': '<?= $_GET['writeplan_id'] ?>',
                        },
                        url: 'apply_post.php',
                        success: function(response) {
                            // console.log(response);
                            alert('班級已刪除!');
                            location.reload();
                        }
                    }); // ajax
                }
            });
        }
        //個別班級修改
        for (let i = 0; i < class_upload.length; i++) {
            class_upload[i].addEventListener("click", function(e) {
                let id = class_upload[i].dataset.cid;
                $.ajax({
                    type: "POST",
                    data: {
                        'type': 'pull_class',
                        'data_id': id,
                        'writeplan_id': '<?= $_GET['writeplan_id'] ?>',
                    },
                    url: 'apply_post.php',
                    success: function(response) {
                        response_arr = JSON.parse(response);
                        $('.addclassdiv').show();
                        $('.upclass_sub').show();
                        $('.addclass_sub').hide();
                        $('.add_class_data').html('修改班級資料');
                        $('.closureaddclass').html('結束修改');
                        //將資料帶入欄位
                        $('#class_name').val(response_arr['class_name']);
                        $('#student_num').val(response_arr['student_num']);
                        $('#teacher_name').val(response_arr['teacher_name']);
                        $('#email').val(response_arr['email']);
                        $('#class_id').val(response_arr['id']);
                        document.querySelector('.back_top').scrollIntoView(true);
       
                    }
                }); // ajax
            });
        }
        //送出修改班級欄位
        upclass_sub.addEventListener('click', function(e) {
            $check_array = ['class_name', 'student_num', 'teacher_name', 'email'];
            var is_stop = false;
            var x = $("#form_data_c").serializeArray();
            $.each(x, function() {
                if ($.inArray(this.name, $check_array) != '-1' && this.value == '') {
                    alert($('#' + this.name).attr('placeholder'));
                    is_stop = true;
                    return false;
                }
            });
            if (is_stop == false) {
                $.ajax({
                    type: "POST",
                    data: {
                        'type': 'up_class',
                        'writeplan_id': x[0].value,
                        'semester': x[1].value,
                        'class_id': x[2].value,
                        'class_name': x[3].value,
                        'student_num': x[4].value,
                        'teacher_name': x[5].value,
                        'email': x[6].value,
                    },
                    url: 'apply_post.php',
                    success: function(response) {
                        // console.log(response);
                        txt = response.split('@@');
                        if (txt[0] != 1) {
                            alert(txt[1]);
                            // alert(txt[1]);
                        } else {
                            // console.log(response);
                            $('.class_list').html(txt[1]);
                            $('.all_class').html('總計： ' + txt[2] + ' 班');
                            $('.all_num').html('人數： ' + txt[3] + ' 人');
                            $('.report_num').html('實際報份： ' + txt[4] + ' 份');
                            alert('修改成功!');
                            location.reload();
                        }
                    }
                }); // ajax
            }
        }, false);
        //表單送出
        <? if ($is_revise == true) { ?>
            subbut.addEventListener('click', function(e) {
                var apply_num = document.getElementById('apply_num').value;
                $check_array = ['class_name', 'student_num', 'teacher_name', 'email'];
                var is_stop = false;
                var x = $("#form_data").serializeArray();
                //console.log(apply_num);
                $check_array = ['president_name', 'landline', 'phone', 'description', 'course'];
                $.each(x, function() {
                    if ($.inArray(this.name, $check_array) != '-1' && this.value == '') {
                        alert($('#' + this.name).attr('placeholder'));
                        is_stop = true;
                        //停止each
                        return false;
                    }
                });
                if (is_stop == false) {
                    if (Math.sign(apply_num) != 1) {
                        apply_num = '<?= $writeplan_array['actual_num'] ?>';
                    }
                    var myForm = document.getElementById('form_data');
                    formData = new FormData(myForm);
                    formData.append('apply_num', apply_num);
                    formData.append('type', 'up_writeplan');
                    formData.append('writeplan_id', <?= $_GET['writeplan_id'] ?>);
                    $.ajax({
                        type: "POST",
                        'contentType': false, //required
                        'processData': false, // required
                        'mimeType': 'multipart/form-data',
                        data: formData,
                        url: 'apply_post.php',
                        success: function(response) {
                            // console.log(response);
                            txt = response.split('@@');
                            if (txt[0] != 1) {
                                alert(txt[1]);
                            } else {
                                alert('修改成功!');
                                history.back();
                            }
                        }
                    }); // ajax
                }
            }, false);
        <? } ?>
    </script>
<? } ?>