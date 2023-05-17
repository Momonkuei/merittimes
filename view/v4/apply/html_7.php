<?
include _BASEPATH . '/../source/apply/post_7.php';
?>
<section class="sectionBlock" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">成果預覽</h1> -->
        <div class="application-steps">
            <div class="btn-group ">
                <a href="apply_tw_1.php">
                    <div class="btn-apply-1 btn-text ">
                        1.填寫計畫
                    </div>
                </a>
                <a href="apply_tw_2.php">
                    <div class="btn-apply-1 btn-text ">
                        2.班級申請
                    </div>
                </a>
                <a href="apply_tw_3.php">
                    <div class="btn-apply-1 btn-text">
                        3.上傳申請
                    </div>
                </a>
                <a href="apply_tw_4.php">
                    <div class="btn-apply-1 btn-text">
                        4.審查進度
                    </div>
                </a>
                <a href="apply_tw_5.php">
                    <div class="btn-apply-1 btn-text">
                        5.期末成果
                    </div>
                </a>
            </div>
            <div class="btn-group ">
                <a href="apply_tw_6.php">
                    <div class="btn-apply-2 btn-text ">
                        開創教師帳號
                    </div>
                </a>
                <a href="apply_tw_7.php">
                    <div class="btn-apply-2 btn-text active">
                        成果預覽
                    </div>
                </a>
                <a href="apply_tw_8.php">
                    <div class="btn-apply-2 btn-text">
                        修改資料
                    </div>
                </a>
            </div>
        </div>
        <div class="form-border">
            <div class="application-form-details form-border-no-title ">
                <div class="top-function-column">
                    <form class="cont_form" method="get" action="apply_<?=$this->data['ml_key']?>_7.php">
                        <div class='add-area'>                       
                            <div class="class-selection">
                                <span class="title">申請期別：</span>

                                <select name="cars" id="cars" class="select-radio">
                                    <option value="">請選擇級別</option>
                                    <?if(!empty($semester)){
                                        foreach($semester as $k => $v){?>
                                            <option value="<?=$k?>" <?=(isset($_GET['cars']) && !empty($_GET['cars']) && $_GET['cars']==$k?'selected':'')?>><?=$v?></option>
                                        <?}
                                    }?>
                                </select>
                            </div>
                            <div  class="btn-group">
                                <button type="submit" class="btn-operate btn-text">
                                    搜尋
                                </button>

                                <button onclick="clearserach()" type="button" class="btn-operate btn-text">清除</button>
                            </div>
                        </div>
                    </form>    
                </div>
                <div class="responsive_tbl">
                    <table class="tableList">
                        <thead>
                            <tr>
                                <th>創立日期</th>
                                <th>教師姓名</th>
                                <th>類別</th>
                                <th>期別</th>
                                <th>班級</th>
                                <th>更新日期</th>
                                <th>觀看網頁</th>
                            </tr>
                        </thead>
                        <?if(!empty($account_data)){?>
                        <tbody>
                            <?foreach($account_data as $k => $v){?>
                                <tr>
                                    <td>
                                        <?=date('Y-m-d H:i:s', strtotime($v['create_time']))?>
                                    </td>
                                    <td><?=$v['teacher_name']?></td>
                                    <td><?=$v['other3']?></td>
                                    <td>
                                         <?if(isset($v['other7']) && $v['other7']!=null){
                                            foreach($v['other7'] as $kk => $vv){
                                                if(isset($semester[$vv]) && !empty($semester[$vv])){
                                                    echo $semester[$vv].'<br>';
                                                }
                                                
                                            }
                                        }?>
                                    </td>
                                    <td><?=$v['class_name']?></td>
                                    <td>
                                        <?=($v['update_time']!='0000-00-00 00:00:00'?date('Y-m-d H:i:s', strtotime($v['update_time'])):'')?>
                                    </td>
                                    <td>
                                        <?if(!isset($v['no_data'])){?><a href="classout_tw_1.php?class_id=<?=$v['id']?>" target="_blank">連結</a><?}?>
                                    </td>
                                </tr>
                            <?}?>
                        </tbody>
                        <?}?>
                    </table>
                </div>
                <?if(!empty($pageRecordInfo['pagination'])){?>
                <div class="pageNumber">
                    <ul>
                        <?php if(isset($pageRecordInfo['prev_url'])):?>
                            <?php if($pageRecordInfo['prev_url'] != ''):?>
                                <li class="prev"><a href="<?php echo $pageRecordInfo['prev_url']?>"><?php echo t('Prev','en')?></a></li>
                            <?php else:?>
                                <li class="prev disabled"><a href="javascript:;"><?php echo t('Prev','en')?></a></li>
                            <?php endif?>
                        <?php endif?>
                        <li><?php echo $pageRecordInfo['pagination']['control']['now']?></li>
                        <li>/</li>
                        <li><?php echo $pageRecordInfo['pagination']['control']['total']?></li>
                        <?php if(isset($pageRecordInfo['next_url'])):?>
                            <?php if($pageRecordInfo['next_url'] != ''):?>
                                <li class="next"><a href="<?php echo $pageRecordInfo['next_url']?>"><?php echo t('Next','en')?></a></li>
                            <?php else:?>
                                <li class="next disabled"><a href="javascript:;"><?php echo t('Next','en')?></a></li>
                            <?php endif?>
                        <?php endif?>
                    </ul>
                </div>
                <?}?>
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->

<script m="body_end">
    function clearserach(){
        window.location.href='apply_<?=$this->data['ml_key']?>_7.php';
    }
</script>