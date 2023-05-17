<?php 

// 設定預設的排版欄位名稱
$sort_id_tmp = '';
if(isset($def['sortable']['sort_id_name'])){
	$sort_id_tmp = $def['sortable']['sort_id_name'];
}
if($sort_id_tmp == ''){
	$sort_id_tmp = 'sort_id';
}

?>

<?php if(!empty($listfield)):?>
	<?php foreach($listfield as $kk => $vv): ?>
	<td class="" <?php if(isset($vv['align']) and $vv['align'] != ''):?>align="<?php echo $vv['align']?>"<?php endif?>><label>
		<?php if($kk == $sort_id_tmp and $sort_field_nobase64 == $sort_id_tmp):?>
			<?php $down_sort_id = $v[$sort_id_tmp]+1 ?>
			<?php $up_sort_id = $v[$sort_id_tmp]-1 ?>
			<a href="javascript:arrow_sort(<?php echo $v['id']?>,<?php echo $down_sort_id?>)"><img height="16" width="16" border="0" alt="Down" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/arrow_down.gif" class="sortImg" /></a>
		<?php endif?>

		<?php // 這裡的判斷式，依照欄位的類型，需要以及可以增加判斷 ?> 
		<?php if(isset($vv['ez']) and $vv['ez'] == true):?>
			<input type="checkbox" class="checkbox_listcontent_trigger" id="checkbox_listcontent_trigger__<?php echo $listcontent[$k]['id']?>" id_reload="<?php if(isset($vv['ezreload']) and $vv['ezreload'] == '1'):?>1<?php endif?>" id_alert="<?php if(isset($vv['ezalert']) and $vv['ezalert'] != ''):?><?php echo $vv['ezalert']?><?php endif?>" value="" <?php if($listcontent[$k][$kk] == '1'):?>checked="checked"<?php endif?> />&nbsp;<?php if(isset($vv['ezother']) and $vv['ezother'] != ""):?><?php G::te($this->data['theme_lang'], $vv['ezother'])?><?php else:?><?php G::te($this->data['theme_lang'], 'Enable', null, '啟用')?><?php endif?>
		<?php elseif(isset($vv['ezshow']) and $vv['ezshow'] == true):?>
			<input type="checkbox" class="checkbox_listcontent_trigger" id="checkbox_listcontent_trigger__<?php echo $listcontent[$k]['id']?>" id_reload="<?php if(isset($vv['ezreload']) and $vv['ezreload'] == '1'):?>1<?php endif?>" id_alert="<?php if(isset($vv['ezalert']) and $vv['ezalert'] != ''):?><?php echo $vv['ezalert']?><?php endif?>" value="" <?php if($listcontent[$k][$kk] == '1'):?>checked="checked"<?php endif?> />&nbsp;<?php if(isset($vv['ezother']) and $vv['ezother'] != ""):?><?php G::te($this->data['theme_lang'], $vv['ezother'])?><?php else:?><?php G::te($this->data['theme_lang'], 'Show', null, '顯示')?><?php endif?>
		<?php elseif(isset($vv['ezfield']) and $vv['ezfield'] != ''):?>
			<input type="checkbox" class="checkbox_listcontent_trigger" id="checkbox_listcontent_trigger__<?php echo $listcontent[$k]['id']?>__<?php echo $vv['ezfield']?>" id_reload="<?php if(isset($vv['ezreload']) and $vv['ezreload'] == '1'):?>1<?php endif?>" id_alert="<?php if(isset($vv['ezalert']) and $vv['ezalert'] != ''):?><?php echo $vv['ezalert']?><?php endif?>" value="" <?php if($listcontent[$k][$kk] == '1'):?>checked="checked"<?php endif?> />&nbsp;<?php if(isset($vv['ezother']) and $vv['ezother'] != ""):?><?php G::te($this->data['theme_lang'], $vv['ezother'])?><?php else:?><?php G::te($this->data['theme_lang'], 'Enable', null, '啟用')?><?php endif?>
		<?php elseif(isset($vv['ezother']) and $vv['ezother'] != ''):?>
			<input type="checkbox" class="checkbox_listcontent_trigger" id="checkbox_listcontent_trigger__<?php echo $listcontent[$k]['id']?>" id_reload="{{if $vv.ezreload == '1'}}1{{/if}}" id_alert="{{if $vv.ezalert != ''}}{{$vv.ezalert}}{{/if}}" value="" {{if $listcontent[$k][$kk] == '1'}}checked="checked"{{/if}} />&nbsp;{{m}}{{$vv.ezother}}{{/m}}
		<?php elseif(isset($vv['ezlabel']) and count($vv['ezlabel']) > 0):?>
			<?php // 例如1就是啟用，2就是停用，顯示的部份 ?>
			<?php echo $vv['ezlabel'][$v[$kk]]?>
		<?php elseif(isset($vv['mls']) and $vv['mls'] == true):?>
			<?php $this->widget('system.widgets.Gw_mls', array('v'=>$v[$kk]))?>
		<?php elseif(isset($vv['kcfinder_small_img']) and $vv['kcfinder_small_img'] == true and isset($v[$kk]) and $v[$kk] != ''):?>
			<img width="47" src="<?php echo vir_path_c.str_replace('_butterfly/', '', $v[$kk])?>" />
		<?php elseif(isset($vv['kcfinder_big_img']) and $vv['kcfinder_big_img'] == true and isset($v[$kk]) and $v[$kk] != ''):?>
			<img width="200" src="<?php echo vir_path_c.str_replace('_butterfly/', '', $v[$kk])?>" />
		<?php elseif(isset($vv['small_img']) and $vv['small_img'] == true):?>
			{{if $def.pic_upload_path != ''}}
				{{if $v.$kk != ""}}{{img a="47" b="47" c=$def.pic_upload_path _html_style='margin-top:5px;margin-bottom:5px;'}}{{$v.$kk}}{{/img}}{{else}}&nbsp;{{/if}}
			{{else}}
				{{if $v.$kk != ""}}{{img a="47" b="47" c=$router_class _html_style='margin-top:5px;margin-bottom:5px;'}}{{$v.$kk}}{{/img}}{{else}}&nbsp;{{/if}}
			{{/if}}
		<?php elseif(isset($vv['url_id']) and $vv['url_id'] != ''):?>
			<a href="<?php echo $router_class?>/<?php echo $vv['url_id']?>/<?php echo $v['id']?>"><?php echo $vv['label']?></a>
		<?php elseif(isset($vv['confirm_url_id']) and $vv['confirm_url_id'] != ''):?>
			<a href="#" title="{{$class_url}}/{{$vv.confirm_url_id}}/{{$v.id}}" onclick="if(confirm('您確定要做這個動作嗎？')){window.location.href=$(this).attr('title');}">{{$vv.label}}</a>
		<?php elseif(isset($vv['have_url']) and $vv['have_url'] == true):?>
			<a target="_blank" href="http://{{$host.web_url}}{{$v.$kk}}">{{$v.$kk}}</a>
		<?php else:?>
			<?php // 值的判斷請寫在這裡?>
			<?php if(isset($v[$kk]) and $v[$kk] == '0000-00-00 00:00:00'):?>
				&nbsp;
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
		<?php if($kk == $sort_id_tmp and $sort_field_nobase64 == $sort_id_tmp):?>
			<?php $up_sort_id = $v[$sort_id_tmp]-1 ?>
			<a href="javascript:arrow_sort(<?php echo $v['id']?>,<?php echo $up_sort_id?>)"><img height="16" width="16" border="0" alt="Down" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/arrow_up.gif" class="sortImg" /></a> 　
		<?php endif?>
	</label></td>
	<?php endforeach?>
<?php endif?>
