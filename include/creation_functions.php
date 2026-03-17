<?php 
    class Creation_functions {
		private $basic_obj;

		public function initialize(Basic_Functions $basic_obj) {
			$this->basic_obj = $basic_obj;
		}
		public function connect() {
			$db = new db();

			$con = $db->connect();
			return $con;
		}

		public function CheckRoleAlreadyExists($bill_company_id,$lower_case_name) {
			$list = array(); $select_query = ""; $role_id = "";
			if(!empty($bill_company_id) && !empty($lower_case_name)) {
               $select_query ="SELECT role_id From ".$GLOBALS['role_table']." WHERE bill_company_id =:bill_company_id AND lower_case_name =:lower_case_name AND deleted=:deleted";
			}
			$params =[':bill_company_id'=>$bill_company_id,':lower_case_name'=>$lower_case_name,':deleted'=>0];
			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['role_table'], $select_query,$params);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['role_id'])) {
							$role_id = $data['role_id'];
						}
					}
				}
			}
			return $role_id;
		}

		public function getUserList($row, $rowperpage, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $order_by_query = "";
			if(!empty($order_column) && !empty($order_direction)) {
				$order_by_query = "ORDER BY ".$order_column." ".$order_direction;
			}
			else {
				$order_by_query = "ORDER BY id DESC";
			}

			if(!empty($rowperpage)) {
				$select_query = "SELECT * FROM {$GLOBALS['user_table']} 
								WHERE deleted = :deleted
								".$order_by_query."
								LIMIT $row, $rowperpage";
			}
			else {
				$select_query = "SELECT * FROM {$GLOBALS['user_table']} 
								WHERE deleted = :deleted
								".$order_by_query;
			}
			$params = [':deleted' => 0];
			$list = $this->basic_obj->getQueryRecords($GLOBALS['user_table'], $select_query, $params);
			return $list;
		}	

		public function CheckUserIDAlreadyExists($user_id) {
			$select_query = ""; $list = array(); $where = ""; $id = ""; $params = array();
			if(!empty($user_id)) {
				$where = "lower_case_login_id = :lower_case_login_id AND ";
				$select_query = "SELECT user_id as userid FROM {$GLOBALS['user_table']} WHERE {$where} deleted = :deleted";
				$params = [':lower_case_login_id' => $user_id, ':deleted' => 0];
				$list = $this->basic_obj->getQueryRecords('', $select_query, $params);
			}
			if(!empty($list)) {
				foreach($list as $data) {
					if(!empty($data['userid']) && $data['userid'] != $GLOBALS['null_value']) {
						$id = $data['userid'];
					}
				}
			}
			return $id;
		}

		public function CheckUserNoAlreadyExists($mobile_number) {
			$select_query = ""; $list = array(); $where = ""; $id = ""; $params = array();
			if(!empty($mobile_number)) {
				$where = "mobile_number = :mobile_number AND ";
				$select_query = "SELECT userid FROM {$GLOBALS['user_table']} WHERE {$where} deleted = :deleted";
				$params = [':mobile_number' => $mobile_number, ':deleted' => 0];
				$list = $this->basic_obj->getQueryRecords('', $select_query, $params);
			}
			if(!empty($list)) {
				foreach($list as $data) {
					if(!empty($data['userid']) && $data['userid'] != $GLOBALS['null_value']) {
						$id = $data['userid'];
					}
				}
			}
			return $id;
		}

		public function getRoleList($row, $rowperpage, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $order_by_query = "";
			if(!empty($order_column) && !empty($order_direction)) {
				$order_by_query = "ORDER BY ".$order_column." ".$order_direction;
			}
			else {
				$order_by_query = "ORDER BY id DESC";
			}

			if(!empty($rowperpage)) {
				$select_query = "SELECT * FROM {$GLOBALS['role_table']} 
								WHERE deleted = :deleted
								".$order_by_query."
								LIMIT $row, $rowperpage";
			}
			else {
				$select_query = "SELECT * FROM {$GLOBALS['role_table']} 
								WHERE deleted = :deleted
								".$order_by_query;
			}
			$params = [':deleted' => 0];
			$list = $this->basic_obj->getQueryRecords($GLOBALS['role_table'], $select_query, $params);
			return $list;
		}

		public function CheckUnitAlreadyExists($unit_name) {
			$list = array(); $select_query = ""; $unit_id = ""; $where = ""; $params=array();
		
			if(!empty($unit_name)) {
				$select_query = "SELECT unit_id FROM " . $GLOBALS['unit_table'] . " WHERE lower_case_name = :unit_name AND deleted = :deleted";	
				$params['unit_name'] =$unit_name;
				$params['deleted'] = 0;
			}
			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['unit_table'], $select_query,$params);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['unit_id'])) {
							$unit_id = $data['unit_id'];
						}
					}
				}
			}
			return $unit_id;
		}

		public function getUnitList($row, $rowperpage, $order_column, $order_direction, $search_value) {
            $select_query = $where = ""; $list = array(); $order_by_query = "";
			if(!empty($search_value)){
				$where = " u.lower_case_name LIKE :search_value AND ";
				$params[':search_value'] = '%' . $search_value . '%';
			}
            if(!empty($order_column) && !empty($order_direction)) {
                $order_by_query = "ORDER BY ".$order_column." ".$order_direction;
            }
            else {
                $order_by_query = "ORDER BY id DESC";
            }

            if(!empty($rowperpage)) {
                $select_query = "SELECT u.* FROM {$GLOBALS['unit_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query." LIMIT $row, $rowperpage";
            }
            else {
                $select_query = "SELECT u.* FROM {$GLOBALS['unit_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query;
            }
            $params[':deleted'] = 0;
            $list = $this->basic_obj->getQueryRecords($GLOBALS['unit_table'], $select_query, $params);
            return $list;
        }

		public function CheckGodownAlreadyExists($godown_name) {
			$list = array(); $select_query = ""; $godown_id = ""; $where = ""; $params=array();
		
			if(!empty($godown_name)) {
				$select_query = "SELECT godown_id FROM " . $GLOBALS['godown_table'] . " WHERE lower_case_name = :godown_name AND deleted = :deleted";	
				$params['godown_name'] =$godown_name;
				$params['deleted'] = 0;
			}
			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['godown_table'], $select_query,$params);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['godown_id'])) {
							$godown_id = $data['godown_id'];
						}
					}
				}
			}
			return $godown_id;
		}
		
	

		public function getRowsCount($table, $column, $value) {
			$rows = 0; $list = array(); $select_query = ""; $params = array();
			if(!empty($table)) {
				if(!empty($column) && !empty($value)) {
					$select_query = "SELECT COUNT(id) as total_rows FROM ".$table." WHERE ".$column." = :value AND deleted = :deleted GROUP BY ".$column;
					$params = [':value' => $value, ':deleted' => 0];
				}
				else {
					$select_query = "SELECT COUNT(id) as total_rows FROM ".$table." WHERE deleted = :deleted";
					$params = [':deleted' => 0];
				}
				//echo $select_query."<br>";
				if(!empty($select_query)) {
					$list = $this->basic_obj->getQueryRecords('', $select_query, $params);
					if(!empty($list)) {
						foreach($list as $data) {
							if(!empty($data['total_rows'])) {
								$rows = $data['total_rows'];
							}
						}
					}
				}
			}
			return $rows;
		}

		public function getCompanyList($row, $rowperpage, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $order_by_query = "";
			if(!empty($order_column) && !empty($order_direction)) {
				$order_by_query = "ORDER BY ".$order_column." ".$order_direction;
			}
			else {
				$order_by_query = "ORDER BY id DESC";
			}

			if(!empty($rowperpage)) {
				$select_query = "SELECT * FROM {$GLOBALS['company_table']} 
								WHERE deleted = :deleted
								".$order_by_query."
								LIMIT $row, $rowperpage";
			}
			else {
				$select_query = "SELECT * FROM {$GLOBALS['company_table']} 
								WHERE deleted = :deleted
								".$order_by_query;
			}
			$params = [':deleted' => 0];
			$list = $this->basic_obj->getQueryRecords($GLOBALS['company_table'], $select_query, $params);
			return $list;
		}
		
		public function getBankList($row, $rowperpage, $order_column, $order_direction, $search_value) {
            $select_query = $where = ""; $list = array(); $order_by_query = "";
			if(!empty($search_value)){
				$where = " (FROM_BASE64(UNHEX(u.bank_name)) LIKE :search_value) AND ";
				$params[':search_value'] = '%' . $search_value . '%';
			}
            if(!empty($order_column) && !empty($order_direction)) {
                $order_by_query = "ORDER BY ".$order_column." ".$order_direction;
            }
            else {
                $order_by_query = "ORDER BY id DESC";
            }

            if(!empty($rowperpage)) {
                $select_query = "SELECT u.* FROM {$GLOBALS['bank_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query." LIMIT $row, $rowperpage";
            }
            else {
                $select_query = "SELECT u.* FROM {$GLOBALS['bank_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query;
            }
            $params[':deleted'] = 0;
            $list = $this->basic_obj->getQueryRecords($GLOBALS['bank_table'], $select_query, $params);
            return $list;
        }

		public function getPurchaseOrderList($row, $rowperpage, $searchValue, $party_id, $cancelled, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $where = ""; $order_by_query = ""; $params = array();
			
			$where = "bill_company_id = :bill_company_id AND";
			$params['bill_company_id'] = $GLOBALS['bill_company_id'];
		
			if(!empty($party_id)) {
				if(!empty($where)) {
					$where = $where." party_id = :party_id AND ";
				}
				else {
					$where = " party_id = :party_id AND ";
				}
				$params['party_id'] = $party_id;
			}
			
			if(!empty($searchValue)){
				if(!empty($where)) {
					$where = $where." (purchase_order_number LIKE :searchValue) AND ";
				}
				else {
					$where = " (purchase_order_number LIKE :searchValue) AND ";
				}
				$params['searchValue'] = "%{$searchValue}%";
			}
			if(!empty($order_column) && !empty($order_direction)) {
				$order_by_query = "ORDER BY ".$order_column." ".$order_direction;
			}
			else {
				$order_by_query = "ORDER BY id DESC";
			}
			
			if(!empty($rowperpage)) {
				$select_query = "SELECT * FROM ".$GLOBALS['purchase_order_table']."
							WHERE ".$where." cancelled = :cancelled AND deleted = :deleted
							".$order_by_query."
							LIMIT $row, $rowperpage";
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
			}
			else {
				$select_query = "SELECT * FROM ".$GLOBALS['purchase_order_table']."
							WHERE ".$where." cancelled = :cancelled AND deleted = :deleted
							".$order_by_query;
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
			}

            $list = $this->basic_obj->getQueryRecords($GLOBALS['purchase_order_table'], $select_query, $params);
			return $list;
		}

		
		public function getProductList($row, $rowperpage, $order_column, $order_direction, $search_value,$filter_product_id) {
            $select_query = $where = ""; $list = array(); $order_by_query = "";

			if(!empty($search_value)){
				$where = " u.size_name LIKE :search_value AND ";
				$params[':search_value'] = '%' . $search_value . '%';
			}

			if(!empty($filter_product_id)) {
				if(!empty($where)) {
					$where = $where." u.product_id = :product_id AND ";
				}
				else {
					$where = " u.product_id = :product_id AND ";
				}
				$params['product_id'] = $filter_product_id;
			}			
            if(!empty($order_column) && !empty($order_direction)) {
                $order_by_query = "ORDER BY ".$order_column." ".$order_direction;
            }
            else {
                $order_by_query = "ORDER BY id DESC";
            }
            
            if(!empty($rowperpage)) {
               $select_query = "SELECT u.* FROM {$GLOBALS['product_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query." LIMIT $row, $rowperpage";
            }
            else {
                $select_query = "SELECT u.* FROM {$GLOBALS['product_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query;
            }
            $params[':deleted'] = 0;
            $list = $this->basic_obj->getQueryRecords($GLOBALS['product_table'], $select_query, $params);
            return $list;
        }
		
		public function getPartyList($row, $rowperpage, $order_column, $order_direction, $search_value, $filter_party_id, $filter_party_type){
			$select_query = "";
			$list = array();
			$params = array();
			$where = "u.deleted = :deleted";
			$params[':deleted'] = 0;

			if (!empty($search_value)) {
				$where .= " AND u.name_mobile_city LIKE :search_value";
				$params[':search_value'] = "%" . $search_value . "%";
			}

			if (!empty($filter_party_id)) {
				$where .= " AND u.party_id = :party_id";
				$params[':party_id'] = $filter_party_id;
			}

			if (!empty($filter_party_type)) {
				$where .= " AND u.party_type = :party_type";
				$params[':party_type'] = $filter_party_type;
			}

			if (!empty($order_column) && !empty($order_direction)) {
				$order_by_query = "ORDER BY {$order_column} {$order_direction}";
			} else {
				$order_by_query = "ORDER BY u.id DESC";
			}

			
			$select_query = "SELECT u.* 
							FROM {$GLOBALS['party_table']} AS u 
							WHERE {$where} 
							{$order_by_query}";

			if (!empty($rowperpage)) {
				$select_query .= " LIMIT {$row}, {$rowperpage}";
			}

			
			return $this->basic_obj->getQueryRecords(
				$GLOBALS['party_table'],
				$select_query,
				$params
			);
		}


		public function PartyMobileExists($mobile_number,$table,$column) {
			$list = array(); $select_query = ""; $party_id = ""; $where = ""; $params = array();
			
			if(!empty($mobile_number)) {
				$select_query = "SELECT {$column} FROM ".$table." WHERE mobile_number = :mobile_number AND deleted = :deleted";	
				$params['mobile_number'] = $mobile_number;
				$params['deleted'] = 0;
			}
			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($table, $select_query,$params);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data[$column])) {
							$party_id = $data[$column];
						}
					}
				}
			}
			return $party_id;
		}

		public function getPartyDetailList($type) {
			$list = array();
			$where = "";
			$params = array();

			if ($type == '1') {
				$where = "party_type IN (:type1, :type3) AND deleted = '0'";
				$params = array(
					':type1' => 1,
					':type3' => 3
				);

			} else if ($type == '2') {
				$where = "party_type IN (:type2, :type3) AND deleted = '0'";
				$params = array(
					':type2' => 2,
					':type3' => 3
				);
			}

			if (!empty($where)) {
				$query = "SELECT * FROM ".$GLOBALS['party_table']." WHERE ".$where;
				$list = $this->basic_obj->getQueryRecords($GLOBALS['party_table'], $query, $params);
			}

			return $list;
		}

		// public function UpdateBalance($bill_company_id,$bill_id,$bill_number,$bill_date,$bill_type,$party_id,$party_name,$party_type,$payment_mode_id,$payment_mode_name,$bank_id,$bank_name,$opening_balance,$opening_balance_type,$credit,$debit){
		// 	$select_query = ""; $lists = array(); $unique_id = ""; $params = array(); $where = '';
		// 	$params['bill_company_id'] = $bill_company_id;
		// 	$params['bill_id'] = $bill_id;
		// 	$params['deleted'] = 0;
		// 	if( !empty($payment_mode_id)) {
		// 		$where = "payment_mode_id = :payment_mode_id AND ";
		// 		$params['payment_mode_id'] = $payment_mode_id;
		// 	}
		// 	if($bill_type == "Purchase" || $bill_type == "Sales"){
		// 		$select_query = "SELECT id FROM ".$GLOBALS['payment_table']." WHERE bill_company_id = :bill_company_id AND bill_id = :bill_id AND deleted = :deleted";
		// 	}
		// 	else {
		// 		$select_query = "SELECT id FROM ".$GLOBALS['payment_table']." WHERE bill_company_id = :bill_company_id AND bill_id = :bill_id AND {$where} deleted = :deleted";
		// 	} 		
		// 	$lists = $this->basic_obj->getQueryRecords($GLOBALS['payment_table'], $select_query,$params);
		// 	if(!empty($lists)) {
		// 		foreach($lists as $data) {
		// 			if(!empty($data['id']) && $data['id'] != $GLOBALS['null_value']) {
		// 				$unique_id = $data['id'];
		// 			}
		// 		}
		// 	}
		// 	$created_date_time = $GLOBALS['create_date_time_label'];
		// 	$updated_date_time = $GLOBALS['create_date_time_label'];
        //     $creator = $GLOBALS['creator'];
        //     $creator_name = $GLOBALS['creator_name'];
		// 	if(preg_match("/^\d+$/", $unique_id)) {
		// 		$action = "Updated Successfully";
		// 		$columns = array(); $values = array();
		// 		$columns = array('updated_date_time','creator_name','bill_date','party_id','party_name','party_type','bank_id','bank_name','payment_mode_id','payment_mode_name','opening_balance','opening_balance_type','credit','debit');
		// 		$values = array($updated_date_time,$creator_name,$bill_date,$party_id,$party_name,$party_type,$bank_id,$bank_name,$payment_mode_id,$payment_mode_name,$opening_balance,$opening_balance_type,$credit,$debit);
		// 		$payment_update_id = $this->basic_obj->UpdateSQL($GLOBALS['payment_table'], $unique_id, $columns, $values, $action);
		// 	}
		// 	else {
		// 		$action = "Inserted Successfully";
		// 		$null_value = $GLOBALS['null_value'];
		// 		$columns = array(); $values = array();
		// 		$columns = array('created_date_time','updated_date_time','creator', 'creator_name', 'bill_company_id','bill_id','bill_number','bill_date','bill_type','party_id','party_name','party_type','bank_id','bank_name','payment_mode_id','payment_mode_name','opening_balance','opening_balance_type','credit','debit','deleted');
		// 		$values = array($created_date_time,$updated_date_time, $creator, $creator_name, $bill_company_id,$bill_id,$bill_number,$bill_date,$bill_type,$party_id,$party_name,$party_type,$bank_id,$bank_name,$payment_mode_id,$payment_mode_name,$opening_balance,$opening_balance_type,$credit,$debit,0);
		// 		$payment_insert_id = $this->basic_obj->InsertSQL($GLOBALS['payment_table'], $columns, $values, '', '', $action);
		// 	}
		// }

		public function GetPartyLinkedCount($party_id) {
			$list = array(); $select_query = ""; $where = ""; $count = 0;$params = array();
			if(!empty($party_id)) {
				$where = " party_id = :party_id AND ";
				$params['party_id'] = $party_id;
                             
				$select_query = "SELECT id_count FROM (
				                    (SELECT count(id) as id_count FROM ".$GLOBALS['payment_table']." WHERE ".$where." deleted = :p_deleted)
								)	as g";
				$params['p_deleted'] = 0;
								
				$list = $this->basic_obj->getQueryRecords('', $select_query,$params);
			}
			if(!empty($list)) {
				foreach($list as $data) {
					if(!empty($data['id_count']) && $data['id_count'] != $GLOBALS['null_value']) {
						$count = $data['id_count'];
					}
				}
			}
			return $count;
		}

		public function DeletePayment($bill_id){
			$payment_bill_list = array(); $payment_unique_id = "";

            $payment_bill_list = $this->basic_obj->getTableRecords($GLOBALS['payment_table'], 'bill_id', $bill_id,'');
            if(!empty($payment_bill_list)){
                foreach($payment_bill_list as $value){
                    if(!empty($value['id'])){
                        $payment_unique_id = $value['id'];
                    }
                    if(preg_match("/^\d+$/", $payment_unique_id)) {
                        $action = "Payment Deleted.";
                    
                        $columns = array(); $values = array();						
                        $columns = array('deleted');
                        $values = array(1);
                        $msg = $this->basic_obj->UpdateSQL($GLOBALS['payment_table'], $payment_unique_id, $columns, $values, $action);
                    }
                }
            }
		}

		public function getSalesPartyList($row, $rowperpage, $order_column, $order_direction, $search_value) {
			$select_query = ""; $list = array(); $order_by_query = "";
			if(!empty($order_column) && !empty($order_direction)) {
				$order_by_query = "ORDER BY ".$order_column." ".$order_direction;
			}
			else {
				$order_by_query = "ORDER BY id DESC";
			}

			$where = ""; $params = array();
			$where = "deleted = :deleted"; $params[':deleted'] = 0;

			if(!empty($search_value)){
				$where .= " AND name_mobile LIKE :search_value";
				$params[':search_value'] = '%' . $search_value . '%';
			}
			if(!empty($where)) {
				$select_query = "SELECT u.* FROM {$GLOBALS['sales_party_table']} as u 
								WHERE ".$where." ".$order_by_query;
				if(!empty($rowperpage)) {
					$select_query = $select_query." LIMIT ".$row.", ".$rowperpage;
				}
			}
			
			$list = $this->basic_obj->getQueryRecords($GLOBALS['sales_party_table'], $select_query, $params);
			return $list;
		}


		public function CombineAndSumUp ($myArray) {
            $finalArray = Array ();
            foreach ($myArray as $nkey => $nvalue) {
                $has = false;
                $fk = false;

                // $n_hsn = $nvalue['hsn_code'] ?? '';
                // $n_tax = $nvalue['tax'] ?? 0;
                foreach ($finalArray as $fkey => $fvalue) {
                    if(($fvalue['hsn_code'] == $nvalue['hsn_code']) && ($fvalue['tax'] == $nvalue['tax'])) {    
						//     $f_hsn = ""; $f_tax = "";
						//             $f_hsn = $fvalue['hsn_code'] ?? '';
						//     $f_tax = $fvalue['tax'] ?? 0;

						// if ($f_hsn === $n_hsn && $f_tax == $n_tax) {
                        $has = true;
                        $fk = $fkey;
                        break;
                    }
                }
    
                if($has === false) {
                    $finalArray[] = $nvalue;
                }
                else {
                    if(!empty($nvalue['hsn_code'])){
                     $finalArray[$fk]['hsn_code'] = $nvalue['hsn_code'];
                    }
                    $finalArray[$fk]['tax'] = $nvalue['tax'];
                    $finalArray[$fk]['quantity'] += $nvalue['quantity'];
                    $finalArray[$fk]['taxable_value'] += $nvalue['taxable_value'];
                    $finalArray[$fk]['tax_amount'] += $nvalue['tax_amount'];
                }
            }
            return $finalArray;
        }


		public function getQuotationList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id, $cancelled, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $where = ""; $order_by_query = ""; $params = array();
			$where = "bill_company_id = :bill_company_id AND";
			$params['bill_company_id'] = $GLOBALS['bill_company_id'];
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." quotation_bill_date >= :from_date AND ";
				}
				else {
					$where = " quotation_bill_date >= :from_date AND ";
				}
				$params['from_date'] = $from_date;
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." quotation_bill_date <= :to_date AND ";
				}
				else {
					$where = " quotation_bill_date <= :to_date AND ";
				}
				$params['to_date'] = $to_date;
			}
			if(!empty($party_id)) {
				if(!empty($where)) {
					$where = $where." party_id = :party_id AND ";
				}
				else {
					$where = " party_id = :party_id AND ";
				}
				$params['party_id'] = $party_id;
			}
			if(!empty($searchValue)){
				if(!empty($where)) {
					$where = $where." (quotation_bill_number LIKE :searchValue) AND ";
				}
				else {
					$where = " (quotation_bill_number LIKE :searchValue) AND ";
				}
				$params['searchValue'] = "%{$searchValue}%";
			}
			if(!empty($order_column) && !empty($order_direction)) {
				$order_by_query = "ORDER BY ".$order_column." ".$order_direction;
			}
			else {
				$order_by_query = "ORDER BY id DESC";
			}
			if(!empty($rowperpage)) {
				$select_query = "SELECT * FROM ".$GLOBALS['quotation_table']."
							WHERE ".$where." cancelled = :cancelled AND deleted = :deleted
							".$order_by_query."
							LIMIT $row, $rowperpage";
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
			}
			else {
				$select_query = "SELECT * FROM ".$GLOBALS['quotation_table']."
							WHERE ".$where." cancelled = :cancelled AND deleted = :deleted
							".$order_by_query;
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
			}
            $list = $this->basic_obj->getQueryRecords($GLOBALS['quotation_table'], $select_query, $params);
			return $list;
		}

		public function getInvoiceList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id, $cancelled, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $where = ""; $order_by_query = ""; $params = array();
			$where = "bill_company_id = :bill_company_id AND";
			$params['bill_company_id'] = $GLOBALS['bill_company_id'];
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." invoice_date >= :from_date AND ";
				}
				else {
					$where = " invoice_date >= :from_date AND ";
				}
				$params['from_date'] = $from_date;
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." invoice_date <= :to_date AND ";
				}
				else {
					$where = " invoice_date <= :to_date AND ";
				}
				$params['to_date'] = $to_date;
			}
			if(!empty($party_id)) {
				if(!empty($where)) {
					$where = $where." party_id = :party_id AND ";
				}
				else {
					$where = " party_id = :party_id AND ";
				}
				$params['party_id'] = $party_id;
			}
			if(!empty($searchValue)){
				if(!empty($where)) {
					$where = $where." (invoice_number LIKE :searchValue) AND ";
				}
				else {
					$where = " (invoice_number LIKE :searchValue) AND ";
				}
				$params['searchValue'] = "%{$searchValue}%";
			}
			if(!empty($order_column) && !empty($order_direction)) {
				$order_by_query = "ORDER BY ".$order_column." ".$order_direction;
			}
			else {
				$order_by_query = "ORDER BY id DESC";
			}
			if(!empty($rowperpage)) {
				$select_query = "SELECT * FROM ".$GLOBALS['invoice_table']."
							WHERE ".$where." cancelled = :cancelled AND deleted = :deleted
							".$order_by_query."
							LIMIT $row, $rowperpage";
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
			}
			else {
				$select_query = "SELECT * FROM ".$GLOBALS['invoice_table']."
							WHERE ".$where." cancelled = :cancelled AND deleted = :deleted
							".$order_by_query;
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
			}
            $list = $this->basic_obj->getQueryRecords($GLOBALS['invoice_table'], $select_query, $params);
			return $list;
		}	

		public function GetLinkedCount($table, $creation_id) { 
			$count = 0;
			$linked_tables = array();

			// --- ROLE ---
			if ($table == $GLOBALS['role_table']) {
				$linked_tables[] = array(
					'tables' => array($GLOBALS['user_table']),
					'field'  => 'role_id',
					'where'  => " AND deleted = :deleted"
				);
			}

			// --- BANK ---
			else if ($table == $GLOBALS['bank_table']) {
				$linked_tables[] = array(
					'tables' => array($GLOBALS['invoice_table']),
					'field'  => 'bank_id',
					'where'  => " AND deleted = :deleted"
				);
			}

			// --- UNIT ---
			else if ($table == $GLOBALS['unit_table']) {
				$linked_tables[] = array(
					'tables' => array($GLOBALS['product_table'],$GLOBALS['order_form_table'], $GLOBALS['estimate_table'], $GLOBALS['invoice_table']),
					'field'  => 'unit_id',
					'where'  => " AND deleted = :deleted"
				);

			}

			// --- UNIT ---
			else if ($table == $GLOBALS['size_table']) {
				$linked_tables[] = array(
					'tables' => array($GLOBALS['product_table'],$GLOBALS['order_form_table'], $GLOBALS['estimate_table'], $GLOBALS['invoice_table']),
					'field'  => 'size_id',
					'where'  => " AND deleted = :deleted"
				);

			}

			// --- PRODUCT ---
		 else if ($table == $GLOBALS['product_table']) {
				$linked_tables[] = array(
					'tables' => array($GLOBALS['order_form_table'], $GLOBALS['estimate_table'], $GLOBALS['invoice_table']),
					'field'  => 'product_id',
					'where'  => " AND cancelled = :cancelled"
				);
			}

			// --- PARTY ---
			else if ($table == $GLOBALS['party_table']) {
				$linked_tables[] = array(
					'tables' => array($GLOBALS['order_form_table'], $GLOBALS['estimate_table'], $GLOBALS['invoice_table']),
					'field'  => 'party_id',
					'where'  => " AND cancelled = :cancelled"
				);

			}

			// --- GODOWN ---
			/*else if ($table == $GLOBALS['godown_table']) {
				$linked_tables[] = array(
					'tables' => array($GLOBALS['received_slip_table'],$GLOBALS['purchase_bill_table'],$GLOBALS['quotation_table'],$GLOBALS['delivery_challan_table'],$GLOBALS['estimate_table'],$GLOBALS['invoice_table'],$GLOBALS['stock_adjustment_table']),
					'field'  => 'godown_id',
					'where'  => " AND cancelled = :cancelled"
				);

				$linked_tables[] = array(
					'tables' => array($GLOBALS['product_table']),
					'field'  => 'godown_id',
					'where'  => " AND deleted = :deleted"
				);

				$linked_tables[] = array(
					'tables' => array($GLOBALS['material_transfer_table']),
					'field'  => 'from_godown_id',
					'where'  => " AND cancelled = :cancelled"
				);

				$linked_tables[] = array(
					'tables' => array($GLOBALS['material_transfer_table']),
					'field'  => 'to_godown_id',
					'where'  => " AND cancelled = :cancelled"
				);
			}

			// --- BRAND ---
			else if ($table == $GLOBALS['brand_table']) {
				$linked_tables[] = array(
					'tables' => array($GLOBALS['received_slip_table'],$GLOBALS['purchase_bill_table'],$GLOBALS['quotation_table'],$GLOBALS['delivery_challan_table'],$GLOBALS['estimate_table'],$GLOBALS['invoice_table'],$GLOBALS['stock_adjustment_table'],$GLOBALS['material_transfer_table']),
					'field'  => 'brand_id',
					'where'  => " AND cancelled = :cancelled"
				);

				$linked_tables[] = array(
					'tables' => array($GLOBALS['product_table']),
					'field'  => 'brand_id',
					'where'  => " AND deleted = :deleted"
				);

			} */

			$union_parts = array();
			$params = array();

			foreach ($linked_tables as $group) {
				foreach ($group['tables'] as $tbl) {

					$alias = $tbl . "_" . $group['field']; // unique param name

					$union_parts[] = "
						SELECT COUNT(id) AS id_count
						FROM {$tbl}
						WHERE FIND_IN_SET(:{$alias}_creation_id, {$group['field']})
						{$group['where']}
					";

					// Parameters
					$params["{$alias}_creation_id"] = $creation_id;

					if (strpos($group['where'], ":deleted") !== false) {
						$params["deleted"] = "0";
					}
					if (strpos($group['where'], ":cancelled") !== false) {
						$params["cancelled"] = "0";
					}
				}
			}

			if (!empty($union_parts)) {
				$query = "
					SELECT SUM(id_count) AS total_count
					FROM (" . implode(" UNION ALL ", $union_parts) . ") AS g
				";

				$rows = $this->basic_obj->getQueryRecords('', $query, $params);

				if (!empty($rows[0]['total_count'])) {
					$count = (int)$rows[0]['total_count'];
				}
			}

			return $count;

		}

		public function getEstimateList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id, $cancelled, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $where = ""; $order_by_query = ""; $params = array();
			$where = "bill_company_id = :bill_company_id AND";
			$params['bill_company_id'] = $GLOBALS['bill_company_id'];
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." estimate_date >= :from_date AND ";
				}
				else {
					$where = " estimate_date >= :from_date AND ";
				}
				$params['from_date'] = $from_date;
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." estimate_date <= :to_date AND ";
				}
				else {
					$where = " estimate_date <= :to_date AND ";
				}
				$params['to_date'] = $to_date;
			}
			if(!empty($party_id)) {
				if(!empty($where)) {
					$where = $where." party_id = :party_id AND ";
				}
				else {
					$where = " party_id = :party_id AND ";
				}
				$params['party_id'] = $party_id;
			}
			if(!empty($searchValue)){
				if(!empty($where)) {
					$where = $where." (estimate_number LIKE :searchValue) AND ";
				}
				else {
					$where = " (estimate_number LIKE :searchValue) AND ";
				}
				$params['searchValue'] = "%{$searchValue}%";
			}
			if(!empty($order_column) && !empty($order_direction)) {
				$order_by_query = "ORDER BY ".$order_column." ".$order_direction;
			}
			else {
				$order_by_query = "ORDER BY id DESC";
			}
			
			if(!empty($rowperpage)) {
				$select_query = "SELECT * FROM ".$GLOBALS['estimate_table']."
							WHERE ".$where." cancelled = :cancelled AND deleted = :deleted
							".$order_by_query."
							LIMIT $row, $rowperpage";
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
			}
			else {
				$select_query = "SELECT * FROM ".$GLOBALS['estimate_table']."
							WHERE ".$where." cancelled = :cancelled AND deleted = :deleted
							".$order_by_query;
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
			}

            $list = $this->basic_obj->getQueryRecords($GLOBALS['estimate_table'], $select_query, $params);
			return $list;
		}


		public function setClearTableRecords($tables) {
            $success = 0; $con = $this->connect();
            if(!empty($tables)) {
                foreach($tables as $table) {
                    if(!empty($table)) {
                        if($table == $GLOBALS['product_table']) {
                            $list = array(); $success++;
                            $list = $this->basic_obj->getTableRecords($GLOBALS['product_table'], '', '', '');
                            if(!empty($list)) {
                                foreach($list as $data) {
                                    $linked_count = 0;
                                    if(!empty($data['product_id']) && $data['product_id'] != $GLOBALS['null_value']) {
                                        $linked_count = '0';
										$linked_count = $this->GetLinkedCount($GLOBALS['product_table'],$data['product_id']);
                                        if(empty($linked_count)) {
                                            $columns = array();
                                            $values = array();
                                            $columns = array('deleted');
                                            $values = array('1');
                                            $product_update_id = $this->basic_obj->UpdateSQL($GLOBALS['product_table'], $data['id'], $columns, $values, '');
                                        }
                                    }
                                }
                            }
                        }
                        else {
                            $table = trim(str_replace("'", "", $table));
                            $update_query = "";
                            $update_query = "UPDATE ".$table." SET deleted = '1'";
                            if(!empty($update_query)) {                        
                                $result = $con->prepare($update_query);
                                if($result->execute() === TRUE) {
                                    $success++;
                                }
                            }
                        }
                    }
                }
                if($success == count($tables)) {
                    $success = 1;
                }
                else {
                    $success = "Unable to clear";
                }
            }
            return $success;
        }

		function getOpeningStockCount($product_id) {
			$list = array(); $select_query = ""; $where = ""; $mt_where = ""; $count = 0;
			if(!empty($product_id)) {
				$where = " FIND_IN_SET('".$product_id."', product_id) AND ";
	
				$select_query = "SELECT id_count FROM (SELECT count(id) as id_count FROM ".$GLOBALS['stock_table']." WHERE ".$where." stock_type = 'Opening Stock' AND deleted = '0') as g";
				$list = $this->basic_obj->getQueryRecords('', $select_query);
			}
			if(!empty($list)) {
				foreach($list as $data) {
					if(!empty($data['id_count']) && $data['id_count'] != $GLOBALS['null_value']) {
						$count = $data['id_count'];
					}
				}
			}
			return $count;
		}

		
		public function CustomerMobileExists($mobile_number) {
			$list = array(); $select_query = ""; $vendor_id = ""; $order_by_query = "";

			if(!empty($mobile_number)) {
				$select_query = "SELECT vendor_id FROM ".$GLOBALS['vendor_table']." WHERE mobile_number = :mobile_number AND bill_company_id = :bill_company_id AND deleted = :deleted";	
			}

			if(!empty($mobile_number)){
				$params[':mobile_number'] =  $mobile_number;
			}
			if(!empty($GLOBALS['bill_company_id']))
			{
				$params[':bill_company_id'] =  $GLOBALS['bill_company_id'];
			}

			$params[':deleted'] = '0';
			if(!empty($select_query)) {
				// print_r($params);
				$list = $this->basic_obj->getQueryRecords($GLOBALS['vendor_table'], $select_query, $params);
				// echo $this->basic_obj->debugQuery($select_query, $params);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['vendor_id'])) {
							$vendor_id = $data['vendor_id'];
						}
					}
				}
			}

			return $vendor_id;
		}

		
		public function GetRoleLinkedCount($role_id) {
			$list = array(); $select_query = ""; $count = 0;$params = array();
			if(!empty($role_id)) {
				$select_query = "SELECT id_count FROM ((SELECT count(id) as id_count FROM ".$GLOBALS['user_table']." WHERE FIND_IN_SET(:role_id, role_id) AND deleted = :deleted)) as g";
				$params['role_id'] = $role_id;
				$params['deleted'] = 0;
				$list = $this->basic_obj->getQueryRecords('', $select_query,$params);
			}
			if(!empty($list)) {
				foreach($list as $data) {
					if(!empty($data['id_count']) && $data['id_count'] != $GLOBALS['null_value']) {
						$count = $data['id_count'];
					}
				}
			}
			return $count;
		}

		public function getPermissionId($bill_company_id,$role_id,$module_key){
			$list = array(); $select_query = ""; $where = ""; $params = array();

			if(!empty($bill_company_id)){
				$where = " bill_company_id = :bill_company_id AND ";
				$params['bill_company_id'] = $bill_company_id;
			}

			if(!empty($role_id)) {
				$where .= " role_id = :role_id AND ";
				$params['role_id'] = $role_id;
			}

			if(!empty($module_key)) {
				$where .= " module = :module_key AND ";
				$params['module_key'] = $module_key;
			}
			
			if(!empty($where)) {
				$select_query = "SELECT * FROM ".$GLOBALS['role_permission_table']." WHERE ".$where." deleted = :deleted ORDER BY id DESC";
				$params['deleted'] = 0;   
			}
			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['role_permission_table'], $select_query,$params);
			}
			
			return $list;
		}

		public function getRolePermissionId($bill_company_id,$role_id,$module_key){
			$list = array(); $select_query = ""; $where = ""; $params = array(); $unique_id = "";

			if(!empty($bill_company_id)){
				$where = " bill_company_id = :bill_company_id AND ";
				$params['bill_company_id'] = $bill_company_id;
			}

			if(!empty($role_id)) {
				$where .= " role_id = :role_id AND ";
				$params['role_id'] = $role_id;
			}

			if(!empty($module_key)) {
				$where .= " module = :module_key AND ";
				$params['module_key'] = $module_key;
			}
			
			if(!empty($where)) {
				$select_query = "SELECT id FROM ".$GLOBALS['role_permission_table']." WHERE ".$where." deleted = :deleted ORDER BY id DESC";
				$params['deleted'] = 0;   
			}
			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['role_permission_table'], $select_query,$params);
			}
			if(!empty($list)){
				foreach($list as $val){
					if(!empty($val['id'])){
						$unique_id =$val['id'];
					}

				}
			}
			
			return $unique_id;
		}
				
		public function GetPaymentModeList() {
			$payment_modes = array(); $payment_mode_decrypt = "";
			$params = array(':deleted' => 0);

			$select_query = "SELECT * FROM ".$GLOBALS['payment_mode_table']." WHERE deleted = :deleted ORDER BY id DESC";
			$list = $this->basic_obj->getQueryRecords($GLOBALS['payment_mode_table'], $select_query, $params);

			if (!empty($list)) {
				foreach ($list as $val) {
					$payment_mode_name = trim($val['payment_mode_name']);
					$payment_mode_decrypt = $this->basic_obj->encode_decode('decrypt',$payment_mode_name);
					$payment_mode_id   = trim($val['payment_mode_id']);

					if (stripos($payment_mode_decrypt, 'cash') !== false) {
						$payment_modes[] = array(
							'payment_mode_id' => $payment_mode_id,
							'payment_mode_name' => $payment_mode_name
						);
						continue;
					}

					$bank_check_query = "
						SELECT payment_mode_id 
						FROM ".$GLOBALS['bank_table']." 
						WHERE FIND_IN_SET(:pm_id, payment_mode_id)
						AND deleted = :deleted
						LIMIT 1
					";
					$bank_params = array(
						':pm_id' => $payment_mode_id,
						':deleted' => 0
					);

					$bank_result = $this->basic_obj->getQueryRecords(
						$GLOBALS['bank_table'],
						$bank_check_query,
						$bank_params
					);

					if (!empty($bank_result)) {
						$payment_modes[] = array(
							'payment_mode_id' => $payment_mode_id,
							'payment_mode_name' => $payment_mode_name
						);
					}
				}
			}

			return $payment_modes;
		}


		public function GetBankLinkedCount($bank_id) {
            $list = array(); $select_query = ""; $where = ""; $count = 0;$params = array();
            if(!empty($bank_id)) {
                $where = " bank_id = :bank_id AND ";
                $params['bank_id'] = $bank_id;
                             
                $select_query = "SELECT id_count FROM (
                                    (SELECT count(id) as id_count FROM ".$GLOBALS['payment_table']." WHERE ".$where." deleted = :p_deleted)
                                    UNION ALL 
                                    (SELECT count(id) as id_count FROM ".$GLOBALS['voucher_table']." WHERE ".$where." deleted = :v_deleted)
                                    UNION ALL 
                                    (SELECT count(id) as id_count FROM ".$GLOBALS['mainpage_table']." WHERE ".$where." deleted = :r_deleted)
                                )   as g";
                $params['p_deleted'] = 0;
                $params['v_deleted'] = 0;
                $params['r_deleted'] = 0;
                                
                $list = $this->basic_obj->getQueryRecords('', $select_query,$params);
            }
            if(!empty($list)) {
                foreach($list as $data) {
                    if(!empty($data['id_count']) && $data['id_count'] != $GLOBALS['null_value']) {
                        $count = $data['id_count'];
                    }
                }
            }
            return $count;
        }

        
        public function GetPaymentmodeLinkedCount($payment_mode_id) {
            $list = array(); $select_query = ""; $where = ""; $count = 0;$params = array();
            if(!empty($payment_mode_id)) {
                $where = " payment_mode_id = :payment_mode_id AND ";
                $params['payment_mode_id'] = $payment_mode_id;
                             
                $select_query = "SELECT id_count FROM (
                                    (SELECT count(id) as id_count FROM ".$GLOBALS['payment_table']." WHERE ".$where." deleted = :p_deleted)
                                    UNION ALL 
                                    (SELECT count(id) as id_count FROM ".$GLOBALS['voucher_table']." WHERE ".$where." deleted = :v_deleted)
                                    UNION ALL 
                                    (SELECT count(id) as id_count FROM ".$GLOBALS['mainpage_table']." WHERE ".$where." deleted = :r_deleted)
                                    UNION ALL 
                                    (SELECT count(id) as id_count FROM ".$GLOBALS['bank_table']." WHERE ".$where." deleted = :b_deleted)
                                )   as g";
                $params['p_deleted'] = 0;
                $params['v_deleted'] = 0;
                $params['r_deleted'] = 0;
                $params['b_deleted'] = 0;
                                
                $list = $this->basic_obj->getQueryRecords('', $select_query,$params);
            }
            if(!empty($list)) {
                foreach($list as $data) {
                    if(!empty($data['id_count']) && $data['id_count'] != $GLOBALS['null_value']) {
                        $count = $data['id_count'];
                    }
                }
            }
            return $count;
        }


		public function CheckSizeAlreadyExists($size_name) {
			$list = array(); $select_query = ""; $size_id = ""; $where = ""; $params=array();
		
			if(!empty($size_name)) {
				$select_query = "SELECT size_id FROM " . $GLOBALS['size_table'] . " WHERE lower_case_name = :size_name AND deleted = :deleted";	
				$params['size_name'] =$size_name;
				$params['deleted'] = 0;
			}
			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['size_table'], $select_query,$params);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['size_id'])) {
							$size_id = $data['size_id'];
						}
					}
				}
			}
			return $size_id;
		}

		public function getSizeList($row, $rowperpage, $order_column, $order_direction, $search_value) {
            $select_query = $where = ""; $list = array(); $order_by_query = "";
			if(!empty($search_value)){
				$where = " u.lower_case_name LIKE :search_value AND ";
				$params[':search_value'] = '%' . $search_value . '%';
			}
            if(!empty($order_column) && !empty($order_direction)) {
                $order_by_query = "ORDER BY ".$order_column." ".$order_direction;
            }
            else {
                $order_by_query = "ORDER BY id DESC";
            }

            if(!empty($rowperpage)) {
                $select_query = "SELECT u.* FROM {$GLOBALS['size_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query." LIMIT $row, $rowperpage";
            }
            else {
                $select_query = "SELECT u.* FROM {$GLOBALS['size_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query;
            }
            $params[':deleted'] = 0;
            $list = $this->basic_obj->getQueryRecords($GLOBALS['size_table'], $select_query, $params);
            return $list;
        }


		public function StockUpdate($page_table,$in_out_type,$bill_unique_id,$bill_unique_number,$product_id,$unit_id,$size_id, $remarks, $stock_date, $quantity,$party_id) {
            $bill_company_id = $GLOBALS['bill_company_id'];
            $product_name = ""; $unit_name = "";$factory_id = $GLOBALS['null_value'];$factory_name = $GLOBALS['null_value'];
            $product_name = $this->basic_obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_id, 'product_name');
            $unit_name = $this->basic_obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $unit_id, 'unit_name');   
            $size_name = $this->basic_obj->getTableColumnValue($GLOBALS['size_table'], 'size_id', $size_id, 'size_name');            
            $inward_unit = 0;  $outward_unit = 0; 
          
            if(empty($party_id)) {
                $party_id = $GLOBALS['null_value'];
            }
           
			if($in_out_type == "In") {
				$inward_unit = $quantity;
			}
			else if($in_out_type == "Out") {
				$outward_unit = $quantity;
			}
            
            
            $created_date_time = $GLOBALS['create_date_time_label']; 
			$updated_date_time = $GLOBALS['create_date_time_label']; 
            $creator = $GLOBALS['creator'];
            $creator_name = $this->basic_obj->encode_decode('encrypt', $GLOBALS['creator_name']);
        
            $stock_action = ""; 
            if($in_out_type == "In") {
                $stock_action = $GLOBALS['stock_action_plus'];
            }
            else if($in_out_type == "Out") {
                $stock_action = $GLOBALS['stock_action_minus'];
            }
            
            $stock_type = "";
            if($page_table == $GLOBALS['estimate_table']) {
                $stock_type = "Estimate";
            }
            else if($page_table == $GLOBALS['invoice_table']) {
                $stock_type = "Invoice";
            }
        
            if(empty($bill_unique_number)) {
                $bill_unique_number = $GLOBALS['null_value'];
            }
            
            $stock_unique_id = ""; 
            $stock_unique_id = $this->getStockUniqueID($bill_unique_id,$product_id,$unit_id,$size_id);
            if(preg_match("/^\d+$/", $stock_unique_id)) {
                $action = "Updated Successfully!";
                $columns = array(); $values = array();
                $columns = array('updated_date_time','creator_name','party_id','stock_date', 'unit_id','unit_name','size_id','size_name','product_id', 'product_name',  'inward_unit','outward_unit',  'stock_type', 'stock_action', 'bill_unique_id', 'bill_unique_number', 'remarks');
                $values = array($updated_date_time, $creator_name, $party_id, $stock_date, $unit_id,$unit_name,$size_id,$size_name,$product_id, $product_name,  $inward_unit,  $outward_unit, $stock_type, $stock_action, $bill_unique_id, $bill_unique_number, $remarks);
                $stock_update_id = $this->basic_obj->UpdateSQL($GLOBALS['stock_table'], $stock_unique_id, $columns, $values, $action);
            }
            else {
                $action = "Inserted Successfully!";
                $columns = array(); $values = array();
                $columns = array('created_date_time','updated_date_time', 'creator', 'creator_name', 'bill_company_id', 'party_id','stock_date', 'unit_id','unit_name','size_id','size_name','product_id', 'product_name',  'inward_unit','outward_unit',  'stock_type', 'stock_action', 'bill_unique_id', 'bill_unique_number', 'remarks', 'deleted');
                $values = array($created_date_time,$updated_date_time, $creator, $creator_name, $bill_company_id, $party_id, $stock_date, $unit_id,$unit_name,$size_id,$size_name,$product_id, $product_name,  $inward_unit,  $outward_unit, $stock_type, $stock_action, $bill_unique_id, $bill_unique_number, $remarks, '0');
                $stock_update_id = $this->basic_obj->InsertSQL($GLOBALS['stock_table'], $columns, $values,'', '', $action);
            }
    
			
        }
	
		public function getStockUniqueID($bill_unique_id, $product_id, $unit_id, $size_id) {
            $where = ""; $select_query = ""; $list = $params = array();$unique_id = "";
            if(!empty($bill_unique_id)) {
                if(!empty($where)) {
                    $where = $where." bill_unique_id = :bill_unique_id AND ";
                }
                else {
                    $where = " bill_unique_id = :bill_unique_id AND ";
                }
                $params['bill_unique_id'] = $bill_unique_id;
            }
            if(!empty($product_id)) {
                if(!empty($where)) {
                    $where = $where." product_id = :product_id AND ";
                }
                else {
                    $where = " product_id = :product_id AND ";
                }
                $params['product_id'] = $product_id;
            }
            if(!empty($unit_id)) {
                if(!empty($where)) {
                    $where = $where." unit_id = :unit_id AND ";
                }
                else {
                    $where = " unit_id = :unit_id AND ";
                }
                $params['unit_id'] = $unit_id;
            }
			if(!empty($size_id)) {
                if(!empty($where)) {
                    $where = $where." size_id = :size_id AND ";
                }
                else {
                    $where = " size_id = :size_id AND ";
                }
                $params['size_id'] = $size_id;
            }

            if(!empty($where)) {
                $select_query = "SELECT id FROM ".$GLOBALS['stock_table']." WHERE ".$where." deleted = :deleted";
				$params['deleted'] = 0;
                $list = $this->basic_obj->getQueryRecords('', $select_query, $params);
            }
            if(!empty($list)) {
                foreach($list as $data) {
                    if(!empty($data['id']) && $data['id'] != $GLOBALS['null_value']) {
                        $unique_id = $data['id'];
                    }
                }
            }
            return $unique_id;
        }

		public function DeletePrevList($bill_id, $stock_unique_ids) {
            $prev_stock_list = array();
            $prev_stock_list = $this->PrevStockList($bill_id);
            
            if(!empty($prev_stock_list)) {
                foreach($prev_stock_list as $data) {
                    if(!empty($data['id'])) {
                        $stock_update_id = "";
                        if(!empty($stock_unique_ids)) {
                            if(!in_array($data['id'], $stock_unique_ids)) {
                                $action = "Deleted Successfully!";
                                $columns = array(); $values = array();
                                $columns = array('deleted');
                                $values = array('1');
                                $stock_update_id = $this->basic_obj->UpdateSQL($GLOBALS['stock_table'], $data['id'], $columns, $values, $action);
                            }
                        }
                        else {
                            $action = "Deleted Successfully!";
                            $columns = array(); $values = array();
                            $columns = array('deleted');
                            $values = array('1');
                            $stock_update_id = $this->basic_obj->UpdateSQL($GLOBALS['stock_table'], $data['id'], $columns, $values, $action);
                        }
                    }
                }
            }
        }
		public function PrevStockList($bill_unique_id) {
            $select_query = ""; $list = array(); $params = array();
            $select_query = "SELECT * FROM ".$GLOBALS['stock_table']." WHERE bill_unique_id = :bill_unique_id AND deleted = :deleted ";
            $params['bill_unique_id'] = $bill_unique_id;
            $params['deleted'] = 0;
            $list = $this->basic_obj->getQueryRecords('', $select_query, $params);
            return $list;
        }

		public function getOutwardQty($bill_unique_id,$unit_id,$size_id,$product_id,$party_id) {
            $where = ""; $select_query = ""; $list = $params = array(); $outward_unit = 0;

            if(!empty($bill_unique_id)) {
                if(!empty($where)) {
                    $where = $where." bill_unique_id != :bill_unique_id AND ";
                }
                else {
                    $where = " bill_unique_id != :bill_unique_id AND ";
                }
                $params['bill_unique_id'] = $bill_unique_id;
            }
            if(!empty($size_id)) {
                if(!empty($where)) {
                    $where = $where." size_id = :size_id AND ";
                }
                else {
                    $where = " size_id = :size_id AND ";
                }
                $params['size_id'] = $size_id;
            }
			if(!empty($party_id)) {
                if(!empty($where)) {
                    $where = $where." party_id = :party_id AND ";
                }
                else {
                    $where = " party_id = :party_id AND ";
                }
                $params['party_id'] = $party_id;
            }
            if(!empty($product_id)) {
                if(!empty($where)) {
                    $where = $where." product_id = :product_id AND ";
                }
                else {
                    $where = " product_id = :product_id AND ";
                }
                $params['product_id'] = $product_id;
            }
            if(!empty($unit_id)) {
                if(!empty($where)) {
                    $where = $where." unit_id = :unit_id AND ";
                }
                else {
                    $where = " unit_id = :unit_id AND ";
                }
                $params['unit_id'] = $unit_id;
            }
			
            $params['deleted'] = '0';

            if(!empty($where)) {
                $select_query = "SELECT SUM(outward_unit) as outward_unit FROM ".$GLOBALS['stock_table']." WHERE ".$where." deleted = :deleted";
                $list = $this->basic_obj->getQueryRecords('', $select_query, $params);
            }
            else
            {
                $select_query = "SELECT SUM(outward_unit) as outward_unit FROM ".$GLOBALS['stock_table']." WHERE deleted = :deleted";
                $list = $this->basic_obj->getQueryRecords('', $select_query, $params);
            }
            if(!empty($list)) {
                foreach($list as $data) {
                    if(!empty($data['outward_unit']) && $data['outward_unit'] != $GLOBALS['null_value']) {
                        $outward_unit = $data['outward_unit'];
                    }
                }
            }
            return $outward_unit;
        }

		public function getPaymentModeTable($row, $rowperpage, $order_column, $order_direction, $search_value) {
            $select_query = $where = ""; $list = array(); $order_by_query = ""; $params = array();
			if(!empty($search_value)){
				$where = " u.payment_mode_name LIKE :search_value AND ";
				$params[':search_value'] = '%' . $search_value . '%';
			}
            if(!empty($order_column) && !empty($order_direction)) {
                $order_by_query = "ORDER BY ".$order_column." ".$order_direction;
            }
            else {
                $order_by_query = "ORDER BY id DESC";
            }

            if(!empty($rowperpage)) {
                $select_query = "SELECT u.* FROM {$GLOBALS['payment_mode_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query." LIMIT $row, $rowperpage";
            }
            else {
                $select_query = "SELECT u.* FROM {$GLOBALS['payment_mode_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query;
            }
            $params[':deleted'] = 0;
            $list = $this->basic_obj->getQueryRecords($GLOBALS['payment_mode_table'], $select_query, $params);
            return $list;
        }

		public function CheckPaymentModeAlreadyExists($company_id, $payment_mode_name) {
			$list = array(); $select_query = ""; $payment_mode_id = ""; $where = ""; $params=array();
		
			if(!empty($payment_mode_name)) {
                $where = "";
                if(!empty($company_id)) {
                    $where = "bill_company_id = :company_id AND ";
                    $params['company_id'] = $company_id;
                }
				$select_query = "SELECT payment_mode_id FROM " . $GLOBALS['payment_mode_table'] . " WHERE {$where} lower_case_name = :payment_mode_name AND deleted = :deleted";	
				$params['payment_mode_name'] = $payment_mode_name;
				$params['deleted'] = 0;
			}
			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['payment_mode_table'], $select_query, $params);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['payment_mode_id'])) {
							$payment_mode_id = $data['payment_mode_id'];
						}
					}
				}
			}
			return $payment_mode_id;
		}
    }
?>