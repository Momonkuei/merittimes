<?php
$path = Yii::getPathOfAlias('application.controllers.layoutv2.section_config.'.$this->data['layout_v2_name']);
//$file = $path.'/'.basename(__FILE__, '.php').'_'.$post['key'].'.php';
$prefix = 'view_editor_';
?>

<?php if(isset($this->data['tag_editmode_post_end'])):?>
	<?php
		if(isset($post[$prefix.'content'])){
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

			//$path = Yii::getPathOfAlias('application.controllers.layoutv2.section_config.'.$this->data['layout_v2_name']);
			@mkdir($path, 0777, true);
			$file = $path.'/'.basename(__FILE__, '.php').'_'.$post['key'].'.php';
			file_put_contents($file, $post[$prefix.'content']);
			@chmod($file,0777);

			// 如果不想要POST的IF判斷式全部重包，那就用這樣子的寫法
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']));
			die;
		}
	?>
<?php endif?>

<?php
	$tmp01 = '';
	if(isset($this->data['section']['key'])){
		if(isset($this->data['section']['key']) and $this->data['router_class'] == 'site' and $this->data['router_method'] == 'demogroup'){
			$file = Yii::getPathOfAlias('application.controllers.layoutv2.section_config.'.str_replace('/', '-',$_GET['p1'])).'/'.basename(__FILE__, '.php').'_'.str_replace('0_', '', $this->data['section']['key']).'.php';
		} else {
			$file = $path.'/'.basename(__FILE__, '.php').'_'.$this->data['section']['key'].'.php';
		}
		// 這裡是修改和非修改模式都會跑的地方
		if(file_exists($file)){
			$tmp01 = file_get_contents($file);
			include $file;
		}
	}
?>

<?php
if(isset($this->data['tag_editmode_get_toolbar']) and $this->data[$this->data['layout_v2_name'].'_editmode']){
?>
	<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END'] = ''?><?php endif?>
<?php $url = $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']+array('pos'=>'1','key'=>''))?>
<?php $this->data['BODY_END'] .= <<<XXX
<script src="/_i/framework/frontend/assetsg/js/edit_area/edit_area_full.js"></script>
<script type="text/javascript">
editAreaLoader.init({
	id: "example_1"	// id of the textarea to transform		
	,start_highlight: true	// if start with highlight
	,allow_resize: "both"
	,allow_toggle: true
	,word_wrap: true
	,language: "en"
	,syntax: "php"	
});
</script>	
XXX;
?>
<br />
<br />
<textarea id="example_1" style="height: 350px; width: 100%;" name="<?php echo $prefix?>content"><?php echo $tmp01?></textarea>
<?php
	// 不然會在出現一次，不要問我為什麼
	unset($this->data['tag_editmode_get_toolbar']);
} // $this->data['tag_editmode_get_toolbar']
?>
