<?php echo $this->renderPartial('//includes/search', $this->data)?>

<?php
	Yii::app()->clientScript->registerCoreScript('jquery.flot');
?>

<div class="row ">
   <div class="col-md-12 col-sm-12">
      <!-- BEGIN REGIONAL STATS PORTLET-->
      <div class="portlet">
   		<!--BODY-->
   		<div class="portlet box red">
               <div class="portlet-title">
                   <div class="caption"><i class="icon-reorder"></i>歷年月份</div>
                   
               </div>
               <div class="portlet-body">
                  <form method="POST" >
                   	<div class="clearfix">
                   		<div class="btn-group" data-toggle="buttons">
                   			<?
                   			
   	                    		$sql = "SELECT date_format(create_time,'%Y') as OrderYear FROM `shoporderform` group by OrderYear order by OrderYear ASC";
   	                    		//$tYears = $DB->query($sql);
   	                    		$tYears = $this->cidb->query($sql)->result_array();;
   	                    		
   	                    		if($tYears)
   	                    		{
   	                    			foreach ($tYears as $key => $value) {
   	                    				$emptyYear[]=$value["OrderYear"];
   	                    			}
   	                    		}
   	                    		else $emptyYear[]=date("Y");

   	                    		
   	                    		if(!isset($_POST["Years"])) $Years[]=date("Y");
   	                    		else $Years=$_POST["Years"];
   	                    		
   	                    		
   	                    		foreach ($emptyYear as $key => $value) 
   	                    		{
   	                    			
   	                    			?>
   	                    				<label class="btn btn-default <?if(in_array($value, $Years)) echo "active";?>"><input type="checkbox" class="toggle" name="Years[]" value="<?=$value?>" <?if(in_array($value, $Years)) echo "checked";?>><?=$value?></label>
   	                    			<?
   	                    		}
   	                    		
   	                    	?>
   	                    	
                   		</div>
                   		<input type="submit" class="btn blue" style="margin-left:15px" value="查詢">
                   	</div>
   	            </form>        	

                  
                   <div id="chart_2" class="chart"></div>
               </div>
           </div>
      
   		<!--BODY-->
      </div>
      <!-- END REGIONAL STATS PORTLET-->
   </div>

</div>

   <script>
   		$(function(){
   			function randValue() {
                    return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
                }
            var tick = [[1,"1月"],[2,"2月"],[3,"3月"],[4,"4月"],[5,"5月"],[6,"6月"],[7,"7月"],[8,"8月"],[9,"9月"],[10,"10月"],[11,"11月"],[12,"12月"]];
            $.ajax({
					url: "backend.php?r=shopsaleanalysis/ajax",
					dataType:"json",
					type:"POST",
					data:{
						"Years":"<?=implode("|", $Years)?>"
						//"type":"getOrderAnalysis"
						}
			}).done(function( msg ) {
					var Data=msg["Data"];
					var Max = msg["Max"];
					var plot = $.plot($("#chart_2"), Data, {

                        series: {
                            lines: {
                                show: true,
                                lineWidth: 2,
                                fill: true,
                                fillColor: {
                                    colors: [{
                                            opacity: 0.05
                                        }, {
                                            opacity: 0.01
                                        }
                                    ]
                                }
                            },
                            points: {
                                show: true
                            },
                            shadowSize: 2
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderWidth: 0
                        },
                        colors: ["#D10000", "#1e90ff", "#6b8e23","#333333","#7900D1","#0000D1","#00D1D1","#D1D100","#940094","#009900",],
                        xaxis: {
                            ticks: tick,
                            tickDecimals: 0
                        },
                        yaxis: {
                        	max:Max,
                            ticks: 11,
                            tickDecimals: 0
                        }
                    });

			});
            

                function showTooltip(x, y, contents) {
                    $('<div id="tooltip">' + contents + '</div>').css({
                            position: 'absolute',
                            display: 'none',
                            top: y + 5,
                            left: x + 15,
                            border: '1px solid #333',
                            padding: '4px',
                            color: '#fff',
                            'border-radius': '3px',
                            'background-color': '#333',
                            opacity: 0.80
                        }).appendTo("body").fadeIn(200);
                }

                var previousPoint = null;
                $("#chart_2").bind("plothover", function (event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));

                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;

                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1];

                            showTooltip(item.pageX, item.pageY, item.series.label + tick[previousPoint][1] + " = " + y+"元");
                        }
                    } else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                });
   		});
   </script>
