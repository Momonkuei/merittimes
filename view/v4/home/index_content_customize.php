<?php if(1):?><!-- head_(如果有alert，請關掉並刪掉括號內容)start -->
<?php
// http://網站的網址/_i/backend.php?r=datasource/update&param=v4049
// 首頁-自定義區塊 - html:indexcustomize
// 
$layoutv3_datasource_id = 4049;
include GGG_BASEPATH.'../../layoutv3/dom5/datasource.php';
// var_dump($content);
// $row = $content;
$this->data['html_indexcustomize_4049'] = $content;
$this->data['index_customize'] = $content; // 好記的名稱

$html_indexcustomize = '';

if(isset($this->data['html_indexcustomize_4049']) and count($this->data['html_indexcustomize_4049']) > 0){
    foreach($this->data['html_indexcustomize_4049'] as $k => $v){
        // 客製欄位使用
        // blha blha 
        if($v['detail']!=''){
            $html_indexcustomize = $v['detail'];
        }
        // $this->data['html_indexcustomize_4049'][$k] = $v;
    }
}
// var_dump($this->data['html_indexcustomize_4049']);
// $data[$ID] = $this->data['html_indexcustomize_4049'];
?>
<?php if(0)://V1第二版的無限層資料輸出範例，如果想要看看，?>
<ul l="layer" ls="html_indexcustomize_4049">
	<li l="list" ><a href="#">{/name/}{/topic/}</a>
		{/child/}
	</li>
	<ul l="box">{split}</ul>
</ul>
<?php endif?>
<?php if(isset($this->data['html_indexcustomize_4049']) and count($this->data['html_indexcustomize_4049']) > 0):?>
    <?php foreach($this->data['html_indexcustomize_4049'] as $k => $v):?>
        <?php // echo $v['id']?>
    <?php endforeach?>
<?php endif?>
<?php endif?><!-- head_(如果有alert，請刪掉括號內容)start -->

<?php echo $html_indexcustomize?>