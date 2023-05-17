<?php if(!stristr($this->data['router_method'],'class_') && !stristr($this->data['router_method'],'classout_') ):?>
  <div class="breadcrumb">
    <?
    //找不到在哪邊轉成英文 直接在這裡轉回中文
    if($this->data['router_method'] == 'guestlogin'){
      $data[$ID][1]=array('name'=>'登入','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
    }
    ?>
    <ul>
    <?php if(isset($data[$ID])):?>
      <?php foreach($data[$ID] as $k => $v):?>
        <li><a <?php if(isset($v['url']) and $v['url'] != ''):?> href="<?php echo $v['url']?>" <?php endif?> ><?php echo $v['name']?></a></li>
      <?php endforeach?>
    <?php endif?>
  <?php if(0):?>
    <li><a href="index.html">HOME</a></li>
    <li><a href="">PRODUCT</a></li>
    <li><a href="">CATELOG 1</a></li>
    <li><a>ABC</a></li>
  <?php endif?>
  </ul>
  </div><!-- .pageNumber -->
<?php endif?>
