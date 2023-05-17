<?php
$prefix = 'view_bbox_';
?>

<?php if(isset($this->data['tag_section_recursive_end'])):?>
	<?php unset($this->data['tag_section_recursive_end'])?>
	<?php if(isset($this->data['section']['key']) and isset($_SESSION[$this->data['session_name']][$this->data['section']['key']]) and isset($current)):?>
		<?php //$key = $this->data['section']['key']?>
		<?php
			$tag = 'div';
			if(isset($current['tag']) and $current['tag'] != ''){
				$tag = $current['tag'];
			}
			//$type = $_SESSION[$this->data['session_name']][$key]['type'];
			$type = 'Bbox'; // 預設值
			$pid = $current['pid'];
			$other = $current['other'];
			$other2 = $current['other2'];

			$tmp01 = $current;

			//var_dump($current);
			//var_dump($tmp01);

			if(isset($tmp01['data_type']) and $tmp01['data_type'] == 1){
				if(isset($tmp01['data_1']) and $tmp01['data_1'] == '1'){
					$type = 'Bbox';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '2'){
					$type = 'Bbox_1c';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '3'){
					$type = 'Bbox_full';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '4'){
					$type = 'Bbox_full_1c';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '5'){
					$type = 'Bbox_full_top';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '6'){
					$type = 'Bbox_full_bottom';
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 2){
				if(isset($tmp01['data_2']) and $tmp01['data_2'] > 0){
					$type = 'Bbox_in_'.$tmp01['data_2'].'c';
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 3){
				if(isset($tmp01['data_3']) and $tmp01['data_3'] > 0){
					$type = 'Bbox_in_2c_L'.$tmp01['data_3'];
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 4){
				if(isset($tmp01['data_4']) and $tmp01['data_4'] > 0
					and isset($tmp01['data_4_2']) and $tmp01['data_4_2'] > 0
				){
					$type = 'Bbox_sin_'.$tmp01['data_4'].'_'.$tmp01['data_4_2'];
					if($tmp01['data_4_2'] <= 11){
						$type .= (string)(12 - $tmp01['data_4_2']);
					}
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 5){
				if(isset($tmp01['data_5']) and $tmp01['data_5'] > 0){
					$type = 'Bbox_sin_'.$tmp01['data_5'].'c_1c';
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 6){
				if(isset($tmp01['data_6']) and $tmp01['data_6'] > 0
					and isset($tmp01['data_6_2']) and $tmp01['data_6_2'] > 0
				){
					$type = 'Bbox_sin_'.$tmp01['data_6'].'c_2cL'.$tmp01['data_6_2'];

					if(isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == 2){
						$type .= '_xs1c';
					} elseif(isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == 3){
						$type .= '_xs2c';
					} elseif(isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == 4){
						$type .= '_xs3c';
					}

					if(isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == 2){
						$type .= '_sm1c';
					} elseif(isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == 3){
						$type .= '_sm2c';
					} elseif(isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == 4){
						$type .= '_sm3c';
					}

					if(isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == 2){
						$type .= '_md1c';
					} elseif(isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == 3){
						$type .= '_md2c';
					} elseif(isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == 4){
						$type .= '_md3c';
					}

				}
			}

			//echo $type;
			//echo $key;
			//echo $pos1;
			//die;
		?>
		<?php eval($this->run_pos_n(1,$key))?>
		<?php if(isset($tmp01['data_layer_only_one']) and $tmp01['data_layer_only_one'] == 1):?>
			<?php $return = file_get_contents(Yii::getPathOfAlias('system.frontend').'/views/layoutv2/sections/Bbox_layer_only_one.html')?>
		<?php else:?>
			<?php $return = file_get_contents(Yii::getPathOfAlias('system.frontend').'/views/layoutv2/sections/Bbox.html')?>
		<?php endif?>
		<?php eval($this->run_pos_m(1))?>

	<?php endif?>

<?php else:?>


	<?php if(isset($this->data['tag_editmode_post_end'])):?>
		<?php
			if(isset($_SESSION[$this->data['session_name']][$post['key']])){
				foreach($_SESSION[$this->data['session_name']][$post['key']] as $k => $v){
					if(preg_match('/^data_/', $k)){
						unset($_SESSION[$this->data['session_name']][$post['key']][$k]);
					} elseif(preg_match('/^data/', $k)){
						unset($_SESSION[$this->data['session_name']][$post['key']][$k]);
					}
				}
			}
			
			foreach(array($prefix.'type',$prefix.'layer_only_one',$prefix.'1',$prefix.'2',$prefix.'3',$prefix.'4',$prefix.'4_2',$prefix.'5',$prefix.'6',$prefix.'6_2',$prefix.'6_3',$prefix.'6_4',$prefix.'6_5') as $k => $v){
				if(isset($post[$v])){
					$_SESSION[$this->data['session_name']][$post['key']][str_replace($prefix,'data_',$v)] = $post[$v];
				}
			}

			$tmp01 = $post;

			if(isset($tmp01['data_type']) and $tmp01['data_type'] == 1){
				if(isset($tmp01['data_1']) and $tmp01['data_1'] == '1'){
					$type = 'Bbox';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '2'){
					$type = 'Bbox_1c';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '3'){
					$type = 'Bbox_full';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '4'){
					$type = 'Bbox_full_1c';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '5'){
					$type = 'Bbox_full_top';
				} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '6'){
					$type = 'Bbox_full_bottom';
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 2){
				if(isset($tmp01['data_2']) and $tmp01['data_2'] > 0){
					$type = 'Bbox_in_'.$tmp01['data_2'].'c';
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 3){
				if(isset($tmp01['data_3']) and $tmp01['data_3'] > 0){
					$type = 'Bbox_in_2c_L'.$tmp01['data_3'];
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 4){
				if(isset($tmp01['data_4']) and $tmp01['data_4'] > 0
					and isset($tmp01['data_4_2']) and $tmp01['data_4_2'] > 0
				){
					$type = 'Bbox_sin_'.$tmp01['data_4'].'_'.$tmp01['data_4_2'];
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 5){
				if(isset($tmp01['data_5']) and $tmp01['data_5'] > 0){
					$type = 'Bbox_sin_'.$tmp01['data_5'].'c_1c';
				}
			} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 6){
				if(isset($tmp01['data_6']) and $tmp01['data_6'] > 0
					and isset($tmp01['data_6_2']) and $tmp01['data_6_2'] > 0
				){
					$type = 'Bbox_sin_'.$tmp01['data_6'].'c_2cL'.$tmp01['data_6_2'];

					if(isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == 2){
						$type .= '_xs1c';
					} elseif(isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == 3){
						$type .= '_xs2c';
					} elseif(isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == 4){
						$type .= '_xs3c';
					}

					if(isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == 2){
						$type .= '_sm1c';
					} elseif(isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == 3){
						$type .= '_sm2c';
					} elseif(isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == 4){
						$type .= '_sm3c';
					}

					if(isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == 2){
						$type .= '_md1c';
					} elseif(isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == 3){
						$type .= '_md2c';
					} elseif(isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == 4){
						$type .= '_md3c';
					}

				}
			}

			if(isset($post[$prefix.'create']) and $post[$prefix.'create'] == 1){
				// 取得剛才新增的元素key值
				end($_SESSION[$this->data['session_name']]);
				$new_key = key($_SESSION[$this->data['session_name']]);
				reset($_SESSION[$this->data['session_name']]);

				// 如果是，要順便建兩個DIV(固定)
				if(preg_match('/^Bbox_in_(\d)c_L(\d+)$/', $type) OR preg_match('/sin/', $type)){ // 例：Bbox_in_2c_L3
					$_SESSION[$this->data['session_name']][] = array(
						'tag' => 'div',
						'type' => 'view_1_layer_div',
						'pid' => $new_key,
						'pos' => '1',
						'other' => '',
						'other2' => '',
					);
					$_SESSION[$this->data['session_name']][] = array(
						'tag' => 'div',
						'type' => 'view_1_layer_div',
						'pid' => $new_key,
						'pos' => '1',
						'other' => '',
						'other2' => '',
					);
				
				// 至少一個DIV
				} elseif(preg_match('/1c/', $type) OR preg_match('/^Bbox_in_(\d)c(_xs3|)$/', $type)){
					$_SESSION[$this->data['session_name']][] = array(
						'tag' => 'div',
						'type' => 'view_1_layer_div',
						'pid' => $new_key,
						'pos' => '1',
						'other' => '',
						'other2' => '',
					);
				}
			}


			// 如果不想要POST的IF判斷式全部重包，那就用這樣子的寫法
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']));
			die;
		?>
	<?php endif?>

	<?php if(isset($this->data['tag_editmode_get_toolbar']) and $this->data[$this->data['layout_v2_name'].'_editmode']):?>
		<?php $tmp01 = $this->data['tag_editmode_get_toolbar']?>
		<br />
		<br />
		順便把該建的建一建<input type="checkbox" name="<?php echo $prefix?>create" value="1" />
		<br />
		<br />
		只有一層<input type="checkbox" name="<?php echo $prefix?>layer_only_one" value="1" <?php if(isset($tmp01['data_layer_only_one']) and $tmp01['data_layer_only_one'] == 1):?>checked<?php endif?> />
		<br />
		<br />
		<input type="radio" name="<?php echo $prefix?>type" value="1" <?php if(isset($tmp01['data_type']) and $tmp01['data_type'] == 1):?>checked<?php endif?> />
		Bbox
		<select class="form-control" name="<?php echo $prefix?>1">
			<option value="1" <?php if( isset($tmp01['data_1']) and $tmp01['data_1'] == '1' ):?>selected<?php endif?> >預設</option>
			<option value="2" <?php if( isset($tmp01['data_1']) and $tmp01['data_1'] == '2' ):?>selected<?php endif?> >_1c</option>
			<option value="3" <?php if( isset($tmp01['data_1']) and $tmp01['data_1'] == '3' ):?>selected<?php endif?> >_full</option>
			<option value="4" <?php if( isset($tmp01['data_1']) and $tmp01['data_1'] == '4' ):?>selected<?php endif?> >_full_1c</option>
			<option value="5" <?php if( isset($tmp01['data_1']) and $tmp01['data_1'] == '5' ):?>selected<?php endif?> >_full_top</option>
			<option value="6" <?php if( isset($tmp01['data_1']) and $tmp01['data_1'] == '6' ):?>selected<?php endif?> >_full_bottom</option>
		</select>
		<br />
		<br />
		<input type="radio" name="<?php echo $prefix?>type" value="2" <?php if(isset($tmp01['data_type']) and $tmp01['data_type'] == 2):?>checked<?php endif?> />
		Bbox_in_	
		<select class="form-control" name="<?php echo $prefix?>2">
			<?php for($x=1;$x<=12;$x++):?>
				<option <?php if( isset($tmp01['data_2']) and $tmp01['data_2'] == $x ):?>selected<?php endif?> ><?php echo $x?></option>
			<?php endfor?>
		</select>
		c
		<br />
		<br />
		<input type="radio" name="<?php echo $prefix?>type" value="3" <?php if(isset($tmp01['data_type']) and $tmp01['data_type'] == 3):?>checked<?php endif?> />
		Bbox_in_2c_L	
		<select class="form-control" name="<?php echo $prefix?>3">
			<?php for($x=1;$x<=11;$x++):?>
				<option <?php if( isset($tmp01['data_3']) and $tmp01['data_3'] == $x ):?>selected<?php endif?> ><?php echo $x?></option>
			<?php endfor?>
		</select>
		<br />
		<br />
		<input type="radio" name="<?php echo $prefix?>type" value="4"<?php if(isset($tmp01['data_type']) and $tmp01['data_type'] == 4):?>checked<?php endif?> />
		Bbox_sin_
		<select class="form-control" name="<?php echo $prefix?>4">
			<?php for($x=1;$x<=12;$x++):?>
				<option <?php if( isset($tmp01['data_4']) and $tmp01['data_4'] == $x ):?>selected<?php endif?> ><?php echo $x?></option>
			<?php endfor?>
		</select>
		_
		<select class="form-control" name="<?php echo $prefix?>4_2">
			<?php for($x=1;$x<=12;$x++):?>
				<option <?php if( isset($tmp01['data_4_2']) and $tmp01['data_4_2'] == $x ):?>selected<?php endif?> ><?php echo $x?></option>
			<?php endfor?>
		</select>
		<br />
		<br />
		<input type="radio" name="<?php echo $prefix?>type" value="5" <?php if(isset($tmp01['data_type']) and $tmp01['data_type'] == 5):?>checked<?php endif?> />
		Bbox_sin_
		<select class="form-control" name="<?php echo $prefix?>5">
			<?php for($x=1;$x<=12;$x++):?>
				<option <?php if( isset($tmp01['data_5']) and $tmp01['data_5'] == $x ):?>selected<?php endif?> ><?php echo $x?></option>
			<?php endfor?>
		</select>
		c_1c
		<br />
		<br />
		<input type="radio" name="<?php echo $prefix?>type" value="6" <?php if(isset($tmp01['data_type']) and $tmp01['data_type'] == 6):?>checked<?php endif?> />
		Bbox_sin_
		<select class="form-control" name="<?php echo $prefix?>6">
			<?php for($x=1;$x<=12;$x++):?>
				<option <?php if( isset($tmp01['data_6']) and $tmp01['data_6'] == $x ):?>selected<?php endif?> ><?php echo $x?></option>
			<?php endfor?>
		</select>
		c_2cL
		<select class="form-control" name="<?php echo $prefix?>6_2">
			<?php for($x=1;$x<=11;$x++):?>
				<option <?php if( isset($tmp01['data_6_2']) and $tmp01['data_6_2'] == $x ):?>selected<?php endif?> ><?php echo $x?></option>
			<?php endfor?>
		</select>
		　
		<select class="form-control" name="<?php echo $prefix?>6_3">
			<option value="1" <?php if( isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == '1' ):?>selected<?php endif?> >不需要</option>
			<option value="2" <?php if( isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == '2' ):?>selected<?php endif?> >_xs1c</option>
			<option value="3" <?php if( isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == '3' ):?>selected<?php endif?> >_xs2c</option>
			<option value="4" <?php if( isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == '4' ):?>selected<?php endif?> >_xs3c</option>
		</select>
		<select class="form-control" name="<?php echo $prefix?>6_4">
			<option value="1" <?php if( isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == '1' ):?>selected<?php endif?> >不需要</option>
			<option value="2" <?php if( isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == '2' ):?>selected<?php endif?> >_sm1c</option>
			<option value="3" <?php if( isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == '3' ):?>selected<?php endif?> >_sm2c</option>
			<option value="4" <?php if( isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == '4' ):?>selected<?php endif?> >_sm3c</option>
		</select>
		<select class="form-control" name="<?php echo $prefix?>6_5">
			<option value="1" <?php if( isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == '1' ):?>selected<?php endif?> >不需要</option>
			<option value="2" <?php if( isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == '2' ):?>selected<?php endif?> >_md1c</option>
			<option value="3" <?php if( isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == '3' ):?>selected<?php endif?> >_md2c</option>
			<option value="4" <?php if( isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == '4' ):?>selected<?php endif?> >_md3c</option>
		</select>


		<?php unset($this->data['tag_editmode_get_toolbar'])?>
	<?php endif?>
<?php endif?>
