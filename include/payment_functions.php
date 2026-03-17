<?php 
 class Payment_Functions {
		private $basic_obj;

		public function initialize(Basic_Functions $basic_obj) {
			$this->basic_obj = $basic_obj;
		}
		public function connect() {
			$db = new db();

			$con = $db->connect();
			return $con;
		}
		public function UpdateBalance($bill_company_id,$bill_id,$bill_number,$bill_date,$bill_type,$party_id,$party_name,$party_type,$payment_mode_id,$payment_mode_name,$bank_id,$bank_name,$opening_balance,$opening_balance_type,$credit,$debit){
			
			$select_query = ""; $lists = array(); $unique_id = ""; $params = array(); $where = '';
			$params['bill_company_id'] = $bill_company_id;
			$params['bill_id'] = $bill_id;
			$params['deleted'] = 0;
			if( !empty($payment_mode_id) && ($payment_mode_id != $GLOBALS['null_value'])) {
				$where = "payment_mode_id = :payment_mode_id AND ";
				$params['payment_mode_id'] = $payment_mode_id;
			}
			if (in_array($bill_type, ['Purchase Estimate', 'Purchase Invoice', 'Quotation', 'Estimate', 'Invoice'])){
				$select_query = "SELECT id FROM ".$GLOBALS['payment_table']." WHERE bill_company_id = :bill_company_id AND bill_id = :bill_id AND deleted = :deleted";
			}
			else {
				$select_query = "SELECT id FROM ".$GLOBALS['payment_table']." WHERE bill_company_id = :bill_company_id AND bill_id = :bill_id AND {$where} deleted = :deleted";
			} 	
			$lists = $this->basic_obj->getQueryRecords($GLOBALS['payment_table'], $select_query,$params);
			if(!empty($lists)) {
				foreach($lists as $data) {
					if(!empty($data['id']) && $data['id'] != $GLOBALS['null_value']) {
						$unique_id = $data['id'];
					}
				}
			}

			
			$created_date_time = $GLOBALS['create_date_time_label'];
			$updated_date_time = $GLOBALS['create_date_time_label'];
            $creator = $GLOBALS['creator'];
            $creator_name = $GLOBALS['creator_name'];
			
			if(preg_match("/^\d+$/", $unique_id)) {
				$action = "Updated Successfully";
				$columns = array(); $values = array();
				$columns = array('updated_date_time','creator_name','bill_date','party_id','party_name','party_type','bank_id','bank_name','payment_mode_id','payment_mode_name','opening_balance','opening_balance_type','credit','debit');
				$values = array($updated_date_time,$creator_name,$bill_date,$party_id,$party_name,$party_type,$bank_id,$bank_name,$payment_mode_id,$payment_mode_name,$opening_balance,$opening_balance_type,$credit,$debit);
				$payment_update_id = $this->basic_obj->UpdateSQL($GLOBALS['payment_table'], $unique_id, $columns, $values, $action);
			}
			else {
				$action = "Inserted Successfully";
				$null_value = $GLOBALS['null_value'];
				$columns = array(); $values = array();
				$columns = array('created_date_time','updated_date_time','creator', 'creator_name', 'bill_company_id','bill_id','bill_number','bill_date','bill_type','party_id','party_name','party_type','bank_id','bank_name','payment_mode_id','payment_mode_name','opening_balance','opening_balance_type','credit','debit','deleted');
				$values = array($created_date_time,$updated_date_time, $creator, $creator_name, $bill_company_id,$bill_id,$bill_number,$bill_date,$bill_type,$party_id,$party_name,$party_type,$bank_id,$bank_name,$payment_mode_id,$payment_mode_name,$opening_balance,$opening_balance_type,$credit,$debit,0);
				$payment_update_id = $this->basic_obj->InsertSQL($GLOBALS['payment_table'], $columns, $values, '', '', $action);
			}

			return $payment_update_id;
		}        

		public function PartyOpeningList($party_id){

			$count = 0;
			
			$select_query = "";
			$select_query = "SELECT COUNT(id) as id_count FROM ".$GLOBALS['payment_table']." WHERE party_id = :party_id AND bill_type != :bill_type AND deleted = :deleted";
			$params['party_id'] = $party_id;
			$params['bill_type'] = "Opening Balance";
			$params['deleted'] = 0;
            
            if(!empty($select_query)) {
                $list = $this->basic_obj->getQueryRecords($GLOBALS['payment_table'], $select_query, $params);
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

		public function getVoucherList($row, $rowperpage, $order_column, $order_direction, $search_value,$cancelled,$from_date,$to_date,$party_id) {
            $select_query = $where = ""; $list = array(); $order_by_query = "";
			if(!empty($search_value)){
				$where = " u.voucher_number LIKE :search_value AND ";
				$params[':search_value'] = '%' . $search_value . '%';
			}
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." voucher_date >= :from_date AND ";
				}
				else {
					$where = " voucher_date >= :from_date AND ";
				}
				$params['from_date'] = $from_date;
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." voucher_date <= :to_date AND ";
				}
				else {
					$where = " voucher_date <= :to_date AND ";
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
            if(!empty($order_column) && !empty($order_direction)) {
                $order_by_query = "ORDER BY ".$order_column." ".$order_direction;
            }
            else {
                $order_by_query = "ORDER BY id DESC";
            }

            if(!empty($rowperpage)) {
                $select_query = "SELECT u.* FROM {$GLOBALS['voucher_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query." LIMIT $row, $rowperpage";
				$params['deleted'] = $cancelled;
            }
            else {
                $select_query = "SELECT u.* FROM {$GLOBALS['voucher_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query;
				$params['deleted'] = $cancelled;
				// print_r($params);
            }
            $list = $this->basic_obj->getQueryRecords($GLOBALS['voucher_table'], $select_query, $params);
            return $list;
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

        public function getPendingList($party_id) {
        	$select_query = ""; $list = array();
			if(!empty($party_id)) {
				
				$select_query = "SELECT * FROM " . $GLOBALS['payment_table'] . " WHERE party_id = :party_id AND deleted = :deleted ORDER BY bill_date ASC";
				$params['party_id'] = $party_id;
                $params['deleted'] = 0;
				$list = $this->basic_obj->getQueryRecords($GLOBALS['payment_table'], $select_query,$params);
			}
			return $list;
		}

		public function getReceiptList($row, $rowperpage, $order_column, $order_direction, $search_value,$cancelled,$from_date,$to_date,$party_id) {
            $select_query = $where = ""; $list = array(); $order_by_query = "";
			if(!empty($search_value)){
				$where = " u.receipt_number LIKE :search_value AND ";
				$params[':search_value'] = '%' . $search_value . '%';
			}
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." receipt_date >= :from_date AND ";
				}
				else {
					$where = " receipt_date >= :from_date AND ";
				}
				$params['from_date'] = $from_date;
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." receipt_date <= :to_date AND ";
				}
				else {
					$where = " receipt_date <= :to_date AND ";
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
            if(!empty($order_column) && !empty($order_direction)) {
                $order_by_query = "ORDER BY ".$order_column." ".$order_direction;
            }
            else {
                $order_by_query = "ORDER BY id DESC";
            }

            if(!empty($rowperpage)) {
                $select_query = "SELECT u.* FROM {$GLOBALS['receipt_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query." LIMIT $row, $rowperpage";
				$params['deleted'] = $cancelled;
            }
            else {
                $select_query = "SELECT u.* FROM {$GLOBALS['receipt_table']} as u WHERE {$where} u.deleted = :deleted ".$order_by_query;
				$params['deleted'] = $cancelled;
				// print_r($params);
            }
            $list = $this->basic_obj->getQueryRecords($GLOBALS['receipt_table'], $select_query, $params);
            return $list;
        }

        public function PaymentlinkedParty($party_id){
            $list = array(); $select_query = "";  $count = 0; $params = array(); $where = "";
            if(!empty($party_id)){
				$where = " FIND_IN_SET(:party_id, party_id) AND ";
				$params[':party_id'] = $party_id;
            }

            if(!empty($where)){
                $select_query = "SELECT count(id) as id_count FROM " . $GLOBALS['payment_table'] . " WHERE " . $where . " bill_type != 'Opening Balance' AND deleted = '0' AND bill_company_id = '".$GLOBALS['bill_company_id']."'";
                $list = $this->basic_obj->getQueryRecords('', $select_query, $params);
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

        public function getPartyTypeList($type) {
            $select_query = ""; $params =  array(); $where = "";
            if ($type == 'Purchase') {
                $select_query = "
                    SELECT *
                    FROM ".$GLOBALS['party_table']."
                    WHERE deleted = :deleted 
                    AND bill_company_id = :bill_company_id
                    AND (party_type = :party_type1 OR party_type = :party_type3)
                ";
				$params['party_type1'] = 1;
            } 
            elseif ($type == 'Sales') {
                $select_query = "
                    SELECT *
                    FROM ".$GLOBALS['party_table']."
                    WHERE deleted = :deleted
                    AND bill_company_id = :bill_company_id
                    AND (party_type = :party_type2 OR party_type = :party_type3)
                ";
				$params['party_type2'] = 2;
            } else {
                $select_query = "
                    SELECT *
                    FROM ".$GLOBALS['party_table']."
                    WHERE deleted = '0'
                    AND bill_company_id = :bill_company_id
                ";
            }

			$params['deleted'] = 0;
			$params['bill_company_id'] = $GLOBALS['bill_company_id'];
			$params['party_type3'] = 3;

			
            $list = $this->basic_obj->getQueryRecords($GLOBALS['party_table'], $select_query, $params);
            return $list;
        }

		public function getPartyBills($bill_company_id, $party_id, $from_page) {
			$list = []; 
			$sql = ""; 

			$whereParts = [];
			$params = [];

			if (!empty($bill_company_id)) {
				$whereParts[] = "g.bill_company_id = :bill_company_id";
				$params['bill_company_id'] = $bill_company_id;
			}

			if (!empty($party_id)) {
				$whereParts[] = "g.party_id = :party_id";
				$params['party_id'] = $party_id;
			}

			$conditions = [
				"(g.fully_paid IS NULL OR g.fully_paid = :null_value OR g.fully_paid = 'P')"
			];

			$params['null_value'] = $GLOBALS['null_value'];

			$conditions = array_merge($conditions, $whereParts);

			if($from_page == 'receipt') {
				// Eswari Traders has estimate and invoice tables
				$sql = "
					SELECT *
					FROM (
						SELECT 
							e.bill_company_id,
							e.party_id,
							e.estimate_date AS bill_date,
							e.estimate_id AS bill_id,
							e.estimate_number AS bill_number,
							e.bill_total,
							'Estimate' AS bill_type,
							e.fully_paid
						FROM {$GLOBALS['estimate_table']} e
						WHERE e.cancelled = :e_cancelled

						UNION ALL

						SELECT 
							i.bill_company_id,
							i.party_id,
							i.invoice_date AS bill_date,
							i.invoice_id AS bill_id,
							i.invoice_number AS bill_number,
							i.bill_total,
							'Invoice' AS bill_type,
							i.fully_paid
						FROM {$GLOBALS['invoice_table']} i
						WHERE i.cancelled = :i_cancelled
					) g
					WHERE " . implode(" AND ", $conditions) . "
					ORDER BY g.bill_date ASC
				";
			} else if ($from_page == 'voucher') {
				// If Eswari Traders adds Purchase later, add those tables here
				$sql = "";
			} 			

			$params['e_cancelled'] = 0;
			$params['i_cancelled'] = 0;

			if (!empty($sql)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['payment_table'], $sql, $params);
			}

			return $list;
		} 

		public function PreviousPaidAmount($party_id, $bill_id, $bill_company_id, $from_page) {
			$list = []; 
			$select_query = ""; 
			$where = "";
			$params = [];
			$paid_amount = 0;

			if (!empty($bill_company_id)) {
				$where = "bill_company_id = :bill_company_id AND ";
				$params['bill_company_id'] = $bill_company_id;
			}

			if (!empty($party_id)) {
				if (!empty($where)) {
					$where .= " party_id = :party_id AND ";
				} else {
					$where = "party_id = :party_id AND ";
				}
				$params['party_id'] = $party_id;
			}

			if (!empty($bill_id)) {
				if (!empty($where)) {
					$where .= " paid_bills = :bill_id AND ";
				} else {
					$where = "paid_bills = :bill_id AND ";
				}
				$params['bill_id'] = $bill_id;
			}

			

			if (!empty($where)) {
				if($from_page == 'receipt') {
					$select_query = "SELECT SUM(COALESCE(credit, 0)) AS paid_amount FROM {$GLOBALS['payment_table']} WHERE $where deleted = :deleted ORDER BY bill_date ASC";
				} else if ($from_page == 'voucher') {
					$select_query = "SELECT SUM(COALESCE(debit, 0)) AS paid_amount FROM {$GLOBALS['payment_table']} WHERE $where deleted = :deleted ORDER BY bill_date ASC";
				}
				
			} 
			$params['deleted'] = 0;

			if (!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['payment_table'], $select_query, $params);
				if(!empty($list)) {
					foreach($list as $data) {
						$paid_amount = $data['paid_amount'];
					}
				}
			}

			return $paid_amount;
		}

		public function getBillDetails($bill_id) {
			
				$list = array(); 
				$params = array();	$where = "";	
				
				if (!empty($bill_id)) {
					$where = "bill_id = :bill_id AND";
					$params['bill_id'] = $bill_id;
				}

				$select_query = "SELECT * FROM {$GLOBALS['payment_table']} WHERE $where deleted = :deleted ORDER BY bill_date ASC";
			$params['deleted'] = 0;

			if (!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['payment_table'], $select_query, $params);
				
			}

			return $list;
		}

		public function RevertBillStatus($table, $type, $bill_id) {

			$msg = "";

			if(!empty($table) && (!empty($bill_id))) {
				$action = "Fully Paid status Update.";
                    
				$columns = array(); $values = array();						
				$columns = array('fully_paid');
				$values = array("NULL");
				$msg = $this->basic_obj->UpdateSQL($table, $bill_id, $columns, $values, $action);
			} 	
			
			return $msg;

		}
}
