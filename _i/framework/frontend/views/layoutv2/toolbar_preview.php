<?php
	if($this->data['router_method'] == 'demopreview'){

		// eval(file_get_contents(FRONTEND_LAYOUTV2.'/index.php?r=layoutv2/category1'));

		// if(isset($_GET['classtype']) and $_GET['classtype'] != ''){
		// } else {
		// 	$_GET['classtype'] = $layoutv2classtype_first['id'];
		// }

		// eval(file_get_contents(FRONTEND_LAYOUTV2.'/index.php?r=layoutv2/category2'));

		if(!file_exists(tmp_path.'/layoutv2_category1.php')){
			$tmp = file_get_contents(FRONTEND_LAYOUTV2.'/index.php?r=layoutv2/category1');
			file_put_contents(tmp_path.'/layoutv2_category1.php', '<'.'?'.'php '."\n".$tmp);
		}
		include tmp_path.'/layoutv2_category1.php';

		if(isset($_GET['classtype']) and $_GET['classtype'] != ''){
		} else {
			$_GET['classtype'] = $layoutv2classtype_first['id'];
		}

		//eval(file_get_contents(FRONTEND_LAYOUTV2.'/index.php?r=layoutv2/category2&classtype='.$_GET['classtype']));

		if(!file_exists(tmp_path.'/layoutv2_category2_'.$_GET['classtype'].'.php')){
			$tmp = file_get_contents(FRONTEND_LAYOUTV2.'/index.php?r=layoutv2/category2&classtype='.$_GET['classtype']);
			file_put_contents(tmp_path.'/layoutv2_category2_'.$_GET['classtype'].'.php', '<'.'?'.'php '."\n".$tmp);
		}
		include tmp_path.'/layoutv2_category2_'.$_GET['classtype'].'.php';

		/*
		 * 複製於 _i/framework/frontend/components/Controller.php
		 */
		//    $layoutv2classtype = $this->db->createCommand()->from('layoutv2')->where('is_enable=1 and type=:type',array(':type'=>'layoutv2classtype'))->order('sort_id')->queryAll();
		//    $layoutv2classtype_tmp = array();
		//    $layoutv2classtype_first = array(); // 沒選的時候，預選第一個分類
		//    if($layoutv2classtype){
		//    	foreach($layoutv2classtype as $k => $v){
		//    		$layoutv2classtype_tmp[$v['id']] = $v;
		//    		if($k == 0){
		//    			$layoutv2classtype_first = $v;
		//    			//break;
		//    		}
		//    	}
		//    }

		//    if(isset($_GET['classtype']) and $_GET['classtype'] != ''){
		//    } else {
		//    	$_GET['classtype'] = $layoutv2classtype_first['id'];
		//    }

		//    //if($this->data['router_method'] == 'demopreview'){
		//    	$layoutv2classes = $this->db->createCommand()->from('layoutv2')->where('is_enable=1 and type=:type',array('type'=>'layoutv2class'))->order('sort_id')->queryAll();
		//    //} else {
		//    //	$layoutv2classes = $this->db->createCommand()->from('html')->where('is_enable=1 and class_id=:class_id',array(':class_id'=>$_GET['classtype']))->order('sort_id')->queryAll();
		//    //}
		//    $layoutv2class_tmp = array();
		//    if($layoutv2classes){
		//    	foreach($layoutv2classes as $k => $v){
		//    		$layoutv2class_tmp[$v['other1']] = $v;
		//    	}
		//    }

		//    $layoutv2class2type = $this->db->createCommand()->from('layoutv2')->where('is_enable=1 and type=:type',array(':type'=>'layoutv2class2type'))->order('sort_id')->queryAll();
		//    $layoutv2classes2 = $this->db->createCommand()->from('layoutv2')->where('is_enable=1 and type=:type',array('type'=>'layoutv2class2'))->order('sort_id')->queryAll();

		//    $layoutv2class2_tmp = array();
		//    if($layoutv2classes2){
		//    	foreach($layoutv2classes2 as $k => $v){
		//    		if(!isset($layoutv2class2_tmp[$v['class_id']])){
		//    			$layoutv2class2_tmp[$v['class_id']] = array();
		//    		}
		//    		$layoutv2class2_tmp[$v['class_id']][] = $v;
		//    	}
		//    }
	}
?>


<?php if(isset($_GET['pos']) and isset($_GET['key'])):?>
	<?php ob_start()?>
	<div class="Bbox_1c margin_base_tb">
		<div class="tumblist-1c">
			<ul class="paging2">
					<?php if(isset($layoutv2classes)):?>
						<?php foreach($layoutv2classes as $KKK => $VVV):?>
							<!---1 張照片 Start-->                
							<li>
							<?php
								//file_put_contents('/home/gisanfu/aaa.php',var_export($VVV,true));

								// 複寫上面的陣列值，要小心，因為是一樣的變數
								$other = '';
								$other2 = '';
								$tag = 'div';

								$key = 'random_'.$_GET['key'];
								//$this->data['section'] = $_SESSION[$this->data['session_name']][$_GET['key']];
								$this->data['section'] = array(
									'key' => $key,
								);
								$type = $VVV['other1'];

								if(preg_match('/^Bbox(_1c|_full|_full_top|_full_1c|_full_bottom|)/', $type) OR preg_match('/^Bbox_in_(\d)c(_xs3|)$/', $type)){

									eval($this->run_pos_n(1,$key));
									// 如果是，要順便建兩個DIV(固定)
									if(preg_match('/^(Bbox|Bbox_full|Bbox_full_bottom|Bbox_full_top)$/', $type)){
										$pos1 = '<div class="cis2-bk">測試資料1</div>';
									} elseif(preg_match('/^Bbox_in_(\d)c_L(\d+)$/', $type) OR preg_match('/sin/', $type)){ // 例：Bbox_in_2c_L3
										$pos1 = '<div class="cis2-bk">測試資料1</div>';
										$pos1 .= '<div class="cis3-bk-lighter">測試資料2</div>';
									// 至少一個DIV
									} elseif(preg_match('/1c/', $type) OR preg_match('/^Bbox_in_(\d)c(_xs3|)$/', $type)){
										$pos1 =  '<div class="cis3-bk">測試資料1</div>';
										$pos1 .= '<div class="cis3-bk-lighter">測試資料2</div>';
										$pos1 .= '<div class="cis3-bk-dark">測試資料3</div>';
									}
									$return = file_get_contents(Yii::getPathOfAlias('application').'/controllers/layoutv2/sections/Bbox.html');
									eval($this->run_pos_m(1));

								} else {
									//continue;

									if(!isset($this->data['layoutv2'][$key])){
										$this->data['layoutv2'][$key] = array(
											array(
												'id' => '123',
												'topic' => '測試A',
												'name' => '測試A',
												'other1' => '測試A',
												'url1' => '#',
												'pic1' => 'demo/testa.jpg',
												'detail' => '測試A',
												'start_date' => '',
											),
											array(
												'id' => '456',
												'topic' => '測試B',
												'name' => '測試B',
												'other1' => '測試B',
												'url1' => '#',
												'pic1' => 'demo/testb.jpg',
												'detail' => '測試B',
												'start_date' => '',
											),
											array(
												'id' => '789',
												'topic' => '測試C',
												'name' => '測試C',
												'other1' => '測試C',
												'url1' => '#',
												'pic1' => 'demo/testc.jpg',
												'detail' => '測試C',
												'start_date' => '',
											),
											//'id' => '789',
											//'topic' => '測試C',
											//'name' => '測試C',
											//'other1' => '測試C',
											//'url1' => '#',
											//'pic1' => 'demo/testc.jpg',
											//'detail' => '測試C',
										);
									}
									eval($this->run_pos_n(1, $key));
									//if($type == 'view_banner_home'){
									//	$other2 = 'h';
									//}
									//if(isset($this->data['layoutv2_param'][$key][2]) and $this->data['layoutv2_param'][$key][2] != ''){
									//	$this->data['layoutv2_sections_select'] = $this->data['layoutv2_param'][$key][2];
									//}
									if(preg_match('/^layout___(.*)$/', $VVV['other1'], $matches)){
										$return = '<iframe frameborder="0" width="100%" height="400" src="'.FRONTEND_LAYOUTV2_DEMO.'/index.php?r='.str_replace('/layout', '/demolayout', $matches[1]).'"></iframe>';
									} elseif(preg_match('/^group___(.*)___(.*)$/', $VVV['other1'], $matches)){
										//$return = '<iframe frameborder="0" width="100%" height="400" src="http://rwddemo.devel2.buyersline.com.tw/index.php?r='.str_replace('/group', '/demogroup', $matches[1]).'"></iframe>';
										$return = '<iframe frameborder="0" width="100%" height="400" src="'.FRONTEND_LAYOUTV2_DEMO.'/index.php?r=site/demogroup&p1='.$matches[1].'&p2='.$matches[2].'"></iframe>';
									} elseif(preg_match('/^view_/', $VVV['other1'], $matches)){
										//$return = $this->renderPartial('//layoutv2/'.$VVV['other1'], $this->data, true);

										if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/'.$type)){
											$return = $this->renderPartial('application.views.layoutv2.'.$type, $this->data, true);
										} else {
											$return = $this->renderPartial('system.frontend.views.layoutv2.'.$type, $this->data, true);
										}
									} elseif(preg_match('/^placeholdit_(.*)_(.*)$/', $VVV['other1'], $matches)){
										$return = '<img src="http://placehold.it/'.$matches[1].'x'.$matches[2].'">';
									} else {
										$return = '';
									}
									eval($this->run_pos_m(1));
									if($type == 'view_banner_home'){
										$return = '<div class="Bbox banner h"><div>'.$return.'</div></div>';
									}
								}
								echo $return;
								//file_put_contents('/home/gisanfu/hg/buyerline_rwd_cttdemo/aaa.txt', $type);
								if(isset($_GET['type_backend']) and $_GET['type_backend'] == $type){
									$current_return_backend = $return;
								}
								if(isset($_SESSION[$this->data['session_name']][$_GET['key']]['type']) and $_SESSION[$this->data['session_name']][$_GET['key']]['type'] == $type){
									$current_return = $return;
								}
							?>
							<br />
							<a href="javascript:;" onclick="javascript:$('#change_class').attr('value','<?php echo $VVV['other1']?>');$(this).text($(this).text() +'(selected)');"><?php echo $VVV['topic']?></a>
						</li>
					<?php endforeach?>
				<?php endif?>
			</ul>
		</div>
	</div>
	<?php 
		$toolbar_preview = ob_get_contents();
		ob_end_clean();

		// 沒有這樣子做，後面會壞掉
		$this->data['section'] = array(
			'key' => $_GET['key'],
		);
	?>
<?php endif?>
