<div class="faqList">
	<div class="itemList togglearea" data-item=".item" data-title=".itemTitle" data-content=".itemContent">

		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="item">
					<div class="itemTitle"><?php echo $v['name']?></div>
					<div class="itemContent">
						<?php echo $v['detail']?>
					</div>
				</div>
			<?php endforeach?>
		<?php endif?>

	</div>
</div>


<?php if(0):?>
<section dom="multi" doms="" class="itemList  togglearea" data-item=".item" data-title=".itemTitle" data-content=".itemContent">

	<div dom="1 f" class="item">
		<div dom="f" class="itemTitle">{*name*}問題標題，商品如何使用？</div>
		<div dom="f" class="itemContent">
			{*content*}問題說明內容，固態照明（SSL）是指一種類型的照明，其利用發光二極管作為照明的光源，而不是電燈絲或氣體。術語“固態”是指這樣的事實，光在LED由固體物體發射 - 半導體的嵌段 - 而不是從真空或氣體管中，如在傳統光源的情況。
		</div>
	</div>

	<div class="item">
		<div class="itemTitle">問題標題，商品如何使用？</div>
		<div class="itemContent">
			問題說明內容，固態照明（SSL）是指一種類型的照明，其利用發光二極管作為照明的光源，而不是電燈絲或氣體。術語“固態”是指這樣的事實，光在LED由固體物體發射 - 半導體的嵌段 - 而不是從真空或氣體管中，如在傳統光源的情況。
		</div>
	</div>

	<div class="item">
		<div class="itemTitle">問題標題，商品如何使用？</div>
		<div class="itemContent">
			問題說明內容，固態照明（SSL）是指一種類型的照明，其利用發光二極管作為照明的光源，而不是電燈絲或氣體。術語“固態”是指這樣的事實，光在LED由固體物體發射 - 半導體的嵌段 - 而不是從真空或氣體管中，如在傳統光源的情況。
		</div>
	</div>

	<div class="item">
		<div class="itemTitle">問題標題，商品如何使用？</div>
		<div class="itemContent">
			問題說明內容，固態照明（SSL）是指一種類型的照明，其利用發光二極管作為照明的光源，而不是電燈絲或氣體。術語“固態”是指這樣的事實，光在LED由固體物體發射 - 半導體的嵌段 - 而不是從真空或氣體管中，如在傳統光源的情況。
		</div>
	</div>

	<div class="item">
		<div class="itemTitle">問題標題，商品如何使用？</div>
		<div class="itemContent">
			問題說明內容，固態照明（SSL）是指一種類型的照明，其利用發光二極管作為照明的光源，而不是電燈絲或氣體。術語“固態”是指這樣的事實，光在LED由固體物體發射 - 半導體的嵌段 - 而不是從真空或氣體管中，如在傳統光源的情況。
		</div>
	</div>

</section>
<?php endif?>
