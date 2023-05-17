
<?php if($this->data['editmode']):?>    

<?php endif?>


<ul class="list-inline [OTHER]" [STYLEPOS1]>	
	<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
		<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
		<li <?php if('index.php?r='.$this->data['current_url'] == $v['url1']):?>class="active"<?php endif?> ><a href="<?php echo $v['url1']?>"><?php echo $v['topic']?></a></li>
		<?php endforeach?>
	<?php endif?>
</ul>