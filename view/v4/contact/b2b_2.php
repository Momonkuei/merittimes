<div class="pageTitleStyle-1"><span>Contact Form<?php //(B2B)
                                                ?></span></div>
<p><?php echo t('請填寫在線表格與我們聯繫。') ?><label class="must"><?php echo t('為必填') ?></label></p>
<?$tmp = 1; ?>
<?php  include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤 onsubmit="return goSubmit('eForm1'); method="post" id="eForm1" name="eForm1""
?>
<!-- <form  class="form_start form_b2b_2 row"  > -->
    <ul class="col-12 col-xl-5">
        <li class="form-item">
            <input type="text" id="company_name" name="company_name" placeholder="" value="<?php echo $save['company_name'] ?>" required="">
            <label t="* tw ucfirst"><em>*</em>公司</label>
        </li>
        <li class="form-item">
            <input type="text" id="name" name="name" placeholder="" value="<?php echo $save['name'] ?>" required="">
            <label t="* tw ucfirst"><em>*</em>姓名</label>
        </li>



        <li class="form-item">
            <input type="email" id="email" name="email" required="">
            <label><em>*</em>信箱</label>
        </li>
        <li class="form-item">
            <input type="text" id="country" name="country">
            <label><em>&nbsp;</em>國家 / 地區</label>
        </li>
        <li class="form-item">
            <input type="text" id="phone" name="phone" required="">
            <label><em>*</em>電話</label>
        </li>
    </ul>
    <ul class="col-12 col-xl-7">
        <li class="form-item">
            <input type="text" id="address" name="address">
            <label>地址</label>
        </li>
        <li class="form-item">
            <input type="text" id="web" name="web">
            <label for="web">網址</label>
        </li>
        <li class="form-item">
            <textarea name="detail" id="detail" cols="30" rows="5" required=""></textarea>
            <label><em>*</em>內容</label>
        </li>
        <li class="form-item code">
            <input type="text" id="captcha" name="captcha" />
            <label><em>*</em>驗證碼</label>
            <div class='code-area'>
                <span>
                    <img id="valImageId" src="captcha.php" width="100" gheight="40" />
                </span>
                <a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
            </div>

        </li>
        <li class="form-item">
            <!-- <button  class="herobtn"><span><?php echo t('SEND','en')?></span></button> -->
            <button class="herobtn"><?php echo t('SEND','en')?></button>
        </li>
    </ul>
</form>