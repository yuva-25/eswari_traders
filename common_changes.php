<?php

include("include_files.php");

if (isset($_REQUEST['get_city'])) {
	$district = filter_input(INPUT_GET, 'get_district', FILTER_SANITIZE_SPECIAL_CHARS);

	if (!empty($district)) {
		$district = $obj->encode_decode("encrypt", $district);
	}
	$city = "";
	$list = array();
	$list = $obj->getOtherCityList($district);
	foreach ($list as $data) {
		if (!empty($data['city'])) {
			$data['city'] = $obj->encode_decode("decrypt", $data['city']);
			if (!empty($city)) {
				$city = $city . "," . trim($data['city']);
			} else {
				$city = $data['city'];
			}
		}
	}
	if (!empty($city)) {
		echo trim($city);
	}
	exit;
}

if (isset($_REQUEST['others_city'])) {
	$other_city = filter_input(INPUT_GET, 'others_city', FILTER_SANITIZE_SPECIAL_CHARS);
	$selected_district_index = filter_input(INPUT_GET, 'selected_district', FILTER_SANITIZE_SPECIAL_CHARS);
	$form_name = filter_input(INPUT_GET, 'form_name', FILTER_SANITIZE_SPECIAL_CHARS);

	if ($other_city == '1') {
		?>
		<div class="form-group">
			<div class="form-label-group in-border">
				<input type="text" id="others_city" name="others_city" class="form-control shadow-none" value=""
					onkeydown="Javascript:KeyboardControls(this,'text',30,1);">
				<label>Others city <span class="text-danger">*</span></label>
			</div>
			<div class="new_smallfnt">Text Only (Max Char : 30)</div>
		</div>
	<?php
	}
}

if(isset($_REQUEST['get_filter_group_id'])) {
	$group_id = filter_input(INPUT_GET, 'get_filter_group_id', FILTER_SANITIZE_SPECIAL_CHARS);
	$group_id = trim($group_id);

	$group_list = array();
	$group_list = $creation_obj->GetCreationCategoryList($GLOBALS['bill_company_id'],$group_id);

	?>
	<option value="">Select Category</option>
	<?php
	if(!empty($group_list)) {
		foreach ($group_list as $data) {
			if(!empty($data['category_id']) && $data['category_id'] != $GLOBALS['null_value']) {
				?>
				<option value="<?php echo $data['category_id']; ?>">
					<?php
						$category_name = "";
						$category_name = $obj->getTableColumnValue($GLOBALS['category_table'],'category_id',$data['category_id'],'category_name');
						if(!empty($category_name) && $category_name != $GLOBALS['null_value']) {
							echo $obj->encode_decode('decrypt', $category_name);
						}
					?>
				</option>
				<?php
			}
		}
	} 
	
}



if(isset($_REQUEST['get_filter_group_id_member'])) {
	$group_id = filter_input(INPUT_GET, 'get_filter_group_id_member', FILTER_SANITIZE_SPECIAL_CHARS);
	$group_id = trim($group_id);
	$category_id = filter_input(INPUT_GET, 'get_filter_category_id', FILTER_SANITIZE_SPECIAL_CHARS);
	$category_id = trim($category_id);

	$group_list = array();
	$group_list = $creation_obj->getCategoryMemberList($group_id,$category_id);

	?>
	<option value="">Select Member</option>
	<?php
	if(!empty($group_list)) {
		foreach ($group_list as $data) {
			if(!empty($data['member_id']) && $data['member_id'] != $GLOBALS['null_value']) {
				?>
				<option value="<?php echo $data['member_id']; ?>">
					<?php
						$member_name = "";
						$member_name = $obj->getTableColumnValue($GLOBALS['member_table'],'member_id',$data['member_id'],'member_name');
						if(!empty($member_name) && $member_name != $GLOBALS['null_value']) {
							echo $obj->encode_decode('decrypt', $member_name);
						}
					?>
				</option>
				<?php
			}
		}
	} 
	
}


if(isset($_REQUEST['change_product_modal'])) {
	$product_list = array();

	$product_list = $obj->getTableRecords($GLOBALS['product_table'], '', '','');
    ?>
	<option value="">Select</option>
	<?php
	if(!empty($product_list)) {
		foreach($product_list as $data) {
			if(!empty($data['product_id']) && $data['product_id'] != $GLOBALS['null_value']) {
				?>
				<option value="<?php echo $data['product_id']; ?>">
					<?php
						if(!empty($data['product_name']) && $data['product_name'] != $GLOBALS['null_value']) {
							echo $obj->encode_decode('decrypt', $data['product_name']);
						}
					?>
				</option>
				<?php
			}
		}
	}
}

if(isset($_REQUEST['change_party_modal'])) {
	$page_title = filter_input(INPUT_GET, 'page_title', FILTER_SANITIZE_SPECIAL_CHARS);
	$customer_list = array();
	$customer_list = $obj->getTableRecords($GLOBALS['party_table'],'','','');
	
    ?>
	<option value="">Select</option>
	<?php
	if(!empty($customer_list)) {
		foreach($customer_list as $data) {
			if(!empty($data['party_id']) && $data['party_id'] != $GLOBALS['null_value']) {
				?>
				<option value="<?php echo $data['party_id']; ?>">
					<?php
						if(!empty($data['name_mobile_city']) && $data['name_mobile_city'] != $GLOBALS['null_value']) {
							echo $obj->encode_decode('decrypt', $data['name_mobile_city']);
						}
					?>
				</option>
				<?php
			}
		}
	}
}


if (isset($_GET['get_sales_chart'])) {
	$from_date = $_GET['from_date'] ?? '';
	$to_date = $_GET['to_date'] ?? '';		
	$bill_values = [];
	$chart_data = $obj->getSalesChartDetails($from_date,$to_date);
		$data = [['Dates', 'Total Bills', 'Total Value']];
	foreach ($chart_data as $row) {
		$data[] = [
			$row['bill_day'],
			(int)$row['bill_count'],
			(float)$row['bill_value']
		];
	}

	echo json_encode(['success' => true, 'data' => $data]);
	exit;
}