<?
include _BASEPATH . '/../source/apply/post_6.php';
?>
<section class="sectionBlock" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">開創教師帳號</h1> -->
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
                    <div class="btn-apply-2 btn-text active">
                        開創教師帳號
                    </div>
                </a>
                <a href="apply_tw_7.php">
                    <div class="btn-apply-2 btn-text ">
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
            <div class="application-form-title  form-border-no-title ">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div class=' content'>
                    新增教師帳號
                    <small>請填寫以下表格，<span>「＊」</span>為必填</small>
                </div>
            </div>
            <!-- 新增教師帳號 -->
            <div class="application-form  teacher-account-management-form addclassdiv" style="display:none">
                <form method="POST" name="applicationForm" id="form_data" class="row cont_form" autocomplete="off">
                    <input type="hidden" id="member_id" name="member_id" value="<?= $_SESSION['member_data']['id'] ?>">
                    <input type="hidden" id="account_id" name="account_id">
                    <div class="form_group col-lg-6">
                        <label class="must-label">教師姓名 <span>：</span>
                        </label>
                        <input type="text" id="name" name="name" placeholder="請輸入教師姓名" value="">
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="must-label">類別<span>：</span>
                        </label>
                        <select  id="other3" name="other3" class="select-radio">
                            <option value="國小組">國小組</option>
                            <option value="國中組">國中組</option>
                            <option value="高中職組">高中職組</option>
                            <option value="大專校院組">大專校院組</option>
                        </select>
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="must-label">申請期別(可以複選所需期別) <span>：</span>
                        </label>
                        <select class="apply-semester" name="semesters[]" multiple></select>
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="must-label">年級班級 <span>：</span>
                        </label>
                        <select name="other6" id="other6" class="select-radio">
                            <option value="">請先選擇期別</option>
                        </select>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">登入帳號<span>：</span>
                        </label>
                        <input type="text" id="login_account" name="login_account" onchange="changeaccount()" placeholder="請輸入登入帳號" value="">
                        <p class="show_acct_text" style="color:red;display:none;">您輸入的帳號已被註冊，請重新填寫！</p>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">密碼 <span>：</span>
                        </label>
                        <input type="password" id="login_password" name="login_password" placeholder="請輸入密碼" value="">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">再次輸入密碼 <span>：</span>
                        </label>
                        <input type="password" id="login_password2" name="login_password2" placeholder="請再輸入密碼" value="">
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="">備註<span>：</span>
                        </label>
                        <textarea id="sms_text" name="sms_text" rows="5" cols="33" placeholder="請在此輸入內容"></textarea>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">權限 <span>：</span>
                        </label>
                        <div class="row">
                            <div class="col-3 radio-label">
                                開啟<input type="radio" name="is_enable" value="1" checked/>
                            </div>
                            <div class="col-3 radio-label">
                                關閉 <input type="radio" name="is_enable" value="0" />
                            </div>
                        </div>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">身份 <span>：</span>
                        </label>
                        <div class="row">
                            <div class="col-3 radio-label">
                                老師<input type="radio" name="member_grade" value="2" />
                            </div>
                            <div class="col-3 radio-label">
                                學生<input type="radio" name="member_grade" value="3" />
                            </div>
                        </div>

                    </div>
                    <div class="first-group-paragraphs col-lg-12">
                        <div class="btn-group">
                            <button class="btn-operate btn-text addclass_sub" type="button">
                                確定新增
                            </button>
                            <button class="btn-operate btn-text up_account" type="button" style="display:none">
                                確定修改
                            </button>
                            <button class="btn-operate btn-text closureaddclass" type="button">
                                結束新增
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- 教師帳號管理 -->
            <div class="application-form-details">
                <div class="top-function-column">
                    <div class='add-area'>
                        <button class='btn-register btn-text addclass'>
                            新增帳號
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                        <form class="form-side-function-column" method="get" action="apply_<?= $this->data['ml_key'] ?>_6.php">
                            <div class="input-field">
                                <label class="must-label">教師姓名 <span>：</span></label>
                                <input type="text" id="search" name="search" placeholder="請輸入教師姓名" value="">
                            </div>
                            <div class="copyBtn">
                                <button class="btn-operate btn-text">
                                    搜尋
                                </button>
                            </div>
                            <button class="btn-operate btn-text">
                                清除搜尋
                            </button>
                        </form>
                    </div>
                </div>
                <div class="responsive_tbl">
                    <table class="tableList">
                        <thead>
                            <tr>
                                <th>創立日期</th>
                                <th>教師姓名</th>
                                <th>帳號</th>
                                <th>類別</th>
                                <th>期別</th>
                                <th>年級班級</th>
                                <th>權限</th>
                                <th>身分</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($account_data as $k => $v) { ?>
                                <tr>
                                    <td>
                                        <?= date('Y-m-d H:i:s', strtotime($v['create_time'])) ?>
                                    </td>
                                    <td><?= $v['name'] ?></td>
                                    <td><?= $v['login_account'] ?></td>
                                    <td><?= $v['other3'] ?></td>
                                    <td>
                                        <? if (isset($v['other7']) && !empty($v['other7'])) {
                                            foreach ($v['other7'] as $kk => $vv) {
                                                if (!empty($vv)) {
                                                    echo $semester[$vv] . '<br>';
                                                }
                                            }
                                        } ?>
                                    </td>
                                    <td><?= $class_data[$v['other6']] ?></td>
                                    <td>
                                        <label class="permission-checkbox">
                                            <?= ($v['is_enable'] == 1 ? '開啟' : '關閉') ?>
                                        </label>
                                    </td>
                                    <td> <?= ($v['member_grade'] == 2 ? '教師' : '學生') ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn-revise btn-text pull_account" data-cid="<?= $v['id'] ?>">
                                                編輯
                                            </a>
                                            <a class="btn-delete btn-text account_delete" data-cid="<?= $v['id'] ?>">
                                                刪除
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <? } ?>
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
    $(function() {
        $(".apply-semester").select2({
            language: 'zh-TW',
            width: '100%',
            // 最多字元限制
            maximumInputLength: 10,
            // 最少字元才觸發尋找, 0 不指定
            minimumInputLength: 0,
            // 當找不到可以使用輸入的文字
            tags: true,
            data: [
                <? foreach ($class_semester_array as $k => $v) { ?> {
                        id: '<?=$k?>',
                        text: '<?=$v?>',
                        // selected:'selected',
                    },
                <? } ?>
            ],
        });
    })
    $(".apply-semester").change(function() {
        if ($(this).val() != '') {
            if ($('#other6').val() != '') {
                var class_id = $('#other6').val();
            } else {
                var class_id = '';
            }
            $.ajax({
                type: "POST",
                data: {
                    'type': 'slelect_class',
                    'data_id': $(this).val(),
                    'class_id': class_id,
                },
                url: 'apply_post.php',
                success: function(response) {
                    // console.log(response);
                    txt = response.split('@@');
                    if (txt[0] != 1) {
                        $('#other6').html('<option value="" selected>' + txt[1] + '</option>');
                    } else {
                        $('#other6').html(txt[1]);
                    }
                }
            });
        } else {
            $('#other6').html('<option value="">請先選擇期別</option>');
        }
    });
    //顯示帳號新增欄位
    var addclass = document.querySelector('.addclass');
    //關閉帳號新增欄位
    var closureaddclass = document.querySelector('.closureaddclass');
    //送出帳號新增欄位
    var addclass_sub = document.querySelector('.addclass_sub');
    //個別帳號刪除
    var account_delete = document.querySelectorAll('.account_delete');
    //個別帳號修改
    var pull_account = document.querySelectorAll('.pull_account');
    //送出修改帳號欄位
    var up_account = document.querySelector('.up_account');
    //顯示帳號新增欄位
    addclass.addEventListener('click', function(e) {
        $('.addclassdiv').show();
        $('.up_account').hide();
        $('.addclass_sub').show();
        $('.add_class_data').html('新增帳號資料');
        //欄位清空
        clear_data();
        //畫面上滑到該區塊
        document.querySelector('.application-steps').scrollIntoView(true);

        // document.querySelector('#form_data').focus();
        // $('#form_data').focus(true);

    }, false);
    //關閉班級新增欄位
    closureaddclass.addEventListener('click', function(e) {
        $('.addclassdiv').hide();
        clear_data();
    }, false);
    //送出帳號新增欄位
    addclass_sub.addEventListener('click', function(e) {
        $check_array = ['login_account', 'name', 'other6', 'login_password', 'login_password2'];
        var is_stop = false;
        var x = $("#form_data").serializeArray();
        $.each(x, function() {
            if ($.inArray(this.name, $check_array) != '-1' && this.value == '') {
                alert($('#' + this.name).attr('placeholder'));
                is_stop = true;
                return false;
            }
        });
        if (is_stop == false) {
            var myForm = document.getElementById('form_data');
            formData = new FormData(myForm);
            formData.append('type', 'addclass_account');
            $.ajax({
                type: "POST",
                'contentType': false, //required
                'processData': false, // required
                data: formData,
                url: 'apply_post.php',
                success: function(response) {
                    
                    txt = response.split('@@');
                    if (txt[0] != 1) {
                        alert(txt[1]);
                    } else {
                        alert('新增成功!');
                        location.reload();
                    }
                }
            }); // ajax
        }
    }, false);
    //個別帳號刪除
    for (let i = 0; i < account_delete.length; i++) {
        account_delete[i].addEventListener("click", function(e) {
            if (confirm("是否要刪除?") == true) {
                let id = account_delete[i].dataset.cid;
                $.ajax({
                    type: "POST",
                    data: {
                        'type': 'del_account',
                        'data_id': id,
                    },
                    url: 'apply_post.php',
                    success: function(response) {
                        alert('帳號已刪除!');
                        location.reload();
                    }
                }); // ajax
            }
        });
    }
    //個別帳號拉資料
    for (let i = 0; i < pull_account.length; i++) {
        pull_account[i].addEventListener("click", function(e) {
            let id = pull_account[i].dataset.cid;
            $.ajax({
                type: "POST",
                data: {
                    'type': 'pull_account',
                    'data_id': id,
                },
                url: 'apply_post.php',
                success: function(response) {
                    response_arr = JSON.parse(response);
                    // //欄位清空
                    clear_data();
                    // console.log(response_arr);
                    $("#other6").html(response_arr['other6']);
                    var result = response_arr['other7'].split(',');
                    for (let i = 0; i < result.length; i++) {
                        $(".apply-semester option[value='" + result[i] + "']").attr("selected", "selected");
                    }
                    $(".apply-semester option").trigger('change');
                    $('.addclassdiv').show();
                    $('.up_account').show();
                    $('.addclass_sub').hide();
                    $('.add_class_data').html('修改帳號資料');
                    $('.closureaddclass').html('結束修改');
                    //將資料帶入欄位
                    $('#account_id').val(response_arr['id']);
                    $('#login_account').val(response_arr['login_account']);
                    $('#login_account').attr('disabled', true);
                    $('#name').val(response_arr['name']);
                    $('#other3').val(response_arr['other3']);
                    $('#sms_text').val(response_arr['sms_text']);
                    $('input:radio[name=is_enable]').filter('[value=' + response_arr['is_enable'] + ']').prop('checked', true);
                    $('input:radio[name=member_grade]').filter('[value=' + response_arr['member_grade'] + ']').prop('checked', true);
                    document.querySelector('.application-steps').scrollIntoView(true)

                }
            }); // ajax
        });
    }
    //送出修改班級欄位
    up_account.addEventListener('click', function(e) {
        $check_array = ['name', 'other6'];
        var is_stop = false;
        var x = $("#form_data").serializeArray();
        $.each(x, function() {
            if ($.inArray(this.name, $check_array) != '-1' && this.value == '') {
                alert($('#' + this.name).attr('placeholder'));
                is_stop = true;
                return false;
            }
        });
        if (is_stop == false) {
            var myForm = document.getElementById('form_data');
            formData = new FormData(myForm);
            formData.append('account_id', $('#account_id').val());
            formData.append('type', 'up_account');
            $.ajax({
                type: "POST",
                'contentType': false, //required
                'processData': false, // required
                data: formData,
                url: 'apply_post.php',
                success: function(response) {
                    // console.log(response);
                    txt = response.split('@@');
                    if (txt[0] != 1) {
                        alert(txt[1]);
                    } else {
                        alert('修改成功!');
                        location.reload();
                    }
                }
            }); // ajax
        }
    }, false);
    //清空欄位資料
    function clear_data() {
        $('#account_id').val('');
        $('#login_account').val('');
        $('#login_account').attr('disabled', false);
        $('#login_password').val('');
        $('#login_password2').val('');
        $('#name').val('');
        $('#other3').val('');
        $('#sms_text').val('');
        $("#other6 option").each(function() {
            $(this).attr("selected", false);
        });
        $(".apply-semester option").attr("selected", false);
        $(".apply-semester option").trigger('change');
        $('input:radio[name=is_enable]').prop('checked', false);
        $('input:radio[name=member_grade]').prop('checked', false);

    }
    //帳號檢測
    function changeaccount() {
        var account = $("#login_account").val();
        $.ajax({
            type: "POST",
            data: {
                'type': 'account_register',
                'account': account,
            },
            url: 'apply_post.php',
            success: function(response) {
                // console.log(response);
                if (response == 1) {
                    alert('您輸入的帳號已被註冊，請重新填寫！');
                    $('.addclass_sub').hide();
                    $('.show_acct_text').show();
                } else {
                    $('.addclass_sub').show();
                    $('.show_acct_text').hide();
                }
            }
        }); // ajax
    }
</script>