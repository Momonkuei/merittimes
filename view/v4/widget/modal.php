<div id="addCart_modal" class="modal">
 <div class="addCart_content">
  <form class="cont_form">
   <div class="row">
     <div class="col-md-3">
      <img src="https://via.placeholder.com/300" alt="">
     </div>
     <div class="col-md-9">
      <div class="subBlockTitle">TEST (複製)</div>
      <div class="subBlockInfo">111</div>
      <a class="subBlockTxt" href=""><i class="fa fa-external-link" aria-hidden="true"></i>看商品詳細</a>
     </div>
    </div>
    <div class="addCart_control">
     <div class="prod_specification">
      <label>規格</label>
      <select>
        <option value="S">S $8550</option>
        <option value="M">M $8600</option>
        <option value="L">L $8650</option>
       </select>
     </div><!-- .prod_specification -->
     <div class="prod_num">
       <label>數量</label>
       <div>
        <div class="number-spinner">
          <span class="ns-btn">
          <a data-dir="dwn"><span class="icon-minus"></span></a>
          </span>
          <input type="text" class="pl-ns-value" value="1" maxlength="2">
          <span class="ns-btn">
          <a data-dir="up"><span class="icon-plus"></span></a>
          </span>
        </div>
       </div>
     </div><!-- .prod_num -->
     <button class="btn-cis1"><i class="fa fa-check" aria-hidden="true"></i>送出</button>
    </div><!-- .addCart_control -->
  </form>
 </div><!-- .addCart_content -->
</div><!-- #addCart_modal -->


<div id="fastLogin_modal" class="modal">
  <div class="row">
    <div class="col-lg-6">
      <div class="pageTitleStyle-1">
        <span>帳號登入</span>
      </div>
      <form class="row cont_form">
        <div class="form_group col-lg-12">
          <label class="must">帳號</label>
          <input type="text" placeholder="Enter your Email">
        </div>
        <div class="form_group col-lg-12">
          <label class="must">密碼</label>
          <input id="password-field" type="password" name="password" value="" placeholder="Password">
        </div>
        <div class="form_group col-lg-12">
          <label class="must">認證碼</label>
          <div class="authenticateCode">
            <input type="text" placeholder="驗證碼">
            <img src="images_v4/contact/checkcode.jpg" alt="">
            <a href=""><i class="fa fa-refresh" aria-hidden="true"></i>更新驗證碼</a>
          </div><!-- .authenticateCode -->
        </div>
        <div class="form_group col-lg-12">
          <button class="btn-cis1"><i class="fa fa-sign-out" aria-hidden="true"></i>登入</button>
          <a class="icon-link" href="member.php?type=forgot"><i class="fa fa-expeditedssl" aria-hidden="true"></i>忘記密碼</a>
        </div>
      </form><!-- .cont_form -->
    </div>
    <div class="col-lg-6">
      <div class="innerBlock_small_mb checkout_now">
        <div class="pageTitleStyle-1">
          <span>立即結帳</span>
        </div>
        <p>為簡化流程，第一次購物您不需要加入會員就可以直接進行購物。完成訂購後，系統將自動將您升級為會員。</p>
        <button class="btn-cis1" onclick="self.location.href='#'"><i class="fa fa-shopping-cart" aria-hidden="true"></i>第一次購物</button>
        <button class="btn-white" onclick="self.location.href='#'"><i class="fa fa-user" aria-hidden="true"></i>註冊會員</button>
      </div><!-- .innerBlock_small -->
      <div class="innerBlock_small fast_loginBtn">
        <div class="pageTitleStyle-1">
          <span>快速登入</span>
        </div>
        <div>
          <a class="btn-white" href=""><span class="icon_mbm icon_fb"></span>FACEBOOK</a>
          <a class="btn-white" href=""><span class="icon_mbm icon_google"></span>GOOGLE</a>
          <a class="btn-white" href=""><span class="icon_mbm icon_line"></span>LINE</a>
        </div>
      </div><!-- .innerBlock_small -->
    </div>
  </div>
</div><!-- #fastLogin_modal-->


<div id="searchForm_modal" class="modal modal_half">
  <div class="pageTitleStyle-1">
    <span>搜尋</span>
  </div>
  <form class="cont_form">
    <div class="srh_content">
      <input type="text" placeholder="搜尋">
    </div>
    <div><button class="btn-cis1">搜尋</button></div>
  </form><!-- .cont_form -->
</div><!-- #searchForm_modal-->


<div id="language_modal" class="modal modal_half">
  <div class="pageTitleStyle-1">
    <span>語系</span>
  </div>
  <ul class="listStyle text-center">
		<li>
			<a href="index_en.php">English</a>
		</li>
		<li>
			<a href="index_tw.php">繁體中文</a>
		</li>
		<li>
			<a href="index_fr.php">French</a>
		</li>
		<li>
			<a href="index_de.php">German</a>
		</li>
	</ul>
</div><!-- #language_modal-->


<div id="memberTerm_modal" class="modal">
  <p>
    會員條款<br /><br />

    一．購物流程<br />
    STEP 01. 選購商品<br />
    您可以透過商品分類或搜尋的方式，找到您需要的商品後點選「我要訂購」加入購物車。結帳前需先輸入帳號、密碼，完成會員登入，以利會員點數累積。<br /><br />

    STEP 02. 輸入資料<br />
    2-1確認購物明細、是否折抵會員點數和付款方式。<br />
    2-2填寫付款人、收貨人資料。<br />
    請正確填寫您的收貨地址與聯絡電話，這樣您才能在送貨期限內順利收到商品！<br /><br />

    STEP 03. 完成訂購<br />
    當完成訂單確認送出後，系統會帶您到訂購完成頁，同時寄一封訂購完成通知信到您的e-mail信箱，您可以到「會員中心／購物紀錄」查詢該筆訂單的處理情形。<br /><br />

    二．到貨日期：<br />
    商品到貨日為繳款確認後（貨到付款除外），以專員電話聯繫告知為主，工作天數約5-6天。<br />
    ★ 請訂購 人保持電話的暢通，如未與訂購人聯繫上，則訂單將延後到貨。<br />
    ★ 訂單當日處理時間AM 10:00 - PM 18:00，超過PM 18:00以隔日訂單處理。<br />
    ★ 若逢年節或國定假日，宅配時間恕指定。不便之處，敬請見諒！<br />
    ★ 若遇天災等特殊狀況（颱風/淹水/路面坍塌），出現商品延誤配達，敬請見諒。<br /><br />

    三．宅配說明：<br />
    全產品皆採黑貓宅急便全程低溫冷藏宅配，收到商品時請立即放入冷藏保存。<br />
    配送區域：單筆訂單配送一個地址。<br /><br />

    黑貓宅急便服務區域<br />
    台灣本島各地各縣市、澎湖部分地區、金門部分地區、小金門、馬袓部分地區(又稱連江縣。南竿、北竿、東莒、西莒、東引)、小琉球、綠島<br /><br />

    不受理的區域<br />
    澎湖望安鄉、七美鄉、虎井島、桶盤島、大倉嶼、員貝嶼、鳥嶼、吉貝嶼、蘭嶼、金門烏坵鄉(大膽島、二膽島)<br />
    台灣本島特定偏遠地區，我們會秉持最快速的配送服務，儘快將您的商品送達。如遇颱風地震等天災，出貨時間將順延，請務必保持電話暢通。<br /><br />

    四． 付款方式：<br />
    信用卡付款：一次付清<br />
    ATM轉帳：在訂購完成後，網頁及訂購確認信函中會顯示該筆訂單專屬的ATM虛擬轉帳帳號，請依此帳號於3天內(含假日)付款，逾期該筆訂單、轉帳帳號將自動取消失效，待繳款確認後我們會立即處理訂單。
    超商代碼繳款:在訂購完成後，網頁及訂購確認信函中會顯示該筆訂單專屬的超商代碼繳費序號，請依此帳號於7天內(含假日)付款，逾期該筆訂單、轉帳帳號將自動取消失效。待繳款確認後我們會立即處理訂單。<br /><br />

    五．發票寄送：<br />
    捐贈、二聯或三聯式發票隨商品寄送<br /><br />

    六．常見問題<br />
    Q：何謂完成訂購?<br />
    請至「我的帳戶/訂單查詢」，確認此次訂購是否有訂單編號產生，若只是將商品點選「加入購物車」、「加入興趣清單」，都不算完成該商品的訂購，系統亦不會保留商品庫存量或優惠價。如該訂單選擇ATM虛擬仗號轉帳方式，請於3天內(含假日)完成付款，如該訂單選擇超商代碼繳費方式，請於7天內(含假日)完成付款，逾期系統會自動取消該筆訂單。<br /><br />

    Q：未收到訂購完成通知信?<br />
    若您沒收到訂單確認信，有幾種可能原因：<br />
    1.您的e-mail信箱錯誤或者郵件信箱已滿而無法成功遞送。<br />
    2.您使用的入口網站所提供的免費信箱，可能因伺服器阻擋，導致信件無法順利寄送至您的信箱內(例如：PCHome、Yahoo…等)。<br />
    3.您的訂購並未成功。請至「我的帳戶」中查詢您的交易記錄，若可查到訂購記錄，即表示訂購已完成。<br /><br />

    7． 退換貨：<br />
    →商品為冷藏食品，取貨後請立即冷藏保存。若顧客取貨後因未冷藏保存造成商品解凍變質，本公司不負退換貨責任。<br />
    →基於保障消費者個人衛生因素考量，不接受客戶鑑賞商品後退貨，除瑕疵品或產品本身與標示規格不符外，本商品如經拆封或經使用，即可能影響退(換)貨權利。<br /><br />

    若產品本身瑕疵或運送過程中導致新品瑕疵，到貨七日內可更換新品。<br />
    》在您收到貨品後，如非人為因素之商品毀損、刮傷、或運輸過程造成包裝破損不完整者，請您儘速通知本公司客服人員：xxx-xxxxxxx，我們會進行商品瑕疵或損壞鑑定，並儘速將新品寄給您。<br />
    》所有要辦理退貨或換貨的客戶皆需E-mail：0800@xxxxx.com.tw或來電至客服中心xxx-xxxxxxx，並提供：訂單號碼、退、換貨原因，您的姓名及聯絡電話，E-mail、地址。<br />
    》若您所訂購之商品無問題而您欲退貨，退回的商品必須恢復原狀，包括主要商品、週邊配件，連同原包裝一併送回。→若無特殊理由（如瑕疵品）而辦理退換貨時，需同時負擔送貨及退貨所需之運費，此金額將自動於退款金額中扣除。有關退、換貨恢復原狀之規定，係依消費者保護法及民法之相關規定辦理。<br /><br />

    反詐騙宣導：<br />
    為防範詐騙行為，本購物網提供每筆選擇ATM虛擬轉帳帳號之訂單「專屬的轉帳帳號」，當完成轉帳後，系統即自動通知店家付款完成，店家客服專員將親自電話聯繫後核對出貨，並於會員中心頁面同步顯示訂單處理進度。若您忘記「專屬轉帳帳號」，可隨時登入「會員中心」→「購物紀錄」中查詢。
    注意：每筆帳號僅限使用一次。
  </p>
</div><!-- #memberTerm_modal-->


<div id="memberPrivacy_modal" class="modal">
  隱私權政策
</div><!-- #memberPrivacy_modal-->


<div id="sideCart_modal" class="modal">
  <div class="sideCart_content">
    <div class="cartInfo">
      <div class="cartTitle">
        <h3>購物車 (<span>2</span>)</h3>
        <h5>TOTAL: <span>$400</span></h5>
      </div>
      <div><a class="btn-gray" data-fancybox data-src="#fastLogin_modal" data-options='{"touch" : false}' href="javascript:;"><i class="fa fa-shopping-cart" aria-hidden="true"></i>立即結帳</a></div>
    </div>
    <div class="proInquiry">
      <?php for ($i=0; $i < 6; $i++) {?>
      <div class="proInquiry_item">
        <div>
          <a href="productsdetail.php">
            <div class="itemImg img-rectangle square itemImgHover hoverEffect1">
              <img src="https://via.placeholder.com/100x100" alt="">
            </div>
          </a>
        </div>
        <div>
          <div class="subBlock_item">
            <div class="subBlockTitle">商品名稱商品名稱</div>
            <p class="subBlockTxt">商品分類1</p>
            <div>數量：1</div>
          </div>
        </div>
        <div>
          <a href="" class="icon-link"><i class="fa fa-trash-o" aria-hidden="true"></i>刪除</a>
        </div>
      </div>
      <?}?>
    </div><!-- .proInquiry -->
  </div><!-- .sideCart_content -->
</div><!-- #memberPrivacy_modal-->
