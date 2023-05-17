<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php if(isset($this->data['id'])):?>
		<?php $formattr = $this->data['vv_type_formattr']?>

		<?php
			$path = 'webroot.assets.members.'.$this->data['router_class'].$this->data['id'].'.member';
			$tmp2 = array();
			if(is_dir(Yii::getPathOfAlias($path))){
				$tmp2 = $this->_getFiles(Yii::getPathOfAlias($path));
				sort($tmp2);//lota 加入排序
			}
			if($tmp2 and count($tmp2) > 0){
				foreach($tmp2 as $kkk => $vvv){
					//echo $_SERVER['DOCUMENT_ROOT'];die;
					//echo _BASEPATH;die;
					$tmp2[$kkk] = str_replace($_SERVER['DOCUMENT_ROOT'].'_i/', '', $vvv);
				}
			}
			//var_dump($tmp2);die;
		?>

		<?php // http://demo.angeltile.com.tw/_i/timthumb.php?src=assets/members/product19/member/MLD-小金木紋-01實景圖.jpg&zc=0&w=800&nowatermark=1&dest=assets/members2/product19/big/MLD-小金木紋-01實景圖.jpg?>
		<?php if(isset($vv['other']) and count($vv['other']) > 0):?>
			<span style="display:none">
				<?php foreach($vv['other'] as $kkk => $vvv):?>
					<?php if($tmp2 and count($tmp2) > 0):?>
						<?php foreach($tmp2 as $kkkk => $vvvv):?>
							<img src="/_i/timthumb.php?zc=3&nowatermark=1&w=<?php echo $vvv?>&h=<?php echo $vvv?>&src=<?php echo $vvvv?>&dest=<?php echo str_replace('assets/members/'.$this->data['router_class'].$this->data['id'].'/member/','assets/members2/'.$this->data['router_class'].$this->data['id'].'/'.$kkk.'/',$vvvv)?>" />
						<?php endforeach?>
					<?php endif ?>
				<?php endforeach?>
			</span>
		<?php endif ?>
	<?php endif?>

<?php endif?>
