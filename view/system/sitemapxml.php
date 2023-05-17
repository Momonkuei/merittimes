<?php
header('Content-type: text/xml');

$tmps = array();
if(!empty($data[$ID])){
	$tmps = explode("\n",var_export($data[$ID],true));
}
//var_dump($tmps);

$url = FRONTEND_DOMAIN;
?>
<?php echo '<'?><?php echo '?'?>xml version="1.0" encoding="UTF-8" ?<?php echo '>'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
	<loc><?php echo $url?>/</loc>
	<?php if(0):?><?php // Jonathan 12/25早上說要換成當天的?>
		<lastmod><?php echo date('Y-m-d', time()-86400*date('w')+(date('w')>0?86400:-6*86400))?><?php // 本周第二天，第一天是星期日?></lastmod>
	<?php endif?>
	<lastmod><?php echo date('Y-m-d')?></lastmod>
	<changefreq>daily</changefreq>
	<priority>1.0</priority>
</url>

<?php if($tmps and count($tmps) > 0):?>
	<?php foreach($tmps as $k => $v):?>
		<?php if(preg_match('/\'url\'\ \=\>\ \'(.*)\'\,/', $v, $matches)):?>
<url>
	<loc><?php echo $url?>/<?php echo $matches[1]?></loc>
	<lastmod><?php echo date('Y-m-d')?></lastmod>
	<changefreq>daily</changefreq>
	<priority>0.8</priority>
</url>
		<?php endif?>
	<?php endforeach?>
<?php endif?>

</urlset><?php die?>
