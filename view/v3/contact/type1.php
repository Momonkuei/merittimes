<?php // include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
<form class="form_start">

	<div class="blockTitle"><span>CONTACT US</span></div>

	<p class="blockInfoTxt">
		<?php echo t('請填寫在線表格與我們聯繫。')?>
		<label class="must"><?php echo t('為必填')?></label>
	</p>

	<?php if(0):?>
		<?php if($this->data['ml_key'] == 'tw'):?>
		<?php else:?>
			<p class="blockInfoTxt">
				Please fill out the online form to contact with us. 
				<label class="must">Fields marked with * are required</label>
			</p>
		<?php endif?>
	<?php endif?>

	<?php if(0):// 2019-03-27 詢問車 改為連到 聯絡我們 ( 點擊後，會帶產品名稱 到 聯絡我們表單 )?>
		<?php if(isset($_SESSION['save']['productinquiry']) and count($_SESSION['save']['productinquiry']) > 0):?>
		<?php
		$tmp = $_SESSION['save']['productinquiry'];
		foreach($tmp as $k => $v); // 單行
		// newsheet___47___0
		$tmps = explode('___',$k);
		$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$tmps[1])->get($tmps[0])->row_array();
		?>
		<div class="Bbox_in_1c">
			<div>
				<div class="formItem">
					<label t="* tw ucfirst">產品名稱</label>
					<p class="txtColor_cis2"><?php echo $row['name']?></p>
					<input type="hidden" name="other2" value="<?php echo $row['name']?>">
				</div>
			</div>
		</div>
		<?php endif?>
	<?php endif?>

	<div class="Bbox_in_2c">
		<div>
			<div class="formItem">
				<label class="must" t="* tw ucfirst">姓名</label>
				<input type="text" id="name" name="name" placeholder="" value="<?php echo $save['name']?>">
			</div>
<?php if(0)://2018-12-19李哥早上說b2b不用?>
			<div class="formItem">
				<label t="* tw ucfirst">性別</label>
				<div class="radio">
					<label><input type="radio" name="gender" t="value tw ucfirst" value="男" /> <span t="* tw ucfirst">男</span> </label>
					<label><input type="radio" name="gender" t="value tw ucfirst" value="女" /> <span t="* tw ucfirst">女</span> </label>
				</div>
			</div>
<?php endif?>
			<div class="formItem">
				<label class="must" t="* tw ucfirst">公司名稱</label>
				<input type="text" id="company_name" name="company_name" placeholder="" value="<?php echo $save['company_name']?>">
			</div>
			<div class="formItem">
				<label t="* tw ucfirst">傳真</label>
				<input type="text" id="fax" name="fax" placeholder="" value="<?php echo $save['fax']?>">
			</div>
			<div class="formItem">
				<label class="must" t="* tw ucfirst">電話</label>
				<input type="text" id="phone" name="phone" placeholder="" value="<?php echo $save['phone']?>">
			</div>
			<div class="formItem">
				<label t="* tw ucfirst">分機</label>
				<input type="text" id="exten" name="exten" placeholder="" value="<?php echo $save['exten']?>">
			</div>
		</div>
	</div>
	<div class="Bbox_in_1c">
		<div>
			<div class="formItem">
				<label class="must">E-Mail</label>
				<input type="email" id="email" name="email" placeholder="" value="<?php echo $save['email']?>">
			</div>
<?php if(0):?>
			<?php
			$rows = $this->cidb->where('is_enable',1)->order_by('name','asc')->get('country')->result_array();
			foreach($rows as $k => $v){
				$v['value'] = $v['name'];

				// $v['name'] = t($v['name'],'en');
				if($this->data['ml_key'] == 'tw'){
					$v['name'] = $v['tw'];
				}
				$rows[$k] = $v;
			}
			$this->data['country'] = $rows;
			?>

			<div style="display:none" k="aabbcccountry">
			    <option value="" l="list">Please Select</option>
			</div>
			<div class="formItem">
				<label class="must" t="* tw ucfirst">國家</label>
				<select name="other1" l="layer" ls="country" kg="aabbcccountry">
				    <option value="{/value/}" l="list">{/name/}</option>
				</select>
			</div>
<?php endif?>
			<div class="formItem oneLine">
				<label t="* tw ucfirst">地址</label>
				<span class="twzipcode"></span>
			</div>
			<div class="formItem">
				<input type="text" id="addr" name="addr" placeholder="<?php echo t('地址')?>" value="<?php // echo $save['addr'] // 2020-02-10 因為後台沒有addr欄位，所以這裡要註解?>">
			</div>

			<?php if(0):?>
				<div class="formItem">
					<label class="" t="* tw ucfirst">附加照片</label>
					<span class="upFileName"></span>
					<div class="upFileBtn">
						<span t="* tw ucfirst">上傳</span>
						<input type="file" id="fileToUpload" name="fileToUpload">
					</div>
				</div>
			<?php endif?>

			<div class="formItem">
				<label class="must" t="* tw ucfirst">意見</label>
				<textarea id="detail" name="detail"><?php echo $save['detail']?></textarea>
			</div>

			<div class="formItem oneLine">
				<label class="must" t="* tw ucfirst">認證碼</label>
				<input type="text" id="captcha" name="captcha" /><img id="valImageId" src="captcha.php" width="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
			</div>
		
		</div>
	</div>


	<div>
		<button><i class="fa fa-paper-plane"></i><?php echo t('SEND','en')?></button>	
	</div>							
</form>
