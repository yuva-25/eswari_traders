<?php	
	class validation {
		public function StringToLower($string) {
			if(!empty($string)) {
				$string_array = "";
				$string_array = explode(" ", $string);
				if(is_array($string_array)) {
					for($n = 0; $n < count($string_array); $n++) {
						if(!empty($string_array[$n])) {
							$string_array[$n] = trim($string_array[$n]);
							$string_array[$n] = strtolower($string_array[$n]);
							$string_array[$n] = ucfirst($string_array[$n]);
						}
						else {
							unset($string_array[$n]);
						}
					}
					$string = implode(" ", $string_array);
				}
			}
			return $string;
		}
		public function clean_value($field_value) {
			if(!empty($field_value)) {
				$field_value = trim($field_value);
			}
			return $field_value;
		}
		public function common_validation($field_value, $field_name, $field_type) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) { /*\"\'\*/
				$field_value = htmlspecialchars_decode($field_value);
				// echo $field_value;
				if(preg_match('/[`~!$^<>*+={}\[\]|?]/', $field_value)) {
					$result = "(` ~ ! $ ^ < > * + = { } [ ] | ?) not allowed";
				}
			}
			else {
				if($field_type == "select") {
					$result = "Select the ".$field_name;
				}
				else {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_regular_expression($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^(?=.*[a-zA-Z])[^`~!$^<>*+={}\[\]|?]+$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." characters are allowed for ".$field_name;
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_regular_num_expression($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^(?=.*[a-zA-Z0-9])[^`~!$^<>*+={}\[\]|?]+$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." characters are allowed for ".$field_name;
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_date($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(date('Y-m-d', strtotime($field_value)) != $field_value) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Select the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_datetime($date, $time, $field_name, $required) {
			$result = "";
			$date = trim($date);
			$time = trim($time);
			if(!empty($date) && !empty($time)) {
				$field_value = $date." ".$time.":00";
				if(date('H:i', strtotime($field_value)) != $time) {
					$result = "Invalid ".$field_name;
				}
			}
			else {
				if($required == 1) {
					if(empty($date)) {
						$result = "Select the Date";
					}
					if(empty($time)) {
						$result = "Select the ".$field_name;
					}
				}
			}
			return $result;
		}
		public function valid_pincode($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^\d{6}$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_landline_number($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match('/^[\+0-9\-\(\)\s]*$/', $field_value)) {
						$result = "Invalid ".$field_name;
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." characters are allowed for ".$field_name;
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_mobile_number($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(preg_match('/^[0-9]{10}$/', $field_value) || preg_match('/^[0-9]{5}(\s)[0-9]{5}$/', $field_value)) {
						if(!empty($field_value) && strpos($field_value, '0') !== false) {
							$zero_count = 0;
							$zero_count = substr_count($field_value, '0');
							if($zero_count == 10) {
								$result = "Mobile number la all zero values not allowed";
							}
						}
					}
					else {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_email($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/', $field_value)) {
						$result = "Invalid ".$field_name;
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." characters are allowed for ".$field_name;
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_username($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(!empty($result)) {
					if(!preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/", $field_value) && !preg_match("/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." characters are allowed for ".$field_name;
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function PasswordRequirements($post_name) {
			$password_success = 0; $password_match = 0;
			if(preg_match("/\d/", $post_name)) {
				$password_match++;
			}
			if(preg_match("/[A-Z]/", $post_name)) {
				$password_match++;
			}
			if(preg_match("/[a-z]/", $post_name)) {
				$password_match++;
			}
			if(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $post_name)) {
				$password_match++;
			}
			if(preg_match('/^\S+$/', $post_name)) {
				$password_match++;
			}
			if($password_match == 5) {
				$password_success = 1;
			}
			return $password_success;
		}
		public function valid_password($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					$result = $this->PasswordRequirements($field_value);
					if($result != 1) {
						$result = "Password not match for required conditions";
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." characters are allowed for ".$field_name;
                    }
					else { $result = ""; }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_aadhaar_number($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {			
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {	
					if(!preg_match('/^\d{4}\s\d{4}\s\d{4}$/', $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_vehicle_number($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^[A-Za-z]{1,2}[\s ]?[0-9]{1,2}[\s ]?[A-Za-z]{0,2}[\s ]?[0-9]{1,4}$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_driving_license_number($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match('/^([a-zA-Z]){2}\s([0-9]){2}\s([0-9]){11}?$/', $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_pancard_number($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match('/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/', $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_voter_id_number($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match('/^([a-zA-Z]){3}([0-9]){7}+$/', $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_gst_number($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_ifsc_code($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match('/^[A-Za-z]{4}\d{7}$/', $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_text($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^[a-zA-Z\s]+$/", $field_value)) {
						$result = "Only Text is allowed for ".$field_name;
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." characters are allowed for ".$field_name;
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_number($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^[0-9]*$/", $field_value)) {
						$result = "Only Numbers is allowed for ".$field_name;
					}
					else if($field_value <= 0) {
						$result = "Should be greater than 0";
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." digits are allowed for ".$field_name;
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_text_number($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^[a-zA-Z0-9\s]+$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." characters are allowed for ".$field_name;
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_number_text($field_value, $field_name, $required, $characters) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z0-9\s]+$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
                    else if(!empty($characters) && preg_match("/^[0-9]*$/", $characters) && strlen($field_value) > $characters) {
                        $result = "Only ".$characters." characters are allowed for ".$field_name;
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_price($field_value, $field_name, $required, $value) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^[0-9]+(\\.[0-9]+)?$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
					else if($field_value <= 0) {
						$result = "Should be greater than 0";
					}
                    else if(!empty($value) && preg_match("/^[0-9]+(\\.[0-9]+)?$/", $value) && $field_value > $value) {
                        $result = "Max Value : ".$value." Only";
                    }
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_hsn($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^[0-9]{4,8}$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_percentage($field_value, $field_name, $required, $allowed_value) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					$field_value = str_replace("%", "", $field_value);
					if(!preg_match("/^[0-9]+(\\.[0-9]+)?$/", $field_value) || (!empty($allowed_value) && $field_value > $allowed_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_time($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_ip_address($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function valid_address($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(preg_match("/[?!<>$+=`~|?!;^*{}]/", $field_value)) {
					$result = "Invalid ".$field_name;
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}
		public function error_display($form_name, $field, $error, $type) {
			$result = "";
			if(!empty($error)) {
				if($type == "text") {
					if($field == 'discount_name' || $field == 'extra_charges_name') {
						$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().find('span.infos').length == 0) {
							jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').after('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> ".$error."</span>');
							jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').css('border','1px solid red');
						}";
					}
					else {
						$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().find('span.infos').length == 0) {
							jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().after('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
							jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').css('border','1px solid red');
						}";
					}
				}
				if($type == "form_radio") {
					$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().after('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').css('border','1px solid red');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').focus();
								}";
				}
				if($type == "checkbox" || $type == "radio") {
					$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().after('<span class=".'"infos text-danger w-100"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').css('border','1px solid red');
								
								}";
				}
				if($type == "textarea") {
					$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] textarea[name=".'"'.$field.'"'."]').parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] textarea[name=".'"'.$field.'"'."]').parent().after('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
									jQuery('form[name=".'"'.$form_name.'"'."] textarea[name=".'"'.$field.'"'."]').css('border','1px solid red');
									jQuery('form[name=".'"'.$form_name.'"'."] textarea[name=".'"'.$field.'"'."]').focus();
								}";
				}
				if($type == "input_group") {
					if($field == "pincode") {
						$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().after('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').css('border','1px solid red');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').focus();
								}
								else {
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().after('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').css('border','1px solid red');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').focus();
								}";
					}
					else {
						$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().after('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').css('border','1px solid red');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').focus();
								}";
					}			
				}
				if($type == "input_group_array") {
					$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().append('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').css('border','1px solid red');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').focus();
								}";
				}
				if($type == "select") {
					$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] select[name=".'"'.$field.'"'."]').parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] select[name=".'"'.$field.'"'."]').parent().parent().append('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
									jQuery('form[name=".'"'.$form_name.'"'."] select[name=".'"'.$field.'"'."]').parent().find('.select2-selection--single').css('border','1px solid red');
								}";
				}
				if($type == "custom_radio") {
					$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().after('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').css('border','1px solid red');
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').focus();
								}";
				}
				if($type == "upload_modal_button") {
					$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] button[name=".'"'.$field.'"'."]').parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] button[name=".'"'.$field.'"'."]').parent().after('<span class=".'"w-100 infos"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
								}";
				}
				if($type == "on_off_checkbox") {
					$result = "if(jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().parent().find('span.infos').length == 0) {
									jQuery('form[name=".'"'.$form_name.'"'."] input[name=".'"'.$field.'"'."]').parent().parent().after('<span class=".'"infos text-danger"'."> <i class=".'"fa fa-exclamation-circle"'."></i> &nbsp; ".$error."</span>');
								}";
				}
			}
			
			return $result;
		}
		public function row_error_display($form_name, $field, $error, $type, $row_name, $row_no) {
			$result = ""; $sno_element = ""; $extra_parent = "";
			
			$class_name = "sno";
			if($row_name == "parent_product_row") {
				$class_name = "parent_sno";
			}
			else if($row_name == "printing_product_row") {
				$class_name = "printing_sno";
			}
			else if($row_name == "tube_product_row") {
				$class_name = "tube_sno";
			}
			else if($row_name == "packaging_product_row") {
				$class_name = "packaging_sno";
			}
			if(!empty($error) && !empty($row_no)) {
				$sno_element = "var snoElement = jQuery(\"form[name='".$form_name."'] tr.".$row_name." .".$class_name."\").filter(function() {
					return jQuery(this).text().trim() == ".$row_no.";
				});";
				
				if ($type == "text") {
					$result = $sno_element."
						if(snoElement.parent().find(\"input[name='".$field."']\").".$extra_parent."find('span.infos').length == 0) {
							snoElement.parent().find(\"input[name='".$field."']\").".$extra_parent."after('<span class=\"infos w-100\"> <i class=\"fa fa-exclamation-circle\"></i> ".$error."</span>');
						}";
				}
				
				if($type == "textarea") {
					$result = $sno_element."
						if(snoElement.parent().find(\"textarea[name='".$field."']\").parent().find('span.infos').length == 0) {
							snoElement.parent().find(\"textarea[name='".$field."']\").after('<span class=\"infos w-100\"> <i class=\"fa fa-exclamation-circle\"></i> ".$error."</span>');
						}";
				}
				if($type == "select") {
					$result = $sno_element."
						if(snoElement.parent().find(\"select[name='".$field."']\").parent().find('span.infos').length == 0) {
							snoElement.parent().find(\"select[name='".$field."']\").parent().after('<span class=\"infos w-100\"> <i class=\"fa fa-exclamation-circle\"></i> ".$error."</span>');
						}";
				}
			}
			return $result;
		}
		public function valid_name_text($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
                    if(!preg_match("/^[a-zA-Z][a-zA-Z\s\&\.\,\'\-]+$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}

		public function valid_company_name($field_value, $field_name, $required) {
			$result = "";
			$field_value = trim($field_value);
			if(!empty($field_value)) {
				$result = $this->common_validation($field_value, $field_name, '');
				if(empty($result)) {
					if(!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z\s &-.']+$/", $field_value)) {
						$result = "Invalid ".$field_name;
					}
				}
			}
			else {
				if($required == 1) {
					$result = "Enter the ".$field_name;
				}
			}
			return $result;
		}

		public function row_error($form_name, $field, $error, $type, $row_class, $row_index) {

			$result = "";

			if (!empty($error) && $type == "text") {

				$result = "
				var row = jQuery('form[name=\"".$form_name."\"] .".$row_class."').eq(".($row_index-1).");

				if(row.find('span.infos').length == 0) {
					row.find('input[name=\"".$field."\"]')
						.css('border','1px solid red')
						.after('<span class=\"infos text-danger\"><i class=\"fa fa-exclamation-circle\"></i> ".$error."</span>');
				}
				";
			}

			return $result;
		}

		public function valid_company_mobile_number($field_value, $field_name, $required)
		{
			$result = "";
			$field_value = trim($field_value);

			if (!empty($field_value)) {

				if (!preg_match('/^[0-9]{10}(\s*,\s*[0-9]{10})*$/', $field_value)) {
					return "Invalid " . $field_name;
				}

			} else {
				if ($required == 1) {
					return "Enter the " . $field_name;
				}
			}

			return $result;
		}


	}
?>
