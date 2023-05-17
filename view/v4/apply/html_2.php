<?
include _BASEPATH . '/../source/apply/post_2.php';
?>

<section class="sectionBlock" data-about="1">
  <div class="container">
    <!-- <h1 class="text-center apply-title">班級申請</h1> -->
    <div class="application-steps">
      <div class="btn-group ">
        <a href="apply_tw_1.php">
          <div class="btn-apply-1 btn-text ">
            1.填寫計畫
          </div>
        </a>
        <a href="apply_tw_2.php">
          <div class="btn-apply-1 btn-text active">
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
        <div class="mark-number">二</div>
        <div class="mark-title">
          專案步驟
        </div>
      </div>

      <div class="application-form-title title-bot-border  ">
        <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
        <div class='content'>
          填寫班級申請
          <small>請填寫以下表格，<span>「＊」</span>為必填</small>
        </div>
      </div>

      <!-- 申請表單 -->
      <div class="class-apply-table">
        <div class="col">
          <div class="row">
            <div class="col-3 title-mark">
              學校全銜
            </div>
            <div class="col-9">
              <?= $_SESSION['member_data']['school_name'] ?>
            </div>
          </div>

        </div>
        <div class="col">
          <div class="row">
            <div class="col-3 title-mark">
              申請期別
            </div>
            <div class="col-9">
              <div class="selection-radio">
                <div class="select">
                  <span class="placeholder"><?= $semester_array['topic'] ?></span>
                  <ul>
                    <li><?= $semester_array['topic'] ?></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col">
          <div class="txt">
            <p class="remind-text">※ 填寫說明：</p>
            <ol>
              <li>
                1.以「申請班級」為單位輸入(同年級不同班須分次輸入)。
              </li>
              <li>
                2.請依步驟填寫表格，列印後並上傳核章表單。
              </li>
            </ol>
          </div>
        </div>

      </div>

      <div class="title-bot-border col-lg-12 back_top"></div>

      <div class="application-form-title  addclassdiv">
        <div class="title-label">
          <div class="title-label-border"></div>
          <P>步驟.A</P>
        </div>
        <div class="add_class_data">新增班級資料</div>
      </div>

      <!-- 班級資料 -->
      <div class="application-form addclassdiv" style="display:none">
        <form action="POST" name="applicationForm" id="form_data" class="row cont_form" autocomplete="off">
          <input type="hidden" id="writeplan_id" name="writeplan_id" value="<?= $_GET['writeplan_id'] ?>">
          <input type="hidden" id="semester" name="semester" value="<?= $semester_array['id'] ?>">
          <input type="hidden" id="class_id" name="class_id" value="">

          <div class="form_group col-lg-6">
            <label class="must-label">年級班別<span>：</span>
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
        </form>

      </div>


      <!--申請明細  -->

      <div class="application-form-details">
        <div class="top-function-column ">
          <div class='add-area'>
            <button class='btn-register btn-text addclass'>
              增加班級
              <i class="fa fa-plus" aria-hidden="true"></i>
            </button>
            <? if (!empty($writeplan_class_array)) { ?>
              <div class="class-selection class-web-label ">
                <span class="title">複製期別：</span>
                <select name="cars" id="cars" class="select-radio">
                  <option value="">請選擇學期</option>
                  <? foreach ($writeplan_class_array as $k => $v) { ?>
                    <option value="<?= $k ?>"><?= $v ?></option>
                  <? } ?>
                </select>
              </div>
              <div class="copyBtn">
                <button class="btn-operate btn-text copy_cars">
                  複製
                </button>
              </div>
            <? } ?>
          </div>
          <div class="remove del_all_class" <?= (empty($writeplan_class) ? 'style="display:none"' : '') ?>>
            <button class='btn-delete btn-text del_allclass'>
              刪除所有班級資料
            </button>
          </div>
        </div>
        <? if (!empty($semester_array_all)) { ?>
          <p class="remind-text">※ 如前一學期已申請，請選擇複製期別，做班級沿用或增刪</p>
        <? } ?>
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
            <tbody class="class_list">
              <? if (!empty($writeplan_class)) {
                foreach ($writeplan_class as $k => $v) { ?>
                  <tr>
                    <td><?= $v['class_name'] ?></td>
                    <td><?= $v['teacher_name'] ?></td>
                    <td><?= $v['student_num'] ?></td>
                    <td><?= $v['email'] ?></td>
                    <td>
                      <div class="btn-group">
                        <a class="btn-revise btn-text class_upload" data-cid="<?= $v['id'] ?>">
                          修改
                        </a>
                        <a class="btn-delete btn-text class_delete" data-cid="<?= $v['id'] ?>">
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

        <div class="col-12 table-footer">
          <div class="row">
            <div class="col-12 col-lg-8">
              <div class="row label-group">
                <div class="col-12 col-lg-4 ">
                  <div class="footer-label all_class">
                    總計： <span> <?= (!empty($writeplan_array['class_name']) ? $writeplan_array['class_name'] : '0') ?></span> 班
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="footer-label all_num">
                    人數： <span> <?= (!empty($writeplan_array['student_name']) ? $writeplan_array['student_name'] : '0') ?></span> 人
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="footer-label report_num">
                    實際報份： <span> <?= (!empty($writeplan_array['actual_num']) ? $writeplan_array['actual_num'] : '0') ?></span> 份
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="row label-group">
                <div class="footer-label application-form application-field">
                  希望報份： <input type="text" id="apply_num" name="apply_num" placeholder="請輸入數量"> 份
                </div>
              </div>

            </div>
          </div>

        </div>

        <!-- 按鈕 -->
        <div class="application-form-details-end sub_botton" <?= (empty($writeplan_class) ? 'style="display:none"' : '') ?>>
          <button class='btn-register btn-text step_b'>
            確認無誤
          </button>

          <p class="remind-text">※ 確認無誤後，則會在步驟B出現列印表單按鈕</p>
        </div>

        <div class="step_b" style="display:none">
          <div class="title-bot-border col-lg-12"></div>
          <div class="application-form-title">
            <div class="title-label">
              <div class="title-label-border"></div>
              <P>步驟.B</P>
            </div>
            列印表單
          </div>
          <p class="remind-text">※請列印此表單檔案，提供貴校相關主管簽核，再將核章檔案於步驟C上傳</p>
          <button class='btn-action btn-text photocopyform'>
            <i class="fa fa-print" aria-hidden="true"></i>
            列印表單
          </button>
          <div class="responsive_tbl">
            <table class="tableList tableList-check">
              <thead>
                <tr>
                  <th>年級/班別</th>
                  <th>教師姓名</th>
                  <th>學生數</th>
                  <th>E-mail</th>
                </tr>
              </thead>
              <tbody class="print_class_list">

              </tbody>
            </table>
          </div>
          <div class="col-12 table-footer check-footer">
            <div class="row">
              <div class="col-12 col-lg-8">
                <div class="row label-group">
                  <div class="col-12 col-lg-4 ">
                    <div class="footer-label print_all_class">
                      總計： <span> 0</span> 班
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="footer-label print_all_num">
                      人數： <span> 0</span> 人
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="footer-label print_report_num">
                      實際報份： <span> 0</span> 份
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="row label-group">
                  <div class="footer-label application-form check-label print_apply_num">
                    希望報份： <span> 0</span> 份
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 table-footer check-footer">
            <div class="row">
              <div class="col-12">
                <div class="row label-group">
                  <div class="col-12 col-lg-4 ">
                    <div class="footer-label">
                      校長：
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="footer-label">
                      主任：
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="footer-label">
                      承辦人：
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="title-bot-border col-lg-12"></div>

        <div class="step_c" style="display:none">
          <div class="application-form-title">
            <div class="title-label">
              <div class="title-label-border"></div>
              步驟.C
            </div>
            上傳核章
          </div>

          <p class="remind-text">※請將核章完的檔案於此處上傳</p>

          <button class='btn-action btn-text' onclick="javascript:window.location.href='apply_tw_3.php?writeplan_id=<?= $_GET['writeplan_id'] ?>'">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
            申請上傳
          </button>
        </div>

      </div>

    </div>





  </div><!-- .container -->
</section><!-- .sectionBlock -->
<script>
  //顯示班級新增欄位
  var addclass = document.querySelector('.addclass');
  //關閉班級新增欄位
  var closureaddclass = document.querySelector('.closureaddclass');
  //送出班級新增欄位
  var addclass_sub = document.querySelector('.addclass_sub');
  //個別班級刪除
  var class_delete = document.querySelectorAll('.class_delete');
  //全部班級刪除
  var del_allclass = document.querySelector('.del_allclass');
  //個別班級修改
  var class_upload = document.querySelectorAll('.class_upload');
  //送出修改班級欄位
  var upclass_sub = document.querySelector('.upclass_sub');
  //步驟B
  var step_b = document.querySelector('.step_b');
  //另開影印頁面
  var photocopyform = document.querySelector('.photocopyform');
  //複製學期
  var copy_cars = document.querySelector('.copy_cars');

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
    document.querySelector('.back_top').scrollIntoView(true);
  }, false);
  //關閉班級新增欄位
  closureaddclass.addEventListener('click', function(e) {
    $('.addclassdiv').hide();
  }, false);
  //送出班級新增欄位
  addclass_sub.addEventListener('click', function(e) {
    $check_array = ['class_name', 'student_num', 'teacher_name', 'email'];
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
          txt = response.split('@@');
          if (txt[0] != 1) {
            alert(txt[1]);
          } else {
            console.log(response);
            // $('.class_list').html(txt[1]);
            // $('.all_class').html('總計： '+txt[2]+' 班');
            // $('.all_num').html('人數： '+txt[3]+' 人');
            // $('.report_num').html('實際報份： '+txt[4]+' 份');
            alert('新增成功!');
            location.reload();
            // $('.addclassdiv').hide();
            // $('.sub_botton').show();
            // $('.del_all_class').show();
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
  //全部班級刪除
  del_allclass.addEventListener('click', function(e) {
    if (confirm("是否要刪除全部班級?") == true) {
      $.ajax({
        type: "POST",
        data: {
          'type': 'del_allclass',
          'writeplan_id': '<?= $_GET['writeplan_id'] ?>',
        },
        url: 'apply_post.php',
        success: function(response) {
          alert('所有班級已刪除!');
          location.reload();
        }
      }); // ajax
    }
  }, false);
  //送出修改班級欄位
  upclass_sub.addEventListener('click', function(e) {
    $check_array = ['class_name', 'student_num', 'teacher_name', 'email'];
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
            console.log(response);
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
  //步驟B
  step_b.addEventListener('click', function(e) {

    var apply_num = $('#apply_num').val().trim();
    if (Math.sign(apply_num) != 1) {
      apply_num = '<?= $writeplan_array['actual_num'] ?>';
    }
    console.log(apply_num);
    $('.step_b').show();
    $('.step_c').show();
    $.ajax({
      type: "POST",
      data: {
        'type': 'pull_alldata',
        'writeplan_id': '<?= $_GET['writeplan_id'] ?>',
        'apply_num': apply_num,
      },
      url: 'apply_post.php',
      success: function(response) {
        txt = response.split('@@');
        if (txt[0] != 1) {
          alert(txt[1]);
        } else {
          $('.print_class_list').html(txt[1]);
          $('.print_all_class').html('總計： ' + txt[2] + ' 班');
          $('.print_all_num').html('人數： ' + txt[3] + ' 人');
          $('.print_report_num').html('實際報份： ' + txt[4] + ' 份');
          $('.print_apply_num').html('希望報份： ' + apply_num + ' 份');
          $('#apply_num').val(apply_num);
        }
      }
    }); // ajax
  }, false);
  //另開影印頁面
  photocopyform.addEventListener('click', function(e) {
    window.open('photocopyform_tw_1.php?writeplan_id=<?= $_GET['writeplan_id'] ?>', '_blank');
  }, false);
  //複製學期

  if (copy_cars != null) {
    copy_cars.addEventListener('click', function(e) {
      semester = $('#cars option:selected').val();
      var is_stop = false;
      if (semester == '') {
        alert('請選擇學期!');
        is_stop = true;
        return false;
      }
      if (is_stop == false) {
        $.ajax({
          type: "POST",
          data: {
            'type': 'copy_cars',
            'original_semester': '<?= $writeplan_array['semester'] ?>',
            'writeplan_id': '<?= $_GET['writeplan_id'] ?>',
            'semester': semester,
          },
          url: 'apply_post.php',
          success: function(response) {
            // console.log(response);
            txt = response.split('@@');
            if (txt[0] != 1) {
              alert(txt[1]);
            } else {
              alert(txt[1]);
              location.reload();
            }
          }
        }); // ajax
      }
    }, false);
  }
</script>