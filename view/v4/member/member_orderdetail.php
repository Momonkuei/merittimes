<div class="member_center">

  <section class="sectionBlock">
    <div class="container">

      <div class="innerBlock_mt">
        <div class="pageTitleStyle-1">
          <span>訂單記錄</span>
        </div>
        <p>會員 王小明 您好，以下是你的訂單歷史記錄</p>
        <div class="noticepay_list">
          <div class="row">
            <div class="col-lg-6">
              <ul>
                <li><span>訂單編號：</span>123456789</li>
                <li><span>訂購時間：</span>2015-10-21 16:31:58</li>
                <li><span>付款方式：</span>銀行匯款/ATM轉帳</li>
                <li><span>訂單狀態：</span>未付款</li>
                <li><span>發票資訊：</span>三聯/xxxx股份有限公司/AA12345678</li>
              </ul>
            </div>
            <div class="col-lg-6">
              <ul>
                <li><span>收件人姓名：</span>李小頭</li>
                <li><span>收件人電話：</span>0912345678</li>
                <li><span>收件人地址：</span>台北市xxxxxxxx</li>
                <li><span>訂單備註：</span>快點寄過來</li>
              </ul>
            </div>
          </div>
        </div><!-- .noticepay_list -->
      </div><!-- .innerBlock_mt -->

      <div class="innerBlock_small">
        <div class="blockTitle">
          <span>付款資訊</span>
        </div>
        <p class="common_red_txt">該筆訂單未完成付款，請依以下付款資訊完成付款。</p>
        <div class="mbm_payInfo">
          <p class="mbmPayInfo_title"><span>超商繳費代碼：</span>LLL17030813377</p>
          <img class="rwd_img" src="images_v4/PaymentCode_img01.png" alt="">
          <img class="rwd_img" src="images_v4/PaymentCode_img02.png" alt="">
          <img class="rwd_img" src="images_v4/PaymentCode_img03.png" alt="">
        </div>
      </div><!-- .innerBlock_small -->

      <div class="innerBlock_small">
        <div class="blockTitle">
          <span>購買清單</span>
        </div>
        <div class="rwdTable">
          <table class="tableList">
            <thead>
              <tr>
                <th>產品名稱</th>
                <th>商品規格</th>
                <th>價格</th>
                <th>小計</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i < 3; $i++) {?>
              <tr>
                <td>
                  <div class="mbm_orderProItem">
                    <div class="order_proImg"><img src="https://via.placeholder.com/70/5C5E5D/5C5E5D" alt=""></div>
                    <div>
                      商品名稱商品名稱商品名稱<br />
                      <div class="tips_active">活動</div>
                    </div>
                  </div>
                </td>
                <td>
                  顏色 / <img src="https://via.placeholder.com/13/FF0000/FF0000" alt=""> 紅<br />
                  尺寸 / L<br />
                  尺碼 / 42<br />
                  數量 / 2
                </td>
                <td>
                  原價$20,000<br />
                  折價-5,000
                </td>
                <td>$35,000</td>
              </tr>
              <?}?>
            </tbody>
          </table>
        </div><!-- .rwdTable -->
        <div class="orderTotal">
          <table>
          	<tbody>
          		<tr>
          			<td>合計</td>
          			<td>$1</td>
          		</tr>
          		<tr>
          			<td>活動折扣</td>
          			<td>$0</td>
          		</tr>
          		<tr>
          			<td>運費</td>
          			<td>$0</td>
          		</tr>
          		<tr class="total">
          			<td>總計</td>
          			<td>$1</td>
          		</tr>
          	</tbody>
          </table>
        </div><!-- .orderTotal -->
        <div class="even_btn">
          <a class="btn-white2" href=""><i class="fa fa-ban" aria-hidden="true"></i>取消訂單</a>
          <a class="btn-white2" href="javascript:history.go(-1)"><i class="fa fa-reply" aria-hidden="true"></i>返回</a>
          <a class="btn-cis1" href="member.php?type=center"><i class="fa fa-user" aria-hidden="true"></i>前往會員中心</a>
        </div><!-- .even_btn -->
      </div><!-- .innerBlock_small -->


    </div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_center -->
