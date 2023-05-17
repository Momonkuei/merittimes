<?
    $nowurl="";
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
        $nowurl = "https://";  
    }         
    else{
        $nowurl = "http://";   
    }
    $nowurl.= urlencode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);   
?>
<!-- <div class="widgetSocial">
	<a href="https://www.facebook.com/sharer/sharer.php?u=<?=$nowurl;?>" target="_blank" class="cowfb">
		<img src="images/social01.svg" alt="">
	</a>
	<a href="https://line.naver.jp/R/msg/text/?<?=$nowurl;?>" target="_blank" class="cowline">
		<img src="images/social02.svg" alt="">
	</a>
	 <a href="javascript:void(0)" onclick="window.print();" class="print">
		<img src="images/social03.svg" alt="">
	</a>
	<a class="btn_clipboard" onclick="copylink()">
		<img src="images/social04.svg" alt="">
	</a>
</div> -->
<?php if(isset($data[$ID])):?>
	<?php $product = $data[$ID]['items']?>
	<?php $images_big = $data[$ID]['big']?>
	<?php $images_small = $data[$ID]['small']?>

	<meta property="og:url"           content="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" m="head_end" />
	<meta property="og:type"          content="website"  m="head_end" />
	<meta property="og:title"         content="<?php echo $product['name']?>"  m="head_end" />
	<meta property="og:description"   content="<?php echo strip_tags($product['detail'])?>"  m="head_end"  />
	<?php if($images_big[0]['pic']!=''):?>
		<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN.'/'.$images_big[0]['pic']?>"  m="head_end"  />
	<?php else:?>
		<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN?>/images/fb_share.jpg" m="head_end"/>
	<?php endif?>

	<div class="prod_blk2 ">
	    <div class="row prod_slider">
            <?php echo "<div class='col-12 prod_slider_title'>".$product['name']."</div>"?>
            <div class="col-lg-12">
                <div class="slider-for">
                    <?php if(isset($images_small)):?>
                        <?php foreach($images_small as $k => $v):?>
                            <div>
                                <div class="<?php echo $data['image_ratio'];//變數在source/core.php?> "><img src="<?php echo $v['pic']?>" alt="<?php echo $v['name']?>"></div>
                            </div>
                        <?php endforeach?>
                    <?php endif?>
                </div>
            </div>
            
        </div>
    </div>
    <div class="tagbox">
        <div ><!-- 食材 -->
            
            <?
                $Ingredientsgroup=$this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id=:class_id' ,array(':ml_key'=>$this->data['ml_key'],':type'=>'productingredientsgroup',':class_id'=>$product['id']))->order('sort_id asc')->queryAll();
                if(!empty($Ingredientsgroup)){
                    echo "<div class='col-12'></div>";
                    foreach($Ingredientsgroup as $Ingredientsgroups){?>
                        <div class="mgb5 outbox">
                            <div class="col-12 outboxtopic"><?=$Ingredientsgroups['topic'];?></div>
                            <div class="row col-12 mb-0 pb-0" >
                            <?
                                $Ingredients = $this->db->createCommand()->from('html')->where(' ml_key=:ml_key and type=:type and class_id=:class_id' ,array(':ml_key'=>$this->data['ml_key'],':type'=>'productingredients',':class_id'=>$Ingredientsgroups['id']))->order('sort_id asc')->queryAll();
                                foreach($Ingredients as $Ingredientsrow){
                                    $haveurl="";
                                    if(!empty($Ingredientsrow["url1"])){
                                        $haveurl="<div class='col-6'><a href='".$Ingredientsrow["url1"]."' target='_blank'>".$Ingredientsrow["topic"]."</a></div>";
                                    }
                                    else{
                                        $haveurl= "<div class='col-6'>".$Ingredientsrow["topic"]."</a></div>";
                                    }
                                    echo "<div class='row col-6 mb-0 pb-0 borderLineDotted' >
                                                ".$haveurl."
                                                <div class='col-6'>".$Ingredientsrow["detail"]."</div>
                                        </div>";
                                }
                            ?>
                            </div>
                        </div>
                    <?}
                }
                ?>
        </div>			    

    

        <div><!--步驟 -->
            <?
                
                $step = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id=:class_id' ,array(':ml_key'=>$this->data['ml_key'],':type'=>'productstep',':class_id'=>$product['id']))->order('sort_id asc')->queryAll();
                if(!empty($step)){
                    echo '<div class="newsList col-12"><div class="itemList newsListType2 Bbox_in_1c newsListType7">';
                    foreach($step as $steps){
                        echo '
                            <div class="item process">
                                <a href="javascript:; ">
                                    <div class="'.$data['image_ratio'].'">
                                        <img src="/_i/assets/upload/productstep/'. $steps['pic1'].'">
                                    </div>
                                </a>
                                <a ">
                                    <div class="itemTitle"> <span>'.$steps['topic'].'</span> </div>
                                    <div class="itemContent" data-txtlen="150">'.$steps['detail'].'</div>
                                </a>
                            </div>';
                    }
                    echo '</div></div>';
                }
            ?>
        </div>
        
        <div class="row col-12 listTag"><!--tag -->
        <ul class="listTag">
            
            
            <?
                $tagary=explode(",",$product["other6"]);
                foreach($tagary as $tagarys){
                    if(!empty($tagarys)){
                        $step = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and id=:id' ,array(':ml_key'=>$this->data['ml_key'],':type'=>'tagpage',':id'=>$tagarys))->order('sort_id asc')->queryRow();
                        // echo '<div class="col-2"><input class="tagbtn" type="button" value="'.$step["topic"].'" onclick="searchtag('."'".$step["topic"]."','".$step["id"]."'".')" /></div>';
                        // echo '<li><input class="tagbtn" type="button" value="'.$step["topic"].'" onclick="searchtag('."'".$step["topic"]."','".$step["id"]."'".')"></li>';
                        echo '<li><input class="tagbtn" type="button" value="'.$step["topic"].'" ></li>';
                    }
                }
            ?>
        </ul>
            
            <form action="searchpage_<?=$this->data['ml_key'];?>.php" method="POST" id="tagform" target="_blank">
                <input type="hidden" id="sendtag" name="sendtag" />
                <input type="hidden" id="sendtagcode" name="sendtagcode" />
            </form>
        </div>
    </div>

    

    

<?php endif?>
<script>
    function searchtag(tag,tagcode){
        $("#sendtag").val(tag);
        $("#sendtagcode").val(tagcode);
        $("#tagform").submit();
        // alert($("#sendtag").val());
    }

    function copylink(){
        var url = document.location.href;
        Document.execCommand(url)
        alert("Copied");
    }

</script>
