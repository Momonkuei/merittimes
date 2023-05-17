<?php $tmp_first = 0?>
<?php foreach($v['field'] as $kk => $vv):?>
	<?php $formattr = ''?>
	<?php if(!empty($vv['attr'])):?>
		<?php foreach($vv['attr'] as $kkk => $vvv):?>
			<?php $formattr = $formattr.' '.$kkk.'="'.$vvv.'"'?>
		<?php endforeach?>
	<?php endif?>

	<?php $field_is_required = ''?>
	<?php if(isset($updatecontent_jqueryvalidation[$kk]['required']) and $updatecontent_jqueryvalidation[$kk]['required'] == 'true'):?>
		<?php $field_is_required = '*'?>
	<?php endif?>
		
	<?php // 每個欄位的包頭?>
	<?php if(!preg_match('/hidden/', $vv['type'])):?>
		<?php if($v['type'] == '1'):?>
			<dt>
				<label>
					<?php G::te($this->data['theme_lang'], G::a($vv, 'vv.label'))?>
					<?php if(isset($vv['mlabel'])):?><?php G::te(G::a($vv, 'vv.mlabel.0'), G::a($vv, 'vv.mlabel.1'), G::a($vv, 'vv.mlabel.2'), G::a($vv, 'vv.mlabel.3'))?><?php endif?>
				</label>
				<?php if($vv['type'] != 'mls'):?><span class="required"><?php echo $field_is_required?></span><?php endif?>
			</dt>
			<dd>
		<?php elseif($v['type'] == '2'):?>
			<dt>
			<?php if(isset($vv['label']) and $vv['label'] != ''):?>
				<label><?php G::te($this->data['theme_lang'], $vv['label'])?></label>
				<?php if($vv['type'] != 'mls'):?><span class="required"><?php echo $field_is_required?></span><?php endif?>
			<?php endif?>
			<?php if(isset($vv['mlabel']) and $vv['mlabel'] != ''):?>
				<label>
					<?php if(isset($vv['mlabel'])):?><?php G::te(G::a($vv, 'vv.mlabel.0'), G::a($vv, 'vv.mlabel.1'), G::a($vv, 'vv.mlabel.2'), G::a($vv, 'vv.mlabel.3'))?><?php endif?>
				</label>
				<?php if($vv['type'] != 'mls'):?><span class="required"><?php echo $field_is_required?></span><?php endif?>
			<?php endif?>
			</dt>
			<dd>
		<?php elseif($v['type'] == 'tab'):?>
		<li class="tabmenu_{{$kk}} <?php if($tmp_first == 0){?>target<?php }?>">
			<?php if(isset($vv['describe']) and $vv['describe'] != ''):?>
				<div style="height:28px;" class="clearBoth"><?php G::te($this->data['theme_lang'], G::a($vv, 'vv.describe'))?><font color="red"><?php echo $field_is_required?></font></div>
			<?php endif?>
			<?php if(isset($vv['describe_html']) and $vv['describe_html'] != ''):?>
				<?php echo $vv['describe_html']?>
			<?php endif?>
		<?php elseif($v['type'] == 'tabm'):?>
			<?php if(isset($vv['describe']) and $vv['describe'] != ''):?>
				<div style="height:28px;" class="clearBoth"><?php G::te($this->data['theme_lang'], G::a($vv, 'vv.describe'))?><font color="red"><?php echo $field_is_required?></font></div>
			<?php endif?>
			<?php if(isset($vv['describe_html']) and $vv['describe_html'] != ''):?>
				<?php echo $vv['describe_html']?>
			<?php endif?>
		<?php endif?>
	<?php endif?>

	<?php if($vv['type'] == 'mls'):?>
		<?php if($def['updatefield']['method'] == 'update'):?>
		<label><?php $this->widget('system.widgets.Gw_mls', array('v'=>$updatecontent[$kk]))?></label>
		<?php else:?>
		<label><?php $this->widget('system.widgets.Gw_mls', array('v'=>$ml_key))?></label>
		<?php endif?>
	<?php elseif($vv['type'] == 'label'):?>
		<label><?php echo $updatecontent[$kk]?></label>
	<?php elseif($vv['type'] == 'input'):?>
		<input <?php echo $formattr?> <?php if(!isset($vv['attr']['type'])):?>type="text"<?php endif?> <?php if(!isset($vv['attr']['value'])):?>value="<?php echo G::a($updatecontent, 'updatecontent.'.$kk)?>"<?php endif?> /><span class="none">使欄位垂直置中使用</span>　
	<?php elseif($vv['type'] == 'hidden'):?>
		<input <?php echo $formattr?> <?php if(!isset($vv['attr']['type'])):?>type="hidden"<?php endif?> <?php if(!isset($vv['attr']['value'])):?>value="<?php echo G::a($updatecontent, 'updatecontent.'.$kk)?>"<?php endif?> />
	<?php elseif($vv['type'] == 'pass'):?>
		<input type="password" <?php echo $formattr?> /><span class="none">使欄位垂直置中使用</span>　
	<?php elseif($vv['type'] == 'file'):?>
		<input type="file" <?php echo $formattr?> /><span class="none">使欄位垂直置中使用</span>　
	<?php elseif($vv['type'] == 'submit'):?>
		<input type="submit" <?php echo $formattr?> /><span class="none">使欄位垂直置中使用</span>　
	<?php elseif($vv['type'] == 'img'):?>
		{{img a=$vv.attr.width b=$vv.attr.height tag='1' c=$vv.attr.class_url}}{{$updatecontent.$kk}}{{/img}}
	<?php elseif($vv['type'] == 'img_tag'):?>
		<img src="{{$updatecontent.$kk}}" <?php echo $formattr?> />
	<?php elseif($vv['type'] == 'inputx'):?>
		<input type="text" <?php echo $formattr?> /><span class="none">使欄位垂直置中使用</span>　
	<?php elseif($vv['type'] == 'inputml'):?>
		{{* 含有多國語系片語搜尋功能的欄位 *}}
		<input type="text" <?php echo $formattr?> value="{{$updatecontent.$kk}}" /><span class="none">使欄位垂直置中使用</span>　
	<?php elseif($vv['type'] == 'inputselect'):?>
		<input type="text" <?php echo $formattr?> <?php if(!isset($vv['attr']['type'])){?>type="text"<?php }?> value="<?php echo G::ae($updatecontent, 'updatecontent.'.$kk)?>" /><span class="none">使欄位垂直置中使用</span>　
		<?php // 給純狀態型的資料使用，例如是、否、開啟、停用等?>
		<select id="<?php echo $vv['attr']['id']?>_inputselect">
			<option value=""><?php G::te(null, 'Please Select', array(), '請選擇')?></option>
			<?php if(isset($updatecontent[$kk.'_inputselect']) and count($updatecontent[$kk.'_inputselect'])):?>
				<?php foreach($updatecontent[$kk.'_inputselect'] as $kkk => $vvv):?>
					<option value="<?php echo $kkk?>"><?php echo $vvv?></option>
				<?php endforeach?>
			<?php endif?>
		</select><span class="none">使欄位垂直置中使用</span>　
	<?php elseif($vv['type'] == 'sort'):?>
		<?php $this->data['action'] = $def['updatefield']['method']?>
		<?php echo $this->renderPartial('//includes/sort', $this->data)?>
	<?php elseif($vv['type'] == 'status'):?>
		<?php if($def['updatefield']['method'] == 'update'):?>
		
		<label><input type="radio" <?php echo $formattr?> value="1" <?php $this->widget('system.widgets.Gw_ez', array('e'=>"checked='checked'", 'z'=>'', 'v'=>G::a($updatecontent, 'updatecontent.'.$kk)))?> /><?php if(isset($vv['other']['other1']) and $vv['other']['other1'] != ''){?><?php G::te($this->data['theme_lang'], $vv['other']['other1'])?><?php }else{?><?php G::te($this->data['theme_lang'], 'Show', null, '顯示')?><?php }?></label>
		<label><input type="radio" <?php echo $formattr?> value="0" <?php $this->widget('system.widgets.Gw_ez', array('e'=>'', 'z'=>"checked='checked'",'v'=>G::a($updatecontent, 'updatecontent.'.$kk)))?> /><?php if(isset($vv['other']['other2']) and $vv['other']['other2'] != ''){?><?php G::te($this->data['theme_lang'], $vv['other']['other2'])?><?php }else{?><?php G::te($this->data['theme_lang'], 'Hidden', null, '隱藏')?><?php }?></label>
		<?php else:?>
		<label><input type="radio" <?php echo $formattr?> value="1" <?php if(isset($vv['other']['default']) and $vv['other']['default'] == ''){?>checked="checked"<?php }elseif(isset($vv['other']['default']) and $vv['other']['default'] == '1'){?>checked="checked"<?php }?> /><?php if(isset($vv['other']['other1']) and $vv['other']['other1'] != ''){?><?php G::te($this->data['theme_lang'], $vv['other']['other1'])?><?php }else{?><?php G::te($this->data['theme_lang'], 'Show', null, '顯示')?><?php }?></label>
		<label><input type="radio" <?php echo $formattr?> value="0" <?php if(isset($vv['other']['default']) and $vv['other']['default'] == '0'){?>checked="checked"<?php }?> /><?php if(isset($vv['other']['other2']) and $vv['other']['other2'] != ''){?><?php G::te($this->data['theme_lang'], $vv['other']['other2'])?><?php }else{?><?php G::te($this->data['theme_lang'], 'Hidden', null, '隱藏')?><?php }?></label>
		<?php endif?>
	<?php elseif($vv['type'] == 'time'):?>
		<label>
			<?php if(isset($updatecontent[$kk])):?>
				<?php if($updatecontent[$kk] == '0000-00-00 00:00:00'):?>
					&nbsp;
				<?php else:?>
					<?php echo $updatecontent[$kk]?>
				<?php endif?>
			<?php else:?>
				&nbsp;
			<?php endif?>
		</label>
	<?php elseif($vv['type'] == 'select'):?>
		<select <?php echo $formattr?>>
		{{if !empty($updatecontent.$kk) }}
			{{assign var="isselectedvalue" value=$vv.other.default}}
			{{foreach from=$updatecontent.$kk key=kkk item=vvv}}
				{{if $isselectedvalue != '' and $def.updatefield.method == 'create'}}
					{{if $isselectedvalue == $kkk}}
						<option value="{{$kkk}}" selected>{{$vvv.value}}</option>
					{{else}}
						<option value="{{$kkk}}">{{$vvv.value}}</option>
					{{/if}}
				{{else}}
					<option value="{{$kkk}}" {{$vvv.is_selected}}>{{$vvv.value}}</option>
				{{/if}}
			{{/foreach}}
		{{/if}}
		</select><span class="none">使欄位垂直置中使用</span>　
	<?php elseif($vv['type'] == 'select3'):?>
		<?php // 給純狀態型的資料使用，例如是、否、開啟、停用等?>
		<select <?php echo $formattr?>>
		<?php if(!empty($vv['other'])):?>
			<?php if($def['updatefield']['method'] == 'create'):?>
				<?php $isselectedvalue = $vv['other']['default']?>
			<?php else:?>
				<?php $isselectedvalue = $updatecontent[$kk]?>
			<?php endif?>

			<?php if($isselectedvalue == ''):?>
				<?php $isselectedvalue = '0'?>
			<?php endif?>

			<?php if(!empty($vv['other']['values'])):?>
				<?php foreach($vv['other']['values'] as $kkk => $vvv):?>
					<?php if($isselectedvalue == $kkk):?>
						<option value="<?php echo $kkk?>" selected><?php echo $vvv?></option>
					<?php else:?>
						<option value="<?php echo $kkk?>"><?php echo $vvv?></option>
					<?php endif?>
				<?php endforeach?>
			<?php endif?>
		<?php endif?>
		</select><span class="none">使欄位垂直置中使用</span>　
	<?php elseif($vv['type'] == 'select2'):?>
	<select <?php echo $formattr?>>
		<?php if(!empty($updatecontent[$kk])):?>
			<?php $isselectedvalue = ''?>
				<?php $select2_value = ''?>
			<?php if(isset($vv['other']['default'])):?>
				<?php $isselectedvalue = $vv['other']['default']?>
			<?php endif?>
			<?php foreach($updatecontent[$kk] as $kkk => $vvv):?>
				<?php if(isset($vvv['value']) and $vvv['value'] == "__empty"):?>
					<?php $select2_value = ''?>
				<?php else:?>
					<?php if(isset($vvv['value'])):?>
						<?php $select2_value = $vvv['value']?>
					<?php endif?>
				<?php endif?>

				<?php if(isset($vv['other']['default']) and $vv['other']['default'] != '' and $def['updatefield']['method'] == 'create'):?>
					<?php if($kkk == $isselectedvalue):?>
						<?php $isselected = 'selected'?>
					<?php endif?>
				<?php else:?>
					<?php if(isset($vvv['is_selected'])):?>
						<?php $isselected = $vvv['is_selected']?>
					<?php endif?>
				<?php endif?>

				<option value="<?php echo $select2_value?>" <?php echo $isselected?> ><?php echo $vvv['name']?></option>

				<?php $isselected = ''?>
			<?php endforeach?>
		<?php endif?>
		</select><span class="none">使欄位垂直置中使用</span>　

	<?php //上面是不跳行欄位，而下面是 ?>

	<?php elseif($vv['type'] == 'ckeditor'):?>
	{{elseif $vv.type == 'ckeditor'}}
			{{$updatecontent.$kk}}
			<p style="height:10px;">&nbsp;</p>
	<?php elseif($vv['type'] == 'ckeditor_js'):?>
		<textarea <?php echo $formattr?> ><?php echo G::a($updatecontent, 'updatecontent.'.$kk)?></textarea>
		<p style="height:10px;">&nbsp;</p>
	<?php elseif($vv['type'] == 'ckeditor_js_limit'):?>
		{{strlen limit=$vv.other.limit message_2="<textarea `$formattr` >"}}{{$updatecontent.$kk}}{{/strlen}}{{strlen limit=$vv.other.limit}}{{$updatecontent.$kk}}{{/strlen}}{{strlen limit=$vv.other.limit message_2="</textarea>"}}{{$updatecontent.$kk}}{{/strlen}}
		{{strlen limit=$vv.other.limit message_2='<p style="height:10px;">&nbsp;</p>'}}{{$updatecontent.$kk}}{{/strlen}}
	<?php elseif($vv['type'] == 'nothing'):?><?php //單純說明欄位?>
		{{$vv.attr.html}}
		{{$vv.other.html}}
	<?php elseif($vv['type'] == 'kcfinder_input'):?>
		<?php // 想要做可以換路徑的文字欄位點下去，觸發kcfinder新視窗 ?>
		<?php // uploadurl_id為0的時候，會吃預設值的路徑，是kcfinder裡面的upload資料夾 ?>
		<input type="text" <?php echo $formattr?> readonly="readonly" onclick="javascript:openKCFinder(this, <?php if(isset($vv['other']['uploadurl_id']) and $vv['other']['uploadurl_id'] != ''):?>'<?php echo $vv['other']['uploadurl_id']?>'<?php else:?>'0'<?php endif ?>, <?php if(isset($vv['other']['type']) and $vv['other']['type'] != ''):?>'<?php echo $vv['other']['type']?>'<?php else:?>''<?php endif?>, <?php if(isset($vv['other']['dir']) and $vv['other']['dir'] != ''):?>'<?php echo $vv['other']['dir']?>'<?php else:?>''<?php endif?>)" style="cursor:pointer" value="<?php echo G::a($updatecontent, 'updatecontent.'.$kk)?>" /><span class="none">使欄位垂直置中使用</span>　
		<a href="javascript:;" id="<?php echo $vv['attr']['id']?>_clear">清除</a>
		<?php if(isset($updatecontent[$kk]) and $updatecontent[$kk] != '' and preg_match('/\.(png|gif|jpg|jpeg)/i', $updatecontent[$kk])):?>
			<br />
			<img
				<?php if(isset($vv['other']['width']) and $vv['other']['width'] != ''):?>width="<?php echo $vv['other']['width']?>"<?php endif?>
				<?php if(isset($vv['other']['height']) and $vv['other']['height'] != ''):?>height="<?php echo $vv['other']['height']?>"<?php endif?>
				src="<?php echo vir_path_c.str_replace('_butterfly/', '', $updatecontent[$kk])?>"
			/>
		<?php endif?>
	<?php elseif($vv['type'] == 'kcfinder_input_school'):?>
		<?php // 大衛特有的 ?>
		<input type="text" <?php echo $formattr?> readonly="readonly" onclick="javascript:openKCFinder(this, <?php if(isset($vv['other']['uploadurl_id']) and $vv['other']['uploadurl_id'] != ''):?>'<?php echo $vv['other']['uploadurl_id']?>'<?php else:?>'0'<?php endif ?>, <?php if(isset($vv['other']['type']) and $vv['other']['type'] != ''):?>'<?php echo $vv['other']['type']?>'<?php else:?>''<?php endif?>, <?php if(isset($vv['other']['dir']) and $vv['other']['dir'] != ''):?>'<?php echo $vv['other']['dir']?>'<?php else:?>''<?php endif?>, <?php if(isset($vv['other']['school_id']) and $vv['other']['school_id'] != ''):?>'<?php echo $vv['other']['school_id']?>'<?php else:?>''<?php endif?>)" style="cursor:pointer" value="<?php echo G::a($updatecontent, 'updatecontent.'.$kk)?>" /><span class="none">使欄位垂直置中使用</span>　
		<a href="javascript:;" id="<?php echo $vv['attr']['id']?>_clear">清除</a>
		<?php if(isset($updatecontent[$kk]) and $updatecontent[$kk] != '' and preg_match('/\.(png|gif|jpg|jpeg)/i', $updatecontent[$kk])):?>
			<br />
			<img
				<?php if(isset($vv['other']['width']) and $vv['other']['width'] != ''):?>width="<?php echo $vv['other']['width']?>"<?php endif?>
				<?php if(isset($vv['other']['height']) and $vv['other']['height'] != ''):?>height="<?php echo $vv['other']['height']?>"<?php endif?>
				src="<?php echo vir_path_c.str_replace('_butterfly/', '', $updatecontent[$kk])?>"
			/>
		<?php endif?>
	<?php elseif($vv['type'] == 'kcfinder'):?>

		<?php $uploadurl_id = '0'?>
		<?php if(isset($vv['other']['uploadurl_id']) and $vv['other']['uploadurl_id'] != ''):?>
			<?php $uploadurl_id = $vv['other']['uploadurl_id']?>
		<?php endif ?>

		<?php $type = ''?>
		<?php if(isset($vv['other']['type']) and $vv['other']['type'] != ''):?>
			<?php $type = $vv['other']['type']?>
		<?php endif ?>

		<?php $dir = ''?>
		<?php if(isset($vv['other']['dir']) and $vv['other']['dir'] != ''):?>
			<?php $type = $vv['other']['dir']?>
		<?php endif ?>

		<?php $kcfinder_url = vir_path_c.'kcfinder/browse.php?uploadurl_id='.$uploadurl_id.'&type='.$type.'&dir='.$dir?>
		<iframe <?php echo $formattr?> frameborder="0" src="<?php echo $kcfinder_url?>"/></iframe>
	<?php elseif($vv['type'] == 'kcfinder_xxx'):?>
		{{if $vv.other.url == ''}}
			{{assign var="kcfinder_url" value="/kcfinder/browse.php?langCode=zh&type="}}
		{{else}}
			{{assign var="kcfinder_url" value=$vv.other.url}}
		{{/if}}
		{{if !empty($vv.other.types) }}
		<select id="{{$vv.attr.id}}_select">
			{{foreach from=$vv.other.types key=kkk item=vvv}}
			<option value="{{$vvv}}">{{$vvv}}</option>
			{{/foreach}}
		</select>
		<br />
		<iframe <?php echo $formattr?> frameborder="0" src="{{$kcfinder_url}}{{$vv.other.types.0}}"/></iframe>
		{{/if}}
	<?php elseif($vv['type'] == 'kcfinder_swfupload_abs'):?>
		{{if $vv.other.url == ''}}
			{{assign var="kcfinder_url" value="/kcfinder/browse.php?langCode=zh&type="}}
		{{else}}
			{{assign var="kcfinder_url" value=$vv.other.url}}
		{{/if}}
		{{include file="includes/swfupload_multi_kcfinder.htm" action=$def.updatefield.method field=$kk class=$router_class no_ext="1" subfield=$vv.other width=$vv.attr.width height=$vv.attr.height style=$vv.attr.style}}
		<iframe <?php echo $formattr?> frameborder="0" src="{{$kcfinder_url}}{{$vv.other.type}}&dir={{$vv.other.path}}"/></iframe>
		<p style="height:10px;">&nbsp;</p>
	<?php elseif($vv['type'] == 'kcfinder2_xxx'):?>
		{{if $vv.other.url == ''}}
			{{assign var="kcfinder_url" value="/kcfinder2/browse.php?langCode=zh&type="}}
		{{else}}
			{{assign var="kcfinder_url" value=$vv.other.url}}
		{{/if}}
		{{if !empty($vv.other.types) }}
		<select id="{{$vv.attr.id}}_select">
			{{foreach from=$vv.other.types key=kkk item=vvv}}
			<option value="{{$vvv}}">{{$vvv}}</option>
			{{/foreach}}
		</select>
		<br />
		<iframe <?php echo $formattr?> frameborder="0" src="{{$kcfinder_url}}{{$vv.other.types.0}}"/></iframe>
		{{/if}}
	<?php elseif($vv['type'] == 'ckfinder'):?>
		<iframe <?php echo $formattr?> frameborder="0" src="/ckfinder/ckfinder.html?langCode=zh"/></iframe>
	<?php elseif($vv['type'] == 'ckfinder2'):?>
		<iframe <?php echo $formattr?> frameborder="0" src="/ckfinder2/ckfinder.html?langCode=zh"/></iframe>
	<?php elseif($vv['type'] == 'iframe'):?>
		<iframe <?php echo $formattr?> frameborder="0" /></iframe>
	<?php elseif($vv['type'] == 'textarea' or $vv['type'] == 'textarea_autoheight_js'):?>
	<textarea <?php echo $formattr?> ><?php echo htmlspecialchars(G::a($updatecontent, 'updatecontent.'.$kk))?></textarea>
		<p style="height:10px;">&nbsp;</p>
	<?php elseif($vv['type'] == 'codemirror2'):?>
		<textarea <?php echo $formattr?> >{{$updatecontent.$kk}}</textarea>
		<p style="height:10px;">&nbsp;</p>
	<?php elseif($vv['type'] == 'fileuploader'):?>
		<?php if(isset($vv['other']['class']) and $vv['other']['class'] != ''):?>
			<?php $class = $vv['other']['class']?>
		<?php else:?>
			<?php $class = $router_class?>
		<?php endif?>

		<?php $this->data['action'] = $def['updatefield']['method']?>
		<?php $this->data['field'] = $kk?>
		<?php $this->data['number'] = $vv['other']['number']?>
		<?php $this->data['value'] = G::a($updatecontent, 'updatecontent.'.$kk)?>
		<?php $this->data['class'] = $class?>
		<?php $this->data['width'] = $vv['other']['width']?>
		<?php $this->data['height'] = $vv['other']['height']?>
		<?php $this->data['type'] = G::a($vv, 'vv.other.type')?>
		<?php $this->data['comment_size'] = $vv['other']['comment_size']?>
		<?php $this->data['top_button'] = $vv['other']['top_button']?>
		<?php $this->data['no_ext'] = $vv['other']['no_ext']?>
		<?php $this->data['no_need_delete_button'] = $vv['other']['no_need_delete_button']?>

		<?php echo $this->renderPartial('//includes/fileuploader', $this->data)?>

		<?php if($vv['other']['top_button'] != '1'):?><br /><?php endif?>
	<?php elseif($vv['type'] == 'fileuploader2'):?><?php //單檔上傳 + 獨立 + 選擇己存在檔案?>
		{{if $vv.other.class != ''}}
			{{assign var="class" value=$vv.other.class}}
		{{else}}
			{{assign var="class" value=$router_class}}
		{{/if}}
		{{include file="includes/fileuploader2.htm" action=$def.updatefield.method field=$kk number=$vv.other.number value=$updatecontent[$kk] class=$class width=$vv.other.width height=$vv.other.width type=$vv.other.type comment_size=$vv.other.comment_size top_button=$vv.other.top_button}}
		{{if $vv.other.top_button != '1'}}<br />{{/if}}
	<?php elseif($vv['type'] == 'fileuploader_multi'):?><?php //多檔上傳 + 重覆使用?>
		<?php if(isset($vv['other']['class']) and $vv['other']['class'] != ''):?>
			<?php $class = $vv['other']['class']?>
		<?php else:?>
			<?php $class = $router_class?>
		<?php endif?>

		<?php $this->data['action'] = $def['updatefield']['method']?>
		<?php $this->data['field'] = $kk?>
		<?php $this->data['number'] = $vv['other']['number']?>
		<?php $this->data['value'] = G::a($updatecontent, 'updatecontent.'.$kk)?>
		<?php $this->data['class'] = $class?>
		<?php $this->data['width'] = $vv['other']['width']?>
		<?php $this->data['height'] = $vv['other']['height']?>
		<?php $this->data['type'] = G::a($vv, 'vv.other.type')?>
		<?php $this->data['comment_size'] = $vv['other']['comment_size']?>
		<?php $this->data['no_ext'] = $vv['other']['no_ext']?>
		<?php $this->data['subfield'] = $vv['other2']?>

		<?php echo $this->renderPartial('//includes/fileuploader_multi', $this->data)?>
<?php if(0):?>
		{{include file="includes/fileuploader_multi.htm" action=$def.updatefield.method field=$kk class=$router_class no_ext="1" subfield=$vv.other width=$vv.attr.width height=$vv.attr.height}}
<?php endif?>
	<?php elseif($vv['type'] == 'fileuploader_multi2'):?>
		{{include file="includes/fileuploader_multi2.htm" action=$def.updatefield.method field=$kk class=$router_class no_ext="1" subfield=$vv.other width=$vv.attr.width height=$vv.attr.height style=$vv.attr.style}}
	<?php elseif($vv['type'] == 'fileuploader_multi3'):?>
		{{include file="includes/fileuploader_multi3.htm" action=$def.updatefield.method field=$kk class=$router_class no_ext="1" subfield=$vv.other width=$vv.attr.width height=$vv.attr.height style=$vv.attr.style}}
	<?php elseif($vv['type'] == 'fileuploader_multi4'):?>
		{{include file="includes/fileuploader_multi4.htm" action=$def.updatefield.method field=$kk class=$router_class no_ext="1" subfield=$vv.other width=$vv.attr.width height=$vv.attr.height style=$vv.attr.style}}
	<?php elseif($vv['type'] == 'fileuploader_multi5'):?>
		{{include file="includes/fileuploader_multi5.htm" action=$def.updatefield.method field=$kk class=$router_class no_ext="1" subfield=$vv.other width=$vv.attr.width height=$vv.attr.height style=$vv.attr.style}}
	<?php elseif($vv['type'] == 'video'):?>
		{{include file="includes/youtube.htm" action=$def.updatefield.method field=$kk value=$updatecontent.$kk}}
	<?php elseif($vv['type'] == 'youtube_multi'):?>
		{{include file="includes/youtube_multi.htm" action=$def.updatefield.method field=$kk value=$updatecontent.$kk subfield=$vv.other}}
	<?php elseif($vv['type'] == 'youtube_multi2'):?>
		{{include file="includes/youtube_multi2.htm" action=$def.updatefield.method field=$kk value=$updatecontent.$kk subfield=$vv.other}}
	<?php elseif($vv['type'] == 'multiselect'):?>
		<select multiple="multiple" <?php echo $formattr?>>
		<?php if(!empty($updatecontent[$kk])):?>
			<?php foreach($updatecontent[$kk] as $kkk => $vvv):?>
			<option value="<?php echo $kkk?>" <?php if(isset($vvv['is_selected'])) echo $vvv['is_selected']?> ><?php echo $vvv['value']?></option>
			<?php endforeach?>
		<?php endif?>
		</select>
	<?php elseif($vv['type'] == 'multiselect2'):?>
		<table><tr><td valign="top">
		<select multiple="multiple" <?php echo $formattr?>>
		{{if !empty($updatecontent.$kk) }}
			{{foreach from=$updatecontent.$kk key=kkk item=vvv}}
				<option value="{{$kkk}}" {{$vvv.is_selected}} html="{{$vvv.value2}}">{{$vvv.value}}</option>
			{{/foreach}}
		{{/if}}
		</select>
		</td><td valign="top">
		<div id="{{$kk}}_display_html">
		</div>
		{{if !empty($updatecontent.$kk) }}
			{{foreach from=$updatecontent.$kk key=kkk item=vvv}}
				<div id="{{$kk}}_display_html_{{$kkk}}" class="none">{{$vvv.value2}}</div>
			{{/foreach}}
		{{/if}}
		</td></tr></table>
	<?php elseif($vv['type'] == 'select4'):?>
		<table><tr><td valign="top">
		<select <?php echo $formattr?>>
		{{if !empty($updatecontent.$kk) }}
			{{foreach from=$updatecontent.$kk key=kkk item=vvv}}
				<option value="{{$kkk}}" {{$vvv.is_selected}} html="{{$vvv.value2}}">{{$vvv.value}}</option>
			{{/foreach}}
		{{/if}}
		</select>
		</td><td valign="top">
		<div id="{{$kk}}_display_html"></div>
		{{if !empty($updatecontent.$kk) }}
			{{foreach from=$updatecontent.$kk key=kkk item=vvv}}
				<div id="{{$kk}}_display_html_{{$kkk}}" class="none">{{$vvv.value2}}</div>
			{{/foreach}}
		{{/if}}
		</td></tr></table>
	<?php elseif($vv['type'] == 'radio4'):?>
		{{assign var="formattr1" value=""}}{{* 用來放ID的 *}}
		{{assign var="formattr2" value=""}}{{* 用來放ID以外的 *}}
		{{if !empty($vv.attr) }}
			{{foreach from=$vv.attr key=kkk item=vvv}}
				{{if $kkk == 'id'}}
					{{assign var="formattr1" value="$formattr1 $kkk=\"$vvv\""}}
				{{else}}
					{{assign var="formattr2" value="$formattr2 $kkk=\"$vvv\""}}
				{{/if}}
			{{/foreach}}
		{{/if}}
		<table><tr><td valign="top" {{$formattr1}} >
		{{if !empty($updatecontent.$kk) }}
			{{foreach from=$updatecontent.$kk key=kkk item=vvv}}
				<label html="{{$vvv.value2}}"><input type="radio" {{$formattr2}} value="{{$kkk}}" {{if $vvv.is_selected == 'selected'}}checked{{/if}} />{{$vvv.value}}</label><br />
			{{/foreach}}
		{{/if}}
		</td><td valign="top">
		<div id="{{$kk}}_display_html"></div>
		</td></tr></table>
	<?php elseif($vv['type'] == 'pre_css'):?>
		<pre class="highlight">
			<?php echo $updatecontent[$kk]?>
		</pre>
	<?php elseif($vv['type'] == 'jstree'):?>
		<div id="{{$vv.attr.id}}"></div>
	<?php elseif($vv['type'] == 'divid_2'):?>
		<?php //{{* 通常這裡會搭配js，或是後台準備好html然後放進來 *}}?>
		<div id="<?php G::ae($vv, 'vv.attr.id')?>">
			<?php echo $updatecontent[$kk]?>
		</div>
	<?php else:?>
		<?php if($def['updatefield']['method'] == 'update' and isset($updatecontent[$kk])):?>
			<?php echo $updatecontent[$kk]?>
		<?php endif?>
	<?php endif?>

	<?php // 每個欄位的包尾 ?>
	<?php if(!preg_match('/hidden/', $vv['type'])):?>
		<?php if($v['type'] == '1'):?>
			</dd>
		<?php elseif($v['type'] == '2'):?>
			</dd>
		<?php // 第2個區塊沒有包尾?>
		<?php elseif($v['type'] == 'tab'):?>
		</li>
		<?php endif?>
	<?php endif?>

	<?php $tmp_first++?>
<?php endforeach?>
