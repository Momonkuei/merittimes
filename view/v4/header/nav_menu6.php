<?php //.navMenuStyle_line選單左右線條，.navMenuStyle_circle 圓角選單，.navIconLt選單icon在左方，.navIconTop選單icon在上方，.navIconHover選單icon Hover效果?>
<?php //.hoverEffect_01選單特效-底線由下至上浮出，.hoverEffect_02選單特效-底線由中間展開，.hoverEffect_03選單特效-底線由左邊展開 navMenuStyle_line navIconLt hoverEffect_01?>
<?php if(1):?>
<ul class="navMenu  navIconLt hoverEffect_01">
  <?php if(isset($data[$ID])):?>
      <?php foreach($data[$ID] as $k => $v):?>
      <li <?php if(isset($v['attr1']) and $v['attr1'] != ''):?><?php echo $v['attr1']?><?php endif?> ><a <?php if(isset($v['attr2']) and $v['attr2'] != ''):?><?php echo $v['attr2']?><?php endif?> ><?php if(isset($v['other9'])){ echo $v['other9'];} //這段在節點移動的部分是多餘的，先註解看看 //2022-01-04 Jane會使用到icon，由other7 改 other9 ?><span><?php echo $v['name']?></span></a>       
        <?php if(isset($v['child']) && (isset($v['has_child']) && $v['has_child']==true)):?>
           <ul class="<?php echo $v['anchor_class']?>" >
               <?php foreach($v['child'] as $kk => $vv):?>               
                <li <?php if(isset($vv['attr1']) and $vv['attr1'] != ''):?><?php echo $vv['attr1']?><?php endif?> ><a <?php if(isset($vv['attr2']) and $vv['attr2'] != ''):?><?php echo $vv['attr2']?><?php endif?>><span><?php echo $vv['name']?></span></a>
                    <?php if(isset($vv['child'])):?>
                      <ul>
                      <?php foreach($vv['child'] as $kkk => $vvv):?>
                              <li <?php if(isset($vvv['attr1']) and $vvv['attr1'] != ''):?><?php echo $vvv['attr1']?><?php endif?>><a <?php if(isset($vvv['attr2']) and $vvv['attr2'] != ''):?><?php echo $vvv['attr2']?><?php endif?>><span><?php echo $vvv['name']?></span></a></li>                            
                      <?php endforeach?>
                      </ul>
                    <?php endif?>
                </li>
              <?php endforeach?>
           </ul>
        <?php endif?>       
    </li>
    <?php endforeach?>     
  <?php endif?>
</ul>
<?php endif?>


<?php if(0):?>
<ul class="navMenu navMenuStyle_line navIconLt hoverEffect_01">
 <li class="moreMenu multiMenu">
  <a href=""><span>關於我們</span></a>
  <!--寬版子選單-->
  <!--.wide需搭配.inner使用，最外層li需有.multiMenu-->
  <ul class="inner wide">
   <li>
    <a class="menuTitle" href=""><span>商品分類1</span></a>
    <ul>
     <li><a href=""><span>商品分類1-1</span></a></li>
     <li><a href=""><span>商品分類1-2</span></a></li>
     <li><a href=""><span>商品分類1-3</span></a></li>
     <li><a href=""><span>商品分類1-4</span></a></li>
     <li><a href=""><span>商品分類1-5</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類2</span></a>
    <ul>
     <li><a href=""><span>商品分類2-1</span></a></li>
     <li><a href=""><span>商品分類2-2</span></a></li>
     <li><a href=""><span>商品分類2-3</span></a></li>
    </ul>
   </li>
  </ul>
  <!--寬版子選單 End-->
 </li>
 <li class="moreMenu multiMenu">
  <a href="products.php?type=1"><span>商品介紹</span></a>
  <!--寬版子選單-->
  <!--.wide需搭配.inner使用，最外層li需有.multiMenu-->
  <ul class="inner wide">
   <li>
    <a class="menuTitle" href=""><span>商品分類1</span></a>
    <ul>
     <li><a href=""><span>商品分類1-1</span></a></li>
     <li><a href=""><span>商品分類1-2</span></a></li>
     <li><a href=""><span>商品分類1-3</span></a></li>
     <li><a href=""><span>商品分類1-4</span></a></li>
     <li><a href=""><span>商品分類1-5</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類2</span></a>
    <ul>
     <li><a href=""><span>商品分類2-1</span></a></li>
     <li><a href=""><span>商品分類2-2</span></a></li>
     <li><a href=""><span>商品分類2-3</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類3</span></a>
    <ul>
     <li><a href=""><span>商品分類3-1</span></a></li>
     <li><a href=""><span>商品分類3-2</span></a></li>
     <li><a href=""><span>商品分類3-3</span></a></li>
     <li><a href=""><span>商品分類3-4</span></a></li>
     <li><a href=""><span>商品分類3-5</span></a></li>
     <li><a href=""><span>商品分類3-6</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類4</span></a>
    <ul>
     <li><a href=""><span>商品分類4-1</span></a></li>
     <li><a href=""><span>商品分類4-2</span></a></li>
     <li><a href=""><span>商品分類4-3</span></a></li>
     <li><a href=""><span>商品分類4-4</span></a></li>
     <li><a href=""><span>商品分類4-5</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類5</span></a>
    <ul>
     <li><a href=""><span>商品分類5-1</span></a></li>
     <li><a href=""><span>商品分類5-2</span></a></li>
     <li><a href=""><span>商品分類5-3</span></a></li>
     <li><a href=""><span>商品分類5-4</span></a></li>
     <li><a href=""><span>商品分類5-5</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類6</span></a>
    <ul>
     <li><a href=""><span>商品分類6-1</span></a></li>
     <li><a href=""><span>商品分類6-2</span></a></li>
     <li><a href=""><span>商品分類6-3</span></a></li>
     <li><a href=""><span>商品分類6-4</span></a></li>
     <li><a href=""><span>商品分類6-5</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類7</span></a>
    <ul>
     <li><a href=""><span>商品分類7-1</span></a></li>
     <li><a href=""><span>商品分類7-2</span></a></li>
     <li><a href=""><span>商品分類7-3</span></a></li>
     <li><a href=""><span>商品分類7-4</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類8</span></a>
    <ul>
     <li><a href=""><span>商品分類8-1</span></a></li>
     <li><a href=""><span>商品分類8-2</span></a></li>
     <li><a href=""><span>商品分類8-3</span></a></li>
     <li><a href=""><span>商品分類8-4</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類9</span></a>
    <ul>
     <li><a href=""><span>商品分類9-1</span></a></li>
     <li><a href=""><span>商品分類9-2</span></a></li>
     <li><a href=""><span>商品分類9-3</span></a></li>
     <li><a href=""><span>商品分類9-4</span></a></li>
     <li><a href=""><span>商品分類9-5</span></a></li>
    </ul>
   </li>
   <li>
    <a class="menuTitle" href=""><span>商品分類10</span></a>
    <ul>
     <li><a href=""><span>商品分類10-1</span></a></li>
     <li><a href=""><span>商品分類10-2</span></a></li>
     <li><a href=""><span>商品分類10-3</span></a></li>
     <li><a href=""><span>商品分類10-4</span></a></li>
     <li><a href=""><span>商品分類10-5</span></a></li>
    </ul>
   </li>
  </ul>
  <!--寬版子選單 End-->
 </li>
 <li><a href=""><span>最新消息</span></a></li>
 <li><a href=""><span>影片專區</span></a></li>
 <li><a href=""><span>認證技術</span></a></li>
 <li><a href=""><span>檔案下載</span></a></li>
 <li><a href=""><span>聯絡我們</span></a></li>
</ul>

<?php endif?>