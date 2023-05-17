//      /* image url */
//      var IMAGE_URL = 'images/';
//      
//      //jQuery.noConflict();
//      //jQuery(function($) {
//      
//      $(document).ready(function() {
//      
//      	/* toggle boxes
//      	------------------------------------------------------------------------- */
//      	$('.box > h2').append('<img src="' + assets_url + template_path + '/images/icons/arrow_state_grey_expanded.png" class="toggle" />');
//      	$('img.toggle').click(function() {
//      		$(this).parent().next().slideToggle(200);
//      	});
//      	$('.box + .closed > section').hide();
//      	
//      	/* sortable table rows
//      	------------------------------------------------------------------------- */
//      	/* gisanfu mark
//      	var fixHelper = function(e, ui) {
//      		ui.children().each(function() {
//      			$(this).width($(this).width());
//      		});
//      		return ui;
//      	};
//      	$('table.sortable tbody').sortable({
//      		handle: 'img.move',
//      		helper: fixHelper,
//      		placeholder: 'ui-state-highlight',
//      		forcePlaceholderSize: true
//      	}).disableSelection();
//      	*/
//      
//      	/* sortable photos
//      	------------------------------------------------------------------------- */
//      	//$('ul.sortable').sortable({
//      	//	placeholder: 'ui-state-highlight',
//      	//	forcePlaceholderSize: true
//      	//});
//      	
//      	/* checkall
//      	------------------------------------------------------------------------- */
//      	var togel = false;
//      	$('#table1 .checkall').click(function() {
//      		$('#table1 :checkbox').attr('checked', !togel);
//      		togel = !togel;
//      	});
//      	var togel2 = false;
//      	$('#table2 .checkall').click(function() {
//      		$('#table2 :checkbox').attr('checked', !togel2);
//      		togel2 = !togel2;
//      	});
//      
//      	/* detail table
//      	------------------------------------------------------------------------- */
//      	$('table.detailtable tr.detail').hide();
//      	$('table.detailtable > tbody > tr:nth-child(4n-3)').addClass('odd');
//      	$('table.detailtable > tbody > tr:nth-child(4n-1)').removeClass('odd').addClass('even');
//      	$('a.detail-link').click(function() {
//      		$(this).parent().parent().next().fadeToggle();
//      		return false;
//      	});
//      	
//      	/* superfish menu
//      	------------------------------------------------------------------------- */
//      	$('ul.sf-menu').superfish({
//      		delay: 107,
//      		animation: false,
//      		dropShadows: false
//      	});
//      
//      	/* message boxes
//      	------------------------------------------------------------------------- */
//      	$('.msg').click(function() {
//      		$(this).fadeTo('slow', 0);
//      		$(this).slideUp(341);
//      	});
//      
//      	/* wysiwyg editor
//      	------------------------------------------------------------------------- */
//      	$('#wysiwyg').wysiwyg();
//      	$('#newscontent').wysiwyg();
//      
//      	/* facebox
//      	------------------------------------------------------------------------- */
//      	//$('a[rel*=facebox]').facebox();
//      
//      	/* date picker
//      	------------------------------------------------------------------------- */
//      	//$('#dob').datepicker({
//      	//	changeMonth: true,
//      	//	changeYear: true
//      	//});
//      	//$('#newsdate').datepicker();
//      
//      	/* accordion
//      	------------------------------------------------------------------------- */
//      	$('.accordion > h3:first-child').addClass('active');
//      	$('.accordion > div').hide();
//      	$('.accordion > h3:first-child').next().show();
//      	$('.accordion > h3').click(function() {
//      		if ($(this).hasClass('active')) {
//      			return false;
//      		}
//      		$(this).parent().children('h3').removeClass('active');
//      		$(this).addClass('active');
//      		$(this).parent().children('div').slideUp(200);
//      		$(this).next().slideDown(200);
//      	});
//      
//      	/* tabs
//      	------------------------------------------------------------------------- */
//      	//$('.tabcontent > div').hide();
//      	$('.tabcontent > div:first-child').show();
//      	$('.tabs > li:first-child').addClass('selected');
//      	$('.tabs > li a').click(function() {
//      		var tab_id = $(this).attr('href');
//      		$(tab_id).parent().children().hide();
//      		$(tab_id).fadeIn();
//      		$(this).parent().parent().children().removeClass('selected');
//      		$(this).parent().addClass('selected');
//      		return false;
//      	});
//      
//      	// 本來是先隱藏，在處理，現在處理後，全開，最後才模擬按第1個，因為有些東西藏起來是沒有辦法init的
//      	// 這行會放在最下面，等大家都init完了以後
//      	//$('.tabs > li a').eq(0).click();
//      	
//      	/* form validation
//      	------------------------------------------------------------------------- */
//      	$('#myForm').validate();
//      	
//      	/* uniform
//      	------------------------------------------------------------------------- */
//      	$('.uniform input[type="checkbox"], .uniform input[type="radio"], .uniform input[type="file"]').uniform();
//      
//      	/* cufon
//      	------------------------------------------------------------------------- */
//      	//Cufon.replace('#site-title');
//      	//Cufon.replace('article > h1');
//      	//Cufon.replace('article > h2');
//      	//Cufon.replace('article > h3');
//      	//Cufon.replace('article > h4');
//      	//Cufon.replace('article > h5');
//      	//Cufon.replace('article > h6');
//      
//      });

	// http://codeboxlabs.com/number-format-function-javascript/
    function number_format(number, decimals, dec_point, thousands_sep) {
        // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
        // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +     bugfix by: Michael White (http://getsprink.com)
        // +     bugfix by: Benjamin Lupton
        // +     bugfix by: Allan Jensen (http://www.winternet.no)
        // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
        // +     bugfix by: Howard Yeend
        // +    revised by: Luke Smith (http://lucassmith.name)
        // +     bugfix by: Diogo Resende
        // +     bugfix by: Rival
        // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
        // +   improved by: davook
        // +   improved by: Brett Zamir (http://brett-zamir.me)
        // +      input by: Jay Klehr
        // +   improved by: Brett Zamir (http://brett-zamir.me)
        // +      input by: Amir Habibi (http://www.residence-mixte.com/)
        // +     bugfix by: Brett Zamir (http://brett-zamir.me)
        // +   improved by: Theriault
        // *     example 1: number_format(1234.56);
        // *     returns 1: '1,235'
        // *     example 2: number_format(1234.56, 2, ',', ' ');
        // *     returns 2: '1 234,56'
        // *     example 3: number_format(1234.5678, 2, '.', '');
        // *     returns 3: '1234.57'
        // *     example 4: number_format(67, 2, ',', '.');
        // *     returns 4: '67,00'
        // *     example 5: number_format(1000);
        // *     returns 5: '1,000'
        // *     example 6: number_format(67.311, 2);
        // *     returns 6: '67.31'
        // *     example 7: number_format(1000.55, 1);
        // *     returns 7: '1,000.6'
        // *     example 8: number_format(67000, 5, ',', '.');
        // *     returns 8: '67.000,00000'
        // *     example 9: number_format(0.9, 0);
        // *     returns 9: '1'
        // *    example 10: number_format('1.20', 2);
        // *    returns 10: '1.20'
        // *    example 11: number_format('1.20', 4);
        // *    returns 11: '1.2000'
        // *    example 12: number_format('1.2000', 3);
        // *    returns 12: '1.200'
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

// http://phpjs.org/functions/nl2br/
function nl2br (str, is_xhtml) {
  // http://kevin.vanzonneveld.net
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: Philip Peterson
  // +   improved by: Onno Marsman
  // +   improved by: Atli Þór
  // +   bugfixed by: Onno Marsman
  // +      input by: Brett Zamir (http://brett-zamir.me)
  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // +   improved by: Maximusya
  // *     example 1: nl2br('Kevin\nvan\nZonneveld');
  // *     returns 1: 'Kevin<br />\nvan<br />\nZonneveld'
  // *     example 2: nl2br("\nOne\nTwo\n\nThree\n", false);
  // *     returns 2: '<br>\nOne<br>\nTwo<br>\n<br>\nThree<br>\n'
  // *     example 3: nl2br("\nOne\nTwo\n\nThree\n", true);
  // *     returns 3: '<br />\nOne<br />\nTwo<br />\n<br />\nThree<br />\n'
  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

  return (str + '').replace('/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g', '$1' + breakTag + '$2');
}

function base64_encode (data) {
    // http://kevin.vanzonneveld.net
    // +   original by: Tyler Akins (http://rumkin.com)
    // +   improved by: Bayron Guevara
    // +   improved by: Thunder.m
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Pellentesque Malesuada
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Rafał Kukawski (http://kukawski.pl)
    // -    depends on: utf8_encode
    // *     example 1: base64_encode('Kevin van Zonneveld');
    // *     returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
    // mozilla has this native
    // - but breaks in 2.0.0.12!
    //if (typeof this.window['atob'] == 'function') {
    //    return atob(data);
    //}
    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
        ac = 0,
        enc = "",
        tmp_arr = [];

    if (!data) {
        return data;
    }

    data = this.utf8_encode(data + '');

    do { // pack three octets into four hexets
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);
        o3 = data.charCodeAt(i++);

        bits = o1 << 16 | o2 << 8 | o3;

        h1 = bits >> 18 & 0x3f;
        h2 = bits >> 12 & 0x3f;
        h3 = bits >> 6 & 0x3f;
        h4 = bits & 0x3f;

        // use hexets to index into b64, and append result to encoded string
        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
    } while (i < data.length);

    enc = tmp_arr.join('');
    
    var r = data.length % 3;
    
    //return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);

    var ggg = (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
	//alert(ggg);
	//ggg = ggg.replace(/=/g, '');
	//ggg = ggg.replace(/-/g, '*');
	//ggg = ggg.replace(/\//g, '+');

	ggg = ggg.replace(/\+/g, '*');
	ggg = ggg.replace(/\//g, '_');
	ggg = ggg.replace(/=/g, ',');

	return ggg;

}

function utf8_encode (argString) {
    // Encodes an ISO-8859-1 string to UTF-8  
    // 
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/utf8_encode    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: sowberry
    // +    tweaked by: Jack
    // +   bugfixed by: Onno Marsman    // +   improved by: Yves Sucaet
    // +   bugfixed by: Onno Marsman
    // +   bugfixed by: Ulrich
    // +   bugfixed by: Rafal Kukawski
    // *     example 1: utf8_encode('Kevin van Zonneveld');    // *     returns 1: 'Kevin van Zonneveld'
    if (argString === null || typeof argString === "undefined") {
        return "";
    }
     var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
    var utftext = "",
        start, end, stringl = 0;
 
    start = end = 0;    stringl = string.length;
    for (var n = 0; n < stringl; n++) {
        var c1 = string.charCodeAt(n);
        var enc = null;
         if (c1 < 128) {
            end++;
        } else if (c1 > 127 && c1 < 2048) {
            enc = String.fromCharCode((c1 >> 6) | 192) + String.fromCharCode((c1 & 63) | 128);
        } else {            enc = String.fromCharCode((c1 >> 12) | 224) + String.fromCharCode(((c1 >> 6) & 63) | 128) + String.fromCharCode((c1 & 63) | 128);
        }
        if (enc !== null) {
            if (end > start) {
                utftext += string.slice(start, end);            }
            utftext += enc;
            start = end = n + 1;
        }
    } 
    if (end > start) {
        utftext += string.slice(start, stringl);
    }
     return utftext;
}
