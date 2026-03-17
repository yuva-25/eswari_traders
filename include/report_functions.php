<?php 
    class Report_functions {
		
		private $basic_obj;

		public function initialize(Basic_Functions $basic_obj) {
			$this->basic_obj = $basic_obj;
		}
		public function connect() {
			$db = new db();

			$con = $db->connect();
			return $con;
		}

		public function getOrderFormReport($bill_company_id,$filter_party_id,$from_date, $to_date,$cancel_bill_btn) { 
			$list = $params = array(); $select_query = ""; $where = ""; 

			$bill_company_id = $GLOBALS['bill_company_id'];
			
			if(!empty($bill_company_id)) {
				$where = "bill_company_id = :bill_company_id";
				$params['bill_company_id'] = $bill_company_id;
			}

			if(!empty($filter_party_id)) {
				if(!empty($where)) {
					$where = $where." AND party_id = :filter_party_id";
				}
				else {
					$where = "party_id = :filter_party_id";
				}
				$params['filter_party_id'] = $filter_party_id;

			}
			
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND order_form_date >= :from_date"; 
				}
				else {
					$where = "order_form_date >= :from_date";
				}
				$params['from_date'] = $from_date;
			}
			
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND order_form_date <= :to_date"; 	
				}
				else {
					$where = "order_form_date <= :to_date";
				}
				$params['to_date'] = $to_date;
			}

			if(empty($cancel_bill_btn)) {   
				if(!empty($where)) {
					$where .= " AND cancelled = :cancelled";
				} else {
					$where = "cancelled = :cancelled";
				}
				$params['cancelled'] = 0;
			}

			$select_query = "";
			if(!empty($where)) {
				$select_query = "SELECT * FROM ".$GLOBALS['order_form_table']."  WHERE ".$where." ORDER BY created_date_time ASC";
			} else {
				$select_query = "SELECT * FROM ".$GLOBALS['order_form_table']." ORDER BY created_date_time ASC";
			}

			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords('', $select_query,$params);
			}
			return $list;
		} 

		public function getSalesBillReport($bill_company_id,$filter_party_id,$from_date, $to_date,$view_type,$cancel_bill_btn) {
			$list = array(); $select_query = ""; $where = ""; $params = array();

			if(!empty($bill_company_id)) {
				$where = "bill_company_id = :bill_company_id";
				$params['bill_company_id'] = $bill_company_id;
			}

			if(!empty($filter_party_id)) {
				if(!empty($where)) {
					$where = $where." AND party_id = :party_id";
				}
				else {
					$where = "party_id = :party_id";
				}
				$params['party_id'] = $filter_party_id;
			}
			
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND bill_date >= :from_date";
				}
				else {
					$where = "bill_date >= :from_date";
				}
				$params['from_date'] = $from_date;
			}
			
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND bill_date <= :to_date";
				}
				else {
					$where = "bill_date <= :to_date";
				}
				$params['to_date'] = $to_date;
			}

			if(!empty($view_type)) {
				if(!empty($where)) {
					$where = $where." AND type = :type";
				}
				else {
					$where = "type = :type";
				}
				$params['type'] = $view_type;
			}

			if(empty($cancel_bill_btn)) {   
				if(!empty($where)) {
					$where .= " AND cancelled = :cancelled";
				} else {
					$where = "cancelled = :cancelled";
				}
				$params['cancelled'] = 0;
			}

			
			$select_query = "";
			if(!empty($where) ) {

				$select_query = "SELECT bill_id,bill_company_id,bill_number,bill_date,party_id,amount,party_details,cancelled,type FROM (

				SELECT 
					est.estimate_id AS bill_id,
					est.bill_company_id,
					est.estimate_number AS bill_number,
					est.estimate_date AS bill_date,
					est.party_id,
					est.total_amount AS amount,
					est.party_details,
					est.cancelled,
					'estimate' AS type
					FROM ".$GLOBALS['estimate_table']." AS est 
					WHERE est.deleted = '0' 
				UNION ALL
                
				SELECT 
					inv.invoice_id AS bill_id,
					inv.bill_company_id,
					inv.invoice_number AS bill_number,
					inv.invoice_date AS bill_date,
					inv.party_id,
					inv.total_amount AS amount,
					inv.party_details,
					inv.cancelled,
					'invoice' AS type
					FROM ".$GLOBALS['invoice_table']." AS inv 
					WHERE inv.deleted = '0' 
				
				) AS g WHERE ".$where." ORDER BY bill_date DESC";
			}
			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords('', $select_query,$params);
				
			}
			return $list;
		}

		public function GetSalesTaxReportList($from_date, $to_date, $party_id) {
            $select_query = ""; $list = array(); $where = ""; $params = array();

			$bill_company_id = $GLOBALS['bill_company_id'];
			
			if(!empty($bill_company_id)) {
				$where = "bill_company_id = :bill_company_id";
				$params['bill_company_id'] = $bill_company_id;
			}

            if (!empty($from_date) && $from_date != "0000-00-00") {
                $from_date = date('Y-m-d', strtotime($from_date));
                if (!empty($where)) {
                    $where .= " AND DATE(invoice_date) >= :from_date";
                } else {
                    $where = "DATE(invoice_date) >= :from_date";
                }
                $params[':from_date'] = $from_date;
            }

            if (!empty($to_date) && $to_date != "0000-00-00") {
                $to_date = date('Y-m-d', strtotime($to_date));
                if (!empty($where)) {
                    $where .= " AND DATE(invoice_date) <= :to_date";
                } else {
                    $where = "DATE(invoice_date) <= :to_date";
                }
                $params[':to_date'] = $to_date;
            }

            if (!empty($party_id)) {
                if (!empty($where)) {
                    $where .= " AND party_id = :party_id";
                } else {
                    $where = "party_id = :party_id";
                }
                $params[':party_id'] = $party_id;
            }

			if (!empty($where)) {
                $where .= " AND gst_option = :gst_option";
            } else {
                $where = "gst_option = :gst_option";
            }
            $params[':gst_option'] = 1;


            if (!empty($where)) {
                $where .= " AND deleted = :deleted";
            } else {
                $where = "deleted = :deleted";
            }
            $params[':deleted'] = 0;

            $select_query = "SELECT * FROM {$GLOBALS['invoice_table']} WHERE $where  ORDER BY id DESC";
			// echo $select_query;
			// print_r($params);
            
            $list = $this->basic_obj->getQueryRecords('', $select_query, $params);

            return $list;
        }

		public function GetPurchaseTaxReportList($from_date, $to_date, $party_id) {
            $select_query = ""; $list = array(); $where = ""; $params = array();

			$bill_company_id = $GLOBALS['bill_company_id'];
			
			if(!empty($bill_company_id)) {
				$where = "bill_company_id = :bill_company_id";
				$params['bill_company_id'] = $bill_company_id;
			}

            if (!empty($from_date) && $from_date != "0000-00-00") {
                $from_date = date('Y-m-d', strtotime($from_date));
                if (!empty($where)) {
                    $where .= " AND DATE(purchase_date) >= :from_date";
                } else {
                    $where = "DATE(purchase_date) >= :from_date";
                }
                $params[':from_date'] = $from_date;
            }

            if (!empty($to_date) && $to_date != "0000-00-00") {
                $to_date = date('Y-m-d', strtotime($to_date));
                if (!empty($where)) {
                    $where .= " AND DATE(purchase_date) <= :to_date";
                } else {
                    $where = "DATE(purchase_date) <= :to_date";
                }
                $params[':to_date'] = $to_date;
            }

            if (!empty($party_id)) {
                if (!empty($where)) {
                    $where .= " AND party_id = :party_id";
                } else {
                    $where = "party_id = :party_id";
                }
                $params[':party_id'] = $party_id;
            }

			if (!empty($where)) {
                $where .= " AND gst_option = :gst_option";
            } else {
                $where = "gst_option = :gst_option";
            }
            $params[':gst_option'] = 1;


            if (!empty($where)) {
                $where .= " AND deleted = :deleted";
            } else {
                $where = "deleted = :deleted";
            }
            $params[':deleted'] = 0;

            $select_query = "SELECT * FROM {$GLOBALS['purchase_table']} WHERE $where  ORDER BY id DESC";
            
            $list = $this->basic_obj->getQueryRecords('', $select_query, $params);

            return $list;
        }

		 function getSalesStockReportList($party_id,$product_id) {
            $select_query = ""; $list = array(); $where = ""; $params = array();


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

            $params[':deleted'] = 0;
            if(!empty($where)) {
             $select_query = "SELECT DISTINCT product_id FROM ".$GLOBALS['stock_table']." WHERE ".$where." deleted = :deleted ORDER BY id ASC";    
            }
            else{
                $select_query = "SELECT DISTINCT product_id FROM ".$GLOBALS['stock_table']." WHERE deleted = :deleted ORDER BY id ASC";
            }
            if(!empty($select_query)) {
                $list = $this->basic_obj->getQueryRecords($GLOBALS['stock_table'], $select_query, $params);
            }
            return $list;

        }

		function getSalesDetailStockReportList($from_date, $to_date,$filter_party_id,$filter_product_id,$filter_size_id,$filter_unit_id) {
            $select_query = ""; $list = array(); $where = ""; $params = array();
            if(!empty($from_date)) {
                $from_date = date("Y-m-d", strtotime($from_date));
                if(!empty($where)) {
                    $where = $where." stock_date >= :from_date AND ";
                }
                else {
                    $where = " stock_date >= :from_date AND ";
                }
                $params['from_date'] = $from_date;
            }
            if(!empty($to_date)) {
                $to_date = date("Y-m-d", strtotime($to_date));
                if(!empty($where)) {
                    $where = $where." stock_date <= :to_date AND ";
                }
                else {
                    $where = " stock_date <= :to_date AND ";
                }
                $params['to_date'] = $to_date;
            }
            if(!empty($filter_size_id)) {
                if(!empty($where)) {
                    $where = $where." size_id = :size_id AND ";
                }
                else {
                    $where = " size_id = :size_id AND ";
                }
                $params['size_id'] = $filter_size_id;
            }
			if(!empty($filter_party_id)) {
                if(!empty($where)) {
                    $where = $where." party_id = :party_id AND ";
                }
                else {
                    $where = " party_id = :party_id AND ";
                }
                $params['party_id'] = $filter_party_id;
            }

            if(!empty($filter_unit_id)) {
                if(!empty($where)) {
                    $where = $where." unit_id = :unit_id AND ";
                }
                else {
                    $where = " unit_id = :unit_id AND ";
                }
                $params['unit_id'] = $filter_unit_id;
            }

            if(!empty($filter_product_id)) {
                if(!empty($where)) {
                    $where = $where." product_id = :product_id AND ";
                }
                else {
                    $where = " product_id = :product_id AND ";
                }
                $params['product_id'] = $filter_product_id;
            }
            
            $params[':deleted'] = 0;
            if(!empty($where)) {
                $select_query = "SELECT * FROM ".$GLOBALS['stock_table']." WHERE ".$where." deleted = :deleted ORDER BY id ASC";    
            }
            else{
                $select_query = "SELECT * FROM ".$GLOBALS['stock_table']." WHERE deleted = :deleted ORDER BY id ASC";
            }
            if(!empty($select_query)) {
                $list = $this->basic_obj->getQueryRecords($GLOBALS['stock_table'], $select_query, $params);
            }
            return $list;

        }




		public function getPaymentReportList($from_date, $to_date, $filter_bill_type, $filter_party_type, $filter_party_id, $payment_mode_id, $bank_id){
			$reports = array();
			$where = "";
			$params = array();

			$bill_company_id=$GLOBALS['bill_company_id'];
			if(!empty($bill_company_id)) {
				$where = "bill_company_id = :bill_company_id";
				$params['bill_company_id'] = $bill_company_id;
			}

			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND bill_date >= :from_date"; 
				}
				else {
					$where = "bill_date >= :from_date";
				}
				$params['from_date'] = $from_date;
			}
			
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND bill_date <= :to_date"; 	
				}
				else {
					$where = "bill_date <= :to_date";
				}
				$params['to_date'] = $to_date;
			}
			
			if(!empty($filter_party_id)) {
				if(!empty($where)) {
					$where = $where." AND party_id = :filter_party_id";
				}
				else {
					$where = "party_id = :filter_party_id";
				}
				$params['filter_party_id'] = $filter_party_id;

			}
				
			if (!empty($filter_party_type)) {
				if (!empty($where)) {
					$where = $where . " AND party_type = :party_type ";
				} else {
					$where = "party_type = :party_type";
				}
				$params['party_type'] = $filter_party_type;
			}

			if (!empty($bank_id)) {
				if (!empty($where)) {
					$where = $where . " AND bank_id = :bank_id ";
				} else {
					$where = "bank_id = :bank_id";
				}
				$params['bank_id'] = $bank_id;
			}

			if (!empty($payment_mode_id)) {
				if (!empty($where)) {
					$where = $where . " AND payment_mode_id = :payment_mode_id ";
				} else {
					$where = "payment_mode_id = :payment_mode_id";
				}
				$params['payment_mode_id'] = $payment_mode_id;
			}

			if ($filter_bill_type == 2) {
				$select_query = "SELECT * FROM " . $GLOBALS['payment_table'] . " WHERE " . $where . " AND bill_type = 'Receipt' AND deleted = :deleted ORDER BY bill_date ASC";
				$params['deleted'] = 0;
			} else if ($filter_bill_type == 1) {
				$select_query = "SELECT * FROM " . $GLOBALS['payment_table'] . " WHERE " . $where . " AND bill_type = 'Voucher' AND deleted = :deleted ORDER BY bill_date ASC";
				$params['deleted'] = 0;
			} else {
				$select_query = "SELECT * FROM " . $GLOBALS['payment_table'] . " WHERE " . $where . " AND bill_number != '" . $GLOBALS['null_value'] . "' AND bill_type IN ('Receipt', 'Voucher') AND deleted = :deleted ORDER BY bill_date ASC";
				$params['deleted'] = 0;
			}

			$reports = $this->basic_obj->getQueryRecords('', $select_query,$params);

			return $reports;
		}

		public function customer_balance_report($bill_company_id,$customer_id,$from_date,$to_date,$filter_bill_type) {

			$reports = [];

			/* ======================================================
			BUILD COMMON FILTERS (for payment table)
			====================================================== */

			$whereArr = [];
			$paymentParams = [];

			$whereArr[] = "bill_company_id = :bill_company_id";
			$whereArr[] = "deleted = 0";
			$paymentParams[':bill_company_id'] = $bill_company_id;

			if (!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				$whereArr[] = "bill_date >= :from_date";
				$paymentParams[':from_date'] = $from_date;
			}

			if (!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				$whereArr[] = "bill_date <= :to_date";
				$paymentParams[':to_date'] = $to_date;
			}

			if (!empty($filter_bill_type)) {
				$whereArr[] = "bill_type = :bill_type";
				$paymentParams[':bill_type'] = $filter_bill_type;
			}

			$whereSql = implode(" AND ", $whereArr);

			/* ======================================================
			CASE 1: SINGLE CUSTOMER
			====================================================== */
			if (!empty($customer_id)) {

				// 🔹 customer params (SEPARATE)
				$customerParams = [
					':customer_id' => $customer_id,
					':bill_company_id' => $bill_company_id
				];

				$customer_query = "
					SELECT
						party_id AS party_id,
						party_name AS party_name,
						mobile_number,
						opening_balance,
						opening_balance_type
					FROM {$GLOBALS['party_table']}
					WHERE party_id = :customer_id
					AND deleted = 0
					AND bill_company_id = :bill_company_id
				";

				$customer = $this->basic_obj->getQueryRecords('', $customer_query, $customerParams);
				if (!empty($customer)) {
					$payment_query = "
						SELECT *
						FROM {$GLOBALS['payment_table']}
						WHERE $whereSql
						AND party_id = :party_id
					";
					// 🔹 merge params safely
					$paymentParamsSingle = $paymentParams;
					$paymentParamsSingle[':party_id'] = $customer_id;

					$reports = $this->basic_obj->getQueryRecords('', $payment_query, $paymentParamsSingle);
				}

				return $reports;
			}else{
				/* ======================================================
				CASE 2: ALL CUSTOMERS
				====================================================== */

				$select_query = "
					SELECT
						sp.party_type AS party_type,
						sp.party_id AS party_id,
						sp.party_name AS party_name,
						sp.mobile_number AS party_mobile_number,
						sp.opening_balance,
						sp.opening_balance_type,
						(
							SELECT SUM(p.credit)
							FROM {$GLOBALS['payment_table']} p
							WHERE p.party_id = sp.party_id
							AND p.deleted = 0
							AND p.bill_type != 'Opening Balance'
							AND p.bill_company_id = :bill_company_id1
						) AS credit,

						(
							SELECT SUM(p.debit)
							FROM {$GLOBALS['payment_table']} p
							WHERE p.party_id = sp.party_id
							AND p.deleted = 0
							AND p.bill_type != 'Opening Balance'
							AND p.bill_company_id = :bill_company_id2
						) AS debit

					FROM {$GLOBALS['party_table']} sp
					WHERE sp.deleted = 0
					AND sp.bill_company_id = :bill_company_id3
				";
				$summaryParams = [
					':bill_company_id1' => $bill_company_id,
					':bill_company_id2' => $bill_company_id,
					':bill_company_id3' => $bill_company_id
				];
				
				$list = $this->basic_obj->getQueryRecords('', $select_query, $summaryParams);
				
				if (!empty($list)) {
					foreach ($list as $data) {

						$total_credit = 0;
						$total_debit  = 0;

						if ($data['opening_balance_type'] === 'Credit') {
							$total_credit += (float)$data['opening_balance'];
						} elseif ($data['opening_balance_type'] === 'Debit') {
							$total_debit += (float)$data['opening_balance'];
						}
						if(!empty($data['credit'])) {
							$total_credit += (float)$data['credit'];
						}
						if(!empty($data['debit'])) {
							$total_debit  += (float)$data['debit'];
						}

						$reports[] = [
							'party_type' => $data['party_type'],
							'party_id'   => $data['party_id'],
							'party_name' => $data['party_name'],
							'party_mobile_number' => $data['party_mobile_number'],
							'balance' => $total_credit - $total_debit,
							'credit'  => $data['credit'],
							'debit'   => $data['debit'],
							'opening_balance' => $data['opening_balance'],
							'opening_balance_type' => $data['opening_balance_type'],
						];
					}
				}

				return $reports;
			}
		}

		public function getOpeningBalance($customer_id, $from_date, $to_date, $bill_company_id){
			$bill_where = "";
			if (!empty($from_date)) {
				$bill_where = "bill_date < '" . date("Y-m-d", strtotime($from_date)) . "' AND";
			}

			$party_query = "SELECT sp.party_type as party_type, sp.party_id as party_id, sp.party_name as party_name,sp.mobile_number as party_mobile_number, sp.opening_balance, sp.opening_balance_type,
						(SELECT SUM(p.credit) FROM " . $GLOBALS['payment_table'] . " as p 
						WHERE " . $bill_where . " p.party_id = sp.party_id AND p.bill_type != 'Opening Balance' AND p.deleted = '0' GROUP BY p.party_id) as credit,
					
						(SELECT SUM(p.debit) FROM " . $GLOBALS['payment_table'] . " as p 
						WHERE " . $bill_where . " p.party_id = sp.party_id AND p.bill_type != 'Opening Balance' AND p.deleted = '0' GROUP BY p.party_id) as debit

						FROM " . $GLOBALS['party_table'] . " as sp WHERE sp.party_id = :party_id AND sp.deleted = '0' ";

			$params[':party_id'] = $customer_id;
			
			$list = $this->basic_obj->getQueryRecords('', $party_query, $params);
			return $list;
		}

		public function getPurchaseBillReport($bill_company_id, $filter_party_id, $from_date, $to_date, $cancel_bill_btn) {
			$list = array(); $select_query = ""; $where = ""; $params = array();

			if(!empty($bill_company_id)) {
				$where = "bill_company_id = :bill_company_id";
				$params['bill_company_id'] = $bill_company_id;
			}

			if(!empty($filter_party_id)) {
				if(!empty($where)) {
					$where = $where." AND party_id = :party_id";
				}
				else {
					$where = "party_id = :party_id";
				}
				$params['party_id'] = $filter_party_id;
			}
			
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND purchase_date >= :from_date";
				}
				else {
					$where = "purchase_date >= :from_date";
				}
				$params['from_date'] = $from_date;
			}
			
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND purchase_date <= :to_date";
				}
				else {
					$where = "purchase_date <= :to_date";
				}
				$params['to_date'] = $to_date;
			}

			if(empty($cancel_bill_btn)) {   
				if(!empty($where)) {
					$where .= " AND cancelled = :cancelled";
				} else {
					$where = "cancelled = :cancelled";
				}
				$params['cancelled'] = 0;
			}

			if(!empty($where)) {
				$select_query = "SELECT purchase_id AS bill_id, bill_company_id, purchase_number AS bill_number, purchase_date AS bill_date, party_id, total_amount AS amount, party_details, cancelled FROM ".$GLOBALS['purchase_table']." WHERE ".$where." AND deleted = '0' ORDER BY purchase_date DESC";
			} else {
				$select_query = "SELECT purchase_id AS bill_id, bill_company_id, purchase_number AS bill_number, purchase_date AS bill_date, party_id, total_amount AS amount, party_details, cancelled FROM ".$GLOBALS['purchase_table']." WHERE deleted = '0' ORDER BY purchase_date DESC";
			}

			if(!empty($select_query)) {
				$list = $this->basic_obj->getQueryRecords($GLOBALS['purchase_table'], $select_query, $params);
			}
			return $list;
		}

		public function getDayBookReportList($bill_company_id,$from_date,$to_date,$party_id,$payment_mode_id,$bill_type) {

			$list = [];
			$whereArr = [];
			$params = [];

			// company
			if (!empty($bill_company_id)) {
				$whereArr[] = "bill_company_id = :bill_company_id";
				$params[':bill_company_id'] = $bill_company_id;
			}

			// not deleted & no opening balance
			$whereArr[] = "deleted = :deleted";
			$params[':deleted'] = 0;

			$whereArr[] = "bill_type != 'Opening Balance'";

			// from date
			if (!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				$whereArr[] = "bill_date >= :from_date";
				$params[':from_date'] = $from_date;
			}

			// to date
			if (!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				$whereArr[] = "bill_date <= :to_date";
				$params[':to_date'] = $to_date;
			}

			// party
			if (!empty($party_id)) {
				$whereArr[] = "party_id = :party_id";
				$params[':party_id'] = $party_id;
			}

			// bill type
			if (!empty($bill_type)) {
				$whereArr[] = "bill_type = :bill_type";
				$params[':bill_type'] = $bill_type;
			}

			// payment mode (FIND_IN_SET required)
			if (!empty($payment_mode_id)) {
				$whereArr[] = "FIND_IN_SET(:payment_mode_id, payment_mode_id)";
				$params[':payment_mode_id'] = $payment_mode_id;
			}

			// build WHERE
			$whereSql = "WHERE " . implode(" AND ", $whereArr);

			$select_query = "
				SELECT *
				FROM {$GLOBALS['payment_table']}
				$whereSql
				ORDER BY bill_date ASC
			";

			$list = $this->basic_obj->getQueryRecords('', $select_query, $params);
			return $list;
		}

    }
?>