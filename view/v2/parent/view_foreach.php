<?php if(isset($this->data['tag_section_recursive_end']) and isset($return)):?>
	<?php //ob_start()?>
	<?php if(isset($this->data['layoutv2'][$key])):?>
		<?php //var_dump($this->data['layoutv2'][$this->data['section']['key']])?>
		<?php foreach($this->data['layoutv2'][$key] as $this->data['layoutv2_'.$key.'_k'] => $this->data['layoutv2_'.$key.'_v']):?>
			<?php eval($this->run_pos_n(1,$key))?>
			<?php $return .= '[POS1]'?>
			<?php eval($this->run_pos_m(1))?>
		<?php endforeach?>
	<?php endif?>
	<?php //$return = ob_get_contents();ob_end_clean()?>
<?php endif?>
