<?php
//$this->breadcrumbs = array(
//	'網站設定',
//);
 ?>
<section id="main" class="grid_12">
    <article id="settings">
        <h1>網站設定</h1>
        <?php $form=$this->beginWidget('CActiveForm', array(
        	'id'=>'setting-form',
        	'enableAjaxValidation'=>false,
        )); ?>
    		<ul class="tabs">
    			<li><a href="#general">一般設定</a></li>
    			<li><a href="#seo">SEO設定</a></li>
    			<li><a href="#mail">郵件設定</a></li>
    		</ul>
            <div class="tabcontent">
                <div id="general">
                    <dl class="inline">
                        <dt><label for="webname">網站Title</label></dt>
                        <dd>
							<input type="text" id="webname" name="webname" value="<?php echo G::a($detail,'detail.webname')?>" size="40" />
							<small>您的網站標題</small>
						</dd>
                        <dt><label for="fburl">Facebook粉絲頁</label></dt>
                        <dd>
							<input type="text" id="fburl" name="fburl" value="<?php echo G::a($detail,'detail.fburl')?>" size="60" />
							<small>您的Facebook粉絲頁面</small>
						</dd>
                        <dt><label for="email">E-mail</label></dt>
                        <dd>
							<input type="text" id="email" name="email" value="<?php echo G::a($detail,'detail.email')?>" size="40" />
							<small>您的公司Email 也是收信的信箱,多個收件者請用逗號區隔</small>
						</dd>
                        <dt><label for="company">公司名稱</label></dt>
                        <dd>
							<input type="text" id="company" name="company" value="<?php echo G::a($detail,'detail.company')?>" size="40" />
							<small>您的公司名稱</small>
						</dd>
                        <dt><label for="number">統一編號</label></dt>
                        <dd>
							<input type="text" id="number" name="number" value="<?php echo G::a($detail,'detail.number')?>" size="40" />
							<small>您的公司統編</small>
						</dd>
                        <dt><label for="zip">郵地區號</label></dt>
                        <dd>
							<input type="text" id="zip" name="zip" value="<?php echo G::a($detail,'detail.zip')?>" size="5" />
							<small>您的公司郵遞區號</small>
						</dd>
                        <dt><label for="address">公司地址</label></dt>
                        <dd>
							<input type="text" id="address" name="address" value="<?php echo G::a($detail,'detail.address')?>" size="60" />
							<small>您的公司地址</small>
						</dd>
                        <dt><label for="phone">公司電話</label></dt>
                        <dd>
							<input type="text" id="phone" name="phone" value="<?php echo G::a($detail,'detail.phone')?>" size="20" />
							<small>您的公司電話</small>
						</dd>
                        <dt><label for="fax">公司傳真</label></dt>
                        <dd>
							<input type="text" id="fax" name="fax" value="<?php echo G::a($detail,'detail.fax')?>" size="20" />
							<small>您的公司傳真</small>
						</dd>
                    </dl>
                </div>
				<div id="seo">
					<dl class="inline">
						<dt><label for="description">網站簡介</label></dt>
						<dd>
							<textarea id="description" name="description" rows="6" cols="60"><?php echo G::a($detail,'detail.description')?></textarea>
							<small>您的網站META簡介</small>
						</dd>
						<dt><label for="keyword">網站關鍵字</label></dt>
						<dd>
							<textarea id="keyword" name="keyword" rows="6" cols="60"><?php echo G::a($detail,'detail.keyword')?></textarea>
							<small>您的網站META關鍵字</small>
						</dd>
					</dl>
				</div>
                <div id="mail">
                    <dl class="inline">
						<dt><label for="mailType">郵件發送方式</label></dt>
						<dd>
                            <select name="mailType">
                                <option value="sendMail" <?php if( G::a($detail,'detail.mailType') == 'sendMail') echo 'selected=""'; ?>>SendMail</option>
                                <option value="SMTP" <?php if( G::a($detail,'detail.mailType')=='SMTP') echo 'selected=""'; ?>>SMTP</option>
                            </select>
							<small>您的郵件發送方式 sendMail:利用Linux內建發信程式 SMTP:需填寫以下資料</small>
						</dd>
						<dt><label for="mailSMTP">郵件HOST</label></dt>
						<dd>
							<input type="text" name="mailSMTP" value="<?php echo G::a($detail,'detail.mailSMTP')?>" size="20" />
							<small>您的SMPT伺服器</small>
						</dd>
						<dt><label for="mailUsr">郵件帳號</label></dt>
						<dd>
							<input type="text" name="mailUsr" value="<?php echo G::a($detail,'detail.mailUsr')?>" size="20" />
							<small>您的郵件帳號</small>
						</dd>
						<dt><label for="mailPwd">郵件密碼</label></dt>
						<dd>
							<input type="password" name="mailPwd" value="<?php echo G::a($detail,'detail.mailPwd')?>" size="20" />
							<small>您的郵件密碼</small>
						</dd>
						<dt><label for="mailPort">郵件PORT</label></dt>
						<dd>
							<input type="text" name="mailPort" value="<?php echo G::a($detail,'detail.mailPort')?>" size="20" />
							<small>您的郵件Port</small>
						</dd>
						<dt><label for="mailSSL">郵件SSL</label></dt>
						<dd>
							<select name="mailSSL">
                                <option value="1" <?php if( G::a($detail,'detail.mailSSL') == 1) echo 'selected=""'; ?>>是</option>
                                <option value="0" <?php if( G::a($detail,'detail.mailSSL') == 0) echo 'selected=""'; ?>>否</option>
                            </select>
							<small>是否需要SSL驗證</small>
						</dd>
                    </dl>
                </div>
            </div>
			<div class="buttons">
				<button type="submit" name="send" class="button">儲存設定</button>
				<button type="reset" class="button white">取消</button>
			</div>
        <?php $this->endWidget(); ?>
    </article>
</section>
