<?php

/* JQuery.validate
required：必填欄位
email：格式要符合E-Mail格式
url：格式要符合網址格式，如：https://www.minwt.com
number：數字格包含小數點
digits：數字為正整數
date：日期格式
dateISO：日期格式，格式必需為YYYY/MM/DD、YYYY-MM-DD、YYYYMMDD
equalTo：與某一欄位值相同

minValue：最小字元長度
maxValue：最大字元長度
rangeValue：字元長度區間長度

minLength：最小字元長度(漢字算一個字符)
maxLength：最大字元長度(漢字算一個字符)
rangeLength：字元長度區間長度(漢字算一個字符)
 */
$company_member_result = $this->cidb->where('keyname','function_constant_company_member')->get('sys_config')->row_array();
$company_member_style=$company_member_result["keyval"];

if(isset($validation) and !empty($validation)){ // 2020-03-19
	// 略過admin_field_get的步驟
} else {
	$admin_field_router_class = str_replace('_', '', $this->data['router_method']); // 2018-06-28 str_replace是為了支援編排頁

	if($this->data['router_method'] == 'guestregister'){
		$admin_field_router_class = 'customer';
	}

	$admin_field_section_id = 0;
	include _BASEPATH.'/../source/system/admin_field_get.php';

	$validation = G::getJqueryValidation($admin_def['empty_orm_data']['rules']);

	// 其它額外條件
	$validation['captcha']['required'] = true;

	if($this->data['router_method'] == 'guestregister'){
		$validation['login_password']['required'] = true;
		$validation['login_password_confirm']['required'] = true;
		if($company_member_style=="true"){
			$validation['other2']['required'] = true;
			$validation['other4']['required'] = true;
			$validation['other3']['required'] = true;
		}
	}
}

// 其它範本
// $validation['old_time_3']['selectcheck'] = true;
// $validation['old_time_4']['selectcheck'] = true;
// $validation['old_time_5']['selectcheck'] = true;
// $validation['old_time_1']['selectcheck'] = true;
// //$validation['old_time_2']['selectcheck'] = true; // #13507
// $validation['old_addr_1']['selectcheck'] = true;
// $validation['old_addr_1_2']['selectcheck'] = true;
// $validation['new_addr_1']['selectcheck'] = true;
// $validation['new_addr_1_2']['selectcheck'] = true;
// $validation['GGGAAA']['selects'] = true;
//
// 其它範本
// $validation['ggg[]']['roles'] = true; // 多個checkbox範例，可以選多個，記得html上，要加上class="roles"
// $validation['ggg']['required'] = true; // 多個radio範例，只能選一個

$this->data['jqueryvalidation'] = json_encode($validation);
$this->data['updatecontent_jqueryvalidation'] = $validation;
?>

<?php if(LAYOUTV3_THEME_NAME == 'v4'):?>
	<?if(isset($tmp)){?>
		<form target="hideframe" action="" method="post" name="memberForm" id="form_data" <?php echo "enctype=\"multipart/form-data\"" ?> class="row form_b2b_2" autocomplete="off" > 
	<? }else{ ?>
		<form target="hideframe" action="" method="post" name="memberForm" id="form_data" <?php echo "enctype=\"multipart/form-data\"" ?> class="row cont_form" autocomplete="off" > 
	<? } ?>

<?php else:?>
<form target="hideframe" action="" method="post" name="memberForm" id="form_data" <?php echo "enctype=\"multipart/form-data\"" ?>  autocomplete="off" > 
<?php endif?>

	<?php // https://stackoverflow.com/questions/7083325/firefox-form-targeting-an-iframe-is-opening-new-tab?noredirect=1&lq=1?>
	<iframe id="hideframe" name="hideframe" style="display:none" src=""></iframe>
	<input id="force_save" type="hidden" name="123" />
	<input type="hidden" name="gtoken" class="gtoken" />

	<script src="js_common/reload.js" m="body_end"></script>

	<?php $save = array()// 存放表單裡面的東西，為了讓使用者輸入一半，去其它地方回來這裡，己輸入過的欄位會留著，直到洽詢送出以後?>
	<?php if(isset($_SESSION['save'][$ID])):?>
		<?php $save = $_SESSION['save'][$ID]?>
	<?php endif?>

	<?php // 這樣子就不用在寫判斷式，看元素有沒有存在?>
	<?php if(isset($admin_fields) and count($admin_fields) > 0):?>
		<?php foreach($admin_fields as $k => $v):?>
			<?php if(!isset($save[$v])):?>
				<?php $save[$v] = ''?>
			<?php endif?>
		<?php endforeach?>
	<?php endif?>

	<script type="text/javascript" m="body_end">
		$(document).ready(function() {
			$('#form_data input[type=text]').change(function(){
				<?php // http://stackoverflow.com/questions/13833204/how-to-set-a-js-object-property-name-from-a-variable?>
				var jsonvariable = {};
				jsonvariable['id'] = '<?php echo $ID?>';
				jsonvariable[$(this).attr('name')] = $(this).val();

				$.ajax({
					type: "POST",
					data: jsonvariable,
					url: 'save.php',
					success: function(response){
						//eval(response);
					}
				}); // ajax
			});
			$('#form_data textarea').change(function(){
				<?php // http://stackoverflow.com/questions/13833204/how-to-set-a-js-object-property-name-from-a-variable?>
				var jsonvariable = {};
				jsonvariable['id'] = '<?php echo $ID?>';
				<?php // http://stackoverflow.com/questions/19241272/save-textarea-value-to-json?>
				var newtext = $(this).val();
				newText = newtext.replace(/\r?\n/g, '<br />');
				jsonvariable[$(this).attr('name')] = newText;

				$.ajax({
					type: "POST",
					data: jsonvariable,
					url: 'save.php',
					success: function(response){
						//eval(response);
					}
				}); // ajax
			});
		});
	</script>	

	<?php if(0):// #35446 這是舊版的欄位驗證在使用的?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#memberForm').submit(function(event){
			MM_validateForm('<?php echo t('姓名')?>','','R','<?php echo t('E-Mail','en')?>','','RisEmail','<?php echo t('電話')?>','', 'R', '<?php echo t('公司名稱')?>', '', 'R', '<?php echo t('意見')?>', '', 'R', '<?php echo t('認證碼')?>', '', 'R', this);
			var ggg = document.MM_returnValue;
			if(ggg === true){
				$('#memberForm').find('button').remove();
				alert('傳送中');
			}
			return ggg;
		});
	});
	</script>
	<?php endif?>

	<?php include 'view/system/default_validate.php'// 2018-06-20 取代form開頭的標籤?>

<?php // 這裡沒有form的結尾哦?>
