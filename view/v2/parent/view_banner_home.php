
<?php if($this->data['editmode']):?>
	<p>
	 記得設定外盒(上層) class=banner winH(or h)<br>
	 banner-slid-01為主id,一頁多banner時需更改<br>
	</p>

<?php endif?>


			<div id="banner-slid-01" class="carousel [OTHER]" data-ride="carousel" [STYLEPOS1]>
				[POS1]
				  <ol class="carousel-indicators">
					<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
						<?php if(count($this->data['layoutv2'][$this->data['section']['key']]) > 1):?>
							<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
							<li data-target="#banner-slid-01" data-slide-to="<?php echo $k?>" <?php if($k == 0):?>class="active"<?php endif?> ></li>
							<?php endforeach?>
						<?php endif?>
					<?php endif?>
				  </ol>

				  <div class="carousel-inner" role="listbox" >
					<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
						<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
							<div class="item show<?=$k+1?> <?php if($k == 0):?>active<?php endif?>" style="background:url('<?php echo $v['pic1']?>') center;background-size:cover" ><p class="txtbox<?=$k+1?>" ><?php echo $v['topic']?></p></div>
						<?php endforeach?>
					<?php endif?>
				  </div>
				<?php if(count($this->data['layoutv2'][$this->data['section']['key']]) > 1):?>
				  <a class="left carousel-control" href="#banner-slid-01" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#banner-slid-01" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
			<?php endif?>
			</div>


<?php // 這是scss的範本?>
<?php if(0):?>
	<?php $tmp1 = 'config.scss'//指定的scss檔案?>
	<?php $tmp2 = 'test1'//指標名稱?>
	<?php $tmp3 = $this->data['layout_v2_name'].'-'.$tmp1.'-'.$tmp2.'-'.$this->data['section']['key']?>
	<?php if(!isset($this->data['scss_configs'])):?><?php $this->data['scss_configs'] = array()?><?php endif?>
	<?php $this->data['scss_configs'][$tmp3] = array(
		'file' => $tmp1,
		'pos' => $tmp2,
		// scss程式碼，記得錢字號要跳脫(反斜線)
		'content' => <<<XXX

\$cis-color-3: red;

XXX
		)
	?>
<?php endif?>
