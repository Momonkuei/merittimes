<section class="pageWidget">
	<section class="stickyFilter">
		<div class="mbPanel" data-mbPanel="mbPanel_effect01">
			<div class=" mbPanel_page">
				<div class="">
					<div class="filterBtn">
						<a href="" class="toggleBtn icon-link" data-target="#proFilter"><i class="fa fa-sliders"></i>條件篩選</a>
						<a href="" class="toggleBtn icon-link" data-target="#proListOrder"><i class="fa fa-sort"></i>產品排序</a>
					</div>
				</div>
			</div>
		</div>
	</section>


	<div id="proFilter" class="popBox">
		<div class="closeSpace closeBtn" data-target="#proFilter"></div>
		<div class="boxContent">
			<a href="" class="closeBtn" data-target="#proFilter"><i class="fa fa-check" aria-hidden="true"></i> 完成</a>
			<div class="mainContent">
<?php if(0):?>
				<section>
					<div class="boxTitle">尺寸</div>
<?php //echo $AA?>
					<?php // $proFilterItem='checkbox'; include 'profilter.php';?>
				</section>

				<section>
					<div class="boxTitle">顏色</div>
<?php //echo $BB?>
					<?php // $proFilterItem='slider'; include 'profilter.php';?>
				</section>
<?php endif?>
				<section>
					<div class="boxTitle">價格區間</div>
<?php //echo $CC?>
<?php echo $__?>
					<?php // $proFilterItem='slider'; include 'profilter.php';?>
				</section>

			</div>
		</div>
	</div>


	<div id="proListOrder" class="popBox">
		<div class="closeSpace closeBtn" data-target="#proListOrder"></div>
		<div class="boxContent">
			<a href="" class="closeBtn" data-target="#proListOrder"><i class="fa fa-check" aria-hidden="true"></i> CLOSE</a>
			<div class="mainContent">
				<form>					
					<?php $is_item_type = false // 預設不是分類?>
					<?php if(isset($data[$ID]) and count($data[$ID]) > 0):?>
						<?php if(isset($data[$ID][0]['pid'])):?>
							<?php $is_item_type = true // 我是分類?>
						<?php endif?>
					<?php endif?>

					<div class="formItem">
						<?php if($is_item_type !== true):?>
							<label>排序</label>
							<select id="dropdown_filter">
								<option value="1" <?php if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter']) and $_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '1'):?> selected="selected" <?php endif?> >價格 高&gt;低</option>
								<option value="2" <?php if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter']) and $_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '2'):?> selected="selected" <?php endif?> >價格 低&lt;高</option>
								<!--
									<option value="4" <?php if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter']) and $_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '4'):?> selected="selected" <?php endif?> >最新上架 新&gt;舊</option>
									<option value="3" <?php if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter']) and $_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '3'):?> selected="selected" <?php endif?> >最新上架 舊&gt;新</option>
								-->
							</select>
						<?php endif?>
					</div>

				</form>
			</div>
		</div>
	</div>	
</section>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
	var nowPos=0;
	var tmpPos=0;
	var funAction=false;
	$(window).on('scroll',function(){
		nowPos=$(this).scrollTop();                
		if($(".banner").length){
			if(nowPos>$(".banner").offset().top+$(".banner").height()){
				funAction=true;
			}else{
				funAction=false;
				$(".stickyFilter").removeClass("open");
			}
		}else{
			funAction=true;
		}
		if(funAction){
				if(nowPos>tmpPos){
					// console.log("stickyFilterscrolldown");
					$(".stickyFilter").removeClass("open");
				}else{
					// console.log("stickyFiltersrollup"); 
					$(".stickyFilter").addClass("open");
				}
				tmpPos=nowPos;
			}
		}
	);
</script>
<?php endif?><!-- body_end -->
