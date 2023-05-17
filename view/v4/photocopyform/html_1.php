<?
//該計畫資料
$writeplan_array=$this->cidb->where('id',$_GET['writeplan_id'])->get('writeplan')->row_array();
//班級資料
$writeplan_class=$this->cidb->like('writeplan_id',','.$_GET['writeplan_id'].',')->where('is_enable',1)->order_by('create_time')->get('writeplan_class')->result_array();
?>


<section class="" data-about="1">
  <div class="container">
    <div class="form-border copy-form">
      <div class="application-form-details">
        <div class="step_b">         
          <div class="responsive_tbl">
            <table class="tableList tableList-check">
              <thead>
                <tr>
                  <th>年級/班別</th>
                  <th>教師姓名</th>
                  <th>學生數</th>
                  <th>E-mail</th>
                </tr>
              </thead>
              <tbody class="print_class_list">
                <?if(!empty($writeplan_class)){
                foreach($writeplan_class as $k => $v){?>
                  <tr>
                    <td><?=$v['class_name']?></td>
                    <td><?=$v['teacher_name']?></td>
                    <td><?=$v['student_num']?></td>
                    <td><?=$v['email']?></td>
                  </tr>
              <?}
              }?>
              </tbody>
            </table>
          </div>
          <div class="col-12 table-footer check-footer" >
            <div class="row">
              <div class="col-8 col-lg-8">
                <div class="row label-group">
                  <div class="col-4 col-lg-4 ">
                    <div class="footer-label print_all_class">
                      總計： <span> <?=(!empty($writeplan_array['class_name'])?$writeplan_array['class_name']:'0')?></span> 班
                    </div>
                  </div>
                  <div class="col-4 col-lg-4">
                    <div class="footer-label print_all_num">
                      人數： <span> <?=(!empty($writeplan_array['student_name'])?$writeplan_array['student_name']:'0')?></span> 人
                    </div>
                  </div>
                  <div class="col-4 col-lg-4">
                    <div class="footer-label print_report_num">
                      實際報份： <span> <?=(!empty($writeplan_array['actual_num'])?$writeplan_array['actual_num']:'0')?></span> 份
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4 col-lg-4">
                <div class="row label-group">
                  <div class="footer-label application-form check-label print_apply_num">
                    希望報份： <span> <?=(!empty($writeplan_array['apply_num'])?$writeplan_array['apply_num']:'0')?></span> 份
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 table-footer check-footer">
            <div class="row">
              <div class="col-12">
                <div class="row label-group">
                  <div class="col-4 col-lg-4 ">
                    <div class="footer-label">
                      校長：
                    </div>
                  </div>
                  <div class="col-4 col-lg-4">
                    <div class="footer-label">
                      主任：
                    </div>
                  </div>
                  <div class="col-4 col-lg-4">
                    <div class="footer-label">
                      承辦人：
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="title-bot-border col-lg-12"></div>
      </div>

    </div>





  </div><!-- .container -->
</section><!-- .sectionBlock -->
