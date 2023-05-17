/*
 * @image_ext  ['jpg', 'jpeg', 'png', 'gif']
 * @document_ext ['doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'csv', 'wmv', 'mpg', 'mp4', 'avi', 'mov', 'zip', 'pptx', 'ppt', 'pdf', 'rar', 'ai', 'tif', 'tiff', 'igs', 'dxf', 'jpg', 'jpeg', 'png', 'gif', 'stp']
 */
var dragsort = ToolMan.dragsort();
var junkdrawer = ToolMan.junkdrawer();

function createuploader_multi(path, field, num, type, image_ext, document_ext, o_image_thumb_tmp_path, o_file_upload_tmp_path, o_image_upload_path, a, b, class_url, subfield){
	var ext;
	var tmpdir;

	if(type == 'image'){
		ext = image_ext;
		tmpdir = o_image_thumb_tmp_path;
	} else if(type == 'document'){
		ext = document_ext;
		tmpdir = o_file_upload_tmp_path;
	}

	var options = {
		element: document.getElementById('file-uploader' + field),
		action: class_url + '/upload',
		//debug: true,
		params: {'path': path, 'type': type, 'width': a, 'height': b},
		allowedExtensions: ext,
		multiple: true,
		template:
			'<div class="qq-uploader">' + 
			'<ul class="qq-upload-list"></ul>' + 
			'<span class="qq-upload-button">' + l.get('Upload') + '</span>' +
			'&nbsp;<span class="qq-delete-button">' + l.get('Delete') + '</span>' +
			'</div>',
		fileTemplate: 
			'<li>*上傳檔案:' +
			'<span class="qq-upload-file"></span>' +
			'<span class="qq-upload-spinner"></span>' +
			'<span class="qq-upload-size"></span>' +
			'<a class="qq-upload-cancel" href="#">' + l.get('Cancel')  + '</a>' +
			'<span class="qq-upload-failed-text">' + l.get('Failed') + '</span>' +
			'</li>',        
		messages: {
			typeError: l.get("{file} has invalid extension. Only {extensions} are allowed."),
			sizeError: l.get("{file} is too large, maximum file size is {sizeLimit}."),
			minSizeError: l.get("{file} is too small, minimum file size is {minSizeLimit}."),
			emptyError: l.get("{file} is empty, please select files again without it."),
			onLeave: l.get("The files are being uploaded, if you leave now the upload will be cancelled.") 
		},
		onSubmit: function(id, fileName){
			//equilibriumH();
			// 把上一個上傳的項目，不管成功或失敗，都移除掉，不然會一直增加，除非你要
			$('#file-uploader' + field).find('.qq-upload-success').remove();
			$('#file-uploader' + field).find('.qq-upload-fail').remove();
		},
		onComplete: function(id, fileName, obj){
			if(obj.success == true){
				if(type == 'image'){
var htmlimage = vir_path_c + tmpdir + '/'+a +'x' + b + '_' + obj.filename;
var htmlhidden = '<input type="hidden" name="uploads['+field+']['+id+']" value="'+obj.filename+'" />';

var html_content = '';

//{{if !empty($subfield) }}
//	{{foreach from=$subfield key=kk item=vv}}
//		html_content += '<div class="controlItem"><span>{{$vv.label}}</span>';
//		html_content += '<span>';
//		{{if $vv.type == 'text'}}
//			html_content += '<input type="text" class="dont_drag_me" name="uploads_attr['+field+'][{{$kk}}]['+id+']" value="{{$v.$kk}}" /><br />';
//		{{elseif $vv.type == 'radio'}}
//			{{if !empty($vv.other) }}
//				{{foreach from=$vv.other key=kkk item=vvv}}
//					{{assign var="a" value=""}}{{*0*}}
//					{{assign var="b" value=""}}{{*1*}}
//					{{if $vvv.value == "0"}}
//						{{assign var="a" value="checked"}}{{*0*}}
//					{{elseif $vvv.value == "1"}}
//						{{assign var="b" value="checked"}}{{*1*}}
//					{{/if}}
//					html_content += '<label><input type="radio" name="uploads_attr['+field+'][{{$kk}}]['+id+']" value="{{$vvv.value}}" {{abcn 1=$b 0=$a}}{{$v.$kk}}{{/abcn}} />{{$vvv.label}}</label>';
//				{{/foreach}}
//				html_content += '';
//			{{/if}}
//		{{/if}}
//		html_content += '</span></div>';
//	{{/foreach}}
//{{/if}}

$.each(subfield, function(k, v) {
	//alert(v.type);
		html_content += v.label+': ';
		//html_content += '<span>';
		if(v.type == 'text'){
			html_content += '<input type="text" class="dont_drag_me" size="10" name="uploads_attr['+field+']['+k+']['+id+']" value="" /><br />';
		} else if(v.type == 'radio'){
			$.each(v.other, function(kk, vv) {
				//{{assign var="a" value=""}}{{*0*}}
				//{{assign var="b" value=""}}{{*1*}}
				//{{if $vv.value == "0"}}
				//	{{assign var="a" value="checked"}}{{*0*}}
				//{{elseif $vv.value == "1"}}
				//	{{assign var="b" value="checked"}}{{*1*}}
				//{{/if}}
				html_content += '<label><input type="radio" name="uploads_attr['+field+']['+k+']['+id+']" value="" />'+vv.label+'</label>';
			});
		}
		html_content += '</span></div>';
});

var licontent = htmlhidden;
licontent += '    <div class="dragBar" id="fileuploader_li_'+field+'_'+id+'_dragarea"><span>排序移動</span></div>';
licontent += '    <div><img width="'+a+'" height="'+b+'" src="' + htmlimage  + '" /></div>';
licontent += '    <div class="links">';
licontent += '    <a class="delete" href="javascript:;" onclick="$(this).parent().parent().remove()">刪除</a><br />';
licontent += html_content;
licontent += '    </div>';
var htmlcontent = '<li id="fileuploader_li_'+field+'_'+id+'" class="item fileuploader_li_'+field+'">'+licontent+'</li>';
					$('#fileuploader_collection_'+field).append(htmlcontent);
					//$('.fileuploader_li_'+field).hover(
					//	function(){
					//		//$(this).css('opacity', '0.5');
					//		$(this).find('.content_attr').css('display', 'block');
					//	},
					//	function(){
					//		//$(this).css('opacity', '1');
					//		$(this).find('.content_attr').css('display', 'none');
					//	}
					//);
					junkdrawer.restoreListOrder('fileuploader_collection_'+field);
					//dragsort.makeListSortable(document.getElementById('fileuploader_collection_'+field), toolman_register_dragstart);
					//dragsort.makeListSortable(document.getElementById('fileuploader_collection_'+field));
					dragsort.makeListSortable(document.getElementById('fileuploader_collection_'+field), setHandle);
				} else if(type == 'document'){
					$('#fileuploader_document_download__' + field).attr('href', base_url + '/' + o_file_upload_tmp_path + '/' + obj.filename);
					$('#fileuploader_document_download__' + field).css('display', 'block');
				}
				//equilibriumH();
			}
			//this.enable();
		}
	};

	//options.button = document.getElementById('fileuploader_top_button_' + field);

	var uploader = new qq.FileUploader(options);

	$('#file-uploader' + field).find('.qq-delete-button').click(function(){
		$('#' + field).attr('value', '');
		$('#image_' + field).attr('src', '/' + o_image_upload_path + '/_system/' + type + '.png');

		$('#fileuploader_document_download__' + field).attr('href', '');
		$('#fileuploader_document_download__' + field).css('display', 'none');

		$(this).parent().find('.qq-upload-list').html('');

		return false;
	});

	//$('#file-uploader' + field).find('.qq-upload-button').css('display', 'none');
	$('#file-uploader' + field).find('.qq-delete-button').css('display', 'none');

	//$('.fileuploader_li_'+field).hover(
	//	function(){
	//		$(this).find('.content_attr').css('display', 'block');
	//	},
	//	function(){
	//		$(this).find('.content_attr').css('display', 'none');
	//	}
	//);

	// 註冊一個東西，讓拖拉的同時，把該設定視窗hide起來
	//function toolman_register_dragstart(item){
	//	var group = item.toolManDragGroup
	//	group.register('dragstart', function() {
	//		$(this).find('.content_attr').css('display', 'none');
	//	});
	//}

	//function toolman_register_saveorder(item) {
	//	var group = item.toolManDragGroup
	//	var list = group.element.parentNode
	//	var id = list.getAttribute("id")
	//	if (id == null) return
	//	group.register('dragend', function() {
	//		ToolMan.cookies().set("list-" + id, 
	//				junkdrawer.serializeList(list), 365)
	//	})
	//}

	junkdrawer.restoreListOrder('fileuploader_collection_'+field);
	//dragsort.makeListSortable(document.getElementById('fileuploader_collection_'+field), toolman_register_dragstart);
	dragsort.makeListSortable(document.getElementById('fileuploader_collection_'+field), setHandle);

	function setHandle(item) {
		item.toolManDragGroup.setHandle(findHandle(item))
	}

	function findHandle(item) {
		var idname = item.id;
		return document.getElementById(idname+'_dragarea');
	}

	// 取得順序的範例
	//junkdrawer.inspectListOrder('swfuploader_collection_'+field);

	// 搜尋功能
	$('.fileuploader_multi_search_' + field).change(function(){
		var ids_tmp = $(this).attr('id');
		// fileuploader_multi_id_{a{$field}}_{a{$k}}
		var ids = ids_tmp.split('_');
		var action_field = ids[4];
		var action_field_select_value = $(this).attr('value');
		if(action_field_select_value == ''){
			$('#fileuploader_collection_' + field + ' li').each(function(index){
				$(this).removeClass('none');
			});
			return false;
		}
		$('#fileuploader_collection_' + field + ' li').each(function(index){
			$(this).addClass('none');
		});
		$('#fileuploader_collection_' + field + ' li').each(function(index){
			var action_field_value = $(this).find('.fileuploader_multi_text_'+field+'_'+action_field).attr('value');
			if(action_field_value == action_field_select_value){
				$(this).removeClass('none');
			}
		});
	});
}
