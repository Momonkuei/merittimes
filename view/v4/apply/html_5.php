<?
include _BASEPATH . '/../source/apply/post_5.php';
?>

<section class="sectionBlock" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">期末成果</h1> -->
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
                    <div class="btn-apply-1 btn-text active">
                        5.期末成果
                    </div>
                </a>
            </div>
            <div class="btn-group ">
                <a href="apply_tw_6.php">
                    <div class="btn-apply-2 btn-text">
                        開創教師帳號
                    </div>
                </a>
                <a href="apply_tw_7.php">
                    <div class="btn-apply-2 btn-text">
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

            <div class="application-steps-mark">
                <div class="mark-number">五</div>
                <div class="mark-title">
                    專案步驟
                </div>
            </div>
            <div class="application-form-title title-bot-border ">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div>
                    上傳期末成果
                    <!-- <small>請填寫以下表格，<span>「＊」</span>為必填</small> -->
                </div>
            </div>
            <div class="application-form ">
                <form action="" method="POST" name="applicationForm" id="form_data" class="row cont_form" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateForm()">
                    <div class="form_group col-lg-6">
                        <label class="must-label">學校全銜<span>：</span>
                        </label>
                        <input type="text" id="name" name="name" placeholder="" value="<?= $_SESSION['member_data']['school_name'] ?>" disabled="disabled">
                    </div>
                    <div class="form_group col-lg-6">
                        <label class="must-label">申請期別 <span>：</span>
                        </label>
                        <!-- <div class="selection-radio">
                            <div class="select">
                                <span class="placeholder">請選擇</span>
                                <ul>
                                    <li>112學年度第1學期</li>
                                    <li>112學年度第2學期</li>
                                    <li>113學年度第1學期</li>
                                    <li>113學年度第2學期</li>
                                </ul>
                            </div>
                        </div> -->
                        <select name="cars" id="cars" class="select-radio" onchange="cheange_data(this)">
                            <option value="">請選擇</option>
                            <? if (!empty($writeplan_array)) {
                                foreach ($writeplan_array as $k => $v) { ?>
                                    <option value="<?= $v['id'] ?>" <?= (isset($_GET['writeplan_id']) && $_GET['writeplan_id'] == $v['id'] ? 'selected' : '') ?>><?= $v['semester_name'] ?></option>
                            <? }
                            } ?>
                        </select>
                    </div>
                    <div class="form_group col-lg-12">
                        <label class="must-label">期末檔案上傳<span>：</span>
                        </label>

                        <div class="row file-input-group">
                            <? if (!empty($fiel_list)) {
                                foreach ($fiel_list as $k => $v) { ?>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class='file-input <?=(!empty($v['file1'])?' -chosen ':'')?>'>
                                            <?if(empty($end_data) || $end_data=='0000-00-00' || $end_data>date('Y-m-d')){?>
                                                <input name='files<?=$v['id']?>' type='file'>
                                                <span class='button'>選擇檔案</span>
                                                <span class='label' data-js-label style="display:none">未選擇檔案</span>
                                            <?}?>
                                            <?if(!empty($v['file1'])){?>
                                                <?if(empty($end_data) || $end_data=='0000-00-00' || $end_data>date('Y-m-d')){?>
                                                    <a class='filed-name' href="<?=$data_path.'/'.$v['file1'] ?>" target="_blank" style="color:red;"><?= $v['file1'] ?></a>
                                                
                                                    <a href="javascript:;" class="delete-file" data-table="writeplan_file" data-field="file1" data-name="<?=$v['file1']?>" data-id="<?=$v['id']?>" onclick="dele_file(this)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                <?}?>
                                            <?}?>

                                        </div>
                                    </div>
                                <?}
                            }?>
                            <?if(empty($end_data) || $end_data=='0000-00-00' || $end_data>date('Y-m-d')){?>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class='file-input'>
                                    <input name='files[]' type='file'>
                                    <span class='button'>選擇檔案</span>
                                    <span class='label' data-js-label>未選擇檔案</span>
                                </div>
                            </div>
                            <?}?>
                        </div>
                    </div>
                    <?if(empty($end_data) || $end_data=='0000-00-00' || $end_data>date('Y-m-d')){?>
                    <div class="btn-group sub_button">
                        <button class="btn-operate btn-text more-file" type="button">
                            上傳更多
                        </button>
                        <button class="btn-register btn-text">
                            送出
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </button>
                    </div>
                    <?}?>
                </form>
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->


<script m="body_end">
    //檔案刪除
    function dele_file(e){
        var code="<?=$_SESSION['member_data']['code']?>";
        var url="<?= (isset($data_path) && !empty($data_path) ? $data_path : '') ?>";
        if(url!=''){
            var return_url=url;
        }else{
            return_url='assets/file/writeplan/'+code+'/'+$('#cars').val();
        }
        if($(e).data('id')!='' && $(e).data('name')!=''){
            if (confirm("是否要刪除?") == true) {
                let id = $(e).data('id');
                let table = $(e).data('table');
                let name = $(e).data('name');
                let field = $(e).data('field');
                $.ajax({
                    type: "POST",
                    data: {
                        'type': 'file_del',
                        'name': name,
                        'id': id,
                        'table': table,
                        'field': field,
                        'url': return_url,
                    },
                    url: 'apply_post.php',
                    success: function(response) {
                        console.log(response);
                        txt = response.split('@@');
                        if (txt[0] != 1) {
                            alert(txt[1]);
                        }else{
                            alert('刪除成功!');
                            window.location.href="/apply_<?=$this->data['ml_key']?>_5.php?writeplan_id="+$('#cars').val();
                        }
                    }
                }); // ajax
            }
        }
    }
    // $('.delete-file').click(function() {
    //     console.log('delete');
    // })
    $(document).ready($(function() {
        const moreFileBtn = $('.more-file');
        const fileInputELe = `
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class='file-input'>
                                    <input name=files[] type='file'>
                                    <span class='button'>選擇檔案</span>
                                    <span class='label' data-js-label>未選擇檔案</span>
                                </div>
                            </div>
                        `;
        let fileGroup = 3;
        // 添加 ht  ml 結構
        moreFileBtn.click(function() {
            if (fileGroup < 12) {
                $('.file-input-group').append(fileInputELe);
                fileGroup++;
                // 執行在script 的 function 讀取檔名並且改名稱
                fileLoad();

                // console.log(fileGroup);
            } else {
                alert("已達上傳上限。");
            }
        })
    }))
    function validateForm() {
        var is_stop = false;
        $check_array = ['cars'];
        var x = $("#form_data").serializeArray();
        if (x[0].value == '') {
            alert('請選擇學期');
            is_stop = true;
        }
        if (is_stop == true) {
            // 不讓表單送出
            return false;
        }
    }
    function cheange_data(e){
        if($(e).val()!=''){
            $.ajax({
                type: "POST",
                data: {
                    'type': 'get_file_list',
                    'writeplan_id': $(e).val(),
                    'url': '<?= (isset($data_path) && !empty($data_path) ? $data_path : '') ?>'
                },
                url: 'apply_post.php',
                success: function(response) {
                    // console.log(response);
                    txt = response.split('@@');
                    if (txt[0] != 1) {
                        alert(txt[1]);
                        $('.file-input-group').html(txt[2]);
                        if(txt[3]!='big'){
                            $('.sub_button').hide();
                        }else{
                            $('.sub_button').show();
                        }
                    }else{
                        $('.file-input-group').html(txt[1]);
                        if(txt[2]!='big'){
                            $('.sub_button').hide();
                        }else{
                            $('.sub_button').show();
                        }
                            
                    }
                    fileLoad();
                }
            }); // ajax
        }
    }
</script>