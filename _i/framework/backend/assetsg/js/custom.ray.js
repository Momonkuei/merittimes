/* image url */
var IMAGE_URL = 'images/';
var OldSortIds=[];

jQuery.noConflict();

jQuery(function($) {
	
	$('*[title]:not([title=""])').qtip({
		content: { text: false },
		position: { corner: { target: 'topRight', tooltip: 'topLeft'} },
		style: 'cream'
	})

	/* toggle boxes
	------------------------------------------------------------------------- */
	$('.box > h2').append('<img src="' + IMAGE_URL + 'icons/arrow_state_grey_expanded.png" class="toggle" />');
	$('img.toggle').click(function() {
		$(this).parent().next().slideToggle(200);
	});
	$('.box + .closed > section').hide();
	
	/* sortable table rows
	------------------------------------------------------------------------- */
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	$('table.sortable tbody').sortable({
		handle: 'img.move',
		helper: fixHelper,
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true,
		start: function (){
			OldSortIds = [];
			jQuery('img[id^=sortid]').each(function(){
				OldSortIds.push(jQuery(this).attr('id').replace('sortid_',''));
			});
		},
		stop: function (){
			var NewSortIds = [];
			jQuery('img[id^=sortid]').each(function(){
				NewSortIds.push(jQuery(this).attr('id').replace('sortid_',''));
			});
			if(typeof(sortable_stop)=="function") sortable_stop(OldSortIds,NewSortIds);
		}
	}).disableSelection();

	/* sortable photos
	------------------------------------------------------------------------- */
	$('ul.sortable').sortable({
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true,
		start: function (){
			OldSortIds = [];
			jQuery('img[id^=sortid]').each(function(){
				OldSortIds.push(jQuery(this).attr('id').replace('sortid_',''));
			});
		},
		stop: function (){
			var NewSortIds = [];
			jQuery('img[id^=sortid]').each(function(){
				NewSortIds.push(jQuery(this).attr('id').replace('sortid_',''));
			});
			if(typeof(sortable_stop)=="function") sortable_stop(OldSortIds,NewSortIds);
		}
	});
	
	/* checkall
	------------------------------------------------------------------------- */
	var togel = false;
	$('#list_main .checkall').click(function() {
		$('#list_main :checkbox').attr('checked', !togel);
		togel = !togel;
	});

	/* detail table
	------------------------------------------------------------------------- */
	$('table.detailtable tr.detail').hide();
	$('table.detailtable > tbody > tr:nth-child(4n-3)').addClass('odd');
	$('table.detailtable > tbody > tr:nth-child(4n-1)').removeClass('odd').addClass('even');
	$('a.detail-link').click(function() {
		$(this).parent().parent().next().fadeToggle();
		return false;
	});
	
	/* superfish menu
	------------------------------------------------------------------------- */
	$('ul.sf-menu').superfish({
		delay: 107,
		animation: false,
		dropShadows: false
	});

	/* left menu
	------------------------------------------------------------------------- */
	$('#leftmenu a[href=#]').click(function (){
		if($(this).next('ul').length>0){
			$(this).next('ul').slideToggle(500);
		}
	})
	
	/* message boxes
	------------------------------------------------------------------------- */
	$('.msg').click(function() {
		$(this).fadeTo('slow', 0);
		$(this).slideUp(341);
	});

	/* wysiwyg editor
	------------------------------------------------------------------------- */
	//$('#wysiwyg').wysiwyg();
	$('textarea.html').wysiwyg();

	/* facebox
	------------------------------------------------------------------------- */
	$('a[rel*=facebox]').facebox();

	/* date picker
	------------------------------------------------------------------------- */
	$.datepicker.setDefaults({
		dateFormat: 'yy-mm-dd',
		dayNames: ['日','一','二','三','四','五','六'],
		dayNamesMin: ['日','一','二','三','四','五','六'],
		dayNamesShort: ['日','一','二','三','四','五','六'],
		monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
		monthNamesShort: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
		prevText: '上一月',
		nextText: '下一月',
		constrainInput: true,
		showMonthAfterYear: true
	});
	$('#dob').datepicker({
		changeMonth: true,
		changeYear: true
	});
	$(':input.date').datepicker();

	/* accordion
	------------------------------------------------------------------------- */
	$('.accordion > h3:first-child').addClass('active');
	$('.accordion > div').hide();
	$('.accordion > h3:first-child').next().show();
	$('.accordion > h3').click(function() {
		if ($(this).hasClass('active')) {
			return false;
		}
		$(this).parent().children('h3').removeClass('active');
		$(this).addClass('active');
		$(this).parent().children('div').slideUp(200);
		$(this).next().slideDown(200);
	});

	/* tabs
	------------------------------------------------------------------------- */
	$('.tabcontent > div').hide();
	$('.tabcontent > div:first-child').show();
	$('.tabs:not(.notauto) > li:first-child').addClass('selected');
	$('.tabs:not(.notauto) > li a').click(function() {
		var tab_id = $(this).attr('href');
		$(tab_id).parent().children().hide();
		$(tab_id).fadeIn();
		$(this).parent().parent().children().removeClass('selected');
		$(this).parent().addClass('selected');
		return false;
	});
	
	/* form validation
	------------------------------------------------------------------------- */
	//$('#info_form').validate();
	
	/* uniform
	------------------------------------------------------------------------- */
	//$('.uniform input[type="checkbox"], .uniform input[type="radio"]').uniform();
	$('.uniform input[type="file"]:not(.file)').uniform();

	/* cufon
	------------------------------------------------------------------------- */
	Cufon.replace('#site-title');
	Cufon.replace('article > h1');
	Cufon.replace('article > h2');
	Cufon.replace('article > h3');
	Cufon.replace('article > h4');
	Cufon.replace('article > h5');
	Cufon.replace('article > h6');

});