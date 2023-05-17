[POS1]
<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>
<?php if(count($tmp) > 1):?>
<div class="tabList">	
	<?php if(isset($tmp['describe2']) && $tmp['describe2']!=''):?>
	<a href="#_" class="tabLabel active"><?php echo G::t(null,'Explanation')?></a>
	<div class="tabContent"><?php echo $tmp['describe2']?></div>
	<?php endif?>
	<?php if(isset($tmp['describe3']) && $tmp['describe3']!=''):?>
	<a href="#_" class="tabLabel"><?php echo G::t(null,'Format')?></a>
	<div class="tabContent"><?php echo $tmp['describe3']?></div>
	<?php endif?>
</div>
<?php endif?>

<?php /* //備份
<div class="tabList">	
	<a href="#_" class="tabLabel active">標題一</a>
	<div class="tabContent">
		<h3>標題一的內文</h3>
		<p>【暢銷冠軍】人氣包款新推出新色~年度強力推薦<br>
		女孩們絕對要比別人先擁有的明星級商品<br>
		率性休閒風永不退燒實搭單品包款</p>

		<p>
		嚴選輕柔牛皮整體散發出時尚的細緻皮革感<br>
		設計感十足 × 功能性超強的休閒美包<br>
		包包身型及大小非常適合上班或逛街使用<br>
		時尚潮流最亮眼的選擇韓國明星強力放送<br>
		內袋LOGO精緻品牌烙印識別&品牌專屬內裡<br>
		不容在錯過的永不退燒實搭單品包款
		</p>
	</div>							
	<a href="#_" class="tabLabel">標題二</a>
	<div class="tabContent">標題二的內文</div>	
</div>
*/ ?>



<?php if(!isset($this->data['HEAD'])):?><?php $this->data['HEAD']=''?><?php endif?>
<?php $this->data['HEAD'] .= <<<XXX
<style>
/*---------------------------------------------------------------------------------------------------*/
/* tabList */
/*---------------------------------------------------------------------------------------------------*/
.tabList                              {width:100%;}
.tabList                              {display:flex;justify-content: flex-start;align-items: center;flex-wrap: wrap;}
.tabList                              {display:-webkit-flex;-webkit-justify-content: flex-start;-webkit-align-items: center;-webkit-flex-wrap: wrap;}
.tabList .tabLabel                    {order:0;}
.tabList .tabContent                  {order:2;width: 100%;}
.tabList .tabContent img              {max-width: 100%;height: auto !important}

/*box position*/
.tabList .tabLabel                    {position: relative;}
.tabList .tabLabel:after              {content:'';position: absolute;left:0;bottom:-2px;height: 2px;width: 100%;}

/*box effect*/
.tabList .tabContent                  {display: none}
.tabList .tabLabel.active+.tabContent {display: block;}
.tabList .tabLabel:focus+.tabContent  {display: block;order:1;}


/* space */
.tabList .tabLabel                    {padding:0 30px;}
.tabList .tabContent                  {padding:30px 0;}


/*color*/
.tabList .tabLabel:hover:after        {background: #D90012}
.tabList .tabLabel.active:after       {background: #D90012}
.tabList .tabContent                  {border-top:1px solid #CFD0D0;}

/*font*/
.tabList .tabLabel                    {font-size:24px;line-height: 1.5em;font-weight: bold;}

@media (max-width:768px){
	
	.tabList .tabLabel                    {order:0;}
	.tabList .tabContent                  {order:0;display: block;}
	.tabList .tabLabel:focus+.tabContent  {display: block;order:0;}

	/*color*/
	.tabList .tabLabel:after              {background: #D90012}
}
</style>
XXX;
?>




<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
<?php $this->data['BODY_END'] .= <<<XXX
<script>
// tab
$(".tabLabel").click(function(){
		if(!($(this).hasClass("active"))){
			$(".tabLabel.active").removeClass("active");
			$(this).addClass("active");
		}
});
</script>
XXX;
?>