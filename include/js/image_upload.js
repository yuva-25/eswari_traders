jQuery(document).ready(function () {
	if (jQuery('#logo').length > 0) {
		jQuery('#logo').change(function (event) {
			if (jQuery('#logo_cover').find('.alert').length > 0) {
				jQuery('#logo_cover').find('.alert').remove();
			}
			var count = jQuery(this).get(0).files.length;
			if (count != 0) {
				upload_files(this, 'logo', '0');
			}
		});
	}
});

jQuery(document).ready(function () {
	if (jQuery('#watermark').length > 0) {
		jQuery('#watermark').change(function (event) {
			if (jQuery('#watermark_cover').find('.alert').length > 0) {
				jQuery('#watermark_cover').find('.alert').remove();
			}
			var count = jQuery(this).get(0).files.length;
			if (count != 0) {
				upload_files(this, 'watermark', '0');
			}
		});
	}
});

function upload_files(obj, field) {
	// alet('hai');
	var fileName = jQuery(obj).get(0).files[0];
	var image_type = fileName.type;

	var idxDot = fileName.name.lastIndexOf(".") + 1;
	var extFile = fileName.name.substr(idxDot, fileName.name.length).toLowerCase();
	if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
		var image_size = fileName.size;
		if (image_size < 2000000) { 			
			var width = ""; var height = "";
			var reader = new FileReader();
			reader.readAsDataURL(fileName);
			reader.onload = function (event) {
				var image = new Image();
				image.src = event.target.result;
				image.onload = function () {
					// if (field == "logo" || field == "product_image" || field == "member_photo") {
					jQuery("#" + field + "_preview").fadeIn("fast").attr('src', event.target.result);
					var image_url = event.target.result;
					var request = jQuery.ajax({ url: "image_upload.php", type: "POST", data: { "image_url": image_url, "image_type": image_type, "field": field } });
					request.done(function (result) {
						var msg = result;
						jQuery('#' + field + '_cover .cover').html(msg);
					});
					// }
				}
			}
		} else {
			if (jQuery('div.alert').length > 0) {
				jQuery('div.alert').remove();
			}
			 jQuery('#' + field + '_cover .cover').before('<div class="alert alert-danger w-100 text-center">Image size is greater than 2MB</div>');
		}
	} else {
		if (jQuery('div.alert').length > 0) {
			jQuery('div.alert').remove();
		}
		jQuery('#' + field + '_cover .cover').before('<div class="alert alert-danger w-100 text-center">Please upload only Image</div>');
	}
}

function delete_upload_image_before_save(obj, field, delete_image_file) {

	jQuery(obj).parent().html('<img src="include/images/cloudupload.png" style="max-width: 150px;" id="' + field + '_preview"/>');

}

