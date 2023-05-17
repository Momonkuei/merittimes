<?php
	Yii::app()->clientScript->registerCoreScript('jquery.flot');

	$query = "select (SELECT count('*') FROM  `customer` WHERE  `gender` = '1') as men,(SELECT count('*') as weman FROM  `customer` WHERE  `gender` = '2') as women";
	$data = $this->db->createCommand($query)->queryRow();
	//if(!$data or !isset($data['id'])){
	if(!$data or ($data['men'] == 0 and $data['women'] == 0)){
		echo 'no data';die;
	}
	//var_dump($data);
	//die;
	//$data = mysql_fetch_array(mysql_query($query, $link));
?>

<?php echo $this->renderPartial('//includes/search', $this->data)?>

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
             		<div class="row">
             			<div class="col-md-6 col-sm-6">
             				<div class="portlet solid light-grey bordered">
   			                  <div class="portlet-title">
   			                     <div class="caption"><i class="icon-bullhorn"></i>性別統計圖</div>
   			                     
   			                  </div>
   			                  <div class="portlet-body">
   			                     <div id="site_activities_loading">
   			                        <img src="assets/img/loading.gif" alt="loading"/>
   			                     </div>
   			                     <div id="site_activities_content" class="display-none">
   			                        <div id="site_activities" style="height: 300px;"></div>
   			                     </div>
   			                  </div>
   			            </div>
             			</div>
             			<div class="col-md-6 col-sm-6">


             				<div class="portlet solid light-grey bordered">
   		                  	<div class="portlet-title">
   		                     	<div class="caption"><i class="icon-reorder"></i>年齡分佈圖</div>
   		                     	<div class="tools">
   		                        	<a href="#portlet-config" data-toggle="modal" class="config"></a>
   		                        	<a href="javascript:;" class="reload"></a>
   		                     	</div>
   		                  	</div>
   			                 <div class="portlet-body">
   			                    
   			                    <div id="pie_chart_1" class="chart"></div>
   		                  	</div>
   		               </div>
             			</div>
             	    </div>
                  	 
   				<!--contant-->
   				
   				<!--contant-->
                
             	</div>
              
           </div>
           <div class="portlet box yellow">
             	<div class="portlet-title">
                	<div class="caption"><i class="icon-reorder"></i>縣市分佈圖</div>
                
             	</div>
             	<div class="portlet-body">
               
                 	<div class="portlet-body">
                    	<div id="Location_loading">
                       	<img src="assets/img/loading.gif" alt="loading"/>
                    	</div>
                    	<div id="Location_content" class="display-none">
                       	<div id="Location" style="height: 300px;"></div>
                    	</div>
                 	</div>
          
           	</div>
      		</div>
       <script>
        function showTooltip(title, x, y,num ,contents) {
       $('<div id="tooltip" class="chart-tooltip"><div class="date">' + title + '<\/div><div class="label label-success">人數: ' + num+ '<\/div><\/div>').css({
           position: 'absolute',
           display: 'none',
           top: y - 50,
           width: 80,
           left: x - 40,
           border: '0px solid #ccc',
           padding: '2px 6px',
           'background-color': '#fff',
       }).appendTo("body").fadeIn(200);
   }
      
   if ($('#site_activities').size() != 0) {
       //site activities
       var previousPoint2 = null;
       $('#site_activities_loading').hide();
       $('#site_activities_content').show();
       $.ajax({
   		url: "backend.php?r=customeranalysis/ajax",
   		dataType:"json",
   		type:"POST",
   		data:{
   			//"type":"getMemberFlotData"
   		}
   	}).done(function( msg ) {
   	   
   	    if(msg) {
   	    	
   	    	var activities = [];
   	    	var tmpData = [];
   	    	var i =1;
   	    	var SexData = msg["Sex"]["data"];
   	    	var MaxSex = msg["Sex"]["Max"];
   	    	var MaxLocationNum = msg["Location"]["Max"];
   	    	var LocationData =msg["Location"]["Data"];
   	    	console.log(LocationData);
   	    	console.log(LocationData.length);

   	    	var LocationTitle = msg["Location"]["Title"];
   	    	
   	    	for(var key in SexData)
   	    	{
   	    		tmpData = [];
   	    		tmpData = [i,SexData[key]];
   	    		activities.push(tmpData);
   	    		i++;
   	    	}

   	    	var plot_activities = $.plot(
           	$("#site_activities"), [{
               	data: activities,
               	color: "rgba(107,207,123, 0.9)",
               	shadowSize: 0,
               	bars: {
                       show: true,
                       lineWidth: 0,
                       fill: true,
                       barWidth:0.2,
                       fillColor: {
                           colors: [{
                                   opacity: 1
                               }, {
                                   opacity: 1
                               }
                           ]
                  		}
               	}
           	}], 
           	{
                   series: {
                       bars: {
                           show: true,
                           barWidth: 0.9
                       }
                   },
                   grid: {
                       show: true,
                       hoverable: true,
                       clickable: false,
                       autoHighlight: true,
                       borderWidth: 0
                   },
                   xaxis: {
                   	show:true,
                       ticks: [[1,'男'], [2,'女']],
                      
                   },
                   yaxis: {
                   	max:MaxSex,
                   	show:true,
                       ticks: 11,
                       tickDecimals: 0
                   }
       		});
   			$("#site_activities").bind("plothover", function (event, pos, item) {
                   $("#x").text(pos.x.toFixed(2));
                   $("#y").text(pos.y.toFixed(2));
                   

                   if (item) {
                       if (previousPoint2 != item.dataIndex) {
                           previousPoint2 = item.dataIndex;
                           var SexNum = 0;
                           if(item.dataIndex == 0)
                           {
                           	SexNum = SexData["men"];
                           }
                           else {
                           	SexNum = SexData["women"];
                           }
                           
                           $("#tooltip").remove();
                           var x = item.datapoint[0].toFixed(2),
                               y = item.datapoint[1].toFixed(2);
                           showTooltip('', item.pageX, item.pageY,SexNum, x);
                       }
                   }
				   // debug
				   //alert(SexData["men"]);
               });

               $('#site_activities').bind("mouseleave", function () {
                   $("#tooltip").remove();
               });

				// var datag = [
				// 	{label: "data1", data:10},
				// 	{label: "data2", data: 20},
				// 	{label: "data3", data: 30},
				// 	{label: "data4", data: 40},
				// 	{label: "data5", data: 50},
				// 	{label: "data6", data: 60},
				// 	{label: "data7", data: 70}
				// ];

               // 年齡分佈
               // $.plot($("#pie_chart_1"), datag, {
               $.plot($("#pie_chart_1"), msg["Age"], {
                   series: {
                       pie: {
                           show: true
                       }
                   },
                   legend: {
                       show: false
                   }
               }); 

               //區域 長條圖
               if(LocationData.length > 0)
               {	
               	
               	
               	$('#Location_loading').hide();
                   $('#Location_content').show();
                   var plot_location = $.plot(
               	$("#Location"), [{
                   	data: LocationData,
                   	color: "rgba(113,183,183, 0.9)",
                   	shadowSize: 0,
                   	bars: {
                           show: true,
                           lineWidth: 0,
                           fill: true,
                           barWidth:0.5,
                           fillColor: {
                               colors: [{
                                       opacity: 1
                                   }, {
                                       opacity: 1
                                   }
                               ]
                      		}
                   	}
               	}], 
               	{
                       series: {
                           bars: {
                               show: true,
                               barWidth: 1
                           }
                       },
                       grid: {
                           show: true,
                           hoverable: true,
                           clickable: false,
                           autoHighlight: true,
                           borderWidth: 0
                       },
                       xaxis: {
                       	show:true,
                           ticks: LocationTitle,
                          
                       },
                       yaxis: {
                       	max:MaxLocationNum,
                       	show:true,
                           
                       }
           		});
   				$("#Location").bind("plothover", function (event, pos, item) {
                       $("#x").text(pos.x.toFixed(2));
                       $("#y").text(pos.y.toFixed(2));
                       

                       if (item) {
                           if (previousPoint2 != item.dataIndex) {
                               previousPoint2 = item.dataIndex;

                               var SexNum = 0;
                               var	LocationNum = LocationData[item.dataIndex][1];
                              	
                               
                               $("#tooltip").remove();
                               var x = item.datapoint[0].toFixed(2),
                                   y = item.datapoint[1].toFixed(2);
                               showTooltip('', item.pageX, item.pageY,LocationNum, x);
                           }
                       }
                   });

                   $('#Location').bind("mouseleave", function () {
                       $("#tooltip").remove();
                   });
               }
               
                   
                   
   	    }

   	 });
       

       

               
   }


       </script>
   		<!--BODY-->
      </div>
      <!-- END REGIONAL STATS PORTLET-->
   </div>

</div>

