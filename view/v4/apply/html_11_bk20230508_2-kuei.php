<section class="sectionBlock" data-about="1">
    <div class="container">

        <!-- <h1 class="text-center apply-title">註冊資料</h1> -->


        <div class="form-border">

            <div class="application-form-title  form-border-no-title title-bot-border">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div class="content">
                    填寫註冊表格
                    <small>請填寫以下表格，<span>「＊」</span>為必填</small>
                </div>
            </div>

            <div class="application-form application-form-detail  ">
                <form target="" method="POST" name="applicationForm" id="form_data" class="row cont_form" autocomplete="off" onsubmit="return validateForm()">


                    <div class="form_group col-lg-6">
                        <label class="must-label">學校全銜<span>：</span>
                        </label>
                        <input type="text" id="school_name" name="school_name" placeholder="請依教育部登記之全銜" value="">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">學校統編 <span>：</span>
                        </label>
                        <input type="text" id="school_compilation" name="school_compilation" placeholder="請輸入學校統編" value="">
                    </div>
                    <?/*<div class="form_group col-lg-6">
            <label class="must-label">學校代碼 <span>：</span>
            </label>
            <input type="text" id="the_code" name="the_code" onchange="changecode()" placeholder="請輸入學校代碼 限制輸入英文和數字" value="">
            <p class="show_code_text" style="color:red;display:none;">您輸入的學校代碼已被註冊，請重新填寫！</p>
          </div>*/ ?>
                    <div class="form_group col-lg-6">
                        <label class="must-label">類別 <span>：</span>
                        </label>
                        <select name="school_type" id="school_type" class="select-radio">
                            <option value="國小組">國小組</option>
                            <option value="國中組">國中組</option>
                            <option value="高中職組">高中職組</option>
                            <option value="大專校院組">大專校院組</option>
                        </select>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">行政區 <span>：</span></label>
                        <select name="administrative" id="administrative" class="select-radio">
                            <option value="">縣市</option>
                            <option value="基隆市">基隆市</option>
                            <option value="臺北市">臺北市</option>
                            <option value="新北市">新北市</option>
                            <option value="宜蘭縣">宜蘭縣</option>
                            <option value="新竹市">新竹市</option>
                            <option value="新竹縣">新竹縣</option>
                            <option value="桃園市">桃園市</option>
                            <option value="苗栗縣">苗栗縣</option>
                            <option value="臺中市">臺中市</option>
                            <option value="彰化縣">彰化縣</option>
                            <option value="南投縣">南投縣</option>
                            <option value="嘉義市">嘉義市</option>
                            <option value="嘉義縣">嘉義縣</option>
                            <option value="雲林縣">雲林縣</option>
                            <option value="臺南市">臺南市</option>
                            <option value="高雄市">高雄市</option>
                            <option value="屏東縣">屏東縣</option>
                            <option value="臺東縣">臺東縣</option>
                            <option value="花蓮縣">花蓮縣</option>
                            <option value="金門縣">金門縣</option>
                            <option value="連江縣">連江縣</option>
                            <option value="澎湖縣">澎湖縣</option>
                        </select>
                    </div>


                    <div class="first-group-paragraphs col-lg-12"></div>

                    <div class="form_group col-lg-12 address-group-title">
                        <label class="must-label must-label-directions">
                            <div class="top">
                                學校詳細地址
                                <span>：</span>
                            </div>
                            <div class="bottom bottom-address">
                                <small class="">請務必選填「路or街」， ex.松隆「路」...</small>
                            </div>
                        </label>
                        <div class="address">
                            <!-- 地址第一段 -->
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="address-detail">
                                        郵遞區號
                                        <input type="text" id="postal" name="postal" placeholder="請輸入郵遞區號" value="" min="0" maxlength="3">
                                    </div>


                                </div>
                                <div class="col-lg-4">
                                    <select name="county" id="county" class="select-radio">
                                        <? include _BASEPATH . '/../view/v4/apply/administrative.php'; ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <div class="address-detail">
                                        <input type="text" id="street" name="street" placeholder="請輸入地址" value="">
                                        (路/街)
                                    </div>
                                </div>
                            </div>

                            <!-- 地址第二段 -->
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="address-detail">
                                        <input type="number" id="part" min="1" name="part" placeholder="請輸入數字" value="">
                                        段
                                    </div>

                                </div>
                                <div class="col-lg-4">
                                    <div class="address-detail">
                                        <input type="number" id="lane" min="1" name="lane" placeholder="請輸入數字" value="">
                                        巷
                                    </div>

                                </div>
                                <div class="col-lg-4">
                                    <div class="address-detail">
                                        <input type="number" id="alley" min="1" name="alley" placeholder="請輸入數字" value="">
                                        弄
                                    </div>
                                </div>

                            </div>

                            <!-- 地址第三段 -->
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="address-detail">
                                        <input type="number" id="no_of" min="1" name="no_of" placeholder="請輸入數字" value="">
                                        號
                                        之
                                        <input type="number" id="no_of2" min="1" name="no_of2" placeholder="請輸入數字" value="">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="address-detail">
                                        <input type="number" id="lou_of" min="1" name="lou_of" placeholder="請輸入數字" value="">
                                        樓
                                        之
                                        <input type="number" id="lou_of2" min="1" name="lou_of2" placeholder="請輸入數字" value="">
                                    </div>

                                </div>
                                <div class="col-lg-4">
                                    <div class="address-detail">
                                        其他
                                        <input type="text" id="other" name="other" placeholder="請輸入地址" value="">

                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>

                    <div class="form-dividing-line col-lg-12"></div>

                    <div class="form_group col-lg-6">
                        <label class="must-label">聯絡人姓名<span>：</span>
                        </label>
                        <input type="text" id="contact_person" name="contact_person" placeholder="請輸入聯絡人姓名" value="">
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="must-label">職稱<span>：</span>
                        </label>
                        <input type="text" id="job_title" name="job_title" placeholder="請輸入職稱" value="">
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="must-label">登入帳號<span>：</span>
                        </label>
                        <input type="text" id="account" name="account" onchange="changeaccount()" placeholder="請設定登入系統帳號" value="">
                        <p class="show_acct_text" style="color:red;display:none;">您輸入的帳號已被註冊，請重新填寫！</p>
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="must-label">密碼<span>：</span>
                        </label>
                        <input type="text" id="password" name="password" placeholder="請輸入密碼" value="">
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="must-label">連絡電話<span>：</span>
                        </label>

                        <div class="phone-detail ">

                            <input type="tel" id="landline_area" name="landline_area" placeholder="區碼" value="" class="area-code">

                            <div class=" linkmark">
                                –
                            </div>

                            <input type="tel" id="landline" name="landline" placeholder="請輸入號碼" value="">
                            <div class="linkmark-2">
                                –
                            </div>

                            <input type="tel" id="extension" name="extension" placeholder="分機" value="" class="extension">

                        </div>
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="must-label">行動電話<span>：</span>
                        </label>
                        <input type="tel" id="phone" name="phone" placeholder="請輸入號碼" value="">
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="">Line ID<span>：</span>
                        </label>
                        <input type="text" id="line_id" name="line_id" placeholder="請輸入Line ID" value="">
                    </div>

                    <div class="form_group col-lg-6">
                        <label class="">傳真<span>：</span>
                        </label>
                        <div class="fax-detail ">
                            <input type="tel" id="fax_area" name="fax_area" placeholder="區碼" value="" class="extension">

                            <div class=" linkmark">
                                –
                            </div>
                            <input type="tel" id="fax" name="fax" placeholder="請輸入號碼" value="">
                        </div>

                    </div>

                    <div class="form_group col-lg-12">
                        <label class="must-label">E-mail<span>：</span>
                        </label>
                        <input type="email" id="email" name="email" onchange="changeemail()" placeholder="請輸入E-mail信箱" value="">
                        <p class="show_email_text" style="color:red;display:none;">您輸入的信箱已被註冊，請重新填寫！</p>
                    </div>


                    <div class="form_group col-lg-12">
                        <div class="btn-group">
                            <button class="btn-register btn-text subbut">
                                確認註冊
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
    $(function() {
        $('#postal').blur(function() {
            var val = Number($('#postal').val());
            console.log(val);

            var is_postal = /^[1-9]\d{2}$/;
            console.log(is_postal.test(val));
            if (!is_postal.test(val)) {
                alert('請填寫郵遞區號前3碼');
            }
        })
    })

    function validateForm() {
        var is_stop = false;
        $check_array = ['school_name', 'school_compilation', 'school_type', 'administrative', 'contact_person', 'job_title', 'account', 'password', 'landline', 'phone', 'email'];
        var x = $("form").serializeArray();
        // console.log(x);
        $.each(x, function() {
            if ($.inArray(this.name, $check_array) != '-1' && this.value == '') {
                if (this.name == 'administrative') {
                    alert('請選擇行政區');
                } else {
                    alert($('#' + this.name).attr('placeholder'));
                }

                is_stop = true;
                //停止each
                return false;
            }
        });
        if ($('#postal').val() == '' || $('#county').find(':selected').text() == '請選擇' || $('#street').val() == '') {
            alert('請填寫地址');
            is_stop = true;
        }
        if ($('#landline_area').val() == '') {
            alert('請輸入電話區碼');
            is_stop = true;
        }
        if (is_stop == true) {
            //不讓表單送出
            return false;
        }
    }

    function changeaccount() {
        var account = $("#account").val();
        $.ajax({
            type: "POST",
            data: {
                'type': 'account_register',
                'account': account,
            },
            url: 'apply_post.php',
            success: function(response) {
                console.log(response);
                if (response == 1) {
                    alert('您輸入的帳號已被註冊，請重新填寫！');
                    $('.subbut').hide();
                    $('.show_acct_text').show();
                } else {
                    $('.subbut').show();
                    $('.show_acct_text').hide();
                }
            }
        }); // ajax
    }

    function changeemail() {
        var email = $("#email").val();
        $.ajax({
            type: "POST",
            data: {
                'type': 'email_register',
                'email': email,
            },
            url: 'apply_post.php',
            success: function(response) {
                console.log(response);
                if (response == 1) {
                    alert('您輸入的信箱已被註冊，請重新填寫！');
                    $('.subbut').hide();
                    $('.show_email_text').show();
                } else {
                    $('.subbut').show();
                    $('.show_email_text').hide();
                }
            }
        }); // ajax
    }

    // function changecode() {
    //   var regex = new RegExp("^[a-zA-Z0-9]+$");
    //   var the_code = $("#the_code").val();
    //   if (!regex.test(the_code)) {
    //     alert('請輸入英文和數字!');
    //     $('.subbut').hide();
    //     $('.show_code_text').html('請輸入英文和數字!');
    //     $('.show_code_text').show();
    //   } else {
    //     $.ajax({
    //       type: "POST",
    //       data: {
    //         'type': 'code_register',
    //         'the_code': the_code,
    //       },
    //       url: 'apply_post.php',
    //       success: function(response) {
    //         console.log(response);
    //         if (response == 1) {
    //           alert('您輸入的學校代碼已被註冊，請重新填寫！');
    //           $('.show_code_text').html('您輸入的學校代碼已被註冊，請重新填寫！');
    //           $('.show_code_text').show();
    //           $('.subbut').hide();
    //         } else {
    //           $('.subbut').show();
    //           $('.show_code_text').hide();
    //         }
    //       }
    //     }); // ajax
    //   }

    // }
</script>