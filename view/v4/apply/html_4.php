<?
include _BASEPATH . '/../source/apply/post_4.php';
?>
<section class="sectionBlock" data-about="1">
    <div class="container">
        <!-- <h1 class="text-center apply-title">審查進度</h1> -->
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
                    <div class="btn-apply-1 btn-text active">
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
                <div class="mark-number">四</div>
                <div class="mark-title">
                    專案步驟
                </div>
            </div>
            <div class="application-form-title title-bot-border  ">
                <img src="images_v4/icon/titleIcon.svg" alt="apply-title-icon">
                <div>
                    審查進度
                    <!-- <small>請填寫以下表格，<span>「＊」</span>為必填</small> -->
                </div>
            </div>
            <!--申請明細  -->
            <div class="application-form-details">
                <div class="responsive_tbl">
                    <table class="tableList">
                        <thead>
                            <tr>
                                <th>申請學期</th>
                                <th>送審日期</th>
                                <th>希望報份</th>
                                <th>審核結果</th>
                                <th>核可報份</th>
                                <th>審查日期</th>
                                <th>核章檔案上傳</th>
                                <th>期末檔案上傳</th>
                                <th>詳細閱讀</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? if (!empty($writeplan_array)) {
                                foreach ($writeplan_array as $k => $v) { ?>
                                    <tr>
                                        <td>
                                            <?= $semester[$v['semester']] ?>
                                        </td>
                                        <td><?= ($v['submission_date'] == '0000-00-00 00:00:00' ? '---' : $v['submission_date']) ?></td>
                                        <td><?=($v['apply_num']>0?$v['apply_num']:'-')?></td>
                                        <td><?= (!empty($v['a_results']) ? $v['a_results'] : '未審核') ?></td>
                                        <td><?=($v['a_results'] != '核可'?'-':$v['approved_num'])?></td>
                                        <td><?= ($v['review_time'] == '0000-00-00 00:00:00' ? '---' : $v['review_time']) ?></td>
                                        <td>
                                            <? if ($v['a_results'] != '核可') { ?><a href="apply_<?= $this->data['ml_key'] ?>_3.php?writeplan_id=<?= $v['id'] ?>"><i class="fa fa-upload" aria-hidden="true"></i><?= (!empty($v['file3']) ? '前往更新' : '前往上傳') ?></a><? } else { ?>已審核無法修改<? } ?>
                                        </td>
                                        <td>
                                            <? if ($v['a_results'] == '核可') { ?><a target="_blank" href="apply_<?= $this->data['ml_key'] ?>_5.php?writeplan_id=<?= $v['id'] ?>"><i class="fa fa-upload" aria-hidden="true"></i>前往上傳</a><? } else { ?>未通過審核無法上傳<? } ?>
                                        </td>
                                        <td>
                                            <a href="apply_<?= $this->data['ml_key'] ?>_9.php?writeplan_id=<?= $v['id'] ?>" ><i class="fa fa-file-text-o" aria-hidden="true"></i><?=($v['a_results']!='核可'?'編輯':'檢視')?></a>
                                        </td>
                                    </tr>
                            <? }
                            } ?>
                        </tbody>
                    </table>
                </div><!-- .responsive_tbl -->
                <?/*<div class="pageNumber">
                    <ul>
                        <li class="prev disabled"><a href="javascript:;">Prev</a></li>
                        <li>1</li>
                        <li>/</li>
                        <li>2</li>target="_blank"
                        <li class="next"><a href="product_tw.php?id=133&amp;page=2">Next</a></li>
                    </ul>
                </div>*/ ?>
                <!-- 按鈕 -->
                <!-- <div class="application-form-details-end">
                    <button class='btn-register btn-text'>
                        確認無誤
                    </button>
                </div> -->
            </div>
        </div>
    </div><!-- .container -->
</section><!-- .sectionBlock -->