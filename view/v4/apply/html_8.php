<section class="sectionBlock" data-about="1">
  <div class="container">

    <!-- <h1 class="text-center apply-title">修改資料</h1> -->
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
          <div class="btn-apply-2 btn-text ">
            開創教師帳號
          </div>
        </a>
        <a href="apply_tw_7.php">
          <div class="btn-apply-2 btn-text ">
            成果預覽
          </div>
        </a>
        <a href="apply_tw_8.php">
          <div class="btn-apply-2 btn-text active">
            修改資料
          </div>
        </a>

      </div>

    </div>

    <div class="form-border">


      <!-- <div class="application-steps-mark">
        <div class="mark-number">二</div>
        <div class="mark-title">
          修改資料
        </div>
      </div> -->


      <!-- <div class="application-form-title title-bot-border ">
        填寫註冊表格
        <small>請填寫以下表格，<span>「＊」</span>為必填</small>
      </div> -->
      <div class="application-form application-form-detail form-border-no-title  ">
        <form target="" method="POST" name="applicationForm" id="form_data" class="row cont_form" autocomplete="off" onsubmit="return validateForm()">
          <div class="form_group col-lg-6">
            <label class="must-label">學校全銜<span>：</span>
            </label>
            <input type="text" id="school_name" name="school_name" placeholder="請依教育部登記之全銜" value="<?= $member_array['school_name'] ?>">
          </div>
          <div class="form_group col-lg-6">
            <label class="must-label">學校統編 <span>：</span>
            </label>
            <input type="text" id="school_compilation" name="school_compilation" placeholder="請輸入學校統編" value="<?= $member_array['other2'] ?>">
          </div>
          <?/*<div class="form_group col-lg-6">
            <label class="must-label">學校代碼 <span>：</span>
            </label>
            <?= $member_array['code'] ?>
          </div>*/ ?>
          <div class="form_group col-lg-6">
            <label class="must-label">類別 <span>：</span>
            </label>
            <select name="school_type" id="school_type" class="select-radio">
              <option <?= ($member_array['other3'] == '國小組' ? 'selected' : '') ?> value="國小組">國小組</option>
              <option <?= ($member_array['other3'] == '國中組' ? 'selected' : '') ?> value="國中組">國中組</option>
              <option <?= ($member_array['other3'] == '高中職組' ? 'selected' : '') ?> value="高中職組">高中職組</option>
              <option <?= ($member_array['other3'] == '大專校院組' ? 'selected' : '') ?> value="大專校院組">大專校院組</option>
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
                    <input type="text" id="postal" name="postal" placeholder="請輸入郵遞區號" value="<?= (!empty($address[0]) ? $address[0] : '') ?>" maxlength="3">
                  </div>


                </div>
                <div class="col-lg-4">
                  <select name="county" id="county" class="select-radio">
                    <? include _BASEPATH . '/../view/v4/apply/administrative.php'; ?>
                  </select>
                </div>

                <div class="col-lg-4">
                  <div class="address-detail">
                    <input type="text" id="street" name="street" placeholder="請輸入地址" value="<?= (!empty($address[2]) ? $address[2] : '') ?>">
                    (路/街)
                  </div>
                </div>
              </div>

              <!-- 地址第二段 -->
              <div class="row">
                <div class="col-lg-4">
                  <div class="address-detail">
                    <input type="number" id="part" name="part" placeholder="請輸入數字" value="<?= (!empty($address[3]) && $address[3] != 'no' ? $address[3] : '') ?>">
                    段
                  </div>

                </div>
                <div class="col-lg-4">
                  <div class="address-detail">
                    <input type="number" id="lane" name="lane" placeholder="請輸入數字" value="<?= (!empty($address[4]) && $address[4] != 'no' ? $address[4] : '') ?>">
                    巷
                  </div>

                </div>
                <div class="col-lg-4">
                  <div class="address-detail">
                    <input type="number" id="alley" name="alley" placeholder="請輸入數字" value="<?= (!empty($address[5]) && $address[5] != 'no' ? $address[5] : '') ?>">
                    弄
                  </div>
                </div>

              </div>

              <!-- 地址第三段 -->
              <div class="row">
                <div class="col-lg-4">
                  <div class="address-detail">
                    <input type="number" id="no_of" name="no_of" placeholder="請輸入數字" value="<?= (!empty($address[6]) && $address[6] != 'no' ? $address[6] : '') ?>">
                    號
                    之
                    <input type="number" id="no_of2" name="no_of2" placeholder="請輸入數字" value="<?= (!empty($address[7]) && $address[7] != 'no' ? $address[7] : '') ?>">
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="address-detail">
                    <input type="number" id="lou_of" name="lou_of" placeholder="請輸入數字" value="<?= (!empty($address[8]) && $address[8] != 'no' ? $address[8] : '') ?>">
                    樓
                    之
                    <input type="number" id="lou_of2" name="lou_of2" placeholder="請輸入數字" value="<?= (!empty($address[9]) && $address[9] != 'no' ? $address[9] : '') ?>">
                  </div>

                </div>
                <div class="col-lg-4">
                  <div class="address-detail">
                    其他
                    <input type="text" id="other" name="other" placeholder="請輸入地址" value="<?= (!empty($address[10]) && $address[10] != 'no' ? $address[10] : '') ?>">

                  </div>

                </div>

              </div>


            </div>
          </div>

          <div class="form-dividing-line col-lg-12"></div>

          <div class="form_group col-lg-6">
            <label class="must-label">聯絡人姓名<span>：</span>
            </label>
            <input type="text" id="contact_person" name="contact_person" placeholder="請輸入聯絡人姓名" value="<?= $member_array['name'] ?>">
          </div>

          <div class="form_group col-lg-6">
            <label class="must-label">職稱<span>：</span>
            </label>
            <input type="text" id="job_title" name="job_title" placeholder="請輸入職稱" value="<?= $member_array['jobtitle'] ?>">
          </div>

          <div class="form_group col-lg-6">
            <label class="must-label">登入帳號<span>：</span>
            </label>
            <?= $member_array['login_account'] ?>
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
              <input type="tel" id="landline_area" name="landline_area" placeholder="區碼" value="<?= $member_array['phone_area'] ?>" class="area-code">

              <div class=" linkmark">
                –
              </div>

              <input type="tel" id="landline" name="landline" placeholder="請輸入號碼" value="<?= $member_array['phone'] ?>">
              <div class=" linkmark-2">
                –
              </div>

              <input type="text" id="extension" name="extension" placeholder="分機" value="<?= $member_array['p_extension'] ?>" class="extension">

            </div>
          </div>

          <div class="form_group col-lg-6">
            <label class="must-label">行動電話<span>：</span>
            </label>
            <input type="tel" id="phone" name="phone" placeholder="請輸入號碼" value="<?= $member_array['mobile'] ?>">
          </div>

          <div class="form_group col-lg-6">
            <label class="">Line ID<span>：</span>
            </label>
            <input type="text" id="line_id" name="line_id" placeholder="請輸入Line ID" value="<?= $member_array['line_id'] ?>">
          </div>

          <div class="form_group col-lg-6">
            <label class="">傳真<span>：</span>
            </label>
            <div class="fax-detail ">
              <input type="tel" id="fax_area" name="fax_area" placeholder="區碼" value="<?= $member_array['fax_area'] ?>" class="extension">

              <div class=" linkmark">
                –
              </div>
              <input type="tel" id="fax" name="fax" placeholder="請輸入號碼" value="<?= $member_array['fax'] ?>">
            </div>
          </div>

          <div class="form_group col-lg-12">
            <label class="must-label">E-mail<span>：</span>
            </label>
            <input type="email" id="email" name="email" onchange="changeemail()" placeholder="請輸入E-mail信箱" value="<?= $member_array['email'] ?>">
            <p class="show_email_text" style="color:red;display:none;">您輸入的信箱已被註冊，請重新填寫！</p>
          </div>


          <div class="form_group col-lg-12">
            <div class="btn-group">
              <button class="btn-register btn-text subbut">
                確認修改
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

  var county = '<?= (!empty($address[1]) ? $address[1] : '0') ?>';
  if (county != '0') {
    $('#county').each(function() {
      $(this).children("option").each(function() {
        if ($(this).val() == county) {
          $(this).attr('selected', true);
        }
      });
    });
  }
  var administrative = '<?= (!empty($member_array['other4']) ? $member_array['other4'] : '0') ?>';
  if (administrative != '0') {
    $('#administrative').each(function() {
      $(this).children("option").each(function() {
        if ($(this).val() == administrative) {
          $(this).attr('selected', true);
        }
      });
    });
  }

  function validateForm() {
    var is_stop = false;
    $check_array = ['school_name', 'school_compilation', 'the_code', 'school_type', 'administrative', 'contact_person', 'job_title', 'account', 'landline', 'phone', 'email'];
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
    if ($('#postal').val() == '' || $('#county').find(':selected').text() == '請選擇' || $('#street').val() == '') {
      alert('請填寫地址');
      is_stop = true;
    }
    if (is_stop == true) {
      //不讓表單送出
      return false;
    }
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
</script>