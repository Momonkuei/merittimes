<div class="locationList"><!-- 頁籤分項 Loop -->
<div class="locationTable active">
<table><!-- 頁籤內的據點 loop -->
	<thead>
		<tr>
			<th>No.</th>
			<th>Subject</th>
			<th>Link</th>
		</tr>
	</thead>
	<tbody>
	<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
		<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
		<tr>
			<td class="Lname"><?php echo $k+1?></td>
			<td class="Lphone"><?php echo $v['topic']?></td>
			<td class="Lfax"><a href="<?php echo $v['url1']?>" target="_blank"><?php echo $v['url1']?></a></td>
		</tr>
		<?php endforeach?>
	<?php endif?>		
	</tbody>
</table>
</div>
<!-- 頁籤分項 Loop --></div>
