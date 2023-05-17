<?
include _BASEPATH . '/../source/classachievement/post_1.php';
?>
<div class="top-function-column application-form cont_form classes-webs-search ">
	<form action="" method="GET" name="applicationForm" id="form_data" class=" cont_form" enctype="multipart/form-data" autocomplete="off">
		<div class="row ">
			<div class="add-area col-xl-10">
				<div class="row">
					<div class="class-selection class-web-label col-xl-3">
						<span class="title">學校：</span>

						<!-- <input name='school' list='schoolList' placeholder="請輸入學校名稱"> -->
						<!-- 因有要求使用搜尋的方式，而進行嘗試 -->
						<!-- <datalist id='schoolList'>
							<? if (!empty($school_list)) {
								foreach ($school_list as $k => $v) { ?>
									<option value="<?= $k ?>" <?= (isset($_GET['school']) && !empty($_GET['school']) && $_GET['school'] == $k ? 'selected' : '') ?>><?= $v ?></option>
							<? }
							} ?>
						</datalist> -->

						<select name="school" id="school" class="select-radio">
							<option value="">請選擇學校</option>
							<? if (!empty($school_list)) {
								foreach ($school_list as $k => $v) { ?>
									<option value="<?= $k ?>" <?= (isset($_GET['school']) && !empty($_GET['school']) && $_GET['school'] == $k ? 'selected' : '') ?>><?= $v ?></option>
							<? }
							} ?>
						</select>
					</div>
					<div class="class-selection class-web-label col-xl-3">
						<span class="title">學期：</span>

						<select name="cars" id="cars" class="select-radio">
							<option value="">請選擇學期</option>
							<? if (!empty($semester_list)) {
								foreach ($semester_list as $k => $v) { ?>
									<option value="<?= $k ?>" <?= (isset($_GET['cars']) && !empty($_GET['cars']) && $_GET['cars'] == $k ? 'selected' : '') ?>><?= $v ?></option>
							<? }
							} ?>
						</select>
					</div>
					<div class="class-web-label col-xl-3">
						<span class="title">班級：</span>

						<input type="text" id="class_name" name="class_name" placeholder="請輸入班級名稱" value="<?= (isset($_GET['class_name']) && !empty($_GET['class_name']) ? $_GET['class_name'] : '') ?>">
					</div>
					<div class="class-web-label col-xl-3">
						<span class="title">老師：</span>

						<input type="text" id="teacher_name" name="teacher_name" placeholder="請輸入老師名稱" value="<?= (isset($_GET['teacher_name']) && !empty($_GET['teacher_name']) ? $_GET['teacher_name'] : '') ?>">
					</div>
				</div>
			</div>
			<div class=" btn-group col-xl-2">
				<button class="btn-operate btn-text">
					搜尋
				</button>
				<button class="btn-operate btn-text" type="button" onclick="javascript:location.href='classachievement_<?= $this->data['ml_key'] ?>.php'">
					清除
				</button>
			</div>
			<!-- <div class="searchBtn col-lg-1">
				<button class="btn-operate btn-text" type="button" onclick="javascript:location.href='classachievement_<?= $this->data['ml_key'] ?>.php'">
					清除
				</button>
			</div> -->
		</div>
	</form>
</div>
<div class="newsList newsListType20 newsListType20-classachievement">
	<div class="row">
		<? if (!empty($class_list)) { ?>
			<? foreach ($class_list as $k => $v) { ?>
				<div class="newsContent col-md-6 col-lg-4">
					<div class="item">
						<div class="date"><?= $school_list[$v['represent_id']] ?></div>
						<a href="classout_tw_1.php?class_id=<?= $v['id'] ?>">
							<div class="imgBox">
								<div class="itemImg traight">
									<img src="<?= $data_path ?><?= (!empty($v['code']) ? $v['code'] . '/' . $v['id'] . '/' : 'all_school/') ?><?= $v['pic1'] ?>">
								</div>
							</div>
							<div class="textBox">
								<div class="itemTitle"><?= $v['class_name'] ?></div>
							</div>
						</a>
					</div>
				</div>
		<? }
		} ?>
	</div>
	<? if (!empty($pageRecordInfo['pagination'])) { ?>
		<div class="pageNumber">
			<ul>
				<?php if (isset($pageRecordInfo['prev_url'])) : ?>
					<?php if ($pageRecordInfo['prev_url'] != '') : ?>
						<li class="prev"><a href="<?php echo $pageRecordInfo['prev_url'] ?>"><?php echo t('Prev', 'en') ?></a></li>
					<?php else : ?>
						<li class="prev disabled"><a href="javascript:;"><?php echo t('Prev', 'en') ?></a></li>
					<?php endif ?>
				<?php endif ?>
				<li><?php echo $pageRecordInfo['pagination']['control']['now'] ?></li>
				<li>/</li>
				<li><?php echo $pageRecordInfo['pagination']['control']['total'] ?></li>
				<?php if (isset($pageRecordInfo['next_url'])) : ?>
					<?php if ($pageRecordInfo['next_url'] != '') : ?>
						<li class="next"><a href="<?php echo $pageRecordInfo['next_url'] ?>"><?php echo t('Next', 'en') ?></a></li>
					<?php else : ?>
						<li class="next disabled"><a href="javascript:;"><?php echo t('Next', 'en') ?></a></li>
					<?php endif ?>
				<?php endif ?>
			</ul>
		</div>
	<? } ?>
</div>

<script m="body_end">
	$(function() {
		$("#school").select2({
			language: 'zh-TW',
			width: '100%',
			// 最多字元限制
			maximumInputLength: 10,
			// 最少字元才觸發尋找, 0 不指定
			minimumInputLength: 0,
			// 當找不到可以使用輸入的文字
			tags: true,
		});

		// 限制欄位最大寬度，避免跑版
		if ($('.classes-webs-search .class-selection .select2-selection--single').length) {
			// const carsWidth = $('#cars').width();

			$('.classes-webs-search .class-selection .select2-selection--single').css('max-width', $('#cars').outerWidth());
		}

	})
</script>