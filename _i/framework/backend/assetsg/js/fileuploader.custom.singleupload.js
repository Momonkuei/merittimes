/*
 * @no_need_delete_button string 0或是1，1代表不要刪除按鈕
 * @image_ext  ['jpg', 'jpeg', 'png', 'gif']
 * @document_ext ['doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'csv', 'wmv', 'mpg', 'mp4', 'avi', 'mov', 'zip', 'pptx', 'ppt', 'pdf', 'rar', 'ai', 'tif', 'tiff', 'igs', 'dxf', 'jpg', 'jpeg', 'png', 'gif', 'stp']
 */
function createuploader_single(path, field, num, type, image_ext, document_ext, o_image_thumb_tmp_path, o_file_upload_tmp_path, o_image_upload_path, a, b, class_url, top_button, no_need_delete_button){
	var ext;
	var tmpdir;

	top_button = top_button || '0';
	no_need_delete_button = no_need_delete_button || '0';

	if(type == 'image'){
		ext = image_ext;
		tmpdir = o_image_thumb_tmp_path;
	} else if(type == 'document'){
		ext = document_ext;
		tmpdir = o_file_upload_tmp_path;
	}

	var options = {
		element: document.getElementById('file-uploader' + num),
		action: class_url + '/upload',
		//debug: true,
		params: {'path': path, 'type': type, 'width': a, 'height': b},
		allowedExtensions: ext,
		multiple: false,
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
			// 把上一個上傳的項目，不管成功或失敗，都移除掉，不然會一直增加，除非你要
			$('#file-uploader' + num).find('.qq-upload-success').remove();
			$('#file-uploader' + num).find('.qq-upload-fail').remove();
		},
		onComplete: function(id, fileName, obj){
			if(obj.success == true){
				if(type == 'image'){
					var filenames = fileName.split('.');
					var ext = filenames[1];
					if(ext == 'svg'){
						// dirty hack
						$('#image_' + field).attr('src', base_url + '/assets/upload_tmp/' + obj.filename + '?token=' + $.random(99999999));
					} else if(ext == 'webp'){
						// dirty hack
						$('#image_' + field).attr('src', base_url + '/assets/upload_tmp/' + obj.filename + '?token=' + $.random(99999999));
					} else if(ext == 'dng'){
						// dirty hack
						$('#image_' + field).attr('src', base_url + '/assets/upload_tmp/' + obj.filename + '?token=' + $.random(99999999));
					} else {
						$('#image_' + field).attr('src', base_url + '/' + tmpdir + '/' + a + 'x' + b + '_' + obj.filename + '?token=' + $.random(99999999));
					}
					//alert(base_url + '/' + tmpdir + '/' + a + 'x' + b + '_' + obj.filename);
					//$('#image_' + field).css('width', '{{$a}}px');
				} else if(type == 'document'){
					//這裡看起來寫錯了，順便修一下
					$('#fileuploader_document_download__' + field).attr('href', base_url + '/' + o_file_upload_tmp_path + '/' + obj.filename);
					//$('#fileuploader_document_download__' + field).attr('href', base_url + '/' + tmp_path + '/' + obj.filename);
					$('#fileuploader_document_download__' + field).css('display', 'block');
				}
				$('#' + field).val(obj.filename);
				$('#' + field + '___origin').val(obj.origin);
				$('#file-uploader' + num).find('.qq-upload-size').html('上傳成功');
				alert('"' + fileName + '" ' + l.get('Upload success'));
			}
			//this.enable();
		}
	};

	if(top_button == '1'){
		options.button = document.getElementById('fileuploader_top_button_' + num);
	}

	var uploader = new qq.FileUploader(options);

	$('#file-uploader' + num).find('.qq-delete-button').click(function(){
		$('#' + field).attr('value', '');
		$('#image_' + field).attr('src', '/' + o_image_upload_path + '/_system/' + type + '.png');

		$('#fileuploader_document_download__' + field).attr('href', '');
		$('#fileuploader_document_download__' + field).css('display', 'none');

		$(this).parent().find('.qq-upload-list').html('');

		return false;
	});

	$('#fileuploader_top_button_delete_' + num).click(function(){
		$('#' + field).attr('value', '');
		$('#image_' + field).attr('src', '/' + o_image_upload_path + '/_system/' + type + '.png');

		$('#fileuploader_document_download__' + field).attr('href', '');
		$('#fileuploader_document_download__' + field).css('display', 'none');

		$('#file-uploader'+num).find('.qq-upload-list').html('');

		return false;
	});

	if(no_need_delete_button != '0'){
		$('#file-uploader' + num).find('.qq-delete-button').css('display', 'none');
		$('#fileuploader_top_button_delete_' + num).css('display', 'none');
	}

	if(top_button == '1'){
		$('#file-uploader' + num).find('.qq-upload-button').css('display', 'none');
		$('#file-uploader' + num).find('.qq-delete-button').css('display', 'none');
	}
}
