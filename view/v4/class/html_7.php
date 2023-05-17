<?
include _BASEPATH . '/../source/class/post_7.php';
?>
<section class="sectionBlock sectionBlock-classweb" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">修改資料</h1> -->
        <?include _BASEPATH . '/../view/v4/class/class_header.php';?>
        <div class="form-border">
            <!-- <div class="application-steps-mark">
                <div class="mark-number">一</div>
                <div class="mark-title">
                    填寫計畫
                </div>
            </div> -->
            <div class="application-form-title title-bot-border form-border-no-title ">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div>
                    修改帳號資訊
                    <!-- <small>請填寫以下表格，<span>「＊」</span>為必填</small> -->
                </div>
            </div>
            <div class="application-form teacher-account-management-form">
                <form action="" method="POST" name="applicationForm" id="form_data" class="row cont_form" autocomplete="off">
                    <div class="form_group col-lg-6">
                        <label class="must-label">登入帳號<span>：</span>
                        </label>
                        <input type="text" id="name" name="name" disabled="disabled" value="<?= $class_account['login_account'] ?>">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">姓名 <span>：</span>
                        </label>
                        <input type="text" id="name" name="name" placeholder="請輸入姓名" value="<?= $class_account['name'] ?>">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">類別 <span>：</span>
                        </label>
                        <select name="other3" id="other3" class="select-radio" disabled="disabled">
                            <option value="<?= $class_account['other3'] ?>"><?= $class_account['other3'] ?></option>
                        </select>
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">年級班級 <span>：</span>
                        </label>
                        <input type="text" disabled="disabled" placeholder="<?= $class_data['class_name'] ?>" value="">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">密碼 <span>：</span>
                        </label>
                        <input type="password" id="password" name="password" placeholder="請輸入密碼" value="">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">再次輸入密碼 <span>：</span>
                        </label>
                        <input type="password" id="password2" name="password2" placeholder="請再輸入密碼" value="">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">班網狀態 <span>：</span>
                        </label>
                        <div class="row">
                            <div class="col-3 radio-label">
                                開啟<input type="radio" name="is_enable" value="1" <?= ($class_data['is_enable'] == '1' ? 'checked' : '') ?> />
                            </div>
                            <div class="col-3 radio-label">
                                關閉 <input type="radio" name="is_enable" value="0" <?= ($class_data['is_enable'] == '0' ? 'checked' : '') ?> />
                            </div>
                        </div>
                    </div>
                    <div class="form_group col-lg-12">
                        <div class="btn-group">
                            <button class="btn-register btn-text">
                                送出
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
</script>