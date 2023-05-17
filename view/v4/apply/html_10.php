

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
        <div>
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
              新北市立北大高中
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
                  <span class="placeholder">請選擇期別</span>
                  <ul>
                    <li>111學年度第一學期</li>
                    <li>111學年度第二學期</li>
                    <li>112學年度第一學期</li>
                    <li>112學年度第二學期</li>
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

      <div class="title-bot-border col-lg-12"></div>

      <div class="application-form-title  ">
        <div class="title-label">
          <div class="title-label-border"></div>
          步驟.A
        </div>
        新增班級資料
      </div>

      <!-- 班級資料 -->
      <div class="application-form">
        <form target="" action="" method="" name="applicationForm" id="form_data" class="row cont_form" autocomplete="off">


          <div class="form_group col-lg-6">
            <label class="must-label">年級班級<span>：</span>
            </label>
            <input type="text" id="name" name="name" placeholder="請輸入年級班別..." value="">
          </div>
          <div class="form_group col-lg-6">
            <label class="must-label">學生數 <span>：</span>
            </label>
            <input type="text" id="name" name="name" placeholder="請輸入學生數..." value="">
          </div>

          <div class="form_group col-lg-6">
            <label class="must-label">教師姓名 <span>：</span>
            </label>
            <input type="text" id="name" name="name" placeholder="請輸入教師姓名..." value="">
          </div>

          <div class="form_group col-lg-6">
            <label class="must-label">Email <span>：</span>
            </label>
            <input type="text" id="name" name="name" placeholder="請輸入Email..." value="">
          </div>

          <div class="first-group-paragraphs col-lg-12">
            <div class="btn-group">
              <button class="btn-operate btn-text">
                確定新增
              </button>
              <button class="btn-operate btn-text">
                結束新增
              </button>
            </div>
          </div>
        </form>

      </div>


      <!--申請明細  -->

      <div class="application-form-details">
        <div class="top-function-column">
          <div class='add-area'>
            <button class='btn-register btn-text'>
              增加班級
              <i class="fa fa-plus" aria-hidden="true"></i>
            </button>

            <div class="class-selection">
              <span class="title">複製期別：</span>

              <div class="select">
                <span class="placeholder">請選擇</span>
                <ul>
                  <li>110學年度第一學期</li>
                  <li>110學年度第二學期</li>
                  <li>111學年度第一學期</li>
                  <li>111學年度第二學期</li>
                </ul>
              </div>
            </div>

            <div class="copyBtn">
              <button class="btn-operate btn-text">
                複製
              </button>
            </div>
          </div>
          <div class="remove">
            <button class='btn-delete btn-text'>
              刪除所有班級資料
            </button>
          </div>
        </div>

        <p class="remind-text">※ 如前一學期已申請，請選擇複製期別，做班級沿用或增刪</p>

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
              <tr>
                <td>
                  一年一班
                </td>
                <td>林教師</td>
                <td>30</td>
                <td>cheng@buyersline.com.tw</td>
                <td>
                  <div class="btn-group">
                    <a href="#uploadForm" class="btn-revise btn-text" data-fancybox="" data-src="#uploadForm">
                      修改
                    </a>
                    <a href="#uploadForm" class="btn-delete btn-text" data-fancybox="" data-src="#uploadForm">
                      刪除
                    </a>
                  </div>

                </td>
              </tr>

              <tr>
                <td>
                  三年二班
                </td>
                <td>林教師</td>
                <td>15</td>
                <td>cheng85@buyersline.com.tw</td>
                <td>
                  <div class="btn-group">
                    <a href="#uploadForm" class="btn-revise btn-text" data-fancybox="" data-src="#uploadForm">
                      修改
                    </a>
                    <a href="#uploadForm" class="btn-delete btn-text" data-fancybox="" data-src="#uploadForm">
                      刪除
                    </a>
                  </div>

                </td>
              </tr>

              <tr>
                <td>
                  五年一班
                </td>
                <td>林教師</td>
                <td>18</td>
                <td>qweqwe@buyersline.com.tw</td>
                <td>
                  <div class="btn-group">
                    <a href="#uploadForm" class="btn-revise btn-text" data-fancybox="" data-src="#uploadForm">
                      修改
                    </a>
                    <a href="#uploadForm" class="btn-delete btn-text" data-fancybox="" data-src="#uploadForm">
                      刪除
                    </a>
                  </div>

                </td>
              </tr>

              <tr>
                <td>
                  二年一班
                </td>
                <td>林教師</td>
                <td>20</td>
                <td>yyeng@buyersline.com.tw</td>
                <td>
                  <div class="btn-group">
                    <a href="#uploadForm" class="btn-revise btn-text" data-fancybox="" data-src="#uploadForm">
                      修改
                    </a>
                    <a href="#uploadForm" class="btn-delete btn-text" data-fancybox="" data-src="#uploadForm">
                      刪除
                    </a>
                  </div>

                </td>
              </tr>

              <tr>
                <td>
                  四年一班
                </td>
                <td>林教師</td>
                <td>30</td>
                <td>cheng@buyersline.com.tw</td>
                <td>
                  <div class="btn-group">
                    <a href="#uploadForm" class="btn-revise btn-text" data-fancybox="" data-src="#uploadForm">
                      修改
                    </a>
                    <a href="#uploadForm" class="btn-delete btn-text" data-fancybox="" data-src="#uploadForm">
                      刪除
                    </a>
                  </div>

                </td>
              </tr>


            </tbody>
          </table>



        </div>

        <div class="col-12 table-footer">
          <div class="row">
            <div class="col-12 col-lg-8">
              <div class="row label-group">
                <div class="col-12 col-lg-4 ">
                  <div class="footer-label">
                    總計： <span> 5</span> 班
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="footer-label">
                    人數： <span> 150</span> 人
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="footer-label">
                    實際報份： <span> 6</span> 份
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="row label-group">
                <div class="footer-label application-form ">
                  申請報份： <input type="text" placeholder="請輸入數量"> 份
                </div>
              </div>

            </div>
          </div>

        </div>

        <!-- 按鈕 -->
        <div class="application-form-details-end">
          <button class='btn-register btn-text'>
            確認無誤
          </button>

          <p class="remind-text">※ 確認無誤後，則會在步驟B出現列印表單按鈕</p>
        </div>

        <div class="title-bot-border col-lg-12"></div>

        <div class="application-form-title">
          <div class="title-label">
            <div class="title-label-border"></div>
            步驟.B
          </div>
          列印表單
        </div>

        <p class="remind-text">※請列印此表單檔案，提供貴校相關主管簽核，再將核章檔案於步驟C上傳</p>

        <button class='btn-action btn-text'>
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
            <tbody>
              <tr>
                <td>
                  一年一班
                </td>
                <td>林教師</td>
                <td>30</td>
                <td>cheng@buyersline.com.tw</td>

                </td>
              </tr>

              <tr>
                <td>
                  三年二班
                </td>
                <td>林教師</td>
                <td>15</td>
                <td>cheng85@buyersline.com.tw</td>

              </tr>

              <tr>
                <td>
                  五年一班
                </td>
                <td>林教師</td>
                <td>18</td>
                <td>qweqwe@buyersline.com.tw</td>

              </tr>

              <tr>
                <td>
                  二年一班
                </td>
                <td>林教師</td>
                <td>20</td>
                <td>yyeng@buyersline.com.tw</td>

              </tr>

              <tr>
                <td>
                  四年一班
                </td>
                <td>林教師</td>
                <td>30</td>
                <td>cheng@buyersline.com.tw</td>

              </tr>


            </tbody>
          </table>



        </div>

        <div class="col-12 table-footer check-footer">
          <div class="row">
            <div class="col-12 col-lg-8">
              <div class="row label-group">
                <div class="col-12 col-lg-4 ">
                  <div class="footer-label">
                    總計： <span> 5</span> 班
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="footer-label">
                    人數： <span> 150</span> 人
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="footer-label">
                    實際報份： <span> 6</span> 份
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="row label-group">
                <div class="footer-label application-form check-label">
                  申請報份： <span> 6</span> 份
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

        <div class="title-bot-border col-lg-12"></div>

        <div class="application-form-title">
          <div class="title-label">
            <div class="title-label-border"></div>
            步驟.C
          </div>
          上傳核章
        </div>

        <p class="remind-text">※請將核章完的檔案於此處上傳</p>

        <button class='btn-action btn-text'>
          <i class="fa fa-cloud-upload" aria-hidden="true"></i>
          申請上傳
        </button>


      </div>

    </div>





  </div><!-- .container -->
</section><!-- .sectionBlock -->