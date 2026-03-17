<?php

include("include_files.php");
$create_date_time = $GLOBALS['create_date_time_label'];
$creator = $GLOBALS['creator'];
$msg = "";
$image_name = "";
$field_name = "";
$image_data = "";
$extension = "";
$preview_name = "";
$temp_dir = $obj->temp_image_directory();
if (isset($_POST['image_url'])) {
	$image_url = $_POST['image_url'];
	$image_type = $_POST['image_type'];
	$preview_name = $_POST['field'];
	if (!empty($preview_name)) {
		$field_name = $preview_name;
		$image_name = $preview_name . "_" . date("d_m_Y_h_i_s");
	}
	if (!empty($image_name)) {
		$display_page = $field_name;
		if (!empty($image_url)) {
			$image_upload = 0;
			switch ($image_type) {
				case 'jpeg':
					$extension = "jpeg";
					$image_upload = 1;
					break;
				case 'jpg':
					$extension = "jpg";
					$image_upload = 1;
					break;
				case 'png':
					$extension = "png";
					$image_upload = 1;
					break;
				case 'image/jpeg':
					$extension = "jpeg";
					$image_upload = 1;
					break;
				case 'image/jpg':
					$extension = "jpg";
					$image_upload = 1;
					break;
				case 'image/png':
					$extension = "png";
					$image_upload = 1;
					break;
			}
		}
		if ($image_upload == 1) {
			if (!empty($image_name)) {
				$image_name = $image_name . "." . $extension;
			}
			if (file_exists($temp_dir . $image_name)) {
				unlink($temp_dir . $image_name);
			}
			if (strpos($image_url, ',') !== false) {
				$image_data = explode(',', $image_url);
				$image_value = "";
				$image_value = base64_decode($image_data[1]);
				$destination = $temp_dir . $image_name;
				file_put_contents($destination, $image_value);
				$success = 1;
				if (!empty($success)) {
					$webp_image = "";
					if (!empty($image_name) && file_exists($temp_dir . $image_name)) {
						$folder_image = $temp_dir . $image_name;
						$extension_list = array('jpg', 'jpeg', 'png');
						$resolution = 42;
						if (in_array($extension, $extension_list)) {
							if (!empty($image_name) && !empty($extension) && $extension != "webp") {
								$webp_image = $image_name;
								$im = "";
								if (!file_exists($temp_dir . $webp_image)) {
									if ($extension == "png" || $extension == "jpg" || $extension == "jpeg") {
										if ($extension == "png") {
											$im = imagecreatefrompng($folder_image);
										} else if ($extension == "jpg" || $extension == "jpeg") {
											$im = imagecreatefromjpeg($folder_image);
										}
									}
								}
							}
						}
					}
					if (!empty($webp_image) && file_exists($temp_dir . $webp_image)) {
						$image_size = filesize($temp_dir . $webp_image);
						if (!empty($image_size)) {
							$date_time = date("dmyhis");
							$msg = '<button type="button" onclick="Javascript:delete_upload_image_before_save(this, ' . "'" . $preview_name . "'" . ', ' . "'" . $webp_image . "'" . ');" class="btn btn-danger"><i class="fa fa-close"></i></button>
										<img id="' . $field_name . '_preview" src = "' . $temp_dir . $webp_image . '?t=' . $date_time . '" class="img-fluid">
										<input type="hidden" name="' . $display_page . '_name" class="form-control" value="' . $webp_image . '">
										';
						}
					}
				}
			}
		} else {
			$msg = "Please upload only images.";
		}
	} else {
		$msg = "Image name is empty";
	}
	echo $msg;
	exit;
}

?>