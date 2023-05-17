<?php if(0):?>
<div class="row">
	<div class="col-md-12">
		<h2>歡迎登入 [ <?php echo $this->data['sys_configs']['admin_title']?> ]</h2>
	</div>
</div>
<?php endif?>


                 <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->               
        <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Modal title</h4>
                  </div>
                  <div class="modal-body">
                     Widget settings form goes here
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn blue">Save changes</button>
                     <button type="button" class="btn default" data-dismiss="modal">Close</button>
                  </div>
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>
         <!-- /.modal -->
         <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <!-- BEGIN STYLE CUSTOMIZER -->
         <div class="theme-panel hidden-xs hidden-sm">
            <div style="display: none;" class="toggler"></div>
            <div style="display: none;" class="toggler-close"></div>
            <div style="display: none;" class="theme-options">
               <div class="theme-option theme-colors clearfix">
                  <span>主題色</span>
                  <ul>
                     <li class="color-blue" data-style="blue"></li>
                     <li class="color-orange" data-style="orange"></li>
                     <li class="color-green" data-style="green"></li>
                     <!-- <li class="color-brown" data-style="brown"></li> -->
                     <li class="color-grey" data-style="grey"></li>
                     <li class="color-black color-default current" data-style="default"></li>
                  </ul>
               </div>
               <div class="theme-option">
                  <span>邊界呈現</span>
                  <select class="layout-option form-control input-small">
                     <option value="fluid" selected="selected">延伸</option>
                     <option value="boxed">限制</option>
                  </select>
               </div>
               <div class="theme-option">
                  <span>頁首菜單</span>
                  <select class="header-option form-control input-small">
                     <option value="固定" selected="selected">固定</option>
                     <option value="預設">預設</option>
                  </select>
               </div>
               <div class="theme-option">
                  <span>側欄</span>
                  <select class="sidebar-option form-control input-small">
                     <option value="固定">固定</option>
                     <option value="預設" selected="selected">預設</option>
                  </select>
               </div>
               <div class="theme-option">
                  <span>頁尾資訊</span>
                  <select class="footer-option form-control input-small">
                     <option value="固定">固定</option>
                     <option value="預設" selected="selected">預設</option>
                  </select>
               </div>
            </div>
         </div>
         <!-- END BEGIN STYLE CUSTOMIZER -->         <!-- BEGIN PAGE HEADER-->
         <div class="row">
            <div class="col-md-12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title">
                  首頁               </h3>
               <ul class="page-breadcrumb breadcrumb">
                  <li>
                     <i class="icon-home"></i>
                     <a href="index.php">首頁</a> 
                  </li>
                  <!--<li><a href="#">Dashboard</a></li>
                  <li class="pull-right">
                     <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
                        <i class="icon-calendar"></i>
                        <span></span>
                        <i class="icon-angle-down"></i>
                     </div>
                  </li>-->
               </ul>
               <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
         </div>
         <!-- END PAGE HEADER-->
         <div class="row ">
            <div class="col-md-12 col-sm-12">
               <!-- BEGIN REGIONAL STATS PORTLET-->
               <div class="portlet">
					<!--BODY-->
               <div class="portlet blue box">
                  <div class="portlet-title">
                     <div class="caption"><i class="icon-cogs"></i></div>
                  </div>
                  <div class="portlet-body">
                     <div class="note note-info">
						<!--contant-->
						  <table align="center" width="355" border="0" cellpadding="3" cellspacing="0">
							<tbody><tr>
							<td><?php echo $this->data['admin_name']?>								您好~~</td>
							</tr>
							<tr>
							  <td>歡迎登入 <?php echo $this->data['sys_configs']['admin_title']?> 網站後台~~</td>
							</tr>
							<tr>
							  <td><font size="2">&nbsp;</font></td>
							</tr>
							<tr>
							  <td><font size="2" color="#666666">現在時間：
<?php echo date('Y-m-d H:i:s')?>							  </font></td>
							</tr>
							<tr>
							  <td><div align="right"><font size="2"><a href="<?php echo $this->createUrl('auth/logout', array('current_base64_url'=> $this->data['current_base64_url']))?>">登出</a></font></div></td>
							</tr>
						  </tbody></table>
						<!--contant-->
                     </div>
                  </div>
               </div>
					<!--BODY-->
               </div>
               <!-- END REGIONAL STATS PORTLET-->
            </div>
		
         </div>
      
	  
