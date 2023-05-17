//設定顯示手機選單的尺寸
var setPoint=1024;



// 自動建立panel & data
var autoCreatPanel=true;

// 自動建立 data , 各區塊手動建立並指定資料
var autoCreatData=false;


if($('header:not(".headerStyle02, .headerStyle03, .headerStyle07")').length){



	//如有自動建立data，則取消自動建立panel&data
	if($('#mbPanel[data-mbPanelMode="autoData"]').length>0){
		autoCreatData=true;
		autoCreatPanel=false;
	}



	//如為靜態，則取消自動建立panel&data
	if($('#mbPanel[data-mbPanelMode="default"]').length>0){
		var mbPanelMode='default';
		autoCreatData=false;
		autoCreatPanel=false;
	}




	//視窗縮放 判斷是否重新整理
	var tmpViewPoint=mbViewPointSet(setPoint);
	var nowViewPoint=mbViewPointSet(setPoint);
	$(window).resize(function(){
		nowViewPoint=mbViewPointSet(setPoint);
		if (nowViewPoint!=tmpViewPoint){
			// location.reload();
			window.location.href = window.location.href;
		}else{
			tmpViewPoint=nowViewPoint;
		}

	});



	//判斷是否已到手機尺寸
	var mbViewPoint=mbViewPointSet(setPoint);
	function mbViewPointSet(viewPoint){
		viewPoint=(viewPoint>0)?viewPoint:768;
		viewPoint='(max-width: '+viewPoint+'px)';
		viewPoint=window.matchMedia(viewPoint).matches;
		return viewPoint;
	}




	// ===========
	// 靜態(不是手機尺寸刪除#mbPanel)
	// ===========
	if(mbPanelMode=='default'){
		if(!mbViewPoint){
			if($("#mbPanel").length){
				$("#mbPanel").remove();
			}
		}
	}



	if(mbViewPoint){

		// ===========
		// 靜態 (將原body內容放到.mbPanel_page裡)
		// ===========
			if(mbPanelMode=='default'){
				// 清空body，將#mbPanel clone 並放在body之下
				if($("#mbPanel").length){
					var $bodyContent=$('.wrapper>*:not(script):not("#mbPanel")');
					$("#mbPanel").append($('<div class="mbPanel_page"></div>').append($('<div class="mbPanel_content"> </div>').append($bodyContent)));
				}
			}



		//=============
		// 自動建立 panel & data
		// creat Panel (mbPanelMode='auto',autoCreatPanel=true)
		// 依 mbPanel.data.js 建立 panel and data
		//=============
			if(autoCreatPanel){

				// 清空body，將#mbPanel clone 並放在body之下
				if($("#mbPanel").length){
					var mbPanel=$("#mbPanel").clone();
					$("body").html("").prepend(mbPanel);
				}else{
					//hide block
					if(typeof hideBlock!='undefined'){
						$(hideBlock).hide().addClass('disabled');
					}
					//define #mbPanel block
					var mbPanelWrap=(typeof mbPanelWrap=='undefined')? $("body>*:not(script)") : $(mbPanelWrap) ;
					mbPanelWrap.wrapAll("<div id='mbPanel' />");
				}

				var pageContent=$("#mbPanel").html();
				var tmpHtml="";
				$("#mbPanel").html("");
				$("#mbPanel").attr('data-mbPanel',mbPanelSet['effect']);
				$("#mbPanel").prepend(function(){

					jQuery.each(mbPanelSet['panels'],function(key,item){

							//creat content
							var itemContent=function(content){
								var contentHTML="";
								var contentID=(typeof content['id']==='undefined')?'':' id="'+content['id']+'" ';
								var contentType=(typeof content['type']==='undefined')?'':content['type'];
								var contentData=(typeof content['data']==='undefined')?'':setPanelData(content['data']);


								if (contentType=="panelMenu"){
									//panelMenu ： <ul class="panelMenu styleGrid" data-styleGrid="2x3"></ul>
									var contentStyleName=(typeof content['style'][0]==='undefined')?'':content['style'][0];
									var contentStyleType=(typeof content['style'][1]==='undefined')?'':' data-'+contentStyleName+'="'+content['style'][1]+'" ';
									contentHTML='<ul class="panelMenu '+contentStyleName+'" '+ contentStyleType + contentID+'>'+
												contentData+
												'</ul>';
								}else{
									contentHTML=contentData;
								}
								return contentHTML;
							}

							tmpHtml+='<div class="mbPanel_'+item['type']+' '+item['pos']+'" id="'+item['id']+'">'+
									 '<div class="mbPanel_content">'+
									 itemContent(item['content'])+
									 '</div>'+
									 '</div>';
					});

					if(pageContent!=""){
						tmpHtml+='<div class="mbPanel_page"><div class="mbPanel_content">'+pageContent+'</div></div>';
					}
					return tmpHtml;

				});
			}



		//=============
		// 自動建立資料
		// set Panel Data (mbPanelMode='autoData')
		//=============
			//指定區塊、及資料
			if(autoCreatData){
				jQuery.each(mbPanelData,function(key,item){
					$(item['target']).html(setPanelData(item['data']));
				});
			}




		//=============
		// set panel Data function
		//=============
			//判斷 型式 產生資料
			function setPanelData(item){
				var itemType=mbPanelDataSet[item]['type'];
				var itemData=mbPanelDataSet[item]['content'];
				var tmpHtml="";
				switch(itemType){
					case 'listLink':
						tmpHtml = getlistLink(itemData);
						break;
					case 'multiMenu':
						tmpHtml = getmultiMenu(itemData);
						break;
					default:
						break;
				}
				return tmpHtml;
			}

			// listLink
			// <a href="" class="showPanel" data-target="#mbPanel_navMenu">漢堡</a>
			function getlistLink(itemArray){
				var tmpHtml="";
				jQuery.each(itemArray,function(key,item){
					tmpHtml+='<a href="'+item['link']+'" class="'+item['class']+'" data-target="'+item['target']+'">'+item['content']+'</a>';
				});
				return tmpHtml;
			}
			// multiMenu
			function getmultiMenu(itemArray){
				var tmpHtml="";
				jQuery.each(itemArray,function(key,item){
					// no submenu
					if(item['submenu']==null || item['submenu']==undefined || item['submenu'].length<1){
						tmpHtml+='<li class=""><a href="'+item['link']+'" class="'+item['class']+'" data-target="'+item['target']+'">'+item['content']+'</a></li>';
					}else{
					// have submenu
						tmpHtml+='<li class="">';
						tmpHtml+='<a href="'+item['link']+'" class="moreMenu"><span>'+item['content']+'</span></a>';
						if(item['submenu'].length>0){
							tmpHtml+='<ul class="subMenu">';
							tmpHtml+=getmultiMenu(item['submenu']);
							tmpHtml+='</ul>';
						}
						tmpHtml+='</li>';
					}
				});

				return tmpHtml;

			}






		//=============
		// basic action
		//=============


			// // page delay show aftr .3s
			// $("body").css("opacity",0);
			// $(function(){setTimeout(function(){$("body").animate({"opacity":1})},300);});


			$(function(){

				//panel - open
					$("#mbPanel .showPanel").click(function(){
						var nowTarget=$(this).attr("data-target");
						//remove opened panel
						$(nowTarget).siblings().removeClass("open");
						//target open & set zindex
						var addClassTarget=[
							nowTarget,
							".mbPanel",
							"#mbPanel",
							"#mbPanel>.mbPanel_funNav",
							".mbPanel>.mbPanel_funNav",
							".mbPanel_page",
						];
						addClassTarget=addClassTarget.toString();
			 			$(addClassTarget).addClass("open");

			 			//body scroll disabled
						$("html,body").css("overflow","hidden");

						return false;
					});

				//panel - Page or funNav click then close Panel
					$(".mbPanel_page,.mbPanel_funNav").click(function(){
						if($(this).hasClass("open")){
							mbPanleCloseAction();
							return false;
						}
					});


				//panel - close btn ( if no target -> close closest panel )
					$("body").on('click','#mbPanel .closePanel',function(){
						var nowTarget=$(this).attr("data-target");

						if(typeof nowTarget=='undefined' || nowTarget==""){
							$(this).closest(".open").parent("li").siblings().show();
							$(this).closest(".open").removeClass("open");
						}else{
							$(nowTarget).parent("li").siblings().show();
							$(nowTarget).siblings().removeClass("open");
							$(nowTarget).removeClass("open");
						}

						if($("#mbPanel").children(".open").length<1){
							mbPanleCloseAction();
						}

						return false;
					});


				//panelMenu - open
					$("#mbPanel .panelMenu a").click(function(){
						if($(this).next(".subMenu").length>0){
							$(this).parent("li").siblings().hide();
							$(this).next(".subMenu").addClass("open");
							//add close btn
							if($(this).next(".subMenu").children(".closePanel").length<1){
								$(this).next(".subMenu").prepend('<li class="closePanel back"><a href=""><span>'+  $(this).html() +'</span></a></li>');
							}
						}
					});



				//scroll down/up panel_funNav show/hide

			        var nowPos=0;
			        var tmpPos=0;
			        var navTopH=$("#mbPanel .mbPanel_funNav.navTop").height();
			        var navBottomH=$("#mbPanel .mbPanel_funNav.navBottom").height();
			    	//function - get target children Height total
			    	var targetChildHeight = function(target){
			    		var tmpH=0;
				    	$(target).children().each(function(e){tmpH+=$(this).height(); });
						return tmpH;
			    	}
					//function - scroll to toggle hide
			    	function scrollNavHide(target){

				        $(window).on('scroll',function(){

				        	//for auto creat mbPanel
			        	    scrollBottom=targetChildHeight(scrollNavTarget)-$(window).height()-(navBottomH);

				        	//判斷是否執行function
				        	var funAction=!$(target).hasClass("open") && !$("#mbPanel").hasClass("open");

				        	//執行function
				    		if(funAction) {
					    		nowPos=$(window).scrollTop();
					    		// console.log("nowpos:"+nowPos);
					    		if((nowPos>tmpPos && nowPos>navTopH) && nowPos<scrollBottom){
					    		    // console.log("scrolldown");
					    		    $("#mbPanel .mbPanel_funNav").addClass("hide");
					    		}else{
					    		    // console.log("srollup");
					    		    $("#mbPanel .mbPanel_funNav").removeClass("hide");
					    		}
					    		tmpPos=nowPos;
				    		}

			    		    return false;
				        });
			    	}

			    	//scroll to toggle hide
			    	var scrollNavTarget='#mbPanel .mbPanel_page';
			    	// var scrollNavTarget='.mbPanel_page';
			    	// var scrollNavTarget='.mbPanel_page .mbPanel_content';

			        if($(scrollNavTarget).length>0){
			        	var scrollBottom=targetChildHeight(scrollNavTarget)-$(window).height()-(navBottomH);
				        scrollNavHide(scrollNavTarget);
			        }







			});


			function mbPanleCloseAction(){
				var removeClassTarget=[
					"#mbPanel",
					".mbPanel",
					"#mbPanel .open",
					".mbPanel .open",
				];
				removeClassTarget=removeClassTarget.toString();
	 			$(removeClassTarget).removeClass("open");
				$("#mbPanel .panelMenu li").show();
				$(".mbPanel .panelMenu li").show();
				$("html,body").css("overflow","");
			}


	 }




}
