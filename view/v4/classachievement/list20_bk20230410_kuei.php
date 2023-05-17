<?
include _BASEPATH . '/../source/classachievement/post_1.php';
?>
<div class="top-function-column application-form cont_form classes-webs-search">
	<form action="" method="GET" name="applicationForm" id="form_data" class="row cont_form" enctype="multipart/form-data" autocomplete="off">
	<div class="row">
		<div class="add-area col-lg-10">
			<div class="row">
				<div class="class-selection class-web-label col-lg-3">
					<span class="title">學校：</span>
					<select name="school" id="school" class="select-radio">
						<option value="">請選擇學校</option>
						<?if(!empty($school_list)){
							foreach($school_list as $k => $v){?>
								<option value="<?=$k?>" <?=(isset($_GET['school']) && !empty($_GET['school']) && $_GET['school']==$k?'selected':'')?>><?=$v?></option>
							<?}
						}?>
					</select>
				</div>
				<div class="class-selection class-web-label col-lg-3">
					<span class="title">學期</span>

					<select name="cars" id="cars" class="select-radio">
						<option value="">請選擇學期</option>
						<?if(!empty($semester_list)){
							foreach($semester_list as $k => $v){?>
								<option value="<?=$k?>" <?=(isset($_GET['cars']) && !empty($_GET['cars']) && $_GET['cars']==$k?'selected':'')?>><?=$v?></option>
							<?}
						}?>
					</select>
				</div>
				<div class="class-web-label col-lg-3">
					<span class="title">班級：</span>

					<input type="text" id="class_name" name="class_name" placeholder="請輸入班級名稱" value="<?=(isset($_GET['class_name']) && !empty($_GET['class_name'])?$_GET['class_name']:'')?>">
				</div>
				<div class="class-web-label col-lg-3">
					<span class="title">老師：</span>

					<input type="text" id="teacher_name" name="teacher_name" placeholder="請輸入老師名稱" value="<?=(isset($_GET['teacher_name']) && !empty($_GET['teacher_name'])?$_GET['teacher_name']:'')?>">
				</div>
			</div>
		</div>
		<div class="searchBtn col-lg-2">
			<button class="btn-operate btn-text">
				搜尋
			</button>
		</div>
	</div>
	</form>
</div>
<div class="newsList newsListType20 newsListType20-classachievement">
	<div class="row">
		<?if(!empty($class_list)){?>
			<?foreach($class_list as $k => $v){?>
				<div class="newsContent col-md-6 col-lg-4">
					<div class="item">
						<div class="date"><?=$school_list[$v['represent_id']]?></div>
						<a href="classout_tw_1.php?class_id=<?=$v['id']?>">
							<div class="imgBox">
								<div class="itemImg traight">
									<img src="<?=$data_path?><?=(!empty($v['code'])?$v['code'].'/'.$v['id'].'/':'all_school/')?><?=$v['pic1']?>">
								</div>
							</div>
							<div class="textBox">
								<div class="itemTitle"><?=$v['class_name']?></div>
							</div>
						</a>
					</div>
				</div>
			<?}
		}?>
	</div>
</div>