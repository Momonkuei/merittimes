<style type="text/css">
div.MsoNormal {
    font-family: "Calibri","sans-serif";
    font-size: 12pt;
    margin: 0 0 0.0001pt;
}
div.WordSection1 {
    background-color: #FFFFFF;
    padding-top: 8px;
    page: WordSection1;
    width: 98%;
}
li.MsoNormal {
    font-family: "Calibri","sans-serif";
    font-size: 12pt;
    margin: 0 0 0.0001pt;
}
p.MsoNormal {
    font-family: "Calibri","sans-serif";
    font-size: 12pt;
    margin: 0 0 0.0001pt;
}
.EOBReport01 {
    background-color: #FFFFFF;
    width: 98%;
}
</style>

<?php

if(!empty($def['updatefield']['head'])){
	foreach($def['updatefield']['head'] as $v){
		Yii::app()->clientScript->registerCoreScript($v);
	}// foreach
} //if

$update_default_1 = $this->renderPartial('//includes/default_validate', $this->data)."\n";
if(isset($update_success) and $update_success == '1'){
	$update_default_1 .= "alert(l.get('Update success'));\n";
}

$update_default_1 .= $this->renderPartial('//default/update_javascript', $this->data)."\n";
// 自定的javascript區塊，存放在實體檔案
if(isset($def['updatefield']['smarty_javascript']) and $def['updatefield']['smarty_javascript'] != ''){
	$update_default_1 .= $this->renderPartial('//'.$def['updatefield']['smarty_javascript'], $this->data)."\n";
}

// 自定的javascript區塊，存放資料庫
if(isset($def['updatefield']['smarty_javascript_text']) and $def['updatefield']['smarty_javascript_text'] != ''){
	$update_default_1 .= $def['updatefield']['smarty_javascript_text']."\n";
}

$update_default_1 .= <<<XXX1
XXX1;

Yii::app()->clientScript->registerScript('update_default_1', $update_default_1, CClientScript::POS_END);
?>

<?php //*麵包或是功能標題*}} ?>
<div class="main_content">

	<?php $this->data['action'] = $def['updatefield']['method']?>
	<?php echo $this->renderPartial('//includes/function_title', $this->data)?>

	<?php if(!empty($def['updatefield'])):?>

		<?php if($def['updatefield']['form']['enable'] == true):?>
			<?php $formattr = ''?>
			<?php if(!empty($def['updatefield']['form']['attr'])):?>
				<?php foreach($def['updatefield']['form']['attr'] as $k => $v):?>
					<?php $formattr = $formattr.' '.$k.'="'.$v.'"'?>
				<?php endforeach?>
			<?php endif?>
			<?php // enctype="multipart/form-data" ?>
			<form <?php echo $formattr?>>
		<?php endif?>

		<?php echo $this->renderPartial('//default/update_fields', $this->data)?>

		<div class="buttons indexgo03" style2="clear:both;">
			<button class="btn blue" type="submit"><i class="icon-ok"></i><?php G::te($this->data['theme_lang'], 'Submit', null, '送出')?></button>
			<button class="btn red" type="submit"><?php G::te($this->data['theme_lang'], 'Reset', null, '清除')?></button>
<?php if(isset($prev_url) and $prev_url != ''):?>
			<button onclick="document.location.href='<?php echo $prev_url?>';" class="button white btn_send" type="button"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></button>
<?php endif?>
		</div>

		<div class=" buttons indexgo03" style2="clear:both;">
<div style="layout-grid:18.0pt" class="WordSection1">
            <br>
            <table border="0" align="center" width="701" cellspacing="0" cellpadding="0">
              <tbody><tr>
                <td align="left" class="targets2" id="sys_config_bill_title_target"><b style="mso-bidi-font-weight:normal"><span style="font-size:15.0pt;font-family:
&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">全球易貨股份有限公司<span lang="EN-US" xml:lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span></b></td>
                <td align="right"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">月費用明細及帳單 <span style="mso-spacerun:yes">&nbsp;</span><span style="mso-spacerun:yes">&nbsp;</span><span lang="EN-US" xml:lang="EN-US">1/2</span>張</span></td>
              </tr>
              <tr>
                <td align="left" height="5">&nbsp;</td>
                <td align="right" height="5">&nbsp;</td>
              </tr>
            </tbody></table>
            <div align="center">
              <table border="0" cellspacing="0" cellpadding="0" style="background:#548DD4;mso-background-themecolor:text2;mso-background-themetint:
 153;border-collapse:collapse;border:none;mso-yfti-tbllook:1184;mso-padding-alt:
 0cm 5.4pt 0cm 5.4pt;mso-border-insideh:none;mso-border-insidev:none" class="MsoTableGrid">
                <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes;
  height:2.85pt">
                  <td width="718" valign="top" style="width:538.6pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:2.85pt"></td>
                </tr>
              </tbody></table>
          </div>
            <p class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt">
              <o:p>&nbsp;</o:p>
            </span></b></p>
            <table border="0" align="center" width="100%" cellspacing="0" cellpadding="0" style="margin-left:19.6pt;border-collapse:collapse;border:none;mso-yfti-tbllook:
 1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:none;mso-border-insidev:
 none" class="MsoTableGrid">
              <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes">
              <td>&nbsp;</td>
                <td align="left" valign="top" style="width:11.0cm;padding:0cm 5.4pt 0cm 5.4pt"><p class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">408
                  <o:p></o:p>
                </span></p>
                  <p style="line-height:12.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="mso-bidi-font-size:12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">台中市南屯區大墩十街<span lang="EN-US" xml:lang="EN-US">300</span>號<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p>
                  <p style="line-height:16.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">EOB</span><span style="mso-bidi-font-size:12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">股份有限公司<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p>
                  <p style="line-height:20.0pt;mso-line-height-rule:exactly" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span style="font-size:14.0pt;font-family:
  &quot;微軟正黑體&quot;,&quot;sans-serif&quot;">王大同</span></b><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;"><span style="mso-spacerun:yes">&nbsp; </span></span><span style="font-size:9.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">先生<span lang="EN-US" xml:lang="EN-US">/</span>女士</span><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></b></p></td>
                <td width="10">&nbsp;</td>
                <td valign="top" style="width:175.4pt;padding:0cm 5.4pt 0cm 5.4pt"><table border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:none;mso-border-bottom-alt:dotted #7F7F7F .5pt;
   mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:128;
   mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:
   .5pt dotted #7F7F7F;mso-border-insideh-themecolor:text1;mso-border-insideh-themetint:
   128;mso-border-insidev:.5pt dotted windowtext" class="MsoTableGrid">
                  <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
                    <td width="218" valign="top" style="width:163.85pt;border:none;border-bottom:
    dotted #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
    128;mso-border-bottom-alt:dotted #7F7F7F .5pt;mso-border-bottom-themecolor:
    text1;mso-border-bottom-themetint:128;padding:0cm 5.4pt 0cm 5.4pt"><p class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;
    color:#404040;mso-themecolor:text1;mso-themetint:191">會員帳戶：</span><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">6220-4309-000-1052</span><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt">
                      <o:p></o:p>
                    </span></p></td>
                  </tr>
                  <tr style="mso-yfti-irow:1">
                    <td width="218" valign="top" style="width:163.85pt;border:none;border-bottom:
    dotted #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
    128;mso-border-top-alt:dotted #7F7F7F .5pt;mso-border-top-themecolor:text1;
    mso-border-top-themetint:128;mso-border-top-alt:dotted #7F7F7F .5pt;
    mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-bottom-alt:
    dotted #7F7F7F .5pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
    128;padding:0cm 5.4pt 0cm 5.4pt"><p class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;
    color:#404040;mso-themecolor:text1;mso-themetint:191">卡別種類：</span><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">金卡<span lang="EN-US" xml:lang="EN-US">
                      <o:p></o:p>
                    </span></span></p></td>
                  </tr>
                  <tr style="mso-yfti-irow:2">
                    <td width="218" valign="top" style="width:163.85pt;border:none;border-bottom:
    dotted #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
    128;mso-border-top-alt:dotted #7F7F7F .5pt;mso-border-top-themecolor:text1;
    mso-border-top-themetint:128;mso-border-top-alt:dotted #7F7F7F .5pt;
    mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-bottom-alt:
    dotted #7F7F7F .5pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
    128;padding:0cm 5.4pt 0cm 5.4pt"><p class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;
    color:#404040;mso-themecolor:text1;mso-themetint:191">結帳日期：</span><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">2011.11.01
                      AM00:00</span><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt">
                        <o:p></o:p>
                      </span></p></td>
                  </tr>
                  <tr style="mso-yfti-irow:3;mso-yfti-lastrow:yes">
                    <td width="218" valign="top" style="width:163.85pt;border:none;border-bottom:
    dotted #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
    128;mso-border-top-alt:dotted #7F7F7F .5pt;mso-border-top-themecolor:text1;
    mso-border-top-themetint:128;mso-border-top-alt:dotted #7F7F7F .5pt;
    mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-bottom-alt:
    dotted #7F7F7F .5pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
    128;padding:0cm 5.4pt 0cm 5.4pt"><p class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;
    color:#404040;mso-themecolor:text1;mso-themetint:191">繳費截止日：</span><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;
    font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">2011.11.30</span></b><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt">
                      <o:p></o:p>
                    </span></p></td>
                  </tr>
                </tbody></table>
                  <p class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt">
                    <o:p></o:p>
                  </span></b></p></td>
                <td>&nbsp;</td>
              </tr>
            </tbody></table>
            <p class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt">
              <o:p>&nbsp;</o:p>
            </span></b></p>
            <p class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt">
              <o:p>&nbsp;</o:p>
            </span></b></p>
            <div align="center">
              <table border="1" width="688" cellspacing="0" cellpadding="0" style="width:515.8pt;border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt" class="MsoTableGrid">
                <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
                  <td width="121" valign="top" style="width:90.7pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center;line-height:20.0pt;
  mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">上期未繳金額<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="68" valign="top" style="width:51.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center;line-height:20.0pt;
  mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="121" valign="top" style="width:90.7pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center;line-height:20.0pt;
  mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">2%</span><span style="font-size:9.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">滯納金<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="68" style="width:51.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center;line-height:20.0pt;
  mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="121" style="width:90.7pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center;line-height:20.0pt;
  mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">本期新增金額<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="68" valign="top" style="width:51.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center;line-height:20.0pt;
  mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="121" valign="top" style="width:90.7pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center;line-height:20.0pt;
  mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">本期應繳現金<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                </tr>
                <tr style="mso-yfti-irow:1;mso-yfti-lastrow:yes;height:31.2pt">
                  <td width="121" style="width:90.7pt;border-top:none;border-left:solid #A6A6A6 2.25pt;
  mso-border-left-themecolor:background1;mso-border-left-themeshade:166;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt;height:31.2pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">3,200
                    <o:p></o:p>
                  </span></b></p></td>
                  <td width="68" style="width:51.0pt;border:none;border-right:solid #A6A6A6 2.25pt;
  mso-border-right-themecolor:background1;mso-border-right-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:31.2pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">+
                    <o:p></o:p>
                  </span></b></p></td>
                  <td width="121" style="width:90.7pt;border-top:none;border-left:none;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:31.2pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">64
                    <o:p></o:p>
                  </span></b></p></td>
                  <td width="68" style="width:51.0pt;border:none;border-right:solid #A6A6A6 2.25pt;
  mso-border-right-themecolor:background1;mso-border-right-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:31.2pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">+
                    <o:p></o:p>
                  </span></b></p></td>
                  <td width="121" style="width:90.7pt;border-top:none;border-left:none;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:31.2pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">20,000
                    <o:p></o:p>
                  </span></b></p></td>
                  <td width="68" style="width:51.0pt;border:none;border-right:solid #A6A6A6 2.25pt;
  mso-border-right-themecolor:background1;mso-border-right-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:31.2pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">=
                    <o:p></o:p>
                  </span></b></p></td>
                  <td width="121" style="width:90.7pt;border-top:none;border-left:none;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:31.2pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">23,264
                    <o:p></o:p>
                  </span></b></p></td>
                </tr>
              </tbody></table>
            </div>
            <p class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt">
              <o:p>&nbsp;</o:p>
            </span></b></p>
            <div align="center">
              <table border="1" width="701" cellspacing="0" cellpadding="0" style="width:525.75pt;border-collapse:collapse;border:none;mso-border-alt:
 solid windowtext .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt" class="MsoTableGrid">
                <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
                  <td width="74" style="width:55.2pt;border:none;border-right:solid white 1.0pt;
  mso-border-right-themecolor:background1;mso-border-right-alt:solid white .5pt;
  mso-border-right-themecolor:background1;background:#404040;mso-background-themecolor:
  text1;mso-background-themetint:191;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;
  mso-themecolor:background1">日期<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="64" style="width:48.2pt;border:none;border-right:solid white 1.0pt;
  mso-border-right-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-right-alt:solid white .5pt;
  mso-border-right-themecolor:background1;background:#404040;mso-background-themecolor:
  text1;mso-background-themetint:191;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;
  mso-themecolor:background1">交易編號<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="122" style="width:91.2pt;border:none;border-right:solid white 1.0pt;
  mso-border-right-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-right-alt:solid white .5pt;
  mso-border-right-themecolor:background1;background:#404040;mso-background-themecolor:
  text1;mso-background-themetint:191;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;
  mso-themecolor:background1">交易對象<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="120" style="width:90.2pt;border:none;border-right:solid white 1.0pt;
  mso-border-right-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-right-alt:solid white .5pt;
  mso-border-right-themecolor:background1;background:#404040;mso-background-themecolor:
  text1;mso-background-themetint:191;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;
  mso-themecolor:background1">描述<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="60" style="width:45.35pt;border:none;border-right:solid white 1.0pt;
  mso-border-right-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-right-alt:solid white .5pt;
  mso-border-right-themecolor:background1;background:#404040;mso-background-themecolor:
  text1;mso-background-themetint:191;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;
  mso-themecolor:background1">銷售<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="60" style="width:45.35pt;border:none;border-right:solid white 1.0pt;
  mso-border-right-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-right-alt:solid white .5pt;
  mso-border-right-themecolor:background1;background:#404040;mso-background-themecolor:
  text1;mso-background-themetint:191;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;
  mso-themecolor:background1">採購<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="64" style="width:48.2pt;border:none;border-right:solid white 1.0pt;
  mso-border-right-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-right-alt:solid white .5pt;
  mso-border-right-themecolor:background1;background:#404040;mso-background-themecolor:
  text1;mso-background-themetint:191;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;
  mso-themecolor:background1">現金費用<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="76" style="width:2.0cm;border:none;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;background:#404040;mso-background-themecolor:
  text1;mso-background-themetint:191;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;
  mso-themecolor:background1">EOB</span><span style="font-size:9.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;mso-themecolor:background1">幣費用<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="60" valign="top" style="width:45.35pt;border:none;border-left:solid white 1.0pt;
  mso-border-left-themecolor:background1;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;background:#404040;mso-background-themecolor:
  text1;mso-background-themetint:191;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;color:white;
  mso-themecolor:background1">付費<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                </tr>
                <tr style="mso-yfti-irow:1">
                  <td width="74" style="width:55.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:
  text1;mso-border-themetint:128;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">2011.10.07
                    <o:p></o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-left:none;mso-border-left-alt:solid #7F7F7F .5pt;
  mso-border-left-themecolor:text1;mso-border-left-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">96874
                    <o:p></o:p>
                  </span></p></td>
                  <td width="122" style="width:91.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-left:none;mso-border-left-alt:solid #7F7F7F .5pt;
  mso-border-left-themecolor:text1;mso-border-left-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:8.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">埔岳實業股份有限公司<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="120" style="width:90.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-left:none;mso-border-left-alt:solid #7F7F7F .5pt;
  mso-border-left-themecolor:text1;mso-border-left-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:8.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">銀杏<span lang="EN-US" xml:lang="EN-US">3</span>瓶<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="60" style="width:45.35pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-left:none;mso-border-left-alt:solid #7F7F7F .5pt;
  mso-border-left-themecolor:text1;mso-border-left-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">52,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="60" style="width:45.35pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-left:none;mso-border-left-alt:solid #7F7F7F .5pt;
  mso-border-left-themecolor:text1;mso-border-left-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-left:none;mso-border-left-alt:solid #7F7F7F .5pt;
  mso-border-left-themecolor:text1;mso-border-left-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">5,200
                    <o:p></o:p>
                  </span></p></td>
                  <td width="76" style="width:2.0cm;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-left:none;mso-border-left-alt:solid #7F7F7F .5pt;
  mso-border-left-themecolor:text1;mso-border-left-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">1,040
                    <o:p></o:p>
                  </span></p></td>
                  <td width="60" valign="top" style="width:45.35pt;border:solid #7F7F7F 1.0pt;
  mso-border-themecolor:text1;mso-border-themetint:128;border-left:none;
  mso-border-left-alt:solid #7F7F7F .5pt;mso-border-left-themecolor:text1;
  mso-border-left-themetint:128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:
  text1;mso-border-themetint:128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                </tr>
                <tr style="mso-yfti-irow:2">
                  <td width="74" style="width:55.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-top:none;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">2011.10.13
                    <o:p></o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">96874
                    <o:p></o:p>
                  </span></p></td>
                  <td width="122" style="width:91.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:8.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">EOB</span><span style="font-size:8.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">全球易貨股份有限公司<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="120" style="width:90.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:8.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">繳九月份費用<span lang="EN-US" xml:lang="EN-US">(</span>未繳清<span lang="EN-US" xml:lang="EN-US">)
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="76" style="width:2.0cm;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="60" valign="top" style="width:45.35pt;border-top:none;border-left:
  none;border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">3,000
                    <o:p></o:p>
                  </span></p></td>
                </tr>
                <tr style="mso-yfti-irow:3">
                  <td width="74" style="width:55.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-top:none;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">2011.10.18
                    <o:p></o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">96890
                    <o:p></o:p>
                  </span></p></td>
                  <td width="122" style="width:91.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:8.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">佳儀服裝工作室<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="120" style="width:90.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:8.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">鹿血丸<span lang="EN-US" xml:lang="EN-US">8</span>箱<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">100,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">10,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="76" style="width:2.0cm;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">2,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="60" valign="top" style="width:45.35pt;border-top:none;border-left:
  none;border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                </tr>
                <tr style="mso-yfti-irow:4">
                  <td width="74" style="width:55.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-top:none;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">2011.10.22
                    <o:p></o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">96899
                    <o:p></o:p>
                  </span></p></td>
                  <td width="122" style="width:91.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:8.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">永大車行<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="120" style="width:90.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:8.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">蜂皇乳<span lang="EN-US" xml:lang="EN-US">2</span>瓶<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">48,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">4,800
                    <o:p></o:p>
                  </span></p></td>
                  <td width="76" style="width:2.0cm;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">960
                    <o:p></o:p>
                  </span></p></td>
                  <td width="60" valign="top" style="width:45.35pt;border-top:none;border-left:
  none;border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                </tr>
                <tr style="mso-yfti-irow:5">
                  <td width="74" style="width:55.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-top:none;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">2011.10.27
                    <o:p></o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">96914
                    <o:p></o:p>
                  </span></p></td>
                  <td width="122" style="width:91.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:8.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">羽生代工所<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="120" style="width:90.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:8.0pt;
  font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">廣告標籤<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">23,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="76" style="width:2.0cm;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="60" valign="top" style="width:45.35pt;border-top:none;border-left:
  none;border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                </tr>
                <tr style="mso-yfti-irow:6;height:7.6pt">
                  <td width="74" style="width:55.2pt;border:solid #7F7F7F 1.0pt;mso-border-themecolor:
  text1;mso-border-themetint:128;border-top:none;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-alt:
  solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:128;
  padding:0cm 5.4pt 0cm 5.4pt;height:7.6pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:6.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt;height:7.6pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:6.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="122" style="width:91.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt;height:7.6pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:6.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="120" style="width:90.2pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt;height:7.6pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:6.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt;height:7.6pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:6.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="60" style="width:45.35pt;border-top:none;border-left:none;
  border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt;height:7.6pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:6.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt;height:7.6pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:6.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="76" style="width:2.0cm;border-top:none;border-left:none;border-bottom:
  solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;mso-border-bottom-themetint:
  128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:text1;
  mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt;height:7.6pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:6.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="60" valign="top" style="width:45.35pt;border-top:none;border-left:
  none;border-bottom:solid #7F7F7F 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:128;border-right:solid #7F7F7F 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:128;mso-border-top-alt:solid #7F7F7F .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:128;mso-border-left-alt:
  solid #7F7F7F .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  128;mso-border-alt:solid #7F7F7F .5pt;mso-border-themecolor:text1;mso-border-themetint:
  128;padding:0cm 5.4pt 0cm 5.4pt;height:7.6pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:6.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                </tr>
                <tr style="mso-yfti-irow:7;mso-yfti-lastrow:yes">
                  <td width="74" style="width:55.2pt;border:none;border-bottom:solid #A6A6A6 1.0pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  mso-border-top-alt:solid #A6A6A6 .5pt;mso-border-top-themecolor:background1;
  mso-border-top-themeshade:166;mso-border-top-alt:solid #A6A6A6 .5pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-bottom-alt:solid #A6A6A6 .5pt;mso-border-bottom-themecolor:background1;
  mso-border-bottom-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;新細明體&quot;,&quot;serif&quot;;mso-ascii-font-family:Arial;
  mso-fareast-font-family:新細明體;mso-fareast-theme-font:minor-fareast;mso-hansi-font-family:
  Arial;mso-bidi-font-family:Arial">總計</span><span lang="EN-US" xml:lang="EN-US" style="font-size:
  9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border:none;border-bottom:solid #A6A6A6 1.0pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  mso-border-top-alt:solid #A6A6A6 .5pt;mso-border-top-themecolor:background1;
  mso-border-top-themeshade:166;mso-border-top-alt:solid #A6A6A6 .5pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-bottom-alt:solid #A6A6A6 .5pt;mso-border-bottom-themecolor:background1;
  mso-border-bottom-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="122" style="width:91.2pt;border:none;border-bottom:solid #A6A6A6 1.0pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  mso-border-top-alt:solid #A6A6A6 .5pt;mso-border-top-themecolor:background1;
  mso-border-top-themeshade:166;mso-border-top-alt:solid #A6A6A6 .5pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-bottom-alt:solid #A6A6A6 .5pt;mso-border-bottom-themecolor:background1;
  mso-border-bottom-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="120" style="width:90.2pt;border:none;border-bottom:solid #A6A6A6 1.0pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  mso-border-top-alt:solid #A6A6A6 .5pt;mso-border-top-themecolor:background1;
  mso-border-top-themeshade:166;mso-border-top-alt:solid #A6A6A6 .5pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-bottom-alt:solid #A6A6A6 .5pt;mso-border-bottom-themecolor:background1;
  mso-border-bottom-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:10.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="60" style="width:45.35pt;border:none;border-bottom:solid #A6A6A6 1.0pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  mso-border-top-alt:solid #A6A6A6 .5pt;mso-border-top-themecolor:background1;
  mso-border-top-themeshade:166;mso-border-top-alt:solid #A6A6A6 .5pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-bottom-alt:solid #A6A6A6 .5pt;mso-border-bottom-themecolor:background1;
  mso-border-bottom-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">200,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="60" style="width:45.35pt;border:none;border-bottom:solid #A6A6A6 1.0pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  mso-border-top-alt:solid #A6A6A6 .5pt;mso-border-top-themecolor:background1;
  mso-border-top-themeshade:166;mso-border-top-alt:solid #A6A6A6 .5pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-bottom-alt:solid #A6A6A6 .5pt;mso-border-bottom-themecolor:background1;
  mso-border-bottom-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">23,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="64" style="width:48.2pt;border:none;border-bottom:solid #A6A6A6 1.0pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  mso-border-top-alt:solid #A6A6A6 .5pt;mso-border-top-themecolor:background1;
  mso-border-top-themeshade:166;mso-border-top-alt:solid #A6A6A6 .5pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-bottom-alt:solid #A6A6A6 .5pt;mso-border-bottom-themecolor:background1;
  mso-border-bottom-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">20,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="76" style="width:2.0cm;border:none;border-bottom:solid #A6A6A6 1.0pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  mso-border-top-alt:solid #A6A6A6 .5pt;mso-border-top-themecolor:background1;
  mso-border-top-themeshade:166;mso-border-top-alt:solid #A6A6A6 .5pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-bottom-alt:solid #A6A6A6 .5pt;mso-border-bottom-themecolor:background1;
  mso-border-bottom-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">4,000
                    <o:p></o:p>
                  </span></p></td>
                  <td width="60" valign="top" style="width:45.35pt;border:none;border-bottom:solid #A6A6A6 1.0pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  mso-border-top-alt:solid #A6A6A6 .5pt;mso-border-top-themecolor:background1;
  mso-border-top-themeshade:166;mso-border-top-alt:solid #A6A6A6 .5pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-bottom-alt:solid #A6A6A6 .5pt;mso-border-bottom-themecolor:background1;
  mso-border-bottom-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt"><p align="right" style="text-align:right" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">3,000
                    <o:p></o:p>
                  </span></p></td>
                </tr>
              </tbody></table>
            </div>
            <p class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
              <o:p>&nbsp;</o:p>
            </span></p>
            <table border="0" align="center" width="701" cellspacing="0" cellpadding="0">
              <tbody><tr>
                <td align="left"><p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">銷售<span lang="EN-US" xml:lang="EN-US">200,000<span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span>現金服務費<span lang="EN-US" xml:lang="EN-US">10%=20,000</span>元整<span lang="EN-US" xml:lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>EOB</span>幣費用<span lang="EN-US" xml:lang="EN-US">2%=4</span></span><span lang="EN-US" xml:lang="EN-US">,000</span></p></td>
                </tr>
              <tr>
                <td align="left" height="5"><p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">採購<span lang="EN-US" xml:lang="EN-US">23,000
              <o:p></o:p>
            </span></span></p></td>
                </tr>
              <tr>
                <td align="left" valign="bottom" height="40"><p class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">EOB</span></b><b style="mso-bidi-font-weight:normal"><span style="font-size:10.0pt;font-family:
&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">幣結算：</span><span lang="EN-US" xml:lang="EN-US">
              <o:p></o:p>
            </span></b></p></td>
                </tr>
              <tr>
                <td align="left" height="5"></td>
                </tr>
            </tbody></table>
            <div align="center"></div>
            
            <div align="center">
              <table border="1" width="688" cellspacing="0" cellpadding="0" style="width:515.85pt;border-collapse:collapse;border:none;mso-border-alt:
 solid windowtext .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt" class="MsoTableGrid">
                <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
                  <td width="83" style="width:62.35pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">上期餘額</span><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">信用額度</span><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">本期新增</span><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">本期花費</span><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">應繳<span lang="EN-US" xml:lang="EN-US">EOB</span>幣</span><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border:none;border-bottom:solid #A6A6A6 2.25pt;
  mso-border-bottom-themecolor:background1;mso-border-bottom-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt"><p align="center" style="text-align:center" class="MsoNormal"><span style="font-size:9.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">可用<span lang="EN-US" xml:lang="EN-US">EOB</span>幣</span><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                </tr>
                <tr style="mso-yfti-irow:1;mso-yfti-lastrow:yes;height:25.5pt">
                  <td width="83" style="width:62.35pt;border-top:none;border-left:solid #A6A6A6 2.25pt;
  mso-border-left-themecolor:background1;mso-border-left-themeshade:166;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;
  font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">43,000</span></b><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;border-right:solid #A6A6A6 2.25pt;
  mso-border-right-themecolor:background1;mso-border-right-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">+</span></b><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border-top:none;border-left:none;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;
  font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">1,000,000</span></b><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;border-right:solid #A6A6A6 2.25pt;
  mso-border-right-themecolor:background1;mso-border-right-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">+</span></b><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border-top:none;border-left:none;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;
  font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">200,000</span></b><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;border-right:solid #A6A6A6 2.25pt;
  mso-border-right-themecolor:background1;mso-border-right-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">-</span></b><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border-top:none;border-left:none;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;
  font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">23,000</span></b><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;border-right:solid #A6A6A6 2.25pt;
  mso-border-right-themecolor:background1;mso-border-right-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">-</span></b><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border-top:none;border-left:none;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;
  font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">4,000</span></b><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="38" style="width:1.0cm;border:none;border-right:solid #A6A6A6 2.25pt;
  mso-border-right-themecolor:background1;mso-border-right-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:
  12.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">=</span></b><span lang="EN-US" xml:lang="EN-US" style="mso-bidi-font-size:12.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                  <td width="83" style="width:62.35pt;border-top:none;border-left:none;
  border-bottom:solid #404040 2.25pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:191;border-right:solid #A6A6A6 2.25pt;mso-border-right-themecolor:
  background1;mso-border-right-themeshade:166;mso-border-top-alt:solid #A6A6A6 2.25pt;
  mso-border-top-themecolor:background1;mso-border-top-themeshade:166;
  mso-border-left-alt:solid #A6A6A6 2.25pt;mso-border-left-themecolor:background1;
  mso-border-left-themeshade:166;padding:0cm 5.4pt 0cm 5.4pt;height:25.5pt"><p align="center" style="text-align:center" class="MsoNormal"><b style="mso-bidi-font-weight:normal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;
  font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">1,216,000</span></b><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p></o:p>
                  </span></p></td>
                </tr>
              </tbody></table>
            </div>
            <p class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
              <o:p>&nbsp;</o:p>
            </span></p>
            <p class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
              <o:p>&nbsp;</o:p>
            </span></p>
            <div align="center">
              <table border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:none;mso-border-alt:solid #D9D9D9 1.5pt;
 mso-border-themecolor:background1;mso-border-themeshade:217;mso-yfti-tbllook:
 1184;mso-padding-alt:4.25pt 5.4pt 4.25pt 5.4pt;mso-border-insideh:1.5pt solid #D9D9D9;
 mso-border-insideh-themecolor:background1;mso-border-insideh-themeshade:217;
 mso-border-insidev:1.5pt solid #D9D9D9;mso-border-insidev-themecolor:background1;
 mso-border-insidev-themeshade:217" class="MsoTableGrid">
                <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes">
                  <td width="722" class="targets2" id="sys_config_bill_adv_target" valign="top" style="width:541.4pt;border:solid #D9D9D9 1.5pt;
  mso-border-themecolor:background1;mso-border-themeshade:217;padding:4.25pt 5.4pt 4.25pt 5.4pt"><p style="line-height:12.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">熱情歡迎<span lang="EN-US" xml:lang="EN-US">EOB</span>七月份新會員 賣濕國際股份有限公司<span lang="EN-US" xml:lang="EN-US"> &amp; </span>每憐貿易有限公司
                    加入<span lang="EN-US" xml:lang="EN-US">EOB</span>易貨交易平台，若您想要了解更多的相關資訊，可詢問您的專屬<span lang="EN-US" xml:lang="EN-US">TCO</span>，我們將給您豐富的商品資訊與專業服務。<span lang="EN-US" xml:lang="EN-US">
                      <o:p></o:p>
                    </span></span></p></td>
                </tr>
              </tbody></table>
            </div>
            <p class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
              <o:p>&nbsp;</o:p>
            </span></p>
            <div align="center">
              <table border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt" class="MsoTableGrid">
                <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
                  <td width="265" valign="top" style="width:7.0cm;border:solid #262626 1.0pt;
  mso-border-themecolor:text1;mso-border-themetint:217;mso-border-alt:solid #262626 .5pt;
  mso-border-themecolor:text1;mso-border-themetint:217;background:#262626;
  mso-background-themecolor:text1;mso-background-themetint:217;padding:0cm 5.4pt 0cm 5.4pt"><p class="MsoNormal"><span class="targets2" id="sys_config_bill_left_title_target" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;
  color:white;mso-themecolor:background1">付款資訊<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                  <td width="23" valign="top" style="width:17.0pt;border:none;border-right:solid #262626 1.0pt;
  mso-border-right-themecolor:text1;mso-border-right-themetint:217;mso-border-left-alt:
  solid #262626 .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  217;mso-border-left-alt:solid #262626 .5pt;mso-border-left-themecolor:text1;
  mso-border-left-themetint:217;mso-border-right-alt:solid #262626 .5pt;
  mso-border-right-themecolor:text1;mso-border-right-themetint:217;padding:
  0cm 5.4pt 0cm 5.4pt"><p class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;
  color:white;mso-themecolor:background1">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="435" valign="top" style="width:326.0pt;border:solid #262626 1.0pt;
  mso-border-themecolor:text1;mso-border-themetint:217;border-left:none;
  mso-border-left-alt:solid #262626 .5pt;mso-border-left-themecolor:text1;
  mso-border-left-themetint:217;mso-border-alt:solid #262626 .5pt;mso-border-themecolor:
  text1;mso-border-themetint:217;background:#262626;mso-background-themecolor:
  text1;mso-background-themetint:217;padding:0cm 5.4pt 0cm 5.4pt"><p class="MsoNormal"><span class="targets2" id="sys_config_bill_right_title_target" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;
  color:white;mso-themecolor:background1">貼心提醒<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                </tr>
                <tr style="mso-yfti-irow:1;mso-yfti-lastrow:yes">
                  <td width="265" class="targets2" id="sys_config_bill_left_data_target" valign="top" style="width:7.0cm;border:solid #262626 1.0pt;
  mso-border-themecolor:text1;mso-border-themetint:217;border-top:none;
  mso-border-top-alt:solid #262626 .5pt;mso-border-top-themecolor:text1;
  mso-border-top-themetint:217;mso-border-alt:solid #262626 .5pt;mso-border-themecolor:
  text1;mso-border-themetint:217;padding:0cm 5.4pt 0cm 5.4pt"><p style="line-height:14.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">存款戶名：全球易貨股份有限公司<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p>
                    <p style="line-height:14.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">統一編號：<span lang="EN-US" xml:lang="EN-US">53148050
                      <o:p></o:p>
                    </span></span></p>
                    <p style="line-height:14.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">銀行：華南商業銀行<span lang="EN-US" xml:lang="EN-US">(008)
                      <o:p></o:p>
                    </span></span></p>
                    <p style="line-height:14.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">分行：中港路分行<span lang="EN-US" xml:lang="EN-US">
                      <o:p></o:p>
                    </span></span></p>
                    <p style="line-height:14.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">帳號：<span lang="EN-US" xml:lang="EN-US">008-424-10-0037776
                      <o:p></o:p>
                    </span></span></p></td>
                  <td width="23" valign="top" style="width:17.0pt;border:none;border-right:solid #262626 1.0pt;
  mso-border-right-themecolor:text1;mso-border-right-themetint:217;mso-border-left-alt:
  solid #262626 .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  217;mso-border-left-alt:solid #262626 .5pt;mso-border-left-themecolor:text1;
  mso-border-left-themetint:217;mso-border-right-alt:solid #262626 .5pt;
  mso-border-right-themecolor:text1;mso-border-right-themetint:217;padding:
  0cm 5.4pt 0cm 5.4pt"><p class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                  <td width="435" valign="top" style="width:326.0pt;border-top:none;border-left:
  none;border-bottom:solid #262626 1.0pt;mso-border-bottom-themecolor:text1;
  mso-border-bottom-themetint:217;border-right:solid #262626 1.0pt;mso-border-right-themecolor:
  text1;mso-border-right-themetint:217;mso-border-top-alt:solid #262626 .5pt;
  mso-border-top-themecolor:text1;mso-border-top-themetint:217;mso-border-left-alt:
  solid #262626 .5pt;mso-border-left-themecolor:text1;mso-border-left-themetint:
  217;mso-border-alt:solid #262626 .5pt;mso-border-themecolor:text1;mso-border-themetint:
  217;padding:0cm 5.4pt 0cm 5.4pt"><p id="sys_config_bill_right_data_target" style="line-height:14.0pt;mso-line-height-rule:exactly" class="targets2 MsoNormal"><span style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">提醒您每月帳單務必於當月繳費截止日前繳納，逾期將產生當期應繳金額之<span lang="EN-US" xml:lang="EN-US">2%</span>滯納金費用。<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p></td>
                </tr>
              </tbody></table>
            </div>
            <p class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
              <o:p>&nbsp;</o:p>
            </span></p>
            <div align="center">
              <table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:none;mso-yfti-tbllook:1184;mso-padding-alt:
 0cm 5.4pt 0cm 5.4pt;mso-border-insideh:none;mso-border-insidev:none" class="MsoTableGrid">
                <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes">
                  <td width="191" valign="top" style="width:143.15pt;padding:0cm 5.4pt 0cm 5.4pt"><p style="line-height:12.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span class="targets2" id="sys_config_bill_title_sub_1_target" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">全球易貨股份有限公司<span lang="EN-US" xml:lang="EN-US">
                    <o:p></o:p>
                  </span></span></p>
                    <p style="line-height:12.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" class="targets2" id="sys_config_bill_title_sub_2_target" xml:lang="EN-US" style="font-size:7.5pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;;
  color:#595959;mso-themecolor:text1;mso-themetint:166">Effect of Butterfly Barter
                      Co., Ltd.</span><span lang="EN-US" xml:lang="EN-US" style="font-size:7.5pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                        <o:p></o:p>
                      </span></p></td>
                  <td width="397" valign="top" style="width:297.7pt;padding:0cm 5.4pt 0cm 5.4pt"><p style="line-height:12.0pt;mso-line-height-rule:exactly" id="sys_config_bill_title_sub_3_target" class="MsoNormal targets2"><span lang="EN-US" xml:lang="EN-US" style="font-size:8.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">408</span><span style="font-size:8.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">台中市南屯區大墩十街<span lang="EN-US" xml:lang="EN-US">300</span>號<span lang="EN-US" xml:lang="EN-US">7F<span style="mso-spacerun:yes">&nbsp; </span>T</span>：<span lang="EN-US" xml:lang="EN-US">04-22511743<span style="mso-spacerun:yes">&nbsp; </span>F</span>：<span lang="EN-US" xml:lang="EN-US">04-22552211
                    <o:p></o:p>
                  </span></span></p>
                    <p style="line-height:12.0pt;mso-line-height-rule:exactly" id="sys_config_bill_title_sub_4_target" class="MsoNormal targets2"><span lang="EN-US" xml:lang="EN-US" style="font-size:8.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">Web</span><span style="font-size:8.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">：<span lang="EN-US" xml:lang="EN-US">www.eob.com<span style="mso-spacerun:yes">&nbsp; </span>E-mail</span>：<span lang="EN-US" xml:lang="EN-US">service@eob.com</span></span><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                      <o:p></o:p>
                    </span></p></td>
                  <td width="134" valign="bottom" style="width:100.55pt;padding:0cm 5.4pt 0cm 5.4pt"><p style="text-align:justify;text-justify:inter-ideograph;
  line-height:12.0pt;mso-line-height-rule:exactly" class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
                    <o:p>&nbsp;</o:p>
                  </span></p></td>
                </tr>
              </tbody></table>
            </div>
            <p class="MsoNormal"><span lang="EN-US" xml:lang="EN-US" style="font-size:10.0pt;font-family:&quot;微軟正黑體&quot;,&quot;sans-serif&quot;">
              <o:p>&nbsp;</o:p>
            </span></p>
          </div>
		</div>

		<div class="buttons indexgo03" style2="clear:both;">
			<button class="btn blue" type="submit"><i class="icon-ok"></i><?php G::te($this->data['theme_lang'], 'Submit', null, '送出')?></button>
			<button class="btn red" type="submit"><?php G::te($this->data['theme_lang'], 'Reset', null, '清除')?></button>
<?php if(isset($prev_url) and $prev_url != ''):?>
			<button onclick="document.location.href='<?php echo $prev_url?>';" class="button white btn_send" type="button"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></button>
<?php endif?>
		</div>

		<?php if($def['updatefield']['method'] == 'update'):?>
		<input type="hidden" name="hidden_id" value="<?php G::ae($updatecontent, 'updatecontent.id')?>" />
		<?php endif?>
		<input type="hidden" name="update_base64_url" value="<?php if(isset($update_base64_url)){ echo $update_base64_url; }?>" />
		<input type="hidden" name="prev_url" value="<?php if(isset($update_base64_url)){ echo $prev_url; }?>" />

		<?php if($def['updatefield']['form']['enable'] == true):?>
		</form>
		<?php endif?>

	<?php endif?><?php //empty($def.updatefield)?>

</div>
