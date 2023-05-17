<div class="application-steps">
    <div class="btn-group ">
        <a href="class_tw_1.php">
            <div class="btn-apply-1 btn-text btn-class <?= ($this->data['router_class'] == 'class_1' ? 'active' : '') ?> ">
                班級資訊
            </div>
        </a>
        <a href="class_tw_2.php">
            <div class="btn-apply-1 btn-class btn-text <?= ($this->data['router_class'] == 'class_2' ? 'active' : '') ?> ">
                公佈欄
            </div>
        </a>
        <a href="class_tw_3.php">
            <div class="btn-apply-1 btn-class btn-text <?= ($this->data['router_class'] == 'class_3' ? 'active' : '') ?>">
                相片成果
            </div>
        </a>
        <a href="class_tw_4.php">
            <div class="btn-apply-1 btn-class btn-text <?= ($this->data['router_class'] == 'class_4' ? 'active' : '') ?>">
                影音成果
            </div>
        </a>
        <a href="classout_tw_1.php<?= !empty($_SESSION["member_data"]['class_id']) ? "?class_id=" . $_SESSION["member_data"]['class_id'] : ""; ?>" target="_blank">
            <div class="btn-apply-1 btn-class btn-text <?= ($this->data['router_class'] == 'class_5' ? 'active' : '') ?>">
                成果預覽
            </div>
        </a>
        <? if ($_SESSION['member_data']['member_grade'] == 2) { ?>
            <a href="class_tw_6.php">
                <div class="btn-apply-1 btn-class btn-text <?= ($this->data['router_class'] == 'class_6' ? 'active' : '') ?>">
                    期末報告
                </div>
            </a>
        <? } ?>
        <a href="class_tw_7.php">
            <div class="btn-apply-1 btn-class btn-text <?= ($this->data['router_class'] == 'class_7' ? 'active' : '') ?>">
                修改資料
            </div>
        </a>
    </div>
    <div class="container">
        <p class='header-remind '>溫馨提醒：只要是對人進行拍照或攝影，不論是學生或是學生作品，都有隱私權、著作權、肖像權問題，此係涉及我國個人資料保護法、著作權法與民法肖像權等相關規定。
            因此請學校與教師小心上傳圖片或影片，並提前做好同意授權程序，以避免事後爭議，謝謝!</p>
    </div>
</div>