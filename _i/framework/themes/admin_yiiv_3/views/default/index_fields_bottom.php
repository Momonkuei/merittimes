<?php 

// 為了要支援sort_id改欄位名稱
$sort_field = 'sort_id';
if(isset($this->def['func_field']['sort_id']) and $this->def['func_field']['sort_id'] != ''){
	$sort_field = $this->def['func_field']['sort_id'];
}

// 設定預設的排版欄位名稱
$sort_id_tmp = '';
if(isset($def['sortable'][$sort_field.'_name'])){
	$sort_id_tmp = $def['sortable'][$sort_field.'_name'];
}
if($sort_id_tmp == ''){
	$sort_id_tmp = $sort_field;
}

?>


<?php if(!empty($listfield)):?>
	<?php foreach($listfield as $kk => $vv): ?>
		<?php if(isset($vv['number_format']) and $vv['number_format'] == true):?>
			<?php if(!isset($v[$kk])):?><?php $v[$kk] = 0?><?php endif?>
			<?php if(!is_string($v[$kk])):?>
				<?php $v[$kk] = number_format($v[$kk])?>
			<?php else:?>
				<?php $v[$kk] = number_format((int)$v[$kk])?>
			<?php endif?>
		<?php endif?>
	<td <?php if(isset($vv['width'])):?>width="<?php echo $vv['width']?>"<?php endif?> class="" <?php if(isset($vv['align']) and $vv['align'] != ''):?>align="<?php echo $vv['align']?>"<?php endif?> <?php if(isset($vv['valign']) and $vv['valign'] != ''):?>valign="<?php echo $vv['valign']?>"<?php endif?> <?php if(isset($listcontent[$k]['_style']) and $listcontent[$k]['_style'] != ''):?>style="<?php echo $listcontent[$k]['_style']?>"<?php endif?> >
		<?php if(0 and $kk == $sort_id_tmp and $sort_field_nobase64 == $sort_id_tmp):?>
			<?php $down_sort_id = $v[$sort_id_tmp]+1 ?>
			<?php $up_sort_id = $v[$sort_id_tmp]-1 ?>
			<a href="javascript:arrow_sort(<?php echo $v[$def['func_field']['id']]?>,<?php echo $down_sort_id?>)"><img height="16" width="16" border="0" alt="Down" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/arrow_down.gif" class="sortImg" /></a>
		<?php endif?>

		<?php // 模組化?>
		<?php $is_module = false?>
		<?php foreach($vv as $kkk => $vvv):?>
			<?php //if(preg_match('/^func_(.*)$/', $kkk, $matches) and file_exists('listfields/'.$matches[1].'.php')):?>
			<?php if(preg_match('/^func_(.*)$/', $kkk, $matches)):?>
				<?php $this->data['vv_type_kk'] = $kk;?>
				<?php $this->data['vv_type_listv'] = $listcontent[$k]?>
				<?php $this->data['vv_type_vv'] = $vv?>
				<?php $this->data['vv_type_func'] = $matches[1]?>
				<?php echo $this->renderPartial('//default/listfields/'.$matches[1], $this->data)?>
				<?php $is_module = true?>
			<?php endif?>

		<?php endforeach?>

		<?php if(!$is_module):?>
			<?php // 這裡的判斷式，依照欄位的類型，需要以及可以增加判斷 ?> 
			<?php if(isset($vv['ez']) and $vv['ez'] == true):?>
				<input type="checkbox" class="checkbox_listcontent_trigger" id="checkbox_listcontent_trigger__<?php echo $listcontent[$k][$def['func_field']['id']]?>" id_uptime="<?php if(isset($vv['ezuptime']) and $vv['ezuptime'] == true):?>1<?php endif?>"  id_reload="<?php if(isset($vv['ezreload']) and $vv['ezreload'] == '1'):?>1<?php endif?>" id_alert="<?php if(isset($vv['ezalert']) and $vv['ezalert'] != ''):?><?php echo $vv['ezalert']?><?php endif?>" value="" <?php if($listcontent[$k][$kk] == '1'):?>checked="checked"<?php endif?> />&nbsp;<?php if(isset($vv['ezother']) and $vv['ezother'] != ""):?><?php G::te($this->data['theme_lang'], $vv['ezother'])?><?php else:?><?php G::te($this->data['theme_lang'], 'Enable', null, '啟用')?><?php endif?>
			<?php elseif(isset($vv['ezshow']) and $vv['ezshow'] == true):?>
				<input type="checkbox" class="checkbox_listcontent_trigger" id="checkbox_listcontent_trigger__<?php echo $listcontent[$k][$def['func_field']['id']]?>"  id_uptime="<?php if(isset($vv['ezuptime']) and $vv['ezuptime'] == true):?>1<?php endif?>" id_reload="<?php if(isset($vv['ezreload']) and $vv['ezreload'] == '1'):?>1<?php endif?>" id_alert="<?php if(isset($vv['ezalert']) and $vv['ezalert'] != ''):?><?php echo $vv['ezalert']?><?php endif?>" value="" <?php if($listcontent[$k][$kk] == '1'):?>checked="checked"<?php endif?> />&nbsp;<?php if(isset($vv['ezother']) and $vv['ezother'] != ""):?><?php G::te($this->data['theme_lang'], $vv['ezother'])?><?php else:?><?php G::te($this->data['theme_lang'], 'Show', null, '顯示')?><?php endif?>
			<?php elseif(isset($vv['ezfield']) and $vv['ezfield'] != ''):?>
				<input type="checkbox" class="checkbox_listcontent_trigger" id="checkbox_listcontent_trigger__<?php echo $listcontent[$k][$def['func_field']['id']]?>__<?php echo $vv['ezfield']?>" id_uptime="<?php if(isset($vv['ezuptime']) and $vv['ezuptime'] == true):?>1<?php endif?>" id_reload="<?php if(isset($vv['ezreload']) and $vv['ezreload'] == '1'):?>1<?php endif?>" id_alert="<?php if(isset($vv['ezalert']) and $vv['ezalert'] != ''):?><?php echo $vv['ezalert']?><?php endif?>" value="" <?php if($listcontent[$k][$kk] == '1'):?>checked="checked"<?php endif?> />&nbsp;<?php if(isset($vv['ezother']) and $vv['ezother'] != ""):?><?php G::te($this->data['theme_lang'], $vv['ezother'])?><?php else:?><?php G::te($this->data['theme_lang'], 'Enable', null, '啟用')?><?php endif?>
			<?php elseif(isset($vv['ezother']) and $vv['ezother'] != ''):?>
				<input type="checkbox" class="checkbox_listcontent_trigger" id="checkbox_listcontent_trigger__<?php echo $listcontent[$k][$def['func_field']['id']]?>"  id_uptime="<?php if(isset($vv['ezuptime']) and $vv['ezuptime'] == true):?>1<?php endif?>" id_reload="{{if $vv.ezreload == '1'}}1{{/if}}" id_alert="{{if $vv.ezalert != ''}}{{$vv.ezalert}}{{/if}}" value="" {{if $listcontent[$k][$kk] == '1'}}checked="checked"{{/if}} />&nbsp;{{m}}{{$vv.ezother}}{{/m}}
			<?php elseif(isset($vv['ezlabel']) and count($vv['ezlabel']) > 0):?>
				<?php // 例如1就是啟用，2就是停用，顯示的部份 ?>
				<?php echo $vv['ezlabel'][$v[$kk]]?>
			<?php elseif(isset($vv['ezdelete']) and $vv['ezdelete'] == true):?>
				<input type="checkbox" class="checkboxes" value="<?php echo $listcontent[$k][$def['func_field']['id']]?>" name="ezdeletes[]">
			<?php elseif(isset($vv['mls']) and $vv['mls'] == true):?>
				<?php $this->widget('system.widgets.Gw_mls', array('v'=>$v[$kk]))?>
			<?php elseif(isset($vv['kcfinder_small_img']) and $vv['kcfinder_small_img'] == true and isset($v[$kk]) and $v[$kk] != ''):?>
				<?php if(file_exists(_BASEPATH.'/'.str_replace('_i/', '', urldecode($v[$kk])))):?>
					<img height="50" src="<?php echo vir_path_c.str_replace('_i/', '', urldecode($v[$kk]))?>" /><?php //2017/7/17 Jonathan建議改為限制高度50 by lota?>
				<?php else:?>
					<img src="https://placehold.it/47x30&text=No+Image" />
				<?php endif?>
			<?php elseif(isset($vv['kcfinder_big_img']) and $vv['kcfinder_big_img'] == true and isset($v[$kk]) and $v[$kk] != ''):?>
				<img width="200" src="<?php echo vir_path_c.str_replace('_i/', '', $v[$kk])?>" />
			<?php elseif(isset($vv['small_img']) and $vv['small_img'] == true):?>
				{{if $def.pic_upload_path != ''}}
					{{if $v.$kk != ""}}{{img a="47" b="47" c=$def.pic_upload_path _html_style='margin-top:5px;margin-bottom:5px;'}}{{$v.$kk}}{{/img}}{{else}}&nbsp;{{/if}}
				{{else}}
					{{if $v.$kk != ""}}{{img a="47" b="47" c=$router_class _html_style='margin-top:5px;margin-bottom:5px;'}}{{$v.$kk}}{{/img}}{{else}}&nbsp;{{/if}}
				{{/if}}
			<?php elseif(isset($vv['url_id']) and $vv['url_id'] != ''):?>
				<?php $router_class = (isset($vv['url_router_class']))?$vv['url_router_class']:$router_class;//2016/6/21 lota 新增?>

				<?php // 2016-08-08 業務管理系統的所有客戶管理的連絡欄位有用到?>
				<?php $label_name = $vv['label']?>
				<?php if(isset($v[$kk.'_url_id_label_name'])):?>
					<?php $label_name = $v[$kk.'_url_id_label_name']?>
				<?php endif?>
					
				<?php if(isset($vv['url_id_field'])):?>
					<a href="backend.php?r=<?php echo $router_class?>/<?php echo $vv['url_id']?>&param=<?php echo $v[$vv['url_id_field']]?>"><?php echo $label_name?></a>
				<?php else:?>
					<?php if(stristr($this->data['router_class'],'news')):?>
						<a href="backend.php?r=<?php echo $router_class?>/<?php echo $vv['url_id']?>&param=<?php echo $v[$def['func_field']['id']]?>" target="_blank"><?php echo $label_name?></a>
					<?php elseif($this->data['router_class']=='praylist'):?>	
						<a target="_blank"  href="backend.php?r=<?php echo $router_class?>/<?php echo $vv['url_id']?>&param=<?php echo $v[$def['func_field']['id']]?>"><?php echo $label_name?></a>
					<?php else:?>	
						<?if(!isset($listcontent[$k]['a_results']) || $listcontent[$k]['a_results']=='核可' ){?>
							<a target="_blank" href="backend.php?r=<?php echo $router_class?>/<?php echo $vv['url_id']?>&param=<?php echo $v[$def['func_field']['id']]?>"><?php echo $label_name?></a>
						<?}?>
					<?php endif?>
				<?php endif?>
			<?php elseif(isset($vv['confirm_url_id']) and $vv['confirm_url_id'] != ''):?>
				<a href="#" title="{{$class_url}}/{{$vv.confirm_url_id}}/{{$v.id}}" onclick="if(confirm('您確定要做這個動作嗎？')){window.location.href=$(this).attr('title');}">{{$vv.label}}</a>
			<?php elseif(isset($vv['have_url']) and $vv['have_url'] == true):?>
				<a target="_blank" href="http://{{$host.web_url}}{{$v.$kk}}">{{$v.$kk}}</a>
			<?php elseif(isset($vv['is_iframe']) and $vv['is_iframe'] == true):?> 
				<?php $iframe_attrs = ''?>
				<?php if(isset($vv['iframe_attrs']) and count($vv['iframe_attrs'])):?>
					<?php foreach($vv['iframe_attrs'] as $kkk => $vvv):?>
						<?php $iframe_attrs .= ' '.$kkk.'="'.$vvv.'" '?>
					<?php endforeach?>
				<?php endif?>
				<iframe <?php echo $iframe_attrs?> src="<?php echo $v[$kk]?>" frameborder="0" /></iframe>
			<?php else:?>
				<?php // 值的判斷請寫在這裡?>
				<?php if(isset($v[$kk]) and $v[$kk] == '0000-00-00 00:00:00'):?>
					&nbsp;
				<?php elseif(isset($v[$kk.'__alias']))://2020-07-07?>
					<?php echo $v[$kk.'__alias']?>
				<?php elseif(isset($v[$kk]) and $v[$kk] == 0):?>
					<?php echo $v[$kk]?>
				<?php elseif(isset($v[$kk])):?>
					<?php if(isset($vv['truncate']) and $vv['truncate'] != ''):?>
						<?php G::tf($this->data['theme_lang'], $v[$kk], array(), '', '2', array('len'=>$vv['truncate']))?>
					<?php else:?>
						<?php echo $v[$kk]?>
					<?php endif?>
				<?php endif?>
			<?php endif?>
		<?php endif?><?php // is_module?>

		<?php if(0 and $kk == $sort_id_tmp and $sort_field_nobase64 == $sort_id_tmp):?>
			<?php $up_sort_id = $v[$sort_id_tmp]-1 ?>
			<a href="javascript:arrow_sort(<?php echo $v[$def['func_field']['id']]?>,<?php echo $up_sort_id?>)"><img height="16" width="16" border="0" alt="Down" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/arrow_up.gif" class="sortImg" /></a> 　
		<?php endif?>
	</td>
	<?php endforeach?>
<?php endif?>
