<style type="text/css">
/*Now the CSS*/
/** {margin: 0; padding: 0;}*/

.tree_css3{
	/*overflow:auto;*/
	width:20000px;
}

.tree_css3 ul {
	padding-top: 20px; position: relative;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;

	margin:auto;
}

.tree_css3 li {
	float: left; text-align: center;
	list-style-type: none;
	position: relative;
	padding: 20px 5px 0 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree_css3 li::before, .tree_css3 li::after{
	content: '';
	position: absolute; top: 0; right: 50%;
	border-top: 1px solid #ccc;
	width: 50%; height: 20px;
}
.tree_css3 li::after{
	right: auto; left: 50%;
	border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree_css3 li:only-child::after, .tree_css3 li:only-child::before {
	display: none;
}

/*Remove space from the top of single children*/
.tree_css3 li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree_css3 li:first-child::before, .tree_css3 li:last-child::after{
	border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree_css3 li:last-child::before{
	border-right: 1px solid #ccc;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
}
.tree_css3 li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree_css3 ul ul::before{
	content: '';
	position: absolute; top: 0; left: 50%;
	border-left: 1px solid #ccc;
	width: 0; height: 20px;
}

.tree_css3 li a{
	border: 1px solid #ccc;
	padding: 5px 10px;
	text-decoration: none;
	color: #666;
	font-family: arial, verdana, tahoma;
	font-size: 11px;
	display: inline-block;
	
	border-radius: 5px !important;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree_css3 li a:hover, .tree_css3 li a:hover+ul li a {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree_css3 li a:hover+ul li::after, 
.tree_css3 li a:hover+ul li::before, 
.tree_css3 li a:hover+ul::before, 
.tree_css3 li a:hover+ul ul::before{
	border-color:  #94a0b4;
}

/*Thats all. I hope you enjoyed it.
Thanks :)*/
</style>

<?php if(isset($tree_data3['keyvalue'])):?>
<ul class="breadcrumb">
	<li><i class="icon-sitemap"></i>
	<?php echo '頂層 <i class="icon-angle-right"></i> '.implode('<i class="icon-angle-right"></i>', $tree_data3['keyvalue'])?>
	</li>
</ul>
<?php endif?>

<?php if(isset($tree_data4)):?>
<div class="portlet box light-grey">
	<div class="portlet-title">
		<h4><i class="icon-globe"></i>圖一(該層與下四層)</h4>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<?php if(0):?>
			<a class="config" data-toggle="modal" href="#portlet-config"></a>
			<a class="reload" href="javascript:;"></a>
			<a class="remove" href="javascript:;"></a>
			<?php endif?>
		</div>
	</div>

	<div class="portlet-body" style="overflow:auto">
		<div class="tree_css3"><?php echo $tree_data4?></div>
	</div>
</div> <!-- portlet box -->
<?php endif?>

<?php if(isset($tree_data)):?>
<div class="portlet box green">
	<div class="portlet-title">
		<h4><i class="icon-globe"></i>圖二(顯示全部)</h4>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<?php if(0):?>
			<a class="config" data-toggle="modal" href="#portlet-config"></a>
			<a class="reload" href="javascript:;"></a>
			<a class="remove" href="javascript:;"></a>
			<?php endif?>
		</div>
	</div>

	<div class="portlet-body" style="overflow:auto">
		<div class="tree_css3"><?php echo $tree_data?></div>
	</div>
</div> <!-- portlet box -->
<?php endif?>

<?php if(isset($tree_data5) and 0):?>
<div class="portlet box blue">
	<div class="portlet-title">
		<h4><i class="icon-globe"></i>圖三(顯示全部)</h4>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<?php if(0):?>
			<a class="config" data-toggle="modal" href="#portlet-config"></a>
			<a class="reload" href="javascript:;"></a>
			<a class="remove" href="javascript:;"></a>
			<?php endif?>
		</div>
	</div>

	<div class="portlet-body" style="overflow:auto">
	<?php echo $tree_data5?>
	</div>

</div> <!-- portlet box -->
<?php endif?>

<?php if(isset($tree_data2)):?>
<div class="portlet box blue">
	<div class="portlet-title">
		<h4><i class="icon-globe"></i>圖四(顯示全部)</h4>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<?php if(0):?>
			<a class="config" data-toggle="modal" href="#portlet-config"></a>
			<a class="reload" href="javascript:;"></a>
			<a class="remove" href="javascript:;"></a>
			<?php endif?>
		</div>
	</div>

	<div class="portlet-body" style="overflow:auto">
	<?php echo $tree_data2?>
	</div>

</div> <!-- portlet box -->
<?php endif?>
