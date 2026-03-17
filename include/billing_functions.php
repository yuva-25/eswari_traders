<?php 
    class Billing_functions {
		private $basic_obj;

		public function initialize(Basic_Functions $basic_obj) {
			$this->basic_obj = $basic_obj;
		}
		public function connect() {
			$db = new db();

			$con = $db->connect();
			return $con;


		}		
		public function getOrderFormList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $where = ""; $order_by_query = ""; $params = array();
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." order_form_date >= :from_date AND ";
				}
				else {
					$where = " order_form_date >= :from_date AND ";
				}
				$params['from_date'] = $from_date;
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." order_form_date <= :to_date AND ";
				}
				else {
					$where = " order_form_date <= :to_date AND ";
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
					$where = $where." (order_form_number LIKE :searchValue) AND ";
				}
				else {
					$where = " (order_form_number LIKE :searchValue) AND ";
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
				$select_query = "SELECT * FROM ".$GLOBALS['order_form_table']."
							WHERE ".$where." converted = :converted AND cancelled = :cancelled AND deleted = :deleted
							".$order_by_query."
							LIMIT $row, $rowperpage";
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
				$params['converted'] = 0;

			}
			else {
				$select_query = "SELECT * FROM ".$GLOBALS['order_form_table']."
							WHERE ".$where." converted = :converted AND cancelled = :cancelled AND deleted = :deleted
							".$order_by_query;
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
				$params['converted'] = 0;
			}
				// echo $this->basic_obj->debugQuery($select_query, $params);
            $list = $this->basic_obj->getQueryRecords($GLOBALS['order_form_table'], $select_query, $params);
			return $list;
		}

		public function getEstimateRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $where = ""; $order_by_query = ""; $params = array();
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
							WHERE ".$where." converted = :converted AND cancelled = :cancelled AND deleted = :deleted
							".$order_by_query."
							LIMIT $row, $rowperpage";
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
				$params['converted'] = 0;

			}
			else {
				$select_query = "SELECT * FROM ".$GLOBALS['estimate_table']."
							WHERE ".$where." converted = :converted AND cancelled = :cancelled AND deleted = :deleted
							".$order_by_query;
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;
				$params['converted'] = 0;

			}
				// echo $this->basic_obj->debugQuery($select_query, $params);

            $list = $this->basic_obj->getQueryRecords($GLOBALS['estimate_table'], $select_query, $params);
			return $list;
		}
		public function getQuotationRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $where = ""; $order_by_query = ""; $params = array();
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." quotation_date >= :from_date AND ";
				}
				else {
					$where = " quotation_date >= :from_date AND ";
				}
				$params['from_date'] = $from_date;
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." quotation_date <= :to_date AND ";
				}
				else {
					$where = " quotation_date <= :to_date AND ";
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
					$where = $where." (quotation_number LIKE :searchValue) AND ";
				}
				else {
					$where = " (quotation_number LIKE :searchValue) AND ";
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
		public function getPurchaseRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $where = ""; $order_by_query = ""; $params = array();
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." purchase_date >= :from_date AND ";
				}
				else {
					$where = " purchase_date >= :from_date AND ";
				}
				$params['from_date'] = $from_date;
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." purchase_date <= :to_date AND ";
				}
				else {
					$where = " purchase_date <= :to_date AND ";
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
					$where = $where." (purchase_number LIKE :searchValue) AND ";
				}
				else {
					$where = " (purchase_number LIKE :searchValue) AND ";
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
				$select_query = "SELECT * FROM ".$GLOBALS['purchase_table']."
							WHERE ".$where."  cancelled = :cancelled AND deleted = :deleted
							".$order_by_query."
							LIMIT $row, $rowperpage";
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;

			}
			else {
				$select_query = "SELECT * FROM ".$GLOBALS['purchase_table']."
							WHERE ".$where."  cancelled = :cancelled AND deleted = :deleted
							".$order_by_query;
				$params['cancelled'] = $cancelled;
				$params['deleted'] = 0;

			}
            $list = $this->basic_obj->getQueryRecords($GLOBALS['purchase_table'], $select_query, $params);
			return $list;
		}
		public function getInvoiceRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$select_query = ""; $list = array(); $where = ""; $order_by_query = ""; $params = array();
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

		public function getDashboardCounList()
		{
			$estimate_count = 0;
			$invoice_count = 0;
			$order_form_count = 0;

			$select_query = "
				SELECT COUNT(id) AS estimate_count
				FROM ".$GLOBALS['estimate_table']."
				WHERE deleted = :deleted AND  converted = :converted AND cancelled = :cancelled
			";
			$params = array(
				'deleted'   => 0,
				'cancelled' => 0,
				'converted' => 0
			);
			$list = $this->basic_obj->getqueryRecords($GLOBALS['estimate_table'], $select_query, $params);
			if (!empty($list[0]['estimate_count'])) {
				$estimate_count = $list[0]['estimate_count'];
			}

			$select_query = "
				SELECT COUNT(id) AS invoice_count
				FROM ".$GLOBALS['invoice_table']."
				WHERE deleted = :deleted AND cancelled = :cancelled 
			";
			$params = array(
				'deleted'   => 0,
				'cancelled' => 0
			);
			$list = $this->basic_obj->getqueryRecords($GLOBALS['invoice_table'], $select_query, $params);

			if (!empty($list[0]['invoice_count'])) {
				$invoice_count = $list[0]['invoice_count'];
			}

			$select_query = "
				SELECT COUNT(id) AS order_form_count
				FROM ".$GLOBALS['order_form_table']."
				WHERE deleted = :deleted AND cancelled = :cancelled AND  converted = :converted 
			";
			$params = array(
				'deleted'   => 0,
				'cancelled' => 0,
				'converted' => 0
			);
			$list = $this->basic_obj->getqueryRecords($GLOBALS['order_form_table'], $select_query, $params);
			if (!empty($list[0]['order_form_count'])) {
				$order_form_count = $list[0]['order_form_count'];
			}
		

			return $order_form_count."$$$".$estimate_count."$$$".$invoice_count;
		}
		public function getSalesChartDetails($from_date, $to_date)
		{
			$params = array();
			$where  = "";

			if (!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				$where .= " AND invoice_date >= :from_date";
				$params['from_date'] = $from_date;
			}

			if (!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				$where .= " AND invoice_date <= :to_date";
				$params['to_date'] = $to_date;
			}


			$select_query = "
				SELECT 
					invoice_date AS bill_day,
					COUNT(id) AS bill_count,
					SUM(total_amount) AS bill_value
				FROM ".$GLOBALS['invoice_table']."
				WHERE deleted = :deleted
				AND cancelled = :cancelled
				{$where}
				GROUP BY invoice_date
				ORDER BY invoice_date
			";

			$params['deleted']   = 0;
			$params['cancelled'] = 0;

			$list = $this->basic_obj->getqueryRecords('', $select_query, $params);
			return $list;
		}

		public function getRecentSales()
		{
			$params = array();

			$params['deleted'] = 0;
			$params['cancelled'] = 0;


			$select_query = "
				SELECT 
					bill_number,
					bill_date,
					party_name,
					bill_total
				FROM (
					SELECT 
						invoice_number AS bill_number,
						created_date_time AS bill_date,
						party_name_mobile_city AS party_name,
						total_amount AS bill_total
					FROM ".$GLOBALS['invoice_table']."
					WHERE deleted = :deleted AND cancelled = :cancelled

					UNION ALL

					SELECT 
						estimate_number AS bill_number,
						created_date_time AS bill_date,
						party_name_mobile_city AS party_name,
						total_amount AS bill_total
					FROM ".$GLOBALS['estimate_table']."
					WHERE deleted = :deleted AND cancelled = :cancelled
				) AS combined_sales
				ORDER BY bill_date DESC
				LIMIT 5
			";
			
			return $this->basic_obj->getqueryRecords('', $select_query, $params);
		}

	

	}

	?>