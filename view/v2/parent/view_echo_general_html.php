<?php if(0 and isset($this->data['layoutv2_param'][$this->data['section']['key']][1])):?>
	<?php $param1 = $this->data['layoutv2_param'][$this->data['section']['key']][1]?>
	<?php if(isset($this->data['layoutv2'][$this->data['section']['key']][$param1])):?>
		<?php echo $this->data['layoutv2'][$this->data['section']['key']][$param1]?>
	<?php endif?>
<?php endif?>

<?php
$path = Yii::getPathOfAlias('application.controllers.layoutv2.section_config.'.$this->data['layout_v2_name']);
//$file = $path.'/'.basename(__FILE__, '.php').'_'.$post['key'].'.php';
$prefix = 'view_echo_general_html_';
?>

<?php if(isset($this->data['tag_editmode_post_end'])):?>
	<?php
		if(isset($post[$prefix.'type'])){
			/*
			 * 可用的變數
			 *  $post['key'],
			 *  $post['switch'],
			 *  $post['is_update'],
			 *  $post['direction'],
			 *  $post['tag'],
			 *  $post['class'],
			 *  $post['key'],
			 *  $post['pos'],
			 *  $post['other_handle'],
			 *  $post['other2'],
			 */

			// checkbox
			if(!isset($post[$prefix.'ml_key'])){
				$post[$prefix.'ml_key'] = 0;
			}

			//$path = Yii::getPathOfAlias('application.controllers.layoutv2.section_config.'.$this->data['layout_v2_name']);
			@mkdir($path, 0777, true);
			$file = $path.'/'.basename(__FILE__, '.php').'_'.$post['key'].'.php';
			$tmp01 = array(
				$prefix.'type'      => $post[$prefix.'type'],
				$prefix.'ml_key'    => $post[$prefix.'ml_key'],
				$prefix.'is_enable' => $post[$prefix.'is_enable'],
				$prefix.'queryx'    => $post[$prefix.'queryx'], // queryAll, queryRow
				$prefix.'sort_id'   => $post[$prefix.'sort_id'],
				$prefix.'target_id' => $post[$prefix.'target_id'],
				$prefix.'output_field'   => $post[$prefix.'output_field'],
			);
			file_put_contents($file, '<'.'?'.'php $tmp01='.var_export($tmp01,true).';');

			// 如果不想要POST的IF判斷式全部重包，那就用這樣子的寫法
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']));
			die;
		}
	?>
<?php endif?>

[POS1]
<?php
	$tmp01 = array();
	if(isset($this->data['section']['key'])){
		$file = $path.'/'.basename(__FILE__, '.php').'_'.$this->data['section']['key'].'.php';
		// 這裡是修改和非修改模式都會跑的地方
		if(file_exists($file)){
			include $file;
			$run = '$tmp = $this->db->createCommand()->from("html")';
			$runs = array();
			if(isset($tmp01[$prefix.'type']) and $tmp01[$prefix.'type'] != ''){
				$runs[] = ' type=\''.$tmp01[$prefix.'type'].'\' ';
			}
			if(isset($tmp01[$prefix.'ml_key']) and $tmp01[$prefix.'ml_key'] > 0){
				$runs[] = ' ml_key=\''.$this->data['ml_key'].'\' ';
			}
			if(isset($tmp01[$prefix.'is_enable']) and $tmp01[$prefix.'is_enable'] == 1){
				$runs[] = ' is_enable=1 ';
			} elseif(isset($tmp01[$prefix.'is_enable']) and $tmp01[$prefix.'is_enable'] == 2){
				$runs[] = ' is_enable=0 ';
			}
			if(count($runs) > 0){
				$runs_tmp = implode(' AND ', $runs);
				$run .= '->where("'.$runs_tmp.'")';
			}
			if(isset($tmp01[$prefix.'sort_id']) and $tmp01[$prefix.'sort_id'] != ''){
				$run .= '->order("'.$tmp01[$prefix.'sort_id'].'")';
			}
			if(isset($tmp01[$prefix.'queryx']) and $tmp01[$prefix.'queryx'] == '2'){
				$run .= '->queryRow();';
			} else {
				$run .= '->queryAll();';
			}
			eval($run);

			if(isset($tmp01[$prefix.'target_id']) and $tmp01[$prefix.'target_id'] != ''){
				$this->data['layoutv2'][$tmp01[$prefix.'target_id']] = $tmp;
			}

			if(isset($tmp01[$prefix.'output_field']) 
				and $tmp01[$prefix.'output_field'] != ''
				and isset($tmp01[$prefix.'queryx'])
				and $tmp01[$prefix.'queryx'] == '2' // 單筆
				and isset($tmp[$tmp01[$prefix.'output_field']])
			){
				echo $tmp[$tmp01[$prefix.'output_field']];
			}
		}
	}
?>

<?php
if(isset($this->data['tag_editmode_get_toolbar']) and $this->data[$this->data['layout_v2_name'].'_editmode']){
	// 搜尋html資料表，整理出來type的列表
	$types = $this->db->createCommand()->select('type')->from('html')->where('type!=""')->group('type')->queryAll();
?>
	<br /><br />
	型態：<select class="form-control" name="<?php echo $prefix?>type">
	<?php foreach($types as $k => $v):?>
		<?php if($v['type'] == ''):?><?php continue?><?php endif?>
		<option <?php if( (isset($tmp01[$prefix.'type']) and $tmp01[$prefix.'type'] == $v['type']) or (!isset($tmp01[$prefix.'type']) and $k == 0) ):?>selected<?php endif?> ><?php echo $v['type']?></option>
	<?php endforeach?>
	</select>
	<br />
	<label>語系： <input type="checkbox" name="<?php echo $prefix?>ml_key" value="1" <?php if(isset($tmp01[$prefix.'ml_key']) and $tmp01[$prefix.'ml_key'] > 0):?>checked<?php endif?> /></label>
	<br />
	是否啟用：
	<select class="form-control" name="<?php echo $prefix?>is_enable">
		<option value="0" <?php if( (isset($tmp01[$prefix.'is_enable']) and $tmp01[$prefix.'is_enable'] == 0) or !isset($tmp01[$prefix.'is_enable']) ):?>selected<?php endif?> >不需要</option>
		<option value="1" <?php if( (isset($tmp01[$prefix.'is_enable']) and $tmp01[$prefix.'is_enable'] == 1) ):?>selected<?php endif?> >搜尋啟用</option>
		<option value="2" <?php if( (isset($tmp01[$prefix.'is_enable']) and $tmp01[$prefix.'is_enable'] == 2) ):?>selected<?php endif?> >搜尋不啟用</option>
	</select>
	<br />
	<label class="radio-inline">
		<input type="radio" name="<?php echo $prefix?>queryx" value="1" <?php if( (isset($tmp01[$prefix.'queryx']) and $tmp01[$prefix.'queryx'] == 1) or !isset($tmp01[$prefix.'queryx']) ):?>checked<?php endif?> > 多筆
	</label>
	<label class="radio-inline">
		<input type="radio" name="<?php echo $prefix?>queryx" value="2" <?php if( (isset($tmp01[$prefix.'queryx']) and $tmp01[$prefix.'queryx'] == 2) ):?>checked<?php endif?> > 單筆
	</label>
	<br />
	<?php $tmp = array(
		'id',
		'ml_key',
		'member_id',
		'class_id',
		'type',
		'topic',
		'detail',
		'url1',
		'pic1',
		'file1',
		'other1',
		'other2',
		'other3',
		'other4',
		'video_1',
		'video_2',
		'video_3',
		'video_4',
		'field_data',
		'field_tmp',
		'sort_id',
		'start_date',
		'end_date',
		'is_news',
		'is_home',
		'is_enable',
		'create_time',
		'update_time',
	)?>
	排序欄位：
	<select class="form-control" name="<?php echo $prefix?>sort_id">
	<option value="" <?php if(!isset($tmp01[$prefix.'sort_id'])):?>selected<?php endif?> >不需要</option>
	<?php foreach($tmp as $k => $v):?>
		<option <?php if( (isset($tmp01[$prefix.'sort_id']) and $tmp01[$prefix.'sort_id'] == $v) ):?>selected<?php endif?> ><?php echo $v?></option>
	<?php endforeach?>
	</select>
	<br />指定給誰(key編號)：<input type="text" name="<?php echo $prefix?>target_id" size="8" value="<?php if(isset($tmp01[$prefix.'target_id'])):?><?php echo $tmp01[$prefix.'target_id']?><?php endif?>" />
	<br />
	輸出單筆欄位：
	<select class="form-control" name="<?php echo $prefix?>output_field">
	<option value="" <?php if(!isset($tmp01[$prefix.'output_field'])):?>selected<?php endif?> >不需要</option>
	<?php foreach($tmp as $k => $v):?>
		<option <?php if( (isset($tmp01[$prefix.'output_field']) and $tmp01[$prefix.'output_field'] == $v) ):?>selected<?php endif?> ><?php echo $v?></option>
	<?php endforeach?>
	</select>
<?php
	// 不然會在出現一次，不要問我為什麼
	unset($this->data['tag_editmode_get_toolbar']);
} // $this->data['tag_editmode_get_toolbar']
?>

<?php 

/*
 * 下面沒有東西哦
 */

if($this->data[$this->data['layout_v2_name'].'_editmode'] and 0){
//[POS1]

	echo '[Data]';

	// 搜尋html資料表，整理出來type的列表
	$types = $this->db->createCommand()->select('type')->from('html')->group('type')->queryAll();
	$tmp_key = $this->data['section']['key'];

	//include 'dBug.php';
	$dbug = '';
	if(isset($this->data['layoutv2_param'][$this->data['section']['key']][11]) and $this->data['layoutv2_param'][$this->data['section']['key']][11] != ''){
		ob_start();
		// 因為這裡會直接輸出，所以要先包起來
		new dBug($this->data['layoutv2'][$this->data['layoutv2_param'][$this->data['section']['key']][11]], '', true); 
			
		$dbug = ob_get_contents();
		ob_end_clean();
	}
	?>
	<a href="javascript:;" id="view_echo_general_html_anchor_<?php echo $this->data['section']['key']?>">顯示參考</a>
	<div class="Bbox_full" id="view_echo_general_html_<?php echo $this->data['section']['key']?>" style="display:none" >
		<h4>用在哪裡？</h4>
		<p>只是簡單的取得資料而以</p>
		<h4>缺點是什麼？</h4>
		<p>無法下自定的SQL、SQL有錯誤的話會讓整個頁面報錯、資料內容物無法更改、欄位也無法更改名稱</p>
		<h4>引數</h4>
		<ul>
			<li>1. 型態(請參照下面)</li>
			<li>2. 語系跟隨(預設忽略，0:否，1:要)</li>
			<li>3. 排序欄位(預設忽略，請指定欄位內容以及排序方式)</li>
			<li>4. 是否啟用(預設忽略，0:否，1:要)</li>
			<li>5. 分類編號(預設忽略)</li>
			<li>6. 會員編號(預設忽略)</li>
			<li>7. 多筆還是單筆(預設多筆，1:多筆，0:單筆)</li>
			<li>8~10. 預留</li>
			<li>11. 這是誰的資料(請提供key值)</li>
		</ul>
		<h4>即有的型態列表</h4>
		<ul>
		<?php foreach($types as $k => $v):?>
			<?php if($v['type'] == ''):?><?php continue?><?php endif?>
			<li><?php echo $v['type']?></li>
		<?php endforeach?>
		</ul>
	</div>
	<div class="Bbox_full">
		<br />
		<?php echo $dbug?>
		<br />
	</div>
	<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
	<?php $this->data['BODY_END'] .= <<<XXX
	<script type="text/javascript">
	$(document).ready(function(){
		$('#view_echo_general_html_anchor_$tmp_key').click(function(){
			$('#view_echo_general_html_$tmp_key').toggle();
			$('#view_echo_general_html_dbug_$tmp_key').toggle();
		});
	});
	</script>

XXX;
	?>

<?php

} // editmode
