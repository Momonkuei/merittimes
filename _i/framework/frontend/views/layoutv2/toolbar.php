<?php
//2016/1/5 lota 加入為了能夠切換layout資料夾設定的變數 只改變子站，不改變母體
$layout_folder = 'layoutv2';
if(isset($GLOBALS['layout_folder'])) $layout_folder = $GLOBALS['layout_folder'];
?>

<?php if($this->data[$this->data['layout_v2_name'].'_editmode']):?>
<div class="Bbox_full">
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<a href="#" id="remove_parent">[移除上方空白]</a>
	<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END'] = ''?><?php endif?>
<?php $demosection_url = $this->data['router_class'].'/'.$this->data['router_method']?>
<?php $FRONTEND_LAYOUTV2_DEMO = FRONTEND_LAYOUTV2_DEMO;//目前用不到?>
<?php $this->data['BODY_END'] .= <<<XXX
		<script type="text/javascript">
		$(document).ready(function(){
			$('#remove_parent').click(function(){
				$(this).parent().remove();
			});
			$('.layoutv2demosection').hover(
				function(){
					// 本地展示
					$('#demosection_local').attr('src','index.php?r=site/demosection&r2=$demosection_url&key2='+$(this).attr('key2'));
					$('#demosection_local').show();
				},
				function(){
				}
			);
		});
</script>	
XXX;
?>
</div>
<?php endif?>



<?php if($this->data[$this->data['layout_v2_name'].'_editmode']):?>
	<?php //$toolbar_preview = $this->renderPartial('//layoutv2/toolbar_preview', $this->data, true)?>
	<?php include 'toolbar_preview.php'?>
	<a class="share_toggle_list_a_0" href="javascript:;">[展開 / 隱藏]</a>
	<span class="share_toggle_list_0" styleg="display:none">

	<div class="Bbox">

		<div class="Bbox_in_2c_L4">
			<div><!-- in_2c_L4第一層 -->
				<div><!-- in_2c_L4第二層第一個 -->
					<a href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('clear'=>1)+$_SESSION[$this->data['session_name'].'_params'])?>">全部重弄</a>
					　<a onclick="return confirm('你？存檔了嗎')" href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('edit'=>0)+$_SESSION[$this->data['session_name'].'_params'])?>">展示</a>

					<?php if(isset($_SESSION[$this->data['session_name'].'_only_tree']) and $_SESSION[$this->data['session_name'].'_only_tree'] == '1'):?>
					　<a href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('only_tree'=>0)+$_SESSION[$this->data['session_name'].'_params'])?>">不只要樹</a>
					<?php else:?>
					　<a href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('only_tree'=>1)+$_SESSION[$this->data['session_name'].'_params'])?>">只要樹</a>
					<?php endif?>

					<?php if(isset($_SESSION[$this->data['session_name'].'_need_point']) and $_SESSION[$this->data['session_name'].'_need_point'] == '1'):?>
					　<a href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('need_point'=>0)+$_SESSION[$this->data['session_name'].'_params'])?>">不要指標</a>
					<?php else:?>
					　<a href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('need_point'=>1)+$_SESSION[$this->data['session_name'].'_params'])?>">要指標</a>
					<?php endif?>

					　<a onclick="return confirm('要存檔嗎？(本地)')" href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('save'=>1)+$_SESSION[$this->data['session_name'].'_params'])?>">存檔本地</a>
<?php if(0):?>
					　<a onclick="return confirm('要存檔到母體嗎？')" href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('savecore'=>1)+$_SESSION[$this->data['session_name'].'_params'])?>">存檔母體！</a>
<?php endif?>
					　<a onclick="return confirm('你要跟進最新分類嗎？')" href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('clearcategoryx'=>1)+$_SESSION[$this->data['session_name'].'_params'])?>">跟進最新分類</a>
					　<a onclick="return confirm('你要清除SCSS暫存嗎？')" href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('clearscss'=>1)+$_SESSION[$this->data['session_name'].'_params'])?>">清除SCSS暫存</a>

					<br />
					<span id="jstree">
					<?php echo $this->data['render_tree']?>
					</span>

					<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END'] = ''?><?php endif?>
<?php if(0):?>
					<link rel="stylesheet" href="/_i/framework/frontend/assetsg/js/jstree/themes/default/style.css" />
<?php $url = $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']+array('pos'=>'1','key'=>''))?>
<?php $this->data['BODY_END'] .= <<<XXX
		<script src="/_i/framework/frontend/assetsg/js/jstree/jstree.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#jstree").jstree();
		});
</script>	
XXX;
?>
<?php endif?>

				</div><!-- / in_2c_L4第二層第一個 -->
				<div><!-- / in_2c_L4第二層第二個 -->
					<iframe id="demosection_local" style="display:none" frameborder="0" width="100%" height="150" src=""></iframe>
					<?php if($this->data[$this->data['layout_v2_name'].'_editmode'] and ( ( isset($_GET['pos']) and isset($_GET['key']) ) OR count($_SESSION[$this->data['session_name']]) == 0 )  ):?>
						<?php $tag = 'div'?>
						<?php $type = 'Bbox'?>
						<?php $other2 = ''?>
						<?php $other = array()?>
						<?php if(count($_SESSION[$this->data['session_name']]) == 0):?>
							<?php $_GET['pos'] = 1?>
							<?php $_GET['key'] = 0?>
						<?php endif?>


						<?php if(isset($_SESSION[$this->data['session_name']][$_GET['key']])):?>
							<?php if(isset($_SESSION[$this->data['session_name']][$_GET['key']]['tag'])):?>
								<?php $tag = $_SESSION[$this->data['session_name']][$_GET['key']]['tag']?>
							<?php endif?>
							<?php $type = $_SESSION[$this->data['session_name']][$_GET['key']]['type']?>
							<?php $other2 = $_SESSION[$this->data['session_name']][$_GET['key']]['other2']?>
							<?php if(isset($_SESSION[$this->data['session_name']][$_GET['key']]['other']) and $_SESSION[$this->data['session_name']][$_GET['key']]['other'] != ''):?>
								<?php $other = explode(',', $_SESSION[$this->data['session_name']][$_GET['key']]['other'])?>
							<?php endif?>
						<?php endif?>
						<form method="POST" action="" class="form-inline">
							跟&nbsp;<input type="text" name="switch" value="" size="2" placeholder="誰" class="form-control" />&nbsp;換位置、
							移到&nbsp;<input type="text" name="move" value="" size="2" placeholder="誰" class="form-control" />&nbsp;的上面，
							<a style="color:red" onclick="return confirm('刪了我？')" title="刪了我？" href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('delme'=>$_GET['key'])+$_SESSION[$this->data['session_name'].'_params'])?>"><b>X</b></a>
							<br /><br />
							建立在此選擇元件的
							<select name="direction" class="form-control">
								<option selected="selected" value="inner">裡面</option>
								<option value="right">後面</option>
							</select>
							<br /><br />
							<input type="hidden" name="key" value="<?php echo $_GET['key']?>" />
							上一層&nbsp;<input class="form-control" type="text" name="pid" size="2" value="<?php if(isset($_SESSION[$this->data['session_name']][$_GET['key']])):?><?php echo $_SESSION[$this->data['session_name']][$_GET['key']]['pid']?><?php endif?>" />，
							位置&nbsp;<input class="form-control" type="text" name="pos" size="2" value="<?php echo $_GET['pos']?>" />，
							修改<input type="checkbox" name="is_update" value="1" />
							<br /><br />
							<select class="from-control" id="type_list" onchange="javascript:$('#change_class').attr('value',$('#type_list option:selected').val());;">
								<option value="">請選擇</option>
								<?php if(isset($layoutv2classtype)):?>
									<?php foreach($layoutv2classtype as $k => $v):?>
										<optgroup label="<?php echo $v['topic']?>">
										<?php
											if(!file_exists(tmp_path.'/layoutv2_category2_'.$v['id'].'.php')){
												$tmp = file_get_contents(FRONTEND_LAYOUTV2.'/index.php?r=layoutv2/category2&classtype='.$v['id']);
												file_put_contents(tmp_path.'/layoutv2_category2_'.$v['id'].'.php', '<'.'?'.'php '."\n".$tmp);
											}
										?>
										<?php include tmp_path.'/layoutv2_category2_'.$v['id'].'.php'?>
										<?php if(isset($this->data['layoutv2classes'])):?>
											<?php foreach($this->data['layoutv2classes'] as $kk => $vv):?>
													<option value="<?php echo $vv['other1']?>"><?php echo $vv['topic']?></option>
											<?php endforeach?>
										<?php endif?>
									<?php endforeach?>
								<?php endif?>
							</select>
							<br /><br />
							<select name="tag" size="10" class="form-control">
								<option disabled="disabled">這裡是外層的Tag(單選)</option><?php //2015/12/22 Lota winnie說要加入 section 標籤?>
								<?php foreach(array('div','span','nav','header','footer','article','section','p','h1','h2','h3','h4') as $k => $v):?>
									<option <?php if($tag == $v):?>selected="selected"<?php endif?> ><?php echo $v?></option>
								<?php endforeach?>
							</select>
							<input type="hidden" id="change_class" name="class" value="<?php echo $type?>" />
							<select multiple="multiple" size="10" name="other[]" class="form-control">
								<option disabled="disabled">這裡是其它的class(複選)</option>

<?php if($layoutv2class2type):?>
<?php foreach($layoutv2class2type as $k => $v):?>
	<option disabled="disabled">- - - - <?php echo $v['topic']?> - - -</option>
	<?php if($layoutv2class2_tmp[$v['id']]):?>
	<?php foreach($layoutv2class2_tmp[$v['id']] as $kk => $vv):?>
		<option value="<?php echo $vv['other1']?>" <?php if(in_array($vv['other1'], $other)):?>selected="selected"<?php endif?> ><?php echo $vv['topic']?></option>
	<?php endforeach?>
	<?php endif?>
<?php endforeach?>
<?php endif?>
								
							</select>
							<br /><br />
							<label><input type="text" name="other2" value="<?php echo $other2?>" size="55" class="form-control" />&nbsp;其它class</label>
							<?php if($other2 != ''):?>
								<br /><br />
								<?php $tmps = explode(' ', $other2)?>
								<?php foreach($tmps as $k => $v):?>
									<?php if(preg_match('/^p(\d+)_(.*)$/', $v, $matches)):?>
										參數<?php echo $matches[1]?>：<?php echo $matches[2]?><br />
									<?php endif?>
								<?php endforeach?>
							<?php endif?>
							<br /><br />
							<input type="submit" value="送出" class="form-control" />

							<?php
								// 為了要擴充區塊的功能
								if(file_exists(Yii::getPathOfAlias('application.views.'.$layout_folder).'/'.$type.'.php')){
									$file = Yii::getPathOfAlias('application.views.'.$layout_folder).'/'.$type.'.php';
								} else {
									$file = Yii::getPathOfAlias('system.frontend.views.layoutv2').'/'.$type.'.php';
								}
								if(file_exists($file)){
									$tmp = file_get_contents($file);
									if(preg_match('/tag_editmode_get_toolbar/', $tmp)){
										$this->data['tag_editmode_get_toolbar'] = $_SESSION[$this->data['session_name']][$_GET['key']];
										include $file;
									}
								}
							?>

							<?php if(isset($current_return) and isset($layoutv2class_tmp[$type]['class_id'])):?>
								<br /><br />
								目前主要的class：<?php echo '[ '.$layoutv2classtype_tmp[$layoutv2class_tmp[$type]['class_id']]['topic'].' ]　'.$layoutv2class_tmp[$type]['topic']?>
								<?php echo $current_return?>
							<?php endif?>

						</form>
					<?php endif?>
				</div><!-- / in_2c_L4第二層第二個 -->
			</div><!-- / in_2c_L4第一層 -->
		</div><!-- / in_2c_L4 -->

	</div><!-- / Bbox -->

	<br />
	<br />
	<br />

	<?php if(isset($_GET['pos']) and isset($_GET['key'])):?>

		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END'] = ''?><?php endif?>
<?php $this->data['BODY_END'] .= <<<XXX
		<script type='text/javascript' src='js/jquery.quick.pagination.js'></script>
		<link rel="stylesheet" href="css/jquery.quick.pagination.css" />
		<script type="text/javascript">
		$(document).ready(function(){
			$("ul.paging2").quickPager({pageSize:"5"});
		});
</script>	
XXX;
?>

	<div class="Bbox_1c">
		<div>
			<div class="SubMenu text-center">
				<ul class="nav nav-pills text-center">
					<?php if(isset($layoutv2classtype)):?>
						<?php foreach($layoutv2classtype as $k => $v):?>
							<li <?php if($_GET['classtype'] == $v['id']):?> class="active" <?php endif?> ><a href="<?php echo $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],array('pos'=>$_GET['pos'],'key'=>$_GET['key'],'classtype'=>$v['id'])+$_SESSION[$this->data['session_name'].'_params'])?>"><?php echo $v['topic']?></a></li>
						<?php endforeach?>
					<?php endif?>
				</ul>
			</div>
		</div>
	</div>

	<?php if(isset($toolbar_preview)):?>
		<?php echo $toolbar_preview?>	
	<?php endif?>

<?php endif?>




	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />


	</span><!-- toggle --> 

			<?php endif?><?php // 如果有點選，才會啟用預覽?>

		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END'] = ''?><?php endif?>
<?php $this->data['BODY_END'] .= <<<XXX
		<script type="text/javascript">
		$(document).ready(function(){
			$('.share_toggle_list_a_0').click(function(){
				$('.share_toggle_list_0').toggle();
			});
		});
</script>	
XXX;
?>


<?php
	if($this->data[$this->data['layout_v2_name'].'_editmode'] and isset($_SESSION[$this->data['session_name'].'_only_tree']) and $_SESSION[$this->data['session_name'].'_only_tree'] == '1'){
		// do nothing
	} else {
		// 產生內容
		$tmp = $this->search_child(0, 1);
		$return = '';
		if(isset($tmp) and count($tmp) > 0){
			foreach($tmp as $k => $v){
				$return .= $this->section_recursive($v);
			}
		}
		echo $return;
	}
?>

<?php if($this->data[$this->data['layout_v2_name'].'_editmode']):?>
<?php // 把下面弄開，為了不要被stick footer給擋住?>
<div class="Bbox_full">
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<a href="#" id="remove_parent2">[移除下方空白]</a>
	<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END'] = ''?><?php endif?>
<?php $this->data['BODY_END'] .= <<<XXX
		<script type="text/javascript">
		$(document).ready(function(){
			$('#remove_parent2').click(function(){
				$(this).parent().remove();
			});
		});
</script>	
XXX;
?>
</div>
<?php endif?>

<?php if(0):?>
<style type="text/css">
ul.thumbnails.image_picker_selector {
  overflow: auto;
  list-style-image: none;
  list-style-position: outside;
  list-style-type: none;
  padding: 0px;
  margin: 0px; }
  ul.thumbnails.image_picker_selector ul {
    overflow: auto;
    list-style-image: none;
    list-style-position: outside;
    list-style-type: none;
    padding: 0px;
    margin: 0px; }
  ul.thumbnails.image_picker_selector li.group_title {
    float: none; }
  ul.thumbnails.image_picker_selector li {
    margin: 0px 12px 12px 0px;
    float: left; }
    ul.thumbnails.image_picker_selector li .thumbnail {
      padding: 6px;
      border: 1px solid #dddddd;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none; }
      ul.thumbnails.image_picker_selector li .thumbnail img {
        -webkit-user-drag: none; }
    ul.thumbnails.image_picker_selector li .thumbnail.selected {
      background: #0088cc; }

</style>
<ul class="thumbnails image_picker_selector"><li><div class="thumbnail"><img class="image_picker_image" src="img/01.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/02.png"></div></li><li><div class="thumbnail selected"><img class="image_picker_image" src="img/03.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/04.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/05.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/06.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/07.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/08.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/09.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/10.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/11.png"></div></li><li><div class="thumbnail"><img class="image_picker_image" src="img/12.png"></div></li></ul>
<?php endif?>
