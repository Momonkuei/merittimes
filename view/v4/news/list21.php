<?php if (isset($data[$this->data['router_method'] . '_describe']) && $data[$this->data['router_method'] . '_describe'] != '') : //這塊給需要顯示簡述的地方
?>
    <div><?php echo $data[$this->data['router_method'] . '_describe'] ?></div>
<?php endif ?>

<!-- 動畫說明 -->

<!-- 動畫注入原則 -->
<!--  v4_animate fadeRight delay_03 -->
<!-- 一個動畫的行程都需要上方的class -->

<!-- v4_animate 隱藏 -->

<!-- fadeRight 移動方向 Right 由左至右 -->

<!-- delay_03 延遲秒數 例 _03 => 0.3s -->


<div class="newsList  newsListType21">
    <div class="row ">
        <ul class="newsListType21_lists">
                    <?php if (isset($data[$ID])) : ?>
                        <?php foreach ($data[$ID] as $k => $v) : ?>
                    <li>
                        <div class="col-12 v4_animate fadeRight delay_03">
                            <div class="item imgHoverBox">
                                <a href="<?php echo $v['url1'] ?>">
                                    <div class="time_date">
                                        <div class="newsListType21_list_imgBox">
                                            <img src="<?php echo $v['pic'] ?>">
                                        </div>
                                    </div>
                                    <div class="itemTitle" ><?php echo $v['name'] ?></div>
                                    <div class="itemContent" ><?php echo $v['content'] ?></div>
                                </a>
                            </div><!-- .item -->
                        </div>
                    </li>
                    <?php endforeach ?>
                <?php endif ?>
                </ul>



    </div>

</div><!-- .newsList -->