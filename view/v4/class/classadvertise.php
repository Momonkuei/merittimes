<?
$classadvertise_list = $this->cidb->where('type', 'classadvertise')->where('is_enable', 1)->order_by('sort_id')->get('html')->result_array();
if (!empty($classadvertise_list)) {
?>
    <div class="news">
        <ul class="news-list">
            <? foreach ($classadvertise_list as $K => $v) { ?>
                <li><?= (!empty($v['url1']) ? '<a href="' . $v['url1'] . '" target="_blank">' : '') ?><?= $v['topic'] ?><?= (!empty($v['url1']) ? '</a>' : '') ?></li>
            <? } ?>
        </ul>
    </div>
<? } ?>

<?
$carousel_list = $this->cidb->where('type', 'carousel')->where('is_enable', 1)->order_by('sort_id')->get('html')->result_array();
if (!empty($carousel_list)) {
?>
    <div class="ad-photo-board ">
        <div class="imgBox v4_animate fadeLeft delay_06 overlapSlide">
            <? foreach ($carousel_list as $k => $v) { ?>
                <a <?=(!empty($v['url1'])?'href="'.$v['url1'].'" target="_blank"':'')?>>
                    <img src="_i/assets/upload/carousel/<?= $v['pic1'] ?>" alt="">
                </a>
            <? } ?>
        </div>
    </div>
<? } ?>